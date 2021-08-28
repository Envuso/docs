@extends('v1.layout.app')

@section('content')

    <x-container>


        <x-header>Websocket Server</x-header>
        <ul>
            <x-context>Configuration</x-context>
            <x-context>How they work</x-context>
            <x-context>Channels/Listeners</x-context>
            <x-sub-context>SocketListener</x-sub-context>
            <x-sub-context>SocketChannelListener</x-sub-context>
            <x-context>Creating a channel</x-context>
            <x-context>Managing access to a channel</x-context>
            <x-context>Sending a socket message to a user</x-context>
        </ul>


        <x-title>Configuration</x-title>
        <x-text>
            Websockets configuration file can be found at
            <x-inline-code>/src/Config/Websockets.ts</x-inline-code>
        </x-text>
        <x-code>
            {{--@formatter:off--}}
{
    // If you dont want to use websockets, you can completely
    // disable it by setting enabled to false.
    enabled : true,

    // You can define global middleware for all of your websockets
    // channels/listeners to use. In this case, we use JWT on all sockets
    middleware : [
        JwtAuthenticationMiddleware
    ],

    // Under the hood, we use https://www.npmjs.com/package/ws
    options : {
        clientTracking : false
    } as ServerOptions
}
            {{--@formatter:on--}}
        </x-code>

        <x-title>How they work</x-title>
        <x-text>
            Users will connect to a "channel", similar to how socket.io works if you're familiar. A channel
            is a way to keep certain sockets "namespaced" and together for a certain piece of functionality in your app.
            <br>
            <br>
            So let's say we have a chat in our app and this chat has a global public chat and private user to user chats.
            <br>
            <br>
            We would have a "global-chat" channel, and a channel that is namespaced to users, for example "chat:user.1", "chat:user.2".
            <br>
            <br>
            Channel names can be dynamic, as you can see with "chat:user.1".
            <br>
            <br>
            In these channels, we can send events, for example with "global-chat", when a user sends a message, we may send a
            "message" event to the server.
            <br>
            <br>
            The server will receive this message then broadcast it to all users again via the "message" event again.
        </x-text>

        <x-title>Channels/Listeners</x-title>
        <x-text>
            When the framework boots, it will check inside
            <x-inline-code>/src/App/Http/Sockets</x-inline-code>
            for instances of:
            <br>
            <x-inline-code>@envuso/core/Sockets/SocketChannelListener</x-inline-code>
            <br>
            <x-inline-code>@envuso/core/Sockets/SocketListener</x-inline-code>
        </x-text>

        <x-context-sub-title>
            SocketListener
        </x-context-sub-title>
        <x-text>
            SocketListener is the simplest type of a socket handler.
            <br />
            It's abstract class looks like this:
        </x-text>

        <x-code>
            {{--@formatter:off--}}
import {SocketConnection} from "./SocketConnection";
import {SocketPacket} from "./SocketPacket";

export abstract class SocketListener {
    /**
    * The event name to listen
    *
    * @returns {string}
    */
    abstract eventName(): string;
    /**
    * Handle the received socket event
    *
    * @returns {Promise&lt;any&gt;}
    */
    abstract handle(connection: SocketConnection, user: any, packet: SocketPacket): Promise&lt;any&gt;;
}
            {{--@formatter:on--}}
        </x-code>

        <x-text>
            SocketListeners are the simplest type of socket implementations, let's say we just want to send events from our frontend
            to our backend. There is no concept of "channels" with them. Just an "event", similar to how javascript events work.
        </x-text>
        <x-text>
            When we send a socket event that matches the event name we defined on this listener, the listener will pick it up and
            the "handle" method will be called. This is where you will define the logic for this socket event.
        </x-text>

        <x-context-sub-title>
            SocketChannelListener
        </x-context-sub-title>
        <x-text>
            SocketChannelListener is similar to a SocketListener, except it uses channels to namespace the events. Like how I mentioned
            the user chat channels "user:chat.1" etc.
            <br>
            They can use dynamic channel names, so "user:chat.1" is defined as "user:chat.*", however, <strong>they can only have one wildcard value</strong>
        </x-text>
        <x-text>
            It's abstract class looks like:
        </x-text>
        <x-code>
            {{--@formatter:off--}}
import {resolve} from "../AppContainer";
import {Middleware} from "../Routing";
import {SocketConnection} from "./SocketConnection";
import {SocketPacket} from "./SocketPacket";
import {ChannelInformation, SocketServer} from "./SocketServer";

export abstract class SocketChannelListener {
    /**
    * This will output the name for the channel originally subscribed to...
    * For example, the channel "user:*", if we subscribed to
    * channel "user:1" it will be the "user:1" channel.
    */
    public getChannelName() {}
    /**
     * An array of middleware to use for this socket listener
     *
     * @returns {Middleware[]}
     */
    abstract middlewares(): Middleware[];
    /**
     * The name of the channel
     * Can use wildcards, for example "user.*"
     *
     * @returns {string}
     */
    abstract channelName(): string;
    /**
     * Determine if the socket connection can access the specified room
     *
     * This will allow us to lock down a room for a user for example.
     * "user:1" can only send/receive on this room.
     *
     * @returns {Promise&lt;boolean&gt;}
     */
    abstract isAuthorised(connection: SocketConnection, user: any): Promise&lt;boolean&gt;;
    /**
     * Broadcast a packet to a channel with the specified event
     *
     * @param {string} channel
     * @param {string} event
     * @param data
     */
    public broadcast&lt;T extends SocketPacket&gt;(channel:string, event: string, data: T | any) {}

    // Socket events are handled dynamically... cannot really specify any type information
    // So if you happen to look here, these are the available parameters.
    // handle(connection: SocketConnection, user: any, packet : SocketPacket): Promise&lt;any&gt;;
}
{{--@formatter:on--}}
        </x-code>

        <x-title>
            Creating a channel
        </x-title>
        <x-text>
            Let's create a channel for our global chat, in
            <x-inline-code>/src/App/Http/Sockets/</x-inline-code>
            we'll create a class called
            <x-inline-code>GlobalChatSocketChannel</x-inline-code>
        </x-text>

        <x-code>
            {{--@formatter:off--}}
import {injectable} from "@envuso/core/AppContainer";
import {Middleware} from "@envuso/core/Routing";
import {SocketChannelListener} from "@envuso/core/Sockets/SocketChannelListener";
import {SocketConnection} from "@envuso/core/Sockets/SocketConnection";
import {SocketPacket} from "@envuso/core/Sockets/SocketPacket";

@injectable()
export class GlobalChatSocketChannel extends SocketChannelListener {
    public channelName(): string {
        return &quot;global-chat&quot;;
    }

    // We can use this method to allow/deny access to this socket channel...
    public async isAuthorised(connection: SocketConnection, user: User): Promise&lt;boolean&gt; {
        // For example, if we only wanted users with the role "admin" to be able to connect:
        // return user.role === 'admin'
        return true;
    }

    // We can define middlewares that we want to use when connecting
    // This could allow us to have public sockets, but maybe one socket
    // channel requires a JWT to connect to it.
    public middlewares(): Middleware[] {
        return [
            // new JwtAuthenticationMiddleware()
        ];
    }

    // SocketChannelListener's handle their events via methods. For example, if we want
    // to handle the "message" event, we would define the method bellow

    // If we wanted to handle the "deletedMessage" event:
    // async deletedMessage(...): Promise&lt;any&gt; {

    // It's important that we use camelcase/snakecase naming.
    // We cannot register methods for "deleted-message".

    async message(connection: SocketConnection, user: User, packet: SocketPacket): Promise&lt;any&gt; {
        // When we receive the message, we'll broadcast it to all users connected to our "global-chat" channel.
        this.broadcast(&#39;global-chat&#39;, &#39;message&#39;, {message: packet.getData().message});
    }
}
        {{--@formatter:on--}}
        </x-code>

        <x-title>Managing access to a channel</x-title>
        <x-text>
            SocketChannelListeners have a "isAuthorised" method defined on them. You can define custom logic to control
            whether a user can access it or not.
        </x-text>
        <x-text>
            For example, to only allow users with an "admin" role defined:
        </x-text>
        <x-code>
            {{--@formatter:off--}}
public async isAuthorised(connection: SocketConnection, user: User): Promise&lt;boolean&gt; {
    return user.role === 'admin';
}
        {{--@formatter:on--}}
        </x-code>

        <x-title>Sending a socket message to a user</x-title>
        <x-text>
            There's a few different ways you can broadcast on a channel, we'll look at all the different ways below.
        </x-text>


        <x-subtitle>
            From inside of a handler method on our SocketChannelListener:
        </x-subtitle>
        <x-code>
            {{--@formatter:off--}}
// This will send an event on the "global-chat" channel
// The event will be named "message"
// The data sent is {message : 'some message'}
this.broadcast(&#39;global-chat&#39;, &#39;message&#39;, {message: 'some message'});
        {{--@formatter:on--}}
        </x-code>

        <x-subtitle>
            Using the Frameworks SocketServer instance directly, we'll resolve SocketServer from the container:
        </x-subtitle>
        <x-text>
            We need to pass the reference to our "GlobalChatSocketChannel", so that
            it can find all users who have "subscriptions" to this channel.
            <br>
            <br>
            Subscriptions are documented on the
            <x-page-link :route="route('overview.websockets.client')" text="Websockets Client documentation" />
        </x-text>
        <x-code>
            {{--@formatter:off--}}
resolve(SocketServer).broadcast(
    GlobalChatSocketChannel,
    'global-chat',
    'message',
    {message : 'some message'}
);
        {{--@formatter:on--}}
        </x-code>

        <x-subtitle>
            Sending on a channel directly to a user, using a user model:
        </x-subtitle>
        <x-code>
            {{--@formatter:off--}}
const user = await User.find(...);

user.sendSocketChannelEvent(
    GlobalChatSocketChannel,
    'global-chat',
    'message',
    {message : 'some message'}
);
        {{--@formatter:on--}}
        </x-code>

        <x-subtitle>
            Sending an event directly to a users connection, using a user model:
        </x-subtitle>
        <x-code>
            {{--@formatter:off--}}
const user = await User.find(...);

user.sendSocketEvent('message', {message : 'some message'});
        {{--@formatter:on--}}
        </x-code>


    </x-container>



@endsection
