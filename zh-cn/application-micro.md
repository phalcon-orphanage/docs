---
layout: default
language: 'zh-cn'
version: '4.0'
title: '微型应用'
keywords: 'application, micro, handlers, api'
---

# 微型应用

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

Phalcon offers a very 'thin' application, so that you can create `Micro` applications with minimal PHP code and overhead. Micro applications are suitable for small applications that will have very low overhead. Such applications are usually APIs, prototypes etc.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->get(
    '/invoices/view/{id}
',
    function ($id) {
        echo "<h1>Invoice #{$id}!</h1>";
    }
);

$app->handle(
    $_SERVER["REQUEST_URI"]
);
```

## Activation

The [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) class is the one responsible for creating a Micro application.

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Micro;

$container = new Di();
$app       = new Micro($container);
```

## Methods

```php
public function __construct(
    DiInterface $container = null
)
```

Constructor. Accepts an optional Di container.

```php
public function after(
    callable $handler
): Micro
```

Appends an `after` middleware to be called after execute the route

```php
public function afterBinding(
    callable $handler
): Micro
```

Appends a afterBinding middleware to be called after model binding

```php
public function before(
    callable $handler
): Micro
```

Appends a before middleware to be called before execute the route

```php
public function delete(
    string $routePattern, 
    callable $handler
): RouteInterface
```

Maps a route to a handler that only matches if the HTTP method is DELETE

```php
public function error(
    callable $handler
): Micro
```

Sets a handler that will be called when an exception is thrown handling the route

```php
public function finish(
    callable $handler
): Micro
```

Appends a `finish` middleware to be called when the request is finished

```php
public function get(
    string $routePattern, 
    callable $handler
): RouteInterface
```

Maps a route to a handler that only matches if the HTTP method is GET

```php
public function getActiveHandler(): callable
```

Return the handler that will be called for the matched route

```php
public function getBoundModels(): array
```

Returns bound models from binder instance

```php
public function getHandlers(): array
```

Returns the internal handlers attached to the application

```php
public function getModelBinder(): BinderInterface | null
```

Get the model binder

```php
public function getReturnedValue(): mixed
```

Returns the value returned by the executed handler

```php
public function getRouter(): RouterInterface
```

Returns the internal router used by the application

```php
public function getService(
    string $serviceName
): object
```

Obtains a service from the DI

```php
public function getSharedService(
    string $serviceName
)
```

Obtains a shared service from the DI

```php
public function handle(
    string $uri
): mixed
```

Handle the whole request

```php
public function hasService(
    string $serviceName
): bool
```

Checks if a service is registered in the DI

```php
public function head(
    string $routePattern, 
    callable $handler
): RouteInterface
```

Maps a route to a handler that only matches if the HTTP method is HEAD

```php
public function map(
    string $routePattern, 
    callable $handler
): RouteInterface
```

Maps a route to a handler without any HTTP method constraint

```php
public function mount(
    CollectionInterface $collection
): Micro
```

Mounts a collection of handlers

```php
public function notFound(
    callable $handler
): Micro
```

Sets a handler that will be called when the router does not match any of the defined routes

```php
public function offsetExists(
    mixed $alias
): bool
```

Check if a service is registered in the internal DI container using the array syntax

```php
public function offsetGet(
    mixed $alias
): mixed
```

Gets a DI service from the internal DI container using the array syntax

```php
public function offsetSet(
    mixed $alias, 
    mixed $definition
)
```

Registers a service in the internal DI container using the array syntax

```php
$app["request"] = new \Phalcon\Http\Request();
```

```php
public function offsetUnset(
    mixed $alias
): void
```

Removes a service from the internal DI container using the array syntax

```php
public function options(    
    string $routePattern, 
    callable $handler
): RouteInterface
```

Maps a route to a handler that only matches if the HTTP method is `OPTIONS`

```php
public function patch(
    string $routePattern, 
    callable $handler
): RouteInterface
```

Maps a route to a handler that only matches if the HTTP method is `PATCH`

```php
public function post(
    string $routePattern, 
    callable $handler
): RouteInterface
```

Maps a route to a handler that only matches if the HTTP method is `POST`

```php
public function put(
    string $routePattern, 
    callable $handler
): RouteInterface
```

Maps a route to a handler that only matches if the HTTP method is `PUT`

```php
public function setActiveHandler(
    callable $activeHandler
)
```

Sets externally the handler that must be called by the matched route

```php
public function setModelBinder(
    BinderInterface $modelBinder, 
    mixed $cache = null
): Micro
```

Sets model binder

```php
$micro = new Micro($di);

$micro->setModelBinder(
    new Binder(),
    'cache'
);
```

```php
public function setResponseHandler(
    callable $handler
): Micro
```

Appends a custom `response` handler to be called instead of the default one

```php
public function setService(
    string $serviceName, 
    mixed $definition, 
    bool $shared = false
): ServiceInterface
```

Sets a service in the internal Di container. If no container is preset a [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) will be automatically created

```php
public function stop()
```

Stops the middleware execution

## Routes

Defining routes in a [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) application is very easy. Routes are defined as follows:

```text
   Application : (http method): (route url/regex, callable PHP function/handler)
```

### Activation

Routing is handled by the [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) object.

> **NOTE**: Routes must always start with `/`
{: .alert .alert-warning }

Usually, the starting route for an application is `/`, accessed via the `GET` HTTP method:

```php
<?php

$application->get(
    '/',
    function () {
        echo '<h1>3.1459</h1>';
    }
);
```

> **NOTE**: Check our <routing> document for more information for the [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router)
{: .alert .alert-info }

**应用程序对象**

Routes can be set using the [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) application object as follows:

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->get(
    '/invoices/view/{id}
',
    function ($id) {
        echo "<h1>Invoice #{$id}!</h1>";
    }
);
```

**Router object**

You can also create a [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) object, setting the routes there and then injecting it in the dependency injection container.

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Router;


$router = new Router();
$router->addGet(
    '/invoices/view/{id}
',
    'InvoicesClass::view'
);

$container   = new Di();
$application = new Micro($container);

$application->setService('router', $router, true);
```

Setting up your routes using the [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) applications http methods (`get`, `post`, etc.) is much easier than setting up a router object with relevant routes and then injecting it in the application. Each method has its advantages and disadvantages. It all depends on the design and needs of your application.

### Rewrite Rules

In order for routes to work, your web server needs to be configured with specific instructions. Please refer to the [webserver setup](webserver-setup) document for more information.

### 处理程序

Handlers are callable pieces of code that get attached to a route. When the route is matched, the handler is executed with all the defined parameters. A handler is any valid PHP `callable`.

#### Registration

Phalcon offers several ways to attach a handler to a route. Your application needs and design as well as coding style will be the factors influencing your choice of implementation.

**匿名函数**

You can use an anonymous function to handle the request

```php
<?php

$app->get(
    '/invoices/view/{id}',
    function ($id) {
        echo "<h1>Invoice #{$id}!</h1>";
    }
);
```

Accessing the `$app` object inside the anonymous function can be achieved by injecting it as follows:

```php
<?php

$app->get(
    '/invoices/view/{id}',
    function ($id) use ($app){
        $content = "<h1>Invoice #{$id}!</h1>";

        $app->response->setContent($content);

        $app->response->send();
    }
);
```

**Function**

You can define a function as the handler and attach it to a specific route.

```php
<?php

function invoiceView($id) {
    echo "<h1>Invoice #{$id}!</h1>";
}

$app->get(
    '/invoices/view/{id}',
    'invoicesView'
);
```

**Static Method**

You can also use a static method as the handler.

```php
<?php

class InvoicesClass
{
    public static function view($id) {
        echo "<h1>Invoice #{$id}!</h1>";
    }
}

$app->get(
    '/invoices/view/{id}',
    'InvoicesClass::View'
);
```

**Method in an Object**

You can also use a method in an object as the handler.

```php
<?php

class InvoicesClass
{
    public function view($id) {
        echo "<h1>Invoice #{$id}!</h1>";
    }
}

$invoices = new InvoicesClass();
$app->get(
    '/invoices/view/{id}',
    [
        $invoices,
        'view'
    ]
);
```

**Controllers**

With the [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) you can create micro or *medium* applications. Medium applications use the micro architecture but expand on it to utilize more than the Micro but less than the Full application. In medium applications you can organize handlers in controllers.

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

$invoices = new MicroCollection();
$invoices
    ->setHandler(new InvoicesController())
    ->setPrefix('/invoices')
    ->get('/', 'index')
    ->get('/view/{id}', 'view')
;

$app->mount($invoices);
```

The `InvoicesController` might look like this:

```php
<?php

use Phalcon\Mvc\Controller;

class InvoicesController extends Controller
{
    public function index()
    {
        // ...
    }

    public function view($id) {
        // ...
    }
}
```

Since our controllers extend the [Phalcon\Mvc\Controller](api/phalcon_mvc#mvc-controller), all the dependency injection services are available with their respective registration names.

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

/**
 * @property Response $response
 */
class InvoicesController extends Controller
{
    public function index()
    {
        // ...
    }

    public function view($id)
    {
        $content = "<h1>Invoice #{$id}!</h1>";

        $this->response->setContent($content);

        return $this->response;
    }
}
```

#### Lazy Loading

In order to increase performance, you might consider implementing lazy loading for your controllers (handlers). The controller will be loaded only if the relevant route is matched.

Lazy loading can be easily achieved when setting your handler in your [Phalcon\Mvc\Micro\Collection](api/phalcon_mvc#mvc-micro-collection) using the second parameter, or by using the `setLazy` method.

```php
<?php

use MyApp\Controllers\InvoicesController;

$invoices->setHandler(
    InvoicesController::class, 
    true
);


$invoices
    ->setHandler(InvoicesController::class)
    ->setLazy(true)
    ->setPrefix('/invoices')
    ->get('/', 'index')
    ->get('/view/{id}', 'view')
;

$app->mount($invoices);
```

**Use case**

We are developing an API for an online store. The endpoints are `/users`, `/invoices` and `/products`. Each of those endpoints are registered using handlers, and each handler is a controller with relevant actions.

The controllers that we use as handlers are as follows:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function get($id)
    {
        // ...
    }

    public function add($payload)
    {
        // ...
    }
}

class InvoicesController extends Controller
{
    public function get($id)
    {
        // ...
    }

    public function add($payload)
    {
        // ...
    }
}

class ProductsController extends Controller
{
    public function get($id)
    {
        // ...
    }

    public function add($payload)
    {
        // ...
    }
}
```

We register the handlers:

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

$users = new MicroCollection();
$users
    ->setHandler(new UsersController())
    ->setPrefix('/users')
    ->get(
        '/get/{id}', 
        'get'
    )
    ->get(
        '/add/{payload}
', 
        'add'
    )
;

$app->mount($users);

$invoices = new MicroCollection();
$invoices
    ->setHandler(new InvoicesController())
    ->setPrefix('/users')
    ->get(
        '/get/{id}', 
        'get'
    )
    ->get(
        '/add/{payload}', 
        'add'
    )
;

$app->mount($invoices);

$products = new MicroCollection();
$products
    ->setHandler(new ProductsController())
    ->setPrefix('/products')
    ->get(
        '/get/{id}', 
        'get'
    )
    ->get(
        '/add/{payload}', 
        'add'
    )
;

$app->mount($products);
```

This implementation loads each handler in turn and mounts it in our application object. The issue with this approach is that each request will result to only one endpoint and therefore one class method executed. The remaining methods/handlers will just remain in memory without being used.

Using lazy loading we reduce the number of objects loaded in memory and as a result our application uses less memory. The above implementation changes if we want to use lazy loading as follows:

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

$users = new MicroCollection();
$users
    ->setHandler(
        UsersController::class,
        true
    )
    ->setPrefix('/users')
    ->get(
        '/get/{id}', 
        'get'
    )
    ->get(
        '/add/{payload}', 
        'add'
    )
;

$app->mount($users);

$invoices = new MicroCollection();
$invoices
    ->setHandler(
        InvoicesController::class,
        true
    )
    ->setPrefix('/users')
    ->get(
        '/get/{id}', 
        'get'
    )
    ->get(
        '/add/{payload}', 
        'add'
    )
;

$app->mount($invoices);

$products = new MicroCollection();
$products
    ->setHandler(
        ProductsController::class,
        true
    )
    ->setPrefix('/products')
    ->get(
        '/get/{id}', 
        'get'
    )
    ->get(
        '/add/{payload}', 
        'add'
    )
```

Using this simple change in implementation, all handlers remain non instantiated until requested by a caller. Therefore whenever a caller requests `/invoices/get/2`, our application will instantiate the `InvoicesController` and call the `get` method in it. Our application now uses less resources than before.

#### Not found (404)

Any route that has not been matched in our [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) application will cause it to try and execute the handler defined with the `notFound` method. Similar to other http methods (`get`, `post` etc.), you can register a handler in the `notFound` method which can be any callable PHP function.

```php
<?php

$app->notFound(
    function () use ($app) {
        $message = 'Nothing to see here. Move along....';
        $app
            ->response
            ->setStatusCode(404, 'Not Found')
            ->sendHeaders()
            ->setContent($message)
            ->send()
        ;
    }
);
```

You can also handle routes that have not been matched (404) with Middleware discussed below.

### HTTP methods

The [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) application provides a set of methods to bind the HTTP method with the route it is intended to.

**delete**

Matches if the HTTP method is `DELETE` and the route is `/api/products/delete/{id}`

```php
<?php

$app->delete(
    '/api/products/delete/{id}',
    'deleteProduct'
);
```

**get**

Matches if the HTTP method is `GET` and the route is `/api/products`

```php
<?php

$app->get(
    '/api/products',
    'getProducts'
);
```

**head**

Matches if the HTTP method is `HEAD` and the route is `/api/products`

```php
<?php

$app->get(
    '/api/products',
    'getProducts'
);
```

**map**

Map allows you to attach the same endpoint to more than one HTTP method. The example below matches if the HTTP method is `GET` or `POST` and the route is `/repos/store/refs`

```php
<?php

$app
    ->map(
        '/repos/store/refs',
        'actionProduct'
    )
    ->via(
        [
            'GET',
            'POST',
        ]
    );
```

**options**

Matches if the HTTP method is `OPTIONS` and the route is `/api/products/options`

```php
<?php

$app->options(
    '/api/products/options',
    'infoProduct'
);
```

**patch**

Matches if the HTTP method is `PATCH` and the route is `/api/products/update/{id}`

```php
<?php

$app->patch(
    '/api/products/update/{id}',
    'updateProduct'
);
```

**post**

Matches if the HTTP method is `POST` and the route is `/api/products/add`

```php
<?php

$app->post(
    '/api/products',
    'addProduct'
);
```

**put**

Matches if the HTTP method is `PUT` and the route is `/api/products/update/{id}`

```php
<?php

$app->put(
    '/api/products/update/{id}',
    'updateProduct'
);
```

### Collections

Collections are a handy way to group collections attached to a handler and a common prefix (if needed). For a hypothetical `/invoices` endpoint we could have the following routes:

```text
/invoices/get/{id}
/invoices/add/{payload}
/invoices/update/{id}
/invoices/delete/{id}
```

All of those routes are handled by our `InvoicesController`. We set up our routes with a collection as follows:

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

$invoices = new MicroCollection();
$invoices->setHandler(new InvoicesController());

$invoices->setPrefix('/invoices');

$invoices->get('/get/{id}', 'displayAction');
$invoices->get('/add/{payload}', 'addAction');
$invoices->get('/update/{id}', 'updateAction');
$invoices->get('/delete/{id}', 'deleteAction');

$app->mount($invoices);
```

> **NOTE**: The name that we bind each route has a suffix of `Action`. This is not necessary, your method can be called anything you like.
{: .alert .alert-warning }

**Methods**

The available methods for the [Phalcon\Mvc\Micro\Collection](api/phalcon_mvc#mvc-micro-collection) object are:

```php
public function delete(
    string $routePattern, 
    callable $handler, 
    string $name = null
): CollectionInterface
```

Maps a route to a handler that only matches if the HTTP method is `DELETE`.

```php
public function get(
    string $routePattern, 
    callable $handler,  
    string $name = null
): CollectionInterface
```

Maps a route to a handler that only matches if the HTTP method is `GET`.

```php
public function getHandler(): mixed
```

Returns the main handler

```php
public function getHandlers(): array
```

Returns the registered handlers

```php
public function getPrefix(): string
```

Returns the collection prefix if any

```php
public function head(
    string $routePattern, 
    callable $handler, 
    string $name = null
): CollectionInterface
```

Maps a route to a handler that only matches if the HTTP method is `HEAD`.

```php
public function isLazy(): bool
```

Returns if the main handler must be lazy loaded

```php
public function map(
    string $routePattern, 
    callable $handler, 
    string | array $method, 
    string $name = null
): CollectionInterface
```

Maps a route to a handler.

```php
public function mapVia(
    string $routePattern, 
    callable $handler, 
    string | array $method, 
    string $name = null
): CollectionInterface
```

Maps a route to a handler via methods.

```php
$collection->mapVia(
    "/invoices",
    "indexAction",
    [
        "POST", 
        "GET"
    ],
    "invoices"
);
```

```php
public function options(
    string $routePattern, 
    callable $handler, 
    string $name = null
): CollectionInterface
```

Maps a route to a handler that only matches if the HTTP method is `OPTIONS`.

```php
public function patch(
    string $routePattern, 
    callable $handler, 
    string $name = null
): CollectionInterface
```

Maps a route to a handler that only matches if the HTTP method is `PATCH`.

```php
public function post(
    string $routePattern, 
    callable $handler, 
    string $name = null
): CollectionInterface
```

Maps a route to a handler that only matches if the HTTP method is `POST`.

```php
public function put(
    string $routePattern, 
    callable $handler, 
    string $name = null
): CollectionInterface
```

Maps a route to a handler that only matches if the HTTP method is `PUT`.

```php
public function setHandler(
    callable $handler, 
    bool $lazy = false
): CollectionInterface
```

Sets the main handler.

```php
public function setLazy(
    bool $lazy
): CollectionInterface
```

Sets if the main handler must be lazy loaded

```php
public function setPrefix(
    string $prefix
): CollectionInterface
```

Sets a prefix for all routes added to the collection

### Parameters

We have briefly seen above how parameters are defined in the routes. Parameters are set in a route string by enclosing the name of the parameter in brackets.

```php
<?php

$app->get(
    '/invoices/view/{id}',
    function ($id) {
        echo "<h1>Invoice #{$id}!</h1>";
    }
);
```

We can also enforce certain rules for each parameter by using regular expressions. The regular expression is set after the name of the parameter, separating it with `:`.

```php
<?php

$app->get(
    '/invoices/view/{id:[0-9]+}',
    function ($id) {
        echo "<h1>Invoice #{$id}!</h1>";
    }
);

$app->get(
    '/invoices/search/year/{year:[0-9][4]}/title/{title:[a-zA-Z\-]+}',
    function ($year, $title) {
        echo "'<h1>Title: {$title}</h1>", PHP_EOL,
             "'<h2>Year: {$year}</h2>"
        ;
    }
);
```

> **NOTE**: Check our <routing> document for more information for the [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router)
{: .alert .alert-info }

### Redirections

You can redirect one matched route to another using the [Phalcon\Http\Response](api/phalcon_http#http-response) object, just like in a full application.

```php
<?php

$app->get('/invoices/show/{id}',
    function ($id) use ($app) {
        $app
            ->response
            ->redirect(
                "invoices/view/{$id}"
            )
            ->sendHeaders()
        ;
    }
);

$app->get('/invoices/view/{id}',
    function ($id) use ($app) {
        echo "<h1>Invoice #{$id}!</h1>";
    }
);
```

> **NOTE**: We have to pass the `$app` object in our anonymous function to have access to the `request` object.
{: .alert .alert-info }

When using controllers as handlers, you can perform the redirect just as easy:

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

/**
 * @property Response $response
 */
class InvoicesController extends Controller
{
    public function show($id)
    {
        return $this
            ->response
            ->redirect(
                "invoices/view/{$id}"
            )
        ;
    }

    public function get($id)
    {
        // ...
    }
}
```

Finally, you can perform redirections in your middleware (if you are using it). An example is below in the relevant section.

### URLs

Another feature of the routes is setting up named routes and generating URLs for those routes.

You will need to name your routes to take advantage of this feature. This can be achieved with the `setName()` method that is exposed from the http methods in our application (`get`, `post`, etc.);

```php
<?php

$app
    ->get(
        '/invoices/view/{id}',
        function ($id) use ($app) {
            // ...
        }
    )
    ->setName('view-invoice');
```

If you are using the [Phalcon\Mvc\Micro\Collection](api/phalcon_mvc#mvc-micro-collection) object, the name needs to be the third parameter of the methods setting the routes.

```php
<?php

$invoices = new MicroCollection();

$invoices
    ->setHandler(
        InvoicesController::class,
        true
    )
    ->setPrefix('/invoices')
    ->get(
        '/view/{id}', 
        'get', 
        'view-invoice'
    )
    ->post(
        '/add', 
        'post', 
        'add-invoice'
    )
;

$app->mount($invoices);
```

Lastly you need the [Phalcon\Url](url) component to generate URLs for the named routes.

```php
<?php

$app->get(
    '/',
    function () use ($app) {
        $url = sprintf(
            '<a href="%s">Invoice</a>',
            $app
                ->url
                ->get(
                    [
                        'for' => 'view-invoice',
                        'id'  => 1234,
                    ]
                )
        );

        echo $url;
    }
);
```

## Dependency Injector

When a micro application is created, a [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) services container is created automatically.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->get(
    '/',
    function () use ($app) {
        $app
            ->response
            ->setContent('3.1459')
            ->send()
        ;
    }
);
```

You can also create a DI container yourself, and assign it to the micro application, therefore manipulating the services depending on the needs of your application.

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Micro;
use Phalcon\Config\Adapter\Ini;

$container = new Di();

$container->set(
    'config',
    function () {
        return new Ini(
            'config.ini'
        );
    }
);

$app = new Micro($container);

$app->get(
    '/',
    function () use ($app) {
        echo $app
            ->config
            ->app_name;
    }
);

$app->post(
    '/contact',
    function () use ($app) {
        $app
            ->flash
            ->success('What are you doing Dave?')
        ;
    }
);
```

You can also use the array syntax to register services in the dependency injection container from the application object:

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Db\Adapter\Pdo\Mysql;

$app = new Micro();

$app['db'] = function () {
    return new Mysql(
        [
            'host'     => 'localhost',
            'username' => 'root',
            'password' => 'secret',
            'dbname'   => 'test_db',
        ]
    );
};

$app->get(
    '/blog',
    function () use ($app) {
        $invoices = $app['db']->query(
            'SELECT * FROM co_invoices'
        );

        foreach ($invoices as $invoice) {
            echo $invoice->inv_title;
        }
    }
);
```

## Responses

A micro application can return many different types of responses. Direct output, use a template engine, calculated data, view based data, JSON etc.

Handlers may return raw responses using plain text, [Phalcon\Http\Response](api/phalcon_http#http-response) object or a custom built component that implements the [Phalcon\Http\ResponseInterface](api/phalcon_http#http-responseinterface).

### Direct

```php
<?php

$app->get(
    '/invoices/view/{id}',
    function ($id) {
        echo "<h1>Invoice #{$id}!</h1>";
    }
);
```

### Including Files

```php
<?php

$app->get(
    '/invoices/view/{id}',
    function ($id) {
        require 'views/results.php';
    }
);
```

### Direct - JSON

```php
<?php

$app->get(
    '/invoices/view/{id}',
    function ($id) {
        echo json_encode(
            [
                'code' => 200,
                'id'   => $id,
            ]
        );
    }
);
```

### New Response

You can use the `setContent` method of a new [Phalcon\Http\Response](api/phalcon_http#http-response) object to return the response back.

```php
<?php

use Phalcon\Http\Response;

$app->get(
    '/invoices/list',
    function () {
        return (new Response())
            ->setContentType('text/plain')
            ->setContent(
                file_get_contents('data.txt')
            )
        ;
    }
);
```

### Application Response

You can also use the [Phalcon\Http\Response](api/phalcon_http#http-response) from the application to return responses to the caller.

```php
<?php

$app->get(
    '/invoices/list',
    function () use ($app) {
        $app
            ->response
            ->setContentType('text/plain')
            ->sendHeaders()
        ;

        readfile('data.txt');
    }
);
```

### Return Response

A different approach returning data back to the caller is to return the [Phalcon\Http\Response](api/phalcon_http#http-response) object directly from the application. When responses are returned by handlers they are automatically sent by the application.

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;

$app = new Micro();

$app->get(
    '/invoices//list',
    function () {
        return (new Response())
            ->setStatusCode(
                401, 
                'Unauthorized'
            )
            ->setContent(
                '401 - Unauthorized'
            )
        ;
    }
);
```

### JSON

JSON can be sent back just as easy using the [Phalcon\Http\Response](api/phalcon_http#http-response) object.

```php
<?php

$app->get(
    '/invoices/index',
    function () use ($app) {

        $data = [
            'code'    => 401,
            'status'  => 'error',
            'message' => 'Unauthorized access',
            'payload' => [],
        ];

        return $this
            ->response
            ->setJsonContent($data)
        ;
    }
);
```

## Events

A [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) application works closely with an [Events Manager](events) if it is present, to trigger events that can be used throughout our application. The type of those events is `micro`. These events trigger in our application and can be attached to relevant handlers that will perform actions needed by our application.

### Available events

以下事件被支持︰

| 事件名称                 | 触发器                                                               | Can stop |
| -------------------- | ----------------------------------------------------------------- |:--------:|
| `afterBinding`       | Triggered after models are bound but before executing the handler |    是的    |
| `afterExecuteRoute`  | Handler just finished running                                     |    否     |
| `afterHandleRoute`   | Route just finished executing                                     |    是的    |
| `beforeExecuteRoute` | Route matched, Handler valid, Handler has not been executed yet   |    是的    |
| `beforeHandleRoute`  | Main method called; Routes have not been checked yet              |    是的    |
| `beforeNotFound`     | Route has not been found                                          |    是的    |

### Authentication example

You can easily check whether a user has been authenticated or not using the `beforeExecuteRoute` event. The following example demonstrates such a scenario:

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;

$manager = new Manager();

$manager->attach(
    'micro:beforeExecuteRoute',
    function (Event $event, $app) {
        if ($app->session->get('auth') === false) {
            $app->flashSession->error(
                "The user is not authenticated"
            );

            $app->response->redirect('/');
            $app->response->sendHeaders();

            return false;
        }
    }
);

$app = new Micro();

$app->setEventsManager($manager);
```

### Not found example

You can also create a redirect for a route that does not exist (404). To do so you can use the `beforeNotFound` event. The following example demonstrates such a scenario:

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;

$manager = new Manager();

$manager->attach(
    'micro:beforeNotFound',
    function (Event $event, $app) {
        $app->response->redirect('/404');
        $app->response->sendHeaders();

        return $app->response;
    }
);

$app = new Micro();

$app->setEventsManager($manager);
```

## Middleware

Middleware are classes that can be attached to your application and introduce another layer where business logic can exist. They run sequentially, according to the order they are registered and not only improve maintainability, by encapsulating specific functionality, but also performance. A middleware class can stop execution when a particular business rule has not been satisfied, thus allowing the application to exit early without executing the full cycle of a request.

> **NOTE**: The middleware handled by the Micro application **are not** compatible with [PSR-15](https://www.php-fig.org/psr/psr-15/). In future versions of Phalcon, the whole HTTP layer will be rewritten to align with PSR-7 and PSR-15.
{: .alert .alert-info }

The presence of a [Phalcon\Events\Manager](api/phalcon_events#events-manager) is essential for middleware to operate, so it has to be registered in our DI container.

### Attached events

Middleware can be attached to a micro application in 3 different events. Those are:

| Event    | 描述                                             |
| -------- | ---------------------------------------------- |
| `before` | Before the handler has been executed           |
| `after`  | After the handler has been executed            |
| `finish` | After the response has been sent to the caller |

> **NOTE**: You can attach as many middleware classes as you want in each of the above events. They will be executed sequentially when the relevant event fires.
{: .alert .alert-warning }

**before**

This event is perfect for stopping execution of the application if certain criteria is not met. In the below example we are checking if the user has been authenticated and stop execution with the necessary redirect.

```php
<?php

$app->before(
    function () use ($app) {
        if (false === $app['session']->get('auth')) {
            $app
                ->flashSession
                ->error("The user is not authenticated")
            ;

            $app
                ->response
                ->redirect('/error')
            ;

            return false;
        }

        return true;
    }
);
```

The code above executes before every route is executed. Returning `false` cancels the route execution.

**after**

This event can be used to manipulate data or perform actions that are needed after the handler has finished executing.

```php
<?php

$app->map(
    '/invoices/list',
    function () {
        return [
            1234 => [
                'total'      => 100,
                'customerId' => 3,
                'title'      => 'Invoice for ACME Inc.',
            ]
        ];
    }
);

$app->after(
    function () use ($app) {
        echo json_encode(
            $app->getReturnedValue()
        );
    }
);
```

In the above example, the handler returns an array of data. The `after` event calls `json_encode` on it, thus returning valid JSON.

> **NOTE**: You will need to do a bit more work here to set the necessary headers for JSON. An alternative to the above code would be to use the Response object and `setJsonContent`
{: .alert .alert-info }

**finish**

This even will fire up when the whole request cycle has been completed.

```php
<?php

$app->finish(
    function () use ($app) {
        if (true === file_exists('/tmp/processing.cache')) {
            unlink('/tmp/processing.cache');
        }
    }
);
```

In the above example we utilize the `finish` event to do some cache cleaning.

### Activation

Attaching middleware to your application is very easy as shown above, with the `before`, `after` and `finish` method calls.

```php
<?php

$app->before(
    function () use ($app) {
        if (false === $app['session']->get('auth')) {
            $app['flashSession']
                ->error("The user isn not authenticated")
            ;

            $app['response']
                ->redirect('/error')
            ;

            return false;
        }

        return true;
    }
);

$app->after(
    function () use ($app) {
        echo json_encode(
            $app->getReturnedValue()
        );
    }
);
```

You can also use classes and attach them to the Events Manager as listener. Using this approach offers more flexibility are reduces the bootstrap file size, since the middleware logic is encapsulated in one file per middleware.

```php
<?php

use Phalcon\Events\Manager;
use Phalcon\Mvc\Micro;

use Website\Middleware\CacheMiddleware;
use Website\Middleware\NotFoundMiddleware;
use Website\Middleware\ResponseMiddleware;

/**
 * Create a new Events Manager.
 */
$manager     = new Manager();
$application = new Micro();

// before
$manager->attach(
    'micro',
    new CacheMiddleware()
);

$application->before(
    new CacheMiddleware()
);

$manager->attach(
    'micro',
    new NotFoundMiddleware()
);

$application->before(
    new NotFoundMiddleware()
);

// after
$manager->attach(
    'micro',
    new ResponseMiddleware()
);

$application->after(
    new ResponseMiddleware()
);

$application->setEventsManager($manager);
```

We need a [Phalcon\Events\Manager](api/phalcon_events#events-manager) object. This can be a newly instantiated object or we can get the one that exists in our DI container (if you have used the `FactoryDefault` one, or if you have not set up a DI container, since it will be automatically created for you).

We attach every middleware class in the `micro` hook in the Events Manager. We could also be a bit more specific and attach it to say the `micro:beforeExecuteRoute` event.

We then attach the middleware class in our application on one of the three listening events discussed above (`before`, `after`, `finish`).

### Implementation

Middleware can be any kind of PHP callable functions. You can organize your code whichever way you like it to implement middleware. If you choose to use classes for your middleware, you will need them to implement the [Phalcon\Mvc\Micro\MiddlewareInterface](api/phalcon_mvc#mvc-micro-middlewareinterface)

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * CacheMiddleware
 */
class CacheMiddleware implements MiddlewareInterface
{
    /**
     * Calls the middleware
     *
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        $cache  = $application['cache'];
        $router = $application['router'];

        $key = preg_replace(
            '/^[a-zA-Z0-9]/',
            '',
            $router->getRewriteUri()
        );

        // Check if the request is cached
        if ($cache->exists($key)) {
            echo $cache->get($key);

            return false;
        }

        return true;
    }
}
```

### Middleware Events

The [events](#events) that are triggered for our application also trigger inside a class that implements the [Phalcon\Mvc\Micro\MiddlewareInterface](api/phalcon_mvc#mvc-micro-middlewareinterface). This offers great flexibility and power for developers since we can interact with the request process.

**API example**

Assume that we have an API that we have implemented with the Micro application. We will need to attach different Middleware classes in the application so that we can better control the execution of the application.

The middleware that we will use are: * Firewall * NotFound * Redirect * CORS * Request * Response

**Firewall Middleware**

This middleware is attached to the `before` event of our Micro application. The purpose of this middleware is to check who is calling our API and based on a whitelist, allow them to proceed or not

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * FirewallMiddleware
 *
 * @property Request  $request
 * @property Response $response
 */
class FirewallMiddleware implements MiddlewareInterface
{
    /**
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeHandleRoute(
        Event $event, 
        Micro $application
    ) {
        $whitelist = [
            '10.4.6.1',
            '10.4.6.2',
            '10.4.6.3',
            '10.4.6.4',
        ];

        $ipAddress = $application
            ->request
            ->getClientAddress()
        ;

        if (true !== array_key_exists($ipAddress, $whitelist)) {
            $this
                ->response
                ->redirect('/401')
                ->send()
            ;

            return false;
        }

        return true;
    }

    /**
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}
```

**Not Found (404) Middleware**

When this middleware is processed, this means that the requesting IP is allowed to access our application. The application will try and match the route and if not found the `beforeNotFound` event will fire. We will stop the processing then and send back to the user the relevant 404 response. This middleware is attached to the `before` event of our Micro application

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * NotFoundMiddleware
 *
 * @property Response $response
 */
class NotFoundMiddleware implements MiddlewareInterface
{
    /**
     * @returns bool
     */
    public function beforeNotFound()
    {
        $this
            ->response
            ->redirect('/404')
            ->send()
        ;

        return false;
    }

    /**
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}
```

**Redirect Middleware**

We attach this middleware again to the `before` event of our Micro application because we do not want the request to proceed if the requested endpoint needs to be redirected.

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * RedirectMiddleware
 *
 * @property Request  $request
 * @property Response $response
 */
class RedirectMiddleware implements MiddlewareInterface
{
    /**
     * Before anything happens
     *
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeHandleRoute(
        Event $event, 
        Micro $application
    ) {
        if ('github' === $application->request->getURI()) {
            $application
                ->response
                ->redirect('https://github.com')
                ->send()
            ;

            return false;
        }

        return true;
    }

    /**
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}
```

#### CORS Middleware

Again this middleware is attached to the `before` event of our Micro application. We need to ensure that it fires before anything happens with our application

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * CORSMiddleware
 *
 * @property Request  $request
 * @property Response $response
 */
class CORSMiddleware implements MiddlewareInterface
{
    /**
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeHandleRoute(
        Event $event, 
        Micro $application
    ) {
        if ($application->request->getHeader('ORIGIN')) {
            $origin = $application
                ->request
                ->getHeader('ORIGIN')
            ;
        } else {
            $origin = '*';
        }

        $application
            ->response
            ->setHeader(
                'Access-Control-Allow-Origin', 
                $origin
            )
            ->setHeader(
                'Access-Control-Allow-Methods',
                'GET,PUT,POST,DELETE,OPTIONS'
            )
            ->setHeader(
                'Access-Control-Allow-Headers',
                'Origin, X-Requested-With, Content-Range, ' .
                'Content-Disposition, Content-Type, Authorization'
            )
            ->setHeader(
                'Access-Control-Allow-Credentials', 
                'true'
            )
        ;
    }

    /**
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}
```

**Request Middleware**

This middleware is receiving a JSON payload and checks it. If the JSON payload is not valid it will stop execution.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * RequestMiddleware
 *
 * @property Request  $request
 * @property Response $response
 */
class RequestMiddleware implements MiddlewareInterface
{
    /**
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeExecuteRoute(
        Event $event, 
        Micro $application
    ) {
        json_decode(
            $application
                ->request
                ->getRawBody()
        );

        if (JSON_ERROR_NONE !== json_last_error()) {
            $application
                ->response
                ->redirect('/malformed')
                ->send()
            ;

            return false;
        }

        return true;

    }

    /**
     * @param Micro $application
     *
     * @returns bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}
```

**Response Middleware**

This middleware is responsible for manipulating our response and sending it back to the caller as a JSON string. Therefore we need to attach it to the `after` event of our Micro application.

> **NOTE**: We are going to be using the `call` method for this middleware, since we have nearly executed the whole request cycle.
{: .alert .alert-warning }

```php
<?php

use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * ResponseMiddleware
 *
 * @property Response $response
 */
class ResponseMiddleware implements MiddlewareInterface
{
     /**
      * @param Micro $application
      *
      * @returns bool
      */
    public function call(Micro $application)
    {
        $payload = [
            'code'    => 200,
            'status'  => 'success',
            'message' => '',
            'payload' => $application->getReturnedValue(),
        ];

        $application
            ->response
            ->setJsonContent($payload)
            ->send()
        ;

        return true;
    }
}
```

### Models

Models can be used in Micro applications, so long as we instruct the application how it can find the relevant classes with an autoloader.

> **NOTE**: The relevant `db` service must be registered in your DI container.
{: .alert .alert-warning }

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Loader;
use Phalcon\Mvc\Micro;

$loader = new Loader();
$loader
    ->registerDirs(
        [
            __DIR__ . '/models/',
        ]
    )
    ->register();

$app = new Micro();

$app->get(
    '/invoices/find',
    function () {
        $invoices = Invoices::find();

        foreach ($invoices as $invoice) {
            echo $invoice->inv_id, '<br>';
        }
    }
);

$app->handle(
    $_SERVER["REQUEST_URI"]
);
```

### Model injection

By using the [Phalcon\Mvc\Model\Binder](api/phalcon_mvc#mvc-model-binder) class you can inject model instances into your routes:

```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Model\Binder;

$loader = new Loader();

$loader->registerDirs(
    [
        __DIR__ . '/models/',
    ]
)->register();

$app = new Micro();

$app->setModelBinder(
    new Binder()
);

$app->get(
    "/invoices/view/{id:[0-9]+}",
    function (Invoices $id) {
        // ...
    }
);

$app->handle(
    $_SERVER["REQUEST_URI"]
);
```

Since the Binder object is using internally PHP's Reflection API which requires additional CPU cycles, there is an option to set a cache so as to speed up the process. This can be done by using the second argument of `setModelBinder()` which can also accept a service name or just by passing a cache instance to the `Binder` constructor.

Currently the binder will only use the models primary key to perform a `findFirst()` on. An example route for the above would be `/invoices/view/1`.

### Views

[Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) does not have inherently a view service. We can however use the [Phalcon\Mvc\View\Simple](api/phalcon_mvc#mvc-view-simple) component to render views.

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\View\Simple;

$app = new Micro();

$app['view'] = function () {
    $view = new Simple();
    $view->setViewsDir('app/views/');

    return $view;
};

$app->get(
    '/invoices/show',
    function () use ($app) {
        // app/views/invoices/view.phtml
        echo $app['view']
            ->render(
                'invoices/view',
                [
                    'id'         => 4,
                    'customerId' => 3,
                    'title'      => 'Invoice for ACME Inc.',
                    'total'      => 100,
                ]
            )
        ;
    }
);
```

> **NOTE**: The above example uses the [Phalcon\Mvc\View\Simple](api/phalcon_mvc#mvc-view-simple) component, which uses relative paths instead of controllers and actions. You can use the [Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) component instead, but to do so you will need to change the parameters passed to `render()`.
{: .alert .alert-warning }

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\View;

$app['view'] = function () {
    $view = new View();

    $view->setViewsDir('app/views/');

    return $view;
};

$app->get(
    '/invoices/view',
    function () use ($app) {
        // app/views/invoices/view.phtml
        echo $app['view']
            ->render(
                'invoices',
                'view',
                [
                    'id'         => 4,
                    'customerId' => 3,
                    'title'      => 'Invoice for ACME Inc.',
                    'total'      => 100,
                ]
            )
        ;
    }
);
```

## Exceptions

Any exceptions thrown in the [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) component will be of type [Phalcon\Mvc\Micro\Exception](api/phalcon_mvc#mvc-micro-exception). You can use this exception to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Exception;

try {
    $app = new Micro();
    $app->before(false);

    $app->handle(
        $_SERVER["REQUEST_URI"]
    );
} catch (Exception $ex) {
    echo $ex->getMessage();
}
```

### Error Handling

The [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) application also has an `error` method, which can be used to trap any errors that originate from exceptions. The following code snippet shows basic usage of this feature:

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->get(
    '/',
    function () {
        throw new \Exception(
            'Error', 
            401
        );
    }
);

$app->error(
    function ($exception) {
        echo json_encode(
            [
                'code'    => $exception->getCode(),
                'status'  => 'error',
                'message' => $exception->getMessage(),
            ]
        );
    }
);
```