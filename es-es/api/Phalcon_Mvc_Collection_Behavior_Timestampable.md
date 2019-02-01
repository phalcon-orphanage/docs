---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Mvc\Collection\Behavior\Timestampable'
---
# Class **Phalcon\Mvc\Collection\Behavior\Timestampable**

*extends* abstract class [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

*implements* [Phalcon\Mvc\Collection\BehaviorInterface](Phalcon_Mvc_Collection_BehaviorInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/collection/behavior/timestampable.zep)

Permite actualizar automáticamente el atributo del modelo guardando la fecha y hora cuando se creó o actualizó el registro

## Métodos

public **notify** (*mixed* $type, [Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Escucha las notificaciones del administrador de modelos

public **__construct** ([*array* $options]) inherited from [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

Phalcon\Mvc\Collection\Behavior

protected **mustTakeAction** (*mixed* $eventName) inherited from [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

Comprueba si el comportamiento debe actuar en ciertos eventos

protected *array* **getOptions** ([*string* $eventName]) inherited from [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

Devuelve las opciones de comportamiento relacionadas a un evento

public **missingMethod** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, *mixed* $method, [*mixed* $arguments]) inherited from [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

Actúa como reservas cuando se llama un método faltante en la colección