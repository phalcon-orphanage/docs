---
layout: default
language: 'es-es'
version: '4.0'
title: 'Instalación'
keywords: 'installation, installing Phalcon'
---

# Instalación

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Requerimentos

### PHP 7.2

Phalcon v4 soporta sólo PHP 7.2 y superiores. PHP 7.1 has been released 2 years ago and its [active support](https://secure.php.net/supported-versions.php) has lapsed, so we decided to follow actively supported PHP versions.

### PSR

Phalcon requiere la extensión PSR. La extensión se puede descargar y compilar desde [este repositorio de GitHub](https://github.com/jbboehr/php-psr). Las instrucciones de instalación están disponibles en el `README` del repositorio. Una vez que la extensión haya sido compilada y esté disponible en su sistema, necesitará cargarla a su `php.ini`. Necesitarás añadir esta línea:

```ini
extension=psr.so
```

antes

```ini
extension=phalcon.so
```

Alternativamente algunas distribuciones añaden un prefijo numérico en los archivos `ini`. Si ese es el caso, elija un número alto para Phalcon (por ejemplo `50-phalcon.ini`).

### PDO

Dado que Phalcon tiene bajo acoplamiento, expone la funcionalidad sin necesidad de extensiones adicionales. Sin embargo, ciertos componentes dependen de extensiones adicionales para funcionar. Cuando necesite conectividad y acceso a la base de datos, necesitará instalar la extensión `php_pdo`. If your RDBMS is MySQL/MariaDB or Aurora, you will need the `php_mysqlnd` extension also. De manera similar, si utiliza una base de datos PostgreSQL con Phalcon, la extensión `php_pgsql` será requerida.

### Hardware

Phalcon fue diseñado para utilizar los menos recursos posibles, al tiempo que ofrece un alto rendimiento. Aunque hemos probado Phalcon en varios ambientes de bajo rendimiento, (por ejemplo 0.25GB RAM, 0.5 CPU), el hardware que usted elija dependerá de las necesidades de su aplicación.

Hemos alojado nuestro sitio web y blog durante los últimos años en una VM de Amazon con 512MB de RAM y 1 vCPU.

### Software

> **NOTE**: You should always try and use the latest version of Phalcon and PHP as both address bugs, security enhancements as well as performance.
{: .alert .alert-danger }

Junto con PHP 7.2 o mayor, dependiendo de las necesidades de su aplicación y de los componentes de Phalcon que necesites, podrías necesitar instalar algunas de las siguientes extensiones:

* [curl](https://secure.php.net/manual/en/book.curl.php)
* [fileinfo](https://secure.php.net/manual/en/book.fileinfo.php)
* [gettext](https://secure.php.net/manual/en/book.gettext.php)
* [gd2](https://secure.php.net/manual/en/book.image.php) (para usar la clase [Phalcon\Image\Adapter\Gd](api/Phalcon_Image_Adapter_Gd))
* [imagick](https://secure.php.net/manual/en/book.imagick.php) (para usar la clase [Phalcon\Image\Adapter\Imagick](api/Phalcon_Image_Adapter_Imagick))
* [json](https://secure.php.net/manual/en/book.json.php)
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (en macOS)
* La extensión [PDO](https://php.net/manual/en/book.pdo.php), así como la extensión específica pertinente a su RDBMS ([MySQL](https://php.net/manual/en/ref.pdo-mysql.php),[PostgreSQL](https://php.net/manual/en/ref.pdo-pgsql.php),etc.)
* La extensión [OpenSSL](https://php.net/manual/en/book.openssl.php)
* La extensión [Mbstring](https://php.net/manual/en/book.mbstring.php)
* [Memcached](https://php.net/manual/en/book.memcached.php) u otros adaptadores de caché relevantes en función de su uso de caché

> **NOTE**: Installing these packages will vary based on your operating system as well as the package manager you use (if any). Por favor consulte la documentación pertinente sobre cómo instalar estas extensiones.
{: .alert .alert-info }

Para el paquete `libpcre3-dev` puedes usar los siguientes comandos:

#### Debian

```bash
sudo apt-get install libpcre3-dev
```

and then try and install Phalcon again

#### CentOS

```bash
sudo yum install pcre-devel
```

#### Mac/Osx using MacPorts

Make sure you have [MacPorts](https://www.macports.org) installed and up to date (`sudo port -v selfupdate`)

```bash
sudo port install php-phalcon4
```

#### Mac/Osx using Brew

```bash
brew install pcre
```

Without `brew`, you need to go to the [PCRE](https://www.pcre.org/) website and download the latest pcre:

```bash
tar -xzvf pcre-8.42.tar.gz
cd pcre-8.42
./configure --prefix=/usr/local/pcre-8.42
make
make install
ln -s /usr/local/pcre-8.42 /usr/sbin/pcre
ln -s /usr/local/pcre-8.42/include/pcre.h /usr/include/pcre.h
```

Para Maverick

```bash
brew install pcre
```

si te da error, puedes usar

```bash
sudo ln -s /opt/local/include/pcre.h /usr/include/
sudo pecl install apc 
```

## Plataformas de instalación

Como Phalcon está compilado como una extensión PHP, su instalación es un poco diferente que cualquier otro framework PHP tradicional. Phalcon necesita ser instalado y cargado como un módulo en el servidor web.

### Linux

Para instalar Phalcon en Linux, necesitará agregar nuestro repositorio en su distribución y luego instalarlo.

#### DEB Based Distributions (Debian, Ubuntu, Etc.)

##### Instalación desde el repositorio

Agregar el repositorio en su distribución:

**Versiones estables**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

**Versiones nocturnas**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

**Versiones principales (alpha, beta, etc.)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.deb.sh | sudo bash
```

> **NOTE**: This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds.
{: .alert .alert-warning }

##### Instalación de Phalcon

Para instalar Phalcon es necesario ejecutar los siguientes comandos en su terminal:

```bash
sudo apt-get update
sudo apt-get install php7.2-phalcon
```

##### PPAs adicionales

**Ondřej Surý**

Si no desea usar nuestro repositorio en [packagecloud.io](https://packagecloud.io/phalcon), puede utilizar uno ofrecido por [Ondřej Surý](https://launchpad.net/~ondrej/+archive/ubuntu/php/).

Instalación del repositorio:

```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

y Phalcon:

```php
sudo apt-get install php-phalcon
```

#### RPM Based Distributions (CentOS, Fedora, Etc.)

##### Instalación desde el repositorio

Agregar el repositorio en su distribución:

**Versiones estables**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

**Versiones nocturnas**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

**Versiones principales (alpha, beta, etc.)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.rpm.sh | sudo bash
```

> **NOTE**: This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds.
{: .alert .alert-warning }


##### Instalación de Phalcon

Para instalar Phalcon es necesario ejecutar los siguientes comandos en su terminal:

```bash
sudo yum update
sudo yum install php72u-phalcon
```

##### RPMs adicionales

**Remi**

[Remi Collet](https://github.com/remicollet) mantiene un excelente repositorio de RPM basado en instalaciones. Puede encontrar instrucciones sobre cómo activar en su distribución [aquí](https://blog.remirepo.net/pages/Config-en).

La instalación de Phalcon después de eso, es tan fácil como:

```bash
yum install php72-php-phalcon4
```

Versiones adicionales están disponibles para cada arquitectura específica (x86/x64), así como versiones específicas de PHP

#### FreeBSD

Un puerto está disponible para FreeBSD. Para instalarlo deberá ejecutar los siguientes comandos:

##### pkg_add

```bash
pkg_add -r phalcon4
```

##### Codigo fuente

```bash
cd /usr/ports/www/phalcon4

make install clean
```

##### Gentoo

Un overlay para la instalación de Phalcon se puede encontrar [aquí](https://github.com/smoke/phalcon-gentoo-overlay)

#### Raspberry Pi

```bash
sudo -s
git clone https://github.com/phalcon/cphalcon
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir build
```

It is also necessary to increase teh swap file from the default 100 MB to at least 2000 MB. Because, the compiler lacks RAM.

```bash
sudo -s
nano /etc/dphys-swapfile
```

Replacing `CONF_SWAPSIZE=100` with `CONF_SWAPSIZE=2000`

After saving the setting, restart the daemon:

```bash
/etc/init.d/dphys-swapfile stop
/etc/init.d/dphys-swapfile start
```

### macOS

On a macOS system you can compile and install the extension with `brew`, `macports` or the source code:

#### Requerimentos

* Recursos de desarrollo para PHP 7.2.x
* XCode

#### Brew

```bash
brew tap tigerstrikemedia/homebrew-phalconphp
brew install php72-phalcon
brew install php73-phalcon
```

#### MacPorts

```bash
sudo port install php72-phalcon
sudo port install php73-phalcon
```

Edit your php.ini file and then append at the end:

```ini
extension=php_phalcon.so
```

Restart your webserver.

### Windows

To use Phalcon on Windows, you will need to install the phalcon.dll. We have compiled several DLLs depending on the target platform. The DLLs can be found in our [download](https://phalcon.io/en/download/windows) page.

Identify your PHP installation as well as architecture. If you download the wrong DLL, Phalcon will not work. `phpinfo()` contains this information. In the example below, we will need the NTS version of the DLL:

![phpinfo](/assets/images/content/phpinfo-api.png)

The available DLLs are:

| Arquitectura | Versión | Tipo                  |
|:------------:|:-------:| --------------------- |
|     x64      |   7.x   | Thread safe           |
|     x64      |   7.x   | Non Thread safe (NTS) |
|     x86      |   7.x   | Thread safe           |
|     x86      |   7.x   | Non Thread safe (NTS) |

Edit your php.ini file and then append at the end:

```ini
extension=php_phalcon.dll
```

Restart your webserver.

### Compile From Sources

Compiling from source is similar to most environments (Linux/macOS).

#### Requerimentos

* Recursos de desarrollo de PHP 7.2.x/7.3.x
* Compilador GCC (Linux/Solaris/FreeBSD) o Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

#### Compilation

Descarga la última `zephir.phar` desde [aquí](https://github.com/phalcon/zephir/releases). Añada a una carpeta a la que puede acceder su sistema.

Clonar el repositorio

```bash
git clone https://github.com/phalcon/cphalcon
```

Compilación de Phalcon

```bash
cd cphalcon/
git checkout tags/v4.0.0-rc.3 ./
zephir fullclean
zephir build
```

Comprueba el módulo

```bash
php -m | grep phalcon
```

You will now need to add `extension=phalcon.so` to your PHP ini and restart your web server, so as to load the extension.

```ini
; Suse: Add a File Called Phalcon.ini in /etc/php7/conf.d/ with This Content:
extension=phalcon.so

; CentOS/RedHat/Fedora: Add a File Called Phalcon.ini in /etc/php.d/ with This Content:
extension=phalcon.so

; Ubuntu/Debian with Apache2: Add a File Called 30-phalcon.ini in /etc/php7/apache2/conf.d/ with This Content:
extension=phalcon.so

; Ubuntu/Debian with Php7-fpm: Add a File Called 30-phalcon.ini in /etc/php7/fpm/conf.d/ with This Content:
extension=phalcon.so

; Ubuntu/Debian with Php7-cli: Add a File Called 30-phalcon.ini in /etc/php7/cli/conf.d/ with This Content:
extension=phalcon.so
```

The instructions above will compile **and** install the module on your system. You can also compile the extension and then add it manually in your `ini` file:

```bash
cd cphalcon/
git checkout tags/v4.0.0-rc.3 ./
zephir fullclean
zephir compile
cd ext
phpize
./configure
make && make install
```

If you use the above method you will need to add the `extension=phalcon.so` in your `php.ini` both for CLI and web server.

#### Tuning Build

By default we compile to be as compatible as possible with all processors (`gcc -mtune=native -O2 -fomit-frame-pointer`). If you would like instruct the compiler to generate optimized machine code that matches the processor where it is currently running on you can set your own compile flags by exporting CFLAGS before the build. For example

    export CFLAGS="-march=native -O2 -fomit-frame-pointer"
    zephir build
    

This will generate the best possible code for that chipset but will likely break the compiled object on older chipsets.

### Shared Hosting

Running your application on shared hosting might restrict you in installing Phalcon, especially if you do not have root access. Some web hosting control panels luckly have Phalcon support.

#### CPanel & WHM

cPanel & WHM support Phalcon using Easy Apache 4 (EA4). You can install Phalcon by enabling the [module](https://github.com/CpanelInc/scl-phalcon) in Easy Apache 4 (EA4).

#### Plesk

The plesk control panel doesn't have Phalcon support but you can find installation instructions on the Plesk [website](https://support.plesk.com/hc/en-us/articles/115002186489-How-to-install-Phalcon-framework-for-a-PHP-supplied-by-Plesk-)