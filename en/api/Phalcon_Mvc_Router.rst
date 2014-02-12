Class **Phalcon\\Mvc\\Router**
==============================

*implements* :doc:`Phalcon\\Mvc\\RouterInterface <Phalcon_Mvc_RouterInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Phalcon\\Mvc\\Router is the standard framework router. Routing is the process of taking a URI endpoint (that part of the URI which comes after the base URL) and decomposing it into parameters to determine which module, controller, and action of that controller should receive the request    

.. code-block:: php

    <?php

    $router = new Phalcon\Mvc\Router();
    
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

public  **__construct** ([*boolean* $defaultRoutes])

Phalcon\\Mvc\\Router constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public *string*  **getRewriteUri** ()

Get rewrite info. This info is read from $_GET['_url']. This returns '/' if the rewrite information cannot be read



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **setUriSource** (*int* $uriSource)

Sets the URI source. One of the URI_SOURCE_* constants 

.. code-block:: php

    <?php

    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);




public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **removeExtraSlashes** (*boolean* $remove)

Set whether router must remove the extra slashes in the handled routes



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **setDefaultNamespace** (*string* $namespaceName)

Sets the name of the default namespace



public *string*  **getDefaultNamespace** ()

Returns the name of the default namespace



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **setDefaultModule** (*string* $moduleName)

Sets the name of the default module



public *string*  **getDefaultModule** ()

Returns the name of the default module



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **setDefaultController** (*string* $controllerName)

Sets the default controller name



public *string*  **getDefaultController** ()

Returns the default controller name



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **setDefaultAction** (*string* $actionName)

Sets the default action name



public *string*  **getDefaultAction** ()

Returns the default action name



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **setDefaults** (*array* $defaults)

Sets an array of default paths. If a route is missing a path the router will use the defined here This method must not be used to set a 404 route 

.. code-block:: php

    <?php

     $router->setDefaults(array(
    	'module' => 'common',
    	'action' => 'index'
     ));




public *array*  **getDefaults** ()

Returns an array of default parameters



public  **handle** ([*string* $uri])

Handles routing information received from the rewrite engine 

.. code-block:: php

    <?php

     //Read the info from the rewrite engine
     $router->handle();
    
     //Manually passing an URL
     $router->handle('/posts/edit/1');




public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **add** (*string* $pattern, [*string/array* $paths], [*string* $httpMethods])

Adds a route to the router without any HTTP constraint 

.. code-block:: php

    <?php

     $router->add('/about', 'About::index');




public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addGet** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is GET



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addPost** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is POST



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addPut** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is PUT



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addPatch** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is PATCH



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addDelete** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is DELETE



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addOptions** (*string* $pattern, [*string/array* $paths])

Add a route to the router that only match if the HTTP method is OPTIONS



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addHead** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is HEAD



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **mount** (*unknown* $group)

Mounts a group of routes in the router



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **notFound** (*array|string* $paths)

Set a group of paths to be returned when none of the defined routes are matched



public  **clear** ()

Removes all the pre-defined routes



public *string*  **getNamespaceName** ()

Returns the processed namespace name



public *string*  **getModuleName** ()

Returns the processed module name



public *string*  **getControllerName** ()

Returns the processed controller name



public *string*  **getActionName** ()

Returns the processed action name



public *array*  **getParams** ()

Returns the processed parameters



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **getMatchedRoute** ()

Returns the route that matchs the handled URI



public *array*  **getMatches** ()

Returns the sub expressions in the regular expression matched



public *bool*  **wasMatched** ()

Checks if the router macthes any of the defined routes



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>` [] **getRoutes** ()

Returns all the routes defined in the router



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  | false **getRouteById** (*string* $id)

Returns a route object by its id



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **getRouteByName** (*string* $name)

Returns a route object by its name



