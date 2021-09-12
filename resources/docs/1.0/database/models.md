# Models

More info needed here.


## Creating a model
You can do it manually, or use the [CLI tool](#)
### Using the CLI tool
```sh
envuso make:model Post
# This will generate a model for you at /src/Models/PostModel.ts
# You can also use sub directories

envuso make:model Blog/Post
# This will generate a model for you at /src/Models/Blog/PostModel.ts
```
### Manually creating
```typescript
> touch /src/Models/PostModel.ts

import {id, Model} from "@envuso/core/Database";
import {Type} from "class-transformer";
import {ObjectId} from "mongodb";

export class PostModel extends Model<PostModel> {

	// @id	allows envuso to take care of the MongoDB object id correctly. It will
	// give the framework knowledge of your primary key.
	@id
	_id: ObjectId;

}
```
## Model structure
All properties on a model will be saved into the database. There is a few more sweet things that come with envuso's models though.
```typescript
export class PostModel extends Model<PostModel> {

	@id
	_id: ObjectId;

	// Storing a sub-object
	// Imagine we store photo information in an object(this is purely an example)
	@Type(() => PostPhotoInformation)
	photoInformation: PostPhotoInformation;

	// Storing an array of sub objects:
	@Type(() => PostPhotoInformation)
	// Just make the type an array.
	// For sub-object array conversion to work @Type() is required!
	photoInformation: PostPhotoInformation[];

	// Models also have validation
	@IsNotEmpty()
	@IsEmail()
	authorEmailAddress:string;

}

export class PostPhotoInformation {
	public fileName:string;
	public path:string;
	public size:number;
	public url:string;
}
```
## Crud Actions
Envuso has kind of an ORM built in for MongoDB which is custom made.  
You're also not confined to this, you could use MongoDB's client directly if you'd like, but the ORM should cover most of your cases.  
There's a lot of convenient methods built in, I also write laravel backends which heavily inspired me, if you use Laravel you should feel right at home and notice a lot of similarities with usage/naming.

### Create
```typescript
await PostModel.create({
	title : 'Cool programming post',
	content : 'Woot'
});

const post = new PostModel();
post.title = 'Cool programming post';
post.content = 'Woot';
await post.save();
```
### Read
```typescript
await PostModel
	.where({title:'Cool programming post'})
	.first();

await PostModel.paginate(20);

await PostModel.findOne({title:'Cool programming post'});

await PostModel.find('example -> postId');

await PostModel.find('Cool programming post', 'title');
```
### Update
```typescript
const post = await PostModel.find('1238712837');
post.title = 'My newly updated title';
await post.save();

await PostModel
	.where({_id:'1238712837'})
	.update({title: 'My newly updated title'});

const post = await PostModel.find('1238712837');
await post.update({title: 'My newly updated title'});
```
### Delete
```typescript
const post = await PostModel.find('1238712837');
await post.delete();

await PostModel
	.where({_id:'1238712837'})
	.delete();
```
