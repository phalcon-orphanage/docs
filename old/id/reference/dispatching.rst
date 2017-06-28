Dispatch Kontroler
==================

:doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` adalah komponen yang bertanggung jawab menciptakan kontroler dan menjalankan aksi yang dibutuhkan
dalam sebuah aplikasi MVC. Memahami operasi dan kemampuannya membantu kita mendapat lebih dari service yang disediakan framework.

Dispatch Loop
-------------
Ini adalah proses penting yang berkaitan dengan alir MVC sendiri, terutama dengan bagian kontroler. Kerja ini terjadi dalam kontroler
dispatcher. File kontroler dibaca, dimuat dan kontroler diciptakan. lalu aksi yang diminta dijalankan. Jika sebuah aksi mengarahkan alir ke
kontroler/aksi lain, dispatcher kontroler mulai lagi. Untuk menjelaskan lebih baik, contoh berikut menunjukkan proses yang dijalankan
dalam :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`:

.. code-block:: php

    <?php

    // Dispatch loop
    while (!$finished) {
        $finished = true;

        $controllerClass = $controllerName . "Controller";

        // Menciptakan kelas kontroler melalui  autoloaders
        $controller = new $controllerClass();

        // Eksekusi aksi
        call_user_func_array(
            [
                $controller,
                $actionName . "Action"
            ],
            $params
        );

        // '$finished' should be reloaded to check if the flow was forwarded to another controller
        $finished = true;
    }

Kode diatas tidak memiliki validasi, filter dan pengecekan tambahan, namun ia mendemonstrasikan alir operasi normal dalam dispatcher.

Kejadian Dispatch Loop
^^^^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` mampu mengirim event ke :doc:`EventsManager <events>` jika tersedia. Event dipicu dengean menggunakan tipe "dispatch". Beberapa event ketika mengembalikan nilai false dapat menghentikan operasi aktif. Event berikut didukung:

+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| Nama Event           | Dipicu                                                                                                                                                                                                         | Bisa stop operasi?  | Dipicu oleh           |
+======================+================================================================================================================================================================================================================+=====================+=======================+
| beforeDispatchLoop   | Dipicu sebelum memasuki dispatch loop. Saat ini dispatcher tidak tahu apakah kontroler atau aksi yang hendak dijalankan ada. Dispatcher hanya tahu informasi yang dilewatkan Router.                           | Ya                  | Listeners             |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeDispatch       | Dipicu setelah memasuki dispatch loop. Saat ini dispatcher tidak tahu apakah kontroler atau aksi yang hendak dijalankan ada. Dispatcher hanya tahu informasi yang dilewatkan Router.                           | Ya                  | Listeners             |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeExecuteRoute   | Dipicu sebelum menjalankan metode kontroler/aksi. Di saat ini dispacher tilah menginisialisasi kontroler dan tahu bila aksi ada.                                                                               | Ya                  | Listeners/Controllers |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| initialize           | Memungkinkan menginisialisasi kontroler secara global dalam request                                                                                                                                            | Tidak               | Controllers           |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| afterExecuteRoute    | Dipicu setelah mengeksekusi metode kontroler/aksi. Operasi tidak bisa dihentikan, hanya gunakan event ini untuk membersihkan sesuatu setelah menjalankan aksi                                                  | Tidak               | Listeners/Controllers |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeNotFoundAction | Dipicu ketika aksi tidak ditemukan dalam kontroler                                                                                                                                                             | Ya                  | Listeners             |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeException      | Dipicu sebelum dispacher melempar sembarang eksepsi                                                                                                                                                            | Ya                  | Listeners             |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| afterDispatch        | Dipicu setelah selesai menjalankan metode kontroler/aksi. Karena operasi tidak dapat dihentikan, hanya gunakan event ini untuk bersih-bersih setelah menjalankan aksi                                          | Yes                 | Listeners             |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| afterDispatchLoop    | Dipicu setelah keluar dispatch loop                                                                                                                                                                            | No                  | Listeners             |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| afterBinding         | Triggered after models are bound but before executing route                                                                                                                                                        | Yes                  | Listeners/Controllers |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+

Panduan :doc:`INVO <tutorial-invo>` menunjukkan bagaimana memanfaatkan  event dispatching untuk mengimplementasi filter keamanan dengan :doc:`Acl <acl>`

Contoh berikut menunjukkan bagaimana memasang listener ke komponen ini:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $di->set(
        "dispatcher",
        function () {
            // Buat event manager
            $eventsManager = new EventsManager();

            // Memasang listener untuk tipe "dispatch"
            $eventsManager->attach(
                "dispatch",
                function (Event $event, $dispatcher) {
                    // ...
                }
            );

            $dispatcher = new MvcDispatcher();

            // Ikat eventsManager ke komponen view
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        },
        true
    );

Kontroller yang diciptakan otomatis bertindak sebagai sebuah listener untuk mengirim event, anda dapat mengimplement metode sebagai callback:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;
    use Phalcon\Mvc\Dispatcher;

    class PostsController extends Controller
    {
        public function beforeExecuteRoute(Dispatcher $dispatcher)
        {
            // Eksekusi sebelum tiap aksi
        }

        public function afterExecuteRoute(Dispatcher $dispatcher)
        {
            // Eksekusi setelah tiap aksi
        }
    }

.. note:: Metode apda event listener menerima objek :doc:`Phalcon\\Events\\Event <../api/Phalcon_Events_Event>` sebagai parameter pertama - metode dalam kontroller tidak.

Mengarahkan ke aksi lain
------------------------
Dispatch loop memungkinkan kita mengarahkan alir ke kontroler/aksi lain. Ini sangat berguna untuk menguji apakah user dapat mengakses
opsi tertentu, mengarahkan user ke screen lain atau sekedar menggunakan ulang kode.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction($year, $postTitle)
        {
            // ... Store some product and forward the user

            // Forward flow to the index action
            $this->dispatcher->forward(
                [
                    "controller" => "posts",
                    "action"     => "index",
                ]
            );
        }
    }

Yang harus diingat membuat sebuah "forward" tidak sama dengan membuat HTTP redirect. Meski keduanya menghasilkan hasil sama.
"forward" tidak memuat ulang halaman saat ini, semua terjadi dalam satu request, sementara HTTP redirect butuh dua request
untuk menyelesaikan proses.

Contoh forwarding:

.. code-block:: php

    <?php

    // Arahkan ali ke aksi lain dalam kontroler saat ini
    $this->dispatcher->forward(
        [
            "action" => "search"
        ]
    );

    // Arahkan alir ke aksi lain dalam kontroler saa ini
    // dengan melewatkan parameter
    $this->dispatcher->forward(
        [
            "action" => "search",
            "params" => [1, 2, 3]
        ]
    );

Aksi forward menerima parameter berikut:

+----------------+------------------------------------------------------------+
| Parameter      | Memicu                                                     |
+================+============================================================+
| controller     | Sebuah nama kontroler sah untuk tujuan forward.            |
+----------------+------------------------------------------------------------+
| action         | Sebuah nama aksi sah untuk tujauan forward.                |
+----------------+------------------------------------------------------------+
| params         | Sebuah array parameter aksi.                               |
+----------------+------------------------------------------------------------+
| namespace      | Sebauah nama namespace sah dimana kontroler menjadi bagian |
+----------------+------------------------------------------------------------+

Menyiapkan Parameter
--------------------
Terima kasih ke hook point yang disediakan :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` anda dapat dengan mudah
mengubah aplikasi anda ke sembarang URL schema:

Contoh, anda ingin URL seperti: http://example.com/controller/key1/value1/key2/value

Parameter secara default dilewatkan sesuai tempatnya di URL ke aksi, anda dapat mengubahnya ke schema yang anda mau:

.. code-block:: php

    <?php

    use Phalcon\Dispatcher;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $di->set(
        "dispatcher",
        function () {
            // Buat sebuah EventsManager
            $eventsManager = new EventsManager();

            // Pasang listener
            $eventsManager->attach(
                "dispatch:beforeDispatchLoop",
                function (Event $event, $dispatcher) {
                    $params = $dispatcher->getParams();

                    $keyParams = [];

                    // Gunakan paramter ganjil sebagai key dan genap sebagai value
                    foreach ($params as $i => $value) {
                        if ($i & 1) {
                            // Previous param
                            $key = $params[$i - 1];

                            $keyParams[$key] = $value;
                        }
                    }

                    // Override parameters
                    $dispatcher->setParams($keyParams);
                }
            );

            $dispatcher = new MvcDispatcher();

            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

Jika schema yang diinginkan adalah: http://example.com/controller/key1:value1/key2:value, kode berikut diperlukan:

.. code-block:: php

    <?php

    use Phalcon\Dispatcher;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $di->set(
        "dispatcher",
        function () {
            // Buat sebuah EventsManager
            $eventsManager = new EventsManager();

            // Pasang sebuah listener
            $eventsManager->attach(
                "dispatch:beforeDispatchLoop",
                function (Event $event, $dispatcher) {
                    $params = $dispatcher->getParams();

                    $keyParams = [];

                    // Pisah tiap parameter sebagai pasangan key,value
                    foreach ($params as $number => $value) {
                        $parts = explode(":", $value);

                        $keyParams[$parts[0]] = $parts[1];
                    }

                    // Override parameters
                    $dispatcher->setParams($keyParams);
                }
            );

            $dispatcher = new MvcDispatcher();

            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

Mengambil Parameters
--------------------
Ketika sebuah route menyediakan parameter bernama, anda dapat menerimanya dalam sebuah kontroler, view atau komponen lain turunan
:doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>`.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // Ambil judul post yang dilewatkan sebagai parameter
            // atau yang disiapkan dalam sebuah event
            $title = $this->dispatcher->getParam("title");

            // Ambil tahun post yang dilewatkan sebagai parameter
            // atau yang disiapkan dalam sebuah event juga lakukan filter
            $year = $this->dispatcher->getParam("year", "int");

            // ...
        }
    }

Menyiapkan aksi
---------------
Anda dapat mendefinisikan sembarang schema bagi aksi sebelum dispatch.

Camel-case nama aksi
^^^^^^^^^^^^^^^^^^^^
Jika ULR asli: http://example.com/admin/products/show-latest-products,
dan misalnya anda ingin mengubahnya menjadi camel-case 'show-latest-products' ke 'ShowLatestProducts',
kode berikut ini diperlukan:

.. code-block:: php

    <?php

    use Phalcon\Text;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $di->set(
        "dispatcher",
        function () {
            // Buat EventsManager
            $eventsManager = new EventsManager();

            // Ubah aksi menjadi camel-case
            $eventsManager->attach(
                "dispatch:beforeDispatchLoop",
                function (Event $event, $dispatcher) {
                    $dispatcher->setActionName(
                        Text::camelize($dispatcher->getActionName())
                    );
                }
            );

            $dispatcher = new MvcDispatcher();

            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

Hapus ekstensi lama
^^^^^^^^^^^^^^^^^^^
Jika URL asli selalu berisi ekstensi '.php':

http://example.com/admin/products/show-latest-products.php
http://example.com/admin/products/index.php

Anda dapat menghapusnya sebelum dispatch kombinasi controller/action:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    $di->set(
        "dispatcher",
        function () {
            // Buat EventsManager
            $eventsManager = new EventsManager();

            // Hapus ekstensi sebelum dispatch
            $eventsManager->attach(
                "dispatch:beforeDispatchLoop",
                function (Event $event, $dispatcher) {
                    $action = $dispatcher->getActionName();

                    // Hapus ekstensi
                    $action = preg_replace("/\.php$/", "", $action);

                    // Override action
                    $dispatcher->setActionName($action);
                }
            );

            $dispatcher = new MvcDispatcher();

            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

Inject model instances
^^^^^^^^^^^^^^^^^^^^^^
Di contoh ini, developer ingin menginspeksi parameter yang sebuah aksi akan terima  untuk
menginjek instance model secara dinamis.

Kontroler terlihat seperti berikut:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        /**
         * Tampilkan post
         *
         * @param \Posts $post
         */
        public function showAction(Posts $post)
        {
            $this->view->post = $post;
        }
    }

Metode 'showAction' menerima instance model \Posts, developer dapat menginspeksinya
sebelum mengirim aksi dan menyiapkan parameter yang sesuai:

.. code-block:: php

    <?php

    use Exception;
    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use ReflectionMethod;

    $di->set(
        "dispatcher",
        function () {
            // Buat EventsManager
            $eventsManager = new EventsManager();

            $eventsManager->attach(
                "dispatch:beforeDispatchLoop",
                function (Event $event, $dispatcher) {
                    // Nama kelas yang mungkin
                    $controllerName = $dispatcher->getControllerClass();

                    // nama metode yang mungkin
                    $actionName = $dispatcher->getActiveMethod();

                    try {
                        // Ambil reflection untuk metode untuk dieksekusi
                        $reflection = new ReflectionMethod($controllerName, $actionName);

                        $parameters = $reflection->getParameters();

                        // Cek parameter
                        foreach ($parameters as $parameter) {
                            // Ambil nama model yang diharapkan
                            $className = $parameter->getClass()->name;

                            // Uji apakah parameter mengharapkan instance model
                            if (is_subclass_of($className, Model::class)) {
                                $model = $className::findFirstById($dispatcher->getParams()[0]);

                                // Override parameters menggunakan model instance
                                $dispatcher->setParams([$model]);
                            }
                        }
                    } catch (Exception $e) {
                        // exception terjadi, mungkin kelas atau aksi tidak ada?
                    }
                }
            );

            $dispatcher = new MvcDispatcher();

            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

Contoh di atas telah disederhanakan untuk tujuan akademis.
Developer dapat memperbaikinya dengan menginjek sembarang ketergantungan atau model dalam aksi sebelum dieksekusi.

From 3.1.x onwards the dispatcher also comes with an option to handle this internally for all models passed into a controller action by using :doc:`Phalcon\\Mvc\\Model\\Binder <../api/Phalcon_Mvc_Model_Binder>`.

.. code-block:: php

    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\Model\Binder;

    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinder(new Binder());

    return $dispatcher;

.. highlights::

    Since Binder object is using internally Reflection Api which can be heavy there is ability to set cache. This can be done by
    using second argument in :code:`setModelBinder()` which can also accept service name or just by passing cache instance to :code:`Binder` constructor.

It also introduces a new interface :doc:`Phalcon\\Mvc\\Model\\Binder\\BindableInterface <../api/Phalcon_Mvc_Model_Binder_BindableInterface>`
which allows you to define the controllers associated models to allow models binding in base controllers.

For example, you have a base CrudController which your PostsController extends from. Your CrudController looks something like this:

.. code-block:: php

    use Phalcon\Mvc\Controller;
    use Phalcon\Mvc\Model;

    class CrudController extends Controller
    {
        /**
         * Show action
         *
         * @param Model $model
         */
        public function showAction(Model $model)
        {
            $this->view->model = $model;
        }
    }

In your PostsController you need to define which model the controller is associated with. This is done by implementing the
:doc:`Phalcon\\Mvc\\Model\\Binder\\BindableInterface <../api/Phalcon_Mvc_Model_Binder_BindableInterface>`
which will add the :code:`getModelName()` method from which you can return the model name. It can return string with just one model name or associative array
where key is parameter name.

.. code-block:: php

    use Phalcon\Mvc\Model\Binder\BindableInterface;
    use Models\Posts;

    class PostsController extends CrudController implements BindableInterface
    {
        public static function getModelName()
        {
            return Posts::class;
        }
    }

By declaring the model associated with the PostsController the binder can check the controller for the :code:`getModelName()` method before passing
the defined model into the parent show action.

If your project structure does not use any parent controller you can of course still bind the model directly into the controller action:

.. code-block:: php

    use Phalcon\Mvc\Controller;
    use Models\Posts;

    class PostsController extends Controller
    {
        /**
         * Shows posts
         *
         * @param Posts $post
         */
        public function showAction(Posts $post)
        {
            $this->view->post = $post;
        }
    }

.. highlights::

    Currently the binder will only use the models primary key to perform a :code:`findFirst()` on.
    An example route for the above would be /posts/show/{1}

Menangani Eksepsi tidak ditemukan
---------------------------------
Menggunakan :doc:`EventsManager <events>` dimungkinkan untuk menyisipkan hook point sebelum dispatcher melemparkan eksepsi ketika kombinasi kontroler/aksi tidak ditemukan:

.. code-block:: php

    <?php

    use Exception;
    use Phalcon\Dispatcher;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

    $di->setShared(
        "dispatcher",
        function () {
            // Buat EventsManager
            $eventsManager = new EventsManager();

            // Pasang listener
            $eventsManager->attach(
                "dispatch:beforeException",
                function (Event $event, $dispatcher, Exception $exception) {
                    // Tangani eksepsi 404
                    if ($exception instanceof DispatchException) {
                        $dispatcher->forward(
                            [
                                "controller" => "index",
                                "action"     => "show404",
                            ]
                        );

                        return false;
                    }

                    // cara lain, kontroler atau aksi tidak ada
                    switch ($exception->getCode()) {
                        case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                        case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                            $dispatcher->forward(
                                [
                                    "controller" => "index",
                                    "action"     => "show404",
                                ]
                            );

                            return false;
                    }
                }
            );

            $dispatcher = new MvcDispatcher();

            // Ikat EventsManager ke dispatcher
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        }
    );

Tentu metode ini dapat dipindah ke dalam kelas plugin independen, sehingga memungkinkan lebih dari satu kelas
mengambil aksi ketika sebuah eksepsi dihasilkan dalam dispatch loop:

.. code-block:: php

    <?php

    use Exception;
    use Phalcon\Events\Event;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

    class ExceptionsPlugin
    {
        public function beforeException(Event $event, Dispatcher $dispatcher, Exception $exception)
        {
            // Default error action
            $action = "show503";

            // Tangani eksepsi 404
            if ($exception instanceof DispatchException) {
                $action = "show404";
            }

            $dispatcher->forward(
                [
                    "controller" => "index",
                    "action"     => $action,
                ]
            );

            return false;
        }
    }

.. highlights::

    Hanya eksepsi yang dihasilkan dispatcher dan eksepsi yang dihasilkan dalam aksi yang dijalankan
    diberitahu dalam event 'beforeException'. Eksepsi yang dihasilkan dalam listener atau
    event kontroler diarahkan ke try/catch paling akhir.

Mengimplementasi Dispatcher anda sendiri
----------------------------------------
Interface :doc:`Phalcon\\Mvc\\DispatcherInterface <../api/Phalcon_Mvc_DispatcherInterface>` harus diimplementasi untuk menciptakan dispatcher anda sendiri
menggantikan yang disediakan Phalcon.
