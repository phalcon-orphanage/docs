---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Assets\Resource'
---
# Class **Phalcon\Assets\Resource**

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/resource.zep)

نمایه یک دارایی است

```php
<?php

$resource = new \Phalcon\Assets\Resource("js", "javascripts/jquery.js");

```

## روش ها

public **getType** ()

public **getPath** ()

عمومی **دریافت محلی** ()

public **getFilter** ()

public **getAttributes** ()

public **getSourcePath** ()

...

public **getTargetPath** ()

...

public **getTargetUri** ()

...

public **__construct** (*string* $type, *string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Resource constructor

public **setType** (*mixed* $type)

نوع منبع را تعیین می کند

public **setPath** (*mixed* $path)

مسیر منبع را تعیین می کند

public **setLocal** (*mixed* $local)

تعیین می کند که آیا منبع محلی است یا خارجی

public **setFilter** (*mixed* $filter)

تعیین می کند که آیا منابع باید فیلتر شوند یا خیر

public **setAttributes** (*array* $attributes)

ویژگی های HTML اضافی را تعیین می کند

public **setTargetUri** (*mixed* $targetUri)

مجموعه هدف uri را برای HTML ایجاد می کند

public **setSourcePath** (*mixed* $sourcePath)

Sets the resource's source path

public **setTargetPath** (*mixed* $targetPath)

Sets the resource's target path

public **getContent** ([*mixed* $basePath])

Returns the content of the resource as an string Optionally a base path where the resource is located can be set

public **getRealTargetUri** ()

Returns the real target uri for the generated HTML

public **getRealSourcePath** ([*mixed* $basePath])

Returns the complete location where the resource is located

public **getRealTargetPath** ([*mixed* $basePath])

Returns the complete location where the resource must be written

public **getResourceKey** ()

کلید منبع را دریافت می کند.