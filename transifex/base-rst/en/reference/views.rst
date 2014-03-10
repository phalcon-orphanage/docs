%{views_7a9935583e6231cd508cd510f32d5668}%
===========
%{views_ef03b15f3a9b49a6b4bb80a813368996}%

%{views_17d77a719ddbd45d2f4bbc7715716450|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`|:doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>`}%

%{views_003b14d6a910d6e7ddfee381215bb477}%
----------------------------------
%{views_dab1c1ef07dda71358c3a6ef720f6bd3}%

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


%{views_1c93242edb5cbc8541a88534f9e9af2b}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction($postId)
        {
            // {%views_9470bcb7969c37437876c883f4ccbf2e%}
            $this->view->setVar("postId", $postId);
        }

    }


%{views_13c164b379d9671d82a101615ab15151}%

%{views_f529f7a38f66822c201c7a2c549408ec}%
----------------------
%{views_2f21f1561bbd4020a45d46f76fefd9aa|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`}%

%{views_177194bd199b8ca419afc6285ed8638b}%

+-------------------+-------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Name              | File                          | Description                                                                                                                                                                                                              |
+===================+===============================+==========================================================================================================================================================================================================================+
| Action View       | app/views/posts/show.phtml    | This is the view related to the action. It only will be shown when the "show" action was executed.                                                                                                                       |
+-------------------+-------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Controller Layout | app/views/layouts/posts.phtml | This is the view related to the controller. It only will be shown for every action executed within the controller "posts". All the code implemented in the layout will be reused for all the actions in this controller. |
+-------------------+-------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Main Layout       | app/views/index.phtml         | This is main action it will be shown for every controller or action executed within the application.                                                                                                                     |
+-------------------+-------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+


%{views_40c229f1a7c8b8128422cb417c95ca94|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`}%

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


%{views_b321993985d76a08d546f9a7901b3c6d|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`}%

.. figure:: ../_static/img/views-1.png
   :align: center



%{views_700f6830c6aa8391f780e3bcb9dae968}%

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


%{views_10b460a3de8edd71111332979572dd63}%
^^^^^^^^^^^^^^^
%{views_702573dde40111cb422cdded5cac3d40}%

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


%{views_898645782f156716701c064f59d9f5d9}%

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


%{views_a4fd48f24a2c518d5b180c6a6d4a79d1}%
^^^^^^^^^^^^^^^^^^^^^^^^
%{views_21a08cde76073183153e0c02dc43cf90|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`}%

%{views_d356d43561f53deaf77231c50250ff8d}%

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

            // {%views_69556848484583057eaea03c03fb80ad%}
            $this->view->setRenderLevel(View::LEVEL_NO_RENDER);

            //...
        }

        public function showAction($postId)
        {
            // {%views_ccd904c46c82c80680ca9c9d083b2c26%}
            $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        }

    }


%{views_0b574a66e81e62ab465902f178ed6a92}%

+-----------------------+--------------------------------------------------------------------------+-------+
| Class Constant        | Description                                                              | Order |
+=======================+==========================================================================+=======+
| LEVEL_NO_RENDER       | Indicates to avoid generating any kind of presentation.                  |       |
+-----------------------+--------------------------------------------------------------------------+-------+
| LEVEL_ACTION_VIEW     | Generates the presentation to the view associated to the action.         | 1     |
+-----------------------+--------------------------------------------------------------------------+-------+
| LEVEL_BEFORE_TEMPLATE | Generates presentation templates prior to the controller layout.         | 2     |
+-----------------------+--------------------------------------------------------------------------+-------+
| LEVEL_LAYOUT          | Generates the presentation to the controller layout.                     | 3     |
+-----------------------+--------------------------------------------------------------------------+-------+
| LEVEL_AFTER_TEMPLATE  | Generates the presentation to the templates after the controller layout. | 4     |
+-----------------------+--------------------------------------------------------------------------+-------+
| LEVEL_MAIN_LAYOUT     | Generates the presentation to the main layout. File views/index.phtml    | 5     |
+-----------------------+--------------------------------------------------------------------------+-------+


%{views_9ff639be8370b38960cba777a5babc2e}%
^^^^^^^^^^^^^^^^^^^^^^^
%{views_31dd34b13e62e822e96a8dc3d89402f7}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;

    $di->set('view', function(){

        $view = new View();

        //{%views_8a19e228d9648c03f52e155849ccb474%}
        $view->disableLevel(array(
            View::LEVEL_LAYOUT => true,
            View::LEVEL_MAIN_LAYOUT => true
        ));

        return $view;

    }, true);


%{views_c857045014ddf4562dba50c87b7c7389}%

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


%{views_086c3b4119cecbc37ccd78bb3629dd47}%
^^^^^^^^^^^^^
%{views_c6e2d02b8e6136be2851ff89c37f992a|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`|:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`}%

.. code-block:: php

    <?php

    class ProductsController extends \Phalcon\Mvc\Controller
    {

        public function listAction()
        {
            // {%views_6be201e49f95681b28b4b8caebe8039d%}
            $this->view->pick("products/search");

            // {%views_3027740efabd889a595106ce8345eb46%}
            $this->view->pick(array('products'));

            // {%views_3027740efabd889a595106ce8345eb46%}
            $this->view->pick(array(1 => 'search'));
        }

    }


%{views_0efce5c37e4d187ce85e1c900ab2b4ab}%
^^^^^^^^^^^^^^^^^^
%{views_29f0d82a073cc35519b6e8961d07c490}%

.. code-block:: php

    <?php

    class UsersController extends \Phalcon\Mvc\Controller
    {

        public function closeSessionAction()
        {
            //{%views_71390553b9d22d273547f8c8bd331230%}
            //...

            //{%views_ba4993bcf124a622dbc56d4ec4e985c1%}
            $this->response->redirect('index/index');

            //{%views_5cd03e89f27efcddc38775afcc436058%}
            $this->view->disable();
        }

    }


%{views_3cb08bf1a7d4bac0f47363c79fa3be2c}%

.. code-block:: php

    <?php

    class UsersController extends \Phalcon\Mvc\Controller
    {

        public function closeSessionAction()
        {
            //{%views_71390553b9d22d273547f8c8bd331230%}
            //...

            //{%views_ba4993bcf124a622dbc56d4ec4e985c1%}
            return $this->response->redirect('index/index');
        }

    }


%{views_e3a9349e409d158182f3e861c8e8e012}%
----------------
%{views_f35015ff07641703b167a1739b147a02|:doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>`|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`}%

%{views_c914389eac07b146045365bfe9b43ae6|:doc:`Volt <volt>`}%

%{views_abf8ed7d7ae41822d01a13c9c81be2da}%

.. code-block:: php

    <?php

    $di->set('view', function() {

        $view = new Phalcon\Mvc\View\Simple();

        $view->setViewsDir('../app/views/');

        return $view;

    }, true);


%{views_ebd95f0288cd6070a75a3a30a7dec279|:doc:`Phalcon\\Mvc\\Application <applications>`}%

.. code-block:: php

    <?php

    try {

        $application = new Phalcon\Mvc\Application($di);

        $application->useImplicitView(false);

        echo $application->handle()->getContent();

    } catch (\Exception $e) {
        echo $e->getMessage();
    }


%{views_398368acf874ef364deacc01fa8ed4e3}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            //{%views_5c4407c96cb0f2eecce688cab8d1ca03%}
            echo $this->view->render('index');

            //{%views_0f7b4bbca2c93378a1aa7cf98e9b2cf7%}
            echo $this->view->render('posts/show');

            //{%views_79265c8524e7b5114cd5e687af08b4d0%}
            echo $this->view->render('index', array('posts' => Posts::find()));

            //{%views_89c608e63ddbc3945c96da96dc91d96b%}
            echo $this->view->render('posts/show', array('posts' => Posts::find()));
        }

    }


%{views_83809746bd6d1d7960195e86f68c8da8}%
--------------
%{views_75f86de4abb898efbb5e31d807256244}%

%{views_f71fd72a447e6a2ffb2643169ff2ecfb}%

.. code-block:: html+php

    <div class="top"><?php $this->partial("shared/ad_banner") ?></div>

    <div class="content">
        <h1>Robots</h1>

        <p>Check out our specials for robots:</p>
        ...
    </div>

    <div class="footer"><?php $this->partial("shared/footer") ?></div>


%{views_67c57e6e7f34e628e2f23b32b066d174}%

.. code-block:: html+php

    <?php $this->partial("shared/ad_banner", array('id' => $site->id, 'size' => 'big')) ?>


%{views_fbe970c3f88ead32c74db6ae1f24455c}%
--------------------------------------------
%{views_11f4881c15938974d44b6e7514313340|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction()
        {
            //{%views_65b786df8771cf9936638d9359806813%}
            $this->view->setVar("posts", Posts::find());

            //{%views_d00977d07ccc6a00491968a1b998ed50%}
            $this->view->posts = Posts::find();

            //{%views_ba577bfcc4105ad93b10817126a7fce8%}
            $this->view->setVars(array(
                'title' => $post->title,
                'content' => $post->content
            ));
        }

    }


%{views_5b0db7a17988863f0629d6ef359a5120}%

.. code-block:: html+php

    <div class="post">
    <?php

      foreach ($posts as $post) {
        echo "<h1>", $post->title, "</h1>";
      }

    ?>
    </div>


%{views_9b5dfc6e03f2e4c7ce50d991756ca24f}%
------------------------------
%{views_712a47a1ca2d73af8f82fe973cc57808|:doc:`Phalcon\\Loader <../api/Phalcon_Loader>`}%

.. code-block:: html+php

    <div class="categories">
    <?php

        foreach (Categories::find("status = 1") as $category) {
           echo "<span class='category'>", $category->name, "</span>";
        }

    ?>
    </div>


%{views_32d287c9930a183a4f900372280abba6}%

%{views_e2809b8367f23b279052a0c57a34b5ac}%
----------------------
%{views_b2c5981e85b422752e6f5a8234e49b37|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`}%

%{views_a18793af605d23cb8e61ce44de8f6524|:doc:`Phalcon\\\Mvc\\View <../api/Phalcon_Mvc_View>`|:doc:`Phalcon\\Cache <cache>`}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function showAction()
        {
            //{%views_9aae4a6bf5e94dfa08a45a805e449b34%}
            $this->view->cache(true);
        }

        public function showArticleAction()
        {
            // {%views_3f06ec587eeeb185b749837fa4e46e18%}
            $this->view->cache(array(
                "lifetime" => 3600
            ));
        }

        public function resumeAction()
        {
            //{%views_78ca43a465c9e94695d57562ffb8c505%}
            $this->view->cache(
                array(
                    "lifetime" => 86400,
                    "key"      => "resume-cache",
                )
            );
        }

        public function downloadAction()
        {
            //{%views_38213376f90ef4d88c04f2ac0c0edc5f%}
            $this->view->cache(
                array(
                    "service"  => "myCache",
                    "lifetime" => 86400,
                    "key"      => "resume-cache",
                )
            );
        }

    }


%{views_f090ddab8a4c1433924b1b348ef399d1}%

%{views_f888bb1a09ced9103b2fa1bf171f4eeb}%

.. code-block:: php

    <?php

    use Phalcon\Cache\Frontend\Output as OutputFrontend,
        Phalcon\Cache\Backend\Memcache as MemcacheBackend;

    //{%views_fa2501fd9d459e571d983c8ef7bb5457%}
    $di->set('viewCache', function() {

        //{%views_83b746e3e149c65f5d387ee018ce18e1%}
        $frontCache = new OutputFrontend(array(
            "lifetime" => 86400
        ));

        //{%views_27c9c860a0e993fc9cd8fe1f98c2dd13%}
        $cache = new MemcacheBackend($frontCache, array(
            "host" => "localhost",
            "port" => "11211"
        ));

        return $cache;
    });

.. highlights::
    The frontend must always be Phalcon\\Cache\\Frontend\\Output and the service 'viewCache' must be registered as
    always open (not shared) in the services container (DI)


%{views_5594ea8d99fb14da5c5c94f61150a4f0}%

%{views_789fb11f699927f5cbb50cddddfc9227}%

.. code-block:: html+php

    <?php

    class DownloadController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

            //{%views_f4122bc44873ef6d1c814a89bb4e7875%}
            if ($this->view->getCache()->exists('downloads')) {

                //{%views_01427910082957d63f852a031133d0e4%}
                $latest = Downloads::find(array(
                    'order' => 'created_at DESC'
                ));

                $this->view->latest = $latest;
            }

            //{%views_f800c653d3ea4100de3ff811ebeea38e%}
            $this->view->cache(array(
                'key' => 'downloads'
            ));
        }

    }


%{views_9d7f5c5fad64a539b7d9e2f14b189916|`PHP alternative site`_}%

%{views_6e5a69a8dd70f8d2cd5e2ae15b313263}%
----------------
%{views_8436fbc2a35e8ace44ce7683ffff75cb|:doc:`Volt <volt>`}%

%{views_4889731af0682a0ff001941c53287b7f|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`}%

%{views_d30b9918e0dd94497b8f8e10fa02a03e}%

%{views_033f4b37a8ab437c02d21fb2b200c4d9|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`}%

%{views_36a82d83487a4e3f40f2064c8ea7324f}%

%{views_39112bd6a8127139d0a52a91360e0188}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{views_51eeef9ead467502cae8fc7f197f246a}%

%{views_06f80f0eb563b269df8884b213cd7994|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`}%

%{views_3e008dba1ca8514936e032d7fada3007}%

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
            //{%views_553f0c688023f26caf45bf60b1e83a13%}
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

            // {%views_4170a1870bc2b6a842ac64d63e928050%}
            $view = $this->_view;

            // {%views_4d5b9ed94de45affdd2318cf390fed58%}
            $options = $this->_options;

            //{%views_3ab78eb524cbb6e088e6865f6b3e2729%}
            //...
        }

    }


%{views_cfdbf34effaf9927896f7e8da605aba4}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{views_1979a43a78910f5cc07142f4eed9a1bd}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            // {%views_9b9d2cb5832b0ac2b118526529c296a7%}
            $this->view->registerEngines(
                array(
                    ".my-html" => "MyTemplateAdapter"
                )
            );
        }

        public function showAction()
        {
            // {%views_a70af6f6b3d19f6e1544ec417a5394bf%}
            $this->view->registerEngines(
                array(
                    ".my-html" => 'MyTemplateAdapter',
                    ".phtml" => 'Phalcon\Mvc\View\Engine\Php'
                )
            );
        }

    }


%{views_474201dbdde6d46b8d104b4ed325697e}%

%{views_0cc44f316c50b5aed136241cb094037e|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`}%

%{views_eed56c16c3fd884a52e645a2764469d8}%

.. code-block:: php

    <?php

    //{%views_c9c2415fac9c89e078730c5f75953e9b%}
    $di->set('view', function() {

        $view = new \Phalcon\Mvc\View();

        //{%views_dc195d80c7c8b4f181529b79237443e5%}
        $view->setViewsDir('../app/views/');

        $view->registerEngines(array(
            ".my-html" => 'MyTemplateAdapter'
        ));

        return $view;

    }, true);


%{views_7649f99d9c471d16ff7db8f1c71fd7c0|`Phalcon Incubator <https://github.com/phalcon/incubator/tree/master/Library/Phalcon/Mvc/View/Engine>`_}%

%{views_c7ee7944a5606c39612539a861cac009}%
--------------------------
%{views_2ec521a259f67d7ede50c9df2312ec77|:doc:`Phalcon\\DI\\Injectable <../api/Phalcon_DI_Injectable>`}%

%{views_d0a80f72e3b2fa16960b55573362eb7d|`ajax request`_}%

.. code-block:: html+php

    <script type="text/javascript">

    $.ajax({
        url: "<?php echo $this->url->get("cities/get") ?>"
    })
    .done(function() {
        alert("Done!");
    });

    </script>


%{views_d3e54f7c04408d6d1a884897bca4169e}%
---------------------
%{views_3d46da924d710a41a1e398ffcde2234c}%

%{views_f529f7a38f66822c201c7a2c549408ec}%
^^^^^^^^^^^^^^^^^^^^^^
%{views_55c38e733242b57b98320ed2e01d60ed|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`}%

.. code-block:: php

    <?php

    $view = new \Phalcon\Mvc\View();

    //{%views_dc195d80c7c8b4f181529b79237443e5%}
    $view->setViewsDir("../app/views/");

    // {%views_486255d3cb9e7c09557cb1337a0b2d33%}
    $view->setVar("someProducts", $products);
    $view->setVar("someFeatureEnabled", true);

    //{%views_59ce96966e8ea7b3f1e65bfb4395322a%}
    $view->start();

    //{%views_171c6f9e1616223878805d804ea397f3%}
    $view->render("products", "list");

    //{%views_84a791cb36fb4c7899a1a066d193b292%}
    $view->finish();

    echo $view->getContent();


%{views_f13eba0f4918c9a0bca147e70fe0279c}%

.. code-block:: php

    <?php

    $view = new \Phalcon\Mvc\View();

    echo $view->getRender('products', 'list',
        array(
            "someProducts" => $products,
            "someFeatureEnabled" => true
        ),
        function($view) {
            //{%views_c1ca4e716d9a88ebcca8f7db7cdd0933%}
            $view->setViewsDir("../app/views/");
            $view->setRenderLevel(Phalcon\Mvc\View::LEVEL_LAYOUT);
        }
    );


%{views_e3a9349e409d158182f3e861c8e8e012}%
^^^^^^^^^^^^^^^^
%{views_34a10d520dd11d9adf54cd9c921f0964|:doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>`}%

.. code-block:: php

    <?php

    $view = new \Phalcon\Mvc\View\Simple();

    //{%views_dc195d80c7c8b4f181529b79237443e5%}
    $view->setViewsDir("../app/views/");

    // {%views_e46d27df223d959f57061b90fcdefdca%}
    echo $view->render("templates/welcomeMail");

    // {%views_d4ed850f254501a2e7c4eacdb100f76d%}
    echo $view->render("templates/welcomeMail", array(
        'email' => $email,
        'content' => $content
    ));


%{views_296b9f4f4f7b51885c71b3592af71235}%
-----------
%{views_c6a4ae6de7ed5a14215f3044e885e5dd|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`|:doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View_Simple>`|:doc:`EventsManager <events>`}%

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


%{views_4eb434eb37be7b4a57c178fa4af88c76}%

.. code-block:: php

    <?php

    $di->set('view', function() {

        //{%views_1d55db2b24319ae2941d54d5b8d5d4a5%}
        $eventsManager = new Phalcon\Events\Manager();

        //{%views_188200bd4a772c505a84a79b119226ca%}
        $eventsManager->attach("view", function($event, $view) {
            echo $event->getType(), ' - ', $view->getActiveRenderPath(), PHP_EOL;
        });

        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir("../app/views/");

        //{%views_bda634f6269a3a06dd0a40fb4d7ae993%}
        $view->setEventsManager($eventsManager);

        return $view;

    }, true);


%{views_1ca1a71f4f5f276064f24f98f4bbcd2e}%

