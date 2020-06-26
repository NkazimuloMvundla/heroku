@extends('super.layouts.super')
@section('title' , 'Add a spec')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
div.valid{display:none;}
#valspec_id{display: none;}

</style>
<script nonce="{{ csp_nonce() }}">
function addSpec(){
  var spec_option = $("#spec_option").val();
  var spec_id = $("#spec_id").val();
 if(spec_id == "Select"){
    $("#cn_nameErr").text("Please select a spec");
  }else if(spec_option == ""){
    $("#spec_optionErr").text("Please enter a City");
  }
  else {

    $.ajax({
            type: "POST",
            url: "/super/add-spec-option",
            data:{spec_option:spec_option,spec_id:spec_id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data) {
             alert('Spec Option added');
             window.location="/super/add-spec-option";

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
        <li><a href="#"><i class="spec spec-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
        <div class="row main-row">
               <!-- /.col -->
               <div spec_id="result"></div>
               <div spec_id="spec_id" class="alert alert-danger valid">
                <ul>
                  @foreach($errors->all() as $error)
                  <li>{{ $error }} </li>

                  @endforeach
                </ul>
              </div>
            <div class="col-md-8">
            <div class="form-group">
                    <label for="text">Select a Spec </label>
                    <select class="form-control" id="spec_id"  name="spec_id">
                        <option disabled>Select</option>
                    @forelse($specifications as $spec)
                    <option value="{{ $spec->spec_id }}"  >{{$spec->spec_name}}</option>
                    @empty
                    <option>No Countries</option>
                    @endforelse
                    </select>
                    @error('spec_name')
                        <span class="spec_id-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <span class="help-block" spec_id="cn_nameErr"></span>
                </div>
            <div class="form-group">
                <label>Add a Spec Option</label>
                <input type="text" id="spec_option" name="spec_option" value="{{ old('spec_option') }}" class="form-control" >
                <span class="text-danger" spec_id="spec_optionErr"></span>
            </div>



            <div class="form-group">
                <button class="btn btn-success addSpec">Add</button>
            </div>

        </div>

        </div>
        </section>

        <script nonce="{{ csp_nonce() }}">
            //delete spec
            $(".addSpec").on("click", function() {
                 addSpec();
            });
        </script>

@endsection
