# CLI

## Installing the CLI Tool

```shell
npm install @envuso/cli -g
yarn global add @envuso/cli
```

## envuso build

This will build the framework with typescript compiler and generate some meta/type files. You don't have to use this, but it could make your experience A little more pleasant :)

```shell
envuso build
```

## envuso generate-app-key

When you start a new project, you will need to set an "APP_KEY" in the .env file. This will create a secure random string which will be used for hashing/encryption/cookies

```shell
envuso generate-app-key
```

## envuso new

This will create a new envuso project and give you some options for set-up

```shell
envuso new
```

## envuso make:controller {name}

This will generate a new controller, the first arg "{name}" is the name for your controller.

Adding --resource will generate some basic routes for CRUD operations.

Adding --resource --model=name will generate basic routes for CRUD but also do some basics for model operations.

```shell
envuso make:controller User
envuso make:controller User --resource
envuso make:controller User --resource --model=User 
```

## envuso make:middleware {name}

This will generate a new middleware

```shell
envuso make:middleware {name}
```

## envuso make:model {name}

This will generate a new model

```shell
envuso make:model {name}
```

## envuso make:policy {name}

This will generate a new model policy If --model=name is specified, this will automatically add the @policy decorator to your model.

```shell
envuso make:policy {name}
envuso make:policy {name} --model=name
```

## envuso make:resource {name} --model={modelName}

This will generate a new api resource and configure it for your model

It will also ask you if you wish to add properties from your mode, if you select yes, it will add all of the models properties to the resource to save you some time.

```shell
envuso make:resource {name} --model={modelName}
```

## envuso make:socket-channel-listeners

This will generate a new socket channel listener

```shell
envuso make:socket-channel-listeners
```

## envuso db:seed

Run the envuso database seeders

If you specify --fresh this will wipe your database then run the seeders.

```shell
envuso db:seed
envuso db:seed --fresh
```

## envuso db:reset

Wipe the whole database

```shell
envuso db:reset
```
## envuso db:reset-collection name

Wipe a specific database collection 

```shell
envuso db:reset-collection name
```
