<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>Envuso Framework</title>

    <link rel="icon" type="image/png" href="/assets/icon.png">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

</head>

<body class=" antialiased min-h-screen bg-gray-900">


<div class="flex flex-row h-full min-h-screen relative">

    <div class="bg-gray-900  min-h-screen flex flex-col w-full sidebar">

        <div
            class="fixed w-full md:w-64 lg:w-64 md:sidebar lg:sidebar overflow-y-auto min-h-screen border-r-2 border-gray-800">
            <div class="relative bg-gradient-to-t from-gray-900 to-gray-800  pt-6 px-4 flex items-center justify-center border-b border-gray-700">
                <i id="menuIcon" class="absolute z-10 left-4 top-4 p-2 text-gray-300 visible md:invisible lg:invisible">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </i>

                <img src="/assets/mid.png" />
            </div>


            <div id="sideMenu" class="px-6 py-5 hidden md:block lg:block">

                <x-sidebar-item :route="route('overview.setup')" text="Getting Started" />

                <x-sidebar-item-group title="Http">
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


    </div>

    <div class="w-full content">
        @yield('content')
    </div>

</div>

<script src="{{mix('js/app.js')}}"></script>

</body>

</html>
