Interface **Phalcon\\Mvc\\RouterInterface**
===========================================

Methods
---------

abstract public  **setDefaultModule** (*string* $moduleName)

Sets the name of the default module



abstract public  **setDefaultController** (*string* $controllerName)

Sets the default controller name



abstract public  **setDefaultAction** (*string* $actionName)

Sets the default action name



abstract public  **setDefaults** (*array* $defaults)

Sets an array of default paths



abstract public  **handle** ([*string* $uri])

Handles routing information received from the rewrite engine



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **add** (*string* $pattern, [*string/array* $paths], [*string* $httpMethods])

Adds a route to the router on any HTTP method



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **addGet** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is GET



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **addPost** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is POST



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **addPut** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is PUT



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **addDelete** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is DELETE



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **addOptions** (*string* $pattern, [*string/array* $paths])

Add a route to the router that only match if the HTTP method is OPTIONS



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **addHead** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is HEAD



abstract public  **clear** ()

Removes all the defined routes



abstract public *string*  **getModuleName** ()

Returns processed module name



abstract public *string*  **getControllerName** ()

Returns processed controller name



abstract public *string*  **getActionName** ()

Returns processed action name



abstract public *array*  **getParams** ()

Returns processed extra params



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **getMatchedRoute** ()

Returns the route that matchs the handled URI



abstract public *array*  **getMatches** ()

Return the sub expressions in the regular expression matched



abstract public *bool*  **wasMatched** ()

Check if the router macthes any of the defined routes



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>` [] **getRoutes** ()

Return all the routes defined in the router



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **getRouteById** (*string* $id)

Returns a route object by its id



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **getRouteByName** (*string* $name)

Returns a route object by its name



