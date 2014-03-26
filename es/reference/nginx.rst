Notas para la instalación en Nginx
========================
Nginx_ es un servidor HTTP libre de código abierto con muy alto rendimiento, puede actuar ademas como servidor proxy inversy y como proxy para MAP/POP3. A diferencia
de los servidores tradicionales, Nginx_ no se basa en hilos para manejar las peticiones. En su lugar usa una arquitectura más escalable event-driven(asíncrona).
Esta arquitectura usa pequeños espacios de memoria, pero aún más importante puede predecir el tamaño de la memoria a ser cargada.

El `PHP-FPM`_ (FastCGI Process Manager) es generalmente usado para permitir a Nginx_ procesar ficheros PHP. Actualmente, `PHP-FPM`_ se encuentra en
paquetes de cualquier distribución Unix PHP. Phalcon + Nginx_ + `PHP-FPM`_ provee un poderoso conjunto que ofrece el máximo rendimiento para tus applications PHP.

Configurando Nginx para Phalcon
-----------------------------
Lo siguiente son definiciones de configuraciones que puedes usar para configurar tu aplicación. 

Configuración básica
^^^^^^^^^^^^^^^^^^^

.. code-block:: nginx

    server {
        listen   8080;
        server_name localhost.dev;

        root /var/www/phalcon/public;
        index index.php index.html index.htm;

        location / {
            if (-f $request_filename) {
                break;
            }

            if (!-e $request_filename) {
                rewrite ^(.+)$ /index.php?_url=$1 last;
                break;
            }
        }

        location ~ \.php$ {
                try_files $uri =404;
                fastcgi_split_path_info ^(.+\.php)(/.+)$;
                fastcgi_pass 127.0.0.1:9000;
                fastcgi_index index.php;
                fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
                include fastcgi_params;
        }
    }

Instancias dedicadas
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
            root $root_path;
        }
    }

Configuración por Host
^^^^^^^^^^^^^^^^^^^^^
Esta configuración te permite tener varias configuraciones por Host:

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
            rewrite ^/(.*)$ /index.php?_url=$1;
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
