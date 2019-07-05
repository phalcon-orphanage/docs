---
layout: default
language: 'es-es'
version: '4.0'
title: 'Entorno de prueba'
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
composer install
```

## Verificación de Zephir

Zephir ya se encuentra instalado en el entorno. Para verificarlo:

```bash
zephir help
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
zephir fullclean
zephir build
```

## Revisión de las extensiones

Se digita:

```bash
php -m
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

Nota: Phalcon v4+ requiere la extensión [PSR](https://github.com/jbboehr/php-psr) que debe ser cargada antes que Phalcon. En este entorno ya se encuentra compilada. Si aparece `Phalcon` en la lista de extensiones, significa que ya ha sido compilado y está listo para ser utilizado.

# Ejecución de pruebas

## Unitaria

Con el entorno ya preparado es el momento de ejecutar las pruebas. El *framework* que Phalcon utiliza para hacerlas es [Codeception](https://codeception.com). Para una introducción básica a este *framework* se recomienda leer [esta página](http://codeception.com/docs/01-Introduction). La lista de comandos se encuentra [aquí](http://codeception.com/docs/reference/Commands).

El primer paso es crear las clases base de Codeception. Este paso se debe repetir cada vez que se agrega nueva funcionalidad en los auxiliadores (*helpers*) de Codeception:

```bash
codecept build
```

El resultado debe ser:

```bash
Building Actor classes for suites: cli, integration, unit
 -> CliTesterActions.php generated successfully. 0 methods added
\CliTester includes modules: Asserts, Cli, \Helper\Cli, \Helper\Unit
 -> IntegrationTesterActions.php generated successfully. 0 methods added
\IntegrationTester includes modules: Asserts, Filesystem, Helper\Integration, Helper\PhalconLibmemcached, Helper\Unit, Phalcon, Redis
 -> UnitTesterActions.php generated successfully. 0 methods added
\UnitTester includes modules: Asserts, Filesystem, Redis, Helper\Unit, Helper\PhalconCacheFile, Helper\PhalconLibmemcached
```

Ahora sí se pueden ejecutar las pruebas:

```bash
codecept run unit
```

Se inicia así la ejecución de la suite de prueba unitaria. Aparecerán muchas pruebas y confirmaciones. Por ejemplo, el conteo de pruebas de unidad al escribir este texto es: Pruebas, 2.884; Confirmaciones: 6.987; Omitidas: 1.478. La razón por la cual hay tantas pruebas omitidas es porque se crearon [*stubs*](https://es.wikipedia.org/wiki/Stub) de prueba para cada componente (incluyendo cada uno de sus métodos). De esta manera se resalta qué es lo que se necesita revisar y cuáles son los componentes o métodos para los cuales se deben diseñar las pruebas. Por cierto, varios de los *stubs* de prueba se encuentran duplicados u obsoletos: serán eliminados una vez que el componente relevante sea revisado y las pruebas pertinentes sean creadas. El objetivo de Phalcon es alcanzar el máximo de cobertura del código posible. Si se alcanza el 100% será maravilloso.

## Integración

Las pruebas de integración necesitan acceso a las bases de datos -- que ya se encuentran disponibles en el entorno. Para rellenarlas hay que ejecutar el siguiente código:

```bash
./tests/_ci/nanobox/setup-dbs-nanobox.sh
```

Si se quiere acceder a las bases de datos, es necesario proveer los datos de conexión. Nanobox los crea por defecto y guarda en las variables de entorno. Es fácil encontrarlas y, si es necesario, se pueden anotar también.

Basta con abrir una nueva terminal, abrir la carpeta en donde se encuentra la Nanobox que se está ejecutando y escribir:

```bash
cd ./cphalcon/
nanobox info local
```

Aparecerá la siguiente información:

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

Con estas variables se puede hacer la conexión con las bases de datos u otros servicios como Mongo, Redis, etc.

# Desarrollo

Ahora con el editor preferido se puede empezar a desarrollar en Zephir. Se puede crear nueva funcionalidad, corregir errores, escribir pruebas, etc. Si se modifican los archivos `zep` (en la carpeta `phalcon`) será necesario recompilar la extensión:

```bash
zephir fullclean
zephir build
```

Y luego se pueden seguir ejecutando las pruebas:

```bash
codecept run tests/unit/somefolder/somecestfile:sometest
```

La documentación de Zephir se encuentra en [Zephir Docs](https://docs.zephir-lang.com).

# Servicios

Los servicios disponibles son: - Memcached - Mongodb - Mysql - Postgresql - Redis

Las extensiones de PHP activas son: - apcu - ctype - curl - dom - fileinfo - gd - gmp - gettext - imagick - iconv - igbinary - json - memcached - mbstring - mongodb - opcache - phar - pdo - pdo_mysql - pdo_pgsql - pdo_sqlite - redis - session - simplexml - tokenizer - yaml - zephir_parser - xdebug - xml - xmlwriter - zip - zlib

Los volcados de base de datos se encuentran en `pruebas/_data/assets/db/schemas`

Cualquier duda o pregunta puede resolverse en nuestro servidor de [Discord](https://phalcon.link/discord) o en nuestro [Foro](https://forum.phalconphp.com).

<3 Phalcon Team