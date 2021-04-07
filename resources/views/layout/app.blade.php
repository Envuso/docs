<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

</head>
<body class=" antialiased min-h-screen bg-gray-900">


<div class="flex flex-row h-full min-h-screen relative">

    <div class="bg-gray-800 min-h-screen flex flex-col w-full sidebar">

        <div class="fixed w-full sidebar overflow-y-auto max-h-screen">
            <div class="py-6 flex items-center justify-center border-b border-gray-700">
                <p class="text-2xl tracking-wide text-blue-400 font-light uppercase block">
                    Envuso Docs
                </p>
            </div>

            <div class="px-6 py-5 ">

                <x-sidebar-item :route="route('overview.home')" text="Home" />

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
