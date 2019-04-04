---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Logger Component

* * *

## Logging to Multiple Adapters

[Phalcon\Logger](api/Phalcon_Logger) can send messages to multiple adapters with a just single call:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter1 = new Stream('/logs/first-log.log');
$adapter2 = new Stream('/remote/second-log.log');
$adapter3 = new Stream('/manager/third-log.log');

$logger = new Logger(
    'messages',
    [
        'local'   => $adapter1,
        'remote'  => $adapter2,
        'manager' => $adapter3,
    ]
);

// Log to all adapters
$logger->error('Something went wrong');
```

The messages are sent to the handlers in the order they were registered using the [first in first out](https://en.wikipedia.org/wiki/FIFO_(computing_and_electronics)) principle.

### Excluding adapters

[Phalcon\Logger](api/Phalcon_Logger) also offers the ability to exclude logging to one or more adapters when logging a message. This is particularly useful when in need to log a `manager` related message in the `manager` log but not in the `local` log without having to instantiate a new logger.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter1 = new Stream('/logs/first-log.log');
$adapter2 = new Stream('/remote/second-log.log');
$adapter3 = new Stream('/manager/third-log.log');

$logger = new Logger(
    'messages',
    [
        'local'   => $adapter1,
        'remote'  => $adapter2,
        'manager' => $adapter3,
    ]
);

// Log to all adapters
$logger->error('Something went wrong');

// Log only to remote and manager
$logger
    ->excludeAdapters(['local'])
    ->info('This does not go to the "local" logger');
```