@extends('super.layouts.super')
@section('title' , 'Manage sub categories')

@section('content')
<script>

function deleteCat(id){
            $(document).ready(function() {

            var res = confirm(' Delete product with ID: ? ' + id);
            if(res){
                $.ajax({
                type: "POST",
                 url: "/super/deleteSingleSubCategory",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('Sub category deleted');
                    window.location="/super/subcategory-view";

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
        function editCat(id){
         $.ajax({
          type: "GET",
          url: "/super/showSub",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           success: function (data) {
            for (var i = 0; i < data.length; i++) {
             $id = data[i].id;
             $category = data[i].pc_name;
            }
            $("#category").val($category);
            $("#catId").val($id);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


    }

        function updateSub(){
        var category = $("#category").val();
        var id = $("#catId").val();
        var main_category = $("#main_category").val();
        if(category == ""){
        $("#categoryErr").text("Please enter a Main Category");
        } else {

        $.ajax({
        type: "POST",
        url: "/super/subUpdate",
        data:{id:id,category:category , main_category:main_category},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
        alert('Sub category updated');
        window.location="/super/subcategory-view";
        },
        error: function (data) {
        console.log('Error', data);
        }
        });


        }



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
                        url: "/super/destroyMultipleSubCategories",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                           alert('Deleted All');
                            window.location="/super/subcategory-view";
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

function showParent(id){

}
</script>
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
        View Sub Category
        </h1>

      </section>

      <!-- Main content -->
      <section class="content container-fluid">
        <div class="col-md-12">
            <div class="box ">
             <!-- /.box-header -->
             <div class="message"></div>
             <div class="box-body">
                <div class="table-responsive mailbox-messages">
                  <table id="example1" class="table table-hover table-striped">
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th> Sub Category Name</th>
                    <th>Category</th>
                    <th>Main Category</th>
                    <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                  @foreach( $SubCategories as $category )
                    <tr>
                      <td><input type="checkbox" id="{{ $category->id }}" name="id[]" value="{{ $category->id }}"></td>
                      <td style="cursor:pointer;" id="category" onclick="showParent({{ $category->pc_id }});">{{ $category->pc_name }}</td>

                            <!--Modal-->
                            <div class="modal fade" id="modal-default" style="display: none;">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="modal-title"></h4>
                            </div>
                            <div class="modal-body" id="modal-body">
                            <div class="form-group">
                                    <label>Select a Main Category</label>
                                    <select name="main_category" id="main_category" class="form-control">
                                        <option >Select</option>
                                        @foreach($mainCategories as $mainCat)

                                        <option value="{{ $mainCat->pc_id }}"   >{{  $mainCat->pc_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="main_categoryErr"></span>
                                </div>
                                <div class="form-group">
                                    <label>Edit a Sub Category</label>
                                    <input type="text" id="category" name="category" value="{{ old('category') }}" class="form-control" >
                                    ID:<input type="number" id="catId" name="catId" value="" disabled >
                                    <span class="text-danger" id="categoryErr"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" name="save" id="save" value="save" onclick="updateSub();" class="btn btn-success">Save changes</button>

                        </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>

                                <td>
                                        @foreach ($Categories as $Cats)
                                        @if($Cats->id == $category->pc_id)
                                        {{ $Cats->pc_name }}
                                        @endif
                                        @endforeach
                                </td>
                                <td>
                                        @foreach ($Categories as $Cats)
                                        @foreach ($mainCategories as $mainCat)
                                        @if($Cats->id == $category->pc_id)
                                        @if($mainCat->pc_id == $Cats->pc_id)
                                        {{ $mainCat->pc_name }}
                                        @endif
                                        @endif
                                        @endforeach
                                        @endforeach

                                    </td>
                     <td >
                     <button name="edit" class="btn btn-default btn-sm"  data-toggle="modal" data-target="#modal-default"  onclick="editCat({{ $category->id  }});">
                        edit
                     </button>
                         or
                     <button id="delete" class="btn btn-default btn-sm" onclick="deleteCat({{ $category->id }})";>
                        delete
                    </button>
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
        {{$SubCategories->links()}}
       </div>
       </div>
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->

@endsection
