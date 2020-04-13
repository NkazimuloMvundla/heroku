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
<!-- jQuery 3 -->
<script src="{{asset("u/bower_components/jquery/dist/jquery.min.js")}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset("u/bower_components/jquery-ui/jquery-ui.min.js")}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset("u/bower_components/bootstrap/dist/js/bootstrap.min.js")}}"></script>
<!-- Morris.js charts -->
<script src="{{asset("u/bower_components/raphael/raphael.min.js")}}"></script>
<script src="{{asset("u/bower_components/morris.js/morris.min.js")}}"></script>
<!-- Sparkline -->
<script src="{{asset("u/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js")}}"></script>
<!-- jvectormap -->
<script src="{{asset("u/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js")}}"></script>
<script src="{{asset("u/plugins/jvectormap/jquery-jvectormap-world-mill-en.js")}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset("u/bower_components/jquery-knob/dist/jquery.knob.min.js")}}"></script>

<!-- FastClick -->
<script src="{{ asset('u/bower_components/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('u/plugins/iCheck/icheck.min.js') }}"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset("u/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" )}}"></script>
<!-- Slimscroll -->
<script src="{{asset("u/bower_components/jquery-slimscroll/jquery.slimscroll.min.js" )}}"></script>
<!-- FastClick -->
<script src="{{asset("u/bower_components/fastclick/lib/fastclick.js" )}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("u/dist/js/adminlte.min.js" )}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset("u/dist/js/pages/dashboard.js" )}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset("u/dist/js/demo.js" )}}"></script>
