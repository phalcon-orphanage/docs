Using Views
===========
Views represent the user interface of your application. Views are often HTML files with embedded PHP code that perform tasks related solely to the
presentation of the data. Views handle the job of providing data to the web browser or other tool that is used to make requests from your application.

The :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` is responsible for the managing the view layer of your MVC application.

A hierarchy of files is supported by the component. This hierarchy allows for common layout points (commonly used views), as well as controller
named folders defining respective view templates.

Integrating Views with Controllers
----------------------------------
Phalcon automatically passes the execution to the view component as soon as a particular controller has completed its cycle. The view component
will look in the views folder for a folder named as the same name of the last controller executed and then for a file named as the last action
executed. For instance, if a request is made to the URL *http://127.0.0.1/blog/posts/show/301*, Phalcon will parse the URL as follows:

+-------------------+-----------+
| Server Address    | 127.0.0.1 |
+-------------------+-----------+
| Phalcon Directory | blog      |
+-------------------+-----------+
| Controller        | posts     |
+-------------------+-----------+
| Action            | show      |
+-------------------+-----------+
| Parameter         | 301       |
+-------------------+-----------+

The dispatcher will look for a "PostsController" and its action "showAction". A simple controller file for this example:

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction($postId)
        {
            // Pass the $postId parameter to the view
            $this->view->setVar("postId", $postId);
        }

    }

The setVar allows us to create view variables on demand so that they can be used in the view template. The example above demonstrates
how to pass the $postId parameter to the respective view template.

:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` uses PHP itself as the template engine, therefore views should have the .phtml extension.
If the views directory is  *app/views* then view component will find automatically for these 3 view files.

+-------------------+-------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Name              | File                          | Description                                                                                                                                                                                                              |
+===================+===============================+==========================================================================================================================================================================================================================+
| Action View       | app/views/posts/show.phtml    | This is the view related to the action. It only will be shown when the "show" action was executed.                                                                                                                       |
+-------------------+-------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Controller Layout | app/views/layouts/posts.phtml | This is the view related to the controller. It only will be shown for every action executed within the controller "posts". All the code implemented in the layout will be reused for all the actions in this controller. |
+-------------------+-------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Main Layout       | app/views/index.phtml         | This is main action it will be shown for every controller or action executed within the application.                                                                                                                     |
+-------------------+-------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

You are not required to implement all of the files mentioned above. :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` will simply move to the
next view level in the hierarchy of files. If all three view files are implemented, they will be processed as follows:

.. code-block:: html+php

    <!-- app/views/posts/show.phtml -->

    <h3>This is show view!</h3>

    <p>I have received the parameter <?php $postId ?></p>

.. code-block:: html+php

    <!-- app/views/layouts/posts.phtml -->

    <h2>This is the "posts" controller layout!</h2>

    <?php echo $this->getContent() ?>

.. code-block:: html+php

    <!-- app/views/index.phtml -->
    <html>
        <head>
            <title>Example</title>
        </head>
        <body>

            <h1>This is main layout!</h1>

            <?php echo $this->getContent() ?>

        </body>
    </html>

Note the lines where the method *$this->getContent()* was called. This method instructs :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`
on where to inject the contents of the previous view executed in the hierarchy. For the example above, the output will be:

.. figure:: ../_static/img/views-1.png
   :align: center

The generated HTML by the request will be:

.. code-block:: html+php

    <!-- app/views/index.phtml -->
    <html>
        <head>
            <title>Example</title>
        </head>
        <body>

            <h1>This is main layout!</h1>

            <!-- app/views/layouts/posts.phtml -->

            <h2>This is the "posts" controller layout!</h2>

            <!-- app/views/posts/show.phtml -->

            <h3>This is show view!</h3>

            <p>I have received the parameter 101</p>

        </body>
    </html>

Using Templates
---------------
Templates are views that can be used to share common view code. They act as controller layouts, so you need to place them in the layouts directory.

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {
        public function initialize()
        {
            $this->view->setTemplateAfter('common');
        }

        public function lastAction()
        {
            $this->flash->notice("These are the latest posts");
        }
    }

.. code-block:: html+php

    <!-- app/views/index.phtml -->
    <!DOCTYPE html>
    <html>
        <head>
            <title>Blog's title</title>
        </head>
        <body>
            <?php echo $this->getContent() ?>
        </body>
    </html>

.. code-block:: html+php

    <!-- app/views/layouts/common.phtml -->

    <ul class="menu">
        <li><a href="/">Home</a></li>
        <li><a href="/articles">Articles</a></li>
        <li><a href="/contact">Contact us</a></li>
    </ul>

    <div class="content"><?php echo $this->getContent() ?></div>

.. code-block:: html+php

    <!-- app/views/layouts/posts.phtml -->

    <h1>Blog Title</h1>

    <?php echo $this->getContent() ?>

.. code-block:: html+php

    <!-- app/views/layouts/posts/last.phtml -->

    <article>
        <h2>This is a title</h2>
        <p>This is the post content</p>
    </article>

    <article>
        <h2>This is another title</h2>
        <p>This is another post content</p>
    </article>

The final output will be the following:

.. code-block:: html+php

    <!-- app/views/index.phtml -->
    <!DOCTYPE html>
    <html>
        <head>
            <title>Blog's title</title>
        </head>
        <body>

            <!-- app/views/layouts/common.phtml -->

            <ul class="menu">
                <li><a href="/">Home</a></li>
                <li><a href="/articles">Articles</a></li>
                <li><a href="/contact">Contact us</a></li>
            </ul>

            <div class="content">

                <!-- app/views/layouts/posts.phtml -->

                <h1>Blog Title</h1>

                <!-- app/views/layouts/posts/last.phtml -->

                <article>
                    <h2>This is a title</h2>
                    <p>This is the post content</p>
                </article>

                <article>
                    <h2>This is another title</h2>
                    <p>This is another post content</p>
                </article>

            </div>

        </body>
    </html>

Using Partials
--------------
Partial templates are another way of breaking the rendering process into simpler more manageable chunks that can be reused by different
parts of the application. With a partial, you can move the code for rendering a particular piece of a response to its own file.

One way to use partials is to treat them as the equivalent of subroutines: as a way to move details out of a view so that your code can be
more easily understood. For example, you might have a view that looks like this:

.. code-block:: html+php

    <?php $this->partial("shared/ad_banner") ?>

    <h1>Robots</h1>

    <p>Check out our specials for robots:</p>
    ...

    <?php $this->partial("shared/footer") ?>


Transfer values from the controller to views
--------------------------------------------
:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` is available in each controller using the view variable ($this->view). You can use that
object to set variables directly to the view from a controller action by using the setVar() method.

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction()
        {
            //Pass all the posts to the views
            $this->view->setVar("posts", Posts:find());
        }

    }

A variable with the name of the first parameter of setView() will be created in the view, ready to be used. The variable can be of any type,
from a simple string, integer etc. variable to a more complex structure such as array, collection etc.

.. code-block:: html+php

    <div class="post">
    <?php

      foreach ($posts as $post)
      {
        echo "<h1>", $post->title, "</h1>";
      }

    ?>
    </div>

Control Rendering Levels
------------------------
As seen above, :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` supports a view hierarchy. You might need to control the level of rendering
produced by the view component. The method Phalcon\Mvc\\View::setRenderLevel() offers this functionality.

This method can be invoked from the controller or from a superior view layer to interfere with the rendering process.

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function findAction()
        {

            // This is an Ajax response so don't generate any kind of view
            $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);

            //...
        }

        public function showAction($postId)
        {
            // Shows only the view related to the action
            $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        }

    }

The available render levels are:

+-----------------------+--------------------------------------------------------------------------+
| Class Constant        | Description                                                              |
+=======================+==========================================================================+
| LEVEL_NO_RENDER       | Indicates to avoid generating any kind of presentation.                  |
+-----------------------+--------------------------------------------------------------------------+
| LEVEL_ACTION_VIEW     | Generates the presentation to the view associated to the action.         |
+-----------------------+--------------------------------------------------------------------------+
| LEVEL_BEFORE_TEMPLATE | Generates presentation templates prior to the controller layout.         |
+-----------------------+--------------------------------------------------------------------------+
| LEVEL_LAYOUT          | Generates the presentation to the controller layout.                     |
+-----------------------+--------------------------------------------------------------------------+
| LEVEL_AFTER_TEMPLATE  | Generates the presentation to the templates after the controller layout. |
+-----------------------+--------------------------------------------------------------------------+
| LEVEL_MAIN_LAYOUT     | Generates the presentation to the main layout. File views/index.phtml    |
+-----------------------+--------------------------------------------------------------------------+

Using models in the view layer
------------------------------
Application models are always available at the view layer. The :doc:`Phalcon\\Loader <../api/Phalcon_Loader>` will instantiate them at runtime automatically:

.. code-block:: html+php

    <div class="categories">
    <?php

    foreach (Catergories::find("status = 1") as $category) {
       echo "<span class='category'>", $category->name, "</span>";
    }

    ?>
    </div>

Although you may perform model manipulation operations such as insert() or update() in the view layer, it is not recommended since it is not
possible to forward the execution flow to another controller in the case of an error or an exception.

Picking Views
-------------
As mentioned above, when :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` is managed by :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`
the view rendered is the one related with the last controller and action executed. You could override this by using the Phalcon\\Mvc\\View::pick() method:

.. code-block:: php

    <?php

    class ProductsController extends \Phalcon\Mvc\Controller
    {

        public function listAction()
        {
            // Pick "views-dir/products/search" as view to render
            $this->view->pick("products/search");
        }

    }

Caching View Fragments
----------------------
Sometimes when you develop dynamic websites and some areas of them are not updated very often, the output is exactly the same between requests. :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` offers caching a part or the whole rendered output to increase performance.

:doc:`Phalcon\\\Mvc\\View <../api/Phalcon_Mvc_View>` integrates with :doc:`Phalcon\\Cache <cache>` to provide an easier way to cache output fragments.
You could manually set the cache handler or set a global handler:

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function showAction()
        {
            //Cache the view using the default settings
            $this->view->cache(true);
        }

        public function showArticleAction()
        {
            // Cache this view for 1 hour
            $this->view->cache(array("lifetime" => 3600));
        }

        public function resumeAction()
        {
            //Cache this view for 1 day with the key "resume-cache"
            $this->view->cache(
                array(
                    "lifetime" => 86400,
                    "key"      => "resume-cache",
                )
            );
        }

    }

When the View component needs to cache something it will request a cache service to the services container. The service name convention for this
service is "viewCache":

.. code-block:: php

    <?php

    //Set the views cache service
    $di->set('viewCache', function(){

        //Cache data for one day by default
        $frontCache = new Phalcon\Cache\Frontend\Output(array(
            "lifetime" => 86400
        ));

        //Memcached connection settings
        $cache = new Phalcon\Cache\Backend\Memcached($frontCache, array(
            "host" => "localhost",
            "port" => "11211"
        ));

        return $cache;
    });

Disabling the view
------------------
If your controller doesn't produce any output in the view (or not even have one) you may disable the view component avoiding unnecessary processing:

.. code-block:: php

    <?php

    class UsersController extends \Phalcon\Mvc\Controller
    {

        public function closeSessionAction()
        {

            //Disable the view
            $this->view->disable();

            //The same
            $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_NO_RENDER);
        }

    }

Template Engines
----------------
Template Engines helps designers to create views without use a complicated syntax. Phalcon includes a powerful and fast templating engine
called :doc:`Volt <volt>`.

Additionally, :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` allows you to use other template engines instead of plain PHP or Volt.

Using a different template engine, usually requires complex text parsing using external PHP libraries in order to generate the final output
for the user. This usually increases the number of resources that your application are using.

If an external template engine is used, :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` provides exactly the same view hierarchy and it's
still possible to access the API inside these templates with a little more effort.

The component uses adapters, these help Phalcon to speak with those external template engines in a unified, let's see how to do that integration.

Creating your own Template Engine Adapter
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
There are many template engines, which you might want to integrate or create one of your own. The first step to use an external template engine
it's create an adapter for it.

A template engine adapter is a class that acts as bridge between :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` and the template engine itself.
Usually it only needs two methods implemented: __construct() and render(). The first one receives the :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`
instance that creates the engine adapter and the DI container used by the application.

The method render() accepts an absolute path to the view file and the view parameters set using $this->view->setVar(). You could read or require it
when it's necessary.

.. code-block:: php

    <?php

    class MyTemplateAdapter extends \Phalcon\Mvc\View\Engine
    {

        /**
         * Adapter constructor
         *
         * @param \Phalcon\Mvc\View $view
         * @param \Phalcon\DI $di
         */
        public function __construct($view, $di)
        {
            //Initiliaze here the adapter
            parent::__construct($view, $di);
        }

        /**
         * Renders a view using the template engine
         *
         * @param string $path
         * @param array $params
         */
        public function render($path, $params)
        {

            // Access view
            $view = $this->_view;

            // Access options
            $options = $this->_options;

            //Render the view
        }

    }

Changing the Template Engine
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
You can replace or add more a template engine from the controller as follows:

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            // Set the engine
            $this->view->registerEngines(
                array(
                    ".my-html" => "MyTemplateAdapter"
                )
            );
        }

        public function showAction()
        {
            // Using more than one template engine
            $this->view->registerEngines(
                array(
                    ".my-html" => 'MyTemplateAdapter'
                    ".phtml" => 'Phalcon\Mvc\View\Engine\Php'
                )
            );
        }

    }

You can replace the template engine completely or use more than one template engine at the same time. The method \Phalcon\\Mvc\\View::registerEngines()
accepts an array containing data that define the template engines. The key of each engine is an extension that aids in distinguishing one from another.
Template files related to the particular engine must have those extensions.

The order that the template engines are defined with \Phalcon\\Mvc\\View::reginsterEngines() defines the relevance of execution. If
:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` finds two views with the same name but different extensions, it will only render the first one.

If you want to register a template engine or a set of them for each request in the application. You could register it when the view service is created:

.. code-block:: php

    <?php

    //Setting up the view component
    $di->set('view', function() {

        $view = new \Phalcon\Mvc\View();

        $view->setViewsDir('../app/views/');

        $view->registerEngines(
            array(
                ".my-html" => 'MyTemplateAdapter'
            )
        );

        return $view;
    });

To better explain how to create an adapter for template engines, let's make the integration with two well known: Mustache and Twig.

Using Mustache
^^^^^^^^^^^^^^
`Mustache`_ is a logic-less template engine available for many platforms and languages. A PHP implementation is available in `this Github repository`_.

You need to manually load the Mustache library before use its engine adapter. Either registering an autoload function or including
the relevant file first can achieve this.

.. code-block:: php

    <?php

    require "path/to/Mustache/Autoloader.php";
    Mustache_Autoloader::register();

A template engine adapter for Mustache would look like:

.. code-block:: php

    <?php

    /**
     * Adapter to use Mustache library as templating engine
     */
    class My_Mustache_Adapter extends \Phalcon\Mvc\View\Engine
    {

        protected $_mustache;

        protected $_params;

        public function __construct(Phalcon\Mvc\View $view, Phalcon\DI $di)
        {
            $this->_mustache = new Mustache_Engine();
            parent::__construct($view, $di);
        }

        public function render($path, $params)
        {
            if (!isset($params['content'])) {
                $params['content'] = $this->_view->getContent();
            }
            $this->_view->setContent($this->_mustache->render(file_get_contents($path), $params));
        }

    }

Now, in the controller it's necessary to replace or add the Mustache adapter to the view component. If all of your actions will use this
template engine, you can register it in the initialize() method of the controller.

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function initialize()
        {

            // Changing PHP engine by Mustache
            $this->view->registerEngines(
                array(".mhtml" => "My_Mustache_Adapter")
            );

        }

        public function showAction()
        {

            $this->view->setVar("showPost", true);
            $this->view->setVar("title", "some title");
            $this->view->setVar("body", "a cool content");

        }

    }

A related view (views-dir/posts/show.mhtml) could be defined using the Mustache syntax:

.. code-block:: html+php

    {{#showPost}}
        <h1>{{title}}</h1>
        <p>{{body}}</p>
    {{/showPost}}

Additionally, as seen above, you must call the method $this->getContent() inside a view to include the contents of a view at a higher
level. In Moustache, this can be done as follows:

.. code-block:: html+php

    <div class="some-menu">
        <!-- the menu -->
    </div>

    <div class="some-main-content">
        {{content}}
    </div>

Using Twig
^^^^^^^^^^
Twig_ is a modern template engine for PHP.

You need to manually load the Twig library before use its engine adapter. Registering its autoloader could do this:

.. code-block:: php

    <?php

    require "path/to/Twig/Autoloader.php";
    Twig_Autoloader::register();

A template engine adapter for Twig would look like:

.. code-block:: php

    <?php

    /**
     * Adapter to use Twig library as templating engine
     */
    class My_Twig_Adapter extends \Phalcon\Mvc\View\Engine
    {

        protected $_twig;

        public function __construct(Phalcon\Mvc\View $view, Phalcon\DI $di)
        {
            $loader = new Twig_Loader_Filesystem($view->getViewsDir());
            $this->_twig = new Twig_Environment($loader);
            parent::__construct($view, $di);
        }

        public function render($path, $params)
        {
            $view = $this->_view;
            if (!isset($params['content'])) {
                $params['content'] = $view->getContent();
            }
            if (!isset($params['view'])) {
                $params['view'] = $view;
            }
            $relativePath = str_replace($view->getViewsDir(), '', $path);
            $this->_view->setContent($this->_twig->render($relativePath, $params));
        }

    }

As seen above, it's necessary to replace the default engine by twig or use it together with other.

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function initialize()
        {

            // Changing PHP engine by Twig
            $this->view->registerEngines(
                array(".twig" => "Twig")
            );

        }

        public function showAction()
        {

            $this->view->setVar("showPost", true);
            $this->view->setVar("title", "some title");
            $this->view->setVar("body", "a cool content");

        }

    }

In this case, the related view will be views-dir/posts/show.twig, this is a file that contains Twig code:

.. code-block:: html+php

    {{% if showPost %}}
        <h1>{{ title }}</h1>
        <p>{{ body }}</p>
    {{% endif %}}

To include the contents of a view at a higher level, the "content" variable is available:

.. code-block:: html+php

    <div class="some-messages">
        {{ content }}
    </div>

Using Smarty
^^^^^^^^^^^^
Smarty_ is a template engine for PHP, facilitating the separation of presentation (HTML/CSS) from application logic.

You need to manually include the Smarty library before use its engine adapter. Including its adapter:

.. code-block:: php

    <?php

    require_once 'Smarty3/Smarty.class.php';

A template engine adapter for Smarty would look like:

.. code-block:: php

    <?php

    class SmartyEngine extends \Phalcon\Mvc\View\Engine
    {

        protected $_smarty;
        protected $_params;

        public function __construct(Phalcon\Mvc\View $view, Phalcon\DI $di)
        {
            $this->_smarty = new Smarty();
            $this->_smarty->template_dir = '.';
            $this->_smarty->compile_dir = SMARTY_DIR . 'templates_c';
            $this->_smarty->config_dir = SMARTY_DIR . 'configs';
            $this->_smarty->cache_dir = SMARTY_DIR . 'cache';
            $this->_smarty->caching = false;
            $this->_smarty->debugging = true;
            parent::__construct($view, $di);
        }

        public function render($path, $params)
        {
            if (!isset($params['content'])) {
                $params['content'] = $this->_view->getContent();
            }
            foreach($params as $key => $value){
                $this->_smarty->assign($key, $value);
            }
            $this->_view->setContent($this->_smarty->fetch($path));
        }

    }

Injecting services in View
--------------------------
Every view executed is included inside a :doc:`Phalcon\\DI\\Injectable <../api/Phalcon_DI_Injectable>` instance, providing easy access
to the application's service container.

The following example shows how to write a jQquery `ajax request`_ using a url with the framework conventions. The service "url" is
injected in the view by just only accessing it:

.. code-block:: html+php

    <script type="text/javascript">

    $.ajax({
        url: "<?php echo $this->url->get("cities/get") ?>"
    })
    .done(function() {
        alert("Done!");
    });

    </script>


Stand-Alone Component
---------------------
All the components in Phalcon can be used as *glue* components individually because they are loosely coupled to each other. Using
:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` in a stand-alone mode can be demonstrated below:

.. code-block:: php

    <?php

    $view = new \Phalcon\Mvc\View();
    $view->setViewsDir("../app/views/");

    // Passing variables to the views, these will be created as local variables
    $view->setVar("someProducts", $products);
    $view->setVar("someFeatureEnabled", true);

    //Start the output buffering
    $view->start();

    //Render all the view hierarchy related to the view products/list.phtml
    $view->render("products", "list");

    //Finish the output buffering
    $view->finish();

    echo $view->getContent();

View Events
-----------
:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` is able to send events to a :doc:`EventsManager <events>` if it's present. Events
are triggered using the type "view". Some events when returning boolean false could stop the active operation. The following events are supported:

+----------------------+------------------------------------------------------------+---------------------+
| Event Name           | Triggered                                                  | Can stop operation? |
+======================+============================================================+=====================+
| beforeRender         | Triggered before start the render process                  | Yes                 |
+----------------------+------------------------------------------------------------+---------------------+
| beforeRenderView     | Triggered before render an existing view                   | Yes                 |
+----------------------+------------------------------------------------------------+---------------------+
| afterRenderView      | Triggered after render an existing view                    | No                  |
+----------------------+------------------------------------------------------------+---------------------+
| afterRender          | Triggered after complete the render process                | No                  |
+----------------------+------------------------------------------------------------+---------------------+

The following example demonstrates how to attach listeners to this component:

.. code-block:: php

    <?php

    $di->set('view', function(){

        //Create an event manager
        $eventsManager = new Phalcon\Events\Manager();

        //Attach a listener for type "view"
        $eventsManager->attach("view", function($event, $view) {
            echo $event->getType(), ' - ', $view->getActiveRenderPath(), PHP_EOL;
        });

        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir("../app/views/");

        //Bind the eventsManager to the view component
        $view->setEventsManager($eventManagers);

        return $view;
    });

.. _Mustache: https://github.com/bobthecow/mustache.php
.. _Twig: http://twig.sensiolabs.org
.. _this Github repository: https://github.com/bobthecow/mustache.php
.. _ajax request: http://api.jquery.com/jQuery.ajax/
.. _Smarty: http://www.smarty.net/