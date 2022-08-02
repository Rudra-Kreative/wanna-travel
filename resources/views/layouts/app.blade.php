<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @include('layouts.css.common-css')
    </head>
    <body>
        @include('layouts.user.header')
            {{ $slot }}
        @include('layouts.user.footer')
        @include('layouts.js.common-js')
    </body>
</html>
