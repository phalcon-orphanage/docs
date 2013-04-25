Class **Phalcon\\Mvc\\Micro\\Collection**
=========================================

Groups handlers as controllers  

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

...


public *array*  **getHandlers** ()

Returns the registered handlers



public  **setHandler** (*mixed* $handler)

Sets the main handler



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



