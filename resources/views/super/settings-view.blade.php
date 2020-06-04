@extends('super.layouts.super')
@section('title' , 'Manage settings')

@section('content')
<script>

function deleteMain(id){
            $(document).ready(function() {

            var res = confirm(' Delete product with ID: ? ' + id);
            if(res){
                $.ajax({
                type: "POST",
                 url: "/super/deleteSingleMainsetting",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('Main setting deleted');
                    window.location="/super/mainsetting-view";

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
        function editfield(id){
         $.ajax({
          type: "GET",
          url: "/super/showfield",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           success: function (data) {
            for (var i = 0; i < data.length; i++) {
             $id = data[i].id;
             $st_field = data[i].st_field;
            }
            $("#st_fieldId").val($id);
            $("#st_field").val($st_field);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


    }
    function editvalue(id){
         $.ajax({
          type: "GET",
          url: "/super/showvalue",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           success: function (data) {
            for (var i = 0; i < data.length; i++) {
             $id = data[i].id;
             $st_value = data[i].st_value;
            }
            $("#st_valueId").val($id);
            $("#st_value").val($st_value);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


    }

        function fieldUpdate(id){

        var st_field = $("#st_field").val();
        var id = $("#st_fieldId").val();

        if(st_field == ""){
        $("#st_fieldErr").text("Please enter a Setting Field");
        } else {

        $.ajax({
            type: "POST",
            url: "/super/fieldUpdate",
            data:{id:id,st_field:st_field },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
                alert('Updated');
                window.location="/super/setting-view";
            },
            error: function (data) {
                console.log('Error', data);
                }
        });

        }
        }


        function ValueUpdate(id){

        var st_value = $("#st_value").val();
        var id = $("#st_valueId").val();

        if(st_value == ""){
        $("#st_fieldErr").text("Please enter a Setting Value");
        } else {

        $.ajax({
        type: "POST",
        url: "/super/valueUpdate",
        data:{id:id,st_value:st_value },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
            alert('Updated');
            window.location="/super/setting-view";
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
                        url: "/super/destroyMultiplesettings",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                           alert('Deleted All');
                            window.location="/super/setting-view";
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
           window.location="/super/mainsetting-view";
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
        View Main setting
        </h1>

      </section>

      <!-- Main content -->
      <section class="content container-fluid">
        <div class="col-md-12">
            <div class="box box-primary">
             <!-- /.box-header -->
             <div class="message"></div>
             <div class="box-body ">
                <div class="table-responsive mailbox-messages">
                  <table id="example1" class="table table-hover table-striped">
                      <thead>
                     <tr>
                        <th>ID</th>
                        <th>Setting Field Name</th>
                        <th>Setting Value</th>
                        <th>Logo</th>
                        </tr>
                      </thead>
                    <tbody>

                  @foreach( $settings as $setting )
                    <tr>
                      <td><input type="checkbox" id="{{ $setting->id }}" name="id[]" value="{{ $setting->id }}"></td>
                      <td style="cursor:pointer;" id="st_field"  data-toggle="modal" data-target="#modal-default"  onclick="editfield({{$setting->id  }});">{{ $setting->st_field }}</td>
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
                                            <label>Edit a Setting Field</label>
                                            <input type="text" id="st_field" name="st_field" value="{{ old('st_field') }}" class="form-control" >
                                          <input type="hidden" id="st_fieldId" name="st_fieldId" value="" disabled >
                                            <span class="text-danger" id="st_fieldErr"></span>
                                        </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" name="save" id="save" value="save" onclick="fieldUpdate({{  $setting->id  }})" class="btn btn-success">Save changes</button>

                        </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>
                            <td style="cursor:pointer;" id="st_value"  data-toggle="modal" data-target="#modal-value"  onclick="editvalue({{$setting->id  }});">{{ $setting->st_value }}</td>
                                 <!--Modal-->
                                 <div class="modal fade" id="modal-value" style="display: none;">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                        <h4 class="modal-title" id="modal-title"></h4>
                                        </div>
                                        <div class="modal-body" id="modal-body">

                                                <div class="form-group">
                                                        <label>Edit a Setting Value</label>
                                                        <input type="text" id="st_value" name="st_value" value="{{ old('st_value') }}" class="form-control" >
                                                      <input type="hidden" id="st_valueId" name="st_valueId" value="" disabled >
                                                        <span class="text-danger" id="st_valueErr"></span>
                                                    </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                        <button type="submit" name="save" id="save" value="save" onclick="ValueUpdate({{  $setting->id  }})" class="btn btn-success">Save changes</button>

                                    </div>
                                        </div>
                                        <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                        </div>

                                        <td>
                                        @if($setting->st_pic !="")
                                        <img src="{{ $setting->st_pic }} " height="100" width="100" >
                                        @endif
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
        {{$settings->links()}}
       </div>
       </div>
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->

@endsection
