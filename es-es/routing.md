---
layout: default
language: 'es-es'
version: '4.0'
title: 'Enrutamiento'
upgrade: '#router'
keywords: 'enrutamiento, rutas'
---

# Componente de Enrutamiento

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

El componente [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) le permite definir rutas que son mapeadas a controladores o manejadores que reciben y pueden manejar la petición. El enrutador tiene dos modos: modo MVC y modo de sólo coincidencia. El primer modo es ideal para trabajar con aplicaciones MVC.

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
```

## Constantes

Hay dos constantes disponibles para el componente [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) que se usan para definir la posición de la ruta en la pila de procesamiento.

- `POSITION_FIRST`
- `POSITION_LAST`

## Métodos

```php
public function __construct(
    bool $defaultRoutes = true
)
```

Constructor Phalcon\Mvc\Router

```php
public function add(
    string $pattern, 
    mixed $paths = null, 
    mixed $httpMethods = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Añade una ruta al enrutador sin ninguna restricción HTTP

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

Añade una ruta al enrutador que sólo coincide si el método HTTP es `CONNECT`

```php
public function addDelete(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es `DELETE`

```php
public function addGet(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es `GET`

```php
public function addHead(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es `HEAD`

```php
public function addOptions(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es `OPTIONS`

```php
public function addPatch(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es `PATCH`

```php
public function addPost(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es `POST`

```php
public function addPurge(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es `PURGE` (soporte Squid y Varnish)

```php
public function addPut(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es `PUT`

```php
public function addTrace(
    string $pattern, 
    mixed $paths = null, 
    mixed $position = Router::POSITION_LAST
): RouteInterface
```

Añade una ruta al enrutador que sólo coincide si el método HTTP es `TRACE`

```php
public function attach(
    RouteInterface $route, 
    mixed $position = Router::POSITION_LAST
): RouterInterface
```

Adjunta un objeto `Route` a la pila de rutas.

```php
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Route;

class CustomRoute extends Route {
     // ...
}

$router = new Router();

$router->attach(
    new CustomRoute(
        "/about", 
        "About::index", 
        ["GET", "HEAD"]
    ),
    Router::POSITION_FIRST
);
```

```php
public function clear(): void
```

Elimina todas las rutas predefinidas

```php
public function getActionName(): string
```

Devuelve el nombre de la acción procesada

```php
public function getControllerName(): string
```

Devuelve el nombre del controlador procesado

```php
public function getMatchedRoute(): RouteInterface
```

Devuelve la ruta que coincide con el URI gestionado

```php
public function getMatches(): array
```

Devuelve las sub expresiones en la expresión regular coincidente

```php
public function getModuleName(): string
```

Devuelve el nombre del módulo procesado

```php
public function getNamespaceName(): string
```

Devuelve el nombre del espacio de nombres procesado

```php
public function getParams(): array
```

Devuelve los parámetros procesados

```php
public function getRouteById(
    mixed $id
): RouteInterface | bool
```

Devuelve un objeto de ruta por su identidad

```php
public function getRouteByName(
    string $name
): RouteInterface | bool
```

Devuelve un objeto de ruta por su nombre

```php
public function getRoutes(): RouteInterface[]
```

Devuelve todas las rutas definidas en el enrutador

```php
public function handle(string $uri): void
```

Gestiona la información de enrutamiento recibida del motor de reescritura

```php
$router->handle("/posts/edit/1");
```

```php
public function isExactControllerName(): bool
```

Devuelve si el nombre del controlador no debe ser destruido

```php
public function mount(
    GroupInterface $group
): RouterInterface
```

Monta un grupo de rutas en el enrutador

```php
public function notFound(
    mixed $paths
): RouterInterface
```

Establece un grupo de caminos a devolver cuando ninguna de las rutas definidas encajan

```php
public function removeExtraSlashes(
    bool $remove
): RouterInterface
```

Establece si el enrutador debe eliminar las barras adicionales en las rutas gestionadas

```php
public function setDefaultAction(
    string $actionName
): RouterInterface
```

Establece el nombre de acción predeterminado

```php
public function setDefaultController(
    string $controllerName
): RouterInterface
```

Establece el nombre predeterminado del controlador

```php
public function setDefaultModule(
    string $moduleName
): RouterInterface
```

Establece el nombre del módulo predeterminado

```php
public function setDefaultNamespace(
    string $namespaceName
): RouterInterface
```

Establece el nombre predeterminado del espacio de nombres

```php
public function setDefaults(
    array $defaults
): RouterInterface
```

Establece un vector de rutas por defecto. Si a una ruta le falta un camino el enrutador usará el definido aquí. No debería usarse este método para establecer una ruta 404

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

Devuelve un vector de parámetros predeterminados

```php
public function wasMatched(): bool
```

Comprueba si el enrutador coincide con alguna de las rutas definidas

## Definición de Rutas

[Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) proporciona capacidades avanzadas de enrutamiento. En el modo MVC, puede definir rutas y mapearlas a los controladores/acciones que necesite. Una ruta se define de la siguiente manera:

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
```

El primer parámetro del método `add()` es el patrón que tiene que encajar y, opcionalmente, el segundo parámetro es un conjunto de caminos. En el ejemplo anterior, para la URI `/admin/invoices/list`, se cargará `InvoicesController` y se llamará a `listAction`. Es importante recordar que el enrutador no ejecuta el controlador y la acción, solo recopila esta información y la envía al [Phalcon\Mvc\Dispatcher](dispatcher) que los ejecuta.

Una aplicación puede tener muchos caminos y definir rutas una a una puede ser una tarea engorrosa. [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) ofrece una forma fácil de registrar rutas.

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

En el ejemplo anterior, usamos comodines para hacer una ruta válida para muchas URIs. Por ejemplo, accediendo a la siguiente URL (`/admin/customers/view/12345/1`) produciría:

| Controlador | Acción | Parámetro | Parámetro |
|:-----------:|:------:|:---------:|:---------:|
| `customers` | `view` |  `12345`  |    `1`    |

El método `add()` recibe un patrón que, opcionalmente, puede tener marcadores de posición predefinidos y modificadores de expresiones regulares. Todos los patrones de enrutamiento deben empezar con un carácter de barra diagonal (`/`). La sintaxis de expresión regular usada es la misma que en las [expresiones regulares PCRE](https://www.php.net/manual/en/book.pcre.php).

> **NOTA**: No es necesario añadir delimitadores de expresiones regulares. Todos los patrones de ruta son insensibles a mayúsculas y minúsculas.
{: .alert .alert-info }

El segundo parámetro define como se deberían vincular las partes coincidentes con el controlador/acción/parámetros. Las partes coincidentes son marcadores de posición o subpatrones delimitados por paréntesis (corchetes redondos). En el ejemplo dado anteriormente, el primer subpatrón coincidente (`:controller`) es la parte del controlador de la ruta, el segundo la acción (`:action`) y después de eso cualquier parámetro pasado (`:params`).

Estos marcadores de posición hacen las expresiones de rutas más legibles y más fáciles de entender. Se soportan los siguientes marcadores de posición:

| Marcador       | Expresión regular        | Coincidencias                                                                                               |
| -------------- | ------------------------ | ----------------------------------------------------------------------------------------------------------- |
| `/:module`     | `/([a-zA-Z0-9\_\-]+)` | Nombre de módulo válido sólo con caracteres alfanuméricos                                                   |
| `/:controller` | `/([a-zA-Z0-9\_\-]+)` | Nombre de controlador válido sólo con caracteres alfanuméricos                                              |
| `/:action`     | `/([a-zA-Z0-9_-]+)`      | Nombre de acción válido sólo con caracteres alfanuméricos                                                   |
| `/:params`     | `(/.*)*`                 | Lista de palabras opcionales separadas por barras. Sólo usar este marcador de posición al final de una ruta |
| `/:namespace`  | `/([a-zA-Z0-9\_\-]+)` | Nombre del espacio de nombres de un solo nivel                                                              |
| `/:int`        | `/([0-9]+)`              | Parámetro entero                                                                                            |

Los nombres de controlador son camelizados, esto significa que los caracteres (`-`) y (`_`) son eliminados y el siguiente carácter se transforma en mayúscula. Por ejemplo, `some_controller` se convierte en `SomeController`.

Ya que puede añadir tantas rutas como necesite usando el método `add()`, el orden en el que se añaden las rutas indica su relevancia. Las rutas añadidas al final tienen más relevancia que las añadidas por encima de ellas. Internamente, todas las rutas definidas se recorren en orden inverso hasta que [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) encuentra la primera que coincide con la URI dada y la procesa, ignorando el resto.

### Parámetros Nombrados

El ejemplo siguiente demuestra como definir nombres en los parámetros de ruta:

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

En el ejemplo anterior, la ruta no define un `controlador` o `acción`. Estos son sustituidos por valores fijos (`invoices` y `view`). El usuario nunca conocerá el controlador subyacente enviado por la petición. En el controlador, a esos parámetros nombrados se puede acceder de la siguiente manera:

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

Tenga en cuenta que los valores de los parámetros se obtienen desde el despachador. También hay otra forma de crear parámetros nombrados como parte del patrón:

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

Puede acceder a esos valores de la misma manera que antes:

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

### Sintaxis Corta

[Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) también ofrece una alternativa, sintaxis más corta. Los siguientes ejemplos producen el mismo resultado:

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

### Sintaxis Vector y Corta

Las sintaxis de vector y corta se pueden mezclar para definir una ruta, en este caso tenga en cuenta que los parámetros nombrados automáticamente se añadirán a los caminos de la ruta de acuerdo a la posición en la que fueron definidos:

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

La primera posición se debe omitir porque se usa para el parámetro nombrado `year`.

### Módulos

Puede definir rutas con módulos en el camino. Esto es especialmente adecuado para aplicaciones multimódulo. Puede definir una ruta por defecto que incluya un comodín de módulo.

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

Con la ruta anterior, siempre necesita tener un nombre de módulo como parte de su URL. Por ejemplo, para la siguiente URL: `/admin/invoices/view/12345`, se procesará como:

| Módulo  | Controlador | Acción | Parámetro |
|:-------:|:-----------:|:------:|:---------:|
| `admin` | `invoices`  | `view` |  `12345`  |

O puede vincular rutas específicas con módulos específicos:

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

O vincularlas a espacios de nombres específicos:

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

El espacio de nombres completo se debe pasar por separado:

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

### Métodos HTTP

Cuando añade una ruta usando simplemente `add()`, la ruta se habilitará para cualquier método HTTP. A veces podemos restringir una ruta para un método específico. Esto es particularmente útil cuando creamos aplicaciones RESTful.

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

### Convertidores

Los convertidores son fragmentos de código que le permiten convertir los parámetros de una ruta antes de que se envíe al [despachador](dispatcher)

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

En el ejemplo anterior, el nombre del parámetro permite guiones, por lo que una URL puede ser `/products/new-ipod-nano-generation`. El método `convert` cambiará el parámetro a `newipodnanogeneration`.

Otro caso de uso para convertidores es cuando se vincula un modelo a una ruta. Esto permite que el modelo se pase directamente a la acción definida.

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

En el ejemplo anterior, el ID se pasa en la URL y nuestro convertidor obtiene el registro de la base de datos, pasándolo de vuelta.

### Grupos

Si un conjunto de rutas tiene caminos comunes se pueden agrupar para un mantenimiento más fácil. Para conseguir esto, usamos el componente [Phalcon\Mvc\Router\Group](api/phalcon_mvc#mvc-router-group)

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

En el ejemplo anterior, primero creamos un grupo con un módulo y controlador común. Entonces añadimos el prefijo `/invoices` al grupo. A continuación añadimos más rutas al grupo, algunas sin parámetros y algunas con. La última ruta nos permite usar un controlador diferente del predeterminado (`common`). Finalmente, añadimos el grupo al enrutador.

Podemos extender el componente [Phalcon\Mvc\Router\Group](api/phalcon_mvc#mvc-router-group) y registrar nuestras rutas en él en una base por grupos. Esto nos permite organizar mejor las rutas de nuestra aplicación.

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

Ahora podemos montar la clase de grupo personalizada en el enrutador:

```php
<?php

$router->mount(
    new InvoicesRoutes()
);
```

## Rutas Coincidentes

Se debe pasar una URI válida al Enrutador para que pueda procesarla y encontrar una ruta coincidente. Por defecto, la URL de enrutamiento se toma de la variable `$_GET['_url']` que se crea por el módulo del motor de reescritura. Un par de reglas de reescritura que funcionan muy bien con Phalcon son:

```apacheconfig
RewriteEngine On
RewriteCond   %{REQUEST_FILENAME} !-d
RewriteCond   %{REQUEST_FILENAME} !-f
RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
```

En esta configuración, cualquier petición a ficheros y carpetas que no existan se enviará a `index.php`. El siguiente ejemplo muestra como usar esto como un componente independiente:

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

En el ejemplo anterior, primero creamos un objeto enrutador. Podemos tener algo de código después de eso, como definición de servicios, rutas, etc.. Entonces cogemos el elemento `_url` del superglobal `$_GET` y después podemos obtener el nombre del controlador o el nombre de la acción o incluso recuperar la ruta coincidente.

## Nombrar Rutas

Cada ruta añadida al enrutador se almacena internamente como un objeto [Phalcon\Mvc\Router\Route](api/phalcon_mvc#mvc-router-route). Esa clase encapsula todos los detalles de cada ruta. Por ejemplo, podemos dar un nombre a un camino para identificarlo de forma única en nuestra aplicación. Esto es especialmente útil si quiere crear URLs desde ella.

```php
<?php

$route = $router->add(
    '/admin/{year:[0-9]{4}}/{month:[0-9]{2}}/{day:[0-9]{2}}/{id:[0-9]{4}',
    'Invoices::view'
);

$route->setName('invoices-view');
```

Entonces, usando por ejemplo el componente [Phalcon\Url](url) podemos construir rutas desde el nombre definido:

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

## Comportamiento Predeterminado

[Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) tiene un comportamiento predeterminado que proporciona un enrutado simple que siempre espera una URI y encaja con el siguiente patrón:

    /:controller/:action/:params
    

Por ejemplo, para una dirección URL como esta `https://dev.phalcon.od/download/linux/ubuntu.html`, este enrutador lo traducirá de la siguiente manera:

|     Controlador      |    Acción     |   Parámetro   |
|:--------------------:|:-------------:|:-------------:|
| `DownloadController` | `linuxAction` | `ubuntu.html` |

Si no desea que el enrutador tenga este comportamiento, debe crear el enrutador pasando `false` en el constructor.

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router(false);
```

## Ruta Predeterminada

Cuando se accede sin ninguna ruta a su aplicación, se usa la ruta `/` para determinar qué caminos se deben usar para mostrar la página inicial de su aplicación

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

## No Encontrado (404)

Si ninguna de las rutas, especificadas en el enrutador, coinciden, puede definir un controlador/acción 404 usando el método `notFound`.

```php
<?php

$router->notFound(
    [
        'controller' => 'index',
        'action'     => 'fourOhFour',
    ]
);
```

> **NOTA**: Esto sólo funcionará si el enrutador se creó sin rutas predeterminadas: `$router = Phalcon\Mvc\Router(false);`
{: .alert .alert-warning }

## Por Defecto

Puede definir valores por defecto para `módulo`, `controlador` y `acción`. Cuando a una ruta le falta cualquiera de estos elementos en su camino, el enrutador usará automáticamente el valor configurado por defecto.

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

## Barras Inclinadas

A veces se podría acceder a una ruta con barras diagonales adicionales o finales. Las barras adicionales producirán un estado no-encontrado en el despachador, que no es lo que queremos. Puede configurar el enrutador para que automáticamente elimine las barras del final de la ruta gestionada.

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router->removeExtraSlashes(true);
```

O, puede modificar rutas específicas para que acepten opcionalmente las barras finales:

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

En lo anterior, `[/]{0,1}` permite una barra final opcional

## Retorno de Llamada

A veces, las rutas sólo deberían encajar si cumplen condiciones específicas. Puede añadir condiciones arbitrarias a las rutas usando la función de retorno `beforeMatch`. Si esta función devuelve `false`, la ruta será tratada como no coincidente:

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

Lo anterior comprobará si la petición se ha hecho con AJAX y devuelve `false` en caso negativo

Puede crear una clase de filtro, para permitir inyectar la misma funcionalidad en diferentes rutas.

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

Para configurar esto, sólo añada la clase a la llamada `beforeMatch`.

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

Finalmente, puede usar el método (o evento) `beforeMatch` para comprobar si era una llamada AJAX o no.

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

## Nombre de Servidor

El componente [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) también permite restricciones de nombre de servidor. Esto significa que rutas específicas o un grupo de rutas se pueden restringir para solo coincidir con la ruta si se ha originado desde un nombre de servidor específico.

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

El nombre de servidor también se puede pasar como expresiones regulares:

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

Cuando usamos grupos de rutas, puede establecer las restricciones de nombre de servidor que se aplican a cada ruta del grupo.

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

## Pruebas

Este componente no tiene ninguna dependencia. Como tal puede crear pruebas unitarias para comprobar sus rutas.

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

## Eventos

Similar a otros componentes Phalcon, [Phalcon\Mvc\Router](api/phalcon_mvc#mvc-router) también tiene eventos, cuando está presente un [Gestor de Eventos](events). Los eventos disponibles son:

| Evento                     | Disparado cuando                            |
| -------------------------- | ------------------------------------------- |
| `router:afterCheckRoutes`  | Después de comprobar todas las rutas        |
| `router:beforeCheckRoute`  | Antes de comprobar una ruta                 |
| `router:beforeCheckRoutes` | Antes de comprobar todas las rutas cargadas |
| `router:beforeMount`       | Antes de montar una nueva ruta              |
| `router:matchedRoute`      | Cuando una ruta coincide                    |
| `router:notMatchedRoute`   | Cuando una ruta no coincide                 |

## Anotaciones

Este componente proporciona una variante que se integra con el servicio [anotaciones](annotations). Usando esta estrategia puede escribir las rutas directamente en los controladores en vez de añadirlas en el componente enrutador directamente.

```php
<?php

use Phalcon\Mvc\Router\Annotations;

$container['router'] = function () {
    $router = new Annotations(false);

    $router->addResource('Invoices', '/admin/invoices');

    return $router;
};
```

En el ejemplo anterior, usamos el componente [Phalcon\Mvc\Router\Annotations](api/phalcon_mvc#mvc-router-annotations) para configurar nuestras rutas. Pasamos `false` para eliminar el comportamiento predeterminado. Después de eso indicamos al componente que lea las anotaciones de `InvoicesController` si la URL encaja con `/admin/invoices`.

`InvoicesController` necesitará tener la siguiente implementación:

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

Sólo se usarán como rutas los métodos marcados con anotaciones válidas. Las anotaciones disponibles son:

| Anotación     | Descripción                                                                          | Uso                                |
| ------------- | ------------------------------------------------------------------------------------ | ---------------------------------- |
| `Delete`      | Restringe el método HTTP a `DELETE`                                                  | `@Delete('/invoices/delete/{id}')` |
| `Get`         | Restringe el método HTTP a `GET`                                                     | `@Get('/invoices/search')`         |
| `Options`     | Restringe el método HTTP a `OPTIONS`                                                 | `@Option('/invoices/info')`        |
| `Post`        | Restringe el método HTTP a `POST`                                                    | `@Post('/invoices/save')`          |
| `Put`         | Restringe el método HTTP a `PUT`                                                     | `@Put('/invoices/save')`           |
| `Route`       | Marca un método como una ruta. Debe colocarse en el docblock del método              | `@Route('/invoices/show')`         |
| `RoutePrefix` | Prefijo que se antepone a cada URI de ruta. Debe colocarse en el docblock del método | `@RoutePrefix('/invoices')`        |

Para las anotaciones que añaden rutas, se soportan los siguiente parámetros:

| Nombre       | Descripción                                    | Uso                                                                 |
| ------------ | ---------------------------------------------- | ------------------------------------------------------------------- |
| `converters` | Un hash de convertidores de parámetros         | `@Route('/posts/{id}/{slug}', converter={id='MyConverter::getId'})` |
| `methods`    | Uno o más métodos HTTP permitidos para la ruta | `@Route('/api/products', methods={'GET', 'POST'})`                  |
| `name`       | El nombre de la ruta                           | `@Route('/api/products', name='get-products')`                      |
| `paths`      | Vector de caminos para la ruta                 | `@Route('/invoices/view/{id}/{slug}', paths={module='backend'})`    |

Si está usando módulos en su aplicación, es mejor utilizar el método `addModuleResource()`:

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

Con lo anterior, leeremos las anotaciones de `Admin\Controllers\InvoicesController` si la URI empieza con `/admin/invoices`.

El enrutador también entiende los prefijos para asegurar que las rutas se resuelven lo más rápido posible. Por ejemplo, para las siguientes rutas:

    /clients/{clientId:[0-9]+}/
    /clients/{clientId:[0-9]+}/robots
    /clients/{clientId:[0-9]+}/parts
    

sólo el prefijo `/clients` se puede usar en todos los controladores, lo que acelera la búsqueda.

## Inyección de Dependencias

Puede registrar el componente enrutador durante la configuración del contenedor, para que esté disponible dentro de los controladores o cualquier otro componente que extienda el componente [Phalcon\Di\Injectable](api/phalcon_di#di-injectable).

Puede usar el ejemplo posterior en su archivo de arranque (por ejemplo `index.php` o `app/config/services.php` si usa [Herramientas de Desarrollador Phalcon](https://phalcon.io/en/download/tools)).

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

Necesita crear `app/config/routes.php` y añadir el código de inicialización del enrutador:

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

## Personalizado

Puede crear sus propios componentes implementando las interfaces proporcionadas: - [Phalcon\Mvc\Router\GroupInterface](api/phalcon_mvc#mvc-router-groupinterface) - [Phalcon\Mvc\Router\RouteInterface](api/phalcon_mvc#mvc-router-routeinterface) - [Phalcon\Mvc\RouterInterface](api/phalcon_mvc#mvc-routerinterface)

## Ejemplos

Los siguientes son ejemplos de rutas personalizadas:

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

> **NOTA**: Tenga cuidado cuando permita caracteres en expresiones regulares para controladores y espacios de nombres. Estos se convertirán en nombres de clases y a su vez interactuarán con el sistema de archivos. Como tal, es posible que un atacante pueda acceder a ficheros no autorizados. Una expresión regular segura es: `/([a-zA-Z0-9\_\-]+)`
{: .alert .alert-danger }
