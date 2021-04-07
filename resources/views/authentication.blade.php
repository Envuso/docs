@extends('layout.app')

@section('content')
    <x-container>

        <x-title>Authentication</x-title>

        <x-text>
            JWT Authentication, registration and login are all handled for you
            out of the box.
            <br>
            You can extend or customise parts to your liking.
        </x-text>

        <x-subtitle>
            Here's some of the methods available to you
        </x-subtitle>

        <br>
        <br>

        <x-subtitle>
            Login with credentials
        </x-subtitle>

        <x-text>
            You can pass the users credentials to this method to log them in.
            <br>
            This will only authorise them for this request, since authentication is JWT orientated.
            <br>
            This method will also take care of comparing the plain password to the hashed password
        </x-text>

        <x-code>
        {{--@formatter:off--}}
        import {Auth} from "@Core/Providers";
        import {User} from "@App/Models/User";

        await Auth.attempt({
            email : '...',
            password: '...'
        });

        // You can also use

        const user = await User.find(userId);

        await Auth.loginAs(user);
        {{--@formatter:on--}}
        </x-code>

        <x-subtitle>
            Validate login credentials
        </x-subtitle>

        <x-text>
            You can pass the users email and password(for example) directly from
            your register endpoint to this method.
            <br>
            It will check if a user exists and return true/false if this user can be registered.
        </x-text>

        <x-code>
        {{--@formatter:off--}}
        import {Auth} from "@Core/Providers";

        const canRegister = await Auth.canRegisterAs({
            email : '...',
            password : '...'
        });

        if(canRegister) {
            // do something...
        }
        {{--@formatter:on--}}
        </x-code>



        <x-subtitle>
            Check if user is authenticated
        </x-subtitle>

        <x-text>
            Check if a user is authenticated for this request
        </x-text>

        <x-code>
        {{--@formatter:off--}}
        import {UnauthorisedException} from "@App/Exceptions/UnauthorisedException";
        import {Auth} from "@Core/Providers";

        if(!Auth.check()) {
            throw new UnauthorisedException();
        }

        {{--@formatter:on--}}
        </x-code>



        <x-subtitle>
            Authed User
        </x-subtitle>

        <x-text>
            Returns the authenticated user for this request.
            <br>
            The user is always a type of <strong>AuthorisedUser</strong>
        </x-text>

        <x-code>
        {{--@formatter:off--}}
        import {AuthorisedUser} from "@Core/Providers/Auth";
        import {Auth} from "@Core/Providers";

        const user : AuthorisedUser = Auth.user();

        {{--@formatter:on--}}
        </x-code>


        <x-subtitle>
            Obtaining a JWT for an authenticated user
        </x-subtitle>

        <x-text>
            Returns the authenticated user for this request.
            <br>
            The user is always a type of <strong>AuthorisedUser</strong>
        </x-text>

        <x-code>
        {{--@formatter:off--}}
        import {AuthorisedUser} from "@Core/Providers/Auth";
        import {User} from "@App/Models/User";
        import {Auth} from "@Core/Providers";

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
