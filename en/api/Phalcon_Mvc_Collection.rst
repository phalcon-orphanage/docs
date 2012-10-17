Class **Phalcon\\Mvc\\Collection**
==================================

Methods
---------

public  **__construct** (*unknown* $dependencyInjector)

...


public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)

Sets the dependency injection container



public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()

Returns the dependency injection container



public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager)

Sets the event manager



public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** ()

Returns the internal event manager



public *array*  **getReservedAttributes** ()





protected :doc:`Phalcon\\Mvc\\Collection <Phalcon_Mvc_Collection>`  **setSource** ()

Sets collection name which model should be mapped



public *string*  **getSource** ()

Returns collection name mapped in the model



public  **setConnectionService** ()

...


public  **getConnection** ()

...


public *mixed*  **readAttribute** (*string* $attribute)

Reads an attribute value by its name <code> echo $robot->readAttribute('name');



public  **writeAttribute** (*string* $attribute, *mixed* $value)

Writes an attribute value by its name <code>$robot->writeAttribute('name', 'Rosey');



protected static  **dumpResult** ()

...


protected static  **_getResultset** ()

...


protected *boolean*  **_preSave** ()

Executes internal hooks before save a record



public  **save** ()

...


public static  **findFirst** (*unknown* $parameters)

...


public static  **find** (*unknown* $parameters)

...


public  **delete** ()

...


