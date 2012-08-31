Class **Phalcon\\Mvc\\Router**
==============================

Phalcon\\Mvc\\Router   <p>Phalcon\\Mvc\\Router is the standard framework router. Routing is the  process of taking a URI endpoint (that part of the URI which comes after the base URL) and  decomposing it into parameters to determine which module, controller, and  action of that controller should receive the request</p>  

.. code-block:: php

    <?php

    
    $router = new Phalcon\Mvc\Router();
    $router->handle();
    echo $router->getControllerName();
    



   Settings baseUri first:  

.. code-block:: php

    <?php

    
    $router = new Phalcon\Mvc\Router();
    $router->handle();
    echo $router->getControllerName();
    



 </example>

Methods
---------

**__construct** (*unknown* **$defaultRoutes**)

**setDI** (*Phalcon\DI* **$dependencyInjector**)

:doc:`Phalcon\\DI <Phalcon_DI>` **getDI** ()

*string* **_getRewriteUri** ()

**setDefaultModule** (*unknown* **$moduleName**)

**setDefaultController** (*unknown* **$controllerName**)

**setDefaultAction** (*unknown* **$actionName**)

**setDefaults** (*unknown* **$defaults**)

**handle** (*string* **$uri**)

:doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>` **add** (*string* **$pattern**, *string/array* **$paths**, *string* **$httpMethods**)

:doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>` **addGet** (*string* **$pattern**, *string/array* **$paths**)

:doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>` **addPost** (*string* **$pattern**, *string/array* **$paths**)

:doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>` **addPut** (*string* **$pattern**, *string/array* **$paths**)

:doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>` **addDelete** (*string* **$pattern**, *string/array* **$paths**)

:doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>` **addOptions** (*string* **$pattern**, *string/array* **$paths**)

:doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>` **addHead** (*string* **$pattern**, *string/array* **$paths**)

**clear** ()

*string* **getModuleName** ()

*string* **getControllerName** ()

*string* **getActionName** ()

*array* **getParams** ()

:doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>` **getMatchedRoute** ()

*array* **getMatches** ()

*bool* **wasMatched** ()

:doc:`Phalcon\\Mvc\\Router\\Route[] <Phalcon_Mvc_Router_Route[]>` **getRoutes** ()

**getRouteById** (*unknown* **$id**)

**getRouteByName** (*unknown* **$name**)

