---
layout: default
language: 'it-it'
version: '4.0'
title: 'Phalcon\Mvc\Collection\Behavior\SoftDelete'
---
# Class **Phalcon\Mvc\Collection\Behavior\SoftDelete**

*extends* abstract class [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

*implements* [Phalcon\Mvc\Collection\BehaviorInterface](Phalcon_Mvc_Collection_BehaviorInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/collection/behavior/softdelete.zep)

Instead of permanently delete a record it marks the record as deleted changing the value of a flag column

## Methods

public **notify** (*mixed* $type, [Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Listens for notifications from the models manager

public **__construct** ([*array* $options]) inherited from [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

Phalcon\Mvc\Collection\Behavior

protected **mustTakeAction** (*mixed* $eventName) inherited from [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

Checks whether the behavior must take action on certain event

protected *array* **getOptions** ([*string* $eventName]) inherited from [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

Returns the behavior options related to an event

public **missingMethod** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, *mixed* $method, [*mixed* $arguments]) inherited from [Phalcon\Mvc\Collection\Behavior](Phalcon_Mvc_Collection_Behavior)

Acts as fallbacks when a missing method is called on the collection