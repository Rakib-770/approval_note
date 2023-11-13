<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Approval Note</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- styles --}}
    <link href="{{ asset('css/mystyle.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="css/mystyle.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @if (Auth::check())
                    <a class="navbar-brand" href="{{ url('/home') }}">Dashboard
                        
                    </a>
                @endif


                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @if (Auth::check())
                        <ul class="navbar-nav me-auto">
                            <a class="navbar-brand ms-2 my-nav-style" href="{{ url('/sent-request') }}">Sent Items
                            </a>
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Received
                                    Items</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" href="{{ url('/received-request') }}">Approval Request</a>
                                    <a class="dropdown-item" href="{{ url('/received-bill-request') }}">Bill Review and
                                        Approval</a>
                                </div>
                            </div>
                        </ul>
                    @endif



                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if (Auth::user()->role == 'admin')
                                        <a class="dropdown-item" href="{{ route('user-management') }}">
                                            {{ __('Users') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('company-management') }}">
                                            {{ __('Companies') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('department-management') }}">
                                            {{ __('Departments') }}
                                        </a>
                                    @endif

                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        {{ __('My Profile') }}
                                    </a>
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
