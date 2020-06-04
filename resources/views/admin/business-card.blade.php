@extends('admin.layout.admin')
@section('title' , 'Edit-Business-card')

@section('content')

<style>
        [role="alert"]
         {
             color:red;
        };

        .bg-primary, .bg-primary a {
            color: #fff;
        }
        .bg-primary {
            background-color: #5fa2dd;
        }
        .bg-success, .bg-success a {
            color: #fff;
        }
        .bg-success {
            background-color: #91c957;
        }
        .widget{
            width: 200px;
        }
        .widget-header {
            padding: 15px 15px 50px 15px;
            min-height: 125px;
            position: relative;
            overflow: hidden;
        }
        .panel .panel-footer, .panel>:last-child {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .widget-body {
            padding: 50px 15px 15px;
            position: relative;
            background: #e3ebf2;
        }
        .panel-body {
            padding: 25px 20px;
        }
        .pad-all {
            padding: 15px;
        }
        .widget-img {
            position: absolute;
            width: 64px;
            height: 64px;
            left: 50%;
            margin-left: -32px;
            top: -32px;
        }
        .img-md {
            width: 64px;
            height: 64px;
        }
        .widget-bg {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                max-height: 100%;
        }
        .img-border-light {
            box-shadow: 0 0 0 4px #fff;
        }
        .img-border {
            box-shadow: 0 0 0 4px rgba(0,0,0,0.1);
        }
        .mar-no {
            margin: 0 !important;
        }
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            font-weight: 600;
        }
        .text-muted, a.text-muted:hover, a.text-muted:focus, a.text-muted:focus {
            color: #606060;
        }
        .mar-btm {
            margin-bottom: 15px;
        }
        .pad-ver {
            padding-top: 15px;
            padding-bottom: 15px;
        }
        .pad-btm {
            padding-bottom: 15px;
        }
        .pad-top {
            padding-top: 8px;
        }
        .small, small {
            font-size: 65%;
        }
        .text-lg {
            font-size: 75%;
        }

        </style>
<div class="content-wrapper">
 <!-- Content Header (Page header) -->
 <section class="content-header">
        <h1>
          Dashboard
          <small>Your business card will be shared across the plartform, make it look nice</small>
        </h1>

      </section>

        <section class="content">
            @if(count($errors) > 0)
            <div id="valid" class="alert alert-danger" >
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }} </li>

                @endforeach
            </ul>
            </div>
            @endif
        <div class="container">

          @if(Session::has('message'))
          <div>
           <ul>
               <li class="label label-success"  style="font-size:15px;">{{ Session::get('message') }}</li>
           </ul>
          </div>
          @endif
        <div class="row">
        <div class="business_card">
            <div class="col-md-3">
            <p class="text-primary"></p>
            <div class="form-group">
            <div class=" widget row-1" style="box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.2);">
                @if(empty($user_details->first()->company_background_img))
                <div class="widget-header bg-purple" style="background:azure;">
                    </div>
                @endif
                @if(!empty($user_details->first()->company_background_img))
                <div class="widget-header bg-purple">
                        <img class="widget-bg img-responsive" src="{{ url($user_details->first()->company_background_img) }}" alt="company background image">
                    </div>
                @endif
                    <div class="widget-body text-center">
                    <?php $encoded_supplier_id = base64_encode( $user_details->first()->id) ;?>
                        <a href="/supplier/{{ $encoded_supplier_id }}">
                        @if(empty($user_details->first()->company_logo))
                        <img alt="Company Logo" class="widget-img img-border-light" src="icons/user.png" >
                        @endif
                        @if(!empty($user_details->first()->company_logo))
                        <img alt="Company Logo" class="widget-img img-border-light" src="{{ url($user_details->first()->company_logo) }}" >
                        @endif</a>
                        <h4 class="mar-no">
                      <?php $encoded_supplier_id = base64_encode( $user_details->first()->id) ;?>
                        <a href="/supplier/{{ $encoded_supplier_id }}">
                         {{ $user_details->first()->company_name }}</a></h4>
                        @if(empty($user_details->first()->company_slogan))
                        <p class="text-muted mar-btm w3-margin-top">You company slogan</p><ul class="list-unstyled text-center pad-top mar-no clearfix">
                        @endif
                        @if(!empty($user_details->first()->company_slogan))
                        <p class="text-muted mar-btm w3-margin-top"><i style="word-wrap: break-word;">'{{ $user_details->first()->company_slogan }}'</i></p><ul class="list-unstyled text-center pad-top mar-no clearfix">
                        @endif

                        </ul>
                    </div>
                </div>
            </div>
                    <div class="business_card" id="business_card">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                            <label>Business card background image</label>
                            <input type="file" id="business_card_background" name="business_card_background"  class="form-control" accept=".jpg, .jpeg, .png" >
                            @error('business_card_background')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group">
                                <label>Company Logo</label>
                                <input type="file" name="company_logo" class="form-control" accept=".jpg, .jpeg, .png">
                                @error('company_logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                                <div class="form-group">
                                <label>Company images like factory or buildings</label>
                                <input type="file" name="company_images[]" class="form-control" multiple accept=".jpg, .jpeg, .png">
                                @error('company_images')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <i>a max of 2 images</i>
                            </div>
                            <div class="form-group">
                                    <label> Business Slogan</label>
                                    <input type="text" class="form-control" id="business_slogan" name="business_slogan" accept=".jpg, .jpeg, .png">
                                    @error('business_slogan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <input type="submit" value="Update Card">
                            </form>
                    </div>
                 </div>
            </div>

            <div class="col-md-6">
                <p>Upload Company Images Like Factory or Buidlings</p>
                @if(!empty($company_images))
                <div class="">
                @foreach($company_images as $company_img)
                <div class="">
                    <span class="btn btn-danger btn-sm" style="margin:5px;position: absolute;" onclick="deleteCompanyImg({{ $company_img->id }})">delete image</span>
                        <img class="img-responsive" src="{{ url($company_img->company_image) }}" alt="company image" width="100%" style="margin:10px;">
                 </div>
                @endforeach
                    </div>
                @endif
            </div>
                </div>
            </div>

        </section>
</div>


@endsection
