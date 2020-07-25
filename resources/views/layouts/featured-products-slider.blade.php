<div class="row">
		<div class="col-md-12">
			<h2 id="Trend" class="featured">Trending <b>Products</b></h2>

					<div class="row">
	      @foreach($featured_products as $product)
	      

						<div class="col-md-2 col-xs-6 col-sm-4 product-item-container">
							<div class="thumb-wrapper">
								<div class="img-box">
			 							<?php $auth = Auth::check() ? Auth::user()->id: ''  ;?>
										<input type="hidden" name="u_id" id="u_id" value="{{ $auth }}">
                            <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
										<a href="/product-details/{{ $encoded_product_id }}" class="view_product">
                                        <img src="{{ $product->pd_photo }}" class="img-responsive" alt="{{ $product->pd_name }}" >
										</a>
								</div>
								<div class="thumb-content">
                        <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
										<a href="/product-details/{{ $encoded_product_id }}" class="view_product">
										<p class="item-name">{{ $product->pd_name }}</p>
                                        </a>
                                        <p class="item-price"><!--<strike>ZAR 400.00</strike>--> <span>ZAR {{ $product->min_price }}-{{ $product->max_price }}</span></p>
                                        <p class="item-price"><span>MOQ:{{ $product->pd_min_order_qty  }}  {{ $product->minOrderUnit }}</span></p>
            <?php  $encoded_user_id = base64_encode($product->pd_u_id ) ;?>
            <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
	      <a href="/contact-supplier/product/{{ $encoded_product_id}}/supplier/{{ $encoded_user_id}}" class="btn btn-success hidden-sm hidden-xs hidden-md">Contact now!</a>
	      
		@if(Auth::check())
			@foreach ($fav as  $f)
				@php
				$array = $fav->toArray() ;  
				@endphp			

				@if( $product->pd_id != $f && !in_array($product->pd_id,$array ) && !empty($countFavs))
				<a  data-id="{{ $product->pd_id }}" id="{{ "add-to-favs" . $product->pd_id }}" class="fa fa-heart btn btn-default  hidden-sm hidden-xs hidden-md add-to-favs">
				</a> 
				<?php break;?>
				@else
				<a  data-id="{{ $product->pd_id }}" id="{{ "add-to-favs" . $product->pd_id }}" class="fa fa-heart fa-red btn btn-default  hidden-sm hidden-xs hidden-md add-to-favs">
				</a> 
					<?php break;?>
				@endif
			@endforeach 

			@if(empty($countFavs))	
					<a  data-id="{{ $product->pd_id }}" id="{{ "add-to-favs" . $product->pd_id }}" class="fa fa-heart btn btn-default  hidden-sm hidden-xs hidden-md add-to-favs">
					</a>
			@endif
	
		@endif

		@if(!Auth::check())
			<a  data-id="{{ $product->pd_id }}" id="{{ "add-to-favs" . $product->pd_id }}" class="fa fa-heart btn btn-default  hidden-sm hidden-xs hidden-md add-to-favs">
			</a> 
		@endif
			

						</div>
							</div>
            </div>
            @endforeach
					</div>
				</div>
			</div>
