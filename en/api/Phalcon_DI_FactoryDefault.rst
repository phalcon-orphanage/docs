Class **Phalcon\\DI\\FactoryDefault**
=====================================

*extends* :doc:`Phalcon\\DI <Phalcon_DI>`

This is a variant of the standard Phalcon\\DI. By default it automatically registers all the services provided by the framework. Thanks to this, the developer does not need to register each service individually.


Methods
---------

public  **__construct** ()

Phalcon\\DI\\FactoryDefault constructor



public  **set** (*unknown* $alias, *unknown* $config) inherited from Phalcon\DI

...


public  **remove** (*unknown* $alias) inherited from Phalcon\DI

...


public  **attempt** (*unknown* $alias, *unknown* $config) inherited from Phalcon\DI

...


public  **_factory** (*unknown* $service, *unknown* $parameters) inherited from Phalcon\DI

...


public  **get** (*unknown* $alias, *unknown* $parameters) inherited from Phalcon\DI

...


public  **getShared** (*unknown* $alias, *unknown* $parameters) inherited from Phalcon\DI

...


public *boolean*  **has** (*unknown* $alias) inherited from Phalcon\DI

Check whether the DI contains a service by a name



public *boolean*  **wasFreshInstance** () inherited from Phalcon\DI

Check whether the last service obtained via getShared produced a fresh instance or an existing one



public *mixed*  **__call** (*string* $method, *array* $arguments) inherited from Phalcon\DI

Magic method to get or set services using setters/getters



public static  **setDefault** (*unknown* $dependencyInjector) inherited from Phalcon\DI

...


public static :doc:`Phalcon\\DI <Phalcon_DI>`  **getDefault** () inherited from Phalcon\DI

Return the last DI created



public static  **reset** () inherited from Phalcon\DI

Resets the internal default DI



