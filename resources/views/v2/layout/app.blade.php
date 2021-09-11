<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>Envuso Framework</title>

    <link rel="icon" type="image/png" href="/assets/icon.png">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

</head>

<body class="antialiased min-h-screen bg-gray-900">


<x-mobile-menu-header />

<div class="body-wrapper">

    <div id="sideMenu" class="sidebar ">

        <x-sidebar-header />
        <x-version-control-v2 />
        <div class="px-6 py-5">

            <x-sidebar-item :route="route('v2.setup')" text="Getting Started" />

            <x-sidebar-item-group title="Prologue">
                <x-sidebar-group-item :route="route('v2.release-notes')" text="Release Notes" />
                <x-sidebar-group-item :route="route('v2.contribute')" text="Contribute" />
            </x-sidebar-item-group>

            <x-sidebar-item-group title="HTTP" class="dropdown-sidebar ">
                <x-sidebar-group-item :route="route('http.v2.routes')" text="Routes" />
                <x-sidebar-group-item :route="route('http.v2.request')" text="Request" />
                <x-sidebar-group-item :route="route('http.v2.response')" text="Response" />
                <x-sidebar-group-item :route="route('http.v2.controllers')" text="Controllers" />
                <x-sidebar-group-item :route="route('http.v2.middleware')" text="Middleware" />
            </x-sidebar-item-group>

            <x-sidebar-item-group title="Database">
                <x-sidebar-group-item :route="route('db.v2.models')" text="Models" />
                <x-sidebar-group-item :route="route('db.v2.query-builder')" text="Query builder" />
                <x-sidebar-group-item :route="route('db.v2.seeders')" text="Seeders" />
            </x-sidebar-item-group>

            <x-sidebar-item-group title="Auth">
                <x-sidebar-group-item :route="route('auth.v2.authentication')" text="Authentication" />
                <x-sidebar-group-item :route="route('auth.v2.policies')" text="Policies/Gates" />
            </x-sidebar-item-group>

            <x-sidebar-item-group title="Websockets">
                <x-sidebar-group-item :route="route('websockets.v2.server')" text="Server" />
                <x-sidebar-group-item :route="route('websockets.v2.client')" text="Client" />
            </x-sidebar-item-group>

            <x-sidebar-item-group title="Additional">
                <x-sidebar-group-item :route="route('additional.v2.cache')" text="Cache" />
                <x-sidebar-group-item :route="route('additional.v2.storage')" text="File Storage" />
                <x-sidebar-group-item :route="route('additional.v2.encryption-hashing')" text="Encryption/Hashing" />
                <x-sidebar-group-item :route="route('additional.v2.data-transfer-objects')" text="Data Transfer Objects" />
            </x-sidebar-item-group>

            <x-sidebar-item :route="route('v2.cli')" text="CLI" />
            <x-sidebar-item :route="route('v2.decorators')" text="Decorators" />

        </div>
    </div>

    <div class="content">

        @yield('content')

        <x-container>
            {{\App\Services\MarkdownView::parse($view_name)}}
        </x-container>

    </div>

</div>

<script src="https://unpkg.com/@popperjs/core@2.9.1/dist/umd/popper.min.js" charset="utf-8"></script>
<script src="{{mix('js/app.js')}}"></script>
</body>

</html>
