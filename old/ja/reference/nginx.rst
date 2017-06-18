Nginx インストール ノート
=========================

Nginx_ は無料でオープンソースな高性能HTTPサーバで、リバースプロキシとしてだけでなく、IMAP/POP3のプロキシサーバとしても動きます。
伝統的なサーバとは異なり、Nginx_ は要求を処理するスレッドに依存しません。
その代わりに、はるかに拡張性の高いイベント駆動型（非同期）アーキテクチャを使用しています。
このアーキテクチャは、使用メモリが少ないのですが、より重要なのは、負荷の下でもメモリ消費量が予測可能だということです。

`PHP-FPM`_ (FastCGI Process Manager) は Nginx_ がPHPファイルを処理できるようにするために、通常使われます。
最近、`PHP-FPM`_ はいくつかのUNIXのPHPのディストリビューションにバンドルされています。Phalcon + Nginx_ + `PHP-FPM`_ は、PHPアプリケーションのための最大のパフォーマンスを提供する協力なツールセットになります。

PhalconのためのNginxの設定
-----------------------------
以下は、Phalconをnginxで使用できるようにする設定です。

基本的な設定
^^^^^^^^^^^^^^^^^^^
:code:`$_GET['_url']` をURIsとする場合:

.. code-block:: nginx

    server {
        listen      80;
        server_name localhost.dev;
        root        /var/www/phalcon/public;
        index       index.php index.html index.htm;
        charset     utf-8;

        location / {
            try_files $uri $uri/ /index.php?_url=$uri&$args;
        }

        location ~ \.php {
            fastcgi_pass  unix:/run/php-fpm/php-fpm.sock;
            fastcgi_index /index.php;

            include fastcgi_params;
            fastcgi_split_path_info       ^(.+\.php)(/.+)$;
            fastcgi_param PATH_INFO       $fastcgi_path_info;
            fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }

        location ~ /\.ht {
            deny all;
        }
    }

:code:`$_SERVER['REQUEST_URI']` をURIsとする場合:

.. code-block:: nginx

    server {
        listen      80;
        server_name localhost.dev;
        root        /var/www/phalcon/public;
        index       index.php index.html index.htm;
        charset     utf-8;

        location / {
            try_files $uri $uri/ /index.php;
        }

        location ~ \.php$ {
            try_files     $uri =404;

            fastcgi_pass  127.0.0.1:9000;
            fastcgi_index /index.php;

            include fastcgi_params;
            fastcgi_split_path_info       ^(.+\.php)(/.+)$;
            fastcgi_param PATH_INFO       $fastcgi_path_info;
            fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }

        location ~ /\.ht {
            deny all;
        }
    }

.. _Nginx: http://wiki.nginx.org/Main
.. _PHP-FPM: http://php-fpm.org/
