@extends('super.layouts.super')
@section('title' , 'CMS')

@section('content')
<script>
function addCms(){

  var cms_title = $("#cms_title").val();
  var cms_page = $("#cms_page").val();
  var cms_content = $("#cms_content").val();
  if(cms_title == ""){
    $(".cms_title_err").text("Please enter a Title");
  }else if(cms_page == ""){
    $(".cms_page_err").text("Please enter a page");
  }else if (cms_content == "") {
      $(".cms_content_err").text("Please select enter a content");
  } else {

    $.ajax({
        type: "POST",
        url: "/super/cms-add",
        data:{cms_title:cms_title, cms_page:cms_page , cms_content:cms_content },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
             alert('added');
             window.location="/super/cms-add";
        },
         error: function (request , status , error) {
            json = $.parseJSON(request.responseText);
            $.each(json.errors, function(key,value){
              $('.alert-danger').show();
              $('.alert-danger').append('<p>' + value + '</p>');
            });
            $('#result').html('');
            }
    });


}


}

</script>
<div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
<!-- Main content -->
 <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add a CMS</h1>
      </section>
    <section class="content container-fluid">
        <div class="row" style="display:flex;justify-content:center;">
            <div class="" id="result"></div>
                <div class="modal-content"></div>
                <div id="valid" class="alert alert-danger" style="display:none;">
                        <ul>
                          @foreach($errors->all() as $error)
                          <li>{{ $error }} </li>

                          @endforeach
                        </ul>
                      </div>
                <div class="col-md-8">
                <div class="form-group">
                    <label>Add a CMS title :</label>
                    <input type="text" id="cms_title" name="cms_title" value="{{ old('cms_title') }}" class="" size="40">

                    @error('cms_title')
                    <span class="invalid-feedback " role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <span class="cms_title_err"></span>
                </div>
                <div class="form-group">
                    <label>Add a CMS page:</label>
                    <input type="text" id="cms_page" name="cms_page" value="{{ old('cms_page') }}" class="" size="40">
                    @error('cms_page')
                    <span class="invalid-feedback " role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <span class="cms_page_err"></span>
                </div>
                <div class="form-group">
                    <label>Add content</label>
                    <textarea class="form-control" id="cms_content" name="cms_content" id="cms_content" cols="50" rows="10" style="width:700px;"></textarea>
                    @error('cms_content')
                    <span class="invalid-feedback " role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <span class="cms_content_err"></span>
                    </div>
                <div class="form-group">
                  <button class="btn btn-success" id="send-message" onclick="addCms();">Add CMS</button>
                </div>
                </div>

        </div>
    </section>
        </div>
</div>
@endsection
