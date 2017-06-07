Notas de Instalação do Nginx
============================

Nginx_ é um servidor http e proxy reverso de alto desempenho, livre, de código aberto, e bem conhecido como um servidor proxy de IMAP/POP3. Diferente dos servidores tradicionais, Nginx_ não depende de threads para processar as requisições. Ao invés, utiliza uma arquitetura orientada a eventos(assíncrono) muito mais escalonável. Esta arquitetura utiliza pequenas quantidades de memória, e muito mais importante do que isso, utiliza porções de memória configuradas sob demanda.

O `PHP-FPM`_ (FastCGI Process Manager) é normalmente utilizado para permitir o Nginx_ processar arquivos PHP. Hoje em dia, `PHP-FPM`_ vem com qualquer distribuição UNIX PHP. Phalcon + Nginx_ + `PHP-FPM`_  provê um poderoso conjunto de ferramentas que oferece o máximo de desempenho para sua aplicação PHP.

Configurando Nginx para o Phalcon
---------------------------------
A seguir existem possíveis configurações que você pode utilizar para configurar o Phalcon com o nginx:

Configuração Básica
^^^^^^^^^^^^^^^^^^^
Utilizando :code:`$_GET['_url']` como fonte das URIs:

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

Utilizando :code:`$_SERVER['REQUEST_URI']` como fonte das URIs:

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
