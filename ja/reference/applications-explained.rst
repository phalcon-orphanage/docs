Understanding How Phalcon Applications Work
===========================================

あなたが :doc:`tutorial <tutorial>` を読んでことがあるか、 :doc:`Phalcon Devtools <tools>` を使ってコードを生成したことがあるなら、以下のブートストラップファイルを見たことがあるはずです：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    // オートローダにディレクトリを登録する
    // ...

    // サービスを登録する
    // ...

    // Handle the request
    $application = new Application($di);

    try {
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo "Exception: ", $e->getMessage();
    }

コントローラーの全ての働きの中核部分は、handle()が呼ばれた際に発生します：

.. code-block:: php

    <?php

    $response = $application->handle();

手動によるブートストラップ
--------------------------
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` を使いたくない場合、上述したコードは以下のように変更できます:

.. code-block:: php

    <?php

    // 「router」サービスを取得
    $router = $di["router"];

    $router->handle();

    $view = $di["view"];

    $dispatcher = $di["dispatcher"];

    // 処理済みのルートパラメータをディスパッチャに渡す

    $dispatcher->setControllerName(
        $router->getControllerName()
    );

    $dispatcher->setActionName(
        $router->getActionName()
    );

    $dispatcher->setParams(
        $router->getParams()
    );

    // viewの開始
    $view->start();

    // リクエストを処理する
    $dispatcher->dispatch();

    // 関連するビューの描画
    $view->render(
        $dispatcher->getControllerName(),
        $dispatcher->getActionName(),
        $dispatcher->getParams()
    );

    // viewの終了
    $view->finish();

    $response = $di["response"];

    // ビューの出力をレスポンスに渡す
    $response->setContent(
        $view->getContent()
    );

    // Send the response
    $response->send();

以下の、 :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` の代替となるコードは、viewコンポーネントを使用していないため、REST APIに適しています:

.. code-block:: php

    <?php

    use Phalcon\Http\ResponseInterface;

    // Get the 'router' service
    $router = $di["router"];

    $router->handle();

    $dispatcher = $di["dispatcher"];

    // Pass the processed router parameters to the dispatcher

    $dispatcher->setControllerName(
        $router->getControllerName()
    );

    $dispatcher->setActionName(
        $router->getActionName()
    );

    $dispatcher->setParams(
        $router->getParams()
    );

    // Dispatch the request
    $dispatcher->dispatch();

    // 直前に実行されたアクションの返り値を取得
    $response = $dispatcher->getReturnedValue();

    // 返り値がResponseオブジェクトのインスタンスか確認する
    if ($response instanceof ResponseInterface) {
        // リクエストを送信する
        $response->send();
    }

ディスパッチャで生成された例外をキャッチして、別のアクションを実行するやり方の代替が以下になります:

.. code-block:: php

    <?php

    use Phalcon\Http\ResponseInterface;

    // Get the 'router' service
    $router = $di["router"];

    $router->handle();

    $dispatcher = $di["dispatcher"];

    // Pass the processed router parameters to the dispatcher

    $dispatcher->setControllerName(
        $router->getControllerName()
    );

    $dispatcher->setActionName(
        $router->getActionName()
    );

    $dispatcher->setParams(
        $router->getParams()
    );

    try {
        // Dispatch the request
        $dispatcher->dispatch();
    } catch (Exception $e) {
        // 例外が発生した場合、それに対応するコントローラーとアクションを実行する

        // Pass the processed router parameters to the dispatcher
        $dispatcher->setControllerName("errors");
        $dispatcher->setActionName("action503");

        // Dispatch the request
        $dispatcher->dispatch();
    }

    // Get the returned value by the last executed action
    $response = $dispatcher->getReturnedValue();

    // Check if the action returned is a 'response' object
    if ($response instanceof ResponseInterface) {
        // Send the response
        $response->send();
    }

上記した実装は :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` を使用するものよりもずっと多くの情報を含んでいますが、これはアプリケーションの初期化の別のやり方です。場合によって、何がインスタンス化されるかを全てコントロールしたい場合もあるでしょうし、特定のコンポーネントを、基本的な機能を継承した独自コンポーネントで置き換えたい場合もあるでしょう。
