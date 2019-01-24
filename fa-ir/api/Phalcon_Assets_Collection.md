---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Assets\Collection'
---
# Class **Phalcon\Assets\Collection**

*implements* [Countable](https://php.net/manual/en/class.countable.php), [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php)

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/collection.zep)

مجموعه ای از منابع را نشان می دهد

## روش ها

عمومی **دریافت پیشوند** ()

...

عمومی **دریافت محلی** ()

...

عمومی **دریافت منابع** ()

...

عمومی **دریافت نام** ()

...

عمومی **دریافت موقعیت** ()

...

public **getFilters** ()

...

public **getAttributes** ()

...

public **getJoin** ()

...

public **getTargetUri** ()

...

public **getTargetPath** ()

...

public **getTargetLocal** ()

...

public **getSourcePath** ()

...

عمومی **__ ساخت** ()

Phalcon\Assets\Collection constructor

public **add** ([Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Adds a resource to the collection

public **addInline** ([Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Adds an inline code to the collection

public **has** ([Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface) $resource)

Checks this the resource is added to the collection.

```php
<?php

use Phalcon\Assets\Resource;
use Phalcon\Assets\Collection;

$collection = new Collection();

$resource = new Resource("js", "js/jquery.js");
$resource->has($resource); // true

```

public **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

Adds a CSS resource to the collection

public **addInlineCss** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Adds an inline CSS to the collection

public [Phalcon\Assets\Collection](Phalcon_Assets_Collection) **addJs** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Adds a javascript resource to the collection

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Adds an inline javascript to the collection

عمومی **تعداد** ()

Returns the number of elements in the form

عمومی **بازخوانی** ()

تکرارکننده داخلی را باز می کند

public **current** ()

Returns the current resource in the iterator

public *int* **key** ()

موقعیت/کلید فعلی را در تکرار بازگرداند

عمومی **بعدی** ()

اشاره گر تکرار داخلی را به موقعیت بعدی حرکت می دهد

عمومی **معتبر** ()

Check if the current element in the iterator is valid

public **setTargetPath** (*mixed* $targetPath)

Sets the target path of the file for the filtered/join output

public **setSourcePath** (*mixed* $sourcePath)

مسیر اصلی منبع را برای تمام منابع موجود در این مجموعه تعیین می کند

public **setTargetUri** (*mixed* $targetUri)

مجموعه هدف uri را برای HTML ایجاد می کند

public **setPrefix** (*mixed* $prefix)

پیشوند مشترک برای تمام منابع را تنظیم می کند

public **setLocal** (*mixed* $local)

مجموعه ای از کلکسیون به طور پیش فرض از منابع محلی استفاده می کند

public **setAttributes** (*array* $attributes)

ویژگی های HTML اضافی را تعیین می کند

public **setFilters** (*array* $filters)

مجموعهای از فیلترهای مجموعه را تنظیم می کند

public **setTargetLocal** (*mixed* $targetLocal)

هدف محلی مجموعه

public **join** (*mixed* $join)

تعیین می کند که آیا تمام منابع فیلتر شده در مجموعه باید در یک فایل نتیجه یکپارچه شوند

public **getRealTargetPath** (*mixed* $basePath)

مکان کامل جایی که مجموعه مجموعه پیوسته/فیلتر شده باید نوشته شود را نشان می دهد

public **addFilter** ([Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface) $filter)

یک فیلتر را به مجموعه اضافه می کند

final protected **addResource** ([Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface) $resource)

یک منبع یا کد درون خطی را به مجموعه اضافه می کند