<!DOCTYPE html>
<html lang={{ str_replace('_', '-', app()->getLocale()) }}>

<head>

    <meta charset="utf-8">

    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@lang('home.title')</title>

    <meta name="google" content="@lang('home.content')" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href='{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}' rel='stylesheet'>

    <link href='{{ asset('bower_components/font-awesome-5/css/all.min.css') }}' rel='stylesheet'>
    <link href='{{ asset('bower_components/font-awesome-5/css/fontawesome.min.css') }}' rel='stylesheet'>

    <script type='text/javascript' src='{{ asset('bower_components/jquery/dist/jquery.min.js') }}'></script>
    <script src="{{ asset('bower_components/pusher-js/dist/web/pusher.min.js') }}"></script>

    <script type='text/javascript' src='{{ asset('bower_components/font-awesome-5/js/fontawesome.min.js') }}'>
    </script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('css')
</head>

<body oncontextmenu='return false' class='snippet-body'>

    @include('user.layouts.header')

    @yield('content')

    @include('user.layouts.footer')

    <script src="{{ asset('bower_components/particles.js/particles.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type='text/javascript' src='{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}'></script>

    @stack('scripts')

    @yield('js')
</body>
