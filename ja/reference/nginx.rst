Nginx インストール ノート
========================
Nginx_ is a free, open-source, high-performance HTTP server and reverse proxy, as well as an IMAP/POP3 proxy server. Unlike
traditional servers, Nginx_ doesn't rely on threads to handle requests. Instead it uses a much more scalable event-driven
(asynchronous) architecture. This architecture uses small, but more importantly, predictable amounts of memory under load.

The `PHP-FPM`_ (FastCGI Process Manager) is usually used to allow Nginx_ to process PHP files. Nowadays, `PHP-FPM`_ is
bundled with any Unix PHP distribution. Phalcon + Nginx_ + `PHP-FPM`_ provides a powerful set of tools that offer
maximum performance for your PHP applications.

Configuring Nginx for Phalcon
-----------------------------
The following are potential configurations you can use to setup nginx with Phalcon:

Basic configuration
^^^^^^^^^^^^^^^^^^^
Using $_GET['_url'] as source of URIs:

.. code-block:: nginx

    server {

        listen   80;
        server_name localhost.dev;

        index index.php index.html index.htm;
        set $root_path '/var/www/phalcon/public';
        root $root_path;

        try_files $uri $uri/ @rewrite;

        location @rewrite {
            rewrite ^/(.*)$ /index.php?_url=/$1;
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
            root $root_path;
        }

        location ~ /\.ht {
            deny all;
        }
    }

Using $_SERVER['REQUEST_URI'] as source of URIs:

.. code-block:: nginx

    server {

        listen   80;
        server_name localhost.dev;

        index index.php index.html index.htm;
        set $root_path '/var/www/phalcon/public';
        root $root_path;

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
            root $root_path;
        }

        location ~ /\.ht {
            deny all;
        }
    }

Dedicated Instance
^^^^^^^^^^^^^^^^^^
.. code-block:: nginx

    server {
        listen       80;
        server_name  localhost;

        charset      utf-8;

        #access_log  /var/log/nginx/host.access.log  main;

        set $root_path '/srv/www/htdocs/phalcon-website/public';

        location / {
            root   $root_path;
            index  index.php index.html index.htm;

            # if file exists return it right away
            if (-f $request_filename) {
                break;
            }

            # otherwise rewrite it
            if (!-e $request_filename) {
                rewrite ^(.+)$ /index.php?_url=/$1 last;
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
            root $root_path;
        }
    }

Configuration by Host
^^^^^^^^^^^^^^^^^^^^^
And this second configuration allow you to have different configurations by host:

.. code-block:: nginx

    server {
        listen      80;
        server_name localhost;
        set         $root_path '/var/www/$host/public';
        root        $root_path;

        access_log  /var/log/nginx/$host-access.log;
        error_log   /var/log/nginx/$host-error.log error;

        index index.php index.html index.htm;

        try_files $uri $uri/ @rewrite;

        location @rewrite {
            rewrite ^/(.*)$ /index.php?_url=/$1;
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
            root $root_path;
        }

        location ~ /\.ht {
            deny all;
        }
    }

.. _Nginx: http://wiki.nginx.org/Main
.. _PHP-FPM: http://php-fpm.org/
