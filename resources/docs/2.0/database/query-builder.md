# Query Builder

The query builder can be accessed via a Model. To start querying we access it statically like so:

```typescript
User.query()
```

For the most part, envuso's query builder is just wrapping mongo's node client. We have a lot of convenience methods built in, but all regular mongo client queries should also work.

## Filtering

In the SQL world "select" statements are used for this, we just have "filters" in mongo.

Most of envuso's filter based methods will start with "where". Like we're asking it "give me all users where x = z".

### where()

There is a few ways to use where, pick your poison

```typescript
Post.query().where('title', 'x');

Post.query().where('title', '=', 'x')

Post.query().where({title : 'x'});
```

There's some syntactic sugar in there, but each way gives options for different ways of complex queries to be simplified or made more like a mongo client query.

For example, "give me all posts where title = x and it has more likes than 10"

```typescript
Post.query()
    .where('title', 'x')
    .where('likes', '>', 10)
    .get()
// This could also be written like:
Post.query()
    .where({
        title : 'x',
        likes : {$gt : 10}
    })
    .get()
```

### whereIn()

Imagine we have some users like

```js
{
    username: 'jane'
}
{
    username: 'bill'
}
{
    username: 'bob'
}
```

And now we want to get all users with the username of either "jane" or "bill"

```typescript
User.query()
    .whereIn('username', ['jane', 'bill'])
    .get();

// This will give us:
{
    username: 'jane'
}
{
    username: 'bill'
}
```

### whereAllIn()

Imagine if we have some book documents like:

```js
[
    {title : 'book name', tags : ['action', 'rpg']},
    {title : 'book name', tags : ['action']}
]
```

Now... we want to get all books with the tag 'action'

```typescript
Book.query()
    .whereAllIn('tags', ['action'])
    .get()

// This will give us:
return [
    {title : 'book name', tags : ['action', 'rpg']},
    {title : 'book name', tags : ['action']}
]

```

If we wanted all with the tags 'action' and 'rpg'

```typescript
Book.query()
    .whereAllIn('tags', ['action', 'rpg'])
    .get()

// This will give us :
return [
    {title : 'book name', tags : ['action', 'rpg']}
]
```

The key difference between .whereIn() and .whereAllIn() is that it will search for a document with an array, containing the specific values

### when()

Imagine some code like this, where we have some condition that needs to add some additional filter

```typescript
const usersQuery = User.query();

if (request().has('age')) {
    usersQuery.where('age', '>', 21);
}

const users = await usersQuery.get();
```

Queries like this can very quickly get out of control and become a mess... We can do it like this instead:

```typescript
await User.query()
    .when(request().has('age'), {age : request('age')})
    .get()
// Or this way
await User.query()
    .when(request().has('age'), builder => {
        return builder.where('age', request('age'))
    })
    .get()
```

### whereHas()

whereHas allows us query for a model which has a relation, but limit this relation which some additional filters

For example, if we have a User model which has many Books Users:

Users:

```typescript
[{id : 1}, {id : 2}, {id : 3}]
```

Books:

```typescript
[
    {id : 1, userId : 1, title : 'something'},
    {id : 2, userId : 1, title : 'something else'},
    {id : 2, userId : 2, title : 'something'},
]
```

Imagine we want to only return Users who have a book with the title of 'something'

```typescript
User.query()
    .whereHas('books', builder => {
        return builder.where('title', 'something');
    })
    .get();

// This will give us the following users:
return [
    {id : 1},
    {id : 2}
]
```

### has()

This is similar to the above example, but without the additional query builder callback

So, imagine we want to get all users which DO have books, excluding users that don't have books.

```typescript
User.query()
    .has('books')
    .get()

// This will give us the following users:
return [
    {id : 1},
    {id : 2}
]
```

### with()

Allows us to load a relationship on our query

View the model relations docs for more info [here](/2.0/database/models#content-with-query-builder-method)

```typescript
User.query().with('books').get();
```

### withCount()

Imagine we want to query for all users and include the count of their books(which are loaded via relations)

```typescript
await User.query()
    .withCount('books')
    .first();

// This will add a booksCount property on the resulting response
// We'd get a user which looks something like this:
// {id: 1, booksCount: 10, books: []}

```

### Checking for existence of a key on a document

If we need to query for a document that has/doesnt have a specific key set

Imagine some user documents like:

```typescript
[
    {id : 0, username : 'bruce'},
    {id : 1},
]
```

#### exists()

Query for documents that have the specified key

```typescript
User.query().exists('username').get();

// This would give us:
// [{id: 0, username: 'bruce'}]
```

#### doesntExist()

Query for documents that dont have the specified key

```typescript
User.query().doesntExist('username').get();

// This would give us:
// [{id: 1}]

// We can also set the second parameter, doesntExist will just call exists(key, false)
User.query().exists('username', false).get();

```

### Updating Documents

Imagine we want to set a value on all users of our query, for example... We want to set a default avatar on all users that don't have one set

Our data looks something like this:

```typescript
[{id : 0, avatar : null}, {id : 1, avatar : 'some url'}]
```

We can do the following:

```typescript
User.query().where('avatar', null).update({avatar : 'some url'});

// Our data now looks like: 
[{id : 0, avatar : 'some url'}, {id : 1, avatar : 'some url'}]

```

#### Batch document updates

Now similar to above... imagine we need to update some data, but instead of setting them all to the same value, we want to give each document a different value

Maybe something silly like, we used to store users usernames in lowercase... and now we want them all to be uppercase
(this is a silly example, but I'm trying to keep things simple whilst also showing great use cases)

```typescript
// First we'll get our data:
const users = await User.query().get();

// Update our users usernames and prepare them for batch update
const preparedUser = users.map(user => ({
    _id      : user._id,
    username : user.username.toUpperCase()
}))

// Notice how we only return the _id and username for each user in this "preparedUser" const

// We can now run a single query to update all of the users data
User.query().batchUpdate('_id', preparedUser);

// Notice the _id?
```

batchUpdate()'s first parameter is a key that will mark each document uniquely, it will tell mongo which document it needs to update This is why we include the _id in the preparedUser map that we
create. Mongo will take this _id and all other fields included in this object and apply them on the user with that _id.

**So make sure you only pass the data you need to be updated. Just so you don't incorrectly overwrite data.**

### count()

Get the count of the documents that match your filter

```typescript
User.query().where('vip', true).count()
```

### random()

Get a random document or random documents

```typescript
User.query().random().get() // Returns users in a random order

User.query().random().first() // Returns a random user
```

### paginate()

This will allow us to return paginate-able data, the way envuso handles it works great with infinite scrolling.

It's based on document ids and cursoring It will ask mongo for all documents with an id > x or < x depending on the direction and apply the limit.

```typescript
// This will give us our first page of users, which is limited to 1 per page.
// Only 1 per page for example purposes

const users = await User.query().paginate(1);

// We'll get an object like this:
const res = {
    data       : [{id : 0}],// this is some example user data
    pagination : {
        before      : null,
        after       : 0,
        hasNext     : true,
        hasPrevious : false,
        total       : 2,
        limit       : 1,
    }
}
```

Envuso tries to help a lot with pagination and keep things easy for you

If our endpoint that we requested this data from was `/api/users` for example

To get our next page of data, we can hit `/api/users?after={after}` with the after value from the pagination object. To get our previous page of data(if hasPrevious is true) we can
hit `/api/users?before={before}`

For example, `/api/users?after=0` based on the original code example

### Ordering results

#### Ascending

For example, get all users in ascending order of their id

```typescript
User.query().orderByAsc('id').get();
```

#### Descending

For example, get all users in descending order of their id

```typescript
User.query().orderByDesc('id').get();
```

## Aggregation pipelines

Envuso uses aggregation pipelines for querying relationships and other things. We have some basic wrappers around pipelines, but they still need to documented and re-worked. However... you can still
access it and also add raw mongo pipeline queries

It's probably best to refer to the type definitions for now, but here's a basic example

builder => will return an instance of `QueryAggregation`

```typescript
User.query().aggregationPipeline(builder => {
    return builder.addAggregation({$match : {username : 'bruce'}})
})
```

### Relation Checks

Our query builder also has some useful helper methods which are used by internals for interacting with relationships

They could be useful depending on what you're doing, or they may also be useless.

#### isRelation()

Check if a relationship has been registered on our model

```typescript
User.query().isRelation('books'); //returns boolean

// We can also see if it is a specific relation type

User.query().isRelation('books', ModelRelationType.HAS_MANY);
```

#### relations()

Get an object of all relations on this model as an object Key is the relation property, value is the meta registered

```typescript
User.query().relations();

// This will give us something like:

return {
    books : {
        propertyKey  : 'books',
        relatedModel : 'Books',
        foreignKey   : 'userId',
        localKey     : '_id',
        type         : 'has-many',
    }
}
```
