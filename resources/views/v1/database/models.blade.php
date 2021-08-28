@extends('v1.layout.app')

@section('content')

    <x-container>


        <x-header>Models</x-header>
        <ul>
            <x-context>Creating a model</x-context>
            <x-sub-context>Using the cli tool</x-sub-context>
            <x-sub-context>Manually creating</x-sub-context>
            <x-context>Model structure</x-context>
            <x-context>Crud Actions</x-context>
            <x-sub-context>Create</x-sub-context>
            <x-sub-context>Read</x-sub-context>
            <x-sub-context>Update</x-sub-context>
            <x-sub-context>Delete</x-sub-context>
        </ul>

        <x-title>Creating a model</x-title>
        <x-text>
            You can do it manually, or use the
            <x-page-link :route="route('overview.cli')">CLI tool</x-page-link>
        </x-text>


        <x-context-sub-title>Using the cli tool</x-context-sub-title>

        <x-code lang="sh" >
            {{--@formatter:off--}}
envuso make:model Post
# This will generate a model for you at /src/Models/PostModel.ts
# You can also use sub directories

envuso make:model Blog/Post
# This will generate a model for you at /src/Models/Blog/PostModel.ts
{{--@formatter:on--}}
        </x-code>

        <x-context-sub-title>Manually creating</x-context-sub-title>
        <x-code >
            {{--@formatter:off--}}
> touch /src/Models/PostModel.ts

import {id, Model} from "@envuso/core/Database";
import {Type} from "class-transformer";
import {ObjectId} from "mongodb";

export class PostModel extends Model&lt;PostModel&gt; {

    // @id allows envuso to take care of the MongoDB object id correctly. It will
    // give the framework knowledge of your primary key.
    @id
    _id: ObjectId;

}
{{--@formatter:on--}}
        </x-code>

        <x-title>Model structure</x-title>
        <x-text>
            All properties on a model will be saved into the database. There is a few more sweet things that come with envuso's models though.
        </x-text>
        <x-code >{{--@formatter:off--}}
export class PostModel extends Model&lt;PostModel&gt; {

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
{{--@formatter:on--}}
        </x-code>

        <x-title>Crud Actions</x-title>
        <x-text>
            Envuso has kind of an ORM built in for MongoDB which is custom made.
            <br />
            You're also not confined to this, you could use MongoDB's client directly if you'd like, but the ORM should cover most of your cases.
            <br />
            There's a lot of convenient methods built in, I also write laravel backends which heavily inspired me, if you
            use Laravel you should feel right at home and notice a lot of similarities with usage/naming.
        </x-text>

        <x-context-sub-title>Create</x-context-sub-title>
        <x-code >{{--@formatter:off--}}
await PostModel.create({
    title : 'Cool programming post',
    content : 'Woot'
});

const post = new PostModel();
post.title = 'Cool programming post';
post.content = 'Woot';
await post.save();
{{--@formatter:on--}}</x-code>

        <x-context-sub-title>Read</x-context-sub-title>
        {{--@formatter:off--}}
<x-code >
await PostModel
    .where({title:'Cool programming post'})
    .first();

await PostModel.paginate(20);

await PostModel.findOne({title:'Cool programming post'});

await PostModel.find('example -> postId');

await PostModel.find('Cool programming post', 'title');
</x-code>
        {{--@formatter:on--}}

        <x-context-sub-title>Update</x-context-sub-title>
        {{--@formatter:off--}}
        <x-code >
const post = await PostModel.find('1238712837');
post.title = 'My newly updated title';
await post.save();

await PostModel
    .where({_id:'1238712837'})
    .update({title: 'My newly updated title'});

const post = await PostModel.find('1238712837');
await post.update({title: 'My newly updated title'});
        </x-code>
        {{--@formatter:on--}}

        <x-context-sub-title>Delete</x-context-sub-title>
        {{--@formatter:off--}}
        <x-code >
const post = await PostModel.find('1238712837');
await post.delete();

await PostModel
    .where({_id:'1238712837'})
    .delete();
        </x-code>
        {{--@formatter:on--}}

    </x-container>



@endsection
