ルーティング
============

ルーターによって、どのコントローラー又はハンドラーがリクエストを受け付けるべきか結びつけを行う、ルートの定義を行うことができます。ルーターはURIの文字列を解析して、この結びつきを決定します。ルーターには2つのモードがあります。MVCモードとマッチオンリーモードです。前者は、MVCのアプリケーションを扱うのに最適です。

ルーティングの定義
------------------
:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` は高度なルーティング機能を提供しています。MVCモードでは、ルートを定義して、それらを好きなコントローラー・アクションと結びつけることができます。ルートは、以下のように定義します：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // ルーターの初期化
    $router = new Router();

    // ルートの定義
    $router->add(
        "/admin/users/my-profile",
        [
            "controller" => "users",
            "action"     => "profile",
        ]
    );

    // 別のルートを定義
    $router->add(
        "/admin/users/change-password",
        [
            "controller" => "users",
            "action"     => "changePassword",
        ]
    );

    $router->handle();

add()メソッドは、第1引数にURIのパターン、第2引数にパスをとります。上記コード例では、URIが正確に「/admin/users/my-profile」であるとき、「users」コントローラーの「profile」アクションが実行されます。現在のバージョンのPhalconでは、ルーターはコントローラー・アクションを実行しません。ルーターは情報を収集して、コントローラー・アクションを実行する役割を持つコンポーネント(例： :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` )に渡しています。

アプリケーションには多くのパスがありうるため、ルートを1つずつ定義するのは大変です。このような場合、より柔軟なルートを作ることができます。

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // ルーターの初期化
    $router = new Router();

    // ルートの定義
    $router->add(
        "/admin/:controller/a/:action/:params",
        [
            "controller" => 1,
            "action"     => 2,
            "params"     => 3,
        ]
    );

上記コード例では、ワイルドカードを使って多くのURIで有効なルートを作っています。例えば、次のURL(/admin/users/a/delete/dave/301)でアクセスすると、コントローラーとパラメーターは以下の表のようになります。

+------------+---------------+
| Controller | users         |
+------------+---------------+
| Action     | delete        |
+------------+---------------+
| Parameter  | dave          |
+------------+---------------+
| Parameter  | 301           |
+------------+---------------+

add()メソッドは、定義済みのプレースホルダーや、正規表現の修飾子をパターンとして受け取ることもできます。全てのルーティングパターンは、スラッシュ(/)から始まらなければなりません。正規表現のシンタックスは、 `PCRE regular expressions`_ と同じです。正規表現のデリミタを付ける必要は無い点に注意してください。また、全てのルートパターンは、文字の大小を区別します。

第2引数は、マッチした部分がどのようにコントローラー・アクション・パラメーターと結び付けられるかを定義します。マッチする部分には、プレースホルダーと、括弧(丸括弧)によって区切られたサブパターンとがあります。前述したコード例では、最初のサブパターン(:controller)がルートのコントローラーの部分で、2番めがアクション、という具合になっています。

プレースホルダーは、読みやすく理解しやすい正規表現を書く助けになります。以下のプレースホルダーがサポートされています：

+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| Placeholder          | Regular Expression          | Usage                                                                                                  |
+======================+=============================+========================================================================================================+
| :code:`/:module`     | :code:`/([a-zA-Z0-9\_\-]+)` | Matches a valid module name with alpha-numeric characters only                                         |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:controller` | :code:`/([a-zA-Z0-9\_\-]+)` | Matches a valid controller name with alpha-numeric characters only                                     |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:action`     | :code:`/([a-zA-Z0-9\_]+)`   | Matches a valid action name with alpha-numeric characters only                                         |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:params`     | :code:`(/.*)*`              | Matches a list of optional words separated by slashes. Only use this placeholder at the end of a route |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:namespace`  | :code:`/([a-zA-Z0-9\_\-]+)` | Matches a single level namespace name                                                                  |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+
| :code:`/:int`        | :code:`/([0-9]+)`           | Matches an integer parameter                                                                           |
+----------------------+-----------------------------+--------------------------------------------------------------------------------------------------------+

コントローラーの名前はキャメルケースに変換されます。ハイフン(-)とアンダースコア(_)は取り除かれ、次の文字が大文字になります。例えば、 some_controller は SomeController に変換されます。

add() メソッドを使うことで好きなだけルートを追加することができるため、ルートが追加された順番が関連性を示します。後で追加されたルートの方が優先して適用されます。内部的には、全ての定義済みルートは、追加された順番とは逆順にマッチングが行われ、 :doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` が与えられたURIに適合するルートを見つけると、残りは無視されます。

名前付きパラメータ
^^^^^^^^^^^^^^^^^^^^^
以下の例では、ルートパラメーターの名前を定義する方法を示しています:

.. code-block:: php

    <?php

    $router->add(
        "/news/([0-9]{4})/([0-9]{2})/([0-9]{2})/:params",
        [
            "controller" => "posts",
            "action"     => "show",
            "year"       => 1, // ([0-9]{4})
            "month"      => 2, // ([0-9]{2})
            "day"        => 3, // ([0-9]{2})
            "params"     => 4, // :params
        ]
    );

上の例では、ルートは "controller" や "action" の部分を含みません。これらは、固定された値( "posts" と "show" )に置き換えられています。リクエストによってどのコントローラーに実際に処理が割り当てられるかは、ユーザーにはわかりません。コントローラーの内部では、名前付きパラメーターに以下のようにしてアクセスできます:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction()
        {
            // "year" のパラメーターを返す
            $year = $this->dispatcher->getParam("year");

            // "month" のパラメーターを返す
            $month = $this->dispatcher->getParam("month");

            // "day" のパラメーターを返す
            $day = $this->dispatcher->getParam("day");

            // ...
        }
    }

パラメーターの値は、ディスパッチャから取得する点に注意してください。なぜこのようになっているかというと、ディスパッチャがアプリケーションのドライバと最後にやりとりするコンポーネントだからです。さらに、名前付きパラメーターを作成する方法がもう一つあります:

.. code-block:: php

    <?php

    $router->add(
        "/documentation/{chapter}/{name}.{type:[a-z]+}",
        [
            "controller" => "documentation",
            "action"     => "show",
        ]
    );

これらの値には、前述したのと同じ方法でアクセスできます:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class DocumentationController extends Controller
    {
        public function showAction()
        {
            // "name" のパラメーターを返す
            $name = $this->dispatcher->getParam("name");

            // "type" のパラメーターを返す
            $type = $this->dispatcher->getParam("type");

            // ...
        }
    }

短縮記法
^^^^^^^^^^^^
ルートパスを定義するのに配列を使いたくない場合、別の記法も利用できます。以下の例は、いずれの書き方でも同じ結果になります:

.. code-block:: php

    <?php

    // 短い書き方
    $router->add(
        "/posts/{year:[0-9]+}/{title:[a-z\-]+}",
        "Posts::show"
    );

    // 配列を使う書き方
    $router->add(
        "/posts/([0-9]+)/([a-z\-]+)",
        [
           "controller" => "posts",
           "action"     => "show",
           "year"       => 1,
           "title"      => 2,
        ]
    );

配列と短縮記法の混合
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
配列と短縮記法を混ぜてルートを定義することもできます。この場合、名前付きパラメーターは、それが定義された順番に合わせて自動的にルートのパスに追加されることに注意してください:

.. code-block:: php

    <?php

    // 'country' という名前付きパラメーターが使用されているため
    // 1番目のパラメーターは使用してはならない
    $router->add(
        "/news/{country:[a-z]{2}}/([a-z+])/([a-z\-+])",
        [
            "section" => 2, // 連番は2から始める
            "article" => 3,
        ]
    );

モジュールへのルーティング
^^^^^^^^^^^^^^^^^^^^^^^^^^
モジュールを含んだルートを定義することができます。これは、複数モジュール構成のアプリケーションに、特に適しています。モジュールのワイルドカードを含んだデフォルトルートを定義することもできます:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    $router = new Router(false);

    $router->add(
        "/:module/:controller/:action/:params",
        [
            "module"     => 1,
            "controller" => 2,
            "action"     => 3,
            "params"     => 4,
        ]
    );

この場合、ルートは必ずURLの一部にモジュール名を含まなければなりません。例えば、 /admin/users/edit/sonny のようなURLです。これは、以下のように処理されます：

+------------+---------------+
| Module     | admin         |
+------------+---------------+
| Controller | users         |
+------------+---------------+
| Action     | edit          |
+------------+---------------+
| Parameter  | sonny         |
+------------+---------------+

あるいは、特定のルートに特定のモジュールを紐付けることもできます:

.. code-block:: php

    <?php

    $router->add(
        "/login",
        [
            "module"     => "backend",
            "controller" => "login",
            "action"     => "index",
        ]
    );

    $router->add(
        "/products/:action",
        [
            "module"     => "frontend",
            "controller" => "products",
            "action"     => 1,
        ]
    );

また、特定の名前空間に紐付けることもできます:

.. code-block:: php

    <?php

    $router->add(
        "/:namespace/login",
        [
            "namespace"  => 1,
            "controller" => "login",
            "action"     => "index",
        ]
    );

名前空間とクラス名は、別々に渡す必要があります:

.. code-block:: php

    <?php

    $router->add(
        "/login",
        [
            "namespace"  => "Backend\\Controllers",
            "controller" => "login",
            "action"     => "index",
        ]
    );

HTTP メソッドの制限
^^^^^^^^^^^^^^^^^^^^^^^^
単に add() を使ってルートを追加した場合、ルートは全てのHTTPメソッドで有効になります。ルートを特定のメソッドだけに制限することも可能で、RESTful APIを持つアプリケーションを作る際には特に便利です:

.. code-block:: php

    <?php

    // HTTPメソッドがGETの場合にだけマッチ
    $router->addGet(
        "/products/edit/{id}",
        "Products::edit"
    );

    // HTTPメソッドがPOSTの場合だけマッチ
    $router->addPost(
        "/products/save",
        "Products::save"
    );

    // HTTPメソッドがPOST又はPUTの場合にだけマッチ
    $router->add(
        "/products/update",
        "Products::update"
    )->via(
        [
            "POST",
            "PUT",
        ]
    );

convertの使用
^^^^^^^^^^^^^^^^^
convertメソッドを使うことで、ルートパラメーターを、ディスパッチャに渡される前に自由に変換することができます。以下の例で使い方を示します:

.. code-block:: php

    <?php

    // アクションの名前にはダッシュが許可されているので、アクションは次のようになる: /products/new-ipod-nano-4-generation
    $route = $router->add(
        "/products/{slug:[a-z\-]+}",
        [
            "controller" => "products",
            "action"     => "show",
        ]
    );

    $route->convert(
        "slug",
        function ($slug) {
            // ダッシュを取り除く
            return str_replace("-", "", $slug);
        }
    );

Another use case for conversors is binding a model into a route. This allows the model to be passed into the defined action directly:

.. code-block:: php

    <?php

    // This example works off the assumption that the ID is being used as parameter in the url: /products/4
    $route = $router->add(
        "/products/{id}",
        [
            "controller" => "products",
            "action"     => "show",
        ]
    );

    $route->convert(
        "id",
        function ($id) {
            // Fetch the model
            return Product::findFirstById($id);
        }
    );

ルートのグループ
^^^^^^^^^^^^^^^^
ルートのセットが共通のパスを持っている場合、グループ化してメンテナンスを簡単にすることができます:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;
    use Phalcon\Mvc\Router\Group as RouterGroup;

    $router = new Router();

    // 共通のモジュールとコントローラーのグループを作る
    $blog = new RouterGroup(
        [
            "module"     => "blog",
            "controller" => "index",
        ]
    );

    // /blog から始まる全てのルート
    $blog->setPrefix("/blog");

    // ルートをグループに追加する
    $blog->add(
        "/save",
        [
            "action" => "save",
        ]
    );

    // もう一つルートをグループに追加する
    $blog->add(
        "/edit/{id}",
        [
            "action" => "edit",
        ]
    );

    // このルートはデフォルトとは異なるルートにマッピングする
    $blog->add(
        "/blog",
        [
            "controller" => "blog",
            "action"     => "index",
        ]
    );

    // グループをルーターに追加
    $router->mount($blog);

ルートのグループを別のファイルに分割して、アプリケーションの構造化とコードの再利用をしやすくする:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router\Group as RouterGroup;

    class BlogRoutes extends RouterGroup
    {
        public function initialize()
        {
            // デフォルトパス
            $this->setPaths(
                [
                    "module"    => "blog",
                    "namespace" => "Blog\\Controllers",
                ]
            );

            // All the routes start with /blog
            $this->setPrefix("/blog");

            // Add a route to the group
            $this->add(
                "/save",
                [
                    "action" => "save",
                ]
            );

            // Add another route to the group
            $this->add(
                "/edit/{id}",
                [
                    "action" => "edit",
                ]
            );

            // This route maps to a controller different than the default
            $this->add(
                "/blog",
                [
                    "controller" => "blog",
                    "action"     => "index",
                ]
            );
        }
    }

ルーターにグループをマウントする

.. code-block:: php

    <?php

    // Add the group to the router
    $router->mount(
        new BlogRoutes()
    );

ルートのマッチ
---------------
ルートが与えられたURIにマッチするかチェックするため、有効なURIがルーターに渡されなければなりません。デフォルトでは、ルーティングURIは、サーバのリライトエンジンモジュールが作成する :code:`$_GET['_url']` 変数から取得されます。以下は、Phalconと一緒に上手く動作するリライトルールの組み合わせです:

.. code-block:: apacheconf

    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]

以下は、ルーターコンポーネントを単独で使用する方法です:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // ルーターオブジェクトを作る
    $router = new Router();

    // ルートを何か定義する
    // ...

    // $_GET["_url"] からURIを取得
    $router->handle();

    // あるいは、URIの値を直接セットする
    $router->handle("/employees/edit/17");

    // マッチしたコントローラー名を取得
    echo $router->getControllerName();

    // マッチしたアクション名を取得
    echo $router->getActionName();

    // マッチしたルートを取得
    $route = $router->getMatchedRoute();

名前付きルート
--------------
ルーターに追加された個々のルートは、 :doc:`Phalcon\\Mvc\\Router\\Route <../api/Phalcon_Mvc_Router_Route>` オブジェクトとして内部に保持されます。このクラスは、それぞれのルートの詳細をカプセル化します。たとえば、パスに名前を付けて、アプリケーション内で一意に識別可能なようにできます。これは、ルートを元にURLを作りたいときには特に便利です。

.. code-block:: php

    <?php

    $route = $router->add(
        "/posts/{year}/{title}",
        "Posts::show"
    );

    $route->setName("show-posts");

次に、例えば :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>` コンポーネントを使って、名前からルートを組み立てることができます:

.. code-block:: php

    <?php

    // /posts/2012/phalcon-1-0-released を返す
    echo $url->get(
        [
            "for"   => "show-posts",
            "year"  => "2012",
            "title" => "phalcon-1-0-released",
        ]
    );

使用例
--------------
以下は、カスタマイズしたルートの使用例です:

.. code-block:: php

    <?php

    // "/system/admin/a/edit/7001" にマッチ
    $router->add(
        "/system/:controller/a/:action/:params",
        [
            "controller" => 1,
            "action"     => 2,
            "params"     => 3,
        ]
    );

    // "/es/news" にマッチ
    $router->add(
        "/([a-z]{2})/:controller",
        [
            "controller" => 2,
            "action"     => "index",
            "language"   => 1,
        ]
    );

    // "/es/news" にマッチ
    $router->add(
        "/{language:[a-z]{2}}/:controller",
        [
            "controller" => 2,
            "action"     => "index",
        ]
    );

    // "/admin/posts/edit/100" にマッチ
    $router->add(
        "/admin/:controller/:action/:int",
        [
            "controller" => 1,
            "action"     => 2,
            "id"         => 3,
        ]
    );

    // "/posts/2015/02/some-cool-content" にマッチ
    $router->add(
        "/posts/([0-9]{4})/([0-9]{2})/([a-z\-]+)",
        [
            "controller" => "posts",
            "action"     => "show",
            "year"       => 1,
            "month"      => 2,
            "title"      => 4,
        ]
    );

    // "/manual/en/translate.adapter.html" にマッチ
    $router->add(
        "/manual/([a-z]{2})/([a-z\.]+)\.html",
        [
            "controller" => "manual",
            "action"     => "show",
            "language"   => 1,
            "file"       => 2,
        ]
    );

    // /feed/fr/le-robots-hot-news.atom にマッチ
    $router->add(
        "/feed/{lang:[a-z]+}/{blog:[a-z\-]+}\.{type:[a-z\-]+}",
        "Feed::get"
    );

    // /api/v1/users/peter.json にマッチ
    $router->add(
        "/api/(v1|v2)/{method:[a-z]+}/{param:[a-z]+}\.(json|xml)",
        [
            "controller" => "api",
            "version"    => 1,
            "format"     => 4,
        ]
    );

.. highlights::

    Beware of characters allowed in regular expression for controllers and namespaces. As these
    become class names and in turn they're passed through the file system could be used by attackers to
    read unauthorized files. A safe regular expression is: :code:`/([a-zA-Z0-9\_\-]+)`

デフォルトの振る舞い
--------------------
:doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>` には、とてもシンプルなルーティングを提供するデフォルトの振る舞いがあります。これは、次のパターンのURIにマッチします: /:controller/:action/:params

たとえば、 *http://phalconphp.com/documentation/show/about.html* のようなURLは、以下のように解釈されます:

+------------+---------------+
| Controller | documentation |
+------------+---------------+
| Action     | show          |
+------------+---------------+
| Parameter  | about.html    |
+------------+---------------+

このルートをアプリケーションのデフォルトとして使用したくない場合は、ルータを作る際にfalseを渡す必要があります:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // デフォルトルートなしのルーターを作る
    $router = new Router(false);

デフォルトルートを設定する
--------------------------
アプリケーションがルート無しでアクセスされた場合、'/' ルートが使われ、サイト・アプリケーションの最初のページが決まります:

.. code-block:: php

    <?php

    $router->add(
        "/",
        [
            "controller" => "index",
            "action"     => "index",
        ]
    );

Not Found パス
---------------
ルーターの中のどのルートにもマッチしなかった場合に使用される、パスのグループを定義することができます:

.. code-block:: php

    <?php

    // 404のパスをセット
    $router->notFound(
        [
            "controller" => "index",
            "action"     => "route404",
        ]
    );

デフォルトパスの設定
---------------------
モジュール、コントローラー、アクションといった共通のパスのデフォルトを定義することができます。ルートがいずれのパスにもマッチしない場合、デフォルトの値がルーターによって自動的に使用されます:

.. code-block:: php

    <?php

    // デフォルト設定
    $router->setDefaultModule("backend");
    $router->setDefaultNamespace("Backend\\Controllers");
    $router->setDefaultController("index");
    $router->setDefaultAction("index");

    // 配列の使用
    $router->setDefaults(
        [
            "controller" => "index",
            "action"     => "index",
        ]
    );

余分なスラッシュの扱い
-----------------------------------
ルートの末尾に余分なスラッシュを付けてアクセスされることがあります。余分なスラッシュがあると、ルートにマッチせずディスパッチャーの中でNot Foundの状態になります。ルートの末尾のスラッシュを自動的に取り除くよう、ルーターを設定することができます:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    $router = new Router();

    // 末尾のスラッシュを自動的に取り除く
    $router->removeExtraSlashes(true);

あるいは、特定のルートだけ選んで、末尾のスラッシュを受け入れるように変更することもできます:

.. code-block:: php

    <?php

    // The [/]{0,1} allows this route to have optionally have a trailing slash
    $router->add(
        "/{language:[a-z]{2}}/:controller[/]{0,1}",
        [
            "controller" => 2,
            "action"     => "index",
        ]
    );

マッチングのコールバック
------------------------
ルートが特定の条件に合致しなければならない場合、 'beforeMatch' コールバックを使うことで、任意の条件をルートに追加することができます。この関数が false を返すと、ルートがマッチしなかったという扱いになります:

.. code-block:: php

    <?php

    $route = $router->add("/login",
        [
            "module"     => "admin",
            "controller" => "session",
        ]
    );

    $route->beforeMatch(
        function ($uri, $route) {
            // リクエストがAjaxによって生成されたかチェック
            if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest") {
                return false;
            }

            return true;
        }
    );

追加条件は、クラスにすることで再利用できます:

.. code-block:: php

    <?php

    class AjaxFilter
    {
        public function check()
        {
            return $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest";
        }
    }

そして、無名関数の代わりに、このクラスを使います:

.. code-block:: php

    <?php

    $route = $router->add(
        "/get/info/{id}",
        [
            "controller" => "products",
            "action"     => "info",
        ]
    );

    $route->beforeMatch(
        [
            new AjaxFilter(),
            "check"
        ]
    );

As of Phalcon 3, there is another way to check this:

.. code-block:: php

    <?php

    $route = $router->add(
        "/login",
        [
            "module"     => "admin",
            "controller" => "session",
        ]
    );

    $route->beforeMatch(
        function ($uri, $route) {
            /**
             * @var string $uri
             * @var \Phalcon\Mvc\Router\Route $route
             * @var \Phalcon\DiInterface $this
             * @var \Phalcon\Http\Request $request
             */
            $request = $this->getShared("request");

            // Check if the request was made with Ajax
            return $request->isAjax();
        }
    );

ホスト名によるアクセス制限
--------------------------
ルーターには、ホスト名による制約を付けることもできます。これは、特定のルートや、ルートのグループに対して、ホスト名の制約にマッチした場合にのみに制限することができる、ということです:

.. code-block:: php

    <?php

    $route = $router->add(
        "/login",
        [
            "module"     => "admin",
            "controller" => "session",
            "action"     => "login",
        ]
    );

    $route->setHostName("admin.company.com");

ホスト名は正規表現にすることもできます:

.. code-block:: php

    <?php

    $route = $router->add(
        "/login",
        [
            "module"     => "admin",
            "controller" => "session",
            "action"     => "login",
        ]
    );

    $route->setHostName("([a-z]+).company.com");

ルートのグループの中で、グループの全てのルートに適用されるホスト名の制限を設定することもできます:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router\Group as RouterGroup;

    // Create a group with a common module and controller
    $blog = new RouterGroup(
        [
            "module"     => "blog",
            "controller" => "posts",
        ]
    );

    // ホスト名制限
    $blog->setHostName("blog.mycompany.com");

    // All the routes start with /blog
    $blog->setPrefix("/blog");

    // デフォルトルート
    $blog->add(
        "/",
        [
            "action" => "index",
        ]
    );

    // Add a route to the group
    $blog->add(
        "/save",
        [
            "action" => "save",
        ]
    );

    // Add another route to the group
    $blog->add(
        "/edit/{id}",
        [
            "action" => "edit",
        ]
    );

    // Add the group to the router
    $router->mount($blog);

URIのソース
-----------
デフォルトでは、URIの情報は :code:`$_GET['_url']` から取得します。この情報は、リライトエンジンからPhalconに渡されます。必要であれば、 :code:`$_SERVER['REQUEST_URI']` を使用することもできます:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // ...

    // $_GET["_url"] を使う(デフォルト)
    $router->setUriSource(
        Router::URI_SOURCE_GET_URL
    );

    // $_SERVER["REQUEST_URI"] を使う
    $router->setUriSource(
        Router::URI_SOURCE_SERVER_REQUEST_URI
    );

あるいは、自分で 'handle' メソッドにURIを渡すこともできます:

.. code-block:: php

    <?php

    $router->handle("/some/route/to/handle");

ルートのテスト
-------------------
このコンポーネントには依存が無いので、以下のようなファイルを作成してルートのテストをすることができます:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    // これらのルートによって、実際のURIをシミュレートする
    $testRoutes = [
        "/",
        "/index",
        "/index/index",
        "/index/test",
        "/products",
        "/products/index/",
        "/products/show/101",
    ];

    $router = new Router();

    // ここで独自のルートを追加
    // ...

    // それぞれのルートをテスト
    foreach ($testRoutes as $testRoute) {
        // ルートの処理
        $router->handle($testRoute);

        echo "Testing ", $testRoute, "<br>";

        // ルートがマッチしたかチェック
        if ($router->wasMatched()) {
            echo "Controller: ", $router->getControllerName(), "<br>";
            echo "Action: ", $router->getActionName(), "<br>";
        } else {
            echo "The route wasn't matched by any route<br>";
        }

        echo "<br>";
    }

アノテーションによるルーター
----------------------------
ルーターは、 :doc:`annotations <annotations>` サービスと統合されたルーティングの定義方法も提供します。この方法を使用することで、サービスに登録することなく、ルートを直接コントローラーに書くことができます:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

    $di["router"] = function () {
        // アノテーションルーターを使う
        $router = new RouterAnnotations(false);

        // URIが /api/products から始まるときは、 ProductsController からアノテーションを読み取る
        $router->addResource("Products", "/api/products");

        return $router;
    };

アノテーションは以下のように定義できます:

.. code-block:: php

    <?php

    /**
     * @RoutePrefix("/api/products")
     */
    class ProductsController
    {
        /**
         * @Get(
         *     "/"
         * )
         */
        public function indexAction()
        {

        }

        /**
         * @Get(
         *     "/edit/{id:[0-9]+}",
         *     name="edit-robot"
         * )
         */
        public function editAction($id)
        {

        }

        /**
         * @Route(
         *     "/save",
         *     methods={"POST", "PUT"},
         *     name="save-robot"
         * )
         */
        public function saveAction()
        {

        }

        /**
         * @Route(
         *     "/delete/{id:[0-9]+}",
         *     methods="DELETE",
         *     conversors={
         *         id="MyConversors::checkId"
         *     }
         * )
         */
        public function deleteAction($id)
        {

        }

        public function infoAction($id)
        {

        }
    }

有効なアノテーションでマーキングされたメソッドだけが、ルートとして使われます。サポートされているアノテーションのリストは以下です:

+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Name         | Description                                                                                       | Usage                                                                      |
+==============+===================================================================================================+============================================================================+
| RoutePrefix  | A prefix to be prepended to each route URI. This annotation must be placed at the class' docblock | :code:`@RoutePrefix("/api/products")`                                      |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Route        | This annotation marks a method as a route. This annotation must be placed in a method docblock    | :code:`@Route("/api/products/show")`                                       |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Get          | This annotation marks a method as a route restricting the HTTP method to GET                      | :code:`@Get("/api/products/search")`                                       |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Post         | This annotation marks a method as a route restricting the HTTP method to POST                     | :code:`@Post("/api/products/save")`                                        |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Put          | This annotation marks a method as a route restricting the HTTP method to PUT                      | :code:`@Put("/api/products/save")`                                         |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Delete       | This annotation marks a method as a route restricting the HTTP method to DELETE                   | :code:`@Delete("/api/products/delete/{id}")`                               |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Options      | This annotation marks a method as a route restricting the HTTP method to OPTIONS                  | :code:`@Option("/api/products/info")`                                      |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+

ルートを追加するアノテーションのため、以下のパラメーターがサポートされています:

+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Name         | Description                                                                                       | Usage                                                                      |
+==============+===================================================================================================+============================================================================+
| methods      | Define one or more HTTP method that route must meet with                                          | :code:`@Route("/api/products", methods={"GET", "POST"})`                   |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| name         | Define a name for the route                                                                       | :code:`@Route("/api/products", name="get-products")`                       |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| paths        | An array of paths like the one passed to :code:`Phalcon\Mvc\Router::add()`                        | :code:`@Route("/posts/{id}/{slug}", paths={module="backend"})`             |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| conversors   | A hash of conversors to be applied to the parameters                                              | :code:`@Route("/posts/{id}/{slug}", conversors={id="MyConversor::getId"})` |
+--------------+---------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+

ルートがモジュール内のコントローラーにマッピングされる場合、 addModuleResource メソッドを使うと良いでしょう:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

    $di["router"] = function () {
        // Use the annotations router
        $router = new RouterAnnotations(false);

        // URIが /api/products から始まる場合、 Backend\Controllers\ProductsController からアノテーションを読み取る
        $router->addModuleResource("backend", "Products", "/api/products");

        return $router;
    };

ルーターインスタンスの登録
---------------------------
PhalconのDIコンテナへのサービス登録の際、ルーターを登録することで、ルーターをコントローラーの中で利用できるようになります。以下のコードをブートストラップファイル (例： index.php 、又は `Phalcon Developer Tools <http://phalconphp.com/en/download/tools>`_ を使っている場合 app/config/services.php) に追加する必要があります。

.. code-block:: php

    <?php

    /**
     * Add routing capabilities
     */
    $di->set(
        "router",
        function () {
            require __DIR__ . "/../app/config/routes.php";

            return $router;
        }
    );

app/config/routes.php を作って、以下のような初期化コードを追加します:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;

    $router = new Router();

    $router->add(
        "/login",
        [
            "controller" => "login",
            "action"     => "index",
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

独自ルータの実装
----------------------------
独自ルーターを作ってPhalconのルーターを置き換える場合、 :doc:`Phalcon\\Mvc\\RouterInterface <../api/Phalcon_Mvc_RouterInterface>` インターフェイスを実装する必要があります。

.. _PCRE regular expressions: http://www.php.net/manual/en/book.pcre.php
