Class **Phalcon\\Di**
=====================

*implements* :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`, ArrayAccess

Phalcon\\Di is a component that implements Dependency Injection/Service Location of services and it"s itself a container for them.  Since Phalcon is highly decoupled, Phalcon\\Di is essential to integrate the different components of the framework. The developer can also use this component to inject dependencies and manage global instances of the different classes used in the application.  Basically, this component implements the `Inversion of Control` pattern. Applying this, the objects do not receive their dependencies using setters or constructors, but requesting a service dependency injector. This reduces the overall complexity, since there is only one way to get the required dependencies within a component.  Additionally, this pattern increases testability in the code, thus making it less prone to errors.  

.. code-block:: php

    <?php

     $di = new \Phalcon\Di();
    
     //Using a string definition
     $di->set("request", "Phalcon\Http\Request", true);
    
     //Using an anonymous function
     $di->set("request", function(){
      return new \Phalcon\Http\Request();
     }, true);
    
     $request = $di->getRequest();



Methods
-------

public  **__construct** ()

Phalcon\\Di constructor



public  **setInternalEventsManager** (*unknown* $eventsManager)

Sets the internal event manager



public  **getInternalEventsManager** ()

Returns the internal event manager



public  **set** (*unknown* $name, *unknown* $definition, [*unknown* $shared])

Registers a service in the services container



public  **setShared** (*unknown* $name, *unknown* $definition)

Registers an "always shared" service in the services container



public  **remove** (*unknown* $name)

Removes a service in the services container



public  **attempt** (*unknown* $name, *unknown* $definition, [*unknown* $shared])

Attempts to register a service in the services container Only is successful if a service hasn"t been registered previously with the same name



public  **setRaw** (*unknown* $name, *unknown* $rawDefinition)

Sets a service using a raw Phalcon\\Di\\Service definition



public  **getRaw** (*unknown* $name)

Returns a service definition without resolving



public  **getService** (*unknown* $name)

Returns a Phalcon\\Di\\Service instance



public  **get** (*unknown* $name, [*unknown* $parameters])

Resolves the service based on its configuration



public *mixed*  **getShared** (*unknown* $name, [*unknown* $parameters])

Resolves a service, the resolved service is stored in the DI, subsequent requests for this service will return the same instance



public  **has** (*unknown* $name)

Check whether the DI contains a service by a name



public  **wasFreshInstance** ()

Check whether the last service obtained via getShared produced a fresh instance or an existing one



public  **getServices** ()

Return the services registered in the DI



public  **offsetExists** (*unknown* $name)

Check if a service is registered using the array syntax



public *boolean*  **offsetSet** (*unknown* $name, *unknown* $definition)

Allows to register a shared service using the array syntax 

.. code-block:: php

    <?php

    $di["request"] = new \Phalcon\Http\Request();




public *mixed*  **offsetGet** (*unknown* $name)

Allows to obtain a shared service using the array syntax 

.. code-block:: php

    <?php

    var_dump($di["request"]);




public  **offsetUnset** (*unknown* $name)

Removes a service from the services container using the array syntax



public *mixed*  **__call** (*unknown* $method, [*unknown* $arguments])

Magic method to get or set services using setters/getters



public static  **setDefault** (*unknown* $dependencyInjector)

Set a default dependency injection container to be obtained into static methods



public static  **getDefault** ()

Return the lastest DI created



public static  **reset** ()

Resets the internal default DI



