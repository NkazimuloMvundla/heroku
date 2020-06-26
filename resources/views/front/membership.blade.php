@extends('layouts.main')
@section('title', 'Premuim-membership')
@section('meta_keywords', 'premium membership,gold-supplier')
@section('meta_description', 'become a premium member and scale your businesses')
<link rel="canonical" href="{{url()->current()}}"/>
@section('content')
<style type="text/css" nonce="{{ csp_nonce() }}">
h2.sell{
font-size: 26px;
font-weight: 300;
text-align: center;
text-transform: uppercase;
position: relative;
margin: 10% 0 50%;
text-align: center;
padding: 13px 20px;
background: rgba(0,188,150,0.8);
text-shadow: 1px 1px 1px rgba(0,0,0,0.5);
box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.2);
color: #fff;
}
.row-1{
background-image: url(img/hu-chen-60XLoOgwkfA-unsplash.jpg);
background-repeat: no-repeat;
background-color: #ccc;
border: 1px solid;
width: inherit;
height: 390px;
background-position: center center;
background-size: cover;

}
@media screen and (max-width: 600px) {
/* One or more CSS rules to apply when the query is satisfied */
h2.sell{
color: #000;
font-size: 16px;
text-transform: uppercase;
margin: 17px 0 50px;
}
.row-1{height: 190px;background-position: center center;background-size: cover;}
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



.mt-10 {
  margin-top: 10px;
}
.mt-20 {
  margin-top: 20px;
}
.mt-30 {
  margin-top: 30px;
}
.mt-40 {
  margin-top: 40px;
}
.mt-50 {
  margin-top: 50px;
}
.mt-80 {
  margin-top: 80px;
}
.pd-20 {
  padding: 20px;
}
.section-padding {
  padding: 40px 0;
}

.section-title {
  color: #fff;
  display: inline-block;
  font-size: 20px;
  letter-spacing: 0.1rem;
  padding: 10px 24px;

}
.blue-heading {background-color: #3498db;}
.aqua-heading {background-color: #1abc9c;}
.red-heading {background-color: #fa5137;}
.purple-heading {background-color: #c4394e;}
.box-shadow-mixin {box-shadow: 0px 2px 10px 2px rgba(221, 221, 221, 0.73);}
.black-box-shadow-mixin { box-shadow: 0px 2px 9px 10px rgba(20, 21, 25, 0.78);}
.pricing-button a.btn {color: #fff;letter-spacing: 0.1rem;padding: 12px 55px;}
.pricing-button a.btn:hover {opacity: 0.9;}
.design-credit a {
 text-decoration: underline;
  -webkit-text-decoration-style: dotted;
     -moz-text-decoration-style: dotted;
          text-decoration-style: dotted;
}
.gg-pricing-table .price {font-family: 'Signika', sans-serif;}
.icon-table .single-pricing-table {padding: 20px;
box-shadow: 0px 2px 10px 2px rgba(221, 221, 221, 0.73);
}
.icon-table .single-pricing-table .pricing-table-heading h2 {
  color: #3d6370;
  font-size: 22px;
  font-weight: 500;
  letter-spacing: 0.1rem;
  margin-top: 30px;
  position: relative;
  width: 100%;
}
.icon-table .single-pricing-table .pricing-table-heading h2:after {
  border: 1px dashed #eee;
  content: "";
  left: 0;
  position: absolute;
  top: 13px;
  width: 100%;
  z-index: -11111;
}
.icon-table .single-pricing-table .price span {color: #fa5137;font-size: 36px;font-weight: 700;}
.icon-table .single-pricing-table .pricing-item {padding: 20px 0;}
.icon-table .single-pricing-table .pricing-item ul {padding-left: 0;}
.icon-table .single-pricing-table .pricing-item ul li {list-style: none;}
.icon-table .single-pricing-table .pricing-item ul li p strong {color: #325D6A;}
.icon-table .single-pricing-table .pricing-button { padding: 20px 0;}
.icon-table .single-pricing-table .pricing-button a.btn-pricing {background-color: #fa5137;}
.more-pre{font-size: 20px;}
.more-pre i{color: orange;}
@media screen and (max-width: 600px) {
/* One or more CSS rules to apply when the query is satisfied */
h2.sell{color: #000;font-size: 16px;text-transform: lowercase;margin: 17px 0 50px;}
.row-1{height: 190px;background-position: center center;background-size: cover}
.more-pre{font-size: 14px;}
}
h4.red-heading{font-size: 14px}
 </style>
<div class="w3-container">
<div>
<div class="row row-1">
<h2 class="sell">	We are dedicated to help <b>South African Based small businesses and independent retailers</b> go big and global.</h2>
</div>
<div class="row">
<!--source more confidently from SouthAfrica



-->
<div class="col-md-12 text-center w3-padding" >
<h5 class="section-title red-heading">Our reach, reseacrh and targeting tools will help your business thrive and connect with a global audince to scale your business</h5>
</div>

</div>
<div class="row text-center more-pre">
<div class="col-md-4"><i class="fa fa-check"></i> Latest Global Business Opportunities</div>
<div class="col-md-4"><i class="fa fa-check"></i> Comprehensive Marketing & Promotion</div>
<div class="col-md-4"><i class="fa fa-check"></i> More Quotations from Potential Partners</div>
</div>

<section class="section-padding">
<div class="container">
<div class="row">
<div class="col-md-12 text-center">
<h1 class="section-title red-heading">Premium Membership  Package</h1>
</div>

<div class="gg-pricing-table icon-table col-md-12 mt-50">

<div class="col-md-4">
<div class="single-pricing-table text-center clearfix">

<div class="pricing-table-heading">
<div class="pricing-icon">
<!--<img src="assets/images/bicycle.png" alt="" class="center-block img-responsive">-->
</div>
<h2>Basic</h2>
</div>

<div class="price">
<span>FREE</span>
</div>

<div class="pricing-item">
<ul>
<li><p><strong>1</strong> User</p></li>
<li><p><strong>Corporate</strong> Visibility</p></li>
<li><p><strong>5</strong> product listing</p></li>
<li><p><strong>5</strong> Products Displayed on Showcase</p></li>
</ul>
</div>

<div class="pricing-button">
<a href="#" class="btn btn-pricing"><i class="fa fa-check"></i> Sign Up</a>
</div>
</div>
</div>

<div class="col-md-4">
<div class="single-pricing-table text-center clearfix">

<div class="pricing-table-heading">
<div class="pricing-icon">
<!--<img src="assets/images/vespa-1.png" alt="" class="center-block img-responsive">-->
</div>
<h2>Standard</h2>
</div>

<div class="price">
<span>$9.90</span>
</div>

<div class="pricing-item">
<ul>
<li><p><strong>Standard </strong> Corporate Visibility </p></li>
<li><p><strong>Limited</strong> to 20 product posting</p></li>
<li><p><strong>Limited </strong> to 10 Products Displayed on Showcase</p></li>
<li><p><strong>Access</strong> to Buyers' Contact Details</p></li>
<li><p><strong>Receive </strong> Daily buying leads</p></li>
</ul>
</div>

<div class="pricing-button">
<a href="#" class="btn btn-pricing"><i class="fa fa-check"></i> Sign Up</a>
</div>
</div>
</div>

<div class="col-md-4">
<div class="single-pricing-table text-center clearfix">

<div class="pricing-table-heading">
<div class="pricing-icon">
<!--<img src="assets/images/car.png" alt="" class="center-block img-responsive">-->
</div>
<h2>Premium</h2>
</div>

<div class="price">
<span>$100.90</span>
</div>

<div class="pricing-item">
<ul>
<li><p><strong>Proirity </strong> Corporate Visibility </p></li>
<li><p><strong>Limited</strong> to 20 product posting</p></li>
<li><p><strong>Limited </strong> to 10 Products Displayed on Showcase</p></li>
<li><p><strong>Access</strong> to Buyers' Contact Details</p></li>
<li><p><strong>Receive </strong> Daily buying leads</p></li>
<li><p><strong>(SEO)</strong> Search Engine Optimization</p></li>
<li><p><strong>(EDM)</strong>  E-mail Direct Marketing</p></li>
</ul>
</div>

<div class="pricing-button">
<a href="#" class="btn btn-pricing"><i class="fa fa-check"></i> Sign Up</a>
</div>
</div>
</div>
</div>

<div class="design-credit text-center col-md-12 mt-40">
</div>
</div>
</div>
</section>
</div>
</div>


@endsection
