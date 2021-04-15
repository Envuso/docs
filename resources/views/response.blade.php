@extends('layout.app')

@section('content')

    <x-container>

        <x-header>Response</x-header>
        <ul>
            <x-context>Accessing the response</x-context>
        </ul>

        <x-title>
            Accessing the response
        </x-title>

        <x-code whitespace="            ">
            {{--@formatter:off--}}


            response().badRequest('Something went wrong');
            response().notFound('Woopsie, 404');
            response().redirect('https://google.com');
            response().json({hello : 'world'});
            response().validationFailure({email : 'Invalid email.'});
            response().header('Location', 'https://google.com');
            response().setResponse(
                {message : 'Oh no!'},
                StatusCodes.INTERNAL_SERVER_ERROR
            ).send();

            // or... from a controller method

            return {
                hello : 'world!'
            };

            {{--@formatter:on--}}
        </x-code>

        <div class="text">
            And again, the same applies with response, the underlying fastify reply can be accessed via
            <x-code :inline="true">response().fastifyReply</x-code>
        </div>

    </x-container>



@endsection
