@extends('admin.layout.admin')
@section('title' , 'Notifications')

@section('content')
<style nonce="{{ csp_nonce() }}">
.created_at{width:20%;}
.notify{background-color:#e8eae6ad;}
.deleteNotification{width:20%;}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Notifications
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content container-fluid">

   <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                   <th>date</th>
                   <th>Notification</th>
                   <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                   @foreach( $notifications as $notification )
                   <tr id="{{ "notify" . $notification->id  }}">
                     <td class="created_at">{{ $notification->created_at }}</td>
                     <td class="notify">{{ $notification->message }}</td>
                    <td class="deleteNotification">
                    <button id="deleteNotification" class="btn btn-default btn-sm delete-nofity" data-id="{{ $notification->id }}"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all"></i> Delete</button>
                    </td>
                    </tr>
                    @endforeach

                    </tbody>

                </table>
                @if(count($notifications) > 0)
                    <button class="btn btn-danger delete-all-nofity">delete all</button>
                @endif
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script nonce="{{ csp_nonce() }}">
$(document).ready(function() {
    $(".delete-nofity").on("click", function() {
        var id = $(this).data("id");
        deleteNotification(id);
    });

     $(".delete-all-nofity").on("click", function() {
         deleteAllNotification();
    });
});
</script>
@endsection
