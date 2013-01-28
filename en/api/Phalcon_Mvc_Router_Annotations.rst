Class **Phalcon\\Mvc\\Router\\Annotations**
===========================================

*extends* :doc:`Phalcon\\Mvc\\Router <Phalcon_Mvc_Router>`

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Mvc\\RouterInterface <Phalcon_Mvc_RouterInterface>`

A router that reads routes annotations from classes/resources  

.. code-block:: php

    <?php

     $di->set('router', function() {
    
    	//Use the annotations router
    	$router = new \Phalcon\Mvc\Router\Annotations();
    
    	//This will do the same as above but only if the handled uri starts with /robots
     		$router->addResource('Robots', '/robots');
    
     		return $router;
    });



Methods
---------

public :doc:`Phalcon\\Mvc\\Router\\Annotations <Phalcon_Mvc_Router_Annotations>`  **addResource** (*string* $handler, [*string* $prefix])

Adds a resource to the annotations handler A resource is a class that contains routing annotations



public  **handle** ([*string* $uri])

Produce the routing parameters from the rewrite information



public  **processControllerAnnotation** (*string* $handler, *unknown* $annotation)

Checks for annotations in the controller docblock



public  **processActionAnnotation** (*unknown* $controller, *unknown* $action, *unknown* $annotation)





public  **__construct** ([*boolean* $defaultRoutes]) inherited from Phalcon\\Mvc\\Router

Phalcon\\Mvc\\Router constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\Mvc\\Router

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\Mvc\\Router

Returns the internal dependency injector



protected *string*  **_getRewriteUri** () inherited from Phalcon\\Mvc\\Router

Get rewrite info. This info is read from $_GET['_url']. This returns '/' if the rewrite information cannot be read



public  **removeExtraSlashes** (*boolean* $remove) inherited from Phalcon\\Mvc\\Router

Set whether router must remove the extra slashes in the handled routes



public  **setDefaultNamespace** (*string* $namespaceName) inherited from Phalcon\\Mvc\\Router

Sets the name of the default namespace



public  **setDefaultModule** (*string* $moduleName) inherited from Phalcon\\Mvc\\Router

Sets the name of the default module



public  **setDefaultController** (*string* $controllerName) inherited from Phalcon\\Mvc\\Router

Sets the default controller name



public  **setDefaultAction** (*string* $actionName) inherited from Phalcon\\Mvc\\Router

Sets the default action name



public  **setDefaults** (*array* $defaults) inherited from Phalcon\\Mvc\\Router

Sets an array of default paths. This defaults apply for all the routes 

.. code-block:: php

    <?php

     $router->setDefaults(array(
    	'module' => 'common',
    	'action' => 'index'
     ));




public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **add** (*string* $pattern, [*string/array* $paths], [*string* $httpMethods]) inherited from Phalcon\\Mvc\\Router

Adds a route to the router on any HTTP method 

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



public  **mount** (*unknown* $group) inherited from Phalcon\\Mvc\\Router

Mounts a group of routes in the router



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



