---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Annotations\AdapterInterface'
---
# Interface **Phalcon\Annotations\AdapterInterface**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapterinterface.zep)

Bu arayüz, Phalcon\Annotations'daki adaptörler tarafından uygulanmalıdır

## Metodlar

abstract public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

Ek açıklama ayrıştırıcısını ayarlar

abstract public **getReader** ()

Açıklama okuyucusunu döndürür

abstract public **get** (*string|object* $className)

Bir sınıfta bulunan tüm notaları ayrıştırır veya alır

abstract public **getMethods** (*string* $className)

Tüm sınıfın yöntemlerinde bulunan açıklamaları geri getirir

abstract public **getMethod** (*string* $className, *string* $methodName)

Özel methodlarda ek açıklamaları bulur ve çevirir

abstract public **getProperties** (*string* $className)

Tüm sınıfın yöntemlerinde bulunan açıklamaları geri getirir

abstract public **getProperty** (*string* $className, *string* $propertyName)

Belli bir özellikte bulunan açıklamaları getirir