Class **Phalcon\\Mvc\\Model\\Behavior\\SoftDelete**
===================================================

*extends* abstract class :doc:`Phalcon\\Mvc\\Model\\Behavior <Phalcon_Mvc_Model_Behavior>`

*implements* :doc:`Phalcon\\Mvc\\Model\\BehaviorInterface <Phalcon_Mvc_Model_BehaviorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/behavior/softdelete.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Instead of permanently delete a record it marks the record as
deleted changing the value of a flag column


Methods
-------

public  **notify** (*mixed* $type, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Listens for notifications from the models manager



public  **__construct** ([*array* $options]) inherited from :doc:`Phalcon\\Mvc\\Model\\Behavior <Phalcon_Mvc_Model_Behavior>`

Phalcon\\Mvc\\Model\\Behavior



protected  **mustTakeAction** (*mixed* $eventName) inherited from :doc:`Phalcon\\Mvc\\Model\\Behavior <Phalcon_Mvc_Model_Behavior>`

Checks whether the behavior must take action on certain event



protected *array* **getOptions** ([*string* $eventName]) inherited from :doc:`Phalcon\\Mvc\\Model\\Behavior <Phalcon_Mvc_Model_Behavior>`

Returns the behavior options related to an event



public  **missingMethod** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *string* $method, [*array* $arguments]) inherited from :doc:`Phalcon\\Mvc\\Model\\Behavior <Phalcon_Mvc_Model_Behavior>`

Acts as fallbacks when a missing method is called on the model



