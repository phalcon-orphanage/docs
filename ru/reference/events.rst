Менеджер событий EventsManager
==============================

Цель данного компонента состоит в добавлении возможности перехватывать процесс выполнения большинства компонентов системы путём создания
специальных "ключевых точек". Эти ключевые точки позволяют разработчику получить информацию о состоянии, манипулировать данными и изменять
процесс работы компонента.

Пример использования
--------------------
В следующем примере, мы используем менеджер событий для прослушивания событий вызываемых в MySQL соединении управляемым :doc:`Phalcon\\Db <../api/Phalcon_Db>`.
Для начала нам необходимо создать объект слушателя. Методы класса являются событиями, которые необходимо прослушивать.

.. code-block:: php

    <?php

    class MyDbListener
    {
        public function afterConnect()
        {

        }

        public function beforeQuery()
        {

        }

        public function afterQuery()
        {

        }
    }

Такой класс может реализовывать необходимые нам события. Менеджер событий будет взаимодействовать между компонентом и нашим классом,
вызывая события, реализованные методами класса и поддерживаемые компонентом.

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    $eventsManager = new EventsManager();

    // Создание слушателя базы данных
    $dbListener    = new MyDbListener();

    // Слушать все события базы данных
    $eventsManager->attach('db', $dbListener);

    $connection    = new DbAdapter(
        array(
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo"
        )
    );

    // Совмещение менеджера событий с адаптером базы данных
    $connection->setEventsManager($eventsManager);

    // Выполнение SQL запроса
    $connection->query("SELECT * FROM products p WHERE p.status = 1");

Для того, чтобы получать все SQL-запросы, выполненные в нашем приложении, мы должны использовать событие “afterQuery”. Первый передаваемый слушателю параметр
содержит контекстную информацию о текущем событии, второй параметр - само соединение.

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as Logger;

    class MyDbListener
    {
        protected $_logger;

        public function __construct()
        {
            $this->_logger = new Logger("../apps/logs/db.log");
        }

        public function afterQuery($event, $connection)
        {
            $this->_logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
        }
    }

В рамках этого примера, мы будем также использовать профайлер :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` для обнаружения SQL-запросов с длительным временем выполнения:

.. code-block:: php

    <?php

    use Phalcon\Db\Profiler;
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
        public function beforeQuery($event, $connection)
        {
            $this->_profiler->startProfile($connection->getSQLStatement());
        }

        /**
         * Этот метод будет запущен, если будет вызван метод 'afterQuery'
         */
        public function afterQuery($event, $connection)
        {
            $this->_logger->log($connection->getSQLStatement(), Logger::INFO);
            $this->_profiler->stopProfile();
        }

        public function getProfiler()
        {
            return $this->_profiler;
        }
    }

Результирующие данные о работе профайлера могут быть получены из слушателя:

.. code-block:: php

    <?php

    // Выполнение SQL запроса
    $connection->execute("SELECT * FROM products p WHERE p.status = 1");

    foreach ($dbListener->getProfiler()->getProfiles() as $profile) {
        echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
        echo "Start Time: ", $profile->getInitialTime(), "\n";
        echo "Final Time: ", $profile->getFinalTime(), "\n";
        echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }

Подобным образом мы можем зарегистрировать лямбда-функцию для выполнения этой задачи, без использования отдельного класса слушателя (как в примере выше):

.. code-block:: php

    <?php

    // Слушаем все события базы данных
    $eventManager->attach('db', function ($event, $connection) {
        if ($event->getType() == 'afterQuery') {
            echo $connection->getSQLStatement();
        }
    });

Создание компонентов с поддержкой событий
-----------------------------------------
Компоненты, созданные в вашем приложении, могут инициировать события в EventsManager. Вы также можете создавать слушателей, которые
реагируют на эти события. В следующем примере мы создаем компонент, под названием "MyComponent".
Этот компонент будет указывать менеджеру событий о выполнении своего метода :code:`someTask()`, что в свою очередь будет вызывать два события для слушателей в EventsManager:

.. code-block:: php

    <?php

    use Phalcon\Events\EventsAwareInterface;

    class MyComponent implements EventsAwareInterface
    {
        protected $_eventsManager;

        public function setEventsManager($eventsManager)
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

Обратите внимание, что события, создаваемые нашим компонентом, имеют префикс "my-component". Это уникальное слово для разделения событий,
которые формируются из разных компонентов. Вы можете создавать события вне компонента с таким же именем, оно ни от чего не зависит.
Теперь давайте создадим слушателя для нашего компонента:

.. code-block:: php

    <?php

    class SomeListener
    {
        public function beforeSomeTask($event, $myComponent)
        {
            echo "Выполняется beforeSomeTask\n";
        }

        public function afterSomeTask($event, $myComponent)
        {
            echo "Выполняется afterSomeTask\n";
        }
    }

Слушатель - это просто класс, который реализует все события, вызываемые в компоненте. Давайте заставим их работать вместе:

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    // Создаём менеджер событий
    $eventsManager = new EventsManager();

    // Создаём экземпляр MyComponent
    $myComponent   = new MyComponent();

    // Связываем компонент и менеджер событий
    $myComponent->setEventsManager($eventsManager);

    // Связываем слушателя и менеджер событий
    $eventsManager->attach('my-component', new SomeListener());

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

    // Получение данных из третьего параметра
    $eventsManager->attach('my-component', function ($event, $component, $data) {
        print_r($data);
    });

    // Получение данных из контекста события
    $eventsManager->attach('my-component', function ($event, $component) {
        print_r($event->getData());
    });

Если слушать необходимо только определённое событие, вы можете указать его в момент связывания:

.. code-block:: php

    <?php

    // Обработчик выполнится только при наступлении события "beforeSomeTask"
    $eventsManager->attach('my-component:beforeSomeTask', function ($event, $component) {
        // ...
    });

Остановка/Продолжение событий
-----------------------------
Несколько слушателей может быть привязано к одному событию, это означает, что при его наступлении эти слушатели будут уведомлены.
Слушатели уведомляются в порядке, в котором они были зарегистрированы в менеджере событий EventsManager. Некоторые события могут быть прекращены
во время работы слушателя и уведомление других слушателей будет остановлено.

.. code-block:: php

    <?php

    $eventsManager->attach('db', function ($event, $connection) {

        // Если событие поддерживает прекращение
        if ($event->isCancelable()) {
            // Прекращение события, остальные слушатели его не получат
            $event->stop();
        }

        // ...

    });

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

    $eventsManager->attach('db', new DbListener(), 150); // Высокий приоритет
    $eventsManager->attach('db', new DbListener(), 100); // Нормальный приоритет
    $eventsManager->attach('db', new DbListener(), 50);  // Низкий приоритет

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
    $eventsManager->attach('custom:custom', function () {
        return 'first response';
    });

    // Добавления еще одного слушателя
    $eventsManager->attach('custom:custom', function () {
        return 'second response';
    });

    // Выполнение события
    $eventsManager->fire('custom:custom', null);

    // Получаем все ответы
    print_r($eventsManager->getResponses());

Сформируются такие данные:

.. code-block:: html

    Array ( [0] => first response [1] => second response )

Создание собственных менеджеров событий (EventsManager)
-------------------------------------------------------
Для создания менеджера необходимо реализовать интерфейс :doc:`Phalcon\\Events\\ManagerInterface <../api/Phalcon_Events_ManagerInterface>` и
заменить им стандартный менеджер EventsManager при инициализации Phalcon.
