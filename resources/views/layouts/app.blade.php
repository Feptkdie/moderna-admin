<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    @yield("javascript")
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url("/home") }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            @can("users-list")
                                <li><a class="nav-link" href="{{ route("users.index") }}">Users</a></li>                        
                            @endcan
                            
                            <!-- @if(auth()->user()->can("note-categories-list") || auth()->user()->can("note-list"))
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        SOS
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        @can("note-categories-list")
                                            <a class="dropdown-item" href="{{ route("note-categories.index") }}">Categories</a>
                                        @endcan 
                                        @can("infos-list")
                                            <a class="dropdown-item" href="{{ route("notes.index") }}">List</a>
                                        @endcan
                                    </div>
                                </li>
                            @endif -->

                            @if(auth()->user()->can("info-categories-list") || auth()->user()->can("infos-list"))
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Products
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        @can("info-categories-list")
                                            <a class="dropdown-item" href="{{ route("info-categories.index") }}">Categories</a>
                                        @endcan 
                                        @can("infos-list")
                                            <a class="dropdown-item" href="{{ route("infos.index") }}">List</a>
                                        @endcan
                                    </div>
                                </li>
                            @endif

                            <!-- @if(auth()->user()->can("company-categories-list") || auth()->user()->can("companies-list"))
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Companies
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        @can("company-categories-list")
                                            <a class="dropdown-item" href="{{ route("company-categories.index") }}">Categories</a>
                                        @endcan 
                                        @can("companies-list")
                                            <a class="dropdown-item" href="{{ route("companies.index") }}">List</a>
                                        @endcan
                                    </div>
                                </li>
                            @endif -->

                            <!-- @if(auth()->user()->can("car-categories-list") || auth()->user()->can("cars-list"))
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Cars
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        @can("car-categories-list")
                                            <a class="dropdown-item" href="{{ route("car-categories.index") }}">Categories</a>
                                        @endcan 
                                        @can("car-list")
                                            <a class="dropdown-item" href="{{ route("cars.index") }}">List</a>
                                        @endcan
                                    </div>
                                </li>
                            @endif -->
                            
                            {{-- @can("super-admin")
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Role
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        @can("roles-list")
                                            <a class="dropdown-item" href="{{ route("roles.index") }}">Roles</a>
                                        @endcan
                                        @can("permissions-list")
                                            <a class="dropdown-item" href="{{ route("permissions.index") }}">Permissions</a>
                                        @endcan
                                    </div>
                                </li>
                            @endcan --}}

                            <!-- @can("super-admin")
                                <li><a class="nav-link" href="{{ route("settings") }}">Settings</a></li>
                            @endcan -->
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->email }}
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
