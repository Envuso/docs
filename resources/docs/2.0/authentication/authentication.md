# Authentication

## Authentication

Envuso ships with some basic controllers implementing JWT authentication, you can use them or delete them.

A lot of the authentication is also orientated around building api's

## Login with credentials

You can pass the users credentials to this method to log them in.  
This will only authorise them for this request, since authentication is JWT orientated.  
This method will also take care of comparing the plain password to the hashed password

```typescript
await Auth.attempt({
    email    : '...',
    password : '...'
});

// You can also use
await Auth.authoriseAs(
    await User.find(userId)
);
```

## Check if the user is authenticated

Check if a user is authenticated for this request

```typescript
if (!Auth.check()) {
    throw new UnauthorisedException();
}
```

## Authed user

Returns the authenticated user for this request.  
The user is always a type of  **AuthorisedUser**

```typescript
const user = Auth.user();
```

## JWT

### Generating a JWT for a user

You can generate a jwt from any Authenticatable User Model

```typescript
let user = await User.find(userId);
user.generateToken();
```

### Authenticating JWT requests on controllers

We can add the JwtAuthenticationMiddleware middleware to our method/controller

JwtAuthenticationMiddleware will do the following:

- Check for a JWT, if one doesnt exist throw an exception
- Get the user for the JWT, if one doesnt exist throw an exception
- Authenticate as the user for the JWT
- If any stage fails, the request will not hit the controller/method

Examples:

```typescript

// Authenticating all methods for this controller
@middleware(new JwtAuthenticationMiddleware())
@controller('/something')
export class SomeController extends Controller {
}

// Authenticating a single method on a controller 
@controller('/something')
export class SomeController extends Controller {

    @middleware(new JwtAuthenticationMiddleware())
    @get('/')
    getSomething() {
        return {};
    }

}

```


