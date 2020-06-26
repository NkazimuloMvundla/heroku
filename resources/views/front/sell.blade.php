@extends('layouts.main')
@section('title' ,'Sell')
@section('meta_keywords', "selling on our plartform")
@section('meta_description', "start delling on our plartform")
@section('content')
<style type="text/css" nonce="{{ csp_nonce() }}">
 	h2.sell{
color: #000;
font-size: 26px;
font-weight: 300;
text-align: center;
text-transform: uppercase;
position: relative;
margin: 17px 0 50px;

}
@media screen and (max-width: 974px) {
/* One or more CSS rules to apply when the query is satisfied */
h2.sell{
color: #000;
font-size: 16px;
text-transform: uppercase;
margin: 17px 0 50px;

}
}
h2 b {
	color: #ffc000;
}
h2.sell::after {
	content: "";
	width: 100px;
	position: absolute;
	margin: 0 auto;
	height: 4px;
	background: rgba(0, 0, 0, 0.2);
	left: 0;
	right: 0;
	bottom: -20px;
}
[data-img]{
        font-size: 26px;
    font-weight: 300;
    text-align: center;
    text-transform: uppercase;
    position: relative;
    margin: 10% 0 50%;
    text-align: center;
    padding: 13px 20px;
    background: #f5f5f5;

    box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.2);
    color: #fff;
}
  .row-1 {

    background-color: #ccc;
    border: 1px solid;
    width: inherit;
    height: 390px;
    background-position: center center;
    background-size: cover;
}

@media only screen and (max-width: 768px) {
  /* For mobile phones: */
  .row-1 {

    height: 430px;

}
}


div.flex{
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    text-align: center;
    font-size: 19px;
}
div.b4-fees{background: #f0f0f0;}
div.data{
    background: #f5f5f5;
    box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.2);
    flex-basis: 25%;
    padding: 12px;
    margin: 7px;


}
div.fees{
    flex-basis: 100%;
    padding: 12px;
    margin: 7px;

}
 </style>
<div class="container">
<div class="col-md-12">
<div class="row">
<div class="row-1">
<h2 class="sell">Who are we ?</h2>
<div class="col-md-4">
  <h2 class="sell" data-img>We are dedicated to help <b>South African Based small businesses</b> go big and global</h2>
</div>
<div class="col-md-4">
 <h2 class="sell" data-img>Our reach, research and targeting tools will help your business thrive </h2>
 <div class="w3-center">
	@if(!Auth::check())
	<button class="btn btn-primary"><a href="{{route('login')}}">Start selling</a></button>
	@endif
</div>
</div>
<div class="col-md-4 hidden-sm hidden-xs hidden-md">
<h2 class="sell" data-img>Connect with a global audince to scale your business.</h2>
</div>
</div>
<div class="row">
<h2 class="sell">Industries we cover</h2>
</div>
<div class="flex">
<div class=" data">Chemicals</div>
<div class=" data">Coal</div>
<div class=" data">Steel</div>
<div class=" data">Minerals</div>
<div class=" data">Agricultural Products</div>
<div class=" data">Petroleum</div>
<div class=" data">Industrial Products</div>
<div class=" data">Machinery</div>
<div class="data">Consumer Goods</div>
<div class=" data">Food</div>
</div>
<div class="row" >
<h2 class="sell">Frequently Asked Questions</h2>
</div>
<div class="flex b4-fees">
 <div class="fees">
 <h2>What fees do I get charged?</h2>
 <p>
  Listing your products on X-po is always free. You can set up your store and start making connections for absolutely free. However we do have restrictions
 </p>
</div>
<div class="fess">
 <h2>How do you stand out on X-po? <small>  Its pretty simple. Follow these 5 cardinal rules: </small></h2>
<ol>
<li>#1Subscribe to be a premium member and enjoy exclusive privileges and prority listing </li>
<li>#2 Make use of our Advertising Service and get 100+ times more brand and
product exposure</li>
<li>#3 God-like images</li>
<li>#4 Detailed and accurate names</li>
<li>#5 Lots of descriptions</li>
</ol>
</div>
</div>
</div>
</div>
</div>


@endsection
