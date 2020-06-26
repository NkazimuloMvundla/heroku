@extends('super.layouts.super')
@section('title' , 'Add Faq Content')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
.showUser{cursor:pointer;}
.clearfix{padding-right:8px; margin-top:52px;}
.valid{display:none;}
#modal-default{display: none;}
#modal-request{display: none;}
.product_name{border: 2px dotted #f3f3f3; padding:3px;}
</style>
<script nonce="{{ csp_nonce() }}">
function addSubCategory(){

  var mainCategory = $("#mc_id").val();
  var category = $("#Category").val();
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
             window.location="/super/subcategory";

            },
            error: function (data) {
            console.log('Error', data)
            }
        });


  }


}

function showCat(id)
{

    $.ajax({
            type: "POST",
            url: "/subcats",
            data:{id:id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
            //console.log(data);
            var select = '<select class="form-control" name="Category" id="Category">';
            select +='<option>' + "Select"+ '</option>' + "<br>";
            for (var i = 0; i < data.length; i++) {
            //  console.log(data[i].pc_)

              select +='<option value="'+ data[i].id +'" >' + data[i].pc_name + '</option>' + "<br>";
              //$("#coin").html("Judge"

            }
            select +='</select';
            $("#coin").html(select)


          //      console.log(data);
            },
            error: function (data) {
                console.log('Error:', data);
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
               <div class="alert alert-danger valid">
                <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }} </li>

                  @endforeach
                </ul>
              </div>
            <div class="col-md-8">
            <div class="form-group">

                <label for="text">Select a Main category</label>
                <select class="form-control " id="mc_id"  name="mainCategory"   onChange="showCat(this.value);">
                        <option >Select</option>
                @forelse($parent_category as $category)
                <option value="{{ $category->pc_id }} "   >{{$category->pc_name}}</option>
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
                <span class="help-block"  id="mainCategoryErr"></span>

            </div>

            <div class="form-group">
                    <label for="">Select a Category</label>
                    <div class="" id="coin">
                        <select class="form-control "  name="Category"  id="c_id">
                        <option selected disabled> Category</option>
                        </select>
                        @error('Category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <span class="help-block"id="categoryErr"></span>

            </div>
            <div class="form-group">
                <label>Add a Sub Category</label>
                <input type="text" id="subcategory" name="subcategory" value="{{ old('subcategory') }}" class="form-control">
                <span class="text-danger" id="subcategoryErr"></span>
            </div>

            <div class="form-group">
                <button class="btn btn-success addSubCategory">Add</button>
            </div>

        </div>

        </div>
    </section>
 <script nonce="{{ csp_nonce() }}">
            //delete spec
            $(".addSubCategory").on("click", function() {
                addSubCategory();
            });


    </script>

@endsection
