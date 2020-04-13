@extends('layouts.main')
@section('title' ,'Products By Category')
@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-2 w3-hide-small w3-hide-medium" id="category" style="padding:7px;margin-top:7px;border-right: 1px solid lightgreen;background: #fff;z-index: 10;height: max-content;">
                <p id="related-categories">Category</p>
                <ul >
                @forelse($lasts as $lastCat )
            <li class="list-item" style="border-bottom: 1px solid #f5f5f5;padding: 7px;">
            <?php  $lastCat_id = base64_encode( $lastCat->id ) ;?>
                <a href="/products-by-last-category/{{ $lastCat->pc_name }}/{{ $lastCat_id }}">{{ $lastCat->pc_name }}</a></li>
            @empty
            <li class="list-item" style="border-bottom: 1px solid #f5f5f5;padding: 7px;">No data</li>
            @endforelse
                </ul>
            </div>
                <div class="col-md-10">
                    <h3 class="text-primary">{{ $category->pc_name }}</h3>
                    <div class="row products-by-category">
                        @foreach ($products as $product)
                            <div class="col-md-3 col-xs-6 " style="border: 1px dotted #e2e2e2">
                                    <div class="thumb-wrapper">
                                        <div class="img-box">
                        <?php $auth = Auth::check() ? Auth::user()->id: ''  ;?>
                        <input type="hidden" name="u_id" id="u_id" value="{{ $auth }}" >
                            <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                                                <a href="/product-details/{{ $encoded_product_id }}">
                                        @foreach ($pd_images as $pd_image)
                                        @if($product->pd_id == $pd_image->pd_photo_id)
                                    <img src="/storage/{{ $pd_image->pd_filename }}" class="img-responsive img-fluid" alt="product-image">
                                    <?php break;?>
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
                                            <div class="star-rating" style="display:none;">
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
              <a href="/contact-supplier/product/{{ $encoded_product_id}}/supplier/{{ $encoded_user_id}}" class="btn btn-default item hidden-sm hidden-xs hidden-md">Contact now!</a>
                                    <a  onclick="myFavorite({{ $product->pd_id }});" data-pd="" id="add-to-favs" class="fa fa-heart btn btn-default hidden-sm hidden-xs hidden-md"></a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                    </div>
                </div>
    </div>
 <div class=" clearfix pull-right" style="padding-right:8px; margin-top:52px;">
          {{$products->links('pager.custom')}}
        
       
       </div>
</div>


@endsection
