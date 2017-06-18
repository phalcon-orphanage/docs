Usando o Servidor Embutido do PHP
=================================

Desde o PHP 5.4.0 você pode usar o servidor embutido (built-in_) do PHP para o desenvolvimento.

Para iniciar o servidor digite o seguinte comando:

.. code-block:: bash

    php -S localhost:8000 -t /public

Se você quer reescrever as URIs para o index.php, utilize o seguinte arquivo de rotas (.htrouter.php):

.. code-block:: php

    <?php
    if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
        $_GET['_url'] = $_SERVER['REQUEST_URI'];
    }
    return false;

E inicie o servidor com o seguinte o comando:

.. code-block:: bash

    php -S localhost:8000 -t /public .htrouter.php

Em seguida navegue com o seu browser para o endereço http://localhost:8000/ e verifique se tudo esta funcionando.

.. _built-in: http://php.net/manual/pt_BR/features.commandline.webserver.php
