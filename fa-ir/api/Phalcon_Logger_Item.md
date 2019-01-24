---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Logger\Item'
---
# Class **Phalcon\Logger\Item**

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/logger/item.zep)

Represents each item in a logging transaction

## روش ها

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