Interface **Phalcon\\DiInterface**
==================================

*extends* ArrayAccess

Methods
---------

abstract public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **set** (*string* $alias, *mixed* $definition, [*boolean* $shared])

Registers a service in the services container



abstract public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **setShared** (*string* $name, *mixed* $definition)

Registers an "always shared" service in the services container



abstract public  **remove** (*string* $alias)

Removes a service in the services container



abstract public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **attempt** (*string* $alias, *mixed* $definition, [*boolean* $shared])

Attempts to register a service in the services container Only is successful if a service hasn't been registered previously with the same name



abstract public *mixed*  **get** (*string* $alias, [*array* $parameters])

Resolves the service based on its configuration



abstract public *mixed*  **getShared** (*string* $alias, [*array* $parameters])

Returns a shared service based on their configuration



abstract public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **setRaw** (*string* $name, :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>` $rawDefinition)

Sets a service using a raw Phalcon\\DI\\Service definition



abstract public *mixed*  **getRaw** (*string* $name)

Returns a service definition without resolving



abstract public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **getService** (*string* $name)

Returns the corresponding Phalcon\\Di\\Service instance for a service



abstract public *boolean*  **has** (*string* $alias)

Check whether the DI contains a service by a name



abstract public *boolean*  **wasFreshInstance** ()

Check whether the last service obtained via getShared produced a fresh instance or an existing one



abstract public *array*  **getServices** ()

Return the services registered in the DI



abstract public static  **setDefault** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Set a default dependency injection container to be obtained into static methods



abstract public static :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDefault** ()

Return the last DI created



abstract public static  **reset** ()

Resets the internal default DI



abstract public  **offsetExists** (*unknown* $offset) inherited from ArrayAccess

...


abstract public  **offsetGet** (*unknown* $offset) inherited from ArrayAccess

...


abstract public  **offsetSet** (*unknown* $offset, *unknown* $value) inherited from ArrayAccess

...


abstract public  **offsetUnset** (*unknown* $offset) inherited from ArrayAccess

...


