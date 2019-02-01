---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Behavior\SoftDelete'
---
# Class **Phalcon\Mvc\Model\Behavior\SoftDelete**

*extends* abstract class [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

*implements* [Phalcon\Mvc\Model\BehaviorInterface](Phalcon_Mvc_Model_BehaviorInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/behavior/softdelete.zep)

Alih-alih menghapus catatan secara permanen, ia menandai rekaman sebagai dihapus mengubah nilai kolom bendera

## Metode

public **notify** (*mixed* $type, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mendengarkan pemberitahuan dari manajer model

public **__construct** ([*array* $options]) inherited from [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

Phalcon\Mvc\Model\Relation

protected **mustTakeAction** (*mixed* $eventName) inherited from [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

Memeriksa apakah perilaku tersebut harus mengambil tindakan pada acara tertentu

protected *array* **getOptions** ([*string* $eventName]) inherited from [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

Mengembalikan opsi perilaku yang terkait dengan suatu peristiwa

public **missingMethod** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *string* $method, [*array* $arguments]) inherited from [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

Bertindak sebagai fallback ketika metode yang hilang dipanggil pada model