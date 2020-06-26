@extends('super.layouts.super')
@section('title' , 'add-specification')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
div.valid{display:none;}
#valspec_id{display: none;}
.add_spec{margin-top: 20px;}
input#specification > button {margin-top:10px;}
</style>
<script nonce="{{ csp_nonce() }}">

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
                "<option  selected disabled>" +
                "Select Category" +
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

function showSubCat(id) {
    $.ajax({
        type: "POST",
        url: "/lastcats",
        data: { id: id },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function(data) {
            var select =
                '<select class="form-control" name="subCategory" id="subCategory" >';
            select +=
                '<option value="" selected disabled>' +
                "Select SubCategory" +
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
            select += "</select";
            $("#last").html(select);
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
        <div class="row main-row">
        <div class="col-md-12">
        <div class="form-group-row">
             @include('layouts.cats')
        </div>

      <div class="form-group col-xs-6 add_spec">
      <label>Add a specification</label>
      <input type="text" name="spec_name" class="form-control" id="specification">
      <button class="btn btn-success addSpec">Add</button>
      <span class="help-block" id="specificationErr"></span>
      </div>

        </div>
        </section>
        <div>
        <span class="text-success" id="data"></span>
      </div>
      <div class="col-md-10" id="data">

      </div>
    </div>
</div>

        <script nonce="{{ csp_nonce() }}">
                //delete spec
                $(".addSpec").on("click", function() {
                addSpec();
                });

                $(document).ready(function() {
                $("#c_id").on("change", function() {
                showSubCat(this.value);
                });
                });

        </script>
@endsection
