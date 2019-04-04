---
layout: default
language: 'tr-tr'
version: '4.0'
category: 'request'
---
# HTTP Request Component

* * *

## Uploading Files

Another common task is file uploading. [Phalcon\Http\Request](api/Phalcon_Http_Request) offers an object-oriented way work with files. For the whole upload process to work, you will need to make the necessary changes to your `php.ini` (see [php-uploads](https://secure.php.net/manual/en/ini.core.php#ini.file-uploads)).

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * Class PostsController
 * 
 * @property Request $request
 */
class PostsController extends Controller
{
    public function uploadAction()
    {
        // Check if the user has uploaded files
        if ($this->request->hasFiles()) {
            $files = $this->request->getUploadedFiles();

            // Print the real file names and sizes
            foreach ($files as $file) {
                // Print file details
                echo $file->getName(), ' ', $file->getSize(), '\n';

                // Move the file into the application
                $file->moveTo(
                    'files/' . $file->getName()
                );
            }
        }
    }
}
```

Each object returned by `Phalcon\Http\Request::getUploadedFiles()` is an instance of the [Phalcon\Http\Request\File](api/Phalcon_Http_Request_File) class. Using the `$_FILES` superglobal array offers the same behavior. `Phalcon\Http\Request\File` encapsulates only the information related to each file uploaded with the request.

The `getUploadedFiles()` accepts two parameters. - `$onlySuccessful`: Contains only successful uploads - `$namedKeys`: Returns the array with named keys obtained by the upload process