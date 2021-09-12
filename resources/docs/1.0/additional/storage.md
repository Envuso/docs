
# File Storage

More info needed here.


## Configuration
```typescript
{
    // When we use Storage without providing a disk to use, all operations will fallback to our default
    defaultDisk : 'local',

        // Here we're mapping a "disk" to a driver and providing some configuration.
        // If we had two different S3 instances we wanted to connect to, this would allow such a thing.
        disks : {
        s3	  : {
            driver	  : 's3',
                bucket	  : process.env.SPACES_BUCKET,
                url		 : process.env.SPACES_URL,
                endpoint	: process.env.SPACES_ENDPOINT,
                credentials : {
                accessKeyId	 : process.env.SPACES_KEY,
                    secretAccessKey : process.env.SPACES_SECRET,
            }
        },
        temp	: {
            driver : 'local',
                root   : path.join(process.cwd(), 'storage', 'temp'),
        },
        local   : {
            driver : 'local',
                root   : path.join(process.cwd(), 'storage', 'local'),
        },
    },

    // Here we provide all drivers available to Envuso, this will allow you to
    // write your own drivers or implement community created drivers.
    drivers : {
        local : LocalFileProvider,
            s3	: S3Provider,
    }

}
```
### Local Driver

The local driver will use the file system of the server your application is running on.  
We can customise it's storage path by changing "root".
### S3 Driver

The S3 driver will connect to any S3 compatible service. For example, I personally use digitalocean spaces, but you could use AWS S3. They all take the same configuration.
## Listing files in a directory
We can list all files in a directory, by default, this will only list files on the top level of the directory that you pass it.  
We can also list all files recursively, however... this does not work with S3.  
**Note how paths returned are never absolute when using the local driver.**

```typescript
import {Storage} from '@envuso/core/Storage';

// Looking in /storage/local for files:
await Storage.disk('local').files('/');

// Looking in /storage/local/extra-thingies for files:
await Storage.disk('local').files('/extra-thingies');

// Looking in /storage/local for files recursively:
await Storage.disk('local').files('/', true);
// Returns:
// image-1.png
// image-2.png
// memes/image-1.png
// memes/image-2.png
```

## Listing directories

```typescript
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').directories('/');
```

## Making a directory

```typescript
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').makeDirectory('/memes');
```

## Deleting a directory

```typescript
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').deleteDirectory('/memes');
```

## Checking if a file exists

```typescript
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').fileExists('image-1.png');
```

## Getting the contents of a file

File contents are always returned as a UTF-8 string.

```typescript
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').get('/file.txt');
```

## Storing a file

How we store files are a little questionable right now. The first initial version of this was built to allow simple file storage from an endpoint... therefore this method is used by internals.  
This is why the object has "tempFilePath".  
At some point I will re-work this.

```typescript
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').put('/directory', {
    filename	 : 'testfile.txt',// This is the original fileName
    storeAs	  : 'testfile.txt',// optional; Allows you to set a new file name when storing
    tempFilePath : '/location/of/some/other/testfile.txt', // The current location of the file you wish to put
});
```

## Deleting a file

```typescript
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').remove('/memes/big-meme.png');
```

## Getting a url for a file

This method only works with the S3 driver.  **Using it with the local provider will return null.**

```typescript
import {Storage} from '@envuso/core/Storage';

await Storage.disk('s3').url('image-1.png');
```

## Getting a temporary url for a file

This method only works with the S3 driver.  **Using it with the local provider will return null.**

```typescript
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').temporaryUrl('image-1.png');
```

