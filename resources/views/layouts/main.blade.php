<!doctype html>
<html lang="en">
<head >
<meta charset="utf-8"/>
<meta name="robots" content="INDEX,FOLLOW"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
<meta name="format-detection" content="telephone=no"/>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>@yield('title', 'Home Page')</title>
<link rel="stylesheet" type="text/css" href="{{ asset('pub/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}">
<!--jQuery validate-->
<link rel="stylesheet" type="text/css" href="pub/js/validate/demo/css/screen.css">
<link rel="stylesheet" type="text/css" href="{{ asset('pub/w3css.css') }}">
<link  rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/css/styles-m.css') }}" />
<link  rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/css/font-awesome.min.css') }}" />
<link  rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/css/product-detail.css') }}" />
<link  rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/css/custom.css') }}" />
<link  rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/css/more.css') }}" />


<link rel="stylesheet" type="text/css" href="pub/css/more.css">
<link  rel="stylesheet" type="text/css"  media="screen and (min-width: 768px)" href="{{ asset('pub/css/styles-l.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('pub/Responsive-Tabs/css/easy-responsive-tabs.css') }}">

<!--JqueryUi-->
<link rel="stylesheet" type="text/css" href="pub/js/jquery-ui/themes/hot-sneaks/jquery-ui.css">
<!--lightSlider CSS-->
<link  rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/light/src/css/lightslider.css') }}" />
  <!-- 1. Link to jQuery (1.8 or later), -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
<header class="header" style="margin-bottom: -18px;">
    <div class="panel wrapper " id="panel-wrap">
     <div class="tm_header_outer w3-hide-small w3-hide-medium ">
      <div class="tm_header_top container-width">
          <div class="header-offerzone">
              <ul class="w3-hide-medium w3-hide-small">
          @if (Auth::check())
          <li class="text-primary">{{ __('Hello') }} {{ Auth::user()->name }}
          </li>
          <li><a  href="{{ route('logout') }}" onclick="event.preventDefault();
                                                       document.getElementById('logout-form').submit();">

          {{ __('Logout') }}
          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                          @csrf
                          </form></li>
          @else
          <li><a href="{{route('login')}}"> {{ __('Sign in')}}</a>  | <a href="{{route('register')}}"> {{ __('Register')}}</a>
          </li>
          @endif

              <li><a href="{{url('sell')}}">{{ __('Sell')}}</a></li>
              <li class="w3-dropdown-hover w3-hide-small w3-hide-meduim " style="z-index:10;"><span>Buyers<span class="caret"></span></span>
              <div class="w3-dropdown-content w3-bar-block w3-card" style="width:224px;">
              <a href="{{route('BuyingRequest')}}" class="w3-bar-item">Post buying requests</a>
              <a href="/suppliers" class="w3-bar-item">Search for suppliers</a>
              </div>


              </li>
              <li class="w3-dropdown-hover w3-hide-small w3-hide-meduim " style="z-index:10;"><span>For Suppliers<span class="caret"></span></span>
              <div class="w3-dropdown-content w3-bar-block  w3-card" style="width:224px;">
              <a href="/u/add-new-product" class="w3-bar-item ">Display new products</a>
              <a href="/all-buying-requests" class="w3-bar-item ">Search buy trade leads</a>
              <a href="/u/manage-products" class="w3-bar-item ">Manage products</a>
              </div>
              </li>

              <li class="w3-dropdown-hover hidden-sm hidden-md " style="z-index:10"><a href=""> Service &amp; Membership<span class="caret"></span> </a>
              <div class="w3-dropdown-content w3-bar-block  w3-card" style="width:224px;">
              <a href="{{route('membership')}}" class="w3-bar-item ">Premium memberships</a>
              <a href="/services" class="w3-bar-item"> Services<span class="w3-tag w3-blue">New</span></a>
              </div>
            </li>

              </ul>
          </div>
           <div class="tm_header_left">
                  <div class="header-socail-links ">
                  <ul>
                  </ul>
                  </div>
          </div>
      </div>
      </div>
      <div class="header content" id="header">
      <div class="tm_header container-width">
      <div class="hidden-lg">
          <style>
    /* Jacob Lett - https//BootstrapCreative.com - Reference / Refresh / Repetition */

.modal-header {
  border-bottom: none;
}

.modal-dialog {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
}

.modal-backdrop {
background-color:#fff;
  opacity:1!important;
    border: 10px solid rgba(136, 136, 136, .4);
}

.modal-content {
  height: auto;
  min-height: 100%;
  border-radius: 0;
  background: none;
  box-shadow: none;
}

.modal-body {
  text-align: center;
}

.modal-body form {
  margin: 0 auto;
  float: none;
  width: 300px;
}

.modal-content .close {
  opacity: 1;
  font-size: 30px;
}

.navbar-default .navbar-collapse,
.navbar-default .navbar-form {
  border: none;
}
</style>
      <!-- Header for mobile  -->
      <header id="mobile-header">
          <!-- Navbar (sit on top) -->
          <div class="w3-hide-large" style="z-index:10;">
              <div class="w3-bar w3-white"  id="myNavbar">
              <a href="{{route('admin.index')}}" class="w3-bar-item  w3-hide-large">
                  <i class="fa fa-bars fa-lg"></i>
                  </a>
                  <a href="/" class=" w3-bar-item w3-center"><b><span style="font-size: 14pt">prototype-x.app</span></b>
                  </a>

              </div>
              <div class="bewlo" style="position:relative;">
                    <form action="/search" method="POST" onsubmit="return validSearchM();" name="">
                    @csrf
                        <div class="input-group">
                     <div class="control">
                          <div class="search-box" >
                          <input type="text" class="form-control" autocomplete="off" placeholder="Search" id="search-mobile" name="search">
                          <div id="search_mobile" class="search_mobile">
                          </div>
                        </div>
                      </div>
                        <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-search"></i>
                        </button>
                        </div>
                        </div>
                    </form>
              </div>
          </div>
          <!--menus-->
      </header>
      </div>
      <div class="header-center" id="header-center">
          <div class="header-logo">
              <strong class="w3-hide-small w3-hide-medium logo">
              <a href="{{url('/')}}">
              <span style="font-size: 32px;">South</span><span style="background-color: #2196F3 !important;color: #fff ;font-size: 32px;">Bulk</span>
              </a>
              </strong>
          </div>
      </div>
      <div class="header-right w3-hide-small w3-hide-medium " id="header-right"><div class="block block-search">
          <div class="block-search-inner">
              <div class="block block-title"><strong>Search</strong></div>

              <div class="block block-content">
                <form action="/search" method="POST" onsubmit="return validSearch();" name="searchForm">
                    @csrf
                  <div class="field search" style="position:relative;">
                      <label class="label" for="search" data-role="minisearch-label">
                      <span>Search</span>
                      </label>
                      <div class="control">
                          <div class="search-box" >
                          <input type="text" class="form-control" autocomplete="off" placeholder="Search" id="search" name="search">
                          <div id="countryList" class="search-res">
                          </div>
                          </div>
                      </div>
                  </div>
              <div class="actions">
                  <button
                  title="Search"
                  class="btn btn-primary" >
                  <span>Search</span>
                  </button>
              </div>
            </form>
         </div>

      </div>
      </div>
      <div class="tm_headerlinkmenu">
          <div class="tm_headerlinks_inner">
              <div class="headertoggle_img">
                  <div class="my-account-cms">
                      <div class="w3-dropdown-hover w3-right w3-card-3">
                          <button class="btn btn-success">Trade center</button>
                          <div class="w3-dropdown-content w3-bar-block  w3-card-4" style="right:0; width:224px; z-index:10;">
                              <a href="/u/mailbox/inbox" class="w3-bar-item w3-padding"><span style="font-size: 9pt">Massages</span> <span class="label label-danger w3-right">
                                  @if(Auth::check())
                                  {{ $count }}
                                  @else
                                  {{ 0 }}
                                  @endif

                              </span></a>
                              <a href="/all-buying-requests" class="w3-bar-item "><span style="font-size: 9pt">Buy Leads</span> <span class="label label-danger w3-right">
                                  @if(Auth::check())
                                      {{ $countBuyingRequest }}
                                      @else
                                      {{ 0 }}
                                      @endif
                                  </span></a>
                              <a href="{{route('admin.index')}}" class="w3-bar-item "><span style="font-size: 9pt">My account</span> <span class="label label-danger w3-right"></span></a>
                          </div>
                      </div>
                  </div>
              </div>
           </div>
          </div>
      </div>
   </div>
  </div>

  <!--menu-head start-->
  <div class="header-bottom w3-hide-small w3-hide-medium">
      <div class="w3-container">
          <div class="row">
              <!-- Main menu -->
              <div  class="megamenu-hori header-bottom-right">
                  <div class="responsive so-megamenu">
                      <nav class="navbar-default">
                          <div class="container-megamenu  horizontal">
                              <div class="megamenu-wrapper">
                                  <div class="megamenu-pattern">
                                      <div class="w3-container">
                                      <ul class="megamenu" data-transition="slide" data-animationtime="250" style="margin:0">
                                      <li data-parent class="cats parent-D" >
                                      <span id="megaLists">&#9776; Categories</span>

                                          <div style="position: absolute;
                                      z-index: 999; ">
                                      <ul class="menu">
                                      @foreach($pCats as $cats)
                                      <li style="cursor:pointer;">
                                          {{$cats->pc_name}}
                                      <div class="megadrop">
                                      <?php $parent = $cats->pc_id ;?>
                                      @foreach($subCats as $s)
                                      @if($parent == $s->pc_id)
                                          <div class="col">
                                          <ul>
                                          <li>
                    <?php  $encoded_cat_id = base64_encode($s->id) ;?>
                                          <a href="/products-by-category/{{ $s->pc_name }}/{{ $encoded_cat_id }}" class="subcats">{{ $s->pc_name }}</a>
                                          </li>
                                          </ul>
                                          </div>
                                              @endif
                                      @endforeach
                                      </div>
                                      </li>
                                      @endforeach
                                      </ul>
                                      <!--end of ul-menu-->
                                      </div>
                                      </li>
                                      <li class="cats">
                                      <span id="megaLists"><a href="/suppliers">Suppliers</a></span>
                                      </li>
                                      <li class="cats">
                                      <span id="megaLists"><a href="{{route('allBuyingRequests')}}">Buying Requests</a></span>
                                      </li>
                                      </ul>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </nav>
                  </div>
              </div>
          </div>
        </div>
    </div>
   <!--menu-head end-->
  </div>
  </header>

<div class="yield-content">
  @yield('content')
</div>
<footer class="page-footer" >
    <div class="w3-container w3-margin-top w3-padding" style="background-color:#445268; color: white;">
        <div class="w3-row-padding">
            <div class="col-md-3">
                <div id="footer">
                <h3>About us</h3>
                    <ul >
                    <li><a href="/about-us"><span id="b" class="fa fa-arrow-right"></span> About southbulk.com</a></li>
                    <li><a href="/services"><span id="b" class="fa fa-arrow-right"></span> Our services</a></li>
                    <li><a href="#"><span id="b" class="fa fa-arrow-right"></span> Contact Us </a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div id="footer">
                <h3>For Buyer</h3>
                    <ul >
                    <li><a href="/buying-request"><span id="b" class="fa fa-arrow-right"></span> Post buying request</a></li>
                    <li><a href="/u/mailbox/inbox"><span id="b" class="fa fa-arrow-right"></span> Messege center</a></li>
                    <li><a href="/suppliers"><span id="b" class="fa fa-arrow-right"></span> Search for verified suppliers</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div id="footer">
                    <h3><a href="">For supplier</a></h3>
                    <ul >
                    <li><a href="/membership"><span id="b" class="fa fa-arrow-right"></span> Premium memberships</a></li>
                    <li><a href="/services"><span id="b" class="fa fa-arrow-right"></span> Target marketing</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <h3 class="contact-heading">Subscribe now</h3>
                <div class="newshead">Get daily insights on leads, sale & more</div>
                <div class="content">
                    <form class="form subscribe"
                    action="{{ route('subscriber') }}"
                    method="post">
                    <div class="field newsletter">
                    <div class="control">
                        @csrf
                    <input name="email" type="email" class="form-control" id="newsletter"
                    placeholder="Enter your email address">
                    </div>
                    </div>
                    <div class="actions">
                    <button class="w3-margin-top action subscribe primary" id="subscribe-btn" title="Subscribe" type="submit">
                    <span>Subscribe now</span>
                    </button>
                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-inner container-width" style="text-align: center;padding: 5px;">
            <span class="copyright">
            <span>Copyright © <?php echo htmlspecialchars(date('Y'))  ;?> Southbulk.com. All rights reserved.</span>
            </span>
        </div>
    </div>
    </footer>

    <noscript>
    <div class="message global noscript">
    <div class="content">
    <p>
    <strong>JavaScript seems to be disabled in your browser.</strong>
    <span>For the best experience on our site, be sure to turn on Javascript in your browser.</span>
    </p>
    </div>
    </div>
    </noscript>
    <script src="{{ asset('pub/js/jquery-2.2.4.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('pub/bootstrap-3.3.7-dist/js/bootstrap.min.js') }}"></script>
    <!-- responsive tags 3.3.7 -->
    <script src="{{ asset('pub/Responsive-Tabs/js/easyResponsiveTabs.js') }}">
    </script>
    <!--lightSlider JS-->
    <script src="{{ asset('pub/light/src/js/lightslider.js') }}"></script>
    <!--jQuery ui-->
    <script src="pub/js/jquery/dist/jquery.min.js"></script>
    <script src="pub/js/jquery-ui/jquery-ui.min.js"></script>
    <!--accordian menu-->
    <script src="{{ asset('pub/accordionMenu/jquery.accordionMenu.js') }}"></script>
    <!--jQuery validate-->
    <script src="{{ asset('pub/js/validate/dist/jquery.validate.js') }}"></script>
    <!--js fun-->
    <script src="{{ asset('pub/js/functions.js') }}"></script>



</body>
</html>
