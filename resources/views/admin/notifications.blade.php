@extends('admin.layout.admin')
@section('title' , 'Notifications')

@section('content')
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
<script>
function deleteNotification(id){
            $(document).ready(function() {
                $.ajax({
                type: "POST",
                 url: "/u/deleteNotification",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('Notification deleted');
                    window.location = 
                },
                error: function (data) {
                   console.log('Error:', data);
                  }
                    });
            


            });

        }

</script>

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
                   <tr>
                     <td style="width:20%">{{ $notification->created_at }}</td>
                     <td>{{ $notification->message }}</td>
                    <td style="width:20%">
                    <button id="deleteNotification" class="btn btn-default btn-sm" onclick="deleteNotification({{ $notification->id }})";><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all"></i> Delete</button>
                    </td>
                    </tr>
                    @endforeach
       
                    </tbody>

                </table>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection