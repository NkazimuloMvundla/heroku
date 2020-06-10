@extends('layouts.main')

@section('title', 'Send Buying Request Offer')
@section('meta_keywords', "send a buying message request", "contact supplier")
@section('meta_description', "send buying request message")
@section('content')

<style>
    header.card-header{
    color: #000;
    background-color: #f1f1f1;
    padding-left: 5px;

    }
</style>
<div class="container">
    <div class="row">
   @foreach($sendAmessage as $data)
    <div class="col-md-3" style="margin-top:7px;">
     <header class="card-header">
        @foreach($lastCats as $cat)
        @if($data->br_pc_id == $cat->id)
        {{$cat->pc_name}}
        <span class="label label-warning pull-right" style="font-size:10px;">buying request</span>
        @endif
        @endforeach
        <h3 class="text-center">{{$data->br_pc_name}}</h3>
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
        <p>Selling Quantity:{{$data->br_order_qty}} / {{$data->br_order_qnty_unit}}</p>
        <?php $new_date = date('Y-m-d', strtotime($data->br_expired_date));  ?>
        @if($data->br_expired_date != null)
        <p>Valid till : {{$new_date}} </p>
        @endif
        <hr>
        <div class="message"> <p>{{ $data->message }}</p></div>
        <label>Product Spec:</label>
        <div class="thumb">  <p>{{$data->br_pd_spec}}</p> </div>
        @endforeach
    </div>
    </div>
        <div class="col-md-8">
        @if(Session::has('Message_sent'))
               <div>
                <ul>
                    <li class="label label-success"  style="font-size:15px;">{{ Session::get('Message_sent') }}</li>
                </ul>
               </div>
         @endif
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Make your best offer for this item</h4>
              </div>
              <div class="modal-body" id="modal-body">
            <?php  $encoded_br_u_id = base64_encode( $sendAmessage->first()->br_u_id) ;?>
                <form name="makeAnOffer" method="POST" id="send_selling_message" action="/messages/{{ $encoded_br_u_id }}">
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
                        <option disabled selected>Select</option>
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
                    <div class="form-group">
                    <div class="">
                      <button  class="btn btn-default" id="send-message" type="submit" class="pull-left">Send Offer</button>
                    </div>
                  </div>
                </form>

              </div>
            </div>
            <!-- /.modal-content -->
          </div>
        </div>
    </div>
   <!--jQuery validate-->
    <script src="{{ asset('pub/js/validate/dist/jquery.validate.min.js') }}"></script>
@endsection

