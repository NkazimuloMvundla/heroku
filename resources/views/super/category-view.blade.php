@extends('super.layouts.super')
@section('title' , 'Manage categories')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
.category{cursor:pointer;}
.clearfix{padding-right:8px; margin-top:52px;}
</style>
<script nonce="{{ csp_nonce() }}">
function deleteCat(id){
            $(document).ready(function() {

            var res = confirm(' Delete product with ID: ? ' + id);
            if(res){
                $.ajax({
                type: "POST",
                 url: "/super/deleteSingleCategory",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('Category deleted');
                    window.location="/super/category-view";

                     },
                error: function (data) {
                   console.log('Error:', data);
                  }
                    });
            }else{
                return res;
            }


            });

        }
        function editCat(id){
         $.ajax({
          type: "GET",
          url: "/super/showCat",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           success: function (data) {
            for (var i = 0; i < data.length; i++) {
             $id = data[i].id;
             $category = data[i].pc_name;
            }
            $("#category").val($category);
            $("#catId").val($id);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


    }



function checkedAll () {
    var check = $('input[name="id[]"]:checked').length;
    if(check > 0 ){
        $(document).ready(function() {
            var res = confirm(' Are you sure you want to delete ? ');
            if(res){

                var notChecked = [], checked = [];
                $("input:checkbox").map(function(){
                this.checked ? checked.push(this.id) : notChecked.push(this.id);
                });
                console.log("Checked " + checked);
                console.log("Not checked " + notChecked);

                        $.ajax({
                        type: "POST",
                        url: "/super/destroyMultipleCategories",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                           alert('Deleted All');
                            window.location="/super/category-view";
                        },
                        error: function (data) {
                        console.log('Error:', data);
                        }
                        });

            }else{
                return res;
            }
        });


    }else{
       alert("Please check at least one ");
    }


}

function showId(limit){

    $.ajax({
      type: "POST",
      url: "/super/limit",
      data:{limit:limit},
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function (data) {
           alert('Result per page');
           window.location="/super/maincategory-view";
      },
       error: function (data) {
          console.log('Error', data);
          }
  });

}

</script>
<div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
        View Main Category
        </h1>

      </section>

      <!-- Main content -->
      <section class="content container-fluid">
        <div class="col-md-12">

            <div class="box">
             <!-- /.box-header -->
             <div class="message"></div>
             <div class="box-body ">
                <div class="table-responsive mailbox-messages">
                  <table id="example1" class="table table-hover table-striped">
                      <thead>
                        <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Main Category</th>
                        <th>Action</th>
                        </tr>
                      </thead>
                    <tbody>

                  @foreach( $Categories as $category )
                    <tr>
                      <td><input type="checkbox" id="{{ $category->id }}" name="id[]" value="{{ $category->id }}"></td>
                      <td class="category" data-id="{{ $category->pc_id }}">{{ $category->pc_name }}</td>
                            <!-- /.modal-dialog -->
                            </div>
                              <td>
                                @foreach ($mainCategories as $mainCat)
                                @if($mainCat->pc_id == $category->pc_id)
                                {{ $mainCat->pc_name }}
                                @endif
                                @endforeach
                            </td>
                     <td>
                     <a href="/super/category-edit/{{  $category->id  }}">
                     <button name="edit" class="btn btn-default btn-sm">
                             Edit
                     </button>
                     </a>
                         or
                     <button data-id="{{ $category->id }}" class="btn btn-default btn-sm delete">
                        delete
                    </button>
                     </td>
                     </tr>

                 @endforeach
                    </tbody>

                  </table>
                  <!-- /.table -->

                </div>
                <!-- /.mail-box-messages -->
              </div>
              <!-- /.box-body -->
              <div class="box-footer no-padding">
                <div class="mailbox-controls">
                  <!-- Check all button -->
                  <button type="button" class="btn btn-default btn-sm checkbox-toggle"  ><i class="fa fa-square-o"></i>
                  </button>
                   <div class="btn-group">
                   <button  class="btn btn-default btn-sm" name="DeleteAll" onclick="checkedAll();"  ><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all" onclick="return deleteAll();"></i> Delete</button>

                  </div>
              </div>
            </div>
            </div>
        </div>
      </section>
      <!-- /.content -->
      <div class="clearfix pull-right">

       </div>
       </div>
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->
<script nonce="{{ csp_nonce() }}">
/*
 function updateCat(){
        var category = $("#category").val();
        var id = $("#catId").val();
        var main_category = $("#main_category").val();
        if(category == ""){
        $("#categoryErr").text("Please enter a Main Category");
        } else {

        $.ajax({
        type: "POST",
        url: "/super/catUpdate",
        data:{id:id,category:category , main_category:main_category},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
        alert('Updated');
        window.location="/super/category-view";
        },
        error: function (data) {
        console.log('Error', data);
        }
        });


        }



        }


*/

Dropzone.options.myDropzone = {
    // Dropzone.autoDiscover = false;
    url: "/super/catUpdate",
    method:"POST",
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 3,
    maxFiles: 3,
    maxFilesize: 1,
    acceptedFiles: "image/*",
    addRemoveLinks: true,

    success: function(responseText, data) {
        alert(data);
    },
    error: function(data){
        console.log("Err", data);
    },

    error: function(file, response) {
        if ($.type(response) === "string") var message = response;
        //dropzone sends it's own error messages in string
        else var message = response.message;
        file.previewElement.classList.add("dz-error");
        _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i];
            _results.push((node.textContent = message));
        }
        return (document.getElementById(
            "dz-error-message"
        ).textContent = _results);
    },

    init: function() {
        dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

        // for Dropzone to process the queue (instead of default form behavior):
        document
            .getElementById("submitFormBtnA")
            .addEventListener("click", function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                dzClosure.processQueue();

        var category = $("#category").val();
        var id = $("#catId").val();
        var main_category = $("#main_category").val();
        if(category == ""){
        $("#categoryErr").text("Please enter a Main Category");
        }

        });

        this.on("success", function(file, responseText) {
             console.log(responseText);
         if (responseText == "success") {
                alert("Product added");
                window.location = "/u/add-new-product";
            }
        });

        this.on("complete", function(file) {
            if (file == "") {
                alert("Please god");
            }
        });

        this.on("error", function(file, data, xhr, responseText) {
            console.log("Err,", responseText)
            if (xhr.status != 200) {
                this.removeFile(file);
            }
        });

        //send all the form data along with the files:
        this.on("sendingmultiple", function(data, xhr, formData) {
            formData.append("mainCategory",  $("#main_category").val());
            formData.append("category",  $("#category").val());
            formData.append("catId", $("#catId").val());
        });
    }
};


</script>

  <script nonce="{{ csp_nonce() }}">
            //delete spec
            $(".category").on("click", function() {
                var id = $(this).data("id");
                showParent(id);
            });

             $(".delete").on("click", function() {
                var id = $(this).data("id");
                deleteCat(id);
            });
        </script>
@endsection
