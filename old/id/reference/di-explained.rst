Dependency Injection Explained
==============================

Contoh berikut ini agak panjang, namun ia mencoba menjelaskan mengapa Phalcon menggunakan lokasi service (service location) dan injeksi ketergantungan (dependency injection).
Pertama, anggap kita mengembangkan sebuah komponen bernama SomeComponent. Ia mengerjakan tugas yang saat ini tidak penting.
Komponen kita punya ketergantungan yakni koneksi ke sebuah database.

Di contoh pertama, koneksi diciptakan dalam komponen. Pendekatan ini tidak praktis; karena
kita tidak dapat mengganti parameter koneksi atau tipe sistem database karena komponen ini hanya bekerja saat diciptakan.

.. code-block:: php

    <?php

    class SomeComponent
    {
        /**
         * Penciptaan koneksi di hardcode didalam
         * komponen, sehingga sulit mengganti secara eksternal
         * atau mengganti perilakunya
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

Untuk memecahkan ini, kita menciptakan setter yang menginjeksi ketergantungan dari luar sebelum menggunakan. Untuk sekarang, ini sepertinya
solusi bagus:

.. code-block:: php

    <?php

    class SomeComponent
    {
        protected $_connection;

        /**
         * Set koneksi dari eksternal
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

    // Buat koneksi
    $connection = new Connection(
        [
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo",
        ]
    );

    // Injeksi koneksi dalam komponen
    $some->setConnection($connection);

    $some->someDbTask();

Sekarang anggap kita menggunakan komponen ini dalam bagian berbeda di aplikasi dan
kita akan membutuhkan untuk menciptakan koneksi  beberapa kali sebelum melewatkannya ke komponen.
Menggunakan semacam registry global dimana kita memperoleh instance koneksi dan tidak perlu
menciptakannya lagi dan lagi dapat memecahkan hal ini:

.. code-block:: php

    <?php

    class Registry
    {
        /**
         * Kembalikan koneksi
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
         * Set koneksi dari ekternal
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

    // Lewatkan koneksi yang terdefinisi dalam registry
    $some->setConnection(Registry::getConnection());

    $some->someDbTask();

Sekarang, bayangkan kita harus mengimplementasi dua metode dalam komponen, yang pertama selalu butuh menciptakan koneksi baru dan yang kedua selalu perlu menggunakan koneksi berbagi:

.. code-block:: php

    <?php

    class Registry
    {
        protected static $_connection;

        /**
         * Buat koneksi
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
         * Buat koneksi sekali dan kembalikan
         */
        public static function getSharedConnection()
        {
            if (self::$_connection === null) {
                self::$_connection = self::_createConnection();
            }

            return self::$_connection;
        }

        /**
         * Selalu kembalikan koneksi baru
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
         * Set koneksi dari luar
         */
        public function setConnection($connection)
        {
            $this->_connection = $connection;
        }

        /**
         * Metode ini butuh koneksi berbagi
         */
        public function someDbTask()
        {
            $connection = $this->_connection;

            // ...
        }

        /**
         * metode ini selalu butuh koneksi baru
         */
        public function someOtherDbTask($connection)
        {

        }
    }

    $some = new SomeComponent();

    // Injeksi koneksi berbagi
    $some->setConnection(
        Registry::getSharedConnection()
    );

    $some->someDbTask();

    // Lewatkan koneksi baru
    $some->someOtherDbTask(
        Registry::getNewConnection()
    );

Sejauh ini kita telah melihat bagaimana dependency injection memecahkan masalah kita. Melewatkan ketergantungan sebagai argumen daripada
menciptakannya secara internal dalam kode membuat aplikasi kita lebih mudah dikelola dan terpisah (decoupled). Namun, di jangka panjang,
bentuk injeksi ketergantungan ini punya kekurangan.

Contoh, jika komponen punya banyak ketergantungan, kita akan butuh menciptakan banyak argumen setter untuk melewatkan
ketergantungan atau menciptakan sebuah kontruktor yang melewatkannya dalam banyak argumen, ditambah lagi menciptakan ketergantungan
sebelum menggunakan komponen, setiap kali, menjadikan kode kita tidak mudah dikelola seperti yang kita mau:

.. code-block:: php

    <?php

    // Buat ketergantungan atau ambil dari registry
    $connection = new Connection();
    $session    = new Session();
    $fileSystem = new FileSystem();
    $filter     = new Filter();
    $selector   = new Selector();

    // Lewatkan sebagai parameter konstruktor
    $some = new SomeComponent($connection, $session, $fileSystem, $filter, $selector);

    // ... atau menggunakan setter
    $some->setConnection($connection);
    $some->setSession($session);
    $some->setFileSystem($fileSystem);
    $some->setFilter($filter);
    $some->setSelector($selector);

Bayangkan bila kita harus menciptakan objek ini di banyak bagian aplikasi kita. Di masa datang, jika kita tidak lagi butuh ketergantungan,
kita butuh menjelajahi semua kode untuk menghapus parameter di tiap kontruktor atau setter dimana kita injeksi kode. Untuk memecahkan hal ini,
kita kembali ke registry global untuk menciptakan komponen. Namun, ia menambah lapisan abstraksi baru sebelum menciptakan
objek:

.. code-block:: php

    <?php

    class SomeComponent
    {
        // ...

        /**
         * Buat metode factory untuk menciptakan instance SomeComponent dan menginjeksi ketergantungan
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

Sekarang kita kembali ka awal, kita kembali membuat ketergantungan dalam komponen! Kita harus menemukan solusi yang
menghindarkan kita dari praktek buruk.

Cara praktis dan elegan untuk menyelesaikan masalah ini adalah menggunakan sebuah kontainer untuk ketergantungan. Kontainer bertindak sebagai registry global
yang kita lihat sebelumnya. Menggunakan kontainer sebagai jembatan untuk memperoleh ketergantungan memungkinkan kita menurunkan kompleksitas
komponen kita:

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
            // Ambil service koneksi
            // selalu kembalikan koneksi baru
            $connection = $this->_di->get("db");
        }

        public function someOtherDbTask()
        {
            // ambil koneksi berbagi
            // ini akan selalu mengembalikan koneksi yang sama
            $connection = $this->_di->getShared("db");

            // This method also requires an input filtering service
            $filter = $this->_di->get("filter");
        }
    }

    $di = new Di();

    // Daftarkan service "db" dalam kontainer
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

    // Daftarkan service "filter" dalam kontainer
    $di->set(
        "filter",
        function () {
            return new Filter();
        }
    );

    // Daftarkan service "session" dalam kontainer
    $di->set(
        "session",
        function () {
            return new Session();
        }
    );

    // Lewatkan kontainer service ke komponen
    $some = new SomeComponent($di);

    $some->someDbTask();

Komponen sekarang dapat dengan mudah mengakses service yang diperlukan ketika membutuhkannya, bila tidak dibutuhkan ia tidak akan menginisialisasi service tersebut,
sehingga menghemat resource. Komponen saat ini terpisah (highly decoupled). Contoh, kita dapat mengganti cara bagaimana koneksi dibuat,
perilakunya atau aspek lain darinya dan tidak akan berpengaruh ke komponen.
