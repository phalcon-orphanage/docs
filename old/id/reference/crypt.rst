Enkripsi/Dekripsi
=================

Phalcon menyediakan fasilitas enkripsi melalui komponen :doc:`Phalcon\\Crypt <../api/Phalcon_Crypt>`.
Kelas ini menawarkan pembungkus berorientasi objek sederhana ke pustaka enkripsi openssl_ milik PHP.

Secara default, komponen ini menyediakan enkripsi aman menggunakan AES-256-CFB.

.. highlights::
    Anda harus menggunakan panjang key sesuai algoritma saat ini.
    Untuk algoritma yang digunakan secara default ukurannya 32 bytes.

Penggunaan Dasar
----------------
Komponen ini dirancang untuk menyediakan cara penggunaan sangat sederhana:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // Buat instance
    $crypt = new Crypt();

    $key  = "This is a secret key (32 bytes).";
    $text = "This is the text that you want to encrypt.";

    $encrypted = $crypt->encrypt($text, $key);

    echo $crypt->decrypt($encrypted, $key);

Anda dapat menggunakan instance sama untuk enkripsi/dekripsi beberapa kali:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // Buat instance
    $crypt = new Crypt();

    $texts = [
        "my-key"    => "This is a secret text",
        "other-key" => "This is a very secret",
    ];

    foreach ($texts as $key => $text) {
        // Lakukan enkripsi
        $encrypted = $crypt->encrypt($text, $key);

        // Sekarang dekripsi
        echo $crypt->decrypt($encrypted, $key);
    }

Opsi Enkripsi
-------------
Opsi berikut tersedia untuk mengubah perilaku enkripsi:

+------------+---------------------------------------------------------------------------------------------------+
| Nama       | Keterangan                                                                                        |
+============+===================================================================================================+
| Cipher     | Cipher adalah algoritma enkripsi yang didukung openssl. Anda dapat melihat daftarnya di sini_     |
+------------+---------------------------------------------------------------------------------------------------+

Contoh:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // Buat instance
    $crypt = new Crypt();

    // Gunakan blowfish
    $crypt->setCipher("bf-cbc");

    $key  = "le password";
    $text = "This is a secret text";

    echo $crypt->encrypt($text, $key);

Dukungan Base64
---------------
Agar enkripsi dapat ditransmisi (email) atau ditampilkan (browser) dengan benar base64_ encoding biasanya diterapkan pada teks terenkripsi:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    // Buat instance
    $crypt = new Crypt();

    $key  = "le password";
    $text = "This is a secret text";

    $encrypt = $crypt->encryptBase64($text, $key);

    echo $crypt->decryptBase64($encrypt, $key);

Menyiapkan Layanan Enkripsi
---------------------------
Anda dapat menyiapkan komponen enkripsi dalam service container agar dapat menggunakannya disembarang bagian aplikasi:

.. code-block:: php

    <?php

    use Phalcon\Crypt;

    $di->set(
        "crypt",
        function () {
            $crypt = new Crypt();

            // Set key enkripsi global
            $crypt->setKey(
                "%31.1e$i86e$f!8jz"
            );

            return $crypt;
        },
        true
    );

lalu, contohnya, dalam sebuah kontroler anda dapat menggunakannya sebagai berikut:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class SecretsController extends Controller
    {
        public function saveAction()
        {
            $secret = new Secrets();

            $text = $this->request->getPost("text");

            $secret->content = $this->crypt->encrypt($text);

            if ($secret->save()) {
                $this->flash->success(
                    "Secret was successfully created!"
                );
            }
        }
    }

.. _openssl: http://www.php.net/manual/en/book.openssl.php
.. _sini: http://www.php.net/manual/en/function.openssl-get-cipher-methods.php
.. _base64: http://www.php.net/manual/en/function.base64-encode.php
