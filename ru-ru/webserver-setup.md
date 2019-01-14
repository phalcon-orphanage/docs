* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='setup'></a>

# Настройка веб-сервера

Чтобы работала маршрутизация (анг. routing) в Phalcon, вам понадобится настроить должным образом веб-сервер, научив его правильно обрабатывать перенаправления. Ниже рассматриваются типичные конфигурации для популярных веб-серверов:

<a name='php-fpm'></a>

## PHP-FPM

The [PHP-FPM](https://php.net/manual/en/install.fpm.php) (FastCGI Process Manager) is usually used to allow the processing of PHP files. В настоящее время PHP-FPM идёт в комплекте с любым дистрибутивом PHP в Unix.

На **Windows** PHP-FPM поставляется вместе с пакетом PHP, как файл `php-cgi.exe`. Вы можете запустить его с этом скриптом. Windows не поддерживает Unix сокеты, скрипт запускает fast-cgi в TCP режиме на порте `9000`.

Создайте файл `php-fcgi.bar` с данным текстом:

```bat
@ECHO OFF
ECHO Starting PHP FastCGI...
set PATH=C:\PHP;%PATH%
C:\bin\RunHiddenConsole.exe C:\PHP\php-cgi.exe -b 127.0.0.1:9000
```

<a name='php-built-in'></a>

## Встроенный в PHP веб-сервер (для разработки)

Чтобы ускорить разработку вашего Phalcon-приложения, самым простым способом его запуска является использование встроенного в PHP веб-сервера. Мы рекомендуем использовать встроенный в PHP веб-сервер исключительно на стадии разработки. Ниже рассмотрены типичные конфигурации для [Nginx](#nginx) и [Apache](#apache), которые вам вероятнее всего подойдут.

<a name='php-built-in-phalcon-configuration'></a>

### Настройка под Phalcon

Для включения ЧПУ без Apache или Nginx (которые необходимы для Phalcon), вы можете использовать файл-роутер:
<a href="https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php" target="_blank">.htrouter.php</a>

If you created your application with [Phalcon-Devtools](/4.0/en/devtools-installation) this file should already exist in the root directory of your project and you can start the server with the following command:

```bash
$(which php) -S localhost:8000 -t public .htrouter.php
```

Работа команды выше: - `$(which php)` — выводит абсолютный путь до интерпретатора PHP на вашей машине - `-S localhost:8000` — "говорит" серверу слушать `host:port` - `-t public` — указывает директорию ресурсов - `.htrouter.php` — отправляет все запросы на роутер (выступает в роли файла .htaccess)

Then point your browser to https://localhost:8000/ to check if everything is working.

<a name='nginx'></a>

## Nginx

[Nginx](https://wiki.nginx.org/Main) is a free, open-source, high-performance HTTP server and reverse proxy, as well as an IMAP/POP3 proxy server. В отличие от традиционных серверов Nginx не использует потоки для обработки запросов. Вместо этого он использует гораздо более масштабируемую, управляемую событиями (асинхронную) архитектуру. Эта архитектура под высокой нагрузкой использует небольшой, и главное, предсказуемый объем памяти.

Связка Phalcon + Nginx + PHP-FPM предоставляет мощный набор инструментов, который позволяет добиться максимальной производительности ваших PHP приложений.

### Установка Nginx

<a href="https://www.nginx.com/resources/wiki/start/topics/tutorials/install/" target="_blank">Официальный сайт Nginx</a>

<a name='nginx-phalcon-configuration'></a>

### Настройка под Phalcon

Вы можете использовать следующую конфигурацию Nginx для работы с Phalcon, вероятнее всего на вам подойдёт:

```nginx
server {
    # Port 80 will require Nginx to be started with root permissions
    # Depending on how you install Nginx to use port 80 you will need
    # to start the server with `sudo` ports about 1000 do not require
    # root privileges
    # listen      80;

    listen        8000;
    server_name   default;

    ##########################
    # In production require SSL
    # listen 443 ssl default_server;

    # ssl on;
    # ssl_session_timeout  5m;
    # ssl_protocols  SSLv2 SSLv3 TLSv1;
    # ssl_ciphers  ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:+SSLv2:+EXP;
    # ssl_prefer_server_ciphers   on;

    # These locations depend on where you store your certs
    # ssl_certificate        /var/nginx/certs/default.cert;
    # ssl_certificate_key    /var/nginx/certs/default.key;
    ##########################

    # This is the folder that index.php is in
    root /var/www/default/public;
    index index.php index.html index.htm;

    charset utf-8;
    client_max_body_size 100M;
    fastcgi_read_timeout 1800;

    # Represents the root of the domain
    # https://localhost:8000/[index.php]
    location / {
        # Matches URLS `$_GET['_url']`
        try_files $uri $uri/ /index.php?_url=$uri&$args;
    }

    # When the HTTP request does not match the above
    # and the file ends in .php
    location ~ [^/]\.php(/|$) {
        # try_files $uri =404;

        # Ubuntu and PHP7.0-fpm in socket mode
        # This path is dependent on the version of PHP install
        fastcgi_pass  unix:/var/run/php/php7.0-fpm.sock;


        # Alternatively you use PHP-FPM in TCP mode (Required on Windows)
        # You will need to configure FPM to listen on a standard port
        # https://www.nginx.com/resources/wiki/start/topics/examples/phpfastcgionwindows/
        # fastcgi_pass  127.0.0.1:9000;

        fastcgi_index /index.php;

        include fastcgi_params;
        fastcgi_split_path_info ^(.+?\.php)(/.*)$;
        if (!-f $document_root$fastcgi_script_name) {
            return 404;
        }

        fastcgi_param PATH_INFO       $fastcgi_path_info;
        # fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
        # and set php.ini cgi.fix_pathinfo=0

        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico)$ {
        expires       max;
        log_not_found off;
        access_log    off;
    }
}
```

### Запуск Nginx

Обычно запуск производится командой `service start nginx`. Но это зависит от метода установки веб-сервера и системного менеджера вашей операционной системы.

<a name='apache'></a>

## Apache

[Apache](https://httpd.apache.org/) is a popular and well known web server available on many platforms.

<a name='apache-phalcon-configuration'></a>

### Настройка под Phalcon

Следующие инструкции позволят настроить Apache для корректной работы с Phalcon. These notes are primarily focused on the configuration of the `mod_rewrite` module allowing to use friendly URLs and the [router component](/4.0/en/routing). Типичное приложение имеет следующую структуру:

```bash
test/
  app/
    controllers/
    models/
    views/
  public/
    css/
    img/
    js/
    index.php
```

<a name='apache-document-root'></a>

#### Корневой каталог

Самый распространённый случай - когда приложение устанавливается в любой подкаталог корневой директории. В таких случаях мы используем два `.htaccess` файла. Первый будет скрывать код приложения и перенаправлять запросы к корню приложения (`public/`).

##### Note that using `.htaccess` files requires your apache installation to have the `AllowOverride All` option set. {.alert.alert-warning}

```apacheconfig
# test/.htaccess

<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteRule   ^$ public/    [L]
    RewriteRule   ((?s).*) public/$1 [L]
</IfModule>
```

Второй `.htaccess` будет располагаться уже в каталоге `public/` и будет перенаправлять все запросы на файл `public/index.php`:

```apacheconfig
# test/public/.htaccess

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
</IfModule>
```

For users that are using the Persian letter 'م' (meem) in uri parameters, there is an issue with `mod_rewrite`. To allow the matching to work as it does with English characters, you will need to change your `.htaccess` file:

```apacheconfig
# test/public/.htaccess

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^([0-9A-Za-z\x7f-\xff]*)$ index.php?params=$1 [L]
</IfModule>
```

If your uri contains characters other than English, you might need to resort to the above change to allow `mod_rewrite` to accurately match your route.

<a name='apache-apache-configuration'></a>

#### Конфигурация Apache

If you do not want to use `.htaccess` files you can move these configurations to the apache's main configuration file:

```apacheconfig
<IfModule mod_rewrite.c>

    <Directory "/var/www/test">
        RewriteEngine on
        RewriteRule  ^$ public/    [L]
        RewriteRule  ((?s).*) public/$1 [L]
    </Directory>

    <Directory "/var/www/test/public">
        RewriteEngine On
        RewriteCond   %{REQUEST_FILENAME} !-d
        RewriteCond   %{REQUEST_FILENAME} !-f
        RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </Directory>

</IfModule>
```

<a name='apache-virtual-hosts'></a>

#### Виртуальные хосты

And this second configuration allows you to install a Phalcon application in a virtual host:

```apacheconfig
<VirtualHost *:80>

    ServerAdmin    admin@example.host
    DocumentRoot   "/var/vhosts/test/public"
    DirectoryIndex index.php
    ServerName     example.host
    ServerAlias    www.example.host

    <Directory "/var/vhosts/test/public">
        Options       All
        AllowOverride All
        Require       all granted
    </Directory>

</VirtualHost>
```

<a name='cherokee'></a>

## Cherokee

[Cherokee](https://www.cherokee-project.com/) is a high-performance web server. It is very fast, flexible and easy to configure.

<a name='cherokee-phalcon-configuration'></a>

### Настройка под Phalcon

Cherokee provides a friendly graphical interface to configure almost every setting available in the web server.

Start the cherokee administrator by executing as root `/path-to-cherokee/sbin/cherokee-admin`

![](/assets/images/content/webserver-cherokee-1.jpg)

Create a new virtual host by clicking on `vServers`, then add a new virtual server:

![](/assets/images/content/webserver-cherokee-2.jpg)

The recently added virtual server must appear at the left bar of the screen. In the `Behaviors` tab you will see a set of default behaviors for this virtual server. Click the `Rule Management` button. Remove those labeled as `Directory /cherokee_themes` and `Directory /icons`:

![](/assets/images/content/webserver-cherokee-3.jpg)

Add the `PHP Language` behavior using the wizard. This behavior allows you to run PHP applications:

![](/assets/images/content/webserver-cherokee-1.jpg)

Normally this behavior does not require additional settings. Add another behavior, this time in the `Manual Configuration` section. In `Rule Type` choose `File Exists`, then make sure the option `Match any file` is enabled:

![](/assets/images/content/webserver-cherokee-5.jpg)

In the 'Handler' tab choose `List & Send` as handler:

![](/assets/images/content/webserver-cherokee-7.jpg)

Edit the `Default` behavior in order to enable the URL-rewrite engine. Change the handler to `Redirection`, then add the following regular expression to the engine `^(.*)$`:

![](/assets/images/content/webserver-cherokee-6.jpg)

Finally, make sure the behaviors have the following order:

![](/assets/images/content/webserver-cherokee-8.jpg)

Execute the application in a browser:

![](/assets/images/content/webserver-cherokee-9.jpg)