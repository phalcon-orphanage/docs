アノテーション パーサー
=======================

アノテーションのパーサーがCで実装されたのは、PHPの世界では初めてのことです。:code:`Phalcon\Annotations` は、汎用的なコンポーネントで、アプリケーションで使われるPHPのクラスのアノテーションをパースしてキャッシュしておくことが、簡単にできます。

アノテーションはクラス、メソッド、プロパティのコメントブロックから読み込まれます。アノテーションはコメントブロック内のどこにでも配置することができます：

.. code-block:: php

    <?php

    /**
     * This is the class description
     *
     * @AmazingClass(true)
     */
    class Example
    {
        /**
         * This a property with a special feature
         *
         * @SpecialFeature
         */
        protected $someProperty;

        /**
         * This is a method
         *
         * @SpecialFeature
         */
        public function someMethod()
        {
            // ...
        }
    }

上記サンプルのコメント内にいくつかのアノテーションが見られます。アノテーションのシンタックスは以下のようになります :

.. code-block:: php

    /**
     * @Annotation-Name
     * @Annotation-Name(param1, param2, ...)
     */

また、アノテーションはコメントブロックの一部として配置することができます：

.. code-block:: php

    <?php

    /**
     * This a property with a special feature
     *
     * @SpecialFeature
     *
     * More comments
     *
     * @AnotherSpecialFeature(true)
     */

パーサーは柔軟性が高いため、以下のようなコメントブロックも有効です:

.. code-block:: php

    <?php

    /**
     * This a property with a special feature @SpecialFeature({
    someParameter="the value", false

     })  More comments @AnotherSpecialFeature(true) @MoreAnnotations
     **/

但し、メンテナンス性、可読性を高めたコードを書くために、コメントブロックの最後にアノテーションすることをお奨めします：

.. code-block:: php

    <?php

    /**
     * This a property with a special feature
     * More comments
     *
     * @SpecialFeature({someParameter="the value", false})
     * @AnotherSpecialFeature(true)
     */

アノテーションの読み取り
------------------------
reflectorは、オブジェクト指向のインターフェースでクラスのアノテーションを簡単に読み取れるよう、実装されています:

.. code-block:: php

    <?php

    use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

    $reader = new MemoryAdapter();

    // Exampleクラスのアノテーションをリフレクションする
    $reflector = $reader->get("Example");

    // クラスのコメントブロックのアノテーションを読み取り
    $annotations = $reflector->getClassAnnotations();

    // アノテーションをトラバースする
    foreach ($annotations as $annotation) {
        // アノテーション名を表示する
        echo $annotation->getName(), PHP_EOL;

        // 引数の数を表示する
        echo $annotation->numberArguments(), PHP_EOL;

        // 引数を表示する
        print_r($annotation->getArguments());
    }

アノテーションを読み取る処理は非常に高速ですが、パフォーマンス上の理由から、アダプタを使用してパースしたアノテーションを保存しておくことが推奨されます。アダプタは処理後のアノテーションをキャッシュし、何度もアノテーションを読み取らなくても良いようにします。

上記サンプルでは、 :doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>` が使用されています。このアダプタはリクエストの間にだけ、キャッシュを行います。そのため、このアダプタは開発用に適しています。本番環境では、他のアダプタを使ってキャッシュを行うこともできます。

アノテーションの種類
--------------------
アノテーションは、パラメータを持つこともあれば持たないこともあります。パラメータには、単純なリテラル(文字列、数値、真偽値、null)、配列、連想配列、別のアノテーション、があります:

.. code-block:: php

    <?php

    /**
     * Simple Annotation
     *
     * @SomeAnnotation
     */

    /**
     * Annotation with parameters
     *
     * @SomeAnnotation("hello", "world", 1, 2, 3, false, true)
     */

    /**
     * Annotation with named parameters
     *
     * @SomeAnnotation(first="hello", second="world", third=1)
     * @SomeAnnotation(first: "hello", second: "world", third: 1)
     */

    /**
     * Passing an array
     *
     * @SomeAnnotation([1, 2, 3, 4])
     * @SomeAnnotation({1, 2, 3, 4})
     */

    /**
     * Passing a hash as parameter
     *
     * @SomeAnnotation({first=1, second=2, third=3})
     * @SomeAnnotation({'first'=1, 'second'=2, 'third'=3})
     * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3})
     * @SomeAnnotation(['first': 1, 'second': 2, 'third': 3])
     */

    /**
     * Nested arrays/hashes
     *
     * @SomeAnnotation({"name"="SomeName", "other"={
     *     "foo1": "bar1", "foo2": "bar2", {1, 2, 3},
     * }})
     */

    /**
     * Nested Annotations
     *
     * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
     */

実用的な使用法
---------------
次に、PHPのアプリケーションでの、アノテーションの実用的な使用例を説明します:

アノテーションでのキャッシュの有効化
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
以下のコントローラーがあり、開発者は直近に実行されたアクションがキャッシュ可能だとマーキングされた場合は、自動的にキャッシュを開始するプラグインを作成しようとしている、と想定してみましょう。最初に、プラグインをディスパッチャに登録して、ルートの実行を通知されるようにします:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Manager as EventsManager;

    $di["dispatcher"] = function () {
        $eventsManager = new EventsManager();

        // プラグインを「dispatch」イベントに紐付け
        $eventsManager->attach(
            "dispatch",
            new CacheEnablerPlugin()
        );

        $dispatcher = new MvcDispatcher();

        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    };

CacheEnablerPluginはディスパッチャで実行された全てのアクションに割り込み、必要に応じてキャッシュを有効化します:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\User\Plugin;

    /**
     * Enables the cache for a view if the latest
     * executed action has the annotation @Cache
     */
    class CacheEnablerPlugin extends Plugin
    {
        /**
         * This event is executed before every route is executed in the dispatcher
         */
        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // 現在実行中のメソッドのアノテーションをパースする
            $annotations = $this->annotations->getMethod(
                $dispatcher->getControllerClass(),
                $dispatcher->getActiveMethod()
            );

            // メソッドに「Cache」というアノテーションがあるか確認する
            if ($annotations->has("Cache")) {
                // メソッドに「Cache」というアノテーションがある場合
                $annotation = $annotations->get("Cache");

                // キャッシュの有効期限を取得
                $lifetime = $annotation->getNamedParameter("lifetime");

                $options = [
                    "lifetime" => $lifetime,
                ];

                // ユーザーが定義したキャッシュのキーがあるか確認する
                if ($annotation->hasNamedParameter("key")) {
                    $options["key"] = $annotation->getNamedParameter("key");
                }

                // 現在のメソッドのキャッシュを有効にする
                $this->view->cache($options);
            }
        }
    }

これで、コントローラーでアノテーションを使えるようになりました:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class NewsController extends Controller
    {
        public function indexAction()
        {

        }

        /**
         * This is a comment
         *
         * @Cache(lifetime=86400)
         */
        public function showAllAction()
        {
            $this->view->article = Articles::find();
        }

        /**
         * This is a comment
         *
         * @Cache(key="my-key", lifetime=86400)
         */
        public function showAction($slug)
        {
            $this->view->article = Articles::findFirstByTitle($slug);
        }
    }

Private/Public areas with Annotations
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
You can use annotations to tell the ACL which controllers belong to the administrative areas:

.. code-block:: php

    <?php

    use Phalcon\Acl;
    use Phalcon\Acl\Role;
    use Phalcon\Acl\Resource;
    use Phalcon\Events\Event;
    use Phalcon\Mvc\User\Plugin;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Acl\Adapter\Memory as AclList;

    /**
     * This is the security plugin which controls that users only have access to the modules they're assigned to
     */
    class SecurityAnnotationsPlugin extends Plugin
    {
        /**
         * This action is executed before execute any action in the application
         *
         * @param Event $event
         * @param Dispatcher $dispatcher
         */
        public function beforeDispatch(Event $event, Dispatcher $dispatcher)
        {
            // Possible controller class name
            $controllerName = $dispatcher->getControllerClass();

            // Possible method name
            $actionName = $dispatcher->getActiveMethod();

            // Get annotations in the controller class
            $annotations = $this->annotations->get($controllerName);

            // The controller is private?
            if ($annotations->getClassAnnotations()->has("Private")) {
                // Check if the session variable is active?
                if (!$this->session->get("auth")) {

                    // The user is no logged redirect to login
                    $dispatcher->forward(
                        [
                            "controller" => "session",
                            "action"     => "login",
                        ]
                    );

                    return false;
                }
            }

            // Continue normally
            return true;
        }
    }

アノテーションアダプタ
----------------------
このコンポーネントはアダプタを利用して、パースした処理済みのアノテーションをキャッシュすることができ、パフォーマンスを向上させ開発・テストを便利にします:

+------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Class                                                                                    | Description                                                                                                                                                                       |
+==========================================================================================+===================================================================================================================================================================================+
| :doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>` | The annotations are cached only in memory. When the request ends the cache is cleaned reloading the annotations in each request. This adapter is suitable for a development stage |
+------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Annotations\\Adapter\\Files <../api/Phalcon_Annotations_Adapter_Files>`   | Parsed and processed annotations are stored permanently in PHP files improving performance. This adapter must be used together with a bytecode cache.                             |
+------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Annotations\\Adapter\\Apc <../api/Phalcon_Annotations_Adapter_Apc>`       | Parsed and processed annotations are stored permanently in the APC cache improving performance. This is the faster adapter                                                        |
+------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Annotations\\Adapter\\Xcache <../api/Phalcon_Annotations_Adapter_Xcache>` | Parsed and processed annotations are stored permanently in the XCache cache improving performance. This is a fast adapter too                                                     |
+------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

独自のアダプタを実装する
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Annotations\\AdapterInterface <../api/Phalcon_Annotations_AdapterInterface>` インターフェースを実装することで、独自のアノテーションアダプタを作成したり、既存のものを継承したりできます。

外部資料
------------------
* `Tutorial: Creating a custom model's initializer with Annotations <https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer>`_
