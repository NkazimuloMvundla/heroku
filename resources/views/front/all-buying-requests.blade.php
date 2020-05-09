@extends('layouts.main')

@section('title', 'Buying Requests')

@section('content')
<div class="container">
    <h4 class="ui-form-group-title text-center text-primary" style="font-size: 20px; background-color:#f8f8f8">Buying requests</h4>
<style>
    header.card-header{
    color: #000;
    background-color: #f1f1f1;
    text-align: center;
    }
</style>
<div class="row">

    @forelse($buyingRequests as $data)
 <div class="col-md-3">
    <header class="card-header">
        @foreach($lastCats as $cat)
        @if($data->br_pc_id == $cat->id)
        >{{$cat->pc_name}}<
        @endif
        @endforeach
        <h3>{{$data->br_pc_name}}</h3>
     </header>
    <div class="data">
        @foreach($users as $user)
        @if($data->br_u_id == $user->id)
        <?php $userId = $user->id ;?>
        <?php Session::put('userId', $userId ); ?>
        <p>Posted by   : {{$user->name}}</p>
        @endif
        @endforeach
        <?php $created_at = date('Y-m-d', strtotime($data->created_at));  ?>
        <p>Date posted :{{$created_at}}</p>
        <p>Order Quantity:{{$data->br_order_qty}} / {{$data->br_order_qnty_unit}}</p>
        <?php $new_date = date('Y-m-d', strtotime($data->br_expired_date));  ?>
        @if($data->br_expired_date != null)
        <p>Valid till : {{$new_date}} </p>
        @endif
        <hr>
        <div class="thumb">  <p>{{$data->br_pd_spec}}</p> </div>
    </div>

    @if($data->br_u_id != Auth::user()->id)
      <button class="btn btn-primary">
    <?php $encoded_request_id = base64_encode( $data->id) ;?>
    <a href="/send-a-buy-message/{{  $encoded_request_id }}">+ Make an offer</a></button>
    @endif

    <button class="btn btn-default " data-toggle="modal" data-target="#modal-default"  onclick="showRequest({{$data->id}});"> + View request </button>

         <!--Moda-->
       <div class="modal fade" id="modal-default" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="modal-title"></h4>
              </div>
              <div class="modal-body" id="modal-body">
                <div class="">
                        <p name="br_pd_spec" id="br_pd_spec"></p>
                </div>
              </div>
              <div class="modal-footer">
                <input type="hidden" id="userId" class="form-control" value="75">
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
<a href="{{route('BuyingRequest')}}" style="color:orange"> Go here </a>  to post a buying request
</div>
@endforelse
</div>

</div>
@endsection
