Notas para la instalación en Nginx
==================================

Nginx_ es un servidor HTTP libre de código abierto con muy alto rendimiento, puede actuar ademas como servidor proxy inversy y como proxy para IMAP/POP3. A diferencia de los servidores tradicionales, Nginx_ no se basa en hilos para manejar las peticiones. En su lugar usa una arquitectura más escalable event-driven (asíncrona). Esta arquitectura usa pequeños espacios de memoria, pero aún más importante puede predecir el tamaño de la memoria a ser cargada.

El `PHP-FPM`_ (FastCGI Process Manager) es generalmente usado para permitir a Nginx_ procesar ficheros PHP. Actualmente, `PHP-FPM`_ se encuentra en paquetes de cualquier distribución Unix PHP. Phalcon + Nginx_ + `PHP-FPM`_ provee un poderoso conjunto que ofrece el máximo rendimiento para tus applications PHP.

Configurando Nginx para Phalcon
-------------------------------
Lo siguiente son definiciones de configuraciones que puedes usar para configurar tu aplicación:

Configuración básica
^^^^^^^^^^^^^^^^^^^^
Using :code:`$_GET['_url']` as source of URIs:

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

Using :code:`$_SERVER['REQUEST_URI']` as source of URIs:

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
