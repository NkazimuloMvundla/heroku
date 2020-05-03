@extends('layouts.main')
@section('title' ,'Search Product')
@section('content')
<style>
div#search-result{
    display: flex;
    justify-content: center;
}

</style>
<div class="w3-container">
    <div style="margin-top: -24px;">
        @if($Productcount > 0)
         <h4 style="background: #f2f3f7; padding:12px;">
                About <span style="color:orange">{{ $Productcount }}</span>  product(s) found for "{{ Session::get('pd_name') }}"

         </h4>
         @endif

         @if($Productcount == 0)
         <h5 style="background: #f2f3f7; padding:12px;" class="text-primary">We couldn't find the product you searched for, why dont you post a buying request here ? <span style="color:orange;weight:bold"></span>
             <a href="{{route('BuyingRequest')}}" style="color:orange"> Post here </a>
         </h5>
         @endif
    </div>

    <div class="row" id="search-result">
        <div class="col-md-2 w3-hide-small w3-hide-medium" id="category" style="border-right: 1px solid lightgreen;">
            <p id="related-categories">Related categories</p>
            <ul>
            @forelse ($lastCats as $related)
            @foreach ($products as $product)
            @if($product->pd_subCategory_id == $related->id )

            <li class="list-item" style="border-bottom: 1px solid #f5f5f5;padding: 7px;">
                  <?php  $lastCat_id = base64_encode( $related->id ) ;?>
                <a href="/products-by-last-category/{{ $related->pc_name }}/{{ $lastCat_id }}">{{ $related->pc_name }}</a></li>
<?//we use break here to filter the result so that it doenst return the same parent for 2 or more pproducts?>
<?php break;?>
            @endif
            @endforeach
            @empty
            @endforelse
        </ul>
            </div>
            <div class="col-md-10">
                @if($Productcount > 0)
                <div class="row products-by-category">
                    @foreach ($products as $product)
                        <div class="col-md-3 col-xs-6 " style="border: 1px dotted #e2e2e2">
                             <div class="thumb-wrapper">
                                <div class="img-box">
                            <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                                    <a href="/product-details/{{ $encoded_product_id}}" class="view_product">
                                    @foreach ($pd_images as $pd_image)
                                    @if($product->pd_id == $pd_image->pd_photo_id)
                                <img src="{{ $pd_image->pd_filename }}" class="img-responsive img-fluid" alt="product-image">
                                <?php break;?>
                                @endif
                                @endforeach
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
                    <a href="/contact-supplier/product/{{ $encoded_product_id}}/supplier/{{ $encoded_user_id}}" class="btn btn-default item">Contact now!</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>
                @endif
                @if($Productcount == 0)
                <p>Oops, No match found</p>
                </div>
                @endif
            </div>



    </div>
   <div class="row clearfix" style="padding-right:8px; margin-top:16px;">
       <div class="col-md-12 hidden-xs hidden-sm text-center">
              {{$products->links('pager.custom')}}
       </div>
       <div class="hidden-xs hidden-sm text-center">
                   <i>Page  {{$products->currentPage()}} of {{$products->lastPage()}}</i>
       </div>
     <div class="col-md-6 hidden-lg text-center">
              {{$products->links('pager.mobile')}}
     </div>
      <div class="col-md-6 hidden-lg text-center">
           <i>Page  {{$products->currentPage()}} of {{$products->lastPage()}}</i>
     </div>

 </div>
</div>
@endsection
