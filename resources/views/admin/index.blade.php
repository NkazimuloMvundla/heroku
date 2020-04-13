@extends('admin.layout.admin')
@section('title', 'User Panel')

@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/u/u/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><a href="/u/mailbox/inbox">Messages</a></span>
              <span class="info-box-number">{{ $count_emails }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->


        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><a href="/u/favorites">Favourites</a></span>
              <span class="info-box-number">{{$countUserFavs}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

   @if(session::get('account') == "Supplier" || session::get('account') == "Both" )

              <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><a href="{{route('manageProduct')}}">Product Listed</a></span>
              <span class="info-box-number">{{ count($product_listed) }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
    @endif
        <!-- /.col -->
      </div>
      <!-- /.row -->
        <div class="row">
        <!-- /.col -->
        <h2 class="text-center">Take your Business to the next level with our Marketing and promotion tools</h2>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-thumbs-up"></i></span>
        <a href="{{route('membership')}}">
        <div class="info-box-content">
        <span class="info-box-text">Premium membership</span>
        <span class="info-box-number">Enjoy exclusive priveligies and stand out from competition</span>
        </div>
        </a>

        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-thumbs-up"></i></span>
        <a href="{{route('membership')}}">
        <div class="info-box-content">
        <span class="info-box-text">Advetising services</span>
        <span class="info-box-number">Get 100+ brand and product exposure</span>
        </div>
        </a>

        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </div>

        </div>
      <!-- /.row -->


    </section>
    <!-- /.content -->
  </div>


@endsection
