Class **Phalcon\\DI\\FactoryDefault**
=====================================

*extends* :doc:`Phalcon\\DI <Phalcon_DI>`

<<<<<<< HEAD
=======
*implements* :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`

>>>>>>> 0.7.0
This is a variant of the standard Phalcon\\DI. By default it automatically registers all the services provided by the framework. Thanks to this, the developer does not need to register each service individually.


Methods
---------

public  **__construct** ()

Phalcon\\DI\\FactoryDefault constructor



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **set** (*string* $alias, *mixed* $config) inherited from Phalcon\\DI
=======
public :doc:`Phalcon\\Di\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **set** (*string* $name, *mixed* $config, *boolean* $shared) inherited from Phalcon\\DI
>>>>>>> 0.7.0

Registers a service in the services container



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **remove** (*string* $alias) inherited from Phalcon\\DI
=======
public :doc:`Phalcon\\Di\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **setShared** (*string* $name, *mixed* $config) inherited from Phalcon\\DI

Registers an "always shared" service in the services container



public  **remove** (*string* $name) inherited from Phalcon\\DI
>>>>>>> 0.7.0

Removes a service in the services container



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **attempt** (*string* $alias, *mixed* $config) inherited from Phalcon\\DI

Attempts to register a service in the services container Only is successful if a services hasn't been registered previosly with the same name



public *mixed*  **_factory** (*string* $service, *mixed* $parameters) inherited from Phalcon\\DI

Factories instances based on its config



public *mixed*  **get** (*string* $alias, *array* $parameters) inherited from Phalcon\\DI
=======
public :doc:`Phalcon\\Di\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **attempt** (*string* $name, *mixed* $config, *unknown* $shared) inherited from Phalcon\\DI

Attempts to register a service in the services container Only is successful if a service hasn't been registered previously with the same name



public *mixed*  **getRaw** (*string* $name) inherited from Phalcon\\DI

Returns a service definition without resolving



public :doc:`Phalcon\\Di\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **getService** (*unknown* $name) inherited from Phalcon\\DI

Returns a Phalcon\\Di\\Service instance



public *mixed*  **get** (*string* $name, *array* $parameters) inherited from Phalcon\\DI
>>>>>>> 0.7.0

Resolves the service based on its configuration



<<<<<<< HEAD
public *mixed*  **getShared** (*string* $alias, *array* $parameters) inherited from Phalcon\\DI

Returns a shared service based on its configuration



public *boolean*  **has** (*unknown* $alias) inherited from Phalcon\\DI
=======
public *mixed*  **getShared** (*string* $name, *array* $parameters) inherited from Phalcon\\DI

Returns a shared service based on their configuration



public *boolean*  **has** (*string* $name) inherited from Phalcon\\DI
>>>>>>> 0.7.0

Check whether the DI contains a service by a name



public *boolean*  **wasFreshInstance** () inherited from Phalcon\\DI

Check whether the last service obtained via getShared produced a fresh instance or an existing one



<<<<<<< HEAD
=======
public *array*  **getServices** () inherited from Phalcon\\DI

Return the services registered in the DI



>>>>>>> 0.7.0
public *mixed*  **__call** (*string* $method, *array* $arguments) inherited from Phalcon\\DI

Magic method to get or set services using setters/getters



<<<<<<< HEAD
public static  **setDefault** (*string* $dependencyInjector) inherited from Phalcon\\DI
=======
public static  **setDefault** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\DI
>>>>>>> 0.7.0

Set a default dependency injection container to be obtained into static methods



<<<<<<< HEAD
public static :doc:`Phalcon\\DI <Phalcon_DI>`  **getDefault** () inherited from Phalcon\\DI

Return the last DI created
=======
public static :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDefault** () inherited from Phalcon\\DI

Return the lastest DI created
>>>>>>> 0.7.0



public static  **reset** () inherited from Phalcon\\DI

Resets the internal default DI



