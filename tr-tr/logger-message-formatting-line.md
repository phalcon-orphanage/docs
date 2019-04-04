---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Logger Component

* * *

## Message Formatting

### Line Formatter

Formats the messages using a one-line string. The default logging format is:

```bash
[%date%][%type%] %message%
```

#### Message Format

If the default format of the message does not fit the needs of your application you can change it using the `setFormat()` method. The log format variables allowed are:

| Variable  | Description                              |
| --------- | ---------------------------------------- |
| %message% | The message itself expected to be logged |
| %date%    | Date the message was added               |
| %type%    | Uppercase string with message type       |

The following example demonstrates how to change the message format:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line('[%type%] - [%date%] - %message%');
$adapter   = new Stream('/logs/application.log');
$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

which produces:

```bash
[ALERT] - [Tue, 25 Dec 18 12:13:14 -0400] - Something went wrong
```

If you do not want to use the constructor to change the message, you can always use the `setFormat()` on the formatter:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line();
$formatter->setFormat('[%type%] - [%date%] - %message%');

$adapter = new Stream('/logs/application.log');
$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

#### Date Format

The default date format is:

```bash
"D, d M y H:i:s O"
```

If the default format of the message does not fit the needs of your application you can change it using the `setDateFormat()` method. The method accepts a string with characters that correspond to date formats. For all available formats, please consult [this page](https://secure.php.net/manual/en/function.date.php).

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line();
$formatter->setDateFormat('Ymd-His');

$adapter = new Stream('/logs/application.log');
$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```