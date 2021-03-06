# Setup


## Why build another framework?

I've been trying a few different frameworks and putting things together of our own... it's never how you want it to be. I don't think this will be the perfect solution for everyone neither.

I really like how Laravel and NestJS work and how you build with them. It inspired me to create something of my own. I originally created a lot of this for a hackathon project, but it was actually decent.

## Installation

```typescript
npm install @envuso/cli -g
yarn global add @envuso/cli

# You can now use "envuso" to create and manage your project
```


## Creating your first project

If you have installed the CLI tool from above, you can now generate your project by running <code class="language-typescript">envuso  new</code> and following the steps, it should take less than 30 seconds.

You can also clone the framework structure and set up everything yourself

## Using Envuso CLI

```typescript
// Preferred way of creating a project
npm install @envuso/cli -g
envuso new
// You will be taken through a few basic steps
> ? Project folder name? EnvusoProject
> ? Your project will be created at: /Users/sam/Code/EnvusoProject
> Is this okay? (Y/n)
? Which package manager do you wish to use?
npm
❯ yarn

// Your project will now be setup for you :)
```

## Doing it yourself

```typescript
// You can also do it your self manually
git clone @envuso/framework my-awesome-project
cd my-awesome-project
yarn
cp example.env .env
// Set the APP_KEY in .env file, you can self generate a key and add it to your .env file
> node -e 'console.log(require("crypto").randomBytes(16).toString("hex"))'

// You're all done :)
```

## Configuration

You will also need to configure your .env file.  
There will be an **example.env** file, which you can copy and rename to **.env** you can use <code class="language-typescript">cp example.env  .env</code>

You may need to change the following values:  
**APP_KEY, APP_HOST, CORS_ORIGIN**

