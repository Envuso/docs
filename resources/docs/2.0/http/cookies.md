# Cookies

This documentation applies for requests and responses

## The Cookie Jar

All cookies for a request and response are stored in a "CookieJar" class instance.

So all methods below will apply to both requests and responses.

By default, all cookie values sent on a response are encrypted/hashed and this is then verified when the server reads the cookies
**If the cookie has been tampered with, it will be discarded.**

```typescript
// Request cookie jar:
request().cookieJar();
// Response cookie jar:
response().cookieJar();
```

### Setting a cookie

The following would add a cookie to our response when it's sent

```typescript
response().cookieJar().put('name', 'value')
```

### Getting all cookies

```typescript
request().cookieJar().all(); // returns CookieContract[]
```

### Getting a cookie via name

```typescript
request().cookieJar().get('name'); // returns CookieContract
```

### Check if exists

```typescript
request().cookieJar().has('name'); // returns boolean
```

## The Cookie instance

When we get or create a cookie we will be interacting with the "Cookie" class

### Creating a cookie
```typescript
Cookie.create('name', 'value');
```

### Setting cookie values
```typescript
const cookie = Cookie.create('name', 'value');

cookie.withName('new name')
cookie.withValue('new value')
cookie.withMaxAge(DateTime.now().addDays(7))
cookie.withExpiresAt(DateTime.now().addDays(7))
cookie.withDomain('https://google.com')
cookie.withPath('/api')
cookie.withHttpOnly(true)
cookie.withSecure(true)
cookie.withSameSite(true)

```

### Getting header string
```typescript
Cookie.create('name', 'value').toHeaderString();
```

### Reading cookie data

When reading a cookie from the request, we will only have it's key/value

```typescript
const cookie = request().cookieJar().get('name')

cookie.getName();
cookie.getValue();
```


## Default Cookie Configuration

```/Config/SessionConfiguration.ts``` some of the default cookie values are stored here under `cookie`
