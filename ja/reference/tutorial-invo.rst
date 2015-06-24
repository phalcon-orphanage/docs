チュートリアル 2: INVOについて説明します
===========================
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

    //設定の読み込み
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

    //コンポーネントがsessionサービスを最初に要求した時に、セッションを開始する
    $di->set('session', function() {
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

アプリケーションへのログイン
------------------------
ログイン機能によって、バックエンドのコントローラーに取り組むことができるようになります。バックエンドとフロントエンドのコントローラーの分割は、論理上のものです。全てのコントローラーは、同じディレクトリ (app/controllers/) に含まれています。

システムに入るために、ユーザーは有効なユーザー名とパスワードを持っている必要があります。ユーザーは "invo" データベースの "users" テーブルに保存されます。

セッションを開始する前に、アプリケーションがデータベースに接続できるよう設定する必要があります。接続情報を持った "db" という名前のサービスが、サービスコンテナ内で用意されます。オートローダーと同様、サービスを設定するための情報は設定ファイルから取得します:

.. code-block:: php

    <?php

    // 設定ファイルに定義されたパラメーターに基いてデータベース接続が作成される
    $di->set('db', function() use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->name
        ));
    });

ここで、MySQL接続アダプタのインスタンスを返しています。ロガーやプロファイラの追加、アダプタの変更等が必要であれば、それらの処理を追加することもできます。

以下の簡単なフォーム (app/views/session/index.phtml) では、ユーザーにログイン情報を求めています。サンプルを簡潔にするため、いくつかのHTMLコードは省いています:

.. code-block:: html+php

    <?php echo $this->tag->form('session/start') ?>

        <label for="email">Username/Email</label>
        <?php echo $this->tag->textField(array("email", "size" => "30")) ?>

        <label for="password">Password</label>
        <?php echo $this->tag->passwordField(array("password", "size" => "30")) ?>

        <?php echo $this->tag->submitButton(array('Login')) ?>

    </form>

SessionController::startAction (app/controllers/SessionController.php) が、フォームに入力されたデータのバリデーションを行います。これには、データベース内の有効なユーザーかの確認も含まれます:

.. code-block:: php

    <?php

    class SessionController extends ControllerBase
    {

        // ...

        private function _registerSession($user)
        {
            $this->session->set('auth', array(
                'id' => $user->id,
                'name' => $user->name
            ));
        }

        public function startAction()
        {
            if ($this->request->isPost()) {

                //POSTで送信された変数を受け取る
                $email = $this->request->getPost('email', 'email');
                $password = $this->request->getPost('password');

                $password = sha1($password);

                //データベースからユーザーを検索
                $user = Users::findFirst(array(
                    "email = :email: AND password = :password: AND active = 'Y'",
                    "bind" => array('email' => $email, 'password' => $password)
                ));
                if ($user != false) {

                    $this->_registerSession($user);

                    $this->flash->success('Welcome ' . $user->name);

                    //ユーザーが有効なら、'invoices' コントローラーに転送する
                    return $this->dispatcher->forward(array(
                        'controller' => 'invoices',
                        'action' => 'index'
                    ));
                }

                $this->flash->error('Wrong email/password');
            }

            //ログインフォームへ再度転送
            return $this->dispatcher->forward(array(
                'controller' => 'session',
                'action' => 'index'
            ));

        }

    }

簡単にするため、 データベースに保存するパスワードハッシュに "sha1_" を使用していますが、このアルゴリズムは実際のアプリケーションでは推奨されません。代わりに、 ":doc:`bcrypt <security>`" を使ってください。

コントローラー内で $this->flash、$this->request、$this->session のようなpublic属性へのアクセスに注目してください。これらは、サービスコンテナであらかじめ定義したサービスです。初めてアクセスされたとき、コントローラーの一部として注入が行われます。

これらのサービスは共有されているため、これらのオブジェクトをどこから呼び出しても、常に同じインスタンスにアクセスすることになります。

例えば、ここで "session" サービスを呼び出して、ユーザーを識別する情報を "auth" という変数に保存しています:

.. code-block:: php

    <?php

    $this->session->set('auth', array(
        'id' => $user->id,
        'name' => $user->name
    ));

バックエンドのセキュリティ保護
--------------------
バックエンドは登録されたユーザーだけがアクセスできるプライベートな領域です。したがって、登録されたユーザーだけがそれらのコントローラーにアクセスできるようチェックする必要があります。たとえば、ログインせずに products コントローラー (プライベート領域) にアクセスしようとすると、以下のように表示されるはずです:

.. figure:: ../_static/img/invo-2.png
   :align: center

コントローラー・アクションにアクセスしようとしたときにはいつでも、アプリケーションは現在のロール (セッションに含まれる) が、アクセス権を持っているか確認します。アクセス権がない場合は、上のようなメッセージを表示し、インデックスページに遷移させます。

次に、アプリケーションがこの動きをどのように実現しているか見ていきましょう。最初に知るべきは、:doc:`Dispatcher <dispatching>` コンポーネントです。これは、 :doc:`Routing <routing>` コンポーネントによって発見されたルートの情報を受け取ります。次に、適切なコントローラーを読み込んで、対応するアクションのメソッドを実行します。

通常、フレームワークはディスパッチャを自動的に作成します。今回は、要求されたアクションを実行する前に、認証を行い、ユーザーがアクセスできるか否かチェックする必要があります。これを実現するため、ブートストラップの中に関数を用意して、ディスパッチャを置き換えています:

.. code-block:: php

    <?php

    $di->set('dispatcher', function() use ($di) {
        $dispatcher = new Phalcon\Mvc\Dispatcher();
        return $dispatcher;
    });

これで、アプリケーションで使用されるディスパッチャを完全に制御できるようになりました。フレーワークの多くのコンポーネントはイベントを発火するので、内部の処理の流れを変更することができます。DIコンポーネントが接着剤として機能し、 :doc:`EventsManager <events>` がコンポーネントが生み出すイベントをインターセプトし、イベントをリスナーに通知します。

イベント管理
^^^^^^^^^^^^^^^^^
:doc:`EventsManager <events>` によって、特定のタイプのイベントにリスナーを割り当てることができます。今、私達が取り組んでいるイベントのタイプは "dispatch" です。以下のコードは、ディスパッチャによって生成される全てのイベントをフィルタリングしています:

.. code-block:: php

    <?php

    $di->set('dispatcher', function() use ($di) {

        //標準のイベントマネージャーをDIから取得
        $eventsManager = $di->getShared('eventsManager');

        //Securityプラグインをインスタンス化
        $security = new Security($di);

        //Securityプラグインを使用して、ディスパッチャが生成するイベントを監視する
        $eventsManager->attach('dispatch', $security);

        $dispatcher = new Phalcon\Mvc\Dispatcher();

        //イベントマネージャーをディスパッチャに束縛する
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

Securityプラグインは (app/plugins/Security.php) にあるクラスです。このクラスは "beforeDispatch" メソッドを実装しています。これは、ディスパッチャーが生成するイベントの1つと同じ名前です:

.. code-block:: php

    <?php

    use Phalcon\Events\Event,
	    Phalcon\Mvc\User\Plugin,
	    Phalcon\Mvc\Dispatcher,
	    Phalcon\Acl;

    class Security extends Plugin
    {

        // ...

        public function beforeDispatch(Event $event, Dispatcher $dispatcher)
        {
            // ...
        }

    }

フックイベントは常に2つの引数を取ります。第1引数はイベントが生成されたコンテキストの情報($event) で、第2引数はイベントを生成したオブジェクト自身 ($dispatcher) です。プラグインが Phalcon\\Mvc\\User\\Plugin を継承することは必須ではありませんが、継承することでアプリケーションのサービスに簡単にアクセスできるようになります。

ACLリストを使用してユーザーがアクセス権を持つかチェックすることで、現在のセッションのロールを検証するようになりました。ユーザーがアクセス権を持たない場合、前述したように最初のページにリダイレクトされます:

.. code-block:: php

    <?php

    use Phalcon\Events\Event,
	    Phalcon\Mvc\User\Plugin,
	    Phalcon\Mvc\Dispatcher,
	    Phalcon\Acl;

    class Security extends Plugin
    {

        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {

            //ロールを定義するため、セッションに "auth" 変数があるかチェックする
            $auth = $this->session->get('auth');
            if (!$auth) {
                $role = 'Guests';
            } else {
                $role = 'Users';
            }

            //ディスパッチャからアクティブなコントローラー名とアクション名を取得する
            $controller = $dispatcher->getControllerName();
            $action = $dispatcher->getActionName();

            //ACLリストを取得
            $acl = $this->getAcl();

            //ロールがコントローラー (又はリソース) にアクセス可能かチェックする
            $allowed = $acl->isAllowed($role, $controller, $action);
            if ($allowed != Acl::ALLOW) {

                //アクセス権が無い場合、indexコントローラーに転送する
                $this->flash->error("You don't have access to this module");
                $dispatcher->forward(
                    array(
                        'controller' => 'index',
                        'action' => 'index'
                    )
                );

                //"false" を返し、ディスパッチャーに現在の処理を停止させる
                return false;
            }

        }

    }

ACLリストの提供
^^^^^^^^^^^^^^^^^^^^^
上の例では、 $this->_getAcl() メソッドでACLを取得しました。このメソッドもプラグインに実装されています。ここでは、アクセス制御リスト (ACL) をどのように作ったか、ステップバイステップで解説します:

.. code-block:: php

    <?php

    //ACLオブジェクトを作る
    $acl = new Phalcon\Acl\Adapter\Memory();

    //デフォルトの挙動はDENY（拒否）
    $acl->setDefaultAction(Phalcon\Acl::DENY);

    //2つのロールを登録する
    //ユーザーは登録済みユーザー、ゲストは未登録ユーザー
    $roles = array(
        'users' => new Phalcon\Acl\Role('Users'),
        'guests' => new Phalcon\Acl\Role('Guests')
    );
    foreach ($roles as $role) {
        $acl->addRole($role);
    }

次に、それぞれのエリアのリソースを個別に定義していきます。コントローラー名がリソースで、これらのアクションがリソースへのアクセス権です:

.. code-block:: php

    <?php

    //プライベートエリアのリソース (バックエンド)
    $privateResources = array(
      'companies' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'products' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'producttypes' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'invoices' => array('index', 'profile')
    );
    foreach ($privateResources as $resource => $actions) {
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

    //公開エリアのリソース (フロントエンド)
    $publicResources = array(
      'index' => array('index'),
      'about' => array('index'),
      'session' => array('index', 'register', 'start', 'end'),
      'contact' => array('index', 'send')
    );
    foreach ($publicResources as $resource => $actions) {
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

いま、ACLは既存のコントローラーと関連するアクションの情報を知っている状態になっています。"Users" ロールはバックエンドとフロントエンド双方の全てのリソースにアクセスできます。"Guests" ロールは公開エリアにだけアクセスできます:

.. code-block:: php

    <?php

    //公開エリアのアクセス権をユーザーとゲストの双方に与える
    foreach ($roles as $role) {
        foreach ($publicResources as $resource => $actions) {
            $acl->allow($role->getName(), $resource, '*');
        }
    }

    //ユーザーにだけ、プライベートエリアへのアクセス権を与える
    foreach ($privateResources as $resource => $actions) {
        foreach ($actions as $action) {
            $acl->allow('Users', $resource, $action);
        }
    }

万歳！ これで、ACLは終わりです。

ユーザーコンポーネント
---------------
全てのUI要素とスタイルは、 `Twitter Bootstrap`_ によって実現されています。ナビゲーションバーなどの要素は、アプリケーションの状態によって変わります。たとえば、右上のリンク "Log in / Sign Up" は、ユーザーがログインしている場合には "Log out" に変わります。

アプリケーションのこの部分は、"Elements" コンポーネント (app/library/Elements.php) で実装されています。

.. code-block:: php

    <?php

    use Phalcon\Mvc\User\Component;

    class Elements extends Component
    {

        public function getMenu()
        {
            //...
        }

        public function getTabs()
        {
            //...
        }

    }

このクラスは Phalcon\\Mvc\\User\\Component を継承しています。このクラスのコンポーネントを継承することは必須ではありませんが、アプリケーションのサービスに素早くアクセスする助けになります。それでは、このクラスをサービスコンテナに登録します:

.. code-block:: php

    <?php

    //Register an user component
    $di->set('elements', function(){
        return new Elements();
    });

As controllers, plugins or components within a view, this component also has access to the services registered
in the container and by just accessing an attribute with the same name as a previously registered service:

.. code-block:: html+php

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="#">INVO</a>
                <?php echo $this->elements->getMenu() ?>
            </div>
        </div>
    </div>

    <div class="container">
        <?php echo $this->getContent() ?>
        <hr>
        <footer>
            <p>&copy; Company 2012</p>
        </footer>
    </div>

The important part is:

.. code-block:: html+php

    <?php echo $this->elements->getMenu() ?>

CRUDを使用した作業
---------------------
Most options that manipulate data (companies, products and types of products), were developed using a basic and
common CRUD_ (Create, Read, Update and Delete). Each CRUD contains the following files:

.. code-block:: bash

    invo/
        app/
            app/controllers/
                ProductsController.php
            app/models/
                Products.php
            app/views/
                products/
                    edit.phtml
                    index.phtml
                    new.phtml
                    search.phtml

Each controller has the following actions:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {

        /**
         * The start action, it shows the "search" view
         */
        public function indexAction()
        {
            //...
        }

        /**
         * Execute the "search" based on the criteria sent from the "index"
         * Returning a paginator for the results
         */
        public function searchAction()
        {
            //...
        }

        /**
         * Shows the view to create a "new" product
         */
        public function newAction()
        {
            //...
        }

        /**
         * Shows the view to "edit" an existing product
         */
        public function editAction()
        {
            //...
        }

        /**
         * Creates a product based on the data entered in the "new" action
         */
        public function createAction()
        {
            //...
        }

        /**
         * Updates a product based on the data entered in the "edit" action
         */
        public function saveAction()
        {
            //...
        }

        /**
         * Deletes an existing product
         */
        public function deleteAction($id)
        {
            //...
        }

    }

検索フォーム
^^^^^^^^^^^^^^^
Every CRUD starts with a search form. This form shows each field that has the table (products), allowing the user
creating a search criteria from any field. Table "products" has a relationship to the table "products_types".
In this case, we previously queried the records in this table in order to facilitate the search by that field:

.. code-block:: php

    <?php

    /**
     * The start action, it shows the "search" view
     */
    public function indexAction()
    {
        $this->persistent->searchParams = null;
        $this->view->productTypes = ProductTypes::find();
    }

All the "product types" are queried and passed to the view as a local variable "productTypes". Then, in the view
(app/views/index.phtml) we show a "select" tag filled with those results:

.. code-block:: html+php

    <div>
        <label for="product_types_id">Product Type</label>
        <?php echo $this->tag->select(array(
            "product_types_id",
            $productTypes,
            "using" => array("id", "name"),
            "useDummy" => true
        )) ?>
    </div>

Note that $productTypes contains the data necessary to fill the SELECT tag using Phalcon\\Tag::select. Once the form
is submitted, the action "search" is executed in the controller performing the search based on the data entered by
the user.

検索の実行
^^^^^^^^^^^^^^^^^^^
The action "search" has a dual behavior. When accessed via POST, it performs a search based on the data sent from the
form. But when accessed via GET it moves the current page in the paginator. To differentiate one from another HTTP method,
we check it using the :doc:`Request <request>` component:

.. code-block:: php

    <?php

    /**
     * Execute the "search" based on the criteria sent from the "index"
     * Returning a paginator for the results
     */
    public function searchAction()
    {

        if ($this->request->isPost()) {
            //create the query conditions
        } else {
            //paginate using the existing conditions
        }

        //...

    }

With the help of :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>`, we can create the search
conditions intelligently based on the data types and values sent from the form:

.. code-block:: php

    <?php

    $query = Criteria::fromInput($this->di, "Products", $_POST);

This method verifies which values are different from "" (empty string) and null and takes them into account to create
the search criteria:

* If the field data type is text or similar (char, varchar, text, etc.) It uses an SQL "like" operator to filter the results.
* If the data type is not text or similar, it'll use the operator "=".

Additionally, "Criteria" ignores all the $_POST variables that do not match any field in the table.
Values are automatically escaped using "bound parameters".

Now, we store the produced parameters in the controller's session bag:

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

A session bag, is a special attribute in a controller that persists between requests. When accessed, this attribute injects
a :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>` service that is independent in each controller.

Then, based on the built params we perform the query:

.. code-block:: php

    <?php

    $products = Products::find($parameters);
    if (count($products) == 0) {
        $this->flash->notice("The search did not found any products");
        return $this->forward("products/index");
    }

If the search doesn't return any product, we forward the user to the index action again. Let's pretend the
search returned results, then we create a paginator to navigate easily through them:

.. code-block:: php

    <?php

    $paginator = new Phalcon\Paginator\Adapter\Model(array(
        "data" => $products,    //Data to paginate
        "limit" => 5,           //Rows per page
        "page" => $numberPage   //Active page
    ));

    //Get active page in the paginator
    $page = $paginator->getPaginate();

Finally we pass the returned page to view:

.. code-block:: php

    <?php

    $this->view->setVar("page", $page);

In the view (app/views/products/search.phtml), we traverse the results corresponding to the current page:

.. code-block:: html+php

    <?php foreach ($page->items as $product) { ?>
        <tr>
            <td><?= $product->id ?></td>
            <td><?= $product->getProductTypes()->name ?></td>
            <td><?= $product->name ?></td>
            <td><?= $product->price ?></td>
            <td><?= $product->active ?></td>
            <td><?= $this->tag->linkTo("products/edit/" . $product->id, 'Edit') ?></td>
            <td><?= $this->tag->linkTo("products/delete/" . $product->id, 'Delete') ?></td>
        </tr>
    <?php } ?>

レコードの登録と更新
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Now let's see how the CRUD creates and updates records. From the "new" and "edit" views the data entered by the user
are sent to the actions "create" and "save" that perform actions of "creating" and "updating" products respectively.

In the creation case, we recover the data submitted and assign them to a new "products" instance:

.. code-block:: php

    <?php

    /**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {

        $products = new Products();

        $products->id = $this->request->getPost("id", "int");
        $products->product_types_id = $this->request->getPost("product_types_id", "int");
        $products->name = $this->request->getPost("name", "striptags");
        $products->price = $this->request->getPost("price", "double");
        $products->active = $this->request->getPost("active");

        //...

    }

Data is filtered before being assigned to the object. This filtering is optional, the ORM escapes the input data and
performs additional casting according to the column types.

When saving we'll know whether the data conforms to the business rules and validations implemented in the model Products:

.. code-block:: php

    <?php

    /**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {

        //...

        if (!$products->create()) {

            //The store failed, the following messages were produced
            foreach ($products->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("products/new");

        } else {
            $this->flash->success("Product was created successfully");
            return $this->forward("products/index");
        }

    }

Now, in the case of product updating, first we must present to the user the data that is currently in the edited record:

.. code-block:: php

    <?php

    /**
     * Shows the view to "edit" an existing product
     */
    public function editAction($id)
    {

        //...

        $product = Products::findFirstById($id);

        $this->tag->setDefault("id", $product->id);
        $this->tag->setDefault("product_types_id", $product->product_types_id);
        $this->tag->setDefault("name", $product->name);
        $this->tag->setDefault("price", $product->price);
        $this->tag->setDefault("active", $product->active);

    }

The "setDefault" helper sets a default value in the form on the attribute with the same name. Thanks to this,
the user can change any value and then sent it back to the database through to the "save" action:

.. code-block:: php

    <?php

    /**
     * Updates a product based on the data entered in the "edit" action
     */
    public function saveAction()
    {

        //...

        //Find the product to update
        $id = $this->request->getPost("id");
        $product = Products::findFirstById($id);
        if (!$product) {
            $this->flash->error("products does not exist " . $id);
            return $this->forward("products/index");
        }

        //... assign the values to the object and store it

    }

タイトルの動的な変更
------------------------------
When you browse between one option and another will see that the title changes dynamically indicating where
we are currently working. This is achieved in each controller initializer:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {

        public function initialize()
        {
            //Set the document title
            $this->tag->setTitle('Manage your product types');
            parent::initialize();
        }

        //...

    }

Note, that the method parent::initialize() is also called, it adds more data to the title:

.. code-block:: php

    <?php

    class ControllerBase extends Phalcon\Mvc\Controller
    {

        protected function initialize()
        {
            //Prepend the application name to the title
            $this->tag->prependTitle('INVO | ');
        }

        //...
    }

Finally, the title is printed in the main view (app/views/index.phtml):

.. code-block:: html+php

    <!DOCTYPE html>
    <html>
        <head>
            <?php echo $this->tag->getTitle() ?>
        </head>
        <!-- ... -->
    </html>

まとめ
----------
This tutorial covers many more aspects of building applications with Phalcon, hope you have served to
learn more and get more out of the framework.

.. _Github: https://github.com/phalcon/invo
.. _CRUD: http://en.wikipedia.org/wiki/Create,_read,_update_and_delete
.. _Twitter Bootstrap: http://twitter.github.io/bootstrap/
.. _sha1: http://php.net/manual/en/function.sha1.php
.. _bcrypt: http://stackoverflow.com/questions/4795385/how-do-you-use-bcrypt-for-hashing-passwords-in-php
