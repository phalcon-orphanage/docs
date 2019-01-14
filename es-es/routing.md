* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Ruteo

El componente router le permite definir las rutas que se asignan a los controladores o gestores que deben recibir la solicitud. Un router simplemente procesa un URI para determinar esta información. El router tiene dos modos: MVC y match mode. El primer modo es ideal para trabajar con aplicaciones de MVC.

<a name='defining'></a>

## Definición de rutas

[Phalcon\Mvc\Router](api/Phalcon_Mvc_Router) provides advanced routing capabilities. En el modo MVC, se puede definir rutas y asignarlas a controladores/acciones. Una ruta se define de la siguiente manera:

```php
<?php

use Phalcon\Mvc\Router;

// Crear un Router
$router = new Router();

// Definir una ruta
$router->add(
    '/admin/users/my-profile',
    [
        'controller' => 'users',
        'action'     => 'profile',
    ]
);

// Otra ruta
$router->add(
    '/admin/users/change-password',
    [
        'controller' => 'users',
        'action'     => 'changePassword',
    ]
);

$router->handle();
````

El primer parámetro del método <code>add()</code> es el patrón que quieres coincidir, opcionalmente, el segundo parámetro es para definir los caminos.
En este caso, si el URI es '/admin/users/my-profile', entonces se ejecutará del controlador 'users' la acción 'profile'. It's important to remember that the router does not execute the controller and action, it only collects this information to inform the correct component (i.e. [Phalcon\Mvc\Dispatcher](api/Phalcon_Mvc_Dispatcher)) that this is the controller/action it should execute.

Una aplicación puede tener muchos caminos y definir rutas una por una puede ser una tarea engorrosa. En estos casos podemos crear rutas más flexibles:

```php
<?php

use Phalcon\Mvc\Router;

// Crear el router
$router = new Router();

// Definir una ruta
$router->add(
    '/admin/:controller/a/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ]
);
``` es el patrón que quieres coincidir, opcionalmente, el segundo parámetro es para definir los caminos.
En este caso, si el URI es '/admin/users/my-profile', entonces se ejecutará del controlador 'users' la acción 'profile'. It's important to remember that the router does not execute the controller and action, it only collects this information to inform the correct component (i.e. [Phalcon\Mvc\Dispatcher](api/Phalcon_Mvc_Dispatcher)) that this is the controller/action it should execute.

Una aplicación puede tener muchos caminos y definir rutas una por una puede ser una tarea engorrosa. En estos casos podemos crear rutas más flexibles:

```php
<?php

use Phalcon\Mvc\Router;

// Crear el router
$router = new Router();

// Definir una ruta
$router->add(
    '/admin/:controller/a/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ]
);
</code>

In the example above, we're using wildcards to make a route valid for many URIs. For example, by accessing the following URL (`/admin/users/a/delete/dave/301`) would produce:

| Controller | Action | Parameter | Parameter |
|:----------:|:------:|:---------:|:---------:|
|   users    | delete |   dave    |    301    |

The `add()` method receives a pattern that can optionally have predefined placeholders and regular expression modifiers. All the routing patterns must start with a forward slash character (`/`). The regular expression syntax used is the same as the [PCRE regular expressions](https://www.php.net/manual/en/book.pcre.php). Note that, it is not necessary to add regular expression delimiters. All route patterns are case-insensitive.

The second parameter defines how the matched parts should bind to the controller/action/parameters. Matching parts are placeholders or subpatterns delimited by parentheses (round brackets). In the example given above, the first subpattern matched (`:controller`) is the controller part of the route, the second the action and so on.

These placeholders help writing regular expressions that are more readable for developers and easier to understand. The following placeholders are supported:

| Marcador       | Expresión regular        | Uso                                                                                                                  |
| -------------- | ------------------------ | -------------------------------------------------------------------------------------------------------------------- |
| `/:module`     | `/([a-zA-Z0-9\_\-]+)` | Coincide con un nombre de módulo válido con caracteres alfanuméricos únicamente                                      |
| `/:controller` | `/([a-zA-Z0-9\_\-]+)` | Coincide con un nombre de controlador válido con caracteres alfanuméricos únicamente                                 |
| `/:action`     | `/([a-zA-Z0-9_-]+)`      | Coincide con un nombre de acción válido con caracteres alfanuméricos únicamente                                      |
| `/:params`     | `(/.*)*`                 | Coincide con una lista de palabras opcionales, separadas por barras. Sólo utilice este marcador al final de una ruta |
| `/:namespace`  | `/([a-zA-Z0-9\_\-]+)` | Coincide con un nombre de espacio de nombres de nivel único                                                          |
| `/:int`        | `/([0-9]+)`              | Coincide con un parámetro entero                                                                                     |

Controller names are camelized, this means that characters (`-`) and (`_`) are removed and the next character is uppercased. For instance, some_controller is converted to SomeController.

Since you can add many routes as you need using the `add()` method, the order in which routes are added indicate their relevance, latest routes added have more relevance than first added. Internally, all defined routes are traversed in reverse order until [Phalcon\Mvc\Router](api/Phalcon_Mvc_Router) finds the one that matches the given URI and processes it, while ignoring the rest.

<a name='defining-named-parameters'></a>

### Parámetros con nombres

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
        // Obtener el parámetro 'año'
        $year = $this->dispatcher->getParam('year');

        // Obtener el parámetro 'mes'
        $month = $this->dispatcher->getParam('month');

        // Obtener el parámetro 'día'
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
        // Obtener el parámetro 'nombre'
        $name = $this->dispatcher->getParam('name');

        // Obtener el parámetro 'tipo'
        $type = $this->dispatcher->getParam('type');

        // ...
    }
}
```

<a name='defining-short-syntax'></a>

### Sintaxis corta

If you don't like using an array to define the route paths, an alternative syntax is also available. The following examples produce the same result:

```php
<?php

// Forma corta
$router->add(
    '/posts/{year:[0-9]+}/{title:[a-z\-]+}',
    'Posts::show'
);

// Forma Array 
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

<a name='defining-mixed-parameters'></a>

### Mezcla de array y sintaxis corta

Array and short syntax can be mixed to define a route, in this case note that named parameters automatically are added to the route paths according to the position on which they were defined:

```php
<?php

// La primera posición se debe omitir porque se usa para
// el parámetro nombrado 'país'
$router->add(
    '/news/{country:[a-z]{2}}/([a-z+])/([a-z\-+])',
    [
        'section' => 2, // Las posiciones comienzan con 2
        'article' => 3,
    ]
);
```

<a name='defining-route-to-modules'></a>

### Enrutamiento a los módulos

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

| Módulo | Controller | Action | Parameter |
|:------:|:----------:|:------:|:---------:|
| admin  |   users    |  edit  |   sonny   |

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

<a name='defining-http-method-restrictions'></a>

### Restricciones del método HTTP

When you add a route using simply `add()`, the route will be enabled for any HTTP method. Sometimes we can restrict a route to a specific method, this is especially useful when creating RESTful applications:

```php
<?php

// Esta ruta solo se combinará si el método HTTP es GET
$router->addGet(
    '/products/edit/{id}',
    'Products::edit'
);

// Esta ruta solo se combinará si el método HTTP es POST
$router->addPost(
    '/products/save',
    'Products::save'
);

// Esta ruta se combinará si el método HTTP es POST o PUT
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

<a name='defining-using-conversors'></a>

### Utilizando conversores

Conversors allow you to freely transform the route's parameters before passing them to the dispatcher. The following examples show how to use them:

```php
<?php

// El nombre de la acción permite guiones, una acción puede ser: /products/new-ipod-nano-4-generation
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
        // Transformar la slug quitando los guiones
        return str_replace('-', '', $slug);
    }
);
```

Another use case for conversors is binding a model into a route. This allows the model to be passed into the defined action directly:

```php
<?php

// Este ejemplo se basa en la suposición de que el ID se está utilizando como parámetro en la url:
 /products/4
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
        // Obtener el modelo
        return Product::findFirstById($id);
    }
);
```

<a name='defining-groups-of-routes'></a>

### Grupos de rutas

If a set of routes have common paths they can be grouped to easily maintain them:

```php
<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;

$router = new Router();

// Crea un grupo con un módulo y un controlador común
$blog = new RouterGroup(
    [
        'module'     => 'blog',
        'controller' => 'index',
    ]
);

// Todas las rutas comienzan con /blog
$blog->setPrefix('/blog');

// Agrega una ruta al grupo
$blog->add(
    '/save',
    [
        'action' => 'save',
    ]
);

// Agregue otra ruta al grupo
$blog->add(
    '/edit/{id}',
    [
        'action' => 'edit',
    ]
);

// Esta ruta se asigna a un controlador diferente al predeterminado
$blog->add(
    '/blog',
    [
        'controller' => 'blog',
        'action'     => 'index',
    ]
);

// Agregue el grupo al enrutador
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
        // Rutas predeterminadas
        $this->setPaths(
            [
                'module'    => 'blog',
                'namespace' => 'Blog\Controllers',
            ]
        );

        // Todas las rutas comienzan con /blog
        $this->setPrefix('/blog');

        // Agrega una ruta al grupo
        $this->add(
            '/save',
            [
                'action' => 'save',
            ]
        );

        // Agregue otra ruta al grupo
        $this->add(
            '/edit/{id}',
            [
                'action' => 'edit',
            ]
        );

        // Esta ruta se asigna a un controlador diferente al predeterminado
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

// Agregue el grupo al enrutador
$router->mount(
    new BlogRoutes()
);
```

<a name='matching'></a>

## Rutas coincidentes

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

// Creando un enrutador
$router = new Router();

// Definir rutas aquí si alguna
// ...

// Tomando el URI de $_GET['_url']
$router->handle();

// O estableciendo el valor de URI directamente
$router->handle('/employees/edit/17');

// Obtener el controlador procesado
echo $router->getControllerName();

// Obtener la acción procesada
echo $router->getActionName();

// Obtener la ruta correspondiente
$route = $router->getMatchedRoute();
```

<a name='naming'></a>

## Nombres de rutas

Each route that is added to the router is stored internally as a [Phalcon\Mvc\Router\Route](api/Phalcon_Mvc_Router_Route) object. That class encapsulates all the details of each route. For instance, we can give a name to a path to identify it uniquely in our application. This is especially useful if you want to create URLs from it.

```php
<?php

$route = $router->add(
    '/posts/{year}/{title}',
    'Posts::show'
);

$route->setName('show-posts');
```

Then, using for example the component [Phalcon\Mvc\Url](api/Phalcon_Mvc_Url) we can build routes from its name:

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

<a name='usage'></a>

## Ejemplos de Uso

The following are examples of custom routes:

```php
<?php

// Coincidencia '/system/admin/a/edit/7001'
$router->add(
    '/system/:controller/a/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'params'     => 3,
    ]
);

// Coincidencia '/es/news'
$router->add(
    '/([a-z]{2})/:controller',
    [
        'controller' => 2,
        'action'     => 'index',
        'language'   => 1,
    ]
);

// Coincidencia '/es/news'
$router->add(
    '/{language:[a-z]{2}}/:controller',
    [
        'controller' => 2,
        'action'     => 'index',
    ]
);

// Coincidencia '/admin/posts/edit/100'
$router->add(
    '/admin/:controller/:action/:int',
    [
        'controller' => 1,
        'action'     => 2,
        'id'         => 3,
    ]
);

// Coincidencia '/posts/2015/02/some-cool-content'
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

// Coincidencia '/manual/en/translate.adapter.html'
$router->add(
    '/manual/([a-z]{2})/([a-z\.]+)\.html',
    [
        'controller' => 'manual',
        'action'     => 'show',
        'language'   => 1,
        'file'       => 2,
    ]
);

// Coincidencia /feed/fr/le-robots-hot-news.atom
$router->add(
    '/feed/{lang:[a-z]+}/{blog:[a-z\-]+}\.{type:[a-z\-]+}',
    'Feed::get'
);

// Coincidencia /api/v1/users/peter.json
$router->add(
    '/api/(v1|v2)/{method:[a-z]+}/{param:[a-z]+}\.(json|xml)',
    [
        'controller' => 'api',
        'version'    => 1,
        'format'     => 4,
    ]
);
```

<h5 class='alert alert-warning'>Beware of characters allowed in regular expression for controllers and namespaces. As these become class names and in turn they're passed through the file system could be used by attackers to read unauthorized files. A safe regular expression is: <code>/([a-zA-Z0-9\_\-]+)</code> </h5>

<a name='default-behavior'></a>

## Comportamiento predeterminado

[Phalcon\Mvc\Router](api/Phalcon_Mvc_Router) has a default behavior that provides a very simple routing that always expects a URI that matches the following pattern: `/:controller/:action/:params`

For example, for a URL like this `https://phalconphp.com/documentation/show/about.html`, this router will translate it as follows:

|  Controller   | Action | Parameter  |
|:-------------:|:------:|:----------:|
| documentation |  show  | about.html |

If you don't want the router to have this behavior, you must create the router passing `false` as the first parameter:

```php
<?php

use Phalcon\Mvc\Router;

// Crea el enrutador sin rutas predeterminadas
$router = new Router(false);
```

<a name='default-route'></a>

## Establecer la ruta por defecto

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

<a name='not-found-paths'></a>

## Rutas no encontradas

If none of the routes specified in the router are matched, you can define a group of paths to be used in this scenario:

```php
<?php

// Establecer camino 404
$router->notFound(
    [
        'controller' => 'index',
        'action'     => 'route404',
    ]
);
```

This is typically for an Error 404 page.

> Esto sólo funcionará si el router se creó sin rutas predeterminadas, osea: `$router = Phalcon\Mvc\Router(false);`

<a name='default-paths'></a>

## Configurar rutas por defecto

It's possible to define default values for the module, controller or action. When a route is missing any of those paths they can be automatically filled by the router:

```php
<?php

// Establecer un predeterminado específico
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

<a name='extra-slashes'></a>

## Tratar con barras extra o finales

Sometimes a route could be accessed with extra/trailing slashes. Those extra slashes would lead to produce a not-found status in the dispatcher. You can set up the router to automatically remove the slashes from the end of handled route:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

// Eliminar barras diagonales automáticamente
$router->removeExtraSlashes(true);
```

Or, you can modify specific routes to optionally accept trailing slashes:

```php
<?php

// El patrón [/]{0,1} permite a esta ruta tener opcionalmente una barra al final
$router->add(
    '/{language:[a-z]{2}}/:controller[/]{0,1}',
    [
        'controller' => 2,
        'action'     => 'index',
    ]
);
```

<a name='callbacks'></a>

## Coincidencias por llamada de retorno

Sometimes, routes should only be matched if they meet specific conditions. You can add arbitrary conditions to routes using the `beforeMatch()` callback. If this function return `false`, the route will be treated as non-matched:

```php
<?php

$route = $router->add('/login',
    [
        'module'     => 'admin',
        'controller' => 'session',
    ]
);

$route->beforeMatch(
    function ($uri, $route) {
        // Comprobar si la consulta fue hecha con Ajax
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
         * @var \Phalcon\DiInterface $this
         * @var \Phalcon\Http\Request $request
         */
        $request = $this->getShared('request');

        // Verifica si la solicitud fue hecha con Ajax
        return $request->isAjax();
    }
);
```

<a name='hostname-constraints'></a>

## Restricciones de nombre de host

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

// Crear un grupo con un módulo y un controlador en común
$blog = new RouterGroup(
    [
        'module'     => 'blog',
        'controller' => 'posts',
    ]
);

// Restricción de nombre de host
$blog->setHostName('blog.mycompany.com');

// Todas las rutas comienzan con /blog
$blog->setPrefix('/blog');

// Ruta por defecto
$blog->add(
    '/',
    [
        'action' => 'index',
    ]
);

// Agregar una ruta por defecto
$blog->add(
    '/save',
    [
        'action' => 'save',
    ]
);

// Agregar otra ruta al grupo
$blog->add(
    '/edit/{id}',
    [
        'action' => 'edit',
    ]
);

// Agregar el grupo al router
$router->mount($blog);
```

<a name='uri-sources'></a>

## Fuentes URI

By default the URI information is obtained from the `$_GET['_url']` variable, this is passed by the Rewrite-Engine to Phalcon, you can also use `$_SERVER['REQUEST_URI']` if required:

```php
<?php

use Phalcon\Mvc\Router;

// ...

// Usar $_GET['_url'] (por defecto)
$router->setUriSource(
    Router::URI_SOURCE_GET_URL
);

// Usar $_SERVER['REQUEST_URI']
$router->setUriSource(
    Router::URI_SOURCE_SERVER_REQUEST_URI
);
```

Or you can manually pass a URI to the `handle()` method:

```php
<?php

$router->handle('/some/route/to/handle');
```

<h5 class='alert alert-danger'>Please note that using <code>Router::URI_SOURCE_GET_URL</code> automatically decodes the Uri, because it is based on the <code>$_REQUEST</code> superglobal. However, for the time being, using <code>Router::URI_SOURCE_SERVER_REQUEST_URI</code> will not automatically decode the Uri for you. This will change in the next major release.</h5>

<a name='testing'></a>

## Probando tus rutas

Since this component has no dependencies, you can create a file as shown below to test your routes:

```php
<?php

use Phalcon\Mvc\Router;

// Estas rutas simulan URIs reales
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

// Agregar aquí las rutas personalizadas
// ...

// Probar cada ruta
foreach ($testRoutes as $testRoute) {
    // Gestionar la ruta
    $router->handle($testRoute);

    echo 'Probando ', $testRoute, '<br>';

    // Comprobar si alguna ruta coincidio
    if ($router->wasMatched()) {
        echo 'Controlador: ', $router->getControllerName(), '<br>';
        echo 'Acción: ', $router->getActionName(), '<br>';
    } else {
        echo "La ruta no coincidió con ninguna ruta<br>";
    }

    echo '<br>';
}
```

<a name='events'></a>

## Eventos

Como muchos otros componentes, los enrutadores tambien tienen eventos. Nunguno de ellos puede detener la operación en curso. A continuación una lista de los eventos disponibles

| Evento                     | Descripción                                            |
| -------------------------- | ------------------------------------------------------ |
| `router:beforeCheckRoutes` | Activado antes de comprobar todas las rutas cargadas   |
| `router:beforeCheckRoute`  | Activado antes de comprobar una ruta                   |
| `router:matchedRoute`      | Se activa cuando una ruta coincidente es encontrada    |
| `router:notMatchedRoute`   | Activado cuando ninguna ruta coincidente es encontrada |
| `router:afterCheckRoutes`  | Activado después de comprobar todas las rutas          |
| `router:beforeMount`       | Se activa cuando se monta una nueva ruta               |

<a name='annotations'></a>

## Anotaciones de Router

This component provides a variant that's integrated with the [annotations](/4.0/en/annotations) service. Using this strategy you can write the routes directly in the controllers instead of adding them in the service registration:

```php
<?php

use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

$di['router'] = function () {
    // Usar las anotaciones del router. Pasamos el valor false ya que no queremos que el router agregue los patrones por defecto
    $router = new RouterAnnotations(false);

    // Leer las anotaciones desde ProductsController si las URI comienzan con /api/products
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

| Nombre      | Descripción                                                                                                          | Uso                                    |
| ----------- | -------------------------------------------------------------------------------------------------------------------- | -------------------------------------- |
| RoutePrefix | Un prefijo que debe ser agregado al comienzo de cada URI. Esta anotación debe ser ubicada en el docblock de la clase | `@RoutePrefix('/api/products')`        |
| Route       | Esta anotación marca al método como una ruta. Esta anotación debe ser ubicada en el docblock del método              | `@Route('/api/products/show')`         |
| Get         | Esta anotación marca el método como una ruta restringida al método `GET` de HTTP                                     | `@Get('/api/products/search')`         |
| Post        | Esta anotación marca el método como una ruta restringida al método `POST` de HTTP                                    | `@Post('/api/products/save')`          |
| Put         | Esta anotación marca el método como una ruta restringida al método `PUT` de HTTP                                     | `@Put('/api/products/save')`           |
| Delete      | Esta anotación marca el método como una ruta restringida al método `DELETE` de HTTP                                  | `@Delete('/api/products/delete/{id}')` |
| Options     | Esta anotación marca el método como una ruta restringida al método `OPTIONS` de HTTP                                 | `@Option('/api/products/info')`        |

For annotations that add routes, the following parameters are supported:

| Nombre     | Descripción                                                         | Uso                                                                  |
| ---------- | ------------------------------------------------------------------- | -------------------------------------------------------------------- |
| methods    | Define uno o más métodos HTTP que la ruta debe cumplir              | `@Route('/api/products', methods={'GET', 'POST'})`                   |
| name       | Define el nombre de la ruta                                         | `@Route('/api/products', name='get-products')`                       |
| paths      | Un arreglo de rutas como el pasado en `Phalcon\Mvc\Router::add()` | `@Route('/posts/{id}/{slug}', paths={module='backend'})`             |
| conversors | Un hash del conversor para aplicar a los parámetros                 | `@Route('/posts/{id}/{slug}', conversors={id='MyConversor::getId'})` |

If you're using modules in your application, it is better use the `addModuleResource()` method:

```php
<?php

use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

$di['router'] = function () {
    // Usar las anotaciones del router
    $router = new RouterAnnotations(false);

    // Leer las anotaciones desde Backend\Controllers\ProductsController si la URI comienza con /api/products
    $router->addModuleResource('backend', 'Products', '/api/products');

    return $router;
};
```

<a name='registration'></a>

## Registro de instancia de Router

You can register router during service registration with Phalcon dependency injector to make it available inside the controllers.

You need to add code below in your bootstrap file (for example `index.php` or `app/config/services.php` if you use [Phalcon Developer Tools](https://phalconphp.com/en/download/tools).

```php
<?php

/**
 * Agregar capacidades de ruteo
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

<a name='custom'></a>

## Implementar tu propio Router

The `Phalcon\Mvc\RouterInterface` interface must be implemented to create your own router replacing the one provided by Phalcon.