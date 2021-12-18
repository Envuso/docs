# Configuration Overview

## Intro

Envuso has lots of configuration files if you didn't notice already... I intended for things to be quite configurable, but everything comes pre-configured. You can just tweak and extend the framework
via these configuration files.

> You can view the docs for each configuration file below "Overview" in the sidebar. 

## Adding custom configuration files

Due to the way typescript is and how configuration files are dynamically loaded/custom to a project, you have to define them.

In `src/Config/Configuration.ts`, there is a list of configurations loaded which will look something like the below:

```typescript
export default class Configuration extends ConfigurationFile {
    load() {
        this.add('app', import("./AppConfiguration"));
        this.add('auth', import("./AuthConfiguration"));
        this.add('database', import("./DatabaseConfiguration"));
        this.add('redis', import("./RedisConfiguration"));
        this.add('paths', import("./FilesystemPathsConfiguration"));
        this.add('serialization', import("./SerializationConfiguration"));
        this.add('server', import("./ServerConfiguration"));
        this.add('services', import("./ServicesConfiguration"));
        this.add('session', import("./SessionConfiguration"));
        this.add('storage', import("./StorageConfiguration"));
        this.add('websockets', import("./WebsocketsConfiguration"));
        this.add('inertia', import("./InertiaConfiguration"));
        this.add('static', import("./StaticAssetConfiguration"));
        this.add('queue', import("./QueueConfiguration"));
    }
}
```

If you want to add your own config, just add a this.add() and the import

## Configuration "Architecture"

Config files are class based, rather than just an exported object, this is so types can be derived from your config files.

When we create a new configuration file, we must extend the `ConfigurationCredentials` class.

For example:

```typescript
import {ConfigurationCredentials} from "@envuso/core/AppContainer/Config/ConfigurationCredentials";

export class SomeCustomConfiguration extends ConfigurationCredentials {
    configurationValue: string = 'hello from config.';
}
```

## Accessing .env file variables in the config files

When envuso loads your .env file, it loads into the `Environment` class. We can use this class 
to get our env variables, it also has some other nice helpers.

```typescript
import {ConfigurationCredentials} from "@envuso/core/AppContainer/Config/ConfigurationCredentials";
import Environment from "@envuso/core/AppContainer/Config/Environment";

export class SomeCustomConfiguration extends ConfigurationCredentials {
    configurationValue: string = Environment.get('HELLO_MESSAGE', 'some fallback message if env doesnt exist');
}
```
