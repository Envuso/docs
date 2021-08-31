@extends('v1.layout.app')

@section('content')

    <x-container>


        <x-header>File Storage</x-header>
        <ul>
            <x-context>Configuration</x-context>
            <x-sub-context>Local Driver</x-sub-context>
            <x-sub-context>S3 Driver</x-sub-context>
            <x-context>Listing files in a directory</x-context>
            <x-context>Listing directories</x-context>
            <x-context>Making a directory</x-context>
            <x-context>Deleting a directory</x-context>
            <x-context>Checking if a file exists</x-context>
            <x-context>Getting the contents of a file</x-context>
            <x-context>Storing a file</x-context>
            <x-context>Deleting a file</x-context>
            <x-context>Getting a url for a file</x-context>
            <x-context>Getting a temporary url for a file</x-context>
        </ul>
        <x-title>Configuration</x-title>
        <x-text>

        </x-text>
        <x-code>
        {{--@formatter:off--}}
{
    // When we use Storage without providing a disk to use, all operations will fallback to our default
    defaultDisk : 'local',

    // Here we're mapping a "disk" to a driver and providing some configuration.
    // If we had two different S3 instances we wanted to connect to, this would allow such a thing.
    disks : {
        s3      : {
            driver      : 's3',
            bucket      : process.env.SPACES_BUCKET,
            url         : process.env.SPACES_URL,
            endpoint    : process.env.SPACES_ENDPOINT,
            credentials : {
                accessKeyId     : process.env.SPACES_KEY,
                secretAccessKey : process.env.SPACES_SECRET,
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
    },

    // Here we provide all drivers available to Envuso, this will allow you to
    // write your own drivers or implement community created drivers.
    drivers : {
        local : LocalFileProvider,
        s3    : S3Provider,
    }

}
        {{--@formatter:on--}}
        </x-code>

        <x-context-sub-title>Local Driver</x-context-sub-title>
        <x-text>
            The local driver will use the file system of the server your application is running on.
            <br>
            We can customise it's storage path by changing "root".
        </x-text>

        <x-context-sub-title>S3 Driver</x-context-sub-title>
        <x-text>
            The S3 driver will connect to any S3 compatible service. For example, I personally use digitalocean spaces, but you
            could use AWS S3. They all take the same configuration.
        </x-text>

        <x-title>Listing files in a directory</x-title>
        <x-text>
            We can list all files in a directory, by default, this will only list files on the top level
            of the directory that you pass it.
            <br>
            We can also list all files recursively, however... this does not work with S3.
            <br>
            <strong>Note how paths returned are never absolute when using the local driver.</strong>
        </x-text>
        <x-code>
        {{--@formatter:off--}}
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
        {{--@formatter:on--}}
        </x-code>

        <x-title>Listing directories</x-title>
        <x-code>
        {{--@formatter:off--}}
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').directories('/');
        {{--@formatter:on--}}
        </x-code>

        <x-title>Making a directory</x-title>
        <x-code>
        {{--@formatter:off--}}
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').makeDirectory('/memes');
        {{--@formatter:on--}}
        </x-code>

        <x-title>Deleting a directory</x-title>
        <x-code>
        {{--@formatter:off--}}
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').deleteDirectory('/memes');
        {{--@formatter:on--}}
        </x-code>

        <x-title>Checking if a file exists</x-title>
        <x-code>
        {{--@formatter:off--}}
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').fileExists('image-1.png');
        {{--@formatter:on--}}
        </x-code>

        <x-title>Getting the contents of a file</x-title>
        <x-text>
            File contents are always returned as a UTF-8 string.
        </x-text>
        <x-code>
        {{--@formatter:off--}}
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').get('/file.txt');
        {{--@formatter:on--}}
        </x-code>

        <x-title>Storing a file</x-title>
        <x-text>
            How we store files are a little questionable right now. The first initial version of
            this was built to allow simple file storage from an endpoint... therefore this method is used by internals.
            <br>
            This is why the object has "tempFilePath".
            <br>
            At some point I will re-work this.
        </x-text>
        <x-code>
        {{--@formatter:off--}}
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').put('/directory', {
    filename     : 'testfile.txt',// This is the original fileName
    storeAs      : 'testfile.txt',// optional; Allows you to set a new file name when storing
    tempFilePath : '/location/of/some/other/testfile.txt', // The current location of the file you wish to put
});
        {{--@formatter:on--}}
        </x-code>

        <x-title>Deleting a file</x-title>
        <x-code>
        {{--@formatter:off--}}
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').remove('/memes/big-meme.png');
        {{--@formatter:on--}}
        </x-code>

        <x-title>Getting a url for a file</x-title>
        <x-text>
            This method only works with the S3 driver. <strong>Using it with the local provider will return null.</strong>
        </x-text>
        <x-code>
        {{--@formatter:off--}}
import {Storage} from '@envuso/core/Storage';

await Storage.disk('s3').url('image-1.png');
        {{--@formatter:on--}}
        </x-code>

        <x-title>Getting a temporary url for a file</x-title>
        <x-text>
            This method only works with the S3 driver. <strong>Using it with the local provider will return null.</strong>
        </x-text>
        <x-code>
        {{--@formatter:off--}}
import {Storage} from '@envuso/core/Storage';

await Storage.disk('local').temporaryUrl('image-1.png');
        {{--@formatter:on--}}
        </x-code>


    </x-container>



@endsection
