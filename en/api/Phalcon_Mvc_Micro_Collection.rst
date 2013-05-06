Class **Phalcon\\Mvc\\Micro\\Collection**
=========================================

*implements* :doc:`Phalcon\\Mvc\\Micro\\CollectionInterface <Phalcon_Mvc_Micro_CollectionInterface>`

Groups Micro-Mvc handlers as controllers  

.. code-block:: php

    <?php

     $app = new Phalcon\Mvc\Micro();
    
     $collection = new Phalcon\Mvc\Micro\Collection();
    
     $collection->setHandler(new PostsController());
    
     $collection->get('/posts/edit/{id}', 'edit');
    
     $app->mount($collection);



Methods
---------

protected  **_addMap** ()

Internal function to add a handler to the group



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **setPrefix** (*string* $prefix)

Sets a prefix for all routes added to the collection



public *string*  **getPrefix** ()

Returns the collection prefix if any



public *array*  **getHandlers** ()

Returns the registered handlers



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **setHandler** (*mixed* $handler, [*boolean* $lazy])

Sets the main handler



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **setLazy** (*boolean* $lazy)

Sets if the main handler must be lazy loaded



public *boolean*  **isLazy** ()

Returns if the main handler must be lazy loaded



public *mixed*  **getHandler** ()

Returns the main handler



public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **map** (*string* $routePattern, *callable* $handler)

Maps a route to a handler



public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **get** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is GET



public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **post** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is POST



public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **put** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is PUT



public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **patch** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is PATCH



public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **head** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is HEAD



public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **delete** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is DELETE



public :doc:`Phalcon\\Mvc\\Router\\RouteInterface <Phalcon_Mvc_Router_RouteInterface>`  **options** (*string* $routePattern, *callable* $handler)

Maps a route to a handler that only matches if the HTTP method is OPTIONS



