@extends('layouts.main')

@section('title', 'Selling Requests')
@section('meta_keywords', "selling requests")
@section('meta_description', "post selling requests")
@section('content')

<link rel="stylesheet" type="text/css" href="pub/js/jquery-ui/themes/hot-sneaks/jquery-ui.min.css">
<style nonce="{{ csp_nonce() }}">
div.container > div.row{  padding: 12px; background: #eaf4ea7a; margin:8px;}
div.row > ul > li { font-size:15px;}
div.beforeForm{padding: 12px;}
</style>
 <script nonce="{{ csp_nonce() }}">
       $( function() {
       $( "#date" ).datepicker({
       numberOfMonths: 1,
       showButtonPanel: true ,
       minDate: new Date()
       });
       } );
 </script>


<div class="container">
    <div class="row">
           @if(Session::has('sellingRequestPosted'))
               <div>
                <ul>
                    <li class="label label-success">{{ Session::get('sellingRequestPosted') }}</li>
                </ul>
               </div>
          @endif
        <div class="col-md-2"></div>
            <div class="col-md-8 w3-margin-top">
                <form  name="postBuyRequestForm" id="postBuyRequestForm" method="post" action="/selling-request">
                 @include('layouts.cats') 
                    <div class="ui-form-item form-group ">
                    <input type="hidden" id="sr_u_id" name="sr_u_id" value="{{Auth::user()->id}}"/>
                    <label class="ui-form-label" for="subject">
                    Product Name: </label>
                    <div class="ui-form-control">
                    <input class="form-control" id="sr_pd_name" maxlength="128"  name="productName" type="text" value="{{ old('productName') }}"/>
                    @error('productName')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <span class="help-block"></span>
                    <div id="suggest-wrapper" class="suggest-wrapper"></div>
                    </div>
                    </div>

                    <div class="ui-form-item form-group ">
                    <label class="ui-form-label" for="subject">
                    Message: </label>
                    <div class="ui-form-control">
                    <textarea class="form-control" id="message" maxlength="128"  name="message" placeholder="give a short discription about what you are selling.."></textarea>
                    @error('message')
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
                        <label for="ex2">Selling Quantity:</label>
                        <input class="form-control" id="sr_order_qnty" name="orderQuantity" type="text" value="{{ old('orderQuantity') }}">
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
                        <p class="ui-form-help">Select a date when you no longer want buyers to contact you.</p>
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


<script nonce="{{ csp_nonce() }}">

 $(document).ready(function() {
        $("#c_id").on("change", function() {
             showSubCat(this.value);
        });
    });

</script>


@endsection
