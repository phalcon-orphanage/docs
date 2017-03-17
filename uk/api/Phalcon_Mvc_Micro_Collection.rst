Class **Phalcon\\Mvc\\Micro\\Collection**
=========================================

*implements* :doc:`Phalcon\\Mvc\\Micro\\CollectionInterface <Phalcon_Mvc_Micro_CollectionInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/micro/collection.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Groups Micro-Mvc handlers as controllers

.. code-block:: php

    <?php

    $app = new \Phalcon\Mvc\Micro();

    $collection = new Collection();

    $collection->setHandler(
        new PostsController()
    );

    $collection->get("/posts/edit/{id}", "edit");

    $app->mount($collection);



Methods
-------

protected  **_addMap** (*string* | *array* $method, *string* $routePattern, *mixed* $handler, *string* $name)

Internal function to add a handler to the group



public  **setPrefix** (*mixed* $prefix)

Sets a prefix for all routes added to the collection



public  **getPrefix** ()

Returns the collection prefix if any



public *array* **getHandlers** ()

Returns the registered handlers



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>` **setHandler** (*mixed* $handler, [*boolean* $lazy])

Sets the main handler



public  **setLazy** (*mixed* $lazy)

Sets if the main handler must be lazy loaded



public  **isLazy** ()

Returns if the main handler must be lazy loaded



public *mixed* **getHandler** ()

Returns the main handler



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>` **map** (*string* $routePattern, *callable* $handler, [*string* $name])

Maps a route to a handler



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>` **get** (*string* $routePattern, *callable* $handler, [*string* $name])

Maps a route to a handler that only matches if the HTTP method is GET



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>` **post** (*string* $routePattern, *callable* $handler, [*string* $name])

Maps a route to a handler that only matches if the HTTP method is POST



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>` **put** (*string* $routePattern, *callable* $handler, [*string* $name])

Maps a route to a handler that only matches if the HTTP method is PUT



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>` **patch** (*string* $routePattern, *callable* $handler, [*string* $name])

Maps a route to a handler that only matches if the HTTP method is PATCH



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>` **head** (*string* $routePattern, *callable* $handler, [*string* $name])

Maps a route to a handler that only matches if the HTTP method is HEAD



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>` **delete** (*string* $routePattern, *callable* $handler, [*string* $name])

Maps a route to a handler that only matches if the HTTP method is DELETE



public :doc:`Phalcon\\Mvc\\Micro\\Collection <Phalcon_Mvc_Micro_Collection>` **options** (*string* $routePattern, *callable* $handler, [*mixed* $name])

Maps a route to a handler that only matches if the HTTP method is OPTIONS



