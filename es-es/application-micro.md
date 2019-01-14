* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

# Micro Aplicaciones

Phalcon ofrece una aplicación muy 'fina', para que pueda crear 'Micro' aplicaciones con un mínimo de código PHP.

Las Micro Aplicaciones son convenientes para aplicaciones pequeñas que van a tener un uso muy ligero. Such applications are for instance our `[website](https://github.com/phalcon/website), this website ([docs](https://github.com/phalcon/docs)), our [store](https://github.com/phalcon/store), APIs, prototypes etc.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
);

$app->handle();
```

<a name='creating-micro-applications'></a>

## Creando una Micro Aplicación

The [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) class is the one responsible for creating a Micro application.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();
```

<a name='routing'></a>

## Ruteo

Defining routes in a [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application is very easy. Routes are defined as follows:

```text
   Aplicación -> (método/verbo) -> (url de la ruta/expresión regular, función PHP de llamada)
```

<a name='routing-setup'></a>

### Configuración

Routing is handled by the [Phalcon\Mvc\Router](api/Phalcon_Mvc_Router) object. [[Info](/4.0/en/routing)]

<h5 class='alert alert-warning'>Routes must always start with <code>/</code></h5>

Usually, the starting route in an application is the route `/`, and in most cases it is accessed via the GET HTTP method:

```php
<?php

// Esta es la ruta inicial
$app->get(
    '/',
    function () {
        echo '<h1>Welcome!</h1>';
    }
);
```

<a name='routing-setup-application'></a>

### El Objeto de la Aplicación

Routes can be set using the [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application object as follows:

```php
use Phalcon\Mvc\Micro;

$app = new Micro();

// Captura consultas GET 
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
);
```

<a name='routing-setup-router'></a>

### El Objeto Ruoter

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

<a name='rewrite-rules'></a>

## Reglas de reescritura

In order for routes to work, certain configuration changes need to be made in your web server's configuration for your particular site.

Those changes are outlined in the [rewrite rules](/4.0/en/rewrite-rules).

<a name='routing-handlers'></a>

## Manejadores

Handlers are callable pieces of code that get attached to a route. Cuando una ruta es igualada, el manejador es ejecutado con todos los parámetros definidos. A handler is any callable piece of code that exists in PHP.

<a name='routing-handlers-definitions'></a>

### Definiciones

Phalcon offers several ways to attach a handler to a route. Your application needs and design as well as coding style will be the factors influencing your choice of implementation.

<a name='routing-handlers-anonymous-function'></a>

#### Funciones anónimas

Finally we can use an anonymous function (as seen above) to handle the request

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
);
```

Acceder al objeto `$app` dentro de la función anónima puede lograrse mediante la inyección de esta, de la siguiente manera:

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

<a name='routing-handlers-function'></a>

#### Funciones

We can define a function as our handler and attach it to a specific route.

```php
// Con una función
function order_display($name) {
    echo "<h1>This is order: {$name}!</h1>";
}

$app->get(
    '/orders/display/{name}',
    'orders_display'
);
```

<a name='routing-handlers-static-method'></a>

#### Método estático

También podemos usar un método estático como nuestro gestor, como se muestra a continuación:

```php
class OrdersClass
{
    public static function display($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
}

$app->get(
    '/orders/display/{name}',
    'OrdersClass::display'
);
```

<a name='routing-handlers-object-method'></a>

#### Método en un objeto

We can also use a method in an object:

```php
class OrdersClass
{
    public function display($name) {
        echo "<h1>This is order: {$name}!</h1>";
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

<a name='routing-handlers-controllers'></a>

#### Controladores

With the [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) you can create micro or medium applications. Medium applications use the micro architecture but expand on it to utilize more than the Micro but less than the Full application.

En aplicaciones medianas puedes organizar los manejadores en los controladores.

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

$orders = new MicroCollection();

// Establece el manejador principal. Por ejemplo, la instancia de un controlador
$orders->setHandler(new OrdersController());

// Establece un prefijo común para todas la rutas
$orders->setPrefix('/orders');

// Usa el método 'index' en OrdersController
$orders->get('/', 'index');

// Usa el método 'show' en OrdersController
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

Since our controllers extend the [Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller), all the dependency injection services are available with their respective registration names. Por ejemplo:

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

<a name='routing-handlers-controllers-lazy-loading'></a>

### Carga perezosa (Lazy Load)

Con el fin de aumentar el rendimiento, podrías considerar aplicar la Carga Perezosa (Lazy Load) para tus controladores (handlers). El controlador será cargado solamente si la ruta pertinente es vinculada.

Lazy loading can be easily achieved when setting your handler in your [Phalcon\Mvc\Micro\Collection](api/Phalcon_Mvc_Micro_Collection):

```php
$orders->setHandler('OrdersController', true);
$orders->setHandler('Blog\Controllers\OrdersController', true);
```

<a name='routing-handlers-controllers-lazy-loading-use-case'></a>

#### Casos de uso

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

// Manejador Users
$users = new MicroCollection();
$users->setHandler(new UsersController());
$users->setPrefix('/users');
$users->get('/get/{id}', 'get');
$users->get('/add/{payload}', 'add');
$app->mount($users);

// Manejador Orders
$orders = new MicroCollection();
$orders->setHandler(new OrdersController());
$orders->setPrefix('/users');
$orders->get('/get/{id}', 'get');
$orders->get('/add/{payload}', 'add');
$app->mount($orders);

// Manejador Products
$products = new MicroCollection();
$products->setHandler(new ProductsController());
$products->setPrefix('/products');
$products->get('/get/{id}', 'get');
$products->get('/add/{payload}', 'add');
$app->mount($products);
```

Esta implementación carga cada controlador a su vez y lo monta en nuestro objeto de aplicación. The issue with this approach is that each request will result to only one endpoint and therefore one class method executed. Los métodos/manejadores restantes sólo permanecerán en la memoria sin ser utilizados.

Using lazy loading we reduce the number of objects loaded in memory and as a result our application uses less memory.

La implementación anterior cambia si queremos usar la carga perezosa de la siguiente manera:

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

<a name='routing-handlers-not-found'></a>

### No encontrado (404)

Any route that has not been matched in our [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application will cause it to try and execute the handler defined with the `notFound` method. Similar to other methods/verbs (`get`, `post` etc.), you can register a handler in the `notFound` method which can be any callable PHP function.

```php
<?php

$app->notFound(
    function () use ($app) {
        $app->response->setStatusCode(404, 'Not Found');
        $app->response->sendHeaders();

        $message = 'Nothing to see here. Move along....';
        $app->response->setContent($message);
        $app->response->send();
    }
);
```

You can also handle routes that have not been matched (404) with Middleware discussed below.

<a name='routing-verbs'></a>

## Métodos - verbos

The [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application provides a set of methods to bind the HTTP method with the route it is intended to.

<a name='routing-verbs-delete'></a>

### delete

Matches if the HTTP method is `DELETE` and the route is `/api/products/delete/{id}`

```php
    $app->delete(
        '/api/products/delete/{id}',
        'delete_product'
    );
```

<a name='routing-verbs-get'></a>

### get

Matches if the HTTP method is `GET` and the route is `/api/products`

```php
    $app->get(
        '/api/products',
        'get_products'
    );
```

<a name='routing-verbs-head'></a>

### head

Matches if the HTTP method is `HEAD` and the route is `/api/products`

```php
    $app->get(
        '/api/products',
        'get_products'
    );
```

<a name='routing-verbs-map'></a>

### map

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

<a name='routing-verbs-options'></a>

### options

Matches if the HTTP method is `OPTIONS` and the route is `/api/products/options`

```php
    $app->options(
        '/api/products/options',
        'info_product'
    );
```

<a name='routing-verbs-patch'></a>

### patch

Matches if the HTTP method is `PATCH` and the route is `/api/products/update/{id}`

```php
    $app->patch(
        '/api/products/update/{id}',
        'update_product'
    );
```

<a name='routing-verbs-post'></a>

### post

Coincide si el método HTTP es `POST` y la ruta es `/api/products/add`

```php
    $app->post(
        '/api/products',
        'add_product'
    );
```

<a name='routing-verbs-put'></a>

### put

Matches if the HTTP method is `PUT` and the route is `/api/products/update/{id}`

```php
    $app->put(
        '/api/products/update/{id}',
        'update_product'
    );
```

<a name='routing-collections'></a>

## Colecciones

Collections are a handy way to group collections attached to a handler and a common prefix (if needed). For a hypothetical `/orders` endpoint we could have the following endpoints:

    /orders/get/{id}
    /orders/add/{payload}
    /orders/update/{id}
    /orders/delete/{id}
    

Todas estas rutas son manejadas por nuestro `OrdersController`. Hemos establecido nuestras rutas con una colección de la siguiente manera:

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

<h5 class='alert alert-warning'>The name that we bind each route has a suffix of <code>Action</code>. This is not necessary, your method can be called anything you like.</h5>

<a name='routing-parameters'></a>

## Parámetros

Hemos visto brevemente cómo están definidos los parámetros en las rutas. Los parámetros se establecen en una cadena de ruta incluyendo el nombre del parámetro entre llaves.

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
);
```

También podemos aplicar ciertas reglas para cada parámetro utilizando expresiones regulares. La expresión regular se encuentra después del nombre del parámetro, separados por un `:`.

```php
// Coincidir por id de orden
$app->get(
    '/orders/display/{id:[0-9]+}',
    function ($id) {
        echo "<h1>This is order: #{$id}!</h1>";
    }
);

// Coincidir por 4 números y un título alfabético
$app->get(
    '/posts/{year:[0-9][4]}/{title:[a-zA-Z\-]+}',
    function ($year, $title) {
        echo '<h1>Title: $title</h1>';
        echo '<h2>Year: $year</h2>';
    }
);
```

Additional information: [Phalcon\Mvc\Router](api/Phalcon_Mvc_Router) [Info](/4.0/en/routing)

<a name='routing-redirections'></a>

## Redirecciones

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

Cuando utilices controladores como manejadores, puedes realizar la redirección así de fácil:

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

<a name='routing-urls-for-routes'></a>

## URLs para Rutas

Another feature of the routes is setting up named routes and generating URLs for those routes. This is a two step process. * First we need to name our route. This can be achieved with the `setName()` method that is exposed from the methods/verbs in our application (`get`, `post`, etc.);

```php
// Establecer una ruta con el nombre 'show-order'
$app
    ->get(
        '/orders/display/{id}',
        function ($id) use ($app) {
            // ... Encontrar la orden y mostrarla
        }
    )
    ->setName('show-order');
```

* We need to use the [Phalcon\Mvc\Url](api/Phalcon_Mvc_Url) component to generate URLs for the named routes.

```php
// Usar el nombre de ruta y generar una URL desde esta
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

<a name='dependency-injector'></a>

# Inyector de Dependencias

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

También puede crear su propio contenedor Di y asignarlo a la micro aplicación, por lo tanto, puedes manipular los servicios según las necesidades de tu aplicación.

```php
<?php

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
        // Leer una configuración desde el config
        echo $app->config->app_name;
    }
);

$app->post(
    '/contact',
    function () use ($app) {
        $app->flash->success('What are you doing Dave?');
    }
);
```

También puedes utilizar la sintaxis de arreglos para registrar servicios en el contenedor de inyección de dependencias desde el objeto de la aplicación:

```php
<br /><?php

use Phalcon\Mvc\Micro;
use Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter;

$app = new Micro();

// Establece el servicio de Base de Datos
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

<a name='responses'></a>

# Respuestas

Una micro aplicación puede devolver diferentes tipos de respuestas. Salida directa, mediante un motor de plantillas, datos calculados, datos basados en vistas, JSON, etc.

Handlers may return raw responses using plain text, [Phalcon\Http\Response](api/Phalcon_Http_Response) object or a custom built component that implements the [Phalcon\Http\ResponseInterface](api/Phalcon_Http_ResponseInterface).

<a name='responses-direct-output'></a>

## Salida Directa

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
);
```

<a name='responses-include'></a>

## Incluir Otro Archivo

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        require 'views/results.php';
    }
);
```

<a name='responses-direct-output-json'></a>

## Salida Directa JSON

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

<a name='responses-new-response-object'></a>

## Nuevo Objeto Response

You can use the `setContent` method of the response object to return the response back:

```php
$app->get(
    '/show/data',
    function () {
        // Crear una respuesta
        $response = new Phalcon\Http\Response();

        // Establecer la cabecera Content-Type
        $response->setContentType('text/plain');

        // Pasar el contenido del archivo
        $response->setContent(file_get_contents('data.txt'));

        // Devolver la respuesta
        return $response;
    }
);
```

<a name='responses-application-response'></a>

## Respuesta de la Aplicación

You can also use the [Phalcon\Http\Response](api/Phalcon_Http_Response) object to return responses to the caller. The response object has a lot of useful methods that make returning respones much easier.

```php
$app->get(
    '/show/data',
    function () use ($app) {
        // Establecer la cabecera Content-Type
        $app->response->setContentType('text/plain');
        $app->response->sendHeaders();

        // Imprimir un archivo
        readfile('data.txt');
    }
);
```

<a name='responses-return-application-response'></a>

## Devolver Respuestas de la Aplicación

A different approach returning data back to the caller is to return the response object directly from the application. When responses are returned by handlers they are automatically sent by the application.

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Http\Response;

$app = new Micro();

// Devuelve una respuesta
$app->get(
    '/welcome/index',
    function () {
        $response = new Response();

        $response->setStatusCode(401, 'Unauthorized');
        $response->setContent('Access is not authorized');

        return $response;
    }
);
```

<a name='responses-json'></a>

## JSON

JSON can be sent back just as easy using the [Phalcon\Http\Response](api/Phalcon_Http_Response) object:

```php
$app->get(
    '/welcome/index',
    function () use ($app) {

        $data = [
            'code'    => 401,
            'status'  => 'error',
            'message' => 'Unauthorized access',
            'payload' => [],
        ];

        $response->setJsonContent($data);

        return $response;
    }
);
```

<a name='events'></a>

# Eventos

A [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application works closely with a [Phalcon\Events\Manager](api/Phalcon_Events_Manager) if it is present, to trigger events that can be used throughout our application. The type of those events is `micro`. Estos eventos se activan en nuestra aplicación y pueden adjuntarse a los manejadores pertinentes que realizan las acciones que son necesitadas por nuestra aplicación.

<a name='events-available-events'></a>

## Eventos Disponibles

Son soportados los siguientes eventos:

| Nombre de evento   | Disparado                                                                             | ¿Detiene la operación? |
| ------------------ | ------------------------------------------------------------------------------------- |:----------------------:|
| beforeHandleRoute  | Método principal llamado; Las rutas no han sido verificadas aún                       |           Si           |
| beforeExecuteRoute | Coincidencia en la Ruta, Manejador válido, el Manejador aún no ha sido ejecutado      |           Si           |
| afterExecuteRoute  | Manejador acaba de terminar de correr                                                 |           No           |
| beforeNotFound     | Ruta no ha sido encontrada                                                            |           Si           |
| afterHandleRoute   | Ruta acaba de terminar su ejecución                                                   |           Si           |
| afterBinding       | Activa después de que los modelos están enlazados pero antes de ejecutar el Manejador |           Si           |

<a name='events-available-events-authentication'></a>

### Ejemplo de Autenticación

You can easily check whether a user has been authenticated or not using the `beforeExecuteRoute` event. In the following example, we explain how to control the application security using events:

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// Crear un gestor de eventos
$eventsManager = new EventsManager();

$eventsManager->attach(
    'micro:beforeExecuteRoute',
    function (Event $event, $app) {
        if ($app->session->get('auth') === false) {
            $app->flashSession->error("The user isn't authenticated");

            $app->response->redirect('/');
            $app->response->sendHeaders();

            // Devolver (false) y detener la operación
            return false;
        }
    }
);

$app = new Micro();

// Enlazar el gestor de eventos a la aplicación
$app->setEventsManager($eventsManager);
```

<a name='events-available-events-not-found'></a>

### Ejemplo de Not Found

You can easily check whether a user has been authenticated or not using the `beforeExecuteRoute` event. In the following example, we explain how to control the application security using events:

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// Crear un gestor de eventos
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

// Enlazar el gestor de eventos a la aplicación
$app->setEventsManager($eventsManager);
```

<a name='middleware'></a>

# Middleware

Middleware are classes that can be attached to your application and introduce another layer where business logic can exist. They run sequentially, according to the order they are registered and not only improve mainainability, by encapsulating specific functionality, but also performance. Una clase middleware puede detener la ejecución cuando una regla de negocio particular no haya sido satisfactoria, lo que permite a la aplicación salir antes de tiempo sin ejecutar el ciclo completo de una solicitud.

The presence of a [Phalcon\Events\Manager](api/Phalcon_Events_Manager) is essential for middleware to operate, so it has to be registered in our Di container.

<a name='middleware-attached-events'></a>

## Eventos adjuntos

Middleware can be attached to a micro application in 3 different events. Those are:

| Evento | Descripción                                                                   |
| ------ | ----------------------------------------------------------------------------- |
| before | Antes de que el manejador haya sido ejecutado                                 |
| after  | Después de que el manejador haya sido ejecutado                               |
| final  | Después de que la respuesta ha sido enviada al componente que hizo la llamada |

<h5 class='alert alert-warning'>You can attach as many middleware classes as you want in each of the above events. They will be executed sequentially when the relevant event fires.</h5>

<a name='middleware-attached-events-before'></a>

### before

This event is perfect for stopping execution of the application if certain criteria is not met. In the below example we are checking if the user has been authenticated and stop execution with the necessary redirect.

```php
<?php

$app = new Phalcon\Mvc\Micro();

// Ejecutado antes que cada route se ejecute
// Retornar false cancela la ejecución del route
$app->before(
    function () use ($app) {
        if (false === $app['session']->get('auth')) {
            $app['flashSession']->error("The user isn't authenticated");

            $app['response']->redirect('/error');

            // Retornamos false para detener la ejecución 
            return false;
        }

        return true;
    }
);
```

<a name='middleware-attached-events-after'></a>

### after

Este evento puede utilizarse para manipular los datos o realizar acciones que son necesarias después de que el manejador ha terminado de ejecutarse. En el siguiente ejemplo, manipulamos nuestra respuesta para enviar un JSON al llamador.

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
        // Esto es ejecutado después de ejecutarse el route
        echo json_encode($app->getReturnedValue());
    }
);
```

<a name='middleware-attached-events-finish'></a>

### finish

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

<a name='middleware-setup'></a>

## Configuración

Attaching middleware to your application is very easy as shown above, with the `before`, `after` and `finish` method calls.

```php
$app->before(
    function () use ($app) {
        if (false === $app['session']->get('auth')) {
            $app['flashSession']->error("The user isn't authenticated");

            $app['response']->redirect('/error');

            // Devolver false detiene la ejecución normal
            return false;
        }

        return true;
    }
);

$app->after(
    function () use ($app) {
        // Esto se ejecuta después de que la ruta es ejecutada
        echo json_encode($app->getReturnedValue());
    }
);
```

Agregar middleware en tu aplicación como clases, para escuchar a los eventos desde el gestor de eventos, se logra de la siguiente manera:

```php
<?php

use Phalcon\Events\Manager;
use Phalcon\Mvc\Micro;

use Website\Middleware\CacheMiddleware;
use Website\Middleware\NotFoundMiddleware;
use Website\Middleware\ResponseMiddleware;

/**
 * Crear un nuevo Gestor de Eventos.
 */
$eventsManager = new Manager();
$application   = new Micro();

/**
 * Agregar el middleware tanto para el gestor de eventos como para la aplicación
 */
$eventsManager->attach('micro', new CacheMiddleware());
$application->before(new CacheMiddleware());

$eventsManager->attach('micro', new NotFoundMiddleware());
$application->before(new NotFoundMiddleware());

/**
 * Este se necesita para escuchar al eventos `after`
 */
$eventsManager->attach('micro', new ResponseMiddleware());
$application->after(new ResponseMiddleware());

/**
 * Asegurate que el gestor de eventos esté ahora en el contenedor DI
 */
$application->setEventsManager($eventsManager);

```

We need a [Phalcon\Events\Manager](api/Phalcon_Events_Manager) object. This can be a newly instantiated object or we can get the one that exists in our DI container (if you have used the `FactoryDefault` one).

Conectamos cada clase middleware en el conector `micro` del administrador de eventos. También podríamos ser un poco más específicos y conectarlo, por ejemplo, al evento `micro:beforeExecuteRoute`.

We then attach the middleware class in our application on one of the three listening events discussed above (`before`, `after`, `finish`).

<a name='middleware-implementation'></a>

## Implementación

Middleware can be any kind of PHP callable functions. Puedes organizar el código del modo te guste para implementar un middleware. If you choose to use classes for your middleware, you will need them to implement the [Phalcon\Mvc\Micro\MiddlewareInterface](api/Phalcon_Mvc_Micro_MiddlewareInterface)

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * CacheMiddleware
 *
 * Caches de página para reducir el procesamiento
 */
class CacheMiddleware implements MiddlewareInterface
{
    /**
     * Llama al middleware
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

        // Verificar si la solicitud se encuentra en cache
        if ($cache->exists($key)) {
            echo $cache->get($key);

            return false;
        }

        return true;
    }
}
```

<a name='middleware-events'></a>

## Eventos en Middleware

The [events](#events) that are triggered for our application also trigger inside a class that implements the [Phalcon\Mvc\Micro\MiddlewareInterface](api/Phalcon_Mvc_Micro_MiddlewareInterface). This offers great flexibility and power for developers since we can interact with the request process.

<a name='middleware-events-api'></a>

### Ejemplo de API

Assume that we have an API that we have implemented with the Micro application. We will need to attach different Middleware classes in the application so that we can better control the execution of the application.

The middleware that we will use are: * Firewall * NotFound * Redirect * CORS * Request * Response

<a name='middleware-events-api-firewall'></a>

#### Firewall Middleware

This middleware is attached to the `before` event of our Micro application. El propósito de este middleware es verificar quién está llamando nuestra API y basado en una lista blanca, para permitir que se proceda o no

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * FirewallMiddleware
 *
 * Comprueba la lista blanca y permite el acceso a los clientes o no
 */
class FirewallMiddleware implements MiddlewareInterface
{
    /**
     * Antes que se ejecute cualquier cosa
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
     * Llamar al middleware
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

<a name='middleware-events-api-not-found'></a>

#### Not Found Middleware

When this middleware is processed, this means that the requesting IP is allowed to access our application. The application will try and match the route and if not found the `beforeNotFound` event will fire. We will stop the processing then and send back to the user the relevant 404 response. This middleware is attached to the `before` event of our Micro application

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * NotFoundMiddleware
 *
 * Procesa los 404s
 */
class NotFoundMiddleware implements MiddlewareInterface
{
    /**
     * La ruta no ha sido encontrada
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
     * Llama al middleware
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

<a name='middleware-events-api-redirect'></a>

#### Redirección en Middleware

We attach this middleware again to the `before` event of our Micro application because we don't want the request to proceed if the requested endpoint needs to be redirected.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * RedirectMiddleware
 *
 * Verificar la solicitud y redireccionar al usuario a algún lugar si se necesario
 */
class RedirectMiddleware implements MiddlewareInterface
{
    /**
     * Antes que nada ocurra
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
     * Llama al middleware
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

<a name='middleware-events-api-cors'></a>

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
 * Verificación CORS
 */
class CORSMiddleware implements MiddlewareInterface
{
    /**
     * Antes de que algo suceda
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

<a name='middleware-events-api-request'></a>

#### Solicitud Middleware

This middleware is receiving a JSON payload and checks it. If the JSON payload is not valid it will stop execution.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * RequestMiddleware
 *
 * Verifica la carga que se está recibiendo
 */
class RequestMiddleware implements MiddlewareInterface
{
    /**
     * Antes de que la ruta sea ejecutada
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
     * Realiza la llamada al Middleware
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

<a name='middleware-events-api-response'></a>

#### Respuesta Middleware

This middleware is responsible for manipulating our response and sending it back to the caller as a JSON string. Therefore we need to attach it to the `after` event of our Micro application.

<h5 class='alert alert-warning'>We are going to be using the <code>call</code> method for this middleware, since we have nearly executed the whole request cycle.</h5>

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
* ResponseMiddleware
*
* Se manipula la respuesta
*/
class ResponseMiddleware implements MiddlewareInterface
{
     /**
      * Antes que cualquier cosa ocurra
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

<a name='models'></a>

# Modelos

Models can be used in Micro applications, so long as we instruct the application how it can find the relevant classes with an autoloader.

<h5 class='alert alert-warning'>The relevant <code>db</code> service must be registered in your Di container.</h5>

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

<a name='model-instances'></a>

# Inyectando instancias de modelos

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
        // haz lo que necesites con el objeto $product
    }
);

$app->handle();
```

El objeto Binder internamente utiliza la Api Reflection lo cual puede ser muy pesado, pero se puede configurar un caché para acelerar el proceso. This can be done by using the second argument of `setModelBinder()` which can also accept a service name or just by passing a cache instance to the `Binder` constructor.

Actualmente Binder utiliza solamente de la clave primaria de los modelos para realizar un `findFirst()`. Una ruta de ejemplo para lo anterior podría ser `/products/1`.

<a name='views'></a>

# Vistas

[Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) does not have inherently a view service. We can however use the [Phalcon\Mvc\View\Simple](api/Phalcon_Mvc_View_Simple) component to render views.

```php
<?php

$app = new Phalcon\Mvc\Micro();

$app['view'] = function () {
    $view = new \Phalcon\Mvc\View\Simple();

    $view->setViewsDir('app/views/');

    return $view;
};

// Devolver una vista
$app->get(
    '/products/show',
    function () use ($app) {
        // Construir app/views/products/show.phtml pasando algunas variables
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

<h5 class='alert alert-warning'>The above example uses the <a href="api/Phalcon_Mvc_View_Simple">Phalcon\Mvc\View\Simple</a> component, which uses relative paths instead of controllers and actions. You can use the <a href="api/Phalcon_Mvc_View">Phalcon\Mvc\View</a> component instead, but to do so you will need to change the parameters passed to <code>render()</code></h5>

```php
<?php

$app = new Phalcon\Mvc\Micro();

$app['view'] = function () {
    $view = new \Phalcon\Mvc\View();

    $view->setViewsDir('app/views/');

    return $view;
};

// Devuelve una vista
$app->get(
    '/products/show',
    function () use ($app) {
        // Construye app/views/products/show.phtml pasando algunas variables
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

<a name='error-handling'></a>

# Manejo de Errores

The [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application also has an `error` method, which can be used to trap any errors that originate from exceptions. The following code snippet shows basic usage of this feature:

```php
<?php

$app = new Phalcon\Mvc\Micro();

$app->get(
    '/',
    function () {
        throw new \Exception('Some error happened', 401);
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