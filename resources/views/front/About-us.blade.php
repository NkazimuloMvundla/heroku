@extends('layouts.main')

@section('title', 'About us')
@section('meta_keywords', 'About our company')
@section('meta_description', 'We help buyers connect with south african merchants')
<link rel="canonical" href="{{url()->current()}}"/>
@section('content')

<style type="text/css" nonce="{{ csp_nonce() }}">
  .welcome{background: #ecf3fb;padding: 12px;margin-top: 3%;color: #f73883;}
  .welcome-row{
    background: #ff4742;
    border: 2px solid #ff4742;
    color: #fff;
    border-radius: 6px;
    text-align: center;
}

.rooted{

    border-radius: 6px;
    text-align: center;
    margin-top: 3%;
    font-size: 15px;
}
/*slideer background */
.about-background {
    background-image: url(/banners/vendor.jpg);
    background-repeat: no-repeat;
    background-color: #ccc;
    border: 1px solid;
    width: 100%;
    height: 390px;
    background-position: center center;
    background-size: cover;
    /*border-radius: 10px 10px 0 0;*/
    border-radius: 0;
}

h4.about {
    color: #fff;
    font-size: 22px;
    font-weight: 300;
    text-align: center;
    position: relative;
    margin: 87px 0 50px;
 }
[data-about] {
    padding: 13px 20px;
    background: #ff4742;
    box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.2);
}
.reach-out{
	background: #f4f7fb;
    padding: 12px;
    border: 2px solid #ff4742;
    border-radius: 6px;
    text-align: center;
    margin-top: 3%;
}
 
</style>
<div class="w3-container">
	<div class="row">
		<div class="col-md-12">
	    <img src="/banners/Blue.gif" class="img-responsives" alt="product image">
		</div>
	</div>
</div>

	<div class="container">
		<div class="row welcome">
			<div class="col-md-12 welcome-row">
		       <p class="text-center"><h2>{{$about_us_content->first()->cms_content}}</h2></p>
			</div>
		</div>

	</div>

    <div class="container">
		<div class="row welcome">
			<div class="col-md-12 welcome-row">
			   <p id="welcome"><h2 class="text-center">Mission</h2></p>
		       <p class="text-center"><h2>Connecting you with South Africa's finest & legitimate community of merchants.</h2></p>
			</div>
		</div>

	</div>

	<div class="w3-container">
		<div class="row rooted">
			<div class="col-md-12">
		       <div class="about-background">
		       	<h4 class="about" data-about>Southbulk has been inspired by small individual entrepreneurs in the streets of South Africa.
		       	Southbulk was founded with one mission in mind, help South African small businesses thrive in the digital world and connect with the global audience.</h4>
		       </div>
			</div>
		</div>

	</div>

    <div class="container">
		<div class="row reach-out">
			<div class="col-md-12">
		      <h3>Want to reach out to us? </h3>
		      Email : support@southbulk.com <br>
		      Chat Live with us <a target="_blank" rel="noopener" href="https://tawk.to/chat/59edc8ddc28eca75e4627939/default"><span id="b" class="fa fa-arrow-right"></span>Chat Now</a>
			</div>
		</div>

	</div>


@endsection
