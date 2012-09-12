Class **Phalcon\\DI**
=====================




Methods
---------

public **__construct** ()

...


public **set** (*unknown* $alias, *unknown* $config)

...


public **remove** (*unknown* $alias)

...


public **attempt** (*unknown* $alias, *unknown* $config)

...


public **_factory** (*unknown* $service, *unknown* $parameters)

...


public **get** (*unknown* $alias, *unknown* $parameters)

...


public **getShared** (*unknown* $alias, *unknown* $parameters)

...


*boolean* public **has** (*unknown* $alias)

Check whether the DI contains a service by a name



*boolean* public **wasFreshInstance** ()

Check whether the last service obtained via getShared produced a fresh instance or an existing one



*mixed* public **__call** (*string* $method, *array* $arguments)

Magic method to get or set services using setters/getters



public static **setDefault** (*unknown* $dependencyInjector)

...


:doc:`Phalcon\\DI <Phalcon_DI>` public static **getDefault** ()

Return the last DI created



public static **reset** ()

Resets the internal default DI



