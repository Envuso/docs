@extends('v1.layout.app')

@section('content')

    <x-container>


        <x-header>Socket Client</x-header>
        <ul>
            <x-context>Installation</x-context>
            <x-context>Setup</x-context>
            <x-context>Subscribing to a channel</x-context>
            <x-context>Receiving events on a channel</x-context>
            <x-context>Receiving non-channel events</x-context>
            <x-context>Unsubscribe from a channel</x-context>
            <x-context>Disconnecting from sockets</x-context>
            <x-context>Re-connecting when a client is disconnected</x-context>
            <x-context></x-context>
        </ul>


        <x-title>Installation</x-title>
        <x-code lang="shell">
            {{--@formatter:off--}}
yarn add @envuso/socket-client
npm install @envuso/socket-client
        {{--@formatter:on--}}
        </x-code>

        <x-title>Setup</x-title>
        <x-code>
            {{--@formatter:off--}}
import {SocketClient, SocketChannel} from '@envuso/socket-client';

const client = new SocketClient('ws://your-server-url');

// Connect to the server using a users JWT
await client.usingJWT('a users jwt').connect();
        {{--@formatter:on--}}
        </x-code>
        <x-text>
            You're now connected to the server and can begin registering subscriptions/listeners.
        </x-text>

        <x-title>Subscribing to a channel</x-title>
        <x-code>
            {{--@formatter:off--}}
import {SocketClient, SocketChannel} from '@envuso/socket-client';

const client = new SocketClient('ws://your-server-url');
await client.usingJWT('a users jwt').connect();

let globalChatChannel : SocketChannel = null;

client.subscribe('global-chat', (error, channel : SocketChannel) => {
    if(error) {
        console.error(error);
        return;
    }

    globalChatChannel = channel;
});


        {{--@formatter:on--}}
        </x-code>

        <x-title>Receiving events on a channel</x-title>
        <x-code>
            {{--@formatter:off--}}
import {SocketClient, SocketChannel} from '@envuso/socket-client';

const client = new SocketClient('ws://your-server-url');
await client.usingJWT('a users jwt').connect();

let globalChatChannel : SocketChannel = null;

client.subscribe('global-chat', (error, channel : SocketChannel) => {
    if(error) {
        console.error(error);
        return;
    }

    globalChatChannel = channel;

    channel.listen('message', onNewMessage);
});

const onNewMessage = (data : {message:string}) => {
    console.log('New global chat message: ', data.message);
});
        {{--@formatter:on--}}
        </x-code>

        <x-title>Receiving non-channel events</x-title>
        <x-code>
            {{--@formatter:off--}}
import {SocketClient, SocketChannel} from '@envuso/socket-client';

const client = new SocketClient('ws://your-server-url');
await client.usingJWT('a users jwt').connect();

let globalChatChannel : SocketChannel = null;

client.listen('message', onNewMessage);

const onNewMessage = (data : {message:string}) => {
    console.log('New message: ', data.message);
});
        {{--@formatter:on--}}
        </x-code>

        <x-title>Unsubscribe from a channel</x-title>
        <x-code>
            {{--@formatter:off--}}
import {SocketClient, SocketChannel} from '@envuso/socket-client';

const client = new SocketClient('ws://your-server-url');
await client.usingJWT('a users jwt').connect();

client.subscribe('global-chat', (error, channel : SocketChannel) => {
    if(error) {
        console.error(error);
        return;
    }

    // Kind of pointless to subscribe to disconnect, but shows the full implementation :D
    channel.unsubscribe();

});
        {{--@formatter:on--}}
        </x-code>

        <x-title>Disconnect from sockets</x-title>
        <x-code>
            {{--@formatter:off--}}
import {SocketClient, SocketChannel} from '@envuso/socket-client';

const client = new SocketClient('ws://your-server-url');
await client.usingJWT('a users jwt').connect();

client.disconnect();
        {{--@formatter:on--}}
        </x-code>

        <x-title>
            Re-connecting when a client is disconnected
        </x-title>
        <x-text>
            When a client gets disconnected from the server due to something like an internet drop-out.
            <br>
            The client will automatically continue to retry to connect to the server.
        </x-text>


    </x-container>



@endsection
