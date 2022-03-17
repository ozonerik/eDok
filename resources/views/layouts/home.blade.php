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
        <link rel="stylesheet" href="{{asset('home/css/baguetteBox.min.css')}}">
        <link rel="stylesheet" href="{{asset('home/css/vanilla-zoom.min.css')}}">
        @livewireStyles
        @stack('css')
        <x-favicon/>
        <style>
            .overlay {
            position: fixed; /* Sit on top of the page content */
            width: 100%; /* Full width (cover the whole page) */
            height: 100%; /* Full height (cover the whole page) */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5); /* Black background with opacity */
            z-index: 5000; /* Specify a stack order in case you're using a different order for other elements */
            cursor: pointer; /* Add a pointer on hover */
            }
        </style>
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
        <script src="{{ asset('home/js/theme.js')}}"></script>
        <script src="{{ asset('home/js/fontawesome6.js')}}"></script>
        <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
        @livewireScripts
        <!-- sweetalert2 -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 2000,
                timerProgressBar:true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            window.addEventListener('alert',({detail:{type,message}})=>{
                Toast.fire({
                    icon:type,
                    title:message
                })
            })
        </script>
        @stack('scripts')
    </body>
</html>
