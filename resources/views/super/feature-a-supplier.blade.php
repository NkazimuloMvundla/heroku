@extends('super.layouts.super')
@section('title' , 'Feature a supplier')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
.showProduct{cursor:pointer;}
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

function approve(id){
    $.ajax({
          type: "POST",
          url: "/super/approve-user",
          data:{id:id},
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {
            window.location="/super/manage-users";


        //      console.log(data);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


}

function takeAction(id, u_id){

   $.ajax({
          type: "POST",
          url: "/super/feature-user",
          data:{id:id, u_id:u_id},
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {

         for(var i = 0; i<data.length;i++){
            if(data[i].featured == 1){
            $("#status" + u_id).text("Featured").css({"background-color":"#00a65a", "color":"white"});

            }
            if(data[i].featured == 2){
            $("#status" + u_id).text("Unfeatured").css({"background-color":"#dd4b39 ", "color":"white"});

            }
         }
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });

}


function showUser(id){
  $.ajax({
          type: "GET",
          url: "/super/showUser",
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

/*
function changeRole(id){
 var role = $("#changeRole").val();
 $.ajax({
          type: "POST",
          url: "/super/change-role",
          data:{id:id, role:role},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {
            alert("Role assigned")
            window.location.reload();
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


}*/

function checkedAll () {
    var check = $('input[name="u_id[]"]:checked').length;
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
                        url: "/super/destroyMultipleUsers",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            $('.message').text('Deleting...');
                            window.location="/super/manage-users";
                            console.log('Success' ,data)
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
         Manage Users
          <small>{{ " There are " . $count ." registered users "}}</small>
        </h1>



      </section>

      <!-- Main content -->
      <section class="content container-fluid">
        <div class="col-md-12">

            <div class="box">
             <!-- /.box-header -->
             <div class="message"></div>
             <div class="box-body">
                <div class="table-responsive mailbox-messages">
                  <table id="example1" class="table table-hover table-striped">
                      <thead>
                    <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Registration Number</th>
                    <th>Status</th>
                    <th>Member since</th>
                    <th>Action Taken</th>
                    <th>Action</th>
                    <th>Account Type</th>
                    </tr>
                    </thead>
                    <tbody>
                  @foreach( $users as $user )
                    <tr>
                      <td><input type="checkbox" id="{{ $user->id }}" name="u_id[]" value="{{ $user->id }}"></td>
                  <td class="showUser"  data-toggle="modal" data-target="#modal-default"  data-id="{{ $user->id }}">{{ $user->company_name }}</td>
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
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>

                            <td>
                                @if($user->registration_number)
                                {{ $user->registration_number }}
                                @else
                                {{ "not provided" }}
                                @endif
                            </td>
                      <td >
                         @if($user->email_verified_at == NULL )
                         <span class="label label-warning">Email unverified</span>
                         @elseif($user->email_verified_at != NULL )
                          <span class="label label-success">Email verified</span>
                          @endif
                      </td>

                      <td> {{ $user->created_at }}</td>
                     <td id="{{ "status" .$user->id  }}">
                        @if($user->featured == 1 )
                        <span class="label label-success">Featured</span>
                        @elseif($user->featured == 2)
                        <span class="label label-danger">Unfeatured</span>
                        @else
                        <span class="label label-warning">Pending</span>
                        @endif
                    </td>
                     <td>
                    <select class="feature_a_supplier"  data-id="{{ $user->id }}">
                        <option selected disabled>Select</option>
                        <option value="1">feature</option>
                        <option value="2">Unfeature</option>
                    </select>
                     </td>

                     <td class="">{{ $user->account_type }}</td>
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
      <div class=" clearfix pull-right">
        {{ $users->links() }}
       </div>
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->
 <script nonce="{{ csp_nonce() }}">
            //delete spec
           $(".showUser").on("click", function() {
                var id = $(this).data("id");
                showUser(id);
            });

            $(".feature_a_supplier").on("change", function() {
                var id = $(this).data("id");
                takeAction(this.value, id);
            });


             $(".delete_all").on("click", function() {
               return checkedAll();
            });


    </script>
@endsection
