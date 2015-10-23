Nginx インストール ノート
=========================

Nginx_ は無料でオープンソースな高性能HTTPサーバで、リバースプロキシとしてだけでなく、IMAP/POP3のプロキシサーバとしても動きます。
伝統的なサーバとは異なり、Nginx_ は要求を処理するスレッドに依存しません。
その代わりに、はるかに拡張性の高いイベント駆動型（非同期）アーキテクチャを使用しています。
このアーキテクチャは、使用メモリが少ないのですが、より重要なのは、負荷の下でもメモリ消費量が予測可能だということです。

`PHP-FRM`_ (FastCGI Process Manager) は Nginx_ がPHPファイルを処理できるようにするために、通常使われます。
最近、`PHP-FPM`_ はいくつかのUNIXのPHPのディストリビューションにバンドルされています。Phalcon + Nginx_ + `PHP-FPM`_ は、PHPアプリケーションのための最大のパフォーマンスを提供する協力なツールセットになります。

PhalconのためのNginxの設定
-----------------------------
以下は、Phalconをnginxで使用できるようにする設定です。

基本的な設定
^^^^^^^^^^^^^^^^^^^
$_GET['_url'] をURIsとする場合:

.. code-block:: nginx

    server {
        listen 80;

        server_name localhost.dev;

        index index.php index.html index.htm;

        root /var/www/phalcon/public;

        try_files $uri $uri/ @rewrite;

        location @rewrite {
            rewrite ^(.*)$ /index.php?_url=$1;
        }

        location ~ \.php {
            fastcgi_pass unix:/run/php-fpm/php-fpm.sock;
            fastcgi_index /index.php;

            include /etc/nginx/fastcgi_params;

            fastcgi_split_path_info       ^(.+\.php)(/.+)$;
            fastcgi_param PATH_INFO       $fastcgi_path_info;
            fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }

        location ~* ^/(css|img|js|flv|swf|download)/(.+)$ {
            root /var/www/phalcon/public;
        }

        location ~ /\.ht {
            deny all;
        }
    }

$_SERVER['REQUEST_URI'] をURIsとする場合:

.. code-block:: nginx

    server {
        listen 80;

        server_name localhost.dev;

        index index.php index.html index.htm;

        root /var/www/phalcon/public;

        location / {
            try_files $uri $uri/ /index.php;
        }

        location ~ \.php$ {
                try_files $uri =404;
                fastcgi_split_path_info ^(.+\.php)(/.+)$;
                fastcgi_pass 127.0.0.1:9000;
                fastcgi_index index.php;
                fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
                include fastcgi_params;
        }

        location ~* ^/(css|img|js|flv|swf|download)/(.+)$ {
            root /var/www/phalcon/public;
        }

        location ~ /\.ht {
            deny all;
        }
    }

専用インスタンス
^^^^^^^^^^^^^^^^^^
.. code-block:: nginx

    server {
        listen       80;
        server_name  localhost;

        charset      utf-8;

        #access_log  /var/log/nginx/host.access.log  main;

        location / {
            root   /srv/www/htdocs/phalcon-website/public;
            index  index.php index.html index.htm;

            # if file exists return it right away
            if (-f $request_filename) {
                break;
            }

            # otherwise rewrite it
            if (!-e $request_filename) {
                rewrite ^(.+)$ /index.php?_url=$1 last;
                break;
            }
        }

        location ~ \.php {
            # try_files    $uri =404;

            fastcgi_index  /index.php;
            fastcgi_pass   127.0.0.1:9000;

            include fastcgi_params;
            fastcgi_split_path_info       ^(.+\.php)(/.+)$;
            fastcgi_param PATH_INFO       $fastcgi_path_info;
            fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }

        location ~* ^/(css|img|js|flv|swf|download)/(.+)$ {
            root /srv/www/htdocs/phalcon-website/public;
        }
    }

ホスト毎の設定
^^^^^^^^^^^^^^^^^^^^^
ホスト毎に違う設定を持つことができて2番目に設定する場合

.. code-block:: nginx

    server {
        listen      80;

        server_name localhost;

        root        /var/www/$host/public;

        access_log  /var/log/nginx/$host-access.log;
        error_log   /var/log/nginx/$host-error.log error;

        index index.php index.html index.htm;

        try_files $uri $uri/ @rewrite;

        location @rewrite {
            rewrite ^(.*)$ /index.php?_url=$1;
        }

        location ~ \.php {
            # try_files    $uri =404;

            fastcgi_index  /index.php;
            fastcgi_pass   127.0.0.1:9000;

            include fastcgi_params;
            fastcgi_split_path_info       ^(.+\.php)(/.+)$;
            fastcgi_param PATH_INFO       $fastcgi_path_info;
            fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }

        location ~* ^/(css|img|js|flv|swf|download)/(.+)$ {
            root /var/www/$host/public;
        }

        location ~ /\.ht {
            deny all;
        }
    }

.. _Nginx: http://wiki.nginx.org/Main
.. _PHP-FPM: http://php-fpm.org/
