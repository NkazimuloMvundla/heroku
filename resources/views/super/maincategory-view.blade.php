@extends('super.layouts.super')
@section('title' , 'Manage main-cat')

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

function deleteMain(id){
            $(document).ready(function() {

            var res = confirm(' Delete product with ID: ? ' + id);
            if(res){
                $.ajax({
                type: "POST",
                 url: "/super/deleteSingleMainCategory",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('Main Category deleted');
                    window.location="/super/maincategory-view";

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
        function editMain(id){
         $.ajax({
          type: "GET",
          url: "/super/showMain",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           success: function (data) {
            for (var i = 0; i < data.length; i++) {
             var id = data[i].pc_id;
             var main_category = data[i].pc_name;
            }
            $(".main_category").val(main_category);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


    }

    function updateMain(id){

    var main_category = $(".main_category").val();

if(main_category == ""){
  $("#main_categoryErr").text("Please enter a Main Category");
} else {

  $.ajax({
      type: "POST",
      url: "/super/mainUpdate",
      data:{id:id,main_category:main_category },
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function (data) {
           alert('Updated');
           window.location="/super/maincategory-view";
      },
       error: function (data) {
          console.log('Error', data);
          }
  });


}


}

function checkedAll () {
    var check = $('input[name="pc_id[]"]:checked').length;
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
                        url: "/super/destroyMultipleMainCategories",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                           alert('Deleted All');
                            window.location="/super/maincategory-view";
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

function showId(limit){

    $.ajax({
      type: "POST",
      url: "/super/limit",
      data:{limit:limit},
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function (data) {
           alert('Result per page');
           window.location="/super/maincategory-view";
      },
       error: function (data) {
          console.log('Error', data);
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
        View Main Category
        </h1>

      </section>

      <!-- Main content -->
      <section class="content container-fluid">
        <div class="col-md-12">

            <div class="box">
             <!-- /.box-header -->
             <div class="message"></div>
             <div class="box-body ">
                <div class="table-responsive mailbox-messages">
                  <table id="example1" class="table table-hover table-striped">
                      <thead>
                                <tr>
                                <th>ID</th>
                                <th>Main Category Name</th>
                                <th>Action</th>
                                </tr>
                      </thead>
                    <tbody>

                  @foreach( $mainCategories as $category )
                    <tr>
                      <td><input type="checkbox" id="{{ $category->pc_id }}" name="pc_id[]" value="{{ $category->pc_id }}"></td>
                      <td >{{ $category->pc_name }}</td>
                            <!--Modal-->
                            <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">??</span></button>
                            <h4 class="modal-title" id="modal-title"></h4>
                            </div>
                            <div class="modal-body" id="modal-body">
                                <div class="form-group">
                                    <label>Add Main Category</label>
                                    <input type="text"  name="main_category" value="{{ old('main_category') }}" class="form-control main_category">
                                    <span class="text-danger" id="main_categoryErr"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" name="save" value="save" data-id="{{  $category->pc_id  }}" class="btn btn-success updateMain">Save changes</button>

                        </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>
                     <td >
                     <button name="edit" class="btn btn-default btn-sm editMain"  data-toggle="modal" data-target="#modal-default"  data-id="{{ $category->pc_id  }}">
                        edit
                     </button>
                         or
                     <button  class="btn btn-default btn-sm deleteMain" data-id="{{ $category->pc_id }}">
                        delete
                    </button>
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
        {{$mainCategories->links()}}
       </div>
       </div>
    </div>
    <!-- /.content-wrapper -->
 <script nonce="{{ csp_nonce() }}">
            //delete spec
            $(".updateMain").on("click", function() {
                var id = $(this).data("id");
                updateMain(id);
            });
            $(".editMain").on("click", function() {
                var id = $(this).data("id");
                editMain(id);
            });

             $(".deleteMain").on("click", function() {
                var id = $(this).data("id");
                deleteMain(id);
            });

             $(".delete_all").on("click", function() {
               return deleteAll();
            });


    </script>
  </div>
  <!-- ./wrapper -->

@endsection
