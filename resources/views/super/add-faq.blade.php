@extends('super.layouts.super')
@section('title' , 'Add a faq')

@section('content')
<script>


function addfaq(){

  $('.alert-danger').hide();
  $('.alert-danger').html('');

  var faq_name = $("#faq").val();

   if(faq_name == ""){
    $("#faqErr").text("Please enter an faq");
  }
  else {

    $.ajax({
            type: "POST",
            url: "/super/faq-add",
            data:{faq_name:faq_name},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
             alert('faq added');
             window.location="/super/faq-add";

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
                <label>Add an FAQ</label>
                <input type="text" id="faq" name="faq" value="{{ old('faq') }}" class="form-control" >
                <span class="text-danger" id="faqErr"></span>
            </div>

            <div class="form-group">
                <button class="btn btn-success" onclick="addfaq();">Add</button>
            </div>

        </div>

        </div>
        </section>


@endsection
