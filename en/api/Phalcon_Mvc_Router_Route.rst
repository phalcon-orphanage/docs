Class **Phalcon\\Mvc\\Router\\Route**
=====================================

This class represents every route defined in the router.


Methods
---------

public **__construct** (*string* $pattern, *array* $paths, *array|string* $httpMethods)

Phalcon\\Mvc\\Router\\Route constructor



*string* public **compilePattern** (*string* $pattern)

Replaces placeholders from pattern returning a valid PCRE regular expression



public **via** (*string|array* $httpMethods)

Set one or more HTTP methods that constraint the matching of the route



public **reConfigure** (*string* $pattern, *array* $paths)

Reconfigure the route adding a new pattern and a set of paths



*string* public **getName** ()

Returns the route's name



public **setName** (*string* $name)

Sets the route's name



public **setHttpMethods** (*string|array* $httpMethods)

Sets a set of HTTP methods that constraint the matching of the route



*string* public **getRouteId** ()

Returns the route's id



*string* public **getPattern** ()

Returns the route's pattern



*string* public **getCompiledPattern** ()

Returns the route's pattern



*array* public **getPaths** ()

Returns the paths



*string|array* public **getHttpMethods** ()

Returns the HTTP methods that constraint matching the route



public static **reset** ()

Resets the internal route id generator



