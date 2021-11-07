# Request

## Accessing the request

```typescript
import {request, RequestContext} from "@envuso/core/Routing";

// You can use the request() helper method
request()

// You can access the context of the request
RequestContext.get().context().request;
```

## Get the authenticated user for this request

Returns null if user is not authenticated.

```typescript
request().user<T>() // returns AuthenticatableContract<T> | null;
```

## Access the session for this request

Access the session via the request

```typescript
request().session() // returns SessionContract
```

**Note: This will only work if we have "SessionAuthenticationProvider" added to the
"Config/AuthConfiguration.ts" config file under "authenticationProviders"**
Example:

```typescript
export default class AuthConfiguration extends ConfigurationCredentials {
    authenticationProviders = [JwtAuthenticationProvider, SessionAuthenticationProvider];
}
```

## Getting request data

### Body

This will give you the data passed as the body of a request

```typescript
request().body()
```

### Query parameters

This will give you all url parameters

```typescript
request().query()
```

### Get all data

This will merge query/body parameters

```typescript
request().all()
```

### Get a specific value from the request body/query

This will give you all url parameters

```typescript
request().get<T>('key')
// You can also pass an optional second value 
// to use as a default if the key does not exist
// By default, this value is null
request().get<T>('key', 'fallback value');
```

### Get a boolean value from the request/body

Returns true when value is "1", "true", "on", and "yes". Otherwise, returns false.

This accepts an optional fallback value, by default this is false

```typescript
request().getBoolean('key')
```

### Check if a keys value is an empty string

```typescript
request().isEmptyString('key')
```

### Get all items except the specified keys

```typescript
request().except('key one', 'key two')
request().except(['key one', 'key two']);
```

### Get only the specified items by their keys

```typescript
request().only('key one', 'key two')
request().only(['key one', 'key two'])
```

### Check if a key exists

```typescript
request().has('key')
```

### Check if a key is missing from the request

```typescript
request().missing('key')
```

### Get all keys

```typescript
request().keys()
```

## Request helpers

### Get the ip of a request

```typescript
request().ip();

// You can also use
request().ips()
// See https://www.fastify.io/docs/latest/Request/ for more info
```

### Get the url of a request

```typescript
request().url()
```

### Get the previous url of a request

If the user visited one page, then another this value will be set. Otherwise it will be null.

```typescript
request().getPreviousUrl()
```

### Get the path of a request

```typescript
request().path()
```

### Get the method of a request

```typescript
request().method()
```

### Check if it was a secure request

Is the request using HTTPS?

```typescript
request().isSecure()
```

### Get the scheme of the request

Get the current requests scheme

```typescript
request().scheme() // returns 'http' | 'https';
```

### Get the id of a request

```typescript
request().id()
```

### Get the session id

Returns the session id from the session cookie

```typescript
request().getSessionId()
```

## Checking request types

### Check if it's a json request

Does our request/response contain Content-Type application/json? IE; our client is asking for JSON response

Envuso Request and Response classes both extend this class so that they share a similar interface without mass code duplication.

```typescript 
request().isJson()
```

### Check if it's a html request

Does our request/response contain Content-Type text/html? IE; our client is asking for HTML response Envuso Request and Response classes both extend this class so that they share a similar interface
without mass code duplication.

```typescript
request().isHtml()
```

### Check if it's an ajax request

credits: Laravel/Symfony Framework 

Returns true if the request is an XMLHttpRequest. It works if your JavaScript library sets an X-Requested-With HTTP header. It is known to work with common
JavaScript frameworks:

see for more information: https://wikipedia.org/wiki/List_of_Ajax_frameworks#JavaScript

```typescript
request().isXmlHttpRequest()

// You can also use:
request().isAjax();
```

### Check if it's a PJAX request

```typescript
request().isPjax()
```

### Check if the request expects a json response

Does our request/response contain Accept application/json? IE; Is our client willing to accept json? Envuso Request and Response classes both extend this class so that they share a similar interface
without mass code duplication.

```typescript
request().wantsJson()
```

### Check if it's a json request & response

credits: Laravel/Symfony Framework

Try to correctly detect JSON only requests

```typescript
request().expectsJson()
```

### Check if the request expects a HTML response

Does our request/response contain Accept text/html IE; Is our client willing to accept html? Envuso Request and Response classes both extend this class so that they share a similar interface without
mass code duplication.

```typescript
request().wantsHtml()
```

### Check if the request was a prefetch type request

Determine if the request is the result of a prefetch call.

```typescript
request().prefetch()
```

## Request/Response headers

Envuso Request and Response classes both extend the "RequestResponseContext" class so that they share a
similar interface without mass code duplication. 
For that reason, some of these methods may or may not be actually useful. For example, in the case of a request, setHeader is useless.

### Get the referer header

```typescript
request().getReferer() // returns string | null
```

### Get all headers defined on the request/response

```typescript
request().headers()
```

### Do we have x header set on the request/response?

```typescript
request().hasHeader('header name')
```

### Get x header from the request/response

Optionally accepts a second parameter as the default value if the header doesn't exist. By default, this value is null.

```typescript
request().getHeader('header name')
```

## Set a header
Apply a header to the request or response, this applies directly to the fastify request/response

```typescript
request().setHeader('header name', 'value')
```

## Interacting with Cookies

You can retrieve the "CookieJar" for this request via:
```typescript
request().cookieJar()
```
For more information on cookies please visit the [cookie documentation](/2.0/http/cookies)

## Retrieve an item that was flashed onto the session

See the SESSION documentation for a better explanation on this TODO: Session docs/flashing

Optionally accepts a default parameter as the second value. If none is specified it will be null.

```typescript
request().old('key')
```
