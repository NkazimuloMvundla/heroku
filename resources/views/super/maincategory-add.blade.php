@extends('super.layouts.super')
@section('title' , 'Add Main Category')

@section('content')
<script>


function addMainCategory(){

  $('.alert-danger').hide();
  $('.alert-danger').html('');

  var main_category = $("#main_category").val();

  if(main_category == ""){
    $("#main_categoryErr").text("Please enter a Main Category");
  }
  else {

    $.ajax({
            type: "POST",
            url: "/super/maincategory-add",
            data:{main_category:main_category },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
             alert('Main category added');
             window.location="/super/maincategory";

            },
            error: function (data) {
            console.log('Error', data)
            }
        });


  }


}

</script>
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
        <div class="row" style="display:flex; justify-content:center;">
               <!-- /.col -->
               <div id="result"></div>
               <div id="valid" class="alert alert-danger" style="display:none;">
                <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }} </li>

                  @endforeach
                </ul>
              </div>
            <div class="col-md-8" style="background: white;padding: 12px;">
            <div class="form-group">
                <label>Add Main Category</label>
                <input type="text" id="main_category" name="main_category" value="{{ old('main_category') }}" class="form-control" >
                <span class="text-danger" id="main_categoryErr"></span>
            </div>

            <div class="form-group">
                <button class="btn btn-success" onclick="addMainCategory();">Add</button>
            </div>

        </div>

        </div>
        </section>


@endsection
