<a href="https://envuso.com/"><div class="text-center py-4 lg:px-4">
  <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
    <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">New</span>
    <span class="font-semibold mr-2 text-left flex-auto">Envuso v2.X has been release!</span>
    <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
  </div>
</div></a>

# Middleware

More info needed here.


## Using middleware on all controller methods

```typescript
// we use new Middleware() so that you can define any additional middleware data
@middleware(new UserHasRoleMiddleware('admin'))
@controller('/prefix')
export class SomethingController extends Controller {

}
```
## Using middleware on one method
```typescript
@controller('/prefix')
export class SomethingController extends Controller {

    @middleware(new UserIsAdminMiddleware())
    @get('/admin')
    async adminAction() {

    }

}
```
## Middleware structure
```typescript
import {Middleware, RequestContext} from "@envuso/core/Routing";

export class UserIsAdminMiddleware extends Middleware {

    public async handler(context: RequestContext) {

        // hasRole() does not exist in the framework, it's purely an example
        if(!context.user().hasRole('admin')) {
            return response().redirect('/404');
        }

    }

}
```
