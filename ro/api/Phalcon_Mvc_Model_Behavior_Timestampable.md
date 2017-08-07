# Class **Phalcon\\Mvc\\Model\\Behavior\\Timestampable**

*extends* abstract class [Phalcon\Mvc\Model\Behavior](/en/3.2/api/Phalcon_Mvc_Model_Behavior)

*implements* [Phalcon\Mvc\Model\BehaviorInterface](/en/3.2/api/Phalcon_Mvc_Model_BehaviorInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/behavior/timestampable.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Allows to automatically update a model’s attribute saving the datetime when a record is created or updated

## Methods

public **notify** (*mixed* $type, [Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model)

Listens for notifications from the models manager

public **__construct** ([*array* $options]) inherited from [Phalcon\Mvc\Model\Behavior](/en/3.2/api/Phalcon_Mvc_Model_Behavior)

Phalcon\\Mvc\\Model\\Behavior

protected **mustTakeAction** (*mixed* $eventName) inherited from [Phalcon\Mvc\Model\Behavior](/en/3.2/api/Phalcon_Mvc_Model_Behavior)

Checks whether the behavior must take action on certain event

protected *array* **getOptions** ([*string* $eventName]) inherited from [Phalcon\Mvc\Model\Behavior](/en/3.2/api/Phalcon_Mvc_Model_Behavior)

Returns the behavior options related to an event

public **missingMethod** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model, *string* $method, [*array* $arguments]) inherited from [Phalcon\Mvc\Model\Behavior](/en/3.2/api/Phalcon_Mvc_Model_Behavior)

Acts as fallbacks when a missing method is called on the model