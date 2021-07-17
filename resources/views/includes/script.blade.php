<script src="{{url('assets/administrator/plugins/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{url('assets/administrator/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Menu Plugin JavaScript -->
<script src="{{url('assets/administrator/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js')}}"></script>
<!--slimscroll JavaScript -->
<script src="{{url('assets/administrator/js/jquery.slimscroll.js')}}"></script>
<script src="{{url('assets/administrator/plugins/bower_components/waypoints/lib/jquery.waypoints.js')}}"></script>
<script src="{{url('assets/administrator/plugins/bower_components/counterup/jquery.counterup.min.js')}}"></script>

<!-- chartist chart -->
<script src="{{url('assets/administrator/plugins/bower_components/chartist-js/dist/chartist.min.js')}}"></script>
<script
    src="{{url('assets/administrator/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js')}}">
</script>
<script src="{{url('assets/administrator/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js')}}">
</script>
<!--Wave Effects -->
<script src="{{url('assets/administrator/js/waves.js')}}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{url('assets/administrator/js/custom.min.js')}}"></script>
<script src="{{asset('assets/general_assets/utility.js')}}"></script>

@yield('other_scripts')
@if (Auth::guard('admin')->check() && Request::is('admin/*'))
<script src="{{url('assets/general_assets/logout.js')}}"></script>
@elseif(Auth::guard('staff')->check() && Request::is('staff/*') )
<script src="{{url('assets/administrator/js/staff/logout.js')}}"></script>
@endif
