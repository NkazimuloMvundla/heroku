@extends('super.layouts.super')
@section('title' , 'Manage Buying Request')

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
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });

}

function takeAction(id, br_id){

   $.ajax({
          type: "POST",
          url: "/super/takeaction-buying-requests",
          data:{id:id, br_id:br_id},
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {

         for(var i = 0; i<data.length;i++){
            if(data[i].br_approval_status == 1){
            $("#status" + br_id).text("Approved").css({"background-color":"#00a65a", "color":"white"});

            }
            if(data[i].br_approval_status == 2){
            $("#status" + br_id).text("Suspended").css({"background-color":"#dd4b39 ", "color":"white"});

            }
         }
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });

}
function deleterequest(id){
            $(document).ready(function() {

            var res = confirm(' Delete request with ID: ? ' + id);
            if(res){
                $.ajax({
                type: "POST",
                 url: "/super/deleteSingleRequest",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('request  deleted');
                    window.location.reload();

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

function showrequest(id){
  $.ajax({
          type: "GET",
          url: "/super/showrequest",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
             $id = data[i].id;
             $br_pc_name = data[i].br_pc_name;
             $br_pd_spec = data[i].br_pd_spec;
             $br_order_qty = data[i].br_order_qty;
             $br_expired_date = data[i].br_expired_date;
             $created_at = data[i].created_at;

            }
            $("#modal-title").text($id);
            $("#br_pc_name").text($br_pc_name);
            $("#br_pd_spec").text($br_pd_spec);
            $("#br_order_qty").text($br_order_qty);
            $("#br_expired_date").text($br_expired_date);
            $("#created_at").text($created_at);



          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


}


function checkedAll () {
    var check = $('input[name="id[]"]:checked').length;
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
                        url: "/super/destroyMultiplerequests",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                         alert('All deleted');
                             window.location.reload();
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

function showUser(id){
  $.ajax({
          type: "GET",
          url: "/super/showRequestUser",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
                var id = data[i].id;
             var name = data[i].name;
             var lastname = data[i].lastname;
             var company = data[i].company_name;
             var email = data[i].email;
             var phone = data[i].phone_number;
             var address = data[i].company_address;
             var about_us = data[i].about_us;
            }
            $("#modal-title").text(id);
            $("#name").text(name);
            $("#lastname").text(lastname);
            $("#company").text(company);
            $("#email").text(email);
            $("#phone").text(phone);
            $("#address").text(address);
            $("#about_us").text(about_us);


          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


}

</script>
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
         Manage Request
          <small>{{ " There are " . $count ." posted requests "}}</small>
        </h1>



      </section>

      <!-- Main content -->
      <section class="content container-fluid">

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
                    <th>Request Name</th>
                    <th>Sub Category</th>
                    <th>Details</th>
                    <th>Action Taken</th>
                    <th>Action</th>
                    <th>Posted By</th>
                   </tr>
                      </thead>
                    <tbody>
                  @foreach( $buyingRequests as $request )
                    <tr>
                      <td><input type="checkbox" id="{{ $request->id }}" name="id[]" value="{{ $request->id }}"></td>
                      <td> {{ $request->br_pc_name }}</td>
                            <!--Moda-->
                            <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="modal-title"></h4>
                            </div>

                            <div class="modal-body" id="modal-body">
                                <div class="col-md-12">
                                        <div class="form-group product_name">
                                            <label>Product Name:</label>
                                                <p name="br_pc_name" id="br_pc_name"></p>
                                            </div>
                                            <div class="form-group product_name">
                                                    <label>Specification:</label>
                                                <p name="br_pd_spec" id="br_pd_spec"></p>
                                            </div>
                                            <div class="form-group product_name">
                                                    <label>Order Quantity:</label>
                                                    <span name="br_order_qty" id="br_order_qty"></span> ::  <span name="minOrderUnit" id="minOrderUnit"></span>
                                            </div>

                                             <div class="form-group product_name">
                                                    <label>Date expiring:</label>
                                                    <p name="br_expired_date" id="br_expired_date"></p>
                                            </div>

                                           <div class="form-group product_name">
                                                <label>Date Posted</label>
                                                    <p name="created_at" id="created_at"></p>
                                            </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                            <input type="hidden" id="requestId" class="form-control" value="75">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>
                      <td >
                            @foreach ($sub_categories as $sub_category )
                            @if($request->br_pc_id == $sub_category->id)
                                    {{ $sub_category->pc_name }}
                            @endif
                            @endforeach
                      </td>

                      <td class="showrequest"  data-toggle="modal" data-target="#modal-default"  data-id="{{ $request->id }}"> click</td>
                    <td id="{{ "status" .$request->id  }}">
                        @if($request->br_approval_status == 1 )
                        <span class="label label-success">Approved</span>
                        @elseif($request->br_approval_status == 2)
                        <span class="label label-danger">Suspended</span>
                        @else
                        <span class="label label-warning">Pending</span>
                        @endif
                    </td>
                     <td >
                 <select class="productAction" data-id="{{ $request->id }}">
                        <option selected disabled>Select</option>
                        <option value="1">Approve</option>
                        <option value="2">Suspend</option>
                    </select>
                    or

                    <button class="btn btn-default btn-sm deleterequest" data-id="{{ $request->id }}">
                        delete
                   </button>
                     </td>
                     <td class="showUser"  data-toggle="modal" data-target="#modal-request"  data-id="{{ $request->br_u_id }}">
                           click
                      </td>
                              <!--Moda-->
                              <div class="modal fade" id="modal-request">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title" id="modal-title"></h4>
                                    </div>
                                    <div class="modal-body" id="modal-body">
                                    <div class="">
                                        <p name="name" id="name"></p>
                                    </div>
                                    <div class="">
                                        <p name="lastname" id="lastname"></p>
                                    </div>

                                    <div class="">
                                        <p name="email" id="email"></p>
                                    </div>
                                    <div class="">
                                            <p name="phone" id="phone"></p>
                                    </div>
                                    <div class="">
                                            <p name="about_us" id="about_us"></p>
                                    </div>
                                    <div class="">
                                            <p name="address" id="address"></p>
                                    </div>
                                    </div>
                                    <div class="modal-footer">
                                    <input type="hidden" id="userId" class="form-control" value="75">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                    </div>
                                    </div>
                                    <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                    </div>

                     </tr>

                 @endforeach
                    </tbody>

                  </table>
                  <!-- /.table -->

                </div>
                <!-- /.mail-box-messages -->
              </div>
              <!-- /.box-body -->
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
      </section>
      <!-- /.content -->
      <div class="clearfix pull-right">
        {{$buyingRequests->links()}}
       </div>
    </div>
    <!-- /.content-wrapper -->
 <script nonce="{{ csp_nonce() }}">
            //delete spec
            $(".showrequest").on("click", function() {
                var id = $(this).data("id");
                showrequest(id);
            });
            $(".deleterequest").on("click", function() {
                var id = $(this).data("id");
                deleterequest(id);
            });

             $(".showUser").on("click", function() {
                var id = $(this).data("id");
                showUser(id);
            });

             $(".delete_all").on("click", function() {
               return checkedAll();
            });


              $(".productAction").on("change", function() {
                var id = $(this).data("id"); 
                takeAction(this.value, id);
            });

    </script>
  </div>
  <!-- ./wrapper -->

@endsection
