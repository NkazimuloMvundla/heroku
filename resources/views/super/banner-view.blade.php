@extends('super.layouts.super')
@section('title' , 'Manage Banners')

@section('content')
<script>

function deleteBanner(id){
            $(document).ready(function() {

            var res = confirm(' Delete product with ID: ? ' + id);
            if(res){
                $.ajax({
                type: "POST",
                 url: "/super/deleteSingleBanner",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('Banner deleted');
                    window.location="/super/view-banner";

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
    var check = $('input[name="bn_id[]"]:checked').length;
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
                        url: "/super/destroyMultipleBanners",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                           alert('Deleted All');
                            window.location="/super/view-banner";
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
           window.location="/super/mainbanner-view";
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
        View Main banner
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
                        <th>Banner Link</th>
                        <th>Banner Image</th>
                        <th>Action</th>
                        </tr>
                      </thead>
                    <tbody>
                  @foreach( $banners as $banner )
                    <tr>
                      <td><input type="checkbox" id="{{ $banner->bn_id }}" name="bn_id[]" value="{{ $banner->bn_id }}"></td>
                      <td >{{ $banner->bn_link }}</td>
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
                                    <label>Add Main banner</label>
                                    <input type="text" id="main_banner" name="main_banner" value="{{ old('main_banner') }}" class="form-control" >
                                    <span class="text-danger" id="main_bannerErr"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" name="save" id="save" value="save" onclick="updateMain({{  $banner->bn_id  }})" class="btn btn-success">Save changes</button>

                        </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>
                            <td><img src="/storage/{{ $banner->bn_img }}" width="100" height="100"></td>
                     <td >
                            <a href="/super/banner/{{ $banner->bn_id }}/edit">
                                <button name="edit" class="btn btn-default btn-sm">
                                 <i class="fa fa-pencil"></i> <span>Edit</span>
                                </button>
                                </a>

                     </button>
                         or
                     <button id="delete" class="btn btn-default btn-sm" onclick="deleteBanner({{ $banner->bn_id }})";>
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
        {{$banners->links()}}
       </div>
       </div>
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->

@endsection
