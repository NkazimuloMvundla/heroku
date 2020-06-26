@extends('super.layouts.super')
@section('title' , 'Manage countries')

@section('content')
<style nonce="{{ csp_nonce() }}">
div.main-row{display:flex; justify-content:center;}
div.main-row > div {background: white;padding: 12px;}
.country{cursor:pointer;}
.clearfix{padding-right:8px; margin-top:52px;}
#modal-default{display: none;}
</style>
<script nonce="{{ csp_nonce() }}">

function deletecity(id){
            $(document).ready(function() {

            var res = confirm(' Delete City with ID: ? ' + id);
            if(res){
                $.ajax({
                type: "POST",
                 url: "/super/deleteSingleCity",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('City deleted');
                    window.location="/super/country-view";

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
        function editcountry(id){
         $.ajax({
          type: "GET",
          url: "/super/showcountry",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           success: function (data) {
            for (var i = 0; i < data.length; i++) {
             $id = data[i].id;
             $country = data[i].cn_name;
            }
            $("#country").val($country);
            $("#countryId").val($id);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


    }
    function editcity(id){
         $.ajax({
          type: "GET",
          url: "/super/showcity",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           success: function (data) {
            for (var i = 0; i < data.length; i++) {
             $id = data[i].id;
             $city = data[i].ct_name;
            }
            $("#city").val($city);
            $("#countryId").val($id);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


    }

        function updatecountry(){
        var cn_name = $("#country").val();
        var id = $("#countryId").val();

        if(country == ""){
        $("#countryErr").text("Please enter a country");
        } else {

        $.ajax({
        type: "POST",
        url: "/super/countryUpdate",
        data:{id:id,cn_name:cn_name},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
        alert('Updated');
        window.location="/super/country-view";
        },
        error: function (data) {
        console.log('Error', data);
        }
        });

        }

        }
        function updatecity(){
        var city = $("#city").val();
        var id = $("#countryId").val();

        if(city == ""){
        $("#countryErr").text("Please enter a City");
        } else {

        $.ajax({
        type: "POST",
        url: "/super/cityUpdate",
        data:{id:id,city:city},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
        alert('Updated');
        window.location="/super/country-view";
        },
        error: function (data) {
        console.log('Error', data);
        }
        });


        }



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
                        url: "/super/destroyMultipleCountries",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                           alert('Deleted All');
                            window.location="/super/country-view";
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
           window.location="/super/maincountry-view";
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
        View Main country
        </h1>

      </section>

      <!-- Main content -->
      <section class="content container-fluid">

        <div class="col-md-12">

            <div class="box box-primary">
             <!-- /.box-header -->
             <div class="message"></div>
             <div class="box-body ">
                <div class="table-responsive mailbox-messages">
                  <table id="example1" class="table table-hover table-striped">
                      <thead>
                        <tr>
                        <th>ID</th>
                        <th>Country Name</th>
                        <th>City Name</th>
                        <th>Delete City</th>
                        </tr>
                      </thead>
                    <tbody>

                  @foreach( $countries as $country )
                  @foreach ($cities as $city)
                    <tr>
                      <td><input type="checkbox" id="{{ $country->id }}" name="id[]" value="{{ $country->id }}"></td>
                        <td class="country" data-id="{{ $country->id }}">
                        {{ $country->id == $city->ct_cn_id ? $country->cn_name : $country->cn_name }}
                      </td>
                            <!--Modal-->
                             <div class="modal fade" id="modal-default" style="display: none;">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="modal-title"></h4>
                            </div>
                            <div class="modal-body" id="modal-body">

                                <div class="form-group">
                                    <label>Edit a country</label>
                                    <input type="text" id="country" name="country" value="{{ old('country') }}" class="form-control" >
                                  <input type="hidden" id="countryId" name="countryId" value="" disabled >
                                    <span class="text-danger" id="countryErr"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                             <button type="submit" name="save" value="save" class="btn btn-success save">Save changes</button>

                        </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>


                    <td style="cursor:pointer;" class="edit_city"  data-toggle="modal" data-target="#modal-city"  data-id="{{ $city->id  }}"> {{  $country->id == $city->ct_cn_id ? $city->ct_name : '' }}
                    </td>
                       <!--Modal-->
                        <div class="modal fade" id="modal-city" style="display: none;">
                        <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="modal-title"></h4>
                        </div>
                        <div class="modal-body" id="modal-body">

                            <div class="form-group">
                                <label>Edit a City</label>
                                <input type="text" id="city" name="city" value="{{ old('city') }}" class="form-control" >
                              <input type="hidden" id="cityId" name="cityId" disabled >
                                <span class="text-danger" id="cityErr"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" name="save" value="save" class="btn btn-success save">Save changes</button>

                    </div>
                        </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                        </div>
                    <td>

                         <button  class="btn btn-default btn-sm delete" data-id="{{ $city->id  }}">
                                delete
                            </button>
                    </td>
                     </tr>
                     @endforeach
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
                   <button  class="btn btn-default btn-sm delete_all" name="DeleteAll">
                    <i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all"></i> Delete</button>
                  </div>
              </div>
            </div>
            </div>
        </div>
      </section>
      <!-- /.content -->
      <div class=" clearfix pull-right" style="padding-right:8px; margin-top:52px;">

       </div>
       </div>
    </div>
    <!-- /.content-wrapper -->

  <script nonce="{{ csp_nonce() }}">
            //delete spec
            $(".showCms").on("click", function() {
                var id = $(this).data("id");
                showCms(id);
            });


             $(".delete").on("click", function() {
                var id = $(this).data("id");
                deletecity(id);
            });

             $(".delete_all").on("click", function() {
               return checkedAll();
            });

            $(".save").on("click", function() {
               updatecity();
            });

             $(".edit_city").on("click", function() {
               var id = $(this).data("id");
                editcity(id);
            });
    </script>
  </div>
  <!-- ./wrapper -->

@endsection
