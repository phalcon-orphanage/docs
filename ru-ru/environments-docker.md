* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Введение

Phalcon Compose является средой разработки на общественных началах для Phalcon проектов, которые запускаются в Docker контейнерах. Его цель заключается в том, чтобы сделать разворачивание Phalcon приложения лёгким, независимо от окружения (development, production).

<a name='dependencies'></a>

## Зависимости

Чтобы запустить этот стек на вашей машине, вам нужно по крайней мере: * Операционная система: Windows, Linux или macOs * [Docker Engine](https://docs.docker.com/installation/) >= 1.10.0 * [Docker Compose](https://docs.docker.com/compose/install/) >= 1.6.2

<a name='services'></a>

## Сервисы

Ниже перечислены предоставляемые сервисы:

| Название сервиса | Описание                                                                                                                                          |
| ---------------- | ------------------------------------------------------------------------------------------------------------------------------------------------- |
| mongo            | MongoDB сервис контейнер.                                                                                                                         |
| postgres         | PostgreSQL сервис контейнер.                                                                                                                      |
| mysql            | MySQL сервис контейнер.                                                                                                                           |
| phpmyadmin       | Веб-интерфейс к MariaDB и MySQL.                                                                                                                  |
| memcached        | Memcached сервис контейнер.                                                                                                                       |
| queue            | Сервис контейнер сервера очередей Beanstalk.                                                                                                      |
| aerospike        | Контейнер с Aerospike — надежной, высокопроизводительной, распределенной базой данных, оптимизированной для работы на SSD и в оперативной памяти. |
| redis            | Сервис контейнер базы данных Redis.                                                                                                               |
| app              | Контейнер с PHP 7, Apache 2 и Composer.                                                                                                           |
| elasticsearch    | Контейнер с Elasticsearch — мощным движком для поиска и аналитики.                                                                                |

<a name='installation'></a>

## Установка

<a name='installation-composer'></a>

### С помощью Composer (рекомендуется)

С помощью Composer, можно создать новый проект следующим образом:

```bash
composer create-project phalcon/compose --prefer-dist путь-к-папке-с-проектом
```

Your output should be similar to this:

```php
Example
 Installing phalcon/compose (version)
  - Installing phalcon/compose (version)
    Loading from cache

Created project in folderName
> php -r "copy('variables.env.example', 'variables.env');"
Loading composer repositories with package information
Updating dependencies (including require-dev)
Nothing to install or update
Generating autoload files
```

<a name='installation-git'></a>

### С помощью Git

Another way to initialize your project is with Git.

```bash
 git clone git@github.com:phalcon/phalcon-compose.git
```

<h5 class='alert alert-warning'>Make sure that you copy <code>variables.env.example</code> to <code>variables.env</code> and adjust the settings in that file </h5>

Add your Phalcon Application into `application` folder.

<a name='configuration'></a>

## Конфигурация

Add `phalcon.local` (or your preferred host name) in your `/etc/hosts` file as follows:

```bash
127.0.0.1 www.phalcon.local phalcon.local
```

<a name='usage'></a>

## Использование

You can now build, create, start, and attach to containers to the environment for your application. To build the containers use following command inside the project root:

```php
docker-compose build
```

To start the application and run the containers in the background, use following command inside project root:

```bash
# Вы можете использовать здесь предпочтительное имя проекта,
# используя опцию "-p", например "-p my-app"
$ docker-compose up -d
```

Now setup your project in the app container using the Phalcon Developer Tools

Replace project in **<project_app_1>** with the name of your project/directory (shown in the output of `docker-compose up -d`)

$ `docker exec -t <project_app_1> phalcon project application simple`

Now you can now launch your application in your browser visiting `https://phalcon.local` (or the host name you chose above).

<a name='setup'></a>

## Настройка

If your application uses a file cache or writes logs to files, you can set up your cache and log folders as follows:

| Директория | Путь             |
| ---------- | ---------------- |
| Кэш        | `/project/cache` |
| Логи       | `/project/log`   |

<a name='logs'></a>

## Логи

For most containers you can access the logs using the `docker logs <container_name>` command in your host machine.

<a name='environment-variables'></a>

## Переменные окружения

You can pass multiple environment variables from an external file to a service's containers by editing the `variables.env` file.

<a name='environment-variables-web'></a>

### Окружение веб-сервера

| Переменная окружения | Описание                                          | По умолчанию    |
| -------------------- | ------------------------------------------------- | --------------- |
| `WEB_DOCUMENT_ROOT`  | Корневой каталог веб-сервера (внутри контейнера). | /project/public |
| `WEB_DOCUMENT_INDEX` | Индексный файл.                                   | index.php       |
| `WEB_ALIAS_DOMAIN`   | Псевдоним домена.                                 | *.vm            |
| `WEB_PHP_SOCKET`     | PHP-FPM сокет.                                    | 127.0.0.1:9000  |
| `APPLICATION_ENV`    | Окружение приложения.                             | development     |
| `APPLICATION_CACHE`  | Директория кэша приложения (внутри контейнера).   | /project/cache  |
| `APPLICATION_LOGS`   | Директория логов (внутри контейнера).             | /project/logs   |

<a name='environment-variables-phpmyadmin'></a>

### Переменные phpMyAdmin

| Переменная окружения | Описание                                                                                        | По умолчанию |
| -------------------- | ----------------------------------------------------------------------------------------------- | ------------ |
| `PMA_ARBITRARY`      | Если установлено в 1, соединение с сервером баз данных будет разрешено.                         | 1            |
| `PMA_HOST`           | Определяет адрес MySQL сервера.                                                                 | mysql        |
| `PMA_HOSTS`          | Определяет список адресов MySQL серверов. Используется только если переменная `PMA_HOST` пуста. |              |
| `PMA_PORT`           | Определяет порт MySQL сервера.                                                                  | 3306         |
| `PMA_VERBOSE`        | Определяет имя MySQL сервера.                                                                   |              |
| `PMA_VERBOSES`       | Определяет список имен MySQL серверов. Используется только если переменная `PMA_VERBOSE` пуста. |              |
| `PMA_USER`           | Определяет имя пользователя для конфигурирования аутентификации.                                | phalcon      |
| `PMA_PASSWORD`       | Определяет пароль пользователя для конфигурирования аутентификации.                             | secret       |
| `PMA_ABSOLUTE_URI`   | Определяет полный адрес к phpMyAdmin (например, https://pma.example.net/).                      |              |

*See also* * https://docs.phpmyadmin.net/en/latest/setup.html#installing-using-docker * https://docs.phpmyadmin.net/en/latest/config.html#config * https://docs.phpmyadmin.net/en/latest/setup.html

<a name='xdebug'></a>

## Удаленный отладчик Xdebug (PhpStorm)

For debugging purposes you can setup Xdebug by passing required parameters (see variables.env).

| Переменная окружения         | Описание                                                      | По умолчанию |
| ---------------------------- | ------------------------------------------------------------- | ------------ |
| `XDEBUG_REMOTE_HOST`         | Значение `xdebug.remote_host` для `php.ini` (IP хост ситемы). |              |
| `XDEBUG_REMOTE_PORT`         | Значение `xdebug.remote_port` для `php.ini`.                  | 9000         |
| `XDEBUG_REMOTE_AUTOSTART`    | Значение `xdebug.remote_autostart` для `php.ini`.             | Off          |
| `XDEBUG_REMOTE_CONNECT_BACK` | Значение `xdebug.remote_connect_back` для `php.ini`.          | Off          |

*NOTE* You can find your local IP address as follows:

```bash
# Linux/MacOS
ifconfig en1 | grep inet | awk '{print $2}' | sed 's/addr://' | grep .

# Windows
ipconfig
```

<a name='troubleshooting'></a>

## Устранение неполадок

<a name='troubleshooting-startup'></a>

### Ошибки запуска или связывания

If you got any startup issues you can try to rebuild app container. There will be no loss of data., it is a safe reset:

```bash
docker-compose stop
docker-compose rm --force app
docker-compose build --no-cache app
docker-compose up -d
```

<a name='troubleshooting-full-reset'></a>

### Полный сброс

To reset all containers, delete all data (mysql, elasticsearch, etc.) but not your project files in `application` folder:

```bash
docker-compose stop
docker-compose rm --force
docker-compose build --no-cache
docker-compose up -d
```

<a name='troubleshooting-dependencies'></a>

### Обновление зависимостей

Sometimes the base images (for example `phalconphp/php-apache:ubuntu-16.04`) are updated. Phalcon Compose depends on these images. You will therefore need to update them and it is always a good thing to do so to ensure that you have the latest functionality available. The dependent containers to these images will need to be updated and rebuilt:

```bash
docker pull mongo:4.0
docker pull postgres:9.5-alpine
docker pull mysql:5.7
docker pull phpmyadmin/phpmyadmin:4.6
docker pull memcached:1.4-alpine
docker pull phalconphp/beanstalkd:1.10
docker pull aerospike:latest
docker pull redis:4.0-alpine
docker pull elasticsearch:5.2-alpine
docker pull phalconphp/php-apache:ubuntu-16.04
```

Linux/MacOS users can use `make` to perform the task:

```bash
make pull
```

Then you have to reset all containers, delete all data, rebuild services and restart application.

Linux/MacOS users can use `make` to perform the task:

```bash
make reset
```