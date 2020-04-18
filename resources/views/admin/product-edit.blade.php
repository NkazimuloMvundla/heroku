@extends('admin.layout.admin')
@section('title' , 'Product-edit')

@section('content')
<script>
        $( function() {
        $( "#date" ).datepicker({
        numberOfMonths: 1,
        showButtonPanel: true ,
        minDate: new Date()
        });
        } );
  </script>

<style>
[role="alert"]{
  color: red;
}


</style>

<script>


</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Update Product Details</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Update Product Details</li>
    </ol>
  </section>
  <section class="content">
      @if(Session::has('message'))
  <div style="margin: 9px;">
        <ul>
            <li class="label label-success"  style="font-size:15px;">{{ Session::get('message') }}</li>
        </ul>
       </div>
       @endif
    <div class="row" style="display:flex; justify-content:center;">
       <!-- /.col -->
    <div class="col-md-8" style="background: white;padding: 12px;">
    <!--form start here-->
 <?php  $encoded_product_id = base64_encode( $product->first()->pd_id) ;?>
 <form method="post" id="update_product" action="/u/product/{{ $encoded_product_id}}" style="z-index: 10" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div id="subs">

    </div>
    <div class="form-group">
        <label for="Product Name">Product Name</label>
        <input type="hidden" id="Product_id" name="Product_id" maxlength="128"  value="{{ $encoded_product_id}}"  class="form-control" />
        <input type="text" id="Product_Name" name="Product_Name" maxlength="128"  value="{{ old('Product_Name') ?? $product->first()->pd_name }}"  class="form-control" />
        @error('Product_Name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="Product Keyword">Product Keyword</label>
    <input type="text" id="Product_Keyword" name="Product_Keyword" value="{{ old('Product_Keyword') ?? $product->first()->pd_keyword }}" maxlength="256"  class="form-control" />
    @error('Product_Keyword')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    <br />
    </div>
    @if(count($spec_option) > 0)
    <label for="Product Specification">Product Specification</label>
    <div class="form-group">
    <table class="table table-striped">
             <thead>
                 <tr>
                    <th>Specification</th>
                    <th>Specification Option</th>
                    <th> Action</th>
                </tr>
                </thead>

                 <tbody>
    @foreach($spec_option as $spec_opt)
        @foreach($specifications as $spec)

            @if($spec_opt->spec_parent_id == $spec->spec_id)
                    <tr>
                        <td>{{ $spec->spec_name }}</td>
                        <td>{{ $spec_opt->spec_option_name}}</td>
                        <td><button  class="btn btn-danger btn-sm" type="button" onclick="deleteSpec({{$spec_opt->id}})">Delete spec</button>|<button class="btn btn-default btn-sm" type="button" data-toggle="modal" data-target="#modal-spec-update" onclick="showSpec({{$spec_opt->id}});">Update spec</button></td>
                    </tr>


         @endif
         @endforeach
        @endforeach
        </tbody>

    </table>
        <div class="form-group">
            <div class="modal fade" id="modal-spec-update" style="display: none;">
                 <div class="modal-dialog">
                    <div class="modal-content">
                         <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                            <h4 class="modal-spec-id" id="modal-spec-id" style="display:none;"></h4>
                            </div>
                            <div class="modal-body" id="modal-body">
                            <div class="row">
                            <div class="form-group">
                            <div class="col-md-8">
                            <input type="text" class="form-control" name="spec_details" id="spec_details" value="">
                              <span class="help-block" style="color:red;" id="subCategoryErr"></span>
                            </div>
                            </div>
                        </div>


                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" name="save" id="save" value="save" onclick="addSpec();" class="btn btn-success">Save changes</button>

                            </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>
            </div>
    </div>
    @endif
    <div class="form-group">
    <label for="Add Product Specification">Add more specification</label>
    <button type="button" class="btn btn-default btn-sm"  data-toggle="modal" data-target="#modal-default">Add Specs</button>

            <div class="modal fade" id="modal-default" style="display: none;">
                 <div class="modal-dialog">
                    <div class="modal-content">
                         <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="modal-title"></h4>
                            </div>
                            <div class="modal-body" id="modal-body">
                            <div class="form-group-row">
                            <div class="col-md-4">
                            <label for="text">Select a Main category</label>
                            <select class="form-control" id="mc_id"  name="mainCategory"   onChange="showCat(this.value);">
                            <option>Select</option>
                            @forelse($parent_category as $category)
                            <option value="{{ $category->pc_id }}">{{$category->pc_name}}</option>
                            <?php $pc_id = $category->pc_id ;?>
                            @empty
                            <option>No categories</option>
                            @endforelse
                            </select>
                            @error('mainCategory')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="help-block " style="color:red;" id="mainCategoryErr"></span>
                            </div>

        <div class="col-md-4">
                    <label>Select a Category</label>
                    <div id="coin">
                    <select class="form-control"  name="Category"  id="c_id">
                    <option>Select</option>
                    </select>
                    @error('Category')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    </div>
                    <span class="help-block" style="color:red;" id="categoryErr"></span>
        </div>

    <div class="col-md-4">
        <label for="number">Select a Sub Category </label>
        <div id="last">
        <select class="form-control"  name="subCategory"  id="sc_id">
        <option selected disabled>Sub Category</option>
        </select>
        @error('subCategory')
        <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
        @enderror
        </div>
        <span class="help-block" style="color:red;" id="subCategoryErr"></span>
        </div>
    </div>
            <div class="form-group">
                <div id="data">
                </div>
                <span id="add_spec_error"></span>
                <span id="add_spec_child_error"></span>
            </div>
            <div id="data-add" class="data-add">
              <button id="add_field_button" onclick="display()" style="display:none;" type="button">Add</button>
                <span><p class="text-center reachedLimitToAppend" style="color: red;"></p></span>
            </div>
            <div class="form-group row">
    <div class="col-md-12">
    <table class="table table-bordered" id="data-2">

    </table>

  </div>

</div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" name="save" id="save" value="save" onclick="updateSpec({{$product->first()->pd_id}});" class="btn btn-success">Save changes</button>

                        </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>
</div>
  <div class="form-group">
    <label for="File">File input</label>
    <input type="file" id="file_upload" name="Product_photo[]" multiple   accept=".jpg, .jpeg, .png">
    <div class="img" style="padding:6px;">
        @foreach ($pd_images as $pd_image )
        <div style="display:inline">
                <span style="border:1px solid #e2e2e2;">
            <img src="/storage/{{ $pd_image->pd_filename }}" width="100" height="100">
            <button type="button" onclick="deleteProductImg({{ $pd_image->id }})">delete</button>
            <input type="hidden" name="pd_photo" value="{{ $pd_image->pd_photo_id }}" id="pd_photo">
               </span>
        </div>
        @endforeach
    </div>
    <p><strong>Note:</strong>A max of 3 images for each product, Only .jpg, .jpeg, .gif, .png formats allowed to a max size of 5 MB.</p>

    @error('Product_photo')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror

  </div>

<div class="form-group">
  <label for="Detailed Description:">Detailed Description:</label>
  <textarea  id="listing_description" name="listing_description" class="form-control">{{ old('listing_description') ?? $product->first()->pd_listing_description }}</textarea>
  @error('listing_description')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
</div>

  <div class="form-group row">
  <div class="col-xs-6 col-md-6">
  <label for="Order Quantity">Order Quantity:</label>
  <input class="form-control" id="Minimum_Order_Quantity" value="{{ old('Minimum_Order_Quantity') ?? $product->first()->pd_min_order_qty }}"  name="Minimum_Order_Quantity" type="text">
  @error('Minimum_Order_Quantity')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
  </div>
  <div class="col-xs-6 col-md-6">
  <label for="Units">Units:</label>
  <select class="form-control" id="Minimum_order_unit" name="Minimum_order_unit" >

    <option>Choose your option</option>
    @foreach ($measurementUnits as $unit )
    <?php $action = $unit->mu_name == $product->first()->minOrderUnit ?  'selected' : ''  ?>
    <option value="{{ $unit->mu_name }}" {{ $action }}>{{ $unit->mu_name }}</option>
    @endforeach

  </select>

  @error('Minimum_order_unit')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
  </div>
  </div>

  <div class="form-group row">
  <div class="col-xs-4">
  <label for="Min-price">Min-price</label>
  <input class="form-control" id="Min_price" title="Enter Max. Price" value="{{ old('Min_price') ?? $product->first()->min_price  }}"  name="Min_price" size="13" maxlength="14" placeholder="R" type="number" min="1">
  <span class="help-block">Rands (R)</span>
  @error('Min_price')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
  </div>
  <div class="col-xs-4">
  <label for="Max-price">Max-price</label>
  <input class="form-control" id="Max_price" title="Enter Max. Price" value="{{ old('Max_price') ?? $product->first()->max_price  }}"  name="Max_price" size="12" maxlength="14" placeholder="R" type="number" min="1">
  <span class="help-block">Rands (R)</span>
  @error('Max_price')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
  </div>
  <div class="col-xs-4">
  <label for="Units">Units</label>
  <select class="form-control" id="Minimum_unit"  name="Minimum_unit">
        <option>Choose your option</option>
        @foreach ($measurementUnits as $units )
        <?php $action = $units->mu_name == $product->first()->fob_mu_id ?  'selected' : ''  ?>
        <option value="{{ $units->mu_name }}" {{ $action }} >{{ $units->mu_name }}</option>
        @endforeach
  </select>
  @error('Minimum_unit')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
  </div>
  </div>

<div class="form-group">
  <label for="Port">Port</label>
  <input type="text" id="Port"  title="Enter the Port" value="{{ old('Port') ?? $product->first()->port  }}" name="Port" class="form-control" />
  @error('Port')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
</div>


<div class="form-group">
        <label>Payments Methods</label>
        @foreach ($paymentTerms as $paymentTerm)
         <?php $payment = explode(',',$product->first()->pd_payment_term ) ;?>

         <?php $action = in_array($paymentTerm->pt_id ,$payment ) ?  'checked' : ''  ?>
        <input id="ptMethod{{ $paymentTerm->pt_id }}" type="checkbox"  {{ $action }} name="paymentMethod[]" value="{{  $paymentTerm->pt_id }}"  />{{ $paymentTerm->pt_name }}

        @endforeach
        @error('paymentMethod')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

      </div>

      <div class="form-group row">
      <div class="col-xs-4">
      <label for="ex1">Capacity</label>
      <input class="form-control" id="supplyQuantity" name="supplyQuantity" value="{{ old('supplyQuantity') ?? $product->first()->capacity}}" placeholder="Quantity">
      @error('supplyQuantity')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>

  <div class="col-xs-4">
  <label for="Unit type">Unit type</label>
  <select class="form-control"  id="supplyUnit" name="supplyUnit" >
  <option >Select unit type</option>
  @foreach ($measurementUnits as $units )
  <?php $action = $units->mu_name == $product->first()->pd_supply_ability ?  'selected' : ''  ?>
  <option value="{{ $units->mu_name }}" {{  $action }} >{{ $units->mu_name }}</option>
  @endforeach
  </option>
  </select>
  @error('supplyUnit')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
</span>
    </div>



  <div class="col-xs-4">
  <?php $period = array('Day','Quarter','Week','Month','Year'); ?>
  <label for="ex3">Period</label>
  <select class="form-control "  id="supplyPeriod" name="supplyPeriod">
  <option>Select period</option>
  <?php foreach($period as $val){ ?>
  <?php $action = $val == $product->first()->supplyPeriod ?  'selected' : ''  ?>
  <option  value="{{ $val }}"  {{ $action }} >{{$val}}</option>
  <?php } ?>
  </select>
  @error('supplyPeriod')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
  </div>
</div>



<div class="form-group">
    <label>Estimated Delivery date</label>
<input id="date" name="deliveryTime" type="text" class="form-control " placeholder="dd.mm.yyyy" value="{{ old('deliveryTime') ?? $product->first()->pd_delivery_time }}">
  @error('deliveryTime')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
</div>
  <input id="submitFormBtnA" name="submitFormBtnA" value="Update" class="btn btn-success"  type="submit"  />

  </form>

    </div>
  </div>

  </section>





</div>

@endsection
