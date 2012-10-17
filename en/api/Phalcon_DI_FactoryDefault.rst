Class **Phalcon\\DI\\FactoryDefault**
=====================================

*extends* :doc:`Phalcon\\DI <Phalcon_DI>`

This is a variant of the standard Phalcon\\DI. By default it automatically registers all the services provided by the framework. Thanks to this, the developer does not need to register each service individually.


Methods
---------

public  **__construct** ()

Phalcon\\DI\\FactoryDefault constructor



public :doc:`Phalcon\\DI <Phalcon_DI>`  **set** (*string* $alias, *mixed* $config) inherited from Phalcon\\DI

Registers a service in the services container



public :doc:`Phalcon\\DI <Phalcon_DI>`  **remove** (*string* $alias) inherited from Phalcon\\DI

Removes a service in the services container



public :doc:`Phalcon\\DI <Phalcon_DI>`  **attempt** (*string* $alias, *mixed* $config) inherited from Phalcon\\DI

Attempts to register a service in the services container Only is successful if a services hasn't been registered previosly with the same name



public *mixed*  **_factory** (*string* $service, *mixed* $parameters) inherited from Phalcon\\DI

Factories instances based on its config



public *mixed*  **get** (*string* $alias, *array* $parameters) inherited from Phalcon\\DI

Resolves the service based on its configuration



public *mixed*  **getShared** (*string* $alias, *array* $parameters) inherited from Phalcon\\DI

Returns a shared service based on its configuration



public *boolean*  **has** (*unknown* $alias) inherited from Phalcon\\DI

Check whether the DI contains a service by a name



public *boolean*  **wasFreshInstance** () inherited from Phalcon\\DI

Check whether the last service obtained via getShared produced a fresh instance or an existing one



public *mixed*  **__call** (*string* $method, *array* $arguments) inherited from Phalcon\\DI

Magic method to get or set services using setters/getters



public static  **setDefault** (*string* $dependencyInjector) inherited from Phalcon\\DI

Set a default dependency injection container to be obtained into static methods



public static :doc:`Phalcon\\DI <Phalcon_DI>`  **getDefault** () inherited from Phalcon\\DI

Return the last DI created



public static  **reset** () inherited from Phalcon\\DI

Resets the internal default DI



