# Data Transfer Objects

More info needed here.


## Why?
They provide a way for you to wrap your data, automatically convert your request data from json to classes via dependency injection and validate the data set on the class.  
Over all, it provides more safety, keeps things structured and follows object orientated principles.


## Examples
Imagine we allow our user to create a post, we'll create a Data Transfer Object to take this data from the controller.  
One example will show how it works without validation and one with validation.

```typescript
import {put, body, DataTransferObject } from "@envuso/core/Routing";
		import {IsString, Length, MaxLength} from "class-validator";
		import {Auth} from "@envuso/core/Authentication";

		class CreatePostRequest extends DataTransferObject {
			// We want our post to have a title and have it limited to min 3 chars, max 20 chars.
			@IsString()
			@Length(3, 30)
			title : string;

			// We want our post to have some content and have a max of 500 chars.
			@IsString()
			@MaxLength(500)
			content:string;

			userId: number = null;
		}

		@put('/post')
		async createPost(@dto() postRequestDto : CreatePostRequest) {
			// We can now access postRequestDto.title / postRequestDto.content
			// It will also have full type safety

			// If our data is not valid, ie content is over 500 chars. A ValidationException will be thrown.
		}

		// Just an example to show manual validation
		@put('/post/admin')
		async adminCreatePost(@dto(false) postRequestDto : CreatePostRequest) {
			// Lets say in this case, we don't want to auto validate because
			// we have a parameter which we want to add to the DTO ourselves

			postRequestDto.userId = Auth.id();

			await postRequestDto.validate()

			// You can use these methods to do something with validation errors
			postRequestDto.failed()
			postRequestDto.errors()
		}
```
## Additional Info
You can use Data Transfer Objects where ever you like in your project, but **@dto() decorator will only work on controller methods.**
