# Websocket Server

More info needed here.


## Configuration
Websockets configuration file can be found at  <code class="language-typescript">/src/Config/Websockets.ts</code>

```typescript
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
```

## How they Work
Users will connect to a "channel", similar to how socket.io works if you're familiar. A channel is a way to keep certain sockets "namespaced" and together for a certain piece of functionality in your app.

So let's say we have a chat in our app and this chat has a global public chat and private user to user chats.

We would have a "global-chat" channel, and a channel that is namespaced to users, for example "chat:user.1", "chat:user.2".

Channel names can be dynamic, as you can see with "chat:user.1".

In these channels, we can send events, for example with "global-chat", when a user sends a message, we may send a "message" event to the server.

The server will receive this message then broadcast it to all users again via the "message" event again.
## Channels/Listeners
When the framework boots, it will check inside <code class="language-typescript">/src/App/Http/Sockets</code> for instances of:  
<code class="language-typescript">@envuso/core/Sockets/SocketChannelListener</code><br>
<code class="language-typescript">@envuso/core/Sockets/SocketListener</code>
### Socket Listener
SocketListener is the simplest type of a socket handler.  
It's abstract class looks like this:

```typescript
import {SocketConnection} from "./SocketConnection";
import {SocketPacket} from "./SocketPacket";

export abstract class SocketListener {
	/**
	* The event name to listen
	*
	* @returns	{string}
	*/
	abstract eventName(): string;
	/**
	* Handle the received socket event
	*
	* @returns	{Promise<any>}
	*/
	abstract handle(connection: SocketConnection, user: any, packet: SocketPacket): Promise<any>;
}
```

SocketListeners are the simplest type of socket implementations, let's say we just want to send events from our frontend to our backend. There is no concept of "channels" with them. Just an "event", similar to how javascript events work.

When we send a socket event that matches the event name we defined on this listener, the listener will pick it up and the "handle" method will be called. This is where you will define the logic for this socket event.
### Socket Channel Listener
SocketChannelListener is similar to a SocketListener, except it uses channels to namespace the events. Like how I mentioned the user chat channels "user:chat.1" etc.  
They can use dynamic channel names, so "user:chat.1" is defined as "user:chat.*", however,  **they can only have one wildcard value**

It's abstract class looks like:

```typescript
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
	 * @returns	{Middleware[]}
	 */
	abstract middlewares(): Middleware[];
	/**
	 * The name of the channel
	 * Can use wildcards, for example "user.*"
	 *
	 * @returns	{string}
	 */
	abstract channelName(): string;
	/**
	 * Determine if the socket connection can access the specified room
	 *
	 * This will allow us to lock down a room for a user for example.
	 * "user:1" can only send/receive on this room.
	 *
	 * @returns	{Promise<boolean>}
	 */
	abstract isAuthorised(connection: SocketConnection, user: any): Promise<boolean>;
	/**
	 * Broadcast a packet to a channel with the specified event
	 *
	 * @param	{string} channel
	 * @param	{string} event
	 * @param	data
	 */
	public broadcast<T extends SocketPacket>(channel:string, event: string, data: T | any) {}

	// Socket events are handled dynamically... cannot really specify any type information
	// So if you happen to look here, these are the available parameters.
	// handle(connection: SocketConnection, user: any, packet : SocketPacket): Promise<any>;
}
```
## Creating a channel
Let's create a channel for our global chat, in  <code class="language-typescript">/src/App/Http/Sockets/</code>  we'll create a class called  <code class="language-typescript">GlobalChatSocketChannel</code>

```typescript
import {injectable} from "@envuso/core/AppContainer";
import {Middleware} from "@envuso/core/Routing";
import {SocketChannelListener} from "@envuso/core/Sockets/SocketChannelListener";
import {SocketConnection} from "@envuso/core/Sockets/SocketConnection";
import {SocketPacket} from "@envuso/core/Sockets/SocketPacket";

@injectable()
export class GlobalChatSocketChannel extends SocketChannelListener {
	public channelName(): string {
		return "global-chat";
	}

	// We can use this method to allow/deny access to this socket channel...
	public async isAuthorised(connection: SocketConnection, user: User): Promise<boolean> {
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
	// async deletedMessage(...): Promise<any> {

	// It's important that we use camelcase/snakecase naming.
	// We cannot register methods for "deleted-message".

	async message(connection: SocketConnection, user: User, packet: SocketPacket): Promise<any> {
		// When we receive the message, we'll broadcast it to all users connected to our "global-chat" channel.
		this.broadcast('global-chat', 'message', {message: packet.getData().message});
	}
}
```

## Managing access to a channel
SocketChannelListeners have a "isAuthorised" method defined on them. You can define custom logic to control whether a user can access it or not.

For example, to only allow users with an "admin" role defined:

```typescript
public async isAuthorised(connection: SocketConnection, user: User): Promise<boolean> {
	return user.role === 'admin';
}
```

## Sending a socket message to a user
There's a few different ways you can broadcast on a channel, we'll look at all the different ways below.

#### From inside of a handler method on our SocketChannelListener:

```typescript
// This will send an event on the "global-chat" channel
// The event will be named "message"
// The data sent is {message : 'some message'}
this.broadcast('global-chat', 'message', {message: 'some message'});
```
#### Using the Frameworks SocketServer instance directly, we'll resolve SocketServer from the container:

We need to pass the reference to our "GlobalChatSocketChannel", so that it can find all users who have "subscriptions" to this channel.

Subscriptions are documented on the  [Websockets Client documentation](https://envuso.com/v2/client)

```typescript
resolve(SocketServer).broadcast(
	GlobalChatSocketChannel,
	'global-chat',
	'message',
	{message : 'some message'}
);
```

#### Sending on a channel directly to a user, using a user model:

```typescript
const user = await User.find(...);

user.sendSocketChannelEvent(
	GlobalChatSocketChannel,
	'global-chat',
	'message',
	{message : 'some message'}
);
```

#### Sending an event directly to a users connection, using a user model:

```typescript
const user = await User.find(...);

user.sendSocketEvent('message', {message : 'some message'});
```
