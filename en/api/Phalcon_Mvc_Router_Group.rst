Class **Phalcon\\Mvc\\Router\\Group**
=====================================

Helper class to create a group of routes with common attributes  

.. code-block:: php

    <?php

     $router = new Phalcon\Mvc\Router();
    
     //Create a group with a common module and controller
     $blog = new Phalcon\Mvc\Router\Group(array(
     	'module' => 'blog',
     	'controller' => 'index'
     ));
    
     //All the routes start with /blog
     $blog->setPrefix('/blog');
    
     //Add a route to the group
     $blog->add('/save', array(
     	'action' => 'save'
     ));
    
     //Add another route to the group
     $blog->add('/edit/{id}', array(
     	'action' => 'edit'
     ));
    
     //This route maps to a controller different than the default
     $blog->add('/blog', array(
     	'controller' => 'about',
     	'action' => 'index'
     ));
    
     //Add the group to the router
     $router->mount($blog);



Methods
---------

public  **__construct** ([*array* $paths])

Phalcon\\Mvc\\Router\\Group constructor



public :doc:`Phalcon\\Mvc\\Router\\Group <Phalcon_Mvc_Router_Group>`  **setPrefix** (*string* $prefix)

Set a common uri prefix for all the routes in this group



public *string*  **getPrefix** ()

Returns the common prefix for all the routes



public :doc:`Phalcon\\Mvc\\Router\\Group <Phalcon_Mvc_Router_Group>`  **setPaths** (*array* $paths)

Set common paths for all the routes in the group



public *array|string*  **getPaths** ()

Returns the common paths defined for this group



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>` [] **getRoutes** ()

Returns the routes added to the group



protected :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **_addRoute** ()

Adds a route applying the common attributes



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **add** (*string* $pattern, [*string/array* $paths], [*string* $httpMethods])

Adds a route to the router on any HTTP method 

.. code-block:: php

    <?php

     $router->add('/about', 'About::index');




public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addGet** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is GET



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addPost** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is POST



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addPut** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is PUT



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addPatch** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is PATCH



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addDelete** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is DELETE



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addOptions** (*string* $pattern, [*string/array* $paths])

Add a route to the router that only match if the HTTP method is OPTIONS



public :doc:`Phalcon\\Mvc\\Router\\Route <Phalcon_Mvc_Router_Route>`  **addHead** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is HEAD



public  **clear** ()

Removes all the pre-defined routes



