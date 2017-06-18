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
              <a href="#apache-phalcon-configuration">Phalcon configuration</a> <ul>
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
              <a href="#cherokee-phalcon-configuration">Phalcon configuration</a>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#php-built-in">Wbudowany serwer</a> <ul>
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

W celu działania routingu w phalconowej aplikacji najpierw musimy skonfigurować nasz web serwer aby przetwarzał przekierowywania prawidłowo. Konfiguracja popularnych web serwerów wygląda następująco:

<a name='nginx'></a>

## Nginx

[Nginx](http://wiki.nginx.org/Main) jest darmowym, open source’owym, wysoce wydajnym serwerem HTTP i Reverse Proxy, jak jaki również serwerem pośredniczącym IMAP/POP3. W przeciwieństwie do tradycyjnych serwerów, Nginx nie korzysta z architektury wielowątkowej do obsługi żądań. Zamiast tego wykorzystuje on znacznie bardziej skalowalną architekturę sterowaną zdarzeniami (asynchroniczną). Ta architektura używa małą, a co ważniejsze, przewidywalną ilość pamięci pod obciążeniem.

[PHP-FPM](http://php-fpm.org/) (FastCGI Process Manager) jest zazwyczaj używany aby NGINX mógł przetwarzać pliki PHP. W dzisiejszych czasach, PHP-FPM jest wbudowany w wszystkich dystrybucjach Linuxa posiadających PHP. Phalcon wraz z NGINX i PHP-FPM dostarcza potężny zestaw narzędzi, które zapewniają maksymalną wydajności dla aplikacji PHP.

<a name='nginx-phalcon-configuration'></a>

### Phalcon configuration

Poniżej prezentujemy proponowane konfiguracje, jakich możesz użyć do konfiguracji Nginx'a dla Phalcona:

<a name='nginx-phalcon-configuration-basic'></a>

#### Basic configuration

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

#### Document root

Najbardziej typowym przypadkiem jest aplikacja zainstalowana w dowolnym folderze znajdującym się w głównym katalogu witryny. W tym przypadku używamy dwóch plików `.htaccess`, pierwszego do ukrycia kodu aplikacjia i przekierowania wszystkich zapytań do głównego katalogu aplikacji (`public/`).

<h5 class='alert alert-warning'>Note that using <code>.htaccess</code> files requires your apache installation to have the <code>AllowOverride All</code> option set. </h5>

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

#### Apache configuration

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

#### Virtual Hosts

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

<a name='php-built-in'></a>

## Wbudowany serwer PHP

Możesz skorzystać z [wbudowanego w](http://php.net/manual/en/features.commandline.webserver.php) PHP serwera podczas tworzenia aplikacji. Aby uruchomić serwer:

```bash
php -S localhost:8000 -t /public
```

<a name='php-built-in-phalcon-configuration'></a>

### Phalcon configuration

Aby włączyć przepisywanie adresów którego Phalcon potrzebuje, możesz użyć następującego pliku routera (`.htrouter.php`):

```php
<?php

if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
    $_GET['_url'] = $_SERVER['REQUEST_URI'];
}

return false;
```

a następnie uruchomić serwer z katalogu głównego projektu poprzez:

```bash
php -S localhost:8000 -t /public .htrouter.php
```

Następnie otwórz w swojej przeglądarce http://localhost:8000/, aby sprawdzić, czy wszystko działa prawidłowo.