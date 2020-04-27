@extends('super.layouts.super')
@section('title' , 'Index')

@section('content')
<div class="wrapper">
<script>
function deleteAdminNotification(id){
            $(document).ready(function() {
                $.ajax({
                type: "POST",
                 url: "/super/deleteAdminNotification",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   $("#notify" + id).fadeOut();

                },
                error: function (data) {
                   console.log('Error:', data);
                  }
                    });



            });

        }

        function deleteAllAdminNotification(){
            $(document).ready(function() {
             var ans = window.confirm("Are you sure you want to delete all notifications ? ");
                if(ans){
                    $.ajax({
                    type: "POST",
                    url: "/super/deleteAllAdminNotification",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function (data) {
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
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
         Todays date is <script>
            var now = new Date();
            document.write(now.toUTCString());
             </script>
              / <span class="bg bg-danger">You have {{ $adminCountNotifications }} notifications</span>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
          <li class="active">Here</li>
        </ol>
      </section>

      <!-- Main content -->
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

                   @foreach( $adminNotifications as $notification )
                   <tr id="{{ "notify" . $notification->id  }}">
                     <td style="width:20%">{{ $notification->created_at }}</td>
                     <td id="notify" style="background-color:#e8eae6ad;">{!! $notification->message !!}</td>
                    <td style="width:20%">
                    <button id="deleteNotification" class="btn btn-default btn-sm" onclick="deleteAdminNotification({{ $notification->id }})";><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all"></i> Delete</button>
                    </td>
                    </tr>
                    @endforeach

                    </tbody>

                </table>
                @if($adminCountNotifications > 0)
                    <button class="btn btn-danger" onclick="deleteAllAdminNotification();">delete all</button>
                @endif
    </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->

@endsection
