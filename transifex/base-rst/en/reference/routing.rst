%{routing_476a8980062af9e778f675c1bc4f73ef}%
=======
%{routing_80737ee348be4a387eda622d15b10c75}%

%{routing_a8a25f2aac05af019b129455c8d4e2eb}%
---------------
%{routing_9dcf17896733a4c6184918c1fe10972e|:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>`}%

.. code-block:: php

    <?php

    // {%routing_e438afb7b123fb30fd783c39fe3c0d64%}
    $router = new \Phalcon\Mvc\Router();

    //{%routing_36675dba0f45d3bd219c6fb8053e6597%}
    $router->add(
        "/admin/users/my-profile",
        array(
            "controller" => "users",
            "action"     => "profile",
        )
    );

    //{%routing_f538757510169716dd05ec2568e198ce%}
    $router->add(
        "/admin/users/change-password",
        array(
            "controller" => "users",
            "action"     => "changePassword",
        )
    );

    $router->handle();


%{routing_af70bfef086f9becd40e8868981bfbc4|:doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`}%

%{routing_e337359c3e1a34b84cd25564e88c6b8f}%

.. code-block:: php

    <?php

    // {%routing_e438afb7b123fb30fd783c39fe3c0d64%}
    $router = new \Phalcon\Mvc\Router();

    //{%routing_36675dba0f45d3bd219c6fb8053e6597%}
    $router->add(
        "/admin/:controller/a/:action/:params",
        array(
            "controller" => 1,
            "action"     => 2,
            "params"     => 3,
        )
    );


%{routing_8cd210a54ff282e87a6ed0f7f1494972}%

+------------+---------------+
| Controller | users         |
+------------+---------------+
| Action     | delete        |
+------------+---------------+
| Parameter  | dave          |
+------------+---------------+
| Parameter  | 301           |
+------------+---------------+


%{routing_0208788d55bbb89d8d903679f676ad94|`PCRE regular expressions`_}%

%{routing_bd30a2c3f46b46c876a14459bb37cb3f}%

%{routing_9eca21e6ab3780f7e55f26df9d3bb9f9}%

+--------------+---------------------+--------------------------------------------------------------------------------------------------------+
| Placeholder  | Regular Expression  | Usage                                                                                                  |
+==============+=====================+========================================================================================================+
| /:module     | /([a-zA-Z0-9\_\-]+) | Matches a valid module name with alpha-numeric characters only                                         |
+--------------+---------------------+--------------------------------------------------------------------------------------------------------+
| /:controller | /([a-zA-Z0-9\_\-]+) | Matches a valid controller name with alpha-numeric characters only                                     |
+--------------+---------------------+--------------------------------------------------------------------------------------------------------+
| /:action     | /([a-zA-Z0-9\_]+)   | Matches a valid action name with alpha-numeric characters only                                         |
+--------------+---------------------+--------------------------------------------------------------------------------------------------------+
| /:params     | (/.*)*              | Matches a list of optional words separated by slashes. Use only this placeholder at the end of a route |
+--------------+---------------------+--------------------------------------------------------------------------------------------------------+
| /:namespace  | /([a-zA-Z0-9\_\-]+) | Matches a single level namespace name                                                                  |
+--------------+---------------------+--------------------------------------------------------------------------------------------------------+
| /:int        | /([0-9]+)           | Matches an integer parameter                                                                           |
+--------------+---------------------+--------------------------------------------------------------------------------------------------------+


%{routing_7eb946b0fa36e208b3b987f9503af17e|some_}%

%{routing_463cf83ff1da5fa1aead4c5adc6d8870|:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>`}%

%{routing_3540d24c854e30bda17e43acc7db78b9}%
^^^^^^^^^^^^^^^^^^^^^
%{routing_acae6bad7acef0f5d14865c3b631c44e}%

.. code-block:: php

    <?php

    $router->add(
        "/news/([0-9]{4})/([0-9]{2})/([0-9]{2})/:params",
        array(
            "controller" => "posts",
            "action"     => "show",
            "year"       => 1, // {%routing_f5cd639e60abaf5c70770f2193039edd%}
            "month"      => 2, // {%routing_e7d05a2cd2e98588676c451035df748b%}
            "day"        => 3, // {%routing_e7d05a2cd2e98588676c451035df748b%}
            "params"     => 4, // {%routing_c8faf368354ddcf09a540ed33a5078be%}
        )
    );


%{routing_5d916475254ea486a884d1f6046ae413}%

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction()
        {

            // {%routing_988f54d638ea3c28b4dcd672d992a39e%}
            $year = $this->dispatcher->getParam("year");

            // {%routing_7bc6d7d26fb4625b3c367d05cbecb6f3%}
            $month = $this->dispatcher->getParam("month");

            // {%routing_19dc82172aefe683b521b7932ce43432%}
            $day = $this->dispatcher->getParam("day");

        }

    }


%{routing_3b64696f43025f9debdd28b92dcc3d55}%

.. code-block:: php

    <?php

    $router->add(
        "/documentation/{chapter}/{name}.{type:[a-z]+}",
        array(
            "controller" => "documentation",
            "action"     => "show"
        )
    );


%{routing_478aded91934b807494433f5e157b553}%

.. code-block:: php

    <?php

    class DocumentationController extends \Phalcon\Mvc\Controller
    {

        public function showAction()
        {

            // {%routing_996e65daa812df4b6a59f6ca18e6d5e5%}
            $name = $this->dispatcher->getParam("name");

            // {%routing_e1c87a801511011720872a707a895b74%}
            $type = $this->dispatcher->getParam("type");

        }

    }


%{routing_40d3496dd82862acf7fa645cf5843ca9}%
^^^^^^^^^^^^
%{routing_21979d3e12775abb02b191341aff60c1}%

.. code-block:: php

    <?php

    // {%routing_5808d93b5a62a02626e69461545b42c9%}
    $router->add("/posts/{year:[0-9]+}/{title:[a-z\-]+}", "Posts::show");

    // {%routing_ac5a335ee540c64c78ddf133ca4e11f4%}
    $router->add(
        "/posts/([0-9]+)/([a-z\-]+)",
        array(
           "controller" => "posts",
           "action"     => "show",
           "year"       => 1,
           "title"      => 2,
        )
    );


%{routing_f3080b2f6ccf5d03da8f1da2560e2d1a}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{routing_ad3d45d5acd8299cd58843284585bf79}%

.. code-block:: php

    <?php

    //{%routing_afbe3625aff91a4008df9b8e148191ee%}
    //{%routing_0199201654ca4047c6811d3ae92f2f4c%}
    $router->add('/news/{country:[a-z]{2}}/([a-z+])/([a-z\-+])',
        array(
            'section' => 2, //{%routing_e072558226ceb8372cf5c7434ae277d6%}
            'article' => 3
        )
    );


%{routing_ab5679a42afac0c7b0181219d03ba29b}%
^^^^^^^^^^^^^^^^^^
%{routing_9add85d11b871eaff3e948f9c4c4b82d}%

.. code-block:: php

    <?php

    $router = new Phalcon\Mvc\Router(false);

    $router->add('/:module/:controller/:action/:params', array(
        'module' => 1,
        'controller' => 2,
        'action' => 3,
        'params' => 4
    ));


%{routing_7a02084b284a14555e834818e8512471}%

+------------+---------------+
| Module     | admin         |
+------------+---------------+
| Controller | users         |
+------------+---------------+
| Action     | edit          |
+------------+---------------+
| Parameter  | sonny         |
+------------+---------------+


%{routing_b75389cde16eadf81bfc0a68ff6150b9}%

.. code-block:: php

    <?php

    $router->add("/login", array(
        'module' => 'backend',
        'controller' => 'login',
        'action' => 'index',
    ));

    $router->add("/products/:action", array(
        'module' => 'frontend',
        'controller' => 'products',
        'action' => 1,
    ));


%{routing_6a0fab83164f4079d3ab6ddd5b16264d}%

.. code-block:: php

    <?php

    $router->add("/:namespace/login", array(
        'namespace' => 1,
        'controller' => 'login',
        'action' => 'index'
    ));


%{routing_a9e57af3ec6ccf5159eeaa8524c3259b}%

.. code-block:: php

    <?php

    $router->add("/login", array(
        'namespace' => 'Backend\Controllers',
        'controller' => 'login',
        'action' => 'index'
    ));


%{routing_453efd9a5cf676ae2ae88a43c16a616b}%
^^^^^^^^^^^^^^^^^^^^^^^^
%{routing_1477452518ac56e7c127ba9b933bf10e}%

.. code-block:: php

    <?php

    // {%routing_7272c11d5377d57012f4df49534d1ead%}
    $router->addGet("/products/edit/{id}", "Products::edit");

    // {%routing_2f6bc0fd4cacf07a48d67d8311c9dd5c%}
    $router->addPost("/products/save", "Products::save");

    // {%routing_c2eafcef2064372c43e67d99455710c0%}
    $router->add("/products/update")->via(array("POST", "PUT"));


%{routing_cf90cec6f911c38eece8ebb5aa3b4b23}%
^^^^^^^^^^^^^^^^^
%{routing_8f5321b91956f88f2b4d583c0f1e846b}%

.. code-block:: php

    <?php

    //{%routing_04d68506c522a4896657a897a9cba94c%}
    $router
        ->add('/products/{slug:[a-z\-]+}', array(
            'controller' => 'products',
            'action' => 'show'
        ))
        ->convert('slug', function($slug) {
            //{%routing_085f85bc9842588f9ab10a2733d9fd68%}
            return str_replace('-', '', $slug);
        });


%{routing_89645649e65162817ae5591359c8a198}%
^^^^^^^^^^^^^^^^
%{routing_9ed218f28edb65d2e1ce51f6ce34c1ec}%

.. code-block:: php

    <?php

    $router = new \Phalcon\Mvc\Router();

    //{%routing_d3dbf364456e79dff31c012172d8aa25%}
    $blog = new \Phalcon\Mvc\Router\Group(array(
        'module' => 'blog',
        'controller' => 'index'
    ));

    //{%routing_43735061c13b24a7f591a1c8b8137f0e%}
    $blog->setPrefix('/blog');

    //{%routing_5a86a91ac4dd449f3cc00d7b3f775ec4%}
    $blog->add('/save', array(
        'action' => 'save'
    ));

    //{%routing_7aa3c893d6c37ebe73797b11b3af0e1d%}
    $blog->add('/edit/{id}', array(
        'action' => 'edit'
    ));

    //{%routing_82fc3962e12dabb102c57c8fab55dc3f%}
    $blog->add('/blog', array(
        'controller' => 'blog',
        'action' => 'index'
    ));

    //{%routing_cf0d7a079879f96295a227eb381c89f0%}
    $router->mount($blog);


%{routing_d18d7dd959e51180c33e8fe7efd1adbe}%

.. code-block:: php

    <?php

    class BlogRoutes extends Phalcon\Mvc\Router\Group
    {
        public function initialize()
        {
            //{%routing_5431d95786f0749df40cb772cb0a299f%}
            $this->setPaths(array(
                'module' => 'blog',
                'namespace' => 'Blog\Controllers'
            ));

            //{%routing_43735061c13b24a7f591a1c8b8137f0e%}
            $this->setPrefix('/blog');

            //{%routing_5a86a91ac4dd449f3cc00d7b3f775ec4%}
            $this->add('/save', array(
                'action' => 'save'
            ));

            //{%routing_7aa3c893d6c37ebe73797b11b3af0e1d%}
            $this->add('/edit/{id}', array(
                'action' => 'edit'
            ));

            //{%routing_82fc3962e12dabb102c57c8fab55dc3f%}
            $this->add('/blog', array(
                'controller' => 'blog',
                'action' => 'index'
            ));

        }
    }


%{routing_b1851b1c2fa5c5307d595bfaaff976ac}%

.. code-block:: php

    <?php

    //{%routing_cf0d7a079879f96295a227eb381c89f0%}
    $router->mount(new BlogRoutes());


%{routing_87641826c33ca36481c575395f04a269}%
---------------
%{routing_c9305535339c97f0535de63c1c82b540}%

.. code-block:: apacheconf

    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^(.*)$ index.php?_url=/$1 [QSA,L]


%{routing_57b493be47ed19be107d98ad207df3e6}%

.. code-block:: php

    <?php

    // {%routing_5b470d05b5291e2e87fb259d20aecc64%}
    $router = new \Phalcon\Mvc\Router();

    // {%routing_54a213830db9190215d220cee8eabbc8%}
    // ...

    // {%routing_d9ec1142c3f874114cbdca3f614f5e2b%}
    $router->handle();

    // {%routing_d4e886c0e6bef2a13fd1e4c362ec0492%}
    $router->handle("/employees/edit/17");

    // {%routing_d35b79aa0c8abf254abb62fc4c778f1d%}
    echo $router->getControllerName();

    // {%routing_7573649970696f9e238184c76d5505b6%}
    echo $router->getActionName();

    //{%routing_407e0df96b74082fe285eb53fafb7028%}
    $route = $router->getMatchedRoute();


%{routing_7ff55897ca1eac97569667483eccf29c}%
-------------
%{routing_87997b24529888023044e0ac18a908b6|:doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>`}%

.. code-block:: php

    <?php

    $route = $router->add("/posts/{year}/{title}", "Posts::show");

    $route->setName("show-posts");

    //{%routing_db357fb8b3bf605ae3443a085fd2ae31%}

    $router->add("/posts/{year}/{title}", "Posts::show")->setName("show-posts");


%{routing_99826062e7ee46bb65b29bd1bdc47f6c|:doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>`}%

.. code-block:: php

    <?php

    // {%routing_4374667393d71c92776bc6ca2ba8a756%}
    echo $url->get(array(
        "for" => "show-posts",
        "year" => "2012",
        "title" => "phalcon-1-0-released"
    ));


%{routing_33df0f1f046d5ea7d528ae7e04b5b00f}%
--------------
%{routing_7d3cc177511a959a88a38ebc77f371bc}%

.. code-block:: php

    <?php

    // {%routing_c2cc5818f72720cf5db29c705f87230e%}
    $router->add(
        "/system/:controller/a/:action/:params",
        array(
            "controller" => 1,
            "action"     => 2,
            "params"     => 3
        )
    );

    // {%routing_3bc55ac109f7512abc97d69edfb95c44%}
    $router->add(
        "/([a-z]{2})/:controller",
        array(
            "controller" => 2,
            "action"     => "index",
            "language"   => 1
        )
    );

    // {%routing_3bc55ac109f7512abc97d69edfb95c44%}
    $router->add(
        "/{language:[a-z]{2}}/:controller",
        array(
            "controller" => 2,
            "action"     => "index"
        )
    );

    // {%routing_8adc7a12513b80e1ef71a38992a26d81%}
    $router->add(
        "/admin/:controller/:action/:int",
        array(
            "controller" => 1,
            "action"     => 2,
            "id"         => 3
        )
    );

    // {%routing_57cffdf1c525d359d4056155dbd687df%}
    $router->add(
        "/posts/([0-9]{4})/([0-9]{2})/([a-z\-]+)",
        array(
            "controller" => "posts",
            "action"     => "show",
            "year"       => 1,
            "month"      => 2,
            "title"      => 4
        )
    );

    // {%routing_bc95ef7ead0f90292bb09f73c0e2aa7e%}
    $router->add(
        "/manual/([a-z]{2})/([a-z\.]+)\.html",
        array(
            "controller" => "manual",
            "action"     => "show",
            "language"   => 1,
            "file"       => 2
        )
    );

    // {%routing_5ae86815d99a6284b10996cf6a15afae%}
    $router->add(
        "/feed/{lang:[a-z]+}/{blog:[a-z\-]+}\.{type:[a-z\-]+}",
        "Feed::get"
    );

    // {%routing_a74af9f2887a549af527cf5c6816171e%}
    $router->add('/api/(v1|v2)/{method:[a-z]+}/{param:[a-z]+}\.(json|xml)',
        array(
            'controller' => 'api',
            'version' => 1,
            'format' => 4
        )
    );

.. highlights::
    Beware of characters allowed in regular expression for controllers and namespaces. As these
    become class names and in turn they're passed through the file system could be used by attackers to
    read unauthorized files. A safe regular expression is: /([a-zA-Z0-9\_\-]+)


%{routing_455c64f03d8a2db20778f630271ab7eb}%
----------------
%{routing_12b50c61cc98da6d971a5884a6f36ea2|:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>`}%

%{routing_d6b9352467b77e061070a12d9d8b2d6c}%

+------------+---------------+
| Controller | documentation |
+------------+---------------+
| Action     | show          |
+------------+---------------+
| Parameter  | about.html    |
+------------+---------------+


%{routing_64e1f6d7e8bd1348c4afc274d26d571a}%

.. code-block:: php

    <?php

    // {%routing_8c0d2307d542718a5f44f362bc75a0e6%}
    $router = new \Phalcon\Mvc\Router(false);


%{routing_5aef7c16fc00974efa801f11d5ab1674}%
-------------------------
%{routing_f263d36de6652a9b4a6d419ea3dc8359}%

.. code-block:: php

    <?php

    $router->add("/", array(
        'controller' => 'index',
        'action' => 'index'
    ));


%{routing_b09e95ff2020febabcc69da62f468438}%
---------------
%{routing_b1656daeb0be1c3b453eed446ec80368}%

.. code-block:: php

    <?php

    //{%routing_0afb82ff58fddb0c28885460b76288dc%}
    $router->notFound(array(
        "controller" => "index",
        "action" => "route404"
    ));


%{routing_33a1d5e7ebac5b03e011b0a0f5ef8c27}%
---------------------
%{routing_4e85ee960ebc91e99e100ebc61abfceb}%

.. code-block:: php

    <?php

    //{%routing_f1a2dc7a4a6a3a08ece6672cae6bbd56%}
    $router->setDefaultModule('backend');
    $router->setDefaultNamespace('Backend\Controllers');
    $router->setDefaultController('index');
    $router->setDefaultAction('index');

    //{%routing_b95bdc68566652e92902b5a4d919035c%}
    $router->setDefaults(array(
        'controller' => 'index',
        'action' => 'index'
    ));


%{routing_45a6a55a7d1f271400e66f477bc919c8}%
-----------------------------------
%{routing_84eb8a6b4c6bfbdc6313b9fae680e929}%

.. code-block:: php

    <?php

    $router = new \Phalcon\Mvc\Router();

    //{%routing_4c419e391a1a280d8cdef97f61e105d8%}
    $router->removeExtraSlashes(true);


%{routing_cb88012b458e6b55753d6ab71de09ed4}%

.. code-block:: php

    <?php

    $router->add(
        '/{language:[a-z]{2}}/:controller[/]{0,1}',
        array(
            'controller' => 2,
            'action'     => 'index'
        )
    );


%{routing_2617728469525c66288abb69d182cb15}%
---------------
%{routing_eeec2b22d72619afda05414dbc3c90ff}%

.. code-block:: php

    <?php

    $router->add('/login', array(
        'module' => 'admin',
        'controller' => 'session'
    ))->beforeMatch(function($uri, $route) {
        //{%routing_807bbe76d40d1fa78e437c5c686c7eca%}
        if ($_SERVER['X_REQUESTED_WITH'] == 'xmlhttprequest') {
            return false;
        }
        return true;
    });


%{routing_e2baf3be5f2a60d1ec516e51de94661d}%

.. code-block:: php

    <?php

    class AjaxFilter
    {
        public function check()
        {
            return $_SERVER['X_REQUESTED_WITH'] == 'xmlhttprequest';
        }
    }


%{routing_dbdc46e51cbe0f58cb90ef9001dab2a7}%

.. code-block:: php

    <?php

    $router->add('/get/info/{id}', array(
        'controller' => 'products',
        'action' => 'info'
    ))->beforeMatch(array(new AjaxFilter(), 'check'));


%{routing_700fdbb69619d592622aa670b3e4aaa2}%
--------------------
%{routing_f5bb43969cf1dfaf2ed5786dcfbcb3b1}%

.. code-block:: php

    <?php

    $router->add('/login', array(
        'module' => 'admin',
        'controller' => 'session',
        'action' => 'login'
    ))->setHostName('admin.company.com');


%{routing_3b6265dc31b17ad6d85aa03a282ad603}%

.. code-block:: php

    <?php

    $router->add('/login', array(
        'module' => 'admin',
        'controller' => 'session',
        'action' => 'login'
    ))->setHostName('([a-z+]).company.com');


%{routing_358162dafe136cd0f52ead45bf46f6fa}%

.. code-block:: php

    <?php

    //{%routing_d3dbf364456e79dff31c012172d8aa25%}
    $blog = new \Phalcon\Mvc\Router\Group(array(
        'module' => 'blog',
        'controller' => 'posts'
    ));

    //{%routing_765ae5df8f323f1106da26fef964c21d%}
    $blog->setHostName('blog.mycompany.com');

    //{%routing_43735061c13b24a7f591a1c8b8137f0e%}
    $blog->setPrefix('/blog');

    //{%routing_1e80b472e30224022737c22cc9d6532a%}
    $blog->add('/', array(
        'action' => 'index'
    ));

    //{%routing_5a86a91ac4dd449f3cc00d7b3f775ec4%}
    $blog->add('/save', array(
        'action' => 'save'
    ));

    //{%routing_7aa3c893d6c37ebe73797b11b3af0e1d%}
    $blog->add('/edit/{id}', array(
        'action' => 'edit'
    ));

    //{%routing_cf0d7a079879f96295a227eb381c89f0%}
    $router->mount($blog);


%{routing_d95c9cb668c864c98ce0f13b7cfbb094}%
-----------
%{routing_fe0a2ee2c90f9752b2a978bfd4b55d83|REQUEST_}%

.. code-block:: php

    <?php

    $router->setUriSource(Router::URI_SOURCE_GET_URL); // {%routing_18c5a9d018efa117de87ba83036d7d8f%}
    $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI); // {%routing_c464d18bc721cb189482c8a99bec39b0%}


%{routing_af97ddd2a6081ddf9a013328616ad06e}%

.. code-block:: php

    <?php

    $router->handle('/some/route/to/handle');


%{routing_4336bee9ffb2243f3e531eee35935fc2}%
-------------------
%{routing_b8b538e16c15ca88ca07203a60c075e5}%

.. code-block:: php

    <?php

    //{%routing_59e8834cf2165c2b6e5f2f1b520ed01c%}
    $testRoutes = array(
        '/',
        '/index',
        '/index/index',
        '/index/test',
        '/products',
        '/products/index/',
        '/products/show/101',
    );

    $router = new Phalcon\Mvc\Router();

    //{%routing_bca1dc0f79cc18ea5d3dfed1135a3cff%}
    //...

    //{%routing_209f4427a0e381c51b1d73f897704d79%}
    foreach ($testRoutes as $testRoute) {

        //{%routing_bc7914700c0a9e19a85b9b37f683a9c7%}
        $router->handle($testRoute);

        echo 'Testing ', $testRoute, '<br>';

        //{%routing_14ffb2211d7c0485944a73776865eca6%}
        if ($router->wasMatched()) {
            echo 'Controller: ', $router->getControllerName(), '<br>';
            echo 'Action: ', $router->getActionName(), '<br>';
        } else {
            echo 'The route wasn\'t matched by any route<br>';
        }
        echo '<br>';

    }


%{routing_3b78bfeabfbeef7d8e6fdb177e468dbe}%
------------------
%{routing_9efa5035be571cb114e90dfd1d23d7ca|:doc:`annotations <annotations>`}%

.. code-block:: php

    <?php

    $di['router'] = function() {

        //{%routing_b9d666c79f94f3cfada1ecd17e50f52d%}
        $router = new \Phalcon\Mvc\Router\Annotations(false);

        //{%routing_42ad74eedd24d64a34e68882a101f024%}
        $router->addResource('Products', '/api/products');

        return $router;
    };


%{routing_f6932f89eb45ce7de0ead2fd92c7c9a7}%

.. code-block:: php

    <?php

    /**
     * @RoutePrefix("/api/products")
     */
    class ProductsController
    {

        /**
         * @Get("/")
         */
        public function indexAction()
        {

        }

        /**
         * @Get("/edit/{id:[0-9]+}", name="edit-robot")
         */
        public function editAction($id)
        {

        }

        /**
         * @Route("/save", methods={"POST", "PUT"}, name="save-robot")
         */
        public function saveAction()
        {

        }

        /**
         * @Route("/delete/{id:[0-9]+}", methods="DELETE",
         *      conversors={id="MyConversors::checkId"})
         */
        public function deleteAction($id)
        {

        }

        public function infoAction($id)
        {

        }

    }


%{routing_e8d954fb39fefaf42280b0ba17212b1e}%

+--------------+---------------------------------------------------------------------------------------------------+--------------------------------------------------------------------+
| Name         | Description                                                                                       | Usage                                                              |
+==============+===================================================================================================+====================================================================+
| RoutePrefix  | A prefix to be prepended to each route uri. This annotation must be placed at the class' docblock | @RoutePrefix("/api/products")                                      |
+--------------+---------------------------------------------------------------------------------------------------+--------------------------------------------------------------------+
| Route        | This annotation marks a method as a route. This annotation must be placed in a method docblock    | @Route("/api/products/show")                                       |
+--------------+---------------------------------------------------------------------------------------------------+--------------------------------------------------------------------+
| Get          | This annotation marks a method as a route restricting the HTTP method to GET                      | @Get("/api/products/search")                                       |
+--------------+---------------------------------------------------------------------------------------------------+--------------------------------------------------------------------+
| Post         | This annotation marks a method as a route restricting the HTTP method to POST                     | @Post("/api/products/save")                                        |
+--------------+---------------------------------------------------------------------------------------------------+--------------------------------------------------------------------+
| Put          | This annotation marks a method as a route restricting the HTTP method to PUT                      | @Put("/api/products/save")                                         |
+--------------+---------------------------------------------------------------------------------------------------+--------------------------------------------------------------------+
| Delete       | This annotation marks a method as a route restricting the HTTP method to DELETE                   | @Delete("/api/products/delete/{id}")                               |
+--------------+---------------------------------------------------------------------------------------------------+--------------------------------------------------------------------+
| Options      | This annotation marks a method as a route restricting the HTTP method to OPTIONS                  | @Option("/api/products/info")                                      |
+--------------+---------------------------------------------------------------------------------------------------+--------------------------------------------------------------------+


%{routing_ef6ddf2ec08b278c4cae5d3de4ecc4bd}%

+--------------+---------------------------------------------------------------------------------------------------+--------------------------------------------------------------------+
| Name         | Description                                                                                       | Usage                                                              |
+==============+===================================================================================================+====================================================================+
| methods      | Define one or more HTTP method that route must meet with                                          | @Route("/api/products", methods={"GET", "POST"})                   |
+--------------+---------------------------------------------------------------------------------------------------+--------------------------------------------------------------------+
| name         | Define a name for the route                                                                       | @Route("/api/products", name="get-products")                       |
+--------------+---------------------------------------------------------------------------------------------------+--------------------------------------------------------------------+
| paths        | An array of paths like the one passed to Phalcon\\Mvc\\Router::add                                | @Route("/posts/{id}/{slug}", paths={module="backend"})             |
+--------------+---------------------------------------------------------------------------------------------------+--------------------------------------------------------------------+
| conversors   | A hash of conversors to be applied to the parameters                                              | @Route("/posts/{id}/{slug}", conversors={id="MyConversor::getId"}) |
+--------------+---------------------------------------------------------------------------------------------------+--------------------------------------------------------------------+


%{routing_2a8d24e00c808b565546152a64c186d3}%

.. code-block:: php

    <?php

    $di['router'] = function() {

        //{%routing_b9d666c79f94f3cfada1ecd17e50f52d%}
        $router = new \Phalcon\Mvc\Router\Annotations(false);

        //{%routing_cbebe00549b82fb07298ec65494d85ca%}
        $router->addModuleResource('backend', 'Products', '/api/products');

        return $router;
    };
    

%{routing_ac44f232dbf5ec48d8c0868482c9ff0d}%
---------------------------

%{routing_ac9e9e05ba519f705c4df55d20b55ac7|`Phalcon Developer Tools <http://phalconphp.com/en/download/tools>`_}%

.. code-block:: php

    <?php
    
    /**
    * add routing capabilities
    */
    $di->set('router', function(){
        require __DIR__.'/../app/config/routes.php';
        return $router;
    });


%{routing_76c01d03be138f0ca89687a425f32b0d}%

.. code-block:: php

    <?php

    $router = new \Phalcon\Mvc\Router();

    $router->add("/login", array(       
        'controller' => 'login',
        'action' => 'index',
    ));

    $router->add("/products/:action", array(        
        'controller' => 'products',
        'action' => 1,
    ));

    return $router;



%{routing_6946292c838dafe294782c973703999a}%
----------------------------
%{routing_de0764d78260a6bae6b3dc64f4b95bd7|:doc:`Phalcon\\Mvc\\RouterInterface <../api/Phalcon_Mvc_RouterInterface>`}%

