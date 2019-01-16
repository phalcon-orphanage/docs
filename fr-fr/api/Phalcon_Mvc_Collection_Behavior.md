* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Collection\Behavior'

* * *

# Abstract class **Phalcon\Mvc\Collection\Behavior**

*implements* [Phalcon\Mvc\Collection\BehaviorInterface](Phalcon_Mvc_Collection_BehaviorInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/collection/behavior.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This is an optional base class for ORM behaviors

## Methods

public **__construct** ([*array* $options])

protected **mustTakeAction** (*mixed* $eventName)

Checks whether the behavior must take action on certain event

protected *array* **getOptions** ([*string* $eventName])

Returns the behavior options related to an event

public **notify** (*mixed* $type, [Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

This method receives the notifications from the EventsManager

public **missingMethod** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, *mixed* $method, [*mixed* $arguments])

Acts as fallbacks when a missing method is called on the collection