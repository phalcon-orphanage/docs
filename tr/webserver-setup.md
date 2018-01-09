<div class='article-menu'>
  <ul>
    <li>
      <a href="#setup">Web Server Kurulumu</a> 
      <ul>
        <li>
          <a href="#php-built-in">Yerleşik Web Sunucusu</a> 
          <ul>
            <li>
              <a href="#php-built-in-phalcon-configuration">Phalcon configuration</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#nginx">Nginx</a> 
          <ul>
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
          <a href="#apache">Apache</a> 
          <ul>
            <li>
              <a href="#apache-phalcon-configuration">Phalcon configuration</a> 
              <ul>
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

Phalcon uygulmasını doğru çalıştırabilmek için web sunucunuzun yönlendirme ayarlarının düzgün işleyecek şekilde yapılandırmanız gerekmektedir. Popüler sunucu yazılımları için kurulum yönergeleri:

<a name='php-fpm'></a>

## PHP-FPM

The [PHP-FPM](http://php.net/manual/en/install.fpm.php) (FastCGI Process Manager) is usually used to allow the processing of PHP files. Nowadays, PHP-FPM is bundled with all Linux based PHP distributions.

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

The anatomy of the command above:

- `$(which php)` - will insert the absolute path to your PHP binary
- `-S localhost:8000` - invokes server mode with the provided `host:port`
- `-t public` - defines the servers root directory, necessary for php to route requests to assets like JS, CSS, and images in your public directory
- `.htrouter.php` - the entry point that will be evaluated for each request

Then point your browser to http://localhost:8000/ to check if everything is working.

<a name='nginx'></a>

## Nginx

[Nginx](http://wiki.nginx.org/Main) ücretsiz, açık kaynak kodlu, yüksek performanslı bir HTTP sunucusu ve ters proxy dir. Aynı zamanda IMAP/POP3 protokellerini sağlayan bir proxy serverdır. Unlike traditional servers, Nginx doesn't rely on threads to handle requests. Bunun yerine nesneye dayalı (asenkron) bir mimari kullanır. Bu mimari küçük ama daha önemlisi tahmin edilen bellek miktarından daha azını kullanır. Böylelikle sistem kaynaklarını verimli şekilde kullanarak bunları ölçümleyebilir.

Phalcon with Nginx and PHP-FPM provide a powerful set of tools that offer maximum performance for your PHP applications.

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

### Start Nginx

Usually `start nginx` from the command line but this depends on your installation method.

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