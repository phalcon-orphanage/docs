---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Relation'
---
# Abstract class **Phalcon\Mvc\Model\Behavior**

*implements* [Phalcon\Mvc\Model\BehaviorInterface](Phalcon_Mvc_Model_BehaviorInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/behavior.zep)

Ini adalah kelas dasar opsional untuk perilaku ORM

## Metode

umum **__membangun** ([*array* $options])

protected **mustTakeAction** (*mixed* $eventName)

Memeriksa apakah perilaku tersebut harus mengambil tindakan pada acara tertentu

protected *array* **getOptions** ([*string* $eventName])

Mengembalikan opsi perilaku yang terkait dengan suatu peristiwa

public **notify** (*mixed* $type, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Metode ini menerima pemberitahuan dari PengelolaAcara

public **missingMethod** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *string* $method, [*array* $arguments])

Bertindak sebagai fallback ketika metode yang hilang dipanggil pada model