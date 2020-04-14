<div class="row">
		<div class="col-md-12">
			<h2 id="Trend" class="featured">Trending <b>Products</b></h2>
					<div class="row">
              @foreach($slide_one as $slideOne)
						<div class="col-md-3 col-xs-6 col-sm-4">
							<div class="thumb-wrapper">
								<div class="img-box">
										<?php $auth = Auth::check() ? Auth::user()->id: ''  ;?>
										<input type="hidden" name="u_id" id="u_id" value="{{ $auth }}" >
                                    <!--	  <span id="add-to-favs" class="fa fa-heart" data-pd="{{ $slideOne->pd_id }}"></span>-->
                            <?php  $encoded_product_id = base64_encode( $slideOne->pd_id) ;?>
										<a href="/product-details/{{ $encoded_product_id }}">
										@foreach ($featured_images as $pd_image)
										@if($slideOne->pd_id == $pd_image->pd_photo_id )
										<img src="{{$pd_image->pd_filename  }}" class="img-responsive" alt="{{ $slideOne->pd_name }}" width="150" height="150">
										<?php break;?>
										@endif
										@endforeach
										</a>
								</div>
								<div class="thumb-content">
                        <?php  $encoded_product_id = base64_encode( $slideOne->pd_id) ;?>
										<a href="/product-details/{{ $encoded_product_id }}">
										<p class="item-name">{{ $slideOne->pd_name }}</p>
										</a><p class="item-price"><!--<strike>ZAR 400.00</strike>--> <span>ZAR {{ $slideOne->min_price }}-{{ $slideOne->max_price }}</span></p>
                                        <p class="item-price"><span>MOQ:{{ $slideOne->pd_min_order_qty  }}  {{ $slideOne->minOrderUnit }}</span></p>
            <?php  $encoded_user_id = base64_encode($slideOne->pd_u_id ) ;?>
            <?php  $encoded_product_id = base64_encode( $slideOne->pd_id) ;?>
              <a href="/contact-supplier/product/{{ $encoded_product_id}}/supplier/{{ $encoded_user_id}}" class="btn btn-success hidden-sm hidden-xs hidden-md">Contact now!</a>
										<a  onclick="myFavorite({{ $slideOne->pd_id }});" data-pd="" id="add-to-favs" class="fa fa-heart btn btn-default  hidden-sm hidden-xs hidden-md"></a>
								</div>
							</div>
            </div>
            @endforeach
					</div>
				</div>
			</div>
