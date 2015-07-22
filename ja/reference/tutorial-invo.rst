チュートリアル 2: Introducing INVO
================================
この第2のチュートリアルでは、より完全なアプリケーションを例にして説明し、Phalconを使用した開発について理解を深めます。INVOは、私達が制作したサンプルアプリケーションの1つです。INVOは小さなWebサイトで、ユーザーは送り状（invoice）を生成したり、顧客や製品を管理したりといったタスクを行うことができます。コードは Github_ からクローンすることができます。

また、INVOのクライアントサイドは `Twitter Bootstrap`_ を使用して作られています。アプリケーションが送り状を生成しなくても、フレームワークの働きを理解するサンプルにはなります。

プロジェクト構造
------------------
ブラウザで http://localhost/invo にアクセスしてアプリケーションを開くと、以下のように表示されるでしょう:

.. code-block:: bash

    invo/
        app/
            app/config/
            app/controllers/
            app/library/
            app/models/
            app/plugins/
            app/views/
        public/
            public/bootstrap/
            public/css/
            public/js/
        schemas/

ご存知のように、Phalconはアプリケーション開発に際して特定の構造を強制しません。このプロジェクトはシンプルなMVC構造を持ち、publicディレクトリをドキュメントルートとします。

ブラウザで http://localhost/invo にアクセスしてアプリケーションを開くと、以下のように表示されるでしょう:

.. figure:: ../_static/img/invo-1.png
   :align: center

アプリケーションは2つの部分に分かれています。フロントエンドは公開されている部分で、訪問者はINVOの概要を知ったり、連絡を求めたりできます。もう一つはバックエンドで、管理用の領域です。登録されたユーザーが、製品や顧客を管理できます。

ルーティング
-------
INVOはRouterコンポーネントに組み込みの標準のルートを使用します。これらのルートは、 /:controller/:action/:params というパターンにマッチします。これは、URIの最初の部分がコントローラー、2番めの部分がアクション、残りがパラメーターになる、ということです。

/session/register というルートでは、SessionController コントローラの registerAction アクションが実行されます。

設定
-------------
INVOには、アプリケーションの一般的なパラメーターをセットする設定ファイルがあります。このファイルはブートストラップ (public/index.php) の最初の数行で読み込まれています:

.. code-block:: php

    <?php

    // 設定の読み込み
    $config = new Phalcon\Config\Adapter\Ini('../app/config/config.ini');

:doc:`Phalcon\\Config <config>` allows us to manipulate the file in an object-oriented way.
設定ファイルは以下の設定を含んでいます:

.. code-block:: ini

    [database]
    host     = localhost
    username = root
    password = secret
    name     = invo

    [application]
    controllersDir = /../app/controllers/
    modelsDir      = /../app/models/
    viewsDir       = /../app/views/
    pluginsDir     = /../app/plugins/
    libraryDir     = /../app/library/
    baseUri        = /invo/

    ;[metadata]
    ;adapter = "Apc"
    ;suffix = my-suffix
    ;lifetime = 3600

Phalconには、定義済みの慣習的な設定は全くありません。セクション名を付けておくと、オプションを適切に構成する助けになります。このファイルには3つのセクションが含まれ、後で使用されます。

オートローダ
-----------
ブートストラップファイル (public/index.php) の2番めのパートは、オートローダーです。オートローダーにディレクトリを登録すると、アプリケーションは、必要になったクラスを登録されたディレクトリ内で探します。

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        array(
            $config->application->controllersDir,
            $config->application->pluginsDir,
            $config->application->libraryDir,
            $config->application->modelsDir,
        )
    )->register();

上記コードでは、設定ファイルに定義されているディレクトリを登録していることに注意してください。viewsDirディレクトリだけは、登録しません。viewsDirにはHTMLファイルとPHPファイルが含まれますが、クラスは含まれていないからです。

リクエストの処理
--------------------
ファイルの最後まで飛ばすと、リクエストは最終的に Phalcon\\Mvc\\Application に処理されています。このクラスは、アプリケーションに必要な全ての初期化と処理の実行を行います:

.. code-block:: php

    <?php

    $app = new \Phalcon\Mvc\Application($di);

    echo $app->handle()->getContent();

依存性の注入 (Dependency Injection)
--------------------
上記コード例の1行目を見てください。 Application クラスのコンストラクタは、$di 変数を引数として受け取っています。この変数の目的は何でしょう？ Phalconは非常に分離された (decoupled) フレームワークなので、全てを協調して動作させる、接着剤としての役割を果たすコンポーネントが必要です。それは、 Phalcon\\DI です。これはサービスコンテナで、依存性の注入（Dependency Injection）や、アプリケーションに必要なコンポーネントの初期化も実行します。

コンテナにサービスを登録するには、様々な方法があります。INVOでは、ほとんどのサービスは無名関数を使って登録されています。このおかげで、オブジェクトは必要になるまでインスタンス化されないので、アプリケーションに必要なリソースが節約できます。

たとえば、以下の抜粋では、sessionサービスが登録されています。無名関数は、アプリケーションがsessionのデータへのアクセスを要求した時に初めて呼ばれます:

.. code-block:: php

    <?php

    // コンポーネントがsessionサービスを最初に要求した時に、セッションを開始する
    $di->set('session', function () {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

これで、アダプタを変更して、初期化処理を追加する等を自由に行えるようになりました。サービスは "session" という名前で登録されていることに注意してください。これは、フレームワークがサービスコンテナ内の有効なサービスを見分けるための慣習です。

リクエストは多数のサービスを利用する可能性があり、それらを1つずつ登録するのは面倒な作業です。そのため、Phalconは Phalcon\\DI\\FactoryDefault というPhalcon\\DI の別バージョンを用意しています。これには、フルスタックフレームワークのための全てのサービスを登録します。

.. code-block:: php

    <?php

    // FactoryDefault は、フルスタックフレームワークを
    // 提供するために必要なサービスを自動的に登録する
    $di = new \Phalcon\DI\FactoryDefault();

FactoryDefault はフレームワークが標準的に提供しているコンポーネントサービスの大部分を登録します。もし、サービス定義のオーバーライドが必要な場合、"session" を上で定義したのと同じように同じ名前で再度定義してください。以上が、$di 変数が存在する理由です。

.. _Github: https://github.com/phalcon/invo
.. _Twitter Bootstrap: http://twitter.github.io/bootstrap/
