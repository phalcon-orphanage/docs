%{applications_b3473fd26b7d8cc92e497638ddc6ccd3}%
================
%{applications_2e9b5038eadc576f44b08732f15b6272|:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`}%

%{applications_5c72b7de87d984c178bc0e685791918e}%
-----------------------------------
%{applications_30f30bef89d983b1a62c9e5ff1737a1e}%

%{applications_f097132aa35267eefdbc61076bc00ea6}%
^^^^^^^^^^^^^
%{applications_416800eeb4591d20f3650afb9c5cbe71}%

.. code-block:: php

    single/
        app/
            controllers/
            models/
            views/
        public/
            css/
            img/
            js/


%{applications_aeb6b481a934736a9317de8e35b816ca}%

.. code-block:: php

    <?php

    use Phalcon\Loader,
        Phalcon\DI\FactoryDefault,
        Phalcon\Mvc\Application,
        Phalcon\Mvc\View;

    $loader = new Loader();

    $loader->registerDirs(
        array(
            '../apps/controllers/',
            '../apps/models/'
        )
    )->register();

    $di = new FactoryDefault();

    // {%applications_faa502b951ab798137c6cb6e31d62100%}
    $di->set('view', function() {
        $view = new View();
        $view->setViewsDir('../apps/views/');
        return $view;
    });

    try {

        $application = new Application($di);

        echo $application->handle()->getContent();

    } catch (\Exception $e) {
        echo $e->getMessage();
    }


%{applications_515ae1eb1a3c418c9df6567ee8ebc937}%

.. code-block:: php

    <?php

    use Phalcon\Loader,
        Phalcon\Mvc\View,
        Phalcon\DI\FactoryDefault,
        Phalcon\Mvc\Dispatcher,
        Phalcon\Mvc\Application;

    $loader = new Loader();

    // {%applications_290a704190b60c65fce3b4833c72f709%}
    $loader->registerNamespaces(
        array(
            'Single\Controllers' => '../apps/controllers/',
            'Single\Models'      => '../apps/models/',
        )
    )->register();

    $di = new FactoryDefault();

    // {%applications_ce131ddce42f7e3db591ccc00b36076c%}
    $di->set('dispatcher', function() {
        $dispatcher = new Dispatcher();
        $dispatcher->setDefaultNamespace('Single\Controllers');
        return $dispatcher;
    });

    // {%applications_faa502b951ab798137c6cb6e31d62100%}
    $di->set('view', function() {
        $view = new View();
        $view->setViewsDir('../apps/views/');
        return $view;
    });

    try {

        $application = new Application($di);

        echo $application->handle()->getContent();

    } catch(\Exception $e){
        echo $e->getMessage();
    }



%{applications_5751c2fd1cb6ec657c0ee1645cd00695}%
^^^^^^^^^^^^
%{applications_655e8a68e201a868cce8e36a8694ab55}%

.. code-block:: php

    multiple/
      apps/
        frontend/
           controllers/
           models/
           views/
           Module.php
        backend/
           controllers/
           models/
           views/
           Module.php
      public/
        css/
        img/
        js/


%{applications_2da6e9ab0cc34715fd676223767bc44e}%

.. code-block:: php

    <?php

    namespace Multiple\Backend;

    use Phalcon\Loader,
        Phalcon\Mvc\Dispatcher,
        Phalcon\Mvc\View,
        Phalcon\Mvc\ModuleDefinitionInterface;

    class Module implements ModuleDefinitionInterface
    {

        /**
         * Register a specific autoloader for the module
         */
        public function registerAutoloaders()
        {

            $loader = new Loader();

            $loader->registerNamespaces(
                array(
                    'Multiple\Backend\Controllers' => '../apps/backend/controllers/',
                    'Multiple\Backend\Models'      => '../apps/backend/models/',
                )
            );

            $loader->register();
        }

        /**
         * Register specific services for the module
         */
        public function registerServices($di)
        {

            //{%applications_d3477be4fcfb5b2e53eb426e85a84ad1%}
            $di->set('dispatcher', function() {
                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace("Multiple\Backend\Controllers");
                return $dispatcher;
            });

            //{%applications_faa502b951ab798137c6cb6e31d62100%}
            $di->set('view', function() {
                $view = new View();
                $view->setViewsDir('../apps/backend/views/');
                return $view;
            });
        }

    }


%{applications_44e1cebcbff50d87515a10aa14148592}%

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router,
        Phalcon\Mvc\Application,
        Phalcon\DI\FactoryDefault;

    $di = new FactoryDefault();

    //{%applications_6346b563f17241e069afc0450dbf99ab%}
    $di->set('router', function () {

        $router = new Router();

        $router->setDefaultModule("frontend");

        $router->add("/login", array(
            'module'     => 'backend',
            'controller' => 'login',
            'action'     => 'index',
        ));

        $router->add("/admin/products/:action", array(
            'module'     => 'backend',
            'controller' => 'products',
            'action'     => 1,
        ));

        $router->add("/products/:action", array(
            'controller' => 'products',
            'action'     => 1,
        ));

        return $router;
    });

    try {

        //{%applications_af3b0c5f3814f511560f1328c6a3e421%}
        $application = new Application($di);

        // {%applications_e09da7fe34c2e54c065067b026d5c495%}
        $application->registerModules(
            array(
                'frontend' => array(
                    'className' => 'Multiple\Frontend\Module',
                    'path'      => '../apps/frontend/Module.php',
                ),
                'backend'  => array(
                    'className' => 'Multiple\Backend\Module',
                    'path'      => '../apps/backend/Module.php',
                )
            )
        );

        //{%applications_6e390072cbe16eea871f567953e9ed8f%}
        echo $application->handle()->getContent();

    } catch(\Exception $e){
        echo $e->getMessage();
    }


%{applications_0d4cde41b79e03bb90ff94219e5b5a66}%

.. code-block:: php

    <?php

    //{%applications_8faa972d61c8284d6df2e1a2a954449a%}
    $view = new \Phalcon\Mvc\View();

    //{%applications_bf3405f13bd7a17626e69f61bce6beb1%}
    //...

    // {%applications_e09da7fe34c2e54c065067b026d5c495%}
    $application->registerModules(
        array(
            'frontend' => function($di) use ($view) {
                $di->setShared('view', function() use ($view) {
                    $view->setViewsDir('../apps/frontend/views/');
                    return $view;
                });
            },
            'backend' => function($di) use ($view) {
                $di->setShared('view', function() use ($view) {
                    $view->setViewsDir('../apps/backend/views/');
                    return $view;
                });
            }
        )
    );


%{applications_ff9fff92ce682ad45e321c4708a60c68|:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`|:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`}%

%{applications_f755654cd30447787e75f8ac4b685c21}%
----------------------------------
%{applications_404f1c1169ce1946415ce2cf66ea0368|:doc:`tutorial <tutorial>`|:doc:`Phalcon Devtools <tools>`}%

.. code-block:: php

    <?php

    try {

        // {%applications_4db062df9a2bcaaed11dacb62050066c%}
        //...

        // {%applications_b0ee5187535bf9ed0d422b1c5d468803%}
        //...

        // {%applications_6e390072cbe16eea871f567953e9ed8f%}
        $application = new \Phalcon\Mvc\Application($di);

        echo $application->handle()->getContent();

    } catch (\Exception $e) {
        echo "Exception: ", $e->getMessage();
    }


%{applications_5b7a57d61632637bde6f41d00b356952}%

.. code-block:: php

    <?php

    echo $application->handle()->getContent();


%{applications_5772ed72bed6d4143cdce5714eae250b}%
-------------------
%{applications_2509fb7e23167c2029f66b267149e12b|:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`}%

.. code-block:: php

    <?php

    // {%applications_5c643e5fc4e1e2b139dc49223954f07d%}
    $router = $di['router'];

    $router->handle();

    $view = $di['view'];

    $dispatcher = $di['dispatcher'];

    // {%applications_e9235990f60bd87dea2cd1916c5dda0b%}
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    // {%applications_f65e37f68b2dad49dd4c7468e500f099%}
    $view->start();

    // {%applications_a30744e6e9ab2ec2d650bb7e14e7ee87%}
    $dispatcher->dispatch();

    // {%applications_667f3a1cf267224a9d75f89198f8785f%}
    $view->render(
        $dispatcher->getControllerName(),
        $dispatcher->getActionName(),
        $dispatcher->getParams()
    );

    // {%applications_daa91b7614c4e32e5dc9b94f30ad9738%}
    $view->finish();

    $response = $di['response'];

    // {%applications_4b93c4493e563230dee6f09fbd73bd33%}
    $response->setContent($view->getContent());

    // {%applications_58548ea8c5de29ab761b4099bdd8281c%}
    $response->sendHeaders();

    // {%applications_730373716a0b13e03cde896c002673b5%}
    echo $response->getContent();


%{applications_37a1738cd5f825f57266a2d2d020ad92|:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`}%

.. code-block:: php

    <?php

    // {%applications_5c643e5fc4e1e2b139dc49223954f07d%}
    $router = $di['router'];

    $router->handle();

    $dispatcher = $di['dispatcher'];

    // {%applications_e9235990f60bd87dea2cd1916c5dda0b%}
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    // {%applications_a30744e6e9ab2ec2d650bb7e14e7ee87%}
    $dispatcher->dispatch();

    //{%applications_f6f4e66567a39e1be5517eb1beada4ae%}
    $response = $dispatcher->getReturnedValue();

    //{%applications_21d70c170fa633a6f5779c5c147a153d%}
    if ($response instanceof Phalcon\Http\ResponseInterface) {

        //{%applications_efc3bcebe3b11474027090395185edd2%}
        $response->send();
    }


%{applications_a40a4e9d3dcfc83a609532a73f819a22}%

.. code-block:: php

    <?php

    // {%applications_5c643e5fc4e1e2b139dc49223954f07d%}
    $router = $di['router'];

    $router->handle();

    $dispatcher = $di['dispatcher'];

    // {%applications_e9235990f60bd87dea2cd1916c5dda0b%}
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    try {

        // {%applications_a30744e6e9ab2ec2d650bb7e14e7ee87%}
        $dispatcher->dispatch();

    } catch (Exception $e) {

        //{%applications_7d5e11cb2a96eab801a42ec98443338b%}

        // {%applications_e9235990f60bd87dea2cd1916c5dda0b%}
        $dispatcher->setControllerName('errors');
        $dispatcher->setActionName('action503');

        // {%applications_a30744e6e9ab2ec2d650bb7e14e7ee87%}
        $dispatcher->dispatch();

    }

    //{%applications_f6f4e66567a39e1be5517eb1beada4ae%}
    $response = $dispatcher->getReturnedValue();

    //{%applications_21d70c170fa633a6f5779c5c147a153d%}
    if ($response instanceof Phalcon\Http\ResponseInterface) {

        //{%applications_efc3bcebe3b11474027090395185edd2%}
        $response->send();
    }


%{applications_37c437cd1d3ac2f34535328f99c300ab|:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`}%

%{applications_e49f4ec3985839b3237b74a15b496e3e}%
------------------
%{applications_bc546a9a38f97da08a7600d2ac9addda|:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`|:doc:`EventsManager <events>`}%

+---------------------+--------------------------------------------------------------+
| Event Name          | Triggered                                                    |
+=====================+==============================================================+
| boot                | Executed when the application handles its first request      |
+---------------------+--------------------------------------------------------------+
| beforeStartModule   | Before initialize a module, only when modules are registered |
+---------------------+--------------------------------------------------------------+
| afterStartModule    | After initialize a module, only when modules are registered  |
+---------------------+--------------------------------------------------------------+
| beforeHandleRequest | Before execute the dispatch loop                             |
+---------------------+--------------------------------------------------------------+
| afterHandleRequest  | After execute the dispatch loop                              |
+---------------------+--------------------------------------------------------------+


%{applications_4eb434eb37be7b4a57c178fa4af88c76}%

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    $eventsManager = new EventsManager();

    $application->setEventsManager($eventsManager);

    $eventsManager->attach(
        "application",
        function($event, $application) {
            // ...
        }
    );


