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
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        <x-favicon/>
    </head>
    <body class="bg-light font-sans antialiased">
        {{ $slot }}
    </body>
</html>