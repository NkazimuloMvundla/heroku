@extends('layouts.main')

@section('title', 'Selling Requests')
@section('meta_keywords', 'selling requests')
@section('meta_description', 'posted selling requests')
<link rel="canonical" href="{{url()->current()}}"/>

@section('content')
<div class="container">
 <h4 class="ui-form-group-title text-center text-primary">Selling requests</h4>

<style nonce="{{ csp_nonce() }}">
    header.card-header{
    color: #000;
    background-color: #f1f1f1;
    text-align: center;
    }
    div.container > h4 {font-size: 20px; background-color:#f8f8f8}
    #modal-default{display: none;}
    .footer{ margin-top: 12em;}
</style>
 <div class="row">
    @forelse($sellingRequests as $data)
    <div class="col-md-3">
     <header class="card-header">
        @foreach($lastCats as $cat)
        @if($data->sr_pc_id == $cat->id)
        >{{$cat->pc_name}}<
        @endif
        @endforeach
        <h3>{{$data->sr_pc_name}}</h3>
     </header>
    <div class="data">
        @foreach($users as $user)
        @if($data->sr_u_id == $user->id)
        <?php $userId = $user->id ;?>
        <?php Session::put('userId', $userId ); ?>
        <p>Posted by   : {{$user->name}}</p>
        @endif
        @endforeach
        <?php $created_at = date('Y-m-d', strtotime($data->created_at));  ?>
        <p>Date posted :{{$created_at}}</p>
        <p>Selling Quantity:{{$data->sr_order_qty}} / {{$data->sr_order_qnty_unit}}</p>
        <?php $new_date = date('Y-m-d', strtotime($data->sr_expired_date));  ?>
        @if($data->sr_expired_date != null)
        <p>Valid till : {{$new_date}} </p>
        @endif
        <hr>
        <div class="thumb">  <p>{{$data->sr_pd_spec}}</p> </div>
    </div>

    @if($data->sr_u_id != Auth::user()->id)
    <button class="btn btn-primary">
    <?php $encoded_request_id = base64_encode( $data->id) ;?>
    <a href="/send-a-sell-message/{{  $encoded_request_id }}">+ Make an offer</a></button>
    @endif

    <button class="btn btn-success view_request" data-toggle="modal" data-target="#modal-default"  data-id="{{ $data->id }}"> + View request </button>

         <!--Moda-->
       <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="modal-title"></h4>
              </div>
              <div class="modal-body" id="modal-body">
                <div class="">
                        <p name="sr_pd_spec" id="sr_pd_spec"></p>
                </div>
                <div class="bg bg-warning">
                        <p name="sr_message" id="sr_message"></p>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
    </div>
    @empty
    <p class="text-center text-primary">Oops, Nothing as yet</p>
    <div class="text-center text-primary">
    <a href="{{route('SellingRequest')}}"> Go here </a>  to post a selling request
    </div>
    @endforelse
</div>

</div>

<script nonce="{{ csp_nonce() }}">

 $(document).ready(function(){
    $(".view_request").on('click', function(){
       var id = $(this).data("id");
       showSellingRequest(id);
    })
  })

</script>
@endsection
