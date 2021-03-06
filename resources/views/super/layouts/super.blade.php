<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" >
  <title>@yield('title','Super Panel')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!--remove this in production-->
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <meta name="robots" content="noindex, nofollow" />

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

  <!-- DataTables -->
  <link rel="stylesheet" type="text/css" href="{{ asset('u/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

  <link rel="stylesheet" href="{{asset('u/dropzone-master/dist/dropzone.css') }}">

  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('u/plugins/iCheck/flat/blue.css') }}">
  <link rel="stylesheet" href="{{ asset('u/plugins/iCheck/flat/blue.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('pub/js/jquery-ui/themes/hot-sneaks/jquery-ui.css') }}">
  <!--Jquery--->
 <script nonce="{{ csp_nonce() }}"  src="{{ asset('pub/js/jquery-3.5.1.min.js') }}"></script>
 <script nonce="{{ csp_nonce() }}"  src="{{ asset('u/dropzone-master/dist/dropzone.js') }}"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<!-- /TinyMCE -->
</head>
<body class="hold-transition skin-black-light sidebar-mini">
<div class="wrapper">

 @include('super.layouts.main-header')
  <!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
@include('super.layouts.sidebar');
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

<script nonce="{{ csp_nonce() }}">



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



<!-- jQuery 3 -->
<script nonce="{{ csp_nonce() }}" src="{{asset("u/bower_components/jquery/dist/jquery.min.js")}}"></script>
<!-- jQuery UI 1.11.4 -->
<script nonce="{{ csp_nonce() }}"  src="{{asset("u/bower_components/jquery-ui/jquery-ui.min.js")}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script nonce="{{ csp_nonce() }}">
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->

<script nonce="{{ csp_nonce() }}"  src="{{asset("pub/bootstrap-3.3.7/js/bootstrap.min.js")}}"></script>


 <!-- DataTables -->
    <script nonce="{{ csp_nonce() }}"  src="/u/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script nonce="{{ csp_nonce() }}"  src="/u/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
       <!-- page script -->
 <script nonce="{{ csp_nonce() }}">
   $(function () {
    $('#example1').DataTable()

  })
  </script>


<!-- FastClick -->
<script nonce="{{ csp_nonce() }}"  src="{{ asset('u/bower_components/fastclick/lib/fastclick.js') }}"></script>
<script  nonce="{{ csp_nonce() }}" src="{{ asset('u/plugins/iCheck/icheck.min.js') }}"></script>

<!-- Slimscroll -->
<script nonce="{{ csp_nonce() }}"  src="{{asset("u/bower_components/jquery-slimscroll/jquery.slimscroll.min.js" )}}"></script>
<!-- FastClick -->
<script nonce="{{ csp_nonce() }}"  src="{{asset("u/bower_components/fastclick/lib/fastclick.js" )}}"></script>
<!-- AdminLTE App -->
<script nonce="{{ csp_nonce() }}"  src="{{asset("u/dist/js/adminlte.min.js" )}}"></script>

</body>
</html>
