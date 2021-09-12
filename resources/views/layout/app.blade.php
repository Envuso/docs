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

    <div class="content">
        @yield('content')
    </div>

</div>

<script src="https://unpkg.com/@popperjs/core@2.9.1/dist/umd/popper.min.js" charset="utf-8"></script>
@if(isset($activeGroup))
    <script>
        window.activeGroup = @json($activeGroup)
    </script>
@endif
<script src="{{mix('js/app.js')}}"></script>
</body>

</html>
