---
layout: default
language: 'tr-tr'
version: '4.0'
title: 'HTTP Uploaded File (PSR-7)'
keywords: 'psr-7, http, http uploaded file'
---

# HTTP Uploaded File (PSR-7)
<hr />
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Genel Bakış
[Phalcon\Http\Message\UploadedFile](api/phalcon_http#http-message-uploadedfile) is an implementation of the [PSR-7](https://www.php-fig.org/psr/psr-7/) HTTP messaging interface as defined by [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--7-blue.svg)

The [Phalcon\Http\Message\UploadedFile](api/phalcon_http#http-message-uploadedfile) is a value object class that stores information for the uploaded files to your application. making it easier to work with. There are several limitations when using just the `$_FILES` superglobal, which the [Phalcon\Http\Message\UploadedFile](api/phalcon_http#http-message-uploadedfile) resolves. The [Phalcon\Http\Message\ServerRequest](api/phalcon_http#http-message-serverrequest) object allows you to retrieve all the uploaded files in a normalized structure, which each leaf is a [Phalcon\Http\Message\UploadedFile](api/phalcon_http#http-message-uploadedfile) object.

```php
<?php

use Phalcon\Http\Message\UploadedFile;

$file = new UploadedFile(
    'php://memory',
    0,
    UPLOAD_ERR_OK,
    'phalcon.txt'
);

echo $file->getClientFilename(); // 'phalcon.txt'
```

We are creating a new [Phalcon\Http\Message\UploadedFile](api/phalcon_http#http-message-uploadedfile) using the memory stream, with size `0`, specifying that there was no upload error (`UPLOAD_ERR_OK`) and the name of the file is `phalcon.txt`. This information is available to us when working with the [Phalcon\Http\Message\ServerRequest](api/phalcon_http#http-message-serverrequest) object automatically.

## Constructor

```php
public function __construct(
    StreamInterface | string | null $stream 
    [, int $size = null 
    [, int error = 0
    [, string clientFilename = null
    [, string clientMediaType = null ]]]] 
)
```
The constructor accepts parameters allowing you to create the object with certain properties populated. You can define the stream, the size of the file, if any error occurred during the upload, the client file name as well as the client media type.

- `stream` - A valid stream for the file (`StreamInterface`, `string`)
- `size` - The size of the file
- `error` - An upload error (see the `UPLOAD_ERR_*`PHP [constants](http://php.net/manual/en/features.file-upload.errors.php))
- `clientFilename` - The name of the uploaded file from the client
- `clientMediaType` - The media type of the uploaded file from the client

## Getters

### `getClientFilename()`

Returns the filename sent by the client. You should not trust the value returned by this method. The client could very well send a malicious filename with the intent to corrupt or hack your application. The value returned is the value stored in the `name` key in the `$_FILES` array.

```php
<?php

use Phalcon\Http\Message\UploadedFile;

$file = new UploadedFile(
    'php://memory',
    0,
    UPLOAD_ERR_OK,
    'phalcon.txt'
);

echo $file->getClientFilename(); // 'phalcon.txt'
```

### `getClientMediaType()`

Returns the media type sent by the client. You should not trust the value returned by this method. The client could very well send a malicious filename with the intent to corrupt or hack your application. The value returned is the value stored in the `type` key in the `$_FILES` array.

```php
<?php

use Phalcon\Http\Message\UploadedFile;

$file = new UploadedFile(
    'php://memory',
    0,
    UPLOAD_ERR_OK,
    'phalcon.txt',
    'application/text'
);

echo $file->getClientMediaType(); // 'application/text'
```

### `getError()`

 Returns the error associated with the uploaded file. The value is PHP's `UPLOAD_ERR_*` [constants](http://php.net/manual/en/features.file-upload.errors.php). If the file was uploaded successfully, the method will return `UPLOAD_ERR_OK`. The value returned is the value stored in the `error` key in the `$_FILES` array.

```php
<?php

use Phalcon\Http\Message\UploadedFile;

$file = new UploadedFile(
    'php://memory',
    0,
    UPLOAD_ERR_OK,
    'phalcon.txt',
    'application/text'
);

echo $file->getError(); // UPLOAD_ERR_OK
```

### `getSize()`

Returns the size of the uploaded file. The value returned is the value stored in the `size` key in the `$_FILES` array if available.

```php
<?php

use Phalcon\Http\Message\UploadedFile;

$file = new UploadedFile(
    'php://memory',
    1234,
    UPLOAD_ERR_OK,
    'phalcon.txt'
);

echo $file->getSize(); // 1234
```

### `getStream()`

Returns the stream representing the uploaded file. The method returns a `StreamInterface` instance. The purpose of this method is to allow utilizing native PHP stream functionality to manipulate the file upload, such as [stream_copy_to_stream()](https://www.php.net/manual/en/function.stream-copy-to-stream.php) (though the result will need to be decorated in a native PHP stream wrapper to work with such functions).

If the `moveTo()` method has been called previously, a [Phalcon\Http\Message\Exception\InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) exception will be thrown.

```php
<?php

use Phalcon\Http\Message\Stream;
use Phalcon\Http\Message\UploadedFile;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$file = new UploadedFile(
    $stream,
    1234,
    UPLOAD_ERR_OK,
    'phalcon.txt'
);

echo $file->getStream(); // '/assets/stream/mit.txt'
```

## `moveTo()`
Moves the uploaded file to a new location. This method should be used as an alternative to [move_uploaded_file()](https://www.php.net/manual/en/function.move-uploaded-file.php). This method is guaranteed to work in both SAPI and non-SAPI environments.

The parameter `$targetPath` can be an absolute or relative path. When calling this method, the original file or stream will be removed. As noted above, if this method is called more than once, any subsequent calls will raise a [Phalcon\Http\Message\Exception\InvalidArgumentException](api/phalcon_http#http-message-exception-invalidargumentexception) exception.

The method performs necessary checks internally so that permissions are properly maintained. If you need to to move the file to a stream, you will need to use `getStream()`, since SAPI operations cannot guarantee writing stream destinations.

```php
<?php

use Phalcon\Http\Message\Stream;
use Phalcon\Http\Message\UploadedFile;

$fileName = dataFolder('/assets/stream/mit.txt');
$stream   = new Stream($fileName, 'rb');

$file = new UploadedFile(
    $stream,
    1234,
    UPLOAD_ERR_OK,
    'phalcon.txt'
);

$file->moveTo('/storage/files/');
```