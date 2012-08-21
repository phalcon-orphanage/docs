Class **Phalcon_Router_Regex**
==============================

Phalcon_Router_Regex is the standard framework router. Routing is the process of taking a URI endpoint (that part of the URI which comes after the base URL) and decomposing it into parameters to determine which module, controller, and action of that controller should receive the request

.. code-block:: php

    <?php
    
    $router = new Phalcon_Router_Regex();
    $router->handle();
    echo $router->getControllerName();
    
   Settings baseUri first:  

.. code-block:: php

    <?php
    
    $router = new Phalcon_Router_Regex();
    $router->handle();
    echo $router->getControllerName();
    
Methods
---------

**__construct** ()

**string** **_getRewriteUri** ()

Get rewrite info

**setBaseUri** (string $baseUri)

Set the base of application

**string** **compilePattern** (string $pattern)

Replaces placeholders from pattern returning a valid PCRE regular expression

**add** (string $pattern, string/array $paths)

Add a route to the router

**handle** (string $uri)

Handles routing information received from the rewrite engine

**string** **getControllerName** ()

Returns processed controller name

**string** **getActionName** ()

Returns processed action name

**array** **getParams** ()

Returns processed extra params

**string** **getCurrentRoute** ()

Returns the route that matches the handled URI

