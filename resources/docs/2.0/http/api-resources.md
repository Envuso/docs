# Api Resources

## What are Api Resources?

Api resources provide some structure for returning our data on endpoints

Imagine we have our User - we probably want to return this in different formats depending on different scenarios

The authenticated user may receive a version with their email and other "private" information.

Whereas a user returned anywhere else publicly should have this private information removed.

Api resources provide a nice and clean way of structuring that data and easily returning/reusing it in responses.

## Creating a resource

We can use the envuso CLI to create a resource:

```shell
$ envuso make:resource User --model User
```

This will create a resource from your model, it will also ask you if you want to add your models properties to save some time. This will add all fields defined on your model to this resource, so you
can just remove/add

## Transforming data

Resources will process the data a single object at a time, so if for example we use UserResource.collection(users)
each user in the array will be passed through the resources transform() method

We can access the object we're transforming via ```this.data``` this data is typed by the generic on the ApiResource class.

For example:

```export class UserResource extends ApiResource<User>``` this.data will be a type of User

```export class UserResource extends ApiResource<Book>``` this.data will be a type of Book

Here's an example of a User api resource:

```typescript
export class UserResource extends ApiResource<User> {
    public transform(request: RequestContextContract): any {
        return {
            _id  : this.data._id,
            name : this.data.name,
        };
    }
}
```

### Using other resources inside a resource

```typescript
export class BookResource extends ApiResource<Book> {
    public transform(request: RequestContextContract): any {
        return {
            _id    : this.data._id,
            title  : this.data.title,
            author : AuthorResource.from(this.data.author),
        };
    }
}
```

### Model relations inside resources

What if we only want to show some data if our relation is set?

```typescript
export class BookResource extends ApiResource<Book> {
    public transform(request: RequestContextContract): any {
        return {
            _id   : this.data._id,
            title : this.data.title,

            // We can do it a few different ways
            authorExampleOne : this.whenLoaded('author', this.data.author),
            // Using with a resource - We can provide a resource constructor
            // The rest will be taken care of
            authorExampleTwo : this.whenLoaded('author', AuthorResource),
            // We can also do it this way:
            authorExampleThree : this.whenLoaded('author', AuthorResource.from(this.data.author)),
        };
    }
}
```

### Conditionally adding data

What if we only want to show a field if some condition is true?

```typescript
export class UserResource extends ApiResource<User> {
    public transform(request: RequestContextContract): any {
        return {
            _id   : this.data._id,
            title : this.data.title,
            // This would only add the email field if the resource we're
            // transforming is the authenticated users data
            email : this.when(request.user.getId() === this.data._id, this.data.email)
        };
    }
}
```

### Passing additional data into your resource

Sometimes we need to pass some external values into our api resource to change how things are transformed

Imagine in the case we want to include a users email address when we're using the admin panel, but not when returning the user publicly

```typescript
// We'll just set a const for the sake of example:
const isAdminPanelRequest = true;

// Lets imagine we're returning the resource on a controller method
// We need to add our aditional values as extra parameters
return UserResource.from(user, isAdminPanelRequest);

// We can now add those additional parameters to our transform() method
export class UserResource extends ApiResource<User> {
    public transform(request: RequestContextContract, isAdminRequest: boolean = false): any {
        return {
            _id   : this.data._id,
            title : this.data.title,
            email : this.when(isAdminRequest, this.data.email)
        };
    }
}
```

## Sending resource responses

We can return the Resources from a controller method and all transformations and such will be handled.

### A single model resource object

```typescript
return UserResource.from(await User.query().first());
```

### Returning multiple models or a paginated model object

```typescript
return UserResource.collection(await User.query().paginated(20))
return UserResource.collection(await User.query().get())
```

