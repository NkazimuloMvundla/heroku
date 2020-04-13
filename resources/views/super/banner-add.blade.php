@extends('super.layouts.super')
@section('title' , 'Add a Banner')

@section('content')
<script>


/*function addBanner(){

  $('.alert-danger').hide();
  $('.alert-danger').html('');

  var banner_link = $("#banner_link").val();
  var banner_img = $("#banner").val();

  if(banner_link == ""){
    $("#banner_linkErr").text("Please enter a Banner Link");
  }else if(banner_img == ""){
    $("#bannerErr").text("Please upload a banner");
  }
  else {

    $.ajax({
            type: "POST",
            url: "/super/add-banner",
            data:{banner_link:banner_link,banner_img:banner_img},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
           console.log(data)

            },
            error: function (data) {
            console.log('Error', data)
            }
        });


  }


}

*/

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
            <form method="post" id="insert_banner" action="/super/add-banner"  enctype="multipart/form-data">
                @csrf
        <div class="row" style="display:flex; justify-content:center;">
               <!-- /.col -->
               <div id="result"></div>
               @if(Session::has('banner'))
               <div class="">
                <ul>
                    <li class="label label-success"  style="font-size:15px;">{{ Session::get('banner') }}</li>

                </ul>

               </div>
               @endif
               <div id="valid" class="alert alert-danger" style="display:none;">
                <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }} </li>

                  @endforeach
                </ul>
              </div>

                <div class="col-md-8" style="background: white;padding: 12px;">
            <div class="form-group">
                <label>Add a banner Link </label>
                <input type="text" id="banner_link" name="banner_link" value="{{ old('banner_link') }}" class="form-control" >
                @error('banner_link')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                <label>Add a banner </label>
                <input type="file" id="banner_img" name="banner_img"  class="form-control" >
                @error('banner_img')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
  <input id="submitFormBtnA" name="submitFormBtnA" value="Update" class="btn btn-success"  type="submit"  />

            </div>

        </div>
              </form>

        </div>
        </section>


@endsection
