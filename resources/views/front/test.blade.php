@extends('admin.layout.admin')
@section('title' , 'Add-new-product')

@section('content')
<script>
        $( function() {
        $( "#date" ).datepicker({
        numberOfMonths: 1,
        showButtonPanel: true ,
        minDate: new Date()
        });
        } );
  </script>


<style>
[role="alert"]{
  color: red;
}

.help-block{
  font-style:italic;
}


</style>

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
    @if(Session::has('message'))
        <div >
        <ul>
        <li class="label label-success"  style="font-size:15px;">{{ Session::get('message') }}</li>
        </ul>
        </div>
    @endif
            <div class="row" style="display:flex; justify-content:center;">
                <!-- /.col -->
                <div class="col-md-8" style="background: white;padding: 12px;">
                <!--form start here-->
                <form method="post" id="addProduct"  action="/image" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="File">File input</label>
          
                    <input type="file" id="file_upload" name="file">

                </div>

                <input id="submitFormBtnA" name="submitFormBtnA"  value="Insert" class="btn btn-success"  type="submit"  />

                </form>

                </div>
            </div>

    </section>


    </div>

@endsection
