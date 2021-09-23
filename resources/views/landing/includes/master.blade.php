<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} - {{$title}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base_url" content="{{url('/')}}">
    <link rel="stylesheet" href="{{asset('assets/css/tailwind.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/svg-icon.css')}}">
    @if (Auth::guard('user')->check())
    <meta name="api_token" content="{{Auth::guard('user')->user()->api_token}}">
    @endif
</head>

<body>
    <div id="main" class="w-full h-full overflow-x-hidden bg-app-transparent">

        @include('landing.includes.header')
        @include('includes.newError')

        @yield('content')

        @include('landing.includes.footer')
    </div>

    <script src="{{asset('assets/main/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/script.js')}}"></script>
    <script src="{{asset('assets/general_assets/utility.js')}}"></script>
    @yield('scripts')
</body>

</html>