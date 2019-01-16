* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Router\Group'

* * *

# Class **Phalcon\Mvc\Router\Group**

*implements* [Phalcon\Mvc\Router\GroupInterface](Phalcon_Mvc_Router_GroupInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/router/group.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Helper class to create a group of routes with common attributes

```php
<?php

$router = new \Phalcon\Mvc\Router();

//Create a group with a common module and controller
$blog = new Group(
    [
        "module"     => "blog",
        "controller" => "index",
    ]
);

//All the routes start with /blog
$blog->setPrefix("/blog");

//Add a route to the group
$blog->add(
    "/save",
    [
        "action" => "save",
    ]
);

//Add another route to the group
$blog->add(
    "/edit/{id}",
    [
        "action" => "edit",
    ]
);

//This route maps to a controller different than the default
$blog->add(
    "/blog",
    [
        "controller" => "about",
        "action"     => "index",
    ]
);

//Add the group to the router
$router->mount($blog);

```

## Methods

public **__construct** ([*mixed* $paths])

Phalcon\Mvc\Router\Group constructor

public **setHostname** (*mixed* $hostname)

Set a hostname restriction for all the routes in the group

public **getHostname** ()

Returns the hostname restriction

public **setPrefix** (*mixed* $prefix)

Set a common uri prefix for all the routes in this group

public **getPrefix** ()

Returns the common prefix for all the routes

public **beforeMatch** (*mixed* $beforeMatch)

Sets a callback that is called if the route is matched. The developer can implement any arbitrary conditions here If the callback returns false the route is treated as not matched

public **getBeforeMatch** ()

Returns the 'before match' callback if any

public **setPaths** (*mixed* $paths)

Set common paths for all the routes in the group

public **getPaths** ()

Returns the common paths defined for this group

public **getRoutes** ()

Returns the routes added to the group

public **add** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

Adds a route to the router on any HTTP method

```php
<?php

$router->add("/about", "About::index");

```

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addGet** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is GET

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addPost** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is POST

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addPut** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is PUT

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addPatch** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is PATCH

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addDelete** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is DELETE

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addOptions** (*string* $pattern, [*string/array* $paths])

Add a route to the router that only match if the HTTP method is OPTIONS

public [Phalcon\Mvc\Router\Route](Phalcon_Mvc_Router_Route) **addHead** (*string* $pattern, [*string/array* $paths])

Adds a route to the router that only match if the HTTP method is HEAD

public **clear** ()

Removes all the pre-defined routes

protected **_addRoute** (*mixed* $pattern, [*mixed* $paths], [*mixed* $httpMethods])

Adds a route applying the common attributes