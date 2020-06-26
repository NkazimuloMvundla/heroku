@extends('super.layouts.super')
@section('title' , 'Add a country')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
div.valid{display:none;}

</style>
<script nonce="{{ csp_nonce() }}">
function addCity(){

  $('.alert-danger').hide();
  $('.alert-danger').html('');

  var city_name = $("#city_name").val();
  var country_id = $("#country_id").val();

 if(country_id == "Select"){
    $("#cn_nameErr").text("Please select a Country");
  }else if(city_name == ""){
    $("#city_nameErr").text("Please enter a City");
  }
  else {

    $.ajax({
            type: "POST",
            url: "/super/add-city",
            data:{city_name:city_name,country_id:country_id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
             alert('City added');
             window.location="/super/add-city";

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
        <li><a href="#"><i class="country country-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
        <div class="row main-row">
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
                    <label for="text">Select a Country </label>
                    <select class="form-control " id="country_id"  name="country_id"  >
                        <option >Select</option>
                    @forelse($countries as $country)
                    <option value="{{ $country->id }}"  >{{$country->cn_name}}</option>
                    @empty
                    <option value="">No Countries</option>
                    @endforelse
                    </select>
                    @error('cn_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <span class="help-block" id="cn_nameErr"></span>
                </div>
            <div class="form-group">
                <label>Add a City</label>
                <input type="text" id="city_name" name="city_name" value="{{ old('city_name') }}" class="form-control" >
                <span class="text-danger" id="city_nameErr"></span>
            </div>
            <!--
            <div class="form-group">
                    <label>Add a Country Flag</label>
                    <input type="file" id="country_flag" name="country_flag" value="{{ old('country_flag') }}" class="form-control" >
                    <span class="text-danger" id="country_flagErr"></span>
                </div>
            -->
            <div class="form-group">
                <button class="btn btn-success addCity">Add</button>
            </div>

        </div>

      </div>

        <script nonce="{{ csp_nonce() }}">
            //delete spec
            $(".addCity").on("click", function() {
                 addCity();
            });
        </script>

    </section>


@endsection
