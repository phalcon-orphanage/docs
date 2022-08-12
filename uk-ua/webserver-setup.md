---
layout: default
language: 'uk-ua'
version: '5.0'
title: 'Налаштування веб-сервера'
keywords: 'web server, webserver, apache, nginx, lighttpd, xampp, wamp, cherokee, php built-in server, веб-сервер, вебсервер'
---

# Налаштування веб-сервера
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Огляд
Для того, щоб забезпечити коректну роботу додатків, розроблених на Phalcon, потрібно налаштувати веб-сервер таким чином, щоб він належним чином здійснював переспрямування. Нижче наведені інструкції для популярних веб-серверів:

## Вбудований РНР
Використання вбудованого веб-сервера PHP не рекомендується для виробничих потреб. Однак, його зручно використовувати для розробки веб-продуктів. Синтаксис:

```bash
$(which php) -S <host>:<port> -t <directory> <setup file>
```

Якщо точка входу у ваш продукт знаходиться за адресою `/public/index.рhp` або ваш проєкт було створено за допомогою [Phalcon Dev](devtools), тоді ви можете запустити веб-сервер наступною командою:

```bash
$(which php) -S localhost:8000 -t public .htrouter.php
```

Ця команда виконує:

| Command             | Description                                                                                                                         |
| ------------------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| `$(which php)`      | will insert the absolute path to your PHP binary                                                                                    |
| `-S localhost:8000` | invokes server mode with the provided `host:port`                                                                                   |
| `-t public`         | defines the servers root directory, necessary for php to route requests to assets like JS, CSS, and images in your public directory |
| `.htrouter.php`     | the entry point that will be evaluated for each request                                                                             |

Файл `.htrouter.php` повинен містити:

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

Якщо ваша точка входу не знаходиться за адресою `public/index.php`, тоді налаштуйте `.htrouter.php` (останній рядок), таким чином, щоб цей скрипт переспрямовував запити безпосередньо на точку входу вашого продукту. Ви також можете змінити порт, якщо забажаєте, а також мережевий інтерфейс, до якого він приєднується.

After executing the command above, navigating to `http://localhost:8000/` will show your site.

## PHP-FPM
The [PHP-FPM][php_fpm] (FastCGI Process Manager) is usually used to allow the processing of PHP files. На сьогодні PHP-FPM входить до складу усіх PHP-дистрибутивів на базі Linux.

On **Windows** PHP-FPM is in the PHP distribution archive. Файл `php-cgi.exe` можна використовувати для запуску процесу і налаштування. Windows не підтримує unix сокети, тож цей скрипт запустить fast-cgi в режимі TCP на порту `9000`.

Створіть файл `php-fcgi.bat` з таким змістом:

```bat
@ECHO OFF
ECHO Starting PHP FastCGI...
set PATH=C:\PHP;%PATH%
c:\bin\RunHiddenConsole.exe C:\PHP\php-cgi.exe -b 127.0.0.1:9000
```

## nginx
[nginx][nginx] is a free, open-source, high-performance HTTP server and reverse proxy, as well as an IMAP/POP3 proxy server. На відміну від традиційних серверів, nginx не покладається на потоки для обробки запитів. Instead, it uses a much more scalable event-driven (asynchronous) architecture. Ця архітектура використовує невеликі, але що не менш важливо, передбачувані обсяги пам'яті під навантаженням.

Phalcon з nginx і PHP-FPM забезпечують потужний набір інструментів, які пропонують максимальну продуктивність для ваших PHP продуктів.

### Установка nginx
[Офіційний сайт nginx][nginx_installation]

### Конфігурація Phalcon
You can use following potential configuration to set up nginx with Phalcon:

```
server {
    # Порт 80 потребує старту nginx з root-правами
    # Залежно від того, як ви встановлюєте nginx, щоб використовувати порт 80 вам буде необхідно
    # стартувати сервер із `sudo`, порти порядку 1000 не потребують
    # root прав
    # слухаємо порт  80;

    listen        8000;
    server_name   default;

    ##########################
    # У виробництві вимагається використання SSL
    # listen 443 ssl default_server;

    # ssl on;
    # ssl_session_timeout  5m;
    # ssl_protocols  SSLv2 SSLv3 TLSv1;
    # ssl_ciphers  ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:+MEDIUM:+LOW:+SSLv2:+EXP;
    # ssl_prefer_server_ciphers   on;

    # Це розташування залежить від того, де ви зберігаєте свої сертифікати
    # ssl_certificate        /var/nginx/certs/default.cert;
    # ssl_certificate_key    /var/nginx/certs/default.key;
    ##########################

    # Це тека, де лежить index.php
    root /var/www/default/public;
    index index.php index.html index.htm;

    charset utf-8;
    client_max_body_size 100M;
    fastcgi_read_timeout 1800;

    # Є кореневим каталогом домена
    # https://localhost:8000/[index.php]
    location / {
        # Збігається з URL `$_GET['_url']`
        try_files $uri $uri/ /index.php?_url=$uri&$args;
    }

    # Коли запит HTTP не такий, як вище
    # а файл закінчується на .php
    location ~ [^/]\.php(/|$) {
        # try_files $uri =404;

        # Ubuntu та PHP7.0-fpm в режимі socket
        # Цей шлях залежить від версії встановленого PHP
        fastcgi_pass  unix:/var/run/php/php7.0-fpm.sock;


        # Якщо альтернативно ви використовуєте PHP-FPM в TCP режимі (вимагається у Windows)
        # Вам необхідно налаштувати FPM для прослуховування стандартного порта
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
        # та встановити php.ini cgi.fix_pathinfo=0

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

### Start
Залежно від вашої системи, команда для запуску nginx може бути однією з таких:

```bash
start nginx
/etc/init.d/nginx start
service nginx start
```

## Apache
[Apache][apache] is a popular and well known web server available on many platforms.

### Конфігурація Phalcon
The following are potential configurations you can use to set up Apache with Phalcon. Ці нотатки в основному зфокусовані на конфігурації модуля `mod_rewrite`, що дозволяє використовувати дружні URL і компонент [маршрутизатора](routing). Типова структура каталогів продукту:

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

**Document root** The most common case is for an application to be installed in a directory under the document root. У такому випадку ми можемо використовувати `.htaccess` файли.  Перший буде використаний для приховування коду продукта, переадресовуючи усі запити до кореневої теки продукта (`public/`).

> **NOTE**: Note that using `.htaccess` files requires your apache installation to have the `AllowOverride All` option set. 
> 
> {: .alert .alert-warning}

```
# tutorial/.htaccess

<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteRule   ^$ public/    [L]
    RewriteRule   ((?s).*) public/$1 [L]
</IfModule>
```

Другий файл `.htaccess` розташований в каталозі `public/` та переадресовує усі запити URI до файлу `public/index.php`:

```
# tutorial/public/.htaccess

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
</IfModule>
```

**International Characters** For users that are using the Persian letter 'م' (meem) in uri parameters, there is an issue with `mod_rewrite`. Щоб виправити проблему вам потрібно змінити ваш файл `.htaccess` наступним чином:

```
# tutorial/public/.htaccess

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond   %{REQUEST_FILENAME} !-d
    RewriteCond   %{REQUEST_FILENAME} !-f
    RewriteRule   ^([0-9A-Za-z\x7f-\xff]*)$ index.php?params=$1 [L]
</IfModule>
```

Якщо ваші URI містять символи, відмінні від латинських, може знадобитися здійснити вищевказані зміни, щоб дозволити `mod_rewrite` точного визначати ваші маршрути.

#### Налаштування Apache
Якщо ви не хочете використовувати `.htaccess` файли, ви можете перенести відповідні команди у головний файл конфігурації apache:

```
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
```

#### Віртуальні хости
Налаштування, зазначені нижче, призначені для установки власного продукту на віртуальний хост:

```
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
```

## Lighttpd

[lighttpd](https://redmine.lighttpd.net/) (звучить, як "lighty") є веб-сервером з відкритим вихідним кодом, оптимізованим для швидкісних критичних середовищ, при цьому відповідає стандартам, залишається безпечним та гнучким. Спочатку його було написано Яном Кнешке як концепт рішення проблеми c10k - як опрацювати 10 000 підключень паралельно на одному сервері, але отримав популярність по всьому світу. Його ім'я є поєднанням слів "light" та "httpd".

### Установка lighttpd

[Офіційний сайт lighttpd](https://redmine.lighttpd.net/projects/lighttpd/wiki/GetLighttpd)

You can use following potential configuration to set up lighttpd with Phalcon:

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

# чіткий парсинг та нормалізація URL для цілісності та безпеки
# https://redmine.lighttpd.net/projects/lighttpd/wiki/Server_http-parseoptsDetails
# (може потребувати явної установки "url-path-2f-decode" = "disable"
#якщо конкретний продукт кодує URLs всередині url-path)
server.http-parseopts = (
  "header-strict"           => "enable",# за замовчуванням
  "host-strict"             => "enable",# за замовчування
  "host-normalize"          => "enable",# за замовчування
  "url-normalize-unreserved"=> "enable",# дуже рекомендовано
  "url-normalize-required"  => "enable",# рекомендовано
  "url-ctrls-reject"        => "enable",# рекомендовано
  "url-path-2f-decode"      => "enable",# дуже рекомендовано (щоб запобігти зламу продукту)
 #"url-path-2f-reject"      => "enable",
  "url-path-dotseg-remove"  => "enable",# дуже рекомендовано (щоб запобігти зламу продукту)
 #"url-path-dotseg-reject"  => "enable",
 #"url-query-20-plus"       => "enable",# цілісність стрічки запиту
)

index-file.names            = ( "index.php", "index.html" )
url.access-deny             = ( "~", ".inc" )
static-file.exclude-extensions = ( ".php", ".pl", ".fcgi" )

compress.cache-dir          = "/var/cache/lighttpd/compress/"
compress.filetype           = ( "application/javascript", "text/css", "text/html", "text/plain" )

# прослуховування портів IPv6 за замовчуванням змінюється на порти IPv4
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
# або
#url.rewrite-if-not-file = ( "/" => "/index.php?_rl=$1" )
```

## WAMP
[WampServer][wamp] is a Windows web development environment. Він дозволяє створювати веб-додатки з використанням Apache2, PHP та баз даних MySQL. Нижче наведені детальні інструкції, як встановити Phalcon на WampServer для Windows. Використання останньої версії WampServer є дуже рекомендованим.

> **NOTE** Since v4, you must install the `PSR` extension from PECL. Відвідайте [цю URL-адресу](https://pecl.php.net/package/psr/0.7.0/windows), щоб отримати DLL і виконайте ті ж кроки для встановлення розширення, як і з DLL Phalcon. 
> 
> {: .alert .alert-warning }

> **NOTE** Paths in this guide should be relative, according to your installation WAMP 
> 
> {: .alert .alert-warning }

### Завантаження Phalcon
Для того, щоб Phalcon працював на Windows, вам потрібно встановити правильну версію, яка відповідає архітектурі та збірці вашого РНР розширення. Load up the `phpinfo` page provided by WAMP and check the `Architecture` and `Extension Build` values. Це дозволить вам завантажити коректну DLL. For a thread safe, x64 using VS16 and PHP 8.1, you will need to download the following file:

```
phalcon-php8.1-ts-windows2019-vs16-x64.zip
```

If your system reports `NTS` (_Non Thread Safe_) then you should download that DLL.

WAMP має 32 і 64 бітові версії. З розділу завантажень ви можете завантажити Phalcon DLL, який відповідає встановленому у вас WAMP.

Extract the `php_phalcon.dll` from the archive and copy the file `php_phalcon.dll` to the PHP extensions folder. If WAMP is installed in the `C:\wamp` folder, the extension needs to be in `C:\wamp\bin\php\php8.1.0\ext` (assuming your WAMP installation installed PHP 8.1.0).

Відредагуйте файл `php.ini`, він розташований у `C:\wamp\bin\php\php7.2.18\php.ini`. Він може бути змінений у блокноті або подібній програмі. We recommend [Notepad++][notepad_plus] to avoid issues with line endings. Додайте в кінець файлу:

```ini
extension=php_phalcon.dll
```

та збережіть його.

Також відредагуйте файл `php.ini`, який розташований у `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. Додайте в кінець файлу:

```ini
extension=php_phalcon.dll 
```

та збережіть його.

> **NOTE**: The path above might differ depending on the apache installation you have for your web server. Налаштуйте його відповідно. 
> 
> {: .alert .alert-warning }

Перезапустіть веб-сервер Apache. Зробіть один клік по іконці WampServer в системному треї. Оберіть `Перезавантажити всі сервіси` у спливаючому меню. Зверніть увагу на те, що значок у треї знову стане зеленим.

Відкрийте свій браузер, щоб перейти до `https://localhost`. З'явиться вітальна сторінка WAMP. Перевірите розділ `завантажені розширення`, щоб переконатися, що Phalcon був завантажений.

> **Congratulations! You are now phlying with Phalcon.** 
> 
> {: .alert .alert-info }

## XAMPP
[XAMPP][xampp] is an easy to install Apache distribution containing MySQL, PHP and Perl. Як тільки ви завантажите XAMPP, все, що буде потрібно - це розпакувати його і почати ним користуватись. Нижче наведені детальні інструкції для встановлення Phalcon на XAMPP для Windows. Використання останньої версії XAMPP настійно рекомендується.

> **NOTE** Paths in this guide should be relative, according to your installation WAMP 
> 
> {: .alert .alert-warning }

### Завантаження Phalcon
Для того, щоб Phalcon працював на Windows, вам потрібно встановити правильну версію, яка відповідає архітектурі та збірці вашого РНР розширення. Load up the `phpinfo` page provided by WAMP and check the `Architecture` and `Extension Build` values. Це дозволить вам завантажити коректну DLL. For a thread safe, x64 using VS16 and PHP 8.1, you will need to download the following file:

```
phalcon-php8.1-ts-windows2019-vs16-x64.zip
```

If your system reports `NTS` (_Non Thread Safe_) then you should download that DLL.

XAMPP offers both 32 and 64 bit versions of Apache and PHP: Phalcon has dlls for both, just choose the right dll for the installed version.

Extract the `php_phalcon.dll` from the archive and copy the file `php_phalcon.dll` to the PHP extensions directory. Якщо ви встановили XAMPP в `C:\xampp`, розширення повинно бути в `C:\xampp\php\ext`

Відредагуйте файл `php.ini`, він розташований у `C:\wamp\bin\php\php7.2.18\php.ini`. Він може бути змінений у блокноті або подібній програмі. We recommend [Notepad++][notepad_plus] to avoid issues with line endings. Додайте в кінець файлу:

```ini
extension=php_phalcon.dll
```

та збережіть його.

Перезапустіть Apache Web Server з Центру управління XAMPP. Це оновить конфігурацію PHP. Відкрийте свій браузер, щоб перейти до `https://localhost`. З'явиться вітальна сторінка XAMPP. Натисніть на посилання `phpinfo()`.

[phpinfo][phpinfo] will output a significant amount of information on screen about the current state of PHP. Прокрутіть вниз, щоб перевірити, чи розширення Phalcon завантажено правильно.

> **Congratulations! You are now phlying with Phalcon.** 
> 
> {: .alert .alert-info }


## Cherokee

[Cherokee][cherokee] is a high-performance web server. Він дуже швидкий, гнучкий та простий у налаштуванні.

### Конфігурація Phalcon
Cherokee пропонує зручний графічний інтерфейс для налаштування майже кожного можливого параметра веб-сервера.

Запустіть адміністратора cherokeе з розташування `/path-to-cherokee/sbin/cherokee-admin`

![](/assets/images/content/webserver-cherokee-1.jpg)

Створіть новий віртуальний хост, натиснувши на `vServers`, а потім додайте новий віртуальний сервер:

![](/assets/images/content/webserver-cherokee-2.jpg)

Нещодавно доданий віртуальний сервер повинен з'явитися в лівій панелі екрану. На вкладці `Behaviors` ви побачите набір типів поведінки за замовчуванням для цього віртуального сервера. Натисніть кнопку `Rule Management`. Видаліть такі позначки, як `Directory/cherokee_themes` та `Directory/icon`:

![](/assets/images/content/webserver-cherokee-3.jpg)

Додайте поведінку `PHP Language` за допомогою майстра. Ця поведінка дозволяє запускати продукти PHP:

![](/assets/images/content/webserver-cherokee-1.jpg)

Зазвичай така поведінка не потребує додаткових налаштувань. Додайте іншу поведінку, цього разу в розділі `Manual Configuration`. У `Rule Type` оберіть `File Exists`, тоді переконайтесь, що опція `Match any file` активована:

![](/assets/images/content/webserver-cherokee-5.jpg)

На вкладці `Handler` оберіть `List & Send` в якості обробника:

![](/assets/images/content/webserver-cherokee-7.jpg)

Відредагуйте поведінку `Default`, щоб увімкнути двигун перезапису URL. Змініть обробник на `Redirection`, а потім додайте наступний регулярний вираз до двигуна `^(.*)$`:

![](/assets/images/content/webserver-cherokee-6.jpg)

Нарешті, переконайтеся, що поведінки мають такий порядок:

![](/assets/images/content/webserver-cherokee-8.jpg)

Запустіть програму у браузері:

![](/assets/images/content/webserver-cherokee-9.jpg)


[apache]: https://httpd.apache.org/
[cherokee]: https://www.cherokee-project.com/
[nginx]: https://wiki.nginx.org/Main
[nginx_installation]: https://www.nginx.com/resources/wiki/start/topics/tutorials/install/
[notepad_plus]: https://notepad-plus-plus.org/
[php_fpm]: https://php.net/manual/en/install.fpm.php
[wamp]: https://www.wampserver.com/en/
[xampp]: https://www.apachefriends.org/download.html
[phpinfo]: https://php.net/manual/en/function.phpinfo.php
