<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Enrutamiento</a> <ul>
        <li>
          <a href="#defining">Definición de rutas</a> <ul>
            <li>
              <a href="#defining-named-parameters">Parámetros con nombres</a>
            </li>
            <li>
              <a href="#defining-short-syntax">Sintaxis corta</a>
            </li>
            <li>
              <a href="#defining-mixed-parameters">Mezcla de array y sintaxis corta</a>
            </li>
            <li>
              <a href="#defining-route-to-modules">Enrutamiento a los módulos</a>
            </li>
            <li>
              <a href="#defining-http-method-restrictions">Restricciones del método HTTP</a>
            </li>
            <li>
              <a href="#defining-using-conversors">Utilizando conversores</a>
            </li>
            <li>
              <a href="#defining-groups-of-routes">Grupos de rutas</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#matching">Rutas coincidentes</a>
        </li>
        <li>
          <a href="#naming">Nombres de rutas</a>
        </li>
        <li>
          <a href="#usage">Ejemplos de Uso</a>
        </li>
        <li>
          <a href="#default-behavior">Comprotamiento predeterminado</a>
        </li>
        <li>
          <a href="#default-route">Establecer la ruta por defecto</a>
        </li>
        <li>
          <a href="#not-found-paths">Rutas Not Found</a>
        </li>
        <li>
          <a href="#default-paths">Configurar rutas por defecto</a>
        </li>
        <li>
          <a href="#extra-slashes">Tratar con barras extra o finales</a>
        </li>
        <li>
          <a href="#callbacks">Coincidencias por llamada de retorno</a>
        </li>
        <li>
          <a href="#hostname-constraints">Restricciones de nombre de host</a>
        </li>
        <li>
          <a href="#uri-sources">Fuentes URI</a>
        </li>
        <li>
          <a href="#testing">Probando tus rutas</a>
        </li>
        <li>
          <a href="#annotations">Anotaciones de Router</a>
        </li>
        <li>
          <a href="#registration">Registro de instancia de Router</a>
        </li>
        <li>
          <a href="#custom">Implementar tu propio Router</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Enrutamiento

El componente router le permite definir las rutas que se asignan a los controladores o gestores que deben recibir la solicitud. Un router simplemente procesa un URI para determinar esta información. El router tiene dos modos: MVC y match mode. El primer modo es ideal para trabajar con aplicaciones de MVC.

<a name='defining'></a>

## Definición de rutas

`Phalcon\Mvc\Router` proporciona capacidades avanzadas de enrutamiento. En el modo de MVC, puede definir rutas y vincularlas a controladores/acciones que usted requiera. Una ruta es definida de la siguiente manera:

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
En este caso, si el URI es '/admin/users/my-profile', entonces se ejecutará del controlador 'users' la acción 'profile'. Es importante recordar que el router no ejecuta el controlador y la acción, sólo recoge esta información para informar la componente correcto (es decir, 'Phalcon\Mvc\Dispatcher') cual es el controlador y acción que debe ejecutar.

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
En este caso, si el URI es '/admin/users/my-profile', entonces se ejecutará del controlador 'users' la acción 'profile'. Es importante recordar que el router no ejecuta el controlador y la acción, sólo recoge esta información para informar la componente correcto (es decir, 'Phalcon\Mvc\Dispatcher') cual es el controlador y acción que debe ejecutar.

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

En el ejemplo anterior, estamos usando comodines para hacer una ruta válida para muchos URIs. Por ejemplo, accediendo a la siguiente URL (`/admin/users/al/delete/dave/301`) produciría:

| Controlador | Acción | Parámetro | Parámetro |
|:-----------:|:------:|:---------:|:---------:|
|    users    | delete |   dave    |    301    |

El método `add()` recibe un patrón que opcionalmente se han predefinido los marcadores de posición y los modificadores de la expresión regular. Todos los patrones de enrutamiento deben comenzar con un carácter de barra diagonal (`/`). La sintaxis de expresión regular utilizada es igual a las [expresiones regulares PCRE](http://www.php.net/manual/en/book.pcre.php). Tenga en cuenta que, no es necesario añadir los delimitadores de expresión regular. Todos los patrones de ruta no distinguen entre mayúsculas y minúsculas.

El segundo parámetro define cómo las partes coincidentes deben enlazar al controlador/acción/parámetros. Las partes coincidentes son marcadores o subpatrones delimitados por paréntesis (corchetes redondeados). En el ejemplo anterior, el primer subpatrón de coincidencia (`:controller`) es la parte del controlador de la ruta, el segundo la acción y así sucesivamente.

Estos marcadores ayudan a escribir expresiones regulares que son más legibles para los desarrolladores y más fácil de entender. Están disponibles los siguientes marcadores:

| Marcador       | Expresión regular        | Uso                                                                                                                  |
| -------------- | ------------------------ | -------------------------------------------------------------------------------------------------------------------- |
| `/:module`     | `/([a-zA-Z0-9\_\-]+)` | Coincide con un nombre de módulo válido con caracteres alfanuméricos únicamente                                      |
| `/:controller` | `/([a-zA-Z0-9\_\-]+)` | Coincide con un nombre de controlador válido con caracteres alfanuméricos únicamente                                 |
| `/:action`     | `/([a-zA-Z0-9_-]+)`      | Coincide con un nombre de acción válido con caracteres alfanuméricos únicamente                                      |
| `/:params`     | `(/.*)*`                 | Coincide con una lista de palabras opcionales, separadas por barras. Sólo utilice este marcador al final de una ruta |
| `/:namespace`  | `/([a-zA-Z0-9\_\-]+)` | Coincide con un nombre de espacio de nombres de nivel único                                                          |
| `/:int`        | `/([0-9]+)`              | Coincide con un parámetro entero                                                                                     |

Los nombres de controlador son camelizados, esto significa que los caracteres (`-`) y (`_`) se quitan y el siguiente carácter se transformará en mayúscula. Por ejemplo, some_controller se convierte en SomeController.

Puesto que puede agregar tantas rutas como necesite mediante el método `add()`, el orden en que se agregan rutas indican su relevancia, las últimas rutas añadidas tienen más importancia que las primeras. Internamente, todas las rutas definidas son recorridas en orden inverso hasta que `Phalcon\Mvc\Router` encuentra una que coincida con la URI dada y la procesará, mientras que el resto serán ignoradas.

<a name='defining-named-parameters'></a>

### Parámetros con nombres

El ejemplo siguiente muestra cómo definir nombres a los parámetros de ruta:

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
        // Get 'year' parameter
        $year = $this->dispatcher->getParam('year');

        // Get 'month' parameter
        $month = $this->dispatcher->getParam('month');

        // Get 'day' parameter
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
        // Get 'name' parameter
        $name = $this->dispatcher->getParam('name');

        // Get 'type' parameter
        $type = $this->dispatcher->getParam('type');

        // ...
    }
}
```

<a name='defining-short-syntax'></a>

### Short Syntax

If you don't like using an array to define the route paths, an alternative syntax is also available. The following examples produce the same result:

```php
<?php

// Short form
$router->add(
    '/posts/{year:[0-9]+}/{title:[a-z\-]+}',
    'Posts::show'
);

// Array form
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

### Mixing Array and Short Syntax

Array and short syntax can be mixed to define a route, in this case note that named parameters automatically are added to the route paths according to the position on which they were defined:

```php
<?php

// First position must be skipped because it is used for
// the named parameter 'country'
$router->add(
    '/news/{country:[a-z]{2}}/([a-z+])/([a-z\-+])',
    [
        'section' => 2, // Positions start with 2
        'article' => 3,
    ]
);
```

<a name='defining-route-to-modules'></a>

### Routing to Modules

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

| Module | Controller | Action | Parameter |
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

### HTTP Method Restrictions

When you add a route using simply `add()`, the route will be enabled for any HTTP method. Sometimes we can restrict a route to a specific method, this is especially useful when creating RESTful applications:

```php
<?php

// This route only will be matched if the HTTP method is GET
$router->addGet(
    '/products/edit/{id}',
    'Products::edit'
);

// This route only will be matched if the HTTP method is POST
$router->addPost(
    '/products/save',
    'Products::save'
);

// This route will be matched if the HTTP method is POST or PUT
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

### Using conversors

Conversors allow you to freely transform the route's parameters before passing them to the dispatcher. The following examples show how to use them:

```php
<?php

// The action name allows dashes, an action can be: /products/new-ipod-nano-4-generation
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
        // Transform the slug removing the dashes
        return str_replace('-', '', $slug);
    }
);
```

Another use case for conversors is binding a model into a route. This allows the model to be passed into the defined action directly:

```php
<?php

// This example works off the assumption that the ID is being used as parameter in the url: /products/4
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
        // Fetch the model
        return Product::findFirstById($id);
    }
);
```

<a name='defining-groups-of-routes'></a>

### Groups of Routes

If a set of routes have common paths they can be grouped to easily maintain them:

```php
<?php

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;

$router = new Router();

// Create a group with a common module and controller
$blog = new RouterGroup(
    [
        'module'     => 'blog',
        'controller' => 'index',
    ]
);

// All the routes start with /blog
$blog->setPrefix('/blog');

// Add a route to the group
$blog->add(
    '/save',
    [
        'action' => 'save',
    ]
);

// Add another route to the group
$blog->add(
    '/edit/{id}',
    [
        'action' => 'edit',
    ]
);

// This route maps to a controller different than the default
$blog->add(
    '/blog',
    [
        'controller' => 'blog',
        'action'     => 'index',
    ]
);

// Add the group to the router
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
        // Default paths
        $this->setPaths(
            [
                'module'    => 'blog',
                'namespace' => 'Blog\Controllers',
            ]
        );

        // All the routes start with /blog
        $this->setPrefix('/blog');

        // Add a route to the group
        $this->add(
            '/save',
            [
                'action' => 'save',
            ]
        );

        // Add another route to the group
        $this->add(
            '/edit/{id}',
            [
                'action' => 'edit',
            ]
        );

        // This route maps to a controller different than the default
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

// Add the group to the router
$router->mount(
    new BlogRoutes()
);
```

<a name='matching'></a>

## Matching Routes

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

// Creating a router
$router = new Router();

// Define routes here if any
// ...

// Taking URI from $_GET['_url']
$router->handle();

// Or Setting the URI value directly
$router->handle('/employees/edit/17');

// Getting the processed controller
echo $router->getControllerName();

// Getting the processed action
echo $router->getActionName();

// Get the matched route
$route = $router->getMatchedRoute();
```

<a name='naming'></a>

## Naming Routes

Each route that is added to the router is stored internally as a `Phalcon\Mvc\Router\Route` object. That class encapsulates all the details of each route. For instance, we can give a name to a path to identify it uniquely in our application. This is especially useful if you want to create URLs from it.

```php
<?php

$route = $router->add(
    '/posts/{year}/{title}',
    'Posts::show'
);

$route->setName('show-posts');
```

Then, using for example the component `Phalcon\Mvc\Url` we can build routes from its name:

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

## Usage Examples

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

<h5 class='alert alert-warning'>Ten cuidado con los caracteres permitidos en una expresión regular para los controladores y los espacios de nombres. Éstos se convierten en nombres de clase y a su vez estos son pasados a través del sistema de archivos y podrían ser utilizados por atacantes para leer archivos no autorizados. Una expresión regular segura puede ser así: <code>/([a-zA-Z0-9\_\-]+)</code> </h5>

<a name='default-behavior'></a>

## Default Behavior

`Phalcon\Mvc\Router` has a default behavior that provides a very simple routing that always expects a URI that matches the following pattern: `/:controller/:action/:params`

For example, for a URL like this `http://phalconphp.com/documentation/show/about.html`, this router will translate it as follows:

|  Controller   | Action | Parameter  |
|:-------------:|:------:|:----------:|
| documentation |  show  | about.html |

If you don't want the router to have this behavior, you must create the router passing `false` as the first parameter:

```php
<?php

use Phalcon\Mvc\Router;

// Create the router without default routes
$router = new Router(false);
```

<a name='default-route'></a>

## Setting the default route

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

## Not Found Paths

If none of the routes specified in the router are matched, you can define a group of paths to be used in this scenario:

```php
<?php

// Set 404 paths
$router->notFound(
    [
        'controller' => 'index',
        'action'     => 'route404',
    ]
);
```

This is typically for an Error 404 page.

<a name='default-paths'></a>

## Setting default paths

It's possible to define default values for the module, controller or action. When a route is missing any of those paths they can be automatically filled by the router:

```php
<?php

// Setting a specific default
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

## Dealing with extra/trailing slashes

Sometimes a route could be accessed with extra/trailing slashes. Those extra slashes would lead to produce a not-found status in the dispatcher. You can set up the router to automatically remove the slashes from the end of handled route:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

// Remove trailing slashes automatically
$router->removeExtraSlashes(true);
```

Or, you can modify specific routes to optionally accept trailing slashes:

```php
<?php

// The [/]{0,1} allows this route to have optionally have a trailing slash
$router->add(
    '/{language:[a-z]{2}}/:controller[/]{0,1}',
    [
        'controller' => 2,
        'action'     => 'index',
    ]
);
```

<a name='callbacks'></a>

## Match Callbacks

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
        // Check if the request was made with Ajax
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

        // Check if the request was made with Ajax
        return $request->isAjax();
    }
);
```

<a name='hostname-constraints'></a>

## Hostname Constraints

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

// Create a group with a common module and controller
$blog = new RouterGroup(
    [
        'module'     => 'blog',
        'controller' => 'posts',
    ]
);

// Hostname restriction
$blog->setHostName('blog.mycompany.com');

// All the routes start with /blog
$blog->setPrefix('/blog');

// Default route
$blog->add(
    '/',
    [
        'action' => 'index',
    ]
);

// Add a route to the group
$blog->add(
    '/save',
    [
        'action' => 'save',
    ]
);

// Add another route to the group
$blog->add(
    '/edit/{id}',
    [
        'action' => 'edit',
    ]
);

// Add the group to the router
$router->mount($blog);
```

<a name='uri-sources'></a>

## URI Sources

By default the URI information is obtained from the `$_GET['_url']` variable, this is passed by the Rewrite-Engine to Phalcon, you can also use `$_SERVER['REQUEST_URI']` if required:

```php
<?php

use Phalcon\Mvc\Router;

// ...

// Use $_GET['_url'] (default)
$router->setUriSource(
    Router::URI_SOURCE_GET_URL
);

// Use $_SERVER['REQUEST_URI']
$router->setUriSource(
    Router::URI_SOURCE_SERVER_REQUEST_URI
);
```

Or you can manually pass a URI to the `handle()` method:

```php
<?php

$router->handle('/some/route/to/handle');
```

<h5 class='alert alert-danger'>Please note that using <code>Router::URI_SOURCE_GET_URL</code> automatically decodes the Uri, because it is based on the <code>$_REQUEST</code> superglobal. Sin embargo, en este momento, si usas <code>Router::URI_SOURCE_SERVER_REQUEST_URI</code> la Uri no será decodificada automáticamente. Esto cambiará en la siguiente versión mayor.</h5>

<a name='testing'></a>

## Testing your routes

Since this component has no dependencies, you can create a file as shown below to test your routes:

```php
<?php

use Phalcon\Mvc\Router;

// These routes simulate real URIs
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

// Add here your custom routes
// ...

// Testing each route
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

<a name='annotations'></a>

## Annotations Router

This component provides a variant that's integrated with the [annotations](/[[language]]/[[version]]/annotations) service. Using this strategy you can write the routes directly in the controllers instead of adding them in the service registration:

```php
<?php

use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

$di['router'] = function () {
    // Use the annotations router. We're passing false as we don't want the router to add its default patterns
    $router = new RouterAnnotations(false);

    // Read the annotations from ProductsController if the URI starts with /api/products
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

| Name        | Description                                                                                       | Usage                                  |
| ----------- | ------------------------------------------------------------------------------------------------- | -------------------------------------- |
| RoutePrefix | A prefix to be prepended to each route URI. This annotation must be placed at the class' docblock | `@RoutePrefix('/api/products')`        |
| Route       | This annotation marks a method as a route. This annotation must be placed in a method docblock    | `@Route('/api/products/show')`         |
| Get         | This annotation marks a method as a route restricting the HTTP method to `GET`                    | `@Get('/api/products/search')`         |
| Post        | This annotation marks a method as a route restricting the HTTP method to `POST`                   | `@Post('/api/products/save')`          |
| Put         | This annotation marks a method as a route restricting the HTTP method to `PUT`                    | `@Put('/api/products/save')`           |
| Delete      | This annotation marks a method as a route restricting the HTTP method to `DELETE`                 | `@Delete('/api/products/delete/{id}')` |
| Options     | This annotation marks a method as a route restricting the HTTP method to `OPTIONS`                | `@Option('/api/products/info')`        |

For annotations that add routes, the following parameters are supported:

| Name       | Description                                                            | Usage                                                                |
| ---------- | ---------------------------------------------------------------------- | -------------------------------------------------------------------- |
| methods    | Define one or more HTTP method that route must meet with               | `@Route('/api/products', methods={'GET', 'POST'})`                   |
| name       | Define a name for the route                                            | `@Route('/api/products', name='get-products')`                       |
| paths      | An array of paths like the one passed to `Phalcon\Mvc\Router::add()` | `@Route('/posts/{id}/{slug}', paths={module='backend'})`             |
| conversors | A hash of conversors to be applied to the parameters                   | `@Route('/posts/{id}/{slug}', conversors={id='MyConversor::getId'})` |

If you're using modules in your application, it is better use the `addModuleResource()` method:

```php
<?php

use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

$di['router'] = function () {
    // Use the annotations router
    $router = new RouterAnnotations(false);

    // Read the annotations from Backend\Controllers\ProductsController if the URI starts with /api/products
    $router->addModuleResource('backend', 'Products', '/api/products');

    return $router;
};
```

<a name='registration'></a>

## Registering Router instance

You can register router during service registration with Phalcon dependency injector to make it available inside the controllers.

You need to add code below in your bootstrap file (for example `index.php` or `app/config/services.php` if you use [Phalcon Developer Tools](http://phalconphp.com/en/download/tools).

```php
<?php

/**
 * Add routing capabilities
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

## Implementing your own Router

Debe implementar la interfaz `Phalcon\Mvc\RouterInterface` para crear su propio enrutador reemplazando uno proporcionado por Phalcon.