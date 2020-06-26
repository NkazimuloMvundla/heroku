@extends('super.layouts.super')
@section('title' , 'Manage reviews')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
.showreview{cursor:pointer;}
.clearfix{padding-right:8px; margin-top:52px;}
.valid{display:none;}
#modal-default{display: none;}
#modal-value{display: none;}
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
          url: "/super/approve-review",
          data:{id:id},
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {
            window.location="/super/manage-reviews";


        //      console.log(data);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


}

function suspend(id){
    $.ajax({
          type: "POST",
          url: "/super/suspend-review",
          data:{id:id},
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {
            window.location="/super/manage-reviews";


        //      console.log(data);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


}

function showreview(id){
  $.ajax({
          type: "GET",
          url: "{{ route('showReviewAjax') }}",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {
            for (var i = 0; i < data.length; i++) {
             var id = data[i].pd_id;
             var pd_name = data[i].pd_name;
            }
            $("#modal-title").text(id);

            $("#about_us").text(pd_name);


          },
          error: function (data) {
              console.log('Error:', data);
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
                        url: "/super/destroyMultiplereviews",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                            $('.message').text('Deleting...');
                            window.location="/super/manage-reviews";
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
         Manage reviews
          <small></small>
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
                        <th>Review</th>
                        <th>Date Posted</th>
                        <th>Action</th>
                        </tr>
                      </thead>
                    <tbody>

                  @foreach( $reviews as $review )
                    <tr>
                      <td><input type="checkbox" id="{{ $review->id }}" name="id[]" value="{{ $review->id }}"></td>
                      <td class="showreview" data-toggle="modal" data-target="#modal-default"  data-id="{{ $review->pd_id }}">{{ $review->review }}</td>
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
                            <input type="hidden" id="reviewId" class="form-control" value="75">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>


                      <td > {{ $review->created_at }}</td>

                     <td >
                     <a href="">
                     <button name="suspend" class="btn btn-default btn-sm suspend" data-id="{{ $review->id }}">
                            @if($review->status == 0)
                             Suspend
                            @elseif($review->status == 2)
                             <span class="label label-danger">Suspended</span>
                            @elseif($review->status == 1)
                             Suspend
                             @endif
                     </button>
                     </a>
                     or

                     <button id="approve" class="btn btn-default btn-sm approve" data-id="{{ $review->id }}">
                        @if($review->status == 0)
                        Approve
                        @elseif($review->status == 1)
                        <span class="label label-success">Approved</span>
                        @elseif($review->status == 2)
                        Approve
                        @endif

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
                   <button  class="btn btn-default btn-sm delete_all " name="DeleteAll"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all"></i> Delete</button>
                  </div>
              </div>
            </div>
            </div>
        </div>
      </section>
      <!-- /.content -->
      <div class=" clearfix pull-right">
        {{$reviews->links()}}
       </div>
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->
 <script nonce="{{ csp_nonce() }}">
            //delete spec
            $(".showreview").on("click", function() {
                var id = $(this).data("id");
                showreview(id);
            });
            $(".suspend").on("click", function() {
                var id = $(this).data("id");
                suspend(id);
            });

             $(".approve").on("click", function() {
                var id = $(this).data("id");
                approve(id);
            });

             $(".delete_all").on("click", function() {
               return checkedAll();
            });

    </script>
@endsection
