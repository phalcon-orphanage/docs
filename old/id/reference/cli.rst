Aplikasi Command Line
=====================

Aplikasi CLI dijalankan dari command line. Mereka berguna untuk menjalankan cron job, script, utiliti dan lainnya.

Struktur
--------
Struktur minimal aplikasi CLI terlihat seperti berikut:

* app/config/config.php
* app/tasks/MainTask.php
* app/cli.php <-- file bootstrap utama

Menciptakan sebuah Bootstrap
----------------------------
Sebagai aplikasi Mvc biasa, sebuah file bootstrap digunakan untuk memulai aplikasi. Alih-alih index.php untuk memulai aplikasi web, kita menggunakan file cli.php.

Di bawah ini adalah contoh bootstrap yang digunakan untuk contoh ini.

.. code-block:: php

    <?php

    use Phalcon\Di\FactoryDefault\Cli as CliDI;
    use Phalcon\Cli\Console as ConsoleApp;
    use Phalcon\Loader;



    // Menggunakan service container factory default CLI
    $di = new CliDI();



    /**
     * Daftarkan autoloade dan daftarkan direktori task
     */
    $loader = new Loader();

    $loader->registerDirs(
        [
            __DIR__ . "/tasks",
        ]
    );

    $loader->register();



    // Muat file konfigurasi (bila ada)

    $configFile = __DIR__ . "/config/config.php";

    if (is_readable($configFile)) {
        $config = include $configFile;

        $di->set("config", $config);
    }



    // Buat aplikasi konsol
    $console = new ConsoleApp();

    $console->setDI($di);



    /**
     * Proses argumen
     */
    $arguments = [];

    foreach ($argv as $k => $arg) {
        if ($k === 1) {
            $arguments["task"] = $arg;
        } elseif ($k === 2) {
            $arguments["action"] = $arg;
        } elseif ($k >= 3) {
            $arguments["params"][] = $arg;
        }
    }



    try {
        // Handle argumen yang masuk
        $console->handle($arguments);
    } catch (\Phalcon\Exception $e) {
        echo $e->getMessage();

        exit(255);
    }

Potongan kode ini dapat dijalankan menggunakan:

.. code-block:: bash

    $ php app/cli.php

    This is the default task and the default action

Tugas
-----
Tugas nekerja mirip kontroller. Tiap aplikasi CLI butuh paling tidak satu MainTask dan mainAction dan tiap tugas butuh sebuah mainAction yang dijalankan bila tidak ada aksi yang diberikan secara eksplisit.

Di bawah ini adalah contoh file app/tasks/MainTask.php:

.. code-block:: php

    <?php

    use Phalcon\Cli\Task;

    class MainTask extends Task
    {
        public function mainAction()
        {
            echo "This is the default task and the default action" . PHP_EOL;
        }
    }

Memroses parameter aksi
-----------------------
Dimungkinkan untuk melewatkan parameter ke aksi, kode untuk ini sudah dihadirkan di contoh bootstrap.

Jika aplikasi jalan dengan parameter dan aksi berikut:

.. code-block:: php

    <?php

    use Phalcon\Cli\Task;

    class MainTask extends Task
    {
        public function mainAction()
        {
            echo "This is the default task and the default action" . PHP_EOL;
        }

        /**
         * @param array $params
         */
        public function testAction(array $params)
        {
            echo sprintf(
                "hello %s",
                $params[0]
            );

            echo PHP_EOL;

            echo sprintf(
                "best regards, %s",
                $params[1]
            );

            echo PHP_EOL;
        }
    }

Kita dapat menjalankan perintah berikut:

.. code-block:: bash

   $ php app/cli.php main test world universe

   hello world
   best regards, universe

Menjalankan tugas secara berantai
---------------------------------
Dimungkinkan juga menjalankan tugas secara berantai jika diperlukan. Untuk mencapai hal ini anda harus menambah console ke DI:

.. code-block:: php

    <?php

    $di->setShared("console", $console);

    try {
        // Handle incoming arguments
        $console->handle($arguments);
    } catch (\Phalcon\Exception $e) {
        echo $e->getMessage();

        exit(255);
    }

Lalu anda dapat menggunakan console dalam tiap tugas. Dibawah ini adalah contoh MainTask.php yang sudah dimodifikasi:

.. code-block:: php

    <?php

    use Phalcon\Cli\Task;

    class MainTask extends Task
    {
        public function mainAction()
        {
            echo "This is the default task and the default action" . PHP_EOL;

            $this->console->handle(
                [
                    "task"   => "main",
                    "action" => "test",
                ]
            );
        }

        public function testAction()
        {
            echo "I will get printed too!" . PHP_EOL;
        }
    }

Namun, lebih baik untuk menggunakan :doc:`Phalcon\\Cli\\Task <../api/Phalcon_Cli_Task>` dan mengimplementasi logika ini disana.
