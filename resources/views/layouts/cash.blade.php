<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
{{--    <link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body{
            background-color: #34568B;
        }
        .panel{
            box-shadow: 5px 5px 10px 3px rgba(0,0,0,0.8);
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">MHM</a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class=" navbar-nav mr-auto">

                    <li  class="nav-item"><a href="{{route('cash_patient_list')}}" class="nav-link"><i class="glyphicon glyphicon-list-alt"></i> List of patient</a></li>

                    <li class="nav-item" ><a id="finance_invoice"  class="nav-link">Cash finance</a></li>


                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>

                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>

    @yield('content')
</div>
</body>
<!-- Scripts -->

<script src="{{ asset('js/app.js') }}" ></script>
<script>
    let cash= document.getElementById('finance_invoice')
    cash.addEventListener('click',()=>{
       fetch()
    })
    async function fetch(){
        let data= await axios.get('/api/cash/finance_rezept')
        let myWindow = window.open('', 'Patient System', 'height=400,width=600');
        myWindow.document.write(data.data)
        myWindow.focus()
        myWindow.print()
    }
</script>

@yield('script')

</html>


