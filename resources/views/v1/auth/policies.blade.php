@extends('v1.layout.app')

@section('content')
    <x-container>


        <x-header>Policies/Gates</x-header>
        <ul>
            <x-context>What are they?</x-context>
            <x-context>Creating a policy</x-context>
            <x-context>Using a policy</x-context>
            <x-sub-context>We can use them from controller methods:</x-sub-context>
            <x-sub-context>With an authed user instance:</x-sub-context>
        </ul>

        <x-title>What are they?</x-title>

        <x-text>
            When we're building api's there's usually a lot of logic that we need to write
            for managing permissions. "Can x user access x feature?" for example.
            <br>
            We don't want to constantly write this code over all of our code base because it's nasty.
            <br>
            We want a simple method to be able to re-use this logic in a simple way.
        </x-text>


        <x-title>Creating a policy</x-title>
        <x-text>
            We create our policies inside <x-inline-code>/src/App/Policies</x-inline-code>, they are just regular javascript classes.
            <br>
            Let's imagine we need a policy to manage whether a user can manage blog posts.
        </x-text>

        <x-code :whitespace="''">
{{--@formatter:off--}}
import {Authenticatable} from "@envuso/core/Common";
import {User} from "../Models/User";

export class PostPolicy {

    // Our authenticated user model is always injected into the policy
    // We just need to return true/false from each method.
    public async create(user: User) {
        return user.role === 'admin';
    }

    // If you want to check against a model, it will be injected as the second parameter.
    public async update(user: User, post : BlogPost) {
        return post.author_id === user.id;
    }

}
{{--@formatter:on--}}
        </x-code>

        <x-text>
            Now we need to goto our BlogPost model and add @policy decorator above our model class.
            <br>
            This will tell the framework that x policy is designated to x model.
        </x-text>

        <x-code whitespace="">
{{--@formatter:off--}}
import {PostPolicy} from '../Policies/PostPolicy'
import {Model, policy} from "@envuso/core/Database";

@policy(PostPolicy)
export class BlogPost extends Model&lt;BlogPost&gt; {
{{--@formatter:on--}}
        </x-code>

        <x-title>Using a policy</x-title>

        <x-text>
            We can use our policy methods in a couple of different ways. I tried to keep this simple/sweet and short to use.
        </x-text>

        <x-context-sub-title>
            We can use them from controller methods:
        </x-context-sub-title>

        <x-code whitespace="">
{{--@formatter:off--}}
// We have to pass our model class to the can method so it knows which policy we're trying to use.
await this.can('create', BlogPost);

// When we're using a model instance, we can pass that instead:
const blogPost = await BlogPost.find(...);
await this.can('update', blogPost);

// We can also do:
this.cannot('create', BlogPost);
{{--@formatter:on--}}
        </x-code>

        <x-context-sub-title>
            With an authed user instance:
        </x-context-sub-title>

        <x-code whitespace="">
{{--@formatter:off--}}
const user = Auth.user();

await user.can('create', BlogPost);
await user.can('update', blogPost);

await user.cannot('create', BlogPost);
await user.cannot('update', blogPost);
{{--@formatter:on--}}
        </x-code>

    </x-container>
@endsection
