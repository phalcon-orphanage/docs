Membaca Konfigurasi
===================

:doc:`Phalcon\\Config <../api/Phalcon_Config>` adalah komponen yang digunakan untuk membaca file konfigurasi beragam format (menggunakan adapter) ke dalam objek PHP untuk digunakan dalam aplikasi.

Array Native
------------
Contoh berikut menunjukkan bagaimana mengubah array native ke objek :doc:`Phalcon\\Config <../api/Phalcon_Config>`. Pilihan ini menawarkan performa terbaik karena tidak ada file yang dibaca selama request.

.. code-block:: php

    <?php

    use Phalcon\Config;

    $settings = [
        "database" => [
            "adapter"  => "Mysql",
            "host"     => "localhost",
            "username" => "scott",
            "password" => "cheetah",
            "dbname"   => "test_db"
        ],
         "app" => [
            "controllersDir" => "../app/controllers/",
            "modelsDir"      => "../app/models/",
            "viewsDir"       => "../app/views/"
        ],
        "mysetting" => "the-value"
    ];

    $config = new Config($settings);

    echo $config->app->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->mysetting, "\n";

Jika anda ingi mengelola projek anda lebih baik anda dapat menyimpan array ke file lain dan membacanya.

.. code-block:: php

    <?php

    use Phalcon\Config;

    require "config/config.php";

    $config = new Config($settings);

File Adapters
-------------
Adapter yang tersedia:

+----------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------+
| Tipe File                                                                  | Keterangan                                                                                              |
+============================================================================+=========================================================================================================+
| :doc:`Phalcon\\Config\\Adapter\\Ini <../api/Phalcon_Config_Adapter_Ini>`   | Menggunakan file INI untuk menyimpan setting. Didalamnya adapter menggunakan fungsi PHP parse_ini_file. |
+----------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Json <../api/Phalcon_Config_Adapter_Json>` | Uses JSON files to store settings.                                                                      |
+----------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Php <../api/Phalcon_Config_Adapter_Php>`   | Uses PHP multidimensional arrays to store settings. This adapter offers the best performance.           |
+----------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Config\\Adapter\\Yaml <../api/Phalcon_Config_Adapter_Yaml>` | Uses YAML files to store settings.                                                                      |
+----------------------------------------------------------------------------+---------------------------------------------------------------------------------------------------------+

Membaca file INI
----------------
File Ini adalah cara umum menyimpan setting. :doc:`Phalcon\\Config <../api/Phalcon_Config>` menggunakan fungsi PHP parse_ini_file untuk membaca file. Seksi file dipecah menjadi sub setting untuk akses lebih mudah.

.. code-block:: ini

    [database]
    adapter  = Mysql
    host     = localhost
    username = scott
    password = cheetah
    dbname   = test_db

    [phalcon]
    controllersDir = "../app/controllers/"
    modelsDir      = "../app/models/"
    viewsDir       = "../app/views/"

    [models]
    metadata.adapter  = "Memory"

Anda dapat membaca file sebagai berikut:

.. code-block:: php

    <?php

    use Phalcon\Config\Adapter\Ini as ConfigIni;

    $config = new ConfigIni("path/config.ini");

    echo $config->phalcon->controllersDir, "\n";
    echo $config->database->username, "\n";
    echo $config->models->metadata->adapter, "\n";

Menggabung Konfigurasi
----------------------
:doc:`Phalcon\\Config <../api/Phalcon_Config>` dapat menggabung properti satu objek konfigurasi ke lainnya secara rekursif.
Properti baru ditambahkan dan properti yang sudah ada diperbarui.

.. code-block:: php

    <?php

    use Phalcon\Config;

    $config = new Config(
        [
            "database" => [
                "host"   => "localhost",
                "dbname" => "test_db",
            ],
            "debug" => 1,
        ]
    );

    $config2 = new Config(
        [
            "database" => [
                "dbname"   => "production_db",
                "username" => "scott",
                "password" => "secret",
            ],
            "logging" => 1,
        ]
    );

    $config->merge($config2);

    print_r($config);

Kode di atas menghasilkan berikut:

.. code-block:: html

    Phalcon\Config Object
    (
        [database] => Phalcon\Config Object
            (
                [host] => localhost
                [dbname]   => production_db
                [username] => scott
                [password] => secret
            )
        [debug] => 1
        [logging] => 1
    )

Ada lebih banyak adapter tersedia untuk komponen ini di `Phalcon Incubator <https://github.com/phalcon/incubator>`_

Injeksi ketergantungan Konfigurasi
----------------------------------
Ada dapat menginjeksi ketergantungan terhadap konfigurasi ke kontroller yang memungkinkan kita menggunakan :doc:`Phalcon\\Config <../api/Phalcon_Config>` dalam :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>`. Agar dapat melakukannya, tambahkan kode berikut dalam script dependency injector.

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault;
    use Phalcon\Config;

    // Buat DI
    $di = new FactoryDefault();

    $di->set(
        "config",
        function () {
            $configData = require "config/config.php";

            return new Config($configData);
        }
    );

Sekarang dalam kontroller anda dapat mengakses konfigurasi memanfaatkan fitur depedency injection dengan nama `config` seperti kode berikut:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class MyController extends Controller
    {
        private function getDatabaseName()
        {
            return $this->config->database->dbname;
        }
    }
