Using PHP Built-in webserver
============================

As of PHP 5.4.0, you can use PHP's on built-in_ web server for development.

To start the server type:

.. code-block:: bash

    php -S localhost:8000 -t /public

If you want to rewrite the URIs to the index.php file use the following router file (.htrouter.php):

.. code-block:: php

    <?php
    if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
        $_GET['_url'] = $_SERVER['REQUEST_URI'];
    }
    return false;

and then start the server from the base project directory with:

.. code-block:: bash

    php -S localhost:8000 -t /public .htrouter.php

Then point your browser to http://localhost:8000/ to check if everything is working.

.. _built-in: http://php.net/manual/es/features.commandline.webserver.php
