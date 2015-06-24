Class **Phalcon\\Mvc\\Micro\\Collection**
=========================================

*implements* :doc:`Phalcon\\Mvc\\Micro\\CollectionInterface <Phalcon_Mvc_Micro_CollectionInterface>`

Groups Micro-Mvc handlers as controllers  

.. code-block:: php

    <?php

     $app = new \Phalcon\Mvc\Micro();
    
     $collection = new Collection();
    
     $collection->setHandler(new PostsController());
    
     $collection->get('/posts/edit/{id}', 'edit');
    
     $app->mount($collection);



Methods
-------

private  **_addMap** (*unknown* $method, *unknown* $routePattern, *unknown* $handler, *unknown* $name)

Internal function to add a handler to the group



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **setPrefix** (*unknown* $prefix)

Sets a prefix for all routes added to the collection



public *string*  **getPrefix** ()

Returns the collection prefix if any



public *array*  **getHandlers** ()

Returns the registered handlers



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **setHandler** (*unknown* $handler, [*unknown* $lazy])

Sets the main handler



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **setLazy** (*unknown* $lazy)

Sets if the main handler must be lazy loaded



public *boolean*  **isLazy** ()

Returns if the main handler must be lazy loaded



public *mixed*  **getHandler** ()

Returns the main handler



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **map** (*unknown* $routePattern, *unknown* $handler, [*unknown* $name])

Maps a route to a handler



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **get** (*unknown* $routePattern, *unknown* $handler, [*unknown* $name])

Maps a route to a handler that only matches if the HTTP method is GET



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **post** (*unknown* $routePattern, *unknown* $handler, [*unknown* $name])

Maps a route to a handler that only matches if the HTTP method is POST



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **put** (*unknown* $routePattern, *unknown* $handler, [*unknown* $name])

Maps a route to a handler that only matches if the HTTP method is PUT



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **patch** (*unknown* $routePattern, *unknown* $handler, [*unknown* $name])

Maps a route to a handler that only matches if the HTTP method is PATCH



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **head** (*unknown* $routePattern, *unknown* $handler, [*unknown* $name])

Maps a route to a handler that only matches if the HTTP method is HEAD



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **delete** (*unknown* $routePattern, *unknown* $handler, [*unknown* $name])

Maps a route to a handler that only matches if the HTTP method is DELETE



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>`  **options** (*unknown* $routePattern, *unknown* $handler, [*unknown* $name])

Maps a route to a handler that only matches if the HTTP method is OPTIONS



