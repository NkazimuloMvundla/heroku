@extends('super.layouts.super')
@section('title' , 'Add a Sub Category')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
.category{cursor:pointer;}
.clearfix{padding-right:8px; margin-top:52px;}
.valid{display:none;}
#modal-default{display: none;}
</style>
<script nonce="{{ csp_nonce() }}">


function addSubCategory(){

  var mainCategory = $("#mc_id").val();
  var category = $("#c_id").val();
  var subcategory = $("#subcategory").val();
  if (mainCategory == "Select") {
    $("#mainCategoryErr").text("Please select a Main Category");
  }
  else if (category == "Select") {
    $("#categoryErr").text("Please select a  Category");
  }else if(subcategory == ""){
    $("#subcategoryErr").text("Please enter a Sub Category");
  }
  else {

    $.ajax({
            type: "POST",
            url: "/super/subcategory-add",
            data:{category:category, subcategory:subcategory },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
             alert('Sub Category added');
             //window.location="/super/subcategory";

            },
            error: function (data) {
            console.log('Error', data)
            }
        });


  }


}
  
function showCat(id) {
    $.ajax({
        type: "POST",
        url: "/subcats",
        data: { _token: $('[name="token"]').val(), id: id },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function(data) {
            var select = "";
            select +=
                "<option  selected>" +
                "Select" +
                "</option>" +
                "<br>";
            for (var i = 0; i < data.length; i++) {
                select +=
                    '<option value="' +
                    data[i].id +
                    '" >' +
                    data[i].pc_name +
                    "</option>" +
                    "<br>";
            }

            $(".coin").html(select);
        }
    });
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
               <div class="valid" class="alert alert-danger">
                <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }} </li>

                  @endforeach
                </ul>
              </div>
            <div class="col-md-8">
            <div class="form-group">

                <label for="text">Select a Main category</label>
                <select class="form-control " id="mc_id"  name="mainCategory">
                        <option >Select</option>
                @forelse($parent_category as $category)
                <option value="{{ $category->pc_id }} ">{{$category->pc_name}}</option>
                <?php $pc_id = $category->pc_id ;?>
                @empty
                <option value="">No categories</option>
                @endforelse
                </select>
                @error('mainCategory')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <span class="help-block" id="mainCategoryErr"></span>

            </div>

            <div class="form-group">
                    <label for="">Select a Category</label>
                        <select class="form-control coin"  name="c_id"  id="c_id">
                        <option selected disabled>Select</option>
                        </select>
                        @error('Category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
           
                    <span class="help-block" id="categoryErr"></span>

            </div>
            <div class="form-group">
                <label>Add a Sub Category</label>
                <input type="text" id="subcategory" name="subcategory" value="{{ old('subcategory') }}" class="form-control" >
                <span class="text-danger" id="subcategoryErr"></span>
            </div>

            <div class="form-group">
                <button class="btn btn-success addSubCategory">Add</button>
            </div>

        </div>

        </div>
        </section>
 <script nonce="{{ csp_nonce() }}">

            $(".addSubCategory").on("click", function() {
               addSubCategory();
            });



 $(document).ready(function() {
        $("#mc_id").on("change", function() {
             showCat(this.value);
        });
    });


    </script>

@endsection
