<a href="https://envuso.com/"><div class="text-center py-4 lg:px-4">
  <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
    <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">New</span>
    <span class="font-semibold mr-2 text-left flex-auto">Envuso v2.X has been release!</span>
    <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
  </div>
</div></a>

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
