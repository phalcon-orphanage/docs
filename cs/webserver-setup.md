<div class='article-menu'>
  <ul>
    <li>
      <a href="#setup">Nastavení webserveru</a> 
      <ul>
        <li>
          <a href="#php-built-in">Vestavěný webserver v PHP</a> 
          <ul>
            <li>
              <a href="#php-built-in-phalcon-configuration">Konfigurace Phalcon frameworku</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#nginx">Nginx</a> 
          <ul>
            <li>
              <a href="#nginx-phalcon-configuration">Phalcon configuration</a> <ul>
                <li>
                  <a href="#nginx-phalcon-configuration-basic">Základní konfigurace</a>
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
                  <a href="#apache-apache-configuration">Konfigurace Apache webserveru</a>
                </li>
                <li>
                  <a href="#apache-virtual-hosts">Virtuální domény (VirtualHost)</a>
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

Aby routování v aplikaci postavené na Phalcon frameworku fungovalo správně, musíte nastavit Vaš webserver aby správně zpracovával přesměrování a požadavky. Instrukce pro oblíbené webservery jsou:

<a name='php-fpm'></a>

## PHP-FPM

The [PHP-FPM](http://php.net/manual/en/install.fpm.php) (FastCGI Process Manager) is usually used to allow the processing of PHP files. V dnešní době je PHP-FPM součástí všech distribucí PHP pro Linuxové systémy.

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

Otevřete internetový prohlížeč a do řádku adresy napište: http://localhost:8000/ pro kontrolu že vše funguje jak má.

<a name='nginx'></a>

## Nginx

[Nginx](http://wiki.nginx.org/Main) je bezplatný, s otevřeným zdrojovým kódem, vysoce výkonný HTTP server a reverzní proxy a také IMAP/POP3 proxy server. Oproti tradičním serverům, Nginx nezávisí na vláknech pro zpracování požadavků. Místo toho používá mnohem více škálovatelnou event-driven (asynchroní) architekturu. Tato architektura používá malé, ale více důležíté, předvídatelné množství paměti.

Phalcon framework společně s Nginx a PHP-FPM nabízí mocnou sadu nástrojů, která nabízí maximální výkon pro Vaše PHP aplikace.

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

[Apache](http://httpd.apache.org/) je dobře známý a oblíbený web server dostupný pro velké množství platforem.

<a name='apache-phalcon-configuration'></a>

### Phalcon configuration

Níže jsou uvedeny potenciální konfigurace, které můžete použít pro nastavení Apache a Phalcon frameworku. These notes are primarily focused on the configuration of the `mod_rewrite` module allowing to use friendly URLs and the [router component](/[[language]]/[[version]]/routing). Běžně má aplikace následující strukturu:

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

Je běžné použití kdy aplikace je instalována v jakémkoliv adresáři který je v tzv.: Document Root složce. V tomto případě použijeme dva `.htaccess` soubory kde první schová aplikační kód a všechny požadavky přesmeruje do veřejné aplikační složky (v našem případě je to složka `public/`).

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

Druhý `.htaccess` soubor je umístěn ve složce `public/`, kde přesměruje všechny URI na soubor `public/index.php`:

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

#### Konfigurace Apache webserveru

V případě že nechcete či nemůžete použít soubory `.htaccess`, můžete vše nastavit v hlavním konfiguračním souboru webserveru Apache:

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

#### Virtuální domény (VirtualHost)

Tato druhá konfigurace Vám dovolí připravit Phalcon aplikaci jako virtuální doménu (virtuální doména nemusí ani existovat ani být registrována ale na serveru, kde takto nakonfigurujeme Apache bude fungovat):

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

[Cherokee](http://www.cherokee-project.com/) je vysoce výkonný webserver. Je velmi rychlý, flexibilní a jednoduchý na konfiguraci.

<a name='cherokee-phalcon-configuration'></a>

### Phalcon configuration

Cherokee nabízí přátelské grafické prostředí pro konfiguraci skoro všech nastavení webserveru přímo v internetovém prohlížeči.

Spusťte administraci Cherokee jako správce (root) přes `/cesta-k-cherokee/sbin/cherokee-admin`

![](/images/content/webserver-cherokee-1.jpg)

Vytvořte novou virtuální doménu kliknutím na `vServers`, poté přidejte nový virtuální server:

![](/images/content/webserver-cherokee-2.jpg)

Vámi přidaný virtuální server se zobrazí na levé straně obrazovky. Na záložce `Behaviors` uvidíte sadu výchozího chování pro vybraný virtuální server. Klikněte na tlačítko `Rule Management`. Odstraňte tyto pravidla: `Directory /cherokee_themes` a `Directory /icons`:

![](/images/content/webserver-cherokee-3.jpg)

Pomocí průvodce přidejte `PHP Langauge`. To Vám umožní spouštět PHP aplikace:

![](/images/content/webserver-cherokee-1.jpg)

Normálně toto chování nepotřebuje žádné další nastavení. Přidejte další chování. Tentokrát v sekci `Manual Configuration`. V sekci `Rule Type` vyberte `File Exists`, poté se ujistěte že volba `Match any file` je povolena:

![](/images/content/webserver-cherokee-5.jpg)

V záložce 'Handler' vyberte `List & Send` jako handler:

![](/images/content/webserver-cherokee-7.jpg)

Upravte chování `Default` abychom mohli povolit přepis URL adres (URL-rewrite engine). Změnte handler na `Redirection` a poté přidejte následujicí regulární výraz: `^(.*)$`:

![](/images/content/webserver-cherokee-6.jpg)

Nakonec se ujistěte že chování mají následující pořadí:

![](/images/content/webserver-cherokee-8.jpg)

Spusťe aplikaci v prohlížeči:

![](/images/content/webserver-cherokee-9.jpg)