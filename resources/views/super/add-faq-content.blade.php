@extends('super.layouts.super')
@section('title' , 'Add Faq Content')

@section('content')

<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
div.valid{display:none;}

</style>
<script nonce="{{ csp_nonce() }}">


function addFaqContent(){

  var faq_parent_id = $("#faq_parent_id").val();
  var faq_heading = $("#faq_heading").val();
  var faq_content = $("#faq_content").val();
  if (faq_parent_id == "Select") {
    $("#faq_nameErr").text("Please select a  faq");
  }
  else if (faq_heading == "") {
    $("#faq_headingErr").text("Please enter an Faq Heading");
  }else if(faq_content == ""){
    $("#faq_contentErr").text("Please enter a Faq Content");
  }
  else {

    $.ajax({
            type: "POST",
            url: "/super/add-faq-content",
            data:{faq_parent_id:faq_parent_id, faq_heading:faq_heading, faq_content:faq_content },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
             alert('Faq Content added');
             window.location="/super/add-faq-content";

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
            @if(Session::has('addFaqcontent'))
            <div class="">
             <ul>
                 <li class="label label-success">{{ Session::get('addFaqcontent') }}</li>

             </ul>

            </div>
            @endif
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
                <label for="text">Select a Faq </label>
                <select class="form-control " id="faq_parent_id"  name="faq_parent_id">
                        <option >Select</option>
                @forelse($faqs as $faq)
                <option value="{{ $faq->id }}">{{$faq->faq_name}}</option>
                <?php $id = $faq->id ;?>
                @empty
                <option>No categories</option>
                @endforelse
                </select>
                @error('faq_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <span class="help-block" id="faq_nameErr"></span>
            </div>
            <div class="form-group">
                    <label for="">Enter Faq Heading</label>
                   <input type="text" name="faq_heading" id="faq_heading" class="form-control" >
                <span class="help-block" id="faq_headingErr"></span>
            </div>
            <div class="form-group">
                <label>Add Faq Content</label>
                <textarea class="form-control" name="faq_content" id="faq_content"></textarea>
                <span class="text-danger" id="faq_contentErr"></span>
            </div>

            <div class="form-group">
                <button class="btn btn-success addFaqContent">Add</button>
            </div>

        </div>

        </div>
        </section>
       <script nonce="{{ csp_nonce() }}">
            //delete spec
            $(".addFaqContent").on("click", function() {
                 addFaqContent();
            });
        </script>

@endsection
