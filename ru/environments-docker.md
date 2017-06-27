<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Overview</a> <ul>
        <li>
          <a href="#dependencies">Зависимости</a>
        </li>
        <li>
          <a href="#services">Сервисы</a>
        </li>
        <li>
          <a href="#installation">Installation</a> <ul>
            <li>
              <a href="#installation-composer">С помощью Composer (рекомендуется)</a>
            </li>
            <li>
              <a href="#installation-git">С помощью Git</a>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#configuration">Конфигурация</a>
        </li>
        <li>
          <a href="#usage">Использование</a>
        </li>
        <li>
          <a href="#setup">Настройка</a>
        </li>
        <li>
          <a href="#logs">Логи</a>
        </li>
        <li>
          <a href="#environment-variables">Переменные окружения</a> <ul>
            <li>
              <a href="#environment-variables-web">Окружение веб-сервера</a>
            </li>
            <li>
              <a href="#environment-variables-phpmyadmin">Переменные phpMyAdmin</a>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#xdebug">Удаленный отладчик Xdebug (PhpStorm)</a>
        </li>
        <li>
          <a href="#troubleshooting">Troubleshooting</a> <ul>
            <li>
              <a href="#troubleshooting-startup">Ошибки запуска или связывания</a>
            </li>
            <li>
              <a href="#troubleshooting-full-reset">Полный сброс</a>
            </li>
            <li>
              <a href="#troubleshooting-dependencies">Обновление зависимостей</a>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#versions">Версии</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Overview

Phalcon Compose является средой разработки на общественных началах для Phalcon проектов, которые запускаются в Docker контейнерах. Его цель заключается в том, чтобы сделать разворачивание Phalcon приложения лёгким, независимо от окружения (development, production).

<a name='dependencies'></a>

## Dependencies

Чтобы запустить этот стек на вашей машине, вам нужно по крайней мере: * Операционная система: Windows, Linux или macOs * [Docker Engine](https://docs.docker.com/installation/) >= 1.10.0 * [Docker Compose](https://docs.docker.com/compose/install/) >= 1.6.2

<a name='services'></a>

## Services

Ниже перечислены предоставляемые сервисы:

| Название сервиса | Description                                                                                                                                       |
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

## Installation

<a name='installation-composer'></a>

### With Composer (recommended)

С помощью Composer, можно создать новый проект следующим образом:

```bash
composer create-project phalcon/compose --prefer-dist путь-к-папке-с-проектом
```

Результат должен быть похож на:

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

### With Git

Другим способом инициализации проекта является Git.

```bash
 git clone git@github.com:phalcon/phalcon-compose.git
```

<h5 class='alert alert-warning'>Убедитесь, что вы скопировали <code>variables.env.example</code> <code>variables.env</code> и настроили параметры в этом файле </h5>

Добавьте ваше Phalcon приложение в папку `application`.

<a name='configuration'></a>

## Configuration

Добавьте `phalcon.local` (или имя предпочтительной хоста) в файл `/etc/hosts` как показано ниже:

```bash
127.0.0.1 www.phalcon.local phalcon.local
```

<a name='usage'></a>

## Usage

Теперь можно создавать, собирать и присоединять контейнеры к окружению вашего приложения. Для того, чтобы собрать контейнеры, используйте следующую команду в корне проекта:

```php
docker-compose build
```

Чтобы запустить приложение и контейнеры в фоновом режиме, используйте следующую команду в корне проекта:

```bash
# Вы можете использовать здесь предпочтительное имя проекта,
# используя опцию "-p", например "-p my-app"
$ docker-compose up -d
```

Теперь вы можете открыть ваше приложение в браузере по адресу `http://phalcon.local` (или используя адрес, который вы выбрали ранее).

<a name='setup'></a>

## Set up

Если ваше приложение использует файловый кэш или пишет логи на диск, вы можете настроить эти директории следующим образом:

| Директория | Путь             |
| ---------- | ---------------- |
| Кэш        | `/project/cache` |
| Logs       | `/project/log`   |

<a name='logs'></a>

## Logs

Для большинства контейнеров можно получить доступ к логам, используя команду `docker logs <имя_контейнера>` на хост системе.

<a name='environment-variables'></a>

## Environment variables

Вы можете передавать неограниченное кол-во переменных окружения в сервис контейнер используя файл `variables.env`.

<a name='environment-variables-web'></a>

### Web environment

| Переменная окружения | Description                                       | Default         |
| -------------------- | ------------------------------------------------- | --------------- |
| `WEB_DOCUMENT_ROOT`  | Корневой каталог веб-сервера (внутри контейнера). | /project/public |
| `WEB_DOCUMENT_INDEX` | Индексный файл.                                   | index.php       |
| `WEB_ALIAS_DOMAIN`   | Псевдоним домена.                                 | *.vm            |
| `WEB_PHP_SOCKET`     | PHP-FPM сокет.                                    | 127.0.0.1:9000  |
| `APPLICATION_ENV`    | Окружение приложения.                             | development     |
| `APPLICATION_CACHE`  | Директория кэша приложения (внутри контейнера).   | /project/cache  |
| `APPLICATION_LOGS`   | Директория логов (внутри контейнера).             | /project/logs   |

<a name='environment-variables-phpmyadmin'></a>

### phpMyAdmin variables

| Environment variable | Description                                                                                     | Default |
| -------------------- | ----------------------------------------------------------------------------------------------- | ------- |
| `PMA_ARBITRARY`      | Если установлено в 1, соединение с сервером баз данных будет разрешено.                         | 1       |
| `PMA_HOST`           | Определяет адрес MySQL сервера.                                                                 | mysql   |
| `PMA_HOSTS`          | Определяет список адресов MySQL серверов. Используется только если переменная `PMA_HOST` пуста. |         |
| `PMA_PORT`           | Определяет порт MySQL сервера.                                                                  | 3306    |
| `PMA_VERBOSE`        | Определяет имя MySQL сервера.                                                                   |         |
| `PMA_VERBOSES`       | Определяет список имен MySQL серверов. Используется только если переменная `PMA_VERBOSE` пуста. |         |
| `PMA_USER`           | Определяет имя пользователя для конфигурирования аутентификации.                                | phalcon |
| `PMA_PASSWORD`       | Определяет пароль пользователя для конфигурирования аутентификации.                             | secret  |
| `PMA_ABSOLUTE_URI`   | Определяет полный адрес к phpMyAdmin (например, https://pma.example.net/).                      |         |

*Смотрите также* * https://docs.phpmyadmin.net/en/latest/setup.html#installing-using-docker * https://docs.phpmyadmin.net/en/latest/config.html#config * https://docs.phpmyadmin.net/en/latest/setup.html

<a name='xdebug'></a>

## Xdebug Remote debugger (PhpStorm)

Из соображений отладки приложения, вы можете настроить Xdebug, передав необходимые параметры (см. variables.env).

| Environment variable         | Description                                                   | Default |
| ---------------------------- | ------------------------------------------------------------- | ------- |
| `XDEBUG_REMOTE_HOST`         | Значение `xdebug.remote_host` для `php.ini` (IP хост ситемы). |         |
| `XDEBUG_REMOTE_PORT`         | Значение `xdebug.remote_port` для `php.ini`.                  | 9000    |
| `XDEBUG_REMOTE_AUTOSTART`    | Значение `xdebug.remote_autostart` для `php.ini`.             | Off     |
| `XDEBUG_REMOTE_CONNECT_BACK` | Значение `xdebug.remote_connect_back` для `php.ini`.          | Off     |

*Обратите внимание* Вы можете получить ваш IP адрес используя команду, как показано ниже:

```bash
# Linux/MacOS
ifconfig en1 | grep inet | awk '{print $2}' | sed 's/addr://' | grep .

# Windows
ipconfig
```

<a name='troubleshooting'></a>

## Troubleshooting

<a name='troubleshooting-startup'></a>

### Startup or linking errors

Если у вас возникли проблемы с контейнером приложения, вы можете безопасно пересобрать его, без потери данных:

```bash
docker-compose stop
docker-compose rm --force app
docker-compose build --no-cache app
docker-compose up -d
```

<a name='troubleshooting-full-reset'></a>

### Full reset

Для сброса всех контейнеров, а также удаления всех данных (mysql, elasticsearch, и т.д.), кроме файлов проекта в директории `application`, используйте следующий набор команд:

```bash
docker-compose stop
docker-compose rm --force
docker-compose build --no-cache
docker-compose up -d
```

<a name='troubleshooting-dependencies'></a>

### Updating dependencies

Иногда базовые образы (например `phalconphp/php-apache:ubuntu-16.04`) обновляются. Phalcon Compose зависит от этих образов. Мы рекомендуем вам следить за актуальностью этих образов. В любом случае, это хорошая идея — держать самые свежие версии этих образов. Это позволит вам всегда быть уверенными в том, что вам доступны самые последние функциональные возможности. Вам необходимо будет также пересобрать все зависимые контейнеры:

```bash
docker pull mongo:3.4
docker pull postgres:9.5-alpine
docker pull mysql:5.7
docker pull phpmyadmin/phpmyadmin:4.6
docker pull memcached:1.4-alpine
docker pull phalconphp/beanstalkd:1.10
docker pull aerospike:latest
docker pull redis:3.2-alpine
docker pull elasticsearch:5.2-alpine
docker pull phalconphp/php-apache:ubuntu-16.04
```

Linux/macOs пользователи, вместо этого, могут воспользоваться `make`:

```bash
make pull
```

Затем вам необходимо удалить все контейнеры, очистить старые данные, пересобрать сервисы и перезапустить приложение.

Linux/MacOS users can use `make` to perform the task:

```bash
make reset
```

<a name='versions'></a>

## Versions

Основные инструменты: Phalcon, Docker и Docker Compose.

| Приложение      | Версия           |
| --------------- | ---------------- |
| Aerospike       | 3.11.1.1         |
| Apache          | 2.4.18           |
| Beanstalk       | 1.10             |
| Composer        | 1.4.1            |
| Elasticsearch   | 5.2.2            |
| Memcached       | 1.4.35           |
| Mongo           | 3.4.2            |
| MySQL           | 5.7.17           |
| PHP             | 7.0.18 + PHP-FPM |
| PHPMD           | 2.6.0            |
| phpMyAdmin      | 4.6.5.2          |
| PHP_CodeSniffer | 2.8.1            |
| Phalcon         | 3.1.2            |
| Phing           | 2.16.0           |
| Phive           | 0.6.3            |
| PostgreSQL      | 9.5.5            |
| Redis           | 3.2.6            |
| Weakref         | 0.3.3            |
| Xdebug          | 2.4.0            |