@extends('super.layouts.super')
@section('title' , 'Manage Spec Options')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
.category{cursor:pointer;}
.clearfix{padding-right:8px; margin-top:52px;}
.valid{display:none;}
#modal-default{display: none;}
</style>
<script nonce="{{ csp_nonce() }}">

function deleteSpecOption(id){
            $(document).ready(function() {

            var res = confirm(' Delete product with ID: ? ' + id);
            if(res){
                $.ajax({
                type: "POST",
                 url: "/super/deleteSingleMainspec_option",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('Main spec_option deleted');
                    window.location="/super/spec-option-view";

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
        function editSpecOption(id){
         $.ajax({
          type: "GET",
          url: "/super/showSpecOption",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           success: function (data) {
            for (var i = 0; i < data.length; i++) {
             var id = data[i].id;
             var spec_option_name = data[i].spec_option_name;
            }
            $("#id").val(id);
            $(".spec_option_name").val(spec_option_name);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


    }


    function specOptionUpdate(){
        var spec_option_name = $(".spec_option_name").val();
        var id = $("#id").val();

        if(spec_option_name == ""){
        $("#spec_option_nameErr").text("Please enter a spec_option_name");
        } else {

        $.ajax({
        type: "POST",
        url: "/super/specOptionUpdate",
        data:{id:id,spec_option_name:spec_option_name},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
        alert('Updated');
        window.location="/super/spec-option-view";
        },
        error: function (data) {
        console.log('Error', data);
        }
        });

        }

        }
        function deleteSpecOption(id){
            $(document).ready(function() {

            var res = confirm(' Delete Spec with ID: ? ' + id);
            if(res){
                $.ajax({
                type: "POST",
                 url: "/super/deleteSingleSpecOption",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('Spec deleted');
                    window.location="/super/spec-option-view";

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
                        url: "/super/destroyMultipleSpecOption",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                           alert('Deleted All');
                            window.location="/super/spec-option-view";
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
           window.location="/super/mainspec_option-view";
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
        View Main spec_option
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
                        <th>Spec Option Name</th>
                        <th>Spec Name</th>
                        <th>Spec Category</th>
                        <th>Action</th>
                        </tr>
                      </thead>
                    <tbody>
                  @foreach( $spec_options as $spec_option )

                    <tr>
                      <td><input type="checkbox" id="{{ $spec_option->id }}" name="id[]" value="{{ $spec_option->id }}"></td>
                      <td >{{ $spec_option->spec_option_name }}</td>
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
                                    <label>Edit spec_option</label>
                                    <input type="text" name="spec_option_name" value="{{ old('spec_option_name') }}" class="form-control spec_option_name">
                                    <input type="hidden" id="id" name="id"  disabled >

                                    <span class="text-danger" id="spec_option_nameErr"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" name="save" value="save" data-id="{{  $spec_option->id  }}" class="btn btn-success save">Save changes</button>

                        </div>
                            </div>
                            <!-- /.modal-content -->
                            </div> 
                            <!-- /.modal-dialog -->
                            </div>

                            <td>
                                @foreach ($specifications as $specification)
                                @if($spec_option->spec_parent_id == $specification->spec_id)
                                {{ $specification->spec_name }}
                                @endif
                                @endforeach
                            </td>
                              <td>
                                @foreach ($sub_categories as $sub_category)
                                @foreach ($specifications as $specification)
                                @if($spec_option->spec_parent_id== $specification->spec_id)
                                @if($specification->spec_subCatid == $sub_category->id)
                                {{ $sub_category->pc_name }}
                                @endif
                                @endif
                                @endforeach
                                @endforeach
                            </td>

                     <td >
                     <button name="edit" class="btn btn-default btn-sm editSpecOption"  data-toggle="modal"  data-target="#modal-default"  data-id="{{ $spec_option->id  }}">
                        edit
                     </button>
                         or
                     <button id="delete" class="btn btn-default btn-sm deleteSpecOption" data-id="{{ $spec_option->id }}";>
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
                   <button class="btn btn-default btn-sm delete_all" name="DeleteAll"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all"></i> Delete</button>

                  </div>
              </div>
            </div>
            </div>
        </div>
      </section>
      <!-- /.content -->
   
       </div>
    </div>
    <!-- /.content-wrapper -->

  </div>
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

            $(".save").on("click", function() {
                var id = $(this).data("id");
                specOptionUpdate(id);
            });

             $(".editSpecOption").on("click", function() {
               var id = $(this).data("id");
                editSpecOption(id);
            });
    </script>
  <!-- ./wrapper -->

@endsection
