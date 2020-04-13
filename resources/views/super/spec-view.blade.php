@extends('super.layouts.super')
@section('title' , 'Manage users')

@section('content')
<script>

function deleteMain(id){
            $(document).ready(function() {

            var res = confirm(' Delete product with ID: ? ' + id);
            if(res){
                $.ajax({
                type: "POST",
                 url: "/super/deleteSingleMainspecification",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('Main specification deleted');
                    window.location="/super/mainspecification-view";

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
        function editSpec(id){
         $.ajax({
          type: "GET",
          url: "/super/showSpec",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           success: function (data) {
            for (var i = 0; i < data.length; i++) {
             $id = data[i].spec_id;
             $spec_name = data[i].spec_name;
            }
            $("#spec_Id").val($id);
            $("#spec_name").val($spec_name);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


    }


    function updateSpec(){
        var spec_name = $("#spec_name").val();
        var id = $("#spec_Id").val();

        if(spec_name == ""){
        $("#spec_nameErr").text("Please enter a spec_name");
        } else {

        $.ajax({
        type: "POST",
        url: "/super/specUpdate",
        data:{id:id,spec_name:spec_name},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
        alert('Updated');
        window.location="/super/spec-view";
        },
        error: function (data) {
        console.log('Error', data);
        }
        });

        }

        }
        function deleteSpec(id){
            $(document).ready(function() {

            var res = confirm(' Delete Spec with ID: ? ' + id);
            if(res){
                $.ajax({
                type: "POST",
                 url: "/super/deleteSingleSpec",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('Spec deleted');
                    window.location="/super/spec-view";

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
    var check = $('input[name="spec_id[]"]:checked').length;
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
                        url: "/super/destroyMultipleSpecs",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                           alert('Deleted');
                            window.location="/super/spec-view";
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

function checkedAll () {
    var check = $('input[name="spec_id[]"]:checked').length;
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
                        url: "/super/destroyMultipleSpecs",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                           alert('Deleted ');
                            window.location="/super/spec-view";
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
           window.location="/super/mainspecification-view";
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
        View Main specification
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
                        <th>Specification Name</th>
                        <th>Spec Category</th>
                        <th>Action</th>
                        </tr>
                      </thead>
                    <tbody>

                  @foreach( $specifications as $specification )

                    <tr>
                      <td><input type="checkbox" id="{{ $specification->spec_id }}" name="spec_id[]" value="{{ $specification->spec_id }}"></td>
                      <td >{{ $specification->spec_name }}</td>
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
                                    <label>Edit specification</label>
                                    <input type="text" id="spec_name" name="spec_name" value="{{ old('spec_name') }}" class="form-control" >
                                    <input type="hidden" id="spec_Id" name="spec_Id" value="" disabled >

                                    <span class="text-danger" id="spec_nameErr"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" name="save" id="save" value="save" onclick="updateSpec({{  $specification->spec_id  }})" class="btn btn-success">Save changes</button>

                        </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>

                            <td>
                                @foreach ($sub_categories as $sub_category)
                                @if($specification->spec_subCatid == $sub_category->id)
                                {{ $sub_category->pc_name }}
                                @endif
                                @endforeach
                            </td>

                     <td >
                     <button name="edit" class="btn btn-default btn-sm"  data-toggle="modal" data-target="#modal-default"  onclick="editSpec({{ $specification->spec_id  }});">
                        edit
                     </button>
                         or
                     <button id="delete" class="btn btn-default btn-sm" onclick="deleteSpec({{ $specification->spec_id }})";>
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
        {{$specifications->links()}}
       </div>
       </div>
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->

@endsection
