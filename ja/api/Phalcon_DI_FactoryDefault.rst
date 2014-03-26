Class **Phalcon\\DI\\FactoryDefault**
=====================================

*extends* class :doc:`Phalcon\\DI <Phalcon_DI>`

*implements* :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`

This is a variant of the standard Phalcon\\DI. By default it automatically registers all the services provided by the framework. Thanks to this, the developer does not need to register each service individually providing a full stack framework


Methods
-------

public  **__construct** ()

Phalcon\\DI\\FactoryDefault constructor



public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **set** (*string* $name, *mixed* $definition, [*boolean* $shared]) inherited from Phalcon\\DI

Registers a service in the services container



public  **remove** (*string* $name) inherited from Phalcon\\DI

Removes a service in the services container



public *mixed*  **getRaw** (*string* $name) inherited from Phalcon\\DI

Returns a service definition without resolving



public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **getService** (*string* $name) inherited from Phalcon\\DI

Returns a Phalcon\\DI\\Service instance



public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **setService** (:doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>` $rawDefinition) inherited from Phalcon\\DI

Sets a service using a raw Phalcon\\DI\\Service definition



public *mixed*  **get** (*string* $name, [*array* $parameters]) inherited from Phalcon\\DI

Resolves the service based on its configuration



public *mixed*  **getShared** (*string* $name, [*array* $parameters]) inherited from Phalcon\\DI

Resolves a service, the resolved service is stored in the DI, subsequent requests for this service will return the same instance



public *boolean*  **has** (*string* $name) inherited from Phalcon\\DI

Check whether the DI contains a service by a name



public *boolean*  **wasFreshInstance** () inherited from Phalcon\\DI

Check whether the last service obtained via getShared produced a fresh instance or an existing one



public :doc:`Phalcon\\DI\\Service <Phalcon_DI_Service>` [] **getServices** () inherited from Phalcon\\DI

Return the services registered in the DI



public static  **setDefault** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\DI

Set a default dependency injection container to be obtained into static methods



public static :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDefault** () inherited from Phalcon\\DI

Return the lastest DI created



public static  **reset** () inherited from Phalcon\\DI

Resets the internal default DI



public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **attempt** (*string* $name, *mixed* $definition, [*boolean* $shared]) inherited from Phalcon\\DI

Attempts to register a service in the services container Only is successful if a service hasn't been registered previously with the same name



public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **setShared** (*string* $name, *mixed* $definition) inherited from Phalcon\\DI

Registers an "always shared" service in the services container



public  **setRaw** (*unknown* $rawDefinition) inherited from Phalcon\\DI

...


public *boolean*  **offsetExists** (*unknown* $property) inherited from Phalcon\\DI

Check if a service is registered using the array syntax. Alias for Phalcon\\Di::has()



public  **offsetSet** (*unknown* $property, *unknown* $value) inherited from Phalcon\\DI

Allows to register a shared service using the array syntax. Alias for Phalcon\\Di::setShared() 

.. code-block:: php

    <?php

    $di['request'] = new Phalcon\Http\Request();




public *mixed*  **offsetGet** (*unknown* $property) inherited from Phalcon\\DI

Allows to obtain a shared service using the array syntax. Alias for Phalcon\\Di::getShared() 

.. code-block:: php

    <?php

    var_dump($di['request']);




public  **offsetUnset** (*unknown* $property) inherited from Phalcon\\DI

Removes a service from the services container using the array syntax. Alias for Phalcon\\Di::remove()



public *mixed*  **__call** (*string* $method, [*array* $arguments]) inherited from Phalcon\\DI

Magic method to get or set services using setters/getters



public  **__clone** () inherited from Phalcon\\DI

...


