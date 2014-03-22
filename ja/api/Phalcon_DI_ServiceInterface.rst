Interface **Phalcon\\DI\\ServiceInterface**
===========================================

Phalcon\\DI\\ServiceInterface initializer


Methods
-------

abstract public *string*  **getName** ()

Returns the name of the service



abstract public  **setShared** (*boolean* $shared)

Sets whether the service is shared or not



abstract public *boolean*  **isShared** ()

Check whether the service is shared or not



abstract public  **setDefinition** (*mixed* $definition)

Set the service definition



abstract public *mixed*  **getDefinition** ()

Returns the service definition



abstract public *bool*  **isResolved** ()

Checks if the service was resolved



abstract public *object*  **resolve** ([*array* $parameters], [:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector])

Resolves the service



