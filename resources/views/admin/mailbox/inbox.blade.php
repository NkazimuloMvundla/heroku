@extends('admin.layout.admin')
@section('title' , 'Inbox')

@section('content')
<div class="content-wrapper">
  <!-- Main content -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Mailbox
    </h1>
    <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Inbox</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
            <div class="col-md-3">
                    <!--         <a href="compose.html" class="btn btn-primary btn-block margin-bottom">Compose</a>     -->
                    @include('admin.layout.email-sidebar')
                            <!-- /. box -->

                            <!-- /.box -->
                </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="box box-primary">
         <h3 class="text-center bg bg-warning">Inbox</h3>
          <div class="box-header with-border">

          <!-- /.box-header -->
          <div class="box-body no-padding">
             <span class="message label label-success" style="font-size:17px;"></span>
            <div class="table-responsive mailbox-messages">
               <!-- /.box-header -->
            <div class="box-body">
                      @if($count_emails > 0)
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th></th>
                  <th>From:</th>
                  <th>Message</th>
                  <th>Time</th>

                </tr>
                </thead>


                <tbody>

               @foreach($userMessages as $message)
                <tr>
                   <td><input type="checkbox" id="{{ $message->id}}" name="emails[]" value=""></td>
                   @foreach ($users as $user )
                            @if($message->msg_from_id == $user->id )
                          <td class="mailbox-name">{{ $user->company_name}} </td>
                            <!--when the click here,  means msg has been read , therefore chnage to 1-->
                          @endif
                    @endforeach
                  <td class="mailbox-subject">
                      <?php  $encoded_mail_Id = base64_encode($message->id ) ;?>
                            <a href="/u/mailbox/inbox/read/{{ $encoded_mail_Id }}"
                                 onclick="updateStatus({{ $message->id}});"> <b>{{ $message->msg_subject }}
                            </a>
                  </td>
                  <td class="mailbox-date">{{ facebook_time_ago($message->created_at)}}</td>

                </tr>

               @endforeach



                </tbody>

              </table>
              @else
              <p>You have no new message(s)</p>
                  @endif
            </div>
            <!-- /.box-body -->
              <!-- /.table -->
            </div>
            <!-- /.mail-box-messages -->
          </div>
          <!-- /.box-body -->
  <!-- /.box-body -->
  @if(!empty($message))
  <div class="box-footer no-padding">
    <div class="mailbox-controls">
      <!-- Check all button -->
      <button type="button" name ="submit" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
      </button>
      <div class="btn-group">
        <button  class="btn btn-default btn-sm" name="DeleteAll" onclick="checkedAll();"  ><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all" onclick="return deleteAl();"></i> Delete</button>

      </div>
      <!-- /.btn-group -->

      <!-- /.pull-right -->
    </div>
  </div>
  @endif
        </div>
        <!-- /. box -->

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  </section>

</div>



@endsection
