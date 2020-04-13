@extends('super.layouts.super')
@section('title' , 'Manage FAQS')

@section('content')
<script>

function deleteFaq(id){
            $(document).ready(function() {

            var res = confirm(' Delete faq with ID: ? ' + id);
            if(res){
                $.ajax({
                type: "POST",
                 url: "/super/deleteSinglefaq",
                  data:{id:id},
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  success: function (data) {
                   alert('faq deleted');
                    window.location="/super/faq-view";

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
        function editFaq(id){
         $.ajax({
          type: "GET",
          url: "/super/showFaq",
          data:{id:id},
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           success: function (data) {
            for (var i = 0; i < data.length; i++) {
             $id = data[i].id;
             $faq = data[i].faq_name;
            }
            $("#faq").val($faq);
            $("#faqId").val($id);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


    }

        function updateFaq(){
        var faq_name = $("#faq").val();
        var id = $("#faqId").val();

        if(faq == ""){
        $("#faqErr").text("Please enter a Main faq");
        } else {

        $.ajax({
        type: "POST",
        url: "/super/faqUpdate",
        data:{id:id,faq_name:faq_name},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function (data) {
        alert('Updated');
        window.location="/super/faq-view";
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
                        url: "/super/destroyMultipleFaq",
                        data:{checked:checked},
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function (data) {
                           alert('Deleted All');
                            window.location="/super/faq-view";
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
           window.location="/super/mainfaq-view";
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
        View Main faq
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
                        <th>Faq Name</th>
                        <th>Faq Content</th>
                        <th>Action</th>
                        </tr>
                      </thead>
                    <tbody>

                  @foreach( $faqs as $faq )
                    <tr>
                      <td><input type="checkbox" id="{{ $faq->id }}" name="id[]" value="{{ $faq->id }}"></td>
                      <td style="cursor:pointer;" id="faq" onclick="showParent({{ $faq->id }});">{{ $faq->faq_name }}</td>

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
                                    <label>Edit a faq</label>
                                    <input type="text" id="faq" name="faq" value="{{ old('faq') }}" class="form-control" >
                                  <input type="hidden" id="faqId" name="faqId" value="" disabled >
                                    <span class="text-danger" id="faqErr"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" name="save" id="save" value="save" onclick="updateFaq();" class="btn btn-success">Save changes</button>

                        </div>
                            </div>
                            <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                            </div>

                    <td> <a href="/super/faq/{{ $faq->faq_name }}/edit">
                        <button name="edit" class="btn btn-default btn-sm">
                         <i class="fa fa-pencil"></i> <span>Edit</span>
                        </button>
                        </a>
                    </td>
                     <td >
                     <button name="edit" class="btn btn-default btn-sm"  data-toggle="modal" data-target="#modal-default"  onclick="editFaq({{ $faq->id  }});">
                        edit
                     </button>
                         or
                     <button id="delete" class="btn btn-default btn-sm" onclick="deleteFaq({{ $faq->id }})";>
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
      <div class=" clearfix pull-right" style="padding-right:8px; margin-top:52px;">
        {{$faqs->links()}}
       </div>
       </div>
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->

@endsection
