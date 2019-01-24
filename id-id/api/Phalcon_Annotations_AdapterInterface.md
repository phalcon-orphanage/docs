---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Annotations\AdapterInterface'
---
# Interface **Phalcon\Annotations\AdapterInterface**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapterinterface.zep)

Antarmuka ini harus diimplementasikan oleh adaptor di Phalcon\Anotasi

## Metode

abstract public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

Menyetel anotasi

abstrak umum **getReader** ()

Mengembalikan pembaca anotasi

abstract public **get** (*string|object* $className)

Mengurai atau mengambil semua anotasi yang ditemukan di kelas

abstract public **getMethods** (*string* $className)

Mengembalikan anotasi yang ditemukan di semua metode kelas

abstract public **getMethod** (*string* $className, *string* $methodName)

Mengembalikan anotasi yang ditemukan dalam metode tertentu

publik abstrak **mendapatkan**properti (*tali*$className)

Mengembalikan anotasi yang ditemukan di semua metode kelas

publik abstrak **mendapatkanproperti** (*tali* $className, *tali* $propertyName)

Mengembalikan anotasi yang ditemukan di properti tertentu