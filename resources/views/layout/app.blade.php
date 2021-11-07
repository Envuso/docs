<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link id="canonical" rel="canonical" href="{{request()->url()}}">

    <link rel="icon" type="image/png" href="/assets/icon.png">

    <!-- Primary Meta Tags -->
    <title>Envuso - TS framework for building elegant backends</title>
    <meta name="title" content="Envuso - TS framework for building elegant backends">
    <meta name="description" content="A fully featured Node.js framework using MongoDB and Fastify, for building backend applications. ">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{request()->url()}}">
    <meta property="og:title" content="Envuso - TS framework for building elegant backends">
    <meta property="og:description" content="A fully featured Node.js framework using MongoDB and Fastify, for building backend applications. ">
    <meta property="og:image" content="/assets/meta-image.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{request()->url()}}">
    <meta property="twitter:title" content="Envuso - TS framework for building elegant backends">
    <meta property="twitter:description" content="A fully featured Node.js framework using MongoDB and Fastify, for building backend applications. ">
    <meta property="twitter:image" content="/assets/meta-image.png">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

</head>

<body class="antialiased min-h-screen bg-gray-900">

<x-mobile-menu-header />

<div class="body-wrapper">

    <x-sidebar.sidebar-menu />

    <div class="content" id="content-wrapper">
        @yield('content')

        <button
            id="scroll-to-top"
            title="Go to top"
            class="opacity-0 transition fixed right-6 bottom-6 bg-gray-800 hover:bg-gray-700 transition shadow-lg rounded-full p-2 z-60"
        >
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
            </svg>
        </button>
    </div>

</div>

<script src="https://unpkg.com/@popperjs/core@2.9.1/dist/umd/popper.min.js" charset="utf-8"></script>
@if(isset($activeGroup))
    <script>
        window.currentPage = {
            activeGroup    : @json($activeGroup),
            currentFullUrl : @json($currentFullUrl ?? null),
            pageUrl        : @json($pageUrl ?? null),
            path           : @json($path),
            title          : @json($title),
            url            : @json($url),
            view           : @json($view),
        };
        window.activeGroup = @json($activeGroup)
    </script>
@endif
<script src="{{mix('js/app.js')}}"></script>
</body>

</html>
