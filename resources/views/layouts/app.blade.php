<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app" class="home-main-page">
        <nav class="navbar navbar-expand-md head justify-content-between">


                <div class="ml-5">
                <a class="navbar-brand float-left" href="{{ url('/').'/'.Config::get('app.locale')}}">
                    @lang('interface.home')
                </a>
                <a class="nav-link float-left" href="{{  url(Config::get('app.locale').'/file/') }}">
                    @lang('interface.review')
                </a>
                    @auth
                    <a class="nav-link float-left" href="{{  url(Config::get('app.locale').'/'.Auth::user()->name.'/files') }}">
                        @lang('interface.files')
                    </a>
                        @endauth
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse form-inline pr-5 " id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav">
                        <!-- Authentication Links -->
                        <div class="btn-group">
                            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{Config::get('app.locale')}}
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{url('setlocale/en')}}">English<img src="{{asset('flags/GB.png')}}" /></a>
                                <a class="dropdown-item" href="{{url('setlocale/ru')}}">Русский<img src="{{asset('flags/RU.png')}}" /></a>

                            </div>
                        </div>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url(Config::get('app.locale').'/login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ url(Config::get('app.locale').'/register') }}">{{ __('Register') }}</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{url(Config::get('app.locale').'/profile') }}">
                                        @lang('interface.Cabinet')
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        @lang('interface.logout')
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest

                    </ul>

                </div>

        </nav>

        <main class="py-4" id="dropArea">
            @yield('content')

