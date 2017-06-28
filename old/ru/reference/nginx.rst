Установка на Nginx
==================

Nginx_ - это свободный, с открытым исходным кодом, высокопроизводительный HTTP-сервер и прокси-сервер, а также IMAP/POP3 прокси-сервер. В отличие от традиционных серверов Nginx_ не использует потоки для обработки запросов. Вместо этого он использует гораздо более масштабируемую, управляемую событиями (асинхронную) архитектуру. Эта архитектура под высокой нагрузкой использует небольшой, и главное, предсказуемый объем памяти.

`PHP-FPM`_ (менеджер процессов FastCGI) обычно используется для обработки PHP-файлов в Nginx_. В настоящее время `PHP-FPM`_ идёт в комплекте с любым дистрибутивом PHP в Unix. Связка Phalcon + Nginx_ + `PHP-FPM`_ предоставляет мощный набор инструментов, который позволяет добиться максимальной производительности ваших PHP приложений.

Конфигурация Nginx для Phalcon
------------------------------
Конфигурации ниже позволят настроить Nginx для работы с Phalcon:

Базовая конфигурация
^^^^^^^^^^^^^^^^^^^^
Использование переменной :code:`$_GET['_url']` для URI:

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

Использование :code:`$_SERVER['REQUEST_URI']` для URI:

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
