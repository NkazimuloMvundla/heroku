@extends('admin.layout.admin')
@section('title' , 'Add-new-product')

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

.help-block{
  font-style:italic;
}


</style>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <section class="content">
      @if(Session::has('message'))
       <div >
        <ul>
            <li class="label label-success"  style="font-size:15px;">{{ Session::get('message') }}</li>
        </ul>

       </div>
       @endif
    <div class="row" style="display:flex; justify-content:center;">
       <!-- /.col -->
    <div class="col-md-8" style="background: white;padding: 12px;">
    <!--form start here-->

   <form method="post" id="addProduct"  action="/u/add-new-product" enctype="multipart/form-data">

  @csrf
  <input type="hidden" id="u_id" name="u_id" value="{{Auth::user()->id}}"/>

        <div class="ui-form-item form-group">
    <label class="ui-form-label" for="commonCategoryName">
    Product Category:       </label>
        <div class="form-group">
            <div id="product-category">
<div class="form-group row"> 
<div class="col-md-4">
<label for="Main category">Select a Main category</label>
<select class="form-control" id="mc_id"  name="mainCategory"   onChange="showCat(this.value);">
<option selected>Main category</option>
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
<span class="help-block main-cats"></span>
</div>


<div class="col-md-4">
<label for="Category">Select a Category</label>
<div  id="coin">
  <select class="form-control"  name="Category"  id="c_id">
  <option selected>Category</option>
  </select>
  @error('Category')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
</div>
<span class="help-block cat"></span>
</div>
<div class="col-md-4 ">

<label for="Sub Category">Select a Sub Category </label>
<div id="last">
  <select class="form-control"  name="subCategory"  id="subCategory">
        <option selected>Sub Category</option>
  </select>
  @error('subCategory')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
</div>
<span class="help-block sub"></span>
</div>
</div>

</div>
</div>
</div>

<div class="form-group">
  <label>Product Name</label>
  <input type="text" id="Product_Name" name="Product_Name" maxlength="128"  value="{{ old('Product_Name') }}"  class="form-control" />
  @error('Product_Name')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
  <span class="help-block product-name"></span>
</div>

<div class="form-group">
    <label>Product Keyword</label>
  <input type="text" id="Product_Keyword" name="Product_Keyword" value="{{ old('Product_Keyword') }}" maxlength="256"  class="form-control" />
  @error('Product_Keyword')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
<span class="help-block product_keyword"></span>
</div>
<div class="form-group">
  <span id="add-spec" style="display:none;">Add Product Specification</span>
  <div id="data">


  </div>
  <span id="add_spec_error"></span>
  <span id="add_spec_child_error"></span>
</div>
  <div id="data-add" class="data-add">
      <button id="add_field_button" onclick="display();" style="display:none;" type="button">Add</button>
      <span><p class="text-center reachedLimitToAppend" style="color: red;"><i></i></p></span>
  </div>

<div class="form-group row">
  <div class="col-md-12">
    <table class="table table-bordered" id="data-2">

    </table>

  </div>

</div>

  <div class="form-group">
    <label for="File">File input</label>
    <div class="dropzone" id="myDropzone">
            <div class="fallback">
              <input type="file" id="file_upload" name="file[]"   multiple>
            </div>
    </div>

    <p><strong>Note:</strong>
      <div style="color:red;" class="dz-error-message" id="dz-error-message"></div>
      <i style="">You must upload at least 1 product image</i> ,
       <i style="">a max of 3 images for each product, <br> Only .jpg, .jpeg, .gif, .png formats allowed to a max size of 5 MB.</i>
    </p>

  @error('file')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
  </div>

<div class="form-group">
  <label>Detailed Description:</label>
  <textarea  id="listing_description" name="listing_description" class="form-control">{{ old('listing_description') }}</textarea>
  @error('listing_description')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
  <span class="help-block listing_description"></span>
</div>

  <div class="form-group row">
  <div class="col-xs-6 col-md-6">
  <label for="ex2">Order Quantity:</label>
  <input class="form-control" id="Minimum_Order_Quantity" autocomplete="off" value="{{ old('Minimum_Order_Quantity') }}"  name="Minimum_Order_Quantity" type="text">
  @error('Minimum_Order_Quantity')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror

  <span class="help-block Minimum_Order_Quantity"></span>
  </div>
  <div class="col-xs-6 col-md-6">
  <label for="Units">Units:</label>
  <select class="form-control" id="Minimum_order_unit" name="Minimum_order_unit" >
    <option>Choose your option</option>
    @foreach ($measurementUnits as $units )
    <option value="{{ $units->mu_name }}" {{ old('Minimum_order_unit') == $units->mu_name ? 'selected' : '' }}>{{ $units->mu_name }}</option>
    @endforeach

  </select>

  @error('Minimum_order_unit')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
   <span class="help-block Minimum_order_unit"></span>
  </div>
  </div>

  <div class="form-group row">
  <div class="col-xs-4">
  <label for="Min-price">Min-price</label>
  <input class="form-control" id="Min_price" title="Enter Min. Price" value="{{ old('Min_price') }}"  name="Min_price" placeholder="R" type="text" min="1">
  <span class="help-block">Rands (R)</span>
  @error('Min_price')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
     <span class="Min_price"></span>
  </div>
  <div class="col-xs-4">
  <label for="Max-price">Max-price</label>
  <input class="form-control" id="Max_price" title="Enter Max. Price" value="{{ old('Max_price') }}"  name="Max_price" placeholder="R" type="text" min="1">
  <span class="help-block">Rands (R)</span>
  @error('Max_price')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
     <span class="Max_price"></span>
  </div>
  <div class="col-xs-4">
  <label for="Units">Units</label>
  <select class="form-control" id="Minimum_unit"  name="Minimum_unit">
        <option>Choose your option</option>
        @foreach ($measurementUnits as $units )
        <option value="{{ $units->mu_name }}" {{ old('Minimum_unit') == $units->mu_name ? 'selected' : '' }} >{{ $units->mu_name }}</option>
        @endforeach
  </select>
  @error('Minimum_unit')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
      <span class="help-block Minimum_unit"></span>
  </div>
  </div>

<div class="form-group">
  <label>Port</label>
  <input type="text" id="Port"  title="Enter the Port" value="{{ old('Port') }}" name="Port" class="form-control" />
  @error('Port')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
      <span class="help-block Port"></span>
</div>


<div class="form-group">
  <label>Payments Methods</label>
  @foreach ($paymentTerms as $paymentTerm)

  <input id="{{  $paymentTerm->pt_id }}" type="checkbox" class="paymentMethod" name="paymentMethod[]" value="{{  $paymentTerm->pt_id }}"  />{{ $paymentTerm->pt_name }}

  @endforeach
  @error('paymentMethod')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
     <span class="help-block paymentMethod"></span>
</div>


      <div class="form-group row">
      <div class="col-xs-4">
      <label for="Capacity">Capacity</label>
      <input class="form-control" id="supplyQuantity" name="supplyQuantity" value="{{ old('supplyQuantity') }}" placeholder="Quantity">
      @error('supplyQuantity')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
         <span class="help-block supplyQuantity"></span>
      </div>

  <div class="col-xs-4">
  <label for="Unit type">Unit type</label>
  <select class="form-control"  id="supplyUnit" name="supplyUnit" >
  <option>Choose your option</option>
  @foreach ($measurementUnits as $units )
  <option value="{{ $units->mu_name }}" {{ old('supplyUnit') == $units->mu_name ? 'selected' : '' }} >{{ $units->mu_name }}</option>
  @endforeach
  </option>
  </select>
  @error('supplyUnit')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
     <span class="help-block supplyUnit"></span>
</span>
    </div>

  <div class="col-xs-4">
  <?php $period = array('Day','Quarter','Week','Month','Year'); ?>
  <label for="Period">Period</label>
  <select class="form-control"  id="supplyPeriod" name="supplyPeriod">
  <option>Select period</option>
  <?php foreach($period as $val){ ?>
  <option  value="{{ $val }}"  {{ old('supplyPeriod') == $val ? 'selected' : '' }} >{{$val}}</option>
  <?php } ?>
  </select>
  @error('supplyPeriod')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
     <span class="help-block supplyPeriod"></span>
  </div>
</div>



<div class="form-group">
    <label>Estimated Delivery date</label>
<input id="date" name="deliveryTime" type="text" class="form-control " placeholder="dd.mm.yyyy" value="{{ old('deliveryTime') }}">
  @error('deliveryTime')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
    <span class="help-block deliveryTime"></span>
</div>
  <input id="submitFormBtnA" name="submitFormBtnA"  disabled value="Insert" class="btn btn-success"  type="submit"  />

  </form>

    </div>
  </div>

  </section>


</div>

@endsection
