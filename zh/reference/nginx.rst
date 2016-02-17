Nginx 安装说明（Nginx Installation Notes）
==========================================

Nginx_ 是一个免费的，开源的高性能的HTTP服务器和反向代理服务器，同样也可作为IMAP/POP3代理服务器。不同于传统的服务器，Nginx_ 不依赖线程去处理请求。相反，它使用一个高扩展的事件驱动（异步）架构。 This architecture uses small, but more importantly, predictable amounts of memory under load.

`PHP-FPM`_ (FastCGI 进程管理器)通常用来允许 Nginx_ 来处理PHP文件。到了如今，`PHP-FPM`_ 已经捆绑在所有的PHP发行版中。Phalcon + Nginx_ + `PHP-FPM`_ 提供了一套强大的工具集，为你的PHP应用提供最强大性能。

Niginx 下配置 Phalcon（Configuring Nginx for Phalcon）
------------------------------------------------------
下面是nginx可以合Phalcon配合使用的大概配置：

基础配置（Basic configuration）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Using :code:`$_GET['_url']` as source of URIs:

.. code-block:: nginx

    server {
        listen      80;
        server_name localhost.dev;
        root        /var/www/phalcon/public;
        index       index.php index.html index.htm;

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

Using :code:`$_SERVER['REQUEST_URI']` as source of URIs:

.. code-block:: nginx

    server {
        listen      80;
        server_name localhost.dev;
        root        /var/www/phalcon/public;
        index       index.php index.html index.htm;

        location / {
            try_files $uri $uri/ /index.php;
        }

        location ~ \.php$ {
            try_files     $uri =404;

            fastcgi_pass  127.0.0.1:9000;
            fastcgi_index /index.php;

            include fastcgi_params;
            fastcgi_split_path_info       ^(.+\.php)(/.+)$;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }

        location ~ /\.ht {
            deny all;
        }
    }

专属实例（Dedicated Instance）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
.. code-block:: nginx

    server {
        listen      80;
        server_name localhost;
        root        /srv/www/htdocs/phalcon-website/public;
        index       index.php index.html index.htm;
        charset     utf-8;

        #access_log /var/log/nginx/host.access.log main;

        location / {
            try_files $uri $uri/ /index.php?_url=$uri&$args;
        }

        location ~ \.php {
            # try_files   $uri =404;

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

使用 Host 配置（Configuration by Host）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
第二个配置允许在主机中拥有不同的配置：

.. code-block:: nginx

    server {
        listen      80;
        server_name localhost;
        root        /var/www/$host/public;
        index       index.php index.html index.htm;

        access_log  /var/log/nginx/$host-access.log;
        error_log   /var/log/nginx/$host-error.log error;

        location / {
            try_files $uri $uri/ /index.php?_url=$uri&$args;
        }

        location ~ \.php {
            # try_files   $uri =404;

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
