<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','Registration')</title>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
<link rel="stylesheet" type="text/css" href="{{ asset('pub/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}">
<link  rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/css/custom.css') }}" />
<link  rel="stylesheet" type="text/css"  media="all" href="{{ asset('pub/css/more.css') }}" />

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
</body>
</html>
