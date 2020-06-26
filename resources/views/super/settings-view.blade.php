@extends('super.layouts.super')
@section('title' , 'Manage settings')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
.editvalue{cursor:pointer;}
.clearfix{padding-right:8px; margin-top:52px;}
.valid{display:none;}
#modal-default{display: none;}
#modal-value{display: none;}
</style>
<script nonce="{{ csp_nonce() }}">

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
             var id = data[i].id;
             var st_field = data[i].st_field;
            }
            $("#st_fieldId").val(id);
            $(".st_field").val(st_field);
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
             var id = data[i].id;
             var st_value = data[i].st_value;
            }
            $("#st_valueId").val(id);
            $(".st_value").val(st_value);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


    }

        function fieldUpdate(id){

        var st_field = $(".st_field").val();
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

        var st_value = $(".st_value").val();
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
                      <td  id="st_field" class="editfield"  data-toggle="modal" data-target="#modal-default"  data-id="{{$setting->id  }}">{{ $setting->st_field }}</td>
                            <!--Modal-->
                            <div class="modal fade" id="modal-default">
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
                                            <input type="text"name="st_field" value="{{ old('st_field') }}" class="form-control st_field" >
                                          <input type="hidden" id="st_fieldId" name="st_fieldId" value="" disabled >
                                            <span class="text-danger" id="st_fieldErr"></span>
                                        </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" name="save"  value="save" data-id="{{  $setting->id  }}" class="btn btn-success fieldUpdate">Save changes</button>

                        </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>
                            <td class="editvalue"  data-toggle="modal" data-target="#modal-value"  data-id="{{$setting->id  }}">{{ $setting->st_value }}</td>
                                 <!--Modal-->
                                 <div class="modal fade" id="modal-value" >
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
                                                        <input type="text"  name="st_value" value="{{ old('st_value') }}" class="form-control st_value">
                                                      <input type="hidden" id="st_valueId" name="st_valueId" value="" disabled >
                                                        <span class="text-danger" id="st_valueErr"></span>
                                                    </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                        <button type="submit" name="save" value="save" data-id="{{  $setting->id  }}" class="btn btn-success ValueUpdate">Save changes</button>

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
                   <button  class="btn btn-default btn-sm delete_all" name="DeleteAll" ><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all"></i> Delete</button>
                  </div>
              </div>
            </div>
            </div>
        </div>
      </section>
      <!-- /.content -->
      <div class=" clearfix pull-right">
        {{$settings->links()}}
       </div>
       </div>
    </div>
    <!-- /.content-wrapper -->
 <script nonce="{{ csp_nonce() }}">
            //delete spec
            $(".category").on("click", function() {
                var id = $(this).data("id");
                showParent(id);
            });

             $(".deleteSpecOption").on("click", function() {
                var id = $(this).data("id");
                deleteSpecOption(id);
            });

             $(".delete_all").on("click", function() {
               return checkedAll();
            });

            $(".fieldUpdate").on("click", function() {
                var id = $(this).data("id");
                fieldUpdate(id);
            });


            $(".ValueUpdate").on("click", function() {
                var id = $(this).data("id");
                ValueUpdate(id);
            });

            $(".editvalue").on("click", function() {
                var id = $(this).data("id");
                editvalue(id);
            });


             $(".editfield").on("click", function() {
               var id = $(this).data("id");
                editfield(id);
            });
    </script>
  </div>
  <!-- ./wrapper -->

@endsection
