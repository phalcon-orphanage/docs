PHP ビルトインサーバーの利用
============================

PHP5.4.0 以降では、PHP の組み込みの Web サーバーを開発用に使うことができます。

サーバーを起動するには、以下のコマンドを打ち込んでください：

.. code-block:: bash

    php -S localhost:8000 -t /public

index.php に渡される URI を書き換えたいなら、以下のルーターファイル(.htrouter.php)を使用してください。

.. code-block:: php

    <?php
    if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
        $_GET['_url'] = $_SERVER['REQUEST_URI'];
    }
    return false;

次に、以下のコマンドでサーバーを起動します：

.. code-block:: bash

    php -S localhost:8000 -t /public .htrouter.php

ブラウザで http://localhost:8000/ にアクセスし、正常に動作していることを確認してください。

.. _built-in: http://php.net/manual/ja/features.commandline.webserver.php
