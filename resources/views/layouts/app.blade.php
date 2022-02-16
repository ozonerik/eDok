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
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        @livewireStyles
        <!-- datatables bootstrap5 -->
        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs5/responsive/css/responsive.bootstrap5.min.css') }}">
        @stack('css')
    </head>
    <body class="font-sans antialiased bg-light"> 
        @livewire('navigation-menu')
        <!-- Page Heading -->
        <header class="d-flex py-3 bg-white shadow-sm border-bottom">
            <div class="container">
                {{ $header }}
            </div>
        </header>

        <!-- Page Content -->
        <main class="container my-5">
            {{ $slot }}
        </main>

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        @livewireScripts
        <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
        <!-- datatables bootstrap5 -->
        <script src="{{ asset('plugins/datatables-bs5/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs5/responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs5/responsive/js/responsive.bootstrap5.min.js') }}"></script>
        <!-- sweetalert2 -->
        <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
        @stack('scripts')
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 5000,
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
    </body>
</html>
