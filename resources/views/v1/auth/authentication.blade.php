@extends('v1.layout.app')

@section('content')
    <x-container>


        <x-header>Authentication</x-header>
        <ul>
            <x-context>Authentication</x-context>
            <x-context>Here's some of the methods available to you</x-context>
            <x-context>Login with credentials</x-context>
            <x-context>Validate login credentials</x-context>
            <x-context>Check if user is authenticated</x-context>
            <x-context>Authed User</x-context>
            <x-context>Obtaining a JWT for an authenticated user</x-context>
        </ul>

        <x-title>Authentication</x-title>

        <x-text>
            JWT Authentication, registration and login are all handled for you
            out of the box.
            <br>
            You can extend or customise parts to your liking.
        </x-text>

        <x-title>
            Here's some of the methods available to you
        </x-title>

        <br>
        <br>

        <x-title>
            Login with credentials
        </x-title>

        <x-text>
            You can pass the users credentials to this method to log them in.
            <br>
            This will only authorise them for this request, since authentication is JWT orientated.
            <br>
            This method will also take care of comparing the plain password to the hashed password
        </x-text>

        <x-code>
        {{--@formatter:off--}}
        import {Auth} from "@envuso/core";
        import {User} from "Models/User";

        await Auth.attempt({
            email : '...',
            password: '...'
        });

        // You can also use

        const user = await User.find(userId);

        await Auth.loginAs(user);
        {{--@formatter:on--}}
        </x-code>

        <x-title>
            Validate login credentials
        </x-title>

        <x-text>
            You can pass the users email and password(for example) directly from
            your register endpoint to this method.
            <br>
            It will check if a user exists and return true/false if this user can be registered.
        </x-text>

        <x-code>
        {{--@formatter:off--}}
        import {Auth} from "@envuso/core";

        const canRegister = await Auth.canRegisterAs({
            email : '...',
            password : '...'
        });

        if(canRegister) {
            // do something...
        }
        {{--@formatter:on--}}
        </x-code>



        <x-title>
            Check if user is authenticated
        </x-title>

        <x-text>
            Check if a user is authenticated for this request
        </x-text>

        <x-code>
        {{--@formatter:off--}}
        import {Auth} from "@envuso/core";

        if(!Auth.check()) {
            throw new UnauthorisedException();
        }

        {{--@formatter:on--}}
        </x-code>



        <x-title>
            Authed User
        </x-title>

        <x-text>
            Returns the authenticated user for this request.
            <br>
            The user is always a type of <strong>AuthorisedUser</strong>
        </x-text>

        <x-code>
        {{--@formatter:off--}}
        import {AuthorisedUser} from "@envuso/core";
        import {Auth} from "@envuso/core";

        const user : AuthorisedUser = Auth.user();

        {{--@formatter:on--}}
        </x-code>


        <x-title>
            Obtaining a JWT for an authenticated user
        </x-title>

        <x-text>
            Returns the authenticated user for this request.
            <br>
            The user is always a type of <strong>AuthorisedUser</strong>
        </x-text>

        <x-code>
        {{--@formatter:off--}}
        import {AuthorisedUser} from "@envuso/core";
        import {User} from "@App/Models/User";
        import {Auth} from "@envuso/core";

        let user = await User.find(userId);

        if(!await Auth.loginAs(user)) {
            // Login failed...
        }

        user : AuthorisedUser = Auth.user();

        return response().json({
            token : user.generateToken()
        });

        {{--@formatter:on--}}
        </x-code>





    </x-container>
@endsection
