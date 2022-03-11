<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @yield('style')
    </head>
    <body>
        <div id="app">
                @yield('content')

        </div>
    </body>
    @if (Auth::check())
        <script>
            window.auth = {!!json_encode([
                   'isLoggedin' => true,
                   'user' => Auth::user()
               ])!!}
        </script>
    @else
        <script>
            window.auth = {!!json_encode([
                    'isLoggedin' => false
                ])!!}
        </script>
    @endif
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</html>
<?php
