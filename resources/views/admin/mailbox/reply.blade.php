@extends('admin.layout.admin')
@section('title' , 'Reply')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <section class="content">
            <div class="row">
                    <!-- /.col -->

                    <div class="col-md-12">
                      <div class="box box-primary">

                        <!-- /.box-footer -->
                        <div class="box-footer">

			                       <div>

            <div >
              <div >
                <div >
				    	 @if(Session::has('sent-success-message'))
				<ul>
				 <li class="label label-success"  style="font-size:15px;">{{ Session::get('sent-success-message') }}</li>
				</ul>
				@endif
                	@if(count($errors) > 0)
                  <div id="valid" class="alert alert-danger" >
                    <ul>
                      @foreach($errors->all() as $error)
                      <li>{{ $error }} </li>

                      @endforeach
                    </ul>
                  </div>
                  @endif
                  <h4 class="modal-title">Reply to {{$msg_from->first()->email}}</h4>
                </div>
                <div class="modal-body" id="modal-body">
                  <form name="makeAnOffer" id="makeOffer" action="/u/reply" enctype="multipart/form-data" method="POST">
                    @csrf
                      <input type="hidden" name="msg_from_id" id="msg_from_id" value="{{ Auth::user()->id }}" >
                    <input type="hidden" name="msg_to_id" id="msg_to_id" value="{{ $msg_from->first()->id }}" >

                    <div class="form-group">
                    <label>Subject:</label>
                    <input type="text" maxlength="255" class="form-control" id="subject" name="subject" placeholder="Please enter a subject" value="{{$userMessages->first()->msg_subject}}">
                    </div>
                    <div class="form-group">
                      <label>Message</label>

                        <textarea name="message"  class="form-control" placeholder="Type your message here.."></textarea>

                    </div>
					 <div class="modal-footer">
		                  <button type="submit" class="btn btn-default pull-right" id="send-message" >Reply</button>
		                </div>
                  </form>

                </div>

              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
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
