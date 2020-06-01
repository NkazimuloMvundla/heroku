@extends('super.layouts.super')
@section('title' , 'Edit a Category')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
        <form action="/super/category-save/{{ $category->first()->id }}" method="POST" enctype="multipart/form-data">
            @csrf

        <div class="row" style="display:flex; justify-content:center;">
                @if(Session::has('category_add'))
                <div>
                 <ul>
                     <li class="label label-success"  style="font-size:15px;">{{ Session::get('category_add') }}</li>

                 </ul>

                </div>
                @endif
               <!-- /.col -->
               <div id="result"></div>
            <div class="col-md-8" style="background: white;padding: 12px;">
            <div class="form-group">
                <label>Select a Main Category</label>
                <select name="main_category" id="main_category" class="form-control">
                    <option disabled selected>Select</option>
                    @foreach($mainCategories as $mainCat)

                    <option value="{{ $mainCat->pc_id }}" >{{ $mainCat->pc_name }}</option>
                    @endforeach
                </select>
                @error('main_category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
                <span class="text-danger" id="main_categoryErr"></span>
            </div>
            <div class="form-group">
                <label>Edit a Category</label>
                <input type="text" id="category" name="category" value="{{ $category->first()->pc_name }}" class="form-control" >
                <span class="text-danger" id="categoryErr"></span>
                @error('category')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="form-group">
                    <label>Edit a Category Image</label>
                    <input type="file" id="category_image" name="category_image"  class="form-control" >
                    <span class="text-danger" id="category_imageErr"></span>
                    @error('category_image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <div class="">
                    <img src="/storage/{{ $category->first()->pc_image }}">
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-success" type="submit" >Save</button>
            </div>

        </div>

        </div>
    </form>
        </section>


@endsection
