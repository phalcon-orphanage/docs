---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Logger Component

* * *

## Creating a logger

Creating a logger is a multi step process. First you create the logger object and then you attach an adapter to it. After that you can start logging messages according to the needs of your application.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/logs/application.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

The above example creates a [Stream](api/Phalcon_Logger_Adapter_Stream) adapter. We then create a logger object and attach this adapter to it. Each adapter attached to a logger needs to have a unique name, for the logger to be able to know where to log the messages. When calling the `error` method on the logger object, the message is going to be stored in the `/logs/application.log`.

Since the logger component implements PSR-3, the following methods are available:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/logs/application.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->alert("This is an alert message");
$logger->critical("This is a critical message");
$logger->debug("This is a debug message");
$logger->error("This is an error message");
$logger->emergency("This is an emergency message");
$logger->info("This is an info message");
$logger->log(Logger::CRITICAL, "This is a log message");
$logger->notice("This is a notice message");
$logger->warning("This is a warning message");

```

The log generated is as follows:

```bash
[Tue, 25 Dec 18 12:13:14 -0400][ALERT] This is an alert message
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] This is a critical message
[Tue, 25 Dec 18 12:13:14 -0400][DEBUG] This is a debug message
[Tue, 25 Dec 18 12:13:14 -0400][ERROR] This is an error message
[Tue, 25 Dec 18 12:13:14 -0400][EMERGENCY] This is an emergency message
[Tue, 25 Dec 18 12:13:14 -0400][INFO] This is an info message
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] This is a log message
[Tue, 25 Dec 18 12:13:14 -0400][NOTICE] This is a notice message
[Tue, 25 Dec 18 12:13:14 -0400][WARNING] This is warning message
```