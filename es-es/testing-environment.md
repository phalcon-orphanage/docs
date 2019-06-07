---
layout: default
language: 'es-es'
version: '4.0'
---

# Entorno de prueba

* * *

# Preámbulo

La comunidad de Phalcon es pequeña y no cuenta con muchos *pull requests*, correcciones de errores o mejoras comparada con otros *frameworks* de PHP. Esto se debía principalmente a que la mayoría de desarrolladores no sabe programar en C. Por este motivo se creo [Zephir](https://zephir-lang.com), un nuevo lenguaje con una sintaxis similar a la de PHP o JavaScript. En 2003 se presentó [este plan](https://blog.phalconphp.com/post/phalcon-2-0-the-future) y algunos meses después se lanzó Zephir y Phalcon fue completamente reescrito en él. Desde entonces se utiliza Zephir para el desarrollo de Phalcon.

# El problema

Un *framework* rico en características necesita un entorno de desarrollo con todos los servicios necesarios para utilizarlas. Por ejemplo, es necesario tener instalados `MySQL`, `Postgresql` y `Sqlite` para comprobar que la funcionalidad del Mapeo objeto-relacional (ORM, por sus siglas en inglés) será igual en todos los adaptadores según la base de datos que necesite la aplicación. También deben estar instaladas todas las extensiones relevantes de PHP.

Dada toda la funcionalidad que Phalcon ofrece, sólo para ejecutar la suite de pruebas se necesita tener instalado un gran número de extensiones y servicios (Redis, Memcached, Beanstalkd, etc.).

El problema se vuelve más complejo aun si se piensa además en todas las versiones de PHP (7.2, 7.3, etc.) que se deben probar; con todos estos prerrequisitos, el desarrollo de Phalcon no es en definitiva una tarea fácil.

# La solución

Originalmente se ensayó a crear un entorno de desarrollo basado en Docker, pero después de cierto tiempo, la manutención de este entorno se volvió muy dispendiosa para el equipo principal.

Sin embargo recientemente, se decidió redoblar los esfuerzos y recrear este entorno mediante el uso de [nanobox](https://nanobox.io). Nanobox es un *envoltorio* sobre Docker que crea un entorno de desarrollo único en el PC, listo para usar. El entorno se vale del sistema de carpetas y archivos, entonces es posible tener dos carpetas donde se ha clonado Phalcon y ejecutar PHP 7.2 en una y 7.3 en la otra. Cada uno de dichos entornos está completamente aislado. Hasta la fecha, Nanobox funciona muy bien.

# Instalación

El primer paso es tener Docker instalado (Instrucciones de instalación [aquí](https://docs.docker.com/engine/installation/)).

El segundo es ir a <https://nanobox.io> y crear una cuenta o ingresar con una existente para descargar la versión de Nanobox indicada para su sistema operativo.

El tercer paso es instalar la versión descargada.

# Ejecución del entorno

## Clonación (*fork*) del repositorio

Es necesario clonar (*fork*) [cphalcon](https://github.com/phalcon/cphalcon) en su cuenta de Github (si aún no se ha hecho): En la página [cphalcon](https://github.com/phalcon/cphalcon) dé un clic al botón `Fork` en la parte superior derecha de la pantalla.

## Copia del *fork*

Now you will need to clone the forked repository to a folder of your choice. The example below assumes that the github account is `niden` - change it to your own.

```bash
git clone git@github.com:niden/cphalcon
```

## Copy the boxfile

Nanobox reads a file called `boxfile.yml` and located in the root of your folder. There are two files supplied in Phalcon that you can use to develop with. One for PHP 7.2 and one for 7.3. Copy one of them to the root of the folder you have cloned your repository.

```bash
cd ./cphalcon
cp -v ./tests/_ci/nanobox/boxfile.7.2.yml ./boxfile.yml

```

You will now end up with a `boxfile.yml` file at the root of your project.

## Configure nanobox

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

## Run nanobox

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
composer install
```

## Check Zephir

Zephir is already installed in the environment. Just check it:

```bash
zephir help
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
zephir fullclean
zephir build
```

## Check extensions

Type

```bash
php -m
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

# Running tests

## Unit

Now that the environment is set up, we need to run the tests. The testing framework Phalcon uses is [Codeception](https://codeception.com). For a basic introduction you can check [this](http://codeception.com/docs/01-Introduction) page. Also for the list of the commands, you can check [here](http://codeception.com/docs/reference/Commands).

We need to first build the Codeception base classes. This needs to happen every time new functionality is introduced in Codeception's helpers.

```bash
codecept build
```

The output should show:

```bash
Building Actor classes for suites: cli, integration, unit
 -> CliTesterActions.php generated successfully. 0 methods added
\CliTester includes modules: Asserts, Cli, \Helper\Cli, \Helper\Unit
 -> IntegrationTesterActions.php generated successfully. 0 methods added
\IntegrationTester includes modules: Asserts, Filesystem, Helper\Integration, Helper\PhalconLibmemcached, Helper\Unit, Phalcon, Redis
 -> UnitTesterActions.php generated successfully. 0 methods added
\UnitTester includes modules: Asserts, Filesystem, Redis, Helper\Unit, Helper\PhalconCacheFile, Helper\PhalconLibmemcached
```

Now we can run the tests:

```bash
codecept run unit
```

This will start running the unit testing suite. You will see a lot of tests and assertions. At the time of this blog post, we have `Tests: 2884, Assertions: 6987, Skipped: 1478` unit tests. The reason for so many skipped tests is because we created test stubs for every component and every method in each component. This was so as to create awareness on what needs to be checked and what components/methods we need to write tests for. Of course some of the test stubs are duplicate or obsolete. Those will be deleted once the relevant component is checked and tests written for it. Our goal is to get as close to 100% code coverage as possible. If we manage to get to 100% that would be great!

## Integration

Integration tests need to access the databases. These databases are already available in the environment. To populate the databases you will need to run the following script:

```bash
./tests/_ci/nanobox/setup-dbs-nanobox.sh
```

If you need to access the databases themselves, you will need the connection information. Nanobox creates that for you and stores it in environment variables. You can easily check those variables and if need be write them down.

Open a separate terminal and navigate to the same folder where you have nanobox running from and type:

```bash
cd ./cphalcon/
nanobox info local
```

You will see an output as the one below:

```bash
----------------------------------------
cphalcon (dev)              Status: up  
----------------------------------------

Mount Path: /Work/niden/cphalcon
Env IP: 172.18.0.2

data.beanstalkd
  IP      : 172.18.0.4

data.memcached
  IP      : 172.18.0.5

data.mongodb
  IP      : 172.18.0.6

data.mysql
  IP      : 172.18.0.7
  User(s) :
    root - MvquBdnJkv
    nanobox - 12oK9JHiyT

data.postgres
  IP      : 172.18.0.8
  User(s) :
    nanobox - ohhtrUaMEu

data.redis
  IP      : 172.18.0.37

Environment Variables
  DATA_BEANSTALKD_HOST = 172.18.0.4
  DATA_MEMCACHED_HOST = 172.18.0.5
  DATA_MONGODB_HOST = 172.18.0.6
  DATA_MYSQL_ROOT_PASS = MvquBdnJkv
  DATA_POSTGRES_USER = nanobox
  DATA_POSTGRES_PASS = ohhtrUaMEu
  DATA_POSTGRES_USERS = nanobox
  DATA_REDIS_HOST = 172.18.0.37
  APP_NAME = dev
  DATA_MYSQL_NANOBOX_PASS = 12oK9JHiyT
  DATA_MYSQL_PASS = 12oK9JHiyT
  DATA_MYSQL_USERS = root nanobox
  DATA_POSTGRES_HOST = 172.18.0.8
  DATA_POSTGRES_NANOBOX_PASS = ohhtrUaMEu
  DATA_MYSQL_HOST = 172.18.0.7
  DATA_MYSQL_USER = nanobox

DNS Aliases
  none
```

You can use these variables to connect to your databases or other services such as Mongo, Redis etc.

# Development

You can now open your favorite editor and start developing in Zephir. You can create new functionality, fix issues, write tests etc. Remember though that if you change any of the `zep` files (inside the `phalcon` folder), you will need to recompile the extension:

```bash
zephir fullclean
zephir build
```

and then you can run your tests

```bash
codecept run tests/unit/somefolder/somecestfile:sometest
```

For Zephir documentation, you can visit the [Zephir Docs](https://docs.zephir-lang.com) site.

# Servicios

The available services are: - Memcached - Mongodb - Mysql - Postgresql - Redis

The PHP extensions enabled are: - apcu - ctype - curl - dom - fileinfo - gd - gmp - gettext - imagick - iconv - igbinary - json - memcached - mbstring - mongodb - opcache - phar - pdo - pdo_mysql - pdo_pgsql - pdo_sqlite - redis - session - simplexml - tokenizer - yaml - zephir_parser - xdebug - xml - xmlwriter - zip - zlib

The database dumps are located under `tests/_data/assets/db/schemas`

If you have any questions, feel free to join us in our [Discord](https://phalcon.link/discord) server or our [Forum](https://forum.phalconphp.com).

<3 Phalcon Team