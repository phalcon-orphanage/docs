Penyaringan dan Sanitasi
========================

Sanitasi input pengguna adalah bagian penting pengembangan software. Mempercayai atau mengabaikan sanitasi input pengguna dapat mengarah ke akses
terlarang ke isi aplikasi Anda, terutama data pengguna, atau bahkan server di mana aplikasi anda disimpan.

.. figure:: ../_static/img/sql.png
   :align: center

`Gambar penuh (dari xkcd)`_

Komponen :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` menyediakan himpunan filter dan helper untuk sanitasi data yang umum digunakan. Ia menyediakan pembungkus berorientasi objek untuk ekstensi filter PHP.

Jenis Filter Bawaan
-------------------
Berikut ini adalah filter bawaan yang disediakan komponen ini:

+-----------+---------------------------------------------------------------------------+
| Nama      | Keterangan                                                                |
+===========+===========================================================================+
| string    | Melucuti tag dan entiti HTML, termasuk petik tunggal dan ganda.           |
+-----------+---------------------------------------------------------------------------+
| email     | Hapus semua karakter kecuali huruf, angka dan !#$%&*+-/=?^_`{\|}~@.[].    |
+-----------+---------------------------------------------------------------------------+
| int       | Hapus semua karakter kecuali angka dan tanda plus minus.                  |
+-----------+---------------------------------------------------------------------------+
| float     | Hapus semua karakter kecuali angka, titik, dan tanda plus minus.          |
+-----------+---------------------------------------------------------------------------+
| alphanum  | Hapus semua karakter kecuali [a-zA-Z0-9]                                  |
+-----------+---------------------------------------------------------------------------+
| striptags | Terapkan fungsi strip_tags_                                               |
+-----------+---------------------------------------------------------------------------+
| trim      | Terapkan fungsi trim_                                                     |
+-----------+---------------------------------------------------------------------------+
| lower     | Terapkan fungsi strtolower_                                               |
+-----------+---------------------------------------------------------------------------+
| upper     | Terapkan fungsi strtoupper_                                               |
+-----------+---------------------------------------------------------------------------+

Sanitasi data
-------------
Sanitasi data adalah proses menghapus karakter tertentu dari sebuah nilai, yang tidak diperlukan atau tidak diinginkan oleh user atau aplikasi.
Dengan sanitasi input kita memastikan integritas aplikasi tetap terjaga.

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // Mengembalikan "someone@example.com"
    $filter->sanitize("some(one)@exa\mple.com", "email");

    // Mengembalikan "hello"
    $filter->sanitize("hello<<", "string");

    // Mengembalikan "100019"
    $filter->sanitize("!100a019", "int");

    // Mengembalikan "100019.01"
    $filter->sanitize("!100a019.01a", "float");


Sanitasi dari Kontroler
-----------------------
Anda dapat mengakses sebuah objek :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` dari kontroller anda ketika mengakses data input GET atau POST
(melalui objek request). Parameter pertama adalah nama variabel yang diambil; kedua adalah filter yang diterapkan kepadanya.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ProductsController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // Sanitasi input bernama price
            $price = $this->request->getPost("price", "double");

            // Sanitasi email dari input
            $email = $this->request->getPost("customerEmail", "email");
        }
    }

Menyaring Parameter Aksi
----------------------
Contoh berikut menunjukkan kepada anda bagaimana membersihkan parameter dalam sebuah aksi kontroler:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ProductsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($productId)
        {
            $productId = $this->filter->sanitize($productId, "int");
        }
    }

Menyaring data
--------------
Selain sanitasi, :doc:`Phalcon\\Filter <../api/Phalcon_Filter>` juga mneyediakan penyaringan dengan menghapus atau mengubah data input
ke format yang kita harapkan.

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // Mengembalikan "Hello"
    $filter->sanitize("<h1>Hello</h1>", "striptags");

    // Mengembalikan "Hello"
    $filter->sanitize("  Hello   ", "trim");

Menggabung Filter
-----------------
Anda dapat menjalankan beberapa filter pada sebuah string pada saat bersamaan dengan melewatkan array pengenal filter pada parameter kedua:

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // Mengembalikan "Hello"
    $filter->sanitize(
        "   <h1> Hello </h1>   ",
        [
            "striptags",
            "trim",
        ]
    );

Menciptakan Filter anda sendiri
-------------------------------
Anda dapat menambahkan filter milik anda ke :doc:`Phalcon\\Filter <../api/Phalcon_Filter>`. Fungsi filter dapat pula berupa fungsi anonim:

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // Menggunakan fungsi anonim
    $filter->add(
        "md5",
        function ($value) {
            return preg_replace("/[^0-9a-f]/", "", $value);
        }
    );

    // Sanitasi dengan filter "md5"
    $filtered = $filter->sanitize($possibleMd5, "md5");

atau, jika anda suka, anda dapat mengimplementasi filter dalam sebuah kelas:

.. code-block:: php

    <?php

    use Phalcon\Filter;

    class IPv4Filter
    {
        public function filter($value)
        {
            return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        }
    }

    $filter = new Filter();

    // Menggunakan sebuah objek
    $filter->add(
        "ipv4",
        new IPv4Filter()
    );

    // Sanitasi dengan filter "ipv4"
    $filteredIp = $filter->sanitize("127.0.0.1", "ipv4");

Sanitasi dan Penyaringan Kompleks
---------------------------------
PHP sendiri menyedikan ekstensi filter bagus untuk anda gunakan. Lihat dokumentasinya: `Data Filtering at PHP Documentation`_

Mengimplementasi Filter anda sendiri
------------------------------------
Interface :doc:`Phalcon\\FilterInterface <../api/Phalcon_FilterInterface>` harus diimplementasi untuk menciptakan layanan penyaringan anda sendiri
menggantikan yang disediakan Phalcon.

.. _Gambar penuh (dari xkcd): http://xkcd.com/327/
.. _Data Filtering at PHP Documentation: http://www.php.net/manual/en/book.filter.php
.. _strip_tags: http://www.php.net/manual/en/function.strip-tags.php
.. _trim: http://www.php.net/manual/en/function.trim.php
.. _strtolower: http://www.php.net/manual/en/function.strtolower.php
.. _strtoupper: http://www.php.net/manual/en/function.strtoupper.php
