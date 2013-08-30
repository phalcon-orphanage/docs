Установка на встроенный в PHP веб-сервер
========================================

В PHP версии 5.4.0 был добавлен встроенный веб-сервер, который можно использовать для разработки.

Для запуска сервера выполните команду:

.. code-block:: bash

    php -S localhost:8000 -t /web_root

Если вы хотите перенаправлять запросы на файл index.php, добавьте файл .htrouter.php со следующим кодом:

.. code-block:: php

    <?php
    if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
        $_GET['_url'] = $_SERVER['REQUEST_URI'];
    }
    return false;

и запустите сервер следующей командой:

.. code-block:: bash

    php -S localhost:8000 -t /web_root .htrouter.php

Откройте свой браузер и перейдите по адресу http://localhost:8000/ , чтобы убедиться, что всё работает.

.. _built-in: http://php.net/manual/en/features.commandline.webserver.php
