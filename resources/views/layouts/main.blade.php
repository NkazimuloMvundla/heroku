<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="robots" content="INDEX,FOLLOW"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
<meta name="format-detection" content="telephone=no"/>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>@yield('title', 'Home Page')</title>
<meta name="keywords" content="@yield('meta_keywords','south african suppliers, south african businesses')">
<meta name="description" content="@yield('meta_description','find south african suppliers')">
<link rel="canonical" href="{{url()->current()}}"/>
<link  rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/css/used-bootstrap.min.css') }}" />
<link rel="stylesheet" type="text/css"  href="{{ asset('pub/bootstrap-3.3.7/css/bootstrap.min.css') }}">
<link  rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/css/styles-m.min.css') }}" />
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
<style nonce="{{ csp_nonce() }}">
    .fa-envelope:before {
    content: "\f0e0"
    }.fa-arrow-right:before {
    content: "\f061"
    }.fa-home:before {
    content: "\f015"
    }.fa-remove:before,.fa-close:before,.fa-times:before {
    content: "\f00d"
    }.fa-heart:before {
    content: "\f004"
    }.pull-right {
    float: right
    }
    .pull-left {
    float: left
    }.fa {
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale
    }
</style>
<link rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/css/font-awesome.min.css') }}" />
<link   rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/css/custom.min.css') }}" />
<link  rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/css/more.min.css') }}" />
<link  rel="stylesheet" type="text/css"  media="screen and (min-width: 768px)" href="{{ asset('pub/css/styles-l.min.css') }}" /> 
<script nonce="{{ csp_nonce() }}" src="/pub/js/jquery-3.5.1.min.js"></script>

</head>
<body id="bodyStyle">
<style nonce="{{ csp_nonce() }}">
.header{margin-bottom: -18px;}
.header-offerzone > #logout-form{display: none;}
div.navbar-header{margin-left:2px;}
button.sidebarCollapse  {border-radius:0;border: 0;}
div.bewlo{position:relative;}
button.submit{background: #ffa50091;height:34px;}
button.submit:hover{background: #ffa50091;}

/*******sidebar*********/
p.made-by > i{color: red}
nav.sidebar > div {font-size: 21px;margin: 4px 14px 4px 4px;}
nav.sidebar > div > button{font-size: 20px;}

/*****header-center******/
div.header-center > div.header-logo > strong > a > span.south{font-size: 32px;}
div.header-center > div.header-logo > strong > a > span.bulk{background-color: #2196F3 !important;color: #fff ;font-size: 32px;}



/******field search*******/
div.field{position:relative;}
div.dropdown-content{margin-left: -20%;width:224px; z-index:10;}
div.dropdown-bar-item > a > span{font-size: 9pt;}
ul.countryList{min-width: 100%;border-radius: 0%}

div.widget > span {
    position: absolute;
    z-index: 10;
    margin-top: 8em;
    margin-left: 5px;
}
ul#liveSearch{display:none;position:absolute}

/*****footer******/
footer.page-footer > div  {background-color:#445268; color: white;}
div.footer-bottom-inner{text-align: center}
span.copyright{color: black}
</style>
<header class="header">
    <div class="panel" id="panel-wrap">
     <div class="tm_header_outer hidden-xs hidden-sm hidden-md">
      <div class="tm_header_top container-width">
          <div class="header-offerzone">
              <ul class="hidden-xs hidden-sm hidden-md">
                @if (Auth::check())
                <li class="text-primary">{{ __('Hello') }}
                {{ Auth::user()->name }}
                </li>
                <li>
                <a data-logout href="{{ route('logout') }}">
                {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                </form>
                </li>
                @else
                <li>
                <a href="{{route('login')}}"> {{ __('Sign in')}}</a>  | <a href="{{route('register')}}"> {{ __('Register')}}</a>
                </li>
                @endif
              <li><a href="{{url('sell')}}">{{ __('Sell')}}</a></li>

              <li class="dropdown  hidden-xs hidden-sm hidden-md">
              <span>Buyers<span class="caret"></span>
               </span>
              <div class="dropdown-content shadow">
              <a href="{{route('BuyingRequest')}}" class="dropdown-bar-item">Post buying requests</a>
              <a href="/suppliers" class="dropdown-bar-item">Search for suppliers</a>
              </div>

              </li>

              <li class="dropdown  hidden-xs hidden-sm hidden-md">
                <span>For Suppliers<span class="caret"></span></span>
                <div class="dropdown-content shadow">
                <a href="{{ route('admin.index') }}" class="dropdown-bar-item ">Display new products</a>
                <a href="/all-buying-requests" class="dropdown-bar-item ">Search buy trade leads</a>
                <a href="{{ route('admin.index') }}" class="dropdown-bar-item ">Manage products</a>
                </div>
              </li>

              <li class="dropdown hidden-xs hidden-sm hidden-md"><span>Service &amp; Membership</span>  <span class="caret"></span> </a>
              <div class="dropdown-content shadow">
              <a href="{{route('membership')}}" class="dropdown-bar-item ">Premium memberships</a>
              <a href="/services" class="dropdown-bar-item"> Services<span class="tag-blue">New</span></a>
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

      <!-- Header for mobile  -->
      <header id="mobile-header">
          <!-- Navbar (sit on top) -->
          <div class="hidden-lg hidden-md">
        <nav class="navbar navbar-default" id="mobile_navbar">
            <div class="container">
                <div class="navbar-header">
                <div class="pull-left">
                    <button type="button" class="navbar-toggle sidebarCollapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                </div>
                <a class="navbar-brand" href="/">MyWebApp.com</a>
                </div>
            </div>
          </nav>
              <div class="bewlo">
                    <form action="/search" method="POST" class="searchFormM" name="searchForm">
                    @csrf
                     <div class="input-group">
                        <div class="control">
                          <div class="search-box">
                          <input type="text" class="form-control" autocomplete="off" placeholder="Search" id="search-mobile" name="search">

                                <ul class="dropdown-menu countryList" id="search_mobile">

                                </ul>

                        </div>
                      </div>
                        <div class="input-group-btn">
                        <button class="btn btn-primary submit" type="submit">
                        <i class="glyphicon glyphicon-search"></i>
                        </button>
                        </div>
                        </div>
                    </form>
              </div>
          </div>
          <!--menus-->
      </header>

            <!-- Sidebar -->
  <nav id="sidebar">
    <div class="pull-right">
   <button type="button" id="sidebarCollapse" class="navbar-btn sidebarCollapse">
                 <span class="fa fa-times"></span>
        </button>
    </div>
    <div class="sidebar-header">
          @if (Auth::check())
          <p>{{ __('Hello!') }} {{ Auth::user()->name}}
          </p>
          @else
           <p><a href="/login">Sign in </a>  |  <a href="/register">Join Free</a></p>
            @endif
                </div>
                <ul class="list-unstyled components">
                    @if(Auth::check())
                        <li>
                        <a  href="{{ route('logout') }}">

                        {{ __('Logout') }}
                        </a>
                        </li>
                    @endif
                    <li>
                        <a href="/">
                        <i class="fa fa-home"></i> <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="/u/mailbox/inbox">
                         <i class="fa fa-envelope"></i> <span>Messages</span>
                       @if(Auth::check())
                       <span class="label label-primary pull-right messages">
                            {{ $count }}
                        </span>
                      @endif
                    </a>
                    </li>
                     <li>
                         <a href="{{ route('allBuyingRequests') }}">
                        <i class="fa fa-chat"></i> <span>Quotations</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('my_favorite') }}">
                        <i class="fa fa-heart"></i> <span>Favourites</span>
                        </a>
                    </li>
                    <li>
                        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="collapsed">
                        <i class="fa fa-service"></i> <span>Services</span>
                        </a>
                        <ul class="list-unstyled collapse" id="pageSubmenu" aria-expanded="false">
                            <li><a href="/sell">Sell</a></li>
                            <li><a href="/membership">Premium membership</a></li>
                            <li><a href="/services">Advertising</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="https://tawk.to/chat/59edc8ddc28eca75e4627939/default">
                        <i class="fa fa-chat"></i> <span>Chat with us</span>
                        </a>
                    </li>
                </ul> 
                <ul class="list-unstyled CTAs">
                    <li><p> <span>Copyright © <?php echo htmlspecialchars(date('Y'))  ;?> Southbulk.com.</span></p> </li>
                    <p class="made-by">Made with <i class="fa fa-heart"></i> by Judge</p>
                </ul>
            </nav>
            <!--end of sidebar-->
      </div>
      <div class="header-center" id="header-center">
          <div class="header-logo">
              <strong class=" hidden-xs hidden-sm hidden-md logo">
              <a href="{{url('/')}}">
              <span class="south">South</span>
              <span class="bulk">Bulk</span>
              </a>
              </strong>
          </div>
      </div>

      <div class="header-right hidden-xs hidden-sm hidden-md " id="header-right"><div class="block block-search">
          <div class="block-search-inner">
              <div class="block block-title"><strong>Search</strong></div>
              <div class="block block-content">
                <form  action="{{ route('formsearch') }}" method="POST"  name="searchForm" class="searchForm">
                    @csrf
                  <div class="field search">
                      <label class="label" for="search" data-role="minisearch-label">
                      <span>Search</span>
                      </label>
                    <div class="control">
                        <div class="search-box">
                            <div class="input-group">
                            <div class="control">
                                <div class="search-box" >
                                <input type="text" class="form-control" autocomplete="off" placeholder="Search" id="search" name="search">
                                <div  class="search-res">
                                   <ul class="dropdown-menu countryList" id="liveSearch">

                                   </ul>
                                </div>
                                </div>
                            </div>
                            <div class="input-group-btn">
                                <button class="btn btn-primary submit" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                            </div>
                        </div>
                    </div>
                  </div>
            </form>
         </div>
      </div>
      </div>
      <div class="tm_headerlinkmenu">
          <div class="tm_headerlinks_inner">
              <div class="headertoggle_img">
                  <div class="my-account-cms">
                      <div class="dropdown pull-right">
                          <span class="btn">Trade center</span>
                          <div class="dropdown-content shadow">
                              <a href="{{ route('admin.index') }}" class="dropdown-bar-item w3-padding"><span>Massages</span> <span class="label label-danger pull-right">
                                  @if(Auth::check())
                                  {{ $count }}
                                  @else
                                  {{ 0 }}
                                  @endif

                              </span></a>
                              <a href="/all-buying-requests" class="dropdown-bar-item">
                                <span>Buy Leads</span> <span class="label label-danger pull-right">
                                  @if(Auth::check())
                                      {{ $countBuyingRequest }}
                                      @else
                                      {{ 0 }}
                                      @endif
                                  </span></a>
                              <a href="{{route('admin.index')}}" class="dropdown-bar-item "><span>My account</span> <span class="label label-danger pull-right"></span></a>
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
  <div class="header-bottom  hidden-xs hidden-sm hidden-md">
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
                                      <ul class="megamenu">
                                      <li data-parent class="cats parent-D">
                                      <span id="megaLists">&#9776; Categories</span>
                                       <div id="menu-mega">
                                      <ul class="menu">
                                      @foreach($pCats as $cats)
                                      <li>
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
                                       <li class="cats">
                                      <span id="megaLists"><a href="{{route('allSellingRequests')}}">Selling Requests</a></span>
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
<footer class="page-footer">
    <div class="w3-container w3-padding">
        <div class="w3-row-paddingt inner-footer-content">
            <div class="col-md-3">
                <div id="footer">
                <h3>About us</h3>
                    <ul >
                    <li><a href="/about-us"><span id="b" class="fa fa-arrow-right"></span> About southbulk.com</a></li>
                    <li><a href="/services"><span id="b" class="fa fa-arrow-right"></span> Our services</a></li>
                    <li><a href="https://tawk.to/chat/59edc8ddc28eca75e4627939/default"><span id="b" class="fa fa-arrow-right"></span> Contact Us </a></li>
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
                    <h3>For supplier</h3>
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
        <div class="footer-bottom-inner container-width">
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
<script nonce="{{ csp_nonce() }}">
 
        $(document).ready(function(){
            $("a[data-logout]").on('click', function(event){
            event.preventDefault();
            document.getElementById('logout-form').submit();

            })
        })
        $(document).ready(function(){
            $(".searchForm").on('submit', function(event){
             return validSearch();

            })
        })

        $(document).ready(function(){
            $(".searchFormM").on('submit', function(event){
             return validSearchM();

            })
        })

             $(document).ready(function () {
                 $('.sidebarCollapse').on('click', function () {
                     $('#sidebar').toggleClass('active');
                   //  $("#bodyStyle").fadeToggle('overlay');
                     $(this).toggleClass('active');
                 });
             });

            $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            });

 </script>

    <!-- Bootstrap 3.3.7 -->
    <script nonce="{{ csp_nonce() }}" src="{{ asset('pub/bootstrap-3.3.7/js/bootstrap.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('pub/js/jquery-ui/jquery-ui.min.js') }}"></script>
     <!--jQuery validate-->
    <script nonce="{{ csp_nonce() }}" src="{{ asset('pub/js/validate/dist/jquery.validate.min.js') }}"></script>
    <!--js fun-->
    <script  nonce="{{ csp_nonce() }}" src="{{ asset('pub/js/functions.min.js') }}"></script>

</body>
</html>
