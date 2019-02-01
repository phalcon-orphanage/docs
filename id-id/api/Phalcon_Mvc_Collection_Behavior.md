---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Collection\Behavior'
---
# Abstract class **Phalcon\Mvc\Collection\Behavior**

*implements* [Phalcon\Mvc\Collection\BehaviorInterface](Phalcon_Mvc_Collection_BehaviorInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/collection/behavior.zep)

Ini adalah kelas dasar opsional untuk perilaku ORM

## Metode

umum **__membangun** ([*array* $options])

protected **mustTakeAction** (*mixed* $eventName)

Memeriksa apakah perilaku tersebut harus mengambil tindakan pada acara tertentu

protected *array* **getOptions** ([*string* $eventName])

Mengembalikan opsi perilaku yang terkait dengan suatu peristiwa

public **notify** (*mixed* $type, [Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Metode ini menerima pemberitahuan dari PengelolaAcara

public **missingMethod** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, *mixed* $method, [*mixed* $arguments])

Bertindak mundur saat metode yang hilang dipanggil pada koleksi