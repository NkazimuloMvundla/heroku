@extends('layouts.main')
@section('title' ,'Search Product')
@section('content')
<style>
div#search-result{
    display: flex;
    justify-content: center;
}

</style>

@if(count($errors) > 0)
    <div id="valid" class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }} </li>
        @endforeach
    </ul>
    </div>
    @endif
<div class="container">
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

        <div class="col-md-2 hidden-xs hidden-sm hidden-md" id="category" style="border-right: 1px solid lightgreen;">
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

           <?php foreach($unique as $u => $key):?>

            <li class="list-item" style="border-bottom: 1px solid #f5f5f5;padding: 7px;">
              @foreach ($uniqueIds as $id => $val)
               @if($u == $id)
                <?php  $lastCat_id = base64_encode( $val ) ;?>
                <a href="/products-by-last-category/{{ $key }}/{{ $lastCat_id }}">{{ $key }}</a>
              @endif
                @endforeach
            </li>

           <?php endforeach ;?>
            @endif
        </ul>

        <div>
        <span>filter by price:</span>
        <form name="filter_price" method="POST" id="filter_price" action="{{ route('filterByPrice') }}">
            @csrf
            <div class="form-group">
            <input type="number" size="4" min="1" required class="form-control" name="min_price" placeholder="min-price">
        </div>
          <div class="form-group">
            <input type="number" min="1" required size="4"  class="form-control" name="max_price" placeholder="max-price">
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
                      <div class="form-group w3-center" style="margin-top:5px;">
                        <button class="btn btn-primary">Go!</button>
                        </div>
                    </div>
                    </form>

                <div class="row products-by-category">
                    @foreach ($products as $product)
                        <div class="col-md-3 col-xs-6 " style="border: 1px dotted #e2e2e2">
                             <div class="thumb-wrapper">
                                <div class="img-box">
                            <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                                    <a href="/product-details/{{ $encoded_product_id}}" class="view_product">

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
                      <a  onclick="myFavorite({{ $product->pd_id }});"  id="add-to-favs" class="fa fa-heart btn btn-default hidden-sm hidden-xs hidden-md"></a>
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
