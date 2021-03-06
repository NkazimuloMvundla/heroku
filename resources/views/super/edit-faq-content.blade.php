@extends('super.layouts.super')
@section('title' , 'Edit Faq Content')

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
function FaqContentUpdate(){

  var faq_name = $("#faq_name").val();
  var faq_heading = $("#faq_heading").val();
  var faq_content = $("#faq_content").val();
  if (faq_name == "Select") {
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
            url: "/super/faq-contentUpdate",
            data:{faq_name:faq_name, faq_heading:faq_heading, faq_content:faq_content },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
             alert('Faq Content Updated');
             window.location="/super/faq-view";

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
               <div  class="alert alert-danger valid">
                <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }} </li>

                  @endforeach
                </ul>
              </div>
            <div class="col-md-8">
            <div class="form-group">
                <label for="text">Select a Faq </label>
                <select class="form-control " id="faq_name"  name="faq_name">
                        <option >Select</option>
                @forelse($faqs as $fa)
                <?php $action = $fa->faq_name == $faq->first()->faq_name  ?  'selected' : ''  ?>
                <option value="{{ $fa->faq_name }}" {{old('faq_name') ?? $action}} >{{$fa->faq_name}}</option>
                <?php $id = $fa->id ;?> 
                @empty
                <option >No categories</option>
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
                   <input type="text" name="faq_heading" id="faq_heading" class="form-control" value="{{ $faq->first()->faq_heading  }}">
                <span class="help-block" id="faq_headingErr"></span>
            </div>
            <div class="form-group">
                <label>Add Faq Content</label>
                <textarea class="form-control" name="faq_content" id="faq_content">{{ $faq->first()->faq_content  }}</textarea>
                <span class="text-danger" id="faq_contentErr"></span>
            </div>

            <div class="form-group">
                <button class="btn btn-success FaqContentUpdate">Add</button>
            </div>

           </div>

        </div>
    </section>
     <script nonce="{{ csp_nonce() }}">
            //delete spec
            $(".FaqContentUpdate").on("click", function() {
                FaqContentUpdate();
            });


    </script>

@endsection
