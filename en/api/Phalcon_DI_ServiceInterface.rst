Interface **Phalcon\\DI\\ServiceInterface**
===========================================

Phalcon\\DI\\ServiceInterface initializer


Methods
-------

abstract public  **getName** ()

Returns the service's name



abstract public  **setShared** (*boolean* $shared)

Sets if the service is shared or not



abstract public *boolean*  **isShared** ()

Check whether the service is shared or not



abstract public  **setDefinition** (*mixed* $definition)

Set the service definition



abstract public *mixed*  **getDefinition** ()

Returns the service definition



abstract public  **isResolved** ()

...


abstract public *mixed*  **resolve** ([*array* $parameters], [:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector])

Resolves the service



