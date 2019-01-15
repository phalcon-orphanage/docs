* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Collection\Behavior\Timestampable'

* * *

# Class **Phalcon\Mvc\Collection\Behavior\Timestampable**

*extends* abstract class [Phalcon\Mvc\Collection\Behavior](/4.0/en/api/Phalcon_Mvc_Collection_Behavior)

*implements* [Phalcon\Mvc\Collection\BehaviorInterface](/4.0/en/api/Phalcon_Mvc_Collection_BehaviorInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/collection/behavior/timestampable.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Allows to automatically update a model’s attribute saving the datetime when a record is created or updated

## Methods

public **notify** (*mixed* $type, [Phalcon\Mvc\CollectionInterface](/4.0/en/api/Phalcon_Mvc_CollectionInterface) $model)

Listens for notifications from the models manager

public **__construct** ([*array* $options]) inherited from [Phalcon\Mvc\Collection\Behavior](/4.0/en/api/Phalcon_Mvc_Collection_Behavior)

Phalcon\Mvc\Collection\Behavior

protected **mustTakeAction** (*mixed* $eventName) inherited from [Phalcon\Mvc\Collection\Behavior](/4.0/en/api/Phalcon_Mvc_Collection_Behavior)

Checks whether the behavior must take action on certain event

protected *array* **getOptions** ([*string* $eventName]) inherited from [Phalcon\Mvc\Collection\Behavior](/4.0/en/api/Phalcon_Mvc_Collection_Behavior)

Returns the behavior options related to an event

public **missingMethod** ([Phalcon\Mvc\CollectionInterface](/4.0/en/api/Phalcon_Mvc_CollectionInterface) $model, *mixed* $method, [*mixed* $arguments]) inherited from [Phalcon\Mvc\Collection\Behavior](/4.0/en/api/Phalcon_Mvc_Collection_Behavior)

Acts as fallbacks when a missing method is called on the collection