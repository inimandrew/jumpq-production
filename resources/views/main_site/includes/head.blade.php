<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags-->
    <!-- Title-->
    @if (Request::is('/'))
    <title>{{config('app.name')}}</title>
    @else
    <?php $show_title = empty($title) ? "Error Page" : $title; ?>
    <title>{{config('app.name')}} - {{$show_title}}</title>
    @endif
    @if (Auth::check())
    <meta name="api_token" content="{{Auth::user()->api_token}}">
    @endif
    <!-- Favicon-->
    <link rel="icon" href="img/core-img/favicon.ico">
    <!-- Style CSS-->
    <link rel="stylesheet" href="{{asset('assets/main/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/main/css/default/classy-nav.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/main/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/main/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('assets/main/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/main/css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/main/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('assets/main/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/main/css/default/icofont.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/main/css/style.css')}}">
    <meta name="base_url" content="{{url('/')}}">
    @if (Auth::guard('user')->check())
    <meta name="api_token" content="{{Auth::guard('user')->user()->api_token}}">
    @endif
    <style>
        .lists{
            list-style: disc !important;
        }

        .important{
            color: #747794;
        }
    </style>
    @yield('other_styles')
</head>
