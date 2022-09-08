<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        @media print{
            body{
                background-color: white;
                /*border:green solid 1px;*/
            }
            * {
                box-sizing: border-box;
                -moz-box-sizing: border-box;
            }
        }
    </style>
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
</head>
<body>
<div id="app">
        @yield('content')
    @auth
        <auto_logout/>
    @endauth

</div>
</body>
</html>

