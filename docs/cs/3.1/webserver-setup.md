<div class='article-menu'>
  <ul>
    <li>
      <a href="#setup">Nastavení webserveru</a> <ul>
        <li>
          <a href="#nginx">Nginx</a> <ul>
            <li>
              <a href="#nginx-phalcon-configuration">Konfigurace Phalcon frameworku</a> <ul>
                <li>
                  <a href="#nginx-phalcon-configuration-basic">Základní konfigurace</a>
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
          <a href="#cherokee">Cherokee</a> <ul>
            <li>
              <a href="#cherokee-phalcon-configuration">Phalcon configuration</a>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#php-built-in">Vestavěný webserver v PHP</a> <ul>
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

Aby routování v aplikaci postavené na Phalcon frameworku fungovalo správně, musíte nastavit Vaš webserver aby správně zpracovával přesměrování a požadavky. Instrukce pro oblíbené webservery jsou:

<a name='nginx'></a>

## Nginx

[Nginx](http://wiki.nginx.org/Main) je bezplatný, s otevřeným zdrojovým kódem, vysoce výkonný HTTP server a reverzní proxy a také IMAP/POP3 proxy server. Oproti tradičním serverům, Nginx nezávisí na vláknech pro zpracování požadavků. Místo toho používá mnohem více škálovatelnou event-driven (asynchroní) architekturu. Tato architektura používá malé, ale více důležíté, předvídatelné množství paměti.

Pro zpracování PHP souborů se Nginx obvykle používá v kombinaci s [PHP-FMP](http://php-fpm.org/) (FastCGI Process Manager). V dnešní době je PHP-FPM součástí všech distribucí PHP pro Linuxové systémy. Phalcon framework společně s Nginx a PHP-FPM nabízí mocnou sadu nástrojů, která nabízí maximální výkon pro Vaše PHP aplikace.

<a name='nginx-phalcon-configuration'></a>

### Phalcon configuration

Níže jsou uvedeny potenciální konfigurace, které můžete použít pro nastavení Nginx a Phalcon frameworku:

<a name='nginx-phalcon-configuration-basic'></a>

#### Basic configuration

Použítí `$_GET['_url']` jako zdroj URI:

```nginx
server {
    listen      80;
    server_name localhost.dev;

    # V této složce je umístěn soubor index.php
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

Použítí `$_SERVER['REQUEST_URI']` jako zdroj URI:

```nginx
server {
    listen      80;
    server_name localhost.dev;

    # V této složce je umístěn soubor index.php
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

<h5 class='alert alert-warning'>Note that using <code>.htaccess</code> files requires your apache installation to have the <code>AllowOverride All</code> option set. </h5>

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

#### Apache configuration

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

#### Virtual Hosts

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

<a name='php-built-in'></a>

## Vestavěný webserver v PHP

Můžete použít [vestavěný](http://php.net/manual/en/features.commandline.webserver.php) webserver pro svůj vývoj. Pro spuštění webserveru napište do konzole (Windows: Aplikace Příkazový řádek, Linux, Mac: aplikace Terminal):

```bash
php -S localhost:8000 -t /public
```

<a name='php-built-in-phalcon-configuration'></a>

### Phalcon configuration

Pro povolení přepisů URI, které Phalcon framework potřebuje, můžete použít soubor pro router (`.htrouter.php`):

```php
<?php

if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
    $_GET['_url'] = $_SERVER['REQUEST_URI'];
}

return false;
```

a poté spusťte webserver ze základního adresáře projektu pomocí:

```bash
php -S localhost:8000 -t /public .htrouter.php
```

Otevřete internetový prohlížeč a do řádku adresy napište: http://localhost:8000/ pro kontrolu že vše funguje jak má.