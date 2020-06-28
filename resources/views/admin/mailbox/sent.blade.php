@extends('admin.layout.admin')
@section('title' , 'Sent emails')

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
              <li><a href="/.."><i class="fa fa-dashboard"></i> Home</a></li>
              <li class="active">Sent mails</li>
            </ol>
          </section>

    <section class="content">
            <div class="row">
                <div class="col-md-3">
                        <!--         <a href="compose.html" class="btn btn-primary btn-block margin-bottom">Compose</a>     -->
                        @include('admin.layout.email-sidebar')
                    </div>
              <!-- /.col -->
              <div class="col-md-9">
                <div class="box box-primary">
                 <h3 class="text-center bg bg-warning">Sent emails</h3>
                  <!-- /.box-header -->
                  <div class="box-body no-padding">
                        <span class="message label label-success scs-msg"></span>
                    <div class="table-responsive mailbox-messages">
                             <div class="box-body">
                                       @if($count_sent_emails > 0)
                      <table  id="example1"  class="table table-hover table-striped">
                        <thead>
                        <tr>
                        <th></th>
                        <th>To:</th>
                        <th>Message</th>
                        <th>Time</th>
                        </tr>
                        </thead>
                        <tbody>
                                @foreach($sentEmails as $message)

                            <tr>
                                <td><input type="checkbox" id="{{ $message->id}}" name="emails[]" value=""></td>
                                @foreach ($users as $user )
                                    @if($message->msg_to_id == $user->id )
                                  <td class="mailbox-name">{{ $user->company_name}}  </td>
                                    <!--when the click here,  means msg has been read , therefore chnage to 1-->
                                  @endif
                                  @endforeach
                                    <td class="mailbox-subject">
                                 <?php  $encoded_mail_Id = base64_encode($message->id ) ;?>
                                    <a href="/u/mailbox/inbox/read/{{ $encoded_mail_Id}}" data-id="{{ $message->id}}"> <b>{{ $message->msg_subject }}
                                    </a>
                                    </td>
                                    <td class="mailbox-date">{{ facebook_time_ago($message->created_at)}}</td>
                                @endforeach
                        </tr>
                        </tbody>
                      </table>
                       @else
                     <p>You have not sent any message(s)</p>
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
                           <!-- Check all button -->
                 <button type="button" class="btn btn-default btn-sm checkbox-toggle"  ><i class="fa fa-square-o"></i>
                 </button>
                      <div class="btn-group">
                        <button  class="btn btn-default btn-sm delete_all" name="DeleteAll" ><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all"></i> Delete</button>

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
 <script  nonce="{{ csp_nonce() }}">
          $(".sendMessage").on("click", function() {
                var id = $(this).data("id");
                sendMessage(id);
            });

             $(".delete_all").on("click", function() {
               return checkedAl();
            });
    </script>
</div>



@endsection
