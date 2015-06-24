Class **Phalcon\\Di\\Service**
==============================

*implements* :doc:`Phalcon\\Di\\ServiceInterface <Phalcon_Di_ServiceInterface>`

Represents individually a service in the services container  

.. code-block:: php

    <?php

     $service = new \Phalcon\Di\Service('request', 'Phalcon\Http\Request');
     $request = service->resolve();

.. code-block:: php

    <?php



Methods
-------

final public  **__construct** (*unknown* $name, *unknown* $definition, [*unknown* $shared])





public  **getName** ()

Returns the service's name



public  **setShared** (*unknown* $shared)

Sets if the service is shared or not



public *boolean*  **isShared** ()

Check whether the service is shared or not



public  **setSharedInstance** (*unknown* $sharedInstance)

Sets/Resets the shared instance related to the service



public  **setDefinition** (*unknown* $definition)

Set the service definition



public *mixed*  **getDefinition** ()

Returns the service definition



public *mixed*  **resolve** ([*unknown* $parameters], [*unknown* $dependencyInjector])

Resolves the service



public :doc:`Phalcon\\Di\\Service <Phalcon_Di_Service>`  **setParameter** (*unknown* $position, *unknown* $parameter)

Changes a parameter in the definition without resolve the service



public *array*  **getParameter** (*unknown* $position)

Returns a parameter in a specific position



public *bool*  **isResolved** ()

Returns true if the service was resolved



public static :doc:`Phalcon\\Di\\Service <Phalcon_Di_Service>`  **__set_state** (*unknown* $attributes)

Restore the internal state of a service



