@extends('super.layouts.super')
@section('title' , 'Manage Request')

@section('content')
<script>

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

function takeActionSellingRequests(id, sr_id){

   $.ajax({
          type: "POST",
          url: "/super/takeaction-selling-requests",
          data:{id:id, sr_id:sr_id},
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {

         for(var i = 0; i<data.length;i++){
            if(data[i].sr_approval_status == 1){
            $("#status" + sr_id).text("Approved").css({"background-color":"#00a65a", "color":"white"});

            }
            if(data[i].sr_approval_status == 2){
            $("#status" + sr_id).text("Suspended").css({"background-color":"#dd4b39 ", "color":"white"});

            }
         }
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });

}


function showSellingRequest(id){
  $.ajax({
          type: "GET",
          url: "/super/showSellingRequest",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
             $id = data[i].id;
             $sr_pc_name = data[i].sr_pc_name;
             $sr_pd_spec = data[i].sr_pd_spec;
             $sr_order_qty = data[i].sr_order_qty;
             $sr_expired_date = data[i].sr_expired_date;
             $created_at = data[i].created_at;

            }
            $("#modal-title").text($id);
            $("#sr_pc_name").text($sr_pc_name);
            $("#sr_pd_spec").text($sr_pd_spec);
            $("#sr_order_qty").text($sr_order_qty);
            $("#sr_expired_date").text($sr_expired_date);
            $("#created_at").text($created_at);



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
                 url: "/super/deleteSingleSellingRequest",
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
                        url: "/super/destroyMultipleSellingrequests",
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

function showSellingRequestUser(id){
  $.ajax({
          type: "GET",
          url: "/super/showSellingRequestUser",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
             $id = data[i].id;
             $name = data[i].name;
             $lastname = data[i].lastname;
             $company = data[i].company_name;
             $email = data[i].email;
             $phone = data[i].phone_number;
             $address = data[i].company_address;
             $about_us = data[i].about_us;
            }
            $("#modal-title").text($id);
            $("#name").text($name);
            $("#lastname").text($lastname);
            $("#company").text($company);
            $("#email").text($email);
            $("#phone").text($phone);
            $("#address").text($address);
            $("#about_us").text($about_us);


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
          <small>{{ " There are " . $count ." posted Selling requests "}}</small>
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
                  @foreach( $sellingRequests as $request )
                    <tr>
                      <td><input type="checkbox" id="{{ $request->id }}" name="id[]" value="{{ $request->id }}"></td>
                      <td> {{ $request->sr_pc_name }}</td>
                            <!--Moda-->
                            <div class="modal fade" id="modal-default" style="display: none;">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="modal-title"></h4>
                            </div>

                            <div class="modal-body" id="modal-body">
                                <div class="col-md-12">
                                        <div class="form-group" style="border: 2px dotted #f3f3f3; padding:3px;">
                                            <label>Product Name:</label>
                                                <p name="sr_pc_name" id="sr_pc_name"></p>
                                            </div>
                                            <div class="form-group" style="border: 2px dotted #f3f3f3; padding:3px;">
                                                    <label>Specification:</label>
                                                <p name="sr_pd_spec" id="sr_pd_spec"></p>
                                            </div>
                                            <div class="form-group" style="border: 2px dotted #f3f3f3; padding:3px;">
                                                    <label>Order Quantity:</label>
                                                    <span name="sr_order_qty" id="sr_order_qty"></span> ::  <span name="minOrderUnit" id="minOrderUnit"></span>
                                            </div>

                                            <div class="form-group" style="border: 2px dotted #f3f3f3; padding:3px;">
                                                    <label>Date expiring:</label>
                                                    <p name="sr_expired_date" id="sr_expired_date"></p>
                                            </div>

                                            <div class="form-group" style="border: 2px dotted #f3f3f3; padding:3px;">
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
                            @if($request->sr_pc_id == $sub_category->id)
                                    {{ $sub_category->pc_name }}
                            @endif
                            @endforeach
                      </td>

                      <td style="cursor:pointer;"  data-toggle="modal" data-target="#modal-default"  onclick="showSellingRequest({{ $request->id }});"> click</td>

                      <td id="{{ "status" .$request->id  }}">
                        @if($request->sr_approval_status == 1 )
                        <span class="label label-success">Approved</span>
                        @elseif($request->sr_approval_status == 2)
                        <span class="label label-danger">Suspended</span>
                        @else
                        <span class="label label-warning">Pending</span>
                        @endif
                    </td>
                     <td>
                  <select id="productAction" onchange="takeActionSellingRequests(this.value, {{ $request->id }})">
                        <option selected disabled>Select</option>
                        <option value="1">Approve</option>
                        <option value="2">Suspend</option>
                    </select>


                    <button id="delete" class="btn btn-default btn-sm" onclick="deleterequest({{ $request->id }})";>
                        delete

                   </button>


                     </td>
                     <td style="cursor:pointer;"  data-toggle="modal" data-target="#modal-request"  onclick="showSellingRequestUser({{ $request->sr_u_id }});">
                           click
                      </td>
                              <!--Moda-->
                              <div class="modal fade" id="modal-request" style="display: none;">
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
                   <button  class="btn btn-default btn-sm" name="DeleteAll" onclick="checkedAll();"  ><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all" onclick="return deleteAll();"></i> Delete</button>

                  </div>
              </div>
            </div>
            </div>
        </div>
      </section>
      <!-- /.content -->
      <div class=" clearfix pull-right" style="padding-right:8px; margin-top:52px;">
        {{$sellingRequests->links()}}
       </div>
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->

@endsection
