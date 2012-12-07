Class **Phalcon\\Mvc\\Router**
==============================

<<<<<<< HEAD
Phalcon\\Mvc\\Router is the standard framework router. Routing is the process of taking a URI endpoint (that part of the URI which comes after the base URL) and decomposing it into parameters to determine which module, controller, and action of that controller should receive the request   
=======
*implements* :doc:`Phalcon\\Mvc\\RouterInterface <Phalcon_Mvc_RouterInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Phalcon\\Mvc\\Router is the standard framework router. Routing is the process of taking a URI endpoint (that part of the URI which comes after the base URL) and decomposing it into parameters to determine which module, controller, and action of that controller should receive the request    
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    $router = new Phalcon\Mvc\Router();
    $router->handle();
    echo $router->getControllerName();



Methods
---------

public  **__construct** (*boolean* $defaultRoutes)

Phalcon\\Mvc\\Router constructor



<<<<<<< HEAD
public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)
=======
public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)
>>>>>>> 0.7.0

Sets the dependency injector



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()
=======
public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()
>>>>>>> 0.7.0

Returns the internal dependency injector



protected *string*  **_getRewriteUri** ()

Get rewrite info



<<<<<<< HEAD
=======
public  **setDefaultNamespace** (*string* $namespaceName)

Sets the name of the default namespace



>>>>>>> 0.7.0
public  **setDefaultModule** (*string* $moduleName)

Sets the name of the default module



public  **setDefaultController** (*string* $controllerName)

Sets the default controller name



public  **setDefaultAction** (*string* $actionName)

Sets the default action name



public  **setDefaults** (*array* $defaults)

Sets an array of default paths



public  **handle** (*string* $uri)

Handles routing information received from the rewrite engine



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **add** (*string* $pattern, *string/array* $paths, *string* $httpMethods)

<<<<<<< HEAD
Add a route to the router on any HTTP method
=======
Adds a route to the router on any HTTP method
>>>>>>> 0.7.0



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addGet** (*string* $pattern, *string/array* $paths)

<<<<<<< HEAD
Add a route to the router that only match if the HTTP method is GET
=======
Adds a route to the router that only match if the HTTP method is GET
>>>>>>> 0.7.0



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addPost** (*string* $pattern, *string/array* $paths)

<<<<<<< HEAD
Add a route to the router that only match if the HTTP method is POST
=======
Adds a route to the router that only match if the HTTP method is POST
>>>>>>> 0.7.0



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addPut** (*string* $pattern, *string/array* $paths)

<<<<<<< HEAD
Add a route to the router that only match if the HTTP method is PUT
=======
Adds a route to the router that only match if the HTTP method is PUT
>>>>>>> 0.7.0



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addDelete** (*string* $pattern, *string/array* $paths)

<<<<<<< HEAD
Add a route to the router that only match if the HTTP method is DELETE
=======
Adds a route to the router that only match if the HTTP method is DELETE
>>>>>>> 0.7.0



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addOptions** (*string* $pattern, *string/array* $paths)

Add a route to the router that only match if the HTTP method is OPTIONS



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addHead** (*string* $pattern, *string/array* $paths)

<<<<<<< HEAD
Add a route to the router that only match if the HTTP method is HEAD
=======
Adds a route to the router that only match if the HTTP method is HEAD
>>>>>>> 0.7.0



public  **clear** ()

Removes all the pre-defined routes



<<<<<<< HEAD
public *string*  **getModuleName** ()

Returns proccesed module name
=======
public *string*  **getNamespaceName** ()

Returns processed namespace name



public *string*  **getModuleName** ()

Returns processed module name
>>>>>>> 0.7.0



public *string*  **getControllerName** ()

<<<<<<< HEAD
Returns proccesed controller name
=======
Returns processed controller name
>>>>>>> 0.7.0



public *string*  **getActionName** ()

<<<<<<< HEAD
Returns proccesed action name
=======
Returns processed action name
>>>>>>> 0.7.0



public *array*  **getParams** ()

<<<<<<< HEAD
Returns proccesed extra params
=======
Returns processed extra params
>>>>>>> 0.7.0



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **getMatchedRoute** ()

Returns the route that matchs the handled URI



public *array*  **getMatches** ()

Return the sub expressions in the regular expression matched



public *bool*  **wasMatched** ()

Check if the router macthes any of the defined routes



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>` [] **getRoutes** ()

Return all the routes defined in the router



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **getRouteById** (*unknown* $id)

Returns a route object by its id



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **getRouteByName** (*unknown* $name)

Returns a route object by its name



