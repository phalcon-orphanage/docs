Injeksi Ketergantungan/Lokasi Service
*************************************

.. highlights::

    Before reading this section, it is wise to read :doc:`the section which explains why Phalcon uses service location and dependency injection <di-explained>`.

:doc:`Phalcon\\Di <../api/Phalcon_Di>` adalah komponen yang mengimplementasi Dependency Injection dan Location of services dan merupakan kontainer service.

Karena Phalcon memiliki ketergantungan minimal (highly decoupled), :doc:`Phalcon\\Di <../api/Phalcon_Di>` penting untuk mengintegrasikan beragam komponen framework. Developer dapat
juga menggunakan komponen ini untuk menginjeksi ketergantungan dan mengelola instance global kelas-kelas berbeda yang digunakan aplikasi.

Pada dasarnya, komponen ini mengimplementasi pola `Inversion of Control`_ . Dengan menerapkannya, objek-objek tidak menerima ketergantungannya menggunakan setter atau konstruktor,
namun meminta service dependency injector. Ini menurunkan kompleksitias keseluruhan karena hanya ada
satu cara untuk mendapatkan ketergantungan yang dibutuhkan dalam sebuah komponen.

Tambahan lagi, pola ini menaikkan testabilitas dalam kode, sehingga menjadikannya tidak rawan kesalahan.

Mendaftarkan service dalam Kontainer
====================================
Framework sendiri atau developer dapat mendaftarkan service. Ketika sebuah komponen A membutuhkan komponen B (atau instance kelas itu) untuk bekerja, ia
dapat meminta komponen B dari kontainer, daripada menciptakan instance komponen B baru.

Cara kerja ini memberi kita banyak keuntungan:

* Kita dapat mudah mengganti sebuah komponen dengan milik kita sendiri atau pihak ketiga.
* Kita memiliki kendali penuh atas inisialisasi objek, memungkinkan kita mengatur objek ini sebelum memberikan ke komponen.
* Kita dapat instance global komponen dengan cara yang terstruktur dan menyatu.

Service dapat didaftarkan dengan beberapa jenis definisi:

Regitrasi Sederhana
-------------------
Seperti terlihat sebelumnya, ada beberapa cara untuk mendaftarkan service. Ini kita sebut sederhana:

String
^^^^^^
Jenis mengharapkan nama kelas valid, mengembalikan sebuah objek dari kelas yang ditentukan, jika kelas tidak dimuat ia akan diciptakan menggunakan auto-loader.
Jenis definisi ini tidak mengizinkan untuk menentukan argumen untuk kontruktor kelas atau parameter:

.. code-block:: php

    <?php

    // mengembalikan new Phalcon\Http\Request();
    $di->set(
        "request",
        "Phalcon\\Http\\Request"
    );

Objek
^^^^^
Jenis ini mengharapkan sebuah objek. Karena fakta bahwa objek tidak perlu di resolve karena ia sudah objek,
bisa dibilang ini tidak benar-benar dependency injection,
namun ia berguna jika anda ingin memaksa ketergantungan yang diberikan selalu objek atau nilai yang sama:

.. code-block:: php

    <?php

    use Phalcon\Http\Request;

    // mengembalikan new Phalcon\Http\Request();
    $di->set(
        "request",
        new Request()
    );

Closure/Fungsi Anonymous
^^^^^^^^^^^^^^^^^^^^^^^^
Metode ini menawarkan kebebasan lebih besar dengan membangun ketergantungan sesuai keinginan, namun, ia sulit
mengubah beberapa parameter secara ekternal tanpa mengubah definisi ketergantungan:

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

    $di->set(
        "db",
        function () {
            return new PdoMysql(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "blog",
                ]
            );
        }
    );

Beberapa keterbatasan dapat diatasi dengan melewatkan variabel tambahan ke lingkungan closure:

.. code-block:: php

    <?php

    use Phalcon\Config;
    use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

    $config = new Config(
        [
            "host"     => "127.0.0.1",
            "username" => "user",
            "password" => "pass",
            "dbname"   => "my_database",
        ]
    );

    // Menggunakan variabel $config dalam scope saat ini
    $di->set(
        "db",
        function () use ($config) {
            return new PdoMysql(
                [
                    "host"     => $config->host,
                    "username" => $config->username,
                    "password" => $config->password,
                    "dbname"   => $config->name,
                ]
            );
        }
    );

You can also access other DI services using the :code:`get()` method:

.. code-block:: php

    <?php

    use Phalcon\Config;
    use Phalcon\Db\Adapter\Pdo\Mysql as PdoMysql;

    $di->set(
        "config",
        function () {
            return new Config(
                [
                    "host"     => "127.0.0.1",
                    "username" => "user",
                    "password" => "pass",
                    "dbname"   => "my_database",
                ]
            );
        }
    );

    // Using the 'config' service from the DI
    $di->set(
        "db",
        function () {
            $config = $this->get("config");

            return new PdoMysql(
                [
                    "host"     => $config->host,
                    "username" => $config->username,
                    "password" => $config->password,
                    "dbname"   => $config->name,
                ]
            );
        }
    );

Registrasi Kompleks
-------------------
Jika diperlukan untuk mengubah definisi service tanpa perlu menciptakan/resolve service,
maka, kita butuh menentukan service menggunakan sintaks array. Menentukan service menggunakan definisi array
dapat terlihat lebih ramai:

.. code-block:: php

    <?php

    use Phalcon\Logger\Adapter\File as LoggerFile;

    // Daftarkan service 'logger' dengan nama kelas dan parameter
    $di->set(
        "logger",
        [
            "className" => "Phalcon\\Logger\\Adapter\\File",
            "arguments" => [
                [
                    "type"  => "parameter",
                    "value" => "../apps/logs/error.log",
                ]
            ]
        ]
    );

    // Menggunakan fungsi anonim
    $di->set(
        "logger",
        function () {
            return new LoggerFile("../apps/logs/error.log");
        }
    );

Kedua registrasi service diatas menghasilkan hasil sama. Namun definisi array, memungkinkan pengubahan parameter service bila diperlukan:

.. code-block:: php

    <?php

    // Ubah nama kelas service
    $di->getService("logger")->setClassName("MyCustomLogger");

    // Ubah parameter pertama tanpa menciptakan logger
    $di->getService("logger")->setParameter(
        0,
        [
            "type"  => "parameter",
            "value" => "../apps/logs/error.log",
        ]
    );

Tambahan lagi menggunakan sintaks array anda dapat menggunakan tiga jenis dependency injection:

Injeksi Konstructor
^^^^^^^^^^^^^^^^^^^
Injeksi jenis ini melewatkan ketergantungan/argumen ke konstruktor kelas.
Anggap kita memiliki komponen berikut:

.. code-block:: php

    <?php

    namespace SomeApp;

    use Phalcon\Http\Response;

    class SomeComponent
    {
        /**
         * @var Response
         */
        protected $_response;

        protected $_someFlag;



        public function __construct(Response $response, $someFlag)
        {
            $this->_response = $response;
            $this->_someFlag = $someFlag;
        }
    }

Service ini dapat didaftarkan dengan cara berikut:

.. code-block:: php

    <?php

    $di->set(
        "response",
        [
            "className" => "Phalcon\\Http\\Response"
        ]
    );

    $di->set(
        "someComponent",
        [
            "className" => "SomeApp\\SomeComponent",
            "arguments" => [
                [
                    "type" => "service",
                    "name" => "response",
                ],
                [
                    "type"  => "parameter",
                    "value" => true,
                ],
            ]
        ]
    );

Service "response" (:doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>`) di resolve lalu dilewatkan ke argumen pertama konstruktor,
sedangkan yang kedua adalah nilai boolean (true) yang dilewatkan apa adanya.

Injeksi Setter
^^^^^^^^^^^^^^
Kelas mungkin punya setter untuk menyisipkan ketergantungan tidak wajib, kelas kita sebelumnya dapat diubah untuk menerima ketergantungan dengan setter:

.. code-block:: php

    <?php

    namespace SomeApp;

    use Phalcon\Http\Response;

    class SomeComponent
    {
        /**
         * @var Response
         */
        protected $_response;

        protected $_someFlag;



        public function setResponse(Response $response)
        {
            $this->_response = $response;
        }

        public function setFlag($someFlag)
        {
            $this->_someFlag = $someFlag;
        }
    }

Service dengan injeksi setter dapat didaftarkan seperti berikut:

.. code-block:: php

    <?php

    $di->set(
        "response",
        [
            "className" => "Phalcon\\Http\\Response",
        ]
    );

    $di->set(
        "someComponent",
        [
            "className" => "SomeApp\\SomeComponent",
            "calls"     => [
                [
                    "method"    => "setResponse",
                    "arguments" => [
                        [
                            "type" => "service",
                            "name" => "response",
                        ]
                    ]
                ],
                [
                    "method"    => "setFlag",
                    "arguments" => [
                        [
                            "type"  => "parameter",
                            "value" => true,
                        ]
                    ]
                ]
            ]
        ]
    );

Injeksi Properti
^^^^^^^^^^^^^^^^
Strategi kurang umum adalah menyisipkan ketergantungan atau parameter langsung melalui atribut publik kelas:

.. code-block:: php

    <?php

    namespace SomeApp;

    use Phalcon\Http\Response;

    class SomeComponent
    {
        /**
         * @var Response
         */
        public $response;

        public $someFlag;
    }

Service dengan injeksi properti dapat didaftarkan sebagai berikut:

.. code-block:: php

    <?php

    $di->set(
        "response",
        [
            "className" => "Phalcon\\Http\\Response",
        ]
    );

    $di->set(
        "someComponent",
        [
            "className"  => "SomeApp\\SomeComponent",
            "properties" => [
                [
                    "name"  => "response",
                    "value" => [
                        "type" => "service",
                        "name" => "response",
                    ],
                ],
                [
                    "name"  => "someFlag",
                    "value" => [
                        "type"  => "parameter",
                        "value" => true,
                    ],
                ]
            ]
        ]
    );

Jenis parameter yang didukung termasuk berikut ini:

+-------------+----------------------------------------------------------+-----------------------------------------------------------------------------------+
| Jenis       | Keterangan                                               | Contoh                                                                            |
+=============+==========================================================+===================================================================================+
| parameter   | Mewakili nilai asli yang dilewatkan sebagai parameter    | :code:`["type" => "parameter", "value" => 1234]`                                  |
+-------------+----------------------------------------------------------+-----------------------------------------------------------------------------------+
| service     | Mewakili service lain dalam kontainer service            | :code:`["type" => "service", "name" => "request"]`                                |
+-------------+----------------------------------------------------------+-----------------------------------------------------------------------------------+
| instance    | Mewakili objek yang harus diciptakan dinamis             | :code:`["type" => "instance", "className" => "DateTime", "arguments" => ["now"]]` |
+-------------+----------------------------------------------------------+-----------------------------------------------------------------------------------+

Resolve service yang definisinya kompleks mungkin lebih lambat dibandingkan yang sederhana seperti yang sudah terlihat sebelumnya. Namun,
ia menyediakan pendekatan yang lebih kokoh untuk mendefinisi dan menginjeksi service.

Mencampur jenis definisi berbeda diizinkan, semua orang dapat memutuskan cara apa yang paling cocok mendaftarkan service
tergantung kebutuhan aplikasi.

Array Syntax
------------
Sintaks array juga diizinkan untuk mendaftarkan service:

.. code-block:: php

    <?php

    use Phalcon\Di;
    use Phalcon\Http\Request;

    // Buat Dependency Injector Container
    $di = new Di();

    // Menggunakan nama kelas
    $di["request"] = "Phalcon\\Http\\Request";

    // Menggunakan fungsi anonymous function, instance akan dimuat secara lazy load
    $di["request"] = function () {
        return new Request();
    };

    // Mendaftarkan instance langsung
    $di["request"] = new Request();

    // Menggunakan definisi array
    $di["request"] = [
        "className" => "Phalcon\\Http\\Request",
    ];

Dicontoh diatas, ketika framework butuh mengakses data request, ia akan meminta service yang diidentifikasi sebagai ‘request’ dalam kontainer.
Kontainer kemudian mengembalikan instance service yang diminta. Developer mungkin suatu saat mengganti sebuah komponen ketika mereka butuh.

Tiap metode (ditunjukkan di contoh diatas) yang digunakan untuk mengatur/mendaftarkan service punya kelebihan dan kekurangan. Tergantung
developer dan kebutuhan tertentu yang mengarahkan mana yang digunakan.

Mengatur service dengan string mudah, namun kurang fleksibilitas. Mengatur service dengan array menawarkan lebih banyak fleksibilitas, namun menjadikan kode
lebih rumit. Fungsi lambda adalah keseimbangan bagus diantara keduanya, namun dapat menyebabkan lebih banyak maintenance dari yang diharapkan.

:doc:`Phalcon\\Di <../api/Phalcon_Di>` menawarkan lazy loading untuk semua service yang disimpan. Kecuali developer memilih menciptakan objek langsung dan menyimpannya
dalam kontainer, tiap objek yang disimpan didalamnya (melalui array, string dan lain-lain) akan di muat secara lazy load yakni hanya akan diciptakan ketika diminta.

Resolving Services
==================
Mendapatkan service dari kontainer hanya masalah memanggil metode "get". Instance baru service akan dikembalikan:

.. code-block:: php

    <?php $request = $di->get("request");

Atau menggunakan metode magic:

.. code-block:: php

    <?php

    $request = $di->getRequest();

Atau menggunakan sintaks akses array:

.. code-block:: php

    <?php

    $request = $di["request"];

Argumen dapat dilewatkan ke konstruktor dengan menambahkan parameter array ke metode "get":

.. code-block:: php

    <?php

    // new MyComponent("some-parameter", "other")
    $component = $di->get(
        "MyComponent",
        [
            "some-parameter",
            "other",
        ]
    );

Event
-----
:doc:`Phalcon\\Di <../api/Phalcon_Di>` mampu mengirim event ke :doc:`EventsManager <events>` jika ada.
Event dipicu menggunakan tipe "di". Beberapa event ketika mengembalikan nilai boolean false dapat menghentikan operasi aktif.
Event berikut didukung:

+----------------------+---------------------------------------------------------------------------------------------------------------------------------+---------------------+--------------------+
| Nama Event           | Dipicu                                                                                                                          | Bisa stop operasi?  | Dipicu di          |
+======================+=================================================================================================================================+=====================+====================+
| beforeServiceResolve | Dipicu sebelum resolve service. Listener menerima nama service dan parameter yang dilewatkan.                                   | Tidak               | Listeners          |
+----------------------+---------------------------------------------------------------------------------------------------------------------------------+---------------------+--------------------+
| afterServiceResolve  | Dipicu sebelum resolve service. Listener menerima nama service, instance dan parameter yang dilewatkan.                         | Tidak               | Listeners          |
+----------------------+---------------------------------------------------------------------------------------------------------------------------------+---------------------+--------------------+

Service Berbagi
===============
Service dapat didaftarkan sebagai "shared" services yang berarti bahwa mereka selalu bertindak sebagai singletons_. Service diresolve untuk pertama kali,
instance sama dikembalikan tiap kali konsumer meminta service dari kontainer:

.. code-block:: php

    <?php

    use Phalcon\Session\Adapter\Files as SessionFiles;

    // daftarkan service session sebagai "always shared"
    $di->setShared(
        "session",
        function () {
            $session = new SessionFiles();

            $session->start();

            return $session;
        }
    );

    // Temukan service untuk pertama kali
    $session = $di->get("session");

    // Mengembalikan objek yang sudah diciptakan pertama kali
    $session = $di->getSession();

Cara lain mendaftarkan shared service adalah melewatkan "true" sebagai parameter ketiga "set":

.. code-block:: php

    <?php

    // Daftarkan service session sebagai "always shared"
    $di->set(
        "session",
        function () {
            // ...
        },
        true
    );

Ketika sebuah service tidak didaftarkan sebagai service berbagi dan anda ingin memastikan instance yang sama diakses tiap kali
service diambil dari DI, anda dapat menggunakan metode 'getShared':

.. code-block:: php

    <?php

    $request = $di->getShared("request");

Memanipulasi masing-masing Service
==================================
Setelah service didaftarkan dalam kontainer service, anda dapat mengambilnya untuk dimanipulasi secara terpisah:

.. code-block:: php

    <?php

    use Phalcon\Http\Request;

    // Daftarkan service "request"
    $di->set("request", "Phalcon\\Http\\Request");

    // Ambil service
    $requestService = $di->getService("request");

    // Ubah definisi
    $requestService->setDefinition(
        function () {
            return new Request();
        }
    );

    // Ubah menjadi berbagi
    $requestService->setShared(true);

    // Resolve service (mengembalikan instance Phalcon\Http\Request)
    $request = $requestService->resolve();

Menciptakan kelas melalui Service Container
===========================================
Ketika anda meminta service ke kontainer service, jika ia tidak dapat menemukan service dengan nama sama ia akan mencoba memuat kelas
dengan nama sama. Dengan perilaku ini kita dapat mengganti sembarang kelas dengan lainnya cuma dengan mendaftarkan service dengan nama itu:

.. code-block:: php

    <?php

    // Daftarkan kontroler sebagai service
    $di->set(
        "IndexController",
        function () {
            $component = new Component();

            return $component;
        },
        true
    );

    // Daftarkan kontroler sebagai service
    $di->set(
        "MyOtherComponent",
        function () {
            // Kembalikan komponen lain
            $component = new AnotherComponent();

            return $component;
        }
    );

    // Buat instance melalui service container
    $myComponent = $di->get("MyOtherComponent");

Anda dapat memanfaatkan ini, dengan selalu menciptakan kelas anda melalui service container (bahkan jika mereka tidak didaftarkan sebagai service). DI akan
fallback ke autoloader yang valid yang akhirnya memuat kelas tersebut. Dengan melakukan ini, anda dapat mengganti sembarang kelas dimasa datang dengan mengimplementasi
definisinya.

Menginjeksi DI secara otomatis
==============================
Jika sebuah kelas atau komponen memerlukan DI sendiri untuk menemukan service, DI dapat diinjeksi otomatis kedalam instance yang diciptakan,
untuk melakukan ini, anda butuh mengimplementasi :doc:`Phalcon\\Di\\InjectionAwareInterface <../api/Phalcon_Di_InjectionAwareInterface>` dalam kelas anda:

.. code-block:: php

    <?php

    use Phalcon\DiInterface;
    use Phalcon\Di\InjectionAwareInterface;

    class MyClass implements InjectionAwareInterface
    {
        /**
         * @var DiInterface
         */
        protected $_di;



        public function setDi(DiInterface $di)
        {
            $this->_di = $di;
        }

        public function getDi()
        {
            return $this->_di;
        }
    }

lalu setelah service diresolve, :code:`$di` akan dilewatkan ke :code:`setDi()` otomatis:

.. code-block:: php

    <?php

    // Daftarkan service
    $di->set("myClass", "MyClass");

    // Resolve service (Catatan: $myClass->setDi($di) dipanggil otomatis)
    $myClass = $di->get("myClass");

Mengelola service dalam file
============================
Anda dapat mengelola lebih baik aplikasi anda dengan memindahkan pendaftaran service ke file terpisah daripada
melakukan semua dalam bootstrap aplikasi:

.. code-block:: php

    <?php

    $di->set(
        "router",
        function () {
            return include "../app/config/routes.php";
        }
    );

Lalu dalam file ("../app/config/routes.php") kembalikan objek yang diresolve:

.. code-block:: php

    <?php

    $router = new MyRouter();

    $router->post("/login");

    return $router;

Mengakses DI cara statik
========================
Jika diperlukan anda dapat mengakses DI yang diciptakan terakhir dalam fungsi statik dengan cara berikut:

.. code-block:: php

    <?php

    use Phalcon\Di;

    class SomeComponent
    {
        public static function someMethod()
        {
            // Ambil service session
            $session = Di::getDefault()->getSession();
        }
    }

Factory Default DI
==================
Meski katakter Phalcon yang terpisah (decoupled) menawarkan kita kebebasan dan fleksibilitas bagus, mungkin kita cuma ingin menggunakannya sebagai framework
full-stack. Untuk mencapai ini, framework menyediakan varian :doc:`Phalcon\\Di <../api/Phalcon_Di>` yang disebut :doc:`Phalcon\\Di\\FactoryDefault <../api/Phalcon_Di_FactoryDefault>`. Kelas ini otomatis
mendaftarkan service yang cocok yang digabung dengan framework untuk menjadikannya framework lengkap (full-stack).

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault;

    $di = new FactoryDefault();

Konvensi Nama Service
=====================
Meski anda dapat mendaftarkan service dengan nama yang anda mau, Phalcon punya beberapa konvensi penamaan yang memungkinkan ia mendapatkan
service bawaan dengan benar ketika anda membutuhkannya.

+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| Nama Service        | Keterangan                                  | Default                                                                                            | Shared |
+=====================+=============================================+====================================================================================================+========+
| dispatcher          | Controllers Dispatching Service             | :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`                                    | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| router              | Routing Service                             | :doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>`                                            | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| url                 | URL Generator Service                       | :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>`                                                  | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| request             | HTTP Request Environment Service            | :doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>`                                        | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| response            | HTTP Response Environment Service           | :doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>`                                      | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| cookies             | HTTP Cookies Management Service             | :doc:`Phalcon\\Http\\Response\\Cookies <../api/Phalcon_Http_Response_Cookies>`                     | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| filter              | Input Filtering Service                     | :doc:`Phalcon\\Filter <../api/Phalcon_Filter>`                                                     | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| flash               | Flash Messaging Service                     | :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`                                        | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| flashSession        | Flash Session Messaging Service             | :doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>`                                      | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| session             | Session Service                             | :doc:`Phalcon\\Session\\Adapter\\Files <../api/Phalcon_Session_Adapter_Files>`                     | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| eventsManager       | Events Management Service                   | :doc:`Phalcon\\Events\\Manager <../api/Phalcon_Events_Manager>`                                    | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| db                  | Low-Level Database Connection Service       | :doc:`Phalcon\\Db <../api/Phalcon_Db>`                                                             | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| security            | Security helpers                            | :doc:`Phalcon\\Security <../api/Phalcon_Security>`                                                 | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| crypt               | Encrypt/Decrypt data                        | :doc:`Phalcon\\Crypt <../api/Phalcon_Crypt>`                                                       | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| tag                 | HTML generation helpers                     | :doc:`Phalcon\\Tag <../api/Phalcon_Tag>`                                                           | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| escaper             | Contextual Escaping                         | :doc:`Phalcon\\Escaper <../api/Phalcon_Escaper>`                                                   | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| annotations         | Annotations Parser                          | :doc:`Phalcon\\Annotations\\Adapter\\Memory <../api/Phalcon_Annotations_Adapter_Memory>`           | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| modelsManager       | Models Management Service                   | :doc:`Phalcon\\Mvc\\Model\\Manager <../api/Phalcon_Mvc_Model_Manager>`                             | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| modelsMetadata      | Models Meta-Data Service                    | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Memory <../api/Phalcon_Mvc_Model_MetaData_Memory>`            | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| transactionManager  | Models Transaction Manager Service          | :doc:`Phalcon\\Mvc\\Model\\Transaction\\Manager <../api/Phalcon_Mvc_Model_Transaction_Manager>`    | Ya     |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| modelsCache         | Cache backend for models cache              | None                                                                                               | Tidak  |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+
| viewsCache          | Cache backend for views fragments           | None                                                                                               | Tidak  |
+---------------------+---------------------------------------------+----------------------------------------------------------------------------------------------------+--------+

Mengimplementasi DI anda sendiri
================================
Interface :doc:`Phalcon\\DiInterface <../api/Phalcon_DiInterface>` harus diimplementasi untuk menciptakan DI anda sendiri menggantikan yang sudah disediakan oleh Phalcon atau melengkapi yang sudah ada.

.. _`Inversion of Control`: http://en.wikipedia.org/wiki/Inversion_of_control
.. _singletons: http://en.wikipedia.org/wiki/Singleton_pattern
