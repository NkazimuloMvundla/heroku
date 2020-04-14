@extends('layouts.main')
@section('title' ,'Product Details')
@section('content')
<style>
.breadcrumb{background: #FFF;}
</style>

<script type="text/javascript">

function sendReview(id){
    //alert("sidd");
    if($('#u_id').val() != ''){
    var product_id=id;
    var name=$("#apr_name").val();
    var comment=$("#comment").val();
    var rating=$("input[name='rating']:checked").val();
    $('.alert-danger').hide();
    $('.alert-danger').html('');
    if(name.trim()==""){
        alert("Your Name is Required !!!");
        $("#apr_name").focus();
        return false;
    }

    if(comment.trim()==""){
        alert("Your comment is required !!!");
        $("#comment").focus();
        return false;
    }
    if (!rating) {
        alert("Please give your rating.....");
        return false;
    }else {
      $.ajax({
        type: "POST",
        url: "/reviews",
        data:{name:name,rating:rating,comment:comment,product_id:product_id},
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
        alert('Your review has been posted successfully');
         window.location="/product-details/{{ $product->first()->pd_id }} " ;


        },
        error: function (request , status , error) {
        json = $.parseJSON(request.responseText);
        $.each(json.errors, function(key,value){
          $('.alert-danger').show();
          $('.alert-danger').append('<p>' + value + '</p>');
        });
        $('#result').html('');
        }
    });
    }

    }else{
        window.location="/login";
    }
}


</script>
 <script>
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
 <style>
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
</style>
    <div class="container">
        <div class="w3-hide-small w3-hide-meduim">
          <ul class="breadcrumb">
              <li><a href="/">Home</a></li>

              <li>{{ $parent->first()->pc_name  }}</li>

              @foreach ($subCats as $cat)
              @if($cat->id == $product->first()->pd_category_id  )
                <?php  $cat_id = base64_encode( $cat->id  ) ;?>
              <li><a href="/products-by-category/{{ $cat->pc_name  }}/{{  $cat_id  }}">{{ $cat->pc_name  }}</a></li>
              @endif
              @endforeach

              @foreach ($lastCats as $subCategory)
              @if($subCategory->id == $product->first()->pd_subCategory_id  )
                  <?php  $subCategoryId = base64_encode( $subCategory->id  ) ;?>
              <li><a href="/products-by-last-category/{{ $subCategory->pc_name  }}/{{ $subCategoryId  }}">{{ $subCategory->pc_name  }}</a></li>
              @endif
              @endforeach
              <li>{{ $product->first()->pd_name }}</li>
          </ul>
        </div>
        <!--first row big-->
        <div class="row">
            <div class="w3-center w3-padding col-md-4" id="product-img">
                <div class="">
                  <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                  @foreach ($pd_images as $pd_image)
                  @if($product->first()->pd_id == $pd_image->pd_photo_id)
                  <li data-thumb="{{ $pd_image->pd_filename }}" id="data-thumbs">
                  <img src="{{ $pd_image->pd_filename }}" class="img-responsive  img-large" style="display:inline-block;" alt="">

                  </li>
                  @endif
                    @endforeach
                  </ul>

                </div>
            </div>
        <style type="text/css">

        .title {
        font-size: 18px;
        color: #212121;
        white-space: normal;
        overflow: hidden;
        text-overflow: ellipsis;
        max-height: auto;
        }
        </style>

            <div class="w3-padding col-md-6" id="product-description" style="
            background: #eaf4ea7a;
            ">
                <div class="product-description">
                  <div class="w3-margin-top">
                  <span class="product-description"><span  style="font-size:14px;">{{ $product->first()->pd_name }}</span></span>
                  </div>
                <div class="w3-margin-top">
                  <span class="product-description">
                  <span style="font-size: 16px">Unit price :</span>
                  <span style="color:#e64545; font-size:14px;"><b>ZAR {{ $product->first()->min_price }}-{{ $product->first()->max_price }}</b>
                  </span>
                  </span>
                </div>
                <div class="w3-margin-top">
                    <span class="product-description">
                    <span style="font-size: 16px">Min. Order</span> : {{ $product->first()->pd_min_order_qty  }}  {{ $product->first()->minOrderUnit }}
                    <span style="font-size: 14px"><b></b></span>
                    </span>
                </div>
                <div class="w3-margin-top w3-hide-small w3-hide-medium">
                  <span class="product-description">
                  <span style="font-size: 16px">Supplier Ability</span>: {{ $product->first()->capacity  }}  {{ $product->first()->pd_supply_ability }} <b>:</b> <b>PER</b> {{ $product->first()->supplyPeriod }}<b>
                  <span style="font-size: 14px"></span></b></span>
                </div>
                <div class="w3-margin-top w3-hide-small w3-hide-medium">
                    <span class="product-description">
                    <span style="font-size: 16px">Payment Terms:</span>
                    </span>
                    @foreach ($payments as $payMethod)
                    @if(in_array($payMethod->pt_id ,$payment_t))
                    <span> {{  $payMethod->pt_name . ' , ' }}  </span>
                    @endif
                    @endforeach
                </div>
              </div>
            <div class="w3-margin-top">
            <?php  $encoded_user_id = base64_encode($product->first()->pd_u_id ) ;?>
            <?php  $encoded_product_id = base64_encode( $product->first()->pd_id) ;?>
              <a href="/contact-supplier/product/{{ $encoded_product_id}}/supplier/{{ $encoded_user_id}}"><span class=" btn btn-primary btn-md" ><span style="font-size: 10pt;width:30%"> Make an Offer <i class="fa fa-envelope"> </i></span></span></a> </a>
            </div>
            <div class="row">
                    <span id="social-conn">
                    <p class="social social-colour  w3-margin-left w3-hide-small w3-hide-medium" style="margin-top:25px;">
                    <span style="font-size: 10pt">Share  </span>
                    <a href="http://www.facebook.com/sharer.php?u=http%3A%2F%2Fb2c.itechscripts.com%2Fproduct.php%3Fp%3D3c59dc048e8850243be8079a5c74d079" class="facebook">
                    <i class="socicon-facebook"></i><span class="sr-only">Share on Facebook</span>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text=Share%20Icons%20Tutorial%20by%20Bootstrapious.com&amp;url=https%3A%2F%2Fbootstrapious.com%2Fp%2Fshare-icons&amp;via=bootstrapious" class="twitter">
                    <i class="socicon-twitter"></i><span class="sr-only">Share on Twitter</span>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=https%3A%2F%2Fbootstrapious.com%2Fp%2Fshare-icons&amp;summary=Check%20out%20this%20nice%20tutorial&amp;source=https%3A%2F%2Fbootstrapious.com%2F" class="linkedin">
                    <i class="socicon-linkedin"></i><span class="sr-only">Share on LinkedIn</span>
                    </a>
                    </p>
                </span>
            </div>
        </div>

        <div class="w3-hide-small w3-hide-medium row-1 w3-padding col-md-2">
            <div class="w3-margin-top">
                <?php  $encoded_user_id = base64_encode($user->first()->id) ;?>
                <a href="/supplier/{{ $encoded_user_id}}" style="color:#052d7a; font-size:14px;"><b>{{ $user->first()->company_name }}</b> </a>
                @if($user->first()->status == 1)
                     <img src="/storage/icons/correct.png" width="20" height="20" alt="verified-supplier" data-toggle="tooltip" data-placement="top" title="Verified supplier">
                @endif
                @if($user->first()->membership == 'Gold Member')
                 <img src="/storage/icons/gold-medal.png" width="20" height="20" alt="gold-supplier" data-toggle="tooltip" data-placement="top" title="Gold supplier">
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
        <div class="w3-bottom w3-hide-large" style="display:none;">
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
              </ul>
          <div class="resp-tabs-container hor_1">
              <div>
                  <div class="panel-body">
                      <div class="row">
                          <div class="col-md-6">
                              <h4 class="bg-info text-center">Specifications</h4>

                              @forelse($spec_option as $spec_opt)
                              @foreach($specifications as $spec)

                              @if($spec_opt->spec_parent_id == $spec->spec_id)

                              <p> {{ $spec->spec_name }} : {{ $spec_opt->spec_option_name}}   </p>

                              @endif
                              @endforeach
                              @empty
                              <p><i>No data</i></p>
                              @endforelse

                          </div>
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

                      <div class="text-primary w3-center w3-hide-large" style="decoration:underline; display:none;">
                            <span data-toggle="modal" data-target="#modal-default"  class="w3-margin-top btn btn-success btn-sm" >More details</span>
                            <!--Moda-->
                            <div class="modal fade" id="modal-default" style="display: none;">
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
                          <img src="{{ $pd_image->pd_filename }}" class="img-responsive" alt="product-image" style="width: 400px;height: 100%;">
                          @endif
                          @endforeach
                          </div>

                      </div>
                  </div>
                </div>
            </div>

          <div>
          <div>
            <div>
              <h4 class="bg-info text-center"><b>Basic Information</b></h4>
            </div>
          <div>
            <?php  $encoded_user_id = base64_encode($user->first()->id) ;?>
            <a href="/supplier/{{ $encoded_user_id }}" style="color:#052d7a; font-size:14px;"><b>{{ $user->first()->company_name }}</b> </a>
            @if( $user->first()->status == 1)
                 <img src="/storage/icons/correct.png" width="20" height="20" alt="verified-supplier" data-toggle="tooltip" data-placement="top" title="Verified supplier">
            @endif
            @if( $user->first()->membership == 'Gold Member')
             <img src="/storage/icons/gold-medal.png" width="20" height="20" alt="gold-supplier" data-toggle="tooltip" data-placement="top" title="Gold supplier">
            @endif
              <p><i class="fa fa-building"></i><strong> Business type </strong>: 	{{ $user->first()->account_type }} </p>
              <p><i class="fa fa-map"></i> <strong> Location </strong>: South Africa </p>
              <p><i class="fa fa-registered"></i><strong> Registration number </strong>: 2324616256 <small>  confirmed with <a href="http://www.seda.org.za/">SEDA</a></small></p>
                    @if($export > 0)
                    <p> <i class="fa fa-money"></i> <strong> Export percentage </strong>: <b>{{$export_capabilities->first()->export_percentage}} %</b> </p>
                    <p>
                    <?php
                    $markets = explode(',', $export_capabilities->first()->main_markets);
                    ?>
                    <strong><i class="fa fa-globe"></i> Markets : </strong>
                    @foreach ($markets as $ind )
                    <span  style="font-size: 11px;">{{ $ind }}, </span>
                    @endforeach
                    </p>
                    <p> <i class="fa fa-calendar"></i> <strong>Year started exporting  </strong>: <b>{{$export_capabilities->first()->export_started}}</b> </p>
                    @endif
          </div>

           <div>
              <h4 class="bg-info text-center"><b>Company images</b></h4>
            </div>
            <div class="row">
         <div class="col-md-8">
            @foreach($company_images as $img)
            <img src="/storage/{{ $img->company_image }}" class="img-responsive" alt="company image">
            @endforeach
         </div>
            </div>
            <!--certificates-->

           <div>
               @if($count_certificates > 0)
              <h4 class="bg-info text-center"><b>Company certificates</b></h4>
              @endif
            </div>
            <div class="row">
         <div class="col-md-8">
            @foreach($certificates as $img)
            <img src="/storage/{{ $img->filename }}" class="img-responsive" alt="company certificate">
            @endforeach
         </div>
            </div>
          </div>
          </div>


          <div>
              <div>
                <div>
                  <div>
                        <div id="review">
                            <table class="table table-striped table-bordered">
                                <tbody>
                                @forelse($reviews as $review)

                                    <tr>
                                    <td style="width: 50%;"><strong>{{$review->rated_by}}</strong></td>
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
                      <div id="valid" class="alert alert-danger" style="display:none;">
                          <ul>
                          @foreach($errors->all() as $error)
                          <li>{{ $error }} </li>
                          @endforeach
                          </ul>
                      </div>
                      <div class="contacts-form">
                          <div class="form-group"> <span class="icon icon-user"></span>
                            <input type="text" name="apr_name" id="apr_name" class="form-control" value="" placeholder="Your Name">
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
                          <div class="buttons clearfix"><a id="button-review" class="btn buttonGray" onclick="sendReview({{$product->first()->pd_id}});">Continue</a></div>
                      </div>

                  </div>
                </div>
              </div>
          </div>
          </div>
          </div>

      <!--you may like-->
      <div class="you-may-like">
        <div class="row w3-margin-top">
        <h6 class="block-title">You May Aslo Like</h6>
        @foreach ($you_may_like as $product)
            <div class="col-md-3 col-xs-6 row-1">
                <div class="thumb-wrapper">
                    <div class="img-box">
                        <?php $auth = Auth::check() ? Auth::user()->id: ''  ;?>
                        <input type="hidden" name="u_id" id="u_id" value="{{ $auth }}" >

                     <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                        <a href="/product-details/{{ $encoded_product_id }}">
                        @foreach ($featured_images as $pd_image)
                        @if($product->pd_id == $pd_image->pd_photo_id)
                        <img src="{{$pd_image->pd_filename  }}" class="img-responsive" alt="product image" width="150" height="150">
                        <?php break; ?>
                        @endif
                        @endforeach
                        </a>
                    </div>
                <div class="thumb-content">
                    <p class="item-name">
                      <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                    <a href="/product-details/{{ $encoded_product_id }}">
                    <span>{{ $product->pd_name }}</span>
                    </a>
                    </p>
                        <p class="item-price"><!--<strike>ZAR 400.00</strike>--> <span>ZAR {{ $product->min_price }}-{{ $product->max_price }}</span></p>
                        <p class="item-price"><span>MOQ:{{ $product->pd_min_order_qty  }}  {{ $product->minOrderUnit }}</span></p>
                      <div class="star-rating w3-hide">
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
                    <a  onclick="myFavorite({{ $product->pd_id }});" data-pd="" id="add-to-favs" class="fa fa-heart btn btn-default  hidden-sm hidden-xs hidden-md"></a>
                </div>
              </div>
            </div>
        @endforeach
        </div>
      </div>

      </div>
  </div>

 <!--Plug-in Initialisation-->
 <script type="text/javascript">
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
</script>

<script>
    $(document).ready(function(){
     $('[data-toggle="tooltip"]').tooltip();
   });
   </script>


@endsection
