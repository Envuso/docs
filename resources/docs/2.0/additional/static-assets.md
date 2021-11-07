# Static Assets

At some point we usually need a way to serve up files from our backend, I come from a PHP background which makes this simple in this regard.

However... for node js this comes with some interesting challenges.

## Setting your static assets directory
We can define a directory which will serve all files inside it from ```/Config/StaticAssetConfiguration.ts -> assetPath```

By default, assetPath will be set to /assets in the root of your project


## View Helpers
If we're using edge views there's some little helpers to make things easier to work with

### asset()

If we have the following file ```/assets/cats.png``` we can return a correctly formatted path which is usable in your frontend 

Example: 

```html
<img src="{{asset('cats.png'}}"/>
// Will be set to:
<img src="/assets/cats.png"/>
```

### Laravel Mix - mix()
Envuso ships with laravel mix for easy webpack setup and building, it's personally the easiest tool for quickly getting started.

If we have some css/js files which when built in production use versioning, we want to use the correct version strings for caching purposes.

Lets imagine we have "app.css", when built in dev, we access it via "/assets/app.css"

But when it's built in prod(with versioning enabled), it will be named something like "/assets/app-dsifjsdiofusio.css" 

Laravel mix stores these version names in a mix-manifest.json configuration file, so we can read them.

For this case, we can use the ```mix()``` helper.

```html
// instead of
<link href="/assets/app.css" rel="stylesheet">
// or 
<link href="{{asset('app.css')}}" rel="stylesheet">

// We can now use:
<link href="{{mix('app.css')}}" rel="stylesheet">
// This will load all versioned assets correctly
```
