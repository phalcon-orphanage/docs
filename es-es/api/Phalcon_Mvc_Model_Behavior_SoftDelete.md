---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Mvc\Model\Behavior\SoftDelete'
---
# Class **Phalcon\Mvc\Model\Behavior\SoftDelete**

*extends* abstract class [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

*implements* [Phalcon\Mvc\Model\BehaviorInterface](Phalcon_Mvc_Model_BehaviorInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/behavior/softdelete.zep)

En lugar de eliminar permanente mente un registro, marca el registro como eliminado cambiando el valor de una columna de marca

## Métodos

public **notify** (*mixed* $type, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Escucha las notificaciones del administrador de modelos

public **__construct** ([*array* $options]) inherited from [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

Phalcon\Mvc\Model\Behavior

protected **mustTakeAction** (*mixed* $eventName) inherited from [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

Comprueba si el comportamiento debe actuar en ciertos eventos

protected *array* **getOptions** ([*string* $eventName]) inherited from [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

Devuelve las opciones de comportamiento relacionadas a un evento

public **missingMethod** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *string* $method, [*array* $arguments]) inherited from [Phalcon\Mvc\Model\Behavior](Phalcon_Mvc_Model_Behavior)

Acts as fallbacks when a missing method is called on the model