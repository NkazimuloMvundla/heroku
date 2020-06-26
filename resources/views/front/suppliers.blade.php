@extends('layouts.main')
@section('title' , 'Suppliers')
@section('meta_keywords' ,'Suppliers','legitimate suppliers')
@section('meta_description' ,'find all legitimate and verified suppliers')
@section('content')
<style nonce="{{ csp_nonce() }}">
    div.container > h3.text-primary{background: #f8f8f8; padding:4px;}
    h3.text-primary > div.row{padding: 12px;}
    div.widget > span {position: absolute;z-index: 10;margin-top: 8em;margin-left: 5px;}
    div.bg-purple{background:azure;}
    span.industry{font-size: 11px;}
    div.featured-products{margin-bottom: 7px;}
    div.prod-link{margin-top:7px;}
    p.comp-back-img{margin-top:7px;}
    p.comp-slogan{margin-top:12px;margin-bottom:12px;}
</style>
<div class="container">
    <h3 class="text-primary">Selected Suppliers</h3>
        <div class="row">
                <!--featured-suppliers-->
<!--
                <div class="col-md-2">
                    <p>sort by</p>
                    <div class="w3-hide-small w3-hide-medium" id="category" style="padding:7px;margin-top:7px;border-right: 1px solid lightgreen;background: #fff;">
                       <select>
                        <option value="premium">Premium</option>
                        <option value="premium">Industry</option>
                       </select>
                    </div>
                </div>-->
                <div id="suppliers">
                    <div class="col-md-12">
                        <div class="row">
                                @foreach($suppliers as $supplier)
                            <div class="col-md-3 col-xs-12">
                                    <div class="panel widget row-1" id="all-suppliers">
                                     <span>
                                           @if($supplier->status == 1)
                                                <img src="icons/correct.png" width="20" height="20" alt="verified-supplier" data-toggle="tooltip" data-placement="top" title="Verified supplier">
                                                 @endif
                                        @if($supplier->membership == 'Gold Member')
                                         <img src="icons/gold-medal.png" width="20" height="20" alt="gold-supplier" data-toggle="tooltip" data-placement="top" title="Gold supplier">
                                        @endif
                                        </span>
                                            @if(empty($supplier->company_background_img))
                                            <div class="widget-header bg-purple" >
                                                </div>
                                            @endif
                                            @if(!empty($supplier->company_background_img))
                                        <div class="widget-header bg-purple">
                                             <img class="widget-bg img-responsive" src="{{ url($supplier->company_background_img) }}" alt="Image">
                                            </div>
                                            @endif

                                             <div class="widget-body text-center">
                    <?php   $encoded_supplier_id = base64_encode( $supplier->id) ;?>
                                                <a href="/supplier/{{ $encoded_supplier_id}}">
                                                        @if(empty($supplier->company_background_img))
                                                        <img alt="Profile Picture" class="widget-img img-border-light" src="icons/user.png">
                                                        @endif
                                                        @if(!empty($supplier->company_background_img))
                                                        <img alt="Profile Picture" class="widget-img img-border-light" src="{{ url($supplier->company_logo) }}">
                                                        @endif
                                                    </a>
                                                  <?php   $encoded_supplier_id = base64_encode( $supplier->id) ;?>
                                                  <h4 class="mar-no"><a href="/supplier/{{ $encoded_supplier_id }}">{{ $supplier->company_name }}</a></h4>
                                                  @if(empty($supplier->company_background_img))
                                                  <p class="text-muted comp-back-img">
                                                      <i></i>
                                                    </p>
                                                    @endif
                                                      @if(!empty($supplier->company_slogan))
                                                      <p class="text-muted comp-slogan">
                                                      <i>'{{ $supplier->company_slogan }}'</i>
                                                    </p>
                                                      @endif

                                                      @if(!empty($supplier->industry))

                                                          <?php
                                                            $industries = explode(',', $supplier->industry);
                                                            ?>
                                                        @foreach ($industries as $ind )

                                                        <span class="industry">{{ $ind }}, </span>
                                                        @endforeach

                                                @endif
                                            </div>
                                        </div>

                            </div>
                            @endforeach
                        </div>

                            </div>


                </div>
        </div>
</div>


@endsection
