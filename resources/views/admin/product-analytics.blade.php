@extends('admin.layout.admin')
@section('title' , ' Product analytics')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product analytics
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
    <div class="row">
    <div class="form-group">
        <div class="col-md-2">
            <label>Product Name:</label>
            <p>{{ $product->first()->pd_name }}</p>
        </div>
        <div class="col-md-3">
            <label>Product Name:</label>
            <p>This product has been viewed 13 times</p>
        </div>
    </div>
<style>
    .fa-star{
        color:orange;
    }
</style>
    </div>
    <div class="row">
        <div class="col-md-12">
        <div class="form-group">
              <?php   $encoded_product_id = base64_encode($product->first()->pd_id) ;?>
                <h5 class="title">Review(s) on <a href="/product-details/{{ $encoded_product_id}}" title="product review">{{ $product->first()->pd_name }}
                </a></h5>
                <table class="table table-striped table-bordered">
                        <tbody>
                        @forelse($result as $review)
                        <tr>
                        <td style="width: 50%;">reviewed by <strong>{{$review->rated_by}}</strong></td>
                        <?php $date = date('Y-m-d', strtotime( $review->created_at )); ?>
                        <td class="text-right">{{ $date}}</td>
                        </tr>

                        <tr>
                        <td colspan="2">
                        <p>{{ $review->review }}</p>
                        <div class="ratings">

                        @if($review->rating == 1 )
                        <div class="rating-box star-rating">
                        <i class="fa fa-star checked"></i>
                            </div>
                        @endif
                        @if($review->rating == 2 )
                        <div class="rating-box star-rating">
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                            </div>
                        @endif
                        @if($review->rating == 3 )
                        <div class="rating-box star-rating">
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                            </div>
                        @endif
                        @if($review->rating == 4 )
                        <div class="rating-box star-rating">
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                            </div>
                        @endif
                        @if($review->rating == 5 )
                        <div class="rating-box star-rating">
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

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
