<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="bastiaandev">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="theme-color" content="#1c1917" />

        {!! seo() !!}

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-stone-900 font-sans text-stone-400 antialiased">
        <a
            href="#main-content"
            class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-md focus:bg-accent-500 focus:px-4 focus:py-2 focus:text-sm focus:font-medium focus:text-accent-950"
        >
            Skip to content
        </a>
        <x-layouts.header />
        {{ $slot }}
        <x-layouts.footer />
    </body>
</html>
