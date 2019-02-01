---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Annotations\Adapter'
---
# Abstract class **Phalcon\Annotations\Adapter**

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter.zep)

This is the base class for Phalcon\Annotations adapters

## Metode

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

Menyetel anotasi

public **getReader** ()

Mengembalikan pembaca anotasi

public **dapatkan** (*string* | *objek* $className)

Mengurai atau mengambil semua anotasi yang ditemukan di kelas

public **getMethods** (*mixed* $className)

Mengembalikan anotasi yang ditemukan di semua metode kelas'

public **getMethod** (*mixed* $className, *mixed* $methodName)

Mengembalikan anotasi yang ditemukan dalam metode tertentu

public **getProperties** (*mixed* $className)

Mengembalikan anotasi yang ditemukan di semua metode kelas'

public **getProperty** (*mixed* $className, *mixed* $propertyName)

Mengembalikan anotasi yang ditemukan di properti tertentu