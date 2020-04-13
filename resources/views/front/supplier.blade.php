@extends('layouts.main')
@section('title' ,'Supplier')
@section('content')


 <style type="text/css">

    .profile-user-img {
        margin: 0 auto;
        width: 100px;
        padding: 3px;
        border: 3px solid #d2d6de;}
        .form-control {
        border-radius: 0;
        box-shadow: none;
        border-color: #d2d6de;}

    </style>

    <div class="container w3-margin-top">
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    <!--    <section class="content-header">
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">User profile</li>
          </ol>
        </section>-->

        <!-- Main content -->
        <section class="content w3-margin-top">

          <div class="row">

            <div class="col-md-3">
                <div id="supplier-panel">
              <!-- Profile Image -->
              <div class="box box-primary ">
                <div class="box-body box-profile">
                    <div class="panel widget row-1">
                      <span style="position: absolute;z-index: 10;margin-top: 8em;margin-left: 5px;">
                                           @if($supplier->status == 1)
                                                <img src="/storage/icons/correct.png" width="20" height="20" alt="verified-supplier" data-toggle="tooltip" data-placement="top" title="Verified supplier">
                                                 @endif
                                        @if($supplier->membership == 'Gold Member')
                                         <img src="/storage/icons/gold-medal.png" width="20" height="20" alt="gold-supplier" data-toggle="tooltip" data-placement="top" title="Gold supplier">
                                        @endif

                                        </span>
                        @if(empty($supplier->company_background_img))
                        <div class="widget-header bg-purple" style="background:azure;">
                            </div>
                        @endif
                        @if(!empty($supplier->company_background_img))
                    <div class="widget-header bg-purple">
                         <img class="widget-bg img-responsive" src="/storage/{{ $supplier->company_background_img }}" alt="Image">
                        </div>
                        @endif
                        <div class="widget-body text-center">
                             <?php   $encoded_supplier_id = base64_encode( $supplier->id) ;?>
                                <a href="/supplier/{{ $encoded_supplier_id }}">
                                    @if(empty($supplier->company_logo))
                                    <img alt="Profile Picture" class="widget-img img-border-light" src="/storage/icons/user.png">
                                    @endif
                                    @if(!empty($supplier->company_logo))
                                    <img alt="Profile Picture" class="widget-img img-border-light" src="/storage/{{ $supplier->company_logo }}">
                                    @endif
                                </a>
                                 <?php   $encoded_supplier_id = base64_encode( $supplier->id) ;?>
                              <h4 class="mar-no"><a href="/supplier/{{ $encoded_supplier_id }}">{{ $supplier->company_name }}</a></h4>
                              @if(empty($supplier->company_slogan))
                              <p class="text-muted mar-btm w3-margin-top">
                                  <i></i>
                                </p>
                                @endif
                                  @if(!empty($supplier->company_slogan))
                                  <p class="text-muted mar-btm w3-margin-top">
                                  <i>'{{ $supplier->company_slogan }}'</i>
                                </p>
                                  @endif
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->

              <!-- About Me Box -->
              <div class="box box-primary">

                <!-- /.box-header -->
                <div class="box-body">
                  <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                  <p class="text-muted">South Africa</p>
                  <hr>
                  <strong><i class="fa fa-industry margin-r-5"></i> Industry</strong>
                  <p>

                    @if(!empty($supplier->industry))

                    <?php
                    $industries = explode(',', $supplier->industry);

                    ?>
                    <?php  $i = 1; ?>
                    @foreach ($industries as $ind )

                    @if($i<count($industries))
                    <?php $ind.= ', ';?>
                    @endif
                     <span  style="font-size: 11px;">{{ $ind }} </span>
                    <?php  $i++; ?>
                    @endforeach

                    @endif

                  </p>
                  <hr>
                  @if($export > 0)

                  <p> <i class="fa fa-money"></i> <strong>Export percentage </strong>: <b>{{$export_capabilities->first()->export_percentage}} %</b> </p>
                  <hr>

                  <p>
                    <?php
                    $markets = explode(',', $export_capabilities->first()->main_markets);
                    ?>
                    <strong><i class="fa fa-globe"></i> Markets : </strong>
                      <?php  $i = 1; ?>
                    @foreach ($markets as $ind )
                    @if($i<count($markets))
                    <?php $ind.= ', ';?>
                    <?php $i++;?>
                    @endif
                    <span  style="font-size: 11px;">{{ $ind }} </span>
                    @endforeach
                  </p>

                  <hr>
                <p> <i class="fa fa-calendar"></i> <strong>Year started exporting  </strong>: <b>{{$export_capabilities->first()->export_started}}</b> </p>
                      @endif
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            </div>
            <!-- /.col -->

            <div class="col-md-9">
                 <!--Horizontal Tab-->
            <div id="company_details">
                <ul class="resp-tabs-list hor_1">
                    <li>All products</li>
                    <li>About us</li>
                </ul>
                <div class="resp-tabs-container hor_1">
                    <div>
                    <!--featured-products-->
                    <div id="featured-products" style="margin-bottom: 7px;">
                        <div class="row">
                        @forelse ($products as $product)
                            <div class="col-md-3 col-xs-6">
                                <div class="thumb-wrapper">
                                    <div class="img-box">
                                    <?php $auth = Auth::check() ? Auth::user()->id: ''  ;?>
                                    <input type="hidden" name="u_id" id="u_id" value="{{ $auth }}" >
                                          <?php   $encoded_product_id = base64_encode( $product->pd_id) ;?>
                                    <a href="/product-details/{{ $encoded_product_id}}">
                                        @foreach ($pd_images as $img)
                                        @if($img->pd_photo_id == $product->pd_id)
                                      <img src="/storage/{{ $img->pd_filename }}" class="img-responsive img-fluid" alt="product image">
                                      <?php break;?>
                                        @endif
                                      @endforeach
                                      </a>
                                    </div>
                                    <div class="thumb-content">
                                        <p class="item-name">
                        <?php   $encoded_product_id = base64_encode( $product->pd_id) ;?>
                                        <a href="/product-details/{{ $encoded_product_id }}">
                                        <span>{{ $product->pd_name }}</span>
                                        </a>
                                        </p>
                                         <p class="item-price"><!--<strike>ZAR 400.00</strike>--> <span>ZAR {{ $product->min_price }}-{{ $product->max_price }}</span></p>
                                        <p class="item-price"><span>MOQ:{{ $product->pd_min_order_qty  }}  {{ $product->minOrderUnit }}</span></p>
                                        <a href="/contact-supplier/product/{{ $product->pd_id }}/supplier/{{ $product->pd_u_id }}" class="btn btn-default item">Contact now!</a>
                                         <a  onclick="myFavorite({{ $product->pd_id }});" data-pd="" id="add-to-favs" class="fa fa-heart btn btn-default  hidden-sm hidden-xs hidden-md"></a>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <p class="text-primary">No products from this supplier as yet.</p>
                        @endforelse

                        </div>
                    <div class="row">
                        <div class="col-md-12 pull-right" style="margin-top:7px;">
                        {{ $products->links() }}
                        </div>

                    </div>
              </div>
            </div>
            <!--about_us tab-->
            <div>
            {{$supplier->about_us}}
              @if($count_comp_img > 0)
              <h4 class="bg-info text-center"><b>Company images</b></h4>
              @endif
              @foreach($company_images as $img)
              <img src="/storage/{{ $img->company_image }}" class="img-responsive img-fluid" alt="company image">
              @endforeach

              <!--certificates-->
                <div>
                @if($count_certificates > 0)
                <h4 class="bg-info text-center"><b>Company certificates</b></h4>
                @endif
                </div>
                <div class="row">
                <div class="col-md-8">
                @foreach($certificates as $img)
                <img src="/storage/{{ $img->filename }}" class="img-responsive" alt="company certificate">
                @endforeach
                </div>

            </div>
                </div>
            </div>
              <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

        </section>
        <!-- /.content -->
      </div>

    </div>
    <!--Plug-in Initialisation-->
    <script type="text/javascript">
        $(document).ready(function() {
            //Horizontal Tab
            $('#company_details').easyResponsiveTabs({
                type: 'default', //Types: default, vertical, accordion
                width: 'auto', //auto or any width like 600px
                fit: true, // 100% fit in a container
                tabidentify: 'hor_1', // The tab groups identifier
                activate: function(event) { // Callback function if tab is switched
                    var $tab = $(this);
                    var $info = $('#nested-tabInfo');
                    var $name = $('span', $info);
                    $name.text($tab.text());
                    $info.show();
                }
            });

            // Child Tab
            $('#ChildVerticalTab_1').easyResponsiveTabs({
                type: 'vertical',
                width: 'auto',
                fit: true,
                tabidentify: 'ver_1', // The tab groups identifier
                activetab_bg: '#fff', // background color for active tabs in this group
                inactive_bg: '#F5F5F5', // background color for inactive tabs in this group
                active_border_color: '#c1c1c1', // border color for active tabs heads in this group
                active_content_border_color: '#5AB1D0' // border color for active tabs contect in this group so that it matches the tab head border
            });

            //Vertical Tab
            $('#parentVerticalTab').easyResponsiveTabs({
                type: 'vertical', //Types: default, vertical, accordion
                width: 'auto', //auto or any width like 600px
                fit: true, // 100% fit in a container
                closed: 'accordion', // Start closed if in accordion view
                tabidentify: 'hor_1', // The tab groups identifier
                activate: function(event) { // Callback function if tab is switched
                    var $tab = $(this);
                    var $info = $('#nested-tabInfo2');
                    var $name = $('span', $info);
                    $name.text($tab.text());
                    $info.show();
                }
            });
        });


    </script>

@endsection