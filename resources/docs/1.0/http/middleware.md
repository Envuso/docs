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
