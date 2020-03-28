---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'HTTP Response (PSR-7)'
keywords: 'psr-7, http, http stream'
---

# HTTP Response (PSR-7)
<hr />
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 概要
[Phalcon\Http\Message\Stream](api/phalcon_http#http-message-stream) is an implementation of the [PSR-7](https://www.php-fig.org/psr/psr-7/) HTTP messaging interface as defined by [PHP-FIG](https://www.php-fig.org/).

![](/assets/images/implements-psr--7-blue.svg)

This class describes a data stream. Typically, an instance will wrap a PHP stream; this interface provides a wrapper around the most common operations, including serialization of the entire stream to a string.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->getContents(); // 'The MIT License (MIT) ...'
```

## Constructor

```php
public function __construct(
    mixed $stream, 
    string $mode = "rb"
)
```
The first parameter can be a string representing the location of the file on the file system or storage area. It can also be a resource, as returned by a method such as [fopen](https://www.php.net/manual/en/function.fopen.php). The second parameter is the open mode for the stream. The default mode is `rb`. For a list of available modes, you can check the documentation for [fopen](https://www.php.net/manual/en/function.fopen.php).

- `stream` - string or resource
- `mode` - A string representing the mode the file is to be opened.

If there is an error, a `RuntimeException` will be thrown.

## Getters
### `__toString()`
Reads all data from the stream into a string, from the beginning to end. The method will first try to `seek()` to the beginning of the stream before reading the data and read the stream until the end is reached.

> **NOTE** Calling this method on large files will result in a large amount of data being loaded in memory 
> 
> {: .alert .alert-danger }

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo (string) $stream; // 'The MIT License (MIT) ...'
```

### `getContents()`
Returns a string with the remaining contents in a string. If the stream cannot be read or an error occurs, a `RuntimeException` will be thrown.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->getContents(); // 'The MIT License (MIT) ...'
```

### `getMetadata()`
Returns the stream metadata as an associative array. If the parameter `$key` is defined, the relevant string element will be returned. The method is a wrapper for PHP's [stream_get_meta_data()](https://php.net/manual/en/function.stream-get-meta-data.php) function. If the key is not found, the method will return `null`.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

var_dump(
    $stream->getMetadata()
);

// [
//     'timed_out'    => false,
//     'blocked'      => true,
//     'eof'          => false,
//     'wrapper_type' => 'plainfile',
//     'stream_type'  => 'STDIO',
//     'mode'         => 'rb',
//     'unread_bytes' => 0,
//     'seekable'     => true,
//     'uri'          => $fileName,
// ];

echo $stream->getMetadata('wrapper_type'); // 'plainfile'
echo $stream->getMetadata('unknown');      // null
```

### `getSize()`
Returns the size of the stream. If it is not known, `null` will be returned

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->getSize(); // 1087
```

## Is
### `isSeekable()`
Returns `true` if the stream is seekable, `false` otherwise.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->isSeekable(); // 'true'
```

### `isReadable()`
Returns `true` if the stream is readable, `false` otherwise.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'w');

echo $stream->isReadable(); // 'false'
```

### `isWritable()`
Returns `true` if the stream is writable, `false` otherwise.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->isWritable(); // 'false'
```

## `close()`
Closes the stream and any underlying resources.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

$stream->close();
```

## `detach()`
Separates any underlying resources from the stream. After the stream has been detached, the stream is in an unusable state. Calling this method on a closed/detached stream will return `null`

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->detach(); // The handle
echo $stream->detach(); // null
```

## `eof()`
Returns `true` if the stream is at the end of the stream, `false` otherwise.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->eof(); // false

$stream->seek(9999);

echo $stream->eof(); // true
```

## `read()`
Read data from the stream. The method accepts an integer specifying the number of bytes from the object and return them. The method could return less number of bytes than specified if the end of the stream is defined. If no more data is available an empty string will be returned. If an error occurs, a `RuntimeException` will be thrown.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

echo $stream->read(15); // 'The MIT License'
```

## `rewind()`
Seek to the beginning of the stream. Uses [fseek()](https://www.php.net/manual/en/function.fseek.php) calling `seek(0)` internally. If the stream is not seekable, a `RuntimeException` will be thrown.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

$stream->seek(8);
echo $stream->read(7); // 'License'
$stream->rewind();
echo $stream->read(3); // 'The'
```

## `seek()`
Seek to a position in the stream. Uses [fseek()](https://www.php.net/manual/en/function.fseek.php) internally. It accepts:
- `offset` - `int` The stream offset
- `whence` - `int` Specifies how the cursor position will be calculated based on the seek offset. Valid values are identical to the built-in PHP $whence values for [fseek()](https://www.php.net/manual/en/function.fseek.php).
    - `SEEK_SET` Set position equal to offset bytes
    - `SEEK_CUR` Set position to current location plus offset
    - `SEEK_END` Set position to end-of-stream plus offset.

If an error occurs, a `RuntimeException` will be thrown.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

$stream->seek(8);
echo $stream->read(7); // 'License'
$stream->rewind();
echo $stream->read(3); // 'The'
```

## `tell()`
Returns the current position of the file read/write pointer as an integer. If an error occurs, a `RuntimeException` will be thrown.

```php
<?php

use Phalcon\Http\Message\Stream;

$fileName = dataDir('assets/stream/mit.txt');

$stream = new Stream($fileName, 'rb');

$stream->seek(8);
echo $stream->tell(); // 8
```

## `write()`
Write data to the stream. It accepts a `string` parameter as the contents to be written. The method returns the number of bytes written to the stream as an integer. If an error occurs, a `RuntimeException` will be thrown.

```php
<?php

use Phalcon\Http\Message\Stream;

$stream = new Stream('php://memory', 'wb');
$source = 'The above copyright notice and this permission '
        . 'notice shall be included in all copies or '
        . 'substantial portions of the Software.';

echo $stream->write($source); // 126
```
