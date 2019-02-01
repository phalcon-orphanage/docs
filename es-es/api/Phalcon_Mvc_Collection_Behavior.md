---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Mvc\Collection\Behavior'
---
# Abstract class **Phalcon\Mvc\Collection\Behavior**

*implements* [Phalcon\Mvc\Collection\BehaviorInterface](Phalcon_Mvc_Collection_BehaviorInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/collection/behavior.zep)

Este es una clase base opcional para comportamientos ORM

## Métodos

public **__construct** ([*array* $options])

protected **mustTakeAction** (*mixed* $eventName)

Comprueba si el comportamiento debe actuar en ciertos eventos

protected *array* **getOptions** ([*string* $eventName])

Devuelve las opciones de comportamiento relacionadas a un evento

public **notify** (*mixed* $type, [Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Este método recibe las notificaciones del EventsManager

public **missingMethod** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, *mixed* $method, [*mixed* $arguments])

Actúa como reservas cuando se llama un método faltante en la colección