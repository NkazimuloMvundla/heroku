@extends('layouts.main')
@section('title' , 'Suppliers')

@section('content')
<div class="container">
    <h3 class="text-primary " style="background: #f8f8f8; padding:4px;">Selected Suppliers</h3>
        <div class="row" style="padding: 12px;">
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
                                     <span style="position: absolute;z-index: 10;margin-top: 8em;margin-left: 5px;">
                                           @if($supplier->status == 1)
                                                <img src="icons/correct.png" width="20" height="20" alt="verified-supplier" data-toggle="tooltip" data-placement="top" title="Verified supplier">
                                                 @endif
                                        @if($supplier->membership == 'Gold Member')
                                         <img src="icons/gold-medal.png" width="20" height="20" alt="gold-supplier" data-toggle="tooltip" data-placement="top" title="Gold supplier">
                                        @endif
                                        </span>
                                            @if(empty($supplier->company_background_img))
                                            <div class="widget-header bg-purple" style="background:azure;">
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
                                                  <p class="text-muted" style="margin-top:7px;">
                                                      <i></i>
                                                    </p>
                                                    @endif
                                                      @if(!empty($supplier->company_slogan))
                                                      <p class="text-muted " style="margin-top:12px;margin-bottom:12px;">
                                                      <i>'{{ $supplier->company_slogan }}'</i>
                                                    </p>
                                                      @endif

                                                      @if(!empty($supplier->industry))

                                                          <?php
                                                            $industries = explode(',', $supplier->industry);
                                                            ?>
                                                        @foreach ($industries as $ind )

                                                        <span  style="font-size: 11px;">{{ $ind }}, </span>
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
