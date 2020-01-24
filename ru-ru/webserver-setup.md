---
layout: default
language: 'ru-ru'
version: '4.0'
title: 'Настройка веб-сервера'
keywords: 'веб сервер, веб-сервер, apache, nginx, xampp, wamp, cherokee, встроенный сервер php'
---

# Настройка веб-сервера

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Введение

Для работы приложения Phalcon вам нужно настроить ваш веб-сервер таким образом, чтобы он должным образом обрабатывал перенаправления. Ниже приведены инструкции для популярных веб-серверов:

## Встроенный в PHP

The PHP built-in web server is not recommended for production applications. Тем не менее, его можно легко использовать в целях разработки. Способ запуска:

```bash
$(which php) -S <host>:<port> -t <directory> <setup file>
```

Если ваше приложение имеет точку входа в `/public/index. hp` или ваш проект был создан [Phalcon Devtools](devtools), то вы можете запустить веб-сервер следующей командой:

```bash
$(which php) -S localhost:8000 -t public .htrouter.php
```

Рассмотрим, что делает команда, представленная выше: - `$(which php)` - вставляет абсолютный путь к вашей двоичной версии PHP - `-S localhost:8000` - вызовет режим сервера с предоставленным `host:port` - `-t public` - определяет корневую директорию сервера, необходимую для того, чтобы php перенаправлял запросы к таким ресурсам, как JS, CSS, и изображениям в вашем публичном каталоге - `. trouter.php` - входная точка, которая будет оцениваться для каждого запроса

Файл `.htrouter.php` должен содержать:

```php
<?php

declare(strict_types=1);

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

$_GET['_url'] = $_SERVER['REQUEST_URI'];

require_once __DIR__ . '/public/index.php';
```

Если ваша точка входа не `public/index.php`, то отредактируйте `. trouter.php` файл соответственно (последняя строка), а также вызов скрипта. Вы также можете изменить порт, если хотите, а также сетевой интерфейс, к которому он привязан.

После выполнения команды выше, перейдите по ссылке `http://localhost:8000/`, по которой отбразится ваш сайт.

## PHP-FPM

Менеджер процессов FastCGI ([PHP-FPM](https://php.net/manual/ru/install.fpm.php)) обычно используется для управления процессом обработки PHP файлов. В настоящее время PHP-FPM комплектуется со всеми основанными на Linux дистрибутивами PHP.

На **Windows** PHP-FPM находится в архиве дистрибутива PHP. Файл `php-cgi.exe` может быть использован для запуска процесса и установки параметров. Windows не поддерживает unix сокеты, поэтому этот скрипт запустит fast-cgi в режиме TCP на `9000` порту.

Создайте файл `php-fcgi.bat` со следующим содержимым:

```bat
@ECHO OFF
ECHO Starting PHP FastCGI...
set PATH=C:\PHP;%PATH%
c:\bin\RunHiddenConsole.exe C:\PHP\php-cgi.exe -b 127.0.0.1:9000
```

## nginx

[nginx](https://wiki.nginx.org/Main) is a free, open-source, high-performance HTTP server and reverse proxy, as well as an IMAP/POP3 proxy server. Unlike traditional servers, nginx doesn't rely on threads to handle requests. Вместо этого он использует гораздо более масштабируемую (асинхронную) архитектуру. Эта архитектура под высокой нагрузкой использует небольшой, и главное, предсказуемый объем памяти.

Phalcon with nginx and PHP-FPM provide a powerful set of tools that offer maximum performance for your PHP applications.

### Install nginx

[nginx Official Site](https://www.nginx.com/resources/wiki/start/topics/tutorials/install/)

### Phalcon Configuration

You can use following potential configuration to setup nginx with Phalcon:

    server {
        # Port 80 will require nginx to be started with root permissions
        # Depending on how you install nginx to use port 80 you will need
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
    

### Запуск Nginx

Depending on your system, the command to start nginx could be one of the following:

```bash
start nginx
/etc/init.d/nginx start
service nginx start
```

## Apache

[Apache](https://httpd.apache.org/) — это популярный веб-сервер, доступный на большинстве современных платформ.

### Phalcon Configuration

Ниже приведены возможные конфигурации, которые можно использовать для настройки Apache с Phalcon. Эти примеры в основном нацелены на настройку модуля ` mod_rewrite`, позволяющего использовать понятные URL-адреса (ЧПУ) и [компонента маршрутизации](routing). Типичное приложение имеет следующую структуру:

```bash
tutorial/
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

**Корневой каталог** Наиболее распространенным вариантом является установка приложения в корневой каталог. Если это так, то мы можем использовать `.htaccess` файлы. Во первых, он будет использоваться для скрытия кода приложения, пересылающего все запросы в корневой каталог приложения (`public/`).

> **NOTE**: Note that using `.htaccess` files requires your apache installation to have the `AllowOverride All` option set.
 {: .alert .alert-warning}

# tutorial/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule   ^$ public/    [L]
        RewriteRule   ((?s).*) public/$1 [L]
    </IfModule>
    

Во вторых, файл `.htaccess` находящийся в каталоге `public/`, перезаписывает все URI в `public/index.php` файл:

    # tutorial/public/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond   %{REQUEST_FILENAME} !-d
        RewriteCond   %{REQUEST_FILENAME} !-f
        RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>
    

**Международные символы** При использовании `mod_rewrite` существует проблема для пользователей, использующих персидскую букву 'م' (meem) в параметрах uri. Чтобы сопоставление работало как и с английскими символами, вам нужно изменить файл `.htaccess`:

    # tutorial/public/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond   %{REQUEST_FILENAME} !-d
        RewriteCond   %{REQUEST_FILENAME} !-f
        RewriteRule   ^([0-9A-Za-z\x7f-\xff]*)$ index.php?params=$1 [L]
    </IfModule>
    

Если URI вашего приложения может содержать символы, отличные от английского, вам, возможно, придется применить указанное выше изменение, чтобы результат работы модуля `mod_rewrite` точно соответствовал маршруту (роуту) приложения.

#### Apache Configuration

Если вы не хотите использовать файлы `.htaccess`, вы можете переместить соответствующие директивы в основной конфигурационный файл apache:

    <IfModule mod_rewrite.c>
    
        <Directory "/var/www/test">
            RewriteEngine on
            RewriteRule  ^$ public/    [L]
            RewriteRule  ((?s).*) public/$1 [L]
        </Directory>
    
        <Directory "/var/www/tutorial/public">
            RewriteEngine On
            RewriteCond   %{REQUEST_FILENAME} !-d
            RewriteCond   %{REQUEST_FILENAME} !-f
            RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
        </Directory>
    
    </IfModule>
    

#### Виртуальные хосты

Конфигурация ниже предназначена для установки вашего приложения на виртуальном хосте:

    <VirtualHost *:80>
    
        ServerAdmin    admin@example.host
        DocumentRoot   "/var/vhosts/tutorial/public"
        DirectoryIndex index.php
        ServerName     example.host
        ServerAlias    www.example.host
    
        <Directory "/var/vhosts/tutorial/public">
            Options       All
            AllowOverride All
            Require       all granted
        </Directory>
    
    </VirtualHost>
    

## WAMP

[ WampServer ](http://www.wampserver.com/ru/) — это веб-среда разработки под Windows. Она позволяет создавать веб-приложения с помощью Apache2, PHP и MySQL. Ниже приведены подробные инструкции по установке Phalcon на WampServer для Windows. Крайне рекомендуем использовать последнюю версию WampServer.

> **Примечание:** Начиная с версии Phalcon 4, вам понадобится установить дополнительное расширение `PHP-PSR` используя PECL. Visit [this URL](https://pecl.php.net/package/psr/0.7.0/windows) to get the DLLs and follow the same steps to install the extension just as with Phalcon's DLLs.
{: .alert .alert-warning }

> 
> **Примечание:** Используемые пути к файлам и каталогам в этом руководстве должны быть относительными установленному WampServer.
{: .alert .alert-warning }

### Установка Phalcon

Для того, чтобы Phalcon заработал в Windows, необходимо установить правильную версию, соответствующую вашей архитектуре и сборке расширений. Откройте страницу `phpinfo`, предоставляемую WAMP:

![](/assets/images/content/webserver-architecture.png)

Проверьте значения `Architecture` и `Extension Build`. Это позволит вам скачать нужную версию DLL файла. Используя приведенный выше пример, вы должны скачать файл:

    phalcon_x86_vc15_php7.2_4.0.0+4237.zip
    

обратите внимание на составные части файла: `x86`, `vc15` и аббревиатуру `TS`, которая означает *потоковую безопасность* (Thread Safe). Если вы используете NTS-версию PHP (*потоко-небезопасная версия, Non Thread Safe*), вам следует скачать соответствующую версию DLL.

WampServer предоставляет как 32-битные, так и 64-битные версии. From the download section, you can download the Phalcon DLL that suits your WAMP installation.

После скачивания библиотеки Phalcon у вас будет zip-файл, примерно такой как показано ниже:

![](/assets/images/content/webserver-zip-icon.png)

Распакуйте архив и получите файл библиотеки Phalcon DLL:

![](/assets/images/content/webserver-extracted-dlls.png)

Copy the file `php_phalcon.dll` to the PHP extensions folder. If WAMP is installed in the `C:\wamp` folder, the extension needs to be in `C:\wamp\bin\php\php7.2.18\ext` (assuming your WAMP installation installed PHP 7.2.18).

![](/assets/images/content/webserver-wamp-phalcon-psr-ext-folder.png)

Edit the `php.ini` file, it is located at `C:\wamp\bin\php\php7.2.18\php.ini`. Для редактирования можно использовать Блокнот или любую подобную программу. We recommend Notepad++ to avoid issues with line endings. Добавьте в конец файла:

```ini extension=php_phalcon.dll

    <br />и сохраните его.
    
    ![](/assets/images/content/webserver-wamp-phalcon-php-ini.png)
    
    Also edit the `php.ini` file, which is located at `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. Добавьте в самый конец файла:
    
    extension=php_phalcon.dll 
    

и сохраните его.

> **NOTE**: The path above might differ depending on the apache installation you have for your web server. Adjust it accordingly.
{: .alert .alert-warning }

> 
> **NOTE**: As mentioned above the `PSR` extension needs to be installed and loaded before Phalcon. Add the `extension=php_psr.dll` line before the one for Phalcon as shown in the image above.
{: .alert .alert-warning }

![](/assets/images/content/webserver-wamp-apache-phalcon-php-ini.png)

Restart the Apache Web Server. Do a single click on the WampServer icon at system tray. Choose `Restart All Services` from the pop-up menu. Check out that tray icon will become green again.

![](/assets/images/content/webserver-wamp-manager.png)

Open your browser to navigate to https://localhost. The WAMP welcome page will appear. Check the section `extensions loaded` to ensure that Phalcon was loaded.

![](/assets/images/content/webserver-wamp-phalcon.png)

> **Congratulations! You are now phlying with Phalcon.**
{: .alert .alert-info }

## XAMPP

[XAMPP](https://www.apachefriends.org/download.html) is an easy to install Apache distribution containing MySQL, PHP and Perl. Once you download XAMPP, all you have to do is extract it and start using it. Below are detailed instructions on how to install Phalcon on XAMPP for Windows. Using the latest XAMPP version is highly recommended.

> **Примечание:** Начиная с версии Phalcon 4, вам понадобится установить дополнительное расширение `PHP-PSR` используя PECL. Visit [this URL](https://pecl.php.net/package/psr/0.7.0/windows) to get the DLLs and follow the same steps to install the extension just as with Phalcon's DLLs.
{: .alert .alert-warning }

> 
> **Примечание:** Используемые пути к файлам и каталогам в этом руководстве должны быть относительными установленному WampServer.
{: .alert .alert-warning }

### Download Phalcon

Для того, чтобы Phalcon заработал в Windows, необходимо установить правильную версию, соответствующую вашей архитектуре и сборке расширений. Load up the `phpinfo` page provided by XAMPP:

![](/assets/images/content/webserver-architecture.png)

Проверьте значения `Architecture` и `Extension Build`. Это позволит вам скачать нужную версию DLL файла. Используя приведенный выше пример, вы должны скачать файл:

    phalcon_x86_vc15_php7.2_4.0.0+4237.zip
    

обратите внимание на составные части файла: `x86`, `vc15` и аббревиатуру `TS`, которая означает *потоковую безопасность* (Thread Safe). Если вы используете NTS-версию PHP (*потоко-небезопасная версия, Non Thread Safe*), вам следует скачать соответствующую версию DLL.

XAMPP is always releasing 32 bit versions of Apache and PHP. You will need to download the x86 version of Phalcon for Windows from the download section.

После скачивания библиотеки Phalcon у вас будет zip-файл, примерно такой как показано ниже:

![](/assets/images/content/webserver-zip-icon.png)

Распакуйте архив и получите файл библиотеки Phalcon DLL:

![](/assets/images/content/webserver-extracted-dlls.png)

Copy the file `php_phalcon.dll` to the PHP extensions directory. If you have installed XAMPP in the `C:\xampp` folder, the extension needs to be in `C:\xampp\php\ext`

![](/assets/images/content/webserver-xampp-phalcon-psr-ext-folder.png)

Edit the `php.ini` file, it is located at `C:\xampp\php\php.ini`. Для редактирования можно использовать Блокнот или любую подобную программу. We recommend [Notepad++](https://notepad-plus-plus.org/) to avoid issues with line endings. Добавьте в конец файла:

```ini
extension=php_phalcon.dll
```

и сохраните его.

> **NOTE**: As mentioned above the `PSR` extension needs to be installed and loaded before Phalcon. Add the `extension=php_psr.dll` line before the one for Phalcon as shown in the image above.
{: .alert .alert-warning }

![](/assets/images/content/webserver-xampp-phalcon-php-ini.png)

Restart the Apache Web Server from the XAMPP Control Center. This will load the new PHP configuration. Open your browser to navigate to `https://localhost`. The XAMPP welcome page will appear. Click on the link `phpinfo()`.

![](/assets/images/content/webserver-xampp-phpinfo.png)

[phpinfo](https://php.net/manual/en/function.phpinfo.php) will output a significant amount of information on screen about the current state of PHP. Scroll down to check if the Phalcon extension has been loaded correctly.

![](/assets/images/content/webserver-xampp-phpinfo-phalcon.png)

> **Congratulations! You are now phlying with Phalcon.**
{: .alert .alert-info }


## Cherokee

[Cherokee](https://www.cherokee-project.com/) is a high-performance web server. It is very fast, flexible and easy to configure.

### Phalcon Configuration

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

In the `Handler` tab choose `List & Send` as handler:

![](/assets/images/content/webserver-cherokee-7.jpg)

Edit the `Default` behavior in order to enable the URL-rewrite engine. Change the handler to `Redirection`, then add the following regular expression to the engine `^(.*)$`:

![](/assets/images/content/webserver-cherokee-6.jpg)

Finally, make sure the behaviors have the following order:

![](/assets/images/content/webserver-cherokee-8.jpg)

Execute the application in a browser:

![](/assets/images/content/webserver-cherokee-9.jpg)