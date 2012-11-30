Class **Phalcon\\DI\\FactoryDefault**
=====================================

*extends* :doc:`Phalcon\\DI <Phalcon_DI>`

*implements* :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`

This is a variant of the standard Phalcon\\DI. By default it automatically registers all the services provided by the framework. Thanks to this, the developer does not need to register each service individually.


Methods
---------

public  **__construct** ()

Phalcon\\DI\\FactoryDefault constructor



public :doc:`Phalcon\\Di\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **set** (*string* $name, *mixed* $config, *boolean* $shared) inherited from Phalcon\\DI

Registers a service in the services container



public :doc:`Phalcon\\Di\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **setShared** (*string* $name, *mixed* $config) inherited from Phalcon\\DI

Registers an "always shared" service in the services container



public  **remove** (*string* $name) inherited from Phalcon\\DI

Removes a service in the services container



public :doc:`Phalcon\\Di\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **attempt** (*string* $name, *mixed* $config, *unknown* $shared) inherited from Phalcon\\DI

Attempts to register a service in the services container Only is successful if a service hasn't been registered previously with the same name



public *mixed*  **getRaw** (*string* $name) inherited from Phalcon\\DI

Returns a service definition without resolving



public :doc:`Phalcon\\Di\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **getService** (*unknown* $name) inherited from Phalcon\\DI

Returns a Phalcon\\Di\\Service instance



public *mixed*  **get** (*string* $name, *array* $parameters) inherited from Phalcon\\DI

Resolves the service based on its configuration



public *mixed*  **getShared** (*string* $name, *array* $parameters) inherited from Phalcon\\DI

Returns a shared service based on their configuration



public *boolean*  **has** (*string* $name) inherited from Phalcon\\DI

Check whether the DI contains a service by a name



public *boolean*  **wasFreshInstance** () inherited from Phalcon\\DI

Check whether the last service obtained via getShared produced a fresh instance or an existing one



public *array*  **getServices** () inherited from Phalcon\\DI

Return the services registered in the DI



public *mixed*  **__call** (*string* $method, *array* $arguments) inherited from Phalcon\\DI

Magic method to get or set services using setters/getters



public static  **setDefault** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\DI

Set a default dependency injection container to be obtained into static methods



public static :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDefault** () inherited from Phalcon\\DI

Return the lastest DI created



public static  **reset** () inherited from Phalcon\\DI

Resets the internal default DI



