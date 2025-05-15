<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config("app.name") }}</title>
        <!-- imagen -->
         <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Alegreya:wght@500&display=swap" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open Sans:wght@400&display=swap" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;600&display=swap" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Josefin Sans:wght@600&display=swap" />
        @vite(['resources/css/app.css', 'resources/js/app.js']);
        <!-- <link rel="stylesheet" href="{{ asset('css/global.css') }}"> -->
        <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
        <!-- Otros -->

        @yield('head')
         
    </head>
<body>
    @yield('header')
    @yield('nav')
    @yield('content')
    @yield('scripts')
    @yield('footer')
</body>
</html>