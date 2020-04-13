

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

      @if(session::get('account') == "Supplier" || session::get('account') == "Both" )
     <li class="">
       <a href="{{ url('u/manage-products') }}">
          <i class="fa fa-shopping-cart"></i> <span>Manage-products</span>
        </a>
      </li>
      @endif

     @if(session::get('account') == "Supplier" || session::get('account') == "Both" )
     <li class="">
       <a href="{{url('u/add-new-product')}}">
          <i class="fa fa-plus"></i> <span>Add new products</span>
          <span class="pull-right-container">

          </span>
        </a>
      </li>
      @endif



      <li class="">
       <a href="{{ url('u/manage-buying-request') }}">
         <i class="fa fa-bold"></i><span>Buying requests manager</span>
          <span class="pull-right-container">

          </span>
        </a>
      </li>
      <li class="">
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
