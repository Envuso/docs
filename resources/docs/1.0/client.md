<a href="https://envuso.com/"><div class="text-center py-4 lg:px-4">
  <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
    <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">New</span>
    <span class="font-semibold mr-2 text-left flex-auto">Envuso v2.X has been release!</span>
    <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
  </div>
</div></a>

# Socket Client

More info needed here.


## Installation

```shell
yarn add @envuso/socket-client
npm install @envuso/socket-client
```

## Setup

```typescript
import {SocketClient, SocketChannel} from '@envuso/socket-client';

const client = new SocketClient('ws://your-server-url');

// Connect to the server using a users JWT
await client.usingJWT('a users jwt').connect();
```

You're now connected to the server and can begin registering subscriptions/listeners.

## Subscribing to a channel
```typescript
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
```

## Receiving events on a channel
```typescript
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
```

## Receiving non-channel events

```typescript
import {SocketClient, SocketChannel} from '@envuso/socket-client';

const client = new SocketClient('ws://your-server-url');
await client.usingJWT('a users jwt').connect();

let globalChatChannel : SocketChannel = null;

client.listen('message', onNewMessage);

const onNewMessage = (data : {message:string}) => {
	console.log('New message: ', data.message);
});
```

## Unsubscribe from a channel

```typescript
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
```

## Disconnect from sockets

```typescript
import {SocketClient, SocketChannel} from '@envuso/socket-client';

const client = new SocketClient('ws://your-server-url');
await client.usingJWT('a users jwt').connect();

client.disconnect();
```

## Re-connecting when a client is disconnected
When a client gets disconnected from the server due to something like an internet drop-out.  
The client will automatically continue to retry to connect to the server.
