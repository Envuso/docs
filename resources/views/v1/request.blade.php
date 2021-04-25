@extends('v1.layout.app')

@section('content')

    <x-container>


        <x-header>Request</x-header>
        <ul>
            <x-context>Accessing the request</x-context>
        </ul>

        <x-title>
           Accessing the request
        </x-title>
        <x-text>
            I was so tired of adding the request/response to the controller method
            and then passing it through my code, it becomes gross, hopefully we agree.
        </x-text>

        <x-code whitespace="        ">
        {{--@formatter:off--}}
        import { request } from "@envuso/core/Routing";

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
