Nginx 安装说明（Nginx Installation Notes）
==========================================

Nginx_ is a free, open-source, high-performance HTTP server and reverse proxy, as well as an IMAP/POP3 proxy server. Unlike traditional servers, Nginx_ doesn't rely on threads to handle requests. Instead it uses a much more scalable event-driven (asynchronous) architecture. This architecture uses small, but more importantly, predictable amounts of memory under load.

The `PHP-FPM`_ (FastCGI Process Manager) is usually used to allow Nginx_ to process PHP files. Nowadays, `PHP-FPM`_ is bundled with any Unix PHP distribution. Phalcon + Nginx_ + `PHP-FPM`_ provides a powerful set of tools that offer maximum performance for your PHP applications.

Niginx 下配置 Phalcon（Configuring Nginx for Phalcon）
------------------------------------------------------
The following are potential configurations you can use to setup nginx with Phalcon:

基础配置（Basic configuration）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Using :code:`$_GET['_url']` as source of URIs:

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

Using :code:`$_SERVER['REQUEST_URI']` as source of URIs:

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

专属实例（Dedicated Instance）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
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

使用 Host 配置（Configuration by Host）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
And this second configuration allow you to have different configurations by host:

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
