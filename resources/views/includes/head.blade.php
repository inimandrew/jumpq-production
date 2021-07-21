<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('administrator/plugins/images/favicon.png')}}">
    <title>{{config('app.name')}} {{$title}}</title>
    <meta name="base_url" content="{{url('/')}}">
    @if (Auth::guard('admin')->check() && Request::is('admin/*'))
    <meta name="api_token" content="{{Auth::guard('admin')->user()->api_token}}">
    @elseif(Auth::guard('staff')->check() && Request::is('staff/*') )
    <meta name="api_token" content="{{Auth::guard('staff')->user()->api_token}}">
    @endif

    <!-- Bootstrap Core CSS -->
    <link href="{{url('assets/administrator/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{url('assets/administrator/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css')}}"
        rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{url('assets/administrator/css/animate.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{url('assets/administrator/css/style.css')}}" rel="stylesheet">
    <link href="{{url('assets/administrator/plugins/bower_components/chartist-js/dist/chartist.min.css')}}"
        rel="stylesheet">
    <link
        href="{{url('assets/administrator/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css')}}"
        rel="stylesheet">
    <!-- color CSS -->
    <link href="{{url('assets/administrator/css/colors/default.css')}}" id="theme" rel="stylesheet">
    <link href="{{url('assets/general_assets/utility.css')}}" rel="stylesheet">
    <style>
        .show {
            display: inline;
        }

        .hide {
            display: none;
        }

        .blink-bg {
            animation: blinkingBackground 2s infinite;
        }

        .good-blink{
            animation: goodBlink 2s infinite;
        }

        @keyframes goodBlink {
            0% {
                background-color: #5eff00;
            }

            25% {
                background-color: #5eff00;
            }

            50% {
                background-color: #5eff00;
            }

            75% {
                background-color: #5eff00;
            }

            100% {
                background-color: #5eff00;
            }
        }


        @keyframes blinkingBackground {
            0% {
                background-color: #ef0a1a;
            }

            25% {
                background-color: #ef0a1a;
            }

            50% {
                background-color: #ef0a1a;
            }

            75% {
                background-color: #ef0a1a;
            }

            100% {
                background-color: #ef0a1a;
            }
        }
    </style>
</head>
