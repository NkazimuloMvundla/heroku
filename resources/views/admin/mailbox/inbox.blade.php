@extends('admin.layout.admin')
@section('title' , 'Inbox')

@section('content')
<style  nonce="{{ csp_nonce() }}">
    .scs-msg{
    font-size:17px;
    }
    #modal_company_result{display: none;}
</style>
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
             <span class="message label label-success scs-msg"></span>
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
                          <td class="mailbox-name">{{ $user->company_name}}
                            @if(Auth::user()->account_type == "Supplier")
                            <span data-toggle="modal" data-target="#modal_company_result"  class="showBuyerDetails" data-id="{{$user->id}}"><a href="#">(view profile)</a></span>
                            @endif
                         </td>
                          @endif
                    @endforeach
                  <td class="mailbox-subject">
                      <?php  $encoded_mail_Id = base64_encode($message->id ) ;?>
                            <a href="/u/mailbox/inbox/read/{{ $encoded_mail_Id }}" class="updateStatus"
                                 data-id="{{ $message->id}}"> <b>{{ $message->msg_subject }}
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
            <!--company-details-->

<!--Moda-->
    <div class="modal fade" id="modal_company_result">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Buyer Info</h4>
              </div>
              <div class="modal-body" id="modal-body">
               <div class="form-group">
                   <label>Company name:</label>
                        <p name="company_name" id="company_name"></p>
                </div>
                    <div class="form-group row">
                       <div class="col-md-6">
                           <label>Last name:</label>
                            <p name="lastname" id="lastname"></p>
                       </div>
                         <div class="col-md-6">
                           <label>Buyer name:</label>
                             <p name="name" id="name"></p>
                       </div>
                </div>
                    <div class="form-group">
                        <label>About us:</label>
                        <p name="about_us" id="about_us"></p>
                    </div>
                    <div class="form-group">
                        <label>Buyer original country:</label>
                        <p name="country" id="country">f</p>
                     </div>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
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


    <script  nonce="{{ csp_nonce() }}">
          $(".showBuyerDetails").on("click", function() {
                var id = $(this).data("id");
                showBuyerDetails(id);
            });

              $(".updateStatus").on("click", function() {
                var id = $(this).data("id");
                updateStatus(id);
            });

             $(".delete_all").on("click", function() {
               return checkedAll();
            });
    </script>

</div>


@endsection
