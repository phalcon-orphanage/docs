使用 PHP 内置 web 服务器（Using PHP Built-in webserver）
========================================================

对于PHP 5.4.0或以上版本, 你可以为项目开发使用PHP内置的web服务器。

为了启动web服务器，需要：

.. code-block:: bash

    php -S localhost:8000 -t /public

如果你想重写URI并指向index.php文件，可以使用以下路由文件（.htrouter.php）：

.. code-block:: php

    <?php
    if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
        $_GET['_url'] = explode('?',$_SERVER['REQUEST_URI'])[0];
    }
    return false;

然后这样启动服务器：

.. code-block:: bash

    php -S localhost:8000 -t /public .htrouter.php

最然打开浏览器输入并跳转到 http://localhost:8000/，检测是否可以正常访问。

.. _built-in: http://php.net/manual/zh/features.commandline.webserver.php
