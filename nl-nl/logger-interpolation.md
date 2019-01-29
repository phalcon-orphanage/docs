---
layout: article
language: 'nl-nl'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Logger Component

* * *

## Interpolation

The logger also supports interpolation. This means that you can inject data to a message based on the needs of your application.

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