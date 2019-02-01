---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Logger\Item'
---
# Class **Phalcon\Logger\Item**

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/item.zep)

Representa cada objeto en una transacción de registro

## Métodos

public **getType** ()

Tipo de registro

public **getMessage** ()

Mensaje de registro

public **getTime** ()

Marca de tiempo del registro

public **getContext** ()

...

public **__construct** (*string* $message, *integer* $type, [*integer* $time], [*array* $context])

Phalcon\Logger\Item constructor