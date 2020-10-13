@extends('layouts.main')
@section('content')

<style nonce="{{ csp_nonce() }}">
 div.slider-background > div.main-content{display:flex;justify-content:center;}

 div.mobile-menu{text-align: center}
 div.moile-menu > div.row {padding: 4px ;  overflow-x: scroll;}
 div.row div.row-2 {flex-basis: 23%;}
 p.mobile-menu{margin-left:4px;}

    div#buying-r div.row{display:flex;justify-content:center;}
    span.cat{margin-left:4px;}
    div.post-req-form{background: white;}
    div.get-qoutes{text-align: center}
    div.get-qoutes > a > button {margin-top: 15px;}


    /*****featured_suppliers*****/
     div.featured-supplier > div.row {padding: 12px;}
     div.hot-supplier-panel{position: absolute;z-index: 10;margin-top: 8em;margin-left: 5px;}
     div.widget-header{background:azure;}


     /****trade shows***/
    div.trade-shows > div.row{padding:10px}
    a[herf="/trade-shows"] > span{text-decoration:underline}
    .mobile-cats{padding-top: 3%;padding-right: 2%;padding-left: 2%;}
    @media only screen and (max-width: 768px) {
     #quantityUnit {
        margin-top: 5%;
    }
   }


</style>
 <div class="page-wrapper">
<!--mainSlider start here-->
  <div class="mainSlider">
    <div class="w3-margin-top">
     <div class="w3-container">
        <div class="slider-background">
          <div class="row main-content">
            <div class="col-md-8">
              <h4 class="sell" data-img="">Do business with South Africa<small> <u>the easy way</u>.</small></h4>
            </div>
          </div>
        </div>
    </div>
    </div>
 

    <!--Mobile menu start-->
    <div class="mobile-menu hidden-lg">
        <div class="row mobile-cats" id="mobile-cats">
          <div class="row-2 col-xs-3">
            <a href="/categories">
                <img src="icons/menu2.png" alt="All Categories" />
            <p id="mobile-menu">All <br><span class="cat">Categories</span></p>
            </a>
          </div>
          <div class="row-2  col-xs-3">
              <a href="/suppliers"><img src="icons/gold-medal.png" alt="Featured Suppliers" />
              <p id="mobile-menu">Featured <br>Suppliers</p>
              </a>
          </div>

        <div class="row-2 col-xs-3" id="Deals">
          <a href="/services"><img src="icons/deal.png" alt="services" />
          <p id="mobile-menu">Southbulk<br>Services</p>
          </a>
        </div>
        <div class="row-2  col-xs-3">
            <a href="/buying-request"><img src="icons/contract.png" alt="Buying Requests" />
            <p id="mobile-menu">Buying<br>Request</p>
            </a>
        </div>
        </div>
      </div>


    <div id="main">
    <!--fill a buy re start here-->
    <div class="w3-container hidden-md hidden-sm hidden-xs" id="buying-r">
        <div class="row">
              <span>We connect buyers with South Africa's finest merchants</span>
        </div>
        <div class="row">
            <div class="col-md-4">
              <h6 class="sell" data-slider=""><img src="banners/shield.png" alt="safer" /> safer</h4>
            </div>
            <div class="col-md-4">
              <h6 class="sell" data-slider=""><img src="banners/choices.png" alt="choices" /> Competitive qoutes</h4>

            </div>
            <div class="col-md-4">
              <h6 class="sell" data-slider=""> <img src="/banners/membership.png" alt="membership" /> Legit merchants</h4>
            </div>
        </div>
    </div>
    <!--Container one-->
    <div class="w3-container">
    <!--featured-products starts-->
    @include('layouts.featured-products-slider')
    </div>

    <div class="w3-container">
     <div class="row find-by-cat-row" id="find-by-cat-row">
        <h2 class="featured">Find by <b>Category</b></h2>
            <div class="w3-center find-by-category">
                <div class="supplier-col col-md-12">
                  <div class="row">
                      @foreach($find_by_category as $category)
                      <div class="col-md-2 col-xs-4 product-item-container">
                      <li>
                        <?php  $category_id = base64_encode(  $category->id  ) ;?>
                    <a href="/products-by-category/{{ $category->pc_name }}/{{ $category_id }}">
                      <img src="{{ url($category->pc_image) }}" alt="category image">
                      <p>{{ $category->pc_name }}</p>
                      </a>
                      </li>
                      </div>
                      @endforeach
                  </div>
                </div>
            </div>
        </div>
    </div>

            <div class="w3-container">
                <div class="row post-req-row" id="post-a-req-row">
                <h2 class="featured">Request for <b>Quotations</b></h2>
                    <div class="post-a-req">
                        <div class="post-a-req-col col-md-12">
                        <div class="row" id="post_a_request">
                        <div class="col-md-7 product-cant-be-found">
                        <h4>Still can't find the product you looking for? </h4>
                        <p class="hidden-sm hidden-xs hidden-md">Submit a buying request to get targeted qoutes from verified merchants.</p>
                        </div>
                        <div class="col-md-5 post-req-form">
                          <div class="form-group">
                              <label>Get qoutes</label>
                             <input type="text" class="form-control" name="product_name" placeholder="Product name">
                          </div>
                             <div class="form-group-row">
                                 <div class="col-md-6">
                                     <input type="text" class="form-control" name="quentity" placeholder="Quantity">
                                 </div>
                                 <div class="col-md-6">
                                    <select class="form-control" name="orderQuantityUnit" id="quantityUnit">
                                    <option selected disabled>Select Unit</option>
                                    @foreach($measurementUnits as $units)
                                    <option value="{{$units->mu_name}}" {{ old('orderQuantityUnit') }}>{{$units->mu_name}}</option>
                                    @endforeach
                                    </select>
                                 </div>
                             </div>
                             <div class="form-group get-qoutes">
                         <a href="{{ route('BuyingRequest') }}"><button class="btn btn-primary">Get qoutes</button></a>
                             </div>
                         </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

    <div class="w3-container featured-supplier">
        <div class="row">
                <!--featured-suppliers-->
                <h2 class="featured">Featured <b> Suppliers</b></h2>
                  <div id="hot-suppliers">
                      @foreach($featured_suppliers as $supplier)
                     <div class="col-md-2">
                      <div class="panel widget row-1" id="hot-supplier-panel">
                            <span>
                              @if($supplier->status == 1)
                                <img src="icons/correct.png" width="20" height="20" alt="verified-supplier" title="Verified supplier">
                               @endif
                                @if($supplier->membership == 'Gold Member')
                                 <img src="icons/gold-medal.png" width="20" height="20" alt="gold-supplier" title="Gold supplier">
                                @endif

                                </span>
                                  @if(empty($supplier->company_background_img))
                                <div class="widget-header bg-purple">
                                    </div>
                                  @endif
                                   @if(!empty($supplier->company_background_img))
                              <div class="widget-header bg-purple">
                                   <img class="widget-bg img-responsive" src="{{url($supplier->company_background_img ) }}" alt="Image">
                                  </div>
                                  @endif
                                   <div class="widget-body text-center">
                    <?php   $encoded_supplier_id = base64_encode( $supplier->id) ;?>
                                          <a href="/supplier/{{ $encoded_supplier_id }}">
                                              @if(empty($supplier->company_logo))
                                              <img alt="Profile Picture" class="widget-img  img-border-light" src="icons/user.png">
                                              @endif
                                              @if(!empty($supplier->company_logo))
                                              <img alt="Profile Picture" class="widget-img img-border-light" src="{{url($supplier->company_logo) }}">
                                              @endif
                                          </a>
                                        <h4 class="mar-no">
                                    <?php   $encoded_supplier_id = base64_encode( $supplier->id) ;?>
                                        <a href="{{ $encoded_supplier_id }}">{{ $supplier->company_name }}</a></h4>
                                        @if(empty($supplier->company_slogan))
                                        <p class="text-muted mar-btm w3-margin-top">
                                            <i></i>
                                          </p>
                                          @endif
                                            @if(!empty($supplier->company_slogan))
                                            <p class="text-muted mar-btm w3-margin-top">
                                            <i>'{{ $supplier->company_slogan }}'</i>
                                          </p>
                                            @endif
                                        <ul class="list-unstyled text-center pad-top mar-no clearfix">
                                      </ul>
                                  </div>
                              </div>
                          </div>
                      @endforeach
                  </div>
               </div>
             </div>

                <div class="w3-container trade-shows">
                    <div class="row">
                    <h2 class="featured">Online Trade <b> Shows</b></h2>
                      <div class="row row-1" id="TradeShowsImg">
                        <div class="col-xs-12 col-md-12" id="tradeShowBackground">
                          <div class="tradeShowContent">
                          <small>South Africa's Online Trade shows are
                              <span class="w3-tag w3-orange">Coming soon!</span>
                              <a href="/trade-shows">
                            <span>Learn more</span></a></small></h3>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>


<!--Container one ends here-->
  </div>
</div>
</div>
@endsection
