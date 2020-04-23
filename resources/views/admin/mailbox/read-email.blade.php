@extends('admin.layout.admin')
@section('title' , 'Read email')

@section('content')
<div class="content-wrapper">

    <section class="content">
            <div class="row">
                    <!-- /.col -->

                    <div class="col-md-12">
                      <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">{{ $userMessages->first()->msg_subject }}</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body no-padding">
                        <div class="mailbox-read-info">

                            <div >

                            <h5>From: {{ $msg_from->first()->email }}
                            </h5>

                            </div>
                            <div>

                            <h5>To:   {{ $msg_to->first()->email }}
                            </h5>

                            </div>

                            <div>
                                <h6>
                                  {{ $userMessages->first()->created_at }}
                                </h6>
                            </div>

                                </div>
                          <!-- /.mailbox-read-info -->
                          <div class="mailbox-controls with-border text-center">
                            <!-- /.btn-group -->
                          </div>
                          <!-- /.mailbox-controls -->
                          <div class="mailbox-read-message" style="background: #f4f4f4;margin: 7px;padding: 7px;">
                            <p>{{ $userMessages->first()->msg_body }}</p>
                            @if($userMessages->first()->quantity != 0 ||  $userMessages->first()->quantity_unit != '0' || $userMessages->first()->price != 0)
                            <p>Quantity needed: {{ $userMessages->first()->quantity }} / {{ $userMessages->first()->quantity_unit }} </p>
                            <p>Offered Price: R{{ $userMessages->first()->price }}</p>
                            @endif

                          </div>
                          <!-- /.mailbox-read-message -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">

                          <ul class="mailbox-attachments clearfix">
                            @if(!empty($userMessages->first()->reply_attachment))
                            <li>
                              <!--
                              <span class="mailbox-attachment-icon">
                                <img alt="Company Logo" class="widget-img img-border-light" src="/storage/{{ $userMessages->first()->reply_attachment }}" width="170" height="200">
                                </span>-->
                              <div class="mailbox-attachment-info">

                                    <i class="fa fa-paperclip"></i>{{ $userMessages->first()->reply_attachment }}
                                    <span class="mailbox-attachment-size">

                                      <a href="/storage/{{ $userMessages->first()->reply_attachment }}" class="btn btn-default btn-xs pull-right" download><i class="fa fa-cloud-download"></i> download</a>
                                    </span>
                              </div>
                            </li>
                            @endif
                          </ul>
                        </div>


                        <!-- /.box-footer -->
                        <div class="box-footer">
                          <div class="pull-right">
                            @if( $msg_from->first()->email != Auth::user()->email)

                                    <?php $encoded_id = base64_encode( $userMessages->first()->id) ;?>
                                 <a href="/u/reply/{{ $encoded_id }}"><i class="fa fa-reply"></i> Reply</a>
                            @endif
                          </div>

                        </div>
                        <!-- /.box-footer -->
                      </div>
                      <!-- /. box -->
                    </div>
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
        </section>

</div>
<script>
        $(function () {
          //Add text editor
          $("#compose-textarea").wysihtml5();
        });
      </script>
@endsection
