@extends('v1.layout.app')

@section('content')

    <x-container>


        <x-header>Middleware</x-header>
        <ul>
            <x-context>Using middleware on all controller methods</x-context>
            <x-context>Using middleware on one method</x-context>
        </ul>

        <x-title>
            Using middleware on all controller methods
        </x-title>

        <x-code whitespace="        ">
        {{--@formatter:off--}}
        // we use new Middleware() so that you can define any additional middleware data
        @middleware(new UserHasRoleMiddleware('admin'))
        @controller('/prefix')
        export class SomethingController extends Controller {

        }
        {{--@formatter:on--}}
        </x-code>

        <x-title>
            Using middleware on one method
        </x-title>

        <x-code whitespace="        ">
        {{--@formatter:off--}}
        @controller('/prefix')
        export class SomethingController extends Controller {

            @middleware(new UserIsAdminMiddleware())
            @get('/admin')
            async adminAction() {

            }

        }
        {{--@formatter:on--}}
        </x-code>


        <x-title>
            Middleware Structure
        </x-title>

        <x-code whitespace="">
        {{--@formatter:off--}}
import {Middleware, RequestContext} from "@envuso/core/Routing";

export class UserIsAdminMiddleware extends Middleware {

    public async handler(context: RequestContext) {

        // hasRole() does not exist in the framework, it's purely an example
        if(!context.user().hasRole('admin')) {
            return response().redirect('/404');
        }

    }

}
        {{--@formatter:on--}}
        </x-code>



    </x-container>



@endsection
