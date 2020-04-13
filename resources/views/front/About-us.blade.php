@extends('layouts.main')

@section('title', 'About us')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
		{{$about_us_content->first()->cms_content}}
		</div>
	</div>


</div>


@endsection
