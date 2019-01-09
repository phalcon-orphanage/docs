* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='setup'></a>

# Web Server Setup

In order for the routing of the Phalcon application to work, you will need to set up your web server to process the redirects properly. Setup instructions for popular web servers are:

<a name='php-fpm'></a>

## PHP-FPM

The [PHP-FPM](http://php.net/manual/en/install.fpm.php) (FastCGI Process Manager) is usually used to allow the processing of PHP files. 現在では、PHP-FPMは全てのLinuxベースのPHPディストリビューションに含まれています。

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

If you created your application with [Phalcon-Devtools](/3.4/en/devtools-installation) this file should already exist in the root directory of your project and you can start the server with the following command:

```bash
$(which php) -S localhost:8000 -t public .htrouter.php
```

上記のコマンドの構造:

- `$(which php)` - phpコマンドのパスを先頭に追加
- `-S localhost:8000` - `host:port` でサーバーモードを実行
- `-t public` - サーバーのルートディレクトリを指定、公開用ディレクトリにあるJS, CSS, 画像へのリクエストをPHPにルーティングさせるのに必要
- `.htrouter.php` - リクエストごとに評価させるエントリポイント

ブラウザで http://localhost:8000/ を開き、すべてが動作していることを確認します。

<a name='nginx'></a>

## Nginx

[Nginx](http://wiki.nginx.org/Main) is a free, open-source, high-performance HTTP server and reverse proxy, as well as an IMAP/POP3 proxy server. Unlike traditional servers, Nginx doesn't rely on threads to handle requests. Instead it uses a much more scalable event-driven (asynchronous) architecture. このアーキテクチャは、ロードするメモリ量を抑えます。しかしより重要なことは、メモリ量を予測できることです。

Nginx と PHP-FPM と Phalcon のパワフルなセットは、PHP アプリケーションの最高のパフォーマンスを提供します。

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

[Apache](http://httpd.apache.org/) は有名でよく知られたWEBサーバーで、多くのプラットフォームで利用可能です。

<a name='apache-phalcon-configuration'></a>

### Phalcon configuration

Phalcon と Apache を使用する、よくある構成を次に示します。 These notes are primarily focused on the configuration of the `mod_rewrite` module allowing to use friendly URLs and the [router component](/3.4/en/routing). 一般的にアプリケーションは次の構造になります。

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

#### ドキュメントルート

ここでは、最も一般的なケースとして、アプリケーションがドキュメントのルートの下の任意のディレクトリにインストールされています。 この場合、`.htaccess`ファイルを2つ使います。最初の一つはそのアプリケーションのドキュメントルート (`public/`) への全てのアプリケーションのフォーワーディングからアプリケーションのコードを隠します。

##### Note that using `.htaccess` files requires your apache installation to have the `AllowOverride All` option set. {.alert.alert-warning}

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

For users that are using the Persian letter 'م' (meem) in uri parameters, there is an issue with `mod_rewrite`. To allow the matching to work as it does with English characters, you will need to change your `.htaccess` file:

```apacheconfig
# test/public/.htaccess

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^([0-9A-Za-z\x7f-\xff]*)$ index.php?params=$1 [L]
</IfModule>
```

If your uri contains characters other than English, you might need to resort to the above change to allow `mod_rewrite` to accurately match your route.

<a name='apache-apache-configuration'></a>

#### Apache の設定

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

[Cherokee](http://www.cherokee-project.com/) is a high-performance web server. It is very fast, flexible and easy to configure.

<a name='cherokee-phalcon-configuration'></a>

### Phalcon configuration

Cherokee を使うと、フレンドリーなGUIでWEBサーバーのほとんどを設定項目を設定できます。

最初に cherokee administratorをroot権限で実行します。 `/path-to-cherokee/sbin/cherokee-admin`

![](/assets/images/content/webserver-cherokee-1.jpg)

Create a new virtual host by clicking on `vServers`, then add a new virtual server:

![](/assets/images/content/webserver-cherokee-2.jpg)

最近追加したvirtual serverはスクリーンの左側に表示されます。 `Behaviors` タブで、このvirtual serverのデフォルトの振舞いの組合せを確認できます。 `Rule Management` ボタンをクリックします。 Remove those labeled as `Directory /cherokee_themes` and `Directory /icons`:

![](/assets/images/content/webserver-cherokee-3.jpg)

Add the `PHP Language` behavior using the wizard. This behavior allows you to run PHP applications:

![](/assets/images/content/webserver-cherokee-1.jpg)

通常、この振舞いは追加の設定を必要としません。 別の振舞いを追加します。今回は、`Manual Configuration`セクションです。 In `Rule Type` choose `File Exists`, then make sure the option `Match any file` is enabled:

![](/assets/images/content/webserver-cherokee-5.jpg)

In the 'Handler' tab choose `List & Send` as handler:

![](/assets/images/content/webserver-cherokee-7.jpg)

`Default`の振舞いを編集して、URL-rewrite エンジンを有効にします。 ハンドラを`Redirection`に変更し、それから次の正規表現をエンジンに追加します。`^(.*)$`:

![](/assets/images/content/webserver-cherokee-6.jpg)

Finally, make sure the behaviors have the following order:

![](/assets/images/content/webserver-cherokee-8.jpg)

Execute the application in a browser:

![](/assets/images/content/webserver-cherokee-9.jpg)