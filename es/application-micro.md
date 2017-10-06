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

Las rutas se pueden definir mediante el objeto de aplicación `Phalcon\Mvc\Micro`, de la siguiente manera:

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

También puedes crear un objeto `Phalcon\Mvc\Router`, establece las rutas en el y luego debes inyectarlo en el contenedor del inyector de dependencias.

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

También podemos usar un método estático como nuestro manejador, como se muestra a continuación:

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

Con `Phalcon\Mvc\Micro` puedes crear micro o medianas aplicaciones. Estas últimas utilizan la arquitectura micro pero se amplían para utilizar más características que las aplicaciones Micro pero no tantas como lo hace una aplicación completa.

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
        $context = "<h1>This is order: {$name}!</h1>";
        $this->response->setContext($context);

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

Coincide si el método HTTP es `POST` y la ruta es `/api/products`

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

También puede crear tu propio contenedor Di y asignarlo a la micro aplicación, por lo tanto, puedes manipular los servicios según las necesidades de tu aplicación.

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

Middleware are classes that can be attached to your application and introduce another layer where business logic can exist. They run sequentially, according to the order they are registered and not only improve mainainability, by encapsulating specific functionality, but also performance. A middleware class can stop execution when a particular business rule has not been satisfied, thus allowing the application to exit early without executing the full cycle of a request.

The presence of a `Phalcon\Events\Manager` is essential for middleware to operate, so it has to be registered in our Di container.

<a name='middleware-attached-events'></a>

## Attached events

Middleware can be attached to a micro application in 3 different events. Those are:

| Event  | Description                                    |
| ------ | ---------------------------------------------- |
| before | Before the handler has been executed           |
| after  | After the handler has been executed            |
| final  | After the response has been sent to the caller |

<div class="alert alert-warning">
    <p>
        You can attach as many middleware classes as you want in each of the above events. They will be executed sequentially when the relevant event fires.
    </p>
</div>

<a name='middleware-attached-events-before'></a>

### before

This event is perfect for stopping execution of the application if certain criteria is not met. In the below example we are checking if the user has been authenticated and stop execution with the necessary redirect.

```php
<?php

$app = new Phalcon\Mvc\Micro();

// Executed before every route is executed
// Return false cancels the route execution
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
        // This is executed after the route is executed
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

## Setup

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
 * Attach the middleware both to the events manager and the application
 */
$eventsManager->attach('micro', new CacheMiddleware());
$application->before(new CacheMiddleware());

$eventsManager->attach('micro', new NotFoundMiddleware());
$application->before(new NotFoundMiddleware());

/**
 * This one needs to listen on the `after` event
 */
$eventsManager->attach('micro', new ResponseMiddleware());
$application->after(new ResponseMiddleware());

/**
 * Make sure our events manager is in the DI container now
 */
$application->setEventsManager($eventsManager);

```

We need a `Phalcon\Events\Manager` object. This can be a newly instantiated object or we can get the one that exists in our DI container (if you have used the `FactoryDefault` one).

We attach every middleware class in the `micro` hook in the Events Manager. We could also be a bit more specific and attach it to say the `micro:beforeExecuteRoute` event.

We then attach the middleware class in our application on one of the three listening events discussed above (`before`, `after`, `finish`).

<a name='middleware-implementation'></a>

## Implementation

Middleware can be any kind of PHP callable functions. You can organize your code whichever way you like it to implement middleware. If you choose to use classes for your middleware, you will need them to implement the `Phalcon\Mvc\Micro\MiddlewareInterface`

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

<a name='middleware-events'></a>

## Events in Middleware

The [events](#events) that are triggered for our application also trigger inside a class that implements the `Phalcon\Mvc\Micro\MiddlewareInterface`. This offers great flexibility and power for developers since we can interact with the request process.

<a name='middleware-events-api'></a>

### API example

Assume that we have an API that we have implemented with the Micro application. We will need to attach different Middleware classes in the application so that we can better control the execution of the application.

The middleware that we will use are: * Firewall * NotFound * Redirect * CORS * Request * Response

<a name='middleware-events-api-firewall'></a>

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
 * Processes the 404s
 */
class NotFoundMiddleware implements MiddlewareInterface
{
    /**
     * The route has not been found
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

<a name='middleware-events-api-redirect'></a>

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
 * Checks the request and redirects the user somewhere else if need be
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
 * CORS checking
 */
class CORSMiddleware implements MiddlewareInterface
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

<a name='middleware-events-api-response'></a>

#### Response Middleware

This middleware is responsible for manipulating our response and sending it back to the caller as a JSON string. Therefore we need to attach it to the `after` event of our Micro application.

<div class='alert alert-warning'>
    <p>
        We are going to be using the <code>call</code> method for this middleware, since we have nearly executed the whole request cycle.
    </p>
</div>

```php
<?php

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
* ResponseMiddleware
*
* Manipulates the response
*/
class ResponseMiddleware implements MiddlewareInterface
{
     /**
      * Before anything happens
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

# Models

Models can be used in Micro applications, so long as we instruct the application how it can find the relevant classes with an autoloader.

<div class="alert alert-warning">
    <p>
        The relevant <code>db</code> service must be registered in your Di container.
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

# Inject model instances

By using the `Phalcon\Mvc\Model\Binder` class you can inject model instances into your routes:

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

<a name='views'></a>

# Views

`Phalcon\Mvc\Micro` does not have inherently a view service. We can however use the `Phalcon\Mvc\View\Simple` component to render views.

```php
<?php

$app = new Phalcon\Mvc\Micro();

$app['view'] = function () {
    $view = new \Phalcon\Mvc\View\Simple();

    $view->setViewsDir('app/views/');

    return $view;
};

// Return a rendered view
$app->get(
    '/products/show',
    function () use ($app) {
        // Render app/views/products/show.phtml passing some variables
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
        The above example uses the <a href="/[[language]]/[[version]]/Phalcon_Mvc_View_Simple">Phalcon\Mvc\View\Simple</a> component, which uses relative paths instead of controllers and actions. You can use the <a href="/[[language]]/[[version]]/Phalcon_Mvc_View">Phalcon\Mvc\View</a> component instead, but to do so you will need to change the parameters passed to <code>render()</code>
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

// Return a rendered view
$app->get(
    '/products/show',
    function () use ($app) {
        // Render app/views/products/show.phtml passing some variables
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

# Error Handling

The `Phalcon\Mvc\Micro` application also has an `error` method, which can be used to trap any errors that originate from exceptions. The following code snippet shows basic usage of this feature:

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