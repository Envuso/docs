@extends('v1.layout.app')

@section('content')

    <x-container>


        <x-header>Routes</x-header>
        <ul>
            <x-context>Where are they defined</x-context>
            <x-context>What methods can I use</x-context>
            <x-context>Accessing the request</x-context>
            <x-context>Accessing the response</x-context>
            <x-context>Controller Method Decorators</x-context>
        </ul>

        <x-title>Where are they defined</x-title>
        <x-text>
            They are defined alongside your controller, you have two ways to
            register the structure of your route
        </x-text>


        <x-code >
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
            <x-inline-code>@controller('/auth')</x-inline-code>
            <strong>/auth</strong> is this controllers prefix.
            <br>
            We then define
            <x-inline-code>@post('/login')</x-inline-code>
            this makes this controller method available
            by sending a POST request to <strong>/auth/login</strong>
        </div>

        <x-title>What methods can I use</x-title>

        <div class="flex flex-col">

            <x-code>
                {{--@formatter:off--}}
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
                {{--@formatter:on--}}
            </x-code>

        </div>


        <x-title>
            Accessing the request
        </x-title>
        <x-text>
            I was so tired of adding the request/response to the controller method
            and then passing it through my code, it becomes gross, hopefully we agree.
        </x-text>

        <x-code >
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
            fastify request with
            <x-inline-code>request().fastifyRequest</x-inline-code>
        </div>

        <x-title>
            Accessing the response
        </x-title>

        <x-code >
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
            And again, the same applies with response, the underlying fastify reply can be accessed via
            <x-inline-code>response().fastifyReply</x-inline-code>
        </div>


        <x-title>
            Controller Method Decorators
        </x-title>
        <x-text>
            There are some decorators available to use on controller methods, these will make your life just a little easier.
        </x-text>

        <x-subtitle>
            Accessing the request body
        </x-subtitle>

        <x-code >
            {{--@formatter:off--}}
import { put, body } from "@envuso/core/Routing";

@put('/user/username')
async users(@body body : any) {
    // If you send a request like PUT /user/username, with a body of {username : "sam"}
    // body will be an object of {username : "sam"}
}
        {{--@formatter:on--}}
        </x-code>

        <x-subtitle>
            Accessing a query parameter
        </x-subtitle>

        <x-code >
            {{--@formatter:off--}}
import { get, query, request } from "@envuso/core/Routing";

@get('/users')
async users(@query page : number) {
    // If you send a request like /users?page=10
    // page will be converted to a number and read the parameter based
    // on the variable name
}
        {{--@formatter:on--}}
        </x-code>

        <x-subtitle>
            Using route parameters
        </x-subtitle>

        <x-code >
            {{--@formatter:off--}}
import { get, param, request } from "@envuso/core/Routing";

@get('/users/:type')
async users(@param type : string) {
    // If you send a request like /users/admin
    // type will contain the content from the route parameter
}
        {{--@formatter:on--}}
        </x-code>

    </x-container>

@endsection
