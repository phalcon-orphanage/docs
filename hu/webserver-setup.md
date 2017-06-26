<div class='article-menu'>
  <ul>
    <li>
      <a href="#setup">Web Server Setup</a> <ul>
        <li>
          <a href="#nginx">Nginx</a> <ul>
            <li>
              <a href="#nginx-phalcon-configuration">Phalcon configuration</a> <ul>
                <li>
                  <a href="#nginx-phalcon-configuration-basic">Basic configuration</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#apache">Apache</a> <ul>
            <li>
              <a href="#apache-phalcon-configuration">Phalcon configuration</a> <ul>
                <li>
                  <a href="#apache-document-root">Document root</a>
                </li>
                <li>
                  <a href="#apache-apache-configuration">Apache configuration</a>
                </li>
                <li>
                  <a href="#apache-virtual-hosts">Virtual Hosts</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#cherokee">Cherokee</a> <ul>
            <li>
              <a href="#cherokee-phalcon-configuration">Phalcon configuration</a>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#php-built-in">Built in Webserver</a> <ul>
            <li>
              <a href="#php-built-in-phalcon-configuration">Phalcon configuration</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='setup'></a>

# Web Server Setup

In order for the routing of the Phalcon application to work, you will need to set up your web server to process the redirects properly. Setup instructions for popular web servers are:

<a name='nginx'></a>

## Nginx

[Nginx](http://wiki.nginx.org/Main) is a free, open-source, high-performance HTTP server and reverse proxy, as well as an IMAP/POP3 proxy server. Unlike traditional servers, Nginx doesn't rely on threads to handle requests. Instead it uses a much more scalable event-driven (asynchronous) architecture. This architecture uses small, but more importantly, predictable amounts of memory under load.

The [PHP-FPM](http://php-fpm.org/) (FastCGI Process Manager) is usually used to allow Nginx to process PHP files. Nowadays, PHP-FPM is bundled with all Linux based PHP distributions. Phalcon with Nginx and PHP-FPM provide a powerful set of tools that offer maximum performance for your PHP applications.

<a name='nginx-phalcon-configuration'></a>

### Phalcon configuration

The following are potential configurations you can use to setup Nginx with Phalcon:

<a name='nginx-phalcon-configuration-basic'></a>

#### Basic configuration

Using `$_GET['_url']` as source of URIs:

```nginx
server {
    listen      80;
    server_name localhost.dev;

    # This is the folder that index.php is in
    root /var/www/phalcon/public;
    index index.php index.html index.htm;

    charset utf-8;

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
```

Using `$_SERVER['REQUEST_URI']` as source of URIs:

```nginx
server {
    listen      80;
    server_name localhost.dev;

    # This is the folder that index.php is in
    root /var/www/phalcon/public;
    index index.php index.html index.htm;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php;
    }

    location ~ \.php$ {
        try_files $uri =404;

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
```

<a name='apache'></a>

## Apache

[Apache](http://httpd.apache.org/) is a popular and well known web server available on many platforms.

<a name='apache-phalcon-configuration'></a>

### Phalcon configuration

The following are potential configurations you can use to setup Apache with Phalcon. These notes are primarily focused on the configuration of the `mod_rewrite` module allowing to use friendly URLs and the [router component](/[[language]]/[[version]]/routing). Commonly an application has the following structure:

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

#### Document root

This being the most common case, the application is installed in any directory under the document root. In this case, we use two `.htaccess` files, the first one to hide the application code forwarding all requests to the application's document root (`public/`).

<h5 class='alert alert-warning'>Note that using <code>.htaccess</code> files requires your apache installation to have the <code>AllowOverride All</code> option set. </h5>

```apacheconfig
# test/.htaccess

<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteRule   ^$ public/    [L]
    RewriteRule   ((?s).*) public/$1 [L]
</IfModule>
```

A second `.htaccess` file is located in the `public/` directory, this re-writes all the URIs to the `public/index.php` file:

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

#### Apache configuration

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

#### Virtual Hosts

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

[Cherokee](http://www.cherokee-project.com/) is a high-performance web server. It is very fast, flexible and easy to configure.

<a name='cherokee-phalcon-configuration'></a>

### Phalcon configuration

Cherokee provides a friendly graphical interface to configure almost every setting available in the web server.

Start the cherokee administrator by executing as root `/path-to-cherokee/sbin/cherokee-admin`

![](/images/content/webserver-cherokee-1.jpg)

Create a new virtual host by clicking on `vServers`, then add a new virtual server:

![](/images/content/webserver-cherokee-2.jpg)

The recently added virtual server must appear at the left bar of the screen. In the `Behaviors` tab you will see a set of default behaviors for this virtual server. Click the `Rule Management` button. Remove those labeled as `Directory /cherokee_themes` and `Directory /icons`:

![](/images/content/webserver-cherokee-3.jpg)

Add the `PHP Language` behavior using the wizard. This behavior allows you to run PHP applications:

![](/images/content/webserver-cherokee-1.jpg)

Normally this behavior does not require additional settings. Add another behavior, this time in the `Manual Configuration` section. In `Rule Type` choose `File Exists`, then make sure the option `Match any file` is enabled:

![](/images/content/webserver-cherokee-5.jpg)

In the 'Handler' tab choose `List & Send` as handler:

![](/images/content/webserver-cherokee-7.jpg)

Edit the `Default` behavior in order to enable the URL-rewrite engine. Change the handler to `Redirection`, then add the following regular expression to the engine `^(.*)$`:

![](/images/content/webserver-cherokee-6.jpg)

Finally, make sure the behaviors have the following order:

![](/images/content/webserver-cherokee-8.jpg)

Execute the application in a browser:

![](/images/content/webserver-cherokee-9.jpg)

<a name='php-built-in'></a>

## PHP Built In Webserver

You can use PHP's [built in](http://php.net/manual/en/features.commandline.webserver.php) web server for your development. To start the server type:

```bash
php -S localhost:8000 -t /public
```

<a name='php-built-in-phalcon-configuration'></a>

### Phalcon configuration

To enable URI rewrites that Phalcon needs, you can use the following router file (`.htrouter.php`):

```php
<?php

if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
    $_GET['_url'] = $_SERVER['REQUEST_URI'];
}

return false;
```

and then start the server from the base project directory with:

```bash
php -S localhost:8000 -t /public .htrouter.php
```

Then point your browser to http://localhost:8000/ to check if everything is working.