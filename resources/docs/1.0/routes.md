<a href="https://envuso.com/"><div class="text-center py-4 lg:px-4">
  <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
    <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">New</span>
    <span class="font-semibold mr-2 text-left flex-auto">Envuso v2.X has been release!</span>
    <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
  </div>
</div></a>

# Routes

More info needed here.


## Where are they defined


They are defined alongside your controller, you have two ways to register the structure of your route

```typescript
@controller('/auth')
export class AuthController extends Controller {

    @post('/login')
    async login() {}

}
```

With AuthController, we define <code class="language-typescript">@controller('/auth')</code> **/auth**  is this controllers prefix.  
We then define  <code class="language-typescript">@post('/login')</code> this makes this controller method available by sending a POST request to  **/auth/login**

## What methods can I use

```typescript
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
```

## Accessing the request


I was so tired of adding the request/response to the controller method and then passing it through my code, it becomes gross, hopefully we agree.

```typescript
import { request } from "@envuso/core/Routing";

@put('/user/avatar')
async uploadAvatar() {
    const file = request().file('avatar')
}
```

At the moment it's fairly basic, but you can access the underlying fastify request with  <code class="language-typescript">request().fastifyRequest</code>

## Accessing the response
```typescript
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
```
And again, the same applies with response, the underlying fastify reply can be accessed via <code class="language-typescript">response().fastifyReply</code>

## Controller method decorators
There are some decorators available to use on controller methods, these will make your life just a little easier.
#### Accessing the request body
```typescript
import { put, body } from "@envuso/core/Routing";

@put('/user/username')
async users(@body	body : any) {
    // If you send a request like PUT /user/username, with a body of {username : "sam"}
    // body will be an object of {username : "sam"}
}
```
####  Accessing a query parameter
```typescript
import { get, query, request } from "@envuso/core/Routing";

@get('/users')
async users(@query	page : number) {
    // If you send a request like /users?page=10
    // page will be converted to a number and read the parameter based
    // on the variable name
}
```
####  Using route parameters
```typescript
import { get, param, request } from "@envuso/core/Routing";

@get('/users/:type')
async users(@param	type : string) {
    // If you send a request like /users/admin
    // type will contain the content from the route parameter
}
```
