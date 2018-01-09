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

To run this stack on your machine, you need at least:

* Operating System: Windows, Linux, or OS X
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

### Con Git

Another way to initialize your project is with Git.

$ `git clone git@github.com:phalcon/phalcon-compose.git`

<div class="alert alert-warning">
    <p>
        Asegúrese de que copia <code>variables.env.example</code> a <code>variables.env</code> y ajustar los parámetros en ese archivo.
    </p>
</div>

Add your Phalcon Application into `application` folder.

<a name='configuration'></a>

## Configuración

Add `phalcon.local` (or your preferred host name) in your `/etc/hosts` file as follows:

$ `127.0.0.1 www.phalcon.local phalcon.local`

<a name='usage'></a>

## Uso

You can now build, create, start, and attach to containers to the environment for your application. To build the containers use following command inside the project root:

$ `docker-compose build`

To start the application and run the containers in the background, use following command inside project root:

También puede usar aquí, el nombre del proyecto preferido, con el parámetro `-p <mi-aplicación>`

$ `docker-compose up -d`

Ahora configura tu proyecto en el contenedor de la aplicación, usando las herramientas de desarrollador de Phalcon

Reemplazar el proyecto en **<project_app_1>** con el nombre de su directorio/proyecto (se muestra en la salida de `docker-compose up -d`)

$ `docker exec -t <project_app_1> phalcon project application simple`

Now you can now launch your application in your browser visiting `http://phalcon.local` (or the host name you chose above).

<a name='setup'></a>

## Configurar

If your application uses a file cache or writes logs to files, you can set up your cache and log folders as follows:

| Directorio | Ruta             |
| ---------- | ---------------- |
| Cache      | `/project/cache` |
| Logs       | `/project/log`   |

<a name='logs'></a>

## Registro de logs

For most containers you can access the logs using the `docker logs <container_name>` command in your host machine.

<a name='environment-variables'></a>

## Variables de entorno

You can pass multiple environment variables from an external file to a service's containers by editing the `variables.env` file.

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

*See also*

* https://docs.phpmyadmin.net/en/latest/setup.html#installing-using-docker
* https://docs.phpmyadmin.net/en/latest/config.html#config
* https://docs.phpmyadmin.net/en/latest/setup.html

<a name='xdebug'></a>

## Depurador remoto Xdebug (PhpStorm)

For debugging purposes you can setup Xdebug by passing required parameters (see variables.env).

| Variable de entorno          | Descripción                                           | Por defecto    |
| ---------------------------- | ----------------------------------------------------- | -------------- |
| `XDEBUG_REMOTE_HOST`         | Valor de `php.ini` para `xdebug.remote_host`.         | (your host IP) |
| `XDEBUG_REMOTE_PORT`         | Valor de `php.ini` para `xdebug.remote_port`.         | 9000           |
| `XDEBUG_REMOTE_AUTOSTART`    | Valor de `php.ini` para `xdebug.remote_autostart`.    | Off            |
| `XDEBUG_REMOTE_CONNECT_BACK` | Valor de `php.ini` para `xdebug.remote_connect_back`. | Off            |

*NOTE* You can find your local IP address as follows:

**Linux/macOS**

$ `ifconfig en1 | grep inet | awk '{print $2}' | sed 's/addr://' | grep .`

**Windows**

&gt; `ipconfig`

<a name='troubleshooting'></a>

## Resolución de problemas

<a name='troubleshooting-startup'></a>

### Inicio o enlace de errores

If you got any startup issues you can try to rebuild app container. There will be no loss of data., it is a safe reset:

```bash
docker-compose stop
docker-compose rm --force app
docker-compose build --no-cache app
docker-compose up -d
```

<a name='troubleshooting-full-reset'></a>

### Reinicio completo

To reset all containers, delete all data (mysql, elasticsearch, etc.) but not your project files in `application` folder:

```bash
docker-compose stop
docker-compose rm --force
docker-compose build --no-cache
docker-compose up -d
```

<a name='troubleshooting-dependencies'></a>

### Actualización de dependencias

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