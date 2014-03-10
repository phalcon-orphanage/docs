%{micro_788ba238448c0f22d9c254a70b84065b}%

==================
%{micro_648846d5e9eabd0bf02300f083324c8f}%


.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    $app->get('/say/welcome/{name}', function ($name) {
        echo "<h1>Welcome $name!</h1>";
    });

    $app->handle();

%{micro_e31cd488f01b9bb2939d662e1188325b}%

----------------------------
%{micro_0cca96e627df9983cf88153c2d5fc687}%


.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

%{micro_a8a25f2aac05af019b129455c8d4e2eb}%

---------------
%{micro_cd66a5f8e2f703c2f2961dbf23a08512}%


.. code-block:: php

    <?php

    $app->get('/say/hello/{name}', function ($name) {
        echo "<h1>Hello! $name</h1>";
    });

%{micro_8a2607a1b3d9c1e7d4c6aa7b1cc42166}%

.. code-block:: php

    <?php

    // {%micro_7498d8df6b27d927a87b057af1aebf65%}
    function say_hello($name) {
        echo "<h1>Hello! $name</h1>";
    }

    $app->get('/say/hello/{name}', "say_hello");

    // {%micro_01da912e811a33919d47c8a74ddfd861%}
    $app->get('/say/hello/{name}', "SomeClass::someSayMethod");

    // {%micro_bf0bdbca721b0c4962c839806d309ccb%}
    $myController = new MyController();
    $app->get('/say/hello/{name}', array($myController, "someAction"));

    //{%micro_9c35a54a2808945a495840b422be844c%}
    $app->get('/say/hello/{name}', function ($name) {
        echo "<h1>Hello! $name</h1>";
    });

:doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` provides a set of methods to define the HTTP method (or methods)
%{micro_316bd31a828df167d7d72ed74c55ead7}%

.. code-block:: php

    <?php

    //{%micro_0acdc84f01c3de1996d30eb564480858%}
    $app->get('/api/products', "get_products");

    //{%micro_a5f97bf5b879d03818789362e62f6cbe%}
    $app->post('/api/products/add', "add_product");

    //{%micro_9685de3866b5e3626a73be2839aef956%}
    $app->put('/api/products/update/{id}', "update_product");

    //{%micro_d3e1d13f48d2e7cb88aede1b28427da6%}
    $app->delete('/api/products/remove/{id}', "delete_product");

    //{%micro_363822d61f231b2b8acf67bdbd1dce45%}
    $app->options('/api/products/info/{id}', "info_product");

    //{%micro_cfe365e9b04bf44e504d0472f5325182%}
    $app->patch('/api/products/update/{id}', "info_product");

    //{%micro_5330c1b15d6f52715e45f926d68be6fc%}
    $app->map('/repos/store/refs',"action_product")->via(array('GET', 'POST'));


%{micro_4a215d25b41d831f94fd7b60c56823b3}%

^^^^^^^^^^^^^^^^^^^^^^
%{micro_384b68c39a5ef3f758b2911215ecab48}%


.. code-block:: php

    <?php

    //{%micro_34f4f4ed3bc000637cc93e5f7e8260ad%}
    $app->get('/posts/{year:[0-9]+}/{title:[a-zA-Z\-]+}', function ($year, $title) {
        echo "<h1>Title: $title</h1>";
        echo "<h2>Year: $year</h2>";
    });

%{micro_796c0bcf8150277f840e5a6d386a47de}%

^^^^^^^^^^^^^^
%{micro_a7fdbf88ca37d62f53e85d18ae5798ef}%


.. code-block:: php

    <?php

    //{%micro_7c335adb80c521502006bc733ed871b0%}
    $app->get('/', function () {
        echo "<h1>Welcome!</h1>";
    });

%{micro_06227ff2f8829cdfcedeee027ea7298b}%

^^^^^^^^^^^^^
%{micro_1be14374a2c637b2bbbb4a3e44954076}%


.. code-block:: apacheconf

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

%{micro_1e6e4ade63d9748952ec93d9dfac5e20}%

----------------------
%{micro_0ce887b41000aeeb257910c81b702ba0}%


.. code-block:: php

    <?php

    //{%micro_a80ab8816878c89e3adc0a7cece510ec%}
    $app->get('/say/hello', function () {
        echo "<h1>Hello! $name</h1>";
    });

    //{%micro_c1eaa0b85bc04bf5960a7de81a90f98d%}
    $app->get('/show/results', function () {
        require 'views/results.php';
    });

    //{%micro_05fad9a71467b9e171ba2cff2dd29bf0%}
    $app->get('/get/some-json', function () {
        echo json_encode(array("some", "important", "data"));
    });

%{micro_5c447a72e04a5ddaaa0a58ec327cf825}%

.. code-block:: php

    <?php

    $app->get('/show/data', function () use ($app) {

        //{%micro_9dcceb5181138665045d759a481b4f30%}
        $app->response->setContentType('text/plain')->sendHeaders();

        //{%micro_b19027a2de9f8ab406282531f7a2fa9e%}
        readfile("data.txt");

    });

%{micro_a9e7eaad6b915f732d9afbbf789280ca}%

.. code-block:: php

    <?php

    $app->get('/show/data', function () {

        //{%micro_ea25894af54d5d28a23fb08f9f153999%}
        $response = new Phalcon\Http\Response();

        //{%micro_9dcceb5181138665045d759a481b4f30%}
        $response->setContentType('text/plain');

        //{%micro_360d9f80b5a733918b85c894147c64a1%}
        $response->setContent(file_get_contents("data.txt"));

        //{%micro_0511ba07cfb3ddd1a0fced413a2fe537%}
        return $response;
    });

%{micro_85ebb8b1fe35876ecb488660ec541ddb}%

-------------------
%{micro_5c2a4dda48773c7b7b6acea701a709ee}%


.. code-block:: php

    <?php

    //{%micro_4e535a56cb99fc005c3d4945a41d7713%}
    $app->post('/old/welcome', function () use ($app) {
        $app->response->redirect("new/welcome")->sendHeaders();
    });

    $app->post('/new/welcome', function () use ($app) {
        echo 'This is the new Welcome';
    });

%{micro_9798a318dd3602294c210880870c54e0}%

--------------------------
%{micro_abee3e3e45f7489d1ed3a7af0125df95}%


.. code-block:: php

    <?php

    //{%micro_1baeb154b758af70236b382c8a669750%}
    $app->get('/blog/{year}/{title}', function ($year, $title) use ($app) {

        //{%micro_1666d869e2703e08a0904736d87914a8%}

    })->setName('show-post');

    //{%micro_efe1f7fde2be6aff0a75f3c05941c02c%}
    $app->get('/', function() use ($app) {

        echo '<a href="', $app->url->get(array(
            'for' => 'show-post',
            'title' => 'php-is-a-great-framework',
            'year' => 2012
        )), '">Show the post</a>';

    });


%{micro_1edd36cbfb44041b7c30b16d6c2d799a}%

----------------------------------------
%{micro_aae2fb5d963da74321705d5b59c18693}%


.. code-block:: php

    <?php

    use Phalcon\DI\FactoryDefault,
        Phalcon\Mvc\Micro,
        Phalcon\Config\Adapter\Ini as IniConfig;

    $di = new FactoryDefault();

    $di->set('config', function() {
        return new IniConfig("config.ini");
    });

    $app = new Micro();

    $app->setDI($di);

    $app->get('/', function () use ($app) {
        //{%micro_ca39bc6c921a2d9027fa80a214dfaa52%}
        echo $app->config->app_name;
    });

    $app->post('/contact', function () use ($app) {
        $app->flash->success('Yes!, the contact was made!');
    });

%{micro_64079488a59faeb550ea2c18104673d3}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro,
        Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter;

    $app = new Micro();

    //{%micro_748cc1e41c403cd76458fba2c9792f85%}
    $app['db'] = function() {
        return new MysqlAdapter(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "test_db"
        ));
    };

    $app->get('/blog', function () use ($app) {
        $news = $app['db']->query('SELECT * FROM news');
        foreach ($news as $new) {
            echo $new->title;
        }
    });

%{micro_dfe1468d30627f01538ae98507febc3e}%

-----------------
%{micro_3cd465e50bae5ff20846030afa6f1c91}%


.. code-block:: php

    <?php

    $app->notFound(function () use ($app) {
        $app->response->setStatusCode(404, "Not Found")->sendHeaders();
        echo 'This is crazy, but this page was not found!';
    });

%{micro_4325ce4e9847b0d604ca69b6743b6465}%

----------------------------
%{micro_94d4d62695afcb1d841a41b9d47f4260}%


.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(array(
        __DIR__ . '/models/'
    ))->register();

    $app = new \Phalcon\Mvc\Micro();

    $app->get('/products/find', function(){

        foreach (Products::find() as $product) {
            echo $product->name, '<br>';
        }

    });

    $app->handle();

%{micro_b2f9f6b99cf3263485d410423f15bf18}%

------------------------
%{micro_b505075c684a62fc5150a58f45018184}%


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

%{micro_0f780737706f95d6efb0e43b8c5b9370}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro,
        Phalcon\Events\Manager as EventsManager;

    //{%micro_ccea41bb95ad572b5f593c2d1852d1d4%}
    $eventManager = new EventsManager();

    //{%micro_39649819a509d7cf883165be8aeecce9%}
    $eventManager->attach('micro', function($event, $app) {

        if ($event->getType() == 'beforeExecuteRoute') {
            if ($app->session->get('auth') == false) {

                $app->flashSession->error("The user isn't authenticated");
                $app->response->redirect("/")->sendHeaders();

                //{%micro_0fbedd9204dc5db86ea0a5da97f26c15%}
                return false;
            }
        }

    });

    $app = new Micro();

    //{%micro_5f8a807560139399123c35aaaf7132a9%}
    $app->setEventsManager($eventManager);

%{micro_a954117055b58c8596806ed51d04a5bc}%

-----------------
%{micro_cd46592838085b7b4c94e18b6cca9f5f}%


.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    //{%micro_7a19577910984437f22b54c1da5b89c4%}
    //{%micro_db2cb8a8a9f51fb25719488bfcef8132%}
    $app->before(function() use ($app) {
        if ($app['session']->get('auth') == false) {
            return false;
        }
        return true;
    });

    $app->map('/api/robots', function(){
        return array(
            'status' => 'OK'
        );
    });

    $app->after(function() use ($app) {
        //{%micro_ad6dff7322b8f1daafebd4471d17e0d1%}
        echo json_encode($app->getReturnedValue());
    });

    $app->finish(function() use ($app) {
        //{%micro_7e6106d8f1196faf1366c4a2f2c7ad4e%}
    });

%{micro_af61d0ee94d5363bff4723b20b510672}%

.. code-block:: php

    <?php

    $app->finish(function() use ($app) {
        //{%micro_8e6935bf018891c2e1c0d04360e78cbd%}
    });

    $app->finish(function() use ($app) {
        //{%micro_bc7d01509c0ceb1a729f0cd93c103f61%}
    });

%{micro_91247934de46a6239a1477c5033afebc}%

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

            $cache = $application['cache'];
            $router = $application['router'];

            $key = preg_replace('/^[a-zA-Z0-9]/', '', $router->getRewriteUri());

            //{%micro_a91acd4a04a8d63b54eca9f777dc2f4a%}
            if ($cache->exists($key)) {
                echo $cache->get($key);
                return false;
            }

            return true;
        }
    }

%{micro_d188b24bbaa8eb2535c56aa6ae8fface}%

.. code-block:: php

    <?php

    $app->before(new CacheMiddleware());

%{micro_8b6387c927d810b580482dcced74c785}%

+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| Event Name          | Triggered                                                                                                                  | Can stop operation?  |
+=====================+============================================================================================================================+======================+
| before              | Before executing the handler. It can be used to control the access to the application                                      | Yes                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| after               | Executed after the handler is executed. It can be used to prepare the response                                             | No                   |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+
| finish              | Executed after sending the response. It can be used to perform clean-up                                                    | No                   |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+

%{micro_8d672192be99dfd34509f659e0938d58}%

-----------------------------
%{micro_d5c2ff46f8c4c2951e8ee0b9c8f58925}%


.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro\Collection as MicroCollection;

    $posts = new MicroCollection();

    //{%micro_75189147858476e97696411d319fca0b%}
    $posts->setHandler(new PostsController());

    //{%micro_252cc4557a0572ad7e2a353bc2a19fe6%}
    $posts->setPrefix('/posts');

    //{%micro_8feeee82ecff4dc4ac6b094e4b583f67%}
    $posts->get('/', 'index');

    //{%micro_fea4f64b27da7c5c89a2d258446ee102%}
    $posts->get('/show/{slug}', 'show');

    $app->mount($posts);

%{micro_0974007ee9d282272b7beb588446ad82}%

.. code-block:: php

    <?php

    class PostsController extends Phalcon\Mvc\Controller
    {

        public function index()
        {
            //...
        }

        public function show($slug)
        {
            //...
        }
    }

%{micro_5443e6f2efcec044c0dbcbaeb846bf40}%

.. code-block:: php

    <?php

    $posts->setHandler('PostsController', true);
    $posts->setHandler('Blog\Controllers\PostsController', true);

%{micro_96018889300caae7d7d05f83cd8e858c}%

-------------------
%{micro_c7feff5e66f92496121ef73b5ea437e7}%


.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro,
        Phalcon\Http\Response;

    $app = new Micro();

    //{%micro_c06c8a627788b3cb7c88a7224b652b37%}
    $app->get('/welcome/index', function() {

        $response = new Response();

        $response->setStatusCode(401, "Unauthorized");

        $response->setContent("Access is not authorized");

        return $response;
    });

%{micro_3eeddf70df32086a3d2bb22803b559d4}%

---------------
%{micro_70e1a9347021840524d101419a67e2f7}%


.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    $app['view'] = function() {
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('app/views/');
        return $view;
    };

    //{%micro_18c2a1c6c28339bee817691385f44cbd%}
    $app->get('/products/show', function() use ($app) {

        // {%micro_81c40fc338aba7ac1b81efcd965882a7%}
        echo $app['view']->render('products/show', array(
            'id' => 100,
            'name' => 'Artichoke'
        ));

    });

