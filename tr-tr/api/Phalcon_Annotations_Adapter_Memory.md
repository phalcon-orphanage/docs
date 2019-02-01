---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Annotations\Adapter\Memory'
---
# Class **Phalcon\Annotations\Adapter\Memory**

*extends* abstract class [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter/memory.zep)

Stores the parsed annotations in memory. This adapter is the suitable development/testing

## Metodlar

herkese açık **oku** (*karışık*$anahtar)

Bellekten çözümlenmiş açıklamaları okur

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](Phalcon_Annotations_Reflection) $data)

Ayrıştırılmış ek açıklamaları belleğe yazar

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Ek açıklama ayrıştırıcısını ayarlar

public **getReader** () inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Açıklama okuyucusunu döndürür

public **get** (*string* | *object* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Bir sınıfta bulunan tüm notaları ayrıştırır veya alır

public **getMethods** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Bütün sınıf yöntemlerinde olan notları çevirir

public **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Özel methodlarda ek açıklamaları bulur ve çevirir

public **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Bütün sınıf yöntemlerinde olan notları çevirir

public **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Belli bir özellikte bulunan açıklamaları getirir