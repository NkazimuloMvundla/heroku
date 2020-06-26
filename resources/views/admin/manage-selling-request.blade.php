 @extends('admin.layout.admin')
@section('title' , 'Manage selling request')

@section('content')
<style nonce="{{ csp_nonce() }}">

#modal-selling{display: none;}
button.update{margin-top:8px;}

</style>
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
                      <td class="message">
                   <button data-id="{{ $sellingRequest->id }}" class="btn btn-default btn-sm delete-req">Delete</button> </br>
                    <a href="#" data-role="update" data-id="{{ $sellingRequest->id }}">
                    <button class="btn btn-info btn-sm update">Update</button></a> </td>
                      <td>{{ $sellingRequest->created_at }}</td>
                      <td>
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
  <div class="modal fade" id="modal-selling">
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

                <button type="submit" name="save" id="save-sellingUpdate" value="save" class="btn btn-success">Save changes</button>
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
<script nonce="{{ csp_nonce() }}">
 $(document).ready(function() {
    $(".delete-req").on("click", function() {
        var id = $(this).data("id");
        deleteSellingRequest(id);
    });
});
</script>

@endsection
