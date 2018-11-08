<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Offline Package</title>

    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Offline Package
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a href="#" id="change_language" target="_self"
                           class="nav-link"
                           @click.prevent="changeLocale"
                        >
                            @{{currentLanguageLabel}}
                        </a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <b-navbar>

                                <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

                                <b-collapse is-nav id="nav_collapse">
                                    <!-- Right aligned nav items -->
                                    <b-navbar-nav class="ml-auto">

                                        <b-nav-item-dropdown right>
                                            <!-- Using button-content slot -->
                                            <template slot="button-content">
                                                <em>{{Auth::user()->name}}</em>
                                            </template>

                                            <b-dropdown-item href="/home"

                                            > New Request

                                            </b-dropdown-item>
                                            
                                            @if(Auth::user()->role->name=="operator")
                                                <b-dropdown-item href="/requests/all"

                                                > All Requests

                                                </b-dropdown-item>

                                                <b-dropdown-item href="/requests/new"

                                                > New Requests

                                                </b-dropdown-item>

                                                <b-dropdown-item href="/requests/received"

                                                > Received Requests

                                                </b-dropdown-item>
                                                <b-dropdown-item href="/requests/workingon"

                                                > Working Requests

                                                </b-dropdown-item>

                                                <b-dropdown-item href="/requests/done"

                                                > Done Requests

                                                </b-dropdown-item>

                                                <b-dropdown-item href="/requests/failed"

                                                > Failed Requests

                                                </b-dropdown-item>
                                                @else
                                                <b-dropdown-item href="/requests/me"

                                                > My Requests

                                                </b-dropdown-item>
                                            @endif

                                            <b-dropdown-item @click="logoutUser();"

                                            > Signout

                                            </b-dropdown-item>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                  style="display: none;">
                                                @csrf
                                            </form>

                                        </b-nav-item-dropdown>
                                    </b-navbar-nav>

                                </b-collapse>
                            </b-navbar>

                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
