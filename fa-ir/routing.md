---
layout: default
language: 'fa-ir'
version: '4.0'
title: 'Routing'
upgrade: '#router'
keywords: 'routing, routes'
---

# Routing Component

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

The [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) component allows you to define routes that are mapped to controllers or handlers that receive and can handle the request. The router has two modes: MVC mode and match-only mode. The first mode is ideal for working with MVC applications.

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->add(
    '/admin/invoices/list',
    [
        'controller' => 'invoices',
        'action'     => 'list',
    ]
);

$router->handle(
    $_SERVER["REQUEST_URI"]
);
````

## Constants
There are two constants available for the [Phalcon\Mvc\Router][mvc-router] component that are used to define the position of the route in the processing stack.

- `POSITION_FIRST`
- `POSITION_LAST`

## Methods

```php
public function __construct(
    bool $defaultRoutes = true
)
```

Phalcon\Mvc\Router constructor

```php
public function add(
    string $pattern, 
    mixed $paths = null, 
    mixed $httpMethods = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Adds a route to the router without any HTTP constraint

```php
use Phalcon\Mvc\Router;

$router->add("/about", "About::index");

$router->add(
    "/about",
    "About::index",
    ["GET", "POST"]
);

$router->add(
    "/about",
    "About::index",
    ["GET", "POST"],
    Router::POSITION_FIRST
);
```

```php
public function addConnect(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Adds a route to the router that only match if the HTTP method is `CONNECT`

```php
public function addDelete(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Adds a route to the router that only match if the HTTP method is `DELETE`

```php
public function addGet(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Adds a route to the router that only match if the HTTP method is `GET`

```php
public function addHead(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Adds a route to the router that only match if the HTTP method is `HEAD`

```php
public function addOptions(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Add a route to the router that only match if the HTTP method is `OPTIONS`

```php
public function addPatch(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Adds a route to the router that only match if the HTTP method is `PATCH`

```php
public function addPost(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Adds a route to the router that only match if the HTTP method is `POST`

```php
public function addPurge(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Adds a route to the router that only match if the HTTP method is `PURGE` (Squid and Varnish support)

```php
public function addPut(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Adds a route to the router that only match if the HTTP method is `PUT`

```php
public function addTrace(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Adds a route to the router that only match if the HTTP method is `TRACE`

```php
public function attach(
    RouteInterface $route, 
    mixed $position = Router::POSITION_LAST
): RouterInterface
```

Attach Route object to the routes stack.

```php use Phalcon\Mvc\Router; use Phalcon\Mvc\Router\Route;

class CustomRoute extends Route { // ... }

$router = new Router();

$router->attach( new CustomRoute( "/about", "About::index", ["GET", "HEAD"] ), Router::POSITION_FIRST );

    <br />```php
    public function clear(): void
    

Removes all the pre-defined routes

```php
public function getActionName(): string
```

Returns the processed action name

```php
public function getControllerName(): string
```

Returns the processed controller name

```php
public function getMatchedRoute(): RouteInterface
```

Returns the route that matches the handled URI

```php
public function getMatches(): array
```

Returns the sub expressions in the regular expression matched

```php
public function getModuleName(): string
```

Returns the processed module name

```php
public function getNamespaceName(): string
```

Returns the processed namespace name

```php
public function getParams(): array
```

Returns the processed parameters

```php
public function getRouteById(
    mixed $id
): RouteInterface | bool
```

Returns a route object by its id

```php
public function getRouteByName(
    string $name
): RouteInterface | bool
```

Returns a route object by its name

```php
public function getRoutes(): RouteInterface[]
```

Returns all the routes defined in the router

```php
public function handle(string $uri): void
```

Handles routing information received from the rewrite engine

```php
$router->handle("/posts/edit/1");
```

```php
public function isExactControllerName(): bool
```

Returns whether controller name should not be mangled

```php
public function mount(
    GroupInterface $group
): RouterInterface
```

Mounts a group of routes in the router

```php
public function notFound(
    mixed $paths
): RouterInterface
```

Set a group of paths to be returned when none of the defined routes are matched

```php
public function removeExtraSlashes(
    bool $remove
): RouterInterface
```

Set whether router must remove the extra slashes in the handled routes

```php
public function setDefaultAction(
    string $actionName
): RouterInterface
```

Sets the default action name

```php
public function setDefaultController(
    string $controllerName
): RouterInterface
```

Sets the default controller name

```php
public function setDefaultModule(
    string $moduleName
): RouterInterface
```

Sets the name of the default module

```php
public function setDefaultNamespace(
    string $namespaceName
): RouterInterface
```

Sets the name of the default namespace

```php
public function setDefaults(
    array $defaults
): RouterInterface
```

Sets an array of default paths. If a route is missing a path the router will use the defined here. This method must not be used to set a 404 route

```php
$router->setDefaults(
    [
        "module" => "common",
        "action" => "index",
    ]
);
```

```php
public function getDefaults(): array
```

Returns an array of default parameters

```php
public function wasMatched(): bool
```

Checks if the router matches any of the defined routes

## Defining Routes

[Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) provides advanced routing capabilities. In MVC mode, you can define routes and map them to controllers/actions that you require. A route is defined as follows:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->add(
    '/admin/invoices/list',
    [
        'controller' => 'invoices',
        'action'     => 'list',
    ]
);

$router->add(
    '/admin/customers/list',
    [
        'controller' => 'customers',
        'action'     => 'list',
    ]
);

$router->handle(
    $_SERVER["REQUEST_URI"]
);
````


The first parameter of the `add()` method is the pattern you want to match and, optionally, the second parameter is a set of paths. In the above example, for the URI `/admin/invoices/list`, the `InvoicesController` will be loaded and the `listAction` will be called. It is important to remember that the router does not execute the controller and action, it only collects this information and then forwards it to the [Phalcon\Mvc\Dispatcher](dispatcher) which executes them.

An application can have many paths and defining routes one by one can be a cumbersome task. [Phalcon\Mvc\Router][mvc-router] offers an easier way to register routes.

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->add(
    '/admin/:controller/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ]
);
```

In the example above, we are using wildcards to make a route valid for many URIs. For example, by accessing the following URL (`/admin/customers/view/12345/1`) would produce:

| Controller  | Action | Parameter | Parameter |
|:-----------:|:------:|:---------:|:---------:|
| `customers` | `view` |  `12345`  |    `1`    |

The `add()` method receives a pattern that can optionally have predefined placeholders and regular expression modifiers. All the routing patterns must start with a forward slash character (`/`). The regular expression syntax used is the same as the [PCRE regular expressions](https://secure.php.net/manual/en/book.pcre.php).

> **NOTE**: It is not necessary to add regular expression delimiters. All route patterns are case-insensitive.
{: .alert .alert-info }

The second parameter defines how the matched parts should bind to the controller/action/parameters. Matching parts are placeholders or subpatterns delimited by parentheses (round brackets). In the example given above, the first subpattern matched (`:controller`) is the controller part of the route, the second the action (`:action`) and after that any parameters passed (`:params`).

These placeholders make the route expressions more readable and easier to understand. The following placeholders are supported:

| Placeholder    | Regular Expression       | Matches                                                                                      |
| -------------- | ------------------------ | -------------------------------------------------------------------------------------------- |
| `/:module`     | `/([a-zA-Z0-9\_\-]+)` | Valid module name with alpha-numeric characters only                                         |
| `/:controller` | `/([a-zA-Z0-9\_\-]+)` | Valid controller name with alpha-numeric characters only                                     |
| `/:action`     | `/([a-zA-Z0-9_-]+)`      | Valid action name with alpha-numeric characters only                                         |
| `/:params`     | `(/.*)*`                 | List of optional words separated by slashes. Only use this placeholder at the end of a route |
| `/:namespace`  | `/([a-zA-Z0-9\_\-]+)` | Single level namespace name                                                                  |
| `/:int`        | `/([0-9]+)`              | Integer parameter                                                                            |

Controller names are camelized, this means that characters (`-`) and (`_`) are removed and the next character is uppercased. For instance, `some_controller` is converted to `SomeController`.

Since you can add as many routes as needed using the `add()` method, the order in which routes are added indicates their relevance. The routes added last have more relevance than the ones added above them. Internally, all defined routes are traversed in reverse order until [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) finds the one that matches the given URI and processes it, while ignoring the rest.

### Named Parameters

The example below demonstrates how to define names to route parameters:

```php
<?php

$router->add(
    //         1     /     2    /    3     /   4
    '/admin/([0-9]{4})/([0-9]{2})/([0-9]{2})/:params',
    [
        'controller' => 'invoices',
        'action'     => 'view',
        'year'       => 1, // ([0-9]{4})
        'month'      => 2, // ([0-9]{2})
        'day'        => 3, // ([0-9]{2})
        'params'     => 4, // :params
    ]
);
```

In the above example, the route does not define a `controller` or `action`. Those are replaced with fixed values (`invoices` and `view`). The user will never know the underlying controller that is dispatched by the request. In the controller, those named parameters can be accessed as follows:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

/**
 * @property Dispatcher $dispatcher
 */
class InvoicesController extends Controller
{
    public function viewAction()
    {
        // year
        $year = $this->dispatcher->getParam('year');

        // month
        $month = $this->dispatcher->getParam('month');

        // day
        $day = $this->dispatcher->getParam('day');

        // ...
    }
}
```

Note that the values of the parameters are obtained from the dispatcher. There is also another way to create named parameters as part of the pattern:

```php
<?php

$router->add(
    '/admin/{year}/{month}/{day}/{invoiceNo:[0-9]+}',
    [
        'controller' => 'invoices',
        'action'     => 'view',
    ]
);
```

You can access their values in the same way as before:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

/**
 * @property Dispatcher $dispatcher
 */
class InvoicesController extends Controller
{
    public function viewAction()
    {
        // year
        $year = $this->dispatcher->getParam('year');

        // month
        $month = $this->dispatcher->getParam('month');

        // day 
        $day = $this->dispatcher->getParam('day');

        // invoiceNo
        $invoicNo = $this->dispatcher->getParam('invoiceNo');

        // ...
    }
}
```

### Short Syntax

[Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) also offers an alternative, shorter syntax. The following examples produce the same result:

```php
<?php

$router->add(
    '/admin/{year:[0-9]{4}}/{month:[0-9]{2}}/{day:[0-9]{2}}/:params',
    'Invoices::view'
);

$router->add(
    '/admin/([0-9]{4})/([0-9]{2})/([0-9]{2})/:params',
    [
        'controller' => 'invoices',
        'action'     => 'view',
        'year'       => 1, // ([0-9]{4})
        'month'      => 2, // ([0-9]{2})
        'day'        => 3, // ([0-9]{2})
        'params'     => 4, // :params
    ]
);
```

### Array and Short Syntax

Array and short syntax can be mixed to define a route, in this case note that named parameters automatically are added to the route paths according to the position on which they were defined:

```php
<?php

$router->add(
    '/admin/{year:[0-9]{4}}/([0-9]{2})/([0-9]{2})/:params',
    [
        'controller' => 'invoices',
        'action'     => 'view',
        'month'      => 2, // ([0-9]{2}) // 2
        'day'        => 3, // ([0-9]{2}) // 3
        'params'     => 4, // :params    // 4
    ]
);
```

The first position must be skipped because it is used for the named parameter `year`.

### Modules

You can define routes with modules in the path. This is specially suitable to multi-module applications. You can define a default route that includes a module wildcard.

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

With the above route, you need to always have the module name as part of your URL. For example, for the following URL: `/admin/invoices/view/12345`, will be processed as:

| Module  | Controller | Action | Parameter |
|:-------:|:----------:|:------:|:---------:|
| `admin` | `invoices` | `view` |  `12345`  |

Or you can bind specific routes to specific modules:

```php
<?php

$router->add(
    '/login',
    [
        'module'     => 'session',
        'controller' => 'login',
        'action'     => 'index',
    ]
);

$router->add(
    '/invoices/:action',
    [
        'module'     => 'admin',
        'controller' => 'invoices',
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

The full namespace needs to be passed separately:

```php
<?php

$router->add(
    '/login',
    [
        'namespace'  => 'Admin\Controllers',
        'controller' => 'login',
        'action'     => 'index',
    ]
);
```

### HTTP Methods

When you add a route using simply `add()`, the route will be enabled for any HTTP method. Sometimes we can restrict a route to a specific method. This is particularly useful when creating RESTful applications.

```php
<?php

// GET
$router->addGet(
    '/invoices/edit/{id}',
    'Invoices::edit'
);

// POST
$router->addPost(
    '/invoices/save',
    'Invoices::save'
);

// POST/PUT
$router->add(
    '/invoices/update',
    'Invoices::update'
)->via(
    [
        'POST',
        'PUT',
    ]
);
```

### Converters

Converters are snippets of code that allow you to convert the parameters of a route prior to it being sent to the <dispatcher>

```php
<?php

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
        return str_replace('-', '', $slug);
    }
);
```

In the above example, the action name allows dashes, therefore an action can be `/products/new-ipod-nano-4-generation`. The `convert` method will change the action to `newipodnano4generation`

Another use case for converters is when binding a model to a route. This allows the model to be passed into the defined action directly.

```php
<?php

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
        return Product::findFirstById($id);
    }
);
```

In the above example the ID is passed in the URL and our converter gets the record from the database, passing it back.

### Groups

If a set of routes have common paths they can be grouped for easier maintenance. To achieve this, we utilize the [Phalcon\Mvc\Router\Group](api/phalcon_mvc#mvc-router-group) component

```php
<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group;

$router   = new Router();
$invoices = new RouterGroup(
    [
        'module'     => 'admin',
        'controller' => 'invoices',
    ]
);

$invoices->setPrefix('/invoices');

$invoices->add(
    '/list',
    [
        'action' => 'list',
    ]
);

$invoices->add(
    '/edit/{id}',
    [
        'action' => 'edit',
    ]
);

$invoices->add(
    '/view',
    [
        'controller' => 'common',
        'action'     => 'index',
    ]
);

$router->mount($invoices);
```

In the above example, we first create a group with a common module and controller. We then add the prefix for the group to be `/invoices`. We then add more routes to the group, some without parameters and some with. The last route allows us to use a different controller than the default one (`common`). Finally, we add the group to the router.

We can extend the [Phalcon\Mvc\Router\Group](api/phalcon_mvc#mvc-router-group) component and register our routes in it on a per group basis. This allows us to better organize the routes of our application.

```php
<?php

use Phalcon\Mvc\Router\Group;

class InvoicesRoutes extends Group
{
    public function initialize()
    {
        $this->setPaths(
            [
                'module'    => 'invoices',
                'namespace' => 'Invoices\Controllers',
            ]
        );

        $this->setPrefix('/invoices');

        $this->add(
            '/list',
            [
                'action' => 'list',
            ]
        );

        $this->add(
            '/edit/{id}',
            [
                'action' => 'edit',
            ]
        );

        $this->add(
            '/view',
            [
                'controller' => 'common',
                'action'     => 'index',
            ]
        );
    }
}
```

Now we can mount the custom group class in the router:

```php
<?php

$router->mount(
    new InvoicesRoutes()
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

In this configuration, any requests to files or folders that do not exist will be sent to `index.php`. The following example shows how to use this as a stand alone component:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

// ...

$router->handle(
    $_GET["_url"]
);

echo $router->getControllerName();
echo $router->getActionName();

$route = $router->getMatchedRoute();
```

In the above example, we first create a router object. We can have some code after that, such as defining services, routes etc.. We then take the `_url` element from the `$_GET` superglobal and after that we can get the controller name or the action name or even get back the matched route.

## Naming Routes

Each route that is added to the router is stored internally as a [Phalcon\Mvc\Router\Route](api/phalcon_mvc#mvc-router-route) object. That class encapsulates all the details of each route. For instance, we can give a name to a path to identify it uniquely in our application. This is especially useful if you want to create URLs from it.

```php
<?php

$route = $router->add(
    '/admin/{year:[0-9]{4}}/{month:[0-9]{2}}/{day:[0-9]{2}}/{id:[0-9]{4}',
    'Invoices::view'
);

$route->setName('invoices-view');
```

Then, using for example the component [Phalcon\Url](url) we can build routes from the defined name:

```php
<?php

// /admin/2019/12/25/1234
echo $url->get(
    [
        'for'   => 'invoices-view',
        'year'  => '2019',
        'month' => '12',
        'day'   => '25',
        'id'    => '1234',
    ]
);
```

## Default Behavior

[Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) has a default behavior providing simple routing that always expects a URI and matches the following pattern:

    /:controller/:action/:params
    

For example, for a URL like this `https://dev.phalcon.od/download/linux/ubuntu.html`, this router will translate it as follows:

|      Controller      |    Action     |   Parameter   |
|:--------------------:|:-------------:|:-------------:|
| `DownloadController` | `linuxAction` | `ubuntu.html` |

If you do not want the router to follow this behavior, you must create the router passing `false` in the constructor.

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router(false);
```

## Default Route

When your application is accessed without any route, the `/` route is used to determine what paths must be used to show the initial page in your application

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

## Not Found (404)

If none of the routes, specified in the router, match, you can define a 404 controller/action by using the `notFound` method.

```php
<?php

$router->notFound(
    [
        'controller' => 'index',
        'action'     => 'fourOhFour',
    ]
);
```

> **NOTE**: This will only work if the router was created without default routes: `$router = Phalcon\Mvc\Router(false);`
{: .alert .alert-warning }

## Defaults

You can define default values for `module`, `controller` and `action. When a route is missing any of these elements in its path, the router will automatically use the default value set.

```php
<?php

$router->setDefaultModule('admin');
$router->setDefaultNamespace('Admin\Controllers');
$router->setDefaultController('index');
$router->setDefaultAction('index');

$router->setDefaults(
    [
        'controller' => 'index',
        'action'     => 'index',
    ]
);
```

## Trailing Slashes

Sometimes a route could be accessed with extra/trailing slashes. The extra slashes will produce a not-found status in the dispatcher, which is not what we want. You can set up the router to automatically remove the slashes from the end of handled route.

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->removeExtraSlashes(true);
```

Or, you can modify specific routes to optionally accept trailing slashes:

```php
<?php

$route = $router->add(
    '/admin/:controller/status[/]{0,1}',
    [
        'controller' => 2,
        'action'     => 'status',
    ]
);
```

In the above, the `[/]{0,1}` allows for an optional trailing slash

## Callbacks

Sometimes, routes should only be matched if they meet specific conditions. You can add arbitrary conditions to routes using the `beforeMatch` callback. If this function return `false`, the route will be treated as non-matched:

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
        if (true === isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest'
        ) {
            return false;
        }

        return true;
    }
);
```

The above will check if the request has been made with AJAX and return false if it was not

You can create a filter class, to allow you to inject the same functionality in different routes.

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

To set this up, we just add the class to the `beforeMatch` call.

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
    [
        new AjaxFilter(),
        'check'
    ]
);
```

Finally you can use the `beforeMatch` method (or event) to check whether this was an AJAX call or not.

```php
<?php

use Phalcon\Di\DiInterface;
use Phalcon\Http\Request;
use Phalcon\Mvc\Router\Route;

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
         * @var string     $uri
         * @var Route       $route
         * @var DiInterface $this
         * @var Request     $request
         */
        $request = $this->getShared('request');

        return $request->isAjax();
    }
);
```

## Hostname

The [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) component also allows for hostname constraints. This means that the specific routes or a group of routes can be restricted to only match the route if it originated from a specific hostname.

```php
<?php

$route = $router->add(
    '/admin/invoices/:action/:params',
    [
        'module'     => 'admin',
        'controller' => 'invoices',
        'action'     => 1,
        'params'     => 2,
    ]
);

$route->setHostName('dev.phalcon.ld');
```

The hostname can also be passed as a regular expressions:

```php
<?php

$route = $router->add(
    '/admin/invoices/:action/:params',
    [
        'module'     => 'admin',
        'controller' => 'invoices',
        'action'     => 1,
        'params'     => 2,
    ]
);

$route->setHostName('([a-z]+).phalcon.ld');
```

When using groups of routes, you can set the hostname constraints that apply for every route in the group.

```php
<?php

use Phalcon\Mvc\Router\Group;

$invoices = new Group(
    [
        'module'     => 'admin',
        'controller' => 'invoices',
    ]
);

$invoices->setHostName('dev.phalcon.ld');
$invoices->setPrefix('/invoices');

$invoices->add(
    '/',
    [
        'action' => 'index',
    ]
);

$invoices->add(
    '/list',
    [
        'action' => 'list',
    ]
);

$invoices->add(
    '/view/{id}',
    [
        'action' => 'view',
    ]
);

$router->mount($invoices);
```

## Testing

This component does not have any dependencies. As such you can create unit tests to test your routes.

```php
<?php

use Phalcon\Mvc\Router;

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

Similar to other Phalcon components, [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) also has events, when an [Events Manager](events) is present. The available events are:

| Event                      | Fired when                        |
| -------------------------- | --------------------------------- |
| `router:afterCheckRoutes`  | After checking all the routes     |
| `router:beforeCheckRoute`  | Before checking a route           |
| `router:beforeCheckRoutes` | Before checking all loaded routes |
| `router:beforeMount`       | Before mounting a new route       |
| `router:matchedRoute`      | When a route is matched           |
| `router:notMatchedRoute`   | When a route is not matched       |

## Annotations

This component provides a variant that is integrated with the <annotations> service. Using this strategy you can write the routes directly in the controllers instead of adding them in router component directly.

```php
<?php

use Phalcon\Mvc\Router\Annotations;

$container['router'] = function () {
    $router = new Annotations(false);

    $router->addResource('Invoices', '/admin/invoices');

    return $router;
};
```

In the above example, we utilize the [Phalcon\Mvc\Router\Annotations](api/phalcon_mvc#mvc-router-annotations) component to set up our routes. We pass `false` to remove the default behavior. After that we are instructing the component to read the annotations from the `InvoicesController` if the URI matches `/admin/invoices`.

The `InvoicesController` will need to have the following implementation:

```php
<?php

/**
 * @RoutePrefix('/admin/invoices')
 */
class InvoicesController
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
     *     name='invoice-edit'
     * )
     */
    public function editAction($id)
    {

    }

    /**
     * @Route(
     *     '/save',
     *     methods={'POST', 'PUT'},
     *     name='invoice-save'
     * )
     */
    public function saveAction()
    {

    }

    /**
     * @Route(
     *     '/delete/{id:[0-9]+}',
     *     methods='DELETE',
     *     converters={
     *         id='MyConverters::checkId'
     *     }
     * )
     */
    public function deleteAction($id)
    {

    }
}
```

Only methods marked with valid annotations are used as routes. The available annotations are:

| Annotation    | Description                                                                    | Usage                              |
| ------------- | ------------------------------------------------------------------------------ | ---------------------------------- |
| `Delete`      | Restrict the HTTP method to `DELETE`                                           | `@Delete('/invoices/delete/{id}')` |
| `Get`         | Restrict the HTTP method to `GET`                                              | `@Get('/invoices/search')`         |
| `Options`     | Restrict the HTTP method to `OPTIONS`                                          | `@Option('/invoices/info')`        |
| `Post`        | Restrict the HTTP method to `POST`                                             | `@Post('/invoices/save')`          |
| `Put`         | Restrict the HTTP method to `PUT`                                              | `@Put('/invoices/save')`           |
| `Route`       | Mark a method as a route. Must be placed in a method docblock                  | `@Route('/invoices/show')`         |
| `RoutePrefix` | Prefix to be prepended to each route URI. Must be placed in the class docblock | `@RoutePrefix('/invoices')`        |

For annotations that add routes, the following parameters are supported:

| Name         | Description                                    | Usage                                                               |
| ------------ | ---------------------------------------------- | ------------------------------------------------------------------- |
| `converters` | A hash of converters for the parameters        | `@Route('/posts/{id}/{slug}', converter={id='MyConverter::getId'})` |
| `methods`    | One or more HTTP methods allowed for the route | `@Route('/api/products', methods={'GET', 'POST'})`                  |
| `name`       | The name for the route                         | `@Route('/api/products', name='get-products')`                      |
| `paths`      | Paths array for the route                      | `@Route('/invoices/view/{id}/{slug}', paths={module='backend'})`    |

If you are using modules in your application, it is better use the `addModuleResource()` method:

```php
<?php

use Phalcon\Mvc\Router\Annotations;

$container['router'] = function () {
    $router = new Annotations(false);

    $router->addModuleResource(
        'admin', 
        'Invoices', 
        '/admin/invoices'
    );

    return $router;
};
```

In the above we will read the annotations from `Admin\Controllers\InvoicesController` if the URI starts with `/admin/invoices`.

The router also understand prefixes to ensure that the routes are resolved as fast as possible. For instance for the following routes:

    /clients/{clientId:[0-9]+}/
    /clients/{clientId:[0-9]+}/robots
    /clients/{clientId:[0-9]+}/parts
    

only the `/clients` prefix can be used in all controllers, thus speeding up the lookup.

## Dependency Injection

You can register the router component during the container setup, to make it available inside the controllers or any other components that extend the [Phalcon\Di\Injectable](api/phalcon_di#di-injectable) component.

You can use the example below in your bootstrap file (for example `index.php` or `app/config/services.php` if you use [Phalcon Developer Tools](https://phalcon.io/en/download/tools)).

```php
<?php

$container->set(
    'router',
    function () {
        require __DIR__ . '/app/config/routes.php';

        return $router;
    }
);
```

You need to create `app/config/routes.php` and add the router initialization code:

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
    '/invoices/:action',
    [
        'controller' => 'invoices',
        'action'     => 1,
    ]
);

return $router;
```

## Custom

You can create your own components by implementing the supplied interfaces: - [Phalcon\Mvc\Router\GroupInterface](api/phalcon_mvc#mvc-router-groupinterface) - [Phalcon\Mvc\Router\RouteInterface](api/phalcon_mvc#mvc-router-routeinterface) - [Phalcon\Mvc\RouterInterface](api/phalcon_mvc#mvc-routerinterface)

## Examples

The following are examples of custom routes:

```php
<?php

// '/system/admin/a/edit/7001'
$router->add(
    '/system/:controller/a/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ]
);

// '/en/news'
$router->add(
    '/([a-z]{2})/:controller',
    [
        'controller' => 2,
        'action'     => 'index',
        'language'   => 1,
    ]
);

// '/en/news'
$router->add(
    '/{language:[a-z]{2}}/:controller',
    [
        'controller' => 2,
        'action'     => 'index',
    ]
);

// '/admin/posts/edit/100'
$router->add(
    '/admin/:controller/:action/:int',
    [
        'controller' => 1,
        'action'     => 2,
        'id'         => 3,
    ]
);

// '/posts/2015/02/some-cool-content'
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

// '/manual/en/translate.adapter.html'
$router->add(
    '/manual/([a-z]{2})/([a-z\.]+)\.html',
    [
        'controller' => 'manual',
        'action'     => 'show',
        'language'   => 1,
        'file'       => 2,
    ]
);

// /feed/fr/hot-news.atom
$router->add(
    '/feed/{lang:[a-z]+}/{blog:[a-z\-]+}\.{type:[a-z\-]+}',
    'Feed::get'
);

// /api/v1/users/peter.json
$router->add(
    '/api/(v1|v2)/{method:[a-z]+}/{param:[a-z]+}\.(json|xml)',
    [
        'controller' => 'api',
        'version'    => 1,
        'format'     => 4,
    ]
);
```

> **NOTE**: Be careful when allowing characters in regular expressions for controllers and namespaces. These will become class names and in turn they will interact with the file system. As such, it is possible that an attacker can access unauthorized files. A safe regular expression is: `/([a-zA-Z0-9\_\-]+)`
{: .alert .alert-danger }

