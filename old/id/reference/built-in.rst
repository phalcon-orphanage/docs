Menggunakan Web Server bawaan PHP
=================================

Mulai PHP 5.4.0, anda dapt menggunakan web server_ bawaan PHP untuk pengembangan.

Untuk memulai server ketik:

.. code-block:: bash

    php -S localhost:8000 -t /public

Jika anda ingin menulis ulang URI ke file index.php gunakan file router berikut (.htrouter.php):

.. code-block:: php

    <?php
    if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
        $_GET['_url'] = $_SERVER['REQUEST_URI'];
    }
    return false;

dan jalankan server dari direktori proyek:

.. code-block:: bash

    php -S localhost:8000 -t /public .htrouter.php

Lau arahkan browser anda ke http://localhost:8000/ untuk menguji apakah semuanya bekerja.

.. _server: http://php.net/manual/en/features.commandline.webserver.php
