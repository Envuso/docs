@extends('v1.layout.app')

@section('content')

<x-container>

    <x-title>
        Why build yet another framework...?
    </x-title>

    <x-text>
        I've been trying a few different frameworks and putting things together of our own... it's never how you want it
        to be. I don't think this will be the perfect
        solution for everyone neither.
        <br />
        <br />
        I really like how Laravel and NestJS work and how you build with them. It inspired me to create something of my
        own. I originally created a lot of this for a
        hackathon project, but it was actually decent.
    </x-text>

    <x-title>
        Installation
    </x-title>

    <x-code lang="sh" whitespace="            ">
        npm install @envuso/framework
        yarn add @envuso/framework
    </x-code>


    <x-title>
        Directory Structure
    </x-title>

    <x-text>
        As you can see, you don't start completely from scratch, there is a few
        classes that the framework needs, but this means you're also able to
        customise quite a few things to your liking.
    </x-text>

    <x-directory-structure />

</x-container>

@endsection
