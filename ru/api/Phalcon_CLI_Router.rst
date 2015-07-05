Class **Phalcon\\Cli\\Router**
==============================

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

Phalcon\\Cli\\Router is the standard framework router. Routing is the process of taking a command-line arguments and decomposing it into parameters to determine which module, task, and action of that task should receive the request    

.. code-block:: php

    <?php

    $router = new \Phalcon\Cli\Router();
    $router->handle(array(
    	'module' => 'main',
    	'task' => 'videos',
    	'action' => 'process'
    ));
    echo $router->getTaskName();



Methods
-------

public  **__construct** ([*unknown* $defaultRoutes])

Phalcon\\Cli\\Router constructor



public  **setDI** (*unknown* $dependencyInjector)

Sets the dependency injector



public  **getDI** ()

Returns the internal dependency injector



public  **setDefaultModule** (*unknown* $moduleName)

Sets the name of the default module



public  **setDefaultTask** (*unknown* $taskName)

Sets the default controller name



public  **setDefaultAction** (*unknown* $actionName)

Sets the default action name



public  **setDefaults** (*unknown* $defaults)

Sets an array of default paths. If a route is missing a path the router will use the defined here This method must not be used to set a 404 route 

.. code-block:: php

    <?php

     $router->setDefaults(array(
    	'module' => 'common',
    	'action' => 'index'
     ));




public  **handle** ([*unknown* $arguments])

Handles routing information received from command-line arguments



public :doc:`Phalcon\\Cli\\Router\\Route <Phalcon_Cli_Router_Route>`  **add** (*unknown* $pattern, [*unknown* $paths])

Adds a route to the router 

.. code-block:: php

    <?php

     $router->add('/about', 'About::main');




public  **getModuleName** ()

Returns proccesed module name



public  **getTaskName** ()

Returns proccesed task name



public  **getActionName** ()

Returns proccesed action name



public *array*  **getParams** ()

Returns proccesed extra params



public  **getMatchedRoute** ()

Returns the route that matchs the handled URI



public *array*  **getMatches** ()

Returns the sub expressions in the regular expression matched



public  **wasMatched** ()

Checks if the router macthes any of the defined routes



public  **getRoutes** ()

Returns all the routes defined in the router



public :doc:`Phalcon\\Cli\\Router\\Route <Phalcon_Cli_Router_Route>`  **getRouteById** (*unknown* $id)

Returns a route object by its id



public  **getRouteByName** (*unknown* $name)

Returns a route object by its name



