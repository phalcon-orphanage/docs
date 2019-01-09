* * *

layout: default language: 'en' version: '3.4'

* * *

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

Routing is handled by the [Phalcon\Mvc\Router](api/Phalcon_Mvc_Router) object. [[Info](/3.4/en/routing)]

<h5 class='alert alert-warning'>Las rutas deben empezar siempre con <code>/</code></h5>

Generalmente, la ruta de inicio en una aplicación, es la ruta `/` y en la mayoría de los casos se accede mediante el método HTTP GET:

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

## Reglas de Reescritura

Para que las rutas funcionen, ciertos cambios de configuración deben hacerse en la configuración de tu servidor web para cada sitio web en particular.

Those changes are outlined in the [rewrite rules](/3.4/en/rewrite-rules).

<a name='routing-handlers'></a>

## Manejadores

Los Manejadores (Handlers), son piezas de código accesibles que están vinculados a una ruta. When the route is matched, the handler is executed with all the defined parameters. Un manejador es cualquier código accesible que existe en PHP.

<a name='routing-handlers-definitions'></a>

### Definiciones

Phalcon offers several ways to attach a handler to a route. Your application needs and design as well as coding style will be the factors influencing your choice of implementation.

<a name='routing-handlers-anonymous-function'></a>

#### Funciones Anónimas

Finalmente podemos utilizar una función anónima (como se ve arriba) para atender la solicitud

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
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

<a name='routing-handlers-function'></a>

#### Función

Podemos definir una función como nuestro manejador y adjuntarlo a una ruta específica.

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

#### Método Estático

We can also use a static method as our handler as follows:

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

#### Método en un Objeto

También podemos usar un método en un objeto:

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

With the [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) you can create micro or medium applications. Estas últimas utilizan la arquitectura de micro pero se amplían para que utilicen más características que las aplicaciones Micro pero no tantas como lo hace una aplicación completa.

In medium applications you can organize handlers in controllers.

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

El `OrdersController` podría tener este aspecto:

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

### Carga Perezosa (Lazy Load)

In order to increase performance, you might consider implementing lazy loading for your controllers (handlers). The controller will be loaded only if the relevant route is matched.

Lazy loading can be easily achieved when setting your handler in your [Phalcon\Mvc\Micro\Collection](api/Phalcon_Mvc_Micro_Collection):

```php
$orders->setHandler('OrdersController', true);
$orders->setHandler('Blog\Controllers\OrdersController', true);
```

<a name='routing-handlers-controllers-lazy-loading-use-case'></a>

#### Casos de uso

Desarrollaremos una API para una tienda en línea. Los puntos de acceso son `/users`, `/orders` y `/products`. Cada uno de los puntos de acceso se registran usando los manejadores, y cada manejador es un controlador con las acciones pertinentes.

Los controladores que usaremos como manejadores son los siguientes:

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

Registraremos los manejadores:

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

This implementation loads each handler in turn and mounts it in our application object. El problema con este enfoque es que cada petición dará lugar a sólo un punto final y por lo tanto de la ejecución de un método de la clase. The remaining methods/handlers will just remain in memory without being used.

Utilizando Carga Perezosa, podemos reducir el número de objetos cargados en memoria y como resultado nuestra aplicación utiliza menos memoria.

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

Con este simple cambio en la aplicación, todos los manejadores permanecen sin ser instanciados hasta que son solicitados. Por lo tanto cuando alguien hace una petición a `/orders/get/2`, nuestra aplicación crea una instancia de `OrdersController` y llama al método `get`. Nuestra aplicación ahora consume menos recursos que antes.

<a name='routing-handlers-not-found'></a>

### No encontrado (404)

Any route that has not been matched in our [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application will cause it to try and execute the handler defined with the `notFound` method. Similar a otros métodos/verbos (`get`, `post` etc.), puedes registrar un manejador en el método `notFound` que puede ser cualquier función PHP accesible.

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

También puede manejar las rutas que no han sido vinculadas (404) con Middleware, este se discute a continuación.

<a name='routing-verbs'></a>

## Métodos - Verbos

The [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application provides a set of methods to bind the HTTP method with the route it is intended to.

<a name='routing-verbs-delete'></a>

### delete

Coincide si el método HTTP es `DELETE` y la ruta es `/api/products/delete/{id}`

```php
    $app->delete(
        '/api/products/delete/{id}',
        'delete_product'
    );
```

<a name='routing-verbs-get'></a>

### get

Coincide si el método HTTP es `GET` y la ruta es `/api/products/`

```php
    $app->get(
        '/api/products',
        'get_products'
    );
```

<a name='routing-verbs-head'></a>

### head

Coincide si el método HTTP es `HEAD` y la ruta es `/api/products/`

```php
    $app->get(
        '/api/products',
        'get_products'
    );
```

<a name='routing-verbs-map'></a>

### map

Map permite adjuntar el mismo punto de acceso a más de un método HTTP. El ejemplo a continuación funciona si el método HTTP es `GET` o `POST` y la ruta es `/repos/store/refs`

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

Coincide si el método HTTP es `OPTIONS` y la ruta es `/api/products/options`

```php
    $app->options(
        '/api/products/options',
        'info_product'
    );
```

<a name='routing-verbs-patch'></a>

### patch

Coincide si el método HTTP es `PATCH` y la ruta es `/api/products/update/{id}`

```php
    $app->patch(
        '/api/products/update/{id}',
        'update_product'
    );
```

<a name='routing-verbs-post'></a>

### post

Matches if the HTTP method is `POST` and the route is `/api/products/add`

```php
    $app->post(
        '/api/products',
        'add_product'
    );
```

<a name='routing-verbs-put'></a>

### put

Coincide si el método HTTP es `PUT` y la ruta es `/api/products/update/{id}`

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

<h5 class='alert alert-warning'>The name that we bind each route has a suffix of <code>Action</code>. This is not necessary, your method can be called anything you like.</h5>

<a name='routing-parameters'></a>

## Parámetros

We have briefly seen above how parameters are defined in the routes. Parameters are set in a route string by enclosing the name of the parameter in brackets.

```php
$app->get(
    '/orders/display/{name}',
    function ($name) {
        echo "<h1>This is order: {$name}!</h1>";
    }
);
```

We can also enforce certain rules for each parameter by using regular expressions. The regular expression is set after the name of the parameter, separating it with `:`.

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

Additional information: [Phalcon\Mvc\Router](api/Phalcon_Mvc_Router) [Info](/3.4/en/routing)

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

**Nota** tenemos que pasar el objeto `$app` en nuestra función anónima para tener acceso al objeto `request`.

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

<a name='routing-urls-for-routes'></a>

## URLs para Rutas

Otra característica de las rutas es la posibilidad de crear rutas nombradas y generar URLs para estas rutas. Se trata de un proceso de dos pasos.

* Primero tenemos que nombrar nuestra ruta. Esto puede lograrse con el método `setName()` que es presentado por los métodos/verbos (`get`, `post`, etc.) en nuestra aplicación;

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

You can also create a Di container yourself, and assign it to the micro application, therefore manipulating the services depending on the needs of your application.

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

You can also use the array syntax to register services in the dependency injection container from the application object:

```php
<br />&lt;?php

use Phalcon\Mvc\Micro;
use Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter;

$app = new Micro();

// Establece el servicio de Base de Datos
$app['db'] = function () {
    return new MysqlAdapter(
        [
            'host'     =&gt; 'localhost',
            'username' =&gt; 'root',
            'password' =&gt; 'secret',
            'dbname'   =&gt; 'test_db',
        ]
    );
};

$app-&gt;get(
    '/blog',
    function () use ($app) {
        $news = $app['db']-&gt;query('SELECT * FROM news');

        foreach ($news as $new) {
            echo $new-&gt;title;
        }
    }
);
```

<a name='responses'></a>

# Respuestas

A micro application can return many different types of responses. Direct output, use a template engine, calculated data, view based data, JSON etc.

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

A different approach returning data back to the caller is to return the response object directly from the application. Cuando las respuestas son devueltas por los manejadores, éstas se envían automáticamente por la aplicación.

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

A [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application works closely with a [Phalcon\Events\Manager](api/Phalcon_Events_Manager) if it is present, to trigger events that can be used throughout our application. El tipo de estos eventos es `micro`. These events trigger in our application and can be attached to relevant handlers that will perform actions needed by our application.

<a name='events-available-events'></a>

## Eventos Disponibles

Son soportados los siguientes eventos:

| Nombre de Evento   | Activador                                                                             | ¿Puede detener la operación? |
| ------------------ | ------------------------------------------------------------------------------------- |:----------------------------:|
| beforeHandleRoute  | Método principal llamado; Las rutas no han sido verificadas aún                       |              Sí              |
| beforeExecuteRoute | Coincidencia en la Ruta, Manejador válido, el Manejador aún no ha sido ejecutado      |              Sí              |
| afterExecuteRoute  | Manejador acaba de terminar de correr                                                 |              No              |
| beforeNotFound     | Ruta no ha sido encontrada                                                            |              Sí              |
| afterHandleRoute   | Ruta acaba de terminar su ejecución                                                   |              Sí              |
| afterBinding       | Activa después de que los modelos están enlazados pero antes de ejecutar el Manejador |              Sí              |

<a name='events-available-events-authentication'></a>

### Ejemplo de Autenticación

Puede comprobar fácilmente si un usuario se ha autenticado o no mediante el evento `beforeExecuteRoute`. En el ejemplo siguiente, explicamos cómo controlar la seguridad de las aplicaciones usando eventos:

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

Puede comprobar fácilmente si un usuario se ha autenticado o no mediante el evento `beforeExecuteRoute`. En el ejemplo siguiente, explicamos cómo controlar la seguridad de las aplicaciones usando eventos:

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

Middleware son clases que pueden adjuntarse a su solicitud y presentar otra capa donde la lógica de negocio puede existir. Se ejecutan secuencialmente, según el orden que están registrados y no sólo mejoran el mantenimiento, mediante el encapsulamiento de funcionalidades específicas, sino también el rendimiento. A middleware class can stop execution when a particular business rule has not been satisfied, thus allowing the application to exit early without executing the full cycle of a request.

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

Este evento es perfecto para detener la ejecución de la aplicación si no se cumplen ciertos criterios. En el siguiente ejemplo comprobaremos si el usuario ha sido autenticado y detenemos la ejecución con la redirección es necesaria.

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

Agregar un middleware para tu aplicación es muy fácil como se muestra arriba, con las llamadas al método `before`, `after` y `finish`.

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

Attaching middleware to your application as classes and having it listen to events from the events manager can be achieved as follows:

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

We need a [Phalcon\Events\Manager](api/Phalcon_Events_Manager) object. Esto puede ser una nueva instancia del objeto o podemos conseguir uno que exista en nuestro contenedor de DI (si has usado el de `FactoryDefault`).

We attach every middleware class in the `micro` hook in the Events Manager. We could also be a bit more specific and attach it to say the `micro:beforeExecuteRoute` event.

Entonces conectamos la clase de middleware en nuestra aplicación en uno de los tres eventos comentados anteriormente (`before`, `after`, `finish`).

<a name='middleware-implementation'></a>

## Implementación

Un Middleware puede ser cualquier tipo de función PHP accesible. You can organize your code whichever way you like it to implement middleware. If you choose to use classes for your middleware, you will need them to implement the [Phalcon\Mvc\Micro\MiddlewareInterface](api/Phalcon_Mvc_Micro_MiddlewareInterface)

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

The [events](#events) that are triggered for our application also trigger inside a class that implements the [Phalcon\Mvc\Micro\MiddlewareInterface](api/Phalcon_Mvc_Micro_MiddlewareInterface). Esto ofrece una gran flexibilidad y potencial para los desarrolladores, ya que podemos interactuar con el proceso de solicitud.

<a name='middleware-events-api'></a>

### Ejemplo de API

Supongamos que tenemos una API que hayamos implementado con una Micro aplicación. Tendríamos que colocar diferentes clases de Middleware en la aplicación y así podríamos controlar la ejecución de la aplicación.

Los middleware que utilizamos son:

* Firewall
* NotFound
* Redirect
* CORS
* Request
* Response

<a name='middleware-events-api-firewall'></a>

#### Firewall Middleware

Este middleware se conecta al evento `before` de nuestra Micro aplicación. El propósito de este middleware es verificar quién está llamando nuestra API y basado en una lista blanca, permitir que se proceda o no

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

Cuando se procesa este middleware, significa que la IP solicitante está autorizada a acceder a nuestra aplicación. La aplicación probará y buscará una coincidencia con la ruta y si no encuentra alguna, el evento `beforeNotFound` se activará. Cuando esto ocurra se detendrá el proceso y se devolverá al usuario la respuesta 404 pertinente. Este middleware está conectado al evento `before` de la Micro aplicación

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

#### Redirect Middleware

Conectamos este middleware otra vez al evento `before` de nuestra Micro aplicación porque no queremos que se procese la solicitud si del destino requerido necesita ser redirigido.

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

#### Response Middleware

Este middleware es responsable de manipular nuestra respuesta y enviarla de vuelta a la entidad que lo llamó como una cadena JSON. Por lo tanto tenemos que conectar al evento `after` de nuestra Micro aplicación.

<h5 class='alert alert-warning'>Usaremos el método <code>call</code> de este middleware, ya que casi hemos ejecutado el ciclo completo de la petición.</h5>

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

Los Modelos pueden utilizarse en Micro aplicaciones, siempre y cuando podamos indicar a la aplicación como puede encontrar las clases relevantes con un cargador automático.

<h5 class='alert alert-warning'>El servicio <code>db</code> debe estar registrado en el contenedor de Di.</h5>

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

Since Binder object is using internally Reflection Api which can be heavy, there is ability to set a cache so as to speed up the process. Esto puede hacerse mediante el segundo argumento de `setModelBinder()` que también puede aceptar un nombre de servicio o simplemente pasando una instancia de caché al constructor `Binder`.

Currently the binder will only use the models primary key to perform a `findFirst()` on. An example route for the above would be `/products/1`.

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

The [Phalcon\Mvc\Micro](api/Phalcon_Mvc_Micro) application also has an `error` method, which can be used to trap any errors that originate from exceptions. El siguiente fragmento de código muestra el uso básico de esta función:

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