Catatan Instalasi Apache
========================

Apache_ adalah web server popular dan terkenal yang tersedia di beragam platform.

Konfigurasi Apache untuk Phalcon
--------------------------------
Berikut ini adalah konfigurasi yang bisa anda gunakan untuk setup Apache dengan Phalcon. Catatan ini utamanya fokus pada konfigurasi modul mod_rewrite yang memungkinkan penggunaan URL yang ramah dan
:doc:`router component <routing>`. Aplikasi biasanya menggunakan struktur berikut:

.. code-block:: php

    test/
      app/
        controllers/
        models/
        views/
      public/
        css/
        img/
        js/
        index.php

Directory dalam Document Root utama
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Ini adalah kasus paling umum, aplikasi diinstall pada sembarang direktori dalam document root.
Pada kasus ini, kita menggunakan dua file .htaccess, yang pertama untuk menyembunyikan kode aplikasi dengan mengarahkan semua request ke document root aplikasi (public/).

.. code-block:: apacheconf

    # test/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  ((?s).*) public/$1 [L]
    </IfModule>

File .htaccess kedua diletakkan di direktori public/ , file ini menulis ulang semua URI ke file public/index.php:

.. code-block:: apacheconf

    # test/public/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

Jika anda tidak ingin menggunakan file .htaccess anda dapat memindahkan konfigurasi ini ke file konfigurasi utama Apache:

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>

        <Directory "/var/www/test">
            RewriteEngine on
            RewriteRule  ^$ public/    [L]
            RewriteRule  ((?s).*) public/$1 [L]
        </Directory>

        <Directory "/var/www/test/public">
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
        </Directory>

    </IfModule>

Virtual Host
^^^^^^^^^^^^
Konfigurasi kedua memungkinkan anda menginstall aplikasi Phalcon dalam sebuah virtual host:

.. code-block:: apacheconf

    <VirtualHost *:80>

        ServerAdmin admin@example.host
        DocumentRoot "/var/vhosts/test/public"
        DirectoryIndex index.php
        ServerName example.host
        ServerAlias www.example.host

        <Directory "/var/vhosts/test/public">
            Options All
            AllowOverride All
            Allow from all
        </Directory>

    </VirtualHost>

.. _Apache: http://httpd.apache.org/

Atau jika Anda menggunakan Apache 2.4 atau diatasnya:

.. code-block:: apacheconf

    <VirtualHost *:80>

        ServerAdmin admin@example.host
        DocumentRoot "/var/vhosts/test/public"
        DirectoryIndex index.php
        ServerName example.host
        ServerAlias www.example.host

        <Directory "/var/vhosts/test/public">
            Options All
            AllowOverride All
            Require all granted
        </Directory>

    </VirtualHost>

.. _Apache: http://httpd.apache.org/
