---
layout: default
language: 'en'
version: '4.0'
title: 'Routing'
keywords: 'routing, routes'
---
# Routing Component
<hr />
![](/assets/images/document-status-under-review-red.svg)

## Overview
The router component allows you to define routes that are mapped to controllers or handlers that should receive the request. A router simply parses a URI to determine this information. The router has two modes: MVC mode and match-only mode. The first mode is ideal for working with MVC applications.

## Defining Routes
[Phalcon\Mvc\Router](api/Phalcon_Mvc_Router) provides advanced routing capabilities. In MVC mode, you can define routes and map them to controllers/actions that you require. A route is defined as follows:

```php
<?php

use Phalcon\Mvc\Router;

// Create the router
$router = new Router();

// Define a route
$router->add(
    '/admin/users/my-profile',
    [
        'controller' => 'users',
        'action'     => 'profile',
    ]
);

// Another route
$router->add(
    '/admin/users/change-password',
    [
        'controller' => 'users',
        'action'     => 'changePassword',
    ]
);

$router->handle(
    $_SERVER["REQUEST_URI"]
);
````

The first parameter of the `add()` method is the pattern you want to match and, optionally, the second parameter is a set of paths. In this case, if the URI is `/admin/users/my-profile`, then the `users` controller with its action `profile` will be executed. It's important to remember that the router does not execute the controller and action, it only collects this information to inform the correct component (i.e. [Phalcon\Mvc\Dispatcher](api/Phalcon_Mvc_Dispatcher)) that this is the controller/action it should execute.

An application can have many paths and defining routes one by one can be a cumbersome task. In these cases we can create more flexible routes:

```php
<?php

use Phalcon\Mvc\Router;

// Create the router
$router = new Router();

// Define a route
$router->add(
    '/admin/:controller/a/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ]
);
```

In the example above, we're using wildcards to make a route valid for many URIs. For example, by accessing the following URL (`/admin/users/a/delete/dave/301`) would produce:

| Controller | Action | Parameter | Parameter |
|:----------:|:------:|:---------:|:---------:|
| users      | delete | dave      | 301       |

The `add()` method receives a pattern that can optionally have predefined placeholders and regular expression modifiers. All the routing patterns must start with a forward slash character (`/`). The regular expression syntax used is the same as the [PCRE regular expressions][pcre]. Note that, it is not necessary to add regular expression delimiters. All route patterns are case-insensitive.

The second parameter defines how the matched parts should bind to the controller/action/parameters. Matching parts are placeholders or subpatterns delimited by parentheses (round brackets). In the example given above, the first subpattern matched (`:controller`) is the controller part of the route, the second the action and so on.

These placeholders help writing regular expressions that are more readable for developers and easier to understand. The following placeholders are supported:

| Placeholder    | Regular Expression    | Usage                                                                                                  |
|----------------|-----------------------|--------------------------------------------------------------------------------------------------------|
| `/:module`     | `/([a-zA-Z0-9\_\-]+)` | Matches a valid module name with alpha-numeric characters only                                         |
| `/:controller` | `/([a-zA-Z0-9\_\-]+)` | Matches a valid controller name with alpha-numeric characters only                                     |
| `/:action`     | `/([a-zA-Z0-9_-]+)`   | Matches a valid action name with alpha-numeric characters only                                         |
| `/:params`     | `(/.*)*`              | Matches a list of optional words separated by slashes. Only use this placeholder at the end of a route |
| `/:namespace`  | `/([a-zA-Z0-9\_\-]+)` | Matches a single level namespace name                                                                  |
| `/:int`        | `/([0-9]+)`           | Matches an integer parameter                                                                           |

Controller names are camelized, this means that characters (`-`) and (`_`) are removed and the next character is uppercased. For instance, some_controller is converted to SomeController.

Since you can add many routes as you need using the `add()` method, the order in which routes are added indicate their relevance, latest routes added have more relevance than first added. Internally, all defined routes are traversed in reverse order until [Phalcon\Mvc\Router](api/Phalcon_Mvc_Router) finds the one that matches the given URI and processes it, while ignoring the rest.

### Parameters with Names
The example below demonstrates how to define names to route parameters:

```php
<?php

$router->add(
    '/news/([0-9]{4})/([0-9]{2})/([0-9]{2})/:params',
    [
        'controller' => 'posts',
        'action'     => 'show',
        'year'       => 1, // ([0-9]{4})
        'month'      => 2, // ([0-9]{2})
        'day'        => 3, // ([0-9]{2})
        'params'     => 4, // :params
    ]
);
```

In the above example, the route doesn't define a `controller` or `action` part. These parts are replaced with fixed values (`posts` and `show`). The user will not know the controller that is really dispatched by the request. Inside the controller, those named parameters can be accessed as follows:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction()
    {
        // Get 'year' parameter
        $year = $this->dispatcher->getParam('year');

        // Get 'month' parameter
        $month = $this->dispatcher->getParam('month');

        // Get 'day' parameter
        $day = $this->dispatcher->getParam('day');

        // ...
    }
}
```

Note that the values of the parameters are obtained from the dispatcher. This happens because it is the component that finally interacts with the drivers of your application. Moreover, there is also another way to create named parameters as part of the pattern:

```php
<?php

$router->add(
    '/documentation/{chapter}/{name}.{type:[a-z]+}',
    [
        'controller' => 'documentation',
        'action'     => 'show',
    ]
);
```

You can access their values in the same way as before:

```php
<?php

use Phalcon\Mvc\Controller;

class DocumentationController extends Controller
{
    public function showAction()
    {
        // Get 'name' parameter
        $name = $this->dispatcher->getParam('name');

        // Get 'type' parameter
        $type = $this->dispatcher->getParam('type');

        // ...
    }
}
```

### Short Syntax
If you don't like using an array to define the route paths, an alternative syntax is also available. The following examples produce the same result:

```php
<?php

// Short form
$router->add(
    '/posts/{year:[0-9]+}/{title:[a-z\-]+}',
    'Posts::show'
);

// Array form
$router->add(
    '/posts/([0-9]+)/([a-z\-]+)',
    [
       'controller' => 'posts',
       'action'     => 'show',
       'year'       => 1,
       'title'      => 2,
    ]
);
```

### Mixing Array and Short Syntax
Array and short syntax can be mixed to define a route, in this case note that named parameters automatically are added to the route paths according to the position on which they were defined:

```php
<?php

// First position must be skipped because it is used for
// the named parameter 'country'
$router->add(
    '/news/{country:[a-z]{2}}/([a-z+])/([a-z\-+])',
    [
        'section' => 2, // Positions start with 2
        'article' => 3,
    ]
);
```

### Routing to Modules
You can define routes whose paths include modules. This is specially suitable to multi-module applications. It's possible define a default route that includes a module wildcard:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router(false);

$router->add(
    '/:module/:controller/:action/:params',
    [
        'module'     => 1,
        'controller' => 2,
        'action'     => 3,
        'params'     => 4,
    ]
);
```

In this case, the route always must have the module name as part of the URL. For example, the following URL: `/admin/users/edit/sonny`, will be processed as:

| Module | Controller | Action | Parameter|
|:------:|:----------:|:------:|:--------:|
| admin  | users      | edit   | sonny    |

Or you can bind specific routes to specific modules:

```php
<?php

$router->add(
    '/login',
    [
        'module'     => 'backend',
        'controller' => 'login',
        'action'     => 'index',
    ]
);

$router->add(
    '/products/:action',
    [
        'module'     => 'frontend',
        'controller' => 'products',
        'action'     => 1,
    ]
);
```

Or bind them to specific namespaces:

```php
<?php

$router->add(
    '/:namespace/login',
    [
        'namespace'  => 1,
        'controller' => 'login',
        'action'     => 'index',
    ]
);
```

Namespaces/class names must be passed separated:

```php
<?php

$router->add(
    '/login',
    [
        'namespace'  => 'Backend\Controllers',
        'controller' => 'login',
        'action'     => 'index',
    ]
);
```

### HTTP Method Restrictions
When you add a route using simply `add()`, the route will be enabled for any HTTP method. Sometimes we can restrict a route to a specific method, this is especially useful when creating RESTful applications:

```php
<?php

// This route only will be matched if the HTTP method is GET
$router->addGet(
    '/products/edit/{id}',
    'Products::edit'
);

// This route only will be matched if the HTTP method is POST
$router->addPost(
    '/products/save',
    'Products::save'
);

// This route will be matched if the HTTP method is POST or PUT
$router->add(
    '/products/update',
    'Products::update'
)->via(
    [
        'POST',
        'PUT',
    ]
);
```

### Using conversors
Conversors allow you to freely transform the route's parameters before passing them to the dispatcher. The following examples show how to use them:

```php
<?php

// The action name allows dashes, an action can be: /products/new-ipod-nano-4-generation
$route = $router->add(
    '/products/{slug:[a-z\-]+}',
    [
        'controller' => 'products',
        'action'     => 'show',
    ]
);

$route->convert(
    'slug',
    function ($slug) {
        // Transform the slug removing the dashes
        return str_replace('-', '', $slug);
    }
);
```

Another use case for conversors is binding a model into a route. This allows the model to be passed into the defined action directly:

```php
<?php

// This example works off the assumption that the ID is being used as parameter in the url: /products/4
$route = $router->add(
    '/products/{id}',
    [
        'controller' => 'products',
        'action'     => 'show',
    ]
);

$route->convert(
    'id',
    function ($id) {
        // Fetch the model
        return Product::findFirstById($id);
    }
);
```

### Groups of Routes
If a set of routes have common paths they can be grouped to easily maintain them:

```php
<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;

$router = new Router();

// Create a group with a common module and controller
$blog = new RouterGroup(
    [
        'module'     => 'blog',
        'controller' => 'index',
    ]
);

// All the routes start with /blog
$blog->setPrefix('/blog');

// Add a route to the group
$blog->add(
    '/save',
    [
        'action' => 'save',
    ]
);

// Add another route to the group
$blog->add(
    '/edit/{id}',
    [
        'action' => 'edit',
    ]
);

// This route maps to a controller different than the default
$blog->add(
    '/blog',
    [
        'controller' => 'blog',
        'action'     => 'index',
    ]
);

// Add the group to the router
$router->mount($blog);
```

You can move groups of routes to separate files in order to improve the organization and code reusing in the application:

```php
<?php

use Phalcon\Mvc\Router\Group as RouterGroup;

class BlogRoutes extends RouterGroup
{
    public function initialize()
    {
        // Default paths
        $this->setPaths(
            [
                'module'    => 'blog',
                'namespace' => 'Blog\Controllers',
            ]
        );

        // All the routes start with /blog
        $this->setPrefix('/blog');

        // Add a route to the group
        $this->add(
            '/save',
            [
                'action' => 'save',
            ]
        );

        // Add another route to the group
        $this->add(
            '/edit/{id}',
            [
                'action' => 'edit',
            ]
        );

        // This route maps to a controller different than the default
        $this->add(
            '/blog',
            [
                'controller' => 'blog',
                'action'     => 'index',
            ]
        );
    }
}
```

Then mount the group in the router:

```php
<?php

// Add the group to the router
$router->mount(
    new BlogRoutes()
);
```

## Matching Routes
A valid URI must be passed to the Router so that it can process it and find a matching route. By default, the routing URI is taken from the `$_GET['_url']` variable that is created by the rewrite engine module. A couple of rewrite rules that work very well with Phalcon are:

```apacheconfig
RewriteEngine On
RewriteCond   %{REQUEST_FILENAME} !-d
RewriteCond   %{REQUEST_FILENAME} !-f
RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
```

In this configuration, any requests to files or folders that don't exist will be sent to `index.php`. The following example shows how to use this component in stand-alone mode:

```php
<?php

use Phalcon\Mvc\Router;

// Creating a router
$router = new Router();

// Define routes here if any
// ...

// Taking URI from $_GET['_url']
$router->handle(
    $_GET["_url"]
);

// Or Setting the URI value directly
$router->handle('/employees/edit/17');

// Getting the processed controller
echo $router->getControllerName();

// Getting the processed action
echo $router->getActionName();

// Get the matched route
$route = $router->getMatchedRoute();
```

## Naming Routes
Each route that is added to the router is stored internally as a [Phalcon\Mvc\Router\Route](api/Phalcon_Mvc_Router_Route) object. That class encapsulates all the details of each route. For instance, we can give a name to a path to identify it uniquely in our application. This is especially useful if you want to create URLs from it.

```php
<?php

$route = $router->add(
    '/posts/{year}/{title}',
    'Posts::show'
);

$route->setName('show-posts');
```

Then, using for example the component [Phalcon\Url](api/Phalcon_Url) we can build routes from its name:

```php
<?php

// Returns /posts/2012/phalcon-1-0-released
echo $url->get(
    [
        'for'   => 'show-posts',
        'year'  => '2012',
        'title' => 'phalcon-1-0-released',
    ]
);
```

## Usage Examples
The following are examples of custom routes:

```php
<?php

// Matches '/system/admin/a/edit/7001'
$router->add(
    '/system/:controller/a/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ]
);

// Matches '/es/news'
$router->add(
    '/([a-z]{2})/:controller',
    [
        'controller' => 2,
        'action'     => 'index',
        'language'   => 1,
    ]
);

// Matches '/es/news'
$router->add(
    '/{language:[a-z]{2}}/:controller',
    [
        'controller' => 2,
        'action'     => 'index',
    ]
);

// Matches '/admin/posts/edit/100'
$router->add(
    '/admin/:controller/:action/:int',
    [
        'controller' => 1,
        'action'     => 2,
        'id'         => 3,
    ]
);

// Matches '/posts/2015/02/some-cool-content'
$router->add(
    '/posts/([0-9]{4})/([0-9]{2})/([a-z\-]+)',
    [
        'controller' => 'posts',
        'action'     => 'show',
        'year'       => 1,
        'month'      => 2,
        'title'      => 3,
    ]
);

// Matches '/manual/en/translate.adapter.html'
$router->add(
    '/manual/([a-z]{2})/([a-z\.]+)\.html',
    [
        'controller' => 'manual',
        'action'     => 'show',
        'language'   => 1,
        'file'       => 2,
    ]
);

// Matches /feed/fr/le-robots-hot-news.atom
$router->add(
    '/feed/{lang:[a-z]+}/{blog:[a-z\-]+}\.{type:[a-z\-]+}',
    'Feed::get'
);

// Matches /api/v1/users/peter.json
$router->add(
    '/api/(v1|v2)/{method:[a-z]+}/{param:[a-z]+}\.(json|xml)',
    [
        'controller' => 'api',
        'version'    => 1,
        'format'     => 4,
    ]
);
```

> Beware of characters allowed in regular expression for controllers and namespaces. As these become class names and in turn they're passed through the file system could be used by attackers to read unauthorized files. A safe regular expression is: `/([a-zA-Z0-9\_\-]+)`
{: .alert .alert-warning }

## Default Behavior
[Phalcon\Mvc\Router](api/Phalcon_Mvc_Router) has a default behavior that provides a very simple routing that always expects a URI that matches the following pattern: `/:controller/:action/:params`

For example, for a URL like this `https://phalcon.io/documentation/show/about.html`, this router will translate it as follows:

| Controller    | Action | Parameter  |
|:-------------:|:------:|:----------:|
| documentation | show   | about.html |

If you don't want the router to have this behavior, you must create the router passing `false` as the first parameter:

```php
<?php

use Phalcon\Mvc\Router;

// Create the router without default routes
$router = new Router(false);
```

## Setting the default route
When your application is accessed without any route, the '/' route is used to determine what paths must be used to show the initial page in your website/application:

```php
<?php

$router->add(
    '/',
    [
        'controller' => 'index',
        'action'     => 'index',
    ]
);
```

## Not Found Paths
If none of the routes specified in the router are matched, you can define a group of paths to be used in this scenario:

```php
<?php

// Set 404 paths
$router->notFound(
    [
        'controller' => 'index',
        'action'     => 'route404',
    ]
);
```

This is typically for an Error 404 page.

> This will only work if the router was created without default routes: `$router = Phalcon\Mvc\Router(FALSE);`

## Setting default paths
It's possible to define default values for the module, controller or action. When a route is missing any of those paths they can be automatically filled by the router:

```php
<?php

// Setting a specific default
$router->setDefaultModule('backend');
$router->setDefaultNamespace('Backend\Controllers');
$router->setDefaultController('index');
$router->setDefaultAction('index');

// Using an array
$router->setDefaults(
    [
        'controller' => 'index',
        'action'     => 'index',
    ]
);
```

## Dealing with extra/trailing slashes
Sometimes a route could be accessed with extra/trailing slashes. Those extra slashes would lead to produce a not-found status in the dispatcher. You can set up the router to automatically remove the slashes from the end of handled route:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

// Remove trailing slashes automatically
$router->removeExtraSlashes(true);
```

Or, you can modify specific routes to optionally accept trailing slashes:

```php
<?php

// The [/]{0,1} allows this route to have optionally have a trailing slash
$router->add(
    '/{language:[a-z]{2}}/:controller[/]{0,1}',
    [
        'controller' => 2,
        'action'     => 'index',
    ]
);
```

## Match Callbacks
Sometimes, routes should only be matched if they meet specific conditions. You can add arbitrary conditions to routes using the `beforeMatch()` callback. If this function return `false`, the route will be treated as non-matched:

```php
<?php

$route = $router->add(
    '/login',
    [
        'module'     => 'admin',
        'controller' => 'session',
    ]
);

$route->beforeMatch(
    function ($uri, $route) {
        // Check if the request was made with Ajax
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            return false;
        }

        return true;
    }
);
```

You can re-use these extra conditions in classes:

```php
<?php

class AjaxFilter
{
    public function check()
    {
        return $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}
```

And use this class instead of the anonymous function:

```php
<?php

$route = $router->add(
    '/get/info/{id}',
    [
        'controller' => 'products',
        'action'     => 'info',
    ]
);

$route->beforeMatch(
    [
        new AjaxFilter(),
        'check'
    ]
);
```

As of Phalcon 3, there is another way to check this:

```php
<?php

$route = $router->add(
    '/login',
    [
        'module'     => 'admin',
        'controller' => 'session',
    ]
);

$route->beforeMatch(
    function ($uri, $route) {
        /**
         * @var string $uri
         * @var \Phalcon\Mvc\Router\Route $route
         * @var \Phalcon\Di\DiInterface $this
         * @var \Phalcon\Http\Request $request
         */
        $request = $this->getShared('request');

        // Check if the request was made with Ajax
        return $request->isAjax();
    }
);
```

## Hostname Constraints
The router allows you to set hostname constraints, this means that specific routes or a group of routes can be restricted to only match if the route also meets the hostname constraint:

```php
<?php

$route = $router->add(
    '/login',
    [
        'module'     => 'admin',
        'controller' => 'session',
        'action'     => 'login',
    ]
);

$route->setHostName('admin.company.com');
```

The hostname can also be passed as a regular expressions:

```php
<?php

$route = $router->add(
    '/login',
    [
        'module'     => 'admin',
        'controller' => 'session',
        'action'     => 'login',
    ]
);

$route->setHostName('([a-z]+).company.com');
```

In groups of routes you can set up a hostname constraint that apply for every route in the group:

```php
<?php

use Phalcon\Mvc\Router\Group as RouterGroup;

// Create a group with a common module and controller
$blog = new RouterGroup(
    [
        'module'     => 'blog',
        'controller' => 'posts',
    ]
);

// Hostname restriction
$blog->setHostName('blog.mycompany.com');

// All the routes start with /blog
$blog->setPrefix('/blog');

// Default route
$blog->add(
    '/',
    [
        'action' => 'index',
    ]
);

// Add a route to the group
$blog->add(
    '/save',
    [
        'action' => 'save',
    ]
);

// Add another route to the group
$blog->add(
    '/edit/{id}',
    [
        'action' => 'edit',
    ]
);

// Add the group to the router
$router->mount($blog);
```

## Testing your routes
Since this component has no dependencies, you can create a file as shown below to test your routes:

```php
<?php

use Phalcon\Mvc\Router;

// These routes simulate real URIs
$testRoutes = [
    '/',
    '/index',
    '/index/index',
    '/index/test',
    '/products',
    '/products/index/',
    '/products/show/101',
];

$router = new Router();

// Add here your custom routes
// ...

// Testing each route
foreach ($testRoutes as $testRoute) {
    // Handle the route
    $router->handle($testRoute);

    echo 'Testing ', $testRoute, '<br>';

    // Check if some route was matched
    if ($router->wasMatched()) {
        echo 'Controller: ', $router->getControllerName(), '<br>';
        echo 'Action: ', $router->getActionName(), '<br>';
    } else {
        echo "The route wasn't matched by any route<br>";
    }

    echo '<br>';
}
```

## Events
Like many other components, routers also have events. None of the events can stop the operation. Below is a list of available events

| Event                      | Description                          |
|----------------------------|--------------------------------------|
| `router:afterCheckRoutes`  | Fired after check all routes         |
| `router:beforeCheckRoute`  | Fired before check a route           |
| `router:beforeCheckRoutes` | Fired before check all loaded routes |
| `router:beforeMount`       | Fired before mount a new route       |
| `router:matchedRoute`      | Fired when a route is matched        |
| `router:notMatchedRoute`   | Fired is any route is matched        |

## Annotations Router
This component provides a variant that's integrated with the [annotations](annotations) service. Using this strategy you can write the routes directly in the controllers instead of adding them in the service registration:

```php
<?php

use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

$di['router'] = function () {
    // Use the annotations router. We're passing false as we don't want the router to add its default patterns
    $router = new RouterAnnotations(false);

    // Read the annotations from ProductsController if the URI starts with /api/products
    $router->addResource('Products', '/api/products');

    return $router;
};
```

The annotations can be defined in the following way:

```php
<?php

/**
 * @RoutePrefix('/api/products')
 */
class ProductsController
{
    /**
     * @Get(
     *     '/'
     * )
     */
    public function indexAction()
    {

    }

    /**
     * @Get(
     *     '/edit/{id:[0-9]+}',
     *     name='edit-robot'
     * )
     */
    public function editAction($id)
    {

    }

    /**
     * @Route(
     *     '/save',
     *     methods={'POST', 'PUT'},
     *     name='save-robot'
     * )
     */
    public function saveAction()
    {

    }

    /**
     * @Route(
     *     '/delete/{id:[0-9]+}',
     *     methods='DELETE',
     *     conversors={
     *         id='MyConversors::checkId'
     *     }
     * )
     */
    public function deleteAction($id)
    {

    }

    public function infoAction($id)
    {

    }
}
```

Only methods marked with valid annotations are used as routes. List of annotations supported:

| Name        | Description                                                                                       | Usage                                  |
|-------------|---------------------------------------------------------------------------------------------------|----------------------------------------|
| Delete      | This annotation marks a method as a route restricting the HTTP method to `DELETE`                 | `@Delete('/api/products/delete/{id}')` |
| Get         | This annotation marks a method as a route restricting the HTTP method to `GET`                    | `@Get('/api/products/search')`         |
| Options     | This annotation marks a method as a route restricting the HTTP method to `OPTIONS`                | `@Option('/api/products/info')`        |
| Post        | This annotation marks a method as a route restricting the HTTP method to `POST`                   | `@Post('/api/products/save')`          |
| Put         | This annotation marks a method as a route restricting the HTTP method to `PUT`                    | `@Put('/api/products/save')`           |
| Route       | This annotation marks a method as a route. This annotation must be placed in a method docblock    | `@Route('/api/products/show')`         |
| RoutePrefix | A prefix to be prepended to each route URI. This annotation must be placed at the class' docblock | `@RoutePrefix('/api/products')`        |

For annotations that add routes, the following parameters are supported:

| Name       | Description                                                          | Usage                                                                |
|------------|----------------------------------------------------------------------|----------------------------------------------------------------------|
| conversors | A hash of conversors to be applied to the parameters                 | `@Route('/posts/{id}/{slug}', conversors={id='MyConversor::getId'})` |
| methods    | Define one or more HTTP method that route must meet with             | `@Route('/api/products', methods={'GET', 'POST'})`                   |
| name       | Define a name for the route                                          | `@Route('/api/products', name='get-products')`                       |
| paths      | An array of paths like the one passed to `Phalcon\Mvc\Router::add()` | `@Route('/posts/{id}/{slug}', paths={module='backend'})`             |

If you're using modules in your application, it is better use the `addModuleResource()` method:

```php
<?php

use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

$di['router'] = function () {
    // Use the annotations router
    $router = new RouterAnnotations(false);

    // Read the annotations from Backend\Controllers\ProductsController if the URI starts with /api/products
    $router->addModuleResource('backend', 'Products', '/api/products');

    return $router;
};
```

## Registering Router instance
You can register router during service registration with Phalcon dependency injector to make it available inside the controllers.

You need to add code below in your bootstrap file (for example `index.php` or `app/config/services.php` if you use [Phalcon Developer Tools][devtools].

```php
<?php

/**
 * Add routing capabilities
 */
$di->set(
    'router',
    function () {
        require __DIR__ . '/../app/config/routes.php';

        return $router;
    }
);
```

You need to create `app/config/routes.php` and add router initialization code, for example:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->add(
    '/login',
    [
        'controller' => 'login',
        'action'     => 'index',
    ]
);

$router->add(
    '/products/:action',
    [
        'controller' => 'products',
        'action'     => 1,
    ]
);

return $router;
```

## Implementing your own Router
The `Phalcon\Mvc\RouterInterface` interface must be implemented to create your own router replacing the one provided by Phalcon.

[devtools]: https://phalcon.io/en/download/tools
[pcre]: https://secure.php.net/manual/en/book.pcre.php
