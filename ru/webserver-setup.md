<div class='article-menu'>
  <ul>
    <li>
      <a href="#setup">Настройка веб-сервера</a> 
      <ul>
        <li>
          <a href="#php-built-in">Встроенный веб-сервер</a> 
          <ul>
            <li>
              <a href="#php-built-in-phalcon-configuration">Настройка под Phalcon</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#nginx">Nginx</a> 
          <ul>
            <li>
              <a href="#nginx-phalcon-configuration">Phalcon configuration</a> <ul>
                <li>
                  <a href="#nginx-phalcon-configuration-basic">Базовая конфигурация</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a href="#apache">Apache</a> 
          <ul>
            <li>
              <a href="#apache-phalcon-configuration">Phalcon configuration</a> 
              <ul>
                <li>
                  <a href="#apache-document-root">Корневой каталог</a>
                </li>
                <li>
                  <a href="#apache-apache-configuration">Конфигурация Apache</a>
                </li>
                <li>
                  <a href="#apache-virtual-hosts">Виртуальные хосты</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a href="#cherokee">Cherokee</a> 
          <ul>
            <li>
              <a href="#cherokee-phalcon-configuration">Phalcon configuration</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='setup'></a>

# Web Server Setup

Чтобы работала маршрутизация (анг. routing) в Phalcon, вам понадобится настроить должным образом веб-сервер, научив его правильно обрабатывать перенаправления. Ниже рассматриваются типичные конфигурации для популярных веб-серверов:

<a name='php-fpm'></a>

## PHP-FPM

The [PHP-FPM](http://php.net/manual/en/install.fpm.php) (FastCGI Process Manager) is usually used to allow the processing of PHP files. В настоящее время PHP-FPM идёт в комплекте с любым дистрибутивом PHP в Unix.

On **Windows** PHP-FPM is in the PHP distribution archive through the file `php-cgi.exe` and you can start it with this script to help set options. Windows does not support unix sockets so this script will start fast-cgi in TCP mode on port `9000`.

Create the file `php-fcgi.bat` with the following contents:

```bat
@ECHO OFF
ECHO Starting PHP FastCGI...
set PATH=C:\PHP;%PATH%
c:\bin\RunHiddenConsole.exe C:\PHP\php-cgi.exe -b 127.0.0.1:9000
```

<a name='php-built-in'></a>

## PHP Built-In Webserver (For Developers)

To speed up getting your Phalcon application running in development the easiest way is to use this built-in PHP server. Do not use this server in a production environment. The following configurations for [Nginx](#nginx) and [Apache](#apache) are what you need.

<a name='php-built-in-phalcon-configuration'></a>

### Phalcon configuration

To enable dynamic URI rewrites, without Apache or Nginx, that Phalcon needs, you can use the following router file:
<a href="https://github.com/phalcon/phalcon-devtools/blob/master/templates/.htrouter.php" target="_blank">.htrouter.php</a>

If you created your application with [Phalcon-Devtools](/[[language]]/[[version]]/devtools-installation) this file should already exist in the root directory of your project and you can start the server with the following command:

```bash
$(which php) -S localhost:8000 -t public .htrouter.php
```

The anatomy of the command above: - `$(which php)` - will insert the absolute path to your PHP binary - `-S localhost:8000` - invokes server mode with the provided `host:port` - `-t public` - defines the servers root directory, necessary for php to route requests to assets like JS, CSS, and images in your public directory - `.htrouter.php` - the entry point that will be evaluated for each request

Откройте свой браузер и перейдите по адресу http://localhost:8000/, чтобы убедиться, что всё работает.

<a name='nginx'></a>

## Nginx

[Nginx](http://wiki.nginx.org/Main) — это свободный, с открытым исходным кодом, высокопроизводительный HTTP-сервер и прокси-сервер, а также IMAP/POP3 прокси-сервер. В отличие от традиционных серверов Nginx не использует потоки для обработки запросов. Вместо этого он использует гораздо более масштабируемую, управляемую событиями (асинхронную) архитектуру. Эта архитектура под высокой нагрузкой использует небольшой, и главное, предсказуемый объем памяти.

Связка Phalcon + Nginx + PHP-FPM предоставляет мощный набор инструментов, который позволяет добиться максимальной производительности ваших PHP приложений.

### Install Nginx

<a href="https://www.nginx.com/resources/wiki/start/topics/tutorials/install/" target="_blank">NginX Offical Site</a>

<a name='nginx-phalcon-configuration'></a>

### Phalcon configuration

You can use following potential configuration to setup Nginx with Phalcon:

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
    # http://localhost:8000/[index.php]
    location / {
        # Matches URLS `$_GET['_url']`
        try_files $uri $uri/ /index.php?_url=$uri&$args;
    }

    # When the HTTP request does not match the above
    # and the file ends in .php
    location ~ \.php$ {
        try_files $uri =404;

        # Ubuntu and PHP7.0-fpm in socket mode
        # This path is dependent on the version of PHP install
        fastcgi_pass  unix:/var/run/php/php7.0-fpm.sock;


        # Alternatively you use PHP-FPM in TCP mode (Required on Windows)
        # You will need to configure FPM to listen on a standard port
        # https://www.nginx.com/resources/wiki/start/topics/examples/phpfastcgionwindows/
        # fastcgi_pass  127.0.0.1:9000;

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

    location ~* \.(js|css|png|jpg|jpeg|gif|ico)$ {
        expires       max;
        log_not_found off;
        access_log    off;
    }
}
```

### Start Nginx

Usually `start nginx` from the command line but this depends on your installation method.

<a name='apache'></a>

## Apache

[Apache](http://httpd.apache.org/) — это популярный веб-сервер, доступный на большинстве современных платформ.

<a name='apache-phalcon-configuration'></a>

### Phalcon configuration

Следующие инструкции позволят настроить Apache для корректной работы с Phalcon. В основном они сводятся к настройке поведения модуля `mod_rewrite`, позволяющего использовать человеко-понятные URL (ЧПУ) и [компонента маршрутизации](/[[language]]/[[version]]/routing). Типичное приложение имеет следующую структуру:

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

<div class="alert alert-warning">
    <p>
        Note that using <code>.htaccess</code> files requires your apache installation to have the `AllowOverride All` option set.
    </p>
</div>

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

<a name='apache-apache-configuration'></a>

#### Конфигурация Apache

Если нет желания или возможности использовать файлы `.htaccess`, то параметры также можно прописать в главном файле конфигурации Apache:

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

В этом заключительном примере конфигурации, мы разрешаем установку Phalcon-приложения в виртуальный хост:

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

[Cherokee](http://www.cherokee-project.com/) — это высокопроизводительный веб сервер. Он очень быстрый, гибкий и лёгкий в настройке.

<a name='cherokee-phalcon-configuration'></a>

### Phalcon configuration

Cherokee имеет удобный графический интерфейс для настройки практически всех параметров, доступных в веб-сервере.

Чтобы запустить администрирование сервера, нужно выполнить команду `/путь-к-cherokee/sbin/cherokee-admin` с правами суперадмина (root).

![](/images/content/webserver-cherokee-1.jpg)

Создайте новый виртуальный хост, для этого кликните на `vServers`, затем добавьте виртуальный сервер:

![](/images/content/webserver-cherokee-2.jpg)

Добавленный виртуальный хост должен появиться на панели слева. На вкладке `Behaviors` вы можете увидеть набор правил для данного сервера. Нажмите кнопку `Rule Management`. Снимите галочки с `Directory /cherokee_themes` и `Directory /icons`:

![](/images/content/webserver-cherokee-3.jpg)

С помощью мастера добавьте обработчик `PHP Language`. Это позволит запускать PHP приложения:

![](/images/content/webserver-cherokee-1.jpg)

Обычно такое решение не требует дополнительной настройки. Добавьте еще одно правило, на этот раз в разделе `Manual Configuration`. В списке `Rule Type` выберите `File Exists`, и убедитесь что опция `Match any file` включена:

![](/images/content/webserver-cherokee-5.jpg)

На вкладке 'Handler' выберите обработчик `List & Send`:

![](/images/content/webserver-cherokee-7.jpg)

Отредактируйте правило `Default` для включения возможностей URL-перезаписи. Выберите `Redirection`, затем добавьте регулярное выражение `^(.*)$`:

![](/images/content/webserver-cherokee-6.jpg)

Убедитесь, что обработчики выставлены в нужном порядке:

![](/images/content/webserver-cherokee-8.jpg)

Запустите приложение в браузере:

![](/images/content/webserver-cherokee-9.jpg)