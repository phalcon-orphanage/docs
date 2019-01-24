---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Annotations\AdapterInterface'
---
# Interface **Phalcon\Annotations\AdapterInterface**

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapterinterface.zep)

این رابط باید توسط آداپتورها در فالکون\حاشیه نویسی اجرا شود

## روش ها

abstract public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

تجزیه کننده حاشیه نویسی را تنظیم می کند

چکیده عمومی **دریافت خواننده** ()

خواننده حاشیه نویسی را برمی گرداند

عمومی **دریافت** (*رشته|شی*$className)

تمام حاشیه نویسی های موجود در یک کلاس را تجزیه و یا بازیابی می کند

عمومی انتزاعی **دریافت روش** (*رشته*$className)

حاشیه نویسی های موجود در تمام روش های کلاس را می دهد

عمومی انتزاعی **دریافت روش** (*رشته* $className, *رشته* $methodName)

حاشیه نویسی های موجود در یک روش خاص را برمی گرداند

عمومی انتزاعی **دریافت خواص** (*رشته*$className)

حاشیه نویسی های موجود در تمام روش های کلاس را می دهد

عمومی انتزاعی **دریافت املاک** (*رشته*$className, *رشته* $propertyName)

حاشیه نویسی های موجود در یک روش خاص را برمی گرداند