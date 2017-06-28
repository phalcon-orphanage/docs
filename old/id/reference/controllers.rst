Menggunakan Kontroler
=====================

Aksi adalah metode pada sebuah kontroler yang menangani request. Defaultnya semua
metode publik pada sebuah kontroler dipetakan ke aksi dan dapat diakses menggunakan sebuah URL. Aksi bertanggung jawab menerjemahkan request dan menciptakan
respon. Respon biasanya dalam bentuk view yang dirender, namun ada juga cara lain untuk menciptakan respon.

Contoh, ketika anda mengakses sebuah URL seperti berikut: http://localhost/blog/posts/show/2015/the-post-title Phalcon secara bawaan akan memecah tiap
bagian seperti berikut:

+-----------------------+----------------+
| **Phalcon Directory** | blog           |
+-----------------------+----------------+
| **Controller**        | posts          |
+-----------------------+----------------+
| **Action**            | show           |
+-----------------------+----------------+
| **Parameter**         | 2015           |
+-----------------------+----------------+
| **Parameter**         | the-post-title |
+-----------------------+----------------+

Di kasus ini, PostsController akan menangani request ini. Tidak ada lokasi khusus untuk meletakkan kontroler dalam aplikasi, ia
dapat dimuat menggunakan :doc:`autoloaders <loader>`, sehingga anda bebas mengorganisasi kontroler sesuai kebutuhan.

Kontroler harus memiliki akhiran "Controller" sementara aksi menggunakan akhiran "Action". Contoh sebuah kontroler adalah sebagai berikut:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($year, $postTitle)
        {

        }
    }

Parameter URI tambahan didefinisi sebagai parameter aksi, sehingga mereka dapat diakses dengan mudah menggunakan variabel lokal. Sebuah kontroler bisa jadi
diturunkan dari :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>`. Dengan melakukan ini, kontroler dapat memiliki akses mudah ke layanan aplikasi.

Parameter tanpa nilai default ditangani seperlunya. Pengaturan nilai opsional untuk parameter dilakukan seperti biasa dalam PHP:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($year = 2015, $postTitle = "some default title")
        {

        }
    }

Parameter disalin dengan urutan sama ketika dilewatkan dalam sebuah route. Anda dapat memeroleh sembarang parameter dari namanya dengan cara berikut:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction()
        {
            $year      = $this->dispatcher->getParam("year");
            $postTitle = $this->dispatcher->getParam("postTitle");
        }
    }

Dispatch Loop
-------------
Dispatch loop akan dijalankan dalam Dispatcher sampai tidak ada aksi tersisa untuk dijalankan. Di contoh sebelumnya hanya satu
aksi yang dijalankan. Kita akan melihat bagaimana :code:`forward()` dapat menyediakan alir operasi yang lebih kompleks dalam dispatch loop, dengan mengarahkan
eksekusi ke kontroler/aksi berbeda.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($year, $postTitle)
        {
            $this->flash->error(
                "You don't have permission to access this area"
            );

            // Arahkan alir ke aksi lain
            $this->dispatcher->forward(
                [
                    "controller" => "users",
                    "action"     => "signin",
                ]
            );
        }
    }

Jika pengguna tidak memiliki izin untuk mengakses aksi tertentu maka mereka akan diarahkan ke kontroler Users dan aksi bernama signin.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UsersController extends Controller
    {
        public function indexAction()
        {

        }

        public function signinAction()
        {

        }
    }

Tidak ada batasan jumlah "forward" yang dapat anda miliki dalam aplikasi, selama mereka tidak menyebabkan referensi sirkular, di mana dititik ini aplikasi akan dihentikan.
Jika tidak ada aksi lain yang harus dikirim oleh dispatch loop, dispatcher otomatis memanggil
lapisan view dalam MVC yang dikelola oleh :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`.

Inisialiasi Kontroler
---------------------
:doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` menawarkan metode :code:`initialize()`, yang dijalankan pertama kali, sebelum semua
aksi dieksekusi pada sebuah kontroler. Penggunaan metode :code:`__construct()` tidak disarankan.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public $settings;

        public function initialize()
        {
            $this->settings = [
                "mySetting" => "value",
            ];
        }

        public function saveAction()
        {
            if ($this->settings["mySetting"] === "value") {
                // ...
            }
        }
    }

.. highlights::

    Metode :code:`initialize()` hanya dipanggil jika event 'beforeExecuteRoute' dieksekusi dengan sukses. Ini mencegah
    kode aplikasi dalam initializer tidak dapat dieksekusi tanpa otorisasi.

Jika anda ingin menjalankan kode inisialiasi tepat setelah menciptakan objek kontroler anda dapat mengimplementasi
metode :code:`onConstruct()`:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function onConstruct()
        {
            // ...
        }
    }

.. highlights::

    Ketahui bahwa metode :code:`onConstruct()` dijalankan bahkan bila aksi yang harus dijalankan tidak ada
    dalam kontroler atau user tidak punya akses ke sana (berdasarkan kontrol akses kustom yang disediakan
    oleh developer).

Menginjeksi Services
--------------------
Jika sebuah kontroler diturunkan dari :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` maka mudah untuk mengakses service
container dalam aplikasi. Contoh, jika kita mendaftarkan sebuah service seperti ini:

.. code-block:: php

    <?php

    use Phalcon\Di;

    $di = new Di();

    $di->set(
        "storage",
        function () {
            return new Storage(
                "/some/directory"
            );
        },
        true
    );

Anda dapat mengakses service tersebut dengan beberapa cara:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class FilesController extends Controller
    {
        public function saveAction()
        {
            // Menginjeksi service dengan mengakses property bernama sama
            $this->storage->save("/some/file");

            // Mengakses service dari DI
            $this->di->get("storage")->save("/some/file");

            // Cara lain mengakses service dengan magic getter
            $this->di->getStorage()->save("/some/file");

            // Cara lain mengakses service dengan magic getter
            $this->getDi()->getStorage()->save("/some/file");

            // Menggunkana sintaks array
            $this->di["storage"]->save("/some/file");
        }
    }

Jika anda menggunakan Phalcon sebagai sebuah full-stack framework, anda dapat membaca service :doc:`bawaan <di>` yang disediakan dalam framework.

Request dan Response
--------------------
Diasumsikan framework menyediakan sejumlah service yang telah terdaftar. Kita menjelaskan bagaimana berinteraksi dengan lingkungan HTTP.
Service "request" mengandung instance :doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>` dan "response"
berisi :doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>` mewakili apa yang akan dikirim kembali ke klien.

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
            // Uji apakah request dibuat dengan POST
            if ($this->request->isPost()) {
                // Akses data POST
                $customerName = $this->request->getPost("name");
                $customerBorn = $this->request->getPost("born");
            }
        }
    }

Objek response biasanya tidak digunakan secara langsung, ia dibuat sebelum eksekusi aksi, kadang kala - seperti dalam event
afterDispatch - cukup berguna bila response dapat diakses langsung:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function notFoundAction()
        {
            // Kirim response header HTTP 404
            $this->response->setStatusCode(404, "Not Found");
        }
    }

Pelajari lebih lanjut tentang lingkungan HTTP di artikel :doc:`request <request>` dan :doc:`response <response>`.

Data Session
------------
Session membantu kita mengelola data persisten antar request. Anda dapat mengakses :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`
dari sembarang kontroler untuk membungkus data yang harus dibuat persisten.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UserController extends Controller
    {
        public function indexAction()
        {
            $this->persistent->name = "Michael";
        }

        public function welcomeAction()
        {
            echo "Welcome, ", $this->persistent->name;
        }
    }

Menggunakan Service sebagai Kontroler
-------------------------------------
Service dapat bertindak sebagai kontroler, kelas kontroler selalu diminta dari service container. Dengan demikian,
tiap kelas lain yang terdaftar dengan nama sama dapat dengan mudah mengganti sebuah kontroler:

.. code-block:: php

    <?php

    // Daftarkan kontroler sebagai service
    $di->set(
        "IndexController",
        function () {
            $component = new Component();

            return $component;
        }
    );

    // Daftarkan kontroler dengan namespace sebagai service
    $di->set(
        "Backend\\Controllers\\IndexController",
        function () {
            $component = new Component();

            return $component;
        }
    );

Event dalam Kontroler
---------------------
Kontroler otomatis bertindak sebagai listener untuk :doc:`dispatcher <dispatching>` event, mengimplementasi metode dengan nama tersebut memungkinkan
anda untuk mengimplementasi hook point sebelum/sesudah aksi dieksekusi:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function beforeExecuteRoute($dispatcher)
        {
            // This is executed before every found action
            if ($dispatcher->getActionName() === "save") {
                $this->flash->error(
                    "You don't have permission to save posts"
                );

                $this->dispatcher->forward(
                    [
                        "controller" => "home",
                        "action"     => "index",
                    ]
                );

                return false;
            }
        }

        public function afterExecuteRoute($dispatcher)
        {
            // Dieksekusi tiap kali setelah aksi yang ditemukan
        }
    }

.. _DRY: https://en.wikipedia.org/wiki/Don%27t_repeat_yourself
