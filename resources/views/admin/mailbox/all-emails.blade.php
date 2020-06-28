@extends('admin.layout.admin')
@section('title' , 'All emails')

@section('content')
<style  nonce="{{ csp_nonce() }}">
    .scs-msg{
    font-size:17px;
    }
</style>
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
                <h1>
                  Mailbox
                </h1>
                <ol class="breadcrumb">
                  <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li class="active">All emails</li>
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
                    <h3 class="text-center bg bg-warning">All emails</h3>
                      <!-- /.box-header -->
                      <div class="box-body no-padding">
                          <span class="message label label-success"></span>
                        <div class="table-responsive mailbox-messages">
                             <div class="box-body">
                                 @if($count_all_emails > 0)
                          <table id="example1" class="table table-hover table-striped">
                                    <thead>
                                    <tr>
                                    <th></th>
                                    <th>From:</th>
                                    <th>Message</th>
                                    <th>Time</th>
                                    </tr>
                                    </thead>
                                <tbody>
                                    @foreach($allMessages as $message)

                                <tr>
                                    <td><input type="checkbox" id="{{ $message->id}}" name="emails[]" value=""></td>
                                    @foreach ($users as $user )
                                        @if($message->msg_from_id == $user->id )
                                      <td class="mailbox-name">From: {{ $user->company_name}}  </td>
                                        <!--when the click here,  means msg has been read , therefore chnage to 1-->
                                      @endif
                                      @endforeach
                                        <td class="mailbox-subject">
                                    <?php  $encoded_mail_Id = base64_encode($message->id ) ;?>
                                        <a href="/u/mailbox/inbox/read/{{ $encoded_mail_Id}}" data-id="{{ $message->id}}" class="sendMessage"> <b>{{ $message->msg_subject }}
                                        </a>
                                        </td>
                                        <td class="mailbox-date">{{ facebook_time_ago($message->created_at)}}</td>
                                    @endforeach
                            </tbody>
                          </table>
                           @else
                      <p>You have no new message(s)</p>
                       @endif
                     </div>
                          <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                      </div>
                      <!-- /.box-body -->

                      @if(!empty($message))
                      <div class="box-footer no-padding">
                        <div class="mailbox-controls">
                          <!-- Check all button -->
                          <button type="button" name ="submit" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                          </button>
                          <div class="btn-group">
                            <button  class="btn btn-default btn-sm delete_all" name="DeleteAll"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all"></i> Delete</button>

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

    <script  nonce="{{ csp_nonce() }}">
          $(".sendMessage").on("click", function() {
                var id = $(this).data("id");
                sendMessage(id);
            });

             $(".delete_all").on("click", function() {
               return checkedAl();
            });
    </script>

    @endsection
