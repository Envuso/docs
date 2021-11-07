# Cache

## Introduction

Right now the cache implementation is quite basic and is based only on Redis.

**You must have the RedisServiceProvider added/loaded to the framework for Caching to work. This is added by default.**

## Retrieving items from the cache

```typescript
await Cache.get('some-key');

// We can also pass a type, .get() uses generics.
await Cache.get<string>('some-string-value');

// We can pass an optional second parameter to use as a fall back. By default this value is null.
await Cache.get('some-non-existent-value', 'woop'); // returns "woop"
```

## Storing items in the cache

### Storing the item forever

```typescript
await Cache.put('some-key', 'some value');
```

### Adding an item that expires

We can create a new DateTime instance and pass this as a third parameter to set the value to expire at x time.

```typescript
await Cache.put('some-key', 'some value', DateTime.now().addHours(24));
// This value will no longer exist after 24 hours
```

## Removing items from the cache

```typescript
await Cache.remove('some-key');
```

## Checking for existence

```typescript
await Cache.has('some-key'); // returns boolean
```

## Retrieve and Store

Sometimes we may want to store an item in the cache, but return a default if it doesn't. This is how .get() works.  
But... what if we want to store an item in the cache if it doesn't exist?  
.remember() will return the item from the cache if it exists, if it doesn't, it will add your item and then return it.

When dealing with caching, we usually end up writing the same boilerplate:

```typescript
let data = await Cache.get('some-data', null);

if (data) {
    return data;
}

data = 'some value';

await Cache.put('some-data', data, DateTime.now().addHours(2))

return data;
```

If exists... return it, if it doesn't, add it then return it.

Now lets look at the remember method:

```typescript
const data = await Cache.remember('some-data', () => 'some value', DateTime.now().addHours(2));

return data; // gives us "some-data"
```

All of that original boilerplate/logic reduced down to 1 line :)

