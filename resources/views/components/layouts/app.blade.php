<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>{{ config('app.name') }} | Bastiaan Steinmeier</title>
        <meta name="description" content="Personal website of Bastiaan Steinmeier" />
        <meta name="author" content="Bastiaan Steinmeier" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-gray-900 font-sans text-white/50 antialiased">
        <x-layouts.header />
            {{ $slot }}
        <x-layouts.footer />
    </body>
</html>
