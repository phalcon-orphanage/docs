Aplikasi MVC
============

Semua kerja keras mengatur operasi dalam MVC di Phalcon normalnya dilakukan oleh
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`. Komponen ini membungkus semua operasi kompleks
yang diperlukan dibelakang layar, menciptakan semua komponen yang diperlukan dan menyatukannnya dengan proyek, memungkinkan
pola MVC bekerja sesuai  yang diinginkan.

Aplikasi Modul Tunggal atau Jamak
---------------------------------
Dengan komponen ini anda dapat menjalankan beragam tipe struktur MVC:

Modul Tunggal
^^^^^^^^^^^^^
Aplikasi MVC tunggal terdiri atas satu modul saja. Namespace dapat digunakan namun tidak wajib.
Aplikasi seperti ini memiliki struktur file sebagai berikut:

.. code-block:: php

    single/
        app/
            controllers/
            models/
            views/
        public/
            css/
            img/
            js/

Jika namespace tidak digunakan, file bootstrap berikut dapat digunakan untuk mengatur alir MVC:

.. code-block:: php

    <?php

    use Phalcon\Loader;
    use Phalcon\Mvc\View;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;

    $loader = new Loader();

    $loader->registerDirs(
        [
            "../apps/controllers/",
            "../apps/models/",
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    // Daftarkan komponen view
    $di->set(
        "view",
        function () {
            $view = new View();

            $view->setViewsDir("../apps/views/");

            return $view;
        }
    );

    $application = new Application($di);

    try {
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo $e->getMessage();
    }

Jika namespace digunakan, bootstrap berikut bisa dipakai:

.. code-block:: php

    <?php

    use Phalcon\Loader;
    use Phalcon\Mvc\View;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;

    $loader = new Loader();

    // Gunakan autoloading dengan prefix namespace
    $loader->registerNamespaces(
        [
            "Single\\Controllers" => "../apps/controllers/",
            "Single\\Models"      => "../apps/models/",
        ]
    );

    $loader->register();

    $di = new FactoryDefault();

    // Daftarkan naespace default untuk dispatcher bagi controller
    $di->set(
        "dispatcher",
        function () {
            $dispatcher = new Dispatcher();

            $dispatcher->setDefaultNamespace("Single\\Controllers");

            return $dispatcher;
        }
    );

    // Register the view component
    $di->set(
        "view",
        function () {
            $view = new View();

            $view->setViewsDir("../apps/views/");

            return $view;
        }
    );

    $application = new Application($di);

    try {
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo $e->getMessage();
    }

Modul Jamak
^^^^^^^^^^^
Sebuah aplikasi dengan module lebih dari satu, menggunakan document root sama untuk lebih dari satu modul. Di kasus ini, struktur file berikut dapat dipakai:

.. code-block:: php

    multiple/
      apps/
        frontend/
           controllers/
           models/
           views/
           Module.php
        backend/
           controllers/
           models/
           views/
           Module.php
      public/
        css/
        img/
        js/

Tiap direktori dalam apps/ punya struktur MVC sendiri. File Module.php disediakan untuk mengkonfigurasi setting spesifik tiap modul seperti autoloader atau custom services:

.. code-block:: php

    <?php

    namespace Multiple\Backend;

    use Phalcon\Loader;
    use Phalcon\Mvc\View;
    use Phalcon\DiInterface;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\ModuleDefinitionInterface;

    class Module implements ModuleDefinitionInterface
    {
        /**
         * Register a specific autoloader for the module
         */
        public function registerAutoloaders(DiInterface $di = null)
        {
            $loader = new Loader();

            $loader->registerNamespaces(
                [
                    "Multiple\\Backend\\Controllers" => "../apps/backend/controllers/",
                    "Multiple\\Backend\\Models"      => "../apps/backend/models/",
                ]
            );

            $loader->register();
        }

        /**
         * Register specific services for the module
         */
        public function registerServices(DiInterface $di)
        {
            // Registering a dispatcher
            $di->set(
                "dispatcher",
                function () {
                    $dispatcher = new Dispatcher();

                    $dispatcher->setDefaultNamespace("Multiple\\Backend\\Controllers");

                    return $dispatcher;
                }
            );

            // Registering the view component
            $di->set(
                "view",
                function () {
                    $view = new View();

                    $view->setViewsDir("../apps/backend/views/");

                    return $view;
                }
            );
        }
    }

Sebuah file bootstrap khusus diperlukan untuk memuat arsitektur MVC bermodul jamak:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Router;
    use Phalcon\Mvc\Application;
    use Phalcon\Di\FactoryDefault;

    $di = new FactoryDefault();

    // Specify routes for modules
    // More information how to set the router up https://docs.phalconphp.com/id/latest/reference/routing.html
    $di->set(
        "router",
        function () {
            $router = new Router();

            $router->setDefaultModule("frontend");

            $router->add(
                "/login",
                [
                    "module"     => "backend",
                    "controller" => "login",
                    "action"     => "index",
                ]
            );

            $router->add(
                "/admin/products/:action",
                [
                    "module"     => "backend",
                    "controller" => "products",
                    "action"     => 1,
                ]
            );

            $router->add(
                "/products/:action",
                [
                    "controller" => "products",
                    "action"     => 1,
                ]
            );

            return $router;
        }
    );

    // Create an application
    $application = new Application($di);

    // Register the installed modules
    $application->registerModules(
        [
            "frontend" => [
                "className" => "Multiple\\Frontend\\Module",
                "path"      => "../apps/frontend/Module.php",
            ],
            "backend"  => [
                "className" => "Multiple\\Backend\\Module",
                "path"      => "../apps/backend/Module.php",
            ]
        ]
    );

    try {
        // Handle the request
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo $e->getMessage();
    }

Jika anda ingin mengelola konfigurasi modul dalam file bootstrap anda dapat menggunakan fungsi anonim untuk mendaftarkan modul:

.. code-block:: php

    <?php

    use Phalcon\Mvc\View;

    // Creating a view component
    $view = new View();

    // Set options to view component
    // ...

    // Register the installed modules
    $application->registerModules(
        [
            "frontend" => function ($di) use ($view) {
                $di->setShared(
                    "view",
                    function () use ($view) {
                        $view->setViewsDir("../apps/frontend/views/");

                        return $view;
                    }
                );
            },
            "backend" => function ($di) use ($view) {
                $di->setShared(
                    "view",
                    function () use ($view) {
                        $view->setViewsDir("../apps/backend/views/");

                        return $view;
                    }
                );
            }
        ]
    );

Ketika :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` memiliki module yang terdaftar, penting untuk
tiap route yang cocok mengembalikan module yang sah. Tiap modul yang terdaftar memiliki sebuah kelas terkait yang
menyediakan fungsi-fungsi untuk menyiapkan modul. Tiap definisi modul kelas wajib mengimplementasi dua metode:
registerAutoloaders() dan registerServices(), yang akan dipanggil oleh
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` tergantung modul mana yang dijalankan.

Event Aplikasi
--------------
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` mampu mengeirim pesan kejadian ke :doc:`EventsManager <events>`
(jika ada). Event dipicu menggunakan tipe "application". Event berikut didukung:

+---------------------+--------------------------------------------------------------+
| Nama Event          | Dipicu                                                       |
+=====================+==============================================================+
| boot                | Dieksekusi ketika aplikasi pertama kali menjalankan request  |
+---------------------+--------------------------------------------------------------+
| beforeStartModule   | Sebelum inisialisasi modul, hanya bila modul terdaftar       |
+---------------------+--------------------------------------------------------------+
| afterStartModule    | Setelah inisialisasi modul, hanya bila modul terdaftar       |
+---------------------+--------------------------------------------------------------+
| beforeHandleRequest | Sebelum eksekusi loop dispatch                               |
+---------------------+--------------------------------------------------------------+
| afterHandleRequest  | Setelah eksekusi loop dispatch                               |
+---------------------+--------------------------------------------------------------+

Contoh berikut menunjukkan bagaimana memasang listener ke komponen ini:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $eventsManager = new EventsManager();

    $application->setEventsManager($eventsManager);

    $eventsManager->attach(
        "application",
        function (Event $event, $application) {
            // ...
        }
    );

Sumber Luar
-----------
* `MVC examples on Github <https://github.com/phalcon/mvc>`_
