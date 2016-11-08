Pesan Flash
===========

Pesan flash digunakan untuk memberitahu user tentang status aksi yang dibuatnya atau sekedar menunjukkan informasi ke user.
Pesan semacam ini dapat dibuat dengan menggunakan komponen ini.

Adapter
-------
Komponen ini menggunakan adapter untuk mendefinisikan perilaku pesan setelah dilewatkan ke Flasher:

+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Adapter | Keterangan                                                                                    | API                                                                        |
+=========+===============================================================================================+============================================================================+
| Direct  | Cetak pesan langsung setelah dilewatkan ke flasher                                            | :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`                |
+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Session | Simpan pesan disession sementara, lalu pesan dicetak di request berikutnya                    | :doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>`              |
+---------+-----------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+

Penggunaan
----------
Biasanya layanan Flash Messaging diminta dari services container.
Jika anda menggunakan :doc:`Phalcon\\Di\\FactoryDefault <../api/Phalcon_Di_FactoryDefault>`
maka :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>` otomatis terdaftar sebagai seervice bernama "flash" dan
:doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>` ittinatus terdaftar sebagai "flashSession" service.
Anda dapat juga mendaftarkannya secara manual:

.. code-block:: php

    <?php

    use Phalcon\Flash\Direct as FlashDirect;
    use Phalcon\Flash\Session as FlashSession;

    // Siapkan flash service
    $di->set(
        "flash",
        function () {
            return new FlashDirect();
        }
    );

    // Siapkan flash session service
    $di->set(
        "flashSession",
        function () {
            return new FlashSession();
        }
    );

Dengan cara ini, anda dapat menggunakannya dalam kontroler atau view:

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
            $this->flash->success("The post was correctly saved!");
        }
    }

Berikut ini adalah empat jenis pesan bawaan yang didukung:

.. code-block:: php

    <?php

    $this->flash->error("too bad! the form had errors");

    $this->flash->success("yes!, everything went very smoothly");

    $this->flash->notice("this a very important information");

    $this->flash->warning("best check yo self, you're not looking too good.");

Anda dapat juga menambahkan pesan dengan tipe milik anda sendiri menggunakan metode :code:`message()`:

.. code-block:: php

    <?php

    $this->flash->message("debug", "this is debug message, you don't say");

Mencetak Pesan
--------------
Pesan yang dikirim ke flash service otomatis diformat berupa HTML:

.. code-block:: html

    <div class="errorMessage">too bad! the form had errors</div>

    <div class="successMessage">yes!, everything went very smoothly</div>

    <div class="noticeMessage">this a very important information</div>

    <div class="warningMessage">best check yo self, you're not looking too good.</div>

Dapat Anda lihat, kelas CSS ditambahkan otomatis ke :code:`<div>`s. Kelas ini memungkinkan anda menentukan pesentasi grafis
pesan di browser. Kelas CSS ini dapat di override, misal jika anda menggunakan Twitter Bootstrap, ia dapat dikonfigurasi sebagai:

.. code-block:: php

    <?php

    use Phalcon\Flash\Direct as FlashDirect;

    // Daftarkan flash service dengan kelas CSS custom
    $di->set(
        "flash",
        function () {
            $flash = new FlashDirect(
                [
                    "error"   => "alert alert-danger",
                    "success" => "alert alert-success",
                    "notice"  => "alert alert-info",
                    "warning" => "alert alert-warning",
                ]
            );

            return $flash;
        }
    );

maka pesan dapat dicetak sebagai berikut:

.. code-block:: html

    <div class="alert alert-danger">too bad! the form had errors</div>

    <div class="alert alert-success">yes!, everything went very smoothly</div>

    <div class="alert alert-info">this a very important information</div>

    <div class="alert alert-warning">best check yo self, you're not looking too good.</div>

Flush Implisit vs. Session
--------------------------
Tergantung adapter yang digunakan untuk mengirim pesan, ia dapat menghasilkan output langsung, atau menyimpan pesan sementara di session untuk ditampilkan nanti.
Kapan anda harus menggunakan masing-masing? Itu tergantung jenis redirection yang anda lakukan setelah mengirim pesan. Contoh,
jika anda membuat "forward" tidak perlu menyimpan pesan dalam session, tetapi jika anda melakukan HTTP redirect, mereka harus disimpan di session:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ContactController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // Simpan post

            // Menggunakan direct flash
            $this->flash->success("Your information was stored correctly!");

            // Forward ke index action
            return $this->dispatcher->forward(
                [
                    "action" => "index"
                ]
            );
        }
    }

Atau menggunakan HTTP redirection:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ContactController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // Simpan post

            // Menggunakan session flash
            $this->flashSession->success("Your information was stored correctly!");

            // Buat HTTP redirection penuh
            return $this->response->redirect("contact/index");
        }
    }

Dalam hal anda perlu mencetak pesan secara manual di view terkait:

.. code-block:: html+php

    <!-- app/views/contact/index.phtml -->

    <p><?php $this->flashSession->output() ?></p>

Atribut 'flashSession' adalah flash yang sebelumnya diset ke kontainer dependency injection.
Anda perlu menjalankan :doc:`session <session>` terlebih dahulu untuk dapat menggunakan flashSession messenger.
