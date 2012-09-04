Class **Phalcon\Mvc\Router**
============================

Methods
---------

public **__construct** (*unknown* $defaultRoutes)

public **setDI** (*unknown* $dependencyInjector)

public **getDI** ()

protected **_getRewriteUri** ()

public **setDefaultModule** (*unknown* $moduleName)

public **setDefaultController** (*unknown* $controllerName)

public **setDefaultAction** (*unknown* $actionName)

public **setDefaults** (*unknown* $defaults)

public **handle** (*unknown* $uri)

public **add** (*unknown* $pattern, *unknown* $paths, *unknown* $httpMethods)

public **addGet** (*unknown* $pattern, *unknown* $paths)

public **addPost** (*unknown* $pattern, *unknown* $paths)

public **addPut** (*unknown* $pattern, *unknown* $paths)

public **addDelete** (*unknown* $pattern, *unknown* $paths)

public **addOptions** (*unknown* $pattern, *unknown* $paths)

public **addHead** (*unknown* $pattern, *unknown* $paths)

public **clear** ()

public **getModuleName** ()

public **getControllerName** ()

public **getActionName** ()

public **getParams** ()

public **getMatchedRoute** ()

public **getMatches** ()

public **wasMatched** ()

public **getRoutes** ()

public **getRouteById** (*unknown* $id)

public **getRouteByName** (*unknown* $name)

