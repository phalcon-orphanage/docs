MVC アプリケーション
====================

Phalcon では MVC の協調動作の背後にある全ての煩雑な作業は通常 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` によって遂行されています。
このコンポーネントは、バックグラウンドで必要となる全ての複雑な処理をカプセル化し、必要とされる全てのコンポーネントを初期化して、それらをプロジェクトに統合し、MVC パターンの望ましい動作を実現します。

シングルまたはマルチモジュールアプリケーション
----------------------------------------------
このコンポーネントを使用すると、様々な種類の MVC 構造を実行することが出来ます。

シングルモジュール
^^^^^^^^^^^^^^^^^^^
シングル MVC アプリケーションは 1 つのモジュールだけで構成されています。名前空間を使用することもできますが不要です。このようなアプリケーションでは、下記のようなファイル構成を持つことになります：

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

名前空間を使用しない場合、下記のブートストラップファイルを MVC のフローを調整するために使用することができます：

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

    // view コンポーネントを登録
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
マルチモジュールアプリケーションは、1 つ以上のモジュールに同じドキュメントルートを使用します。この場合、以下のようなファイル構成が使用できます：

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

apps/ 配下のそれぞれのディレクトリが独自の MVC 構造を持っています。Module.php はそれぞれのモジュールにおける固有の設定、例えばオートローダーや専用のサービスの登録等に使用します：

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
         * モジュール用に特定のオートローダを登録
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
         * モジュール用に特定のサービスを登録
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

            // view コンポーネントを登録
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

マルチモジュールの MVC 構成をロードするには、特別なブートストラップファイルが必要になります：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;

    $di = new FactoryDefault();

    // モジュールのルーティング設定
    // 詳細はルーティングの設定を参照  https://docs.phalconphp.com/ja/latest/reference/routing.html
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

    // インストールしたモジュールを登録
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
| イベント名            | トリガー                                                      |
+=====================+==============================================================+
| boot                | アプリケーションが最初のリクエストを処理した時に実行される             |
+---------------------+--------------------------------------------------------------+
| beforeStartModule   | モジュールが登録されている場合に限り、モジュールが初期化される前に実行される |
+---------------------+--------------------------------------------------------------+
| afterStartModule    | モジュールが登録されている場合に限り、モジュールが初期化された後に実行される |
+---------------------+--------------------------------------------------------------+
| beforeHandleRequest | ディスパッチループが開始される前に実行される                        |
+---------------------+--------------------------------------------------------------+
| afterHandleRequest  | ディスパッチループの後に実行される                                |
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
* `Github にある MVC 例 <https://github.com/phalcon/mvc>`_
