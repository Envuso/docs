@extends('layout.app')

@section('content')
    <x-container>

        <x-title>Controllers</x-title>

        <x-subtitle>
            Controllers can be generated
        </x-subtitle>
        <x-text>
            First of all, save yourself the hassle, controllers can be generated.
            <br>
            Here's what available:
        </x-text>

        <x-code lang="sh" whitespace="            ">
            # You don't need to specify "Controller".
            # "Login" will be generated as "LoginController"
            {{config('docs.cli_access')}} make:controller Login

            # Generate a controller with basic CRUD layout
            {{config('docs.cli_access')}} make:controller Tasks --resource

            # Generate a controller for basic CRUD with your model
            # NOTE: This doesn't generate a model for you.
            {{config('docs.cli_access')}} make:controller Tasks --resource --model Task
        </x-code>


    </x-container>
@endsection
