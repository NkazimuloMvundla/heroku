@extends('admin.layout.admin')
@section('title' , 'Manage-Products')

@section('content')

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
            <span class="message text-center label label-success" style="font-size:16px;"></span>

           <div class="box box-primary">

               <div class="box-tools pull-right" style="display: none;">
                 <div class="has-feedback">
                   <input type="text" class="form-control input-sm" placeholder="Search Mail">
                   <span class="glyphicon glyphicon-search form-control-feedback"></span>
                 </div>
               </div>
               <!-- /.box-tools -->

             <!-- /.box-header -->
             <div class="">
               <div class="table-responsive mailbox-messages" style="padding: 20px;">
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
                     <td><input type="checkbox" id="{{ $product->pd_id }}" name="pd_id[]" value=""></td>
                     <td ><a href=""></a>{{ $product->pd_name }}</td>

                     <td >
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

                    <button id="sendID" class="btn btn-default btn-sm" onclick="sendId({{ $product->pd_id }})";><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all"></i> Delete</button>

                    @empty
                    <td class="">You haven't added any product as yet</td>
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
                  <button  class="btn btn-default btn-sm" name="DeleteAll" onclick="checkedAll();"  ><i class="fa fa-trash-o" data-toggle="tooltip" title="Delete all" onclick="return deleteAll();"></i> Delete</button>

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
@endsection
