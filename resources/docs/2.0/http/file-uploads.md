# File Uploads

**This documentation is for interacting with files and incoming requests.**

## Interacting with file uploads

### Does the request contain any files?

```typescript 
request().hasFiles() // returns boolean
```

### Get all files on the request

```typescript 
request().files() // returns UploadedFileContract[]
```

### Get all files on the request as an object

The key difference between this method and request().files() is that request().files() returns an array. This method will return an object with the form data key as the files key.

```typescript 
request().filesKeyed() // returns {[key:string] : UploadedFileContract}
```

### Get a singular file on the request

```typescript 
request().file(key: string) // returns UploadedFileContract 
```

### Get all the file keys defined on the request

```typescript
request().fileKeys() // returns string[]
```

### Set an uploaded file

This is an internal method... but is public. There shouldn't be any need to call it.

Set file information that has been processed and is ready to upload/stream to s3 etc

```typescript
request().setUploadedFile(file)
```

## UploadedFileContract / UploadedFile

UploadedFileContract / UploadedFile class instances are used to represent file uploads everywhere in the framework

### Get the mimetype of the uploaded file
Has the potential to return null if it's an unsupported file type.

All supported file types are listed [here](https://github.com/sindresorhus/file-type#supported-file-types)

In the case it returns null, you can use [getMimeType()](2.0/http/file-uploads#content-get-original-mime-type-of-the-file)

```typescript
file.getMimeType() // returns MimeType;
```

### Get original mime type of the file
This is potentially risky to use.

If you're unsure about the risks, please take a read here:
<a target="blank" href="https://cheatsheetseries.owasp.org/cheatsheets/File_Upload_Cheat_Sheet.html">https://cheatsheetseries.owasp.org/cheatsheets/File_Upload_Cheat_Sheet.html
</a>

This should only be used as a fallback if [getMimeType()](/2.0/http/file-uploads#content-get-mime-type) returns null

```typescript
file.getOriginalMimeType() // returns MimeType;
```

### Get the encoder type for the file upload

```typescript
file.getEncoding() // returns string;
```

### Get the file extension
This is theoretically safe and taken from the file contents directly. But it does have a small chance to return null.

All supported file types are listed [here](https://github.com/sindresorhus/file-type#supported-file-types)

In the case it returns null, you can use getOriginalExtension() below

```typescript
file.getExtension() // returns FileExtension;
```

**This method is potentially risky to use**

It should only be used if you cannot use getExtension() above.

If you're unsure about the risks, please take a read here:
<a target="blank" href="https://cheatsheetseries.owasp.org/cheatsheets/File_Upload_Cheat_Sheet.html">https://cheatsheetseries.owasp.org/cheatsheets/File_Upload_Cheat_Sheet.html
</a>
```typescript
file.getOriginalExtension() // returns FileExtension;
```

### Get the fs stat values

```typescript
file.getFileStat() // returns Stats;
```

### Get the size of the file in bytes

```typescript
file.getSize() // returns number;
```

### Get file field name

This will get the name of the form data key used to submit this file

```typescript
file.getFieldName() // returns string;
```

### Get the temp file name

This is the name of the temp file which is assigned after uploading the file

```typescript
file.getTempFileName() // returns string;
```

### Get the absolute path of the temporary file

```typescript
file.getTempFilePath() // returns string;
```

### Get originally uploaded files name

```typescript
file.getOriginalFileName() // returns string;
```

### Get the file name without the extension

This will be the original file name, excluding the extension

```typescript
file.getFileNameWithoutExtension() // returns string;
```

### Deleting the temp file

If the temp file exists, it will be deleted.

**Note: This will be called automatically by framework internals once your file has been stored using storeFile() / store() / storeAs(). There shouldn't be any situations you need to manually call
this**

```typescript
file.deleteTempFile() // returns void;
```

## Storing uploaded files

All of these methods will use the default storage driver which can be configured in
```/Config/StorageConfiguration.ts -> defaultDisk```

### Storing in a specific location

**Note: This method will just call file.storeFile()**

A random file name will be generated and assigned to this file

If you want to control file name, see the below method

```typescript
file.store('/some/file/path') // returns Promise<UploadedFileInformation>;
```

### Store with a custom file name

**Note: This method will just call file.storeFile()**

Store the uploaded file in the specified directory using a user specified file name, rather than generated.

```typescript
file.storeAs('/some/file/path', 'some custom filename.png') // returns Promise<UploadedFileInformation>;
```

### Store file

This method handles store() and storeAs() so there's less code for those methods.

```typescript
file.storeFile('/some/file/path') // returns Promise<UploadedFileInformation>;
// Also has an optional parameter to set a custom file name
file.storeFile('/some/file/path', 'optional custom name.png') // returns Promise<UploadedFileInformation>;
```

### UploadedFileInformation

This will be returned by store() / storeAs() / storeFile()

Example output: 
```json
{
	"url" : "https://somestorageservice.com/file/2f732hf782h.png",
    "path": "file/2f732hf782h.png",
    "originalName" : "cute-cat-image.png"
}
```

**Important note: A url can only be provided when using an S3 based storage driver** 

## Example File Upload

```typescript

@controller('/files')
export class FileUploadController extends Controller {

    @put('/')
    async uploadFile() {
        const uploadedFile = request().file('file');

        if (!uploadedFile) {
            throw new Exception('File does not exist.');
        }

        const file = await uploadedFile.storeFile('avatars');

        return {
            message : 'File uploaded successfully',
            url     : file.url,
        }
    }

}

```

We can also use DataTransferObjects... which offer some simple/handy validations for file uploads

```typescript

class FileUploadDto extends DataTransferObject {
    
	// Validate the property is a file upload of any type
	@IsFileUpload()
    
    // If we want the property to only accept image uploads
    @IsImageFileUpload()
    
    // If we want the property to only accept video uploads
    @IsVideoFileUpload()
    
    // For this example, we'll use IsImageFileUpload
    @IsImageFileUpload()
	image: UploadedFileContract;
}

@controller('/files')
export class FileUploadController extends Controller {

    @put('/')
    async uploadFile(@dto() upload : FileUploadDto) {
        // We no longer need to get the file from the request()
		// const uploadedFile = request().file('file');

		// We no longer need to check if the file exists
        // The DTO will throw an error if it doesnt
        // if (!uploadedFile) {
        //     throw new Exception('File does not exist.');
        // }

        const file = await upload.image.storeFile('avatars');

        return {
            message : 'File uploaded successfully',
            url     : file.url,
        }
    }

}
```
