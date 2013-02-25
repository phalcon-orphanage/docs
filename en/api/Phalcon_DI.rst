Class **Phalcon\\DI**
=====================

*implements* :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`

Phalcon\\DI is a component that implements Dependency Injection of services and it's itself a container for them.  Since Phalcon is highly decoupled, Phalcon\\DI is essential to integrate the different components of the framework. The developer can also use this component to inject dependencies and manage global instances of the different classes used in the application.  Basically, this component implements the `Inversion of Control` pattern. Applying this, the objects do not receive their dependencies using setters or constructors, but requesting a service dependency injector. This reduces the overall complexity, since there is only one way to get the required dependencies within a component.  Additionally, this pattern increases testability in the code, thus making it less prone to errors.  

.. code-block:: php

    <?php

     $di = new Phalcon\DI();
    
     //Using a string definition
     $di->set('request', 'Phalcon\Http\Request', true);
    
     //Using an anonymous function
     $di->set('request', function(){
      return new Phalcon\Http\Request();
     }, true);
    
     $request = $di->getRequest();



Methods
---------

public  **__construct** ()

Phalcon\\DI constructor



public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **set** (*string* $name, *mixed* $definition, [*boolean* $shared])

Registers a service in the services container



public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **setShared** (*string* $name, *mixed* $definition)

Registers an "always shared" service in the services container



public  **remove** (*string* $name)

Removes a service in the services container



public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **attempt** (*string* $name, *mixed* $definition, [*boolean* $shared])

Attempts to register a service in the services container Only is successful if a service hasn't been registered previously with the same name



public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **setRaw** (*string* $name, *Phalcon\\DI\\ServiceInterface* $rawDefinition)

Sets a service using a raw Phalcon\\DI\\Service definition



public *mixed*  **getRaw** (*string* $name)

Returns a service definition without resolving



public :doc:`Phalcon\\DI\\ServiceInterface <Phalcon_DI_ServiceInterface>`  **getService** (*string* $name)

Returns a Phalcon\\DI\\Service instance



public *mixed*  **get** (*string* $name, [*array* $parameters])

Resolves the service based on its configuration



public *mixed*  **getShared** (*string* $name, [*array* $parameters])

Resolves a service, the resolved service is stored in the DI, subsequent requests for this service will return the same instance



public *boolean*  **has** (*string* $name)

Check whether the DI contains a service by a name



public *boolean*  **wasFreshInstance** ()

Check whether the last service obtained via getShared produced a fresh instance or an existing one



public :doc:`Phalcon\\DI\\Service <Phalcon_DI_Service>` [] **getServices** ()

Return the services registered in the DI



public *boolean*  **offsetExists** (*string* $alias)

Check if a service is registered using the array syntax



public  **offsetSet** (*string* $alias, *mixed* $definition)

Allows to register a shared service using the array syntax 

.. code-block:: php

    <?php

    $di['request'] = new Phalcon\Http\Request();




public *mixed*  **offsetGet** (*string* $alias)

Allows to obtain a shared service using the array syntax 

.. code-block:: php

    <?php

    var_dump($di['request']);




public  **offsetUnset** (*string* $alias)

Removes a service from the services container using the array syntax



public *mixed*  **__call** (*string* $method, [*array* $arguments])

Magic method to get or set services using setters/getters



public static  **setDefault** (*Phalcon\\DiInterface* $dependencyInjector)

Set a default dependency injection container to be obtained into static methods



public static :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDefault** ()

Return the lastest DI created



public static  **reset** ()

Resets the internal default DI



