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
                                                <a href="/product-details/{{ $encoded_product_id }}" class="view_product">

                                    <img src="/storage/{{ $product->pd_photo }}" class="img-responsive img-fluid" alt="product-image">

                                        </a>
                                        </div>
                                        <div class="thumb-content">
                                        <p class="item-name">
                                            <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                                            <a href="/product-details/{{ $encoded_product_id }}" class="view_product">
                                            <span>{{ $product->pd_name }}</span>
                                            </a>
                                        </p>
                                        <p class="item-price">
                                            <span>ZAR {{ $product->min_price }}-{{ $product->max_price }}
                                            </span>
                                        </p>
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
                                    <a  onclick="myFavorite({{ $product->pd_id }});"  id="add-to-favs" class="fa fa-heart btn btn-default hidden-sm hidden-xs hidden-md"></a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                    </div>
                </div>
    </div>
<div class="row clearfix" style="padding-right:8px; margin-top:16px;">
       <div class="col-md-12 hidden-xs hidden-sm text-center">
              {{$products->links('pager.custom')}}
        <i>Page  {{$products->currentPage()}} of {{$products->lastPage()}}</i>
       </div>
     <div class="col-md-6 hidden-lg text-center">
              {{$products->links('pager.mobile')}}
     </div>
      <div class="col-md-6 hidden-lg text-center">
           <i>Page  {{$products->currentPage()}} of {{$products->lastPage()}}</i>
     </div>

 </div>


@endsection
