@extends('layouts.main')
@section('title' ,'Product Reviews')
@section('meta_keywords', 'product reviews')
@section('meta_description', 'product reviews')
<link rel="canonical" href="{{url()->current()}}"/>
@section('content')
<style nonce="{{ csp_nonce() }}">
div.container > div.row {display: flex;justify-content: center;padding: 12px;}
img{height:200px;width:200px;}
tr > td#revied_by{width: 50%;}
h2.title > a{color:orange;}
</style>
<div class="container">
        <div class="row">
            <img src="{{ url($pd_images->first()->pd_filename) }}" class="img-responsive img-thumbnail" alt="product-name">
    </div>
    <div class="row">
        <div class="col-md-12">
                    <?php   $encoded_product_id = base64_encode($product->first()->pd_id) ;?>
                <h2 class="title">Review(s) on <a href="/product-details/{{ $encoded_product_id}}" title="product review">{{ $product->first()->pd_name }}</a></h2>
                <table class="table table-striped table-bordered">
                        <tbody>
                        @forelse($result as $review)
                        <tr>
                        <td id="revied_by"><strong>{{$review->rated_by}}</strong></td>
                        <?php $date = date('Y-m-d', strtotime( $review->created_at )); ?>
                        <td class="text-right">{{ $date}}</td>
                        </tr>

                        <tr>
                        <td colspan="2">
                        <p>{{ $review->review }}</p>
                        <div class="ratings">

                        @if($review->rating == 1 )
                        <div class="rating-box star-rating ">

                        <i class="fa fa-star checked"></i>
                            </div>
                        @endif
                        @if($review->rating == 2 )
                        <div class="rating-box star-rating ">

                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                            </div>
                        @endif
                        @if($review->rating == 3 )
                        <div class="rating-box star-rating ">

                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                            </div>
                        @endif
                        @if($review->rating == 4 )
                        <div class="rating-box star-rating ">

                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                            </div>
                        @endif
                        @if($review->rating == 5 )
                        <div class="rating-box star-rating ">

                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                            </div>
                        @endif

                        </div>
                        </td>
                        @empty
                        <td>No reviews as yet</td>
                        </tr>
                        @endforelse

                        </tbody>
                        </table>
        </div>


    </div>


</div>
@endsection
