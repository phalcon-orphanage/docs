MVC アプリケーション
====================

PhalconでMVCの動作が組織される背後には、 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` の働きがあります。このコンポーネントは、バックグラウンドで必要となる全ての複雑な処理をカプセル化し、必要とされる全てのコンポーネントを初期化して、それらをプロジェクトに統合し、MVCパターンの望ましい動作を実現します。

シングルまたはマルチモジュールアプリケーション
----------------------------------------------
このコンポーネントを使用すると、様々な種類のMVC構造を実行することが出来ます。

シングルモジュール
^^^^^^^^^^^^^^^^^^^
シングルMVCアプリケーションは、1つのモジュールで構成されています。名前空間を使用することもできますが、使用しなくてもかまいません。このようなアプリケーションでは、下記のようなファイル構成を持つことになります：

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

名前空間を使用しない場合、下記のブートストラップファイルをMVCのフローを調整するために使用することができます：

.. code-block:: php

    <?php

    use Phalcon\Loader;
    use Phalcon\Mvc\View;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;

    $loader = new Loader();

    $loader->registerDirs(
        [
            "../apps/controllers/",
            "../apps/models/",
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    // viewコンポーネントを登録
    $di->set(
        "view",
        function () {
            $view = new View();

            $view->setViewsDir("../apps/views/");

            return $view;
        }
    );

    $application = new Application($di);

    try {
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo $e->getMessage();
    }

名前空間を使用する場合、下記のブートストラップファイルを使用できます：

.. code-block:: php

    <?php

    use Phalcon\Loader;
    use Phalcon\Mvc\View;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;

    $loader = new Loader();

    // 名前空間の接頭辞を伴ったオートローディングの設定
    $loader->registerNamespaces(
        [
            "Single\\Controllers" => "../apps/controllers/",
            "Single\\Models"      => "../apps/models/",
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    // コントローラーの名前空間を設定してディスパッチャに登録
    $di->set(
        "dispatcher",
        function () {
            $dispatcher = new Dispatcher();

            $dispatcher->setDefaultNamespace("Single\\Controllers");

            return $dispatcher;
        }
    );

    // Register the view component
    $di->set(
        "view",
        function () {
            $view = new View();

            $view->setViewsDir("../apps/views/");

            return $view;
        }
    );

    $application = new Application($di);

    try {
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo $e->getMessage();
    }

マルチモジュール
^^^^^^^^^^^^^^^^
マルチモジュールアプリケーションは、1つ以上のモジュールに同じドキュメントルートを使用します。この場合、以下のようなファイル構成が使用できます：

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

apps/ 配下のそれぞれのディレクトリが独自のMVC構造を持っています。Module.php はそれぞれのモジュールにおける固有の設定、例えばオートローダーや専用のサービスの登録等に使用します：

.. code-block:: php

    <?php

    namespace Multiple\Backend;

    use Phalcon\Loader;
    use Phalcon\Mvc\View;
    use Phalcon\DiInterface;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\ModuleDefinitionInterface;

    class Module implements ModuleDefinitionInterface
    {
        /**
         * Register a specific autoloader for the module
         */
        public function registerAutoloaders(DiInterface $di = null)
        {
            $loader = new Loader();

            $loader->registerNamespaces(
                [
                    "Multiple\\Backend\\Controllers" => "../apps/backend/controllers/",
                    "Multiple\\Backend\\Models"      => "../apps/backend/models/",
                ]
            );

            $loader->register();
        }

        /**
         * Register specific services for the module
         */
        public function registerServices(DiInterface $di)
        {
            // ディスパッチャを登録
            $di->set(
                "dispatcher",
                function () {
                    $dispatcher = new Dispatcher();

                    $dispatcher->setDefaultNamespace("Multiple\\Backend\\Controllers");

                    return $dispatcher;
                }
            );

            // Registering the view component
            $di->set(
                "view",
                function () {
                    $view = new View();

                    $view->setViewsDir("../apps/backend/views/");

                    return $view;
                }
            );
        }
    }

マルチモジュールのMVC構成をロードするには、特別なブートストラップファイルが必要になります：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;

    $di = new FactoryDefault();

    // モジュールのルーティング設定
    // More information how to set the router up https://docs.phalconphp.com/ja/latest/reference/routing.html
    $di->set(
        "router",
        function () {
            $router = new Router();

            $router->setDefaultModule("frontend");

            $router->add(
                "/login",
                [
                    "module"     => "backend",
                    "controller" => "login",
                    "action"     => "index",
                ]
            );

            $router->add(
                "/admin/products/:action",
                [
                    "module"     => "backend",
                    "controller" => "products",
                    "action"     => 1,
                ]
            );

            $router->add(
                "/products/:action",
                [
                    "controller" => "products",
                    "action"     => 1,
                ]
            );

            return $router;
        }
    );

    // アプリケーションを初期化
    $application = new Application($di);

    // モジュールを登録する
    $application->registerModules(
        [
            "frontend" => [
                "className" => "Multiple\\Frontend\\Module",
                "path"      => "../apps/frontend/Module.php",
            ],
            "backend"  => [
                "className" => "Multiple\\Backend\\Module",
                "path"      => "../apps/backend/Module.php",
            ]
        ]
    );

    try {
        // リクエストを処理する
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo $e->getMessage();
    }

モジュール設定をブートストラップファイルで整えたい場合、無名関数を使用してモジュールを登録することができます：

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;

    // viewコンポーネントの初期化
    $view = new View();

    // viewコンポーネントにオプションを設定
    // ...

    // Register the installed modules
    $application->registerModules(
        [
            "frontend" => function ($di) use ($view) {
                $di->setShared(
                    "view",
                    function () use ($view) {
                        $view->setViewsDir("../apps/frontend/views/");

                        return $view;
                    }
                );
            },
            "backend" => function ($di) use ($view) {
                $di->setShared(
                    "view",
                    function () use ($view) {
                        $view->setViewsDir("../apps/backend/views/");

                        return $view;
                    }
                );
            }
        ]
    );

:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` にモジュールが登録されている場合、マッチしたルートが有効なモジュールを返すことが常に必要になります。それぞれの登録済みモジュールは、モジュールの機能を提供するために必要な関連クラスを持っています。それぞれのモジュールのクラス定義は、registerAutoloaders() とregisterServices() という2つのメソッドを実装しなければなりません。これらは、モジュールが実行される際に :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` に呼ばれます。

アプリケーション・イベント
--------------------------
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` は、 :doc:`EventsManager <events>` にイベントを送ることができます ( :doc:`EventsManager <events>` がある場合)。イベントは「application」というタイプで発火します。以下のイベントがサポートされています:

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

以下の例は、リスナーへのこのコンポーネントの追加方法を示しています:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $eventsManager = new EventsManager();

    $application->setEventsManager($eventsManager);

    $eventsManager->attach(
        "application",
        function (Event $event, $application) {
            // ...
        }
    );

外部資料
------------------
* `MVC examples on Github <https://github.com/phalcon/mvc>`_
