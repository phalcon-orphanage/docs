URL とパスを生成する
=========================

:doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>` は Phalcon アプリケーションに置いて、URL 生成を担うコンポーネントです。
ルーティングをベースにした、個々の URL を生成する能力があります。

ベース URI の設定
------------------
アプリケーションをインストールしたドキュメントルートのディレクトリの状況に応じて、ベース URI が必要になる場合があります。

例えば、ドキュメントルートが /var/www/htdocs であなたのアプリケーションが /var/www/htdocs/invo にインストールしてある場合、ベース URI は /invo/ になります。
VirtualHost を使っていたり、またはドキュメントルート直下にインストールしている場合、ベース URI は / になります。
Phalcon が検出しているベース URI を確認するため、下記のコードを実行しましょう。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Url;

    $url = new Url();

    echo $url->getBaseUri();

Phalcon は、デフォルトでは自動的にベース URI を検出します。
しかしアプリケーションのパフォーマンスを向上させたい場合は、設定を手動で行うことを推奨しています。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Url;

    $url = new Url();

    // ベース URI を相対的に設定
    $url->setBaseUri("/invo/");

    // ベース URI としてフルドメインを指定する
    $url->setBaseUri("//my.domain.com/");

    // ベース URI としてフルドメインを指定する
    $url->setBaseUri("http://my.domain.com/my-app/");

通常、このコンポーネントは DI コンテナ内で登録されなければならないので、下記のように設定することもできます。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Url;

    $di->set(
        "url",
        function () {
            $url = new Url();

            $url->setBaseUri("/invo/");

            return $url;
        }
    );

URI の生成
---------------
もし、:doc:`ルーティング <routing>`のデフォルトの振る舞いを使用するならば、
あなたのアプリケーションのルーティングパターンは /:controller/:action/:params にすることができます。
従って、ルータ内部で定義しているあらゆるパターン含め、GET メソッドへ渡す文字列パターンも簡単に作ることができます。

.. code-block:: php

    <?php echo $url->get("products/save"); ?>

ベース URI を先頭につける必要が無いことに注意してください。名前をつけたルートであれば、動的に簡単に変更、作成ができます。
例えば、次のようなルートを持っていたとします。

.. code-block:: php

    <?php

    $router->add(
        "/blog/{year}/{month}/{title}",
        [
            "controller" => "posts",
            "action"     => "show",
        ]
    )->setName("show-post");

URL は次のような方法で生成することができます。

.. code-block:: php

    <?php

    // 結果は /blog/2015/01/some-blog-post となります
    $url->get(
        [
            "for"   => "show-post",
            "year"  => "2015",
            "month" => "01",
            "title" => "some-blog-post",
        ]
    );

mod_rewrite を使用せずに URL を生成する
------------------------------------
mod_rewrite を使用せずに URL を生成する場合も、このコンポーネントを使うことができます。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Url;

    $url = new Url();

    // $_GET["_url"] 内の URI を渡す
    $url->setBaseUri("/invo/index.php?_url=/");

    // 出力結果は /invo/index.php?_url=/products/save となります。
    echo $url->get("products/save");

この際、:code:`$_SERVER["REQUEST_URI"]` を使うことも可能です。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Url;

    $url = new Url();

    // $_GET["_url"] 内の URI を渡す
    $url->setBaseUri("/invo/index.php?_url=/");

    // $_SERVER["REQUEST_URI"] を使っ、マニュアルでハンドルが必要になります。て URI を渡す
    $url->setBaseUri("/invo/index.php/");

この場合、ルーター内で要求した URI をマニュアルで対処する必要があります。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    $router = new Router();

    // ... ルートをマニュアルで定義する

    $uri = str_replace($_SERVER["SCRIPT_NAME"], "", $_SERVER["REQUEST_URI"]);

    $router->handle($uri);

結果のルートは下記のようになります

.. code-block:: php

    <?php

    // 結果として /invo/index.php/products/save となります。
    echo $url->get("products/save");

Volt での URL の生成
------------------------
Volt 内部でこのコンポーネントを使って URL を生成するために url という関数を用意しています。

.. code-block:: html+jinja

    <a href="{{ url("posts/edit/1002") }}">Edit</a>

静的なルートが生成されます。

.. code-block:: html+jinja

    <link rel="stylesheet" href="{{ static_url("css/style.css") }}" type="text/css" />

静的な URI vs. 動的な URI
-----------------------
このコンポーネントは、同一アプリケーション内で異なるベース URI を設定することも許されています。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Url;

    $url = new Url();

    // 動的 URI
    $url->setBaseUri("/");

    // 静的リソースは CDN へ
    $url->setStaticBaseUri("http://static.mywebsite.com/");

:doc:`Phalcon\\Tag <tags>` は、このコンポーネントを使った動的・静的　URI の両方を要求します。

独自 URL ジェネレータの実装
-----------------------------------
Phalcon が提供している URL ジェネレータの代わりに独自で URL ジェネレータを作成する場合、 :doc:`Phalcon\\Mvc\\UrlInterface <../api/Phalcon_Mvc_UrlInterface>` インターフェースを必ず実装してください。
