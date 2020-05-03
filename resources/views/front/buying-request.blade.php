@extends('layouts.main')

@section('title', 'Buying Requests')

@section('content')


 <script>
       $( function() {
       $( "#date" ).datepicker({
       numberOfMonths: 1,
       showButtonPanel: true ,
       minDate: new Date()
       });
       } );
 </script>





<div class="container">
<div class="row" style="padding: 12px; background: #eaf4ea7a; margin:8px;">
    @if(Session::has('buyingRequestPosted'))
            <div>
            <ul>
                <li class="label label-success"  style="font-size:15px;">{{ Session::get('buyingRequestPosted') }}</li>
            </ul>
            </div>
        @endif
<div class="col-md-2"></div>

<div class="col-md-8 w3-margin-top" style=" padding: 12px;">
<form  name="postBuyRequestForm" id="postBuyRequestForm" method="post" action="/buying-request" >
@include('layouts.cats')

<div class="ui-form-item form-group ">
<input type="hidden" id="br_u_id" name="br_u_id" value="{{Auth::user()->id}}"/>
<label class="ui-form-label" for="subject">
Product Name: </label>
<div class="ui-form-control">
<input class="form-control" id="br_pd_name" maxlength="128"  name="productName" type="text" value="{{ old('productName') }}"/>
@error('productName')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror

  <span class="help-block"></span>
<div id="suggest-wrapper" class="suggest-wrapper"></div>
</div>
</div>
        <div class="ui-form-item form-group">
        <label class="ui-form-label" for="detailTextarea">
            Product Detailed Specification:
        </label>
        <div class="ui-form-control">
            <textarea maxlength="50"  id="br_pd_spec" name="detailedSpecification" class="form-control">{{ old('detailedSpecification') }}</textarea>
            <div id="remainingNumber"><span id="countDown" class="remark-alert"></span><span class="text-primary"> Characters Remaining</span> </div>
            @error('detailedSpecification')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <span class="help-block"></span>
    </div>
 <div class="form-group row ">
  <div class="col-xs-6 col-md-6 ">
    <label for="ex2">Order Quantity:</label>
    <input class="form-control" id="br_order_qnty" name="orderQuantity" type="text" value="{{ old('orderQuantity') }}">
    @error('orderQuantity')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-xs-6 col-md-6 ">
  <label for="sel1">Select list:</label>
  <select class="form-control" name="orderQuantityUnit" id="quantityUnit">
    <option selected disabled>Select Unit</option>
    @foreach($measurementUnits as $units)
    <option value="{{$units->mu_name}}" {{ old('orderQuantityUnit') }}>{{$units->mu_name}}</option>
    @endforeach
    </select>
    @error('orderQuantityUnit')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
 </div>
        <div class="ui-form-item form-group ">
        <label class="ui-form-label" for="expireTime">
            Expired Time:</label>
        <div class="ui-form-control">
        <div class="form-group">
        <div id="filterDate2">
          <!-- Datepicker as text field -->
          <div class="input-group date" data-date-format="dd.mm.yyyy">
        <input id="date" name="deliveryDate" type="text" class="form-control " placeholder="dd.mm.yyyy" value="{{ old('diliveryDate') }}">
            <div class="input-group-addon" >
              <span class="glyphicon glyphicon-th"></span>
            </div>
          </div>
        </div>
      </div>
            <span class="help-block"> </span>
            <p class="ui-form-help">Select a date when you no longer want suppliers to contact you.</p>
        </div>
    </div>
    <div class="w3-center ui-form-action form-group">
        <div ><input id="form-submit-btn" name="submitBuyReqButt" value="Submit"  class="btn btn-success " type="submit"></div>
    </div>

</form>
</div>


<div class="col-md-2"></div>


</div>

</div>


<script>
$(document).ready(function() {
    $( "#postBuyRequestForm").validate({
        rules: {
            mainCategory: "required",
            Category: "required",
            subCategory: "required",
            productName: "required",
            detailedSpecification: "required",
            orderQuantityUnit: "required",
            orderQuantity: {
                required: true,
                number: true
            }
        },
        messages: {
            mainCategory: "This field is required",
            Category: "This field is required",
            subCategory: "This field is required",
            productName: "This field is required",
            detailedSpecification: "This field is required",
            orderQuantityUnit: "This field is required",
            orderQuantity: {
                required: "This field is required",
                number: "This field must be numeric",
            }
        }
    });


});


</script>


@endsection
