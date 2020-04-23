<header class="main-header">
        <!-- Logo -->
      <a href="{{route('home')}}" class="logo">

          <!-- mini logo for sidebar mini 50x50 pixels -->

          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Southbulk.com</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="/" class="sidebar-toggle" data-toggle="push-menu" role="button">
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
                 <?php $new_date = date('Y-m-d', strtotime(Auth::user()->created_at)); // prints the current date

                 ?>

                 <small>Member Since {{ $new_date }}</small>
                    </p>
                    <p> Business type: {{ Auth::user()->account_type }}</p>
                  </li>




                  <!-- Menu Footer-->
                  <li class="user-footer">
                      @if(Session::has('account'))
                    <div class="pull-left">
                      @if(Session::get('account') == 'Supplier' || Session::get('account') == 'Both' )
                      <a href="{{route('Profile')}}" class="btn btn-default btn-flat">Profile</a>
                      @endif
                    </div>
                      @endif
                    <div class="pull-right">
                  <a href="{{route('logout')}}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">

            {{ __('Logout') }}</a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                    </div>
                  </li>
                </ul>
              </li>

            </ul>      </div>
        </nav>
      </header>
