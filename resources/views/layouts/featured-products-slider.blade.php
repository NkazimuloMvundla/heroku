<div class="row">
		<div class="col-md-12">
			<h2 id="Trend" class="featured">Trending <b>Products</b></h2>
					<div class="row">
              @foreach($featured_products as $slideOne)
						<div class="col-md-2 col-xs-6 col-sm-4 product-item-container">
							<div class="thumb-wrapper">
								<div class="img-box">
			 							<?php $auth = Auth::check() ? Auth::user()->id: ''  ;?>
										<input type="hidden" name="u_id" id="u_id" value="{{ $auth }}">
                            <?php  $encoded_product_id = base64_encode( $slideOne->pd_id) ;?>
										<a href="/product-details/{{ $encoded_product_id }}" class="view_product">
                                        <img src="{{ $slideOne->pd_photo }}" class="img-responsive" alt="{{ $slideOne->pd_name }}" >
										</a>
								</div>
								<div class="thumb-content">
                        <?php  $encoded_product_id = base64_encode( $slideOne->pd_id) ;?>
										<a href="/product-details/{{ $encoded_product_id }}" class="view_product">
										<p class="item-name">{{ $slideOne->pd_name }}</p>
                                        </a>
                                        <p class="item-price"><!--<strike>ZAR 400.00</strike>--> <span>ZAR {{ $slideOne->min_price }}-{{ $slideOne->max_price }}</span></p>
                                        <p class="item-price"><span>MOQ:{{ $slideOne->pd_min_order_qty  }}  {{ $slideOne->minOrderUnit }}</span></p>
            <?php  $encoded_user_id = base64_encode($slideOne->pd_u_id ) ;?>
            <?php  $encoded_product_id = base64_encode( $slideOne->pd_id) ;?>
              <a href="/contact-supplier/product/{{ $encoded_product_id}}/supplier/{{ $encoded_user_id}}" class="btn btn-success hidden-sm hidden-xs hidden-md">Contact now!</a>
					<a  data-id="{{ $slideOne->pd_id }}" id="add-to-favs" class="fa fa-heart btn btn-default  hidden-sm hidden-xs hidden-md add-to-favs"></a>
								</div>
							</div>
            </div>
            @endforeach
					</div>
				</div>
			</div>
