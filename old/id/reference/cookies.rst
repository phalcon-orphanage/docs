Pengelolaan Cookies
===================

Cookies_ adalah cara yang berguna untuk menyimpan potongan data kecil di mesin klien yang dapat dibaca meski
pengguna menutup brosernya. :doc:`Phalcon\\Http\\Response\\Cookies <../api/Phalcon_Http_Response_Cookies>`
bertindak sebagai penampung global untuk cookies. Cookies disimpan disini selama eksekusi request dan dikirim
otomatis diakhir request.

Penggunaan Dasar
----------------
Anda dapat mengubah/membaca cookies dengan mengakses 'cookies' service disembarang bagian aplikasi di mana service bisa
diakses:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SessionController extends Controller
    {
        public function loginAction()
        {
            // Uji apakah cookies sebelumnya sudah diset
            if ($this->cookies->has("remember-me")) {
                // Baca cookie
                $rememberMeCookie = $this->cookies->get("remember-me");

                // Baca isi cookie
                $value = $rememberMeCookie->getValue();
            }
        }

        public function startAction()
        {
            $this->cookies->set(
                "remember-me",
                "some value",
                time() + 15 * 86400
            );
        }

        public function logoutAction()
        {
            $rememberMeCookie = $this->cookies->get("remember-me");

            // Hapus cookie
            $rememberMe->delete();
        }
    }

Enkripsi/Dekripsi Cookies
-------------------------
Secara default, cookies secara otomatis dienkripsi sebelum dikirim ke klien dan didekripsi ketika dibaca dari pengguna.
Perlindungan ini mencegah pengguna yang tidak berhak melihat isi cookies di klien (browser).
Meski ada perlindungan ini, data sensitif seharusnya tidak disimpan di cookies.

Anda dapat mematikan enkripsi dengan cara berikut:

.. code-block:: php

    <?php

    use Phalcon\Http\Response\Cookies;

    $di->set(
        "cookies",
        function () {
            $cookies = new Cookies();

            $cookies->useEncryption(false);

            return $cookies;
        }
    );

Jika anda ingin menggunakan enkripsi, sebuah key global harus diset di 'crypt' service:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    $di->set(
        "crypt",
        function () {
            $crypt = new Crypt();

            $crypt->setKey('#1dj8$=dp?.ak//j1V$'); // Gunakan key anda sendiri!

            return $crypt;
        }
    );

.. highlights::

    Mengirim data cookies tanpa enkripsi ke klien termasuk struktur objek kompleks, result sets,
    informasi layanan, dan lain-lain. dapat membuka detail internal aplikasi yang dapat dimanfaatkan penyerang
    untuk menyerang aplikasi. Jika anda tidak ingin menggunakan enkripsi, kami sarankankan anda hanya mengirim
    data cookie sangat sederhana atau string literal kecil.

.. _Cookies: http://en.wikipedia.org/wiki/HTTP_cookie
