<a href="https://envuso.com/"><div class="text-center py-4 lg:px-4">
  <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
    <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">New</span>
    <span class="font-semibold mr-2 text-left flex-auto">Envuso v2.X has been release!</span>
    <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
  </div>
</div></a>

# Encryption/Hashing

More info needed here.


## Encryption

### Introduction
Under the hood we use [SimpleCryptoJS](https://www.npmjs.com/package/simple-crypto-js)  
Before you can use any Encryption features, you will need an "APP_KEY" set in your .env file. This should be done already, but just a note!

### Encryption a value
```typescript
import {Encryption} from '@envuso/core/Crypt';
			   Encryption.encrypt('some string');
```

### Decrypting a value
```typescript
import {Encryption} from '@envuso/core/Crypt';

			   const encryptedString = Encryption.encrypt('some string');
			   const decryptedString = Encryption.decrypt(encryptedString);

			   console.log(decryptedString); // 'some string'
```

### Getting a secure random
```typescript
import {Encryption} from '@envuso/core/Crypt';

			   Encryption.random(16);
```

## Hashing

### Introduction
Under the hood we use [bcrypt](https://www.npmjs.com/package/bcrypt) for all hashing
### Hashing with Bcrypt
```typescript
import {Hash} from '@envuso/core/Common';

Hash.make('some key');
// You can also pass the amount of hashing rounds:
// Default value is 10
Hash.make('some key', 20);
```
### Checking a hash with Bcrypt
```typescript
import {Hash} from '@envuso/core/Common';

const userProvidedPassword = '123';
const user = await User.find({email : 'some email'});

if(Hash.check(userProvidedPassword, user.password)) {
	// The hash is valid
} else {
	// The hash is invalid
}
```
