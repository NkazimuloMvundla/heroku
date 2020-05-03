

  <section class="sidebar">

    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
       <li>
        <a href="{{url('u/mailbox/inbox')}}">
          <i class="fa fa-envelope"></i> <span>Mailbox</span>
          <span class="pull-right-container">
          </span>
        </a>
      </li>

      @if(Auth::user()->account_type == "Supplier" || Auth::user()->account_type == "Both" )
       <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Product</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="{{ url('u/manage-products') }}">
              <i class="fa fa-shopping-cart"></i> <span>Manage-products</span>
              </a>
            </li>
            <li>
              <a href="{{url('u/add-new-product')}}">
              <i class="fa fa-plus"></i> <span>Add new products</span>
              <span class="pull-right-container">
              </span>
              </a>
            </li>
          </ul>
        </li>
       @endif


        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Requests</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li>
                <a href="{{ url('u/manage-buying-request') }}">
                 <span>Manage-Buying-request</span>
                <span class="pull-right-container">
                </span>
                </a>
            </li>
            @if(Auth::user()->account_type == "Supplier" || Auth::user()->account_type == "Both")
               <li>
                <a href="{{ url('u/manage-selling-request') }}">
                  <span>Manage-Selling-request</span>
                <span class="pull-right-container">
                </span>
                </a>
            </li>
             <li>
                <a href="{{ route('SellingRequest') }}">
                 <span>Post Selling request</span>
                <span class="pull-right-container">
                </span>
                </a>
             </li>
             @endif
              <li>
                <a href="{{ route('BuyingRequest') }}">
                 <span>Post  Buying request</span>
                <span class="pull-right-container">
                </span>
                </a>
             </li>
          </ul>
        </li>

      <li>
            <a href="{{ url('u/favorites') }}">
              <i class="fa fa-heart"></i><span>Favourites</span>
               <span class="pull-right-container">

               </span>
             </a>
           </li>
       @if(session::get('account') == "Supplier" || session::get('account') == "Both")
            <li class="">
                <a href="{{ url('u/business-card') }}">
                  <i class="fa fa-building"></i><span>Business Card</span>
                  <span class="pull-right-container">
                  </span>
                </a>
            </li>
            @endif
       </ul>
  </section>
