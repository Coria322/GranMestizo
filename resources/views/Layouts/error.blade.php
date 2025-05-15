<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>
    <!-- imagen -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Alegreya:wght@500&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open Sans:wght@400&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;600&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Josefin Sans:wght@600&display=swap" />
    @vite(['resources/css/errors.css'])
    <!-- Otros -->

    @yield('head')

</head>

<body
    <div class="container">
        <div class="err-panel">
            <div class="log-container">
                <div class="num">@yield('num1', '4')</div>
                <img class="logo-mex-1" alt="Logo" src="{{ asset('imgs/Logo mex.png') }}">
                <div class="num1">@yield('num2', '4')</div>
            </div>
            <b class="error">@yield('error', 'ERROR')</b>
            @yield('content')
            <button class="volver-btn" onclick="window.location.href='{{ url('/') }}'">Regresar...</button>
        </div>
    </div>
</body>

</html>