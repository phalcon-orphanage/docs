---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'فالکون/حاشیه نویسی/آداپتور/مخزن ایکس'
---
# Class **Phalcon\Annotations\Adapter\Xcache**

*extends* abstract class [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter/xcache.zep)

Stores the parsed annotations to XCache. This adapter is suitable for production

```php
<?php

$annotations = new \Phalcon\Annotations\Adapter\Xcache();

```

## روش ها

public [Phalcon\Annotations\Reflection](Phalcon_Annotations_Reflection) **read** (*string* $key)

یادداشت های تجزیه شده را از مخزن ایکس می خواند

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](Phalcon_Annotations_Reflection) $data)

یادداشت های تجزیه شده را از مخزن ایکس می خواند

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

تجزیه کننده حاشیه نویسی را تنظیم می کند

public **getReader** () inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

خواننده حاشیه نویسی را برمی گرداند

public **get** (*string* | *object* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

تمام حاشیه نویسی های موجود در یک کلاس را تجزیه و یا بازیابی می کند

public **getMethods** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

حاشیه نویسی های موجود در تمام روش های کلاس را می دهد

public **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

حاشیه نویسی های موجود در یک روش خاص را برمی گرداند

public **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

حاشیه نویسی های موجود در تمام روش های کلاس را می دهد

public **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

حاشیه نویسی های موجود در یک روش خاص را برمی گرداند