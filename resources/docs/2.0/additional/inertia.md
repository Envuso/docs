# InertiaJS

Envuso ships with first party support for [inertiajs](https://inertiajs.com/)

Envuso + Inertia apps just feel nice and snappy, if you haven't tried it before, give it a go

If you removed a lot of things, need a reference, or want to know all the bits for removing it, here's the steps required for it to work

**(Keep in mind that envuso comes with inertia out of the box)**

# Configuration Steps

### src/Config/InertiaConfiguration.ts

This config file allows us to provide the name of the edge view which will render our base layout page.

### src/Config/Configuration.ts

Other config registrations removed for brevity

```typescript
export default class Configuration extends ConfigurationFile {
    load() {
        //.... 
        this.add('inertia', import("./InertiaConfiguration"));
        //....
    }
}
```

### src/Config/ServerConfiguration.ts

InjectViewGlobals and SetInertiaSharedDataMiddleware will be required in `middleware`

```typescript
export class ServerConfiguration extends ConfigurationCredentials implements ServerConfig {
    middleware = [
        StartSessionMiddleware,
        // These middlewares are required for it to work
        InjectViewGlobals,
        // This is shipped with envuso, if you deleted this, see further below for creating it
        SetInertiaSharedDataMiddleware,
    ];
}
```

### src/Config/AppConfiguration.ts

Finally, we can add `InertiaServiceProvider`

```typescript
import {InertiaServiceProvider} from "@envuso/core/Packages/Inertia/InertiaServiceProvider";

export class AppConfiguration extends ConfigurationCredentials implements ApplicationConfiguration {
    providers: (new () => ServiceProviderContract)[] = [
        // Add it last in the list 
        InertiaServiceProvider,
    ];
}
```

## Working with inertia on the backend

### Adding our inertia base page

This will allow our frontend to take over, but we need a SSR page first to initiate this.

Let's add a new controller/route

```typescript
@controller('/dashboard')
export class DashboardController extends Controller {
    @get('/')
    public async index() {
        return Inertia.render('Dashboard', {
            message : 'Hello World!'
        });
    }
}
```

We've now told envuso that the /dashboard route will render an inertia page.

Let's add our .edge view for this to work

### Inertia Edge View

In `src/Resources/Views`, create a file called "InertiaApp.edge"

```html
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- By default envuso ships with laravel mix for bundling assets -->
    <link href="{{mix('app.css')}}" rel="stylesheet" />
</head>

<body class="bg-gray-100">

<!-- This is the important **required** part -->
<div id="app" data-page="{{page}}"></div>
</div>

<!-- By default envuso ships with laravel mix for bundling assets -->
<script src="{{mix('app.js')}}"></script>
</body>
</html>
```

Now when we visit /dashboard this .edge view will be rendered and our frontend will take over. Inertia will then load our Dashboard component that we defined in ```Inertia.render('Dashboard');```

## Handling inertia requests

Envuso's support is working quite nicely, lets take a quick look over some of the things that are possible:

### Handling redirects nicely

I personally think it's small things like this that make our life a breeze.

If we make a request to an endpoint to save some data for example, but then we need to redirect back to the page we were at

```typescript
export class SomeController extends Controller {
    @get('/some/inertia-endpoint')
    async someEndpoint() {
        // .with() will flash session data, so you could 
        // output this on your frontend if you'd like.
        return back().with('message', 'Hello there.');

        // We could also do it a few other ways:
        return redirect().back();
        return redirect().route('SomeOtherController.someOtherEndpoint');
        return redirect().to('/something/else');
        return redirect('/something/else');
    }
}
```

### Sharing global data with inertia

If you no longer have the "SetInertiaSharedDataMiddleware", you'll need to create it and add it to your
`src/Config/ServerConfiguration.ts -> middleware` configuration.

Make sure you extend `InertiaMiddleware`

```typescript
import {InertiaMiddleware} from "@envuso/core/Packages/Inertia/Middleware/InertiaMiddleware";

export class SetInertiaSharedDataMiddleware extends InertiaMiddleware {
    share(context: RequestContextContract) {
        return {
            errors : context.session.store().get('errors', null),
        };
    }
}
```

with the `share()` method, we can pass any additional global data. For example, I like to define a "messages" global configuration like so:

```typescript
return {
    errors   : context.session.store().get('errors', null),
    messages : {
        success : context.session.store().get('success', null),
        error   : context.session.store().get('error', null),
    }
}
```

now from my endpoints I can do something like:

```typescript
back().with('error', 'You dont have permission to do this')
back().with('success', 'Changes saved successfully')
```

and then on my frontend display a pretty banner for feedback on an action.

## Working with inertia on the frontend

Please look through the inertia documentation for information on this.
