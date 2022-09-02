---
layout: default
language: 'es-es'
version: '4.0'
title: 'Micro Application'
keywords: 'application, micro, handlers, api'
---

# Micro Aplicaciones

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Phalcon ofrece una aplicación muy 'ligera', para que pueda crear `Micro` aplicaciones con un mínimo de código PHP y sobrecarga. Las micro aplicaciones son aptas para pequeñas aplicaciones que tendrán un bajo nivel de sobrecarga. Tales aplicaciones son generalmente APIs, prototipos, etc.

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

## Activación

La clase [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) es la responsable de crear una Micro Aplicación.

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Micro;

$container = new Di();
$app       = new Micro($container);
```

## Métodos

```php
public function __construct(
    DiInterface $container = null
)
```

Constructor. Acepta un contenedor Di opcional.

```php
public function after(
    callable $handler
): Micro
```

Añade un `after` middleware a ser llamado después de ejecutar la ruta

```php
public function afterBinding(
    callable $handler
): Micro
```

Agrega un middleware afterBinding a ser llamado después del enlace del modelo

```php
public function before(
    callable $handler
): Micro
```

Agrega un middleware a ser llamado antes de ejecutar la ruta

```php
public function delete(
    string $routePattern, 
    callable $handler
): RouteInterface
```

Asigna una ruta a un controlador que solo coincide si el método HTTP es DELETE

```php
public function error(
    callable $handler
): Micro
```

Configura un controlador que será llamado cuando se arroje una excepción al gestionar la ruta

```php
public function finish(
    callable $handler
): Micro
```

Añade un `finish` middleware a ser llamado cuando la solicitud haya finalizado

```php
public function get(
    string $routePattern, 
    callable $handler
): RouteInterface
```

Asigna una ruta a un controlador que solo coincide si el método HTTP es GET

```php
public function getActiveHandler(): callable
```

Devuelve el controlador que será llamado por la ruta correspondiente

```php
public function getBoundModels(): array
```

Devuelve los modelos enlazados de la instancia del enlazador

```php
public function getHandlers(): array
```

Devuelve los gestores internos adjuntos a la aplicación

```php
public function getModelBinder(): BinderInterface | null
```

Obtiene el enlazador modelo

```php
public function getReturnedValue(): mixed
```

Devuelve el valor devuelto por el gestor ejecutado

```php
public function getRouter(): RouterInterface
```

Devuelve el enrutador interno utilizado por la aplicación

```php
public function getService(
    string $serviceName
): object
```

Obtiene un servicio del DI

```php
public function getSharedService(
    string $serviceName
)
```

Obtiene un servicio compartido del DI

```php
public function handle(
    string $uri
): mixed
```

Maneja toda la solicitud

```php
public function hasService(
    string $serviceName
): bool
```

Comprueba si un servicio está registrado en el DI

```php
public function head(
    string $routePattern, 
    callable $handler
): RouteInterface
```

Asigna una ruta a un controlador que solo coincide si el método HTTP es HEAD

```php
public function map(
    string $routePattern, 
    callable $handler
): RouteInterface
```

Asigna una ruta a un controlador sin ninguna restricción de método HTTP

```php
public function mount(
    CollectionInterface $collection
): Micro
```

Monta una colección de gestores

```php
public function notFound(
    callable $handler
): Micro
```

Configura un gestor que será llamado cuando el enrutador no coincida con ninguna de las rutas definidas

```php
public function offsetExists(
    mixed $alias
): bool
```

Comprueba si un servicio está registrado en el DI interno utilizando la sintaxis de array

```php
public function offsetGet(
    mixed $alias
): mixed
```

Obtiene un servicio DI desde el contenedor DI interno usando la sintaxis de array

```php
public function offsetSet(
    mixed $alias, 
    mixed $definition
)
```

Registra un servicio en el contenedor DI interno usando la sintaxis de array

```php
$app["request"] = new \Phalcon\Http\Request();
```

```php
public function offsetUnset(
    mixed $alias
): void
```

Elimina un servicio del DI interno utilizando la sintaxis de array

```php
public function options(    
    string $routePattern, 
    callable $handler
): RouteInterface
```

Asigna una ruta a un gestor que solo coincide si el método HTTP es `OPTIONS`

```php
public function patch(
    string $routePattern, 
    callable $handler
): RouteInterface
```

Asigna una ruta a un gestor que solo coincide si el método HTTP es `PATCH`

```php
public function post(
    string $routePattern, 
    callable $handler
): RouteInterface
```

Asigna una ruta a un gestor que solo coincide si el método HTTP es `POST`

```php
public function put(
    string $routePattern, 
    callable $handler
): RouteInterface
```

Asigna una ruta a un gestor que solo coincide si el método HTTP es `PUT`

```php
public function setActiveHandler(
    callable $activeHandler
)
```

Configura externamente el gestor que debe ser llamado por la ruta coincidente

```php
public function setModelBinder(
    BinderInterface $modelBinder, 
    mixed $cache = null
): Micro
```

Configura el enlazador de modelo

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

Añade un gestor `response` personalizado a ser llamado en lugar del predeterminado

```php
public function setService(
    string $serviceName, 
    mixed $definition, 
    bool $shared = false
): ServiceInterface
```

Establece un servicio en el contenedor DI interno. Si ningún contenedor es preseteado un [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) se creará automáticamente

```php
public function stop()
```

Detiene la ejecución de middleware

## Rutas

Es muy fácil definir rutas en una aplicación [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro). Las rutas se definen de la siguiente manera:

```text
   Application : (http method): (route url/regex, callable PHP function/handler)
```

### Activación

El enrutamiento se controla mediante el objeto [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router).

> **NOTA**: Las rutas siempre deben comenzar con `/`
{: .alert .alert-warning }

Generalmente, la ruta inicial de una aplicación es `/`, a la que se accede mediante el método HTTP `GET`:

```php
<?php

$application->get(
    '/',
    function () {
        echo '<h1>3.1459</h1>';
    }
);
```

> **NOTA**: Comprueba nuestro documento <routing> para más información sobre [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router)
{: .alert .alert-info }

**El objeto de la Aplicación**

Las rutas se pueden definir mediante el objeto de aplicación [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro), de la siguiente forma:

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

**El Objeto *Router***

También puedes crear un objeto [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router), establecer las rutas en él y luego inyectarlo en el contenedor del inyector de dependencias.

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

Configurar las rutas usando los métodos ([get](api/phalcon_mvc#mvc-micro), `post`, etc.) del objeto `Phalcon\Mvc\Micro` de micro aplicaciones es mucho más fácil que crear un objeto enrutador con rutas pertinentes y luego inyectarlas en la aplicación. Cada método tiene sus ventajas y desventajas. Todo depende del diseño y las necesidades de tu aplicación.

### Reglas de reescritura

Para que las rutas funcionen, su servidor web debe configurarse con instrucciones específicas. Por favor, consulte el documento de [configuración del servidor web](webserver-setup) para más información.

### Gestores

Los Manejadores o *Handlers*, son piezas de código invocables que están vinculados a una ruta. Cuando una ruta encaja, el manejador se ejecuta con todos los parámetros definidos. Un manejador es cualquier PHP `callable` válido.

#### Registro

Phalcon ofrece muchas formas de adjuntar un gestor a una ruta. Las necesidades y el diseño de su aplicación, así como el estilo de codificación, serán los factores que influirán en su elección de implementación.

**Funciones anónimas**

Puede utilizar una función anónima para manejar la solicitud

```php
<?php

$app->get(
    '/invoices/view/{id}',
    function ($id) {
        echo "<h1>Invoice #{$id}!</h1>";
    }
);
```

Acceder al objeto `$app` dentro de la función anónima puede lograrse mediante la inyección de esta, de la siguiente manera:

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

**Funciones**

Podemos definir una función como el manejador y adjuntarlo a una ruta específica.

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

**Método estático**

También podemos usar un método estático como gestor, como se muestra a continuación.

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

**Método en un objeto**

También puede utilizar un método en un objeto como manejador.

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

**Controladores**

Con [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) puedes crear aplicaciones micro o *medianas*. Estas últimas utilizan la arquitectura micro pero se amplían para utilizar más características que las aplicaciones Micro pero no tantas como lo hace una aplicación completa. En aplicaciones medianas puedes organizar los manejadores en los controladores.

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

El `InvoicesController` podría verse así:

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

Puesto que nuestros controladores extienden de la clase [Phalcon\Mvc\Controller](api/phalcon_mvc#mvc-controller), todos los servicios de la inyección de dependencias están disponibles con sus nombres de registro respectivos.

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

#### Carga perezosa (Lazy Load)

Con el fin de aumentar el rendimiento, usted podría considerar aplicar la carga perezosa para los controladores (gestores). El controlador será cargado solamente si se iguala la ruta pertinente.

La carga perezosa se puede lograr fácilmente al configurar su manejador en su [Phalcon\Mvc\Micro\Collection](api/phalcon_mvc#mvc-micro-collection) usando el segundo parámetro, o usando el método `setLazy`.

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

**Casos de uso**

Desarrollaremos una API para una tienda en línea. Los puntos de acceso son `/users`, `/invoices` y `/products`. Cada uno de los puntos de acceso se registran usando los manejadores, y cada manejador es un controlador con las acciones pertinentes.

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

Registraremos los manejadores:

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
    ->setPrefix('/invoices')
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

Esta implementación carga cada controlador a su vez y lo monta en nuestro objeto de aplicación. El problema con este enfoque es que cada petición dará lugar a sólo un punto final y por lo tanto de la ejecución de un método de la clase. Los métodos/manejadores restantes sólo permanecerán en la memoria sin ser utilizados.

Utilizando Carga Perezosa, podemos reducir el número de objetos cargados en memoria y como resultado nuestra aplicación utiliza menos memoria. La implementación anterior cambia si queremos usar la carga perezosa de la siguiente manera:

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
    ->setPrefix('/invoices')
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

$app->mount($products);   
```

Con este simple cambio en la aplicación, todos los manejadores permanecen sin ser instanciados hasta que son solicitados. Por lo tanto cuando alguien hace una petición a `/invoices/get/2`, nuestra aplicación crea una instancia de `InvoicesController` y llama al método `get`. Nuestra aplicación ahora consume menos recursos que antes.

#### Consejo de rendimiento extra

Si estás trabajando en una aplicación grande, no es necesario montar todas las colecciones, incluso si se cargan perezosamente: Phalcon usará regex para hacer coincidir las rutas. Para acelerar el proceso de enrutamiento es posible ejecutar un *pre-filter* como este, usando el ejemplo previo:

```php
        $uri = new \Phalcon\Http\Message\Uri($_SERVER['REQUEST_URI']);
        $path = $uri->getPath();
        $parts = explode("/", $path);
        $collection = $parts[1];

        switch ($collection) {
            case "users":
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

                break;

            case "invoices":
                $invoices = new MicroCollection();
                $invoices
                    ->setHandler(
                        InvoicesController::class,
                        true
                    )
                    ->setPrefix('/invoices')
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

                break;

            case "products": 
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

                $app->mount($products);  

                break;

            default: 
            //do nothing (or something)
        }
```

De esta manera, Phalcon puede manejar decenas (o cientos) de rutas sin penalización en el rendimiento de regex: usar `explode()` es más rápido que regex.

#### Not found (404)

Cualquier ruta que no coincida en nuestra aplicación [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) hará que se intente ejecutar el manejador definido con el método `notFound`. Similar a otros métodos http (`get`, `post` etc.), puede registrar un manejador en el método `notFound` que puede ser cualquier función PHP invocable.

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

También puede gestionar rutas que no coinciden (404) con Middleware, discutido a continuación.

### Métodos HTTP

La aplicación [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) proporciona un conjunto de métodos para vincular el método HTTP con la ruta que se pretende.

**delete**

Coincide si el método HTTP es `DELETE` y la ruta es `/api/products/delete/{id}`

```php
<?php

$app->delete(
    '/api/products/delete/{id}',
    'deleteProduct'
);
```

**get**

Coincide si el método es `GET` y la ruta es `/api/products`

```php
<?php

$app->get(
    '/api/products',
    'getProducts'
);
```

**head**

Coincide si el método HTTP es `HEAD` y la ruta es `/api/products`

```php
<?php

$app->head(
    '/api/products',
    'getProducts'
);
```

**map**

`Map` le permite adjuntar el mismo punto de acceso a más de un método HTTP. El ejemplo siguiente coincide si el método HTTP es `GET` o `POST` y la ruta es `/repos/store/refs`

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

Coincide si el método es `OPTIONS` y la ruta es `/api/products/options`

```php
<?php

$app->options(
    '/api/products/options',
    'infoProduct'
);
```

**patch**

Coincide si el método es `PATCH` y la ruta es `/api/products/update/{id}`

```php
<?php

$app->patch(
    '/api/products/update/{id}',
    'updateProduct'
);
```

**post**

Coincide si el método es `POST` y la ruta es `/api/products/add`

```php
<?php

$app->post(
    '/api/products',
    'addProduct'
);
```

**put**

Coincide si el método HTTP es `PUT` y la ruta es `/api/products/update/{id}`

```php
<?php

$app->put(
    '/api/products/update/{id}',
    'updateProduct'
);
```

### Colecciones

Las colecciones son una forma práctica de agrupar colecciones adjuntas a un manejador y un prefijo común (si es necesario). Para un hipotético punto de acceso `/invoices` podríamos tener las siguientes rutas:

```text
/invoices/get/{id}
/invoices/add/{payload}
/invoices/update/{id}
/invoices/delete/{id}
```

Todas estas rutas son manejadas por nuestro `InvoicesController`. Configuramos nuestras rutas con una colección de la siguiente manera:

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

> **NOTA**: El nombre que hemos asociado a cada ruta tiene el sufijo `Action`. Esto no es necesario, tu método puede ser llamado como desees.
{: .alert .alert-warning }

**Métodos**

Los método disponibles para el objeto [Phalcon\Mvc\Micro\Collection](api/phalcon_mvc#mvc-micro-collection) son:

```php
public function delete(
    string $routePattern, 
    callable $handler, 
    string $name = null
): CollectionInterface
```

Asigna una ruta a un manejador que sólo coincide si el método HTTP es `DELETE`.

```php
public function get(
    string $routePattern, 
    callable $handler,  
    string $name = null
): CollectionInterface
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es `GET`.

```php
public function getHandler(): mixed
```

Devuelve el gestor principal

```php
public function getHandlers(): array
```

Devuelve los gestores registrados

```php
public function getPrefix(): string
```

Devuelve el prefijo de la colección (si hay alguno)

```php
public function head(
    string $routePattern, 
    callable $handler, 
    string $name = null
): CollectionInterface
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es `HEAD`.

```php
public function isLazy(): bool
```

Devuelve si el gestor principal debe ser cargado de forma diferida

```php
public function map(
    string $routePattern, 
    callable $handler, 
    string | array $method, 
    string $name = null
): CollectionInterface
```

Asigna una ruta a un gestor.

```php
public function mapVia(
    string $routePattern, 
    callable $handler, 
    string | array $method, 
    string $name = null
): CollectionInterface
```

Asigna una ruta a un gestor a través de métodos.

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

Asigna una ruta a un manejador que solo coincide si el método HTTP es `OPTIONS`.

```php
public function patch(
    string $routePattern, 
    callable $handler, 
    string $name = null
): CollectionInterface
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es `PATCH`.

```php
public function post(
    string $routePattern, 
    callable $handler, 
    string $name = null
): CollectionInterface
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es `POST`.

```php
public function put(
    string $routePattern, 
    callable $handler, 
    string $name = null
): CollectionInterface
```

Asigna una ruta a un manejador que solo coincide si el método HTTP es `PUT`.

```php
public function setHandler(
    callable $handler, 
    bool $lazy = false
): CollectionInterface
```

Configura el gestor principal.

```php
public function setLazy(
    bool $lazy
): CollectionInterface
```

Establece si el gestor principal debe ser cargado de forma diferida

```php
public function setPrefix(
    string $prefix
): CollectionInterface
```

Configura un prefijo para todas las rutas agregadas a la colección

### Parámetros

Brevemente, hemos visto anteriormente cómo se definen los parámetros en las rutas. Los parámetros son establecidos en la cadena de la ruta encerrando el nombre del parámetro entre llaves.

```php
<?php

$app->get(
    '/invoices/view/{id}',
    function ($id) {
        echo "<h1>Invoice #{$id}!</h1>";
    }
);
```

También podemos aplicar ciertas reglas para cada parámetro, utilizando expresiones regulares. La expresión regular se encuentra después del nombre del parámetro, separando por un `:`.

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

> **NOTA**: Comprueba nuestro documento <routing> para más información sobre [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router)
{: .alert .alert-info }

### Redirecciones

Se puede redireccionar una ruta coincidente a otra mediante el objeto [Phalcon\Http\Response](api/phalcon_http#http-response), al igual que en una aplicación completa.

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

> **NOTA**: tenemos que pasar el objeto `$app` en nuestra función anónima para tener acceso al objeto `request`.
{: .alert .alert-info }

Cuando utilices controladores como manejadores, puedes realizar la redirección así de fácil:

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

Finalmente, puede realizar redirecciones en su middleware (si lo esta utilizando). Más adelante hay un ejemplo, en la sección pertinente.

### URLs

Otra característica de las rutas es la posibilidad de crear rutas nombradas y generar URLs para estas rutas.

Tendrá que nombrar sus rutas para aprovechar esta función. Esto puede lograrse con el método `setName()` que esta expuesto por el método Http (`get`, `post`, etc.) en nuestra aplicación;

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

Si está utilizando el objeto [Phalcon\Mvc\Micro\Collection](api/phalcon_mvc#mvc-micro-collection), el nombre debe ser el tercer parámetro de los métodos que configuran las rutas.

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

Por último, necesita el componente [Phalcon\Url](url) para generar URLs para las rutas nombradas.

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

## Inyector de Dependencias

Cuando se crea una micro aplicación, un contenedor de servicios de [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) se crea automáticamente.

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

También puede crear su propio contenedor DI y asignarlo a la micro aplicación, por lo tanto, puedes manipular los servicios según las necesidades de tu aplicación.

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

También puedes utilizar la sintaxis de vector para registrar servicios en el contenedor de inyección de dependencias desde el objeto de la aplicación:

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

## Respuestas

Una micro aplicación puede retornar muchos tipos de respuestas. Una salida directa, utilizar un motor de plantillas, calcular datos, una vista basada en datos, JSON, etc.

Los Manejadores pueden devolver respuestas simples utilizando texto sin formato, mediante el objeto [Phalcon\Http\Response](api/phalcon_http#http-response) o con un componente personalizado que implemente [Phalcon\Http\ResponseInterface](api/phalcon_http#http-responseinterface).

### Directo

```php
<?php

$app->get(
    '/invoices/view/{id}',
    function ($id) {
        echo "<h1>Invoice #{$id}!</h1>";
    }
);
```

### Incluyendo Archivos

```php
<?php

$app->get(
    '/invoices/view/{id}',
    function ($id) {
        require 'views/results.php';
    }
);
```

### JSON Directo

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

### Nueva respuesta

Puede utilizar el método `setContent` de un nuevo objeto [Phalcon\Http\Response](api/phalcon_http#http-response) para devolver la respuesta.

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

### Respuesta de la Aplicación

También puede utilizar [Phalcon\Http\Response](api/phalcon_http#http-response) de la aplicación para devolver respuestas al llamante.

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

### Devolviendo Respuestas

Un método diferente para devolver los datos a la llamador, es devolver el objeto [Phalcon\Http\Response](api/phalcon_http#http-response) directamente desde la aplicación. Cuando las respuestas son devueltas por los manejadores, éstas se envían automáticamente por la aplicación.

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

## Eventos

Una aplicación [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) trabaja muy de cerca con el [Gestor de Eventos](events), si este está presente, para activar eventos que puedan ser utilizados a través de nuestra aplicación. El tipo de estos eventos es `micro`. Estos eventos se activan en nuestra aplicación y pueden adjuntarse a los manejadores pertinentes que realizan las acciones que son necesitadas por nuestra aplicación.

### Eventos Disponibles

Se soportan los siguientes eventos:

| Nombre de evento     | Disparado                                                                             | Puede detenerse |
| -------------------- | ------------------------------------------------------------------------------------- |:---------------:|
| `afterBinding`       | Activa después de que los modelos están enlazados pero antes de ejecutar el Manejador |       Si        |
| `afterExecuteRoute`  | Manejador acaba de terminar de correr                                                 |       No        |
| `afterHandleRoute`   | Ruta acaba de terminar su ejecución                                                   |       Si        |
| `beforeExecuteRoute` | Coincidencia en la Ruta, Manejador válido, el Manejador aún no ha sido ejecutado      |       Si        |
| `beforeHandleRoute`  | Método principal llamado; Las rutas no han sido verificadas aún                       |       Si        |
| `beforeNotFound`     | Ruta no ha sido encontrada                                                            |       Si        |

### Ejemplo de Autenticación

Puede comprobar fácilmente si un usuario se ha autenticado o no usando el evento `beforeExecuteRoute`. El siguiente ejemplo demuestra dicho escenario:

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

### Ejemplo de Not Found

También puede crear una redirección para una ruta que no existe (404). Para ello puede usar el evento `beforeNotFound`. El siguiente ejemplo demuestra dicho escenario:

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

*Middleware* son clases que se pueden adjuntar a su aplicación e introducen otra capa donde pueda existir la lógica de negocio. Se ejecutan secuencialmente, según el orden en el que se registran, y no sólo mejora el mantenimiento, por encapsular funcionalidad específica, sino también el rendimiento. Una clase *middleware* puede detener la ejecución cuando una regla de negocio particular no se ha satisfecho, permitiendo así que la aplicación salga antes sin ejecutar el ciclo completo de una petición.

> **NOTA**: El middleware manejado por la Micro aplicación **no son** compatibles con [PSR-15](https://www.php-fig.org/psr/psr-15/). En futuras versiones de Phalcon, toda la capa HTTP se reescribirá para alinearse con PSR-7 y PSR-15.
{: .alert .alert-info }

La presencia de un [Phalcon\Events\Manager](api/phalcon_events#events-manager) es esencial para que funcione el *middleware*, así que tiene que registrarse en nuestro contenedor DI.

### Eventos adjuntos

*Middleware* se puede adjuntar a una aplicación micro en 3 eventos distintos. Estos son:

| Evento   | Descripción                                                                   |
| -------- | ----------------------------------------------------------------------------- |
| `before` | Antes de que el manejador haya sido ejecutado                                 |
| `after`  | Después de que el manejador haya sido ejecutado                               |
| `finish` | Después de que la respuesta ha sido enviada al componente que hizo la llamada |

> **NOTA**: Es posible adjuntar todas las clases middleware que desee en cada uno de estos eventos. Estas serán ejecutadas secuencialmente cuando el evento sera ejecutado.
{: .alert .alert-warning }

**before**

Este evento es perfecto para detener la ejecución de una aplicación si cierto criterio no se cumple. En el ejemplo siguiente estamos comprobando si el usuario se ha autenticado y paramos la ejecución con la redirección necesaria.

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

El código anterior se ejecuta antes de que se ejecute cada ruta. Al devolver `false` se cancela la ejecución de la ruta.

**after**

Este evento se puede usar para manipular datos o realizar acciones necesarias después de que el manejador haya terminado de ejecutarse.

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

En el ejemplo anterior, el manejador devuelve un vector de datos. El evento `after` llama a `json_encode`, devolviendo así un JSON válido.

> **NOTA**: Necesitarás hacer un poco más de trabajo aquí para establecer los encabezados necesarios para JSON. Una alternativa al código anterior sería usar el objeto *Response* y `setJsonContent`
{: .alert .alert-info }

**finish**

Este evento se disparará cuando se ha completado todo el ciclo de la petición.

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

En el ejemplo anterior usamos el evento `finish` para hacer algo de limpieza de caché.

### Activación

Adjuntar *middleware* a su aplicación es muy fácil como se ha visto antes, con las llamadas a los métodos `before`, `after` y `finish`.

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

También puede usar clases y adjuntarlas al Gestor de Eventos como oyente. Usar este enfoque ofrece más flexibilidad y reduce el tamaño de fichero de arranque, ya que la lógica *middleware* está encapsulada en un fichero por *middleware*.

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

Necesitamos un objeto [Phalcon\Events\Manager](api/phalcon_events#events-manager). Puede ser un objeto recién instanciado o podemos obtener el existente de nuestro contenedor DI (si ha usado `FactoryDefault`, o si no ha configurado un contenedor DI, ya que será creado automáticamente para usted).

Adjuntamos cada clase middleware en el ancla `micro` en el Gestor de Eventos. También podría ser un poco más específico y adjuntarlo al evento `micro:beforeExecuteRoute`.

Entonces adjuntamos la clase *middleware* en nuestra aplicación sobre uno de los tres eventos oyentes mencionados anteriormente (`before`, `after`, `finish`).

### Implementación

El *middleware* puede ser cualquier tipo de función PHP invocable. Puede organizar su código de la forma que más le guste para implementar el *middleware*. Si elige usar clases para su *middleware*, necesitará implementar [Phalcon\Mvc\Micro\MiddlewareInterface](api/phalcon_mvc#mvc-micro-middlewareinterface)

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

### Eventos Middleware

Los [eventos](#events) que se disparan por nuestra aplicación también se disparan dentro de una clase que implemente [Phalcon\Mvc\Micro\MiddlewareInterface](api/phalcon_mvc#mvc-micro-middlewareinterface). Esto ofrece una gran flexibilidad y poder para los desarrolladores ya que podemos interactuar con los procesos solicitados.

**Ejemplo API**

Supongamos que tenemos un API que hemos implementado con la aplicación Micro. Necesitamos adjuntar diferentes clases *Middleware* para poder controlar mejor la ejecución de la aplicación.

Los *middleware* que usaremos son:

* Cortafuegos
* No Encontrado
* Redirección
* CORS
* Petición
* Respuesta

**Middleware Cortafuegos**

Este *middleware* se adjunta al evento `before` de nuestra aplicación Micro. El propósito de este middleware es comprobar quién está llamando a nuestra API y basado en una lista blanca, permitirles continuar o no

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

**Middleware No Encontrado (404)**

Cuando se procesa este *middleware*, significa que la IP solicitante puede acceder a nuestra aplicación. La aplicación intentará hacer coincidir la ruta y si no la encuentra disparará el evento `beforeNotFound`. Entonces detendremos el procesamiento y devolveremos al usuario la respuesta 404 relevante. Este *middleware* se adjunta al evento `before` de nuestra aplicación Micro

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
     * @param Event $event
     * @param Micro $application
     *
     * @returns bool
     */
    public function beforeNotFound(Event $event, Micro $application)
    {
        $application->response->redirect('/404');
        $application->response->send();

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

**Middleware Redirección**

Adjuntamos este *middleware* otra vez al evento `before` de nuestra aplicación Micro porque no queremos que la petición se procese si el destino solicitado tiene que ser redirigido.

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

#### Middleware CORS

Otra vez este *middleware* se adjunta al evento `before` de nuestra aplicación Micro. Necesitamos asegurarnos que se dispara antes de que ocurra cualquier cosa en nuestra aplicación

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

**Middleware Petición**

Este *middleware* recibe una carga útil JSON y la comprueba. Si la carga útil JSON no es válida detendrá la ejecución.

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

**Middleware Respuesta**

Este *middleware* es responsable de manipular nuestra respuesta y devolverla al que llama como una cadena JSON. Por lo tanto, necesitamos adjuntarlo al evento `after` de nuestra aplicación Micro.

> **NOTA**: Usaremos el método `call` de este middleware, ya que casi hemos ejecutado el ciclo completo de la petición.
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

### Modelos

Los modelos se pueden usar en aplicaciones Micro, siempre y cuando se indique a la aplicación cómo puede encontrar las clases relevantes con el autocargador.

> **NOTA**: El servicio `db` debe estar registrado en el contenedor de DI.
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

### Inyección del modelo

Al usar la clase [Phalcon\Mvc\Model\Binder](api/phalcon_mvc#mvc-model-binder) puede inyectar instancias de modelos en sus rutas:

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

Ya que el objeto `Binder</em> está usando internamente la API Reflexión de PHP, que requiere ciclos de CPU adicionales, hay una opción para configurar un caché que acelere el proceso. Esto se puede hacer usando el segundo argumento de <code>setModelBinder()` que puede aceptar un nombre de servicio o simplemente pasarle una instancia de caché al constructor `Binder`.

Actualmente, el vinculador (binder) solo utilizará la clave primaria de los modelos para realizar un `findFirst()`. Un ejemplo de ruta para lo anterior sería `/invoices/view/1`.

### Vistas

[Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) no tiene inherentemente un servicio vista. Sin embargo, podemos usar el componente [Phalcon\Mvc\View\Simple](api/phalcon_mvc#mvc-view-simple) para renderizar vistas.

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

> **NOTA**: El ejemplo anterior utiliza el componente [Phalcon\Mvc\View\Simple](api/phalcon_mvc#mvc-view-simple), que utiliza rutas relativas en lugar de controladores y acciones. Puedes utilizar el componente [Phalcon\Mvc\View](api/phalcon_mvc#mvc-view) en su lugar, pero para ello tendrás que cambiar los parámetros pasado a `render()`.
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

## Excepciones

Cualquier excepción lanzada en el componente [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) será del tipo [Phalcon\Mvc\Micro\Exception](api/phalcon_mvc#mvc-micro-exception). Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

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

### Manejo de Errores

La aplicación [Phalcon\Mvc\Micro](api/phalcon_mvc#mvc-micro) también tiene un método `error`, que se puede usar para atrapar cualquier error originado desde excepciones. El siguiente fragmento de código muestra un uso básico de esta característica:

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
