@extends('layouts.main')
@section('title' ,'Filtered by price')
<?php  $min = htmlspecialchars( Session::get("min_price")) ;?>
<?php  $max = htmlspecialchars( Session::get("max_price")) ;?>
@section('meta_keywords', 'filter by price')
@section('meta_description', 'filtered price range at ' . $min . '-'. $max )
<link rel="canonical" href="{{url()->current()}}"/>
@section('content')
<style nonce="{{ csp_nonce() }}">
div#search-result{ display: flex; justify-content: center;margin-top: 12px;}
div#totalFound{background: #f2f3f7; padding:12px;}
div>h5#totalFound > span{color: orange}
h5#totalFound{background: #f2f3f7; padding:12px;}
h5#notFound > span{ color:orange;weight:bold}
h5#notFound > span > a{ color:orange}
div#search-result > div {border-right: 1px solid lightgreen;}
li.list-item{border-bottom: 1px solid #f5f5f5;padding: 7px;}
div.btn-go{margin-top: 5px}
div.star-rating{display: none;}
div.clearfix{padding-right:8px; margin-top:16px;}
</style>
<div class="container">
    <div>
        @if($Productcount > 0)
         <h5 id="totalFound" class="search-result">
                About <span>{{ $Productcount }}</span>  product(s) found for price range at {{ Session::get("min_price") }} - {{ Session::get("max_price") }}
         </h5>
         @endif

         @if($Productcount == 0)
         <h5 id="notFound" class="text-primary result">We couldn't find the product you searched for, why dont you post a buying request here ?
             <a href="{{route('BuyingRequest')}}"> Post here </a>
         </h5>
         @endif
    </div>
    <div class="row" id="search-result">
        <div class="col-md-2 hidden-xs hidden-sm hidden-md" id="category">
            <p id="related-categories">Related categories</p>
        <ul>
            @if($count_related_cats > 0)
            <?php $array  = []  ;?>
            <?php $ids = [] ;?>
            @foreach ($related_cats as $related)

            <?php  array_push($array, $related->pc_name); ?>
            <?php  array_push($ids, $related->id); ?>
            <?php $unique = array_unique($array);?>
            <?php $uniqueIds = array_unique($ids);?>
            @endforeach

            @for ($i = 0; $i <count($unique); $i++)
            <li class="list-item">
            <?php  $lastCat_id = base64_encode( $uniqueIds[$i] ) ;?>
            <?php $pc_name = $unique[$i];?>
            <a href="/products-by-last-category/{{ $pc_name }}/{{ $lastCat_id }}">{{ $pc_name }}</a>
            </li>
            @endfor
            @endif
        </ul>

        <div>
        <span>filter by price:</span>
       <form name="filter_price" method="POST" id="filter_price" action="{{ route('filterByPrice') }}">
            @csrf
            <div class="form-group">
            <input type="number" size="4" required class="form-control" name="min_price" placeholder="min-price">
        </div>
          <div class="form-group">
            <input type="number" size="4" required class="form-control" name="max_price" placeholder="max-price">
        </div>
         <div class="form-group">
          <button class="btn btn-primary">Go!</button>
        </div>
        </form>
        </div>
            </div>
            <div class="col-md-10">
                @if($Productcount > 0)
                  <span class="hidden-lg">filter by price:</span>
                    <form name="filter_price" class="hidden-lg" method="POST" id="filter_price" action="{{ route('filterByPrice') }}">
                    @csrf
                    <div class="form-group-row">
                        <div class="col-xs-6">
                            <input type="number" size="4"  class="form-control" name="min_price" placeholder="min-price">
                        </div>
                    <div class="col-xs-6">
                        <input type="number" size="4"  class="form-control" name="max_price" placeholder="max-price">
                        </div>
                      <div class="form-group w3-center btn-go">
                        <button class="btn btn-primary">Go!</button>
                        </div>
                    </div>
                    </form>
                <div class="row products-by-category">
                    @foreach ($products as $product)
                        <div class="col-md-3 col-xs-6 product-item-container">
                             <div class="thumb-wrapper">
                                <div class="img-box">
                            <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                                    <a href="/product-details/{{ $encoded_product_id}}" class="view_product">

                                <img src="{{ url($product->pd_photo) }}" class="img-responsive img-fluid" alt="product-image">
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
                                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                            </ul>
                                        </div>
                        <?php  $encoded_user_id = base64_encode($product->pd_u_id ) ;?>
                        <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                    <a href="/contact-supplier/product/{{ $encoded_product_id}}/supplier/{{ $encoded_user_id}}" class="btn btn-default item">Contact now!</a>
                         <a data-id="{{ $product->pd_id  }}" id="add-to-favs" class="fa fa-heart btn btn-default hidden-sm hidden-xs hidden-md add-to-favs"></a>
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
   <div class="row clearfix">
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
