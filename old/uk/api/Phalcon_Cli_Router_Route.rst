Class **Phalcon\\Cli\\Router\\Route**
=====================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cli/router/route.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This class represents every route added to the router


Constants
---------

*string* **DEFAULT_DELIMITER**

Methods
-------

public  **__construct** (*string* $pattern, [*array* $paths])

Phalcon\\Cli\\Router\\Route constructor



public  **compilePattern** (*mixed* $pattern)

Replaces placeholders from pattern returning a valid PCRE regular expression



public *array* | *boolean* **extractNamedParams** (*string* $pattern)

Extracts parameters from a string



public  **reConfigure** (*string* $pattern, [*array* $paths])

Reconfigure the route adding a new pattern and a set of paths



public  **getName** ()

Returns the route's name



public  **setName** (*mixed* $name)

Sets the route's name

.. code-block:: php

    <?php

    $router->add(
        "/about",
        [
            "controller" => "about",
        ]
    )->setName("about");




public :doc:`Phalcon\\Cli\\Router\\Route <Phalcon_Cli_Router_Route>` **beforeMatch** (*callback* $callback)

Sets a callback that is called if the route is matched.
The developer can implement any arbitrary conditions here
If the callback returns false the route is treated as not matched



public *mixed* **getBeforeMatch** ()

Returns the 'before match' callback if any



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



public :doc:`Phalcon\\Cli\\Router\\Route <Phalcon_Cli_Router_Route>` **convert** (*string* $name, *callable* $converter)

Adds a converter to perform an additional transformation for certain parameter



public  **getConverters** ()

Returns the router converter



public static  **reset** ()

Resets the internal route id generator



public static  **delimiter** ([*mixed* $delimiter])

Set the routing delimiter



public static  **getDelimiter** ()

Get routing delimiter



