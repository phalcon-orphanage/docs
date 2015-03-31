Class **Phalcon\\Cli\\Router\\Route**
=====================================

This class represents every route added to the router


Constants
---------

*string* **DEFAULT_DELIMITER**

Methods
-------

public  **__construct** (*unknown* $pattern, [*unknown* $paths])

Phalcon\\Cli\\Router\\Route constructor



public *string*  **compilePattern** (*unknown* $pattern)

Replaces placeholders from pattern returning a valid PCRE regular expression



public *array|boolean*  **extractNamedParams** (*unknown* $pattern)

Extracts parameters from a string



public  **reConfigure** (*unknown* $pattern, [*unknown* $paths])

Reconfigure the route adding a new pattern and a set of paths



public *string*  **getName** ()

Returns the route's name



public :doc:`Phalcon\\Cli\\Router\\Route <Phalcon_Cli_Router_Route>`  **setName** (*unknown* $name)

Sets the route's name 

.. code-block:: php

    <?php

     $router->add('/about', array(
         'controller' => 'about'
     ))->setName('about');




public :doc:`Phalcon\\Cli\\Router\\Route <Phalcon_Cli_Router_Route>`  **beforeMatch** (*unknown* $callback)

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



public :doc:`Phalcon\\Cli\\Router\\Route <Phalcon_Cli_Router_Route>`  **convert** (*unknown* $name, *unknown* $converter)

Adds a converter to perform an additional transformation for certain parameter



public *array*  **getConverters** ()

Returns the router converter



public static  **reset** ()

Resets the internal route id generator



public static  **delimiter** ([*unknown* $delimiter])

Set the routing delimiter



public static *string*  **getDelimiter** ()

Get routing delimiter



