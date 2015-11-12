Interface **Phalcon\\DiInterface**
==================================

*implements* ArrayAccess

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/diinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **set** (*unknown* $name, *unknown* $definition, [*unknown* $shared])

...


abstract public  **setShared** (*unknown* $name, *unknown* $definition)

...


abstract public  **remove** (*unknown* $name)

...


abstract public  **attempt** (*unknown* $name, *unknown* $definition, [*unknown* $shared])

...


abstract public  **get** (*unknown* $name, [*unknown* $parameters])

...


abstract public  **getShared** (*unknown* $name, [*unknown* $parameters])

...


abstract public  **setRaw** (*unknown* $name, :doc:`Phalcon\\Di\\ServiceInterface <Phalcon_Di_ServiceInterface>` $rawDefinition)

...


abstract public  **getRaw** (*unknown* $name)

...


abstract public  **getService** (*unknown* $name)

...


abstract public  **has** (*unknown* $name)

...


abstract public  **wasFreshInstance** ()

...


abstract public  **getServices** ()

...


abstract public static  **setDefault** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

...


abstract public static  **getDefault** ()

...


abstract public static  **reset** ()

...


abstract public  **offsetExists** (*unknown* $offset) inherited from ArrayAccess

...


abstract public  **offsetGet** (*unknown* $offset) inherited from ArrayAccess

...


abstract public  **offsetSet** (*unknown* $offset, *unknown* $value) inherited from ArrayAccess

...


abstract public  **offsetUnset** (*unknown* $offset) inherited from ArrayAccess

...


