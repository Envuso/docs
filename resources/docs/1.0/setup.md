<a href="https://envuso.com/"><div class="text-center py-4 lg:px-4">
  <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
    <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">New</span>
    <span class="font-semibold mr-2 text-left flex-auto">Envuso v2.X has been release!</span>
    <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
  </div>
</div></a>

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

## Directory Structure

You can export the current file by clicking **Export to disk** in the menu. You can choose to export the file as plain Markdown, as HTML using a Handlebars template or as a PDF.

