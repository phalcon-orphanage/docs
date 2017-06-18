Dependency Injection Explained
==============================

Следующий пример немного длинный, но он стремится объяснить, почему Phalcon использует сервис-локации и внедрение зависимостей.
Итак, представим, что мы разрабатываем компонент, назовём его SomeComponent. Сейчас нам не важно, какую именно задачу он выполняет.
Наш компонент имеет некоторую зависимость, отвечающую за соединение с базой данных.

В первом примере соединение устанавливается внутри компонента. Такой подход не является практичным, так как
не позволяет нам менять параметры соединения или тип СУБД из-за того, что компонент работает только так, как был создан.

.. code-block:: php

    <?php

    class SomeComponent
    {
        /**
         * Создание соединения жестко вшито в
         * компонент, поэтому сложно его заменить
         * или изменить его поведение
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

Чтобы решить эту проблему, создадим сеттер (setter), который внедрит внешнюю зависимость перед использованием. Теперь это похоже на
хорошее решение:

.. code-block:: php

    <?php

    class SomeComponent
    {
        protected $_connection;

        /**
         * Назначает внешнее соединение
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

    // Создаем соединение с БД
    $connection = new Connection(
        [
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo",
        ]
    );

    // Внедряем соединение в компонент
    $some->setConnection($connection);

    $some->someDbTask();

Теперь примем во внимание тот факт, что мы используем компонент в различных частях приложения,
поэтому появляется необходимость создавать соединение несколько раз и передавать его в компонент.
С помощью некоторого глобального реестра будем получать копию соединения, тем самым нам больше нет надобности
создавать его вновь и вновь:

.. code-block:: php

    <?php

    class Registry
    {
        /**
         * Возвращает соединение
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
         * Назначает внешнее соединение
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

    // Передаем соединение, определенное в реестре
    $some->setConnection(Registry::getConnection());

    $some->someDbTask();

Теперь представим, что нам необходимо реализовать в компоненте два метода: первый всегда нуждается в создании нового соединения, а второй всегда использует уже установленное (shared):

.. code-block:: php

    <?php

    class Registry
    {
        protected static $_connection;

        /**
         * Создаёт соединение
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
         * Создаёт соединение единожды и возвращает его
         */
        public static function getSharedConnection()
        {
            if (self::$_connection === null) {
                self::$_connection = self::_createConnection();
            }

            return self::$_connection;
        }

        /**
         * Всегда возвращает новое соединение
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
         * Назначает внешнее соединение
         */
        public function setConnection($connection)
        {
            $this->_connection = $connection;
        }

        /**
         * Для этого метода всегда требуется уже установленное соединение
         */
        public function someDbTask()
        {
            $connection = $this->_connection;

            // ...
        }

        /**
         * Для этого метода всегда требуется новое соединение
         */
        public function someOtherDbTask($connection)
        {

        }
    }

    $some = new SomeComponent();

    // Тут внедряется уже установленное (shared) соединение
    $some->setConnection(
        Registry::getSharedConnection()
    );

    $some->someDbTask();

    // А здесь всегда в качестве параметра передаётся новое соединение
    $some->someOtherDbTask(
        Registry::getNewConnection()
    );

До сих пор мы рассматривали случаи, когда внедрение зависимостей решает наши задачи. Передача зависимостей в качестве аргументов вместо
создания их внутри кода делает наше приложение более гибким и уменьшает его связанность. Однако, в перспективе,
такая форма внедрения зависимостей имеет некоторые недостатки.

Например, если компонент имеет много зависимостей, мы будем вынуждены создавать сеттеры с множеством аргументов для передачи
зависимостей или конструктор, который принимает их в качестве большого числа аргументов, вдобавок к этому, всякий раз создавать ещё и сами зависимости
до использования компонента. Это сделает наш код слишком сложным для сопровождения:

.. code-block:: php

    <?php

    // Создаем зависимости или получаем их из реестра
    $connection = new Connection();
    $session    = new Session();
    $fileSystem = new FileSystem();
    $filter     = new Filter();
    $selector   = new Selector();

    // Передаем их в конструктор в качестве параметров
    $some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

    // ... Или используем сеттеры
    $some->setConnection($connection);
    $some->setSession($session);
    $some->setFileSystem($fileSystem);
    $some->setFilter($filter);
    $some->setSelector($selector);

Представьте, что пришлось бы создавать этот объект во многих частях нашего приложения. Если когда-нибудь мы перестанем нуждаться в какой-либо зависимости,
нам придётся пройтись по всем этим местам и удалить соответствующий параметр в вызовах конструктора или в сеттерах. Чтобы решить эту проблему,
вернёмся к глобальному реестру для создания компонента. Однако, это добавит новый уровень абстракции, предшествующий созданию
объекта:

.. code-block:: php

    <?php

    class SomeComponent
    {
        // ...

        /**
         * Определение метода factory, который создаёт экземпляр SomeComponent и внедряет в него зависимости
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

Минуточку, мы снова вернулись туда, откуда начали: создание зависимостей внутри компонента! Мы можем двигаться дальше и находить способ
решать эту проблему каждый раз. Но, это означает, что мы снова и снова будем наступать на те же грабли.

Практически применимый и элегантный способ решить эту проблему — это использовать контейнер для зависимостей. Он играет ту же роль, что и глобальный реестр, который
мы видели выше. Использование контейнера в качестве моста к зависимостям позволяет нам уменьшить сложность
нашего компонента:

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
            // Получение сервиса соединений
            // Всегда возвращает соединение
            $connection = $this->_di->get("db");
        }

        public function someOtherDbTask()
        {
            // Получение сервиса соединения, предназначенного для общего доступа,
            // всегда возвращает одно и то же соединение
            $connection = $this->_di->getShared("db");

            // Этот метод так же требует сервис фильтрации входных данных
            $filter = $this->_di->get("filter");
        }
    }

    $di = new Di();

    // Регистрируем в контейнере сервис "db"
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

    // Регистрируем в контейнере сервис "filter"
    $di->set(
        "filter",
        function () {
            return new Filter();
        }
    );

    // Регистрируем в контейнере сервис "session"
    $di->set(
        "session",
        function () {
            return new Session();
        }
    );

    // Передаем контейнер сервисов в качестве единственного параметра
    $some = new SomeComponent($di);

    $some->someDbTask();

Теперь компонент имеет простой доступ к сервисам, которые ему необходимы. Если сервис невостребован, он не будет инициализирован,
тем самым экономя ресурсы. Также компонент теперь обладает низкой связанностью. Например, можно заменить способ создания соединений,
поведение или любой другой аспект их работы, и это никак не отразится на компоненте.
