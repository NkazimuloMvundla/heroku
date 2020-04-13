@extends('super.layouts.super')
@section('title' , 'Manage countries')

@section('content')
<script>

function deletecountry(id){
            $(document).ready(function() {

            var res = confirm(' Delete country with ID: ? ' + id);
            if(res){
                $.ajax({
                type: "POST",
                 url: "/super/deleteSinglecountry",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('country deleted');
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

        function updatecountry(){
        var cn_name = $("#country").val();
        var id = $("#countryId").val();

        if(country == ""){
        $("#countryErr").text("Please enter a Main country");
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
                        url: "/super/destroyMultiplecountry",
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

function showParent(id){

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
        <div class="col-md-2">
            <label>Result per page:</label>
                <div class="form-group">
                        <select name="limit" id="limit"  onChange="showId(this.value);" class="form-control">
                            <option disabled selected>select</option>
                            <option value="1" >1</option>
                             <option value="2">2</option>
                             <option value="3">3</option>
                         </select>
                </div>
        </div>
        <div class="col-md-9">

            <div class="box box-primary">
             <!-- /.box-header -->
             <div class="message"></div>
             <div class="box-body no-padding">
                <div class="table-responsive mailbox-messages">
                  <table class="table table-hover table-striped">
                    <tbody>
                    <tr>
                    <th>ID</th>
                    <th>Country Name</th>
                    <th>City Name</th>
                    <th>Action</th>
                  </tr>
                  @foreach( $countries as $country )
                  @forelse ($cities as $city)
                    <tr>
                      <td><input type="checkbox" id="{{ $country->id }}" name="id[]" value="{{ $country->id }}"></td>
                      <td style="cursor:pointer;" id="country" onclick="showParent({{ $country->id }}); ">
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
                            <button type="submit" name="save" id="save" value="save" onclick="updatecountry();" class="btn btn-success">Save changes</button>

                        </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>


                    <td> {{  $country->id == $city->ct_cn_id ? $city->ct_name : '' }}
                    </td>
                    <td>
                <button name="edit" class="btn btn-default btn-sm"  data-toggle="modal" data-target="#modal-default"  onclick="editcountry({{ $country->id  }});">
                            edit
                         </button> or
                         <button id="delete" class="btn btn-default btn-sm" onclick="deletecountry({{ $country->id }})";>
                                delete
                            </button>
                    </td>

                    @empty
                    <td>No cities</td>



                     </tr>
                     @endforelse
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
      <div class=" clearfix pull-right" style="padding-right:8px; margin-top:52px;">

       </div>
       </div>
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->

@endsection
