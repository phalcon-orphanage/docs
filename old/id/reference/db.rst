Lapisan Abstraksi Database
==========================

:doc:`Phalcon\\Db <../api/Phalcon_Db>` adalah komponen di belakang :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` yang memberi tenaga lapisan model
dalam framework. Ia terdiri atas lapisan abstraksi independen terhadap sistem database, yang ditulis sepenuhnya dalam C.

Komponen ini memungkinkan manipulasi database level bawah menggunakan model tradisional.

.. highlights::

    Panduan ini tidak dimaksudkan sebagai dokumentasi lengkap metode yang tersedia dan argumennya. Silakan kunjungi :doc:`API <../api/index>`
    untuk referensi lengkap.

Adapter Database
----------------
Komponen ini menggunakan adapter untuk membungkus detil spesifik sistem database. Phalcon menggunakan PDO_ untuk menyambung ke database. Engine
database berikut didukung:

+-----------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Class                                                                                   | Keterangan                                                                                                                                                                                                                        |
+=========================================================================================+===================================================================================================================================================================================================================================+
| :doc:`Phalcon\\Db\\Adapter\\Pdo\\Mysql <../api/Phalcon_Db_Adapter_Pdo_Mysql>`           | Sistem manajemen database relasional (RDBMS) yang paling banyak digunakan di dunia yang berjalan sebagai sebuah server yang meneyediakan akses banyak pengguna ke sejumlah database                                               |
+-----------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Db\\Adapter\\Pdo\\Postgresql <../api/Phalcon_Db_Adapter_Pdo_Postgresql>` | PostgreSQL adalah sistem database relasional open source yang bertenaga. Ia aktif dikembangkan lebih dari 15 tahun dan memiliki arsitektur teruji yang telah memperoleh reputasi untuk keandalan, integritasi data dan kebenaran. |
+-----------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Db\\Adapter\\Pdo\\Sqlite <../api/Phalcon_Db_Adapter_Pdo_Sqlite>`         | SQLite adalah pustaka software yang mengimplementasi engine SQL database transaksional yang berdiri sendiri, tanpa server dan tanpa konfigurasi                                                                                   |
+-----------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

Mengimplementasi Adapter anda sendiri
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Interface :doc:`Phalcon\\Db\\AdapterInterface <../api/Phalcon_Db_AdapterInterface>` harus diimplementasi untuk dapat menciptakan apater database
anda sendiri atau mengembangkan yang sudah ada.

Dialek Database
---------------
Phalcon membungkus detil spesifik tiap engine database dalam dialek. Mereka menyediakan fungsi umum dan pembangkit SQL untuk adapter.

+--------------------------------------------------------------------------------+-----------------------------------------------------+
| Class                                                                          | Keterangan                                          |
+================================================================================+=====================================================+
| :doc:`Phalcon\\Db\\Dialect\\Mysql <../api/Phalcon_Db_Dialect_Mysql>`           | Dialek SQL spesifik untuk sistem database MySQL     |
+--------------------------------------------------------------------------------+-----------------------------------------------------+
| :doc:`Phalcon\\Db\\Dialect\\Postgresql <../api/Phalcon_Db_Dialect_Postgresql>` | Dialek SQL spesifik untuk sistem database PostgreSQL|
+--------------------------------------------------------------------------------+-----------------------------------------------------+
| :doc:`Phalcon\\Db\\Dialect\\Sqlite <../api/Phalcon_Db_Dialect_Sqlite>`         | Dialek SQL spesifik untuk sistem database SQLite    |
+--------------------------------------------------------------------------------+-----------------------------------------------------+

Mengimplementasi dialek anda sendiri
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Interface :doc:`Phalcon\\Db\\DialectInterface <../api/Phalcon_Db_DialectInterface>` harus diimplementasi untuk dapat menciptakan dialek database anda sendiri atau mengembangkan yang sudah ada.

Menyambung ke Database
----------------------
Untuk menciptakan koneksi harus dilakukan dengan menciptakan kelas adapter. Butuh sebuah array berisi parameter koneksi. Contoh
dibawah menunjukkan bagaimana menciptakan sebuah koneksi dengan melewatkan parameter wajib dan tidak:

.. code-block:: php

    <?php

    // Wajib
    $config = [
        "host"     => "127.0.0.1",
        "username" => "mike",
        "password" => "sigma",
        "dbname"   => "test_db",
    ];

    // Opsional
    $config["persistent"] = false;

    // Buat koneksi
    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config);

.. code-block:: php

    <?php

    // wajib
    $config = [
        "host"     => "localhost",
        "username" => "postgres",
        "password" => "secret1",
        "dbname"   => "template",
    ];

    // Opsional
    $config["schema"] = "public";

    // Buat koneksi
    $connection = new \Phalcon\Db\Adapter\Pdo\Postgresql($config);

.. code-block:: php

    <?php

    // Wajib
    $config = [
        "dbname" => "/path/to/database.db",
    ];

    // Buat koneksi
    $connection = new \Phalcon\Db\Adapter\Pdo\Sqlite($config);

Menyiapkan opsi tambahan PDO
----------------------------
Anda dapat mengatur opsi PDO saat konkesi dengan melewatkan parameter 'options':

.. code-block:: php

    <?php

    // Buat koneksi dengan opsi PDO
    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(
        [
            "host"     => "localhost",
            "username" => "root",
            "password" => "sigma",
            "dbname"   => "test_db",
            "options"  => [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
                PDO::ATTR_CASE               => PDO::CASE_LOWER,
            ]
        ]
    );

Mencari Row
-----------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` menyediakan beberapa metode untuk query baris ke tabel. Sintaks SQL spesifik target engine database diperlukan dalam hal ini:

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots ORDER BY name";

    // Kirim pernyataan SQL ke sistem database
    $result = $connection->query($sql);

    // Cetak nama tiap robot
    while ($robot = $result->fetch()) {
       echo $robot["name"];
    }

    // Dapatkan semua row dalam sebuah array
    $robots = $connection->fetchAll($sql);
    foreach ($robots as $robot) {
       echo $robot["name"];
    }

    // Ambil baris pertama saja
    $robot = $connection->fetchOne($sql);

Secara default pemanggilan ini menciptakan array dengan indeks asosiatif dan numerik. Anda dapat mengubah perilaku ini menggunakan :code:`Phalcon\Db\Result::setFetchMode()`. Mteode ini menerima sebuah konstan, yang menentukan tipe indeks yang diperlukan.

+---------------------------------+-----------------------------------------------------------+
| Konstan                         | Keterangan                                                |
+=================================+===========================================================+
| :code:`Phalcon\Db::FETCH_NUM`   | Kembalikan array dengan indeks numerik                    |
+---------------------------------+-----------------------------------------------------------+
| :code:`Phalcon\Db::FETCH_ASSOC` | Kembalikan array dengan indeks asosiatif                  |
+---------------------------------+-----------------------------------------------------------+
| :code:`Phalcon\Db::FETCH_BOTH`  | Kembalikan array dengan indeks asosiatif dan numerik      |
+---------------------------------+-----------------------------------------------------------+
| :code:`Phalcon\Db::FETCH_OBJ`   | Kembalikan objek daripada array                           |
+---------------------------------+-----------------------------------------------------------+

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots ORDER BY name";
    $result = $connection->query($sql);

    $result->setFetchMode(Phalcon\Db::FETCH_NUM);
    while ($robot = $result->fetch()) {
       echo $robot[0];
    }

:code:`Phalcon\Db::query()` mengembalikan instance :doc:`Phalcon\\Db\\Result\\Pdo <../api/Phalcon_Db_Result_Pdo>`. Objek ini membungkus semua fungsionalitas terkait result set yang dikembalikan yakni menelusuri, mencari record tertentu, jumlah dan lain-lain.

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots";
    $result = $connection->query($sql);

    // Menelusuri resultset
    while ($robot = $result->fetch()) {
       echo $robot["name"];
    }

    // Mencari row ketiga
    $result->seek(2);
    $robot = $result->fetch();

    // Hitung jumlah resultset
    echo $result->numRows();

Mengikat Parameter
------------------
Parameter terikat juga didukung :doc:`Phalcon\\Db <../api/Phalcon_Db>`. Meski ada dampak kecil di performa dengan menggunakan
parameter terikat, anda disarankan untuk menggunakan metodologi ini untuk menghilangkan kemungkinan kode anda terkena serangan SQL
injection. Baik string maupun positional placeholder didukung. Mengikat parameter dapat dilakukan seperti berikut:

.. code-block:: php

    <?php

    // Mengikat dengan placeholder numerik
    $sql    = "SELECT * FROM robots WHERE name = ? ORDER BY name";
    $result = $connection->query(
        $sql,
        [
            "Wall-E",
        ]
    );

    // Mengikat dengan placeholder bernama
    $sql     = "INSERT INTO `robots`(name`, year) VALUES (:name, :year)";
    $success = $connection->query(
        $sql,
        [
            "name" => "Astro Boy",
            "year" => 1952,
        ]
    );

Ketika menggunakan placeholder numerik, anda akan harus menentukannya sebagai integer yakni 1 atau 2. Untuk kasus "1" atau "2"
mereka dianggap string dan bukan integer, sehingga placeholder tidak dapat diganti dengan benar. Dengan sembarang adapter
data otomatis di escape menggunakan `PDO Quote <http://www.php.net/manual/en/pdo.quote.php>`_.

Fungsi ini memerhitungkan connection charset, sehingga disarankan untuk menentukan charset yang benar
dalam parameter koneksi atau dalam konfigurasi server database, karena charset
keliru akan menghasilkan dampak tidak diinginkan ketika menyimpan atau mangambil data.

Anda dapat juga melewatkan parameter langsung ke metode execute/query. untuk hal ini
parameter terikat langsung dilewatkan ke PDO:

.. code-block:: php

    <?php

    // Mengikat placeholder PDO
    $sql    = "SELECT * FROM robots WHERE name = ? ORDER BY name";
    $result = $connection->query(
        $sql,
        [
            1 => "Wall-E",
        ]
    );

Menambah/Mengubah/Menghapus Row
-------------------------------
Untuk menambah, mengubah atau menghapus row, anda dapat menggunakan SQL atau menggunakan fungsi yang telah tersedia  oleh kelas ini:

.. code-block:: php

    <?php

    // Menambah data dengan perintah SQL
    $sql     = "INSERT INTO `robots`(`name`, `year`) VALUES ('Astro Boy', 1952)";
    $success = $connection->execute($sql);

    // Dengan placeholder
    $sql     = "INSERT INTO `robots`(`name`, `year`) VALUES (?, ?)";
    $success = $connection->execute(
        $sql,
        [
            "Astro Boy",
            1952,
        ]
    );

    // Membangkitkan SQL yang diperlukan secara dinamis
    $success = $connection->insert(
        "robots",
        [
            "Astro Boy",
            1952,
        ],
        [
            "name",
            "year",
        ],
    );

    // Membangkitkan SQL yang diperlukan secara dinamis (sintaks lain)
    $success = $connection->insertAsDict(
        "robots",
        [
            "name" => "Astro Boy",
            "year" => 1952,
        ]
    );

    // Mengubah data dengan pernyataan SQL
    $sql     = "UPDATE `robots` SET `name` = 'Astro boy' WHERE `id` = 101";
    $success = $connection->execute($sql);

    // Dengan placeholders
    $sql     = "UPDATE `robots` SET `name` = ? WHERE `id` = ?";
    $success = $connection->execute(
        $sql,
        [
            "Astro Boy",
            101,
        ]
    );

    // Membangkitkan SQL yang diperlukan secara dinamis
    $success = $connection->update(
        "robots",
        [
            "name",
        ],
        [
            "New Astro Boy",
        ],
        "id = 101" // Peringatan! Disini, nilainya tidak di escape
    );

    // Membangkitkan SQL yang diperlukan secara dinamis (sintaks lain)
    $success = $connection->updateAsDict(
        "robots",
        [
            "name" => "New Astro Boy",
        ],
        "id = 101" // Peringatan! Disini, nilainya tidak di escape
    );

    // Dengan kondisi escape
    $success = $connection->update(
        "robots",
        [
            "name",
        ],
        [
            "New Astro Boy",
        ],
        [
            "conditions" => "id = ?",
            "bind"       => [101],
            "bindTypes"  => [PDO::PARAM_INT], // Parameter opsional
        ]
    );
    $success = $connection->updateAsDict(
        "robots",
        [
            "name" => "New Astro Boy",
        ],
        [
            "conditions" => "id = ?",
            "bind"       => [101],
            "bindTypes"  => [PDO::PARAM_INT], // Parameter opsional
        ]
    );

    // Menghapus data dengan pernyataan SQL
    $sql     = "DELETE `robots` WHERE `id` = 101";
    $success = $connection->execute($sql);

    // Dengan placeholder
    $sql     = "DELETE `robots` WHERE `id` = ?";
    $success = $connection->execute($sql, [101]);

    // Membangkitkan SQL yang diperlukan secara dinamis
    $success = $connection->delete(
        "robots",
        "id = ?",
        [
            101,
        ]
    );

Transaksi dan Transaksi Bersarang
---------------------------------
Bekerja dengan transaksi didukung seperti halnya dengan PDO. Melakukan manipulasi data dalam transaksi
sering kali menaikkan performa pada sebagian besar sistem database:

.. code-block:: php

    <?php

    try {
        // Mulai transaksi
        $connection->begin();

        // Eksekusi beberapa pernyataan SQL
        $connection->execute("DELETE `robots` WHERE `id` = 101");
        $connection->execute("DELETE `robots` WHERE `id` = 102");
        $connection->execute("DELETE `robots` WHERE `id` = 103");

        // Commit jika semuanya berjalan baik
        $connection->commit();
    } catch (Exception $e) {
        // Exception terjadi rollback transaksi
        $connection->rollback();
    }

Sebagai tambahan transaksi baku, :doc:`Phalcon\\Db <../api/Phalcon_Db>` menyediakan dukungan bawaan untuk `transaksi bersarang`_
(jika sistem database yang digunakan mendukung). Ketika anda memanggil begin() untuk kedua kali sebuah transaksi bersarang
diciptakan:

.. code-block:: php

    <?php

    try {
        // Mulai sebuah transaksi
        $connection->begin();

        // Eksekusi pernyataan SQL
        $connection->execute("DELETE `robots` WHERE `id` = 101");

        try {
            // Mulai transaksi bersarang
            $connection->begin();

            // Execute these SQL statements into the nested transaction
            $connection->execute("DELETE `robots` WHERE `id` = 102");
            $connection->execute("DELETE `robots` WHERE `id` = 103");

            // Buat save point
            $connection->commit();
        } catch (Exception $e) {
            // Kesalahan terjadi, lepaskan transaksi bersarang
            $connection->rollback();
        }

        // Lanjutkan, eksekusi pernyataan SQL lain
        $connection->execute("DELETE `robots` WHERE `id` = 104");

        // Commit jika semua berjalan baik
        $connection->commit();
    } catch (Exception $e) {
        // Kesalahan terjadi, batalkan transaksi
        $connection->rollback();
    }

Kejadian Database
-----------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` mampu mengirim kejadian ke sebuah :doc:`EventsManager <events>` jika ada. Beberapa kejadian yang ketika mengembalikan nilai boolean false dapat menghentikan operasi yang aktif. Kejadian berikut didukung:

+---------------------+-----------------------------------------------------------+---------------------+
| Nama Event          | Dipicu                                                    | Bisa stop operasi?  |
+=====================+===========================================================+=====================+
| afterConnect        | Setelah koneksi sukses ke sistem database                 | Tidak               |
+---------------------+-----------------------------------------------------------+---------------------+
| beforeQuery         | Sebelum mengirim pernyataan SQL ke sistem database        | Ya                  |
+---------------------+-----------------------------------------------------------+---------------------+
| afterQuery          | Setelah mengirim pernyataan SQL ke sistem database        | Tidak               |
+---------------------+-----------------------------------------------------------+---------------------+
| beforeDisconnect    | Sebelum menutup koneksi database sementara                | Tidak               |
+---------------------+-----------------------------------------------------------+---------------------+
| beginTransaction    | Sebelum memulai transaksi                                 | Tidak               |
+---------------------+-----------------------------------------------------------+---------------------+
| rollbackTransaction | Sebelum membatalkan transaksi                             | Tidak               |
+---------------------+-----------------------------------------------------------+---------------------+
| commitTransaction   | Sebelum commit transaksi                                  | Tidak               |
+---------------------+-----------------------------------------------------------+---------------------+

Mengikat sebuah EventsManager ke sebuah koneksi mudah, :doc:`Phalcon\\Db <../api/Phalcon_Db>` akan memicu kejadian bertipe "db":

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Adapter\Pdo\Mysql as Connection;

    $eventsManager = new EventsManager();

    // Pantau semua kejadian database
    $eventsManager->attach('db', $dbListener);

    $connection = new Connection(
        [
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo",
        ]
    );

    // Salin eventsManager ke instance adapter db
    $connection->setEventsManager($eventsManager);

Menghentikan operasi SQL berguna jika misalnya anda ingin membuat implementasi penguji SQL injeksi:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;

    $eventsManager->attach(
        "db:beforeQuery",
        function (Event $event, $connection) {
            $sql = $connection->getSQLStatement();

            // Uji untuk kata-kata berbahaya dalam pernyataan SQL
            if (preg_match("/DROP|ALTER/i", $sql)) {
                // Operasi DROP/ALTER tidak izinkan di aplikasi ini,
                // Ini pastinya SQL injection!
                return false;
            }

            // OK
            return true;
        }
    );

Profiling SQL Statements
------------------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` menyertakan komponen profiling bernama :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>`, yang digunakan untuk menganalisa performa operasi database juga mendiagnosa masalah performa dan menemukan bottleneck.

Profiling database sangat mudah dengan :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>`:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Profiler as DbProfiler;

    $eventsManager = new EventsManager();

    $profiler = new DbProfiler();

    // Pantau semua kejadian database
    $eventsManager->attach(
        "db",
        function (Event $event, $connection) use ($profiler) {
            if ($event->getType() === "beforeQuery") {
                $sql = $connection->getSQLStatement();

                // Mulai profil koneksi aktif
                $profiler->startProfile($sql);
            }

            if ($event->getType() === "afterQuery") {
                // Hentikan profil aktif
                $profiler->stopProfile();
            }
        }
    );

    // Salin eventsManager ke connection
    $connection->setEventsManager($eventsManager);

    $sql = "SELECT buyer_name, quantity, product_name "
         . "FROM buyers "
         . "LEFT JOIN products ON buyers.pid = products.id";

    // Eksekusi perintah SQL
    $connection->query($sql);

    // Ambil profil terakhir dari profiler
    $profile = $profiler->getLastProfile();

    echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
    echo "Start Time: ", $profile->getInitialTime(), "\n";
    echo "Final Time: ", $profile->getFinalTime(), "\n";
    echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";

Anda dapat menciptakan kelas profil anda sendiri berdasar :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` untuk merekam statistik real time perintah yang dikirim ke sistem database:

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Profiler as Profiler;
    use Phalcon\Db\Profiler\Item as Item;

    class DbProfiler extends Profiler
    {
        /**
         * Dieksekusi sebelum perintah SQL dikirim ke server db
         */
        public function beforeStartProfile(Item $profile)
        {
            echo $profile->getSQLStatement();
        }

        /**
         * Dieksekusi setelah perintah SQL dikirim ke server db
         */
        public function afterEndProfile(Item $profile)
        {
            echo $profile->getTotalElapsedSeconds();
        }
    }

    // Buat sebuah Events Manager
    $eventsManager = new EventsManager();

    // Buat pemantau
    $dbProfiler = new DbProfiler();

    // Pasang pemantau untuk memantau semua kejadian database
    $eventsManager->attach("db", $dbProfiler);

Log Perintah SQL
----------------
Menggunakan komponen abstraksi level tinggi seperti :doc:`Phalcon\\Db <../api/Phalcon_Db>` untuk mengakses sebuah database, sulit untuk memahami perintah apa yang dikirim ke sistem database. :doc:`Phalcon\\Logger <../api/Phalcon_Logger>` berinteraksi dengan :doc:`Phalcon\\Db <../api/Phalcon_Db>`, menyediakan kemampuan logging di lapisan abstraksi database.

.. code-block:: php

    <?php

    use Phalcon\Logger;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Logger\Adapter\File as FileLogger;

    $eventsManager = new EventsManager();

    $logger = new FileLogger("app/logs/db.log");

    $eventsManager->attach(
        "db:beforeQuery",
        function (Event $event, $connection) use ($logger) {
            $sql = $connection->getSQLStatement();

            $logger->log($sql, Logger::INFO);
        }
    );

    // Pasang eventsManager ke instance adapter db
    $connection->setEventsManager($eventsManager);

    // Jalankan perintah SQL
    $connection->insert(
        "products",
        [
            "Hot pepper",
            3.50,
        ],
        [
            "name",
            "price",
        ]
    );

Kode di atas, file *app/logs/db.log* akan berisi seperti ini:

.. code-block:: php

    [Sun, 29 Apr 12 22:35:26 -0500][DEBUG][Resource Id #77] INSERT INTO products
    (name, price) VALUES ('Hot pepper', 3.50)


Implementasi Logger anda sendiri
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Anda dapat mengimplementasi kelas logger anda sendiri untuk query database, dengan menciptakan sebuah kelas yang mengimplementasi sebuah metode bernama "log".
Metode ini harus menerima string sebagai argumen pertama. Anda dapat melewatkan objek logging ke :code:`Phalcon\Db::setLogger()`,
dan dari sana tiap perintah SQL yang dijalankan akan memanggil metode tersebut untuk log result.

Deskripsi Tables/Views
----------------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` juga menyediakan metode untuk mendapatkan informasi detil tentang tabel dan view:

.. code-block:: php

    <?php

    // Ambil tabel pada database test_db
    $tables = $connection->listTables("test_db");

    // Apakah ada tabel 'robots' dalam database?
    $exists = $connection->tableExists("robots");

    // Ambil nama, tipe data dan fitur khusus field 'robots'
    $fields = $connection->describeColumns("robots");
    foreach ($fields as $field) {
        echo "Column Type: ", $field["Type"];
    }

    // Ambil indeks pada tabel 'robots'
    $indexes = $connection->describeIndexes("robots");
    foreach ($indexes as $index) {
        print_r(
            $index->getColumns()
        );
    }

    // Ambil foreign keys pada tabel 'robots'
    $references = $connection->describeReferences("robots");
    foreach ($references as $reference) {
        // Cetak kolom yang direferensi
        print_r(
            $reference->getReferencedColumns()
        );
    }

Sebuah deksripsi tabel sangat mirip dengan perintah describe di MySQL, ia berisi informasi berikut:

+-------+----------------------------------------------------+
| Indeks| Keterangan                                         |
+=======+====================================================+
| Field | Nama field                                         |
+-------+----------------------------------------------------+
| Type  | Tipe kolom                                         |
+-------+----------------------------------------------------+
| Key   | Apakah primary key atau index?                     |
+-------+----------------------------------------------------+
| Null  | Kolom ini mengizinkan nilai null?                  |
+-------+----------------------------------------------------+

Metode untuk mendapatkan informasi tenant view juga diimplementasi untuk semua sistem database yang didukung:

.. code-block:: php

    <?php

    // Ambil view pada database test_db
    $tables = $connection->listViews("test_db");

    // Apakah ada view bernama 'robots' di database?
    $exists = $connection->viewExists("robots");

Creating/Altering/Dropping Tables
---------------------------------
Sistem database berbeda (MySQL, Postgresql dan lain-lain.) menyediakan kemampuan untuk menciptakan, mengubah atau menghapus tabel dengan
perintah seperti CREATE, ALTER atau DROP. Sintaks SQL berbeda berdasarkan pada sistem database yang digunakan.
:doc:`Phalcon\\Db <../api/Phalcon_Db>` menawarkan antarmuka seragam untuk mengubah tabel, tanpa perlu
membedakan sintaks SQL berdasarkan target sistem storage.

Menciptakan Tabel
^^^^^^^^^^^^^^^^^
Contoh berikut menunjukkan bagaimana menciptakan sebuah tabel:

.. code-block:: php

    <?php

    use \Phalcon\Db\Column as Column;

    $connection->createTable(
        "robots",
        null,
        [
           "columns" => [
                new Column(
                    "id",
                    [
                        "type"          => Column::TYPE_INTEGER,
                        "size"          => 10,
                        "notNull"       => true,
                        "autoIncrement" => true,
                        "primary"       => true,
                    ]
                ),
                new Column(
                    "name",
                    [
                        "type"    => Column::TYPE_VARCHAR,
                        "size"    => 70,
                        "notNull" => true,
                    ]
                ),
                new Column(
                    "year",
                    [
                        "type"    => Column::TYPE_INTEGER,
                        "size"    => 11,
                        "notNull" => true,
                    ]
                ),
            ]
        ]
    );

:code:`Phalcon\Db::createTable()` menerima array asosiatif yang mendeskripsikan tabel. Kolom ditentukan dengan kelas
:doc:`Phalcon\\Db\\Column <../api/Phalcon_Db_Column>`. tabel di bawah menunjukkan opsi yang tersedia untuk mendefinisikan kolom:

+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| Option          | Keterangan                                                                                                                                 | Opsional |
+=================+============================================================================================================================================+==========+
| "type"          | Tipe kolom. Harus konstan :doc:`Phalcon\\Db\\Column <../api/Phalcon_Db_Column>` (lihat daftar dibawah)                                     | Tidak    |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "primary"       | True jika kolom adalah primary key tabel                                                                                                   | Ya       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "size"          | Beberapa tipe kolom seperti VARCHAR atau INTEGER bisa memiliki size tertentu                                                               | Ya       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "scale"         | Kolom DECIMAL atau NUMBER dapat memiliki skala untuk menentukan berapa desimal yang disimpan                                               | Ya       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "unsigned"      | Kolom INTEGER dapat berupa signed atau unsigned. Opsi ini tidak dapat diterapkan untuk tipe kolom lain                                     | Ya       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "notNull"       | Kolom dapat menyimpan nilai null?                                                                                                          | Ya       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "default"       | Nilai default (ketika digunakan dengan :code:`"notNull" => true`).                                                                         | Ya       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "autoIncrement" | Dengan atribut ini kolom akan diisi dengan integer auto-increment. Hanya satu kolom dalam tabel yang bisa punya atribut ini.               | Ya       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "bind"          | Salah satu konstant BIND_TYPE_* yang menjelaskan bahwiman kolom harus diikat sebelum disimpan                                              | Ya       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "first"         | Kolom harus ditempatkan di posisi pertama dalam urutan kolom                                                                               | Ya       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "after"         | Kolom harus ditempatkan setelah posisi kolom terindikasi                                                                                   | Ya       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+

:doc:`Phalcon\\Db <../api/Phalcon_Db>` mendukung tipe kolom database berikut:

* :code:`Phalcon\Db\Column::TYPE_INTEGER`
* :code:`Phalcon\Db\Column::TYPE_DATE`
* :code:`Phalcon\Db\Column::TYPE_VARCHAR`
* :code:`Phalcon\Db\Column::TYPE_DECIMAL`
* :code:`Phalcon\Db\Column::TYPE_DATETIME`
* :code:`Phalcon\Db\Column::TYPE_CHAR`
* :code:`Phalcon\Db\Column::TYPE_TEXT`

Array asosiatif yang dilewatkan dalam :code:`Phalcon\Db::createTable()` dapat memiliki key berikut:

+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| Index        | Keterangan                                                                                                                             | Opsional |
+==============+========================================================================================================================================+==========+
| "columns"    | Sebuah array dengan himpunan kolom tabel ditentukan oleh :doc:`Phalcon\\Db\\Column <../api/Phalcon_Db_Column>`                         | Tidak    |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "indexes"    | Sebuah array dengan himpunan indeks tabel ditentukan oleh :doc:`Phalcon\\Db\\Index <../api/Phalcon_Db_Index>`                          | Ya       |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "references" | Sebuah array dengan himpunan referensi tabel (foreign key) ditentukan oleh :doc:`Phalcon\\Db\\Reference <../api/Phalcon_Db_Reference>` | Ya       |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "options"    | Sebuah array dengan himpunan opsi pembuatan tabel. Opsi ini terkait dengan sistem database yang migrasi dibuat.                        | Ya       |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+

mengubah Tabel
^^^^^^^^^^^^^^
Saat aplikasi anda tumbuh, anda mungkin perlu mengubah database anda, sebagai bagian dari refactoring atau menambah fitur baru.
Tidak semua sistem database mengizinkan mengubah kolom yang sudah ada atau menamb kolom antara yang sudah ada. :doc:`Phalcon\\Db <../api/Phalcon_Db>`
dibatasi oleh keterbatasan ini.

.. code-block:: php

    <?php

    use Phalcon\Db\Column as Column;

    // Menambah kolom baru
    $connection->addColumn(
        "robots",
        null,
        new Column(
            "robot_type",
            [
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 32,
                "notNull" => true,
                "after"   => "name",
            ]
        )
    );

    // Mengubah kolom yang suadh ada
    $connection->modifyColumn(
        "robots",
        null,
        new Column(
            "name",
            [
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 40,
                "notNull" => true,
            ]
        )
    );

    // Menghapus kolom "name"
    $connection->dropColumn(
        "robots",
        null,
        "name"
    );

Menghapus Tables
^^^^^^^^^^^^^^^^
Contoh menghapus tabel:

.. code-block:: php

    <?php

    // Hapus tabel robot dari database aktif
    $connection->dropTable("robots");

    // Hapus tabel robot dari database "machines"
    $connection->dropTable("robots", "machines");

.. _PDO: http://www.php.net/manual/en/book.pdo.php
.. _`transaksi bersarang`: http://en.wikipedia.org/wiki/Nested_transaction
