@extends('super.layouts.super')
@section('title' , 'Add a setting')

@section('content')
<script>

/*
function addSetting(){

  $('.alert-danger').hide();
  $('.alert-danger').html('');

  var setting_name = $("#setting_name").val();
  var setting_field = $("#setting_field").val();
  var setting_pic = $("#setting_pic").val();

   if(setting_field == ""){
    $("#setting_fieldErr").text("Please enter a Field");
  }else if(setting_name == ""){
    $("#setting_nameErr").text("Please enter a Setting Value");
  }
  else {

    $.ajax({
            type: "POST",
            url: "/super/add-setting",
            data:{setting_name:setting_name,setting_field:setting_field,setting_pic:setting_pic},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
             alert('Setting added');
             window.location="/super/add-setting";

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
            @if(Session::has('setting_add'))

             <ul>
                 <li class="label label-success"  style="font-size:15px;">{{ Session::get('setting_add') }}</li>

             </ul>
             @endif

        <form action="#" name="add-setting" enctype="multipart/form-data" method="POST">
            @csrf
        <div class="row" style="display:flex; justify-content:center;">
               <!-- /.col -->
               <div id="result"></div>
               <div id="valid" class="alert alert-danger" style="display:none;">
                <ul>
                @if($errors->any())
                  @foreach($errors->all() as $error)
                  <li>{{ $error }} </li>

                  @endforeach
                  @endif
                </ul>
              </div>
            <div class="col-md-8" style="background: white;padding: 12px;">
                <div class="form-group">
                    <label>Add a Setting Field</label>
                    <input type="text" id="setting_field" name="setting_field" value="{{ old('setting_field') }}" class="form-control" >
                    <span class="text-danger" id="setting_fieldErr"></span>
                    @error('setting_field')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                </div>
            <div class="form-group">
                <label>Add a Setting</label>
                <input type="text" id="setting_name" name="setting_name" value="{{ old('setting_name') }}" class="form-control" >
                <span class="text-danger" id="setting_nameErr"></span>
                @error('setting_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>

            <div class="form-group">
                    <label>Add a Picture </label>
                    <input type="file" id="setting_pic" name="setting_pic"  class="form-control" >
                    <span class="text-danger" id="setting_picErr"></span>
                    @error('setting_pic')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>

            <div class="form-group">
                    <input id="submitFormBtnA" name="submitFormBtnA" value="Insert" class="btn btn-success"  type="submit"  />

            </div>

        </div>

        </div>
    </form>
        </section>


@endsection
