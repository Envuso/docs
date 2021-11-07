# Response

## Accessing the response

```typescript
import {response, RequestContext} from "@envuso/core/Routing";

// You can use the response() helper method
response()

// You can access the context of the response
RequestContext.get().context().response;
```

## Sending responses

**All the below response examples assume you calling them inside a controller method**

### JSON Responses

If you send a javascript object as a response, this will be interpreted as a JSON response

Example:

```typescript
return {
    id    : user._id,
    email : user.email
}
```

We can also do it like this:
```typescript
return response().json({
    id    : user._id,
    email : user.email
})
// We can also specify an optional response code, by default its 200
return response().json({...}, 500)
```

### 404 - Not found

```typescript
return response().notFound('Woopsie, not found');
```

### 500 - Internal Server Error

```typescript
return response().internalError('Something went wrong...');
```

### 400 - Bad Request

```typescript
return response().badRequest('Something is wrong');
return response().badRequest({message : 'Something is wrong'});
```

### Manually sending responses

```typescript
return response().setResponse(
    {message : 'Oh no!'},
    StatusCodes.INTERNAL_SERVER_ERROR
).send();
```

### Sending JSON or a View depending on request type

In some scenarios you may wish for an endpoint to output json and a view
If our requests "Accept" header is "application/json" a JSON response will be sent
If it's not, a view(html) response will be sent

```typescript
return response().negotiated(
	{message : 'Hello world from JSON'},
    {templatePath : 'template path', data : {message : 'Hello world from html'}}
)
```

### Sending views

Envuso uses [edge](https://github.com/edge-js/edge) templates for rendering views

You can read more information on views [here](/2.0/http/views)

```typescript
return response().view('template path', {message : 'Hello world'})
```

### Sending redirects

There's two ways of doing this in envuso, let's first cover the simplest way which utilises Fastify's redirect method

This will instantly send a redirect response and end the request
```typescript
return response().redirectNow('https://google.com')
```

Since we also want to handle redirects within our application, we also have a wrapper around redirects

If we were to do ```response().redirect('/home')``` or ```response().redirectResponse()```

We would receive an instance of `RedirectResponseContract` which has some other handy little features

```typescript
const redirect = response().redirectResponse();

// Redirects but with a key/value flashed into the session
return redirect.with('key', 'value')

// If we are making a post request with some form data
// We may want to redirect back with that data available in the 
// session so we can show it in the form again, but with some errors

// This will set all the current data from the request automatically
return redirect.withInput()
// Or we can manually control it
return redirect.withInput({username : 'some username'})

// Redirects but with a cookie 
return redirect.withCookie('key', 'value')
// We can also send a cookie instance
return redirect.withCookie(
    Cookie.create('cookieName', 'cookieValue')
        .withDomain('...')
        .withSecure(true)
)

// We can also use the below to redirect back to the previous url
return redirect.back();
// We also have a helper for the .back() method
return back()

```

There is also a "redirect()" helper, which allows us to create a redirect response, but without directly going through `request().redirectResponse()` or `request().redirect()` 
```typescript
return redirect() // returns a RedirectResponseContract

// We could do something like
return redirect().route('UserController.view')

// We could also use it like:
return redirect('https://google.com')
```

### Redirecting to a route
We can also redirect to Envuso Routes, all envuso routes have a generated name which takes the format of "{controller name}.{controller method name}"

If we use the ```envuso build``` command, this will generate some useful meta for us which will give us auto completion on these route names with redirects

If we have a controller "UserController" with a method named "getUser", we can redirect to that like:

```typescript
return response().route('UserController.getUser')
// Or:
return redirect().route('UserController.getUser')
```

If your route also takes route parameters and such, we can also pass them into the route() method with the second parameter

Imagine a route like ```/user/:id/view```(Registered as ```UserController.viewUser```), which takes the users id as a route parameter
or one like ```/user/view?id=``` which takes a query parameter

```typescript
return response().route('UserController.viewUser', {id : 'some user id'});
```
