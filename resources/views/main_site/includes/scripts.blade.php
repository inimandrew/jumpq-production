<!-- jQuery (Necessary for All JavaScript Plugins)-->
<script src="{{asset('assets/main/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/main/js/popper.min.js')}}"></script>
<script src="{{asset('assets/main/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/main/js/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/main/js/default/classy-nav.min.js')}}"></script>
<script src="{{asset('assets/main/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/main/js/default/scrollup.js')}}"></script>
<script src="{{asset('assets/main/js/default/sticky.js')}}"></script>
<script src="{{asset('assets/main/js/waypoints.min.js')}}"></script>
<script src="{{asset('assets/main/js/jquery.countdown.min.js')}}"></script>
<script src="{{asset('assets/main/js/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/main/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('assets/main/js/jarallax.min.js')}}"></script>
<script src="{{asset('assets/main/js/jarallax-video.min.js')}}"></script>
<script src="{{asset('assets/main/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('assets/main/js/wow.min.js')}}"></script>
<script src="{{asset('assets/main/js/default/active.js')}}"></script>
<script src="{{asset('assets/general_assets/utility.js')}}"></script>
@if (Auth::guard('user')->check() && Request::is('user*'))
<script src="{{asset('assets/users/js/logout.js')}}"></script>
@endif
@if (!Request::is('/'))
<script src="{{asset('assets/main/js/branches.js')}}"></script>
@endif

@yield('other_scripts')
