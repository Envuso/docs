# Encryption/Hashing

## Encryption

### Introduction
Under the hood we use [SimpleCryptoJS](https://www.npmjs.com/package/simple-crypto-js)  
Before you can use any Encryption features, you will need an "APP_KEY" set in your .env file. This should be done already, but just a note!

Envuso has two encryption drivers available which can be used where applicable.

#### Encryption - AES-CBC algorithm
More secure encryption but can impact performance.

#### RabbitEncryption - [Wikipedia](https://en.wikipedia.org/wiki/Rabbit_(cipher))
Less secure than AES-CBC but very fast.

Envuso originally used the AES-CBC driver for cookies/session data and response times increased by around 10-30ms. After switching to Rabbit, there is around 1-2 ms difference.

Both drivers implement the "EncryptionContract" interface.

We can obtain Encryption drivers as shown below. All methods are static.
```typescript
// AES-CBC
Encryption.encrypt();
// Rabbit
RabbitEncryption.encrypt();
```

### Encrypting a value
```typescript
Encryption.encrypt('some string');
RabbitEncryption.encrypt('some string');
```

### Decrypting a value
```typescript
Encryption.decrypt(encryptedString);
RabbitEncryption.decrypt(encryptedString);
```

### Getting a secure random
```typescript
Encryption.random(16);
RabbitEncryption.random(16);
```

### Getting the app secret key
```typescript
Encryption.getKey();
RabbitEncryption.getKey();
```

### Creating an encryption instance with a custom key
```typescript
Encryption.createInstance('custom secret key').encrypt();
RabbitEncryption.createInstance('custom secret key').encrypt();
```

## Hashing

### Introduction
Under the hood we use [bcrypt](https://www.npmjs.com/package/bcrypt) for all hashing

### Hashing with Bcrypt
```typescript
Hash.make('some key');
// You can also pass the amount of hashing rounds:
// Default value is 10
Hash.make('some key', 20);
```
### Checking a hash with Bcrypt
```typescript
const userProvidedPassword = '123';
const user = await User.find({email : 'some email'});

if(Hash.check(userProvidedPassword, user.password)) {
	// The hash is valid
} else {
	// The hash is invalid
}
```
