# # Controllers

More info needed here.


## Controllers can be generated
First of all, save yourself the hassle, controllers can be generated.  
Here's what available:

```typescript
# You do not need to specify "Controller".
# "Login" will be generated as "LoginController"
envuso make:controller Login

# Generate a controller with basic CRUD layout
envuso make:controller Tasks --resource

# Generate a controller for basic CRUD with your model
# NOTE: This does not generate a model for you.
envuso make:controller Tasks --resource --model Task
```
## Controller structure

```typescript
// All controllers must use the @controller() decorator
@controller('/prefix')
export class SomethingController extends Controller {
	// This is all that is needed. Controllers will automatically
	// be detected on framework boot and bind to the fastify instance.
}
```
