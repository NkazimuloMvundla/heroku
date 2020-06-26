@extends('super.layouts.super')
@section('title' , 'CMS-view')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
.showCms{cursor:pointer;}
#logout-form{display: none;}
.clearfix{padding-right:8px; margin-top:52px;}
#modal-default{display: none;}
</style>
<script nonce="{{ csp_nonce() }}">
function editCms(id){
  $.ajax({ 
          type: "GET",
          url: "/super/showCms",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
             var id = data[i].id;
             var cms_title = data[i].cms_title;
             var cms_page = data[i].cms_page;
             var cms_content = data[i].cms_content;
             var cms_banner = data[i].cms_banner ;

            }

            $("#modal-title").text(id);
            $("#cms_id").val(id);
            $(".cms_title").val(cms_title);
            $(".cms_page").val(cms_page);
            $("#cms_content").text(cms_content);
            $("#cms_banner").text(cms_banner);



          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


}
function showCms(id){
  $.ajax({
          type: "GET",
          url: "/super/showCms",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
             $id = data[i].id;
             $cms_title = data[i].cms_title;
             $cms_page = data[i].cms_page;
             $cms_content = data[i].cms_content;
             $cms_banner = data[i].cms_banner ;

            }

            $(".modal-body").html('<div class="">' + $cms_content  + '</div>');



          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


}

function updateCms(){

var id = $("#cms_id").val();
var cms_title = $(".cms_title").val();
var cms_page = $(".cms_page").val();
var cms_content = $("#cms_content").val();
if(cms_title == ""){
  $(".cms_title_err").text("Please enter a Title");
}else if(cms_page == ""){
  $(".cms_page_err").text("Please enter a page");
}else if (cms_content == "") {
    $(".cms_content_err").text("Please select enter a content");
} else {

  $.ajax({
      type: "POST",
      url: "/super/cms-update",
      data:{id:id,cms_title:cms_title, cms_page:cms_page , cms_content:cms_content },
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function (data) {
         alert('Updated successfully')
         window.location="/super/content-management";
      },
       error: function (data) {
          console.log('Error', data);
          }
  });


}


}



function checkedAll () {
    var check = $('input[name="cms_id[]"]:checked').length;
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
                        url: "/super/destroyMultipleCms",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            alert('Deleted');
                            window.location="/super/content-management";
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
       alert("Please check atleast one ");
    }


}


</script>
<div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <h1>
              Content Management Management
              <small></small>
            </h1>
          </section>

          <!-- Main content -->
          <section class="content container-fluid">

            <div class="col-md-12">

                <div class="box ">
                 <!-- /.box-header -->
                 <div class="message"></div>
                 <div class="box-body ">
                    <div class="table-responsive mailbox-messages">
                      <table id="example1" class="table table-hover table-striped">
                          <thead>
                        <tr>
                        <th>ID</th>
                        <th>CMS Title</th>
                        <th>CMS page</th>
                        <th>CMS content</th>
                        <th>Action</th>
                        </tr>
                          </thead>
                        <tbody>
                        @foreach( $cms_s as $cms )
                        <tr>
                          <td><input type="checkbox" class="cms_id" id="{{ $cms->id }}" name="cms_id[]" value="{{ $cms->id }}"></td>

                          <td data-id="{{ $cms->id }}">{{ $cms->cms_title }}</td>
                          <td >{{ $cms->cms_page }} </td>
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
                                        <div class="form-group">
                                                <label>Edit a CMS title :</label>
                                                <input type="hidden" id="cms_id" name="cms_id" value="" class="form-control" size="40">
                                                <input type="text" name="cms_title" value="{{ old('cms_title') }}" class="form-control cms_title" size="40">

                                                @error('cms_title')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                <span class="cms_title_err"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Edit a CMS page:</label>
                                                <input type="text" name="cms_page" value="{{ old('cms_page') }}"  class="form-control cms_page" >
                                                @error('cms_page')
                                                <span class="invalid-feedback " role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                <span class="cms_page_err"></span>
                                            </div>
                                            <div class="form-group">
                                            <label>Content</label>
                                            <textarea class="form-control" id="cms_content" name="cms_content" id="cms_content"  ></textarea>
                                            @error('cms_content')
                                            <span class="invalid-feedback " role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <span class="cms_content_err"></span>
                                            </div>

                                <div class="">
                                    <label>Banner</label>
                                    <p name="email" id="email"></p>
                                </div>

                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" name="save" value="save" class="btn btn-success save">Save changes</button>

                                </div>
                                </div>
                                <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                                </div>
                                <div class="elipses">
                          <td  >
                               {{ $cms->cms_content }}
                          </td>
                        </div>
                         <td >

                         <button name="edit" data-id="{{ $cms->id }}" class="btn btn-default btn-sm edit_cms"  data-toggle="modal" data-target="#modal-default">
                                edit
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
                       <button  class="btn btn-default btn-sm delete_all" name="DeleteAll"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all"></i> Delete</button>

                      </div>
                  </div>
                </div>
                </div>
            </div>
          </section>
          <!-- /.content -->
          <div class="clearfix pull-right">

           </div>
        </div>
        <!-- /.content-wrapper -->

      </div> 


  <script nonce="{{ csp_nonce() }}">
          
            
            $(".showCms").on("click", function() {
                var id = $(this).data("id");
                showCms(id);
            });

             $(".delete_all").on("click", function() {
               return checkedAll();
            });

            $(".save").on("click", function() {
               updateCms();
            });

             $(".edit_cms").on("click", function() {
               var id = $(this).data("id");
                editCms(id);
            });
    </script>
      <!-- ./wrapper -->
      @endsection
