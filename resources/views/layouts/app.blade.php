<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <style>
    main {
    margin-right: 160px;
    padding: 0px 10px;
    }
    </style>

</head>
<body>

    <nav id="app" style="position: fixed;width: 100%;z-index: 2;
  " >
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark" >
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                  App Page
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <a class="navbar-brand" href="{{ url('profile',Auth::id()) }}">
                               My Account |
                            </a>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-left"  aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ route('settings') }}">
                                        {{ __('User Settings') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                    </ul>
                </div>
            </div>
        </nav>
    </nav>



    <div class="w3-sidebar w3-bar-block" style="width:15%;right:0;height: 100%; background: #42474f; color: white;top:52px;  z-index: 1;">

        <a  class="w3-bar-item w3-button" href="#home">Financial Information</a>
        <a  class="w3-bar-item w3-button" href="#news">News</a>
        <a  class="w3-bar-item w3-button" href="#contact">Contact</a>
        <a  class="w3-bar-item w3-button"href="{{Route('privateArea', Auth::id())}}">My Private Area</a>
        <a  class="w3-bar-item w3-button" href="{{ route('allUsers') }}">{{ __('Users List') }}</a>



    </div>

    @endguest

    </nav>
        <main class="py-4">
            <br>
            <br>
            @yield('content')
        </main>
    </div>
</body>
</html>
