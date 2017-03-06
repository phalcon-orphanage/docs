# Micro Applications

- [Creating a Micro Application](#creating-micro-application)
- [Routing](#routing)
- [Handlers](#handlers)
    - [Anonymous Function](#handlers-anonymous-function)
    - [Function](#handlers-function)
    - [Static Method](#handlers-static-method)
    - [Method in an Object](#handlers-object-method)
    - [Controllers](#handlers-controllers)
        - [Lazy Loading](#handlers-controllers-lazy-loading)
- [Methods - Verbs](#verbs)
    - [delete](#verb-delete) 
    - [get](#verb-get) 
    - [head](#verb-head) 
    - [map](#verb-map) 
    - [options](#verb-options) 
    - [patch](#verb-patch) 
    - [post](#verb-post) 
    - [put](#verb-put) 

Phalcon offers a very 'thin' application, so that you can create 'Micro' applications with minimal PHP code. 

Micro applications are suitable for small applications that will have very low overhead. Such applications are for instance our [website](https://github.com/phalcon/website), this website ([docs](https://github.com/phalcon/docs)), our [store](https://github.com/phalcon/store),  APIs, prototypes etc.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();

$app->get(
    '/say/welcome/{name}',
    function ($name) {
        echo "<h1>Welcome {$name}!</h1>";
    }
);

$app->handle();
```

<a name='creating-micro-applications'></a>
## Creating a Micro Application
The `Phalcon\Mvc\Micro` class is the one responsible for creating a Micro application.

```php
<?php

use Phalcon\Mvc\Micro;

$app = new Micro();
```

<a name='routing'></a>
## Routing
After your `Phalcon\Mvc\Micro` application has been created, you will need to define some routes so that your application can understand user requests and send relevant responses back.

All the routing for our application is handled by the `Phalcon\Mvc\Router` object. [<i class='fa fa-border fa-info'></i>](/en/[[version]]/routing)

**Routes must always start with `/`.** 

You can also use a HTTP method constraint, that will allow each request to be matched with its corresponding method. This is also known as the `verb` of the request.

This is how we define a route matching a `GET` request:

```php
$app->get(
    '/say/hello/{name}',
    function ($name) {
        echo "<h1>Hello! {$name}</h1>";
    }
);
```

Other HTTP methods can be used when defining routes just as easily. In the above example, the `get` method indicates `GET` HTTP method (or verb). 

The `get` method indicates that the associated HTTP method is GET. The route `/say/hello/{name}` accepts the parameter `{$name}`. It is passed directly to the route handler, which in this case is an anonymous function.

<a name='handlers'></a>
## Handlers
Handlers are callable pieces of code that get attached to a route. When the route is matched, the handler is executed with all the defined parameters. A handler is any callable piece of code that exists in PHP.


<a name='handlers-anonymous-function'></a>
### Anonymous Function
Finally we can use an anonymous function (as seen above) to handle the request  

```php
$app->get(
    '/say/hello/{name}',
    function ($name) {
        echo "<h1>Hello! {$name}</h1>";
    }
);
```

<a name='handlers-function'></a>
### Function
We can define a function as our handler and attach it to a specific route.  

```php
// With a function
function say_hello($name) {
    echo "<h1>Hello! {$name}</h1>";
}

$app->get(
    '/say/hello/{name}',
    'say_hello'
);
```

<a name='handlers-static-method'></a>
### Static Method
We can also use a static method as our handler as follows:  

```php
class SomeClass
{
    public static function someSayMethod($name) {
        echo "<h1>Hello! {$name}</h1>";
    }
}

$app->get(
    '/say/hello/{name}',
    'SomeClass::someSayMethod'
);
```

<a name='handlers-object-method'></a>
### Method in an Object
We can also use a method in an object:  

```php
class SomeClass
{
    public function someSayMethod($name) {
        echo "<h1>Hello! {$name}</h1>";
    }
}

$myClass = new SomeClass();
$app->get(
    '/say/hello/{name}',
    [
        $myClass,
        'someSayMethod',
    ]
);
```

<a name='handlers-controllers'></a>
### Controllers
With the `Phalcon\Mvc\Micro` you can create micro or medium applications. Medium applications utilize the micro architecture but expand on it to utilize more than the Micro but less than the Full application.
 
In medium applications you can organize handlers in controllers.  

```php
<?php

use Phalcon\Mvc\Micro\Collection as MicroCollection;

$posts = new MicroCollection();

// Set the main handler. ie. a controller instance
$posts->setHandler(new PostsController());

// Set a common prefix for all routes
$posts->setPrefix('/posts');

// Use the method 'index' in PostsController
$posts->get('/', 'index');

// Use the method 'show' in PostsController
$posts->get('/show/{slug}', 'show');

$app->mount($posts);
```
The `PostsController` might look like this:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function index()
    {
        // ...
    }

    public function show($slug)
    {
        // ...
    }
}
```

<a name='handlers-controllers-lazy-loading'></a>
#### Lazy Loading 
In order to increase performance, you might consider implementing lazy loading for your controllers (handlers). The controller will be loaded only if the relevant route is matched. 

Lazy loading can be easily achieved when setting your handler in your `Phalcon\Mvc\Micro\Collection`:

```php
$posts->setHandler('PostsController', true);
$posts->setHandler('Blog\Controllers\PostsController', true);
```

<a name='verbs'></a>
## Methods - Verbs
The `Phalcon\Mvc\Micro` application provides a set of methods to bind the HTTP method with the route it is intended to.

<a name='verbs-delete'></a>
### delete 
Matches if the HTTP method is `DELETE` and the route is `/api/products/delete/{id}`

```php
    $app->delete(
        '/api/products/delete/{id}',
        'delete_product'
    );
```

<a name='verbs-get'></a>
### get 
Matches if the HTTP method is `GET` and the route is `/api/products`

```php
    $app->get(
        '/api/products',
        'get_products'
    );
```

<a name='verbs-head'></a>
### head 
Matches if the HTTP method is `HEAD` and the route is `/api/products`

```php
    $app->get(
        '/api/products',
        'get_products'
    );
```

<a name='verbs-map'></a>
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

<a name='verbs-options'></a>
### options 
Matches if the HTTP method is `OPTIONS` and the route is `/api/products/options`

```php
    $app->options(
        '/api/products/options',
        'info_product'
    );
```

<a name='verbs-patch'></a>
### patch 
Matches if the HTTP method is `PATCH` and the route is `/api/products/update/{id}`

```php
    $app->patch(
        '/api/products/update/{id}',
        'update_product'
    );
```

<a name='verbs-post'></a>
### post 
Matches if the HTTP method is `POST` and the route is `/api/products/add`

```php
    $app->post(
        '/api/products',
        'add_product'
    );
```

<a name='verbs-put'></a>
### put 
Matches if the HTTP method is `PUT` and the route is `/api/products/update/{id}`

```php
    $app->put(
        '/api/products/update/{id}',
        'update_product'
    );
```

 




To access the HTTP method data :code:`$app` needs to be passed into the closure:

.. code-block:: php

    <?php

    // Matches if the HTTP method is POST
    $app->post(
        '/api/products/add',
        function () use ($app) {
            echo $app->request->getPost('productID');
        }
    );

Routes with Parameters
^^^^^^^^^^^^^^^^^^^^^^
Defining parameters in routes is very easy as demonstrated above. The name of the parameter has to be enclosed in brackets. Parameter
formatting is also available using regular expressions to ensure consistency of data. This is demonstrated in the example below:

.. code-block:: php

    <?php

    // This route have two parameters and each of them have a format
    $app->get(
        '/posts/{year:[0-9]+}/{title:[a-zA-Z\-]+}',
        function ($year, $title) {
            echo '<h1>Title: $title</h1>';
            echo '<h2>Year: $year</h2>';
        }
    );

Starting Route
^^^^^^^^^^^^^^
Normally, the starting route in an application is the route /, and it will more frequent to be accessed by the method GET.
This scenario is coded as follows:

.. code-block:: php

    <?php

    // This is the start route
    $app->get(
        '/',
        function () {
            echo '<h1>Welcome!</h1>';
        }
    );

Rewrite Rules
^^^^^^^^^^^^^
The following rules can be used together with Apache to rewrite the URis:

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

Working with Responses
----------------------
You are free to produce any kind of response in a handler: directly make an output, use a template engine, include a view,
return a json, etc.:

.. code-block:: php

    <?php

    // Direct output
    $app->get(
        '/say/hello',
        function () {
            echo '<h1>Hello! $name</h1>';
        }
    );

    // Requiring another file
    $app->get(
        '/show/results',
        function () {
            require 'views/results.php';
        }
    );

    // Returning JSON
    $app->get(
        '/get/some-json',
        function () {
            echo json_encode(
                [
                    'some',
                    'important',
                    'data',
                ]
            );
        }
    );

In addition to that, you have access to the service :doc:`'response' <response>`, with which you can manipulate better the
response:

.. code-block:: php

    <?php

    $app->get(
        '/show/data',
        function () use ($app) {
            // Set the Content-Type header
            $app->response->setContentType('text/plain');

            $app->response->sendHeaders();

            // Print a file
            readfile('data.txt');
        }
    );

Or create a response object and return it from the handler:

.. code-block:: php

    <?php

    $app->get(
        '/show/data',
        function () {
            // Create a response
            $response = new Phalcon\Http\Response();

            // Set the Content-Type header
            $response->setContentType('text/plain');

            // Pass the content of a file
            $response->setContent(file_get_contents('data.txt'));

            // Return the response
            return $response;
        }
    );

Making redirections
-------------------
Redirections could be performed to forward the execution flow to another route:

.. code-block:: php

    <?php

    // This route makes a redirection to another route
    $app->post('/old/welcome',
        function () use ($app) {
            $app->response->redirect('new/welcome');

            $app->response->sendHeaders();
        }
    );

    $app->post('/new/welcome',
        function () use ($app) {
            echo 'This is the new Welcome';
        }
    );

Generating URLs for Routes
--------------------------
:doc:`Phalcon\\Mvc\\Url <url>` can be used to produce URLs based on the defined routes. You need to set up a name for the route;
by this way the 'url' service can produce the corresponding URL:

.. code-block:: php

    <?php

    // Set a route with the name 'show-post'
    $app->get(
        '/blog/{year}/{title}',
        function ($year, $title) use ($app) {
            // ... Show the post here
        }
    )->setName('show-post');

    // Produce a URL somewhere
    $app->get(
        '/',
        function () use ($app) {
            echo '<a href='', $app->url->get(
                [
                    'for'   => 'show-post',
                    'title' => 'php-is-a-great-framework',
                    'year'  => 2015
                ]
            ), ''>Show the post</a>';
        }
    );

Interacting with the Dependency Injector
----------------------------------------
In the micro application, a :doc:`Phalcon\\Di\\FactoryDefault <di>` services container is created implicitly; additionally you
can create outside the application a container to manipulate its services:

.. code-block:: php

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
            // Read a setting from the config
            echo $app->config->app_name;
        }
    );

    $app->post(
        '/contact',
        function () use ($app) {
            $app->flash->success('Yes!, the contact was made!');
        }
    );

The array-syntax is allowed to easily set/get services in the internal services container:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter;

    $app = new Micro();

    // Setup the database service
    $app['db'] = function () {
        return new MysqlAdapter(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'test_db'
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

Not-Found Handler
-----------------
When a user tries to access a route that is not defined, the micro application will try to execute the 'Not-Found' handler.
An example of that behavior is below:

.. code-block:: php

    <?php

    $app->notFound(
        function () use ($app) {
            $app->response->setStatusCode(404, 'Not Found');

            $app->response->sendHeaders();

            echo 'This is crazy, but this page was not found!';
        }
    );

Models in Micro Applications
----------------------------
:doc:`Models <models>` can be used transparently in Micro Applications, only is required an autoloader to load models:

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        [
            __DIR__ . '/models/'
        ]
    )->register();

    $app = new \Phalcon\Mvc\Micro();

    $app->get(
        '/products/find',
        function () {
            $products = Products::find();

            foreach ($products as $product) {
                echo $product->name, '<br>';
            }
        }
    );

    $app->handle();

Micro Application Events
------------------------
:doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` is able to send events to the :doc:`EventsManager <events>` (if it is present).
Events are triggered using the type 'micro'. The following events are supported:

+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| Event Name          | Triggered                                                                                                                  | Can stop operation?  |
+=====================+============================================================================================================================+======================+
| beforeHandleRoute   | The main method is just called, at this point the application doesn't know if there is some matched route                  | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| beforeExecuteRoute  | A route has been matched and it contains a valid handler, at this point the handler has not been executed                  | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| afterExecuteRoute   | Triggered after running the handler                                                                                        | No                   |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| beforeNotFound      | Triggered when any of the defined routes match the requested URI                                                           | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| afterHandleRoute    | Triggered after completing the whole process in a successful way                                                           | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+

In the following example, we explain how to control the application security using events:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    // Create a events manager
    $eventsManager = new EventsManager();

    $eventsManager->attach(
        'micro:beforeExecuteRoute',
        function (Event $event, $app) {
            if ($app->session->get('auth') === false) {
                $app->flashSession->error('The user isn't authenticated');

                $app->response->redirect('/');

                $app->response->sendHeaders();

                // Return (false) stop the operation
                return false;
            }
        }
    );

    $app = new Micro();

    // Bind the events manager to the app
    $app->setEventsManager($eventsManager);

Middleware events
-----------------
In addition to the events manager, events can be added using the methods 'before', 'after' and 'finish':

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    // Executed before every route is executed
    // Return false cancels the route execution
    $app->before(
        function () use ($app) {
            if ($app['session']->get('auth') === false) {
                $app['flashSession']->error('The user isn't authenticated');

                $app['response']->redirect('/error');

                // Return false stops the normal execution
                return false;
            }

            return true;
        }
    );

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

    $app->finish(
        function () use ($app) {
            // This is executed when the request has been served
        }
    );

You can call the methods several times to add more events of the same type:

.. code-block:: php

    <?php

    $app->finish(
        function () use ($app) {
            // First 'finish' middleware
        }
    );

    $app->finish(
        function () use ($app) {
            // Second 'finish' middleware
        }
    );

Code for middlewares can be reused using separate classes:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro\MiddlewareInterface;

    /**
     * CacheMiddleware
     *
     * Caches pages to reduce processing
     */
    class CacheMiddleware implements MiddlewareInterface
    {
        public function call($application)
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

Then add the instance to the application:

.. code-block:: php

    <?php

    $app->before(
        new CacheMiddleware()
    );

The following middleware events are available:

+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| Event Name          | Triggered                                                                                                                  | Can stop operation?  |
+=====================+============================================================================================================================+======================+
| before              | Before executing the handler. It can be used to control the access to the application                                      | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| after               | Executed after the handler is executed. It can be used to prepare the response                                             | No                   |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| finish              | Executed after sending the response. It can be used to perform clean-up                                                    | No                   |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+


Returning Responses
-------------------
Handlers may return raw responses using :doc:`Phalcon\\Http\\Response <response>` or a component that implements the relevant interface.
When responses are returned by handlers they are automatically sent by the application.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Http\Response;

    $app = new Micro();

    // Return a response
    $app->get(
        '/welcome/index',
        function () {
            $response = new Response();

            $response->setStatusCode(401, 'Unauthorized');

            $response->setContent('Access is not authorized');

            return $response;
        }
    );

Rendering Views
---------------
:doc:`Phalcon\\Mvc\\View\\Simple <views>` can be used to render views, the following example shows how to do that:

.. code-block:: php

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
                    'name' => 'Artichoke'
                ]
            );
        }
    );

Please note that this code block uses :doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>` which uses relative paths instead of controllers and actions.
If you would like to use :doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>` instead, you will need to change the parameters of the :code:`render()` method:

.. code-block:: php

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
                    'name' => 'Artichoke'
                ]
            );
        }
    );

Error Handling
--------------
A proper response can be generated if an exception is raised in a micro handler:

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    $app->get(
        '/',
        function () {
            throw new \Exception('An error');
        }
    );

    $app->error(
        function ($exception) {
            echo 'An error has occurred';
        }
    );

If the handler returns 'false' the exception is stopped.



```php
public setDI (Phalcon\DiInterface $dependencyInjector)
public mount (Phalcon\Mvc\Micro\CollectionInterface $collection)
public Phalcon\Mvc\Micro notFound (callable $handler)
public Phalcon\Mvc\Micro error (callable $handler)
public getRouter ()
public Phalcon\Di\ServiceInterface setService (string $serviceName, mixed $definition, [boolean $shared])
public hasService (mixed $serviceName)
public object getService (string $serviceName)
public mixed getSharedService (string $serviceName)
public mixed handle ([string $uri])
public stop ()
public setActiveHandler (callable $activeHandler)
public callable getActiveHandler ()
public mixed getReturnedValue ()
public boolean offsetExists (string $alias)
public offsetSet (string $alias, mixed $definition)
public mixed offsetGet (string $alias)
public offsetUnset (string $alias)
public Phalcon\Mvc\Micro before (callable $handler)
public Phalcon\Mvc\Micro after (callable $handler)
public Phalcon\Mvc\Micro finish (callable $handler)
public array getHandlers ()
public getDI () inherited from Phalcon\Di\Injectable
public setEventsManager (Phalcon\Events\ManagerInterface $eventsManager) inherited from Phalcon\Di\Injectable
public getEventsManager () inherited from Phalcon\Di\Injectable
public __get (mixed $propertyName) inherited from Phalcon\Di\Injectable
```


Related Sources
---------------
* :doc:`Creating a Simple REST API <tutorial-rest>` is a tutorial that explains how to create a micro application to implement a RESTful web service.
* `Stickers Store <http://store.phalconphp.com>`_ is a very simple micro-application making use of the micro-mvc approach [`Github <https://github.com/phalcon/store>`_].


