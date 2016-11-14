Notes d'installation pour Nginx
===============================
Nginx est un projet libre et open-source qui permet d'avoir un serveur HTTP et un reverse proxy extrêmement performant ainsi qu'un relais IMAP/POP3. Contrairement aux serveurs classiques, Nginx_ n'exploite pas des threads pour traiter les requêtes. A la place il utilise une architecture plus évolutive basée sur des événements (asynchrones). Cette architecture utilise de petites quantités de mémoire mais plus importantes et prévisibles en cas de charge.

Le `PHP-FPM`_ (FastCGI Process Manager) est habituellement utilisé pour permettre à Nginx_ de traiter les fichiers PHP. Actuellement, `PHP-FPM`_ est fourni avec n'importe quelle distribution PHP Unix. La combinaison Phalcon + Nginx_ + `PHP-FPM`_ fourni un puissant ensemble d'outils qui offre un maximum de performance pour vos applications PHP.

Configurer Nginx pour Phalcon
-----------------------------
Ce qui suit sont de possibles configurations que vous pouvez utiliser pour configurer Nginx avec Phalcon:

Configuration de base
^^^^^^^^^^^^^^^^^^^^^
En utilisant :code:`$_GET['_url']` comme source des URIs:

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

En utilisant :code:`$_SERVER['REQUEST_URI']` comme source des URIs:

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
