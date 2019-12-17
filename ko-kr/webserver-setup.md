---
layout: default
language: 'ko-kr'
version: '4.0'
title: '웹서버 설정'
keywords: 'web server, webserver, apache, nginx, xampp, wamp, cherokee, php built-in server, 웹서버, 서버'
---

# 웹서버 설정

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 개요

Phalcon 어플리케이션의 라우팅 기능이 동작하도록 하려면, 웹 서버가 리다이렉트를 적절하게 처리할 수 있도록 설정이 필요합니다. 아래는 일반적으로 많이 쓰는 웹서버들의 경우 설정방법입니다.

## PHP 내장 웹서버

The PHP built-in web server is not recommended for production applications. 하지만 개발목적으로는 아주 쉽게 사용하실 수 있습니다. 문법은 다음과 같습니다:

```bash
$(which php) -S <host>:<port> -t <directory> <setup file>
```

어플리케이션의 진입점이 `/public/index.php` 이거나 [Phalcon 개발자도구](devtools)로 프로젝트를 생성하신 경우, 아래의 명령어로 웹서버를 시작하실 수 있습니다:

```bash
$(which php) -S localhost:8000 -t public .htrouter.php
```

위의 명령어는 다음의 기능을 수행합니다: - `$(which php)` - PHP 바이너리에 대한 절대경로 - `-S localhost:8000` - `host:port` 로 서버모드 실행 - `-t public` - 서버의 루트디렉토리를 지정. 공개 디렉토리에 있는 JS, CSS, 이미지 파일같은 자원에 대한 클라이언트 요청을 php가 라우팅하기 위해 필요 - `.htrouter.php` - 각각의 요청을 처리하는 진입점

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

[nginx](https://wiki.nginx.org/Main) is a free, open-source, high-performance HTTP server and reverse proxy, as well as an IMAP/POP3 proxy server. Unlike traditional servers, nginx doesn't rely on threads to handle requests. 그 대신 훨씬 더 확장가능한 이벤트 기반(비동기적) 아키텍쳐를 사용하고 있습니다. 이 아키텍쳐는 작은 양의 메모리만 사용하는데, 그보다 중요한 것은 예측가능한 크기의 메모리를 사용한다는 것입니다.

Phalcon with nginx and PHP-FPM provide a powerful set of tools that offer maximum performance for your PHP applications.

### Install nginx

[nginx Official Site](https://www.nginx.com/resources/wiki/start/topics/tutorials/install/)

### Phalcon 설정

You can use following potential configuration to setup nginx with Phalcon:

    server {
        # Port 80 will require nginx to be started with root permissions
        # Depending on how you install nginx to use port 80 you will need
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
        # https://localhost:8000/[index.php]
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
    

### 시작

Depending on your system, the command to start nginx could be one of the following:

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
    

## WAMP

[WampServer](http://www.wampserver.com/en/) 는 윈도우용 웹 개발환경입니다. 이 환경을 이용해서 Apache2, PHP 와 MySQL 데이터베이스를 이용해서 웹 어플리케이션을 개발하실 수 있습니다. 다음은 WampServer 에서 Phalcon을 설치하는 방법에 대한 상세한 설명입니다. 최신버전 WampServer 사용을 강력히 권고드립니다.

> **주의** v4 버전부터는, PECL을 통해 `PSR`을 설치하셔야 합니다. [이 URL](https://pecl.php.net/package/psr/0.7.0/windows)에 방문하셔서 Phalcon의 DLL 설치와 같은 방법으로 DLL을 받으실 수 있습니다.
{: .alert .alert-warning }

> 
> **주의** 이 가이드 상에서의 경로는 WAMP 설치하신 것에 맞춘 상대경로로 확인하셔야 합니다
{: .alert .alert-warning }

### Phalcon 다운로드

Phalcon이 윈도우에서 동작하려면, 시스템의 아키텍처에 맞는 버전의 빌드된 익스텐션을 설치하셔야 합니다. WAMP에서 제공하는 `phpinfo` 페이지를 로드하세요:

![](/assets/images/content/webserver-architecture.png)

`Architecture` 와 `Extension Build` 값을 확인하세요. 그 값 기준으로 호환되는 DLL파일을 다운로드 받으실 수 있습니다. 위의 예시를 기준으로 보면 다음의 파일을 다운로드 해야 합니다:

    phalcon_x86_vc15_php7.2_4.0.0+4237.zip
    

`x86`, `vc15` 이면서 `TS` 즉, *Thread Safe(다중스레드지원)*인 조건에 맞는 파일입니다. 시스템에서 `NTS` (*Non Thread Safe(단일스레드지원)*) 로 나온다면 그에 맞는 DLL을 내려받아야 하겠죠.

WAMP는 32bit와 64bit 버전이 있습니다. From the download section, you can download the Phalcon DLL that suits your WAMP installation.

Phalcon 라이브러리를 다운로드 하시면 아래에 보시는 것과 비슷한 zip 파일이 있을겁니다:

![](/assets/images/content/webserver-zip-icon.png)

압축파일을 해제하시면 Phalcon DLL 파일이 있을겁니다:

![](/assets/images/content/webserver-extracted-dlls.png)

`php_phalcon.dll` 파일을 PHP 의 extensions 폴더로 복사하세요. WAMP가 `C:\wamp` 폴더에 설치되어 있는 경우, 익스텐션은 `C:\wamp\bin\php\php7.2.18\ext` 폴더에 있어야 합니다. (WAMP 설치시 설치된 PHP버전이 7.2.18이라고 가정).

![](/assets/images/content/webserver-wamp-phalcon-psr-ext-folder.png)

`php.ini` 파일을 수정하세요. 이 파일은 `C:\wamp\bin\php\php7.2.18\php.ini` 에 있습니다. 메모장이나 기타 텍스트편집 프로그램으로 수정하실 수 있습니다. 줄바꿈 문제를 겪지 않으시려면 Notepad++ 사용을 추천합니다. 파일의 제일 아랫쪽에 추가해주세요:

```ini extension=php_phalcon.dll

    <br />그리고 저장해주세요.
    
    ![](/assets/images/content/webserver-wamp-phalcon-php-ini.png)
    
    `C:\wamp\bin\apache\apache2.4.9\bin\php.ini` 에 있는 `php.ini` 파일도 동일한 수정이 필요합니다. 파일 제일 아랫쪽에 추가: 
    
    ```ini
    extension=php_phalcon.dll 
    

그리고 저장해주세요.

> **주의**: 웹서버로 사용하는 apache 설치방식에 따라 경로는 달라질 수 있습니다. 감안해서 파일을 찾아 수정해주세요.
{: .alert .alert-warning }

> 
> **주의**: 위에서 언급한 바와 같이 `PSR` 익스텐션의 설치가 필요하며 이 익스텐션은 Phalcon이 로드되기 전에 로드되어야 합니다. 위의 이미지에 나타난 것 처럼 Phalcon 관련 줄 윗쪽에`extension=php_psr.dll` 줄이 위치해야 합니다.
{: .alert .alert-warning }

![](/assets/images/content/webserver-wamp-apache-phalcon-php-ini.png)

Apache 웹 서버를 재시작 하세요. 시스템 트레이에 있는 WampServer 아이콘을 클릭. 팝업 메뉴에서 `Restart All Services` 를 선택. 트레이 아이콘이 다시 녹색으로 바뀌는지 확인.

![](/assets/images/content/webserver-wamp-manager.png)

브라우저를 실행해서 주소창에 https://localhost 입력 후 엔터 WAMP 의 환영페이지가 나타날 것입니다. `extensions loaded` 섹션에서 Phalcon이 정상적으로 로드되었는지 확인해주세요.

![](/assets/images/content/webserver-wamp-phalcon.png)

> **축하합니다! 이제 Phalcon 과 함께 phlying 하고 계시네요.**
{: .alert .alert-info }

## XAMPP

[XAMPP](https://www.apachefriends.org/download.html) 는 MYSQL,PHP와 Perl이 포함된, 쉽게 설치할 수 있는 Apache 배포판입니다. XAMPP를 다운로드 하신 후, 압축을 풀고 그냥 사용하시면 됩니다. 아래는 윈도우 에서 돌아가는 XAMPP 상에서 Phalcon을 설치하는 방법에 대한 자세한 안내입니다. 최신버전의 XAMPP를 사용하시기를 강력히 권해 드립니다.

> **주의** v4 버전부터는, PECL을 통해 `PSR`을 설치하셔야 합니다. [이 URL](https://pecl.php.net/package/psr/0.7.0/windows)에 방문하셔서 Phalcon의 DLL 설치와 같은 방법으로 DLL을 받으실 수 있습니다.
{: .alert .alert-warning }

> 
> **주의** 이 가이드 상에서의 경로는 WAMP 설치하신 것에 맞춘 상대경로로 확인하셔야 합니다
{: .alert .alert-warning }

### Phalcon 다운로드

Phalcon이 윈도우에서 동작하려면, 시스템의 아키텍처에 맞는 버전의 빌드된 익스텐션을 설치하셔야 합니다. WAMP에서 제공하는 `phpinfo` 페이지를 로드하세요:

![](/assets/images/content/webserver-architecture.png)

`Architecture` 와 `Extension Build` 값을 확인하세요. 그 값 기준으로 호환되는 DLL파일을 다운로드 받으실 수 있습니다. 위의 예시를 기준으로 보면 다음의 파일을 다운로드 해야 합니다:

    phalcon_x86_vc15_php7.2_4.0.0+4237.zip
    

`x86`, `vc15` 이면서 `TS` 즉, *Thread Safe(다중스레드지원)*인 조건에 맞는 파일입니다. 시스템에서 `NTS` (*Non Thread Safe(단일스레드지원)*) 로 나온다면 그에 맞는 DLL을 내려받아야 하겠죠.

XAMPP 항상 32 bit 버전의 Apache와 PHP를 릴리즈합니다. 다운로드 섹션에서 x86버전의 윈도우용 Phalcon을 다운로드 받으셔야 합니다.

Phalcon 라이브러리를 다운로드 하시면 아래에 보시는 것과 비슷한 zip 파일이 있을겁니다:

![](/assets/images/content/webserver-zip-icon.png)

압축파일을 해제하시면 Phalcon DLL 파일이 있을겁니다:

![](/assets/images/content/webserver-extracted-dlls.png)

`php_phalcon.dll` 파일을 PHP 익스텐션 디렉토리로 복사하세요. XAMPP를 `C:\xampp` 폴더에 설치하신 경우 익스텐션은`C:\xampp\php\ext` 폴더에 들어가야 합니다.

![](/assets/images/content/webserver-xampp-phalcon-psr-ext-folder.png)

`C:\xampp\php\php.ini` 에 있는 `php.ini` 파일을 편집하세요. 메모장이나 기타 텍스트편집 프로그램으로 수정하실 수 있습니다. 줄바꿈관련 문제를 겪지 않으려면 [Notepad++](https://notepad-plus-plus.org/) 프로그램 이용을 추천합니다. 파일의 제일 아랫쪽에 추가해주세요:

```ini
extension=php_phalcon.dll
```

그리고 저장해주세요.

> **주의**: 위에서 언급한 바와 같이 `PSR` 익스텐션의 설치가 필요하며 이 익스텐션은 Phalcon이 로드되기 전에 로드되어야 합니다. 위의 이미지에 나타난 것 처럼 Phalcon 관련 줄 윗쪽에`extension=php_psr.dll` 줄이 위치해야 합니다.
{: .alert .alert-warning }

![](/assets/images/content/webserver-xampp-phalcon-php-ini.png)

XAMPP 컨트롤센터에서 Apache 웹서버를 재시작 해주세요. 재시작 하면 변경된 PHP 설정을 읽어들입니다. 브라우저를 실행해서 주소창에 `https://localhost` 입력 후 엔터 XAMPP 환영 페이지가 나타날 것입니다. `phpinfo()` 링크를 클릭하세요.

![](/assets/images/content/webserver-xampp-phpinfo.png)

[phpinfo](https://php.net/manual/en/function.phpinfo.php) 는 현재 PHP이 상태에 대한 엄청난 양의 정보를 표시할 것입니다. Phalcon익스텐션이 정상적으로 로드되었는지 아래로 스크롤 해서 확인해주세요.

![](/assets/images/content/webserver-xampp-phpinfo-phalcon.png)

> **축하합니다! 이제 Phalcon 과 함께 phlying 하고 계시네요.**
{: .alert .alert-info }


## Cherokee

[Cherokee](https://www.cherokee-project.com/) 는 고성능의 웹서버입니다. 매우 빠르고, 유연하며, 설정이 쉽습니다.

### Phalcon 설정

Cherokee 는 웹서버에서 가능한 거의 모든 값을 설정 할 수 있도록 친숙한 그래픽 UI를 제공합니다.

`/path-to-cherokee/sbin/cherokee-admin` 를 root 권한으로 실행해서 cherokee 관리자를 시작합니다

![](/assets/images/content/webserver-cherokee-1.jpg)

`vServers`를 클릭해서 새로운 가상호스트를 생성한 후, 새로운 가상서버를 생성하세요:

![](/assets/images/content/webserver-cherokee-2.jpg)

가장 최근에 추가된 가상 서버가 화면 좌측 바에 나타날 것입니다. `Behaviors`탭에서는 가상서버의 동작에 대한 기본값들을 확인하실 수 있습니다. `Rule Management`버튼을 클릭하세요. `Directory /cherokee_themes` 부분과 `Directory /icons` 부분을 삭제하세요:

![](/assets/images/content/webserver-cherokee-3.jpg)

마법사를 이용해서 `PHP Language` behavior를 추가하세요. 이 behavior값이 PHP어플리케이션이 동작하도록 해줍니다:

![](/assets/images/content/webserver-cherokee-1.jpg)

일반적으로 이 behavior는 추가적인 설정을 할 필요는 없습니다. 이번에는 `Manual Configuration`섹션에 다른 behavior를 추가합시다. `Rule Type` 부분에서 `File Exists`를 선택하신 후, `Match any file` 옵션이 활성화 되도록 해주세요:

![](/assets/images/content/webserver-cherokee-5.jpg)

`Handler` 탭에서 핸들러로 `List & Send`를 선택하세요:

![](/assets/images/content/webserver-cherokee-7.jpg)

`Default` behavior 를 수정해서 URL-rewrite 엔진을 활성화 합니다. `Redirection` 을 핸들러로 선택한 후, 엔진에 다음의 정규식을 추가해 주세요 `^(.*)$`:

![](/assets/images/content/webserver-cherokee-6.jpg)

마지막으로, behaviors가 다음의 순서대로 되어있는지 확인해 주세요:

![](/assets/images/content/webserver-cherokee-8.jpg)

브라우저에서 어플리케이션을 실행해주세요

![](/assets/images/content/webserver-cherokee-9.jpg)