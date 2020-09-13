@extends('layouts.main')

@section('title', 'About us')
@section('meta_keywords', 'About our company')
@section('meta_description', 'We help buyers connect with south african merchants')
<link rel="canonical" href="{{url()->current()}}"/>
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
		{{$about_us_content->first()->cms_content}}
		</div>
	</div>


</div>


@endsection
