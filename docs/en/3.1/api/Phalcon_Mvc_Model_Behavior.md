# Abstract class **Phalcon\\Mvc\\Model\\Behavior**

*implements* [Phalcon\Mvc\Model\BehaviorInterface](/en/3.1.2/api/Phalcon_Mvc_Model_BehaviorInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/behavior.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This is an optional base class for ORM behaviors


## Methods
public  **__construct** ([*array* $options])





protected  **mustTakeAction** (*mixed* $eventName)

Checks whether the behavior must take action on certain event



protected *array* **getOptions** ([*string* $eventName])

Returns the behavior options related to an event



public  **notify** (*mixed* $type, [Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model)

This method receives the notifications from the EventsManager



public  **missingMethod** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model, *string* $method, [*array* $arguments])

Acts as fallbacks when a missing method is called on the model



