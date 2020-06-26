@extends('admin.layout.admin')
@section('title' , 'My Favorites')
@section('content')
<style nonce="{{ csp_nonce() }}">
.star-rating li {
    padding: 0;
}
.star-rating i {
    font-size: 14px;
    color: #ffc000;
}

/*every product data*/
	div.img-box{
	display: flex;
	justify-content: center;
	}
	div.img-box img{
		height:150px;
		width:150px;
	}
	.item .img-box {
    height: 160px;
    width: 100%;
    position: relative;
}
 .item img {
    max-width: 100%;
    max-height: 100%;
    display: inline-block;
    position: absolute;
    bottom: 0;
    margin: 0 auto;
    left: 0;
    right: 0;
}
 .item h4 {
    font-size: 18px;
    margin: 10px 0;
}
.thumb-content .btn {
    color: #333;
    border-radius: 0;
    font-size: 11px;
    text-transform: uppercase;
    font-weight: bold;
    background: none;
    border: 1px solid #ccc;
    padding: 5px 10px;
    margin-top: 5px;
    line-height: 16px;

}
.item .btn:hover, .carousel .item .btn:focus {
    color: #fff;
    background: #000;
    border-color: #000;
    box-shadow: none;
}
.item .btn i {
    font-size: 14px;
    font-weight: bold;
    margin-left: 5px;
}
.thumb-wrapper {
    text-align: center;
}
 .thumb-content {
    padding: 4px;
	margin-top:6px;

}

.item-name{
font-size: 13px;
padding: 2px 0;
white-space: nowrap;
overflow: hidden;
text-overflow: ellipsis;
}
.item-price {
    font-size: 13px;
    padding: 2px 0;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}
.item-price strike {
    color: #999;
    margin-right: 5px;
}
.item-price span {
    color: #86bd57;
    font-size: 110%;
}
div.content-wrapper{background:#fff;}
</style>
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header" >
               <h1>
                 Products that you liked
               </h1>

             </section>

               <section class="content">
                <div class="container">
                       <div class="row">
                <div class="col-md-11">
                    <h3 class="text-primary"></h3>
                    <div class="row products-by-category">
                     @forelse ($favorites as $fav)
                        @foreach ($products as $product)
                        @if($fav->mf_pd_id == $product->pd_id)
                            <div class="col-md-3 col-xs-6">
                                    <div class="thumb-wrapper">
                                        <div class="img-box">
                                             <?php  $product_id = base64_encode ($product->pd_id) ;?>
                                                <a href="/product-details/{{ $product_id }}">
                                        @foreach ($pd_images as $pd_image)
                                        @if($product->pd_id == $pd_image->pd_photo_id)
                                    <img src="{{ url($pd_image->pd_filename) }}" class="img-responsive img-fluid" alt="">
                                    <?php break;?>
                                    @endif
                                    @endforeach
                                        </a>
                                        </div>
                                        <div class="thumb-content">
                                            <p class="item-name">
                                              <?php  $product_id = base64_encode($product->pd_id) ;?>
                                                <a href="/product-details/{{ $product_id }}">
                                            <span>{{ $product->pd_name }}</span>
                                             </a>
                                            </p>
                                        <p class="item-price"><!--<strike>ZAR 400.00</strike>--> <span>ZAR {{ $product->min_price }}-{{ $product->max_price }}</span></p>
                                            <p class="item-price"><span>MOQ:{{ $product->pd_min_order_qty  }}  {{ $product->minOrderUnit }}</span></p>
                        <?php  $encoded_user_id = base64_encode($product->pd_u_id ) ;?>
                        <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                    <a href="/contact-supplier/product/{{ $encoded_product_id}}/supplier/{{ $encoded_user_id}}" class="btn btn-default item">Contact now!</a>
                    <button class="btn btn-danger delete-pd" data-id="{{ $product->pd_id }}">remove</button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                @empty
                                <p class="text-primary">You haven't liked any products as yet. Products that you like will be added here and you can easily contact the seller later.</p>
                                @endforelse
                    </div>
                </div>
    </div>
                </div>

               </section>

</div>
<script nonce="{{ csp_nonce() }}">
$(document).ready(function() {
    $(".delete-pd").on("click", function() {
        var id = $(this).data("id");
        removeProduct(id);
    });
});
</script>
@endsection
