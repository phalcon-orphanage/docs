---
layout: default
language: 'it-it'
version: '4.0'
title: 'Testing Environment'
keywords: 'testing environment, codeception, nanobox, testing, phpunit, tests'
---

# Testing Environment

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

# Overview

Phalcon has always had a small development community and not that many pull requests, offering bug fixes and enhancements, compared to other PHP frameworks. This was primarily due to the fact that most developers do not really know C. To help developers contribute, we have created a new language called [Zephir](https://zephir-lang.com), which has a very similar syntax to PHP or Javascript. In [2003](https://blog.phalcon.io/post/phalcon-2-0-the-future) we announced this plan and a few months later we released the language and rewrote all the Phalcon code in Zephir. We have been using Zephir ever since for developing Phalcon.

# The Problem

Having a framework that is rich in features requires a development environment that will offer all those features and related services. For instance one needs to install `MySQL`, `Postgresql` and `Sqlite` to be able to check whether functionality in the ORM will be the same when using any of these adapters for your database needs. Additionally the relevant extensions for PHP have to be installed in the development system.

When looking at all the functionality that Phalcon offers, just to run the testing suite, one needs a great number of extensions as well as services installed (Redis, Memcached, Beanstalkd etc.)

If one considers the PHP version also (PHP 7.2, 7.3 etc.), developing for Phalcon is not an easy task, because of all these prerequisites.

# Solution

We have tried in the past to create a development environment based on docker, but after a while, maintaining this environment was very taxing for the core team.

Recently however, we have redoubled our efforts to create this environment and we decided to use [nanobox](https://nanobox.io). For those that do not know, nanobox is a "wrapper" to docker which creates a unique environment in your machine, ready to use. The environment is folder based so you could potentially have two folders where you have cloned Phalcon, and use the PHP 7.2 on one and the 7.3 on the other. Each of those environments is completely isolated. We have been using nanobox for a while now and it is working extremely well.

# Installation

You will first need to have docker installed on your machine. Instructions on how to do that, can be found [here](https://docs.docker.com/engine/installation/).

Go to <https://nanobox.io> and create an account if you do not have one already, so that you can download the nanobox installation file for your platform.

Once the file is downloaded, install it.

# Running the Environment

## Fork the Repository

Fork the [cphalcon](https://github.com/phalcon/cphalcon) to your github account, if you have not done so already. Visit the [cphalcon](https://github.com/phalcon/cphalcon) page on your browser and click the `Fork` button at the top right of the screen.

## Clone the Fork

Now you will need to clone the forked repository to a folder of your choice. The example below assumes that the github account is `niden` - change it to your own.

```bash
git clone git@github.com:niden/cphalcon
```

## Copy the Boxfile

Nanobox reads a file called `boxfile.yml` and located in the root of your folder. There are two files supplied in Phalcon that you can use to develop with. One for PHP 7.2 and one for 7.3. Copy one of them to the root of the folder you have cloned your repository.

```bash
cd ./cphalcon
cp -v ./tests/_ci/nanobox/boxfile.7.2.yml ./boxfile.yml

```

You will now end up with a `boxfile.yml` file at the root of your project.

## Configure Nanobox

Now we need to run nanobox for the first time. Since this will be the first time you run nanobox, it will ask you to configure it. The installation is very simple

```bash
nanobox run
```

It will ask you to log in first. Type your nanobox username and password, the same credentials you used when creating the nanobox account, so that you can download the installation file.

```bash
$ nanobox login
Nanobox Username: niden
Nanobox Password: 
```

You will also need to configure nanobox. The next step is to decide how you want nanobox to work. There are two options * a lightweight VM (Virtualbox) * docker native

It is highly recommended you use docker (hence the requirement above to ensure that you have docker installed).

```bash
CONFIGURE NANOBOX
---------------------------------------------------------------
Please answer the following questions so we can customize your
nanobox configuration. Feel free to update your config at any
time by running: 'nanobox configure'

(Learn more at : https://docs.nanobox.io/local-config/configure-nanobox/)

How would you like to run nanobox?
  a) Inside a lightweight VM
  b) Via Docker Native

  Note : Mac users, we strongly recommend choosing (a) until Docker Native
         resolves an issue causing slow speeds : http://bit.ly/2jYFfWQ

Answer: 
```

## Run Nanobox

After finishing the configuration, you will see nanobox trying to download a lot of packages and containers. This is normal and it is going to take a while depending on the connection speed you have. After packages and containers are downloaded, subsequent runs will use cached copies of those packages (unless there is an update).

Once the whole process finishes, you will end up with a screen that looks like this:

```bash
Preparing environment :


                                   **
                                ********
                             ***************
                          *********************
                            *****************
                          ::    *********    ::
                             ::    ***    ::
                           ++   :::   :::   ++
                              ++   :::   ++
                                 ++   ++
                                    +
                    _  _ ____ _  _ ____ ___  ____ _  _
                    |\ | |__| |\ | |  | |__) |  |  \/
                    | \| |  | | \| |__| |__) |__| _/\_

--------------------------------------------------------------------------------
+ You are in a Linux container
+ Your local source code has been mounted into the container
+ Changes to your code in either the container or desktop will be mirrored
+ If you run a server, access it at >> 172.18.0.2
--------------------------------------------------------------------------------
```

You are now inside the environment with all the extensions and services you need. Please note that the IP shown will most likely be different than the one displayed above.

## Composer

Just in case update composer:

```bash
/app $ composer install
```

## Check Zephir

Zephir is already installed in the environment. Just check it:

```bash
/app $ zephir help
```

A screen like the one below should appear:

```bash
Usage:
  help [options] [--] [<command_name>]

Arguments:
  command               The command to execute
  command_name          The command name [default: "help"]

Options:
      --format=FORMAT   The output format (txt, xml, json, or md) [default: "txt"]
      --raw             To output raw command help
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
      --dumpversion     Print the Zephir version — and don't do anything else
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Help:
  The help command displays help for a given command:

    php /data/bin/zephir help list

  You can also output the help in other formats by using the --format option:

    php /data/bin/zephir help --format=xml list

  To display the list of available commands, please use the list command.
```

## Compile Phalcon

Phalcon is not compiled yet. We need to instruct Zephir to do that:

```bash
/app $ zephir fullclean
/app $ zephir build
```

## Check Extensions

Type

```bash
/app $ php -m
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

Note that Phalcon v4+ requires the [PSR](https://github.com/jbboehr/php-psr) extension to be loaded before Phalcon. In this environment we have compiled it for you. Once you see `phalcon` in the list, you have the extension compiled and ready to use.

## Setup databases

First, we need to have a `.env` file in the project root.

```bash
/app $ cp tests/_ci/nanobox/.env.example .env
```

To generate the necessary database schemas, you need to run the relevant script:

```bash
/app $ php tests/_ci/generate-db-schemas.php
```

The script looks for classes located under `tests/_data/fixtures/Migrations`. These classes contain the necessary code to create the relevant SQL statements for each RDBMS. You can easily inspect one of those files to understand its structure. Additionally, these migration classes can be instantiated in your tests to clear the target table, insert new records etc. This methodology allows us to create the database schema per RDBMS, which will be loaded automatically from Codeception, but also allows us to clear tables and insert data we need to them so that our tests are more controlled and isolated.

If there is a need to add an additional table, all you have to do is create the Phalcon model of course but also create the migration class with the relevant SQL statements. Running the generate script (as seen above) will update the schema file so that Codeception can load it in your RDBMS prior to running the tests.

To populate the databases you will need to run the following script:

```bash
/app $ tests/_ci/nanobox/setup-dbs-nanobox.sh
```

# Running Tests

## Unit

Now that the environment is set up, we need to run the tests. The testing framework Phalcon uses is [Codeception](https://codeception.com). For a basic introduction you can check [this](https://codeception.com/docs/01-Introduction) page. Also for the list of the commands, you can check [here](https://codeception.com/docs/reference/Commands).

We need to first build the Codeception base classes. This needs to happen every time new functionality is introduced in Codeception's helpers.

Now you can run:

```bash
/app $ vendor/bin/codecept build
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
/app $ php vendor/bin/codecept run unit
```

This will start running the unit testing suite. You will see a lot of tests and assertions. At the time of this article, we have `Tests: 3235, Assertions: 8244, Skipped: 175` unit tests. The reason for so many skipped tests is because we created test stubs for every component and every method in each component. This was so as to create awareness on what needs to be checked and what components/methods we need to write tests for. Of course some of the test stubs are duplicate or obsolete. Those will be deleted once the relevant component is checked and tests written for it. Our goal is to get as close to 100% code coverage as possible. If we manage to get to 100% that would be great!

Execute all tests from a folder:

```bash
/app $ php vendor/bin/codecept run tests/unit/some/folder/
```

Execute single test:

```bash
/app $ php vendor/bin/codecept run tests/unit/some/folder/some/test/file.php
```

## Database

To run database related tests you need to run the `database` suite specifying the RDBMS and group:

```bash
/app $ php vendor/bin/codecept run tests/database -g common
/app $ php vendor/bin/codecept run tests/database -g mysql --env mysql
/app $ php vendor/bin/codecept run tests/database -g sqlite --env sqlite
/app $ php vendor/bin/codecept run tests/database -g pgsql --env pgsql
```

Available options:

```bash
--env mysql
--env sqlite
--env pgsql
```

If you need to access the databases themselves, you will need the connection information. Nanobox creates that for you and stores it in environment variables. You can easily check those variables and if need be write them down.

Open a separate terminal and navigate to the same folder where you have nanobox running from and type:

```bash
cd ./cphalcon/
nanobox info local
```

You will see an output as the one below:

```bash
----------------------------------------------
cphalcon (dev)              Status: up
----------------------------------------------

Mount Path: /home/niden/cphalcon
Env IP: 172.20.0.20

data.memcached
  IP      : 172.20.0.23

data.mongodb
  IP      : 172.20.0.24

data.mysql
  IP      : 172.20.0.25
  User(s) :
    root - 9IqTGEVM2M
    nanobox - yXOMmf71NS

data.postgres
  IP      : 172.20.0.21
  User(s) :
    nanobox - exwjG6g6rm

data.redis
  IP      : 172.20.0.22

Environment Variables
  DATA_MONGODB_HOST = 172.20.0.24
  DATA_MYSQL_HOST = 172.20.0.25
  DATA_MYSQL_ROOT_PASS = 9IqTGEVM2M
  DATA_MYSQL_USER = nanobox
  DATA_POSTGRES_PASS = exwjG6g6rm
  APP_NAME = dev
  DATA_MYSQL_NANOBOX_PASS = yXOMmf71NS
  DATA_MYSQL_USERS = root nanobox
  DATA_POSTGRES_HOST = 172.20.0.21
  DATA_POSTGRES_USER = nanobox
  DATA_MEMCACHED_HOST = 172.20.0.23
  DATA_POSTGRES_NANOBOX_PASS = exwjG6g6rm
  DATA_POSTGRES_USERS = nanobox
  DATA_REDIS_HOST = 172.20.0.22
  DATA_MYSQL_PASS = yXOMmf71NS

DNS Aliases
  none
```

You can use these variables to connect to your databases or other services such as Mongo, Redis etc.

# Development

You can now open your favorite editor and start developing in Zephir. You can create new functionality, fix issues, write tests etc. Remember though that if you change any of the `zep` files (inside the `phalcon` folder), you will need to recompile the extension:

```bash
/app $ zephir fullclean
/app $ zephir build
```

and then you can run your tests

```bash
/app $ codecept run tests/unit/somefolder/somecestfile:sometest
```

For Zephir documentation, you can visit the [Zephir Docs](https://docs.zephir-lang.com) site.

# Services

The available services are: - Memcached - Mongodb - Mysql - Postgresql - Redis

The PHP extensions enabled are: - apcu - ctype - curl - dom - fileinfo - gd - gmp - gettext - imagick - iconv - igbinary - intl - json - memcached - mbstring - mongodb - opcache - phar - pdo - pdo_mysql - pdo_pgsql - pdo_sqlite - redis - session - simplexml - sqlite3 - tokenizer - yaml - zephir_parser - xdebug - xml - xmlwriter - zip - zlib

The database dumps are located under `tests/_data/assets/schemas`

If you have any questions, feel free to join us in our [Discord](https://phalcon.io/discord) server or our [Forum](https://forum.phalcon.io).

<3 Phalcon Team
