@extends('layouts.main')
@section('title' ,'Product Reviews')
@section('content')

<div class="container">
        <div class="row" style="display: flex;justify-content: center;padding: 12px;">
            <img src="{{ url($pd_images->first()->pd_filenam) }}" class="img-responsive img-thumbnail" alt="product-name" style="height:200px;width:200px;">
    </div>
    <div class="row">
        <div class="col-md-12">
                    <?php   $encoded_product_id = base64_encode($product->first()->pd_id) ;?>
                <h2 class="title">Review(s) on <a href="/product-details/{{ $encoded_product_id}}" title="product review">{{ $product->first()->pd_name }}</a></h2>
                <table class="table table-striped table-bordered">
                        <tbody>
                        @forelse($result as $review)

                        <tr>
                        <td style="width: 50%;"><strong>{{$review->rated_by}}</strong></td>
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
