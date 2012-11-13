Interface **Phalcon\\Mvc\\UrlInterface**
========================================

Phalcon\\Mvc\\UrlInterface initializer


Methods
---------

abstract public  **setBaseUri** (*string* $baseUri)

Sets a prefix to all the urls generated



abstract public *string*  **getBaseUri** ()

Returns the prefix for all the generated urls. By default /



abstract public  **setBasePath** (*string* $basePath)

Sets a base paths for all the generated paths



abstract public *string*  **getBasePath** ()

Returns a base path



abstract public *string*  **get** (*string|array* $uri)

Generates a URL



abstract public *string*  **path** (*string* $path)

Generates a local path



