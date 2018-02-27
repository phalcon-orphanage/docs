<div class='article-menu'>
  <ul>
    <li>
      <a href="#creating-micro-application">Creando una Micro Aplicación</a>
    </li>
    <li>
      <a href="#routing">Ruteo</a> 
      <ul>
        <li>
          <a href="#routing-setup">Configuración</a> 
          <ul>
            <li>
              <a href="#routing-setup-application">El Objeto de la Aplicación</a>
            </li>
            <li>
              <a href="#routing-setup-router">El Objeto Ruoter</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#rewrite-rules">Reglas de reescritura</a>
        </li>
        <li>
          <a href="#routing-handlers">Manejadores</a> <ul>
            <li>
              <a href="#routing-handlers-definitions">Definiciones</a> 
              <ul>
                <li>
                  <a href="#routing-handlers-anonymous-function">Funciones anónimas</a>
                </li>
                <li>
                  <a href="#routing-handlers-function">Funciones</a>
                </li>
                <li>
                  <a href="#routing-handlers-static-method">Método estático</a>
                </li>
                <li>
                  <a href="#routing-handlers-object-method">Método en un objeto</a>
                </li>
                <li>
                  <a href="#routing-handlers-controllers">Controladores</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#routing-handlers-controllers-lazy-loading">Carga perezosa (Lazy Load)</a> 
              <ul>
                <li>
                  <a href="#routing-handlers-controllers-lazy-loading-use-case">Casos de uso</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#routing-handlers-not-found">Not Found (404)</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#routing-verbs">Métodos - verbos</a> 
          <ul>
            <li>
              <a href="#routing-verb-delete">delete</a>
            </li>
            <li>
              <a href="#routing-verb-get">get</a>
            </li>
            <li>
              <a href="#routing-verb-head">head</a>
            </li>
            <li>
              <a href="#routing-verb-map">map</a>
            </li>
            <li>
              <a href="#routing-verb-options">options</a>
            </li>
            <li>
              <a href="#routing-verb-patch">patch</a>
            </li>
            <li>
              <a href="#routing-verb-post">post</a>
            </li>
            <li>
              <a href="#routing-verb-put">put</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#routing-collections">Colecciones</a>
        </li>
        <li>
          <a href="#routing-parameters">Parámetros</a>
        </li>
        <li>
          <a href="#routing-redirections">Redirecciones</a>
        </li>
        <li>
          <a href="#routing-urls-for-routes">URLs para Rutas</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#dependency-injector">Inyector de Dependencias</a>
    </li>
    <li>
      <a href="#responses">Respuestas</a> 
      <ul>
        <li>
          <a href="#responses-direct-output">Salida Directa</a>
        </li>
        <li>
          <a href="#responses-include">Incluir Otro Archivo</a>
        </li>
        <li>
          <a href="#responses-direct-output-json">Salida Directa JSON</a>
        </li>
        <li>
          <a href="#responses-new-response-object">Nuevo Objeto Response</a>
        </li>
        <li>
          <a href="#responses-application-response">Respuesta de la Aplicación</a>
        </li>
        <li>
          <a href="#responses-return-application-response">Devolver Respuestas de la Aplicación</a>
        </li>
        <li>
          <a href="#responses-json">JSON</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#events">Eventos</a> 
      <ul>
        <li>
          <a href="#events-available-events">Eventos Disponibles</a> <ul>
            <li>
              <a href="#events-available-events-authentication">Ejemplo de Autenticación</a>
            </li>
            <li>
              <a href="#events-available-events-not-found">Ejemplo de Not Found</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <li>
      <a href="#middleware">Middleware</a> <ul>
        <li>
          <a href="#middleware-attached-events">Eventos adjuntos</a> 
          <ul>
            <li>
              <a href="#middleware-attached-events-before">before</a>
            </li>
            <li>
              <a href="#middleware-attached-events-after">after</a>
            </li>
            <li>
              <a href="#middleware-attached-events-finish">finish</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#middleware-implementation">Implementación</a>
        </li>
        <li>
          <a href="#middleware-setup">Configuración</a>
        </li>
        <li>
          <a href="#middleware-events">Eventos en Middleware</a> 
          <ul>
            <li>
              <a href="#middleware-events-api">Ejemplo de API</a> 
              <ul>
                <li>
                  <a href="#middleware-events-api-firewall">Firewall Middleware</a>
                </li>
                <li>
                  <a href="#middleware-events-api-not-found">Not Found Middleware</a>
                </li>
                <li>
                  <a href="#middleware-events-api-redirect">Redirección en Middleware</a>
                </li>
                <li>
                  <a href="#middleware-events-api-cors">CORS Middleware</a>
                </li>
                <li>
                  <a href="#middleware-events-api-request">Solicitud Middleware</a>
                </li>
                <li>
                  <a href="#middleware-events-api-response">Respuesta Middleware</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <li>
      <a href="#models">Modelos</a>
    </li>
    <li>
      <a href="#model-instances">Inyectando instancias de modelos</a>
    </li>
    <li>
      <a href="#views">Vistas</a>
    </li>
    <li>
      <a href="#error-handling">Manejo de Errores</a>
    </li>
  </ul>
</div>

# Micro Aplicaciones

Phalcon ofrece una aplicación muy 'fina', para que pueda crear 'Micro' aplicaciones con un mínimo de código PHP.

Las Micro Aplicaciones son convenientes para aplicaciones pequeñas que van a tener un uso muy ligero. Este tipo de aplicaciones es, por ejemplo, nuestro [sitio web](https://github.com/phalcon/website), este sitio web ([docs](https://github.com/phalcon/docs)), nuestra [tienda](https://github.com/phalcon/store), APIs, prototipos etc.

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

La clase `Phalcon\Mvc\Micro` es la responsable de crear una Micro Aplicación.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();
```

<a name='routing'></a>

## Ruteo

Es muy fácil definir rutas en una aplicación `Phalcon\Mvc\Micro`. Las rutas se definen de la siguiente manera:

```text
   Aplicación -> (método/verbo) -> (url de la ruta/expresión regular, función PHP de llamada)
```

<a name='routing-setup'></a>

### Configuración

El enrutamiento se controla mediante el objeto `Phalcon\Mvc\Router`. [[más información](/[[language]]/[[version]]/routing)]

<div class="alert alert-danger">
    <p>
        Las rutas deben empezar siempre con <code>/</code>
    </p>
</div>

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

Las rutas se pueden definir mediante el objeto de aplicación `Phalcon\Mvc\Micro`, de la siguiente forma:

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

También puedes crear un objeto `Phalcon\Mvc\Router`, establecer las rutas en el y luego debes inyectarlo en el contenedor del inyector de dependencias.

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

Configurar las rutas usando los métodos (`get`, `post`, etc.) del objeto `Phalcon\Mvc\Micro` de micro aplicaciones es mucho más fácil que crear un objeto de enrutador con rutas pertinentes y luego inyectarla en la aplicación.

Cada método tiene sus ventajas y desventajas. Todo depende del diseño y necesidades de tu aplicación.

<a name='rewrite-rules'></a>

## Reglas de Reescritura

Para que las rutas funcionen, ciertos cambios de configuración deben hacerse en la configuración de tu servidor web para cada sitio web en particular.

Estos cambios están descritos en las reglas de reescritura de [Apache](http://httpd.apache.org/docs/current/rewrite/) o [NGINX](https://www.nginx.com/blog/creating-nginx-rewrite-rules/), dependiendo del servidor que este utilizado.

<a name='routing-handlers'></a>

## Manejadores

Los Manejadores (Handlers), son piezas de código accesibles que están vinculados a una ruta. Cuando una ruta es igualada, el manejador es ejecutado con todos los parámetros definidos. Un manejador es cualquier código accesible que existe en PHP.

<a name='routing-handlers-definitions'></a>

### Definiciones

Phalcon ofrece varias formas de conectar un manejador a una ruta. Las necesidades de tu aplicación y su diseño así como el estilo de codificación serán los factores que influyan en la manera que implementes esto.

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

Acceder al objeto `$app` dentro de la función anónima puede lograrse mediante la inyección de esta, de la siguiente manera:

```php
$app->get(
    '/orders/display/{name}',
    function ($name) use ($app) {
        $content = "<h1>Esta es la orden: {$name}!</h1>";
        $app->response->setContent($content);
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

Con `Phalcon\Mvc\Micro` puedes crear micro o medianas aplicaciones. Estas últimas utilizan la arquitectura de micro pero se amplían para que utilicen más características que las aplicaciones Micro pero no tantas como lo hace una aplicación completa.

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

Puesto que nuestros controladores extienden de la clase `Phalcon\Mvc\Controller`, todos los servicios de la inyección de dependencias están disponibles con sus nombres de registro respectivos. Por ejemplo:

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
        $content = "<h1>Esta es la orden: {$name}!</h1>";
        $this->response->setContent($content);

        return $this->response;
    }
}
```

<a name='routing-handlers-controllers-lazy-loading'></a>

### Carga Perezosa (Lazy Load)

Con el fin de aumentar el rendimiento, podrías considerar aplicar la Carga Perezosa (Lazy Load) para tus controladores (handlers). El controlador será cargado solamente si la ruta pertinente es vinculada.

La carga perezosa puede lograrse fácilmente cuando el manejador es establecido en una `Phalcon\Mvc\Micro\Collection`:

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

Esta implementación carga cada controlador a su vez y lo monta en nuestro objeto de aplicación. El problema con este enfoque es que cada petición dará lugar a sólo un punto final y por lo tanto de la ejecución de un método de la clase. Los métodos/manejadores restantes sólo permanecerán en la memoria sin ser utilizados.

Utilizando Carga Perezosa, podemos reducir el número de objetos cargados en memoria y como resultado nuestra aplicación utiliza menos memoria.

La implementación anterior cambia si queremos usar la carga perezosa de la siguiente manera:

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

// Manejador Users
$users = new MicroCollection();
$users->setHandler('UsersController', true);
$users->setPrefix('/users');
$users->get('/get/{id}', 'get');
$users->get('/add/{payload}', 'add');
$app->mount($users);

// Manejador Orders
$orders = new MicroCollection();
$orders->setHandler('OrdersController', true);
$orders->setPrefix('/users');
$orders->get('/get/{id}', 'get');
$orders->get('/add/{payload}', 'add');
$app->mount($orders);

// Manejador Products
$products = new MicroCollection();
$products->setHandler('ProductsController', true);
$products->setPrefix('/products');
$products->get('/get/{id}', 'get');
$products->get('/add/{payload}', 'add');
$app->mount($products);
```

Con este simple cambio en la aplicación, todos los manejadores permanecen sin ser instanciados hasta que son solicitados. Por lo tanto cuando alguien hace una petición a `/orders/get/2`, nuestra aplicación crea una instancia de `OrdersController` y llama al método `get`. Nuestra aplicación ahora consume menos recursos que antes.

<a name='routing-handlers-not-found'></a>

### No encontrado (404)

Cualquier ruta que no haya sido vinculada en nuestra aplicación `Phalcon\Mvc\Micro` hará que se intente ejecutar el manejador definido con el método `notFound`. Similar a otros métodos/verbos (`get`, `post` etc.), puedes registrar un manejador en el método `notFound` que puede ser cualquier función PHP accesible.

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

La aplicación `Phalcon\Mvc\Micro` proporciona un conjunto de métodos para enlazar el método HTTP con la ruta que se pretende.

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
    $app->head(
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

Coincide si el método HTTP es `POST` y la ruta es `/api/products/add`

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

Las colecciones son una forma útil de agrupar colecciones vinculadas un manejador y un prefijo común (si es necesario). Para un hipotético punto de acceso `/orders` podríamos tener los siguientes puntos de acceso:

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

<div class='alert alert-warning'>
    <p>
        El nombre que con el que unimos cada ruta tiene un sufijo de <code>Action</code>. Esto no es necesario, el método puede ser llamado de cualquier forma que te guste.
    </p>
</div>

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

Información adicional: `Phalcon\Mvc\Router` [Info](/[[language]]/[[version]]/routing)

<a name='routing-redirections'></a>

## Redirecciones

Se puede redireccionar una ruta coincidente a otra mediante el objeto `Phalcon\Http\Response`, al igual que en una aplicación completa.

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

Por último, puedes realizar redirecciones en el middleware (si lo usas). Un ejemplo se muestra a continuación en la sección correspondiente.

<a name='routing-urls-for-routes'></a>

## URLs para Rutas

Otra característica de las rutas es la creación de rutas nombradas y la generación de URLs para estas rutas. Se trata de un proceso de dos pasos.

* Primero tenemos que nombrar nuestra ruta. Esto puede lograrse con el método `setName()` que es presentado por los métodos/verbos (`get`, `post`, etc.) en nuestra aplicación

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

* Segundo tenemos que utilizar el componente `Phalcon\Mvc\Url` para generar las URLs para las rutas nombradas.

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

Cuando se crea una micro aplicación, un contenedor de servicios de `Phalcon\Di\FactoryDefault` se crean implícitamente.

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
<?php

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

Los Manejadores pueden devolver respuestas simples utilizando texto sin formato, mediante el objeto `Phalcon\Http\Response` o con un componente personalizado que implemente `Phalcon\Http\ResponseInterface`.

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

Puedes utilizar el método `setContent` del objeto Response para devolver la respuesta nuevamente:

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

También puedes utilizar el objeto `Phalcon\Http\Response` para devolver las respuestas al objeto que realizó la llamada. El objeto Response tiene muchos métodos útiles que hacen que devolver las respuestas sea mucho más fácil.

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

Un enfoque diferente para regresar datos al objeto que realizó la llamada, es devolver el objeto Response directamente desde la aplicación. Cuando las respuestas son devueltas por los manejadores, éstas se envían automáticamente por la aplicación.

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

Devolver datos JSON es muy sencillo, solo debes usar el objeto `Phalcon\Http\Response`:

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

Una aplicación `Phalcon\Mvc\Micro` trabaja muy de cerca con `Phalcon\Events\Manager`, si este está presente, para activar eventos que puedan ser utilizados a través de nuestra aplicación. El tipo de estos eventos es `micro`. Estos eventos se activan en nuestra aplicación y pueden adjuntarse a los manejadores pertinentes que realizan las acciones que son necesitadas por nuestra aplicación.

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

Otro evento incorporado que se puede utilizar para implementar la lógica de negocio es `beforeNotFound`. En el ejemplo siguiente se muestra una de las maneras de manejar las solicitudes de una dirección inexistente:

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

Middleware son clases que pueden adjuntarse a su solicitud y presentar otra capa donde la lógica de negocio puede existir. Se ejecutan secuencialmente, según el orden que están registrados y no sólo mejoran el mantenimiento, mediante el encapsulamiento de funcionalidades específicas, sino también el rendimiento. Una clase middleware puede detener la ejecución cuando una regla de negocio particular no haya sido satisfactoria, lo que permite a la aplicación salir antes de tiempo sin ejecutar el ciclo completo de una solicitud.

La presencia de un `Phalcon\Events\Manager` es esencial para el middleware al operar, por lo que tiene estar registrado en nuestro contenedor Di.

<a name='middleware-attached-events'></a>

## Eventos adjuntos

Middleware se puede adjuntar a una micro aplicación en 3 diferentes eventos. Estos son:

| Evento | Descripción                                                                   |
| ------ | ----------------------------------------------------------------------------- |
| before | Antes de que el manejador haya sido ejecutado                                 |
| after  | Después de que el manejador haya sido ejecutado                               |
| final  | Después de que la respuesta ha sido enviada al componente que hizo la llamada |

<div class="alert alert-warning">
    <p>
        Puede colocar tantas clases de middleware como quieras en cada uno de los eventos antes mencionados. Se ejecutarán secuencialmente cuando el evento es disparado.
    </p>
</div>

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

Esto se ejecuta cuando se ha completado el ciclo de toda petición. En el ejemplo siguiente, la utilizamos para limpiar algunos archivos de caché.

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

Necesitamos un objeto `Phalcon\Events\Manager`. Esto puede ser una nueva instancia del objeto o podemos conseguir uno que exista en nuestro contenedor de DI (si has usado el de `FactoryDefault`).

Conectamos cada clase middleware en el conector `micro` del administrador de eventos. También podríamos ser un poco más específicos y conectarlo, por ejemplo, al evento `micro:beforeExecuteRoute`.

Entonces conectamos la clase de middleware en nuestra aplicación en uno de los tres eventos comentados anteriormente (`before`, `after`, `finish`).

<a name='middleware-implementation'></a>

## Implementación

Un Middleware puede ser cualquier tipo de función PHP accesible. Puedes organizar el código del modo te guste para implementar un middleware. Si eliges utilizar las clases para el middleware, necesitarás que implementen la clase `Phalcon\Mvc\Micro\MiddlewareInterface`

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

Los [eventos](#events) que se activan para nuestra aplicación también accionan eventos internamente de una clase que implementa `Phalcon\Mvc\Micro\MiddlewareInterface`. Esto ofrece una gran flexibilidad y potencial para los desarrolladores, ya que podemos interactuar con el proceso de solicitud.

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

Este middleware se conecta al evento `before` de nuestra Micro aplicación. El propósito de este middleware es verificar quién está llamando nuestra API y basado en una lista blanca, para permitir que se proceda o no

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

De nuevo, este middleware se conecta al evento `before` de nuestra Micro aplicación. Tenemos que garantizar que esto se active antes de que algo suceda con nuestra aplicación

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

<a name='middleware-events-api-request'></a>

#### Request Middleware

Este middleware está recibiendo una carga JSON y la revisa. Si la carga JSON no es válida detiene la ejecución.

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

<div class='alert alert-warning'>
    <p>
        Usaremos el método <code>call</code> de este middleware, ya que casi hemos ejecutado el ciclo completo de la petición.
    </p>
</div>

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

<div class="alert alert-warning">
    <p>
        El servicio <code>db</code> debe estar registrado en el contenedor de Di.
    </p>
</div>

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

Mediante el uso de la clase `Phalcon\Mvc\Model\Binder` puedes inyectar instancias de modelos en tus rutas:

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

El objeto Binder internamente utiliza la Api Reflection lo cual puede ser muy pesado, pero se puede configurar un caché para acelerar el proceso. Esto puede hacerse mediante el segundo argumento de `setModelBinder()` que también puede aceptar un nombre de servicio o simplemente pasando una instancia de caché al constructor `Binder`.

Actualmente Binder utiliza solamente de la clave primaria de los modelos para realizar un `findFirst()`. Una ruta de ejemplo para lo anterior podría ser `/products/1`.

<a name='views'></a>

# Vistas

`Phalcon\Mvc\Micro` no tiene inherentemente un servicio de vistas. Sin embargo podemos utilizar el componente `Phalcon\Mvc\View\Simple` para crear una vista.

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

<div class='alert alert-warning'>
    <p>
        El ejemplo anterior utiliza el componente <a href="/[[language]]/[[version]]/Phalcon_Mvc_View_Simple">Phalcon\Mvc\View\Simple</a>, que utiliza rutas relativas en lugar de los controladores y acciones. Puedes utilizar el componente <a href="/[[language]]/[[version]]/Phalcon_Mvc_View">Phalcon\Mvc\View</a> en su lugar, pero para ello tendrás que cambiar los parámetros pasados a <code>render()</code>
    </p>
</div>

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

La aplicación `Phalcon\Mvc\Micro` también tiene un método `error`, que puede utilizarse para atrapar los errores que se originan de las excepciones. El siguiente fragmento de código muestra el uso básico de esta función:

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