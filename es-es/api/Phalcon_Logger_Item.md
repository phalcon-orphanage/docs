---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Logger\Item'
---
# Class **Phalcon\Logger\Item**

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/item.zep)

Represents each item in a logging transaction

## Métodos

public **getType** ()

Log type

public **getMessage** ()

Log message

public **getTime** ()

Log timestamp

public **getContext** ()

...

public **__construct** (*string* $message, *integer* $type, [*integer* $time], [*array* $context])

Phalcon\Logger\Item constructor