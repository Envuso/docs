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
    <!-- Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body class=" antialiased min-h-screen bg-gray-900">


    <div class="flex flex-row h-full min-h-screen relative">

        <div class="bg-gray-900  min-h-screen flex flex-col w-full sidebar">

            <div
                class="fixed w-full md:w-64 lg:w-64 md:sidebar lg:sidebar overflow-y-auto min-h-screen border-r-2 border-gray-800">
                <div
                    class="bg-gradient-to-t from-gray-900 to-gray-800  pt-6 px-4 flex items-center justify-center border-b border-gray-700">
                    {{--<p class="text-2xl tracking-wide text-blue-400 font-light uppercase block">
                    Envuso Docs
                </p>--}}
                    <img src="/assets/mid.png" />
                </div>
                <i id="menuIcon" class="material-icons ml-36 text-gray-300 visible md:invisible lg:invisible"
                    style="vertical-align: center; font-size: 64px;">menu</i>
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
    <script src="{{ asset('js/nav.js') }}"></script>

</body>

</html>
