@extends('layouts.main')
@section('content')

 <div class="page-wrapper">
<!--mainSlider start here-->
  <div class="mainSlider">
    <div class="w3-margin-top">
     <div class="w3-container">
        <div class="slider-background">
          <div class="row main-content" style="display:flex;justify-content:center;">
            <div class="col-md-8">
              <h4 class="sell" data-img="">Do business with South Africa<small> <u>the easy way</u>.</small></h4>
            </div>
          </div>
        </div>
    </div>
    </div>


    <!--Mobile menu start-->
    <div class="mobile-menu hidden-lg" align="center">
        <div class="row row-1" style="padding: 4px ;  overflow-x: scroll;" >
          <div class="row-2 col-xs-3" style="flex-basis: 23%;">
            <a href="/categories">
                <img src="https://media.publit.io/file/ecomImages/profile/icons/menu2.png" alt="All Categories" />
            <p id="mobile-menu">All <br><span style="margin-left:4px;">Categories</span></p>
            </a>
          </div>
          <div class="row-2  col-xs-3 " style="flex-basis: 23%;">
              <a href="/suppliers"><img src="https://media.publit.io/file/ecomImages/profile/icons/gold-medal.png" alt="Featured Suppliers" />
              <p id="mobile-menu">Featured <br>Suppliers</p>
              </a>
          </div>

        <div class="row-2 col-xs-3" style="flex-basis: 23%;" id="Deals">
          <a href="/services"><img src="https://media.publit.io/file/ecomImages/profile/icons/deal.png" alt="services" />
          <p style="margin-right:4px;" id="mobile-menu">Southbulk<br>Services</p>
          </a>
        </div>
        <div class="row-2  col-xs-3" style="flex-basis: 23%;">
            <a href="/buying-request"><img src="https://media.publit.io/file/ecomImages/profile/icons/contract.png" alt="Buying Requests" />
            <p id="mobile-menu">Buying<br>Request</p>
            </a>
        </div>
        </div>
      </div>


    <div id="main">
    <!--fill a buy re start here-->
    <div class="w3-container hidden-md hidden-sm hidden-xs" id="buying-r">
        <div class="row" style="display:flex;justify-content:center;">
              <span>We connect buyers with South Africa's finest merchants</span>
        </div>
        <div class="row" style="display:flex;justify-content:center;">
            <div class="col-md-4">
              <h6 class="sell" data-slider=""><img src="https://media.publit.io/file/ecomImages/profile/icons/shield.png" alt="safer" /> safer</h4>
            </div>
            <div class="col-md-4">
              <h6 class="sell" data-slider=""><img src="https://media.publit.io/file/ecomImages/profile/icons/choices.png" alt="choices" /> Competitive qoutes</h4>

            </div>
            <div class="col-md-4">
              <h6 class="sell" data-slider=""> <img src="https://media.publit.io/file/ecomImages/profile/icons/membership.png" alt="membership" /> Legit merchants</h4>
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
                      <div class="row-1 col-md-2 col-xs-4">
                      <li>
                        <?php  $category_id = base64_encode(  $category->id  ) ;?>
                    <a href="/products-by-category/{{ $category->pc_name }}/{{ $category_id }}">
                      <img src="/storage/{{ $category->pc_image }}" alt="category image">
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
                    <div class="col-md-5 post-req-form" style="background: white;">
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
                             <div class="form-group" style="text-align: center">
                         <a href="{{ route('BuyingRequest') }}"><button class="btn btn-primary" style="margin-top: 15px;">Get qoutes</button></a>
                             </div>
                         </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

    <div class="w3-container">
        <div class="row" style="padding: 12px; ">
                <!--featured-suppliers-->
                <h2 class="featured">Featured <b> Suppliers</b></h2>
                  <div id="hot-suppliers">
                      @foreach($featured_suppliers as $supplier)
                     <div class="col-md-2">
                      <div class="panel widget row-1" id="hot-supplier-panel">
                            <span style="position: absolute;z-index: 10;margin-top: 8em;margin-left: 5px;">
                              @if($supplier->status == 1)
                                        <img src="https://media.publit.io/file/ecomImages/profile/icons/correct.png" width="20" height="20" alt="verified-supplier" data-toggle="tooltip" data-placement="top" title="Verified supplier">
                               @endif
                                @if($supplier->membership == 'Gold Member')
                                 <img src="/storage/icons/gold-medal.png" width="20" height="20" alt="gold-supplier" data-toggle="tooltip" data-placement="top" title="Gold supplier">
                                @endif

                                </span>
                                  @if(empty($supplier->company_background_img))
                                <div class="widget-header bg-purple" style="background:azure;">
                                    </div>
                                  @endif
                                  @if(!empty($supplier->company_background_img))
                              <div class="widget-header bg-purple">
                                   <img class="widget-bg img-responsive" src="/storage/{{ $supplier->company_background_img }}" alt="Image">
                                  </div>
                                  @endif
                                   <div class="widget-body text-center">
                    <?php   $encoded_supplier_id = base64_encode( $supplier->id) ;?>
                                          <a href="/supplier/{{ $encoded_supplier_id }}">
                                              @if(empty($supplier->company_logo))
                                              <img alt="Profile Picture" class="widget-img  img-border-light" src="/storage/icons/user.png">
                                              @endif
                                              @if(!empty($supplier->company_logo))
                                              <img alt="Profile Picture" class="widget-img img-border-light" src="/storage/{{ $supplier->company_logo }}">
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

                <div class="w3-container">
                    <div class="row" style="padding:10px">
                    <h2 class="featured">Online Trade <b> Shows</b></h2>
                      <div class="row row-1" id="TradeShowsImg">
                        <div class="col-xs-12 col-md-12" id="tradeShowBackground">
                          <div class="tradeShowContent">
                          <small>South Africa's Online Trade shows are <span class="w3-tag w3-orange">Coming soon!</span> <a href=""><span style="text-decoration:underline">Learn more</span></a></small></h3>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>


<!--Container one ends here-->
  </div>
</div>
</div>
<script>
     $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
     });

</script>
@endsection
