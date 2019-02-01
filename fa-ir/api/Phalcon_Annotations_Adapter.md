---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Annotations\Adapter'
---
# Abstract class **Phalcon\Annotations\Adapter**

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter.zep)

This is the base class for Phalcon\Annotations adapters

## روش ها

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

تجزیه کننده حاشیه نویسی را تنظیم می کند

عمومی **دریافت خواننده** ()

خواننده حاشیه نویسی را برمی گرداند

عمومی **دریافت** (*رشته* | *شی* $className)

تمام حاشیه نویسی های موجود در یک کلاس را تجزیه و یا بازیابی می کند

عمومی **دریافت روش** (*مخلوط* $className)

حاشیه نویسی های موجود در تمام روش های کلاس را می دهد

عمومی **دریافت روش** (*مخلوط* $className, *مخلوط* $methodName)

حاشیه نویسی های موجود در یک روش خاص را برمی گرداند

عمومی **دریافت خواص** (*مخلوط*$className)

حاشیه نویسی های موجود در تمام روش های کلاس را می دهد

عمومی **دریافت املاک** (*مخلوط*$className, *مخلوط* $propertyName)

حاشیه نویسی های موجود در یک روش خاص را برمی گرداند