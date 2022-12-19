<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Task Assignment</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    {{--    <!-- Scripts -->--}}
    {{--    @vite(['resources/sass/app.scss', 'resources/js/app.js'])--}}

    {{--    <script src="{{ asset('js/dashboard/common.js') }}"></script>--}}

    {{--    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">--}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"
          integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/dashboard/common.js') }}"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    {{--        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">--}}
    {{--            <div class="container">--}}
    {{--                <a class="navbar-brand" href="{{ url('/') }}">--}}
    {{--                    {{ config('app.name', 'Task Management') }}--}}
    {{--                </a>--}}
    {{--                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">--}}
    {{--                    <span class="navbar-toggler-icon"></span>--}}
    {{--                </button>--}}

    {{--                <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
    {{--                    <!-- Left Side Of Navbar -->--}}
    {{--                    <ul class="navbar-nav me-auto">--}}

    {{--                    </ul>--}}

    {{--                    <!-- Right Side Of Navbar -->--}}
    {{--                    <ul class="navbar-nav ms-auto">--}}
    {{--                        <!-- Authentication Links -->--}}
    {{--                        @guest--}}
    {{--                            @if (Route::has('login'))--}}
    {{--                                <li class="nav-item">--}}
    {{--                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
    {{--                                </li>--}}
    {{--                            @endif--}}

    {{--                            @if (Route::has('register'))--}}
    {{--                                <li class="nav-item">--}}
    {{--                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
    {{--                                </li>--}}
    {{--                            @endif--}}
    {{--                        @else--}}
    {{--                            <li class="nav-item dropdown">--}}
    {{--                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
    {{--                                    {{ Auth::user()->name }}--}}
    {{--                                </a>--}}

    {{--                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">--}}
    {{--                                    <a class="dropdown-item" href="{{ route('logout') }}"--}}
    {{--                                       onclick="event.preventDefault();--}}
    {{--                                                     document.getElementById('logout-form').submit();">--}}
    {{--                                        {{ __('Logout') }}--}}
    {{--                                    </a>--}}

    {{--                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
    {{--                                        @csrf--}}
    {{--                                    </form>--}}
    {{--                                </div>--}}
    {{--                            </li>--}}
    {{--                        @endguest--}}
    {{--                    </ul>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </nav>--}}

    {{--    <nav class="navbar navbar-expand-lg bg-light">--}}
    {{--        <div class="container-fluid">--}}
    {{--            <a class="navbar-brand" href="#">Task Assignment</a>--}}
    {{--            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"--}}
    {{--                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">--}}
    {{--                <span class="navbar-toggler-icon"></span>--}}
    {{--            </button>--}}
    {{--            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">--}}
    {{--                <div class="navbar-nav">--}}
    {{--                    <a class="nav-link active " aria-current="page" href="#">Users</a>--}}
    {{--                    <a class="nav-link" href="#">Roles</a>--}}
    {{--                    <a class="nav-link" href="#">Categories</a>--}}
    {{--                    <a class="nav-link" href="#">Sub Categories</a>--}}
    {{--                    <a class="nav-link" href="#">Items</a>--}}

    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </nav>--}}

    @if(\Illuminate\Support\Facades\Auth::check())
        <nav class="navbar navbar-expand-lg bg-primary py-3">
            <div class="container-fluid">
                <h3>Task Assignment Project</h3>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo02"
                        aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 px-5 align-items-center">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.user.index') }}">Users</a>
                        </li>
                        |
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.permissions.index') }}">Permissions</a>
                        </li>
                        |
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.role.index') }}">Roles</a>
                        </li>
                        |
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.admin.index') }}">Admins</a>
                        </li>
                        |
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.category.index') }}">Categories</a>
                        </li>
                        |
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.sub.category.index') }}">Sub Categories</a>
                        </li>
                        |
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.item.index') }}">Items</a>
                        </li>
                    </ul>

                    <form class="d-flex" id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                    </form>
                </div>
            </div>
        </nav>
    @endif
    <main>
        @yield('content')
    </main>

</div>

@yield('scripts')

<script>
    @if(session('success') || session('fail'))
        @if (session('success'))
            successEvent(`{{ session()->get('success') }}`)
        @elseif(session('fail'))
            errorEvent(`{{ session()->get('fail') }}`)
        @endif
    @endif
</script>

</body>
</html>
