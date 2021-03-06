# Cache

More info needed here.


## Introduction

Right now the cache implementation is quite basic and is based only on Redis.  
**Caching will only will only work if you have "redis : {enabled : true}" in your  <code class="language-typescript">/src/Config/Database.ts</code>  config file.**

## Obtaining a cache instance

You can use it directly via the container, or via static methods

```typescript
import {Cache} from '@envuso/core/Cache';
import {resolve} from '@envuso/core/AppContainer';

Cache.set()
resolve(Cache).set()
```

## Retrieving items from the cache

All cache methods are async, so you will need to use .then() or await them to get the result.  
You can pass a second parameter to .get() to provide as the default value if the item does not exist in the cache.  
By default, the second parameter will return null

```typescript
const value = await Cache.get('some-key');

const nonExistentValue = await Cache.get('some-non-existent-value', 'woop');

console.log(nonExistentValue); // returns 'woop';
```

## Storing items in the cache

#### Storing the item forever

```typescript
import {Cache} from '@envuso/core/Cache';

await Cache.put('some-key', 'some value');
```

#### adding an item that expires at x time

We can create a new DateTime instance and pass this as a third parameter to set the value to expire at x time.

```typescript
import {Cache} from '@envuso/core/Cache';
import {DateTime} from '@envuso/core/Common';

await Cache.put('some-key', 'some value', DateTime.now().addSeconds(20));

// 25 seconds later...
setTimeout(async () => {
	console.log(await Cache.get('some-key')) // returns null
}, 25 * 1000);
```

## Removing items from the cache

```typescript
import {Cache} from '@envuso/core/Cache';

await Cache.remove('some-key');
```

## check if item exists in cache

.exists() will return true if the item exists, false if it does not exist.

```typescript
import {Cache} from '@envuso/core/Cache';

await Cache.exists('some-key'); // returns true or false
```

## retrieve and store

Sometimes we may want to store an item in the cache, but return a default if it doesn't. This is how .get() works.  
But... what if we want to store an item in the cache if it doesn't exist?  
.remember() will return the item from the cache if it exists, if it doesn't, it will add your item and then return it.

```typescript
import {Cache} from '@envuso/core/Cache';

await Cache.remember('some-key', () => await User.get(), DateTime.now().addSeconds(20));
```
