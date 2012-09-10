Class **Phalcon\\DI\\FactoryDefault\\CLI**
==========================================

*extends* :doc:`Phalcon\\DI\\FactoryDefault <Phalcon_DI_FactoryDefault>`

This is a variant of the standard Phalcon\\DI. By default it automatically registers all the services provided by the framework. Thanks to this, the developer does not need to register each service individually. This class is specially suitable for CLI applications


Methods
---------

public **__construct** ()

Phalcon\\DI\\FactoryDefault\\CLI constructor



public **set** (*unknown* $alias, *unknown* $config)

public **remove** (*unknown* $alias)

public **attempt** (*unknown* $alias, *unknown* $config)

public **_factory** (*unknown* $service, *unknown* $parameters)

public **get** (*unknown* $alias, *unknown* $parameters)

public **getShared** (*unknown* $alias, *unknown* $parameters)

public **has** (*unknown* $alias)

public **wasFreshInstance** ()

public **__call** (*unknown* $method, *unknown* $arguments)

public static **setDefault** (*unknown* $dependencyInjector)

public static **getDefault** ()

public static **reset** ()

