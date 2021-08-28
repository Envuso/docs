@extends('v1.layout.app')

@section('content')

    <x-container>


        <x-header>Cache</x-header>
        <ul>
            <x-context>Introduction</x-context>
            <x-context>Obtaining a cache instance</x-context>
            <x-context>Introduction</x-context>
            <x-context>Obtaining a cache instance</x-context>
            <x-context>Retrieving items from the cache</x-context>
            <x-context>Storing items in the cache</x-context>
            <x-context>Removing items from the cache</x-context>
            <x-context>Check if item exists in cache</x-context>
            <x-context>Retrieve and store</x-context>
        </ul>

        <x-title>Introduction</x-title>
        <x-text>
            Right now the cache implementation is quite basic and is based only on Redis.
            <br>
            <strong>Caching will only will only work if you have "redis : {enabled : true}" in your
                <x-inline-code>/src/Config/Database.ts</x-inline-code>
                    config file.</strong>
        </x-text>


        <x-title>Obtaining a cache instance</x-title>
        <x-text>
            You can use it directly via the container, or via static methods
        </x-text>
        <x-code>
            {{--@formatter:off--}}
import {Cache} from '@envuso/core/Cache';
import {resolve} from '@envuso/core/AppContainer';

Cache.set()
resolve(Cache).set()
        {{--@formatter:on--}}
        </x-code>

        <x-title>Retrieving items from the cache</x-title>
        <x-text>
            All cache methods are async, so you will need to use .then() or await them to get the result.
            <br>
            You can pass a second parameter to .get() to provide as the default value if the item does not exist in the cache.
            <br>
            By default, the second parameter will return null
        </x-text>
        <x-code>
            {{--@formatter:off--}}
const value = await Cache.get('some-key');

const nonExistentValue = await Cache.get('some-non-existent-value', 'woop');

console.log(nonExistentValue); // returns 'woop';
        {{--@formatter:on--}}
        </x-code>

        <x-title>Storing items in the cache</x-title>
        <x-subtitle>
            Storing the item forever:
        </x-subtitle>

        <x-code>
            {{--@formatter:off--}}
import {Cache} from '@envuso/core/Cache';

await Cache.put('some-key', 'some value');
            {{--@formatter:on--}}
        </x-code>
        <x-subtitle>
            Adding an item that expires at x time
        </x-subtitle>
        <x-text>
            We can create a new DateTime instance and pass this as a third parameter to set the value to expire at x time.
        </x-text>

        <x-code>
            {{--@formatter:off--}}
import {Cache} from '@envuso/core/Cache';
import {DateTime} from '@envuso/core/Common';

await Cache.put('some-key', 'some value', DateTime.now().addSeconds(20));

// 25 seconds later...
setTimeout(async () => {
    console.log(await Cache.get('some-key')) // returns null
}, 25 * 1000);
            {{--@formatter:on--}}
        </x-code>

        <x-title>Removing items from the cache</x-title>
        <x-code>
            {{--@formatter:off--}}
import {Cache} from '@envuso/core/Cache';

await Cache.remove('some-key');
        {{--@formatter:on--}}
        </x-code>


        <x-title>Check if item exists in cache</x-title>
        <x-text>
            .exists() will return true if the item exists, false if it does not exist.
        </x-text>
        <x-code>
            {{--@formatter:off--}}
import {Cache} from '@envuso/core/Cache';

await Cache.exists('some-key'); // returns true or false
        {{--@formatter:on--}}
        </x-code>


        <x-title>Retrieve and store</x-title>
        <x-text>
            Sometimes we may want to store an item in the cache, but return a default if it doesn't. This is how .get() works.
            <br>
            But... what if we want to store an item in the cache if it doesn't exist?
            <br>
            .remember() will return the item from the cache if it exists, if it doesn't, it will add your item and then return it.
        </x-text>
        <x-code>
            {{--@formatter:off--}}
import {Cache} from '@envuso/core/Cache';

await Cache.remember('some-key', () => await User.get(), DateTime.now().addSeconds(20));
        {{--@formatter:on--}}
        </x-code>


    </x-container>



@endsection
