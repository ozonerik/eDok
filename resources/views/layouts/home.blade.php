<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="eDokumen(eDok) - SMK Negeri 1 Krangkeng">
    <meta name="author" content="Unit ICT SMKN 1 Krangkeng">
    <meta name="generator" content="eDokumen(eDok)">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/cover/">    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">  
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>   
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body class="d-flex h-100 text-center text-white bg-dark">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="mb-auto">
        <div>
        <img src="{{ asset('img/logo.svg') }}" alt="logo" class="w-25 float-md-start mb-0"/>
        <nav class="nav nav-masthead justify-content-center float-md-end">
            <a class="nav-link active" aria-current="page" href="/">Home</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ms-4 nav-link">Register</a>
                    @endif
                @endif
            @endif
        </nav>
        </div>
        </header>

        <main class="px-3">
        {{ $slot }}
        </main>

        <footer class="mt-auto text-white-50">
            <p>Copyright &copy; 2022 Unit ICT SMKN 1 Krangkeng<br>All Rights Reserved</p>
        </footer>
    </div>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>