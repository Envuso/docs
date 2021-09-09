<a href="https://envuso.com/"><div class="text-center py-4 lg:px-4">
  <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
    <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">New</span>
    <span class="font-semibold mr-2 text-left flex-auto">Envuso v2.X has been release!</span>
    <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
  </div>
</div></a>

# Controllers

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
