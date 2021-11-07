# Sessions

## Configuration

Sessions need to use a cookie to identify the user on each request.

### Session cookie values

We can adjust the generated session cookie values by modifying

```/Config/SessionConfiguration.ts -> cookie```

### Session data storage

Currently, envuso has two drivers for storing session data

- Redis
- File

The default driver is set to Redis

We can change the driver by changing:

```/Config/SessionConfiguration.ts -> sessionStorageDriver```

#### Redis

We will use the redis set-up in your framework to store user session data.

#### File

Session data is stored as a .json file in /storage/sessions

### Session Cookie name

The default name is "sessionId", we can modify that in

```/Config/SessionConfiguration.ts -> sessionCookie```

## Accessing the users session

```typescript
request().session()
session()
RequestContext.session()
```

### Previous request url

Mainly used by internals to provide ```redirect().back()``` functionality... but it could also be useful to use.

```typescript
session().store().previousUrl();
session().store().setPreviousUrl('url');
```

### Invalidating a session

This will end the session, clear all data and generate a new session id

```typescript
session().invalidate();
```

### CSRF helpers

CSRF is still a WIP, but it works with edge views

Here's some things available:

```typescript
// Is the CSRF token & secret set yet?
session().hasCsrfToken(); // returns boolean;
// Get the CSRF token
session().getCsrfToken(); // returns string;
// Get the CSRF token secret
session().getCsrfSecret(); // returns string;
// Generate a new CSRF secret & token
session().regenerateToken(); // returns Promise<void>;
```

## The session store

If we want to interact with session data, ie set/get/remove data. We need to use the session store

We can use that via the store() method, for example:

```typescript
session().store() // returns SessionStoreContract
```

### Get all items

```typescript
session().store().items();
```

### Retrieve items via key

```typescript
session().store().only(['item one', 'item two']);
```

### Check if a key exists

```typescript
session().store().exists('key name')
```

### Check if a key exists and is not null

```typescript
session().store().has('key name')
```

### Check if a key is missing

This is just the opposite of exists()

```typescript
session().store().missing('key name')
```

### Get item by key

Returns the item with the specified key

```typescript
session().store().get('key name')
// optionally accepts a second parameter to use as a fallback
// if the value doesnt exist, by default this is null
session().store().get('key name', 'some fallback')
```

### Pulling items

Will get an item by key then remove it from the store

```typescript
session().store().pull('key name')
// optionally accepts a second parameter to use as a fallback
// if the value doesnt exist, by default this is null
session().store().pull('key name', 'some fallback')
```

### Replace

Will basically merge the object in and overwrite any values with the passed in object

```typescript
// Imagine our session data looks like this:
// {'key name' : 'old', 'key two name' : 'another'}

session().store().replace({'key name' : 'value'})

// It will now look like this
// {'key name' : 'value', 'key two name' : 'another'}
```

### Put

Set a key -> value or object on the store.

```typescript
session().store().put({'key name' : 'value'})
session().store().put('key name', 'value')
```

### Remove multiple items by key

```typescript
session().store().forget(['key one', 'key two'])
```

### Remove all data from the store

```typescript
session().store().flush()
```

### Remove all data and set new data

This will call .flush() from above and then .put() the values.

```typescript
session().store().populate({someValue : false})
```

## Session store arrays

Sometimes we will need to maintain an array on the store

The framework uses this for some of its internals also.

### Pushing to an array

```typescript
// If our session data looks like:
// {someStoredArray: [{someKey: 'some value'}], someOtherArray: [1, 2]}

session().store().push('someStoredArray', {someOtherKey : 'some other value'});
session().store().push('someOtherArray', 3);

// We also don't need to have an array created in the session already also
// If it doesn't exist, it'll be created and pushed too.
session().store().push('someNewArray', 'wooo, add a new one');

// Our session data will now look like:
return {
    someStoredArray : [
        {someKey : 'some value'},
        {someOtherKey : 'some other value'},
    ],
    someOtherArray  : [1, 2, 3],
    someNewArray    : ['wooo, add a new one']
}
```

## Session store integers

### Incrementing

```typescript
// If our session data looks like:
{
    pageViews: 1
}
session().store().increment('pageViews');
// We can pass a second param to set the increment amount
// And add new values just like arrays
session().store().increment('newIntValue', 10);

// It will now look like:
return {
    pageViews   : 2,
    newIntValue : 10
}
```

### Decrementing

```typescript
// If our session data looks like:
{
    pageViews: 20
}
session().store().decrement('pageViews');
// We can pass a second param to set the decrement amount
session().store().decrement('someNewUnknownInt', 10);

// It will now look like:
return {
    pageViews         : 19,
    someNewUnknownInt : -10
}
```

## Flashing data onto the session

Flashing is technique to add data to the session for the current & next request.

For example, we want to show the user an error message on the next page and then hide it.

### flash

Flash a key->value pair into the store This item will only exist for one request and not be available in the current request. So, we're adding an item into the store for the next request by the user,
but only that request.

Use ```flashNow``` if it needs to be accessible in the current request + next

```typescript
session().store().flash('key', 'value');
// On the next request we can then do the following to get the value
session().store().old('key')
// We can also use
request().old('key')
```

### flashNow

Flash into the store that is immediately available in the current request

```typescript
session().store().flash('key', 'value');
// On the next/current request we can then do the following to get the value
session().store().old('key')
```

### keep

If on the next request, we want to keep the flashed data for one more life cycle we can use keep

```typescript
session().store().flash('key', 'value');

// On the next request...
session().store().keep(['key']);
```

## Flashing input:

In the future we will use input flashing for validation errors with data transfer objects

They are basically used to represent some user input for one request.

For example, we have a form on the frontend to submit email/password. But the email validation failed, we would ```return back()``` with that data... like so:

```typescript
return back().withInput({email : request('email')});
// We could also do
return back().withInput();
// This would add all of our request body values to the flashed input
```

### Adding data via the store

```typescript
session().store().flashInput({email : 'value'});
```

### Checking for existence

```typescript
session().store().hasOldInput('email');
```

### Getting a value

```typescript
session().store().getOldInput('email');
request().old('email')
// We can specify an optional fallback value, by default this is null
session().store().getOldInput('email', 'fail');
request().old('email', 'fail')
```

