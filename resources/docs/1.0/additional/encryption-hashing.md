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
