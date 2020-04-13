@extends('layouts.main')
@section('title' ,'Products By Category')
@section('content')
<div class="container">
   <div class="row">
    <div class="col-md-2 w3-hide-small w3-hide-medium" id="category" style="padding:7px;margin-top:7px;border-right: 1px solid lightgreen;background: #fff;">
        <p id="related-categories">Category</p>
        <ul>
        @foreach ($last_category as $lastCat)
        <li class="list-item active" style="border-bottom: 1px solid #f5f5f5;padding: 7px;">
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
                    <div class="row products-by-category" >
                        @forelse ($products as $product)
                            <div class="col-md-3 col-xs-6" style="border:1px solid #e2e2e2">
                                    <div class="thumb-wrapper">
                                        <div class="img-box">
                         <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                                 <a href="/product-details/{{ $encoded_product_id }}">
                                        @foreach ($pd_images as $pd_image)
                                        @if($product->pd_id == $pd_image->pd_photo_id)
                                    <img src="/storage/{{ $pd_image->pd_filename }}" class="img-responsive img-fluid" alt="">
                                    <?php break ;?>
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
                                                    <li class="list-inline-item"><i class="fa  fa-star"></i></li>
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
                                @empty
                                <p class="text-primary">There are no products in this Category as yet, but please do check back later!</p>
                                @endforelse
                    </div>
                </div>
    </div>
 <div class="row clearfix pull-right" style="padding-right:8px; margin-top:52px;">
    <div class="col-md-12">
              {{$products->links('pager.custom')}}
        <i>Page  {{$products->currentPage()}} of {{$products->lastPage()}}</i>
    </div>
    
 </div>
   
</div>


@endsection