@extends('super.layouts.super')
@section('title' , 'Feature a product')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
.showUser{cursor:pointer;}
.clearfix{padding-right:8px; margin-top:52px;}
.valid{display:none;}
#modal-default{display: none;}
#modal-request{display: none;}
.product_name{border: 2px dotted #f3f3f3; padding:3px;}
</style>
<script nonce="{{ csp_nonce() }}">

function showId(id){
    $.ajax({
          type: "POST",
          url: "/super/limit",
          data:{id:id},
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {
          console.log(data);


        //      console.log(data);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });

}

function featured_a_product(id, pd_id){

   $.ajax({
          type: "POST",
          url: "/super/feature-product",
          data:{id:id, pd_id:pd_id},
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {

         for(var i = 0; i<data.length;i++){
            if(data[i].pd_featured_status == 1){
            $("#status" + pd_id).text("Featured").css({"background-color":"#00a65a", "color":"white"});

            }
            if(data[i].pd_featured_status == 2){
            $("#status" + pd_id).text("Unfeatured").css({"background-color":"#dd4b39 ", "color":"white"});

            }
         }
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });

}

function deleteProduct(id){
            $(document).ready(function() {

            var res = confirm(' Delete product with ID: ? ' + id);
            if(res){
                $.ajax({
                type: "POST",
                 url: "/super/deleteSingleProduct",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('Product  deleted');
                    window.location="/super/manage-products";

                     },
                error: function (data) {
                   console.log('Error:', data);
                  }
                    });
            }else{
                return res;
            }


            });

        }

function showProduct(id){
        var imagesArray = [];
  $.ajax({
          type: "GET",
          url: "/super/showProduct",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {
            //  console.log('Sucess', data)
            for (var i = 0; i < data.length; i++) {
             $id = data[i].pd_id;
             $pd_name = data[i].pd_name;
             $pd_keyword = data[i].pd_keyword;
             $pd_listing_description = data[i].pd_listing_description;
             $pd_min_order_qty = data[i].pd_min_order_qty;
             $minOrderUnit = data[i].minOrderUnit;
             $min_price = data[i].min_price;
             $max_price = data[i].max_price;

             imagesArray.push(data[i].pd_filename);


            }

            var html ="";
             for(var x = 0; x<imagesArray.length;x++){
               // console.log(imagesArray[x]);
                html +='<img src="'+imagesArray[x]+'" width="250px" height="400px">'
             }
            $("#modal-title").text($id);
            $("#pd_name").text($pd_name);
            $("#pd_keyword").text($pd_keyword);
            $("#pd_listing_description").text($pd_listing_description);
            $("#pd_min_order_qty").text($pd_min_order_qty);
            $("#minOrderUnit").text($minOrderUnit);
            $("#min_price").text($min_price);
            $("#max_price").text($max_price);
             $("#pd_photo").html(html);



          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


}


function checkedAll () {
    var check = $('input[name="pd_id[]"]:checked').length;
    if(check > 0 ){
        $(document).ready(function() {
            var res = confirm(' Are you sure you want to delete ? ');
            if(res){

                var notChecked = [], checked = [];
                $("input:checkbox").map(function(){
                this.checked ? checked.push(this.id) : notChecked.push(this.id);
                });
                console.log("Checked " + checked);
                console.log("Not checked " + notChecked);

                        $.ajax({
                        type: "POST",
                        url: "/super/destroyMultipleproducts",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                         alert('All deleted');
                            window.location="/super/manage-products";
                        },
                        error: function (data) {
                        console.log('Error:', data);
                        }
                        });

            }else{
                return res;
            }
        });


    }else{
       alert("Please check at least one ");
    }


}
</script>
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
         Feature a Product
          <small>{{ " There are " . $count ." registered products "}}</small>
        </h1>



      </section>

      <!-- Main content -->
      <section class="content container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
             <!-- /.box-header -->
             <div class="message"></div>
             <div class="box-body">
                <div class="table-responsive mailbox-messages">
                  <table id="example1" class="table table-hover table-striped">
                      <thead>
                        <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Details</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Company</th>
                        </tr>
                      </thead>
                    <tbody>

                  @foreach( $products as $product )
                    <tr>
                      <td><input type="checkbox" id="{{ $product->pd_id }}" name="pd_id[]" value="{{ $product->pd_id }}"></td>
                      <td> {{ $product->pd_name }}</td>
                      <td class="showProduct"  data-toggle="modal" data-target="#modal-default" data-id="{{ $product->pd_id }}"> click</td>
                    <td id="{{ "status" .$product->pd_id  }}">
                        @if($product->pd_featured_status == 1 )
                        <span class="label label-success">Featured</span>
                        @else
                        <span class="label label-danger">UnFeatured</span>
                        @endif
                    </td>
                     <td >

                    <select class="productAction" data-id="{{ $product->pd_id}}" >
                        <option selected disabled>Select</option>
                        <option value="1">Feature</option>
                        <option value="2">unFeature</option>
                    </select>
                    or
                    <button  class="btn btn-default btn-sm deleteProduct" data-id="{{ $product->pd_id }}";>
                        delete
                   </button>
                     </td>
                     <td>
                         @foreach ($users as $user)
                        @if($user->id == $product->pd_u_id)
                             {{ $user->company_name }}
                        @endif

                         @endforeach
                     </td>

                     </tr>

                 @endforeach
                    </tbody>

                  </table>
                  <!-- /.table -->

                </div>
                <!-- /.mail-box-messages -->
              </div>
              <!-- /.box-body -->

              <!--modal-->
                    <!--Moda-->
                            <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">??</span></button>
                            <h4 class="modal-title" id="modal-title"></h4>
                            </div>

                            <div class="modal-body" id="modal-body">
                                <div class="col-md-12">
                                        <div class="form-group product_name">
                                            <label>Product Name:</label>
                                                <p name="pd_name" id="pd_name"></p>
                                            </div>
                                            <div class="form-group product_name">
                                                    <label>Product Keyword:</label>
                                                <p name="pd_keyword" id="pd_keyword"></p>
                                            </div>

                                               <div class="form-group product_name">
                                                    <label>Product Listing description:</label>
                                                <p name="pd_listing_description" id="pd_listing_description"></p>
                                            </div>
                                                 <div class="form-group product_name">
                                                    <label>Product Minimum Order Quantity:</label>
                                                    <span name="pd_min_order_qty" id="pd_min_order_qty"></span> ::  <span name="minOrderUnit" id="minOrderUnit"></span>
                                            </div>

                                                 <div class="form-group product_name">
                                                    <label>Product minimum price:</label>
                                                    <p name="min_price" id="min_price"></p>
                                            </div>
                                                 <div class="form-group product_name">
                                                    <label>Product max price:</label>
                                                    <p name="max_price" id="max_price"></p>
                                            </div>

                                                <div class="form-group product_name">
                                                <label>Product Images</label>
                                                    <p name="pd_photo" id="pd_photo"></p>
                                            </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                            <input type="hidden" id="productId" class="form-control" value="75">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>

              <div class="box-footer no-padding">
                <div class="mailbox-controls">
                  <!-- Check all button -->
                  <button type="button" class="btn btn-default btn-sm checkbox-toggle"  ><i class="fa fa-square-o"></i>
                  </button>
                   <div class="btn-group">
                   <button  class="btn btn-default btn-sm delete_all" name="DeleteAll"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all"></i> Delete</button>
                  </div>
              </div>
            </div>
            </div>
        </div>
    </div>
      </section>
      <!-- /.content -->
      <div class="container">
          <div class="row">
              <div class="col-md-4">
                    <div class=" clearfix pull-right">
                            {{$products->links()}}
                    </div>
              </div>
          </div>
      </div>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->
    <!-- /.content-wrapper -->
 <script nonce="{{ csp_nonce() }}">
            //delete spec
            $(".showProduct").on("click", function() {
                var id = $(this).data("id");
                showProduct(id);
            });
            $(".deleteProduct").on("click", function() {
                var id = $(this).data("id");
                deleteProduct(id);
            });

             $(".productAction").on("change", function() {
                var id = $(this).data("id"); 
                featured_a_product(this.value, id);
            });



             $(".delete_all").on("click", function() {
               return checkedAll();
            });


    </script>
@endsection
