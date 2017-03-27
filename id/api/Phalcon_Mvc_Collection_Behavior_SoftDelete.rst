Class **Phalcon\\Mvc\\Collection\\Behavior\\SoftDelete**
========================================================

*extends* abstract class :doc:`Phalcon\\Mvc\\Collection\\Behavior <Phalcon_Mvc_Collection_Behavior>`

*implements* :doc:`Phalcon\\Mvc\\Collection\\BehaviorInterface <Phalcon_Mvc_Collection_BehaviorInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/collection/behavior/softdelete.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Instead of permanently delete a record it marks the record as
deleted changing the value of a flag column


Methods
-------

public  **notify** (*mixed* $type, :doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model)

Listens for notifications from the models manager



public  **__construct** ([*array* $options]) inherited from :doc:`Phalcon\\Mvc\\Collection\\Behavior <Phalcon_Mvc_Collection_Behavior>`

Phalcon\\Mvc\\Collection\\Behavior



protected  **mustTakeAction** (*mixed* $eventName) inherited from :doc:`Phalcon\\Mvc\\Collection\\Behavior <Phalcon_Mvc_Collection_Behavior>`

Checks whether the behavior must take action on certain event



protected *array* **getOptions** ([*string* $eventName]) inherited from :doc:`Phalcon\\Mvc\\Collection\\Behavior <Phalcon_Mvc_Collection_Behavior>`

Returns the behavior options related to an event



public  **missingMethod** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $model, *mixed* $method, [*mixed* $arguments]) inherited from :doc:`Phalcon\\Mvc\\Collection\\Behavior <Phalcon_Mvc_Collection_Behavior>`

Acts as fallbacks when a missing method is called on the collection



