---
layout: default
language: 'ru-ru'
version: '4.0'
---
# Micro Application

* * *

Phalcon offers a very 'thin' application, so that you can create `Micro` applications with minimal PHP code and overhead. Micro applications are suitable for small applications that will have very low overhead. Such applications are usually API ones, prototypes etc.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>Это заказ: {$name}!</h1>";
    }
);

$app->handle();
```

## Creating a Micro Application

The [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) class is the one responsible for creating a Micro application.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();
```

## Routing

Defining routes in a [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application is very easy. Routes are defined as follows:

```text
   Приложение -> (метод/глагол) -> (url адрес/регулярное выражение, вызываемая функция PHP)
```

### Setup

Routing is handled by the [Phalcon\Mvc\Router](api/Phalcon_Mvc_Router) object. [[Info](routing)]

> Routes must always start with `/`
{: .alert .alert-warning }

Usually, the starting route in an application is the route `/`, and in most cases it is accessed via the GET HTTP method:

```php
<?php

// Это стартовый маршрут
$app->get(
    '/',
    function () {
        echo '<h1>Welcome!</h1>';
    }
);
```

#### Application object

Routes can be set using the [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application object as follows:

```php
use Phalcon\Mvc\Micro;

$app = new Micro();

// Соответствия для GET запроса
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
);
```

#### Router object

You can also create a [Phalcon\Mvc\Router](api/Phalcon_Mvc_Router) object, setting the routes there and then injecting it in the dependency injection container.

```php
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Router;

$router = new Router();

$router->addGet(
    '/orders/display/{name}',
    'OrdersClass::display';
    }
);


$app = new Micro();
$app->setService('router', $router, true);
```

Setting up your routes using the [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) applications verb methods (`get`, `post`, etc.) is much easier than setting up a router object with relevant routes and then injecting it in the application.

Each method has its advantages and disadvantages. It all depends on the design and needs of your application.

### Rewrite Rules

In order for routes to work, certain configuration changes need to be made in your web server's configuration for your particular site.

Those changes are outlined in the [rewrite rules](rewrite-rules).

### Handlers

Handlers are callable pieces of code that get attached to a route. When the route is matched, the handler is executed with all the defined parameters. A handler is any callable piece of code that exists in PHP.

#### Definitions

Phalcon offers several ways to attach a handler to a route. Your application needs and design as well as coding style will be the factors influencing your choice of implementation.

##### Anonymous Function

Finally we can use an anonymous function (as seen above) to handle the request

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>Это заказ: {$name}!</h1>";
    }
);
```

Accessing the `$app` object inside the anonymous function can be achieved by injecting it as follows:

```php
$app->get(
    '/orders/display/{name}',
    function ($name) use ($app) {
        $context = "<h1>This is order: {$name}!</h1>";
        $app->response->setContext($context);
        $app->response->send();
    }
);
```

##### Function

We can define a function as our handler and attach it to a specific route.

```php
// Определение функции
function order_display($name) {
    echo "<h1>Это заказа: {$name}!</h1>";
}

$app->get(
    '/orders/display/{name}',
    'orders_display'
);
```

##### Static Method

We can also use a static method as our handler as follows:

```php
class OrdersClass
{
    public static function display($name) {
        echo "<h1>Это заказ: {$name}!</h1>";
    }
}

$app->get(
    '/orders/display/{name}',
    'OrdersClass::display'
);
```

##### Method in an Object

We can also use a method in an object:

```php
class OrdersClass
{
    public function display($name) {
        echo "<h1>Это заказ: {$name}!</h1>";
    }
}

$orders = new OrdersClass();
$app->get(
    '/orders/display/{name}',
    [
        $orders,
        'display',
    ]
);
```

##### Controllers

With the [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) you can create micro or medium applications. Medium applications use the micro architecture but expand on it to utilize more than the Micro but less than the Full application.

In medium applications you can organize handlers in controllers.

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

$orders = new MicroCollection();

// Установка главного обработчика, т.е. экземпляра контроллера
$orders->setHandler(new OrdersController());

// Установка основного префикса для всех маршрутов
$orders->setPrefix('/orders');

// Использовать метод 'index' контроллера OrdersController
$orders->get('/', 'index');

// Использовать метод 'show' контроллера OrdersController
$orders->get('/display/{slug}', 'show');

$app->mount($orders);
```

The `OrdersController` might look like this:

```php
<?php

use Phalcon\Mvc\Controller;

class OrdersController extends Controller
{
    public function index()
    {
        // ...
    }

    public function show($name)
    {
        // ...
    }
}
```

Since our controllers extend the [Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller), all the dependency injection services are available with their respective registration names. For example:

```php
<?php

use Phalcon\Mvc\Controller;

class OrdersController extends Controller
{
    public function index()
    {
        // ...
    }

    public function show($name)
    {
        $context = "<h1>This is order: {$name}!</h1>";
        $this->response->setContext($context);

        return $this->response;
    }
}
```

#### Lazy Loading

In order to increase performance, you might consider implementing lazy loading for your controllers (handlers). The controller will be loaded only if the relevant route is matched.

Lazy loading can be easily achieved when setting your handler in your [Phalcon\Mvc\Micro\Collection](api/Phalcon_Mvc_Micro_Collection):

```php
$orders->setHandler('OrdersController', true);
$orders->setHandler('Blog\Controllers\OrdersController', true);
```

##### Use case

We are developing an API for an online store. The endpoints are `/users`, `/orders` and `/products`. Each of those endpoints are registered using handlers, and each handler is a controller with relevant actions.

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

class OrdersController extends Controller
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

// Обработчик Users
$users = new MicroCollection();
$users->setHandler(new UsersController());
$users->setPrefix('/users');
$users->get('/get/{id}
', 'get');
$users->get('/add/{payload}
', 'add');
$app->mount($users);

// Обработчик Orders
$orders = new MicroCollection();
$orders->setHandler(new OrdersController());
$orders->setPrefix('/users');
$orders->get('/get/{id}
', 'get');
$orders->get('/add/{payload}', 'add');
$app->mount($orders);

// Обработчик Products
$products = new MicroCollection();
$products->setHandler(new ProductsController());
$products->setPrefix('/products');
$products->get('/get/{id}
', 'get');
$products->get('/add/{payload}', 'add');
$app->mount($products);
```

This implementation loads each handler in turn and mounts it in our application object. The issue with this approach is that each request will result to only one endpoint and therefore one class method executed. The remaining methods/handlers will just remain in memory without being used.

Using lazy loading we reduce the number of objects loaded in memory and as a result our application uses less memory.

The above implementation changes if we want to use lazy loading as follows:

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

// Users handler
$users = new MicroCollection();
$users->setHandler(new UsersController(), true);
$users->setPrefix('/users');
$users->get('/get/{id}', 'get');
$users->get('/add/{payload}', 'add');
$app->mount($users);

// Orders handler
$orders = new MicroCollection();
$orders->setHandler(new OrdersController(), true);
$orders->setPrefix('/users');
$orders->get('/get/{id}', 'get');
$orders->get('/add/{payload}', 'add');
$app->mount($orders);

// Products handler
$products = new MicroCollection();
$products->setHandler(new ProductsController(), true);
$products->setPrefix('/products');
$products->get('/get/{id}', 'get');
$products->get('/add/{payload}', 'add');
$app->mount($products);
```

Using this simple change in implementation, all handlers remain uninstantiated until requested by a caller. Therefore whenever a caller requests `/orders/get/2`, our application will instantiate the `OrdersController` and call the `get` method in it. Our application now uses less resources than before.

#### Not found (404)

Any route that has not been matched in our [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application will cause it to try and execute the handler defined with the `notFound` method. Similar to other methods/verbs (`get`, `post` etc.), you can register a handler in the `notFound` method which can be any callable PHP function.

```php
<?php

$app->notFound(
    function () use ($app) {
        $app->response->setStatusCode(404, 'Не найдено');
        $app->response->sendHeaders();

        $message = 'Не на что здесь смотреть. Продолжаем....';
        $app->response->setContent($message);
        $app->response->send();
    }
);
```

You can also handle routes that have not been matched (404) with Middleware discussed below.

### Methods - Verbs

The [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application provides a set of methods to bind the HTTP method with the route it is intended to.

#### delete

Matches if the HTTP method is `DELETE` and the route is `/api/products/delete/{id}`

```php
    $app->delete(
        '/api/products/delete/{id}',
        'delete_product'
    );
```

#### get

Matches if the HTTP method is `GET` and the route is `/api/products`

```php
    $app->get(
        '/api/products',
        'get_products'
    );
```

#### head

Matches if the HTTP method is `HEAD` and the route is `/api/products`

```php
    $app->get(
        '/api/products',
        'get_products'
    );
```

#### map

Map allows you to attach the same endpoint to more than one HTTP method. The example below matches if the HTTP method is `GET` or `POST` and the route is `/repos/store/refs`

```php
    $app
        ->map(
            '/repos/store/refs',
            'action_product'
        )
        ->via(
            [
                'GET',
                'POST',
            ]
        );
```

#### options

Matches if the HTTP method is `OPTIONS` and the route is `/api/products/options`

```php
    $app->options(
        '/api/products/options',
        'info_product'
    );
```

#### patch

Matches if the HTTP method is `PATCH` and the route is `/api/products/update/{id}`

```php
    $app->patch(
        '/api/products/update/{id}',
        'update_product'
    );
```

#### post

Matches if the HTTP method is `POST` and the route is `/api/products/add`

```php
    $app->post(
        '/api/products',
        'add_product'
    );
```

#### put

Matches if the HTTP method is `PUT` and the route is `/api/products/update/{id}`

```php
    $app->put(
        '/api/products/update/{id}',
        'update_product'
    );
```

### Collections

Collections are a handy way to group collections attached to a handler and a common prefix (if needed). For a hypothetical `/orders` endpoint we could have the following endpoints:

```text
/orders/get/{id}
/orders/add/{payload}
/orders/update/{id}
/orders/delete/{id}
```

All of those routes are handled by our `OrdersController`. We set up our routes with a collection as follows:

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

$orders = new MicroCollection();
$orders->setHandler(new OrdersController());

$orders->setPrefix('/orders');

$orders->get('/get/{id}', 'displayAction');
$orders->get('/add/{payload}', 'addAction');
$orders->get('/update/{id}', 'updateAction');
$orders->get('/delete/{id}', 'deleteAction');

$app->mount($orders);
```

> The name that we bind each route has a suffix of `Action`. This is not necessary, your method can be called anything you like.
{: .alert .alert-warning }

### Parameters

We have briefly seen above how parameters are defined in the routes. Parameters are set in a route string by enclosing the name of the parameter in brackets.

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>Это заказ: {$name}!</h1>";
    }
);
```

We can also enforce certain rules for each parameter by using regular expressions. The regular expression is set after the name of the parameter, separating it with `:`.

```php
// Сопоставить order id
$app->get(
    '/orders/display/{id:[0-9]+}',
    function ($id) {
        echo "<h1>This is order: #{$id}!</h1>";
    }
);

// Сопоставить год (4 числа) и заголовок (буквы)
$app->get(
    '/posts/{year:[0-9][4]}/{title:[a-zA-Z\-]+}',
    function ($year, $title) {
        echo '<h1>Заголовок: $title</h1>';
        echo '<h2>Год: $year</h2>';
    }
);
```

Additional information: [Phalcon\Mvc\Router](api/Phalcon_Mvc_Router) [Info](routing)

### Redirections

You can redirect one matched route to another using the [Phalcon\Http\Response](api/Phalcon_Http_Response) object, just like in a full application.

```php
$app->post('/old/url',
    function () use ($app) {
        $app->response->redirect('new/url');
        $app->response->sendHeaders();
    }
);

$app->post('/new/welcome',
    function () use ($app) {
        echo 'This is the new Welcome';
    }
);
```

**Note** we have to pass the `$app` object in our anonymous function to have access to the `request` object.

When using controllers as handlers, you can perform the redirect just as easy:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function oldget($id)
    {
        return $this->response->redirect('users/get/' . $id);
    }

    public function get($id)
    {
        // ...
    }
}
```

Finally, you can perform redirections in your middleware (if you are using it). An example is below in the relevant section.

### URLs for Routes

Another feature of the routes is setting up named routes and generating URLs for those routes. This is a two step process. * First we need to name our route. This can be achieved with the `setName()` method that is exposed from the methods/verbs in our application (`get`, `post`, etc.);

```php
// Задать маршрут с именем 'show-order'
$app
    ->get(
        '/orders/display/{id}',
        function ($id) use ($app) {
            // ... Найти заказ и показать его
        }
    )
    ->setName('show-order');
```

* We need to use the [Phalcon\Url](api/Phalcon_Url) component to generate URLs for the named routes.

```php
// Используем именованный маршрут и создаем URL от него
$app->get(
    '/',
    function () use ($app) {
        $url = sprintf(
            '<a href="%s">Show the order</a>',
            $app->url->get(
                [
                    'for' => 'show-order',
                    'id'  => 1234,
                ]
            )
        );

        echo $url;
    }
);
```

## Dependency Injector

When a micro application is created, a [Phalcon\Di\FactoryDefault](api/Phalcon_Di_FactoryDefault) services container is create implicitly.

```php
<?php

use Phalcon\Mvc\Micro;
$app = new Micro();

$app->get(
    '/',
    function () use ($app) {
        $app->response->setContent('Hello!!');
        $app->response->send();
    }
);
```

You can also create a Di container yourself, and assign it to the micro application, therefore manipulating the services depending on the needs of your application.

```php
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Config\Adapter\Ini as IniConfig;

$di = new FactoryDefault();

$di->set(
    'config',
    function () {
        return new IniConfig('config.ini');
    }
);

$app = new Micro();

$app->setDI($di);

$app->get(
    '/',
    function () use ($app) {
        // Читаем настройки из конфига
        echo $app->config->app_name;
    }
);

$app->post(
    '/contact',
    function () use ($app) {
        $app->flash->success('Что ты делаешь Дэйв?');
    }
);
```

You can also use the array syntax to register services in the dependency injection container from the application object:

```php
<br /><?php

use Phalcon\Mvc\Micro;
use Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter;

$app = new Micro();

// Настройка сервиса базы данных
$app['db'] = function () {
    return new MysqlAdapter(
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
        $news = $app['db']->query('SELECT * FROM news');

        foreach ($news as $new) {
            echo $new->title;
        }
    }
);
```

## Responses

A micro application can return many different types of responses. Direct output, use a template engine, calculated data, view based data, JSON etc.

Handlers may return raw responses using plain text, [Phalcon\Http\Response](api/Phalcon_Http_Response) object or a custom built component that implements the [Phalcon\Http\ResponseInterface](api/Phalcon_Http_ResponseInterface).

### Direct output

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>Это заказ: {$name}!</h1>";
    }
);
```

### Including another file

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        require 'views/results.php';
    }
);
```

### Direct output JSON

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo json_encode(
            [
                'code' => 200,
                'name' => $name,
            ]
        );
    }
);
```

### New Response object

You can use the `setContent` method of the response object to return the response back:

```php
$app->get(
    '/show/data',
    function () {
        // Создание ответа
        $response = new Phalcon\Http\Response();

        // Установка заголовка Content-Type
        $response->setContentType('text/plain');

        // Передача контента из файла
        $response->setContent(file_get_contents('data.txt'));

        // Возврат ответа
        return $response;
    }
);
```

### Application Response

You can also use the [Phalcon\Http\Response](api/Phalcon_Http_Response) object to return responses to the caller. The response object has a lot of useful methods that make returning respones much easier.

```php
$app->get(
    '/show/data',
    function () use ($app) {
        // Установка заголовка Content-Type
        $app->response->setContentType('text/plain');
        $app->response->sendHeaders();

        // Вывод файла
        readfile('data.txt');
    }
);
```

### Return Application Response

A different approach returning data back to the caller is to return the response object directly from the application. When responses are returned by handlers they are automatically sent by the application.

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;

$app = new Micro();

// Возврат объекта Response
$app->get(
    '/welcome/index',
    function () {
        $response = new Response();

        $response->setStatusCode(401, 'Не авторизован');
        $response->setContent('Доступ не авторизован');

        return $response;
    }
);
```

### JSON

JSON can be sent back just as easy using the [Phalcon\Http\Response](api/Phalcon_Http_Response) object:

```php
$app->get(
    '/welcome/index',
    function () use ($app) {

        $data = [
            'code'    => 401,
            'status'  => 'error',
            'message' => 'Не авторизированный доступ',
            'payload' => [],
        ];

        $response->setJsonContent($data);

        return $response;
    }
);
```

## Events

A [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application works closely with a [Phalcon\Events\Manager](api/Phalcon_Events_Manager) if it is present, to trigger events that can be used throughout our application. The type of those events is `micro`. These events trigger in our application and can be attached to relevant handlers that will perform actions needed by our application.

### Available events

Поддерживаются следующие типы событий:

| Название события   | Срабатывает                                                                  | Можно остановить операцию? |
| ------------------ | ---------------------------------------------------------------------------- |:--------------------------:|
| beforeHandleRoute  | Основной метод вызван; Маршруты еще не проверены                             |             Да             |
| beforeExecuteRoute | Маршрут сопоставлен, обработчик верный, но еще не выполнен                   |             Да             |
| afterExecuteRoute  | Обработчик только что закончил работать                                      |            Нет             |
| beforeNotFound     | Маршрут не найден                                                            |             Да             |
| afterHandleRoute   | Маршрут только что закончил выполнение                                       |             Да             |
| afterBinding       | Срабатывает после того, как модели связаны, но перед выполнением обработчика |             Да             |

### Authentication example

You can easily check whether a user has been authenticated or not using the `beforeExecuteRoute` event. In the following example, we explain how to control the application security using events:

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// Создаем менеджер событий
$eventsManager = new EventsManager();

$eventsManager->attach(
    'micro:beforeExecuteRoute',
    function (Event $event, $app) {
        if ($app->session->get('auth') === false) {
            $app->flashSession->error("The user isn't authenticated");

            $app->response->redirect('/');
            $app->response->sendHeaders();

            // Возврат (false) останавливает операцию
            return false;
        }
    }
);

$app = new Micro();

// Привязываем менеджер событий к приложению
$app->setEventsManager($eventsManager);
```

### Not found example

You can easily check whether a user has been authenticated or not using the `beforeExecuteRoute` event. In the following example, we explain how to control the application security using events:

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// Создаем менеджер событий
$eventsManager = new EventsManager();

$eventsManager->attach(
    'micro:beforeNotFound',
    function (Event $event, $app) {
        $app->response->redirect('/404');
        $app->response->sendHeaders();

        return $app->response;
    }
);

$app = new Micro();

// Привязываем менеджер событий к приложению
$app->setEventsManager($eventsManager);
```

## Middleware

Middleware are classes that can be attached to your application and introduce another layer where business logic can exist. They run sequentially, according to the order they are registered and not only improve mainainability, by encapsulating specific functionality, but also performance. A middleware class can stop execution when a particular business rule has not been satisfied, thus allowing the application to exit early without executing the full cycle of a request.

The presence of a [Phalcon\Events\Manager](api/Phalcon_Events_Manager) is essential for middleware to operate, so it has to be registered in our Di container.

### Attached events

Middleware can be attached to a micro application in 3 different events. Those are:

| Событие  | Описание                                        |
| -------- | ----------------------------------------------- |
| `before` | Перед выполнением обработчика                   |
| `after`  | После выполнения обработчика                    |
| `finish` | После того, как был отправлен ответ вызывающему |

> You can attach as many middleware classes as you want in each of the above events. They will be executed sequentially when the relevant event fires.
{: .alert .alert-warning }

#### before

This event is perfect for stopping execution of the application if certain criteria is not met. In the below example we are checking if the user has been authenticated and stop execution with the necessary redirect.

```php
<?php

$app = new Phalcon\Mvc\Micro();

// Вызывается перед выполнением каждого маршрута
// Возврат false отменяет выполнение маршрута
$app->before(
    function () use ($app) {
        if (false === $app['session']->get('auth')) {
            $app['flashSession']->error("Пользователь не авторизован");

            $app['response']->redirect('/error');

            // Возврат false останавливает нормальное выполнение
            return false;
        }

        return true;
    }
);
```

#### after

This event can be used to manipulate data or perform actions that are needed after the handler has finished executing. In the example below, we manipulate our response to send JSON back to the caller.

```php
$app->map(
    '/api/robots',
    function () {
        return [
            'status' => 'OK',
        ];
    }
);

$app->after(
    function () use ($app) {
        // This is executed after the route is executed
        echo json_encode($app->getReturnedValue());
    }
);
```

#### finish

This even will fire up when the whole request cycle has been completed. In the example below, we use it to clean up some cache files.

```php
$app->finish(
    function () use ($app) {
        if (true === file_exists('/tmp/processing.cache')) {
            unlink('/tmp/processing.cache');
        }
    }
);
```

### Setup

Attaching middleware to your application is very easy as shown above, with the `before`, `after` and `finish` method calls.

```php
$app->before(
    function () use ($app) {
        if (false === $app['session']->get('auth')) {
            $app['flashSession']->error("The user isn't authenticated");

            $app['response']->redirect('/error');

            // Return false stops the normal execution
            return false;
        }

        return true;
    }
);

$app->after(
    function () use ($app) {
        // This is executed after the route is executed
        echo json_encode($app->getReturnedValue());
    }
);
```

Attaching middleware to your application as classes and having it listen to events from the events manager can be achieved as follows:

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
$eventsManager = new Manager();
$application   = new Micro();

/**
 * Прикрепляем middleware к менеджеру событий и приложению 
*/
$eventsManager->attach('micro', new CacheMiddleware());
$application->before(new CacheMiddleware());

$eventsManager->attach('micro', new NotFoundMiddleware());
$application->before(new NotFoundMiddleware());

/**
 * Этот нужен, чтобы слушать событие `after`
 */
$eventsManager->attach('micro', new ResponseMiddleware());
$application->after(new ResponseMiddleware());

/**
 * Убедимся, что наш менеджер событий теперь находится в DI контейнере
 */
$application->setEventsManager($eventsManager);

```

We need a [Phalcon\Events\Manager](api/Phalcon_Events_Manager) object. This can be a newly instantiated object or we can get the one that exists in our DI container (if you have used the `FactoryDefault` one).

We attach every middleware class in the `micro` hook in the Events Manager. We could also be a bit more specific and attach it to say the `micro:beforeExecuteRoute` event.

We then attach the middleware class in our application on one of the three listening events discussed above (`before`, `after`, `finish`).

### Implementation

Middleware can be any kind of PHP callable functions. You can organize your code whichever way you like it to implement middleware. If you choose to use classes for your middleware, you will need them to implement the [Phalcon\Mvc\Micro\MiddlewareInterface](api/Phalcon_Mvc_Micro_MiddlewareInterface)

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * CacheMiddleware
 *
 * Caches pages to reduce processing
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

        $key = preg_replace('/^[a-zA-Z0-9]/', '', $router->getRewriteUri());

        // Check if the request is cached
        if ($cache->exists($key)) {
            echo $cache->get($key);

            return false;
        }

        return true;
    }
}
```

### Events in Middleware

The [events](#events) that are triggered for our application also trigger inside a class that implements the [Phalcon\Mvc\Micro\MiddlewareInterface](api/Phalcon_Mvc_Micro_MiddlewareInterface). This offers great flexibility and power for developers since we can interact with the request process.

#### API example

Assume that we have an API that we have implemented with the Micro application. We will need to attach different Middleware classes in the application so that we can better control the execution of the application.

The middleware that we will use are: * Firewall * NotFound * Redirect * CORS * Request * Response

#### Firewall Middleware

This middleware is attached to the `before` event of our Micro application. The purpose of this middleware is to check who is calling our API and based on a whitelist, allow them to proceed or not

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * FirewallMiddleware
 *
 * Checks the whitelist and allows clients or not
 */
class FirewallMiddleware implements MiddlewareInterface
{
    /**
     * Before anything happens
     *
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeHandleRoute(Event $event, Micro $application)
    {
        $whitelist = [
            '10.4.6.1',
            '10.4.6.2',
            '10.4.6.3',
            '10.4.6.4',
        ];
        $ipAddress = $application->request->getClientAddress();

        if (true !== array_key_exists($ipAddress, $whitelist)) {
            $this->response->redirect('/401');
            $this->response->send();

            return false;
        }

        return true;
    }

    /**
     * Calls the middleware
     *
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

#### Not Found Middleware

When this middleware is processed, this means that the requesting IP is allowed to access our application. The application will try and match the route and if not found the `beforeNotFound` event will fire. We will stop the processing then and send back to the user the relevant 404 response. This middleware is attached to the `before` event of our Micro application

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * NotFoundMiddleware
 *
 * Обрабатывает 404
 */
class NotFoundMiddleware implements MiddlewareInterface
{
    /**
     * Маршрут не был найден
     *
     * @returns bool
     */
    public function beforeNotFound()
    {
        $this->response->redirect('/404');
        $this->response->send();

        return false;
    }

    /**
     * Вызывает middleware
     *
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

#### Redirect Middleware

We attach this middleware again to the `before` event of our Micro application because we don't want the request to proceed if the requested endpoint needs to be redirected.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * RedirectMiddleware
 *
 * Проверяет запрос и перенаправляет пользователя куда-нибудь еще, если необходимо
 */
class RedirectMiddleware implements MiddlewareInterface
{
    /**
     * Прежде чем что-то произойдет
     *
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeHandleRoute(Event $event, Micro $application)
    {
        if ('github' === $application->request->getURI()) {
            $application->response->redirect('https://github.com');
            $application->response->send();

            return false;
        }

        return true;
    }

    /**
     * Вызывает middleware
     *
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
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * CORSMiddleware
 *
 * Проверка CORS
 */
class CORSMiddleware implements MiddlewareInterface
{
    /**
     * Прежде, чем что-нибудь случится
     *
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeHandleRoute(Event $event, Micro $application)
    {
        if ($application->request->getHeader('ORIGIN')) {
            $origin = $application->request->getHeader('ORIGIN');
        } else {
            $origin = '*';
        }

        $application
            ->response
            ->setHeader('Access-Control-Allow-Origin', $origin)
            ->setHeader(
                'Access-Control-Allow-Methods',
                'GET,PUT,POST,DELETE,OPTIONS'
            )
            ->setHeader(
                'Access-Control-Allow-Headers',
                'Origin, X-Requested-With, Content-Range, ' .
                'Content-Disposition, Content-Type, Authorization'
            )
            ->setHeader('Access-Control-Allow-Credentials', 'true');
    }

    /**
     * Вызывает middleware
     *
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

#### Request Middleware

This middleware is receiving a JSON payload and checks it. If the JSON payload is not valid it will stop execution.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * RequestMiddleware
 *
 * Check incoming payload
 */
class RequestMiddleware implements MiddlewareInterface
{
    /**
     * Before the route is executed
     *
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeExecuteRoute(Event $event, Micro $application)
    {
        json_decode($application->request->getRawBody());
        if (JSON_ERROR_NONE !== json_last_error()) {
            $application->response->redirect('/malformed');
            $application->response->send();

            return false;
        }

        return true;

    }

    /**
     * Calls the middleware
     *
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

#### Response Middleware

This middleware is responsible for manipulating our response and sending it back to the caller as a JSON string. Therefore we need to attach it to the `after` event of our Micro application.

> We are going to be using the `call` method for this middleware, since we have nearly executed the whole request cycle.
{: .alert .alert-warning }

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
* ResponseMiddleware
*
* Изменяет ответ
*/
class ResponseMiddleware implements MiddlewareInterface
{
     /**
      * Прежде, чем что-нибудь случится
      *
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

        $application->response->setJsonContent($payload);
        $application->response->send();

        return true;
    }
}
```

### Models

Models can be used in Micro applications, so long as we instruct the application how it can find the relevant classes with an autoloader.

> The relevant `db` service must be registered in your Di container.
{: .alert .alert-warning }

```php
<?php

$loader = new \Phalcon\Loader();
$loader
    ->registerDirs(
        [
            __DIR__ . '/models/',
        ]
    )
    ->register();

$app = new \Phalcon\Mvc\Micro();

$app->get(
    '/products/find',
    function () {
        $products = \MyModels\Products::find();

        foreach ($products as $product) {
            echo $product->name, '<br>';
        }
    }
);

$app->handle();
```

### Inject model instances

By using the [Phalcon\Mvc\Model\Binder](api/Phalcon_Mvc_Model_Binder) class you can inject model instances into your routes:

```php
<?php

$loader = new \Phalcon\Loader();

$loader->registerDirs(
    [
        __DIR__ . '/models/',
    ]
)->register();

$app = new \Phalcon\Mvc\Micro();
$app->setModelBinder(new \Phalcon\Mvc\Model\Binder());

$app->get(
    "/products/{product:[0-9]+}",
    function (Products $product) {
        // do anything with $product object
    }
);

$app->handle();
```

Since Binder object is using internally Reflection Api which can be heavy, there is ability to set a cache so as to speed up the process. This can be done by using the second argument of `setModelBinder()` which can also accept a service name or just by passing a cache instance to the `Binder` constructor.

Currently the binder will only use the models primary key to perform a `findFirst()` on. An example route for the above would be `/products/1`.

### Views

[Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) does not have inherently a view service. We can however use the [Phalcon\Mvc\View\Simple](api/Phalcon_Mvc_View_Simple) component to render views.

```php
<?php

$app = new Phalcon\Mvc\Micro();

$app['view'] = function () {
    $view = new \Phalcon\Mvc\View\Simple();

    $view->setViewsDir('app/views/');

    return $view;
};

// Вернуть отображенный вид
$app->get(
    '/products/show',
    function () use ($app) {
        // Отобразить app/views/products/show.phtml с передачей некоторых переменных
        echo $app['view']->render(
            'products/show',
            [
                'id'   => 100,
                'name' => 'Artichoke',
            ]
        );
    }
);
```

> The above example uses the [Phalcon\Mvc\View\Simple](api/Phalcon_Mvc_View_Simple) component, which uses relative paths instead of controllers and actions. You can use the [Phalcon\Mvc\View](api/Phalcon_Mvc_View) component instead, but to do so you will need to change the parameters passed to `render()`.
{: .alert .alert-warning }

```php
<?php

$app = new Phalcon\Mvc\Micro();

$app['view'] = function () {
    $view = new \Phalcon\Mvc\View();

    $view->setViewsDir('app/views/');

    return $view;
};

// Вернуть отображенный вид
$app->get(
    '/products/show',
    function () use ($app) {
        // Отображаем app/views/products/show.phtml с передачей некоторых переменных
        echo $app['view']->render(
            'products',
            'show',
            [
                'id'   => 100,
                'name' => 'Artichoke',
            ]
        );
    }
);
```

### Error Handling

The [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application also has an `error` method, which can be used to trap any errors that originate from exceptions. The following code snippet shows basic usage of this feature:

```php
<?php

$app = new Phalcon\Mvc\Micro();

$app->get(
    '/',
    function () {
        throw new \Exception('Произошла ошибка', 401);
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