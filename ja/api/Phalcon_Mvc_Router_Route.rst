Class **Phalcon\\Mvc\\Router\\Route**
=====================================

*implements* :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`

This class represents every route added to the router


Methods
-------

public  **__construct** (*string* $pattern, [*array* $paths], [*array|string* $httpMethods])

Phalcon\\Mvc\\Router\\Route constructor



public *string*  **compilePattern** (*string* $pattern)

Replaces placeholders from pattern returning a valid PCRE regular expression



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **via** (*string|array* $httpMethods)

Set one or more HTTP methods that constraint the matching of the route 

.. code-block:: php

    <?php

     $route->via('GET');
     $route->via(array('GET', 'POST'));




public  **reConfigure** (*string* $pattern, [*array* $paths])

Reconfigure the route adding a new pattern and a set of paths



public *string*  **getName** ()

Returns the route's name



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **setName** (*string* $name)

Sets the route's name 

.. code-block:: php

    <?php

     $router->add('/about', array(
         'controller' => 'about'
     ))->setName('about');




public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **beforeMatch** (*callback* $callback)

Sets a callback that is called if the route is matched. The developer can implement any arbitrary conditions here If the callback returns false the route is treaded as not matched



public *mixed*  **getBeforeMatch** ()

Returns the 'before match' callback if any



public *string*  **getRouteId** ()

Returns the route's id



public *string*  **getPattern** ()

Returns the route's pattern



public *string*  **getCompiledPattern** ()

Returns the route's compiled pattern



public *array*  **getPaths** ()

Returns the paths



public *array*  **getReversedPaths** ()

Returns the paths using positions as keys and names as values



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **setHttpMethods** (*string|array* $httpMethods)

Sets a set of HTTP methods that constraint the matching of the route (alias of via) 

.. code-block:: php

    <?php

     $route->setHttpMethods('GET');
     $route->setHttpMethods(array('GET', 'POST'));




public *string|array*  **getHttpMethods** ()

Returns the HTTP methods that constraint matching the route



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **setHostname** (*unknown* $hostname)

Sets a hostname restriction to the route 

.. code-block:: php

    <?php

     $route->setHostname('localhost');




public *string*  **getHostname** ()

Returns the hostname restriction if any



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **convert** (*string* $name, *callable* $converter)

Adds a converter to perform an additional transformation for certain parameter



public *array*  **getConverters** ()

Returns the router converter



public static  **reset** ()

Resets the internal route id generator



