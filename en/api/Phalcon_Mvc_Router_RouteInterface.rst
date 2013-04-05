Interface **Phalcon\\Mvc\\Router\\RouteInterface**
==================================================

Methods
---------

abstract public  **__construct** (*string* $pattern, [*array* $paths], [*array|string* $httpMethods])

Phalcon\\Mvc\\Router\\Route constructor



abstract public *string*  **compilePattern** (*string* $pattern)

Replaces placeholders from pattern returning a valid PCRE regular expression



abstract public  **via** (*string|array* $httpMethods)

Set one or more HTTP methods that constraint the matching of the route



abstract public  **reConfigure** (*string* $pattern, [*array* $paths])

Reconfigure the route adding a new pattern and a set of paths



abstract public *string*  **getName** ()

Returns the route's name



abstract public  **setName** (*string* $name)

Sets the route's name



abstract public  **setHttpMethods** (*string|array* $httpMethods)

Sets a set of HTTP methods that constraint the matching of the route



abstract public *string*  **getRouteId** ()

Returns the route's id



abstract public *string*  **getPattern** ()

Returns the route's pattern



abstract public *string*  **getCompiledPattern** ()

Returns the route's pattern



abstract public *array*  **getPaths** ()

Returns the paths



abstract public *string|array*  **getHttpMethods** ()

Returns the HTTP methods that constraint matching the route



abstract public static  **reset** ()

Resets the internal route id generator



