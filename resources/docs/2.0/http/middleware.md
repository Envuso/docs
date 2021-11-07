# Middleware

## What is Middleware?

Middleware allows us to define some logic which we want to run before our Controller logic is run.

Let's imagine the below scenarios:

- We have an admin panel, and we want to prevent all users without a role from accessing it.
- We have some public pages which should let users without an account from viewing. But we also have some pages that require the user to login and we also want to redirect users who visit them to
  /login, if they arent logged in.

Middleware is perfect for these kinds of scenarios.

Envuso also uses Middleware to check if a user is authenticated and initiate authentication logic(for JWT and sessions)

## Using middleware on all controller methods

```typescript
// we use new Middleware() so that you can define any additional middleware data
@middleware(new UserHasRoleMiddleware('admin'))
@controller('/prefix')
export class SomethingController extends Controller {

}
```

## Using middleware on one method

```typescript
@controller('/prefix')
export class SomethingController extends Controller {

    @middleware(new UserIsAdminMiddleware())
    @get('/admin')
    async adminAction() {

    }

}
```

## Middleware structure

```typescript
import {Middleware, RequestContext} from "@envuso/core/Routing";

export class UserIsAdminMiddleware extends Middleware {
    public async handler(context: RequestContext) {
        // hasRole() does not exist in the framework, it's purely an example
        if (!context.user().hasRole('admin')) {
            return response().redirect('/404');
        }
    }
}
```

## Applying middleware globally

In some scenarios you may want some global type of middleware which runs on **every** request.

We can easily achieve this, if we go to our ```/Config/ServerConfiguration.ts``` config file, we have a ```middleware```
property.

If we have a custom middleware with the name of ```CustomLogicMiddleware``` for example

```typescript

export default class ServerConfiguration extends ConfigurationCredentials implements ServerConfig {

    /**
     * Stripped other config properties for simplicity
     */

    middleware = [
        StartSessionMiddleware,
        InjectViewGlobals,
        HandleInertiaRequestMiddleware,
        // We add our custom middleware here
        CustomLogicMiddleware,
    ];
}
```

The ordering of middleware matters they run one after another, starting at the first.

