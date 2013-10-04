Interface **Phalcon\\DI\\ServiceInterface**
===========================================

Phalcon\\DI\\ServiceInterface initializer


Methods
---------

abstract public  **__construct** (*string* $name, *mixed* $definition, [*boolean* $shared])





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



abstract public static :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **__set_state** (*array* $attributes)

Restore the interal state of a service



