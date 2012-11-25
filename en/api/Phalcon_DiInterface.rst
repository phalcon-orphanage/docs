Interface **Phalcon\\DiInterface**
==================================

Phalcon\\DiInterface initializer


Methods
---------

abstract public :doc:`Phalcon\\DI <Phalcon_DI>`  **set** (*string* $alias, *mixed* $config, *boolean* $shared)

Registers a service in the services container



abstract public :doc:`Phalcon\\DI <Phalcon_DI>`  **setShared** (*string* $name, *mixed* $config)

Registers an "always shared" service in the services container



abstract public  **remove** (*string* $alias)

Removes a service in the services container



abstract public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **attempt** (*string* $alias, *mixed* $config, *boolean* $shared)

Attempts to register a service in the services container Only is successful if a service hasn't been registered previously with the same name



abstract public *mixed*  **get** (*string* $alias, *array* $parameters)

Resolves the service based on its configuration



abstract public *mixed*  **getShared** (*string* $alias, *array* $parameters)

Returns a shared service based on their configuration



abstract public *mixed*  **getRaw** (*string* $name)

Returns a service definition without resolving



abstract public :doc:`Phalcon\\Di\\ServiceInterface <Phalcon_Di_ServiceInterface>`  **getService** (*unknown* $name)

Returns the corresponding Phalcon\\Di\\Service instance for a service



abstract public *boolean*  **has** (*string* $alias)

Check whether the DI contains a service by a name



abstract public *boolean*  **wasFreshInstance** ()

Check whether the last service obtained via getShared produced a fresh instance or an existing one



abstract public *array*  **getServices** ()

Return the services registered in the DI



abstract public static  **setDefault** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Set a default dependency injection container to be obtained into static methods



abstract public static :doc:`Phalcon\\DI <Phalcon_DI>`  **getDefault** ()

Return the last DI created



abstract public static  **reset** ()

Resets the internal default DI



