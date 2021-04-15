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

            <div class="px-6 py-5">

                <x-sidebar-item :route="route('overview.setup')" text="Getting Started" />

                <x-sidebar-item-group title="Prologue">
                    <x-sidebar-group-item :route="route('overview.release-notes')" text="Release Notes" />
                    <x-sidebar-group-item :route="route('overview.contribute')" text="Contribute" />
                </x-sidebar-item-group>

                <x-sidebar-item-group title="HTTP">
                    <x-sidebar-group-item :route="route('overview.routes')" text="Routes" />
                    <x-sidebar-group-item :route="route('overview.request')" text="Request" />
                    <x-sidebar-group-item :route="route('overview.response')" text="Response" />
                    <x-sidebar-group-item :route="route('overview.controllers')" text="Controllers" />
                    <x-sidebar-group-item :route="route('overview.middleware')" text="Middleware" />
                </x-sidebar-item-group>

                <x-sidebar-item-group title="Database">
                    <x-sidebar-group-item :route="route('overview.models')" text="Models" />
                    <x-sidebar-group-item :route="route('overview.query-builder')" text="Query builder" />
                </x-sidebar-item-group>

                <x-sidebar-item-group title="Database">
                    <x-sidebar-group-item :route="route('overview.authentication')" text="Authentication" />
                </x-sidebar-item-group>

                <x-sidebar-item :route="route('overview.cli')" text="CLI" />
                <x-sidebar-item :route="route('overview.decorators')" text="Decorators" />

            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>

    </div>

    <script src="{{mix('js/app.js')}}"></script>

</body>

</html>
