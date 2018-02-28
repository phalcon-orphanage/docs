<div class='article-menu'>
  <ul>
    <li>
      <a href="#setup">Web Server Setup</a> <ul>
        <li>
          <a href="#nginx">Nginx</a> <ul>
            <li>
              <a href="#nginx-phalcon-configuration">Настройка под Phalcon</a> <ul>
                <li>
                  <a href="#nginx-phalcon-configuration-basic">Базовая конфигурация</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a href="#apache">Apache</a> <ul>
            <li>
              <a href="#apache-phalcon-configuration">Настройка Phalcon</a> <ul>
                <li>
                  <a href="#apache-document-root">Корневой каталог</a>
                </li>
                <li>
                  <a href="#apache-apache-configuration">Конфигурация Apache</a>
                </li>
                <li>
                  <a href="#apache-virtual-hosts">Виртуальные хосты</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a href="#cherokee">Cherokee</a> <ul>
            <li>
              <a href="#cherokee-phalcon-configuration">Настройка Phalcon</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#php-built-in">Встроенный веб-сервер</a> <ul>
            <li>
              <a href="#php-built-in-phalcon-configuration">Настройка Phalcon</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='setup'></a>

# Настройка веб-сервера

Чтобы работала маршрутизация (анг. routing) в Phalcon, вам понадобится настроить должным образом веб-сервер, научив его правильно обрабатывать перенаправления. Ниже рассматриваются типичные конфигурации для популярных веб-серверов:

<a name='nginx'></a>

## Nginx

[Nginx](http://wiki.nginx.org/Main) — это свободный, с открытым исходным кодом, высокопроизводительный HTTP-сервер и прокси-сервер, а также IMAP/POP3 прокси-сервер. В отличие от традиционных серверов Nginx не использует потоки для обработки запросов. Вместо этого он использует гораздо более масштабируемую, управляемую событиями (асинхронную) архитектуру. Эта архитектура под высокой нагрузкой использует небольшой, и главное, предсказуемый объем памяти.

[PHP-FPM](http://php-fpm.org/) (менеджер процессов FastCGI) обычно используется для обработки PHP-файлов в Nginx. В настоящее время PHP-FPM идёт в комплекте с любым дистрибутивом PHP в Unix. Связка Phalcon + Nginx + PHP-FPM предоставляет мощный набор инструментов, который позволяет добиться максимальной производительности ваших PHP приложений.

<a name='nginx-phalcon-configuration'></a>

### Настройка Phalcon

Конфигурации ниже позволят настроить Nginx для работы с Phalcon:

<a name='nginx-phalcon-configuration-basic'></a>

#### Basic configuration

Использование переменной `$_GET['_url']` для URI:

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

Использование `$_SERVER['REQUEST_URI']` для URI:

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

[Apache](http://httpd.apache.org/) — это популярный веб-сервер, доступный на большинстве современных платформ.

<a name='apache-phalcon-configuration'></a>

### Настройка под Phalcon

Следующие инструкции позволят настроить Apache для корректной работы с Phalcon. В основном они сводятся к настройке поведения модуля `mod_rewrite`, позволяющего использовать человеко-понятные URL (ЧПУ) и [компонента маршрутизации](/[[language]]/[[version]]/routing). Типичное приложение имеет следующую структуру:

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

Самый распространённый случай - когда приложение устанавливается в любой подкаталог корневой директории. В таких случаях мы используем два `.htaccess` файла. Первый будет скрывать код приложения и перенаправлять запросы к корню приложения (`public/`).

<h5 class='alert alert-warning'>Обратите внимание, для полного разрешения использования директив в <code>.htaccess</code> файле, в главном конфигурационном файле Apache необходимо установить параметр <code>AllowOverride All</code>. </h5>

```apacheconfig
# test/.htaccess

<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteRule   ^$ public/    [L]
    RewriteRule   ((?s).*) public/$1 [L]
</IfModule>
```

Второй `.htaccess` будет располагаться уже в каталоге `public/` и будет перенаправлять все запросы на файл `public/index.php`:

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

Если нет желания или возможности использовать файлы `.htaccess`, то параметры также можно прописать в главном файле конфигурации Apache:

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

В этом заключительном примере конфигурации, мы разрешаем установку Phalcon-приложения в виртуальный хост:

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

[Cherokee](http://www.cherokee-project.com/) — это высокопроизводительный веб сервер. Он очень быстрый, гибкий и лёгкий в настройке.

<a name='cherokee-phalcon-configuration'></a>

### Настройка Phalcon

Cherokee имеет удобный графический интерфейс для настройки практически всех параметров, доступных в веб-сервере.

Чтобы запустить администрирование сервера, нужно выполнить команду `/путь-к-cherokee/sbin/cherokee-admin` с правами суперадмина (root).

![](/images/content/webserver-cherokee-1.jpg)

Создайте новый виртуальный хост, для этого кликните на `vServers`, затем добавьте виртуальный сервер:

![](/images/content/webserver-cherokee-2.jpg)

Добавленный виртуальный хост должен появиться на панели слева. На вкладке `Behaviors` вы можете увидеть набор правил для данного сервера. Нажмите кнопку `Rule Management`. Снимите галочки с `Directory /cherokee_themes` и `Directory /icons`:

![](/images/content/webserver-cherokee-3.jpg)

С помощью мастера добавьте обработчик `PHP Language`. Это позволит запускать PHP приложения:

![](/images/content/webserver-cherokee-1.jpg)

Обычно такое решение не требует дополнительной настройки. Добавьте еще одно правило, на этот раз в разделе `Manual Configuration`. В списке `Rule Type` выберите `File Exists`, и убедитесь что опция `Match any file` включена:

![](/images/content/webserver-cherokee-5.jpg)

На вкладке 'Handler' выберите обработчик `List & Send`:

![](/images/content/webserver-cherokee-7.jpg)

Отредактируйте правило `Default` для включения возможностей URL-перезаписи. Выберите `Redirection`, затем добавьте регулярное выражение `^(.*)$`:

![](/images/content/webserver-cherokee-6.jpg)

Убедитесь, что обработчики выставлены в нужном порядке:

![](/images/content/webserver-cherokee-8.jpg)

Запустите приложение в браузере:

![](/images/content/webserver-cherokee-9.jpg)

<a name='php-built-in'></a>

## Встроенный веб-сервер

Вы можете использовать [встроенный веб-сервер](http://php.net/manual/en/features.commandline.webserver.php) для разработки. Для запуска сервера выполните команду:

```bash
php -S localhost:8000 -t /public
```

<a name='php-built-in-phalcon-configuration'></a>

### Настройка под Phalcon

Если вы хотите перенаправлять запросы на файл index.php, добавьте файл `.htrouter.php` со следующим кодом:

```php
<?php

if (!file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
    $_GET['_url'] = $_SERVER['REQUEST_URI'];
}

return false;
```

и запустите сервер следующей командой:

```bash
php -S localhost:8000 -t /public .htrouter.php
```

Откройте свой браузер и перейдите по адресу http://localhost:8000/, чтобы убедиться, что всё работает.