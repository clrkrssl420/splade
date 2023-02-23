<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SpringHive') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
        {{-- Font Awesome --}}
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        {{-- Icons --}}
        <link href="{{ URL::asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
        <link href="{{ URL::asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
        {{-- Main Argon CSS --}}
        <link href="{{ URL::asset('assets/css/argon-dashboard-tailwind.css?v=1.0.1') }}" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/js/app.js'])
        @spladeHead
    </head>
    <body class="m-0 font-sans text-base antialiased font-normal bg-slate-200">
        @splade
    </body>
</html>
