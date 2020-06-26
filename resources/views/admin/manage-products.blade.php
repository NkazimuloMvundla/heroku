@extends('admin.layout.admin')
@section('title' , 'Manage-Products')

@section('content')
<style nonce="{{ csp_nonce() }}">
span.message{font-size:16px;}
div.box-tools{display: none;}
div.mailbox-messages{padding: 20px;}
td.checkbox{width:10%;}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Manage Products</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">manage products</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
               <!-- /.col -->
        <div >
             <!-- /.col -->

        <div class="col-md-12">
            <span class="message text-center label label-success"></span>

           <div class="box box-primary">

               <div class="box-tools pull-right">
                 <div class="has-feedback">
                   <input type="text" class="form-control input-sm" placeholder="Search Mail">
                   <span class="glyphicon glyphicon-search form-control-feedback"></span>
                 </div>
               </div>
               <!-- /.box-tools -->

             <!-- /.box-header -->
             <div class="">
               <div class="table-responsive mailbox-messages">
                     <div class="">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                   <th>ID</th>
                   <th>Product Name</th>
                   <th>Status</th>
                   <th>Date added</th>
                   <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
               @forelse( $products as $product )
                <?php $status = $product->pd_approval_status ;?>
                <?php
                 if( $product->pd_approval_status == 1 )
                     $status = 'Approved ';
                 elseif($product->pd_approval_status == 2)
                     $status = 'Suspended ';
                 else
                     $status = 'Pending Approval';

                 ?>
                   <tr>
                     <td class="checkbox">
                        <input type="checkbox" id="{{ $product->pd_id }}" name="pd_id[]">
                    </td>
                     <td>{{ $product->pd_name }}</td>

                     <td>
                        @if($product->pd_approval_status == 0)
                        <span class="label label-warning">{{ $status }}</span>
                        @endif
                        @if($product->pd_approval_status == 1)
                         <span class="label label-success">{{ $status }}</span>
                         @endif
                         @if($product->pd_approval_status == 2)
                         <span class="label label-danger">{{ $status }}</span>
                         @endif

                     </td>
                     <td >{{ $product->created_at }}</td>
                    <td >
                      <?php  $encoded_product_id = base64_encode( $product->pd_id) ;?>
                    <a href="/u/product/{{ $encoded_product_id }}/edit">
                    <button name="edit" class="btn btn-default btn-sm">
                     <i class="fa fa-pencil"></i> <span>Edit</span>
                    </button>
                    </a>
                    or

                    <button id="sendID" data-id="{{  $product->pd_id }}" class="btn btn-default btn-sm sendID"><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all"></i> Delete</button>
                    @empty
                    <td>You haven't added any product as yet</td>
                    </tr>
                   @endforelse
                    </tbody>

                </table>
              </div>

               </div>
               <!-- /.mail-box-messages -->
             </div>
             <!-- /.box-body -->
             @if(!empty($product))
             <div class="box-footer no-padding">
               <div class="mailbox-controls">
                 <!-- Check all button -->
                 <button type="button" class="btn btn-default btn-sm checkbox-toggle"  ><i class="fa fa-square-o"></i>
                 </button>
                  <div class="btn-group">
                  <button id="DeleteAll" class="btn btn-default btn-sm deleteAll" name="DeleteAll">
                 <i class="fa fa-trash-o delete-all" data-toggle="tooltip" title="Delete all"></i> Delete all</button>
                 </div>
             </div>
           </div>
           <!-- /. box -->
           @endif
         </div>


       </div>

        </div>

        </div>
        </section>

</div>

<script nonce="{{ csp_nonce() }}">
 $(document).ready(function() {
    $(".sendID").on("click", function() {
        var id = $(this).data("id");
         sendId(id);
    });

     $(".deleteAll").on("click", function() {
        checkedAll();
    });
    $(".delete-all").on("click", function() {
       return deleteAll();
    });
});
</script>
@endsection
