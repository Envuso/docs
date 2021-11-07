# File Storage

## Configuration

```typescript
export default class StorageConfiguration extends ConfigurationCredentials implements StorageConfig {

    /**
     * The default storage provider to use on the request() helper
     * or when using Storage.get(), Storage.put() etc
     */
    defaultDisk: keyof DisksList = 'local';

    /**
     * We can create "disks" which are based on one of the storage drivers
     *
     * For example, with local storage driver, we set set the root path for storing files.
     *
     * @type {DisksList}
     */
    disks: DisksList = {
        s3      : {
            driver      : 's3',
            bucket      : Environment.get('SPACES_BUCKET'),
            url         : Environment.get('SPACES_URL'),
            endpoint    : Environment.get('SPACES_ENDPOINT'),
            credentials : {
                accessKeyId     : Environment.get('SPACES_KEY'),
                secretAccessKey : Environment.get('SPACES_SECRET'),
            }
        },
        temp    : {
            driver : 'local',
            root   : path.join(process.cwd(), 'storage', 'temp'),
        },
        local   : {
            driver : 'local',
            root   : path.join(process.cwd(), 'storage', 'local'),
        },
        storage : {
            driver : 'local',
            root   : path.join(process.cwd(), 'storage'),
        },
    };

    drivers: DriversList = {
        local : LocalFileProvider,
        s3    : S3Provider,
    };

}
```

### Local Driver

The local driver will use the file system of the server your application is running on.  
We can customise its storage path by changing "root".

### S3 Driver

The S3 driver will connect to any S3 compatible service. For example, I personally use digitalocean spaces, but you could use AWS S3. They all take the same configuration.

## Disks

When using the storage service, if we don't specify a disk it will use our default from the configuration file.

Some examples:

```typescript
// This will use our local storage driver
Storage.disk('local').get('...');
// This will use the default from the config
Storage.get('...')
// We can also create "on demand" disks on the fly
Storage.onDemand({
    driver : 'local',
    root   : path.join(process.cwd(), 'some/custom/location'),
}).get('...')
```

## Listing files in a directory

We can list all files in a directory, by default, this will only list files on the top level of the directory that you pass it.  
We can also list all files recursively, however... this does not work with S3.  
**Note how paths returned are never absolute when using the local driver.**

```typescript
// Looking in /storage/local for files:
await Storage.files('/');

// Looking in /storage/local/extra-thingies for files:
await Storage.files('/extra-thingies');

// Looking in /storage/local for files recursively:
await Storage.files('/', true);
// Returns:
// image-1.png
// image-2.png
// memes/image-1.png
// memes/image-2.png
```

## Listing directories

```typescript
await Storage.directories('/')
```

## Making a directory

```typescript
await Storage.makeDirectory('/memes');
```

## Deleting a directory

```typescript
await Storage.deleteDirectory('/memes');
```

## Checking if a file exists

```typescript
await Storage.fileExists('image-1.png');
```

## Getting the contents of a file
File contents are always returned as a UTF-8 string.

```typescript
await Storage.get('/file.txt');
```

## Storing a file

How we store files are a little questionable right now. The first initial version of this was built to allow simple file storage from an endpoint... therefore this method is used by internals.  
This is why the object has "tempFilePath".  
At some point I will re-work this.

```typescript
await Storage.put('/directory', {
    filename     : 'testfile.txt',// This is the original fileName
    storeAs      : 'testfile.txt',// optional; Allows you to set a new file name when storing
    tempFilePath : '/location/of/some/other/testfile.txt', // The current location of the file you wish to put
});
```

## Deleting a file

```typescript
await Storage.remove('/memes/big-meme.png');
```

## Getting a url for a file

This method only works with the S3 driver.  **Using it with the local provider will return null.**

```typescript
await Storage.url('image-1.png');
```

## Getting a temporary url for a file

This method only works with the S3 driver.  **Using it with the local provider will return null.**

```typescript
await Storage.temporaryUrl('image-1.png');
```

