Class **Phalcon\\Mvc\\Router**
==============================

Phalcon\\Mvc\\Router is the standard framework router. Routing is the process of taking a URI endpoint (that part of the URI which comes after the base URL) and decomposing it into parameters to determine which module, controller, and action of that controller should receive the request   

.. code-block:: php

    <?php

    $router = new Phalcon\Mvc\Router();
    $router->handle();
    echo $router->getControllerName();

Settings baseUri first: 

.. code-block:: php

    <?php

    $router = new Phalcon\Mvc\Router();
    $router->handle();
    echo $router->getControllerName();

</example>


Methods
---------

public **__construct** (*unknown* $defaultRoutes)

public **setDI** (*Phalcon\DI* $dependencyInjector)

Sets the dependency injector



:doc:`Phalcon\\DI <../api/Phalcon_DI>` public **getDI** ()

Returns the internal dependency injector



*string* protected **_getRewriteUri** ()

Get rewrite info



public **setDefaultModule** (*unknown* $moduleName)

public **setDefaultController** (*unknown* $controllerName)

public **setDefaultAction** (*unknown* $actionName)

public **setDefaults** (*unknown* $defaults)

public **handle** (*string* $uri)

Handles routing information received from the rewrite engine



:doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>` public **add** (*string* $pattern, *string/array* $paths, *string* $httpMethods)

Add a route to the router on any HTTP method



:doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>` public **addGet** (*string* $pattern, *string/array* $paths)

Add a route to the router that only match if the HTTP method is GET



:doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>` public **addPost** (*string* $pattern, *string/array* $paths)

Add a route to the router that only match if the HTTP method is POST



:doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>` public **addPut** (*string* $pattern, *string/array* $paths)

Add a route to the router that only match if the HTTP method is PUT



:doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>` public **addDelete** (*string* $pattern, *string/array* $paths)

Add a route to the router that only match if the HTTP method is DELETE



:doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>` public **addOptions** (*string* $pattern, *string/array* $paths)

Add a route to the router that only match if the HTTP method is OPTIONS



:doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>` public **addHead** (*string* $pattern, *string/array* $paths)

Add a route to the router that only match if the HTTP method is HEAD



public **clear** ()

Removes all the pre-defined routes



*string* public **getModuleName** ()

Returns proccesed module name



*string* public **getControllerName** ()

Returns proccesed controller name



*string* public **getActionName** ()

Returns proccesed action name



*array* public **getParams** ()

Returns proccesed extra params



:doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>` public **getMatchedRoute** ()

Returns the route that matchs the handled URI



*array* public **getMatches** ()

Return the sub expressions in the regular expression matched



*bool* public **wasMatched** ()

Check if the router macthes any of the defined routes



:doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>` public **getRoutes** ()





public **getRouteById** (*unknown* $id)

public **getRouteByName** (*unknown* $name)

