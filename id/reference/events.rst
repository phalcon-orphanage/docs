Events Manager
==============

Tugas komponen ini adalah mengintersepsi eksekusi sebagian besar komponen lain dalam framework dengan menciptakan "hook points". Hook
point ini memungkinkan developer mendapatkan informasi status, manipulasi data atau  mengubah alir eksekusi selama proses sebuah komponen.

Contoh Penggunaan
-------------
Di contoh berikut, kita menggunakan EventsManager untuk mendengarkan kejadian yabg dihasilkan oleh koneksi MySQL yang dikelola :doc:`Phalcon\\Db <../api/Phalcon_Db>`.
Pertama, kita perlu sebuah objek listener untuk melakukannya. Kita menciptakan sebuah kelas yang metodenya adalah event yang ingin kita dengarkan:

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

Kelas baru ini bisa sebanyak yang kita mau. EventsManager akan menghubungkan komponen dan kelas listener kita sehingga menyediakan,
hook points berdasarkan metode yag kita definisi di kelas listener kita:

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    $eventsManager = new EventsManager();

    // Buat sebuah listener database
    $dbListener    = new MyDbListener();

    // Dengarkan semua kejadian database
    $eventsManager->attach('db', $dbListener);

    $connection    = new DbAdapter(
        array(
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo"
        )
    );

    // Pasang eventsManager ke instance adapter db
    $connection->setEventsManager($eventsManager);

    // Kirim perintah SQL ke server database
    $connection->query("SELECT * FROM products p WHERE p.status = 1");

Untuk dapat mencatat semua perintah SQl yang dieksekusi oleh aplikasi kita, kita perlu menggunakan event “afterQuery”. Parameter pertama yang dilewatkan ke
event listener berisi informasi kontekstual tentang event  yang sedang berjalan, kedua adalah koneksinya.

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

Sebagai bagian dari contoh ini, kita akan mengimplementasi :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` untuk mendeteksi perintah SQL yang butuh waktu lama dari biasanya:

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
        public function beforeQuery($event, $connection)
        {
            $this->_profiler->startProfile($connection->getSQLStatement());
        }

        /**
         * Ini dieksekusi ketika event dipicu adalah 'afterQuery'
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

Data profile yang dihasilkan dapat diperoleh dari listener:

.. code-block:: php

    <?php

    // Kirim perintah SQL ke server database
    $connection->execute("SELECT * FROM products p WHERE p.status = 1");

    foreach ($dbListener->getProfiler()->getProfiles() as $profile) {
        echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
        echo "Start Time: ", $profile->getInitialTime(), "\n";
        echo "Final Time: ", $profile->getFinalTime(), "\n";
        echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }

Dengan cara yang sama, kita dapat mendaftarkan fungsi lambda untuk menjalankan tugas daripada menggunakan kelas listener terpisah (seperti yang terlihat di atas):

.. code-block:: php

    <?php

    // Dengarkan semua kejadian database
    $eventsManager->attach('db', function ($event, $connection) {
        if ($event->getType() == 'afterQuery') {
            echo $connection->getSQLStatement();
        }
    });

Menciptakan komponen yang memicu kejadian
-----------------------------------------
Anda dapat menciptakan komponen dalam aplikasi anda yang memicu kejadian ke EventsManager. Sebagai akibatnya, mungkin ada listener lain yang 
bereaksi ketika kejadian ini dibangkitkan. Di contoh berikut, kita menciptakan sebuah komponen bernama called "MyComponent".
Komponen ini peduli EventsManager (ia mengimplementasi :doc:`Phalcon\\Events\\EventsAwareInterface <../api/Phalcon_Events_EventsAwareInterface>`); ketika metode :code:`someTask()` dieksekusi, ia memicu dua kejadian ke tiap listener dalam EventsManager:

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

            // Lakukan tugas
            echo "Here, someTask\n";

            $this->_eventsManager->fire("my-component:afterSomeTask", $this);
        }
    }

Perhatikan bahwa kejadian yang dihasilkan komponen ini diawali dengan "my-component". Ini adalah kata unik yang membantu kita
mengenali kejadian yang dibangkitkan komponen tertentu. Anda bahkan dapat menghasilkan kejadian diluar komponen dengan
nama sama. Sekarang buat sebuah listener untuk komponen ini:

.. code-block:: php

    <?php

    class SomeListener
    {
        public function beforeSomeTask($event, $myComponent)
        {
            echo "Here, beforeSomeTask\n";
        }

        public function afterSomeTask($event, $myComponent)
        {
            echo "Here, afterSomeTask\n";
        }
    }

Sebuah listener hanyalah sebuah kelas yang mengimplementasi salah satu kejadian yang dipicu oleh komponen. Sekarang mari kita buat semuanya bekerja bersama:

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;

    // Buat Events Manager
    $eventsManager = new EventsManager();

    // Buat instance MyComponent
    $myComponent   = new MyComponent();

    // Ikat eventsManager ke instance tersebut
    $myComponent->setEventsManager($eventsManager);

    // Pasangkan listener ke EventsManager
    $eventsManager->attach('my-component', new SomeListener());

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

    // Terima data dalam parameter ketiga
    $eventsManager->attach('my-component', function ($event, $component, $data) {
        print_r($data);
    });

    // Terima data dak konteks kejadian
    $eventsManager->attach('my-component', function ($event, $component) {
        print_r($event->getData());
    });

Jika sebuah listener hanya tertarik mendengarkan jenis kejadian tertentu, anda dapat memasang sebuah listener langsung:

.. code-block:: php

    <?php

    // Handler hanya akan dieksekusi jika kejadian yang dipicu adalah "beforeSomeTask"
    $eventsManager->attach('my-component:beforeSomeTask', function ($event, $component) {
        // ...
    });

Perambatan/Pembatalan Event
---------------------------
Banyak listener dapat ditambahkan ke event manager yang sama. Ini artinya untuk kejadian berjenis sama, banyak listener dapat diberitahu.
Listener diberi tahu dalam urutan mereka didaftarkan dalam EventsManager. Beberapa kejadian dapat dibatalkan, yang artinya kejadian 
ini bisa dihentikan sehingga mencegah listener lain diberitahu kejadian ini:

.. code-block:: php

    <?php

    $eventsManager->attach('db', function ($event, $connection) {

        // Kita stop kejadian jika dapat dibatalkan
        if ($event->isCancelable()) {
            // Stop kejadian, sehingga listener lain tidak diberitahu tentang kejadian ini
            $event->stop();
        }

        // ...

    });

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

    $eventsManager->attach('db', new DbListener(), 150); // More priority
    $eventsManager->attach('db', new DbListener(), 100); // Normal priority
    $eventsManager->attach('db', new DbListener(), 50);  // Less priority

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
    $eventsManager->attach('custom:custom', function () {
        return 'first response';
    });

    // Pasang listener
    $eventsManager->attach('custom:custom', function () {
        return 'second response';
    });

    // Picu kejadian
    $eventsManager->fire('custom:custom', null);

    // Ambil semua response yang terkumpul
    print_r($eventsManager->getResponses());

Contoh diatas menghasilkan:

.. code-block:: html

    Array ( [0] => first response [1] => second response )

Mengimplementasi EventsManager sendiri
--------------------------------------
Interface :doc:`Phalcon\\Events\\ManagerInterface <../api/Phalcon_Events_ManagerInterface>` harus diimplementasi untuk menciptakan 
EventsManager anda sendiri menggantikan yang disediakan Phalcon.
