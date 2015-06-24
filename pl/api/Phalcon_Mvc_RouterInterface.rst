Interface **Phalcon\\Mvc\\RouterInterface**
===========================================

Methods
-------

abstract public  **setDefaultModule** (*unknown* $moduleName)

...


abstract public  **setDefaultController** (*unknown* $controllerName)

...


abstract public  **setDefaultAction** (*unknown* $actionName)

...


abstract public  **setDefaults** (*unknown* $defaults)

...


abstract public  **handle** ([*unknown* $uri])

...


abstract public  **add** (*unknown* $pattern, [*unknown* $paths], [*unknown* $httpMethods])

...


abstract public  **addGet** (*unknown* $pattern, [*unknown* $paths])

...


abstract public  **addPost** (*unknown* $pattern, [*unknown* $paths])

...


abstract public  **addPut** (*unknown* $pattern, [*unknown* $paths])

...


abstract public  **addPatch** (*unknown* $pattern, [*unknown* $paths])

...


abstract public  **addDelete** (*unknown* $pattern, [*unknown* $paths])

...


abstract public  **addOptions** (*unknown* $pattern, [*unknown* $paths])

...


abstract public  **addHead** (*unknown* $pattern, [*unknown* $paths])

...


abstract public  **clear** ()

...


abstract public  **getModuleName** ()

...


abstract public  **getNamespaceName** ()

...


abstract public  **getControllerName** ()

...


abstract public  **getActionName** ()

...


abstract public  **getParams** ()

...


abstract public  **getMatchedRoute** ()

...


abstract public  **getMatches** ()

...


abstract public  **wasMatched** ()

...


abstract public  **getRoutes** ()

...


abstract public  **getRouteById** (*unknown* $id)

...


abstract public  **getRouteByName** (*unknown* $name)

...


