<!DOCTYPE html>
@include('main_site.includes.head')

<body>
    <!-- Preloader-->
    <div id="preloader">
        <div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div>
    </div>
    <!-- Header Area-->
    @include('main_site.includes.navbar')

    @if ($errors->count)
    @include('includes.error')
    @endif
    @yield('content')


    @include('main_site.includes.footer')
    <!-- Footer Area-->
    @include('main_site.includes.scripts')
</body>

</html>
