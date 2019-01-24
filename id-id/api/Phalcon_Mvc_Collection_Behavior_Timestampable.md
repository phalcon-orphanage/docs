---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Collection\Behavior\Timestampable'
---
# Class **Phalcon\Mvc\Collection\Behavior\Timestampable**

*extends* abstract class [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

*implements* [Phalcon\Mvc\Collection\BehaviorInterface](Phalcon_Mvc_Collection_BehaviorInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/collection/behavior/timestampable.zep)

Memungkinkan untuk memperbarui secara otomatis atribut model yang menyimpannya datetime saat record dibuat atau diperbaharui

## Metode

public **notify** (*mixed* $type, [Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Mendengarkan pemberitahuan dari manajer model

public **__construct** ([*array* $options]) inherited from [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

Phalcon\Mvc\Collection\Behavior

protected **mustTakeAction** (*mixed* $eventName) inherited from [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

Memeriksa apakah perilaku tersebut harus mengambil tindakan pada acara tertentu

protected *array* **getOptions** ([*string* $eventName]) inherited from [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

Mengembalikan opsi perilaku yang terkait dengan suatu peristiwa

public **missingMethod** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, *mixed* $method, [*mixed* $arguments]) inherited from [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

Bertindak mundur saat metode yang hilang dipanggil pada koleksi