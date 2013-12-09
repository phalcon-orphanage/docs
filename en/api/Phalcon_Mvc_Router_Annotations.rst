Class **Phalcon\\Mvc\\Router\\Annotations**
===========================================

*extends* class :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Mvc\\RouterInterface <Phalcon_Mvc_RouterInterface>`

A router that reads routes annotations from classes/resources  

.. code-block:: php

    <?php

     $di['router'] = function() {
    
    	//Use the annotations router
    	$router = new \Phalcon\Mvc\Router\Annotations(false);
    
    	//This will do the same as above but only if the handled uri starts with /robots
     		$router->addResource('Robots', '/robots');
    
     		return $router;
    };



Constants
---------

*integer* **URI_SOURCE_GET_URL**

*integer* **URI_SOURCE_SERVER_REQUEST_URI**

Methods
---------

public :doc:`Phalcon\\Mvc\\Router\\Annotations <Phalcon_Mvc_Router_Annotations>`  **addResource** (*string* $handler, [*string* $prefix])

Adds a resource to the annotations handler A resource is a class that contains routing annotations



public :doc:`Phalcon\\Mvc\\Router\\Annotations <Phalcon_Mvc_Router_Annotations>`  **addModuleResource** (*string* $module, *string* $handler, [*string* $prefix])

Adds a resource to the annotations handler A resource is a class that contains routing annotations The class is located in a module



public  **handle** ([*string* $uri])

Produce the routing parameters from the rewrite information



public  **processControllerAnnotation** (*string* $handler, *unknown* $annotation)

Checks for annotations in the controller docblock



public  **processActionAnnotation** (*string* $module, *string* $namespace, *string* $controller, *string* $action, :doc:`Phalcon\\Annotations\\Annotation <Phalcon_Annotations_Annotation>` $annotation)

Checks for annotations in the public methods of the controller



public  **setControllerSuffix** (*string* $controllerSuffix)

Changes the controller class suffix



public  **setActionSuffix** (*string* $actionSuffix)

Changes the action method suffix



public *array*  **getResources** ()

Return the registered resources



public  **__construct** ([*boolean* $defaultRoutes]) inherited from Phalcon\\Mvc\\Router

Phalcon\\Mvc\\Router constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\Mvc\\Router

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\Mvc\\Router

Returns the internal dependency injector



public *string*  **getRewriteUri** () inherited from Phalcon\\Mvc\\Router

Get rewrite info. This info is read from $_GET['_url']. This returns '/' if the rewrite information cannot be read



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **setUriSource** (*string* $uriSource) inherited from Phalcon\\Mvc\\Router

Sets the URI source. One of the URI_SOURCE_* constants 

.. code-block:: php

    <?php

    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);




public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **removeExtraSlashes** (*boolean* $remove) inherited from Phalcon\\Mvc\\Router

Set whether router must remove the extra slashes in the handled routes



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **setDefaultNamespace** (*string* $namespaceName) inherited from Phalcon\\Mvc\\Router

Sets the name of the default namespace



public *string*  **getDefaultNamespace** () inherited from Phalcon\\Mvc\\Router

Returns the name of the default namespace



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **setDefaultModule** (*string* $moduleName) inherited from Phalcon\\Mvc\\Router

Sets the name of the default module



public *string*  **getDefaultModule** () inherited from Phalcon\\Mvc\\Router

Returns the name of the default module



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **setDefaultController** (*string* $controllerName) inherited from Phalcon\\Mvc\\Router

Sets the default controller name



public *string*  **getDefaultController** () inherited from Phalcon\\Mvc\\Router

Returns the default controller name



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **setDefaultAction** (*string* $actionName) inherited from Phalcon\\Mvc\\Router

Sets the default action name



public *string*  **getDefaultAction** () inherited from Phalcon\\Mvc\\Router

Returns the default action name



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **setDefaults** (*array* $defaults) inherited from Phalcon\\Mvc\\Router

Sets an array of default paths. If a route is missing a path the router will use the defined here This method must not be used to set a 404 route 

.. code-block:: php

    <?php

     $router->setDefaults(array(
    	'module' => 'common',
    	'action' => 'index'
     ));




public *array*  **getDefaults** () inherited from Phalcon\\Mvc\\Router

Returns an array of default paths



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **add** (*string* $pattern, [*string/array* $paths], [*string* $httpMethods]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router without any HTTP constraint 

.. code-block:: php

    <?php

     $router->add('/about', 'About::index');




public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addGet** (*string* $pattern, [*string/array* $paths]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router that only match if the HTTP method is GET



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addPost** (*string* $pattern, [*string/array* $paths]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router that only match if the HTTP method is POST



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addPut** (*string* $pattern, [*string/array* $paths]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router that only match if the HTTP method is PUT



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addPatch** (*string* $pattern, [*string/array* $paths]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router that only match if the HTTP method is PATCH



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addDelete** (*string* $pattern, [*string/array* $paths]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router that only match if the HTTP method is DELETE



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addOptions** (*string* $pattern, [*string/array* $paths]) inherited from Phalcon\\Mvc\\Router

Add a route to the router that only match if the HTTP method is OPTIONS



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addHead** (*string* $pattern, [*string/array* $paths]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router that only match if the HTTP method is HEAD



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **mount** (*unknown* $group) inherited from Phalcon\\Mvc\\Router

Mounts a group of routes in the router



public :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`  **notFound** (*array* $paths) inherited from Phalcon\\Mvc\\Router

Set a group of paths to be returned when none of the defined routes are matched



public  **clear** () inherited from Phalcon\\Mvc\\Router

Removes all the pre-defined routes



public *string*  **getNamespaceName** () inherited from Phalcon\\Mvc\\Router

Returns the processed namespace name



public *string*  **getModuleName** () inherited from Phalcon\\Mvc\\Router

Returns the processed module name



public *string*  **getControllerName** () inherited from Phalcon\\Mvc\\Router

Returns the processed controller name



public *string*  **getActionName** () inherited from Phalcon\\Mvc\\Router

Returns the processed action name



public *array*  **getParams** () inherited from Phalcon\\Mvc\\Router

Returns the processed parameters



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **getMatchedRoute** () inherited from Phalcon\\Mvc\\Router

Returns the route that matchs the handled URI



public *array*  **getMatches** () inherited from Phalcon\\Mvc\\Router

Returns the sub expressions in the regular expression matched



public *bool*  **wasMatched** () inherited from Phalcon\\Mvc\\Router

Checks if the router macthes any of the defined routes



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>` [] **getRoutes** () inherited from Phalcon\\Mvc\\Router

Returns all the routes defined in the router



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **getRouteById** (*string* $id) inherited from Phalcon\\Mvc\\Router

Returns a route object by its id



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **getRouteByName** (*string* $name) inherited from Phalcon\\Mvc\\Router

Returns a route object by its name



