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
            '../apps/controllers/',
            '../apps/models/'
        ]
    )->register();

    $di = new FactoryDefault();

    // Daftarkan komponen view
    $di->set('view', function () {
        $view = new View();
        $view->setViewsDir('../apps/views/');
        return $view;
    });

    try {

        $application = new Application($di);

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
            'Single\Controllers' => '../apps/controllers/',
            'Single\Models'      => '../apps/models/',
        ]
    )->register();

    $di = new FactoryDefault();

    // Daftarkan naespace default untuk dispatcher bagi controller
    $di->set('dispatcher', function () {
        $dispatcher = new Dispatcher();
        $dispatcher->setDefaultNamespace('Single\Controllers');
        return $dispatcher;
    });

    // Register the view component
    $di->set('view', function () {
        $view = new View();
        $view->setViewsDir('../apps/views/');
        return $view;
    });

    try {

        $application = new Application($di);

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
                    'Multiple\Backend\Controllers' => '../apps/backend/controllers/',
                    'Multiple\Backend\Models'      => '../apps/backend/models/',
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
            $di->set('dispatcher', function () {
                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace("Multiple\Backend\Controllers");
                return $dispatcher;
            });

            // Registering the view component
            $di->set('view', function () {
                $view = new View();
                $view->setViewsDir('../apps/backend/views/');
                return $view;
            });
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
    // More information how to set the router up https://docs.phalconphp.com/en/latest/reference/routing.html
    $di->set('router', function () {

        $router = new Router();

        $router->setDefaultModule("frontend");

        $router->add(
            "/login",
            [
                'module'     => 'backend',
                'controller' => 'login',
                'action'     => 'index'
            ]
        );

        $router->add(
            "/admin/products/:action",
            [
                'module'     => 'backend',
                'controller' => 'products',
                'action'     => 1
            ]
        );

        $router->add(
            "/products/:action",
            [
                'controller' => 'products',
                'action'     => 1
            ]
        );

        return $router;
    });

    try {

        // Create an application
        $application = new Application($di);

        // Register the installed modules
        $application->registerModules(
            [
                'frontend' => [
                    'className' => 'Multiple\Frontend\Module',
                    'path'      => '../apps/frontend/Module.php',
                ],
                'backend'  => [
                    'className' => 'Multiple\Backend\Module',
                    'path'      => '../apps/backend/Module.php',
                ]
            ]
        );

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
            'frontend' => function ($di) use ($view) {
                $di->setShared('view', function () use ($view) {
                    $view->setViewsDir('../apps/frontend/views/');
                    return $view;
                });
            },
            'backend' => function ($di) use ($view) {
                $di->setShared('view', function () use ($view) {
                    $view->setViewsDir('../apps/backend/views/');
                    return $view;
                });
            }
        ]
    );

Ketika :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` memiliki module yang terdaftar, penting untuk
tiap route yang cocok mengembalikan module yang sah. Tiap modul yang terdaftar memiliki sebuah kelas terkait yang
menyediakan fungsi-fungsi untuk menyiapkan modul. Tiap definisi modul kelas wajib mengimplementasi dua metode:
registerAutoloaders() dan registerServices(), yang akan dipanggil oleh
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` tergantung modul mana yang dijalankan.

Memahami perilaku default
-------------------------
Jika anda mengikuti :doc:`tutorial <tutorial>` atau membuat kode menggunakan :doc:`Phalcon Devtools <tools>`,
anda mungkin mengenali file bootstrap berikut:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    try {

        // Register autoloaders
        // ...

        // Register services
        // ...

        // Handle the request
        $application = new Application($di);

        $response = $application->handle();

        $response->send();

    } catch (\Exception $e) {
        echo "Exception: ", $e->getMessage();
    }

Inti semua kerja kontroller terjadi ketika handle() dipanggil:

.. code-block:: php

    <?php

    $response = $application->handle();

Bootstrap manual
----------------
Jika anda ingin menggunakan :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`, kode di atas dapat diubah seperti berikut:

.. code-block:: php

    <?php

    // Get the 'router' service
    $router = $di['router'];

    $router->handle();

    $view = $di['view'];

    $dispatcher = $di['dispatcher'];

    // Pass the processed router parameters to the dispatcher
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    // Start the view
    $view->start();

    // Dispatch the request
    $dispatcher->dispatch();

    // Render the related views
    $view->render(
        $dispatcher->getControllerName(),
        $dispatcher->getActionName(),
        $dispatcher->getParams()
    );

    // Finish the view
    $view->finish();

    $response = $di['response'];

    // Pass the output of the view to the response
    $response->setContent($view->getContent());

    // Send the response headers
    $response->sendHeaders();

    // Print the response
    echo $response->getContent();

Pengganti :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` berikut tidak memiliki komponen view membuatnya cocok untuk Rest API:

.. code-block:: php

    <?php

    // Get the 'router' service
    $router = $di['router'];

    $router->handle();

    $dispatcher = $di['dispatcher'];

    // Pass the processed router parameters to the dispatcher
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    // Dispatch the request
    $dispatcher->dispatch();

    // Get the returned value by the last executed action
    $response = $dispatcher->getReturnedValue();

    // Check if the action returned is a 'response' object
    if ($response instanceof Phalcon\Http\ResponseInterface) {

        // Send the response
        $response->send();
    }

Alternatif lain adalah menangkap eksepsi yang dihasilkan oleh dispatcher dan mengarahkan ke aksi lain:

.. code-block:: php

    <?php

    // Dapatkan service 'router'
    $router = $di['router'];

    $router->handle();

    $dispatcher = $di['dispatcher'];

    // Lewatkan parameter router yang telah diproses ke dispatcher
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    try {

        // Kirim request
        $dispatcher->dispatch();

    } catch (Exception $e) {

        // An exception has occurred, dispatch some controller/action aimed for that

        // Lewatkan parameter router yang telah diproses ke dispatcher
        $dispatcher->setControllerName('errors');
        $dispatcher->setActionName('action503');

        // Kirim request
        $dispatcher->dispatch();
    }

    // Get the returned value by the last executed action
    $response = $dispatcher->getReturnedValue();

    // Check if the action returned is a 'response' object
    if ($response instanceof Phalcon\Http\ResponseInterface) {

        // Send the response
        $response->send();
    }

Meski implementasi di atas lebih banyak kodenya dibanding menggunakan :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`,
ia menawarkan alternatif bootstraping aplikasi anda. Tergantung kebutuhan anda, anda mungkin ingin memiliki kendali penuh
terhadap apa yang harus diciptakan dan yang tidak, atau mengganti komponen tertentu dengan milik anda sendiri untuk memperluas fungsionalitas defaultnya.

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

    use Phalcon\Events\Manager as EventsManager;

    $eventsManager = new EventsManager();

    $application->setEventsManager($eventsManager);

    $eventsManager->attach(
        "application",
        function ($event, $application) {
            // ...
        }
    );

Sumber Luar
-----------
* `MVC examples on Github <https://github.com/phalcon/mvc>`_
