# Policies/Gates

More info needed here.


## What are they?
When we're building api's there's usually a lot of logic that we need to write for managing permissions. "Can x user access x feature?" for example.  
We don't want to constantly write this code over all of our code base because it's nasty.  
We want a simple method to be able to re-use this logic in a simple way.

## Creating a policy
We create our policies inside  <code class="language-typescript">/src/App/Policies</code>, they are just regular javascript classes.  
Let's imagine we need a policy to manage whether a user can manage blog posts.

```typescript
import {Authenticatable} from "@envuso/core/Common";
import {User} from "../Models/User";

export class PostPolicy {

	// Our authenticated user model is always injected into the policy
	// We just need to return true/false from each method.
	public async create(user: User) {
		return user.role === 'admin';
	}

	// If you want to check against a model, it will be injected as the second parameter.
	public async update(user: User, post : BlogPost) {
		return post.author_id === user.id;
	}

}
```

Now we need to goto our BlogPost model and add @policy decorator above our model class.  
This will tell the framework that x policy is designated to x model.

```typescript
import {PostPolicy} from '../Policies/PostPolicy'
import {Model, policy} from "@envuso/core/Database";

@policy(PostPolicy)
export class BlogPost extends Model<BlogPost> {
```
## Using  a policy
We can use our policy methods in a couple of different ways. I tried to keep this simple/sweet and short to use.
### We can use them from controller methods
```typescript
// We have to pass our model class to the can method so it knows which policy we're trying to use.
await this.can('create', BlogPost);

// When we're using a model instance, we can pass that instead:
const blogPost = await BlogPost.find(...);
await this.can('update', blogPost);

// We can also do:
this.cannot('create', BlogPost);
```
### With an authed user instance
```typescript
const user = Auth.user();

await user.can('create', BlogPost);
await user.can('update', blogPost);

await user.cannot('create', BlogPost);
await user.cannot('update', blogPost);
```
