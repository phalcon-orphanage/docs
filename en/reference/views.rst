Using Views
===========
Views represent the user interface of your application. Views are often HTML files with embedded PHP code that perform tasks related solely to the presentation of the data. Views handle the job of providing data to the web browser or other tool that is used to make requests from your application.

The :doc:`Phalcon_View <../api/Phalcon_View>` is responsible for the managing the view layer of your MVC application.

A hierarchy of files is supported by the component. This hierarchy allows for common layout points (commonly used views), as well as controller named folders defining respective view templates.

Integrating Views with Controllers
----------------------------------
Phalcon automatically passes the execution to the view component as soon as a particular controller has completed its cycle. The view component will look in the views folder for a folder named as the same name of the last controller executed and then for a file named as the last action executed. For instance, if a request is made to the URL *http://127.0.0.1/blog/posts/show/301*, Phalcon will parse the URL as follows:

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

    class PostsController extends Phalcon_Controller
    {

        function indexAction()
        {

        }

        function showAction($postId)
        {
            // Pass the $postId parameter to the view
            $this->view->setVar("postId", $postId);
        }

    }

The setVar allows us to create view variables on demand so that they can be used in the view template. The example above demonstrates how to pass the $postId parameter to the respective view template.

:doc:`Phalcon_View <../api/Phalcon_View>` uses PHP itself as the template engine, therefore views should have the .phtml extension. If the views directory is  *app/views* then view component will find automatically for these 3 view files.

+-------------------+-------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Name              | File                          | Description                                                                                                                                                                                                           |
+===================+===============================+=======================================================================================================================================================================================================================+
| Action View       | app/views/posts/show.phtml    | This is the view related to the action. It only will be shown when the "show" action was executed.                                                                                                                    |
+-------------------+-------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Controller Layout | app/views/layouts/posts.phtml | This is the view related to the controller. It only will be shown for every action executed within the controller "posts". All the code implemented in the layout will reused for all the actions in this controller. |
+-------------------+-------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Main Layout       | app/views/index.phtml         | This is main action it will be shown for every controller or action executed within the application.                                                                                                                  |
+-------------------+-------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

You are not required to implement all of the files mentioned above. :doc:`Phalcon_View <../api/Phalcon_View>` will simply move to the next view level in the hierarchy of files. If all three view files are implemented, they will be processed as follows:

.. code-block:: html+php

    <!-- app/views/posts/show.phtml -->

    <h3>This is show view!</h3>

    <p>I have received the parameter <?php $postId ?></p>

.. code-block:: html+php

    <!-- app/views/layouts/posts.phtml -->

    <h2>This is the "posts" controller layout!</h2>

    <?php $this->getContent() ?>

.. code-block:: html+php

    <!-- app/views/index.phtml -->
    <html>
        <head>
            <title>Example</title>
        </head>
        <body>

            <h1>This is main layout!</h1>

            <?php $this->getContent() ?>

        </body>
    </html>

Note the lines where the method *$this->getContent()* was called. This method instructs :doc:`Phalcon_View <../api/Phalcon_View>` on where to inject the contents of the previous view executed in the hierarchy. For the example above, the output will be:

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

Using Partials
--------------
Partial templates are another way of breaking the rendering process into simpler more manageable chunks that can be reused by different parts of the application. With a partial, you can move the code for rendering a particular piece of a response to its own file.

One way to use partials is to treat them as the equivalent of subroutines: as a way to move details out of a view so that your code can be more easily understood. For example, you might have a view that looks like this:

.. code-block:: html+php

    <?php $this->partial("shared/ad_banner") ?>

    <h1>Robots</h1>

    <p>Check out our specials for robots:</p>
    ...

    <?php $this->partial("shared/footer") ?>


Transfer values from the controller to views
--------------------------------------------
:doc:`Phalcon_View <../api/Phalcon_View>` is available in each controller using the view variable ($this->view). You can use that object to set variables directly to the view from a controller action by using the setVar() method.

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function indexAction()
        {

        }

        function showAction()
        {
            //Pass all the posts to the views
            $this->view->setVar("posts", Posts:find());
        }

    }

A variable with the name of the first parameter of setView() will be created in the view, ready to be used. The variable can be of any type, from a simple string, integer etc. variable to a more complex structure such as array, collection etc.

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
As seen above, :doc:`Phalcon_View <../api/Phalcon_View>` supports a view hierarchy. You might need to control the level of rendering produced by the view component. The method Phalcon_View::setRenderLevel() offers this functionality.

This method can be invoked from the controller or from a superior view layer to interfere with the rendering process.

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function indexAction()
        {

        }

        function findAction()
        {

            // This is an Ajax response so don't generate any kind of view
            $this->view->setRenderLevel(Phalcon_View::LEVEL_NO_RENDER);

            //...
        }

        function showAction($postId)
        {
            // Shows only the view related to the action
            $this->view->setRenderLevel(Phalcon_View::LEVEL_ACTION_VIEW);
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
Application models are always available at the view layer. The :doc:`Phalcon Loader <../api/Phalcon_Loader>` will instantiate them at runtime automatically:

.. code-block:: html+php

    <div class="categories">
    <?php

    foreach (Catergories::find("status = 1") as $category) {
       echo "<span class='category'>", $category->name, "</span>";
    }

    ?>
    </div>

Although you may perform model manipulation operations such as insert() or update() in the view layer, it is not recommended since it is not possible to forward the execution flow to another controller in the case of an error or an exception.

Picking Views
-------------
As mentioned above, when :doc:`Phalcon_View <../api/Phalcon_View>` is managed by :doc:`Phalcon_Controller_Front <../api/Phalcon_Controller_Front>` the view rendered is the one related with the last controller and action executed. You could override this by using the Phalcon_View::pick() method:

.. code-block:: php

    <?php

    class ProductsController extends Phalcon_Controller
    {

        function listAction()
        {
            // Pick "views-dir/products/search" as view to render
            $this->view->pick("products/search");
        }

    }


Caching View Fragments
^^^^^^^^^^^^^^^^^^^^^^
Sometimes when you develop dynamic websites and some areas of them are not updated very often, the output is exactly the same between requests. :doc:`Phalcon_View <../api/Phalcon_View>` offers caching a part or the whole rendered output to increase performance.

:doc:`Phalcon_View <../api/Phalcon_View>` integrates with :doc:`Phalcon_Cache <../api/Phalcon_Cache>` to provide an easier way to cache output fragments. You could manually set the cache handler or set a global handler:

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function initialize()
        {

            // Cache data for one day by default
            $frontendOptions = array(
                "lifetime" => 86400
            );

            // File cache settings
            $backendOptions = array(
                "cacheDir" => "../app/cache/"
            );

            // Create a memcached cache
            $cache = Phalcon_Cache::factory(
                "Output",
                "Memcached",
                $frontendOptions,
                $backendOptions
            );

            // Set the cache to the view component
            $this->view->setCache($cache);
        }

        function showAction()
        {
            //Cache the view using the default settings
            $this->view->cache(true);
        }

        function showArticleAction()
        {
            // Cache this view for 1 hour
            $this->view->cache(array("lifetime" => 3600));
        }

        function resumeAction()
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

In the above example, a cache backend was instantiated in the initialize() method of the current controller. You can set the cache initialization options in your configuration file so that they can be easily accessed when needed:

.. code-block:: ini

    [views]
    cache.adapter  = "File"
    cache.cacheDir = "cacheDir"
    cache.lifetime = 86400

Template Engines
----------------
From version 0.4.0 onwards, :doc:`Phalcon_View <../api/Phalcon_View>` allows you to use other template engines instead of plain PHP. This helps developers to create and design views with less effort. The Mustache_ and Twig_ template engines are supported.

Using a different template engine, usually requires complex text parsing using external PHP libraries in order to generate the final output for the user. This usually increases the number of resources that your application is using.

If an external template engine is used, :doc:`Phalcon_View <../api/Phalcon_View>` provides exactly the same view hierarchy and it's still possible to access the API inside these templates.

Changing the Template Engine
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
You can replace or add more a template engine from the controller as follows:

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function indexAction()
        {
            // Changing PHP engine to Mustache
            $this->view->registerEngines(
                array".mhtml" => "Mustache")
            );
        }

        function showAction()
        {
            // Using both PHP and Mustache engines
            $this->view->registerEngines(
                array(
                    ".phtml" => "Php",
                    ".mhtml" => "Mustache",
                )
            );
        }

    }

You can replace the template engine completely or use more than one template engine at the same time. The method Phalcon_View::registerEngines() accepts an array containing data that define the template engines. The key of each engine is an extension that aids in distinguishing one from another. Template files related to the particular engine must have those extensions.

The order that the template engines are defined with Phalcon_View::reginsterEngines() defines the relevance of execution. If :doc:`Phalcon_View <../api/Phalcon_View>` finds two views with the same name but different extensions, it will only render the first one.

Using Mustache
^^^^^^^^^^^^^^
`Mustache`_ is a logic-less template engine available for many platforms and languages. A PHP implementation is available in `this Github repository`_.

You need to manually load the Mustache library before use its engine adapter. This can be achieved by either registering an autoload function or including the relevant file first.

.. code-block:: php

    <?php require "path/to/Mustache.php";

In the controller it's necessary to replace or add the Mustache adapter to the view component. If all of your actions will use this template engine, you can register it in the initialize() method of the controller.

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function initialize()
        {

            // Changing PHP engine by Mustache
            $this->view->registerEngines(
                array(".mhtml" => "Mustache")
            );

        }

        function showAction()
        {

            $this->view->setVar("showPost", true);
            $this->view->setVar("title", "some title");
            $this->view->setVar("body", "a cool content");

        }

    }

A related view (views-dir/posts/show.mhtml) could be defined using the Mustache syntax:

.. code-block:: php

    <?php

    {{#showPost}}
        <h1>{{title}}</h1>
        <p>{{body}}</p>
    {{/showPost}}

Additionally, as seen above, you must call the method $this->getContent() inside a view to include the contents of a view at a higher level. In Moustache, this can be done as follows:

.. code-block:: php

    <div class="some-menu">
        <! -- the menu -->
    </div>

    <div class="some-main-content">
        {{getContent}}
    </div>

Finally, it is possible to define your own Mustache instance instead of the one created by the adapter. This offers maximum customization towards your project's needs:

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function showAction()
        {

            // Instancing a mustache object or a sub-class of Mustache
            $presenter = new CustomMustache();

            // ... make some mustache stuff

            // Registering the object as an option
            $this->view->registerEngines(
                array(
                    ".mhtml" => array(
                        "Mustache",
                        array(
                            "mustache" => $presenter
                        )
                    )
                )
            );
        }

    }

Using Twig
^^^^^^^^^^
Twig_ is a modern template engine for PHP.

You need to manually load the Twig library before use its engine adapter. This could be done by registering its autoloader:

.. code-block:: php

    <?php

    require "path/to/twig.php";
    Twig_Autoloader::register();

As seen above, it's necessary to replace the default engine by twig or use it together with other.

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function initialize()
        {

            // Changing PHP engine by Twig
            $this->view->registerEngines(
                array(".twig" => "Twig")
            );

        }

        function showAction()
        {

            $this->view->setVar("showPost", true);
            $this->view->setVar("title", "some title");
            $this->view->setVar("body", "a cool content");

        }

    }

In this case, the related view will be views-dir/posts/show.twig, this is a file that contains Twig code:

.. code-block:: php

    <?php

    {{% if showPost %}}
        <h1>{{ title }}</h1>
        <p>{{ body }}</p>
    {{% endif %}}

To include the contents of a view at a higher level, the "content" variable is available:

.. code-block:: php

    <div class="some-messages">
        {{ content }}
    </div>

Phalcon implicitly creates a twig object as follows:

.. code-block:: php

    <?php

    $loader = new Twig_Loader_Filesystem($viewsDirectory);
    $twig   = new Twig_Environment($loader);

If you want to modify any of those variables before rendering the views, you can pre-build and pass them as options:

.. code-block:: php

    <?php

    class PostsController extends Phalcon_Controller
    {

        function showAction()
        {

            // Creating manually the Twig object
            $loader = new Twig_Loader_Filesystem($this->view->getViewsDir());
            $twig   = new Twig_Environment(
                $loader,
                array("cache" => "/path/to/compilation_cache")
            );

            // Registering the object as an option
            $this->view->registerEngines(
                array(
                    ".twig" => array(
                        "Twig",
                        array(
                            "twig" => $twig
                        )
                    )
                )
            );

        }

    }



Creating your own Template Engine
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
There are many template engines, which you might want to integrate or create one of your own. This section provides the steps to achieve this.

A template adapter is only instantiated once across the execution of the request. Usually it only needs two methods implemented: __contstruct() and render(). The first one receives the :doc:`Phalcon_View <../api/Phalcon_View>` instance which creates the engine adapter and the options passed when the engine was registered.

The method render() accepts an absolute path to the view file and the view parameters set using $this->view->setVar(). You could read or require it when it's necessary.

.. code-block:: php

    <?php

    class MyTemplateAdapter extends Phalcon_View_Engine
    {

        /**
         * Adapter constructor
         *
         * @param Phalcon_View $view
         * @param array $options
         */
        function __construct($view, $options)
        {
            parent::__construct($view, $options);
        }

        /**
         * Renders a view using the template engine
         *
         * @param string $path
         * @param array $params
         */
        function render($path, $params)
        {

            // Access view
            $view = $this->_view;

            // Access options
            $options = $this->_options;

        }

    }

When registering the engine, a instance of your template adapter must be passed along with the desired extension:

.. code-block:: php

    <?php

    class SomeController extends Phalcon_Controller
    {

        function someAction()
        {

            // Registering the object as an engine
            $this->view->registerEngines(
                array(".my-html" => new MyTemplateAdapter())
            );

        }

    }


View Environment
----------------
Every view executed is included inside a :doc:`Phalcon_View_Engine <../api/Phalcon_View_Engine>` instance, providing access to the view environment and its properties that can be used in your developments.

The following example shows how to write a jQquery `ajax request`_ using a url with the framework conventions. The method url() is called from a $this instance that references the :doc:`Phalcon_View <../api/Phalcon_View>` object:

.. code-block:: php+html

    <script type="text/javascript>">
    $.ajax({
        url: "<?php $this->url("cities/get") ?>"
    })
    .done(function() {
        alert("Done!");
    });
    </script>


Stand-Alone Component
---------------------
All the components in Phalcon can be used as *glue* components individually because they are loosely coupled to each other. Using :doc:`Phalcon_View <../api/Phalcon_View>` in a stand alone mode can be demonstrated below:

.. code-block:: php

    <?php

    $view = new Phalcon_View();
    $view->setViewsDir("../app/views/");

    // Passing variables to the views, these will be created as local variables
    $view->setVar("someProducts", $products);
    $view->setVar("someFeatureEnabled", true);

    $view->start();
    $view->render("products", "list");
    $view->finish();

    echo $view->getContent();


.. _Mustache: https://github.com/bobthecow/mustache.php
.. _Twig: http://twig.sensiolabs.org
.. _this Github repository: https://github.com/bobthecow/mustache.php
.. _ajax request: http://api.jquery.com/jQuery.ajax/
