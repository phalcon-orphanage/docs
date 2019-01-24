---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Anotasi\Adaptor\Memori'
---
# Class **Phalcon\Annotations\Adapter\Memory**

*extends* abstract class [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter/memory.zep)

Stores the parsed annotations in memory. This adapter is the suitable development/testing

## Metode

public **baca** (*mixed* $key)

Membaca anotasi parsing dari memori

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](Phalcon_Annotations_Reflection) $data)

Menulis anotasi parsing ke memori

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Menyetel anotasi

public **getReader** () inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Mengembalikan pembaca anotasi

public **get** (*string* | *object* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Mengurai atau mengambil semua anotasi yang ditemukan di kelas

public **getMethods** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Mengembalikan anotasi yang ditemukan di semua metode kelas'

public **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Mengembalikan anotasi yang ditemukan dalam metode tertentu

public **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Mengembalikan anotasi yang ditemukan di semua metode kelas'

public **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Mengembalikan anotasi yang ditemukan di properti tertentu