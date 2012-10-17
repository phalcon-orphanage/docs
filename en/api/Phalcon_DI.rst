Class **Phalcon\\DI**
=====================




Methods
---------

public  **__construct** ()

...


public :doc:`Phalcon\\DI <Phalcon_DI>`  **set** (*string* $alias, *mixed* $config)

Registers a service in the services container



public :doc:`Phalcon\\DI <Phalcon_DI>`  **remove** (*string* $alias)

Removes a service in the services container



public :doc:`Phalcon\\DI <Phalcon_DI>`  **attempt** (*string* $alias, *mixed* $config)

Attempts to register a service in the services container Only is successful if a services hasn't been registered previosly with the same name



public *mixed*  **_factory** (*string* $service, *mixed* $parameters)

Factories instances based on its config



public *mixed*  **get** (*string* $alias, *array* $parameters)

Resolves the service based on its configuration



public *mixed*  **getShared** (*string* $alias, *array* $parameters)

Returns a shared service based on its configuration



public *boolean*  **has** (*unknown* $alias)

Check whether the DI contains a service by a name



public *boolean*  **wasFreshInstance** ()

Check whether the last service obtained via getShared produced a fresh instance or an existing one



public *mixed*  **__call** (*string* $method, *array* $arguments)

Magic method to get or set services using setters/getters



public static  **setDefault** (*string* $dependencyInjector)

Set a default dependency injection container to be obtained into static methods



public static :doc:`Phalcon\\DI <Phalcon_DI>`  **getDefault** ()

Return the last DI created



public static  **reset** ()

Resets the internal default DI



