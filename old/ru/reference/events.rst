Менеджер событий EventsManager
==============================

Цель данного компонента состоит в добавлении возможности перехватывать процесс выполнения большинства компонентов системы путём создания
специальных "ключевых точек". Эти ключевые точки позволяют разработчику получить информацию о состоянии, манипулировать данными и изменять
процесс работы компонента.

Naming Convention
-----------------
Phalcon events use namespaces to avoid naming collisions. Each component in Phalcon occupies a different event namespace and you are free to create
your own as you see fit. Event names are formatted as "component:event". For example, as :doc:`Phalcon\\Db <../api/Phalcon_Db>` occupies the "db"
namespace, its "afterQuery" event's full name is "db:afterQuery".

When attaching event listeners to the events manager, you can use "component" to catch all events from that component (eg. "db" to catch all of the
:doc:`Phalcon\\Db <../api/Phalcon_Db>` events) or "component:event" to target a specific event (eg. "db:afterQuery").

Пример использования
--------------------
In the following example, we will use the EventsManager to listen for the "afterQuery" event produced in a MySQL connection managed by
:doc:`Phalcon\\Db <../api/Phalcon_Db>`:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    $eventsManager = new EventsManager();

    $eventsManager->attach(
        "db:afterQuery",
        function (Event $event, $connection) {
            echo $connection->getSQLStatement();
        }
    );

    $connection = new DbAdapter(
        [
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo",
        ]
    );

    // Совмещение менеджера событий с адаптером базы данных
    $connection->setEventsManager($eventsManager);

    // Выполнение SQL запроса
    $connection->query(
        "SELECT * FROM products p WHERE p.status = 1"
    );

Now every time a query is executed, the SQL statement will be echoed out.
Первый передаваемый слушателю параметр содержит контекстную информацию о текущем событии, второй параметр - само соединение.
A third parameter may also be specified which will contain arbitrary data specific to the event.

.. highlights::

    You must explicitly set the Events Manager to a component using the :code:`setEventsManager()` method in order for that component to trigger events. You can create a new Events Manager instance for each component or you can set the same Events Manager to multiple components as the naming convention will avoid conflicts.

Instead of using lambda functions, you can use event listener classes instead. Event listeners also allow you to listen to multiple events.
В рамках этого примера, мы будем также использовать профайлер :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` для обнаружения SQL-запросов с длительным временем выполнения:

.. code-block:: php

    <?php

    use Phalcon\Db\Profiler;
    use Phalcon\Events\Event;
    use Phalcon\Logger;
    use Phalcon\Logger\Adapter\File;

    class MyDbListener
    {
        protected $_profiler;

        protected $_logger;

        /**
         * Создаем профайлер и запускаем логгер
         */
        public function __construct()
        {
            $this->_profiler = new Profiler();
            $this->_logger   = new Logger("../apps/logs/db.log");
        }

        /**
         * Этот метод будет запущен, если будет вызван метод 'beforeQuery'
         */
        public function beforeQuery(Event $event, $connection)
        {
            $this->_profiler->startProfile(
                $connection->getSQLStatement()
            );
        }

        /**
         * Этот метод будет запущен, если будет вызван метод 'afterQuery'
         */
        public function afterQuery(Event $event, $connection)
        {
            $this->_logger->log(
                $connection->getSQLStatement(),
                Logger::INFO
            );

            $this->_profiler->stopProfile();
        }

        public function getProfiler()
        {
            return $this->_profiler;
        }
    }

Attaching an event listener to the events manager is as simple as:

.. code-block:: php

    <?php

    // Создание слушателя базы данных
    $dbListener = new MyDbListener();

    // Слушать все события базы данных
    $eventsManager->attach(
        "db",
        $dbListener
    );

Результирующие данные о работе профайлера могут быть получены из слушателя:

.. code-block:: php

    <?php

    // Выполнение SQL запроса
    $connection->execute(
        "SELECT * FROM products p WHERE p.status = 1"
    );

    foreach ($dbListener->getProfiler()->getProfiles() as $profile) {
        echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
        echo "Start Time: ", $profile->getInitialTime(), "\n";
        echo "Final Time: ", $profile->getFinalTime(), "\n";
        echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }

Создание компонентов с поддержкой событий
-----------------------------------------
Компоненты, созданные в вашем приложении, могут инициировать события в EventsManager. Вы также можете создавать слушателей, которые
реагируют на эти события. В следующем примере мы создаем компонент, под названием "MyComponent".
Этот компонент будет указывать менеджеру событий о выполнении своего метода :code:`someTask()`, что в свою очередь будет вызывать два события для слушателей в EventsManager:

.. code-block:: php

    <?php

    use Phalcon\Events\EventsAwareInterface;
    use Phalcon\Events\Manager as EventsManager;

    class MyComponent implements EventsAwareInterface
    {
        protected $_eventsManager;

        public function setEventsManager(EventsManager $eventsManager)
        {
            $this->_eventsManager = $eventsManager;
        }

        public function getEventsManager()
        {
            return $this->_eventsManager;
        }

        public function someTask()
        {
            $this->_eventsManager->fire("my-component:beforeSomeTask", $this);

            // тут выполнение каких-либо действий
            echo "Выполняется someTask\n";

            $this->_eventsManager->fire("my-component:afterSomeTask", $this);
        }
    }

Notice that in this example, we're using the "my-component" event namespace.
Теперь давайте создадим слушателя для нашего компонента:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;

    class SomeListener
    {
        public function beforeSomeTask(Event $event, $myComponent)
        {
            echo "Выполняется beforeSomeTask\n";
        }

        public function afterSomeTask(Event $event, $myComponent)
        {
            echo "Выполняется afterSomeTask\n";
        }
    }

Давайте заставим их работать вместе:

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    // Создаём менеджер событий
    $eventsManager = new EventsManager();

    // Создаём экземпляр MyComponent
    $myComponent = new MyComponent();

    // Связываем компонент и менеджер событий
    $myComponent->setEventsManager($eventsManager);

    // Связываем слушателя и менеджер событий
    $eventsManager->attach(
        "my-component",
        new SomeListener()
    );

    // Выполняем метод нашего компонента
    $myComponent->someTask();

Когда метод :code:`someTask()` выполнится, сработают оба метода слушателя, и выведутся следующие строки:

.. code-block:: php

    Выполняется beforeSomeTask
    Выполняется someTask
    Выполняется afterSomeTask

Во время наступления события в слушателей можно передавать дополнительные данные, они должны передаваться третьим параметром в метод :code:`fire()`:

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData);

Слушатель также получает эти данные третьим параметром:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;

    // Получение данных из третьего параметра
    $eventsManager->attach(
        "my-component",
        function (Event $event, $component, $data) {
            print_r($data);
        }
    );

    // Получение данных из контекста события
    $eventsManager->attach(
        "my-component",
        function (Event $event, $component) {
            print_r($event->getData());
        }
    );

Using Services From The DI
--------------------------
By extending :doc:`Phalcon\\Mvc\\User\\Plugin <../api/Phalcon_Mvc_User_Plugin>`, you can access services from the DI, just like you would in a controller:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Mvc\User\Plugin;

    class SomeListener extends Plugin
    {
        public function beforeSomeTask(Event $event, $myComponent)
        {
            echo "Here, beforeSomeTask\n";

            $this->logger->debug(
                "beforeSomeTask has been triggered";
            );
        }

        public function afterSomeTask(Event $event, $myComponent)
        {
            echo "Here, afterSomeTask\n";

            $this->logger->debug(
                "afterSomeTask has been triggered";
            );
        }
    }

Остановка/Продолжение событий
-----------------------------
Несколько слушателей может быть привязано к одному событию, это означает, что при его наступлении эти слушатели будут уведомлены.
Слушатели уведомляются в порядке, в котором они были зарегистрированы в менеджере событий EventsManager. Некоторые события могут быть прекращены
во время работы слушателя и уведомление других слушателей будет остановлено.

.. code-block:: php

    <?php

    use Phalcon\Events\Event;

    $eventsManager->attach(
        "db",
        function (Event $event, $connection) {
            // Если событие поддерживает прекращение
            if ($event->isCancelable()) {
                // Прекращение события, остальные слушатели его не получат
                $event->stop();
            }

            // ...
        }
    );

По умолчанию все события поддерживают прекращение, большинство событий, выполняемых в ядре фреймворка, тоже поддерживают прекращение. Вы можете
указать, что событие не прекращаемое передавая :code:`false` в четвертый параметр вызова :code:`fire()`:

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData, false);

Настройка слушателей (Listener)
-------------------------------
При установке слушателей можно устанавливать их приоритет. Это позволяет указать порядок их вызова в момент выполнения.

.. code-block:: php

    <?php

    // активация установки приоритетов
    $eventsManager->enablePriorities(true);

    $eventsManager->attach("db", new DbListener(), 150); // Высокий приоритет
    $eventsManager->attach("db", new DbListener(), 100); // Нормальный приоритет
    $eventsManager->attach("db", new DbListener(), 50);  // Низкий приоритет

Сбор ответов
------------
Менеджер событий умеет собрать каждый ответ, возвращаемый каждым слушателем, пример ниже показывает как это можно использовать:

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    $eventsManager = new EventsManager();

    // Настройка сборщика ответов
    $eventsManager->collectResponses(true);

    // Добавления слушателя
    $eventsManager->attach(
        "custom:custom",
        function () {
            return "first response";
        }
    );

    // Добавления еще одного слушателя
    $eventsManager->attach(
        "custom:custom",
        function () {
            return "second response";
        }
    );

    // Выполнение события
    $eventsManager->fire("custom:custom", null);

    // Получаем все ответы
    print_r($eventsManager->getResponses());

Сформируются такие данные:

.. code-block:: html

    Array ( [0] => first response [1] => second response )

Создание собственных менеджеров событий (EventsManager)
-------------------------------------------------------
Для создания менеджера необходимо реализовать интерфейс :doc:`Phalcon\\Events\\ManagerInterface <../api/Phalcon_Events_ManagerInterface>` и
заменить им стандартный менеджер EventsManager при инициализации Phalcon.
