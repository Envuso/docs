# Seeders

More info needed here.


## What's a seeder
Seeders allow you to push some required data into your database. For example, if your site needs a list of categories stored in the database when it's in production/dev environments.  
You can define seeders to publish these categories for you from a simple cli command.
## Creating a seeder
In  `/src/Seeders`  create a new ts file, for example. CategoriesSeeder.ts.

```typescript
import {Seeder} from "@envuso/core/Database";
import {Category} from "../App/Models/Category";

export class CategoriesSeeder extends Seeder {
	public async seed(): Promise<any> {

		console.log('Hello from our categories seeder.');

		Category.create({title : 'Programming with Envuso'});

	}
}
```

As you can see, inside our  `seed()`  function, we will publish a single category. In your case, you can put any logic inside here that you wish.  
Your application could make an api request and store the data from the response, the choice is yours.

## Registering a seeder
Now that we've created a seeder, we need to let Envuso know about it, lets head into  `/src/Seeders/Seeders.ts`

```typescript
import {DatabaseSeeder} from "@envuso/core/Database";
import {CategoriesSeeder} from "./CategoriesSeeder";
import {StoreApiInformationSeeder} from "./StoreApiInformationSeeder";

export class Seeders extends DatabaseSeeder {

	public registerSeeders() {
		this.add(CategoriesSeeder);
		this.add(StoreApiInformationSeeder);
	}

}
```

I tried to keep this as simple as possible, but in short, we just need to add  `this.add(CategoriesSeeder)`  to the registerSeeders method.  
This will bind these seeders to our container when you run  `ecli db:seed`  , then envuso internals will iterate through your seeders and run them all.

## Running seeders
Right now, the only way to run them is via the packaged "ecli" file from the core. You should be able to run this in your project root via `ecli db:seed`

If this does not work, you may need to access it via node_modules; `./node_modules/.bin/ecli db:seed`

If you face any issues when running ecli db:seed. It may be that you need to build your application.  
Try running `yarn/npm run build` and then running db:seed again.

I tried to keep this process as simple as possible to use, but it could still be improved. I will for sure take strides towards this.
