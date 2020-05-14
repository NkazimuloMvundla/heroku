<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" >
  <title>@yield('title','Admin Panel')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" type="text/css" href="{{ asset('pub/bootstrap-3.3.7/css/bootstrap.min.css') }}">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('u/bower_components/font-awesome/css/font-awesome.min.css' ) }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('u/bower_components/Ionicons/css/ionicons.min.css' ) }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('u/dist/css/AdminLTE.min.css' ) }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('u/dist/css/skins/_all-skins.min.css' ) }}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{asset('u/bower_components/morris.js/morris.css' ) }}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{asset('u/bower_components/jvectormap/jquery-jvectormap.css' ) }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{asset('u/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css' ) }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('u/bower_components/bootstrap-daterangepicker/daterangepicker.css' ) }}">

  <!-- DataTables -->
  <link rel="stylesheet" type="text/css" href="{{ asset('u/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

  <!-- bootstrap wysihtml5 - text editor -->

  <link rel="stylesheet" href=" {{asset("u/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" )}}">

  <link rel="stylesheet" href="{{asset('u/dropzone-master/dist/dropzone.css') }}">

  <link rel="stylesheet" href="{{ asset('u/plugins/iCheck/flat/blue.css') }}">
  <link rel="stylesheet" href="{{ asset('u/plugins/iCheck/flat/blue.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('pub/js/jquery-ui/themes/hot-sneaks/jquery-ui.css') }}">

    <!--screen -css-->
 <link rel="stylesheet" href="{{asset('u/validate/demo/css/screen.css' ) }}">
 <!--Jquery--->
 <script src="{{ asset('u/bower_components/jquery/dist/jquery.min.js') }}"></script>
 <script src="{{ asset('u/dropzone-master/dist/dropzone.js') }}"></script>


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
<body class="skin-black-light sidebar-mini">
<div class="wrapper">

 @include('admin.layout.header')
  <!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
@include('admin.layout.sidebar')
<!-- /.sidebar -->
</aside>
  <!-- Content Wrapper. Contains page content -->
 <div class="yield-content">
  @yield('content')
</div>

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2016 Southbulk.com</strong> All rights
    reserved.
  </footer>


  </div>
<!-- ./wrapper -->

    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('u/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{asset("pub/bootstrap-3.3.7/js/bootstrap.min.js")}}"></script>

    <!--profile validate -->
    <script src="{{ asset('u/validate/dist/jquery.validate.min.js') }}"></script>
    <!--js func -->
    <script src="{{ asset('u/js/uu/inbox.js') }}"></script>
     <!--js func -->
    <script src="{{ asset('u/js/product/add.js') }}"></script>
      <!--js func -->
    <script src="{{ asset('u/js/uu/favs/remove-favs.js') }}"></script>
        <!--js func -->
    <script src="{{ asset('u/js/product/manage.js') }}"></script>
          <!--js func -->
    <script src="{{ asset('u/js/functions.js') }}"></script>

    <script src="{{ asset('pub/js/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- DataTables -->
    <script src="/u/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/u/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- jQuery 3 -->
    <script>
    $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script>



    $(function () {
      //Enable iCheck plugin for checkboxes
      //iCheck for checkbox and radio inputs
      $('.mailbox-messages input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
      });

      //Enable check and uncheck all functionality
      $(".checkbox-toggle").click(function () {
        var clicks = $(this).data('clicks');
        if (clicks) {
          //Uncheck all checkboxes
          $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
          $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
        } else {
          //Check all checkboxes
          $(".mailbox-messages input[type='checkbox']").iCheck("check");
          $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
        }
        $(this).data("clicks", !clicks);
      });

      //Handle starring for glyphicon and font awesome
      $(".mailbox-star").click(function (e) {
        e.preventDefault();
        //detect type
        var $this = $(this).find("a > i");
        var glyph = $this.hasClass("glyphicon");
        var fa = $this.hasClass("fa");

        //Switch states
        if (glyph) {
          $this.toggleClass("glyphicon-star");
          $this.toggleClass("glyphicon-star-empty");
        }

        if (fa) {
          $this.toggleClass("fa-star");
          $this.toggleClass("fa-star-o");
        }
      });
    });
  </script>

  <!-- page script -->
  <script>
   $(function () {
    $('#example1').DataTable()

  })
  </script>

<!-- FastClick -->
<script src="{{ asset('u/bower_components/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('u/plugins/iCheck/icheck.min.js') }}"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset("u/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" )}}"></script>
<!-- Slimscroll -->
<script src="{{asset("u/bower_components/jquery-slimscroll/jquery.slimscroll.min.js" )}}"></script>

<!-- AdminLTE App -->
<script src="{{asset("u/dist/js/adminlte.min.js" )}}"></script>


</body>
</html>
