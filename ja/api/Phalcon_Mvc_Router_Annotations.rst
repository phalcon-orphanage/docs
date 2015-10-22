Class **Phalcon\\Mvc\\Router\\Annotations**
===========================================

*extends* class :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Mvc\\RouterInterface <Phalcon_Mvc_RouterInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/router/annotations.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

A router that reads routes annotations from classes/resources  

.. code-block:: php

    <?php

     $di['router'] = function() {
    
    	//Use the annotations router
    	$router = new Annotations(false);
    
    	//This will do the same as above but only if the handled uri starts with /robots
     		$router->addResource('Robots', '/robots');
    
     		return $router;
    };



Constants
---------

*integer* **URI_SOURCE_GET_URL**

*integer* **URI_SOURCE_SERVER_REQUEST_URI**

*integer* **POSITION_FIRST**

*integer* **POSITION_LAST**

Methods
-------

public  **addResource** (*unknown* $handler, [*unknown* $prefix])

Adds a resource to the annotations handler A resource is a class that contains routing annotations



public  **addModuleResource** (*unknown* $module, *unknown* $handler, [*unknown* $prefix])

Adds a resource to the annotations handler A resource is a class that contains routing annotations The class is located in a module



public  **handle** ([*unknown* $uri])

Produce the routing parameters from the rewrite information



public  **processControllerAnnotation** (*unknown* $handler, *unknown* $annotation)

Checks for annotations in the controller docblock



public  **processActionAnnotation** (*string* $module, *string* $namespaceName, *string* $controller, *string* $action, :doc:`Phalcon\\Annotations\\Annotation <Phalcon_Annotations_Annotation>` $annotation)

Checks for annotations in the public methods of the controller



public  **setControllerSuffix** (*unknown* $controllerSuffix)

Changes the controller class suffix



public  **setActionSuffix** (*unknown* $actionSuffix)

Changes the action method suffix



public *array*  **getResources** ()

Return the registered resources



public  **__construct** ([*unknown* $defaultRoutes]) inherited from Phalcon\\Mvc\\Router

Phalcon\\Mvc\\Router constructor



public  **setDI** (*unknown* $dependencyInjector) inherited from Phalcon\\Mvc\\Router

Sets the dependency injector



public  **getDI** () inherited from Phalcon\\Mvc\\Router

Returns the internal dependency injector



public  **setEventsManager** (*unknown* $eventsManager) inherited from Phalcon\\Mvc\\Router

Sets the events manager



public  **getEventsManager** () inherited from Phalcon\\Mvc\\Router

Returns the internal event manager



public  **getRewriteUri** () inherited from Phalcon\\Mvc\\Router

Get rewrite info. This info is read from $_GET['_url']. This returns '/' if the rewrite information cannot be read



public  **setUriSource** (*unknown* $uriSource) inherited from Phalcon\\Mvc\\Router

Sets the URI source. One of the URI_SOURCE_* constants 

.. code-block:: php

    <?php

    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);




public  **removeExtraSlashes** (*unknown* $remove) inherited from Phalcon\\Mvc\\Router

Set whether router must remove the extra slashes in the handled routes



public  **setDefaultNamespace** (*unknown* $namespaceName) inherited from Phalcon\\Mvc\\Router

Sets the name of the default namespace



public  **setDefaultModule** (*unknown* $moduleName) inherited from Phalcon\\Mvc\\Router

Sets the name of the default module



public  **setDefaultController** (*unknown* $controllerName) inherited from Phalcon\\Mvc\\Router

Sets the default controller name



public  **setDefaultAction** (*unknown* $actionName) inherited from Phalcon\\Mvc\\Router

Sets the default action name



public  **setDefaults** (*unknown* $defaults) inherited from Phalcon\\Mvc\\Router

Sets an array of default paths. If a route is missing a path the router will use the defined here This method must not be used to set a 404 route 

.. code-block:: php

    <?php

     $router->setDefaults(array(
    	'module' => 'common',
    	'action' => 'index'
     ));




public  **getDefaults** () inherited from Phalcon\\Mvc\\Router

Returns an array of default parameters



public  **add** (*unknown* $pattern, [*unknown* $paths], [*unknown* $httpMethods], [*unknown* $position]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router without any HTTP constraint 

.. code-block:: php

    <?php

     use Phalcon\Mvc\Router;
    
     $router->add('/about', 'About::index');
     $router->add('/about', 'About::index', ['GET', 'POST']);
     $router->add('/about', 'About::index', ['GET', 'POST'], Router::POSITION_FIRST);




public  **addGet** (*unknown* $pattern, [*unknown* $paths], [*unknown* $position]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router that only match if the HTTP method is GET



public  **addPost** (*unknown* $pattern, [*unknown* $paths], [*unknown* $position]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router that only match if the HTTP method is POST



public  **addPut** (*unknown* $pattern, [*unknown* $paths], [*unknown* $position]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router that only match if the HTTP method is PUT



public  **addPatch** (*unknown* $pattern, [*unknown* $paths], [*unknown* $position]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router that only match if the HTTP method is PATCH



public  **addDelete** (*unknown* $pattern, [*unknown* $paths], [*unknown* $position]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router that only match if the HTTP method is DELETE



public  **addOptions** (*unknown* $pattern, [*unknown* $paths], [*unknown* $position]) inherited from Phalcon\\Mvc\\Router

Add a route to the router that only match if the HTTP method is OPTIONS



public  **addHead** (*unknown* $pattern, [*unknown* $paths], [*unknown* $position]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router that only match if the HTTP method is HEAD



public  **mount** (*unknown* $group) inherited from Phalcon\\Mvc\\Router

Mounts a group of routes in the router



public  **notFound** (*unknown* $paths) inherited from Phalcon\\Mvc\\Router

Set a group of paths to be returned when none of the defined routes are matched



public  **clear** () inherited from Phalcon\\Mvc\\Router

Removes all the pre-defined routes



public  **getNamespaceName** () inherited from Phalcon\\Mvc\\Router

Returns the processed namespace name



public  **getModuleName** () inherited from Phalcon\\Mvc\\Router

Returns the processed module name



public  **getControllerName** () inherited from Phalcon\\Mvc\\Router

Returns the processed controller name



public  **getActionName** () inherited from Phalcon\\Mvc\\Router

Returns the processed action name



public  **getParams** () inherited from Phalcon\\Mvc\\Router

Returns the processed parameters



public  **getMatchedRoute** () inherited from Phalcon\\Mvc\\Router

Returns the route that matchs the handled URI



public  **getMatches** () inherited from Phalcon\\Mvc\\Router

Returns the sub expressions in the regular expression matched



public  **wasMatched** () inherited from Phalcon\\Mvc\\Router

Checks if the router macthes any of the defined routes



public  **getRoutes** () inherited from Phalcon\\Mvc\\Router

Returns all the routes defined in the router



public  **getRouteById** (*unknown* $id) inherited from Phalcon\\Mvc\\Router

Returns a route object by its id



public  **getRouteByName** (*unknown* $name) inherited from Phalcon\\Mvc\\Router

Returns a route object by its name



public  **isExactControllerName** () inherited from Phalcon\\Mvc\\Router

Returns whether controller name should not be mangled



