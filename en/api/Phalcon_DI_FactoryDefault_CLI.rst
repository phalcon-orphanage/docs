Class **Phalcon\\DI\\FactoryDefault\\CLI**
==========================================

*extends* :doc:`Phalcon\\DI\\FactoryDefault <Phalcon_DI_FactoryDefault>`

This is a variant of the standard Phalcon\\DI. By default it automatically registers all the services provided by the framework. Thanks to this, the developer does not need to register each service individually. This class is specially suitable for CLI applications


Methods
---------

public **__construct** ()

Phalcon\\DI\\FactoryDefault\\CLI constructor



public **set** (*unknown* $alias, *unknown* $config) inherited from Phalcon_DI

...


public **remove** (*unknown* $alias) inherited from Phalcon_DI

...


public **attempt** (*unknown* $alias, *unknown* $config) inherited from Phalcon_DI

...


public **_factory** (*unknown* $service, *unknown* $parameters) inherited from Phalcon_DI

...


public **get** (*unknown* $alias, *unknown* $parameters) inherited from Phalcon_DI

...


public **getShared** (*unknown* $alias, *unknown* $parameters) inherited from Phalcon_DI

...


*boolean* public **has** (*unknown* $alias) inherited from Phalcon_DI

Check whether the DI contains a service by a name



*boolean* public **wasFreshInstance** () inherited from Phalcon_DI

Check whether the last service obtained via getShared produced a fresh instance or an existing one



*mixed* public **__call** (*string* $method, *array* $arguments) inherited from Phalcon_DI

Magic method to get or set services using setters/getters



public static **setDefault** (*unknown* $dependencyInjector) inherited from Phalcon_DI

...


:doc:`Phalcon\\DI <Phalcon_DI>` public static **getDefault** () inherited from Phalcon_DI

Return the last DI created



public static **reset** () inherited from Phalcon_DI

Resets the internal default DI



