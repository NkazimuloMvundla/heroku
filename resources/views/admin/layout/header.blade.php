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
                  <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">{{ Session::get('user_messages_count') }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have {{ Session::get('user_messages_count') }} message(s)</li>
              <li class="footer"><a href="{{ route('inbox.index') }}">See All Messages</a></li>
            </ul>
           </li>
           <!-- Notifications: style can be found in dropdown.less -->
         <li class="dropdown notifications-menu" style="margin-right: 6em;border-right: 1px solid #d2d6de;">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{ Session::get('count_notifications') }}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have {{ Session::get('count_notifications') }} notification(s)</li>
              <li class="footer"><a href="{{ route('notifications') }}">View all</a></li>
            </ul>
          </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
               <p style="margin:13px 9px 0 0;" class="dropdown-toggle" data-toggle="dropdown">

                  <span class="btn btn-sm btn-default">{{ "Edit profile" }}</span>
                </p>
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
                      <a href="{{route('Profile')}}" class="btn btn-default btn-flat">Profile</a>
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
