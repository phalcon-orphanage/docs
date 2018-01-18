<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Overview</a> 
      <ul>
        <li>
          <a href="#dependencies">Dependencies</a>
        </li>
        <li>
          <a href="#services">Services</a>
        </li>
        <li>
          <a href="#installation">Installation</a> 
          <ul>
            <li>
              <a href="#installation-composer">With Composer (recommended)</a>
            </li>
            <li>
              <a href="#installation-git">With Git</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#configuration">Configuration</a>
        </li>
        <li>
          <a href="#usage">Sposób użycia</a>
        </li>
        <li>
          <a href="#setup">Konfiguracja</a>
        </li>
        <li>
          <a href="#logs">Logi</a>
        </li>
        <li>
          <a href="#environment-variables">Environment variables</a> 
          <ul>
            <li>
              <a href="#environment-variables-web">Web environment</a>
            </li>
            <li>
              <a href="#environment-variables-phpmyadmin">phpMyAdmin variables</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#xdebug">Xdebug Remote debugger (PhpStorm)</a>
        </li>
        <li>
          <a href="#troubleshooting">Troubleshooting</a> <ul>
            <li>
              <a href="#troubleshooting-startup">Startup or linking errors</a>
            </li>
            <li>
              <a href="#troubleshooting-full-reset">Full reset</a>
            </li>
            <li>
              <a href="#troubleshooting-dependencies">Updating dependencies</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#versions">Versions</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Overview

Phalcon Compose is a community driven boilerplate development environment for Phalcon projects that runs on Docker. Its purpose is to make it easier to bootstrap Phalcon applications and run them on development or production environments.

<a name='dependencies'></a>

## Dependencies

To run this stack on your machine, you need at least:

* Operating System: Windows, Linux, or OS X
* [Docker Engine](https://docs.docker.com/installation/) >= 1.10.0
* [Docker Compose](https://docs.docker.com/compose/install/) >= 1.6.2

<a name='services'></a>

## Services

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

## Installation

<a name='installation-composer'></a>

### With Composer (recommended)

Using Composer, you can create a new project as follows:

$ `composer create-project phalcon/compose --prefer-dist <folder name>`

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

### With Git

Another way to initialize your project is with Git.

$ `git clone git@github.com:phalcon/phalcon-compose.git`

<div class="alert alert-warning">
    <p>
        Make sure that you copy <code>variables.env.example</code> to <code>variables.env</code> and adjust the settings in that file.
    </p>
</div>

Add your Phalcon Application into `application` folder.

<a name='configuration'></a>

## Configuration

Add `phalcon.local` (or your preferred host name) in your `/etc/hosts` file as follows:

$ `127.0.0.1 www.phalcon.local phalcon.local`

<a name='usage'></a>

## Sposób użycia

You can now build, create, start, and attach to containers to the environment for your application. To build the containers use following command inside the project root:

$ `docker-compose build`

To start the application and run the containers in the background, use following command inside project root:

You can use here your prefered project name with `-p <my-app>` parameter

$ `docker-compose up -d`

Now setup your project in the app container using the Phalcon Developer Tools

Replace project in **<project_app_1>** with the name of your project/directory (shown in the output of `docker-compose up -d`)

$ `docker exec -t <project_app_1> phalcon project application simple`

Now you can now launch your application in your browser visiting `http://phalcon.local` (or the host name you chose above).

<a name='setup'></a>

## Konfiguracja

If your application uses a file cache or writes logs to files, you can set up your cache and log folders as follows:

| Directory | Ścieżka          |
| --------- | ---------------- |
| Cache     | `/project/cache` |
| Logs      | `/project/log`   |

<a name='logs'></a>

## Logi

For most containers you can access the logs using the `docker logs <container_name>` command in your host machine.

<a name='environment-variables'></a>

## Environment variables

You can pass multiple environment variables from an external file to a service's containers by editing the `variables.env` file.

<a name='environment-variables-web'></a>

### Web environment

| Environment variable | Description                                         | Domyślne        |
| -------------------- | --------------------------------------------------- | --------------- |
| `WEB_DOCUMENT_ROOT`  | Document root for webserver (inside the container). | /project/public |
| `WEB_DOCUMENT_INDEX` | Index document.                                     | index.php       |
| `WEB_ALIAS_DOMAIN`   | Domain aliases.                                     | *.vm            |
| `WEB_PHP_SOCKET`     | PHP-FPM socket address.                             | 127.0.0.1:9000  |
| `APPLICATION_ENV`    | Application environment.                            | development     |
| `APPLICATION_CACHE`  | Application cache dir (inside the container).       | /project/cache  |
| `APPLICATION_LOGS`   | Application logs dir (inside the container).        | /project/logs   |

<a name='environment-variables-phpmyadmin'></a>

### phpMyAdmin variables

| Environment variable | Description                                                                                                  | Domyślne |
| -------------------- | ------------------------------------------------------------------------------------------------------------ | -------- |
| `PMA_ARBITRARY`      | When set to 1 connection to the server will be allowed.                                                      | 1        |
| `PMA_HOST`           | Define address/host name of the MySQL server.                                                                | mysql    |
| `PMA_HOSTS`          | Define comma separated list of address/host names of the MySQL servers. Used only if `PMA_HOST` is empty.    |          |
| `PMA_PORT`           | Define port of the MySQL server.                                                                             | 3306     |
| `PMA_VERBOSE`        | Define verbose name of the MySQL server.                                                                     |          |
| `PMA_VERBOSES`       | Define comma separated list of verbose names of the MySQL servers. Used only if `PMA_VERBOSE` is empty.      |          |
| `PMA_USER`           | Define username to use for config authentication method.                                                     | phalcon  |
| `PMA_PASSWORD`       | Define password to use for config authentication method.                                                     | secret   |
| `PMA_ABSOLUTE_URI`   | The fully-qualified path (e.g. https://pma.example.net/) where the reverse proxy makes phpMyAdmin available. |          |

*See also*

* https://docs.phpmyadmin.net/en/latest/setup.html#installing-using-docker
* https://docs.phpmyadmin.net/en/latest/config.html#config
* https://docs.phpmyadmin.net/en/latest/setup.html

<a name='xdebug'></a>

## Xdebug Remote debugger (PhpStorm)

For debugging purposes you can setup Xdebug by passing required parameters (see variables.env).

| Environment variable         | Description                                       | Domyślne       |
| ---------------------------- | ------------------------------------------------- | -------------- |
| `XDEBUG_REMOTE_HOST`         | `php.ini` value for `xdebug.remote_host`.         | (your host IP) |
| `XDEBUG_REMOTE_PORT`         | `php.ini` value for `xdebug.remote_port`.         | 9000           |
| `XDEBUG_REMOTE_AUTOSTART`    | `php.ini` value for `xdebug.remote_autostart`.    | Off            |
| `XDEBUG_REMOTE_CONNECT_BACK` | `php.ini` value for `xdebug.remote_connect_back`. | Off            |

*NOTE* You can find your local IP address as follows:

**Linux/macOS**

$ `ifconfig en1 | grep inet | awk '{print $2}' | sed 's/addr://' | grep .`

**Windows**

&gt; `ipconfig`

<a name='troubleshooting'></a>

## Troubleshooting

<a name='troubleshooting-startup'></a>

### Startup or linking errors

If you got any startup issues you can try to rebuild app container. There will be no loss of data., it is a safe reset:

```bash
docker-compose stop
docker-compose rm --force app
docker-compose build --no-cache app
docker-compose up -d
```

<a name='troubleshooting-full-reset'></a>

### Full reset

To reset all containers, delete all data (mysql, elasticsearch, etc.) but not your project files in `application` folder:

```bash
docker-compose stop
docker-compose rm --force
docker-compose build --no-cache
docker-compose up -d
```

<a name='troubleshooting-dependencies'></a>

### Updating dependencies

Sometimes the base images (for example `phalconphp/php-apache:ubuntu-16.04`) are updated. Phalcon Compose depends on these images. You will therefore need to update them and it is always a good thing to do so to ensure that you have the latest functionality available. The dependent containers to these images will need to be updated and rebuilt:

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

Linux/MacOS users can use `make` to perform the task:

$ `make pull`

Then you have to reset all containers, delete all data, rebuild services and restart application.

Linux/MacOS users can use `make` to perform the task:

$ `make reset`