---
layout: default
language: 'it-it'
version: '5.0'
title: 'Testing Environment'
keywords: 'testing environment, codeception, testing, phpunit, tests'
---

# Testing Environment
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

# Overview
Phalcon has always had a small development community and not that many pull requests, offering bug fixes and enhancements, compared to other PHP frameworks. This was primarily due to the fact that most developers do not really know C. To help developers contribute, we have created a new language called [Zephir][zephir], which has a very similar syntax to PHP or Javascript. In [2003][2003], we announced this plan and a few months later we released the language and rewrote all the Phalcon code in Zephir. We have been using Zephir ever since for developing Phalcon.

# The Problem
Having a framework that is rich in features requires a development environment that will offer all those features and related services. For instance one needs to install `MySQL`, `Postgresql` and `Sqlite` to be able to check whether functionality in the ORM will be the same when using any of these adapters for your database needs. Additionally, the relevant extensions for PHP have to be installed in the development system.

When looking at all the functionality that Phalcon offers, just to run the testing suite, one needs a great number of extensions as well as services installed (Redis, Memcached etc.)

If one considers the PHP version also (PHP 7.4, 8.0 etc.), developing for Phalcon is not an easy task, because of all these prerequisites.

# Solution
We had a good solution with `nanobox` in the past but since that project has been discontinued, we redoubled our efforts and used docker for our needs. With a few commands, developers can be contributing to phalcon as well as running the tests in no time.

# Installation
You will first need to have `docker` installed on your machine. Instructions on how to do that, can be found [here][docker_installation]. Additionally, we will need `docker-compose`. Installation instructions can be found [here][docker_compose]

# Running the Environment
## Fork the Repository
Fork the [cphalcon][cphalcon] to your GitHub account, if you have not done so already. Visit the [cphalcon][cphalcon] page on your browser and click the `Fork` button at the top right of the screen.

## Clone the Fork
Now you will need to clone the forked repository to a folder of your choice. The example below assumes that the GitHub account is `niden` - change it to your own.

```bash
git clone git@github.com:niden/cphalcon
```

## Build the environment
Once you are in `cphalcon` folder (or wherever you cloned the repository), you will need to build the containers
```bash
docker-compose build 
```

This will be a lengthy process, depending on the specifications of your machine. This process is not run frequently, only when there are changes in the dockerfiles.

## Start the environment
Once all the containers have been built, you will need to start it. You can start it with the containers exposing ports to your host or without.

```bash
docker-compose up -d
```
The above command uses the `docker-compose.yml` file from the repository. The `-d` command runs the environment in the background, and you can reuse your terminal. Without this option, you will have to use `Ctrl-C` to stop it.

With the above command, the services containers will bind their respective ports to your host.

| Service    | Port |
| ---------- | ---- |
| `mysql`    | 3306 |
| `postgres` | 5432 |
| `redis`    | 6379 |

You can then connect to your environment from your host directly. For example to connect to the `mysql` database, you will just need `localhost` as your host, since the 3306 port is bound.

This configuration is very handy and works well for most developers. However, there are developers that work on many projects at the same time, and those projects use the same services (i.e. mysql). Using this configuration will not allow a second environment to work, that uses `mysql` in the same manner, because the `mysql` port on the host is already in use.

You can therefore, use the `docker-compose-local.yml` file, which does not expose ports from the services containers to the host, keeping everything isolated.

```bash
docker-compose -f docker-compose-local.yml up -d
```
If you use the above command to start your environment, you will need to know the IP address of a service container that you need to connect to. If, for instance, you need to connect to the `mysql` container, using `localhost` as your host will not work. You will need to find the correct IP address:

```bash
docker inspect cphalcon-mysql
```

`cphalcon-mysql` is the name for the `mysql` service. You can check the `docker-compose-local.yml` file if you are interested in finding the names of the containers. The above command will produce:

```bash
[
    {
        "Id": "121513ec37c31bcb717526b5f792e373534a9d7187db5d919d30e8c89a7cc897",
        "Created": "2022-09-01T16:05:38.440859071Z",
        "Path": "docker-entrypoint.sh",
        "Args": [
            "mysqld"
        ],
//........
        "NetworkSettings": {
            "Networks": {
                "cphalcon_default": {
                    "IPAMConfig": null,
                    "Links": null,
                    "Aliases": [
                        "mysql",
                        "121513ec37c3"
                    ],
                    "NetworkID": "3be8b1ff3f87e11bd60c568d3a5ca04d0cd6b07779bcbe585eaac12f60bf26c9",
                    "EndpointID": "d0940c441edf26b573e2f42f7f659666c4c1535394843bc0e115ddbac947420b",
                    "Gateway": "172.18.0.1",
                    "IPAddress": "172.18.0.4",
                    "IPPrefixLen": 16,
                    "IPv6Gateway": "",
                    "GlobalIPv6Address": "",
                    "GlobalIPv6PrefixLen": 0,
                    "MacAddress": "02:42:ac:12:00:04",
                    "DriverOpts": null
                }
            }
        }
    }
]
```
Then you can connect to the container using the `IPAddress`

```bash
mysql -uroot -p -h172.18.0.4
```

## Stop the environment
To stop the environment you can press `Ctrl-C` if you have not used the `-d` flag. If you have, you will need to tell docker that you no longer wish the environment to be up:

```bash
docker-compose down
```

## Enter the Environment
To enter the environment, we will need to tell docker, which one we need. There are three environments built for us:

- `cphalcon-7.4`
- `cphalcon-8.0`
- `cphalcon-8.1`

Each of those represents the PHP version that they have installed.

To enter the PHP 8.1 environment, we need:

```bash
docker exec -it cphalcon-8.1 /bin/bash
```
The following prompt will appear:

```bash
root@cphalcon-81:/srv# 
```

You are now inside the environment with all the extensions and services you need.

To exit the environment, all you need is to type `exit` and press the enter key.

```bash
root@cphalcon-81:/srv# exit 
```

## Aliases
The environments come with predefined aliases for your terminal. You can find them all in the `.bashrc` file under the `docker/` folder and relevant PHP version subfolder. Some of these are:

| Alias              | Command                                                       |
| ------------------ | ------------------------------------------------------------- |
| `g`                | git                                                           |
| `h`                | history                                                       |
| `l`                | ls -lF ${colorflag}                                           |
| `ll`               | LC_ALL="C.UTF-8" ls -alF                                      |
| `zephir`           | ./zephir                                                      |
| `zf`               | ./zephir fullclean                                            |
| `zg`               | ./zephir generate                                             |
| `zs`               | ./zephir stubs                                                |
| `cpl`              | zf && zg && cd ext/ && ./install && ..                        |
| `codecept`         | php -d extension=ext/modules/phalcon.so ./vendor/bin/codecept |
| `phpcs`            | php -d extension=ext/modules/phalcon.so ./vendor/bin/phpcs    |
| `phpcbf`           | php -d extension=ext/modules/phalcon.so ./vendor/bin/phpcbf   |
| `psalm`            | php ./vendor/bin/psalm                                        |
| `test-unit`        | Run all unit tests                                            |
| `test-cli`         | Run all cli tests                                             |
| `test-integration` | Run all integration tests                                     |
| `test-db-common`   | Run all common database tests                                 |
| `test-db-mysql`    | Run all `mysql` tests                                         |
| `test-db-pgsql`    | Run all `postgesql` tests                                     |
| `test-db-sqlite`   | Run all `sqlite` tests                                        |
| `test-db`          | Run all database tests                                        |
| `test-all`         | Run all tests                                                 |

## Composer
Just in case update composer:

```bash
root@cphalcon-81:/srv# composer install
```

## Check Zephir
Zephir is already installed in the environment. Just check it:

```bash
root@cphalcon-81:/srv# zephir 
```
A screen like the one below should appear (output formatted for reading):

```bash
 _____              __    _
/__  /  ___  ____  / /_  (_)____
  / /  / _ \/ __ \/ __ \/ / ___/
 / /__/  __/ /_/ / / / / / /
/____/\___/ .___/_/ /_/_/_/
         /_/

Zephir 0.16.2 by Andres Gutierrez and Serghei Iakovlev (3e961ab)

Usage:
  command [options] [arguments]

Options:
      --dumpversion  Print the version of the compiler and don't 
                     do anything else (also works with a single hyphen)
  -h, --help         Print this help message
      --no-ansi      Disable ANSI output
  -v, --verbose      Displays more detail in error messages from 
                     exceptions generated by commands (can also disable with -V)
      --vernum       Print the version of the compiler as integer
      --version      Print compiler version information and quit

Available commands:
  api        Generates a HTML API based on the classes exposed in the extension
  build      Generates/Compiles/Installs a Zephir extension
  clean      Cleans any object files created by the extension
  compile    Compile a Zephir extension
  fullclean  Cleans any object files created by the extension 
             (including files generated by phpize)
  generate   Generates C code from the Zephir code without compiling it
  help       Display help for a command
  init       Initializes a Zephir extension
  install    Installs the extension in the extension directory 
             (may require root password)
  stubs      Generates stubs that can be used in a PHP IDE
```

## Compile Phalcon
Phalcon is not compiled yet. We need to instruct Zephir to do that:

```bash
root@cphalcon-81:/srv# cpl
```

## Check Extensions
Type

```bash
root@cphalcon-81:/srv# php -m
```

and you will see:

```bash
[PHP Modules]
apcu
Core
ctype
....
PDO
pdo_mysql
pdo_pgsql
pdo_sqlite
phalcon
Phar
psr
redis
...

[Zend Modules]
Xdebug
```

Once you see `phalcon` in the list, you have the extension compiled and ready to use.

## Setup databases

First, we need to have a `.env` file in the project root.

```bash
root@cphalcon-81:/srv# cp tests/_config/.env.docker .env
```

# Running Tests
## Unit
Now that the environment is set up, we need to run the tests. The testing framework Phalcon uses is [Codeception][codeception]. For a basic introduction you can check [this][codeception_introduction] page. Also, for the list of the commands, you can check [here][codeception_commands].

We need to first build the Codeception base classes. This needs to happen every time new functionality is introduced in Codeception's helpers.

Now you can run:
```bash
root@cphalcon-81:/srv# codecept build
```
The output should show:
```bash
Building Actor classes for suites: cli, database, integration, unit
 -> CliTesterActions.php generated successfully. 152 methods added
\CliTester includes modules: Asserts, Cli, \Helper\Cli, \Helper\Unit
 -> DatabaseTesterActions.php generated successfully. 252 methods added
\DatabaseTester includes modules: Phalcon4, Redis, Asserts, Filesystem, Helper\Database, Helper\Unit
 -> IntegrationTesterActions.php generated successfully. 251 methods added
\IntegrationTester includes modules: Phalcon4, Redis, Asserts, Filesystem, Helper\Integration, Helper\PhalconLibmemcached, Helper\Unit
 -> UnitTesterActions.php generated successfully. 166 methods added
\UnitTester includes modules: Apc, Asserts, Filesystem, Helper\Unit
```

Now we can run the tests:

```bash
root@cphalcon-81:/srv# test-unit
```

This will start running the unit testing suite. You will see a lot of tests and assertions. At the time of this article, we have `Tests: 2780, Assertions: 8965, Skipped: 34` unit tests. The reason for so many skipped tests is that we created test stubs for every component and every method in each component. This was to create awareness on what needs to be checked and what components/methods we need to write tests for. Of course some test stubs are duplicate or obsolete. Those will be deleted once the relevant component is checked and tests written for it. Our goal is to get as close to 100% code coverage as possible. If we manage to get to 100% that would be great!

Execute all tests from a folder:

```bash
root@cphalcon-81:/srv# codecept run tests/unit/some/folder/
```

Execute single test:

```bash
root@cphalcon-81:/srv# codecept run tests/unit/some/folder/some/test/file.php
```

## Database
To run database related tests you can use the relevant aliases:

```bash
root@cphalcon-81:/srv# test-db-common
root@cphalcon-81:/srv# test-db-mysql 
root@cphalcon-81:/srv# test-db-pgsql 
root@cphalcon-81:/srv# test-db-sqlite
root@cphalcon-81:/srv# test-db       
```

# Development
You can now open your favorite editor and start developing in Zephir. You can create new functionality, fix issues, write tests etc. Remember though that if you change any of the `zep` files (inside the `phalcon` folder), you will need to recompile the extension:

```bash
root@cphalcon-81:/srv# cpl
```
and then you can run your tests

```bash
root@cphalcon-81:/srv# codecept run tests/unit/somefolder/somecestfile:sometest
```

For Zephir documentation, you can visit the [Zephir Docs][zephir_docs] site.

# Services
The available services are:
- Memcached
- Mysql
- Postgresql
- Redis

The PHP extensions enabled are:
- apcu
- ctype
- curl
- dom
- fileinfo
- gd
- gmp
- gettext
- imagick
- iconv
- igbinary
- intl
- json
- memcached
- mbstring
- mongodb
- opcache
- phar
- pdo
- pdo_mysql
- pdo_pgsql
- pdo_sqlite
- redis
- session
- simplexml
- sqlite3
- tokenizer
- yaml
- zephir_parser
- xdebug
- xml
- xmlwriter
- zip
- zlib

The database dumps are located under `tests/_data/assets/schemas`

If you have any questions, feel free to join us in our [Discord][discord] server or our [Discussions][discussions].


<3 Phalcon Team


[2003]: https://blog.phalcon.io/post/phalcon-2-0-the-future
[cphalcon]: https://github.com/phalcon/cphalcon
[codeception]: https://codeception.com
[codeception_commands]: https://codeception.com/docs/reference/Commands
[codeception_introduction]: https://codeception.com/docs/01-Introduction
[discord]: https://phalcon.io/discord
[docker_installation]: https://docs.docker.com/engine/installation/
[docker_compose]: https://docs.docker.com/compose/install/
[discussions]: https://phalcon.io/discussions
[zephir]: https://zephir-lang.com
[zephir_docs]: https://docs.zephir-lang.com
