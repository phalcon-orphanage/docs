Mendebug Aplikasi
=================

.. figure:: ../_static/img/xdebug-1.jpg
    :align: center

PHP menawarkan tool untuk mendebug aplikasi menggunakan pesan pemberitahuan, peringatan, kesalahan dan eksepsi. Kelas `Exception`_ menawarkan informasi seperti file,
baris, pesan, kode numerik, backtrace dan lain-lain. dimana  error terjadi. Framework OOP seperti Phalcon utamanya menggunakan kelas ini untuk membungkus
fungsionalitas ini dan menyediakan informasi tersebut ke developer atau pengguna.

Meski ditulis dalam C, Phalcon menjalankan metode di ranah PHP, menyediakan kapabilitas debug yang dimiliki aplikasi atau framework lain
yang ditulis dengan PHP.

Menangkap Eksepsi
-----------------
Sepanjang tutorial dan contoh dokumentasi Phalcon, ada elemen umum yang menangkap eksepsi. Ini adalah blok try/catch:

.. code-block:: php

    <?php

    try {

        // ... Kode Phalcon/PHP

    } catch (\Exception $e) {

    }

Tiap eksepsi yang dilempar dalam blok ini akan ditangkap dalam variabel :code:`$e`. :doc:`Phalcon\\Exception <../api/Phalcon_Exception>` diturunkan dari
Kelas `Exception`_ PHP dan digunakan untuk memahami apakah eksepsi berasal dari Phalcon atau PHP.

Semua eksepsi dibangkitkan oleh PHP barasal dari kelas `Exception`_, dan paling tidak punya elemen berikut:

.. code-block:: php

    <?php

    class Exception
    {

        /* Properties */
        protected string $message;
        protected int $code;
        protected string $file;
        protected int $line;

        /* Methods */
        public __construct ([ string $message = "" [, int $code = 0 [, Exception $previous = NULL ]]])
        final public string getMessage ( void )
        final public Exception getPrevious ( void )
        final public mixed getCode ( void )
        final public string getFile ( void )
        final public int getLine ( void )
        final public array getTrace ( void )
        final public string getTraceAsString ( void )
        public string __toString ( void )
        final private void __clone ( void )
    }

Mengambil informasi dari :doc:`Phalcon\\Exception <../api/Phalcon_Exception>` sama dengan kelas `Exception`_ PHP:

.. code-block:: php

    <?php

    try {

        // ... App code ...

    } catch (\Exception $e) {
        echo get_class($e), ": ", $e->getMessage(), "\n";
        echo " File=", $e->getFile(), "\n";
        echo " Line=", $e->getLine(), "\n";
        echo $e->getTraceAsString();
    }

Oleh karena itu mudah untuk menemukan file dan baris kode aplikasi yang membangkitkan eksepsi, juga komponen yang terlibat
membangkitkan eksepsi:

.. code-block:: html

    PDOException: SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost'
        (using password: NO)
     File=/Applications/MAMP/htdocs/invo/public/index.php
     Line=74
    #0 [internal function]: PDO->__construct('mysql:host=loca...', 'root', '', Array)
    #1 [internal function]: Phalcon\Db\Adapter\Pdo->connect(Array)
    #2 /Applications/MAMP/htdocs/invo/public/index.php(74):
        Phalcon\Db\Adapter\Pdo->__construct(Array)
    #3 [internal function]: {closure}()
    #4 [internal function]: call_user_func_array(Object(Closure), Array)
    #5 [internal function]: Phalcon\Di->_factory(Object(Closure), Array)
    #6 [internal function]: Phalcon\Di->get('db', Array)
    #7 [internal function]: Phalcon\Di->getShared('db')
    #8 [internal function]: Phalcon\Mvc\Model->getConnection()
    #9 [internal function]: Phalcon\Mvc\Model::_getOrCreateResultset('Users', Array, true)
    #10 /Applications/MAMP/htdocs/invo/app/controllers/SessionController.php(83):
        Phalcon\Mvc\Model::findFirst('email='demo@pha...')
    #11 [internal function]: SessionController->startAction()
    #12 [internal function]: call_user_func_array(Array, Array)
    #13 [internal function]: Phalcon\Mvc\Dispatcher->dispatch()
    #14 /Applications/MAMP/htdocs/invo/public/index.php(114): Phalcon\Mvc\Application->handle()
    #15 {main}

Anda dapat lihat dari output diatas kelas dan metode Phalcon ditampilkan seperti halnya komponen lain, dan bahkan menampilkan
parameter yang digunakan dalam tiap pemanggilan. Method `Exception::getTrace`_ menyediakan informasi tambahan bila diperlukan.

Komponen Debug
--------------
Phalcon menyediakan sebuah komponen debug yang memungkinkan developer dengan mudah menemukan error yang dihasilkan aplikasi
yang dibuat dengan framework ini.

Screencast berikut ini menjelaskan bagaimana ia bekerja:

.. raw:: html

    <div align="center">
        <iframe src="//player.vimeo.com/video/68893840" width="500" height="313" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
    </div>

Untuk menghidupkannya, tambahkan kode berikut ini di bootstrap anda:

.. code-block:: php

    <?php

    $debug = new \Phalcon\Debug();
    $debug->listen();

Tiap blok Try/Catch harus dihapus atau dimatikan agar komponen ini bekerja semestinya.

Refleksi dan Introspeksi
------------------------
Tiap instance kelas Phalcon menawarkan perilaku yang sama seperti kelas PHP biasa. Dimungkinkan untuk menggunakan
`Reflection API`_ atau print sembarang objek untuk menunjukkan status internalnya:

.. code-block:: php

    <?php

    $router = new Phalcon\Mvc\Router();
    print_r($router);

Mudah untuk mengetahu status internal tiap objek. Contoh di atas mencetak berikut:

.. code-block:: html

    Phalcon\Mvc\Router Object
    (
        [_dependencyInjector:protected] =>
        [_module:protected] =>
        [_controller:protected] =>
        [_action:protected] =>
        [_params:protected] => Array
            (
            )
        [_routes:protected] => Array
            (
                [0] => Phalcon\Mvc\Router\Route Object
                    (
                        [_pattern:protected] => #^/([a-zA-Z0-9\_]+)[/]{0,1}$#
                        [_compiledPattern:protected] => #^/([a-zA-Z0-9\_]+)[/]{0,1}$#
                        [_paths:protected] => Array
                            (
                                [controller] => 1
                            )

                        [_methods:protected] =>
                        [_id:protected] => 0
                        [_name:protected] =>
                    )

                [1] => Phalcon\Mvc\Router\Route Object
                    (
                        [_pattern:protected] => #^/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)(/.*)*$#
                        [_compiledPattern:protected] => #^/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)(/.*)*$#
                        [_paths:protected] => Array
                            (
                                [controller] => 1
                                [action] => 2
                                [params] => 3
                            )
                        [_methods:protected] =>
                        [_id:protected] => 1
                        [_name:protected] =>
                    )
            )
        [_matchedRoute:protected] =>
        [_matches:protected] =>
        [_wasMatched:protected] =>
        [_defaultModule:protected] =>
        [_defaultController:protected] =>
        [_defaultAction:protected] =>
        [_defaultParams:protected] => Array
            (
            )
    )

Menggunakan XDebug
------------------
XDebug_ adalah tool yang keren yang melengkapi debugging aplikasi PHP. Ia juga adalah ektensi C untuk PHP, dan anda dapat menggunakannya bersama
Phalcon tanpa konfigurasi tambahan atau efek samping.

Screencast berikut menunjukkan sesi Xdebug dengan Phalcon:

.. raw:: html

    <div align="center">
        <iframe src="//player.vimeo.com/video/69867342" width="500" height="313" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
    </div>

Setelah anda menginstall xdebug, anda dapat menggunakan API-nya untuk mendapatkan informasi lebih detail mengenai eksepsi dan pesan.

.. highlights::

    Kami sarankan menggunakan  paling tidak XDebug 2.2.3 untuk kompatibilitas lebih baik dengan Phalcon

Contoh berikut mengimplementasi xdebug_print_function_stack_ untuk menghentikan eksekusi dan menghasilkan backtrace:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SignupController extends Controller
    {
        public function indexAction()
        {

        }

        public function registerAction()
        {
            // Request variabel dari form HTML
            $name  = $this->request->getPost("name", "string");
            $email = $this->request->getPost("email", "email");

            // Stop eksekusi dan tunjukkan backtrace
            return xdebug_print_function_stack("stop here!");

            $user        = new Users();
            $user->name  = $name;
            $user->email = $email;

            // Store and check for errors
            $user->save();
        }
    }

Di sini, Xdebug juga akan menunjukkan variabel di lingkup lokal dan backtrace nya juga:

.. code-block:: html

    Xdebug: stop here! in /Applications/MAMP/htdocs/tutorial/app/controllers/SignupController.php
        on line 19

    Call Stack:
        0.0383     654600   1. {main}() /Applications/MAMP/htdocs/tutorial/public/index.php:0
        0.0392     663864   2. Phalcon\Mvc\Application->handle()
            /Applications/MAMP/htdocs/tutorial/public/index.php:37
        0.0418     738848   3. SignupController->registerAction()
            /Applications/MAMP/htdocs/tutorial/public/index.php:0
        0.0419     740144   4. xdebug_print_function_stack()
            /Applications/MAMP/htdocs/tutorial/app/controllers/SignupController.php:19

Xdebug menyediakan beberapa cara untuk mendapatkan informasi debug dan trace terkait eksekusi aplikasi menggunakan Phalcon. Anda dapt
membaca `dokumentasi XDebug`_ untuk informasi lanjut.

.. _`Pretty Exceptions`: https://github.com/phalcon/pretty-exceptions
.. _Exception: http://www.php.net/manual/en/language.exceptions.php
.. _`Reflection API`: http://php.net/manual/en/book.reflection.php
.. _`Exception::getTrace`: http://www.php.net/manual/en/exception.gettrace.php
.. _XDebug: http://xdebug.org
.. _`dokumentasi XDebug`: http://xdebug.org/docs
.. _xdebug_print_function_stack: http://xdebug.org/docs/stack_trace
