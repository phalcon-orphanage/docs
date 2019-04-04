---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Logger Component

* * *

## Interpolation

The logger also supports interpolation. There are times that you might need to inject additional text in your logging messages; text that is dynamically created by your application. This can be easily achieved by sending an array as the second parameter of the logging method (i.e. `error`, `info`, `alert` etc.). The array holds keys and values, where the key is the placeholder in the message and the value is what will be injected in the message.

The following example demonstrates interpolation by injecting in the message the parameter "framework" and "secs".

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

$message = '{framework} executed the "Hello World" test in {secs} second(s)';
$context = [
    'framework' => 'Phalcon',
    'secs'      => 1,
];

$logger->info($message, $context);
```