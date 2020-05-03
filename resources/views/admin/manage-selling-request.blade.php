 @extends('admin.layout.admin')
@section('title' , 'Manage selling request')

@section('content')

<div class="content-wrapper">


    <section class="content">
         <!-- /.row -->
      <div class="row">
            <div class="col-xs-12">
             <div class="box">

                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tbody><tr>
                      <th>ID</th>
                      <th>Action</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Details</th>
                    </tr>
                    @forelse($sellingRequests as $sellingRequest)
                    <?php $status = $sellingRequest->br_approval_status ;?>
                    <?php
                     if( $sellingRequest->br_approval_status == 1 )
                         $status = 'Approved';
                     elseif($sellingRequest->br_approval_status == 2)
                         $status = 'Suspended';
                     else
                            $status = 'Pending';

                     ?>


                    <tr id="{{ $sellingRequest->id }}">
                      <td>{{ $sellingRequest->id }}</td>
                      <td class="message"><button class="btn btn-default btn-sm" onclick="deleteRequest({{ $sellingRequest->id }})">Delete</button> </br><a href="#" data-role="update" data-id="{{ $sellingRequest->id }}"><button style="margin-top:8px;" class="btn btn-info btn-sm">Update</button></a> </td>
                      <td>{{ $sellingRequest->created_at }}</td>

                      <td >
                         @if($status == 'Pending')
                          <span class="label label-warning">{{ $status }}</span>
                          @endif
                           @if($status == 'Approved')
                           <span class="label label-success">{{ $status }}</span>
                           @endif
                           @if($status == 'Suspended')
                           <span class="label label-danger">{{ $status }}</span>
                           @endif
                      </td>
                      <td data-target="sr_pd_spec">{{ $sellingRequest->sr_pd_spec }}</td>
                      @empty
                      <td class="">You currently have not posted any selling request(s)</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>

          <!--Moda-->
  <div class="modal fade" id="modal-default" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Edit Request</h4>
              </div>
              <div class="modal-body">
                <form method="post" id="insert_form">
                       <textarea name="sr_pd_spec" id="sr_pd_spec" class="form-control"></textarea>
                </form>

              </div>
              <div class="modal-footer">
                <input type="hidden" id="userId" class="form-control">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>

                <button type="submit" name="save" id="save" value="save" class="btn btn-success">Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
          </div>
        </section>

</div>
<script>


//  append values in input fields
$(document).on('click','a[data-role=update]',function(){
            var id  = $(this).data('id');
            var sr_pd_spec  = $('#'+id).children('td[data-target=sr_pd_spec]').text();

            $('#sr_pd_spec').val(sr_pd_spec);
             $('#userId').val(id);

            $('#modal-default').modal('toggle');
      });

      $('#save').click(function(){
         var id  = $('#userId').val();
         var sr_pd_spec =  $('#sr_pd_spec').val();
         if(sr_pd_spec == ""){
             alert('This cannot be empty');
         }else{

          $.ajax({
              url      : '/u/update-selling-request',
              method   : 'POST',
              data     : {sr_pd_spec : sr_pd_spec , id: id},
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success  : function(data){

                    // now update user record in table
                    $('#'+id).children('td[data-target=sr_pd_spec]').text(sr_pd_spec);

                    $('#modal-default').modal('toggle');

                },
                error: function (data) {
                   console.log('Error:', data);
                  }
          });
         }

       });



function deleteRequest(id) {
        $(document).ready(function() {
          var res = confirm(' Are you sure you want to delete ? ');
            if(res){
              $.ajax({
              type: "POST",
              url: "/u/delete-buying-request",
              data:{id:id},
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function (data) {
              $('.message').text('Deleting...');
              window.location.reload();
              },
              error: function (data) {
              console.log('Error:', data);
              }
              });
            }



        });




}

</script>

@endsection
