---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Mvc\Model\Behavior'
---
# Abstract class **Phalcon\Mvc\Model\Behavior**

*implements* [Phalcon\Mvc\Model\BehaviorInterface](Phalcon_Mvc_Model_BehaviorInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/behavior.zep)

Este es una clase base opcional para comportamientos ORM

## Métodos

public **__construct** ([*array* $options])

protected **mustTakeAction** (*mixed* $eventName)

Comprueba si el comportamiento debe actuar en ciertos eventos

protected *array* **getOptions** ([*string* $eventName])

Devuelve las opciones de comportamiento relacionadas a un evento

public **notify** (*mixed* $type, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Este método recibe las notificaciones del EventsManager

public **missingMethod** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *string* $method, [*array* $arguments])

Acts as fallbacks when a missing method is called on the model