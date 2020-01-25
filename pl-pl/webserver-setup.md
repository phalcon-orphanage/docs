---
layout: default
language: 'pl-pl'
version: '4.0'
title: 'Web Server Setup'
keywords: 'web server, webserver, apache, nginx, xampp, wamp, cherokee, php built-in server'
---

# Webserver Setup

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

In order for the routing for a Phalcon application to work, you will need to set up your web server in a way that it will process redirects properly. Below are instructions for popular web servers:

## PHP Built-in

The PHP built-in web server is not recommended for production applications. You can use it though very easily for development purposes. The syntax is:

```bash
$(which php) -S <host>:<port> -t <directory> <setup file>
```

If your application has its entry point in `/public/index.php` or your project has been created by the [Phalcon Devtools](devtools), then you can start the web server with the following command:

```bash
$(which php) -S localhost:8000 -t public .htrouter.php
```

The above command does: - `$(which php)` - will insert the absolute path to your PHP binary - `-S localhost:8000` - invokes server mode with the provided `host:port` - `-t public` - defines the servers root directory, necessary for php to route requests to assets like JS, CSS, and images in your public directory - `.htrouter.php` - the entry point that will be evaluated for each request

The `.htrouter.php` file must contain:

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

If your entry point is not `public/index.php`, then adjust the `.htrouter.php` file accordingly (last line) as well as the script call. You can also change the port if you like as well as the network interface that it binds to.

After executing the command above, navigating to `http://localhost:8000/` will show your your site.

## PHP-FPM

The [PHP-FPM](https://php.net/manual/en/install.fpm.php) (FastCGI Process Manager) is usually used to allow the processing of PHP files. Nowadays, PHP-FPM is bundled with all Linux based PHP distributions.

On **Windows** PHP-FPM is in the PHP distribution archive. The file `php-cgi.exe` can be used to start the process and set options. Windows does not support unix sockets so this script will start fast-cgi in TCP mode on port `9000`.

Create the file `php-fcgi.bat` with the following contents:

```bat
@ECHO OFF
ECHO Starting PHP FastCGI...
set PATH=C:\PHP;%PATH%
c:\bin\RunHiddenConsole.exe C:\PHP\php-cgi.exe -b 127.0.0.1:9000
```

## nginx

[nginx](https://wiki.nginx.org/Main) is a free, open-source, high-performance HTTP server and reverse proxy, as well as an IMAP/POP3 proxy server. Unlike traditional servers, nginx doesn't rely on threads to handle requests. Instead it uses a much more scalable event-driven (asynchronous) architecture. This architecture uses small, but more importantly, predictable amounts of memory under load.

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
    

### Start

Depending on your system, the command to start nginx could be one of the following:

```bash
start nginx
/etc/init.d/nginx start
service nginx start
```

## Apache

[Apache](https://httpd.apache.org/) is a popular and well known web server available on many platforms.

### Phalcon Configuration

The following are potential configurations you can use to setup Apache with Phalcon. These notes are primarily focused on the configuration of the `mod_rewrite` module allowing to use friendly URLs and the [router component](routing). A common directory structure for an application is:

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

**Document root** The most common case is for an application to be installed in a directory under the document root. If that is the case, we can use `.htaccess` files. The first one will be used to hide the application code forwarding all requests to the application's document root (`public/`).

> **NOTE**: Note that using `.htaccess` files requires your apache installation to have the `AllowOverride All` option set.
 {: .alert .alert-warning}

# tutorial/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule   ^$ public/    [L]
        RewriteRule   ((?s).*) public/$1 [L]
    </IfModule>
    

A second `.htaccess` file is located in the `public/` directory, this re-writes all the URIs to the `public/index.php` file:

    # tutorial/public/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond   %{REQUEST_FILENAME} !-d
        RewriteCond   %{REQUEST_FILENAME} !-f
        RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>
    

**International Characters** For users that are using the Persian letter 'م' (meem) in uri parameters, there is an issue with `mod_rewrite`. To allow the matching to work as it does with English characters, you will need to change your `.htaccess` file:

    # tutorial/public/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond   %{REQUEST_FILENAME} !-d
        RewriteCond   %{REQUEST_FILENAME} !-f
        RewriteRule   ^([0-9A-Za-z\x7f-\xff]*)$ index.php?params=$1 [L]
    </IfModule>
    

If your uri contains characters other than English, you might need to resort to the above change to allow `mod_rewrite` to accurately match your route.

#### Apache Configuration

If you do not want to use `.htaccess` files, you can move the relevant directives to apache's main configuration file:

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
    

#### Virtual Hosts

The configuration below is for when you want to install your application in a virtual host:

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

[WampServer](http://www.wampserver.com/en/) is a Windows web development environment. It allows you to create web applications with Apache2, PHP and a MySQL database. Below are detailed instructions on how to install Phalcon on WampServer for Windows. Using the latest WampServer version is highly recommended.

> **NOTE** Since v4, you must install the `PSR` extension from PECL. Visit [this URL](https://pecl.php.net/package/psr/0.7.0/windows) to get the DLLs and follow the same steps to install the extension just as with Phalcon's DLLs.
{: .alert .alert-warning }

> 
> **NOTE** Paths in this guide should be relative, according to your installation WAMP
{: .alert .alert-warning }

### Download Phalcon

For Phalcon to work on Windows, you must install the correct version that matches your architecture and extension built. Load up the `phpinfo` page provided by WAMP:

![](/assets/images/content/webserver-architecture.png)

Check the `Architecture` and `Extension Build` values. Those will allow you to download the correct DLL. In the above example you should download the file:

    phalcon_x86_vc15_php7.2_4.0.0+4237.zip
    

which will match `x86`, `vc15` and `TS` which is *Thread Safe*. If your system reports `NTS` (*Non Thread Safe*) then you should download that DLL.

WAMP has both 32 and 64 bit versions. From the download section, you can download the Phalcon DLL that suits your WAMP installation.

After downloading the Phalcon library you will have a zip file like the one shown below:

![](/assets/images/content/webserver-zip-icon.png)

Extract the library from the archive to get the Phalcon DLL:

![](/assets/images/content/webserver-extracted-dlls.png)

Copy the file `php_phalcon.dll` to the PHP extensions folder. If WAMP is installed in the `C:\wamp` folder, the extension needs to be in `C:\wamp\bin\php\php7.2.18\ext` (assuming your WAMP installation installed PHP 7.2.18).

![](/assets/images/content/webserver-wamp-phalcon-psr-ext-folder.png)

Edit the `php.ini` file, it is located at `C:\wamp\bin\php\php7.2.18\php.ini`. It can be edited with Notepad or a similar program. We recommend Notepad++ to avoid issues with line endings. Append at the end of the file:

```ini extension=php_phalcon.dll

    <br />and save it.
    
    ![](/assets/images/content/webserver-wamp-phalcon-php-ini.png)
    
    Also edit the `php.ini` file, which is located at `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. Append at the end of the file: 
    
    ```ini
    extension=php_phalcon.dll 
    

and save it.

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

> **NOTE** Since v4, you must install the `PSR` extension from PECL. Visit [this URL](https://pecl.php.net/package/psr/0.7.0/windows) to get the DLLs and follow the same steps to install the extension just as with Phalcon's DLLs.
{: .alert .alert-warning }

> 
> **NOTE** Paths in this guide should be relative, according to your installation WAMP
{: .alert .alert-warning }

### Download Phalcon

For Phalcon to work on Windows, you must install the correct version that matches your architecture and extension built. Load up the `phpinfo` page provided by XAMPP:

![](/assets/images/content/webserver-architecture.png)

Check the `Architecture` and `Extension Build` values. Those will allow you to download the correct DLL. In the above example you should download the file:

    phalcon_x86_vc15_php7.2_4.0.0+4237.zip
    

which will match `x86`, `vc15` and `TS` which is *Thread Safe*. If your system reports `NTS` (*Non Thread Safe*) then you should download that DLL.

XAMPP is always releasing 32 bit versions of Apache and PHP. You will need to download the x86 version of Phalcon for Windows from the download section.

After downloading the Phalcon library you will have a zip file like the one shown below:

![](/assets/images/content/webserver-zip-icon.png)

Extract the library from the archive to get the Phalcon DLL:

![](/assets/images/content/webserver-extracted-dlls.png)

Copy the file `php_phalcon.dll` to the PHP extensions directory. If you have installed XAMPP in the `C:\xampp` folder, the extension needs to be in `C:\xampp\php\ext`

![](/assets/images/content/webserver-xampp-phalcon-psr-ext-folder.png)

Edit the `php.ini` file, it is located at `C:\xampp\php\php.ini`. It can be edited with Notepad or a similar program. We recommend [Notepad++](https://notepad-plus-plus.org/) to avoid issues with line endings. Append at the end of the file:

```ini
extension=php_phalcon.dll
```

and save it.

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