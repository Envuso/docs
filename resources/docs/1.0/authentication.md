<a href="https://envuso.com/"><div class="text-center py-4 lg:px-4">
  <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
    <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">New</span>
    <span class="font-semibold mr-2 text-left flex-auto">Envuso v2.X has been release!</span>
    <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
  </div>
</div></a>

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
