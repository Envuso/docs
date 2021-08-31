# Authentication

More info needed here.


## Authentication
JWT Authentication, registration and login are all handled for you out of the box.  
You can extend or customise parts to your liking.

## Here's some of the methods available to you

## Login with credentials
You can pass the users credentials to this method to log them in.  
This will only authorise them for this request, since authentication is JWT orientated.  
This method will also take care of comparing the plain password to the hashed password

```typescript
import {Auth} from "@envuso/core";
		import {User} from "Models/User";

		await Auth.attempt({
			email : '...',
			password: '...'
		});

		// You can also use

		const user = await User.find(userId);

		await Auth.loginAs(user);
```

## Validate login credentials
You can pass the users email and password(for example) directly from your register endpoint to this method.  
It will check if a user exists and return true/false if this user can be registered.

```typescript
import {Auth} from "@envuso/core";

		const canRegister = await Auth.canRegisterAs({
			email : '...',
			password : '...'
		});

		if(canRegister) {
			// do something...
		}
```
## Check if user is authenticated
Check if a user is authenticated for this request

```typescript
import {Auth} from "@envuso/core";

		if(!Auth.check()) {
			throw new UnauthorisedException();
		}
```

## Authed user
Returns the authenticated user for this request.  
The user is always a type of  **AuthorisedUser**

```typescript
import {AuthorisedUser} from "@envuso/core";
		import {Auth} from "@envuso/core";

		const user : AuthorisedUser = Auth.user();
```
## Obtaining a JWT for an authenticated user
Returns the authenticated user for this request.  
The user is always a type of  **AuthorisedUser**

```typescript
import {AuthorisedUser} from "@envuso/core";
		import {User} from "@App/Models/User";
		import {Auth} from "@envuso/core";

		let user = await User.find(userId);

		if(!await Auth.loginAs(user)) {
			// Login failed...
		}

		user : AuthorisedUser = Auth.user();

		return response().json({
			token : user.generateToken()
		});
```
