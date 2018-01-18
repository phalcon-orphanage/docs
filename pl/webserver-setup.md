<div class='article-menu'>
  <ul>
    <li>
      <a href="#setup">Ustawianie Web serwera</a> 
      <ul>
        <li>
          <a href="#php-built-in">Wbudowany serwer</a> 
          <ul>
            <li>
              <a href="#php-built-in-phalcon-configuration">Konfiguracja Phalcona</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#nginx">Nginx</a> 
          <ul>
            <li>
              <a href="#nginx-phalcon-configuration">Phalcon configuration</a> <ul>
                <li>
                  <a href="#nginx-phalcon-configuration-basic">Podstawowa konfiguracja</a>
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

W celu działania routingu w phalconowej aplikacji najpierw musimy skonfigurować nasz web serwer aby przetwarzał przekierowywania prawidłowo. Konfiguracja popularnych web serwerów wygląda następująco:

<a name='php-fpm'></a>

## PHP-FPM

The [PHP-FPM](http://php.net/manual/en/install.fpm.php) (FastCGI Process Manager) is usually used to allow the processing of PHP files. W dzisiejszych czasach, PHP-FPM jest wbudowany w wszystkich dystrybucjach Linuxa posiadających PHP.

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

Następnie otwórz w swojej przeglądarce http://localhost:8000/, aby sprawdzić, czy wszystko działa prawidłowo.

<a name='nginx'></a>

## Nginx

[Nginx](http://wiki.nginx.org/Main) jest darmowym, open source’owym, wysoce wydajnym serwerem HTTP i Reverse Proxy, jak jaki również serwerem pośredniczącym IMAP/POP3. W przeciwieństwie do tradycyjnych serwerów, Nginx nie korzysta z architektury wielowątkowej do obsługi żądań. Zamiast tego wykorzystuje on znacznie bardziej skalowalną architekturę sterowaną zdarzeniami (asynchroniczną). Ta architektura używa małą, a co ważniejsze, przewidywalną ilość pamięci pod obciążeniem.

Phalcon wraz z NGINX i PHP-FPM dostarcza potężny zestaw narzędzi, które zapewniają maksymalną wydajności dla aplikacji PHP.

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

[Apache](http://httpd.apache.org/) jest popularnym i dobrze znanym serwerem sieci web dostępnym na wielu platformach.

<a name='apache-phalcon-configuration'></a>

### Phalcon configuration

Poniżej prezentujemy proponowane konfiguracje jakich możesz użyć do konfiguracji Phalcona z Apache. These notes are primarily focused on the configuration of the `mod_rewrite` module allowing to use friendly URLs and the [router component](/[[language]]/[[version]]/routing). Zwykle aplikacja ma następującą strukturę:

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

Najbardziej typowym przypadkiem jest aplikacja zainstalowana w dowolnym folderze znajdującym się w głównym katalogu witryny. W tym przypadku używamy dwóch plików `.htaccess`, pierwszego do ukrycia kodu aplikacjia i przekierowania wszystkich zapytań do głównego katalogu aplikacji (`public/`).

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

Drugi plik `.htaccess` zlokalizowany jest w folderze `public/`, przekierowuje on wszystkie adresy do pliku `public/index.php`:

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

Jeśli nie chcesz używać plików `.htaccess` możesz przenieść te konfiguracje do głównego pliku konfiguracyjnego apache’a

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

[Cherokee](http://www.cherokee-project.com/) jest serwerem sieci web o wysokiej wydajności. Jest bardzo szybki, elastyczny i łatwy w konfiguracji.

<a name='cherokee-phalcon-configuration'></a>

### Phalcon configuration

Cherokee zapewnia przyjazny interfejs graficzny pozwalający na skonfigurowanie prawie każdej dostępnej opcji w tym serwerze.

Uruchom administratora cherokee przez wykonanie jako root `/ścieżka-do-cherokee/sbin/cherokee-admin`

![](/images/content/webserver-cherokee-1.jpg)

Utwórz nowy wirtualny host klikając na `vServers`, a następnie dodaj nowy wirtualny serwer:

![](/images/content/webserver-cherokee-2.jpg)

Ostatnio dodany serwer wirtualny powinien pojawić się na pasku po lewej stronie ekranu. W karcie `Behaviors` powinieneś zobaczyć zestaw domyślnych zachowań dla tego serwera wirtualnego. Kliknij przycisk `Rule Management`. Usuń reguły oznaczone jako `Directory /cherokee_themes` i `Directory /icons`:

![](/images/content/webserver-cherokee-3.jpg)

Dodaj zachowanie `PHP Language` przy użyciu kreatora. To zachowanie umożliwia uruchamianie aplikacji PHP:

![](/images/content/webserver-cherokee-1.jpg)

To zachowanie zazwyczaj nie wymaga dodatkowej konfiguracji. Dodaj kolejne zachowanie, tym razem w sekcji `Manual Configuration`. W polu `Rule Type` wybierz `File Exists`, a następnie upewnij się, że opcja `Match any file` jest włączona:

![](/images/content/webserver-cherokee-5.jpg)

W zakładce 'Handler' należy wybrać `List & Send` jako handler’a:

![](/images/content/webserver-cherokee-7.jpg)

Zmień `Default` zachowanie w celu włączenia przepisywania linków. Zmień handler’a na `Redirection`, a następnie dodaj do silnika następujące wyrażenie regularne `^(.*)$`:

![](/images/content/webserver-cherokee-6.jpg)

Na koniec, upewnij się, że zachowania mają następującą kolejność:

![](/images/content/webserver-cherokee-8.jpg)

Uruchom aplikację w przeglądarce:

![](/images/content/webserver-cherokee-9.jpg)