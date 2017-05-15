<div class='article-menu'>
  <ul>
    <li>
      <a href="#setup">Ustawianie Web serwera</a> <ul>
        <li>
          <a href="#nginx">Nginx</a> <ul>
            <li>
              <a href="#nginx-phalcon-configuration">Konfiguracja Phalcona</a> <ul>
                <li>
                  <a href="#nginx-phalcon-configuration-basic">Podstawowa konfiguracja</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#apache">Apache</a> <ul>
            <li>
              <a href="#apache-phalcon-configuration">Konfiguracja Phalcona</a> <ul>
                <li>
                  <a href="#apache-document-root">Absolutna ścieżka do witryny</a>
                </li>
                <li>
                  <a href="#apache-apache-configuration">Konfiguracja Apache</a>
                </li>
                <li>
                  <a href="#apache-virtual-hosts">Wirtualne hosty</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#cherokee">Cherokee</a> <ul>
            <li>
              <a href="#cherokee-phalcon-configuration">Konfiguracja Phalcona</a>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#php-built-in">Wbudowany serwer</a> <ul>
            <li>
              <a href="#php-built-in-phalcon-configuration">Konfiguracja Phalcona</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='setup'></a>

# Ustawianie Web serwera

W celu działania routingu w phalconowej aplikacji najpierw musimy skonfigurować nasz web serwer aby przetwarzał przekierowywania prawidłowo. Konfiguracja popularnych web serwerów wygląda następująco:

<a name='nginx'></a>

## Nginx

[Nginx](http://wiki.nginx.org/Main) jest darmowym, open source’owym, wysoce wydajnym serwerem HTTP i Reverse Proxy, jak jaki również serwerem pośredniczącym IMAP/POP3. W przeciwieństwie do tradycyjnych serwerów, Nginx nie korzysta z architektury wielowątkowej do obsługi żądań. Zamiast tego wykorzystuje on znacznie bardziej skalowalną architekturę sterowaną zdarzeniami (asynchroniczną). Ta architektura używa małą, a co ważniejsze, przewidywalną ilość pamięci pod obciążeniem.

[PHP-FPM](http://php-fpm.org/) (FastCGI Process Manager) jest zazwyczaj używany aby NGINX mógł przetwarzać pliki PHP. W dzisiejszych czasach, PHP-FPM jest wbudowany w wszystkich dystrybucjach Linuxa posiadających PHP. Phalcon wraz z NGINX i PHP-FPM dostarcza potężny zestaw narzędzi, które zapewniają maksymalną wydajności dla aplikacji PHP.

<a name='nginx-phalcon-configuration'></a>

### Konfiguracja Phalcona

Poniżej prezentujemy proponowane konfiguracje, jakich możesz użyć do konfiguracji Nginx'a dla Phalcona:

<a name='nginx-phalcon-configuration-basic'></a>

#### Podstawowa konfiguracja

Użycie `$_GET['_url']` jako źródła URI

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

Użycie `$_SERVER['REQUEST_URI']` jako źródła URI:

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

[Apache](http://httpd.apache.org/) jest popularnym i dobrze znanym serwerem sieci web dostępnym na wielu platformach.

<a name='apache-phalcon-configuration'></a>

### Konfiguracja Phalcona

Poniżej prezentujemy proponowane konfiguracje jakich możesz użyć do konfiguracji Phalcona z Apache. These notes are primarily focused on the configuration of the `mod_rewrite` module allowing to use friendly URLs and the [router component](/en/[[version]]/routing). Commonly an application has the following structure:

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

#### Absolutna ścieżka do witryny

This being the most common case, the application is installed in any directory under the document root. In this case, we use two `.htaccess` files, the first one to hide the application code forwarding all requests to the application's document root (`public/`).

##### Należy zauważyć że używanie plików `.htaccess` wiąże się z koniecznością ustawienia opcji `AllowOverride All` w twojej konfiguracji apache. {.alert.alert-warning}

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

#### Konfiguracja Apache

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

#### Wirtualne hosty

Następująca konfiguracja umożliwia Ci zainstalowanie aplikacji Phalcona w wirtualnym hoście:

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

<a name='nginx'></a>

0### Konfiguracja Phalcona

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

<a name='nginx'></a>

1## Wbudowany serwer PHP

You can use PHP's [built in](http://php.net/manual/en/features.commandline.webserver.php) web server for your development. To start the server type:

```bash
php -S localhost:8000 -t /public
```

<a name='nginx'></a>

2### Konfiguracja Phalcona

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