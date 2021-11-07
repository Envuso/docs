# Seeders

## What's a seeder

Seeders allow you to push some required data into your database. For example, if your site needs a list of categories stored in the database when it's in production/dev environments.  
You can define seeders to publish these categories for you from a simple cli command.

## Creating a seeder

In ``` /src/Seeders```  create a new ts file, for example. CategoriesSeeder.ts.

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

As you can see, inside our  ``` seed()```  function, we will publish a single category. In your case, you can put any logic inside here that you wish.  
Your application could make an api request and store the data from the response, the choice is yours.

## Registering a seeder

Now that we've created a seeder, we need to let Envuso know about it, lets head into  ``` /src/Seeders/Seeders.ts```

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

We just need to add  ``` this.add(CategoriesSeeder)```  to the registerSeeders method.  


## Running seeders

You can run seeders using the envuso cli tool

```shell
$ envuso db:seed
```
