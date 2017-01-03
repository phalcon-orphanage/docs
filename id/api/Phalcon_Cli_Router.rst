Class **Phalcon\\Cli\\Router**
==============================

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cli/router.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

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

public  **__construct** ([*mixed* $defaultRoutes])

Phalcon\\Cli\\Router constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector



public  **getDI** ()

Returns the internal dependency injector



public  **setDefaultModule** (*mixed* $moduleName)

Sets the name of the default module



public  **setDefaultTask** (*mixed* $taskName)

Sets the default controller name



public  **setDefaultAction** (*mixed* $actionName)

Sets the default action name



public  **setDefaults** (*array* $defaults)

Sets an array of default paths. If a route is missing a path the router will use the defined here This method must not be used to set a 404 route 

.. code-block:: php

    <?php

     $router->setDefaults(array(
    	'module' => 'common',
    	'action' => 'index'
     ));




public  **handle** ([*array* $arguments])

Handles routing information received from command-line arguments



public :doc:`Phalcon\\Cli\\Router\\Route <Phalcon_Cli_Router_Route>` **add** (*string* $pattern, [*string/array* $paths])

Adds a route to the router 

.. code-block:: php

    <?php

     $router->add('/about', 'About::main');




public  **getModuleName** ()

Returns proccesed module name



public  **getTaskName** ()

Returns proccesed task name



public  **getActionName** ()

Returns processed action name



public *array* **getParams** ()

Returns processed extra params



public  **getMatchedRoute** ()

Returns the route that matches the handled URI



public *array* **getMatches** ()

Returns the sub expressions in the regular expression matched



public  **wasMatched** ()

Checks if the router matches any of the defined routes



public  **getRoutes** ()

Returns all the routes defined in the router



public :doc:`Phalcon\\Cli\\Router\\Route <Phalcon_Cli_Router_Route>` **getRouteById** (*int* $id)

Returns a route object by its id



public  **getRouteByName** (*mixed* $name)

Returns a route object by its name



