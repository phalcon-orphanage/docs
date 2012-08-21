Class **Phalcon_Router_Rewrite**
================================

Phalcon_Router_Rewrite is the standard framework router. Routing is the process of taking a URI endpoint (that part of the URI which comes after the base URL) and decomposing it into parameters to determine which module, controller, and action of that controller should receive the request.

Rewrite rules using a single document root: 

.. code-block:: php

    <?php
    
    $router = new Phalcon_Router_Rewrite(); 
    $router->handle();
    echo $router->getControllerName();

  Rewrite rules using a hidden directory and a public/ document root: 

.. code-block:: php

    <?php
    
    $router = new Phalcon_Router_Rewrite(); 
    $router->handle();
    echo $router->getControllerName();

   On public/.htaccess:  

.. code-block:: php

    <?php
    
    $router = new Phalcon_Router_Rewrite(); 
    $router->handle();
    echo $router->getControllerName();
    
   The component can be used as follows:  

.. code-block:: php

    <?php
    
    $router = new Phalcon_Router_Rewrite(); 
    $router->handle();
    echo $router->getControllerName();
    
Methods
---------

**_getRewriteUri** ()

Get rewrite info

**setPrefix** (unknown $prefix)

Set a uri prefix. This will be replaced from the beginning of the uri

**handle** (string $uri)

Handles routing information received from the rewrite engine

**string** **getControllerName** ()

Returns proccesed controller name

**string** **getActionName** ()

Returns proccesed action name

**array** **getParams** ()

Returns proccesed extra params

