@extends('v1.layout.app')

@section('content')

    <x-container>


        <x-header>Encryption/Hashing</x-header>
        <ul>
            <x-context>Encryption</x-context>
            <x-sub-context>Introduction</x-sub-context>
            <x-sub-context>Encrypting a value</x-sub-context>
            <x-sub-context>Decrypting a value</x-sub-context>
            <x-sub-context>Getting a secure random</x-sub-context>

            <x-context>Hashing</x-context>
            <x-sub-context>Introduction</x-sub-context>
            <x-sub-context>Hashing with Bcrypt</x-sub-context>
            <x-sub-context>Checking a hash with Bcrypt</x-sub-context>
        </ul>

       <div>
           <x-title>Encryption</x-title>
           <x-context-sub-title>Introduction</x-context-sub-title>
           <x-text>
               Under the hood we use
               <x-page-link route="https://www.npmjs.com/package/simple-crypto-js">SimpleCryptoJS</x-page-link>
               <br>
               Before you can use any Encryption features, you will need an "APP_KEY" set in your .env file. This should be done already, but just a note!
           </x-text>

           <x-context-sub-title>Encrypting a value</x-context-sub-title>
           <x-code>
               {{--@formatter:off--}}
               import {Encryption} from '@envuso/core/Crypt';
               Encryption.encrypt('some string');
               {{--@formatter:on--}}
           </x-code>

           <x-context-sub-title>Decrypting a value</x-context-sub-title>
           <x-code>
               {{--@formatter:off--}}
               import {Encryption} from '@envuso/core/Crypt';

               const encryptedString = Encryption.encrypt('some string');
               const decryptedString = Encryption.decrypt(encryptedString);

               console.log(decryptedString); // 'some string'
               {{--@formatter:on--}}
           </x-code>

           <x-context-sub-title>Getting a secure random</x-context-sub-title>
           <x-code>
               {{--@formatter:off--}}
               import {Encryption} from '@envuso/core/Crypt';

               Encryption.random(16);
               {{--@formatter:on--}}
           </x-code>
       </div>

       <div>
           <x-title>Hashing</x-title>
           <x-context-sub-title>Introduction</x-context-sub-title>
           <x-text>
               Under the hood we use
               <x-page-link route="https://www.npmjs.com/package/bcrypt">bcrypt</x-page-link> for all hashing
           </x-text>

           <x-context-sub-title>Hashing with Bcrypt</x-context-sub-title>
           <x-code>
               {{--@formatter:off--}}
import {Hash} from '@envuso/core/Common';

Hash.make('some key');
// You can also pass the amount of hashing rounds:
// Default value is 10
Hash.make('some key', 20);
               {{--@formatter:on--}}
           </x-code>

           <x-context-sub-title>Checking a hash with Bcrypt</x-context-sub-title>
           <x-code>
               {{--@formatter:off--}}
import {Hash} from '@envuso/core/Common';

const userProvidedPassword = '123';
const user = await User.find({email : 'some email'});

if(Hash.check(userProvidedPassword, user.password)) {
    // The hash is valid
} else {
    // The hash is invalid
}
               {{--@formatter:on--}}
           </x-code>

       </div>

    </x-container>
@endsection
