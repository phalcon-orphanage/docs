Notas de Instalação do Nginx
========================
Nginx_ é um servidor http e proxy reverso de alto desempenho,livre, de código aberto, e bem conhecido como um servidor proxy de IMAP/POP3. Diferente dos servidores tradicionais, Nginx_ não depende de threads para processar as requisições. Ao invés, utiliza uma arquitetura orientada a eventos(assíncrono) muito mais escalonável. Esta arquitetura utiliza pequenas quantidade de memória, e muito mais importante do que isso, utiliza porções de memória configuradas sob demanda.

O `PHP-FPM`_ (FastCGI Process Manager) é normalmente utilizado para permitir o Nginx_ processar arquivos PHP. Hoje em dia, `PHP-FPM`_ vem com qualquer distribuição UNIX PHP. Phalcon + Nginx_ + `PHP-FPM`_  prove um poderoso conjunto de ferramentas que oferece o máximo desempenho para sua aplicação PHP.

Configurando Nginx para o Phalcon
-----------------------------
A seguir existem possíveis configurações que você pode utilizar para configurar o Phalcon com o nginx:

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

Utilizando $_SERVER['REQUEST_URI'] como fonte das URIs:

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

Instância Dedicada
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

Configuração por Host 
^^^^^^^^^^^^^^^^^^^^^
Esta segunda configuração permite você ter diferentes configurações por host:

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
