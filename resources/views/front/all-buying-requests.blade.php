@extends('layouts.main')

@section('title', 'Buying Requests')

@section('content')
<div class="container">
    <h4 class="ui-form-group-title text-center text-primary" style="font-size: 20px;">All buying requests</h4>

<div class="row">
        @forelse($buyingRequests as $data)
        <div class="col-md-3">
    <header class="w3-container w3-light-grey">

        @foreach($lastCats as $cat)
        @if($data->br_pc_id == $cat->id)
        >{{$cat->pc_name}}
        @endif
        @endforeach

        <h3>{{$data->br_pc_name}}</h3>
     </header>
    <div class="w3-container data">
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
    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-sending" onclick="sendMessage({{$data->br_u_id}});"> + Make an offer</button>
    @endif

<!--Moda-->
    <div class="modal fade" id="modal-sending"  style="display: none;">
  <div id="result"></div>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <div id="valid" class="alert alert-danger" style="display:none;">
                  <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }} </li>

                    @endforeach
                  </ul>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="">Make your best offer for this item</h4>
              </div>
              <div class="modal-body" id="modal-body">
                <form name="makeAnOffer" id="makeOffer" action="/messages">
                  @csrf
                  <input type="hidden" name="msg_from_id" id="msg_from_id" value="{{Auth::user()->id}}" >

                  <label>Subject</label>
                  <div class="form-group">
                  <input type="text"  class="form-control" id="subject" name="subject" placeholder="Please enter a subject" value="">
                  <span class="error" id="subjectErr"></span>
                  @error('subject')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  </div>
                  <label>Your offer(Shipping included)</label>
                  <div class="form-group">
                  <input type="text" class="form-control" id="price" name="price">
                      <span class="error" id="priceErr"></span>
                      @error('price')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
                  <div class="form-group">
                    <label>Quantity Unit:</label>
                    <div class="quantityUnit">

                      <select name="quantityUnit" id="quantityUnit">
                        <option>Select</option>
                        @foreach($measurementUnits as $unit)
                        <option value="{{$unit->mu_name}}">{{$unit->mu_name}}</option>
                        @endforeach
                      </select>
                      <span class="error" id="quantityUnitErr"></span>
                      @error('quantityUnit')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Quantity :</label>
                    <div class="quantity">
                      <input type="text" id="quantity" name="quantity" placeholder="Please enter quantity eg 1000" class="form-control" >
                      <span class="error" id="quantityErr"></span>
                      @error('quantity')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Add a Comment</label>
                    <div class="comment">
                      <textarea name="comment" id="comment"></textarea>
                              <span class="error" id="commentErr"></span>
                      @error('comment')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>

                </form>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button  class="btn btn-default pull-right" id="send-message" >Send Offer</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

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
