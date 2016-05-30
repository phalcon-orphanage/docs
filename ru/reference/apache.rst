Установка на Apache
===================

Apache_ - популярный веб-сервер, доступный на большинстве современных платформ.

Конфигурация Apache для Phalcon
-------------------------------
Следующие инструкции позволят настроить Phalcon на Apache. В основном они сводятся к настройке поведения модуля mod_rewrite, позволяющего использовать человеко-понятные URL (ЧПУ) и
:doc:`роутера компонентов <routing>`. Типичное приложение имеет следующую структуру:

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
^^^^^^^^^^^^^^^^^^^^^^^^^^^
Самый распространённый случай - когда приложение устанавливается в любой подкаталог корневой директории.
В таких случаях мы используем два .htaccess файла. Первый будет скрывать код приложения и перенаправлять запросы
к корню приложения (public/).

.. code-block:: apacheconf

    # test/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  ((?s).*) public/$1 [L]
    </IfModule>

Второй .htaccess будет располагаться уже в каталоге public/, и будет перенаправлять все запросы на файл public/index.php:

.. code-block:: apacheconf

    # test/public/.htaccess

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

Если нет желания или возможности использовать файлы .htaccess, то параметры также можно прописать в главном файле конфигурации Apache:

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

Виртуальные хосты
^^^^^^^^^^^^^^^^^
Параметры можно также прописать в настройках конкретного виртуального хоста:

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

>= Apache 2.4:

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
