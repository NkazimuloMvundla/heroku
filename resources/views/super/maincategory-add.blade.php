@extends('super.layouts.super')
@section('title' , 'Add Main Category')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
.showUser{cursor:pointer;}
.clearfix{padding-right:8px; margin-top:52px;}
.valid{display:none;}
#modal-default{display: none;}
#modal-request{display: none;}
</style>
<script nonce="{{ csp_nonce() }}">
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
        <div class="row main-row">
               <!-- /.col -->
               <div id="result"></div>
               <div class="alert alert-danger valid">
                <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }} </li>

                  @endforeach
                </ul>
              </div>
            <div class="col-md-8">
            <div class="form-group">
                <label>Add Main Category</label>
                <input type="text" id="main_category" name="main_category" value="{{ old('main_category') }}" class="form-control" >
                <span class="text-danger" id="main_categoryErr"></span>
            </div>

            <div class="form-group">
                <button class="btn btn-success addMainCategory">Add</button>
            </div>

        </div>

        </div>
         <script nonce="{{ csp_nonce() }}">
            //delete spec
            $(".addMainCategory").on("click", function() {
               addMainCategory();
            });


    </script>
 </section>


@endsection
