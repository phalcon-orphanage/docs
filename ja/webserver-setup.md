<div class='article-menu'>
  <ul>
    <li>
      <a href="#setup">Web Server Setup</a> <ul>
        <li>
          <a href="#nginx">Nginx</a> <ul>
            <li>
              <a href="#nginx-phalcon-configuration">Phalcon configuration</a> <ul>
                <li>
                  <a href="#nginx-phalcon-configuration-basic">基本構成</a>
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
                  <a href="#apache-document-root">ドキュメントルート</a>
                </li>
                <li>
                  <a href="#apache-apache-configuration">Apache の設定</a>
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
          <a href="#php-built-in">Web サーバーの構築</a> <ul>
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

[Nginx](http://wiki.nginx.org/Main) is a free, open-source, high-performance HTTP server and reverse proxy, as well as an IMAP/POP3 proxy server. Unlike traditional servers, Nginx doesn't rely on threads to handle requests. Instead it uses a much more scalable event-driven (asynchronous) architecture. このアーキテクチャは、ロードするメモリ量を抑えます。しかしより重要なことは、メモリ量を予測できることです。

The [PHP-FPM](http://php-fpm.org/) (FastCGI Process Manager) is usually used to allow Nginx to process PHP files. 現在では、PHP-FPMは全てのLinuxベースのPHPディストリビューションに含まれています。 Nginx と PHP-FPM と Phalcon のパワフルなセットは、PHP アプリケーションの最高のパフォーマンスを提供します。

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

[Apache](http://httpd.apache.org/) は有名でよく知られたWEBサーバーで、多くのプラットフォームで利用可能です。

<a name='apache-phalcon-configuration'></a>

### Phalcon configuration

Phalcon と Apache を使用する、よくある構成を次に示します。 ここでの注釈は主に`mod_rewrite` モジュールの設定にフォーカスしています。このモジュールはフレンドリーなURLや[router component](/[[language]]/[[version]]/routing)が使用できるように設定します。 一般的にアプリケーションは次の構造になります。

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

ここでは、最も一般的なケースとして、アプリケーションがドキュメントのルートの下の任意のディレクトリにインストールされています。 この場合、`.htaccess`ファイルを2つ使います。最初の一つはそのアプリケーションのドキュメントルート (`public/`) への全てのアプリケーションのフォーワーディングからアプリケーションのコードを隠します。

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

`.htaccess`ファイルを使用しない場合、これらの設定をApacheのメインの設定ファイルに移動してください。:

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

この 2 番目の構成では、Phalconアプリケーションをvirtual hostにインストールできます。

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

[Cherokee](http://www.cherokee-project.com/) は高性能のWEBSサーバーです。非常に高速で、フレキシブルで、設定が簡単です。

<a name='cherokee-phalcon-configuration'></a>

### Phalcon configuration

Cherokee を使うと、フレンドリーなGUIでWEBサーバーのほとんどを設定項目を設定できます。

最初に cherokee administratorをroot権限で実行します。 `/path-to-cherokee/sbin/cherokee-admin`

![](/images/content/webserver-cherokee-1.jpg)

Create a new virtual host by clicking on `vServers`, then add a new virtual server:

![](/images/content/webserver-cherokee-2.jpg)

最近追加したvirtual serverはスクリーンの左側に表示されます。 `Behaviors` タブで、このvirtual serverのデフォルトの振舞いの組合せを確認できます。 `Rule Management` ボタンをクリックします。 Remove those labeled as `Directory /cherokee_themes` and `Directory /icons`:

![](/images/content/webserver-cherokee-3.jpg)

Add the `PHP Language` behavior using the wizard. This behavior allows you to run PHP applications:

![](/images/content/webserver-cherokee-1.jpg)

通常、この振舞いは追加の設定を必要としません。 別の振舞いを追加します。今回は、`Manual Configuration`セクションです。 In `Rule Type` choose `File Exists`, then make sure the option `Match any file` is enabled:

![](/images/content/webserver-cherokee-5.jpg)

In the 'Handler' tab choose `List & Send` as handler:

![](/images/content/webserver-cherokee-7.jpg)

`Default`の振舞いを編集して、URL-rewrite エンジンを有効にします。 ハンドラを`Redirection`に変更し、それから次の正規表現をエンジンに追加します。`^(.*)$`:

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

ブラウザで http://localhost:8000/ を開き、すべてが動作していることを確認します。