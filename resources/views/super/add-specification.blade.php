@extends('super.layouts.super')
@section('title' , 'add-specification')

@section('content')
<script>
function showCat(id)
{

    $.ajax({
            type: "POST",
            url: "/subcats",
            data:{id:id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
            //console.log(data);
            var select = '<select class="form-control" name="Category" onChange="showSubCat(this.value);" id="Category">';
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


function showSubCat(id){
  $.ajax({
          type: "POST",
          url: "/lastcats",
          data:{id:id},
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data) {
          //console.log(data);
          var select = '<select class="form-control" name="subCategory" id="subCategory" onChange="show_list();" >';
          select +='<option value="" selected disabled>' + "Select SubCategory"+ '</option>' + "<br>";
          for (var i = 0; i < data.length; i++) {
          //  console.log(data[i].pc_)

            select +='<option value="'+ data[i].id +'" >' + data[i].pc_name + '</option>' + "<br>";
            //$("#coin").html("Judge"

          }
          select +='</select';
          $("#last").html(select)


        //      console.log(data);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });

}

function addSpec(){

  var mainCategory = $("#mc_id").val();
  var category = $("#Category").val();
  var subcategory = $("#subCategory").val();
  var specification = $("#specification").val();
  if (mainCategory == "Select") {
    $("#mainCategoryErr").text("Please select a Main Category");
  }
  else if (category == "Select") {
    $("#categoryErr").text("Please select a  Category");
  }else if(specification == ""){
    $("#specificationErr").text("Please enter a specification");
  }
  else {

    $.ajax({
            type: "POST",
            url: "/super/add-specification",
            data:{mainCategory:mainCategory, subcategory:subcategory , specification:specification },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
             alert('Spec  added');
             window.location="/super/add-specification";

            },
            error: function (data) {
            console.log('Error', data)
            }
        });


  }


}

function show_list()
{
  var subcateid =  $("#subCategory").val();

    $.ajax({
            type: "POST",
            url: "/super/showSpecList",
            data:{subcateid:subcateid },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
            var table = '<table class="table table-hover table-striped">';
              table +='<tbody>';
              table +='<tr>';
              table +='<th>' + 'Spec Name ' + '</th>';
              table +='</tr>';
              for (var i = 0; i < data.length; i++) {
              $id = data[i].id;


              table +='<tr>';
              table +='<td>' + data[i].spec_name +'</td>';
              table +='<td>' + '<input type="text" class="form-control" >' + '</td>';

              table +='</tr>';



              }
              table +='</tbody>';
              table +='</table>';
               $("#data").html(table);


            },
            error: function (data) {
            console.log('Error', data)
            }
        });
}

</script>

<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
<!-- Main content -->
<!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>Add a specification</h1>
    </section>

    <section class="content container-fluid">
        <div class="row" style="display:flex;justify-content:center;">
        <div class="col-md-12">
        <div class="form-group-row">
            <div class="col-md-4 ">
                <label for="text">Select a Main category</label>
                <select class="form-control " id="mc_id"  name="mainCategory"   onChange="showCat(this.value);">
                   <option >Select</option>
                @forelse($parent_category as $category)
                <option value="{{ $category->pc_id }}">{{$category->pc_name}}</option>
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
                 <span class="help-block " style="color:red;" id="mainCategoryErr"></span>
                </div>

        <div class="col-md-4">
        <label for="">Select a Category</label>
        <div class="" id="coin">
        <select class="form-control"  name="Category"  id="c_id">
           <option>Select</option>
        </select>
        @error('Category')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        </div>
            <span class="help-block " style="color:red;" id="categoryErr"></span>
        </div>

    <div class="col-md-4 ">
    <label for="number">Select a Sub Category </label>
    <div class="" id="last">
    <select class="form-control "  name="subCategory"  id="sc_id">
    <option selected disabled>Sub Category</option>
    </select>
    @error('subCategory')
    <span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
    </span>
    @enderror
    </div>
     <span class="help-block" style="color:red;" id="subCategoryErr"></span>
    </div>
  </div>

      <div class="form-group col-xs-6" style="margin-top: 20px;">
      <label>Add a specification</label>
      <input type="text" name="spec_name" class="form-control" id="specification">
      <button class="btn btn-success" style="margin-top:10px;" onclick="addSpec();">Add</button>
      <span class="help-block " style="color:red;" id="specificationErr"></span>
      </div>

        </div>
        </section>
        <div class="">
        <span class="text-success" id="data"></span>
      </div>
      <div class="col-md-10" id="data">

      </div>
    </div>
</div>

@endsection
