<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Phalcon Compose Docker</a> 
      <ul>
        <li>
          <a href="#dependencies">Dependencias</a>
        </li>
        <li>
          <a href="#services">Servicios</a>
        </li>
        <li>
          <a href="#installation">Instalación</a> 
          <ul>
            <li>
              <a href="#installation-composer">Con Composer (recomendado)</a>
            </li>
            <li>
              <a href="#installation-git">Con Git</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#configuration">Configuración</a>
        </li>
        <li>
          <a href="#usage">Uso</a>
        </li>
        <li>
          <a href="#setup">Configurar</a>
        </li>
        <li>
          <a href="#logs">Registro de logs</a>
        </li>
        <li>
          <a href="#environment-variables">Variables de entorno</a> 
          <ul>
            <li>
              <a href="#environment-variables-web">Entorno web</a>
            </li>
            <li>
              <a href="#environment-variables-phpmyadmin">Variables de phpMyAdmin</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#xdebug">Depurador remoto Xdebug (PhpStorm)</a>
        </li>
        <li>
          <a href="#troubleshooting">Resolución de problemas</a> <ul>
            <li>
              <a href="#troubleshooting-startup">Inicio o enlace de errores</a>
            </li>
            <li>
              <a href="#troubleshooting-full-reset">Reinicio completo</a>
            </li>
            <li>
              <a href="#troubleshooting-dependencies">Actualización de dependencias</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#versions">Versiones</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Resumen

Phalcon Compose es un entorno de desarrollo impulsado por la comunidad para los proyectos de Phalcon que se ejecutan en Docker. Su propósito es facilitar el arranque de aplicaciones Phalcon y ejecutarse en entornos de desarrollo o producción.

<a name='dependencies'></a>

## Dependencias

Para ejecutar esta pila en su maquina, al menos, necesitará lo siguiente:

* Sistema Operativo: Windows, Linux, o OS X
* [Docker Engine](https://docs.docker.com/installation/) >= 1.10.0
* [Docker Compose](https://docs.docker.com/compose/install/) >= 1.6.2

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

$ `composer create-project phalcon/compose --prefer-dist <nombre de la carpeta>`

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

$ `git clone git@github.com:phalcon/phalcon-compose.git`

<div class="alert alert-warning">
    <p>
        Asegúrese de que copia <code>variables.env.example</code> a <code>variables.env</code> y ajustar los parámetros en ese archivo.
    </p>
</div>

Añadir la aplicación Phalcon en la carpeta `application`.

<a name='configuration'></a>

## Configuración

Añadir `phalcon.local` (o su nombre de host preferido) en el archivo `/etc/hosts` como se muestra a continuación:

$ `127.0.0.1 www.phalcon.local phalcon.local`

<a name='usage'></a>

## Uso

Ahora puede construir, crear, iniciar y colocar contenedores para el entorno de su aplicación. Para construir los contenedores utilice los siguientes comandos dentro de la raíz del proyecto:

$ `docker-compose build`

Para iniciar la aplicación y ejecutar los contenedores en segundo plano, utilice el siguiente comando dentro de la raíz del proyecto:

También puede usar aquí, el nombre del proyecto preferido, con el parámetro `-p <mi-aplicación>`

$ `docker-compose up -d`

Ahora configura tu proyecto en el contenedor de la aplicación, usando las herramientas de desarrollador de Phalcon

Reemplazar el proyecto en **<project_app_1>** con el nombre de su directorio/proyecto (se muestra en la salida de `docker-compose up -d`)

$ `docker exec -t <project_app_1> phalcon project application simple`

Ahora puede lanzar la aplicación en su navegador ingresando a `http://phalcon.local` (o el nombre de host que elegiste anteriormente).

<a name='setup'></a>

## Configurar

Si su aplicación utiliza un caché de archivos o escribe registros de logs en archivos, puede configurar la memoria de caché y carpetas para los registros de la siguiente manera:

| Directorio | Ruta             |
| ---------- | ---------------- |
| Cache      | `/project/cache` |
| Logs       | `/project/log`   |

<a name='logs'></a>

## Registro de logs

Para la mayoría de los recipientes puede acceder a los registros utilizando el comando `docker logs <nombre_del_contenedor>` en tu ordenador.

<a name='environment-variables'></a>

## Variables de entorno

Usted puede pasar varias variables de entorno desde un archivo externo a los contenedores del servicio, editando el archivo `variables.env`.

<a name='environment-variables-web'></a>

### Entorno web

| Variable de entorno  | Descripción                                                              | Por defecto     |
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

| Variable de entorno | Descripción                                                                                                                       | Por defecto |
| ------------------- | --------------------------------------------------------------------------------------------------------------------------------- | ----------- |
| `PMA_ARBITRARY`     | Cuándo se configura en 1 se permitirá la conexión con el servidor.                                                                | 1           |
| `PMA_HOST`          | Definir dirección o nombre de host del servidor MySQL.                                                                            | mysql       |
| `PMA_HOSTS`         | Definir una lista separada por comas de nombres de host/dirección de los servidores de MySQL. Usar sólo si `PMA_HOST` está vacía. |             |
| `PMA_PORT`          | Definir el puerto del servidor MySQL.                                                                                             | 3306        |
| `PMA_VERBOSE`       | Definir el nombre detallado del servidor MySQL.                                                                                   |             |
| `PMA_VERBOSES`      | Definir una lista separada por comas de nombres detallados de los servidores de MySQL. Usar sólo si `PMA_VERBOSE` está vacía.     |             |
| `PMA_USER`          | Definir el nombre de usuario para configuración el método de autenticación.                                                       | phalcon     |
| `PMA_PASSWORD`      | Definir la contraseña a utilizar para configurar el método de autenticación.                                                      | secret      |
| `PMA_ABSOLUTE_URI`  | Ruta completa de acceso (por ejemplo https://pma.example.net/) donde el proxy inverso hace que phpMyAdmin este disponible.        |             |

*Ver también*

* https://docs.phpmyadmin.net/en/latest/setup.html#installing-using-docker
* https://docs.phpmyadmin.net/en/latest/config.html#config
* https://docs.phpmyadmin.net/en/latest/setup.html

<a name='xdebug'></a>

## Depurador remoto Xdebug (PhpStorm)

Para propósitos de depuración puede configurar Xdebug pasando los parámetros requeridos (ver variables.env).

| Variable de entorno          | Descripción                                           | Por defecto    |
| ---------------------------- | ----------------------------------------------------- | -------------- |
| `XDEBUG_REMOTE_HOST`         | Valor de `php.ini` para `xdebug.remote_host`.         | (your host IP) |
| `XDEBUG_REMOTE_PORT`         | Valor de `php.ini` para `xdebug.remote_port`.         | 9000           |
| `XDEBUG_REMOTE_AUTOSTART`    | Valor de `php.ini` para `xdebug.remote_autostart`.    | Off            |
| `XDEBUG_REMOTE_CONNECT_BACK` | Valor de `php.ini` para `xdebug.remote_connect_back`. | Off            |

*Nota* Puede encontrar su dirección IP local como se muestra a continuación:

**Linux/macOS**

$ `ifconfig en1 | grep inet | awk '{print $2}' | sed 's/addr://' | grep .`

**Windows**

&gt; `ipconfig`

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

Los usuarios de Linux/MacOS pueden utilizar `make` para realizar la tarea:

$ `make pull`

Luego tienes que reiniciar todos los contenedores, eliminar todos los datos, reconstruir los servicios y reiniciar la aplicación.

Los usuarios de Linux/MacOS pueden utilizar `make` para realizar la tarea:

$ `make reset`