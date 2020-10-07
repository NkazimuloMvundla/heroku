<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','Registration')</title>



    <!-- Fonts -->
    <link  nonce="{{ csp_nonce() }}"  rel="dns-prefetch" href="//fonts.gstatic.com">
    <link nonce="{{ csp_nonce() }}"  href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!--remove this in production-->
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- Styles -->
<link rel="stylesheet" type="text/css" href="{{ asset('pub/bootstrap-3.3.7/css/bootstrap.min.css') }}">
<link  rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/css/custom.css') }}" />
<link  rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/css/more.css') }}" />

 <script nonce="{{ csp_nonce() }}"  src="{{ asset('pub/js/jquery-3.5.1.min.js') }}"></script>

</head>
<body>
    <div id="app">
            <nav class="navbar navbar-default" role="navigation">
                <div class="container">


                    <div class="navbar-header">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                {{ config('Southbulk.com', 'Southbulk.com') }}
                            </a>
                       </div>
                       <div>
                            <ul class="nav navbar-nav">
                           <li class=""><a href="/login">Login</a></li>
                           <li class=""><a href="/register">Registration</a></li>
                       </ul>
                    </div>
                </div>
               </nav>

        <main>
            @yield('content')
        </main>
    </div>
       <!-- InputMask -->
    <script nonce="{{ csp_nonce() }}" src="{{ asset('pub/input-mask/jquery.inputmask.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('pub/input-mask/jquery.inputmask.extensions.js') }}"></script>
    
<script nonce="{{ csp_nonce() }}" >
    
 $(function () {

  //$(selector).inputmask("99-9999999");  //static mask
  $("#phone_number").inputmask({"mask": "(999) 999-9999"}); //specifying options
 // $(selector).inputmask("9-a{1,3}9{1,3}"); //mask with dynamic syntax

  });
</script>
</body>
</html>
