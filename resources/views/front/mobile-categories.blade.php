@extends('layouts.main')
@section('title' ,'Categories')
@section('content')

<script>
		jQuery(function() {
			jQuery("#acdnmenu").accordionMenu();
		});
</script>
 <style>
        #menu{
            padding: 7px;
        }

        #acdnmenu ul.acdnTop {
        display: block;
        border: 1px solid #D8E2F3;
        background: none repeat scroll 0 0 #FFFFFF;
        padding-left: 0;
        }
        #acdnmenu div.acdnHeading, #acdnmenu a.acdnLink {

        color: #000000;
        font: 19px Raleway;
        outline: medium none;
        padding: 8px 8px 8px 24px;
        text-align: left;
        text-decoration: none;
        }
        #acdnmenu div.acdnCurrent, #acdnmenu div:hover, #acdnmenu a.acdnLink:hover, #acdnmenu div.acdnCurrent a.acdnLink {
        background-position: 0 -64px;
        color: #000000;
        font-weight: normal;
        text-decoration: none;
        }
        #acdnmenu a.acdnCurrent, #acdnmenu a.acdnCurrent:hover {
        color: #336699;
        text-decoration: none;
        }
        #acdnmenu div.acdnArrowImage {
        background-image: url("{{ asset('pub/accordionMenu/arrows.gif') }}");
        background-position: 0 0;
        height: 12px;
        left: 4px;
        top: 9px;
        width: 12px;
        }
        #acdnmenu div.acdnCurrent div.acdnArrowImage {
        background-position: 0 -12px;
        }
        #acdnmenu li.acdnSeparator {
        border-bottom: 1px solid
        #e2e2e2;
        padding: 0px 0px 0px 0px;
        margin: 0px 0px 0px 0px;
        font-size: 0px
        }
        #acdnmenu ul.acdnSub {
        padding-left: 14px;
        }
        #acdnmenu ul.acdnSub div.acdnHeading {
        background: none repeat scroll 0 0 transparent;
        color: #000000;
        font: 17px Raleway;
        padding: 5px 5px 5px 20px;
        text-align: left;
        }
        #acdnmenu ul.acdnSub div.acdnHeading a {
        color: #000000;
        }
        #acdnmenu ul.acdnSub div.acdnCurrent {
        background: none repeat scroll 0 0 transparent;
        color: #000000;
        }
        #acdnmenu ul.acdnSub a.acdnLink {
        background: none repeat scroll 0 0 transparent;
        color: #000000;
        font: 16px Raleway;
        padding: 5px 5px 5px 20px;
        text-decoration: none;
        }
        #acdnmenu ul.acdnSub a.acdnLink:hover, #acdnmenu ul.acdnSub a.acdnCurrent, #acdnmenu ul.acdnSub div.acdnHeading a:hover, #acdnmenu ul.acdnSub div.acdnHeading a.acdnCurrent {
        background: none repeat scroll 0 0 transparent;
        color: #000000;
        text-decoration: underline;
        }
        #acdnmenu ul.acdnSub div.acdnArrowImage {
        background-image: url("{{ asset('pub/accordionMenu/arrows.gif') }}");
        background-position: 0 -24px;
        height: 12px;
        left: 4px;
        top: 6px;
        width: 12px;
        }
        #acdnmenu ul.acdnSub div.acdnCurrent div.acdnArrowImage {
        background-position: 0 -36px;
        }
        #acdnmenu, #acdnmenu ul {
        display: block;
        font-size: 0;
        line-height: 0;
        }
        #acdnmenu li {
        font-size: 12px;
        line-height: 16px;
        }
        #acdnmenu:after {
        clear: both;
        content: ".";
        display: block;
        height: 0;
        visibility: hidden;
        }
        #acdnmenu ul {
        list-style-type: none;
        margin: 0px;
        overflow: hidden;
        padding: 0px;
        position: relative;
        top: 0px;
        display: none;
        }
        #acdnmenu li {
        margin: 0px;
        padding: 0px;
        }
        #acdnmenu div.acdnHeading, #acdnmenu div.acdnCurrent {
        cursor: pointer;
        position: relative;
        }
        #acdnmenu div.acdnArrowImage {
        overflow: hidden;
        position: absolute;
        }

        .cat-title{

        font-size: 20px;
        line-height: 30px;
        color: #000;
        font-weight: 200;
        margin-bottom: 4px;
        border-left: 5px solid #54ae3f;
        border-right: 5px solid #54ae3f;
        text-align: center;
        padding:2px;
        background-color: #f3f3f3;
        }
        </style>

        <div class="container hidden-lg">
            <div class="row">
                <div class="col-md-12">
                        <div id="menu">
                                <nav>
                                <div id="acdnmenu">
                                <ul>
                                        @foreach ($pCats as $cats )
                                <li>{{ $cats->pc_name }}
                                <ul>
                                        @foreach ($subCats as $sub )
                                        @if($cats->pc_id == $sub->pc_id )
                                <li>{{ $sub->pc_name }}
                                <ul style="border: 1px dotted gainsboro;">
                                        @foreach ($lastCats as $last )
                                        @if($sub->id == $last->pc_id )
                                <?php  $lastId = base64_encode(  $last->id ) ;?>
                                <li><a href="/products-by-last-category/{{ $last->pc_name }}/{{$lastId}}"> <i id="b" class="fa fa-arrow-right"></i> {{ $last->pc_name }}</a></li>
                                        @endif
                                        @endforeach
                                </ul>

                                </li>
                                        @endif
                                        @endforeach
                                </ul>
                                </li>
                                        @endforeach
                                </ul>
                                </div>
                                </nav>
                                </div>
                </div>
            </div>
        </div>


@endsection
