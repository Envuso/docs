@extends('v1.layout.app')

@section('content')
    <x-container>

        <x-header>Controllers</x-header>
        <ul>
            <x-context>Controllers can be generated</x-context>
        </ul>


        <x-title>
            Controllers can be generated
        </x-title>
        <x-text>
            First of all, save yourself the hassle, controllers can be generated.
            <br>
            Here's what available:
        </x-text>

        <x-code whitespace="            ">
            # You do not need to specify "Controller".
            # "Login" will be generated as "LoginController"
            '{{config('docs.cli_access')}} make:controller Login'

            # Generate a controller with basic CRUD layout
            '{{config('docs.cli_access')}} make:controller Tasks --resource'

            # Generate a controller for basic CRUD with your model
            # NOTE: This does not generate a model for you.
            '{{config('docs.cli_access')}} make:controller Tasks --resource --model Task'
        </x-code>


    </x-container>
@endsection
