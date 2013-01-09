Class **Phalcon\\Mvc\\Router\\Route**
=====================================

*implements* :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`

This class represents every route added to the router


Methods
---------

public  **__construct** (*string* $pattern, [*array* $paths], [*array|string* $httpMethods])

Phalcon\\Mvc\\Router\\Route constructor



public *string*  **compilePattern** (*string* $pattern)

Replaces placeholders from pattern returning a valid PCRE regular expression



public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **via** (*string|array* $httpMethods)

Set one or more HTTP methods that constraint the matching of the route



public  **reConfigure** (*string* $pattern, [*array* $paths])

Reconfigure the route adding a new pattern and a set of paths



public *string*  **getName** ()

Returns the route's name



public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **setName** (*string* $name)

Sets the route's name



public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **setHttpMethods** (*string|array* $httpMethods)

Sets a set of HTTP methods that constraint the matching of the route



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



public *string|array*  **getHttpMethods** ()

Returns the HTTP methods that constraint matching the route



public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **convert** (*string* $name, *callable* $converter)

Adds a converter to perform an additional transformation for certain parameter



public *array*  **getConverters** ()

Returns the router converter



public static  **reset** ()

Resets the internal route id generator



