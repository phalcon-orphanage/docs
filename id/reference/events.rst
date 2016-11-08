Events Manager
==============

Tugas komponen ini adalah mengintersepsi eksekusi sebagian besar komponen lain dalam framework dengan menciptakan "hook points". Hook
point ini memungkinkan developer mendapatkan informasi status, manipulasi data atau  mengubah alir eksekusi selama proses sebuah komponen.

Konvensi Penamaan
-----------------
Event Phalcon menggunakan namespace untuk menghindari tabrakan penamaan. Tiap komponen dalam Phalcon menempati sebuah namespace berbeda dan anda bebas menciptakan
milik anda sesuai kebutuhan. Nama kejadian diformat sebagai "component:event". Contoh, karena :doc:`Phalcon\\Db <../api/Phalcon_Db>` menempati namespace "db", 
nama lengkap event "afterQuery" adalah "db:afterQuery".

Ketika memasang event listener ke event manager, anda dapat menggunakan "component" untuk menangkap semua kejadian dari komponen tersebut (contoh "db" untuk menangkap semua
kejadian :doc:`Phalcon\\Db <../api/Phalcon_Db>`) atau "component:event" untuk mengacu kejadian tertentu(contoh "db:afterQuery").

Contoh Penggunaan
-----------------
Di contoh berikut, kita menggunakan EventsManager untuk mendengarkan kejadian yabg dihasilkan oleh koneksi MySQL yang dikelola :doc:`Phalcon\\Db <../api/Phalcon_Db>`.
Pertama, kita perlu sebuah objek listener untuk melakukannya. Kita menciptakan sebuah kelas yang metodenya adalah event yang ingin kita dengarkan:

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

    // Pasang eventsManager ke instance adapter db
    $connection->setEventsManager($eventsManager);

    // Kirim perintah SQL ke server database
    $connection->query(
        "SELECT * FROM products p WHERE p.status = 1"
    );

Sekarang tiap kali sebuah query dieksekusi, pernyataan SQL akan dicetak. Parameter pertama yang dilewatkan ke fungsi lambda berisi informasi 
kontekstual tentang kejadian yang berjalan, yang kedua adalah sumber kejadian (dalam hal ini koneksi itu sendiri). Parameter ketiga dapat
juga ditentukan yang akan berisi data sembarang terkait kejadian.

.. highlights::

    You must explicitly set the Events Manager to a component using the :code:`setEventsManager()` method in order for that component to trigger events. You can create a new Events Manager instance for each component or you can set the same Events Manager to multiple components as the naming convention will avoid conflicts.

Selain menggunakan fungsi lambda, anda dapat menggunakan kelas event listener. Event listener juga memungkinkan anda untuk mendengarkan kejadian lebih dari satu. Di
contoh ini, kita akan mengimplementasi :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` untuk mendeteksi pernyataan SQL yang butuh waktu lama
untuk dieksekusi dari perkiraan:

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
         * Buat profiler dan mulai catat log
         */
        public function __construct()
        {
            $this->_profiler = new Profiler();
            $this->_logger   = new Logger("../apps/logs/db.log");
        }

        /**
         * Ini dieksekusi ketika event dipicu adalah 'beforeQuery'
         */
        public function beforeQuery(Event $event, $connection)
        {
            $this->_profiler->startProfile(
                $connection->getSQLStatement()
            );
        }

        /**
         * Ini dieksekusi ketika event dipicu adalah 'afterQuery'
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

Memasang sebuah event listener ke event manager sesederhana berikut ini:

.. code-block:: php

    <?php

    // Buat listener database
    $dbListener = new MyDbListener();

    // Dengarkan semua kejadian database
    $eventsManager->attach(
        "db",
        $dbListener
    );

Profile data yang dihasilkan dapat diperoleh dari listener:

.. code-block:: php

    <?php

    // Kirim perintah SQL ke server database
    $connection->execute(
        "SELECT * FROM products p WHERE p.status = 1"
    );

    foreach ($dbListener->getProfiler()->getProfiles() as $profile) {
        echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
        echo "Start Time: ", $profile->getInitialTime(), "\n";
        echo "Final Time: ", $profile->getFinalTime(), "\n";
        echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }

Menciptakan komponen yang memicu kejadian
-----------------------------------------
Anda dapat menciptakan komponen dalam aplikasi anda yang memicu kejadian ke EventsManager. Sebagai akibatnya, mungkin ada listener lain yang 
bereaksi ketika kejadian ini dibangkitkan. Di contoh berikut, kita menciptakan sebuah komponen bernama called "MyComponent".
Komponen ini peduli EventsManager (ia mengimplementasi :doc:`Phalcon\\Events\\EventsAwareInterface <../api/Phalcon_Events_EventsAwareInterface>`); ketika metode :code:`someTask()` dieksekusi, ia memicu dua kejadian ke tiap listener dalam EventsManager:

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

            // Lakukan tugas
            echo "Here, someTask\n";

            $this->_eventsManager->fire("my-component:afterSomeTask", $this);
        }
    }

Perhatikan di contoh ini kita menggunakan namespace event "my-component". Sekarang kita butuh menciptakan event listener untuk komponen ini:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;

    class SomeListener
    {
        public function beforeSomeTask(Event $event, $myComponent)
        {
            echo "Here, beforeSomeTask\n";
        }

        public function afterSomeTask(Event $event, $myComponent)
        {
            echo "Here, afterSomeTask\n";
        }
    }

Sekarang mari bkita buat semuanya bekerja bersama:

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    // Buat Events Manager
    $eventsManager = new EventsManager();

    // Buat instance MyComponent
    $myComponent = new MyComponent();

    // Ikat eventsManager ke instance tersebut
    $myComponent->setEventsManager($eventsManager);

    // Pasangkan listener ke EventsManager
    $eventsManager->attach(
        "my-component",
        new SomeListener()
    );

    // Eksekusi metode dalam komponen
    $myComponent->someTask();

Saat :code:`someTask()` dieksekusi, dua metode dalam listener akan dieksekusi, menghasilkan output berikut:

.. code-block:: php

    Here, beforeSomeTask
    Here, someTask
    Here, afterSomeTask

Data tambahan dapat juga dilewatkan ketika memicu kejadian menggunakan parameter ketiga :code:`fire()`:

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData);

Dalam sebuah listener parameter ketiga juga menerima data ini:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;

    $eventsManager->attach(
        "my-component",
        function (Event $event, $component, $data) {
            print_r($data);
        }
    );

    // Terima data dari konteks kejadian
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

Perambatan/Pembatalan Event
---------------------------
Banyak listener dapat ditambahkan ke event manager yang sama. Ini artinya untuk kejadian berjenis sama, banyak listener dapat diberitahu.
Listener diberi tahu dalam urutan mereka didaftarkan dalam EventsManager. Beberapa kejadian dapat dibatalkan, yang artinya kejadian 
ini bisa dihentikan sehingga mencegah listener lain diberitahu kejadian ini:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;

    $eventsManager->attach(
        "db",
        function (Event $event, $connection) {
            // We stop the event if it is cancelable
            if ($event->isCancelable()) {
                // Stop the event, so other listeners will not be notified about this
                $event->stop();
            }

            // ...
        }
    );

Defaultnya, event dapat dibatalkan, bahkan sebagian besar kejadian yang dihasilkan oleh framework dapat dibatalkan. Anda dapat memicu kejadian yang tidak dapat dibatalkan
dengan melewatkan :code:`false` di parameter keempat :code:`fire()`:

.. code-block:: php

    <?php

    $eventsManager->fire("my-component:afterSomeTask", $this, $extraData, false);

Prioritas Listener
------------------
Ketika memasang listener anda dapat menentukan prioritas tertentu. Dengan fitur ini anda dapat memasang listener dengan mengindikasi urutan
mereka harus dipanggil:

.. code-block:: php

    <?php

    $eventsManager->enablePriorities(true);

    $eventsManager->attach("db", new DbListener(), 150); // More priority
    $eventsManager->attach("db", new DbListener(), 100); // Normal priority
    $eventsManager->attach("db", new DbListener(), 50);  // Less priority

Mengumpulkan Response
---------------------
Event manager dapat mengumpulkan tiap response yang dikembalikan oleh semua listener yang diberitahu. Contoh ini menjelaskan bagaimana ia bekerja:

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    $eventsManager = new EventsManager();

    // Siapkan event manager untuk mengumpulkan response
    $eventsManager->collectResponses(true);

    // Pasang sebuah listener
    $eventsManager->attach(
        "custom:custom",
        function () {
            return "first response";
        }
    );

    // Pasang listener
    $eventsManager->attach(
        "custom:custom",
        function () {
            return "second response";
        }
    );

    // Picu kejadian
    $eventsManager->fire("custom:custom", null);

    // Ambil semua response yang terkumpul
    print_r($eventsManager->getResponses());

Contoh diatas menghasilkan:

.. code-block:: html

    Array ( [0] => first response [1] => second response )

Mengimplementasi EventsManager sendiri
--------------------------------------
Interface :doc:`Phalcon\\Events\\ManagerInterface <../api/Phalcon_Events_ManagerInterface>` harus diimplementasi untuk menciptakan 
EventsManager anda sendiri menggantikan yang disediakan Phalcon.
