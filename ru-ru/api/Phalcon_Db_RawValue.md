---
layout: article
language: 'ru-ru'
version: '4.0'
title: 'Phalcon\Db\RawValue'
---
# Class **Phalcon\Db\RawValue**

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/rawvalue.zep)

This class allows to insert/update raw data without quoting or formatting.

The next example shows how to use the MySQL now() function as a field value.

```php
<?php

$subscriber = new Subscribers();

$subscriber->email     = "andres@phalconphp.com";
$subscriber->createdAt = new \Phalcon\Db\RawValue("now()");

$subscriber->save();

```

## Methods

public **getValue** ()

Raw value without quoting or formatting

public **__toString** ()

Raw value without quoting or formatting

public **__construct** (*mixed* $value)

Phalcon\Db\RawValue constructor