---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Db\RawValue'
---
# Class **Phalcon\Db\RawValue**

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/rawvalue.zep)

Esta clase permite insertar o actualizar información no procesada sin citar o formatear.

El siguiente ejemplo muestra cómo utilizar la función MySQL now() como un valor de campo.

```php
<?php

$subscriber = new Subscribers();

$subscriber->email     = "andres@phalconphp.com";
$subscriber->createdAt = new \Phalcon\Db\RawValue("now()");

$subscriber->save();

```

## Métodos

public **getValue** ()

Valor no procesado sin citar o formatear

public **__toString** ()

Valor no procesado sin citar o formatear

public **__construct** (*mixed* $value)

Phalcon\Db\RawValue constructor