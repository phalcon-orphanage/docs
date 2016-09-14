Dependency Injection Explained
==============================

以下の例は少々長めですが、なぜサービス・ロケーションと依存性の注入を使用するのかを説明しています。初めに、SomeComponentというコンポーネントを開発しているとしましょう。これは、今のところ重要ではないタスクを実行します。このコンポーネントは、DB接続に依存しています。

この最初のサンプルでは、コンポーネントの中でDB接続オブジェクトを作成しています。このアプローチは、実用的ではありません。コンポーネントのDB接続のパラメータを外部から操作したり、DBMSの種類を変更したりといった操作が行えないからです。

.. code-block:: php

    <?php

    class SomeComponent
    {
        /**
         * The instantiation of the connection is hardcoded inside
         * the component, therefore it's difficult replace it externally
         * or change its behavior
         */
        public function someDbTask()
        {
            $connection = new Connection(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );

            // ...
        }
    }

    $some = new SomeComponent();

    $some->someDbTask();

この問題を解決するため、依存しているオブジェクトを、使用する前に外部から注入するセッターを作りました。今のところ、これはよい解決法のようにみえます。

.. code-block:: php

    <?php

    class SomeComponent
    {
        protected $_connection;

        /**
         * Sets the connection externally
         */
        public function setConnection($connection)
        {
            $this->_connection = $connection;
        }

        public function someDbTask()
        {
            $connection = $this->_connection;

            // ...
        }
    }

    $some = new SomeComponent();

    // DB接続を作成する
    $connection = new Connection(
        [
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo",
        ]
    );

    // DB接続をコンポーネントに注入する
    $some->setConnection($connection);

    $some->someDbTask();

ここで、このコンポーネントをアプリケーションの別の部分で使用すると考えると、コンポーネントを使う度にDB接続を作成して渡す必要があるでしょう。ある種のグローバルな容れ物からDB接続を取得できるようにすれば、何度もDB接続を作る必要は無くなるはずです:

.. code-block:: php

    <?php

    class Registry
    {
        /**
         * Returns the connection
         */
        public static function getConnection()
        {
            return new Connection(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );
        }
    }

    class SomeComponent
    {
        protected $_connection;

        /**
         * Sets the connection externally
         */
        public function setConnection($connection)
        {
            $this->_connection = $connection;
        }

        public function someDbTask()
        {
            $connection = $this->_connection;

            // ...
        }
    }

    $some = new SomeComponent();

    // Registry内で定義されたDB接続を渡す
    $some->setConnection(Registry::getConnection());

    $some->someDbTask();

ここで、コンポーネントに2つのメソッドを実装しなければならないと想像してみましょう。1つは常に新しいDB接続を作成する必要があり、もう1つは共有されたDB接続を必要とします:

.. code-block:: php

    <?php

    class Registry
    {
        protected static $_connection;

        /**
         * Creates a connection
         */
        protected static function _createConnection()
        {
            return new Connection(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );
        }

        /**
         * Creates a connection only once and returns it
         */
        public static function getSharedConnection()
        {
            if (self::$_connection === null) {
                self::$_connection = self::_createConnection();
            }

            return self::$_connection;
        }

        /**
         * Always returns a new connection
         */
        public static function getNewConnection()
        {
            return self::_createConnection();
        }
    }

    class SomeComponent
    {
        protected $_connection;

        /**
         * Sets the connection externally
         */
        public function setConnection($connection)
        {
            $this->_connection = $connection;
        }

        /**
         * This method always needs the shared connection
         */
        public function someDbTask()
        {
            $connection = $this->_connection;

            // ...
        }

        /**
         * This method always needs a new connection
         */
        public function someOtherDbTask($connection)
        {

        }
    }

    $some = new SomeComponent();

    // このメソッドは共有のDB接続を注入する
    $some->setConnection(
        Registry::getSharedConnection()
    );

    $some->someDbTask();

    // ここでは、新しいDB接続を常にパラメーターとして渡す
    $some->someOtherDbTask(
        Registry::getNewConnection()
    );

ここまで、依存性の注入がいかにして我々の問題を解決するかをみてきました。依存しているオブジェクトを、内部で作成するのではなく、引数として渡せるようにすることで、アプリケーションはよりメンテナンスしやすく、疎結合になります。しかし、長い目で見ると、この形の依存性の注入には欠点があります。

たとえば、もしコンポーネントに多数の依存関係があるなら、依存しているオブジェクトを渡すための多くの引数をもつセッターを作成するか、多くの引数をもつコンストラクタを作成する必要があります。加えて、コンポーネントを使う度に依存しているオブジェクトを全て作成する必要があり、コードのメンテナンス性は失われてしまいます:

.. code-block:: php

    <?php

    // 依存オブジェクトの作成（あるいは、Registryからの取得）
    $connection = new Connection();
    $session    = new Session();
    $fileSystem = new FileSystem();
    $filter     = new Filter();
    $selector   = new Selector();

    // コンストラクタに渡す
    $some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

    // あるいは、セッターを使用する
    $some->setConnection($connection);
    $some->setSession($session);
    $some->setFileSystem($fileSystem);
    $some->setFilter($filter);
    $some->setSelector($selector);

このオブジェクトをアプリケーションの多くの部分で作成しなければならないと考えてみましょう。もし、依存関係のいずれも必要としないのであれば、このオブジェクトに依存性を注入しているところから、コンストラクタ（あるいはセッター）のパラメーターを取り除く必要があります。この問題を解決するため、コンポーネントを作成するためのグローバルな容れ物、という考え方に立ち戻ってみましょう。ただし、ここではオブジェクトを作る前に抽象化のレイヤーを追加しています:

.. code-block:: php

    <?php

    class SomeComponent
    {
        // ...

        /**
         * Define a factory method to create SomeComponent instances injecting its dependencies
         */
        public static function factory()
        {
            $connection = new Connection();
            $session    = new Session();
            $fileSystem = new FileSystem();
            $filter     = new Filter();
            $selector   = new Selector();

            return new self($connection, $session, $fileSystem, $filter, $selector);
        }
    }

ちょっと待って下さい、これは初めと同じように、コンポーネントの内部で依存関係を作り上げています！　私達はいつも、どんどん進んで問題を解決する方法を見つけることができます。しかし、今回はバッドプラクティスに陥ってしまったようです。

これらの問題の実用的で手際のよい解決法は、依存関係のコンテナを使うことです。コンテナは、上で見てきたように、グローバルな容れ物として機能します。依存関係のためのコンテナを、依存関係のあるオブジェクトを取得するためのブリッジとすることで、コンポーネントの複雑さを減らすことができます:

.. code-block:: php

    <?php

    use Phalcon\Di;
    use Phalcon\DiInterface;

    class SomeComponent
    {
        protected $_di;

        public function __construct(DiInterface $di)
        {
            $this->_di = $di;
        }

        public function someDbTask()
        {
            // connectionサービスを取得
            // 常に新しいconnectionを返す
            $connection = $this->_di->get("db");
        }

        public function someOtherDbTask()
        {
            // 共有のconnectionサービスを取得
            // 常に同じconnectionサービスを返す
            $connection = $this->_di->getShared("db");

            // このメソッドは入力値のフィルタリングをするサービスを必要とする
            $filter = $this->_di->get("filter");
        }
    }

    $di = new Di();

    // 「db」サービスをコンテナに登録する
    $di->set(
        "db",
        function () {
            return new Connection(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );
        }
    );

    // 「filter」サービスをコンテナに登録する
    $di->set(
        "filter",
        function () {
            return new Filter();
        }
    );

    // 「session」サービスをコンテナに登録する
    $di->set(
        "session",
        function () {
            return new Session();
        }
    );

    // サービスコンテナを唯一のパラメータとして渡す
    $some = new SomeComponent($di);

    $some->someDbTask();

これで、コンポーネントは必要とするサービスにシンプルにアクセスできるようになりました。不要なサービスは、初期化されることさえないので、リソースを節約できます。コンポーネントは高度に疎結合です。たとえば、コンポーネントの振る舞いやその他の側面を変更せずに、DB接続のやり方を変更することができます。
