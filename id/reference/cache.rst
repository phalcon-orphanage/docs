Meningkatkan Performa dengan Cache
==================================

Phalcon menyediakan kelas :doc:`Phalcon\\Cache <cache>` yang memumungkinkan akses lebih cepat ke data terproses yang sering digunakan.
:doc:`Phalcon\\Cache <cache>` ditulis dalam C, menghasilkan performa lebih tinggi dan menurunkan overhead ketika mengambil item dari backend.
Kelas ini menggunakan struktur internal komponen frontend dan backend. Komponen front-end bertugas sebagai sumber input atau antar muka,
sementara komponen backend menyediakan opsi penyimpanan bagi kelas.

Kapan mengimplementasi cache?
-----------------------------
Meski komponen ini sangat cepat, mengimplementasinya dalam kasus ia tidak dibutuhkan dapat menyebabkan kehilangan performa daripada kenaikan.
Kami sarankan anda cek kasus ini sebelum menggunakna cache:

* Anda membuat kalkulasi kompleks yang selalu menghasilkan hasil yang sama (jarang berubah)
* Anda menggunakan banyak helper dan output yang dihasilkan hampir selalu sama
* Anda mengakses database terus menerus dan data ini jarang berubah

.. highlights::

    *NOTE* Bahkan seteleh mengimplementasi cache, anda harus cek hit rasio cache terhadap periode waktu. Ini dapat mudah
    dilakukan, khususnya untuk Memcache atau Apc, dengan tool relevan yang disediakan backend.

Perilaku Caching
----------------
Proses cache terbagi dua bagian:

* **Frontend**: Bagian ini bertanggung jawab untuk menguji apakah key telah kedaluwarsa dan melakukan transformasi tambahan terhadap data sebelum disimpan dan setelah diambil dari backend.
* **Backend**: Bagian ini bertanggung jawab untuk berkomunikasi, menulis/membaca data yang diperlukan frontend.

Caching Potongan Output
-----------------------
Output fragment adalah penggalan HTML atau teks yang dicache sebagaimana adanya dan dikembalikan apa adanya. Outputnya otomatis ditangkap
dari fungsi ob_* atau output PHP sehingga dapat disimpan di cache. Contoh berikut menunjukkan penggunaannya.
Kode tersebut menerima output yang dibangkitkan oleh PHP dan menyimpannya di sebuah file. Isi file diperbarui tiap 172800 detik (2 hari).

Implementasi mekanisme caching ini memungkinkan kita memperoleh kenaikan performa dengan tidak mengeksekusi pemanggilan helper :code:`Phalcon\Tag::linkTo()`
kapanpun potongan kode tersebut dipanggil.

.. code-block:: php

    <?php

    use Phalcon\Tag;
    use Phalcon\Cache\Backend\File as BackFile;
    use Phalcon\Cache\Frontend\Output as FrontOutput;

    // Buat output frontend. Cache file selama 2 hari
    $frontCache = new FrontOutput(
        [
            "lifetime" => 172800,
        ]
    );

    // Buat komponen yang akan menyimpan cache "Output" ke backend "File"
    // Set direktori cache, penting menambahkan "/" diakhir
    // untuk nama folder
    $cache = new BackFile(
        $frontCache,
        [
            "cacheDir" => "../app/cache/",
        ]
    );

    // Get/Set cache file ke ../app/cache/my-cache.html
    $content = $cache->start("my-cache.html");

    // Jika $content null maka isi akan dibuat untuk cache
    if ($content === null) {
        // Cetak tanggal dan waktu
        echo date("r");

        // Buat link ke sign-up action
        echo Tag::linkTo(
            [
                "user/signup",
                "Sign Up",
                "class" => "signup-button",
            ]
        );

        // Simpan output ke file cache
        $cache->save();
    } else {
        // Echo output yang dicache
        echo $content;
    }

*NOTE* Pada contoh di atas, Kode kita tetap sama, mencetak output ke user seperti yang sudah dilakukannya sebelumnya. Komponen cache kita
secara transparan menangkap output dan menyimpannya dalam file cache (ketika cache dibuat) atau mengirimkan kembali ke user
hasil pre-kompilasi dari pemanggilan sebelumnya, sehingga menghindari operasi yang mahal.

Caching Data Sembarang
----------------------
Caching data sama pentingnya bagi aplikasi anda. Caching dapat menurunkan beban database dengan menggunakan ulang data yang sering digunakan (namun tidak berubah),
sehingga mempercepat aplikasi anda.

Contoh File Backend
^^^^^^^^^^^^^^^^^^^
Salah satu adapter caching adalah 'File'. Yang paling penting untuk adapter ini adalah lokasi dimana file cache akan disimpan.
Ini dikendalikan oleh opsi cacheDir yang *wajib* memiliki backslash diakhir.

.. code-block:: php

    <?php

    use Phalcon\Cache\Backend\File as BackFile;
    use Phalcon\Cache\Frontend\Data as FrontData;

    // Cache file selama 2 days menggunakna Data frontend
    $frontCache = new FrontData(
        [
            "lifetime" => 172800,
        ]
    );

    // Buat komponen yang akan menyimpan cache "Data" ke "File" backend
    // Atur direktori file cache - penting untuk menambah "/" diakhir
    // folder
    $cache = new BackFile(
        $frontCache,
        [
            "cacheDir" => "../app/cache/",
        ]
    );

    $cacheKey = "robots_order_id.cache";

    // Coba ambil record yang dicache
    $robots = $cache->get($cacheKey);

    if ($robots === null) {
        // $robots null karena cache kedaluwarsa atau data tidak ada
        // Buat panggilan database dan isi variabel
        $robots = Robots::find(
            [
                "order" => "id",
            ]
        );

        // Simpan dalam cache
        $cache->save($cacheKey, $robots);
    }

    // Gunakan $robots :)
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

Contoh Memcached Backend
^^^^^^^^^^^^^^^^^^^^^^^^
Contoh di atas berubah sedikit (terutama dalam hal konfigurasi) ketika kita menggunakan Memcached backend.

.. code-block:: php

    <?php

    use Phalcon\Cache\Frontend\Data as FrontData;
    use Phalcon\Cache\Backend\Libmemcached as BackMemCached;

    // Cache data selama satu jam
    $frontCache = new FrontData(
        [
            "lifetime" => 3600,
        ]
    );

    // Buat komponen yang akan cache "Data" ke "Memcached" backend
    // Pengaturan koneksi Memcached
    $cache = new BackMemCached(
        $frontCache,
        [
            "servers" => [
                [
                    "host"   => "127.0.0.1",
                    "port"   => "11211",
                    "weight" => "1",
                ]
            ]
        ]
    );

    $cacheKey = "robots_order_id.cache";

    // Coba ambil record yang dicache
    $robots = $cache->get($cacheKey);

    if ($robots === null) {
        // $robots null karena cache kedaluwarsa atau karena data tidak ada
        // Buat panggilan database dan isi variabel
        $robots = Robots::find(
            [
                "order" => "id",
            ]
        );

        // Simpan di cache
        $cache->save($cacheKey, $robots);
    }

    // Gunakan $robots :)
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

Menanyakan cache
----------------
Elemen ditambakan ke cache diidentifikasi secara unik menggunakan sebuah key. Dalam hal File backend, key-nya adalah
nama file aktual. Untuk menerima data dari cache cache, kita cukup memanggilnya menggunakan key unik. Jika key tidak
ada, metode get akan mengembalikan null.

.. code-block:: php

    <?php

    // Ambil produk dengan key "myProducts"
    $products = $cache->get("myProducts");

Jika anda ingin tahu key mana yang disimpan di cache, anda dapat memanggil metode queryKeys:

.. code-block:: php

    <?php

    // Query all keys used in the cache
    $keys = $cache->queryKeys();

    foreach ($keys as $key) {
        $data = $cache->get($key);

        echo "Key=", $key, " Data=", $data;
    }

    // Query keys in the cache that begins with "my-prefix"
    $keys = $cache->queryKeys("my-prefix");

Menghapus data dari cache
-------------------------
Ada kalanya anda akan membutuhkan untuk menghapus entri cache (karena pembaruan pada data yang dicache).
Yang diperlukan hanya key ke data yang disimpan bersamanya.

.. code-block:: php

    <?php

    // Hapus sebuah item dengan key spesifik
    $cache->delete("someKey");

    $keys = $cache->queryKeys();

    // Hapus semua item dari cache
    foreach ($keys as $key) {
        $cache->delete($key);
    }

Menguji keberadaan cache
------------------------
Dimungkinkan untuk menguji apakah sebuah cache sudah ada dengan key yang ada:

.. code-block:: php

    <?php

    if ($cache->exists("someKey")) {
        echo $cache->get("someKey");
    } else {
        echo "Cache does not exists!";
    }

Masa hidup
----------
"Masa hidup" adalah waktu dalam detik sebauh cache dapat hidup sebelum kedaluwarsa. Secara default, semua cache yang diciptakan menggunakan masa idup yang diatur dalam penciptaan frontend.
Anda dapat mengatur masa hidup tertentu saat menciptakan atau mengambil data dari cache:

Mengatur ,asa hidup ketika mengambil:

.. code-block:: php

    <?php

    $cacheKey = "my.cache";

    // Mengatur cache ketika mengambil result
    $robots = $cache->get($cacheKey, 3600);

    if ($robots === null) {
        $robots = "some robots";

        // Simpan dicache
        $cache->save($cacheKey, $robots);
    }

Mengatur masa hidup ketika menyimpan:

.. code-block:: php

    <?php

    $cacheKey = "my.cache";

    $robots = $cache->get($cacheKey);

    if ($robots === null) {
        $robots = "some robots";

        // Atur cache saat menyimpan
        $cache->save($cacheKey, $robots, 3600);
    }

Cache Banyak-Tingkat
--------------------
Fitur komponen cache ini, megnizinkan developer untuk membuat implementasi cache banyak-tingkat. Fitur baru ini sangat berguna
karena anda dapat menyimpan data sama di beberapa lokasi cache dengan masa hidup berbeda, membaca pertama kali dari adapter yang lebih cepat
dan berakhir di yang paling lambat hingga data kedaluwarsa:

.. code-block:: php

    <?php

    use Phalcon\Cache\Multiple;
    use Phalcon\Cache\Backend\Apc as ApcCache;
    use Phalcon\Cache\Backend\File as FileCache;
    use Phalcon\Cache\Frontend\Data as DataFrontend;
    use Phalcon\Cache\Backend\Memcache as MemcacheCache;

    $ultraFastFrontend = new DataFrontend(
        [
            "lifetime" => 3600,
        ]
    );

    $fastFrontend = new DataFrontend(
        [
            "lifetime" => 86400,
        ]
    );

    $slowFrontend = new DataFrontend(
        [
            "lifetime" => 604800,
        ]
    );

    // Backend didaftarakan dari yang tercepat ke yang lambat
    $cache = new Multiple(
        [
            new ApcCache(
                $ultraFastFrontend,
                [
                    "prefix" => "cache",
                ]
            ),
            new MemcacheCache(
                $fastFrontend,
                [
                    "prefix" => "cache",
                    "host"   => "localhost",
                    "port"   => "11211",
                ]
            ),
            new FileCache(
                $slowFrontend,
                [
                    "prefix"   => "cache",
                    "cacheDir" => "../app/cache/",
                ]
            ),
        ]
    );

    // Simpan disemua backend
    $cache->save("my-key", $data);

Adapter Frontend
----------------
Adapter frontend yang tersedia yang digunakan sebagai antarmuka atau sumber input cache adalah:

+------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------+
| Adapter                                                                            | Keterangan                                                                                                                                             |
+====================================================================================+========================================================================================================================================================+
| :doc:`Phalcon\\Cache\\Frontend\\Output <../api/Phalcon_Cache_Frontend_Output>`     | Membaca input dari standard PHP output                                                                                                                 |
+------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Cache\\Frontend\\Data <../api/Phalcon_Cache_Frontend_Data>`         | Digunakan untuk cache sembarang data PHP (big arrays, objects, text, dan lain-lain). Data diserialisasi sebelum disimpan di backend.                   |
+------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Cache\\Frontend\\Base64 <../api/Phalcon_Cache_Frontend_Base64>`     | Digunakan untuk cache data biner. Data. Data diserialisasi dengan base64_encode sebelum disimpan di backend.                                           |
+------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Cache\\Frontend\\Json <../api/Phalcon_Cache_Frontend_Json>`         | Data di encode dalam JSON sebelum disimpan backend. Di decode setelah dibaca. Frontend berguna untuk berbagi data dengan bahasa atau framework lain.   |
+------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Cache\\Frontend\\Igbinary <../api/Phalcon_Cache_Frontend_Igbinary>` | Digunakan untu cache beragam data PHP (big arrays, objects, text, dan lain-lain). Data diserialisasi menggunakan IgBinary sebelum disimpan di backend. |
+------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Cache\\Frontend\\None <../api/Phalcon_Cache_Frontend_None>`         | Digunakan untuk cache beragam data PHP data tanpa serialisasi.                                                                                         |
+------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------+

Mengimplementasi adapter Frontend anda sendiri
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Interface :doc:`Phalcon\\Cache\\FrontendInterface <../api/Phalcon_Cache_FrontendInterface>` harus diimplementasi untuk dapat menciptakan adapter frontend anda atau mengembangkan yang sudah ada.

Adapter Backend
---------------
Adapter backend yang tersedia untuk menyimpan cache:

+----------------------------------------------------------------------------------+-----------------------------------------------+------------+--------------------------+
| Adapter                                                                          | Keterangan                                    | Info       | Ekstensi yang diperlukan |
+==================================================================================+===============================================+============+==========================+
| :doc:`Phalcon\\Cache\\Backend\\File <../api/Phalcon_Cache_Backend_File>`         | Menyimpan data ke file lokal                  |            |                          |
+----------------------------------------------------------------------------------+-----------------------------------------------+------------+--------------------------+
| :doc:`Phalcon\\Cache\\Backend\\Memcache <../api/Phalcon_Cache_Backend_Memcache>` | Menyimpan data ke server memcached            | Memcached_ | memcache_                |
+----------------------------------------------------------------------------------+-----------------------------------------------+------------+--------------------------+
| :doc:`Phalcon\\Cache\\Backend\\Apc <../api/Phalcon_Cache_Backend_Apc>`           | Menyimpan data ke Alternative PHP Cache (APC) | APC_       | `APC extension`_         |
+----------------------------------------------------------------------------------+-----------------------------------------------+------------+--------------------------+
| :doc:`Phalcon\\Cache\\Backend\\Mongo <../api/Phalcon_Cache_Backend_Mongo>`       | Menyimpan data ke Mongo Database              | MongoDb_   | `Mongo`_                 |
+----------------------------------------------------------------------------------+-----------------------------------------------+------------+--------------------------+
| :doc:`Phalcon\\Cache\\Backend\\Xcache <../api/Phalcon_Cache_Backend_Xcache>`     | Menyimpan data di in XCache                   | XCache_    | `xcache extension`_      |
+----------------------------------------------------------------------------------+-----------------------------------------------+------------+--------------------------+
| :doc:`Phalcon\\Cache\\Backend\\Redis <../api/Phalcon_Cache_Backend_Redis>`       | Menyimpan data di Redis                       | Redis_     | `redis extension`_       |
+----------------------------------------------------------------------------------+-----------------------------------------------+------------+--------------------------+

Mengimplementasi adapter Backend anda sendiri
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Interface :doc:`Phalcon\\Cache\\BackendInterface <../api/Phalcon_Cache_BackendInterface>` harus diimplementasi untuk menciptakan adapter backend anda sendiri atau mengembangkan yang sudah ada.

Opsi File Backend
^^^^^^^^^^^^^^^^^
Backend ini akan menyimpan konten yang dicache ke file di server lokal. Opsi yang tersedia untuk backend ini:

+----------+-------------------------------------------------------------+
| Option   | Keterangan                                                  |
+==========+=============================================================+
| prefix   | Sebuah prefix yang otomatis ditambahkan didepan cache key   |
+----------+-------------------------------------------------------------+
| cacheDir | Direktori yang writable dimana file cache diletakkan        |
+----------+-------------------------------------------------------------+

Opsi Memcached Backend
^^^^^^^^^^^^^^^^^^^^^^
Backend ini akan menyimpan konten yang dicache di server memcached. Opsi yang tersedia untuk backend ini:

+------------+-------------------------------------------------------------+
| Option     | Description                                                 |
+============+=============================================================+
| prefix     | Sebuah prefix yang otomatis ditambahkan didepan cache key   |
+------------+-------------------------------------------------------------+
| host       | memcached host                                              |
+------------+-------------------------------------------------------------+
| port       | memcached port                                              |
+------------+-------------------------------------------------------------+
| persistent | Membuat koneksi persistent ke memcached?                    |
+------------+-------------------------------------------------------------+

APC Backend Options
^^^^^^^^^^^^^^^^^^^
Backend ini akan menyimpan konten yang dicache di Alternative PHP Cache (APC_). Opsi yang tersedia untuk backend ini:

+------------+-------------------------------------------------------------+
| Option     | Keterangan                                                  |
+============+=============================================================+
| prefix     | Sebuah prefix yang otomatis ditambahkan didepan cache key   |
+------------+-------------------------------------------------------------+

Opsi Mongo Backend
^^^^^^^^^^^^^^^^^^
Backend ini akan menyimpan konten yang dicache di server MongoDB. Opsi yang tersedia untuk backend ini:

+------------+-------------------------------------------------------------+
| Option     | Keterangan                                                  |
+============+=============================================================+
| prefix     | Sebuah prefix yang otomatis ditambahkan didepan cache key   |
+------------+-------------------------------------------------------------+
| server     | MongoDB connection string                                   |
+------------+-------------------------------------------------------------+
| db         | Mongo database name                                         |
+------------+-------------------------------------------------------------+
| collection | Mongo collection dalam database                             |
+------------+-------------------------------------------------------------+

Opsi XCache Backend
^^^^^^^^^^^^^^^^^^^
Backend ini akan menyimpan konten yang dicache di XCache (XCache_). Opsi yang tersedia untuk backend ini:

+------------+-------------------------------------------------------------+
| Option     | Keterangan                                                  |
+============+=============================================================+
| prefix     | Sebuah prefix yang otomatis ditambahkan didepan cache key   |
+------------+-------------------------------------------------------------+

Opsi Redis Backend
^^^^^^^^^^^^^^^^^^
Backend ini akan menyimpan konten yang dicache di server Redis (Redis_). Opsi yang tersedia untuk backend ini:

+------------+---------------------------------------------------------------------+
| Option     | Description                                                         |
+============+=====================================================================+
| prefix     | Sebuah prefix yang otomatis ditambahkan didepan cache key           |
+------------+---------------------------------------------------------------------+
| host       | Redis host                                                          |
+------------+---------------------------------------------------------------------+
| port       | Redis port                                                          |
+------------+---------------------------------------------------------------------+
| auth       | Password untuk autentikasi ke server Redis yang dilindungi password |
+------------+---------------------------------------------------------------------+
| persistent | Menciptakan koneksi persistent ke Redis                             |
+------------+---------------------------------------------------------------------+
| index      | Index database Redis database yang digunakan                        |
+------------+---------------------------------------------------------------------+

Ada lebih banyak adapter tersedia untuk komponen ini di `Phalcon Incubator <https://github.com/phalcon/incubator>`_

.. _Memcached: http://www.php.net/memcache
.. _memcache: http://pecl.php.net/package/memcache
.. _APC: http://php.net/apc
.. _APC extension: http://pecl.php.net/package/APC
.. _MongoDb: http://mongodb.org/
.. _Mongo: http://pecl.php.net/package/mongo
.. _XCache: http://xcache.lighttpd.net/
.. _XCache extension: http://pecl.php.net/package/xcache
.. _Redis: http://redis.io/
.. _redis extension: http://pecl.php.net/package/redis
