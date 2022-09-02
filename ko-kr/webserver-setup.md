---
layout: default
language: 'ko-kr'
version: '4.0'
title: '웹서버 설정'
keywords: 'web server, webserver, apache, nginx, lighttpd, xampp, wamp, cherokee, php built-in server'
---

# 웹서버 설정

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## 개요

Phalcon 어플리케이션의 라우팅 기능이 동작하도록 하려면, 웹 서버가 리다이렉트를 적절하게 처리할 수 있도록 설정이 필요합니다. 아래는 일반적으로 많이 쓰는 웹서버들의 경우 설정방법입니다.

## PHP 내장 웹서버

PHP 내장서버는 실제 운영 환경에서는 사용을 추천하지 않습니다. 하지만 개발목적으로는 아주 쉽게 사용하실 수 있습니다. 문법은 다음과 같습니다:

```bash
$(which php) -S <host>:<port> -t <directory> <setup file>
```

어플리케이션의 진입점이 `/public/index.php` 이거나 [Phalcon 개발자도구](devtools)로 프로젝트를 생성하신 경우, 아래의 명령어로 웹서버를 시작하실 수 있습니다:

```bash
$(which php) -S localhost:8000 -t public .htrouter.php
```

The above command does:

- `$(which php)` - will insert the absolute path to your PHP binary
- `-S localhost:8000` - invokes server mode with the provided `host:port`
- `-t public` - defines the servers root directory, necessary for php to route requests to assets like JS, CSS, and images in your public directory
- `.htrouter.php` - the entry point that will be evaluated for each request

`.htrouter.php` 파일에는 반드시 다음의 내용이 있어야 합니다:

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

진입점이 `public/index.php` 가 아닌 경우, `.htrouter.php` 의 마지막 줄과 스크립트 호출부분을 그에 맞춰 적절하게 수정해 주세요. 원하시는 경우 포트나 바인딩되는 네트워크 인터페이스등을 변경하실 수 있습니다.

위의 명령어를 실행하신 후, 브라우저에서 `http://localhost:8000/` 로 가 보시면 사이트가 표시됩니다.

## PHP-FPM

[PHP-FPM](https://php.net/manual/en/install.fpm.php) (FastCGI Process Manager) 은 주로 PHP 파일 실행처리를 위해 사용되었습니다. 요즘은 리눅스 기반의 PHP 배포판에 PHP-FPM이 번들되어 배포됩니다.

**윈도우** 환경의 경우 PHP 배포판 아카이브에 PHP-FPM 이 있습니다. `php-cgi.exe` 파일은 프로세스를 시작하고 옵션을 설정하는데 사용할 수 있습니다. 윈도우는 유닉스 소켓을 지원하지 않기 때문에 이 스크립트는 `9000`번 포트에서 TCP모드로 fast-cgi를 시작해 줍니다.

아래의 내용으로 `php-fcgi.bat` 파일을 생성하세요:

```bat
@ECHO OFF
ECHO PHP FastCGI를 시작합니다...
set PATH=C:\PHP;%PATH%
c:\bin\RunHiddenConsole.exe C:\PHP\php-cgi.exe -b 127.0.0.1:9000
```

## nginx

[nginx](https://wiki.nginx.org/Main) 는 무료이며 오픈소스인 고성능의 HTTP서버이자 리버스프록시 이면서 동시에 IMAP/POP3 프록시 서버이기도 합니다. 전통적인 서버와 달리, Nginx는 쓰레드에 의존해서 요청을 처리하지 않습니다. 그 대신 훨씬 더 확장가능한 이벤트 기반(비동기적) 아키텍쳐를 사용하고 있습니다. 이 아키텍쳐는 작은 양의 메모리만 사용하는데, 그보다 중요한 것은 예측가능한 크기의 메모리를 사용한다는 것입니다.

Phalcon 은 Nginx, PHP-FPM 과 함께 사용함으로써 최고 성능의 PHP 어플리케이션을 만들 수 있는 강력한 도구들을 제공합니다.

### nginx 설치

[nginx 공식 사이트](https://www.nginx.com/resources/wiki/start/topics/tutorials/install/)

### Phalcon 설정

nginx에서 Phalcon을 사용하시려면 다음의 설정 예를 참고하세요:

    server {
        # 80번 포트를 사용하려면 nginx를 루트권한으로 시작해야 합니다
        # nginx 설치한 방식에 따라 `sudo` 로 서버를 시작해야 할 수 있습니다.
        # 1000번 근처부터는 루트권한이 필요 없습니다.
        # listen      80;
    
        listen        8000;
        server_name   default;
    
        ##########################
        # 운영환경에서는 SSL이 필요합니다
        # listen 443 ssl default_server;
    
        # ssl on;
        # ssl_session_timeout  5m;
        # ssl_protocols  SSLv2 SSLv3 TLSv1;
        # ssl_ciphers  ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:+SSLv2:+EXP;
        # ssl_prefer_server_ciphers   on;
    
        # 아래의 경로는 인증서 저장위치에 따라 달라집니다
        # ssl_certificate        /var/nginx/certs/default.cert;
        # ssl_certificate_key    /var/nginx/certs/default.key;
        ##########################
    
        # index.php 파일이 존재하는 폴더
        root /var/www/default/public;
        index index.php index.html index.htm;
    
        charset utf-8;
        client_max_body_size 100M;
        fastcgi_read_timeout 1800;
    
        # 도메인의 루트경로를 기술합니다
        # https://localhost:8000/[index.php]
        location / {
            # Matches URLS `$_GET['_url']`
            try_files $uri $uri/ /index.php?_url=$uri&$args;
        }
    
        # HTTP요청이 위와 매치되지 않으면서
        # 파일 명이 .php 로 끝날때
        location ~ [^/]\.php(/|$) {
            # try_files $uri =404;
    
            # Ubuntu & PHP7.0-fpm 환경에서 소켓모드
            # 이 경로는 PHP 설치 버전에 따라 달라짐
            fastcgi_pass  unix:/var/run/php/php7.0-fpm.sock;
    
    
            # PHP-FPM을 TCP모드에서 사용할 수도 있습니다( 윈도우에서는 필수)
            # 이 경우 FPM이 표준 포트를 읽도록(listen) 설정해야 합니다.
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
    

### 시작

nginx 를 시작하는 명령어는 시스템에 따라 달라질 수 있습니다:

```bash
start nginx
/etc/init.d/nginx start
service nginx start
```

## Apache

[Apache](https://httpd.apache.org/) 다양한 플랫폼을 지원하는 인기있고 잘 알려진 웹서버입니다.

### Phalcon 설정

다음은 Apache에서 Phalcon을 사용하는 경우 참고하실 수 있는 설정입니다 이 섹션은 friendly URLs 와 [라우터 콤포넌트](routing)를 사용하기 위한 `mod_rewrite` 모듈의 설정에 대해 주로 다루고 있습니다. 어플리케이션을 위한 일반적인 디렉토리 구조는 다음과 같습니다:

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

**Document root** 어플리케이션을 document root 아래에 설치하는 것이 가장 일반적인 케이스이지요. 그런 경우, `.htaccess` 파일을 이용할 수 있습니다. 첫번째. htaccess파일은 모든 요청을 어플리케이션의 document root(`public/`) 로 포워딩시켜 어플리케이션 코드를 감추는데 사용합니다.

> **주의**: 설치된 apache 에 `AllowOverride All` 옵션이 설정되어 있어야 `.htaccess` 파일을 사용할 수 있습니다.
 {: .alert .alert-warning}

# tutorial/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule   ^$ public/    [L]
        RewriteRule   ((?s).*) public/$1 [L]
    </IfModule>
    

두번째 `.htaccess` 파일은 `public/` 디렉토리에 존재하며, 모든 URI를 `public/index.php` 파일로 re-write 합니다:

    # tutorial/public/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond   %{REQUEST_FILENAME} !-d
        RewriteCond   %{REQUEST_FILENAME} !-f
        RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>
    

**International Characters** uri 파라미터에 페르시아 문자인 'م' (meem) 을 사용하는 사용자의 경우, `mod_rewrite` 사용에 문제가 발생합니다. 영문자 처럼 매칭이 잘 동작하도록 하기 위해서는, `.htaccess` 파일의 수정이 필요합니다:

    # tutorial/public/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond   %{REQUEST_FILENAME} !-d
        RewriteCond   %{REQUEST_FILENAME} !-f
        RewriteRule   ^([0-9A-Za-z\x7f-\xff]*)$ index.php?params=$1 [L]
    </IfModule>
    

uri가 영어 이외의 문자를 포함하는 경우, `mod_rewrite`가 정확하게 라우트를 매칭시키기 위해서는 위의 코드를 참고해서 해당문자에 맞게 적용시켜야 할 수 있습니다.

#### Apache 설정

`.htaccess` 파일을 사용하고 싶지 않으시다면, 관련 설정을 apache의 메인 설정파일에 넣으셔도 됩니다:

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
    

#### 가상 호스트

어플리케이션을 가상호스트에 설치하실 때 아래의 설정을 참조하세요:

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
    

## Lighttpd

[lighttpd](https://redmine.lighttpd.net/) (pronounced "lighty") is an open-source web server optimized for speed-critical environments while remaining standards-compliant, secure and flexible. It was originally written by Jan Kneschke as a proof-of-concept of the c10k problem – how to handle 10,000 connections in parallel on one server, but has gained worldwide popularity. Its name is a portmanteau of "light" and "httpd".

### Install lighttpd

[lighttpd Official Site](https://redmine.lighttpd.net/projects/lighttpd/wiki/GetLighttpd)

You can use following potencial configuration to setup lighttpd with Phalcon:

```nginx
server.modules = (
        "mod_indexfile",
        "mod_access",
        "mod_alias",
        "mod_redirect",
        "mod_rewrite",
)

server.document-root        = "/var/www/html/public"
server.upload-dirs          = ( "/var/cache/lighttpd/uploads" )
server.errorlog             = "/var/log/lighttpd/error.log"
server.pid-file             = "/var/run/lighttpd.pid"
server.username             = "www-data"
server.groupname            = "www-data"
server.port                 = 80

# strict parsing and normalization of URL for consistency and security
# https://redmine.lighttpd.net/projects/lighttpd/wiki/Server_http-parseoptsDetails
# (might need to explicitly set "url-path-2f-decode" = "disable"
#  if a specific application is encoding URLs inside url-path)
server.http-parseopts = (
  "header-strict"           => "enable",# default
  "host-strict"             => "enable",# default
  "host-normalize"          => "enable",# default
  "url-normalize-unreserved"=> "enable",# recommended highly
  "url-normalize-required"  => "enable",# recommended
  "url-ctrls-reject"        => "enable",# recommended
  "url-path-2f-decode"      => "enable",# recommended highly (unless breaks app)
 #"url-path-2f-reject"      => "enable",
  "url-path-dotseg-remove"  => "enable",# recommended highly (unless breaks app)
 #"url-path-dotseg-reject"  => "enable",
 #"url-query-20-plus"       => "enable",# consistency in query string
)

index-file.names            = ( "index.php", "index.html" )
url.access-deny             = ( "~", ".inc" )
static-file.exclude-extensions = ( ".php", ".pl", ".fcgi" )

compress.cache-dir          = "/var/cache/lighttpd/compress/"
compress.filetype           = ( "application/javascript", "text/css", "text/html", "text/plain" )

# default listening port for IPv6 falls back to the IPv4 port
include_shell "/usr/share/lighttpd/use-ipv6.pl " + server.port
include_shell "/usr/share/lighttpd/create-mime.conf.pl"
include "/etc/lighttpd/conf-enabled/*.conf"

#server.compat-module-load   = "disable"
server.modules += (
        "mod_compress",
        "mod_dirlisting",
        "mod_staticfile",
)

url.rewrite-once = ( "^(/(?!(favicon.ico$|css/|js/|img/)).*)" => "/index.php?_url=$1" )
# or
#url.rewrite-if-not-file = ( "/" => "/index.php?_rl=$1" )
```

## WAMP

[WampServer](https://www.wampserver.com/en/) is a Windows web development environment. It allows you to create web applications with Apache2, PHP and a MySQL database. Below are detailed instructions on how to install Phalcon on WampServer for Windows. Using the latest WampServer version is highly recommended.

> **주의** v4 버전부터는, PECL을 통해 `PSR`을 설치하셔야 합니다. [이 URL](https://pecl.php.net/package/psr/0.7.0/windows)에 방문하셔서 Phalcon의 DLL 설치와 같은 방법으로 DLL을 받으실 수 있습니다.
{: .alert .alert-warning }

> 
> **주의** 이 가이드 상에서의 경로는 WAMP 설치하신 것에 맞춘 상대경로로 확인하셔야 합니다
{: .alert .alert-warning }

### Phalcon 다운로드

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

```ini
 extension=php_phalcon.dll
```

and save it.

![](/assets/images/content/webserver-wamp-phalcon-php-ini.png)

Also edit the `php.ini` file, which is located at `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. Append at the end of the file:

```ini
extension=php_phalcon.dll 
```

and save it.

> **주의**: 웹서버로 사용하는 apache 설치방식에 따라 경로는 달라질 수 있습니다. 감안해서 파일을 찾아 수정해주세요.
{: .alert .alert-warning }

> 
> **주의**: 위에서 언급한 바와 같이 `PSR` 익스텐션의 설치가 필요하며 이 익스텐션은 Phalcon이 로드되기 전에 로드되어야 합니다. 위의 이미지에 나타난 것 처럼 Phalcon 관련 줄 윗쪽에`extension=php_psr.dll` 줄이 위치해야 합니다.
{: .alert .alert-warning }

![](/assets/images/content/webserver-wamp-apache-phalcon-php-ini.png)

Restart the Apache Web Server. Do a single click on the WampServer icon at system tray. Choose `Restart All Services` from the pop-up menu. Check out that tray icon will become green again.

![](/assets/images/content/webserver-wamp-manager.png)

Open your browser to navigate to https://localhost. The WAMP welcome page will appear. Check the section `extensions loaded` to ensure that Phalcon was loaded.

![](/assets/images/content/webserver-wamp-phalcon.png)

> **축하합니다! 이제 Phalcon 과 함께 phlying 하고 계시네요.**
{: .alert .alert-info }

## XAMPP

[XAMPP](https://www.apachefriends.org/download.html) is an easy to install Apache distribution containing MySQL, PHP and Perl. Once you download XAMPP, all you have to do is extract it and start using it. Below are detailed instructions on how to install Phalcon on XAMPP for Windows. Using the latest XAMPP version is highly recommended.

> **주의** v4 버전부터는, PECL을 통해 `PSR`을 설치하셔야 합니다. [이 URL](https://pecl.php.net/package/psr/0.7.0/windows)에 방문하셔서 Phalcon의 DLL 설치와 같은 방법으로 DLL을 받으실 수 있습니다.
{: .alert .alert-warning }

> 
> **주의** 이 가이드 상에서의 경로는 WAMP 설치하신 것에 맞춘 상대경로로 확인하셔야 합니다
{: .alert .alert-warning }

### Phalcon 다운로드

For Phalcon to work on Windows, you must install the correct version that matches your architecture and extension built. Load up the `phpinfo` page provided by XAMPP:

![](/assets/images/content/webserver-architecture.png)

Check the `Architecture` and `Extension Build` values. Those will allow you to download the correct DLL. In the above example you should download the file:

    phalcon_x86_vc15_php7.2_4.0.0+4237.zip
    

which will match `x86`, `vc15` and `TS` which is *Thread Safe*. If your system reports `NTS` (*Non Thread Safe*) then you should download that DLL.

Notice that XAMPP offers both 32 and 64 bit versions of Apache and PHP (5.6+): Phalcon has dlls for both, just choose the right dll for the installed version.

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

> **주의**: 위에서 언급한 바와 같이 `PSR` 익스텐션의 설치가 필요하며 이 익스텐션은 Phalcon이 로드되기 전에 로드되어야 합니다. 위의 이미지에 나타난 것 처럼 Phalcon 관련 줄 윗쪽에`extension=php_psr.dll` 줄이 위치해야 합니다.
{: .alert .alert-warning }

![](/assets/images/content/webserver-xampp-phalcon-php-ini.png)

Restart the Apache Web Server from the XAMPP Control Center. This will load the new PHP configuration. Open your browser to navigate to `https://localhost`. The XAMPP welcome page will appear. Click on the link `phpinfo()`.

![](/assets/images/content/webserver-xampp-phpinfo.png)

[phpinfo](https://php.net/manual/en/function.phpinfo.php) will output a significant amount of information on screen about the current state of PHP. Scroll down to check if the Phalcon extension has been loaded correctly.

![](/assets/images/content/webserver-xampp-phpinfo-phalcon.png)

> **축하합니다! 이제 Phalcon 과 함께 phlying 하고 계시네요.**
{: .alert .alert-info }


## Cherokee

[Cherokee](https://www.cherokee-project.com/) is a high-performance web server. It is very fast, flexible and easy to configure.

### Phalcon 설정

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
