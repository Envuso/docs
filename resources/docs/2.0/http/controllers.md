# Controllers

## What are controllers?

Controllers allow us to handle our application logic, it also gives us a way of grouping a bunch of endpoints together in one place for a specific thing.

Imagine we need to have some endpoints for our User to upload an image, change some settings etc.

We would create a UserController for this, and add some methods for the things we need.
Maybe, "uploadImage" and "updateSettings".

Envuso allows us to define our end point routes as controller methods. We will then add decorators
to our controller/methods to let Envuso know what it needs to handle and at which endpoint it can do it.

Example: 
```typescript
@controller('/api/user')
export class UserController extends Controller {
    
	@put('/image')
	public uploadImage() {}
	
    @patch('/settings')
    public updateSettings() {}
	
}
```

All the routes which are defined on your controller with the decorators will then be passed to Fastify which handles our actual HTTP Routing. If it matches a route, it will call the method of your controller.


## Controllers can be generated

First, save yourself the hassle, controllers can be generated.  
Here's what available:

```shell
# You do not need to specify "Controller".
# "Login" will be generated as "LoginController"
envuso make:controller Login

# Generate a controller with basic CRUD layout
envuso make:controller Tasks --resource

# Generate a controller for basic CRUD with your model
# NOTE: This does not generate a model for you.
envuso make:controller Tasks --resource --model Task
```

## Controller structure

```typescript
// All controllers must use the @controller() decorator
@controller('/prefix')
export class SomethingController extends Controller {
    // This is all that is needed. Controllers will automatically
    // be detected on framework boot and bind to the fastify instance.
}
```

## Controller Methods

When we are handling a request, we have access to some methods

### this.view

We can return a view response from our controller This is just syntactic sugar, so we don't have to do ```response().view()```

```typescript
this.view('name', {message : 'hi'})
```

### this.can / this.cannot

If we use the can/cannot methods(example below) this will allow us to use model policy checks from inside our method

More information on model policies can be found [here](/2.0/authentication/policies)

```typescript
const user = await User.find(1);

await this.can('deleteUser', user)
await this.cannot('deleteUser', user)
```

## Controller Method Decorators

### Define Route Method
Without these decorators Envuso doesn't know which method can accept our request, and at which url it can.

```typescript
// Handles GET requests
@get('/path')
// Handles POST requests
@post('/path')
// Handles PUT requests
@put('/path')
// Handles PATCH requests
@patch('/path')
// Handles HEAD requests
@head('/path')
// Handles DELETE requests
// There's a few naming options since we cant use @delete()
@destroy('/path')
@remove('/path')
@delete_('/path')

// Handles GET, DELETE, HEAD, POST, PATCH, PUT, OPTIONS requests
@all('/path')
// Handles the provided request methods
@method(["GET", "DELETE", "HEAD", "POST", "PATCH", "PUT", "OPTIONS"], '/path')
```

### Define Middleware for a route
More information on middleware can be found [here](/2.0/http/middleware)

```typescript
@middleware(new JwtAuthenticationMiddleware())
```


## Some internal methods for controllers

Some of these may or may not be useful. 
A better explanation will be added in the future, but you can also look into the type definitions on the framework

### Accessing the routing/controller manager
```typescript
import {Routing} from '@envuso/core/Routing';

// Returns the routing manager instance
Routing.get();
```

### Get all meta data defined for a controller

```typescript
Routing.get().getControllerMeta(UserController);
```

### Get all meta data defined for a controller

```typescript
Routing.get().getRouteByName('UserController.viewUser') // returns RouteContract 
```

### Get all controllers

```typescript
Routing.get().getControllers() // returns ControllerAndRoutes[] 
```

### Check if x path is registered

```typescript
Routing.get().hasPathRegistered('/api/users', ['GET']) // returns boolean 
```

### Get a route via it's path

```typescript
Routing.get().getRouteByPath('/api/users') // returns StoredRouteInformation|null 
Routing.get().getRouteByPath('/api/users/:id') // returns StoredRouteInformation|null 
```

### Get all routes registered

```typescript
Routing.get().getRoutes() // returns { [key: string]: StoredRouteInformation }
```

### Check if the routing manager has been initiated

```typescript
Routing.get().isInitiated() // returns boolean
```
