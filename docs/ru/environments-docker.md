<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Введение</a> <ul>
        <li>
          <a href="#dependencies">Зависимости</a>
        </li>
        <li>
          <a href="#services">Сервисы</a>
        </li>
        <li>
          <a href="#installation">Установка</a> <ul>
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
          <a href="#troubleshooting">Устранение неполадок</a> <ul>
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

# Введение

Phalcon Compose является средой разработки на общественных началах для Phalcon проектов, которые запускаются в Docker контейнерах. Его цель заключается в том, чтобы сделать разворачивание Phalcon приложения лёгким, независимо от окружения (development, production).

<a name='dependencies'></a>

## Зависимости

Чтобы запустить этот стек на вашей машине, вам нужно по крайней мере: * Операционная система: Windows, Linux или macOs * [Docker Engine](https://docs.docker.com/installation/) >= 1.10.0 * [Docker Compose](https://docs.docker.com/compose/install/) >= 1.6.2

<a name='services'></a>

## Сервисы

Services included are:

| Service name  | Description                                                                                         |
| ------------- | --------------------------------------------------------------------------------------------------- |
| mongo         | MongoDB server container.                                                                           |
| postgres      | PostgreSQL server container.                                                                        |
| mysql         | MySQL database container.                                                                           |
| phpmyadmin    | A web interface for MySQL and MariaDB.                                                              |
| memcached     | Memcached server container.                                                                         |
| queue         | Beanstalk queue container.                                                                          |
| aerospike     | Aerospike – the reliable, high performance, distributed database optimized for flash and RAM.       |
| redis         | Redis database container.                                                                           |
| app           | PHP 7, Apache 2 and Composer container.                                                             |
| elasticsearch | Elasticsearch is a powerful open source search and analytics engine that makes data easy to search. |

<a name='installation'></a>

## Установка

<a name='installation-composer'></a>

### С помощью Composer (рекомендуется)

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

### С помощью Git

Другим способом инициализации проекта является Git.

```bash
 git clone git@github.com:phalcon/phalcon-compose.git
```

##### Убедитесь, что вы скопировали `variables.env.example` `variables.env` и настроили параметры в этом файле {.alert.alert-warning}

Добавьте ваше Phalcon приложение в папку `application`.

<a name='configuration'></a>

## Конфигурация

Добавьте `phalcon.local` (или имя предпочтительной хоста) в файл `/etc/hosts` как показано ниже:

```bash
127.0.0.1 www.phalcon.local phalcon.local
```

<a name='usage'></a>

## Использование

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

## Настройка

Если ваше приложение использует файловый кэш или пишет логи на диск, вы можете настроить эти директории следующим образом:

| Directory | Path             |
| --------- | ---------------- |
| Cache     | `/project/cache` |
| Logs      | `/project/log`   |

<a name='logs'></a>

## Логи

Для большинства контейнеров можно получить доступ к логам, используя команду `docker logs <имя_контейнера>` на хост системе.

<a name='dependencies'></a>

0## Переменные окружения

Вы можете передавать неограниченное кол-во переменных окружения в сервис контейнер используя файл `variables.env`.

<a name='dependencies'></a>

1### Окружение веб-сервера

| Переменная окружения | Описание                                            | По умолчанию    |
| -------------------- | --------------------------------------------------- | --------------- |
| `WEB_DOCUMENT_ROOT`  | Document root for webserver (inside the container). | /project/public |
| `WEB_DOCUMENT_INDEX` | Index document.                                     | index.php       |
| `WEB_ALIAS_DOMAIN`   | Domain aliases.                                     | *.vm            |
| `WEB_PHP_SOCKET`     | PHP-FPM socket address.                             | 127.0.0.1:9000  |
| `APPLICATION_ENV`    | Application environment.                            | development     |
| `APPLICATION_CACHE`  | Application cache dir (inside the container).       | /project/cache  |
| `APPLICATION_LOGS`   | Application logs dir (inside the container).        | /project/logs   |

<a name='dependencies'></a>

2### Переменные phpMyAdmin

| Переменная окружения | Описание                                                                                                     | По умолчанию |
| -------------------- | ------------------------------------------------------------------------------------------------------------ | ------------ |
| `PMA_ARBITRARY`      | When set to 1 connection to the server will be allowed.                                                      | 1            |
| `PMA_HOST`           | Define address/host name of the MySQL server.                                                                | mysql        |
| `PMA_HOSTS`          | Define comma separated list of address/host names of the MySQL servers. Used only if `PMA_HOST` is empty.    |              |
| `PMA_PORT`           | Define port of the MySQL server.                                                                             | 3306         |
| `PMA_VERBOSE`        | Define verbose name of the MySQL server.                                                                     |              |
| `PMA_VERBOSES`       | Define comma separated list of verbose names of the MySQL servers. Used only if `PMA_VERBOSE` is empty.      |              |
| `PMA_USER`           | Define username to use for config authentication method.                                                     | phalcon      |
| `PMA_PASSWORD`       | Define password to use for config authentication method.                                                     | secret       |
| `PMA_ABSOLUTE_URI`   | The fully-qualified path (e.g. https://pma.example.net/) where the reverse proxy makes phpMyAdmin available. |              |

*Смотрите также* * https://docs.phpmyadmin.net/en/latest/setup.html#installing-using-docker * https://docs.phpmyadmin.net/en/latest/config.html#config * https://docs.phpmyadmin.net/en/latest/setup.html

<a name='dependencies'></a>

3## Удаленный отладчик Xdebug (PhpStorm)

Из соображений отладки приложения, вы можете настроить Xdebug, передав необходимые параметры (см. variables.env).

| Environment variable         | Description                                              | Default |
| ---------------------------- | -------------------------------------------------------- | ------- |
| `XDEBUG_REMOTE_HOST`         | `php.ini` value for `xdebug.remote_host` (your host IP). |         |
| `XDEBUG_REMOTE_PORT`         | `php.ini` value for `xdebug.remote_port`.                | 9000    |
| `XDEBUG_REMOTE_AUTOSTART`    | `php.ini` value for `xdebug.remote_autostart`.           | Off     |
| `XDEBUG_REMOTE_CONNECT_BACK` | `php.ini` value for `xdebug.remote_connect_back`.        | Off     |

*Обратите внимание* Вы можете получить ваш IP адрес используя команду, как показано ниже:

```bash
# Linux/MacOS
ifconfig en1 | grep inet | awk '{print $2}' | sed 's/addr://' | grep .

# Windows
ipconfig
```

<a name='dependencies'></a>

4## Устранение неполадок

<a name='dependencies'></a>

5### Ошибки запуска или связывания

Если у вас возникли проблемы с контейнером приложения, вы можете безопасно пересобрать его, без потери данных:

```bash
docker-compose stop
docker-compose rm --force app
docker-compose build --no-cache app
docker-compose up -d
```

<a name='dependencies'></a>

6### Полный сброс

Для сброса всех контейнеров, а также удаления всех данных (mysql, elasticsearch, и т.д.), кроме файлов проекта в директории `application`, используйте следующий набор команд:

```bash
docker-compose stop
docker-compose rm --force
docker-compose build --no-cache
docker-compose up -d
```

<a name='dependencies'></a>

7### Обновление зависимостей

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

Linux/macOs пользователи, вместо этого, могут воспользоваться `make`:

```bash
make reset
```

<a name='dependencies'></a>

8## Версии

Основные инструменты: Phalcon, Docker и Docker Compose.

| Application     | Version          |
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