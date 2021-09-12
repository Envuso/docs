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
