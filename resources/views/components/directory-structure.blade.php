<!-- @formatter:off -->

<div class="structure my-6 bg-opacity-50 text-gray-300 bg-gray-800 overflow-x-auto p-4 rounded-lg shadow-lg font-medium whitespace-pre font-mono">{{--
--}}<x-folder prefix="├── " name="App"/>
|   ├──<span class="description font-semibold text-xs px-2 py-0.5 bg-gray-700 rounded-md shadow-md">Modifiable interfaces that the core will use</span>
<x-folder prefix="│   ├── " name="Contracts"/>
│   │   └── AuthContracts.ts
│   ├──<span class="description font-semibold text-xs px-2 py-0.5 bg-gray-700 rounded-md shadow-md">Exceptions used by the core</span>
<x-folder prefix="│   ├── " name="Exceptions"/>
│   │   ├──<span class="description font-semibold text-xs px-2 py-0.5 bg-gray-700 rounded-md shadow-md">Generic Exception that you can extend</span>
│   │   ├── Exception.ts
│   │   ├──<span class="description font-semibold text-xs px-2 py-0.5 bg-gray-700 rounded-md shadow-md">Modify the responses of an exception</span>
│   │   ├── ExceptionHandler.ts
│   │   ├──<span class="description font-semibold text-xs px-2 py-0.5 bg-gray-700 rounded-md shadow-md">When the user cannot be authorised</span>
│   │   ├── UnauthorisedException.ts
│   │   └──<span class="description font-semibold text-xs px-2 py-0.5 bg-gray-700 rounded-md shadow-md">Class validation failed</span>
│   │   └── ValidationException.ts
<x-folder prefix="│   ├── " name="Http"/>
│   │   ├──<span class="description font-semibold text-xs px-2 py-0.5 bg-gray-700 rounded-md shadow-md">All your endpoint controllers</span>
<x-folder prefix="│   │   ├── " name="Controllers"/>
<x-folder prefix="│   │   │   └── " name="Auth"/>
│   │   │       ├──<span class="description font-semibold text-xs px-2 py-0.5 bg-gray-700 rounded-md shadow-md">A base controller containing JWT Auth</span>
│   │   │       └── AuthController.ts
<x-folder prefix="│   │   └── " name="Middleware"/>
│   │       ├──<span class="description font-semibold text-xs px-2 py-0.5 bg-gray-700 rounded-md shadow-md">A base for only allowing authorised users access</span>
│   │       └── AuthorizationMiddleware.ts
<x-folder prefix="│   └── " name="Models"/>
│       ├──<span class="description font-semibold text-xs px-2 py-0.5 bg-gray-700 rounded-md shadow-md">The base User model, the core will use this, do not rename.</span>
│       └── User.ts
├──<span class="description font-semibold text-xs px-2 py-0.5 bg-gray-700 rounded-md shadow-md">All of your app configuration</span>
<x-folder prefix="├── " name="Config"/>
│   ├── app.ts
│   ├── auth.ts
│   ├── database.ts
│   ├── http.ts
│   ├── index.ts
│   ├── providers.ts
│   └── storage.ts
├──<span class="description font-semibold text-xs px-2 py-0.5 bg-gray-700 rounded-md shadow-md">An example test using Jest</span>
<x-folder prefix="├── " name="__tests__"/>
│   └── example.test.ts
└──<span class="description font-semibold text-xs px-2 py-0.5 bg-gray-700 rounded-md shadow-md">Framework/Server bootstrapping and initialisation</span>
└── index.ts
</div>



<!-- @formatter:on -->

