---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Assets\Inline'
---
# Class **Phalcon\Assets\Inline**

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/inline.zep)

Represents an inline asset

```php
<?php

$inline = new \Phalcon\Assets\Inline("js", "alert('hello world');");

```

## روش ها

public **getType** ()

...

public **getContent** ()

...

public **getFilter** ()

...

public **getAttributes** ()

...

public **__construct** (*string* $type, *string* $content, [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Inline constructor

public **setType** (*mixed* $type)

نوع خطی را تنظیم می کند

public **setFilter** (*mixed* $filter)

تعیین می کند که آیا منابع باید فیلتر شوند یا خیر

public **setAttributes** (*array* $attributes)

ویژگی های HTML اضافی را تعیین می کند

public **getResourceKey** ()

کلید منبع را دریافت می کند.