@extends('layout.app')

@section('content')

    <x-container>


        <x-title>Request</x-title>

        <x-subtitle>
           Accessing the request
        </x-subtitle>
        <x-text>
            I was so tired of adding the request/response to the controller method
            and then passing it through my code, it becomes gross, hopefully we agree.
        </x-text>

        <x-code whitespace="        ">
        {{--@formatter:off--}}
        import { request } from "@Core/Helpers";

        @put('/user/avatar')
        async uploadAvatar() {
            const file = request().file('avatar')
        }
        {{--@formatter:on--}}
        </x-code>

        <div class="text">
            At the moment it's fairly basic, but you can access the underlying
            fastify request with <x-code :inline="true">request().fastifyRequest</x-code>
        </div>

    </x-container>



@endsection
