* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='requirements'></a>

# Requerimentos

Phalcon necesita PHP para ejecutar. Su diseño ligeramente acoplado permite los desarrolladores instalar el Phalcon y utilizar su funcionalidad sin extensiones adicionales. Algunos componentes tienen dependencias de otras extensiones. Por ejemplo, para utilizar la conectividad de base de datos, la extensión `php_pdo` será requerida. Si su RDBMS es MySql/MariaDb o Aurora base de datos, también se necessita lá extensión `php_mysqlnd`. De manera similar, si utiliza una base de datos PostgreSQL con Phalcon, la extensión `php_pgsql` será requerida.

<a name='requirements-hardware'></a>

## Hardware

Phalcon fue diseñado para utilizar los menos recursos posibles, al tiempo que ofrece un alto rendimiento. Aunque hemos probado Phalcon en varios ambientes de bajo rendimiento, (por ejemplo 0.25GB RAM, 0.5 CPU), el hardware que usted elija dependerá de las necesidades de su aplicación.

Nuestro sitio web y blog (así como otros sitios) están alojados en una VM de Amazon con 512MB de RAM y 1 vCPU.

<a name='requirements-software'></a>

## Software

* PHP >= 5.5

<h5 class='alert alert-danger'>You should always try and use the latest version of Phalcon and PHP as both address bugs, security enhancements as well as performance. PHP 5.5 will be deprecated in the near future, and Phalcon 4 will only support PHP 7 </h5>

Phalcon necesita las siguientes extensiones para ser ejecutado (mínimo):

* `curl`
* `gettext`
* `GD2` (para usar la clase `Phalcon\Image\Adapter\Gd`)
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (en macOS)
* `json`
* `mbstring`
* `pdo_*`
* `fileinfo`
* `openssl`

<a name='requirements-software-optional'></a>

### Opcional, dependiendo de las necesidades de su aplicación

* [PDO](https://php.net/manual/en/book.pdo.php) Extension as well as the relevant RDBMS specific extension (i.e. [MySQL](https://php.net/manual/en/ref.pdo-mysql.php), [PostgreSql](https://php.net/manual/en/ref.pdo-pgsql.php) etc.)
* [OpenSSL](https://php.net/manual/en/book.openssl.php) Extension
* [Mbstring](https://php.net/manual/en/book.mbstring.php) Extension
* [Memcache](https://php.net/manual/en/book.memcache.php), [Memcached](https://php.net/manual/en/book.memcached.php) or other relevant cache adapters depending on your usage of cache

<a name='installation'></a>

# Instalación

Since Phalcon is compiled as a PHP extension, its installation is somewhat different than any other traditional PHP framework. Phalcon needs to be installed and loaded as a module on your web server.

<a name='installation-linux'></a>

## Linux

Para instalar Phalcon en Linux, necesitará agregar nuestro repositorio en su distribución y luego instalarlo.

<a name='installation-linux-debian'></a>

### Distribuciones basadas en DEB (Debian, Ubuntu, etc)

<a name='installation-linux-debian-repository'></a>

#### Instalación desde el repositorio

Agregar el repositorio en su distribución:

<a name='installation-linux-debian-repository-stable'></a>

##### Versiones estables

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

o

<a name='installation-linux-debian-repository-nightly'></a>

##### Versiones nocturnas

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

<h5 class='alert alert-warning'>This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds. </h5>

<a name='installation-linux-debian-phalcon'></a>

#### Instalación de Phalcon

Para instalar Phalcon es necesario ejecutar los siguientes comandos en su terminal:

<a name='installation-linux-debian-phalcon-php5'></a>

##### PHP 5.x

```bash
sudo apt-get update
sudo apt-get install php5-phalcon
```

<a name='installation-linux-debian-phalcon-php7'></a>

##### PHP 7

```bash
sudo apt-get update
sudo apt-get install php7.0-phalcon
```

<a name='installation-linux-debian-other-ppa'></a>

#### PPAs adicionales

#### Ondřej Surý

Si no desea usar nuestro repositorio en [packagecloud.io](https://packagecloud.io/phalcon), puede utilizar uno ofrecido por [Ondřej Surý](https://launchpad.net/~ondrej/+archive/ubuntu/php/).

Installation of the repo:

```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

and Phalcon:

```php
sudo apt-get install php-phalcon
```

<a name='installation-linux-rpm'></a>

### Distribuciones basadas en RPM (CentOS, Fedora, etc.)

<a name='installation-linux-rpm-repository'></a>

#### Instalación desde el repositorio

Agregar el repositorio en su distribución:

<a name='installation-linux-rpm-repository-stable'></a>

##### Versiones estables

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

o

<a name='installation-linux-rpm-repository-nightly'></a>

##### Versiones nocturnas

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

<h5 class='alert alert-warning'>This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds. </h5>

<a name='installation-linux-rpm-phalcon'></a>

#### Instalación de Phalcon

Para instalar Phalcon es necesario ejecutar los siguientes comandos en su terminal:

<a name='installation-linux-rpm-phalcon-php5'></a>

##### PHP 5.x

```bash
sudo yum update
sudo yum install php56u-phalcon
```

<a name='installation-linux-rpm-phalcon-php7'></a>

##### PHP 7

```bash
sudo yum update
sudo yum install php70u-phalcon
```

<a name='installation-linux-rpm-other-rpm'></a>

#### RPMs adicionales

##### Remi

[Remi Collet](https://github.com/remicollet) mantiene un excelente repositorio de RPM basado en instalaciones. Puede encontrar instrucciones sobre cómo activar en su distribución [aquí](https://blog.remirepo.net/pages/Config-en).

La instalación de Phalcon después de eso, es tan fácil como:

```bash
yum install php56-php-phalcon3
```

Versiones adicionales están disponibles para cada arquitectura específica (x86/x64), así como versiones específicas de PHP (5.5, 5.6, 7.x)

<a name='installation-freebsd'></a>

## FreeBSD

Una versión alternativa está disponible para FreeBSD. Para instalarlo deberá ejecutar los siguientes comandos:

### `pkg_add`

```bash
pkg_add -r phalcon
```

### Codigo fuente

```bash
export CFLAGS="-O2 --fvisibility=hidden"

cd /usr/ports/www/phalcon

make install clean
```

<a name='installation-gentoo'></a>

## Gentoo

Un overlay para la instalación de Phalcon puede encontrarse aquí <https://github.com/smoke/phalcon-gentoo-overlay>

<a name='installation-macos'></a>

## macOS

En sistemas macOS puede compilar e instalar la extensión con `brew`, `macports` o el código fuente:

### Requerimentos

* Recursos para el desarrollo PHP 5.5.x/5.6.x/7.0.x/7.1.x
* XCode

<a name='installation-macos-brew'></a>

### Brew

Como el [homebrew/php ha quedado obsoleto](https://brew.sh/2018/01/19/homebrew-1.5.0/) y está en proceso de ser eliminado, se ha creado un repositorio personalizado para Phalcon.

PHP 5.5 no ha sido portado a homebrew/core y como tal ya no existe. Por otro lado se ha añadido PHP 7.2.

```bash
brew tap tigerstrikemedia/homebrew-phalconphp
brew install php56-phalcon
brew install php70-phalcon
brew install php71-phalcon
brew install php72-phalcon
```

<a name='installation-macos-macports'></a>

### MacPorts

```bash
sudo port install php55-phalcon
sudo port install php56-phalcon
```

Editar el archivo php.ini y luego añadir al final:

```ini
extension=php_phalcon.so
```

Reinicie su servidor Web.

<a name='installation-windows'></a>

## Windows

Para utilizar Phalcon en Windows, usted necesitará instalar el phalcon.dll. Hemos compilado varias DLLs dependiendo de la plataforma de destino. Los archivos dll pueden encontrarse en nuestra página de [descarga](https://phalconphp.com/en/download/windows).

Identifique su instalación de PHP, así como la arquitectura. Si descarga el archivo DLL erróneo, Phalcon no funcionará. `phpinfo()` contiene esta información. En el ejemplo siguiente, vamos a necesitar la versión NTS de la DLL:

![phpinfo](/assets/images/content/phpinfo-api.png)

Las DLL disponibles son:

| Arquitectura | Versión | Tipo                  |
|:------------:|:-------:| --------------------- |
|     x64      |   7.x   | Thread safe           |
|     x64      |   7.x   | Non Thread safe (NTS) |
|     x86      |   7.x   | Thread safe           |
|     x86      |   7.x   | Non Thread safe (NTS) |
|     x64      |   5.6   | Thread safe           |
|     x64      |   5.6   | Non Thread safe (NTS) |
|     x86      |   5.6   | Thread safe           |
|     x86      |   5.6   | Non Thread safe (NTS) |
|     x64      |   5.5   | Thread safe           |
|     x64      |   5.5   | Non Thread safe (NTS) |
|     x86      |   5.5   | Thread safe           |
|     x86      |   5.5   | Non Thread safe (NTS) |

Editar el archivo php.ini y luego añadir al final:

```ini
extension=php_phalcon.dll
```

Reinicie su servidor Web.

<a name='installation-sources'></a>

## Compilar desde código fuente

Compilar desde código fuente es similar a la mayoría de los entornos (Linux/macOS).

### Requerimentos

* Recursos para el desarrollo PHP 5.5.x/5.6.x/7.0.x/7.1.x
* Compilador GCC (Linux/Solaris/FreeBSD) o Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

Puede instalar estos paquetes en su sistema con el gestor de paquetes relevantes. Las instrucciones para las distribuciones de linux populares están a continuación:

#### Ubuntu

```bash
sudo apt-get install php5-dev libpcre3-dev gcc make
```

#### Suse

```bash
sudo zypper install php5-devel gcc make
```

#### CentOS/Fedora/RHEL

```bash
sudo yum install php-devel pcre-devel gcc make
```

### Compilar Phalcon

Primero tenemos que clonar Phalcon desde el repositorio de Github

```bash
git clone https://github.com/phalcon/cphalcon
```

y ahora compilar la extensión

```bash
cd cphalcon/build
sudo ./install
```

Ahora usted tendrá que añadir `extension=phalcon.so` a su PHP ini y reiniciar su servidor web, para que la extensión sea cargada.

```ini
# Suse: Agregue un archivo llamado phalcon.ini en /etc/php5/conf.d/ con el siguiente contenido:
extension=phalcon.so

# CentOS/RedHat/Fedora: Agregue un archivo llamado phalcon.ini en /etc/php.d/ con el siguiente contenido:
extension=phalcon.so

# Ubuntu/Debian con apache2: Agregue un archivo llamado 30-phalcon.ini en /etc/php5/apache2/conf.d/ con el siguiente contenido:
extension=phalcon.so

# Ubuntu/Debian con php5-fpm: Agregue un archivo llamado 30-phalcon.ini en /etc/php5/fpm/conf.d/ con el siguiente contenido:
extension=phalcon.so

# Ubuntu/Debian con php5-cli: Agregue un archivo llamado 30-phalcon.ini en /etc/php5/cli/conf.d/ con el siguiente contenido:
extension=phalcon.so
```

<a name='installation-sources-advanced'></a>

## Compilación avanzada

Phalcon detecta automáticamente su arquitectura, sin embargo, puede forzar la compilación para una arquitectura específica:

```bash
cd cphalcon/build

# Una de las siguientes:
sudo ./install --arch 32bits
sudo ./install --arch 64bits
sudo ./install --arch safe
```

Si el instalador automático falla, puedes generar la extensión manualmente:

```bash
git clone https://github.com/phalcon/cphalcon
# cd cphalcon/build/php5/32bits
cd cphalcon/build/php5/64bits

# NOTA: para PHP 7 debe usar
# cd cphalcon/build/php7/32bits
# o
# cd cphalcon/build/php7/64bits

make clean
phpize --clean

export CFLAGS="-O2 --fvisibility=hidden"
./configure --enable-phalcon

make
make install
```

Si tienes versiones específicas de php ejecutando:

```bash
git clone https://github.com/phalcon/cphalcon
# cd cphalcon/build/php5/32bits
cd cphalcon/build/php5/64bits

# NOTA: para PHP 7 debe usar
# cd cphalcon/build/php7/32bits
# o
# cd cphalcon/build/php7/64bits

make clean
/opt/php-5.6.15/bin/phpize --clean

export CFLAGS="-O2 --fvisibility=hidden"
./configure --with-php-config=/opt/php-5.6.15/bin/php-config --enable-phalcon

make
make install
```

Ahora usted tendrá que añadir `extension=phalcon.so` a su PHP ini y reiniciar su servidor web, para que la extensión sea cargada.

<a name='installation-testing'></a>
Puede crear un pequeño script en la raíz del servidor web que tenga lo siguiente:

```php
<?php

phpinfo();
```

y cargarlo en su navegador web. Debería haber una sección para Phalcon. Si no la hay, asegúrese de que su extensión ha sido compilada correctamente, que hizo los cambios necesarios a su `php.ini` y también que ha reiniciado el servidor web.

También puede comprobar la instalación desde la línea de comandos:

```bash
php -r 'print_r(get_loaded_extensions());'
```

Esto devolverá algo similar a esto:

```php
Array
(
    [0] => Core
    [1] => libxml
    [2] => filter
    [3] => SPL
    [4] => standard
    [5] => phalcon
    [6] => pdo_mysql
)
```

También puede ver los módulos instalados mediante la CLI:

```bash
php -m
```

<h5 class='alert alert-danger'>Note that in some Linux based systems, you might need to change two <code>php.ini</code> files, one for your web server (Apache/Nginx), and one for the CLI. If Phalcon is loaded only for say the web server, you will need to locate the CLI <code>php.ini</code> and make the necessary additions for the module to be loaded. </h5>
