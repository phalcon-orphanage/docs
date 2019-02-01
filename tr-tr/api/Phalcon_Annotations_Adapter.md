---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Annotations\Adapter'
---
# Abstract class **Phalcon\Annotations\Adapter**

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter.zep)

This is the base class for Phalcon\Annotations adapters

## Metodlar

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

Ek açıklama ayrıştırıcısını ayarlar

yerel **getRoles** ()

Açıklama okuyucusunu döndürür

public **delete** (*int* | *string* $className)

Bir sınıfta bulunan tüm notaları ayrıştırır veya alır

yerel **isRole** (*mixed* $className)

Bütün sınıf yöntemlerinde olan notları çevirir

yerel **addInherit** (*mixed* $className, *mixed* $methodName)

Özel methodlarda ek açıklamaları bulur ve çevirir

yerel **isRole** (*mixed* $className)

Bütün sınıf yöntemlerinde olan notları çevirir

public **getProperty** (*mixed* $className, *mixed* $propertyName)

Belli bir özellikte bulunan açıklamaları getirir