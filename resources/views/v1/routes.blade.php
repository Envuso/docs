@extends('v1.layout.app')

@section('content')

    <x-container>


        <x-header>Routes</x-header>
        <ul>
            <x-context>Where are they defined</x-context>
            <x-context>What methods can I use</x-context>
            <x-context>Accessing the request</x-context>
            <x-context>Accessing the response</x-context>
        </ul>

        <x-title>Where are they defined</x-title>
        <x-text>
            They are defined alongside your controller, you have two ways to
            register the structure of your route
        </x-text>


        <x-code whitespace="            ">
            {{--@formatter:off--}}
            @controller('/auth')
            export class AuthController extends Controller {

                @post('/login')
                async login() {}

            }
            {{--@formatter:on--}}
        </x-code>

        <div class="text">
            With AuthController, we define
            <x-code :inline="true">@controller('/auth')</x-code>
             <strong>/auth</strong> is this controllers prefix.
            <br>
            We then define <x-code :inline="true">@post('/login')</x-code> this makes this controller method available
            by sending a POST request to <strong>/auth/login</strong>
        </div>

        <x-title>What methods can I use</x-title>

        <div class="flex flex-col">

            <x-code>
                @get('/auth')
                @post('/auth')
                @put('/auth')
                @patch('/auth')
                //Delete is a tricky one... We wanted lowercase naming
                //on decorators, "delete" in ts/js is a reserved word
                //Pick your poison...
                @destroy('/auth')
                @remove('/auth')
                @delete_('/auth')

            </x-code>

        </div>



        <x-title>
           Accessing the request
        </x-title>
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

        <x-title>
            Accessing the response
        </x-title>

        <x-code whitespace="        ">
        {{--@formatter:off--}}


        response().badRequest('Something went wrong');
        response().notFound('Woopsie, 404');
        response().redirect('https://google.com');
        response().json({hello : 'world'});
        response().validationFailure({email : 'Invalid email.'});
        response().header('Location', 'https://google.com');
        response().setResponse(
            { message : 'Oh no!'},
            StatusCodes.INTERNAL_SERVER_ERROR
        ).send();

        // or... from a controller method

        return {
            hello : 'world!'
        };

        {{--@formatter:on--}}
        </x-code>

        <div class="text">
            And again, the same applies with response, the underlying fastify reply can be accessed via <x-code :inline="true">response().fastifyReply</x-code>
        </div>
    </x-container>



@endsection
