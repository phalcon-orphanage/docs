---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Налаштування веб-сервера'
keywords: 'web server, webserver, apache, nginx, lighttpd, xampp, wamp, cherokee, php built-in server, веб-сервер, вебсервер'
---

# Налаштування веб-сервера

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

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

- `$(which php)` - вставляє абсолютний шлях до вашого файлу РНР
- `-S localhost:8000` - запускає сервер з заданим параметрами `host:port`
- `-t public` - визначає root-адресу, що необхідна РНР для переспрямування запитів до ресурсів JS, CSS та малюнків, що знаходяться у вашій теці "public"
- `.htrouter.php` - точка входу, яка буде використовуватись для оцінки кожного запиту

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

Після виконання команди вище, перехід за адресою `http://localhost:8000/` дозволить побачити ваш сайт.

## PHP-FPM

[PHP-FPM](https://php.net/manual/en/install.fpm.php) (FastCGI Process Manager) зазвичай використовуються для обробки PHP файлів. На сьогодні PHP-FPM входить до складу усіх PHP-дистрибутивів на базі Linux.

На **Windows** PHP-FPM знаходиться в архіві дистрибуції PHP. Файл `php-cgi.exe` можна використовувати для запуску процесу і налаштування. Windows не підтримує unix сокети, тож цей скрипт запустить fast-cgi в режимі TCP на порту `9000`.

Створіть файл `php-fcgi.bat` з таким змістом:

```bat
@ECHO OFF
ECHO Starting PHP FastCGI...
set PATH=C:\PHP;%PATH%
c:\bin\RunHiddenConsole.exe C:\PHP\php-cgi.exe -b 127.0.0.1:9000
```

## nginx

[nginx](https://wiki.nginx.org/Main) є безкоштовним високопродуктивним HTTP-сервером та зворотним проксі з відкритим вихідним кодом, а також IMAP/POP3 проксі-сервером. На відміну від традиційних серверів, nginx не покладається на потоки для обробки запитів. Замість цього він використовує більш масштабну (асинхронну) архітектуру. Ця архітектура використовує невеликі, але що не менш важливо, передбачувані обсяги пам'яті під навантаженням.

Phalcon з nginx і PHP-FPM забезпечують потужний набір інструментів, які пропонують максимальну продуктивність для ваших PHP продуктів.

### Установка nginx

[Офіційний сайт nginx](https://www.nginx.com/resources/wiki/start/topics/tutorials/install/)

### Конфігурація Phalcon

Ви можете використовувати такі потенційні параметри для налаштування роботи nginx з Phalcon:

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
    

### Запуск

Залежно від вашої системи, команда для запуску nginx може бути однією з таких:

```bash
start nginx
/etc/init.d/nginx start
service nginx start
```

## Apache

[Apache](https://httpd.apache.org/) є популярним і добре відомим веб-сервером, доступним на багатьох платформах.

### Конфігурація Phalcon

Нижче наведено потенційні установки, які ви можете використовувати для налаштування Apache із Phalcon. Ці нотатки в основному зфокусовані на конфігурації модуля `mod_rewrite`, що дозволяє використовувати дружні URL і компонент [маршрутизатора](routing). Типова структура каталогів продукту:

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

**Коренева тека** Найпоширеніший випадок - коли продукт встановлюють в каталозі під кореневою текою. У такому випадку ми можемо використовувати `.htaccess` файли. Перший буде використаний для приховування коду продукта, переадресовуючи усі запити до кореневої теки продукта (`public/`).

> **ПРИМІТКА**: Зауважте, що використання файлів `.htaccess` вимагає, щоб у налаштуваннях вашого apache було встановлено опцію `AllowOverride All`.
 {: .alert .alert-warning}

# tutorial/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule   ^$ public/    [L]
        RewriteRule   ((?s).*) public/$1 [L]
    </IfModule>
    

Другий файл `.htaccess` розташований в каталозі `public/` та переадресовує усі запити URI до файлу `public/index.php`:

    # tutorial/public/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond   %{REQUEST_FILENAME} !-d
        RewriteCond   %{REQUEST_FILENAME} !-f
        RewriteRule   ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>
    

**Міжнародні символи** Для користувачів, які використовують перську літеру 'م' (meem) в параметрах uri є проблема з `mod_rewrite`. Щоб виправити проблему вам потрібно змінити ваш файл `.htaccess` наступним чином:

    # tutorial/public/.htaccess
    
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond   %{REQUEST_FILENAME} !-d
        RewriteCond   %{REQUEST_FILENAME} !-f
        RewriteRule   ^([0-9A-Za-z\x7f-\xff]*)$ index.php?params=$1 [L]
    </IfModule>
    

Якщо ваші URI містять символи, відмінні від латинських, може знадобитися здійснити вищевказані зміни, щоб дозволити `mod_rewrite` точного визначати ваші маршрути.

#### Налаштування Apache

Якщо ви не хочете використовувати `.htaccess` файли, ви можете перенести відповідні команди у головний файл конфігурації apache:

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
    

#### Віртуальні хости

Налаштування, зазначені нижче, призначені для установки власного продукту на віртуальний хост:

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

[lighttpd](https://redmine.lighttpd.net/) (звучить, як "lighty") є веб-сервером з відкритим вихідним кодом, оптимізованим для швидкісних критичних середовищ, при цьому відповідає стандартам, залишається безпечним та гнучким. Спочатку його було написано Яном Кнешке як концепт рішення проблеми c10k - як опрацювати 10 000 підключень паралельно на одному сервері, але отримав популярність по всьому світу. Його ім'я є поєднанням слів "light" та "httpd".

### Установка lighttpd

[Офіційний сайт lighttpd](https://redmine.lighttpd.net/projects/lighttpd/wiki/GetLighttpd)

Ви можете використовувати наступну конфігурацію для налаштування роботи lighttpd із Phalcon:

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

[WampServer](https://www.wampserver.com/en/) є середовищем веб-розробника Windows. Він дозволяє створювати веб-додатки з використанням Apache2, PHP та баз даних MySQL. Нижче наведені детальні інструкції, як встановити Phalcon на WampServer для Windows. Використання останньої версії WampServer є дуже рекомендованим.

> **ПРИМІТКА** Починаючи з v4, ви повинні встановити розширення PECL `PSR`. Відвідайте [цю URL-адресу](https://pecl.php.net/package/psr/0.7.0/windows), щоб отримати DLL і виконайте ті ж кроки для встановлення розширення, як і з DLL Phalcon.
{: .alert .alert-warning }

> 
> **ПРИМІТКА** Шляхи у цьому посібнику мають бути співставними з вашою установкою WAMP
{: .alert .alert-warning }

### Завантаження Phalcon

Для того, щоб Phalcon працював на Windows, вам потрібно встановити правильну версію, яка відповідає архітектурі та збірці вашого РНР розширення. Завантажте сторінку `phpinfo` за допомогою WAMP:

![](/assets/images/content/webserver-architecture.png)

Перевірте визначення `архітектури` і `збірки розширення РНР`. Це дозволить вам завантажити коректну DLL. У наведеному вище прикладі ви повинні завантажити файл:

    phalcon_x86_vc15_php7.2_4.0.0+4237.zip
    

який відповідатиме `x86`, `vc15` і `TS` що означає *Thread Safe*. Якщо ваша система повідомляє про `NTS` (*Non Thread Safe*), то ви повинні завантажити цю DLL.

WAMP має 32 і 64 бітові версії. З розділу завантажень ви можете завантажити Phalcon DLL, який відповідає встановленому у вас WAMP.

Після завантаження бібліотеки Phalcon ви матимете zip-файл як показано нижче:

![](/assets/images/content/webserver-zip-icon.png)

Розархівуйте цей файл, щоб отримати Phalcon DLL:

![](/assets/images/content/webserver-extracted-dlls.png)

Скопіюйте файл `php_phalcon.dll` в папку розширень PHP. Якщо WAMP встановлено у теці `C:\wamp`, розширення повинне бути в `C:\wamp\bin\php\php7.2.18\ext` (припустимо, що ваша версія WAMP має встановлену PHP 7.2.18).

![](/assets/images/content/webserver-wamp-phalcon-psr-ext-folder.png)

Відредагуйте файл `php.ini`, він розташований у `C:\wamp\bin\php\php7.2.18\php.ini`. Він може бути змінений у блокноті або подібній програмі. Ми рекомендуємо Notepad++, щоб уникнути проблем з закінченням рядків. Додайте в кінець файлу:

```ini
 extension=php_phalcon.dll
```

та збережіть його.

![](/assets/images/content/webserver-wamp-phalcon-php-ini.png)

Також відредагуйте файл `php.ini`, який розташований у `C:\wamp\bin\apache\apache2.4.9\bin\php.ini`. Додайте в кінець файлу:

```ini
extension=php_phalcon.dll 
```

та збережіть його.

> **ПРИМІТКА**: Зазначені вище шляхи можуть відрізнятись залежно від місця установки та версії apache вашого веб сервера. Налаштуйте його відповідно.
{: .alert .alert-warning }

> 
> **ПРИМІТКА**: Як зазначено вище, розширення `PSR` має бути встановлене та завантажуватись до старту Phalcon. Додайте `extension=php_psr.dll` рядок перед відповідною стрічкою Phalcon, як показано на зображенні вище.
{: .alert .alert-warning }

![](/assets/images/content/webserver-wamp-apache-phalcon-php-ini.png)

Перезапустіть веб-сервер Apache. Зробіть один клік по іконці WampServer в системному треї. Оберіть `Перезавантажити всі сервіси` у спливаючому меню. Зверніть увагу на те, що значок у треї знову стане зеленим.

![](/assets/images/content/webserver-wamp-manager.png)

Відкрийте свій браузер, щоб перейти до https://localhost. З'явиться вітальна сторінка WAMP. Перевірите розділ `завантажені розширення`, щоб переконатися, що Phalcon був завантажений.

![](/assets/images/content/webserver-wamp-phalcon.png)

> **Вітаємо! Тепер ви літаєте разом із Phalcon.**
{: .alert .alert-info }

## XAMPP

[XAMPP](https://www.apachefriends.org/download.html) дистрибутив Apache, що легко встановлюється та містить MySQL, PHP і Perl. Як тільки ви завантажите XAMPP, все, що буде потрібно - це розпакувати його і почати ним користуватись. Нижче наведені детальні інструкції для встановлення Phalcon на XAMPP для Windows. Використання останньої версії XAMPP настійно рекомендується.

> **ПРИМІТКА** Починаючи з v4, ви повинні встановити розширення PECL `PSR`. Відвідайте [цю URL-адресу](https://pecl.php.net/package/psr/0.7.0/windows), щоб отримати DLL і виконайте ті ж кроки для встановлення розширення, як і з DLL Phalcon.
{: .alert .alert-warning }

> 
> **ПРИМІТКА** Шляхи у цьому посібнику мають бути співставними з вашою установкою WAMP
{: .alert .alert-warning }

### Завантаження Phalcon

Для того, щоб Phalcon працював на Windows, вам потрібно встановити правильну версію, яка відповідає архітектурі та збірці вашого РНР розширення. Завантажте сторінку `phpinfo` за допомогою XAMPP:

![](/assets/images/content/webserver-architecture.png)

Перевірте визначення `архітектури` і `збірки розширення РНР`. Це дозволить вам завантажити коректну DLL. У наведеному вище прикладі ви повинні завантажити файл:

    phalcon_x86_vc15_php7.2_4.0.0+4237.zip
    

який відповідатиме `x86`, `vc15` і `TS` що означає *Thread Safe*. Якщо ваша система повідомляє про `NTS` (*Non Thread Safe*), то ви повинні завантажити цю DLL.

Notice that XAMPP offers both 32 and 64 bit versions of Apache and PHP (5.6+): Phalcon has dlls for both, just choose the right dll for the installed version.

Після завантаження бібліотеки Phalcon ви матимете zip-файл як показано нижче:

![](/assets/images/content/webserver-zip-icon.png)

Розархівуйте цей файл, щоб отримати Phalcon DLL:

![](/assets/images/content/webserver-extracted-dlls.png)

Скопіюйте файл `php_phalcon.dll` в каталог розширень PHP. Якщо ви встановили XAMPP в `C:\xampp`, розширення повинно бути в `C:\xampp\php\ext`

![](/assets/images/content/webserver-xampp-phalcon-psr-ext-folder.png)

Відредагуйте файл `php.ini`, він розташований у `C:\xampp\php\php.ini`. Він може бути змінений у блокноті або подібній програмі. Ми рекомендуємо [Notepad++](https://notepad-plus-plus.org/), щоб уникнути проблем з закінченням рядків. Додайте в кінець файлу:

```ini
extension=php_phalcon.dll
```

та збережіть його.

> **ПРИМІТКА**: Як зазначено вище, розширення `PSR` має бути встановлене та завантажуватись до старту Phalcon. Додайте рядок `extension=php_psr.dll` перед відповідною стрічкою Phalcon, як показано на зображенні вище.
{: .alert .alert-warning }

![](/assets/images/content/webserver-xampp-phalcon-php-ini.png)

Перезапустіть Apache Web Server з Центру управління XAMPP. Це оновить конфігурацію PHP. Відкрийте свій браузер, щоб перейти до `https://localhost`. З'явиться вітальна сторінка XAMPP. Натисніть на посилання `phpinfo()`.

![](/assets/images/content/webserver-xampp-phpinfo.png)

[phpinfo](https://php.net/manual/en/function.phpinfo.php) виведе велику кількість інформації на екран про поточний стан PHP. Прокрутіть вниз, щоб перевірити, чи розширення Phalcon завантажено правильно.

![](/assets/images/content/webserver-xampp-phpinfo-phalcon.png)

> **Вітаємо! Тепер ви літаєте разом із Phalcon.**
{: .alert .alert-info }


## Cherokee

[Cherokee](https://www.cherokee-project.com/) - високопродуктивний веб-сервер. Він дуже швидкий, гнучкий та простий у налаштуванні.

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
