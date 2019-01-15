* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Controladores

Phalcon Compose es un entorno de desarrollo impulsado por la comunidad para los proyectos de Phalcon que se ejecutan en Docker. Su propósito es facilitar el arranque de aplicaciones Phalcon y ejecutarse en entornos de desarrollo o producción.

<a name='dependencies'></a>

## Dependencias

Para ejecutar esta pila en su máquina, necesita por lo menos: * Sistema operativo: Windows, Linux o OS X * [Docker Engine](https://docs.docker.com/installation/) > = 1.10.0 * [ Docker Compose](https://docs.docker.com/compose/install/) > = 1.6.2

<a name='services'></a>

## Servicios

Los servicios incluidos son:

| Nombre del servicio | Descripción                                                                                                            |
| ------------------- | ---------------------------------------------------------------------------------------------------------------------- |
| mongo               | Contenedor del servidor MongoDB.                                                                                       |
| postgres            | Contenedor del servidor PostgreSQL.                                                                                    |
| mysql               | Contenedor de base de datos MySQL.                                                                                     |
| phpmyadmin          | Una interfaz web para MySQL y MariaDB.                                                                                 |
| memcached           | Contenedor del servidor Memcached.                                                                                     |
| queue               | Contenedor de cola de Beanstalk.                                                                                       |
| aerospike           | Aerospike: base de datos distribuida fiable, de alto rendimiento optimizada para flash y RAM.                          |
| redis               | Contenedor de base de datos Redis.                                                                                     |
| app                 | Contenedor de PHP 7, Apache 2 y Composer.                                                                              |
| elasticsearch       | Elasticsearch es un motor de búsqueda y análisis de código abierto de gran alcance, que facilita la búsqueda de datos. |

<a name='installation'></a>

## Instalación

<a name='installation-composer'></a>

### Con Composer (recomendado)

Usando Composer, se puede crear un nuevo proyecto de la siguiente forma:

```bash
composer create-project phalcon/compose --prefer-dist <folder name>
```

La salida debería ser similar a:

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

### Con Git

Otra forma de inicializar su proyecto es con Git.

```bash
 git clone git@github.com:phalcon/phalcon-compose.git
```

<h5 class='alert alert-warning'>Make sure that you copy <code>variables.env.example</code> to <code>variables.env</code> and adjust the settings in that file </h5>

Añadir la aplicación Phalcon en la carpeta `application`.

<a name='configuration'></a>

## Configuración

Añadir `phalcon.local` (o su nombre de host preferido) en el archivo `/etc/hosts` como se muestra a continuación:

```bash
127.0.0.1 www.phalcon.local phalcon.local
```

<a name='usage'></a>

## Uso

Ahora puede construir, crear, iniciar y colocar contenedores para el entorno de su aplicación. Para construir los contenedores utilice los siguientes comandos dentro de la raíz del proyecto:

```php
docker-compose build
```

Para iniciar la aplicación y ejecutar los contenedores en segundo plano, utilice el siguiente comando dentro de la raíz del proyecto:

```bash
# You can use here your prefered project name with "-p my-app" parameter
$ docker-compose up -d
```

Ahora configura tu proyecto en el contenedor de la aplicación, usando las herramientas de desarrollador de Phalcon

Reemplazar el proyecto en **<project_app_1>** con el nombre de su directorio/proyecto (se muestra en la salida de `docker-compose up -d`)

$ `docker exec -t <project_app_1> phalcon project application simple`

Now you can now launch your application in your browser visiting `https://phalcon.local` (or the host name you chose above).

<a name='setup'></a>

## Configurar

Si su aplicación utiliza un caché de archivos o escribe registros de logs en archivos, puede configurar la memoria de caché y carpetas para los registros de la siguiente manera:

| Directorio       | Ruta             |
| ---------------- | ---------------- |
| Cache            | `/project/cache` |
| Registro de logs | `/project/log`   |

<a name='logs'></a>

## Registro de logs

Para la mayoría de los recipientes puede acceder a los registros utilizando el comando `docker logs <nombre_del_contenedor>` en tu ordenador.

<a name='environment-variables'></a>

## Variables de entorno

Usted puede pasar varias variables de entorno desde un archivo externo a los contenedores del servicio, editando el archivo `variables.env`.

<a name='environment-variables-web'></a>

### Entorno web

| Variable de entorno  | Descripción                                                              | Predeterminado  |
| -------------------- | ------------------------------------------------------------------------ | --------------- |
| `WEB_DOCUMENT_ROOT`  | Raíz del documento para el servidor Web (dentro del contenedor).         | /project/public |
| `WEB_DOCUMENT_INDEX` | Documento índice.                                                        | index.php       |
| `WEB_ALIAS_DOMAIN`   | Alias de dominio.                                                        | *.vm            |
| `WEB_PHP_SOCKET`     | Dirección del socket PHP-FPM.                                            | 127.0.0.1:9000  |
| `APPLICATION_ENV`    | Entorno de la aplicación.                                                | development     |
| `APPLICATION_CACHE`  | Directorio de cache de la aplicación (dentro del contenedor).            | /project/cache  |
| `APPLICATION_LOGS`   | Directorio de registro de logs de la aplicación (dentro del contenedor). | /project/logs   |

<a name='environment-variables-phpmyadmin'></a>

### Variables de phpMyAdmin

| Variable de entorno | Descripción                                                                                                                       | Predeterminado |
| ------------------- | --------------------------------------------------------------------------------------------------------------------------------- | -------------- |
| `PMA_ARBITRARY`     | Cuándo se configura en 1 se permitirá la conexión con el servidor.                                                                | 1              |
| `PMA_HOST`          | Definir dirección o nombre de host del servidor MySQL.                                                                            | mysql          |
| `PMA_HOSTS`         | Definir una lista separada por comas de nombres de host/dirección de los servidores de MySQL. Usar sólo si `PMA_HOST` está vacía. |                |
| `PMA_PORT`          | Definir el puerto del servidor MySQL.                                                                                             | 3306           |
| `PMA_VERBOSE`       | Definir el nombre detallado del servidor MySQL.                                                                                   |                |
| `PMA_VERBOSES`      | Definir una lista separada por comas de nombres detallados de los servidores de MySQL. Usar sólo si `PMA_VERBOSE` está vacía.     |                |
| `PMA_USER`          | Definir el nombre de usuario para configuración el método de autenticación.                                                       | phalcon        |
| `PMA_PASSWORD`      | Definir la contraseña a utilizar para configurar el método de autenticación.                                                      | secret         |
| `PMA_ABSOLUTE_URI`  | Ruta completa de acceso (por ejemplo https://pma.example.net/) donde el proxy inverso hace que phpMyAdmin este disponible.        |                |

*See also* * https://docs.phpmyadmin.net/en/latest/setup.html#installing-using-docker * https://docs.phpmyadmin.net/en/latest/config.html#config * https://docs.phpmyadmin.net/en/latest/setup.html

<a name='xdebug'></a>

## Depurador remoto Xdebug (PhpStorm)

Para propósitos de depuración puede configurar Xdebug pasando los parámetros requeridos (ver variables.env).

| Variable de entorno          | Descripción                                              | Predeterminado |
| ---------------------------- | -------------------------------------------------------- | -------------- |
| `XDEBUG_REMOTE_HOST`         | `php.ini` value for `xdebug.remote_host` (your host IP). |                |
| `XDEBUG_REMOTE_PORT`         | Valor de `php.ini` para `xdebug.remote_port`.            | 9000           |
| `XDEBUG_REMOTE_AUTOSTART`    | Valor de `php.ini` para `xdebug.remote_autostart`.       | Off            |
| `XDEBUG_REMOTE_CONNECT_BACK` | Valor de `php.ini` para `xdebug.remote_connect_back`.    | Off            |

*Nota* Puede encontrar su dirección IP local como se muestra a continuación:

```bash
# Linux/MacOS
ifconfig en1 | grep inet | awk '{print $2}' | sed 's/addr://' | grep .

# Windows
ipconfig
```

<a name='troubleshooting'></a>

## Resolución de problemas

<a name='troubleshooting-startup'></a>

### Inicio o enlace de errores

Si tienes cualquier problema de inicio, puede intentar reconstruir el contenedor de la aplicación. No habrá ninguna pérdida de datos., es un reinicio seguro:

```bash
docker-compose stop
docker-compose rm --force app
docker-compose build --no-cache app
docker-compose up -d
```

<a name='troubleshooting-full-reset'></a>

### Reinicio completo

Para restablecer todos los contenedores, eliminar todos los datos (mysql, elasticsearch, etcétera) pero no los archivos de proyectos en carpeta `aplicación`:

```bash
docker-compose stop
docker-compose rm --force
docker-compose build --no-cache
docker-compose up -d
```

<a name='troubleshooting-dependencies'></a>

### Actualización de dependencias

A veces las imágenes de base (por ejemplo `phalconphp/php-apache: ubuntu-16.04`) se actualizan. Phalcon Compose depende de estas imágenes. Por lo tanto usted tendrá que actualizarlas y siempre es bueno hacerlo para asegurar que tenga la funcionalidad más reciente disponible. Los contenedores dependientes de estas imágenes tendrán que ser actualizados y reconstruidos:

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

Los usuarios de Linux/MacOS pueden utilizar `make` para realizar la tarea:

```bash
make pull
```

Luego tienes que reiniciar todos los contenedores, eliminar todos los datos, reconstruir los servicios y reiniciar la aplicación.

Los usuarios de Linux/MacOS pueden utilizar `make` para realizar la tarea:

```bash
make reset
```