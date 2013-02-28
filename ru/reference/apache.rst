Установка на Apache
=========================
Apache_ самый популярный веб-сервер, доступный на большинстве современных платформ.

Конфигурация Apache для Phalcon
------------------------------
Слудающие инструкции позволят установить Phalcon На Apache. В основном они сводятся к настройке поведения модуля
mod-rewrite при использования человеко-понятных URL (ЧПУ) и :doc:`роутера компонентов <routing>`.
Типичное приложение имеет следующую структуру:

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

Корневой каталог документов
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Самый распостранённый случай - когда приложение в любой подкаталог корневой дирректории. А таких случаях мы используем два .htaccess
файла. Первый будет скрывать код приложения и перенаправлять запросы к корню приложения (public/).

.. code-block:: apacheconf

    # test/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  (.*) public/$1 [L]
    </IfModule>

Второй .htaccess будет распологаться уже в каталоге public/, и будет перенаправлять все запросы на файл public/index.php:

.. code-block:: apacheconf

    # test/public/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

Если нет желания или возможности использовать файлы .htaccess, то параметры так же можно прописать в главной файле конфигурации Apache:

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>

        <Directory "/var/www/test">
            RewriteEngine on
            RewriteRule  ^$ public/    [L]
            RewriteRule  (.*) public/$1 [L]
        </Directory>

        <Directory "/var/www/test/public">
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
        </Directory>

    </IfModule>

Виртуальные хосты
^^^^^^^^^^^^^
Параметры можно так же прописать в настройках конкртеного виртуального хоста:

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
