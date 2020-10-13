@extends('layouts.main')
@section('title' ,'Product Details')
<?php  $pd_name = htmlspecialchars( $product->first()->pd_name) ;?>
@section('meta_keywords', $pd_name)
<?php  $pd_listing_description = htmlspecialchars( $product->first()->pd_listing_description) ;?>
@section('meta_description', $pd_listing_description)

@section('content')
 <script nonce="{{ csp_nonce() }}">

    $(document).ready(function() {
       $("#content-slider").lightSlider({
           loop:true,
           keyPress:true
       });
       $('#image-gallery').lightSlider({
           gallery:true,
           item:1,
           thumbItem:9,
           slideMargin: 0,
           speed:500,
           auto:false,
           loop:true,
           onSliderLoad: function() {
               $('#image-gallery').removeClass('cS-hidden');
           }
       });
   });
</script>
 <style nonce="{{ csp_nonce() }}">
 div.lSSlideWrapper {transition-duration: 500ms; transition-timing-function: ease;}
 ul.lSGallery{margin-top: 5px; transition-duration: 500ms; width: 121.5px; transform: translate3d(0px, 0px, 0px);}
 	@media (max-width: 768px) {
			  ul.lSGallery > li {
			        width:121px
            }
    }
   ul.lSGallery > li {width:100%;width:35.333333333333336px;margin-right:5px;}
 .breadcrumb{background: #FFF;}
    ul{
        list-style: none outside none;
        padding-left: 0;
        margin: 0;
    }
    .demo .item{
        margin-bottom: 60px;
    }
    .content-slider li{
        background-color: #ed3020;
        text-align: center;
        color: #FFF;
    }
    .content-slider h3 {
        margin: 0;
        padding: 70px 0;
    }
    .demo{
        width: 800px;
    }
    .drift-demo-trigger {

        float: left;
    }

		@media (max-width: 900px) {
			.wrapper {
				text-align: center;
				width: auto;
			}

			.detail,
			.drift-demo-trigger {
				float: none;
			}

			.drift-demo-trigger {
				max-width: 100%; 
				width: auto;
				margin: 0 auto;
			}

			.detail {
				margin: 0;
				width: auto;
			}

			p {
				margin: 0 auto 1em;
			}

			.responsive-hint {
				display: none;
			}

			.drift-bounding-box {
				display: none;
			}
		}

 /* @media (min-width: 992px){
      img[data-zoom]{
          margin-left:15%;
      }
  }*/
a#product_cats{text-decoration: underline;color: orange;}
.title {font-size: 18px;color: #212121;white-space: normal;overflow: hidden;text-overflow: ellipsis;
max-height: auto;}
div.detail{background: #eaf4ea7a}
span.product-description  > span {font-size:16px;}
span#product_discription{color:#e64545; font-size:14px;}
span#product_discription > span {color:#e64545; font-size:14px;}
span#make_offer{font-size: 10pt;width:30%}
p.social{margin-top:25px;}
p.social > span{font-size:10pt;}
a.#supplier_link{color:#052d7a; font-size:14px;}
div#more_details{decoration:underline; display:none;}
div#modal-default{display: none;}
img[data-images]{width: 400px;height: 100%;}
span#industries{font-size:11px;}
td[data-rated]{width: 50%;}
div#valid{display: none;}
td#questionUpdates{width: 50%;}
ul.social-conn{display: flex;}
.fa-facebook-official , .fa-twitter-square , .fa-linkedin-square{font-size:22px; cursor: pointer; margin:10px;}
p.share-social{margin-top:7px;}
.product-detail{color:#c50f31bf}
</style>
<link rel="stylesheet" nonce="{{ csp_nonce() }}" type="text/css" href="{{ asset('pub/Responsive-Tabs/css/easy-responsive-tabs.min.css') }}">
<!--lightSlider CSS-->
<link  rel="stylesheet" nonce="{{ csp_nonce() }}" type="text/css"  media="all" href="{{ asset('pub/light/src/css/lightslider.min.css') }}" />
<link  rel="stylesheet" nonce="{{ csp_nonce() }}" type="text/css"  media="all" href="{{ asset('pub/drift-master/dist/drift-basic.css') }}" />
    <div class="container">
        <div class="hidden-xs hidden-sm hidden-meduim">
          <ul class="breadcrumb">
              <li><a href="/">Home</a></li>

              <li>{{ $parent->first()->pc_name  }}</li>
                <?php  $cat_id = base64_encode( $subcategory->id  ) ;?>
                <li><a id="product_cats" href="/products-by-category/{{ $subcategory->pc_name  }}/{{  $cat_id  }}">{{ $subcategory->pc_name  }}</a>
                </li>

             <?php  $subCategoryId = base64_encode( $last_categories->id  ) ;?>
              <li><a id="product_cats" href="/products-by-last-category/{{ $last_categories->pc_name  }}/{{ $subCategoryId  }}">{{ $last_categories->pc_name  }}</a></li>
              <li>{{ $product->first()->pd_name }}</li>
          </ul>
        </div>
        <!--first row big-->
        <div class="row">
            <div class="w3-center w3-padding col-md-4" id="product-img">
                <div>
                  <ul id="image-gallery" class="gallery list-unstyled cS-hidden text-center">
                  @foreach ($pd_images as $pd_image)
                    @if($product->first()->pd_id == $pd_image->pd_photo_id)
                    <li data-thumb="{{ url($pd_image->pd_filename) }}" id="data-thumbs">
                    <img data-zoom="{{ url($pd_image->pd_filename) }}"   src="{{ url($pd_image->pd_filename) }}" class="img-responsives" alt="product image">
                    </li>
                    @endif
                    @endforeach
                  </ul>

                </div>
            </div>
            <div class="detail w3-padding col-md-6" id="product-description">
                <div class="product-description">
                  <div class="w3-margin-top">
                  <span class="product-description">
                   <span>{{ $product->first()->pd_name }}</span>
                  </span>
                  </div>
                  <div class="w3-margin-top">
                  <span class="product-description">
                  <span>Product discription : </span>
                  <span class="product-detail">{{ $product->first()->pd_listing_description }}
                  </span>
                  </span>
                </div>
                <div class="w3-margin-top">
                  <span class="product-description">
                  <span>Unit price :</span>
                  <span id="product_discription"><b>ZAR {{ $product->first()->min_price }}-{{ $product->first()->max_price }}</b>
                  </span>
                  </span>
                </div>
                <div class="w3-margin-top">
                    <span class="product-description">
                    <span>Min. Order</span> :<span class="product-detail">{{ $product->first()->pd_min_order_qty  }}  {{ $product->first()->minOrderUnit }}
                      </span>
                    </span>
                </div>
                <div class="w3-margin-top hidden-xs hidden-sm hidden-md">
                  <span class="product-description">
                  <span>Supplier Ability</span>:  <span class="product-detail"> {{ $product->first()->capacity  }}  {{ $product->first()->pd_supply_ability }} <b>:</b> <b>PER</b> {{ $product->first()->supplyPeriod }}<b>
                 </span></b></span>
                </div>
                <div class="w3-margin-top hidden-xs hidden-sm hidden-md">
                    <span class="product-description">
                    <span>Payment Terms:</span>
                    </span>
                     <?php  $i = 1; ?>
                    @foreach ($payments as $payMethod)
                    @if(in_array($payMethod->pt_id ,$payment_t))

                    @if($i<count($payment_t))
                    <?php $payMethod->pt_name.= ', ';?>
                    <?php $i++;?>
                    @endif

                    <span class="product-detail"> {{  $payMethod->pt_name }}  </span>
                    @endif
                    @endforeach
                </div>
              </div>
            <div class="w3-margin-top">
            <?php  $encoded_user_id = base64_encode($product->first()->pd_u_id ) ;?>
            <?php  $encoded_product_id = base64_encode( $product->first()->pd_id) ;?>
              <a href="/contact-supplier/product/{{ $encoded_product_id}}/supplier/{{ $encoded_user_id}}"><span class=" btn btn-primary btn-md">
            <span id="make_offer"> Make an Offer <i class="fa fa-envelope"> </i></span>
            </span></a> </a>
            </div>


                <div id="social-conn">
                    <p class="text-success share-social">Share</p>
                    <ul class="social-conn">
                    <li class="social-share facebook"><i class="fa fa-facebook-official" aria-hidden="true"></i></li>
                    <li class="social-share twitter"><i class="fa fa-twitter-square" aria-hidden="true"></i></li>
                    <li class="social-share linkedin"><i class="fa fa-linkedin-square" aria-hidden="true"></i></li>
                    </ul>
                </div>

        </div>

        <div class="hidden-xs hidden-sm hidden-md row-1 w3-padding col-md-2">
            <div class="w3-margin-top">
                <?php  $encoded_user_id = base64_encode($user->first()->id) ;?>
                <a id="supplier_link" href="/supplier/{{ $encoded_user_id}}"><b>{{ $user->first()->company_name }}</b> </a>
                @if($user->first()->status == 1)
                     <img src="{{ url("icons/correct.png") }}" width="20" height="20" alt="verified-supplier" data-toggle="tooltip" data-placement="top" title="Verified supplier">
                @endif
                @if($user->first()->membership == 'Gold Member')
                 <img src="{{ url("icons/gold-medal.png") }}" width="20" height="20" alt="gold-supplier" data-toggle="tooltip" data-placement="top" title="Gold supplier">
                @endif
            </div>
                 <?php  $encoded_user_id = base64_encode($user->first()->id) ;?>
            <a href="/supplier/{{ $encoded_user_id }}">
              <div class="w3-margin-top w3-margin-right w3-button w3-white w3-border w3-border-blue w3-hover-blue">Visit store</div>
             </a>
        </div>
    </div>
    <!--end of first row-->
  </div>
        <div class="w3-bottom hidden-lg hidden">
            <div class="w3-bar w3-center w3-white w3-card-4 w3-padding">
            <span class="btn btn-primary"><span> Contacts Now <i class="fa fa-envelope"> </i></span></span>
            </div>
        </div>
        <!--product tabs-->

    <div class="w3-margin-top container">
      <div id="container">
          <div id="product_detail">
              <ul class="resp-tabs-list hor_1">
                  <li>Products details</li>
                  <li>Company details</li>
                  <li>Reviews</li>
                  @if(count($questions) > 0)
                  <li>Product FAQ's</li>
                  @endif
              </ul>
          <div class="resp-tabs-container hor_1">
              <div>
                  <div class="panel-body">
                      <div class="row">
                         @if(count($spec_option) > 0)
                          <div class="col-md-6">
                              <h4 class="bg-info text-center">Specifications</h4>
                                @foreach($spec_option as $spec_opt)
                                    @foreach($specifications as $spec)
                                        @if($spec_opt->spec_parent_id == $spec->spec_id)
                                            <p> {{ $spec->spec_name }} : {{ $spec_opt->spec_option_name}}   </p>
                                        @endif
                                    @endforeach
                                @endforeach

                          </div>
                              @endif
                      <div class="col-md-6">
                            <h4 class="bg-info text-center">Trade information</h4>
                            <div>
                            <p> Port: 	{{ $product->first()->port }} </p>
                            </div>
                            <div>
                            <p> Supply ability: 	{{ $product->first()->capacity  }}  {{ $product->first()->pd_supply_ability }} <b>:</b> <b>PER</b> {{ $product->first()->supplyPeriod }} </p>
                            </div>

                            <div >
                            <p> Estimated delivery time: {{$product->first()->pd_delivery_time}} </p>
                            </div>
                      </div>

                      <div id="more_details" class="text-primary w3-center hidden-lg">
                            <span data-toggle="modal" data-target="#modal-default"  class="w3-margin-top btn btn-success btn-sm" >More details</span>
                            <!--Moda-->
                            <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Product Details</h4>
                            </div>
                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                            <!-- Modal ends here -->
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-12">
                      <h4 class="bg-info text-center">Images</h4>
                          <div>
                          @foreach ($pd_images as $pd_image)
                          @if($product->first()->pd_id == $pd_image->pd_photo_id)
                          <img data-images src="{{ url($pd_image->pd_filename) }}" class="img-responsive" alt="product-image">
                          @endif
                          @endforeach
                          </div>

                      </div>
                  </div>
                </div>
            </div>

    <!--second tab start-->
          <div>
           <div>
            <div>
              <h4 class="bg-info text-center"><b>Basic Information</b></h4>
            </div>
          <div>
            <?php  $encoded_user_id = base64_encode($user->first()->id) ;?>
            <a id="supplier_link" href="/supplier/{{ $encoded_user_id }}" ><b>{{ $user->first()->company_name }}</b> </a>
            @if( $user->first()->status == 1)
            <img src="{{ url("icons/correct.png") }}" width="20" height="20" alt="verified-supplier" data-toggle="tooltip" data-placement="top" title="Verified supplier">
            @endif
            @if( $user->first()->membership == 'Gold Member')
             <img src="{{ url("icons/gold-medal.png") }}" width="20" height="20" alt="gold-supplier" data-toggle="tooltip" data-placement="top" title="Gold supplier">
            @endif
              <p><i class="fa fa-building"></i><strong> Business type </strong>: 	{{ $user->first()->account_type }} </p>
              <p><i class="fa fa-map"></i> <strong> Location </strong>: South Africa </p>
              <p><i class="fa fa-registered"></i><strong> Registration number </strong>: {{ $user->first()->registration_number }} <small>  confirmed with <a href="http://www.seda.org.za/">SEDA</a></small></p>
                    @if($export > 0)
                    <p> <i class="fa fa-money"></i> <strong> Export percentage </strong>: <b>{{$export_capabilities->first()->export_percentage}} %</b> </p>
                    <p>
                    <?php
                    $markets = explode(',', $export_capabilities->first()->main_markets);
                    ?>
                    <strong><i class="fa fa-globe"></i> Markets : </strong>
                       <?php  $i = 1; ?>
                    @foreach ($markets as $ind )
                    @if($i<count($markets))
                    <?php $ind.= ', ';?>
                    <?php $i++;?>
                    @endif
                    <span id="industries">{{ $ind }} </span>
                    @endforeach
                    </p>
                    <p> <i class="fa fa-calendar"></i> <strong>Year started exporting  </strong>: <b>{{$export_capabilities->first()->export_started}}</b> </p>
                    @endif
          </div>
        @if($count_comp_img > 0)
           <div>
              <h4 class="bg-info text-center"><b>Company images</b></h4>
            </div>
            <div class="row">
         <div class="col-md-8">
            @foreach($company_images as $img)
            <img src="{{ url($img->company_image) }}" class="img-responsive" alt="company image">
            @endforeach
         </div>
            </div>
        @endif
            <!--certificates-->

           <div>
               @if($count_certificates > 0)
              <h4 class="bg-info text-center"><b>Company certificates</b></h4>
              @endif
            </div>
            <div class="row">
         <div class="col-md-8">
            @foreach($certificates as $img)
            <img src="{{ url($img->filename) }}" class="img-responsive" alt="company certificate">
            @endforeach
         </div>
            </div>
          </div>
          </div>
          <!--second tab end-->

          <!--reviews tab start-->
           <div>
              <div>
                <div>
                   <div>
                      <div id="review">
                            <table class="table table-striped table-bordered review-table">
                                <tbody>
                                @forelse($reviews as $review)
                                    <tr>
                                    <td data-rated><strong>{{$review->rated_by}}</strong></td>
                                    <?php $date = date('Y-m-d', strtotime( $review->created_at )); ?>
                                    <td class="text-right">{{ $date}}</td>
                                    </tr>
                                      <tr>
                                      <td colspan="2">
                                      <p>{{ $review->review }}</p>
                                      <div class="ratings">

                                      @if($review->rating == 1 )
                                      <div class="rating-box star-rating ">

                                      <i class="fa fa-star checked"></i>
                                      </div>
                                      @endif
                                      @if($review->rating == 2 )
                                      <div class="rating-box star-rating ">

                                      <i class="fa fa-star checked"></i>
                                      <i class="fa fa-star checked"></i>
                                      </div>
                                      @endif
                                      @if($review->rating == 3 )
                                      <div class="rating-box star-rating ">

                                      <i class="fa fa-star checked"></i>
                                      <i class="fa fa-star checked"></i>
                                      <i class="fa fa-star checked"></i>
                                      </div>
                                      @endif
                                      @if($review->rating == 4 )
                                      <div class="rating-box star-rating ">

                                      <i class="fa fa-star checked"></i>
                                      <i class="fa fa-star checked"></i>
                                      <i class="fa fa-star checked"></i>
                                      <i class="fa fa-star checked"></i>
                                      </div>
                                      @endif
                                      @if($review->rating == 5 )
                                      <div class="rating-box star-rating ">

                                      <i class="fa fa-star checked"></i>
                                      <i class="fa fa-star checked"></i>
                                      <i class="fa fa-star checked"></i>
                                      <i class="fa fa-star checked"></i>
                                      <i class="fa fa-star checked"></i>
                                      </div>
                                      @endif

                                      </div>
                                      </td>
                                      @empty
                                      <td>No reviews as yet</td>
                                      </tr>
                                        @endforelse
                                        @if(!count($reviews) == 0)
                                        <tr>
                                        <td colspan="2">
                                        <?php  $encoded_user_id = base64_encode( $product->first()->pd_id) ;?>
                                        <a href="/product/{{  $encoded_user_id  }}/reviews"><h3>See More Review</h3></a>
                                        </td>
                                        </tr>
                                        @endif
                                </tbody>
                            </table>
                            <div class="text-right "></div>
                        </div>
                      <h2 id="review-title">Write a review</h2>
                      <div id="result"></div>
                      <div id="valid" class="alert alert-danger">
                          <ul>
                          @foreach($errors->all() as $error)
                          <li>{{ $error }} </li>
                          @endforeach
                          </ul>
                      </div>
                      <div class="contacts-form" id="review-form">
                          <div class="form-group"> <span class="icon icon-user"></span>
                            <input type="text" name="apr_name" id="apr_name" class="form-control"  placeholder="Your Name">
                          </div>
                          <div class="form-group"> <span class="icon icon-bubbles-2"></span>
                            <textarea class="form-control" name="comment" id="comment" placeholder="Your Review"></textarea>
                          </div>
                          <div class="form-group">
                            <b>Rating</b> <span>Bad</span>&nbsp;
                            <input type="radio" name="rating" value="1"> &nbsp;
                            <input type="radio" name="rating" value="2"> &nbsp;
                            <input type="radio" name="rating" value="3"> &nbsp;
                            <input type="radio" name="rating" value="4"> &nbsp;
                            <input type="radio" name="rating" value="5"> &nbsp;<span>Good</span>
                          </div>
                          <?php $auth = Auth::check() ? Auth::user()->id: ''  ;?>
                          <input type="hidden" name="u_id" id="u_id" value="{{ $auth }}" >
                          <div class="buttons clearfix"><a id="button-review" class="btn sendReview" data-id="{{$product->first()->pd_id}}">Continue</a></div>
                      </div>


                  </div>
                </div>
              </div>
          </div>
          <!--reviews tab end-->

          <!--product FAQ's tab start-->
           @if(count($questions) > 0)
          <div>
           <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                    <th>Question</th>
                    <th>Answer</th>
                    </tr>
                </thead>
                    <tbody>
                        @foreach( $questions as $question )
                            <tr>
                                <td id="questionUpdates">
                                {{ $question->question }}
                                </td>
                                <td>
                                @foreach($answers as $answer)
                                @if($answer->question_id == $question->id)
                                {{ $answer->answer }}
                                @endif
                                @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                  <!-- /.table -->
           </div>
           @endif
          <!--product FAQ's tab end-->
          </div>
        </div>

      <!--you may like-->
      <div class="you-may-like">
        <div class="row">
        <h6 class="block-title">You May Aslo Like</h6>

        @foreach ($you_may_like as $product)
            @if($product->pd_photo != null)
            <div class="col-md-3 col-xs-6  product-item-container">
                <div class="thumb-wrapper">
                    <div class="img-box">
                        <?php $auth = Auth::check() ? Auth::user()->id: ''  ;?>
                        <input type="hidden" name="u_id" id="u_id" value="{{ $auth }}">

                       <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                        <a href="/product-details/{{ $encoded_product_id }}" class="view_product">
                        <img src="{{ url($product->pd_photo)  }}" class="img-responsive" alt="product image" width="150" height="150">

                        </a>
                    </div>
                <div class="thumb-content">
                    <p class="item-name">
                      <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                    <a href="/product-details/{{ $encoded_product_id }}" class="view_product">
                    <span>{{ $product->pd_name }}</span>
                    </a>
                    </p>
                        <p class="item-price"><!--<strike>ZAR 400.00</strike>--> <span>ZAR {{ $product->min_price }}-{{ $product->max_price }}</span></p>
                        <p class="item-price"><span>MOQ:{{ $product->pd_min_order_qty  }}  {{ $product->minOrderUnit }}</span></p>
                      <div class="star-rating hidden">
                          <ul class="list-inline">
                              <li class="list-inline-item"><i class="fa fa-star"></i></li>
                              <li class="list-inline-item"><i class="fa fa-star"></i></li>
                              <li class="list-inline-item"><i class="fa fa-star"></i></li>
                              <li class="list-inline-item"><i class="fa fa-star"></i></li>
                              <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                          </ul>
                      </div>
                        <?php  $encoded_user_id = base64_encode($product->pd_u_id ) ;?>
                        <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                    <a href="/contact-supplier/product/{{ $encoded_product_id}}/supplier/{{ $encoded_user_id}}" class="btn btn-default item">Contact now!</a>
                  
                   @if(Auth::check())
                      @foreach ($fav as  $f)
                      @php
                      $array = $fav->toArray() ;  
                      @endphp			

                      @if( $product->pd_id != $f && !in_array($product->pd_id,$array ) )
                      <a  data-id="{{ $product->pd_id }}" id="{{ "add-to-favs" . $product->pd_id }}" class="fa fa-heart btn btn-default  hidden-sm hidden-xs hidden-md add-to-favs">
                      </a> 
                      <?php break;?>
                      @else
                      <a  data-id="{{ $product->pd_id }}" id="{{ "add-to-favs" . $product->pd_id }}" class="fa fa-heart fa-red btn btn-default  hidden-sm hidden-xs hidden-md add-to-favs">
                      </a> 
                      <?php break;?>
                      @endif
                      @endforeach

                    

                      @endif

                      @if(!Auth::check())
                      <a  data-id="{{ $product->pd_id }}" id="{{ "add-to-favs" . $product->pd_id }}" class="fa fa-heart btn btn-default  hidden-sm hidden-xs hidden-md add-to-favs">
                      </a> 
                      @endif
                </div>
              </div>
            </div>
            @endif
        @endforeach
        </div>
      </div>

      </div>
  </div>
          <!--Drift-->
 <script nonce="{{ csp_nonce() }}" src="{{ asset('pub/drift-master/dist/Drift.min.js') }}"></script>
 <!--Plug-in Initialisation-->
 <script type="text/javascript" nonce="{{ csp_nonce() }}">
     $('.drift-demo-trigger').each(function(i, el) {
	        new Drift(el, {
            paneContainer: document.querySelector('.detail'),
            zoomFactor: 2,
            inlinePane: 900,
            inlineOffsetY: -85,
            containInline: true,
            hoverBoundingBox: true,
            handleTouch:false
		});
    })

    $(document).ready(function() {
        //Horizontal Tab
        $('#product_detail').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });

        // Child Tab
        $('#ChildVerticalTab_1').easyResponsiveTabs({
            type: 'vertical',
            width: 'auto',
            fit: true,
            tabidentify: 'ver_1', // The tab groups identifier
            activetab_bg: '#fff', // background color for active tabs in this group
            inactive_bg: '#F5F5F5', // background color for inactive tabs in this group
            active_border_color: '#c1c1c1', // border color for active tabs heads in this group
            active_content_border_color: '#5AB1D0' // border color for active tabs contect in this group so that it matches the tab head border
        });

        //Vertical Tab
        $('#parentVerticalTab').easyResponsiveTabs({
            type: 'vertical', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo2');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
    });


    $(".sendReview").on("click", function() {
    var id = $(this).data("id");
    sendReview(id);
    });


setShareLinks();

function socialWindow(url) {
  var left = (screen.width - 570) / 2;
  var top = (screen.height - 570) / 2;
  var params = "menubar=no,toolbar=no,status=no,width=570,height=570,top=" + top + ",left=" + left;
  // Setting 'params' to an empty string will launch
  // content in a new tab or window rather than a pop-up.
  // params = "";
  window.open(url,"NewWindow",params);
}

function setShareLinks() {
  var pageUrl = encodeURIComponent(document.URL);
  var tweet = encodeURIComponent($("meta[name='description']").attr("content"));

  $(".social-share.facebook").on("click", function() {
    url = "https://www.facebook.com/sharer.php?u=" + pageUrl;
    socialWindow(url);
  });

  $(".social-share.twitter").on("click", function() {
    url = "https://twitter.com/intent/tweet?url=" + pageUrl + "&text=" + tweet;
    socialWindow(url);
  });

  $(".social-share.linkedin").on("click", function() {
    url = "https://www.linkedin.com/shareArticle?mini=true&url=" + pageUrl;
    socialWindow(url);
  })
}

</script>

  <!-- responsive tags 3.3.7 -->
    <script nonce="{{ csp_nonce() }}" src="{{ asset('pub/Responsive-Tabs/js/easyResponsiveTabs.min.js') }}">
    </script>

    <!--lightSlider JS-->
    <script nonce="{{ csp_nonce() }}" src="{{ asset('pub/light/src/js/lightslider.min.js') }}"></script>


@endsection
