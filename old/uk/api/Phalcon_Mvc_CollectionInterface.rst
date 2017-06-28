Interface **Phalcon\\Mvc\\CollectionInterface**
===============================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/collectioninterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **setId** (*mixed* $id)

...


abstract public  **getId** ()

...


abstract public  **getReservedAttributes** ()

...


abstract public  **getSource** ()

...


abstract public  **setConnectionService** (*mixed* $connectionService)

...


abstract public  **getConnection** ()

...


abstract public  **setDirtyState** (*mixed* $dirtyState)

...


abstract public  **getDirtyState** ()

...


abstract public static  **cloneResult** (:doc:`Phalcon\\Mvc\\CollectionInterface <Phalcon_Mvc_CollectionInterface>` $collection, *array* $document)

...


abstract public  **fireEvent** (*mixed* $eventName)

...


abstract public  **fireEventCancel** (*mixed* $eventName)

...


abstract public  **validationHasFailed** ()

...


abstract public  **getMessages** ()

...


abstract public  **appendMessage** (:doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>` $message)

...


abstract public  **save** ()

...


abstract public static  **findById** (*mixed* $id)

...


abstract public static  **findFirst** ([*array* $parameters])

...


abstract public static  **find** ([*array* $parameters])

...


abstract public static  **count** ([*array* $parameters])

...


abstract public  **delete** ()

...


