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

    use Phalcon\Di\FactoryDefault\Cli as CliDI,
        Phalcon\Cli\Console as ConsoleApp;

    define('VERSION', '1.0.0');

    // Menggunakan service container factory default CLI
    $di = new CliDI();

    // Tentukan direktori aplikasi
    defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__)));

    /**
     * Daftarkan autoloade dan daftarkan direktori task
     */
    $loader = new \Phalcon\Loader();
    $loader->registerDirs(
        [
            APPLICATION_PATH . '/tasks'
        ]
    );
    $loader->register();

    // Muat file konfigurasi (bila ada)
    if (is_readable(APPLICATION_PATH . '/config/config.php')) {
        $config = include APPLICATION_PATH . '/config/config.php';
        $di->set('config', $config);
    }

    // Buat aplikasi konsol
    $console = new ConsoleApp();
    $console->setDI($di);

    /**
     * Proses argumen
     */
    $arguments = [];
    foreach ($argv as $k => $arg) {
        if ($k == 1) {
            $arguments['task'] = $arg;
        } elseif ($k == 2) {
            $arguments['action'] = $arg;
        } elseif ($k >= 3) {
            $arguments['params'][] = $arg;
        }
    }

    // Definisikan konstan global untuk tugas dan aksi saat ini
    define('CURRENT_TASK',   (isset($argv[1]) ? $argv[1] : null));
    define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));

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

    class MainTask extends \Phalcon\Cli\Task
    {
        public function mainAction()
        {
            echo "\nThis is the default task and the default action \n";
        }
    }

Memroses parameter aksi
-----------------------
Dimungkinkan untuk melewatkan parameter ke aksi, kode untuk ini sudah dihadirkan di contoh bootstrap.

Jika aplikasi jalan dengan parameter dan aksi berikut:

.. code-block:: php

    <?php

    class MainTask extends \Phalcon\Cli\Task
    {
        public function mainAction()
        {
            echo "\nThis is the default task and the default action \n";
        }

        /**
         * @param array $params
         */
        public function testAction(array $params)
        {
            echo sprintf('hello %s', $params[0]) . PHP_EOL;
            echo sprintf('best regards, %s', $params[1]) . PHP_EOL;
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

    $di->setShared('console', $console);

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

    class MainTask extends \Phalcon\Cli\Task
    {
        public function mainAction()
        {
            echo "\nThis is the default task and the default action \n";

            $this->console->handle(
                [
                    'task'   => 'main',
                    'action' => 'test'
                ]
            );
        }

        public function testAction()
        {
            echo "\nI will get printed too!\n";
        }
    }

Namun, lebih baik untuk menggunakan :doc:`Phalcon\\Cli\\Task <../api/Phalcon_Cli_Task>` dan mengimplementasi logika ini disana.
