---
layout: default
language: 'es-es'
version: '4.0'
title: 'Entorno de prueba'
keywords: 'probando el entorno, codeception, nanobox, testing, phpunit, tests'
---

# Entorno de prueba

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

# Preámbulo

La comunidad de Phalcon es pequeña y no cuenta con muchos *pull requests*, correcciones de errores o mejoras comparada con otros *frameworks* de PHP. Esto se debía principalmente a que la mayoría de desarrolladores no sabe programar en C. Por este motivo se creo [Zephir](https://zephir-lang.com), un nuevo lenguaje con una sintaxis similar a la de PHP o JavaScript. En 2003 se presentó [este plan](https://blog.phalcon.io/post/phalcon-2-0-the-future) y algunos meses después se lanzó Zephir y Phalcon fue completamente reescrito en él. Desde entonces se utiliza Zephir para el desarrollo de Phalcon.

# El problema

Un *framework* rico en características necesita un entorno de desarrollo con todos los servicios necesarios para utilizarlas. Por ejemplo, es necesario tener instalados `MySQL`, `Postgresql` y `Sqlite` para comprobar que la funcionalidad del Mapeo objeto-relacional (ORM, por sus siglas en inglés) será igual en todos los adaptadores según la base de datos que necesite la aplicación. También deben estar instaladas todas las extensiones relevantes de PHP.

Dada toda la funcionalidad que Phalcon ofrece, sólo para ejecutar la suite de pruebas se necesita tener instalado un gran número de extensiones y servicios (Redis, Memcached, Beanstalkd, etc.)

El problema se vuelve más complejo aún si se piensa además en todas las versiones de PHP (7.2, 7.3, etc.) que se deben probar; con todos estos pre requisitos, el desarrollo de Phalcon no es en definitiva una tarea fácil.

# La solución

Originalmente se ensayó a crear un entorno de desarrollo basado en Docker, pero después de cierto tiempo, la manutención de este entorno se volvió muy exigente para el equipo principal.

Sin embargo recientemente, se decidió redoblar los esfuerzos y recrear este entorno mediante el uso de [nanobox](https://nanobox.io). Nanobox es un *envoltorio* sobre Docker que crea un entorno de desarrollo único en el PC, listo para usar. El entorno se vale del sistema de carpetas y archivos, entonces es posible tener dos carpetas donde se ha clonado Phalcon y ejecutar PHP 7.2 en una y 7.3 en la otra. Cada uno de dichos entornos está completamente aislado. Hasta la fecha, Nanobox funciona muy bien.

# Instalación

El primer paso es tener Docker instalado. Si necesita ayuda, aquí puede encontrar las [instrucciones de instalación](https://docs.docker.com/engine/installation/).

El segundo es ir a <https://nanobox.io> y crear una cuenta o ingresar con una existente para descargar la versión de Nanobox indicada para su sistema operativo.

El tercer paso es instalar la versión descargada.

# Ejecución del entorno

## Clonación (*fork*) del repositorio

Es necesario clonar (*fork*) [cphalcon](https://github.com/phalcon/cphalcon) en su cuenta de Github (si aún no se ha hecho): En la página [cphalcon](https://github.com/phalcon/cphalcon) dé un clic al botón `Fork` en la parte superior derecha de la pantalla.

## Copia del *fork*

Ahora es necesario clonar el *fork* en una carpeta cualquiera del PC. En el siguiente ejemplo se utiliza como cuenta de Github `niden` (debe ser remplazada por la apropiada):

```bash
git clone git@github.com:niden/cphalcon
```

## Copia del *boxfile*

Nanobox lee un archivo llamado `boxfile.yml`, ubicado en la raíz de la carpeta. Phalcon ofrece dos archivos para facilitar el desarrollo: uno para PHP 7.2 y otro para 7.3. Se debe copiar alguno de ellos a la raíz de la carpeta en la que se clonó el repositorio.

```bash
cd ./cphalcon
cp -v ./tests/_ci/nanobox/boxfile.7.2.yml ./boxfile.yml

```

Aparecerá entonces el archivo `boxfile.hml` en la raíz de la carpeta del proyecto.

## Configuración de Nanobox

Ahora se puede ejecutar Nanobox. Por ser la primera vez, es necesario seguir los pasos de configuración, muy sencillos:

```bash
nanobox run
```

Ahora se debe iniciar la sesión utilizando los mismos nombre de usuario y contraseña de la cuenta de Nanobox para poder iniciar la descarga del archivo de instalación.

```bash
$ nanobox login
Nanobox Username: niden
Nanobox Password: 
```

También es necesario configurar Nanobox. Se debe escoger cómo se quiere que trabaje. Hay dos opciones: * Máquina Virtual (VM, por sus siglas en inglés) liviana utilizando Virtualbox * Docker nativo

Se recomienda escoger la opción **b**, *Docker nativo* (de aquí que se aconsejara instalar Docker desde el principio) como respuesta al final de los siguientes párrafos en la terminal, después de `Answer`:

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

## Ejecución de Nanobox

Terminada la configuración, Nanobox empezará a descargar un montón de paquetes y contenedores. Esto es normal y tardará un poco según la velocidad de conexión del sistema. Finalizada la descarga, todas las ejecuciones posteriores utilizarán estos paquetes y contenedores (salvo que haya alguna actualización disponible).

Al terminar el proceso de instalación, aparecerá una ventana similar a esta:

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

Esto significa que la instalación ha sido exitosa y ahora están a su alcance todas las extensiones y servicios necesarios. Nota: Es probable que la IP `172.18.0.2` que aparece al final del ejemplo sea diferente en su sistema.

## Composer

Por precaución es preferible actualizar `composer`:

```bash
/app $ composer install
```

## Comprobar Zephir

Zephir ya está instalado en el entorno. Compruébelo:

```bash
/app $ zephir help
```

Debe aparecer una pantalla similar a la siguiente:

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

## Compilación de Phalcon

Phalcon aún no está compilado. Hay que darle las instrucciones a Zephir para que lo haga:

```bash
/app $ zephir fullclean
/app $ zephir build
```

## Comprobar Extensiones

Tipo

```bash
/app $ php -m
```

y se debe recibir:

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

Tenga en cuenta que Phalcon v4+ requiere que se cargue la extensión [PSR](https://github.com/jbboehr/php-psr) antes que Phalcon. En este entorno lo hemos compilado para usted. Una vez que vea `phalcon` en la lista, ya tiene la extensión compilada y lista para usar.

## Configuración de bases de datos

Primero, necesitamos tener un fichero `.env` en la raíz del proyecto.

```bash
/app $ cp tests/_ci/nanobox/.env.example .env
```

Para generar los esquemas de base de datos necesarios, necesitará ejecutar el script relevante:

```bash
/app $ php tests/_ci/generate-db-schemas.php
```

El script busca las clases localizadas bajo `tests/_data/fixtures/Migrations`. Estas clases contienen el código necesario para crear las sentencias SQL relevantes para cada RDBMS. Puede inspeccionar fácilmente alguno de esos ficheros para entender su estructura. Además, estas clases de migración se pueden instanciar en sus tests para limpiar la tabla destino, insertar nuevos registros, etc. Esta metodología nos permite crear el esquema de base de datos por RDBMS, que se cargará automáticamente desde Codeception, pero también nos permite limpiar tablas e insertar en ellas los datos que necesitemos, con lo que nuestras pruebas están más controladas y aisladas.

Si se necesita añadir una tabla adicional, todo lo que tiene que hacer es crear el modelo Phalcon, por supuesto, pero también crear la clase de migración con las sentencias SQL relevantes. Ejecutar el script de generación (como se ve arriba) actualizará el fichero de esquema para que Codeception pueda cargarlo en su RDBMS antes de ejecutar las pruebas.

Para rellenar la base de datos necesitará ejecutar el script siguiente:

```bash
/app $ tests/_ci/nanobox/setup-dbs-nanobox.sh
```

# Pruebas en ejecución

## Unitaria

Ahora que el entorno está configurado, necesitamos ejecutar las pruebas. El framework de pruebas de Phalcon usa [Codeception](https://codeception.com). Para una introducción básica, puede consultar [esta](https://codeception.com/docs/01-Introduction) página. También para la lista de comandos, puede consultar [aquí](https://codeception.com/docs/reference/Commands).

Primero necesitamos construir las clases base de Codeception. Esto debe ocurrir cada vez que se introduce nueva funcionalidad en los ayudantes de Codeception.

Ahora puede ejecutar:

```bash
/app $ vendor/bin/codecept build
```

La salida debería mostrar:

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

Ahora puede ejecutar las pruebas:

```bash
/app $ php vendor/bin/codecept run unit
```

Esto empezará ejecutando el conjunto de pruebas unitarias. Verá un montón de pruebas y afirmaciones. En el momento de este artículo, tenemos `Tests: 3235, Assertions: 8244, Skipped: 175` pruebas unitarias. La razón de tantas pruebas omitidas es que creamos *stubs* de prueba para cada componente y cada método en cada componente. Esto fue para crear consciencia sobre lo que hay que comprobar y sobre qué componentes/métodos se necesita escribir pruebas. Por supuesto, algunos de los *stubs* de prueba están duplicados u obsoletos. Estos se eliminarán una vez que el componente relevante se compruebe y se escriban pruebas para él. Nuestro objetivo es acercarnos tanto al 100% de cobertura de código como sea posible. ¡Si conseguimos llegar al 100% sería genial!

Ejecutar todas las pruebas desde una carpeta:

```bash
/app $ php vendor/bin/codecept run tests/unit/some/folder/
```

Ejecutar una única prueba:

```bash
/app $ php vendor/bin/codecept run tests/unit/some/folder/some/test/file.php
```

## Base de Datos

Para ejecutar las pruebas relacionadas con base de datos necesita ejecutar el paquete `database` especificando el RDBMS y grupo:

```bash
/app $ php vendor/bin/codecept run tests/database -g common
/app $ php vendor/bin/codecept run tests/database -g mysql --env mysql
/app $ php vendor/bin/codecept run tests/database -g sqlite --env sqlite
/app $ php vendor/bin/codecept run tests/database -g pgsql --env pgsql
```

Opciones disponibles:

```bash
--env mysql
--env sqlite
--env pgsql
```

Si necesita acceder a las bases de datos en sí, necesitará información de la conexión. Nanobox lo crea por usted y lo almacena en variables de entorno. Puede comprobar fácilmente esas variables, y si es necesario, anotarlas.

Abra un terminal independiente y navegue a la misma carpeta desde donde se está ejecutando nanobox y escriba:

```bash
cd ./cphalcon/
nanobox info local
```

Verá una salida como la siguiente:

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

Puede usar estas variables para conectar a su base de datos u otros servicios como Mongo, Redis, etc.

# Desarrollo

Ahora puede abrir su editor favorito y empezar a desarrollar en Zephir. Puede crear nueva funcionalidad, arreglar problemas, escribir pruebas, etc. No obstante, recuerde que si cambia cualquiera de los ficheros `zep` (dentro del directorio `phalcon`), necesitará recompilar al extensión:

```bash
/app $ zephir fullclean
/app $ zephir build
```

y luego puede ejecutar sus pruebas

```bash
/app $ codecept run tests/unit/somefolder/somecestfile:sometest
```

Para la documentación de Zephir, puede visitar el sitio [Docs Zephir](https://docs.zephir-lang.com).

# Servicios

Los servicios disponibles son: - Memcached - Mongodb - Mysql - Postgresql - Redis

Las extensiones PHP habilitadas son: - apcu - ctype - curl - dom - fileinfo - gd - gmp - gettext - imagick - iconv - igbinary - intl - json - memcached - mbstring - mongodb - opcache - phar - pdo - pdo_mysql - pdo_pgsql - pdo_sqlite - redis - session - simplexml - sqlite3 - tokenizer - yaml - zephir_parser - xdebug - xml - xmlwriter - zip - zlib

Los volcados de base de datos están ubicados bajo `tests/_data/assets/schemas`

Si tiene cualquier cuestión, no dude en unirse a nosotros en nuestro servidor [Discord](https://phalcon.io/discord) o nuestro [Foro](https://forum.phalcon.io).

<3 Phalcon Team
