<header class="main-header">
    <style nonce="{{ csp_nonce() }}">
    .notifications-menu{margin-right: 6em;border-right: 1px solid #d2d6de;}
    li.user-menu > p {margin:13px 9px 0 0;}
    form#logout-form{display: none;}
    </style>
    <!-- Logo -->
  <a href="{{route('super.index')}}" class="logo">

      <!-- mini logo for sidebar mini 50x50 pixels -->

      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Southbulk.com</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php session(['username' => Auth::user()->name ]);
            ?>

              <span class="hidden-xs">{{ session('username') }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <p>
                  buyer  <small>Member since 2020</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{route('Profile')}}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
              <a href="{{route('logout')}}" class="btn btn-default btn-flat">

                    {{ __('Logout') }}</a>

                 <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
                </div>
              </li>
            </ul>
          </li>

        </ul>      </div>
    </nav>
  </header>
  
  <script nonce="{{ csp_nonce() }}">
   $(document).ready(function(){
            $("a[data-logout]").on('click', function(event){
            event.preventDefault();
            document.getElementById('logout-form').submit();

            })
         })
  </script>