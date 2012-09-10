Class **Phalcon\\Mvc\\Url**
===========================

This components aids in the generation off: URIs, URLs and Paths


Methods
---------

public **setDI** (*Phalcon\DI* $dependencyInjector)

Sets the DependencyInjector container



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** ()

Sets the DependencyInjector container



public **setBaseUri** (*string* $baseUri)

Sets a prefix to all the urls generated



*string* public **getBaseUri** ()

Returns the prefix for all the generated urls. By default /



*string $basePath* public **setBasePath** (*unknown* $basePath)

Sets a base paths for all the generated paths



*string* public **getBasePath** ()

Returns a base path



*string* public **get** (*string|array* $uri)

Generates a URL



*string* public **path** (*unknown* $path)

Generates a local path



