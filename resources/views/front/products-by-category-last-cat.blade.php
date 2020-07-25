@extends('layouts.main')
@section('title' ,'Products By Last Category')
@section('meta_keywords', 'products by category')
@section('meta_description', 'find more products from ' .  htmlspecialchars($lasts->first()->pc_name) .' category')
<link rel="canonical" href="{{url()->current()}}"/>
@section('content')
<style nonce="{{ csp_nonce() }}">
div#category{padding:7px;margin-top:7px;border-right: 1px solid lightgreen;background: #fff;}
div.products-by-category{border:1px dotted #e2e2e2;}
div.star-rating{display:none;}
div.clearfix{padding-right:8px; margin-top:16px;}
li.list-item {border-bottom: 1px solid #f5f5f5;padding: 7px;}
</style>
<div class="container">
   <div class="row">
    <div class="col-md-2 hidden-xs hidden-sm hidden-md" id="category">
        <p id="related-categories">Category</p>
        <ul>
        @foreach ($last_category as $lastCat)
        <li class="list-item active">
        <?php  $lastCat_id = base64_encode( $lastCat->id ) ;?>
        <a href="/products-by-last-category/{{ $lastCat->pc_name }}/{{ $lastCat_id }}">{{ $lastCat->pc_name }}</a></li>
        @endforeach
        </ul>
         </div>
                <div class="col-md-10">
                    @foreach ($subCats as $subCat )
                    @foreach ($lasts as $lastCat)
                    @if($lastCat->pc_id == $subCat->id)
                    <h3 class="text-primary">{{ $subCat->pc_name }}  <small>{{ $lasts->first()->pc_name }} </small> </h3>
                        @endif
                    @endforeach
                    @endforeach
                    <div class="row products-by-category">
                        @forelse ($products as $product)
                            <div class="col-md-3 col-xs-6 product-item-container">
                                    <div class="thumb-wrapper">
                                        <div class="img-box">
                        <?php $auth = Auth::check() ? Auth::user()->id: ''  ;?>
                        <input type="hidden" name="u_id" id="u_id" value="{{ $auth }}" >
                         <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                                 <a href="/product-details/{{ $encoded_product_id }}" class="view_product">
                              <img src="{{ url($product->pd_photo) }}" class="img-responsive img-fluid" alt="product">
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
                                            <div class="star-rating">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa  fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                                </ul>
                                            </div>
                                <?php  $encoded_user_id = base64_encode($product->pd_u_id ) ;?>
                                <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                                <a href="/contact-supplier/product/{{ $encoded_product_id}}/supplier/{{ $encoded_user_id}}" class="btn btn-default item">Contact now!</a>
                                  @include('layouts.includes.favs')
                                        </div>
                                    </div>
                                 </div>
                                @empty
                                <p class="text-primary">There are no products in this Category as yet, but please do check back later!</p>
                                @endforelse
                    </div>
                </div>
    </div>
   <div class="row clearfix">
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
 </div>


@endsection
