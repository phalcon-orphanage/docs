Interface **Phalcon\\Mvc\\Micro\\CollectionInterface**
======================================================

Phalcon\\Mvc\\Micro\\CollectionInterface initializer


Methods
-------

abstract public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **setPrefix** (*string* $prefix)

Sets a prefix for all routes added to the collection



abstract public *string*  **getPrefix** ()

Returns the collection prefix if any



abstract public *array*  **getHandlers** ()

Returns the registered handlers



abstract public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **setHandler** (*mixed* $handler, [*boolean* $lazy])

Sets the main handler



abstract public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **setLazy** (*boolean* $lazy)

Sets if the main handler must be lazy loaded



abstract public *boolean*  **isLazy** ()

Returns if the main handler must be lazy loaded



abstract public *mixed*  **getHandler** ()

Returns the main handler



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **map** (*string* $routePattern, *callable* $handler)

Maps a route to a handler



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **get** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is GET



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **post** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is POST



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **put** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is PUT



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **patch** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is PATCH



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **head** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is HEAD



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **delete** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is DELETE



abstract public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **options** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is OPTIONS



