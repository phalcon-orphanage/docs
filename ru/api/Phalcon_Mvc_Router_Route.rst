Class **Phalcon\\Mvc\\Router\\Route**
=====================================

*implements* :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/router/route.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This class represents every route added to the router


Methods
-------

public  **__construct** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

Phalcon\\Mvc\\Router\\Route constructor



public  **compilePattern** (*mixed* $pattern)

Replaces placeholders from pattern returning a valid PCRE regular expression



public  **via** (*mixed* $httpMethods)

Set one or more HTTP methods that constraint the matching of the route 

.. code-block:: php

    <?php

     $route->via('GET');
     $route->via(array('GET', 'POST'));




public  **extractNamedParams** (*mixed* $pattern)

Extracts parameters from a string



public  **reConfigure** (*mixed* $pattern, [*mixed* $paths])

Reconfigure the route adding a new pattern and a set of paths



public static  **getRoutePaths** ([*mixed* $paths])

Returns routePaths



public  **getName** ()

Returns the route's name



public  **setName** (*mixed* $name)

Sets the route's name 

.. code-block:: php

    <?php

     $router->add('/about', array(
         'controller' => 'about'
     ))->setName('about');




public  **beforeMatch** (*mixed* $callback)

Sets a callback that is called if the route is matched. The developer can implement any arbitrary conditions here If the callback returns false the route is treated as not matched 

.. code-block:: php

    <?php

     $router->add('/login', array(
      'module'     => 'admin',
      'controller' => 'session'
     ))->beforeMatch(function ($uri, $route) {
       // Check if the request was made with Ajax
       if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'xmlhttprequest') {
          return false;
       }
         return true;
     });




public  **getBeforeMatch** ()

Returns the 'before match' callback if any



public  **match** (*mixed* $callback)

Allows to set a callback to handle the request directly in the route 

.. code-block:: php

    <?php

    $router->add("/help", array())->match(function () {
      return $this->getResponse()->redirect('https://support.google.com/', true);
    });




public  **getMatch** ()

Returns the 'match' callback if any



public  **getRouteId** ()

Returns the route's id



public  **getPattern** ()

Returns the route's pattern



public  **getCompiledPattern** ()

Returns the route's compiled pattern



public  **getPaths** ()

Returns the paths



public  **getReversedPaths** ()

Returns the paths using positions as keys and names as values



public  **setHttpMethods** (*mixed* $httpMethods)

Sets a set of HTTP methods that constraint the matching of the route (alias of via) 

.. code-block:: php

    <?php

     $route->setHttpMethods('GET');
     $route->setHttpMethods(array('GET', 'POST'));




public  **getHttpMethods** ()

Returns the HTTP methods that constraint matching the route



public  **setHostname** (*mixed* $hostname)

Sets a hostname restriction to the route 

.. code-block:: php

    <?php

     $route->setHostname('localhost');




public  **getHostname** ()

Returns the hostname restriction if any



public  **setGroup** (:doc:`Phalcon\\Mvc\\Router\\GroupInterface <Phalcon_Mvc_Router_GroupInterface>` $group)

Sets the group associated with the route



public  **getGroup** ()

Returns the group associated with the route



public  **convert** (*mixed* $name, *mixed* $converter)

Adds a converter to perform an additional transformation for certain parameter



public  **getConverters** ()

Returns the router converter



public static  **reset** ()

Resets the internal route id generator



