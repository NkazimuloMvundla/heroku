@extends('super.layouts.super')
@section('title' , 'Add a country')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
span.add-spec{display: none;}
div.valid{display:none;}

</style>

<script nonce="{{ csp_nonce() }}">


function addCountry(){

  $('.alert-danger').hide();
  $('.alert-danger').html('');

  var country_name = $("#country_name").val();

   if(country_name == ""){
    $("#country_nameErr").text("Please enter a Country");
  }
  else {

    $.ajax({
            type: "POST",
            url: "/super/add-country",
            data:{country_name:country_name},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
             alert('Country added');
             window.location="/super/add-country";

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
        <div class="row">
               <!-- /.col -->
               <div id="result"></div>
               <div class="valid" class="alert alert-danger">
                <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }} </li>

                  @endforeach
                </ul>
              </div>
            <div class="col-md-8">
            <div class="form-group">
                <label>Add a Country</label>
                <input type="text" id="country_name" name="country_name" value="{{ old('country_name') }}" class="form-control" >
                <span class="text-danger" id="country_nameErr"></span>
            </div>
            <!--
            <div class="form-group">
                    <label>Add a Country Flag</label>
                    <input type="file" id="country_flag" name="country_flag" value="{{ old('country_flag') }}" class="form-control" >
                    <span class="text-danger" id="country_flagErr"></span>
                </div>
            -->
            <div class="form-group">
                <button class="btn btn-success addCountry">Add</button>
            </div>

        </div>

        </div>
    </section>
        <script nonce="{{ csp_nonce() }}">
            //delete spec
            $(".addCountry").on("click", function() {
                 addCountry();
            });
        </script>

@endsection
