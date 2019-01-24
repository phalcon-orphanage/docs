---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Annotations\Collection'
---
# Class **Phalcon\Annotations\Collection**

*implements* [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php), [Countable](https://php.net/manual/en/class.countable.php)

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/collection.zep)

Represents a collection of annotations. This class allows to traverse a group of annotations easily

```php
<?php

//Traverse annotations
foreach ($classAnnotations as $annotation) {
    echo "Name=", $annotation->getName(), PHP_EOL;
}

//Check if the annotations has a specific
var_dump($classAnnotations->has("Cacheable"));

//Get an specific annotation in the collection
$annotation = $classAnnotations->get("Cacheable");

```

## روش ها

عمومی **__ ساخت** ([*آرایه* $reflectionData])

Phalcon\Annotations\Collection constructor

عمومی **تعداد** ()

تعدادی حاشیه نویسی را در مجموعه می گیر

عمومی **بازخوانی** ()

تکرارکننده داخلی را باز می کند

public [Phalcon\Annotations\Annotation](Phalcon_Annotations_Annotation) **current** ()

حاشیه نویسی فعلی را در آن تکرار می کند

کلید عمومی**کلید** ()

موقعیت/کلید فعلی را در تکرار بازگرداند

عمومی **بعدی** ()

اشاره گر تکرار داخلی را به موقعیت بعدی حرکت می دهد

عمومی **معتبر** ()

بررسی کنید آیا حاشیه نویسی فعلی در تکرار معتبر است

عمومی **دریافت حاشیه نویسی** ()

حاشیه نویسی داخلی را به صورت آرایه نمایش می دهد

عمومی **دریافت** (*رشته* $name)

اولین حاشیه نویسی مطابق با یک نام را برمی گرداند

عمومی **دریافت همه** (*رشته* $name)

تمام حاشیه نویسی هایی را که با یک نام مطابقت دارند، تمام می کند

عمومی **دارای** (*رشته* $name)

بررسی کنید که آیا یک حاشیه در مجموعه وجود دارد