@extends('v1.layout.app')

@section('content')

    <x-container>


        <x-header>Seeders</x-header>
        <ul>
            <x-context>Whats a seeder?</x-context>
            <x-context>Creating a seeder</x-context>
            <x-context>Registering a seeder</x-context>
            <x-context>Running seeders</x-context>
        </ul>

        <x-title>Whats a seeder?</x-title>
        <x-text>
            Seeders allow you to push some required data into your database. For example, if your site needs a list of categories
            stored in the database when it's in production/dev environments.
            <br />
            You can define seeders to publish these categories for you from a simple cli command.
        </x-text>

        <x-title>Creating a seeder</x-title>
        <x-text>
            In
            <x-inline-code>/src/Seeders</x-inline-code>
            create a new ts file, for example. CategoriesSeeder.ts.
        </x-text>

        <x-code >
            {{--@formatter:off--}}
import {Seeder} from "@envuso/core/Database";
import {Category} from "../App/Models/Category";

export class CategoriesSeeder extends Seeder {
    public async seed(): Promise&lt;any&gt; {

        console.log('Hello from our categories seeder.');

        Category.create({title : 'Programming with Envuso'});

    }
}
            {{--@formatter:on--}}
        </x-code>

        <x-text>
            As you can see, inside our
            <x-inline-code>seed()</x-inline-code>
            function, we will publish a single category. In your case,
            you can put any logic inside here that you wish.
            <br />
            Your application could make an api request and store the data from the response, the choice is yours.
        </x-text>


        <x-title>Registering a seeder</x-title>
        <x-text>
            Now that we've created a seeder, we need to let Envuso know about it, lets head into
            <x-inline-code>/src/Seeders/Seeders.ts</x-inline-code>
        </x-text>
        <x-code >
            {{--@formatter:off--}}
import {DatabaseSeeder} from "@envuso/core/Database";
import {CategoriesSeeder} from "./CategoriesSeeder";
import {StoreApiInformationSeeder} from "./StoreApiInformationSeeder";

export class Seeders extends DatabaseSeeder {

    public registerSeeders() {
        this.add(CategoriesSeeder);
        this.add(StoreApiInformationSeeder);
    }

}
            {{--@formatter:on--}}
        </x-code>

        <x-text>
            I tried to keep this as simple as possible, but in short, we just need to add
            <x-inline-code>this.add(CategoriesSeeder)</x-inline-code>
            to the registerSeeders method.
            <br />
            This will bind these seeders to our container when you run
            <x-inline-code>ecli db:seed</x-inline-code>
            , then envuso internals will iterate through your seeders and run them all.
        </x-text>

        <x-title>Running seeders</x-title>
        <x-text>
            Right now, the only way to run them is via the packaged "ecli" file from the core. You should be able to run this in your
            project root via
            <x-inline-code>ecli db:seed</x-inline-code>

            <br />
            <br />
            If this does not work, you may need to access it via node_modules;
            <x-inline-code>./node_modules/.bin/ecli db:seed</x-inline-code>

            <br />
            <br />
            If you face any issues when running ecli db:seed. It may be that you need to build your application.
            <br />
            Try running
            <x-inline-code>yarn/npm run build</x-inline-code>
            and then running db:seed again.
            <br />
            <br />
            I tried to keep this process as simple as possible to use, but it could still be improved. I will for sure take strides towards this.
        </x-text>


    </x-container>



@endsection
