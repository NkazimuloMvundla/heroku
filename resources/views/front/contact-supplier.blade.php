@extends('layouts.main')

@section('title', 'Contact Supplier')
@section('meta_keywords', 'contact supplier')
@section('meta_description', 'contact a merchant')
<link rel="canonical" href="{{url()->current()}}"/>
@section('content')

<style nonce="{{ csp_nonce() }}">
div.container > div.row{display:flex;justify-content:center;padding: 12px; background: #eaf4ea7a; margin:8px;}
ul.success > li { font-size:15px;}
.successMsg{ font-size:18px;}
</style>

<div class="container">

<div class="row">

<div class="col-md-6">
        @if(Session::has('Contact_Supplier'))
         <ul id="success">
             <li class="label label-success successMsg">{{ Session::get('Contact_Supplier') }}</li>
         </ul>
        @endif
        <div id="result"></div>
        <!--
        <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }} </li>
        @endforeach
        </ul>
    -->
        <div class="contact_supplier" id="contact_supplier">
        <form name="contactSupplierStore" id="contactSupplierStore" action="{{ route('contactSupplierStore') }}" method="POST">
                  @csrf
                  <input type="hidden" name="msg_from_id" id="msg_from_id" value="{{Auth::user()->id}}" >
                  <input type="hidden" name="msg_to_id" id="msg_to_id" value="{{ $product->first()->pd_u_id }}" >
                  <div class="form-group">
                    <span class="bg-success" id="successMsg"></span>
                  </div>
                 <div class="form-group">
                  <img src="{{ url($product->first()->pd_photo) }}" class="img-responsive img-fluid" alt="prodoct-image" width="60" height="60">
                 </div>
                  <div class="form-group">
                        <label>Subject</label>
                  <input type="text"  class="form-control" id="subject" name="subject" placeholder="Please enter a subject" value="{{ 'I am interested  in your ' . $product->first()->pd_name }}">
                  <span class="error" id="subjectErr"></span>
                  @error('subject')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                  </div>
                  <label>Your offer(Shipping included)</label>
                  <div class="form-group">
                  <input type="number" min="1" class="form-control" id="price" name="price" placeholder="ZAR" value="{{old('price')}}">
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
                        <option value="">Choose your option</option>
                        @foreach($measurementUnits as $unit)
                        <option value="{{$unit->mu_name}}" {{ old('quantityUnit') == $unit->mu_name ? 'selected':''}}>{{$unit->mu_name}}</option>
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
                    <input type="number" min="1" id="quantity" name="quantity" placeholder="Please enter quantity eg 1000" class="form-control" value="{{old('quantity')}}">
                      <span class="error" id="quantityErr"></span>
                      @error('quantity')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Add a Message</label>
                    <div class="message">
                      <textarea name="message" id="message"></textarea>
                      <span class="error"></span>
                      @error('message')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                  </div>
                  @if($product->first()->pd_u_id != Auth::user()->id)
                  <input id="submitFormBtnA" name="submitFormBtnA" value="Send Offer" class="btn btn-success"  type="submit"  />
                  @endif
                </form>



              </div>

</div>
</div>

</div>


@endsection
