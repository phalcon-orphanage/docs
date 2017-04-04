Менеджер событий EventsManager
==============================

Цель данного компонента состоит в добавлении возможности перехватывать процесс выполнения большинства компонентов системы путём создания
специальных "ключевых точек". Эти ключевые точки позволяют разработчику получить информацию о состоянии, манипулировать данными и изменять
процесс работы компонента.

Соглашение об именах
--------------------

События Phalcon используют пространства имен, чтобы избежать конфликтов имен. 
Каждый компонент в Phalcon занимает другое пространство имен событий, и вы можете создавать свои собственные, 
как считаете нужным. Имена событий форматируются как «компонент: событие». 
Например, как :doc:`Phalcon\\Db <../api/Phalcon_Db>` занимает пространство имен "db", 
то  полное имя "afterQuery"  - "db:afterQuery".

When attaching event listeners to the events manager, you can use "component" to catch all events from that component (eg. "db" to catch all of the
:doc:`Phalcon\\Db <../api/Phalcon_Db>` events) or "component:event" to target a specific event (eg. "db:afterQuery").

При подключении прослушивателей событий к диспетчеру событий вы можете использовать "компонент", чтобы поймать все события из этого компонента (например, "db", чтобы перехватить все события :doc:`Phalcon\\Db <../api/Phalcon_Db>`) или "компонент: событие" для таргетинга на конкретное событие (например, "db:afterQuery").

Пример использования
--------------------
В следующем примере мы будем использовать EventManager для прослушивания события "afterQuery", созданного в соединении MySQL, определяемом в :doc:`Phalcon\\Db <../api/Phalcon_Db>`:

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

Теперь каждый раз, когда выполняется запрос, выражение SQL будет выведено на экран.
Первый передаваемый слушателю параметр содержит контекстную информацию о текущем событии, второй параметр - само соединение.
Также может быть указан третий параметр, который будет содержать произвольные данные, специфичные для события.

.. highlights::

    Вы должны явно установить диспетчер событий в компонент с помощью метода: :code:`setEventsManager()`, чтобы этот компонент мог инициировать события. Вы можете создать новый экземпляр Event Manager для каждого компонента или установить один и тот же диспетчер событий на несколько компонентов, поскольку соглашение об именах позволит избежать конфликтов.

Вместо использования лямбда-функций вы можете использовать классы прослушивания событий. Слушатели событий также позволяют вам слушать несколько событий.
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

Присоединение прослушивателя событий к менеджеру событий так же просто, как:

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

    use Phalcon\Events\ManagerInterface;
    use Phalcon\Events\EventsAwareInterface;

    class MyComponent implements EventsAwareInterface
    {
        protected $_eventsManager;

        public function setEventsManager(ManagerInterface $eventsManager)
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

Обратите внимание: в этом примере мы используем пространство имен "my-component".
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

Использование служб из DI
--------------------------
Расширяя :doc:`Phalcon\\Mvc\\User\\Plugin <../api/Phalcon_Mvc_User_Plugin>`, вы можете обращаться к службам из DI, как и в контроллере:

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
