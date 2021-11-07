# Models

## What are models?

Models represent an object that we will store in our mongo db collection, it also represents our collection as a whole.

If we want to interact with our "users" collection, we will have a "User" Model which allows us to do this.

Envuso models use [Class transformer](https://github.com/typestack/class-transformer) and [Class validator](https://github.com/typestack/class-validator) which gives us some additional nice features
for converting Classes -> objects and vice versa. It's worth taking a look at both to get a good idea on what's possible.

## Creating a model

You can do it manually, or use the [CLI tool](/2.0/getting-started/cli)

Using the CLI tool we can do:

```sh
envuso make:model Post
# This will generate a model for you at /src/Models/PostModel.ts
# You can also use sub directories

envuso make:model Blog/Post
# This will generate a model for you at /src/Models/Blog/PostModel.ts
```

Manually, we will need to create a file, for example:

```shell
$ touch /src/Models/PostModel.ts
```

And add the below for example:

```typescript

import {id, Model} from "@envuso/core/Database";
import {Type} from "class-transformer";
import {ObjectId} from "mongodb";

export class PostModel extends Model<PostModel> {

    // @id	allows envuso to take care of the MongoDB object id correctly. It will
    // give the framework knowledge of your primary key.
    @id
    _id: ObjectId;

}
```

## Model structure

All properties on a model will be saved into the database. There are some things to be aware of, let's take a look at them

### Using MongoDB ObjectId's

If a model needs to store an ObjectId, it's recommended to add the ```@id``` decorator to the property

Regardless of the structure/type of the property, this tells the framework that x property contains an ObjectId that will need to be transformed.

For example:

```typescript
export class UserModel extends Model<UserModel> {
    @id
    _id: ObjectId;

    // Imagine we need to store some other id, perhaps an uploaded photo id
    @id
    profilePhotoId: ObjectId;

    // We can also use them in other ways... here's a few examples:

    // An array containing ObjectIds
    @id
    objectIdArr: ObjectId[] = [];

    // An object with an id inside
    @id
    objWithIds: { id?: ObjectId } = {};

    // An array of objects with an id inside
    @id
    objArrWithIds: { id?: ObjectId }[] = {};

    // A class transform/array of class transforms

    @id
    @Type(() => SomeUserInformation)
    someUserInfo: SomeUserInformation;

    @id
    @Type(() => SomeUserInformation)
    someUserInfoArr: SomeUserInformation[];
}

class SomeUserInformation {
    @id
    userId: ObjectId;
}

```

When we add the ```@id``` decorator, this lets the model & query builder know about the property. So it can convert the value to an ObjectId when saving it to your collection and convert it to a
string when outputting it on a response.

When we use a property which has an ```@id``` decorator assigned in a query, it will also attempt to correctly convert the query value to an ObjectId.

If for example, we try to find a User by its ```_id``` and we use a string instead of an ObjectId instance, MongoDB will fail to find your user.

**Envuso takes care of this conversion for you automatically, but in some advanced queries it may fail**

Did you notice the use of ```@Type()``` and classes in the above model? This is a feature of [Class transformer](https://github.com/typestack/class-transformer)... here's some more examples:

```typescript
export class PostModel extends Model<PostModel> {

    @id
    _id: ObjectId;

    // Storing a sub-object
    // Imagine we store photo information in an object(this is purely an example)
    @Type(() => PostPhotoInformation)
    photoInformation: PostPhotoInformation;

    // Storing an array of sub objects:
    // For sub-object array conversion to work @Type() is required!
    @Type(() => PostPhotoInformation)
    photoInformation: PostPhotoInformation[];

    // Models also have validation
    @IsNotEmpty()
    @IsEmail()
    authorEmailAddress: string;

}

export class PostPhotoInformation {
    public fileName: string;
    public path: string;
    public size: number;
    public url: string;
}
```

### Dates

Dates are pretty simple, but what if we want to enforce a certain formatting or ensure it gets converted correctly to a Date when saved?

```typescript
export class UserModel extends Model<UserModel> {
    @id
    _id: ObjectId;

    @date()
    createdAt: Date;
}
```

We can use ```@date()``` this will tell envuso that we have a Date type value here. Why does envuso need to know?

Let's imagine we want to use some specific formatting on all api responses, now we have to do something like the below everywhere:

```typescript
return userModel.createdAt.toDateString();
```

Instead, we can add a value to ```@date()```

```typescript
export class UserModel extends Model<UserModel> {
    @id
    _id: ObjectId;

    @date('toDateString')
    createdAt: Date;
}
```

This will now call 'createdAt.toDateString()' for you when returned as a response, and it will save in your collection as a correctly formatted Date

## Relationships

Al-though MongoDB doesn't technically support relationships, it's nice to have the ability to use them, especially to reduce code complexity in the case that one collection needs to work with another
collection.

### Getting started with relationships relationship:

Some examples and a walk through of how envuso handles relations

Let's take the below UserModel

```typescript
export class UserModel extends Model<UserModel> {
    @id
    _id: ObjectId;
}
```

Imagine our user can create posts, we will typically store these posts in a different collection/model... perhaps a "PostModel"

Our post will store the user who created it, an id of the post, a title and some content.

```typescript
export class PostModel extends Model<PostModel> {
    @id
    _id: ObjectId;

    @id
    userId: ObjectId;

    title: string;
    content: string;
}
```

Now, when we display or use our Post, we want to display who created the post. Without relationships, we would need to do something like this for a single Post:

```typescript

const post       = await Post.query().where('_id', 'some id').first();
// Oh... we also need our user
const postAuthor = await User.query().where('_id', post.userId).first();
```

You can imagine how this spirals out of control, yet works for some simple cases...

Let's add some relationships to our Models, so we can make our lives a little easier.

First we'll add a way to get all of x users posts

```typescript
export class UserModel extends Model<UserModel> {
    @id
    _id: ObjectId;

    // Our first parameter is the Model name that we want to retreive
    // Our second parameter is the foreign key, ie the property that will be defined on PostModel
    // Our third parameter is the local Key, ie the property we will use from UserModel
    // It will get all PostModels that the foreign key value === the local key value.
    @hasMany('PostModel', 'userId', '_id')
    posts: PostModel[];
}
```

By adding the ```@hasMany``` decorator to our ```posts``` property, we allow the query builder to get the related models and add the result of that query to our ```posts``` property. Without the posts
property, typescript wouldn't allow us to access the "dynamically" loaded data.

So in this case, Envuso's query builder will get all Posts that have a ```userId``` which matches the ```_id``` on our UserModel

Now let's set up our PostModel to have the inverse of this relation.

```typescript
export class PostModel extends Model<PostModel> {
    @id
    _id: ObjectId;

    @id
    userId: ObjectId;

    title: string;
    content: string;

    // Our first parameter is the Model name that we want to retreive

    // Our second parameter is the local Key, ie the property we will use from PostModel
    // In our case, this is our userId on PostModel

    // Our third parameter is the foreign key, ie the property that will be defined on UserModel
    // In our case, this is our _id on UserModel. We want to get the UserModel that matches PostModels userId.
    @belongsTo('UserModel', 'userId', '_id')
    user: UserModel;
}
```

Now we have our models set up correctly, let's actually write some queries

We're going to look at three examples

- Getting a post with its author
- Getting all posts with their authors
- Getting a user with all their posts

All of them will use ```.with()``` which you can find more info on further down below.
```.with()``` will tell the query builder that we want to load the relations.

We will use the name of the property which has the @hasMany or @belongsTo decorator defined on it. In our case, this is "posts" or "user"

Getting a post with its author

```typescript
const post = await PostModel.query()
    .with('user')
    .first()
```

Getting all posts with their authors

```typescript
const posts = await PostModel.query()
    .with('user')
    .get()
```

Getting a user with all their posts

```typescript
const user = await UserModel.query()
    .with('posts')
    .first()
```

With all the above queries, we can also use other query builder methods. For example, getting a specific user with all their posts

```typescript
const user = await UserModel.query()
    // This will find a user with the _id = '1'
    .where('_id', '1')
    .with('posts')
    .first()
```

### Relationship types & Decorators

Currently, envuso has three different decorators for the below relationship types, most relationships can just be achieved with hasOne/hasMany

#### Has Many

Has many will load all the specified models where the foreign key of the specified model matches the local key of the current model.

```typescript
export class SomeModel extends Model<SomeModel> {
    @hasMany('BookModel', 'foreign key on BookModel', 'local key on SomeModel that matches the foreign key')
    books: BookModel[];
}
```

#### Has One

Has one will load the specified model where the foreign key of the specified model matches the local key of the current model.

```typescript
export class SomeModel extends Model<SomeModel> {
    @hasOne('BookModel', 'foreign key on BookModel', 'local key on SomeModel that matches the foreign key')
    book: BookModel;
}
```

#### Belongs To

This is basically the same as a ```hasOne``` relation, just in reverse. Basically it's syntactic sugar.

```typescript
export class BookModel extends Model<BookModel> {
    @belongsTo('SomeModel', 'local key on BookModel', 'foreign key on SomeModel that matches the local key of BookModel')
    someModel: SomeModel;
}
```

### Loading Relationships

When we have defined some relations, ```@hasOne() / @hasMany() / @belongsTo()```, we will then need to be able to load the related data, there is two ways to achieve this.

#### .with() query builder method

When we're using the query builder to pull some data from our database, we can specify the relationships with our ```with()``` method.

We need to use the property name on our model that contains the ```@hasOne() / @hasMany() / @belongsTo()``` decorator.

We can use .with() with any type of relationship that envuso supports, this will just allow envuso to switch up how it queries the data to get your main Model + it's related data. To achieve this,
envuso will use MongoDB Aggregation Pipelines.

Example .with() query:

```typescript
// Imagine the following model: 
export class BookModel extends Model<BookModel> {
    @id
    authorId: ObjectId;

    @belongsTo('UserModel', 'authorId', '_id')
    author: UserModel;

    @id
    categoryIds: ObjectId[] = [];

    @hasMany('CategoryModel', '_id', 'categoryIds')
    categories: CategoryModels[];
}

// And now our query
BookModel.query()
    .with('author', 'categories')
    .get()
```

This will load all BookModels from our collection and at the same time efficiently load the related data for the "author" and "categories" property decorator types.

What if we've already loaded our BookModel, and now we just need our author for some checks or something?

#### .load() model method

In the cases where we've already obtained a model from our database but we then need to load a relation, .load() is here to save us.

Imagine the following model, where a Book has an author but also has many categories

```typescript
export class BookModel extends Model<BookModel> {
    @id
    authorId: ObjectId;

    @belongsTo('UserModel', 'authorId', '_id')
    author: UserModel;

    @id
    categoryIds: ObjectId[] = [];

    @hasMany('CategoryModel', '_id', 'categoryIds')
    categories: CategoryModels[];
}
```

Now let's look at using load:

```typescript

// We'll pull a BookModel from the database just for example purposes
const book = await BookModel.query().first();

// Now we need to get our author to perform some check
await book.load('author');

// This will load our author relation as normal, we can now use it
if (book.author.isVip) {
    // Do something
}
```

## Crud Actions

Envuso has kind of an ORM built in for MongoDB which is custom made.  
You're also not confined to this, you could use MongoDB's client directly if you'd like, but the ORM should cover most of your cases.  
There's a lot of convenient methods built in, I also write laravel backends which heavily inspired me, if you use Laravel you should feel right at home and notice a lot of similarities with
usage/naming.

### Create

```typescript
await PostModel.create({
    title   : 'Cool programming post',
    content : 'Woot'
});

const post   = new PostModel();
post.title   = 'Cool programming post';
post.content = 'Woot';
await post.save();

// What about many?
await PostModel.createMany([
    {title : 'Yay', content : 'Woot'},
    {title : 'Yay #2', content : 'Woot'},
]);
```

### Read

```typescript
await PostModel.query()
    .where({title : 'Cool programming post'})
    .first();
await PostModel.query()
    .where('title', 'Cool programming post')
    .first();

await PostModel.query().paginate(20);

// Using mongodb query syntax:
await PostModel.findOne({title : 'Cool programming post'});

// Find the post by it's _id, by default
await PostModel.find('87483748738743');
// Using something other than _id 
await PostModel.find('Cool programming post', 'title')

// Using mongodb query syntax, returns many
await PostModel.get({title : 'Cool programming post'});

```

### Update

```typescript
const post = await PostModel.find('1238712837');
post.title = 'My newly updated title';
await post.save();

await post.update({title : 'My newly updated title'});

await PostModel.query()
    .where({_id : '1238712837'})
    .update({title : 'My newly updated title'});

```

### Delete

```typescript
const post = await PostModel.find('1238712837');
await post.delete();

await PostModel.query()
    .where({_id : '1238712837'})
    .delete();
```


## Model methods

These are other methods that aren't used in the above examples/explanations

### collection()
Return the mongo client collection instance for this model

```typescript
const post = await Post.find('some post id');

post.collection();
```

### collectionName()
Get the name for the mongo collection

```typescript
const post = await Post.find('some post id');

post.collectionName(); // returns posts
```

### count()
Get the count of documents in the collection without any query

```typescript
await Post.count()
```

### dehydrate()
Convert the model to a plain javascript object

```typescript
const post = await Post.find('some post id');

// We can call it staticically with a model instance 
Post.dehydrate(post);

// Or call it on the model directory
post.dehydrate();
```

### hydrate()
Convert the model from a plain javascript object to a model instance

```typescript
const post = {title : 'Some awesome post'}

// We can call it staticically with a model instance 
Post.hydrate(post);

// Or we can use a model instance:
const otherPost = await Post.find('some post id');
otherPost.hydrate(post);

// Or we can use the class constructor to convert it with hydrateUsing()
Post.hydrateUsing(Post, post);
```

### getAttributes()
Get all the data defined on the model as a plain object
This is similar to dehydrate(), except this does not perform proper deserialization

It's mainly used by internals, but could be useful when you need a basic object to remove some keys from or perform some iteration

```typescript
const post = await Post.find('some post id');
post.getAttributes();
```

### isAttribute()
Check if the specified key is a defined property on our Model class

```typescript
const post = await Post.find('some post id');

post.isAttribute('title'); // returns bool
```

### isDateField()
Check if the specified key is defined with a ```@date()``` decorator

```typescript
const post = await Post.find('some post id');

post.isDateField('createdAt'); // returns bool
```

### getModelFields()
Get all the property names defined on our Model class

```typescript
const post = await Post.find('some post id');

post.getModelFields(); // returns string[]
```

### relationIsLoaded()
Check if a relationship property is set
This can be slightly inaccurate also... if we load a relationship
but there isn't a relation to actually load(ie, a user with a book, but it doesnt have a book stored)
then the value of the relationship on the model will be null.

```typescript
const post = await Post.find('some post id');

post.relationIsLoaded('author') // returns bool
```

### refresh()
Loads a fresh instance of the current model from our database and set's the values on our model again.

```typescript
const post = await Post.find('some post id');

await post.refresh() // returns Post
```

### make()
Create an instance of the model without persisting it to the database

```typescript
const post = Post.make({title : 'Some cool post'})

```

### getModelId()
Get the _id field of the model

This is mainly used by internals

```typescript
const post = await Post.find('some post id');

const id = post.getModelId();
```

### isFresh()
Check if our model has been persisted to the database or not

```typescript
const post = await Post.make({title : 'Some cool post'})

post.isFresh() // returns true since our post doesn't have an _id yet

await post.save();

psot.isFresh() // returns false since we now have an _id assigned
```
