# Request

More info needed here.


## Accessing the request
I was so tired of adding the request/response to the controller method and then passing it through my code, it becomes gross, hopefully we agree.

```typescript
import { request } from "@envuso/core/Routing";

@put('/user/avatar')
async uploadAvatar() {
	const file = request().file('avatar')
}
```

At the moment it's fairly basic, but you can access the underlying fastify request with  <code class="language-typescript">request().fastifyRequest</code>
