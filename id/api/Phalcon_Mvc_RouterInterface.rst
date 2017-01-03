Interface **Phalcon\\Mvc\\RouterInterface**
===========================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/routerinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **setDefaultModule** (*mixed* $moduleName)

...


abstract public  **setDefaultController** (*mixed* $controllerName)

...


abstract public  **setDefaultAction** (*mixed* $actionName)

...


abstract public  **setDefaults** (*array* $defaults)

...


abstract public  **handle** ([*mixed* $uri])

...


abstract public  **add** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

...


abstract public  **addGet** (*mixed* $pattern, [*mixed* $paths])

...


abstract public  **addPost** (*mixed* $pattern, [*mixed* $paths])

...


abstract public  **addPut** (*mixed* $pattern, [*mixed* $paths])

...


abstract public  **addPatch** (*mixed* $pattern, [*mixed* $paths])

...


abstract public  **addDelete** (*mixed* $pattern, [*mixed* $paths])

...


abstract public  **addOptions** (*mixed* $pattern, [*mixed* $paths])

...


abstract public  **addHead** (*mixed* $pattern, [*mixed* $paths])

...


abstract public  **addPurge** (*mixed* $pattern, [*mixed* $paths])

...


abstract public  **addTrace** (*mixed* $pattern, [*mixed* $paths])

...


abstract public  **addConnect** (*mixed* $pattern, [*mixed* $paths])

...


abstract public  **mount** (:doc:`Phalcon\\Mvc\\Router\\GroupInterface <Phalcon_Mvc_Router_GroupInterface>` $group)

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


abstract public  **getRouteById** (*mixed* $id)

...


abstract public  **getRouteByName** (*mixed* $name)

...


