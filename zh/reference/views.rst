使用视图（Using Views）
=======================
视图代表了应用程序中的用户界面. 视图通常是在 HTML 文件里嵌入 PHP 代码，这些代码仅仅是用来展示数据。
视图的任务是当应用程序发生请求时，提供数据给 web 浏览器或者其他工具。


:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` 和 :doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>`
负责管理你的MVC应用程序的视图(View)层。

集成视图到控制器（Integrating Views with Controllers）
------------------------------------------------------
当某个控制器已经完成了它的周期，Phalcon自动将执行传递到视图组件。视图组件将在视图文件夹中寻找一个文件夹名与最后一个控制器名相同,文件命名与最后一个动作相同的文件执行。例如，如果请求的URL *http://127.0.0.1/blog/posts/show/301*, Phalcon将如下所示的方式按解析URL:

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

调度程序将寻找一个“PostsController”控制器及其“showAction”动作。对于这个示例的一个简单的控制器文件：

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

setVar允许我们创建视图变量，这样可以在视图模板中使用它们。上面的示例演示了如何传递 $postId 参数到相应的视图模板。

分层渲染（Hierarchical Rendering）
----------------------------------
:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` 支持文件的层次结构，在Phalcon中是默认的视图渲染组件。这个层次结构允许通用的布局点(常用的视图)和以控制器命名的文件夹中定义各自的视图模板

该组件使用默认PHP本身作为模板引擎，因此视图应该以.phtml作为拓展名。如果视图目录是 *app/views* ，视图组件会自动找到这三个视图文件。

+-------------------+-------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| 名称              | 文件                          | 解释                                                                                                                                                                                                              |
+===================+===============================+==========================================================================================================================================================================================================================+
| Action View       | app/views/posts/show.phtml    | 这是该动作相关的视图。它只会在执行“show”动作时显示。 |
+-------------------+-------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Controller Layout | app/views/layouts/posts.phtml | 这是该控制器相关的视图。它只会“posts”控制器内每个动作执行时显示。这个控制器的所有动作将重用这个布局的全部代码。|
+-------------------+-------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Main Layout       | app/views/index.phtml         | 这是主布局，它将在应用程序的每个控制器或动作执行时显示。|
+-------------------+-------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

你不需要实现上面提到的所有文件。在文件的层次结构中 :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` 将简单地移动到下一个视图级别。如果这三个视图文件被实现，他们将被按下面方式处理:

.. code-block:: html+php

    <!-- app/views/posts/show.phtml -->

    <h3>This is show view!</h3>

    <p>I have received the parameter <?php echo $postId ?></p>

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

注意方法 *$this->getContent()* 被调用的这行。这种方法指示 :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` 在这里注入前面视图层次结构执行的内容。在上面的示例中，输出将会是：

.. figure:: ../_static/img/views-1.png
   :align: center

请求生成的HTML的将为：

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

使用模版（Using Templates）
^^^^^^^^^^^^^^^^^^^^^^^^^^^
模板视图可以用来分享共同的视图代码。他们作为控制器的布局，所以你需要放在布局目录。

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

最终的输出如下:

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

渲染级别控制（Control Rendering Levels）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
如上所述，:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` 支持视图分层。你可能需要控制视图组件的渲染级别。方法 Phalcon\Mvc\\View::setRenderLevel() 提供这个功能。

这种方法可以从控制器调用或是从上级视图层干涉渲染过程。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller,
        Phalcon\Mvc\View;

    class PostsController extends Controller
    {

        public function indexAction()
        {

        }

        public function findAction()
        {

            // This is an Ajax response so it doesn't generate any kind of view
            $this->view->setRenderLevel(View::LEVEL_NO_RENDER);

            //...
        }

        public function showAction($postId)
        {
            // Shows only the view related to the action
            $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        }

    }

可用的渲染级别:

+-----------------------+--------------------------------------------------------------------------+-------+
| 类常量                | 解释                                                                     | 顺 序 |
+=======================+==========================================================================+=======+
| LEVEL_NO_RENDER       | 表明要避免产生任何形式的显示。                                           |       |
+-----------------------+--------------------------------------------------------------------------+-------+
| LEVEL_ACTION_VIEW     | 生成显示到视图关联的动作。                                               | 1     |
+-----------------------+--------------------------------------------------------------------------+-------+
| LEVEL_BEFORE_TEMPLATE | 生成显示到控制器模板布局之前。                                           | 2     |
+-----------------------+--------------------------------------------------------------------------+-------+
| LEVEL_LAYOUT          | 生成显示到控制器布局。                                                   | 3     |
+-----------------------+--------------------------------------------------------------------------+-------+
| LEVEL_AFTER_TEMPLATE  | 生成显示到控制器模板布局后。                                             | 4     |
+-----------------------+--------------------------------------------------------------------------+-------+
| LEVEL_MAIN_LAYOUT     | 生成显示到主布局。文件： views/index.phtml                               | 5     |
+-----------------------+--------------------------------------------------------------------------+-------+

关闭渲染级别（Disabling render levels）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
你可以永久或暂时禁用渲染级别。如果不在整个应用程序使用，可以永久禁用一个级别：

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;

    $di->set('view', function(){

        $view = new View();

        //Disable several levels
        $view->disableLevel(array(
            View::LEVEL_LAYOUT => true,
            View::LEVEL_MAIN_LAYOUT => true
        ));

        return $view;

    }, true);

或者在某些应用程序的一部分暂时或禁用:

.. code-block:: php

    <?php

    use Phalcon\Mvc\View,
        Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {

        public function indexAction()
        {

        }

        public function findAction()
        {
            $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
        }

    }

选择视图（Picking Views）
^^^^^^^^^^^^^^^^^^^^^^^^^
如上所述, 当 :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` 由 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` 视图渲染的是最后的一个相关的控制器和执行动作。你可以使用 Phalcon\\Mvc\\View::pick() 方法覆盖它。

.. code-block:: php

    <?php

    class ProductsController extends \Phalcon\Mvc\Controller
    {

        public function listAction()
        {
            // Pick "views-dir/products/search" as view to render
            $this->view->pick("products/search");

            // Pick "views-dir/products/list" as view to render
            $this->view->pick(array('products'));

            // Pick "views-dir/products/list" as view to render
            $this->view->pick(array(1 => 'search'));
        }

    }

关闭视图（Disabling the view）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
如果你的控制器不在视图里产生(或没有)任何输出，你可以禁用视图组件来避免不必要的处理：

.. code-block:: php

    <?php

    class UsersController extends \Phalcon\Mvc\Controller
    {

        public function closeSessionAction()
        {
            //Close session
            //...

            //An HTTP Redirect
            $this->response->redirect('index/index');

            //Disable the view to avoid rendering
            $this->view->disable();
        }

    }

你可以返回一个“response”的对象，避免手动禁用视图:

.. code-block:: php

    <?php

    class UsersController extends \Phalcon\Mvc\Controller
    {

        public function closeSessionAction()
        {
            //Close session
            //...

            //An HTTP Redirect
            return $this->response->redirect('index/index');
        }

    }

简单渲染（Simple Rendering）
----------------------------
:doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>` 是 :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`的另一个组成部分。
它保留 :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` 的大多数的设计思想，但缺少文件的层次结构是它们的主要区别。

该组件允许开发人员控制渲染视图时，视图所在位置。
此外，该组件可以利用从视图中继承的可用的模板引擎。比如 :doc:`Volt <volt>` 和其他的一些模板引擎。

默认使用该的组件必须替换服务容器：

.. code-block:: php

    <?php

    $di->set('view', function() {

        $view = new Phalcon\Mvc\View\Simple();

        $view->setViewsDir('../app/views/');

        return $view;

    }, true);

自动渲染必须在 :doc:`Phalcon\\Mvc\\Application <applications>`被禁用 (如果需要):

.. code-block:: php

    <?php

    try {

        $application = new Phalcon\Mvc\Application($di);

        $application->useImplicitView(false);

        echo $application->handle()->getContent();

    } catch (\Exception $e) {
        echo $e->getMessage();
    }

渲染一个视图必须显式地调用render方法来指定你想显示的视图的相对路径：

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            //Render 'views-dir/index.phtml'
            echo $this->view->render('index');

            //Render 'views-dir/posts/show.phtml'
            echo $this->view->render('posts/show');

            //Render 'views-dir/index.phtml' passing variables
            echo $this->view->render('index', array('posts' => Posts::find()));

            //Render 'views-dir/posts/show.phtml' passing variables
            echo $this->view->render('posts/show', array('posts' => Posts::find()));
        }

    }

使用局部模版（Using Partials）
------------------------------
局部模板是把渲染过程分解成更简单、更好管理的、可以重用不同部分的应用程序块的另一种方式。你可以移动渲染特定响应的代码块到自己的文件。

使用局部模板的一种方法是把它们作为相等的子例程：作为一种移动细节视图，这样您的代码可以更容易地被理解。例如，您可能有一个视图看起来像这样：

.. code-block:: html+php

    <div class="top"><?php $this->partial("shared/ad_banner") ?></div>

    <div class="content">
        <h1>Robots</h1>

        <p>Check out our specials for robots:</p>
        ...
    </div>

    <div class="footer"><?php $this->partial("shared/footer") ?></div>

方法 partial() 也接受一个只会存在于局部范围的变量/参数的数组作为第二个参数:

.. code-block:: html+php

    <?php $this->partial("shared/ad_banner", array('id' => $site->id, 'size' => 'big')) ?>

控制器传值给视图（Transfer values from the controller to views）
----------------------------------------------------------------
:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` is available in each controller using the view variable ($this->view). You can
use that object to set variables directly to the view from a controller action by using the setVar() method.

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
            $this->view->setVar("posts", Posts::find());

            //Using the magic setter
            $this->view->posts = Posts::find();

            //Passing more than one variable at the same time
            $this->view->setVars(array(
                'title' => $post->title,
                'content' => $post->content
            ));
        }

    }

A variable with the name of the first parameter of setVar() will be created in the view, ready to be used. The variable can be of any type,
from a simple string, integer etc. variable to a more complex structure such as array, collection etc.

.. code-block:: html+php

    <div class="post">
    <?php

      foreach ($posts as $post) {
        echo "<h1>", $post->title, "</h1>";
      }

    ?>
    </div>

在视图中使用模型（Using models in the view layer）
--------------------------------------------------
Application models are always available at the view layer. The :doc:`Phalcon\\Loader <../api/Phalcon_Loader>` will instantiate them at
runtime automatically:

.. code-block:: html+php

    <div class="categories">
    <?php

        foreach (Categories::find("status = 1") as $category) {
           echo "<span class='category'>", $category->name, "</span>";
        }

    ?>
    </div>

Although you may perform model manipulation operations such as insert() or update() in the view layer, it is not recommended since
it is not possible to forward the execution flow to another controller in the case of an error or an exception.

缓存视图片段（Caching View Fragments）
--------------------------------------
Sometimes when you develop dynamic websites and some areas of them are not updated very often, the output is exactly
the same between requests. :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` offers caching a part or the whole
rendered output to increase performance.

:doc:`Phalcon\\\Mvc\\View <../api/Phalcon_Mvc_View>` integrates with :doc:`Phalcon\\Cache <cache>` to provide an easier way
to cache output fragments. You could manually set the cache handler or set a global handler:

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
            $this->view->cache(array(
                "lifetime" => 3600
            ));
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

        public function downloadAction()
        {
            //Passing a custom service
            $this->view->cache(
                array(
                    "service"  => "myCache",
                    "lifetime" => 86400,
                    "key"      => "resume-cache",
                )
            );
        }

    }

When we do not define a key to the cache, the component automatically creates one doing a md5_ to view name is currently rendered.
It is a good practice to define a key for each action so you can easily identify the cache associated with each view.

When the View component needs to cache something it will request a cache service to the services container.
The service name convention for this service is "viewCache":

.. code-block:: php

    <?php

    use Phalcon\Cache\Frontend\Output as OutputFrontend,
        Phalcon\Cache\Backend\Memcache as MemcacheBackend;

    //Set the views cache service
    $di->set('viewCache', function() {

        //Cache data for one day by default
        $frontCache = new OutputFrontend(array(
            "lifetime" => 86400
        ));

        //Memcached connection settings
        $cache = new MemcacheBackend($frontCache, array(
            "host" => "localhost",
            "port" => "11211"
        ));

        return $cache;
    });

.. highlights::
    The frontend must always be Phalcon\\Cache\\Frontend\\Output and the service 'viewCache' must be registered as
    always open (not shared) in the services container (DI)

When using view caching is also useful to prevent that controllers perform the processes that produce the data to be displayed
in the views.

To achieve this we must identify uniquely each cache with a key. First we verify that the cache does not exist or has
expired to make the calculations/queries to display data in the view:

.. code-block:: html+php

    <?php

    class DownloadController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

            //Check whether the cache with key "downloads" exists or has expired
            if ($this->view->getCache()->exists('downloads')) {

                //Query the latest downloads
                $latest = Downloads::find(array(
                    'order' => 'created_at DESC'
                ));

                $this->view->latest = $latest;
            }

            //Enable the cache with the same key "downloads"
            $this->view->cache(array(
                'key' => 'downloads'
            ));
        }

    }

The `PHP alternative site`_ is an example of implementing the caching of fragments.

模版引擎（Template Engines）
----------------------------
Template Engines helps designers to create views without use a complicated syntax. Phalcon includes a powerful and fast templating engine
called :doc:`Volt <volt>`.

Additionally, :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` allows you to use other template engines instead of plain PHP or Volt.

Using a different template engine, usually requires complex text parsing using external PHP libraries in order to generate the final output
for the user. This usually increases the number of resources that your application are using.

If an external template engine is used, :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` provides exactly the same view hierarchy and it's
still possible to access the API inside these templates with a little more effort.

This component uses adapters, these help Phalcon to speak with those external template engines in a unified way, let's see how to do that integration.

创建模版引擎（Creating your own Template Engine Adapter）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
There are many template engines, which you might want to integrate or create one of your own. The first step to start using an external template engine is create an adapter for it.

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
            //Initialize here the adapter
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
            //...
        }

    }

替换模版引擎（Changing the Template Engine）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
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
                    ".my-html" => 'MyTemplateAdapter',
                    ".phtml" => 'Phalcon\Mvc\View\Engine\Php'
                )
            );
        }

    }

You can replace the template engine completely or use more than one template engine at the same time. The method \Phalcon\\Mvc\\View::registerEngines()
accepts an array containing data that define the template engines. The key of each engine is an extension that aids in distinguishing one from another.
Template files related to the particular engine must have those extensions.

The order that the template engines are defined with \Phalcon\\Mvc\\View::registerEngines() defines the relevance of execution. If
:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` finds two views with the same name but different extensions, it will only render the first one.

If you want to register a template engine or a set of them for each request in the application. You could register it when the view service is created:

.. code-block:: php

    <?php

    //Setting up the view component
    $di->set('view', function() {

        $view = new \Phalcon\Mvc\View();

        //A trailing directory separator is required
        $view->setViewsDir('../app/views/');

        $view->registerEngines(array(
            ".my-html" => 'MyTemplateAdapter'
        ));

        return $view;

    }, true);

There are adapters available for several template engines on the `Phalcon Incubator <https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Mvc/View/Engine>`_

注入服务到视图（Injecting services in View）
--------------------------------------------
Every view executed is included inside a :doc:`Phalcon\\DI\\Injectable <../api/Phalcon_DI_Injectable>` instance, providing easy access
to the application's service container.

The following example shows how to write a jQuery `ajax request`_ using a url with the framework conventions.
The service "url" (usually :doc:`Phalcon\\Mvc\\Url <url>`) is injected in the view by accessing a property with the same name:

.. code-block:: html+php

    <script type="text/javascript">

    $.ajax({
        url: "<?php echo $this->url->get("cities/get") ?>"
    })
    .done(function() {
        alert("Done!");
    });

    </script>

独立的组件（Stand-Alone Component）
-----------------------------------
All the components in Phalcon can be used as *glue* components individually because they are loosely coupled to each other:

分层渲染（Hierarchical Rendering）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Using :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` in a stand-alone mode can be demonstrated below

.. code-block:: php

    <?php

    $view = new \Phalcon\Mvc\View();

    //A trailing directory separator is required
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

A short syntax is also available:

.. code-block:: php

    <?php

    $view = new \Phalcon\Mvc\View();

    echo $view->getRender('products', 'list',
        array(
            "someProducts" => $products,
            "someFeatureEnabled" => true
        ),
        function($view) {
            //Set any extra options here
            $view->setViewsDir("../app/views/");
            $view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
        }
    );

简单渲染（Simple Rendering）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Using :doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>` in a stand-alone mode can be demonstrated below:

.. code-block:: php

    <?php

    $view = new \Phalcon\Mvc\View\Simple();

    //A trailing directory separator is required
    $view->setViewsDir("../app/views/");

    // Render a view and return its contents as a string
    echo $view->render("templates/welcomeMail");

    // Render a view passing parameters
    echo $view->render("templates/welcomeMail", array(
        'email' => $email,
        'content' => $content
    ));

视图事件（View Events）
-----------------------
:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>` and :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View_Simple>` are able to send
events to an :doc:`EventsManager <events>` if it is present. Events are triggered using the type "view". Some events when returning
boolean false could stop the active operation. The following events are supported:

+----------------------+------------------------------------------------------------+---------------------+
| Event Name           | Triggered                                                  | Can stop operation? |
+======================+============================================================+=====================+
| beforeRender         | Triggered before starting the render process               | Yes                 |
+----------------------+------------------------------------------------------------+---------------------+
| beforeRenderView     | Triggered before rendering an existing view                | Yes                 |
+----------------------+------------------------------------------------------------+---------------------+
| afterRenderView      | Triggered after rendering an existing view                 | No                  |
+----------------------+------------------------------------------------------------+---------------------+
| afterRender          | Triggered after completing the render process              | No                  |
+----------------------+------------------------------------------------------------+---------------------+
| notFoundView         | Triggered when a view was not found                        | No                  |
+----------------------+------------------------------------------------------------+---------------------+

The following example demonstrates how to attach listeners to this component:

.. code-block:: php

    <?php

    $di->set('view', function() {

        //Create an events manager
        $eventsManager = new Phalcon\Events\Manager();

        //Attach a listener for type "view"
        $eventsManager->attach("view", function($event, $view) {
            echo $event->getType(), ' - ', $view->getActiveRenderPath(), PHP_EOL;
        });

        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir("../app/views/");

        //Bind the eventsManager to the view component
        $view->setEventsManager($eventsManager);

        return $view;

    }, true);

The following example shows how to create a plugin that clean/repair the HTML produced by the render process using Tidy_:

.. code-block:: php

    <?php

    class TidyPlugin
    {

        public function afterRender($event, $view)
        {

            $tidyConfig = array(
                'clean' => true,
                'output-xhtml' => true,
                'show-body-only' => true,
                'wrap' => 0,
            );

            $tidy = tidy_parse_string($view->getContent(), $tidyConfig, 'UTF8');
            $tidy->cleanRepair();

            $view->setContent((string) $tidy);
        }

    }

    //Attach the plugin as a listener
    $eventsManager->attach("view:afterRender", new TidyPlugin());

.. _this Github repository: https://github.com/bobthecow/mustache.php
.. _ajax request: http://api.jquery.com/jQuery.ajax/
.. _Tidy: http://www.php.net/manual/en/book.tidy.php
.. _md5: http://php.net/manual/en/function.md5.php
.. _PHP alternative site: https://github.com/phalcon/php-site
