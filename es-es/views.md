---
layout: default
language: 'es-es'
version: '4.0'
---

# Vistas

* * *

![](/assets/images/document-status-under-review-red.svg)

## Using Views

Las vistas representan la interfaz de usuario de su aplicación. Las vistas, son a menudo, archivos HTML con código PHP incrustado que realizan tareas relacionadas solamente a la presentación de datos. Las vistas llevan a cabo el trabajo de proveer datos al navegador web u otra herramienta que es usada para hacer solicitudes desde su aplicación.

[Phalcon\Mvc\View](api/Phalcon_Mvc_View) and [Phalcon\Mvc\View\Simple](api/Phalcon_Mvc_View_Simple) are responsible for the managing the view layer of your MVC application.

## Integrating Views with Controllers

Phalcon automatically passes the execution to the view component as soon as a particular controller has completed its cycle. The view component will look in the views folder for a folder named as the same name of the last controller executed and then for a file named as the last action executed. For instance, if a request is made to the URL *https://127.0.0.1/blog/posts/show/301*, Phalcon will parse the URL as follows:

| Dirección del servidor | 127.0.0.1 |
| ---------------------- | --------- |
| Phalcon Directory      | blog      |
| Controller             | posts     |
| Action                 | show      |
| Parameter              | 301       |

The dispatcher will look for a `PostsController` and its action `showAction`. A simple controller file for this example:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($postId)
    {
        // Pasamos el parámetro $postId a la vista
        $this->view->postId = $postId;
    }
}
```

The `setVar()` method allows us to create view variables on demand so that they can be used in the view template. The example above demonstrates how to pass the `$postId` parameter to the respective view template.

## Hierarchical Rendering

[Phalcon\Mvc\View](api/Phalcon_Mvc_View) supports a hierarchy of files and is the default component for view rendering in Phalcon. This hierarchy allows for common layout points (commonly used views), as well as controller named folders defining respective view templates.

This component uses by default PHP itself as the template engine, therefore views should have the `.phtml` extension. If the views directory is *app/views* then view component will find automatically for these 3 view files.

| Nombre                    | Archivo                       | Descripción                                                                                                                                                                                                                       |
| ------------------------- | ----------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Vista de la acción        | app/views/posts/show.phtml    | This is the view related to the action. It only will be shown when the `show` action is executed.                                                                                                                                 |
| Plantilla del controlador | app/views/layouts/posts.phtml | Esta es la vista relacionada con el controlador. Sólo se mostrará para cada acción ejecutada en el controlador "posts". Se reutilizará todo el código puesto en ejecución en el diseño de todas las acciones en este controlador. |
| Plantilla principal       | app/views/index.phtml         | Se trata de la acción principal que se mostrará para cada controlador o acción ejecutada dentro de la aplicación.                                                                                                                 |

You are not required to implement all of the files mentioned above. [Phalcon\Mvc\View](api/Phalcon_Mvc_View) will simply move to the next view level in the hierarchy of files. If all three view files are implemented, they will be processed as follows:

```php
<!-- app/views/posts/show.phtml -->

<h3>Esto muestra la vista!</h3>

<p>Recibimos el parámetro: <?php echo $postId; ?></p>
```

```php
<!-- app/views/layouts/posts.phtml -->

<h2>Esta es la plantilla del controlador "posts"!</h2>

<?php echo $this->getContent(); ?>
```

```php
<!-- app/views/index.phtml -->
<html>
    <head>
        <title>Ejemplo</title>
    </head>
    <body>

        <h1>Esta es la plantilla principal!</h1>

        <?php echo $this->getContent(); ?>

    </body>
</html>
```

Note the lines where the method `$this->getContent()` was called. This method instructs [Phalcon\Mvc\View](api/Phalcon_Mvc_View) on where to inject the contents of the previous view executed in the hierarchy. For the example above, the output will be:

.. figure:: ../_static/img/views-1.png :align: center

The generated HTML by the request will be:

```php
<!-- app/views/index.phtml -->
<html>
    <head>
        <title>Ejemplo</title>
    </head>
    <body>

        <h1>Esta es la plantilla principal!</h1>

        <!-- app/views/layouts/posts.phtml -->

        <h2>Esta es la plantilla el controlador "posts"!</h2>

        <!-- app/views/posts/show.phtml -->

        <h3>Esta es la vista!</h3>

        <p>Recibimos el parámetro: 101</p>

    </body>
</html>
```

### Using Templates

Templates are views that can be used to share common view code. They act as controller layouts, so you need to place them in the layouts directory.

Templates can be rendered before the layout (using `$this->view->setTemplateBefore()`) or they can be rendered after the layout (using `this->view->setTemplateAfter()`). In the following example the template (`layouts/common.phtml`) is rendered after the main layout (`layouts/posts.phtml`):

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function initialize()
    {
        $this->view->setTemplateAfter('common');
    }

    public function lastAction()
    {
        $this->flash->notice(
            'Estos son los últimos posts'
        );
    }
}
```

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Título del Blog</title>
    </head>
    <body>
        <?php echo $this->getContent(); ?>
    </body>
</html>
```

```php
<!-- app/views/layouts/common.phtml -->

<ul class='menu'>
    <li><a href='/'>Página principal</a></li>
    <li><a href='/articles'>Artículos</a></li>
    <li><a href='/contact'>Contáctenos</a></li>
</ul>

<div class='content'><?php echo $this->getContent(); ?></div>
```

```php
<!-- app/views/layouts/posts.phtml -->

<h1>Título del Blog</h1>

<?php echo $this->getContent(); ?>
```

```php
<!-- app/views/posts/last.phtml -->

<article>
    <h2>Este es el artículo</h2>
    <p>Este es el contenido de la publicación</p>
</article>

<article>
    <h2>Este es otro título</h2>
    <p>Este es el contenido de otra publicación</p>
</article>
```

The final output will be the following:

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Título del Blog</title>
    </head>
    <body>

        <!-- app/views/layouts/common.phtml -->

        <ul class='menu'>
            <li><a href='/'>Página principal</a></li>
            <li><a href='/articles'>Artículos</a></li>
            <li><a href='/contact'>Contáctenos</a></li>
        </ul>

        <div class='content'>

            <!-- app/views/layouts/posts.phtml -->

            <h1>Título del Blog</h1>

            <!-- app/views/posts/last.phtml -->

            <article>
                <h2>Este es un título</h2>
                <p>Este es el contenido de la publicación</p>
            </article>

            <article>
                <h2>Este es otro título</h2>
                <p>Este es el contenido de otra publicación</p>
            </article>

        </div>

    </body>
</html>
```

If we had used `$this->view->setTemplateBefore('common')`, this would be the final output:

```php
<!-- app/views/index.phtml -->
<!DOCTYPE html>
<html>
    <head>
        <title>Título del Blog</title>
    </head>
    <body>

        <!-- app/views/layouts/posts.phtml -->

        <h1>Título del Blog</h1>

        <!-- app/views/layouts/common.phtml -->

        <ul class='menu'>
            <li><a href='/'>Página principal</a></li>
            <li><a href='/articles'>Artículos</a></li>
            <li><a href='/contact'>Contáctenos</a></li>
        </ul>

        <div class='content'>

            <!-- app/views/posts/last.phtml -->

            <article>
                <h2>Este es un título</h2>
                <p>Este es el contenido de la publicación</p>
            </article>

            <article>
                <h2>Este es otro título</h2>
                <p>Este es otro contenido de publicación</p>
            </article>

        </div>

    </body>
</html>
```

### Control Rendering Levels

As seen above, [Phalcon\Mvc\View](api/Phalcon_Mvc_View) supports a view hierarchy. You might need to control the level of rendering produced by the view component. The method `Phalcon\Mvc\View::setRenderLevel()` offers this functionality.

This method can be invoked from the controller or from a superior view layer to interfere with the rendering process.

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function findAction()
    {
        // Esta es una respuesta en Ajax, no es necesario generar ninguna vista
        $this->view->setRenderLevel(
            View::LEVEL_NO_RENDER
        );

        // ...
    }

    public function showAction($postId)
    {
        // Solo mostraremos la vista relacionada con la acción
        $this->view->setRenderLevel(
            View::LEVEL_ACTION_VIEW
        );
    }
}
```

The available render levels are:

| Constante de clase      | Descripción                                                                 | Orden |
| ----------------------- | --------------------------------------------------------------------------- |:-----:|
| `LEVEL_NO_RENDER`       | Indicado para evitar la generación de cualquier tipo de presentación.       |       |
| `LEVEL_ACTION_VIEW`     | Genera la presentación a la vista asociada a la acción.                     |   1   |
| `LEVEL_BEFORE_TEMPLATE` | Genera plantillas de presentación previas al diseño del controlador.        |   2   |
| `LEVEL_LAYOUT`          | Genera la presentación en el diseño del controlador.                        |   3   |
| `LEVEL_AFTER_TEMPLATE`  | Genera la presentación a las plantillas después del diseño del controlador. |   4   |
| `LEVEL_MAIN_LAYOUT`     | Generates the presentation to the main layout. File views/index.phtml       |   5   |

### Disabling render levels

You can permanently or temporarily disable render levels. A level could be permanently disabled if it isn't used at all in the whole application:

```php
<?php

use Phalcon\Mvc\View;

$di->set(
    'view',
    function () {
        $view = new View();

        // Desactivar varios niveles
        $view->disableLevel(
            [
                View::LEVEL_LAYOUT      => true,
                View::LEVEL_MAIN_LAYOUT => true,
            ]
        );

        return $view;
    },
    true
);
```

Or disable temporarily in some part of the application:

```php
<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function findAction()
    {
        $this->view->disableLevel(
            View::LEVEL_MAIN_LAYOUT
        );
    }
}
```

### Picking Views

As mentioned above, when [Phalcon\Mvc\View](api/Phalcon_Mvc_View) is managed by [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application) the view rendered is the one related with the last controller and action executed. You could override this by using the `Phalcon\Mvc\View::pick()` method:

```php
<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function listAction()
    {
        // Seleccionar 'views-dir/products/search' como vista a renderizar
        $this->view->pick('products/search');

        // Seleccionar 'views-dir/books/list' como vista a renderizar
        $this->view->pick(
            [
                'books',
            ]
        );

        // Seleccionar 'views-dir/products/search' como vista a renderizar
        $this->view->pick(
            [
                1 => 'search',
            ]
        );
    }
}
```

### Disabling the view

If your controller does not produce any output in the view (or not even have one) you may disable the view component avoiding unnecessary processing:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function closeSessionAction()
    {
        // Cerrar sesión
        // ...

        // Desactivar la vista para evitar renderizado
        $this->view->disable();
    }
}
```

Alternatively, you can return `false` to produce the same effect:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function closeSessionAction()
    {
        // ...

        // Desactivar la vista para evitar renderizado
        return false;
    }
}
```

You can return a `response` object to avoid disable the view manually:

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function closeSessionAction()
    {
        // Cerrar sesión
        // ...

        // Una redirección HTTP
        return $this->response->redirect('index/index');
    }
}
```

## Simple Rendering

[Phalcon\Mvc\View\Simple](api/Phalcon_Mvc_View_Simple) is an alternative component to [Phalcon\Mvc\View](api/Phalcon_Mvc_View). It keeps most of the philosophy of [Phalcon\Mvc\View](api/Phalcon_Mvc_View) but lacks of a hierarchy of files which is, in fact, the main feature of its counterpart.

This component allows the developer to have control of when a view is rendered and its location. In addition, this component can leverage of view inheritance available in template engines such as `Volt` and others.

The default component must be replaced in the service container:

```php
<?php

use Phalcon\Mvc\View\Simple as SimpleView;

$di->set(
    'view',
    function () {
        $view = new SimpleView();

        $view->setViewsDir('../app/views/');

        return $view;
    },
    true
);
```

Automatic rendering must be disabled in [Phalcon\Mvc\Application](api/Phalcon_Mvc_Application) (if needed):

```php
<?php

use Exception;
use Phalcon\Mvc\Application;

try {
    $application = new Application($di);

    $application->useImplicitView(false);

    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (Exception $e) {
    echo $e->getMessage();
}
```

To render a view it's necessary to call the render method explicitly indicating the relative path to the view you want to display:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {
        // Renderizar 'views-dir/index.phtml'
        echo $this->view->render('index');

        // Renderizar 'views-dir/posts/show.phtml'
        echo $this->view->render('posts/show');

        // Renderizar 'views-dir/index.phtml' pasando variables
        echo $this->view->render(
            'index',
            [
                'posts' => Posts::find(),
            ]
        );

        // Renderizar 'views-dir/posts/show.phtml' pasando variables
        echo $this->view->render(
            'posts/show',
            [
                'posts' => Posts::find(),
            ]
        );
    }
}
```

This is different to [Phalcon\Mvc\View](api/Phalcon_Mvc_View) who's `render()` method uses controllers and actions as parameters:

```php
<?php

$params = [
    'posts' => Posts::find(),
];

// Phalcon\Mvc\View
$view = new \Phalcon\Mvc\View();
echo $view->render('posts', 'show', $params);

// Phalcon\Mvc\View\Simple
$simpleView = new \Phalcon\Mvc\View\Simple();
echo $simpleView->render('posts/show', $params);
```

## Using Partials

Partial templates are another way of breaking the rendering process into simpler more manageable chunks that can be reused by different parts of the application. With a partial, you can move the code for rendering a particular piece of a response to its own file.

One way to use partials is to treat them as the equivalent of subroutines: as a way to move details out of a view so that your code can be more easily understood. For example, you might have a view that looks like this:

```php
<div class='top'><?php $this->partial('shared/ad_banner'); ?></div>

<div class='content'>
    <h1>Robots</h1>

    <p>Revise nuestras ofertas para robots:</p>
    ...
</div>

<div class='footer'><?php $this->partial('shared/footer'); ?></div>
```

The `partial()` method does accept a second parameter as an array of variables/parameters that only will exists in the scope of the partial:

```php
<?php $this->partial('shared/ad_banner', ['id' => $site->id, 'size' => 'big']); ?>
```

## Transfer values from the controller to views

[Phalcon\Mvc\View](api/Phalcon_Mvc_View) is available in each controller using the view variable (`$this->view`). You can use that object to set variables directly to the view from a controller action by using the `setVar()` method.

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
        $user  = Users::findFirst();
        $posts = $user->getPosts();

        // Pasar todos los nombres de usuarios y las publicaciones a la vista
        $this->view->setVar('username', $user->username);
        $this->view->setVar('posts', $posts);

        // Utilizando los setters mágicos
        $this->view->username = $user->username;
        $this->view->posts    = $posts;

        // Pasando más de una variable al mismo tiempo
        $this->view->setVars(
            [
                'username' => $user->username,
                'posts'    => $posts,
            ]
        );
    }
}
```

A variable with the name of the first parameter of `setVar()` will be created in the view, ready to be used. The variable can be of any type, from a simple string, integer etc. variable to a more complex structure such as array, collection etc.

```php
<h1>
    Publicaciones de {{ username }}
</h1>

<div class='post'>
<?php

    foreach ($posts as $post) {
        echo '<h2>', $post->title, '</h2>';
    }

?>
</div>
```

## Caching View Fragments

Sometimes when you develop dynamic websites and some areas of them are not updated very often, the output is exactly the same between requests. [Phalcon\Mvc\View](api/Phalcon_Mvc_View) offers caching a part or the whole rendered output to increase performance.

[Phalcon\Mvc\View](api/Phalcon_Mvc_View) integrates with `Phalcon\Cache` to provide an easier way to cache output fragments. You could manually set the cache handler or set a global handler:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function showAction()
    {
        // Cachear una vista usando la configuración por defecto
        $this->view->cache(true);
    }

    public function showArticleAction()
    {
        // Cachear esta vista por una hora
        $this->view->cache(
            [
                'lifetime' => 3600,
            ]
        );
    }

    public function resumeAction()
    {
        // Cachear esta vista por un día con la clave 'resume-cache'
        $this->view->cache(
            [
                'lifetime' => 86400,
                'key'      => 'resume-cache',
            ]
        );
    }

    public function downloadAction()
    {
        // Pasando un servicio personalizado
        $this->view->cache(
            [
                'service'  => 'myCache',
                'lifetime' => 86400,
                'key'      => 'resume-cache',
            ]
        );
    }
}
```

When we do not define a key to the cache, the component automatically creates one using an [MD5](https://php.net/manual/en/function.md5.php) hash of the name of the controller and view currently being rendered in the format of `controller/view`. It is a good practice to define a key for each action so you can easily identify the cache associated with each view. When the View component needs to cache something it will request a cache service from the services container. The service name convention for this service is `viewCache`:

```php
<?php

use Phalcon\Cache\Frontend\Output as OutputFrontend;
use Phalcon\Cache\Backend\Memcache as MemcacheBackend;

// Configuramos el servicio de cache para las vistas
$di->set(
    'viewCache',
    function () {
        // Por defecto, almacenar datos por un día
        $frontCache = new OutputFrontend(
            [
                'lifetime' => 86400,
            ]
        );

        // Configuración de conexión con Memcached
        $cache = new MemcacheBackend(
            $frontCache,
            [
                'host' => 'localhost',
                'port' => '11211',
            ]
        );

        return $cache;
    }
);
```

> The frontend must always be [Phalcon\Cache\Frontend\Output](api/Phalcon_Cache_Frontend_Output) and the service `viewCache` must be registered as always open (not shared) in the services container (DI).
{: .alert .alert-warning }

When using views, caching can be used to prevent controllers from needing to generate view data on each request. To achieve this we must identify uniquely each cache with a key. First we verify that the cache does not exist or has expired to make the calculations/queries to display data in the view:

```php
<?php

use Phalcon\Mvc\Controller;

class DownloadController extends Controller
{
    public function indexAction()
    {
        // Comprobar si existe o ha expirado el cache con clave 'downloads'
        if ($this->view->getCache()->exists('downloads')) {
            // Consultar últimas descargas
            $latest = Downloads::find(
                [
                    'order' => 'created_at DESC',
                ]
            );

            $this->view->latest = $latest;
        }

        // Activar el cache con la misma clave 'downloads'
        $this->view->cache(
            [
                'key' => 'downloads',
            ]
        );
    }
}
```

## Template Engines

Template Engines help designers to create views without the use of a complicated syntax. Phalcon includes a powerful and fast templating engine called `Volt`. [Phalcon\Mvc\View](api/Phalcon_Mvc_View) allows you to use other template engines instead of plain PHP or Volt.

Using a different template engine, usually requires complex text parsing using external PHP libraries in order to generate the final output for the user. This usually increases the number of resources that your application will use.

If an external template engine is used, [Phalcon\Mvc\View](api/Phalcon_Mvc_View) provides exactly the same view hierarchy and it's still possible to access the API inside these templates with a little more effort.

This component uses adapters, these help Phalcon to speak with those external template engines in a unified way, let's see how to do that integration.

### Creating your own Template Engine Adapter

There are many template engines, which you might want to integrate or create one of your own. The first step to start using an external template engine is create an adapter for it.

A template engine adapter is a class that acts as bridge between [Phalcon\Mvc\View](api/Phalcon_Mvc_View) and the template engine itself. Usually it only needs two methods implemented: `__construct()` and `render()`. The first one receives the [Phalcon\Mvc\View](api/Phalcon_Mvc_View) instance that creates the engine adapter and the DI container used by the application.

The method `render()` accepts an absolute path to the view file and the view parameters set using `$this->view->setVar()`. You could read or require it when it's necessary.

```php
<?php

use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Engine;

class MyTemplateAdapter extends Engine
{
    /**
     * Adapter constructor
     *
     * @param \Phalcon\Mvc\View $view
     * @param \Phalcon\Di $di
     */
    public function __construct($view, DiInterface $di)
    {
        // Initialize here the adapter
        parent::__construct($view, $di);
    }

    /**
     * Renders a view using the template engine
     *
     * @param string $path
     * @param array $params
     */
    public function render(string $path, $params)
    {
        // Access view
        $view = $this->_view;

        // Access options
        $options = $this->_options;

        // Render the view
        // ...
    }
}
```

### Changing the Template Engine

You can replace the template engine completely or use more than one template engine at the same time. The method `Phalcon\Mvc\View::registerEngines()` accepts an array containing data that define the template engines. The key of each engine is an extension that aids in distinguishing one from another. Template files related to the particular engine must have those extensions.

The order that the template engines are defined with `Phalcon\Mvc\View::registerEngines()` defines the relevance of execution. If [Phalcon\Mvc\View](api/Phalcon_Mvc_View) finds two views with the same name but different extensions, it will only render the first one.

If you want to register a template engine or a set of them for each request in the application. You could register it when the view service is created:

```php
<?php

use Phalcon\Mvc\View;

// Setting up the view component
$di->set(
    'view',
    function () {
        $view = new View();

        $view->setViewsDir('../app/views/');

        // Set the engine
        $view->registerEngines(
            [
                '.my-html' => \MyTemplateAdapter::class,
            ]
        );

        // Using more than one template engine
        $view->registerEngines(
            [
                '.my-html' => \MyTemplateAdapter::class,
                '.phtml'   => \Phalcon\Mvc\View\Engine\Php::class,
            ]
        );

        return $view;
    },
    true
);
```

There are adapters available for several template engines on the [Phalcon Incubator](https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Mvc/View/Engine)

## Injecting services in View

Every view executed is included inside a [Phalcon\Di\Injectable](api/Phalcon_Di_Injectable) instance, providing easy access to the application's service container.

The following example shows how to write a jQuery [ajax request](https://api.jquery.com/jQuery.ajax/) using a URL with the framework conventions. The service `url` (usually [Phalcon\Url](api/Phalcon_Url)) is injected in the view by accessing a property with the same name:

```js
<script type='text/javascript'>

$.ajax({
    url: '<?php echo $this->url->get('cities/get'); ?>'
})
.done(function () {
    alert('Terminado!');
});

</script>
```

## Stand-Alone Component

All the components in Phalcon can be used as *glue* components individually because they are loosely coupled to each other:

### Hierarchical Rendering

Using [Phalcon\Mvc\View](api/Phalcon_Mvc_View) in a stand-alone mode can be demonstrated below:

```php
<?php

use Phalcon\Mvc\View;

$view = new View();

$view->setViewsDir('../app/views/');

// Passing variables to the views, these will be created as local variables
$view->setVar('someProducts', $products);
$view->setVar('someFeatureEnabled', true);

// Start the output buffering
$view->start();

// Render all the view hierarchy related to the view products/list.phtml
$view->render('products', 'list');

// Finish the output buffering
$view->finish();

echo $view->getContent();
```

A short syntax is also available:

```php
<?php

use Phalcon\Mvc\View;

$view = new View();

echo $view->getRender(
    'products',
    'list',
    [
        'someProducts'       => $products,
        'someFeatureEnabled' => true,
    ],
    function ($view) {
        // Configurar aquí cualquier opción extra

        $view->setViewsDir('../app/views/');

        $view->setRenderLevel(
            View::LEVEL_LAYOUT
        );
    }
);
```

### Simple Rendering

Using [Phalcon\Mvc\View\Simple](api/Phalcon_Mvc_View_Simple) in a stand-alone mode can be demonstrated below:

```php
<?php

use Phalcon\Mvc\View\Simple as SimpleView;

$view = new SimpleView();

$view->setViewsDir('../app/views/');

// Render a view and return its contents as a string
echo $view->render('templates/welcomeMail');

// Render a view passing parameters
echo $view->render(
    'templates/welcomeMail',
    [
        'email'   => $email,
        'content' => $content,
    ]
);
```

## View Events

[Phalcon\Mvc\View](api/Phalcon_Mvc_View) and [Phalcon\Mvc\View\Simple](api/Phalcon_Mvc_View_Simple) are able to send events to an `EventsManager` if it is present. Events are triggered using the type `view`. Algunos eventos cuando se devuelva `false` podrían detener la operación activa. Son soportados los siguientes eventos:

| Nombre de evento   | Disparado                                     | ¿Detiene la operación? |
| ------------------ | --------------------------------------------- |:----------------------:|
| `afterRender`      | Triggered after completing the render process |           No           |
| `afterRenderView`  | Triggered after rendering an existing view    |           No           |
| `beforeRender`     | Triggered before starting the render process  |           Si           |
| `beforeRenderView` | Triggered before rendering an existing view   |           Si           |
| `notFoundView`     | Activado cuando una vista no se encontró      |           No           |

En el ejemplo siguiente se muestra cómo adjuntar oyentes (listeners) a este componente:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\View;

$di->set(
    'view',
    function () {
        // Crear un gestor de eventos
        $eventsManager = new EventsManager();

        // Adjuntar un oyente para el tipo 'view'
        $eventsManager->attach(
            'view',
            function (Event $event, $view) {
                echo $event->getType(), ' - ', $view->getActiveRenderPath(), PHP_EOL;
            }
        );

        $view = new View();

        $view->setViewsDir('../app/views/');

        // Enlazar el eventsManager con el componente de la vista
        $view->setEventsManager($eventsManager);

        return $view;
    },
    true
);
```

The following example shows how to create a plugin that cleans/repair the HTML produced by the render process using [Tidy](https://secure.php.net/manual/en/book.tidy.php):

```php
<?php

use Phalcon\Events\Event;

class TidyPlugin
{
    public function afterRender(Event $event, $view)
    {
        $tidyConfig = [
            'clean'          => true,
            'output-xhtml'   => true,
            'show-body-only' => true,
            'wrap'           => 0,
        ];

        $tidy = tidy_parse_string(
            $view->getContent(),
            $tidyConfig,
            'UTF8'
        );

        $tidy->cleanRepair();

        $view->setContent(
            (string) $tidy
        );
    }
}

// Adjuntar el plugin como un oyente
$eventsManager->attach(
    'view:afterRender',
    new TidyPlugin()
);
```