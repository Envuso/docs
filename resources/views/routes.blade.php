@extends('layout.app')

@section('content')

    <x-container>


        <x-title>Routes</x-title>

        <x-subtitle>Where are they defined?</x-subtitle>
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

        <x-subtitle>What methods can I use?</x-subtitle>

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

        <x-subtitle>
            Accessing the response
        </x-subtitle>

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
