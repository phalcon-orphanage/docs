Class **Phalcon\\Mvc\\Router**
==============================

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Mvc\\RouterInterface <Phalcon_Mvc_RouterInterface>`

Phalcon\\Mvc\\Router is the standard framework router. Routing is the process of taking a URI endpoint (that part of the URI which comes after the base URL) and decomposing it into parameters to determine which module, controller, and action of that controller should receive the request    

.. code-block:: php

    <?php

    $router = new Router();
    
    $router->add(
    	"/documentation/{chapter}/{name}.{type:[a-z]+}",
    	array(
    		"controller" => "documentation",
    		"action"     => "show"
    	)
    );
    
    $router->handle();
    
    echo $router->getControllerName();



Constants
---------

*integer* **URI_SOURCE_GET_URL**

*integer* **URI_SOURCE_SERVER_REQUEST_URI**

Methods
-------

public  **__construct** ([*unknown* $defaultRoutes])

Phalcon\\Mvc\\Router constructor



public  **setDI** (*unknown* $dependencyInjector)

Sets the dependency injector



public  **getDI** ()

Returns the internal dependency injector



public  **getRewriteUri** ()

Get rewrite info. This info is read from $_GET['_url']. This returns '/' if the rewrite information cannot be read



public  **setUriSource** (*unknown* $uriSource)

Sets the URI source. One of the URI_SOURCE_* constants 

.. code-block:: php

    <?php

    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);




public  **removeExtraSlashes** (*unknown* $remove)

Set whether router must remove the extra slashes in the handled routes



public  **setDefaultNamespace** (*unknown* $namespaceName)

Sets the name of the default namespace



public  **setDefaultModule** (*unknown* $moduleName)

Sets the name of the default module



public  **setDefaultController** (*unknown* $controllerName)

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




public  **handle** ([*unknown* $uri])

Handles routing information received from the rewrite engine 

.. code-block:: php

    <?php

     //Read the info from the rewrite engine
     $router->handle();
    
     //Manually passing an URL
     $router->handle('/posts/edit/1');




public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **add** (*unknown* $pattern, [*unknown* $paths], [*unknown* $httpMethods])

Adds a route to the router without any HTTP constraint 

.. code-block:: php

    <?php

     $router->add('/about', 'About::index');




public  **addGet** (*unknown* $pattern, [*unknown* $paths])

Adds a route to the router that only match if the HTTP method is GET



public  **addPost** (*unknown* $pattern, [*unknown* $paths])

Adds a route to the router that only match if the HTTP method is POST



public  **addPut** (*unknown* $pattern, [*unknown* $paths])

Adds a route to the router that only match if the HTTP method is PUT



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addPatch** (*unknown* $pattern, [*unknown* $paths])

Adds a route to the router that only match if the HTTP method is PATCH



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addDelete** (*unknown* $pattern, [*unknown* $paths])

Adds a route to the router that only match if the HTTP method is DELETE



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addOptions** (*unknown* $pattern, [*unknown* $paths])

Add a route to the router that only match if the HTTP method is OPTIONS



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addHead** (*unknown* $pattern, [*unknown* $paths])

Adds a route to the router that only match if the HTTP method is HEAD



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **mount** (*unknown* $group)

Mounts a group of routes in the router



public  **notFound** (*unknown* $paths)

Set a group of paths to be returned when none of the defined routes are matched



public  **clear** ()

Removes all the pre-defined routes



public  **getNamespaceName** ()

Returns the processed namespace name



public  **getModuleName** ()

Returns the processed module name



public  **getControllerName** ()

Returns the processed controller name



public  **getActionName** ()

Returns the processed action name



public  **getParams** ()

Returns the processed parameters



public  **getMatchedRoute** ()

Returns the route that matchs the handled URI



public  **getMatches** ()

Returns the sub expressions in the regular expression matched



public  **wasMatched** ()

Checks if the router macthes any of the defined routes



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>` [] **getRoutes** ()

Returns all the routes defined in the router



public  **getRouteById** (*unknown* $id)

Returns a route object by its id



public  **getRouteByName** (*unknown* $name)

Returns a route object by its name



public  **isExactControllerName** ()

Returns whether controller name should not be mangled



