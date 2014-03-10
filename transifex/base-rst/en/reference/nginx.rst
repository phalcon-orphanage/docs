%{nginx_6bb6d356501587cdcc495f1a8fa2073f}%
========================
%{nginx_703537526a0c2eb0802d1c8091f2648b|Nginx_|Nginx_}%

%{nginx_3a6a1339cfce179e86b462fdf346efd0|Nginx_|Nginx_|`PHP-FPM`_}%

%{nginx_78202a14fc06eb13905c98df74daefea}%
-----------------------------
%{nginx_7f7917062f284058784dc2cb1844fe2f}%

%{nginx_839322a0f1a181663d7634673806c4a0}%
^^^^^^^^^^^^^^^^^^^
%{nginx_ca4e50852f253e0259dec38dbbeb7cf9}%

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


%{nginx_a93f8ef6b3921aa42339f436605c377d|REQUEST_}%

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


%{nginx_b166a645493a42ae90176ee6541a9025}%
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


%{nginx_680e3dd6ca9727cba90ee64c7d7840ba}%
^^^^^^^^^^^^^^^^^^^^^
%{nginx_79faffba7d0ce9018b84c3ba2cfec9ca}%

