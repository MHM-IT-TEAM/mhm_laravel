<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MHM Inventory System') }}</title>
    <!-- Fonts -->
    <!-- Styles -->
    <link rel="stylesheet" href="{{public_path('css/app.css')}}" />
    <style type="text/css">
        header{
            display:flex;
            flex-direction: row;
        }
        .firma-title {
            text-align: left;
            width: 55%;
            line-height: 0.95;
            color:#00537f;
        }
        #logo {
            width: 40%;
            max-height: 90px;
            margin-top: 10px;
            position: absolute;
            left: 400px;
        }
        /*body{*/
        /*    transform: rotate(15deg);*/
        /*}*/
    </style>
    @yield('custom_style')
</head>

<body class="antialiased">
    <header>
        <div class="firma-title">
            <h5>ONG MOBILE HILFE MADAGASKAR</h5>
            Lot 53 Ambovo Ambohidratrimo<br>
            hock@mobile-hilfe-madagaskar.de<br>
            www.mobile-hilfe-madagaskar.de<br>
            NIF: 3000676027  STAT: 94951 11 2011 0 07043<br>
            Tel: 033 84 573 90
        </div>
        <div class="logo-container">
{{--            <img id="logo" src="{{public_path('storage/assets/media/system/images/header.jpg')}}" />--}}
        </div>
    </header>
    <div>
        @yield('content')
    </div>
    <script src="{{public_path("js/app.js")}}" type="text/javascript"></script>
</body>

</html>
