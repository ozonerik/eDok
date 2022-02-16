<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="eDokumen(eDok) - SMK Negeri 1 Krangkeng">
        <meta name="author" content="Unit ICT SMKN 1 Krangkeng">
        <meta name="generator" content="eDokumen(eDok)">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('home/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('home/css/simple-line-icons.min.css')}}">
        <link rel="stylesheet" href="{{asset('home/css/baguetteBox.min.css')}}">
        <link rel="stylesheet" href="{{asset('home/css/vanilla-zoom.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('home/css/ionicons.min.css') }}">   
        @stack('css')
    </head>
    <body class="font-sans antialiased">
        <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
            <div class="container">
                <div class="navbar-brand logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/logo.svg') }}" alt="logo" class="w-50"/>
                    </a>
                </div>
                <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1">
                    <span class="visually-hidden">Toggle navigation</span>
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link @if(request()->routeIs('home')) active @endif" href="{{ route('home') }}">Home</a></li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item"><a class="nav-link @if(request()->routeIs('dashboard')) active @endif" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="post" id="logout">
                                @csrf
                                    <a class="nav-link" href="#" onclick="document.getElementById('logout').submit()">
                                        <i class="fas fa-sign-out-alt"></i> Sign Out
                                    </a>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link @if(request()->routeIs('login')) active @endif" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i> Sign In
                                </a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link @if(request()->routeIs('register')) active @endif" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus"></i>Register
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endif
                    </ul>
                </div>
            </div>
        </nav>
        <main class="page landing-page">
        {{ $slot }}
        </main>
        <footer class="page-footer dark">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h5>eDokumen (eDok)</h5>
                        <p class="text-wrap text-light">eDokumen (eDok) adalah suatu web app yang dibangun oleh Tim ICT SMKN 1 Krangkeng untuk kebutuhan penyimpanan dan sharing file digital dari para stakeholder yang ada di SMKN 1 Krangkeng</p>  
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <p>Copyright &copy; 2022 Unit ICT SMKN 1 Krangkeng<br>All Rights Reserved</p>
            </div>
        </footer>
        <!-- Scripts -->
        <script src="{{ asset('home/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('home/js/baguetteBox.min.js') }}"></script>
        <script src="{{ asset('home/js/vanilla-zoom.js') }}"></script>
        <script src="{{ asset('home/js/theme.js')}} "></script>
        @stack('scripts')
    </body>
</html>
