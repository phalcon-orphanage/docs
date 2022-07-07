---
layout: default
language: 'es-es'
version: '5.0'
title: 'Instalación'
keywords: 'instalación, instalación de Phalcon'
---

# Instalación
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Requerimentos

### PHP 7.2
Phalcon v4 soporta sólo PHP 7.2 y superiores. PHP 7.1 has been released 2 years ago and its [active support][php-support] has lapsed, so we decided to follow actively supported PHP versions. La instalación de un servidor web está fuera del ámbito de este documento. Por favor, consulte las guías relevantes en Internet sobre cómo instalar un servidor web.

### PSR (Recomendaciones Estándar de PHP)
Phalcon requiere la extensión PSR. The extension can be downloaded and compiled from [this][psr-extension] GitHub repository. Las instrucciones de instalación están disponibles en el `README` del repositorio. Dependiendo del método de instalación que elija, puede que necesite añadir una directiva en su `php. ni` para que la extensión PSR esté cargada.

```ini
extension=psr.so
```

> **NOTE**: You will need the PSR 1.0 extension installed. 
> 
> {: .alert .alert-danger }

### PDO
Dado que Phalcon tiene bajo acoplamiento, expone la funcionalidad sin necesidad de extensiones adicionales. Sin embargo, ciertos componentes dependen de extensiones adicionales para funcionar. Cuando necesite conectividad y acceso a la base de datos, necesitará instalar la extensión `php_pdo`. Si su RDBMS es MySQL/MariaDB o Aurora, también se necesita la extensión `php_mysqlnd`. De manera similar, usar una base de datos PostgreSql con Phalcon requiere la extensión `php_pgsql`.

### Orden de Carga
Phalcon debe cargarse después de `PDO` y `PSR`. Algunas distribuciones añaden un prefijo numérico en los archivos `ini`. Si ese es el caso, elija un número alto para Phalcon (por ejemplo, `50-phalcon. ni`), mayor que `PDO` y `PSR`. Esto lo cargará después de las dos extensiones previas. Sin embargo, si su distribución solo tiene un archivo `php.ini`, por favor asegúrese de que el orden es similar a este:

```ini
extension=psr.so
extension=phalcon.so
```

### Hardware
Phalcon fue diseñado para utilizar los mínimos recursos posibles, al tiempo que ofrece un alto rendimiento. Aunque hemos probado Phalcon en varios ambientes de bajo rendimiento, (como 0,25GB RAM, 0,5 CPU), el hardware que usted elija dependerá de las necesidades de su aplicación.

Hemos alojado nuestro sitio web y blog durante los últimos años en una VM de Amazon con 512MB de RAM y 1 vCPU.

### Software

> **NOTE**: You should always try and use the latest version of Phalcon and PHP as both address bugs, security enhancements as well as performance. 
> 
> {: .alert .alert-danger }

Desde PHP 7.2 o mayor, dependiendo de las necesidades de su aplicación y de los componentes de Phalcon que necesite, podría necesitar instalar algunas de las siguientes extensiones:

* [curl][curl]
* [fileinfo][fileinfo]
* [gettext][gettext]
* [gd2][gd2] (to use the [Phalcon\Image\Adapter\Gd](api/Phalcon_Image_Adapter_Gd) class)
* [imagick][imagick] (to use the [Phalcon\Image\Adapter\Imagick](api/Phalcon_Image_Adapter_Imagick) class)
* [json][json]
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (en macOS)
* [PDO][pdo] Extension as well as the relevant RDBMS specific extension (i.e. [MySQL][mysql], [PostgreSql][postgresql] etc.)
* [OpenSSL][openssl] Extension
* [Mbstring][mbstring] Extension
* [Memcached][memcached] or other relevant cache adapters depending on your usage of cache

> **NOTE**: Installing these packages will vary based on your operating system as well as the package manager you use (if any). Por favor, consulte la documentación pertinente sobre cómo instalar estas extensiones. 
> 
> {: .alert .alert-info }

Para el paquete `libpcre3-dev` puede usar los siguientes comandos:

### Pecl
El método de instalación de Pecl está disponible para Windows, Linux y MacOS. Bajo windows se utilizarán archivos dll precompilados. En Linux y MacOS se compilará Phalcon localmente por lo que podría ser más rápido usar un método de instalación diferente en estas plataformas. To install using Pecl make sure you have [pecl/pear][install-pecl] installed.
```
pecl channel-update pecl.php.net
pecl install phalcon
```

#### Debian
```bash
sudo apt-get install libpcre3-dev
```
y luego intente instalar Phalcon otra vez

#### CentOS
```bash
sudo yum install pcre-devel
```

#### Mac/Osx usando Brew
```bash
brew install pcre
```

Without `brew`, you need to go to the [PCRE][pcre] website and download the latest pcre:

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
si le da error, puede usar

```bash
sudo ln -s /opt/local/include/pcre.h /usr/include/
sudo pecl install apc 
```

## Plataformas de instalación
Como Phalcon está compilado como una extensión PHP, su instalación es un poco diferente que cualquier otro framework PHP tradicional. Phalcon necesita ser instalado y cargado como un módulo en su servidor web.

### Linux
Para instalar Phalcon en Linux, necesitará añadir nuestro repositorio en su distribución y luego instalarlo.

#### Distribuciones basadas en DEB (Debian, Ubuntu, etc.)

##### Instalación desde el repositorio
Añada el repositorio a su distribución:

**Versiones estables**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

**Versiones lanzadas cada noche**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

**Versiones en línea principal (alfa, beta, etc.)**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.deb.sh | sudo bash
```

> **NOTE**: This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds. 
> 
> {: .alert .alert-warning }

##### Instalación de Phalcon
Para instalar Phalcon es necesario ejecutar los siguientes comandos en su terminal:

```bash
sudo apt-get update
sudo apt-get install php7.2-phalcon
```

##### PPAs adicionales
**Ondřej Surý**

If you do not wish to use our repository at [packagecloud.io][packagecloud], you can always use the one offered by [Ondřej Surý][ondrej].

Instalación del repositorio:
```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

y Phalcon:

```php
sudo apt-get install php-phalcon4
```

#### Distribuciones basadas en RPM (CentOS, Fedora, etc.)

##### Instalación desde el repositorio
Añada el repositorio a su distribución:

**Versiones estables**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

**Versiones lanzadas cada noche**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

**Versiones en línea principal (alfa, beta, etc.)**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.rpm.sh | sudo bash
```

> **NOTE**: This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds. 
> 
> {: .alert .alert-warning }


##### Instalación de Phalcon
Para instalar Phalcon es necesario ejecutar los siguientes comandos en su terminal:

```bash
sudo yum update
sudo yum install php72u-phalcon
```

##### RPMs Adicionales
**Remi**

[Remi Collet][remi] maintains an excellent repository for RPM based installations. You can find instructions on how to enable it for your distribution [here][remi-config].

La instalación de Phalcon después de eso, es tan fácil como:

```bash
yum install php72-php-phalcon4
```

Versiones adicionales están disponibles para cada arquitectura específica (x86/x64), así como versiones específicas de PHP


#### FreeBSD
Para FreeBSD está disponible el paquete binario (pkg) y compilarlo desde el código fuente (ports). Para instalarlo deberá ejecutar los siguientes comandos:

##### pkg
```bash
pkg install php74-phalcon4
```

##### ports
```bash
cd /usr/ports/www/phalcon4

make install clean
```

##### Gentoo
An overlay for installing Phalcon can be found [here][gentoo-overlay]

#### Raspberry Pi

```bash
sudo -s
git clone https://github.com/phalcon/cphalcon
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir build
```

También es necesario aumentar el archivo de intercambio de 100 MB por defecto a por lo menos 2000 MB. Porque, el compilador carece de RAM.

```bash
sudo -s
nano /etc/dphys-swapfile
```

Reemplazando `CONF_SWAPSIZE=100` con `CONF_SWAPSIZE=2000`

Después de guardar la configuración, reinicie el demonio:

```bash
/etc/init.d/dphys-swapfile stop
/etc/init.d/dphys-swapfile start
```

### macOS
Brew incluye paquetes binarios para que no necesite compilar Phalcon usted mismo. Si desea compilar la extensión usted mismo, necesita las siguientes dependencias instaladas:

#### Requisitos de compilación
* Recursos de desarrollo para PHP 7.x
* XCode

#### Brew
Instalación binaria (preferida):
```bash
brew tap phalcon/extension https://github.com/phalcon/homebrew-tap
brew install phalcon
```
Compilar Phalcon:
```bash
brew tap phalcon/extension https://github.com/phalcon/homebrew-tap
brew install phalcon --build-from-source 
```

#### MacPorts
```bash
sudo port install php72-phalcon
sudo port install php73-phalcon
```

Editar el archivo `php.ini` y luego añadir al final:

```ini
extension=php_phalcon.so
```

Reinicie su servidor web.

### PHPBrew (macOS/Linux)

PHPBrew es una excelente manera de administrar múltiples versiones de PHP y sus extensiones en su(s) sistema(s). Installation instructions for PHPBrew can be found [here][install-phpbrew]

Si está utilizando PHPBrew, puede instalar Phalcon usando lo siguiente:

```bash
sudo phpbrew ext install phalcon
```

También puede instalar la dependencia PSR desde PHPBrew si es necesario:

```bash
sudo phpbrew ext install psr
```

### Windows
Para utilizar Phalcon en Windows, usted necesitará instalar el phalcon.dll. Hemos compilado varias DLLs dependiendo de la plataforma de destino. The DLLs can be found in our [download][download] page.

Identifique su instalación de PHP, así como la arquitectura. Si descarga el archivo DLL erróneo, Phalcon no funcionará. `phpinfo()` contiene esta información. En el ejemplo siguiente, vamos a necesitar la versión NTS de la DLL:

![phpinfo](/assets/images/content/phpinfo-api.png)

Las DLL disponibles son:

| Arquitectura | Versión | Tipo                  |
|:------------:|:-------:| --------------------- |
|     x64      |   7.x   | Thread safe           |
|     x64      |   7.x   | Non Thread safe (NTS) |
|     x86      |   7.x   | Thread safe           |
|     x86      |   7.x   | Non Thread safe (NTS) |

Editar el archivo `php.ini` y luego añadir al final:

```ini
extension=php_phalcon.dll
```

Reinicie su servidor web.

### Compilar Desde Código Fuente
Compilar desde código fuente es similar a la mayoría de los entornos (Linux/macOS).

#### Requerimentos
* Recursos de desarrollo de PHP 7.2.x/7.3.x
* Compilador GCC (Linux/Solaris/FreeBSD) o Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

#### Compilación
Download the latest `zephir.phar` from [here][zephir-phar]. Añada a una carpeta a la que puede acceder su sistema.

Clonar el repositorio

```bash
git clone https://github.com/phalcon/cphalcon
```

Compilación de Phalcon

```bash
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir build
```

Comprueba el módulo

```bash
php -m | grep phalcon
```

Ahora tendrá que añadir `extension=phalcon.so` a su archivo PHP ini y reiniciar su servidor web, para que la extensión sea cargada.
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

The instructions above will compile **and** install the module on your system. También puede compilar la extensión y luego añadirla manualmente a su archivo `ini`:

```bash
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir compile
cd ext
phpize
./configure
make && make install
```

Si usa el método anterior, necesitará añadir la linea `extension=phalcon.so` a su `php.ini` tanto para CLI como para el servidor web.

#### Ajustes de construcción

Por defecto, compilamos para ser lo más compatible posible con todos los procesadores (`gcc -mtune=native -O2 -fomit-frame-pointer`). Si desea que el compilador genere código de máquina optimizado, que coincida con el procesador en el que se está ejecutando actualmente, puede configurar sus propios parámetros de compilación, exportando CFLAGS antes de la compilación. Por ejemplo

```
export CFLAGS="-march=native -O2 -fomit-frame-pointer"
zephir build
```

Esto generará el mejor código posible para ese chipset pero probablemente romperá el objeto compilado en chipsets antiguos.

### Hosting compartido
Ejecutar su aplicación en un alojamiento compartido podría restringirlo en la instalación de Phalcon, especialmente si no tiene acceso root. Algunos paneles de control de alojamiento web afortunadamente tienen soporte de Phalcon.

#### cPanel & WHM
cPanel & WHM soportan Phalcon usando Easy Apache 4 (EA4). You can install Phalcon by enabling the [module][cpanel-phalcon] in Easy Apache 4 (EA4).

#### Plesk
The plesk control panel doesn't have Phalcon support but you can find installation instructions on the Plesk [website][plesk]

[plesk]: https://support.plesk.com/hc/en-us/articles/115002186489-How-to-install-Phalcon-framework-for-a-PHP-supplied-by-Plesk-
[cpanel-phalcon]: https://github.com/CpanelInc/scl-phalcon
[curl]: https://www.php.net/manual/en/book.curl.php
[download]: https://phalcon.io/en/download/windows
[fileinfo]: https://www.php.net/manual/en/book.fileinfo.php
[gettext]: https://www.php.net/manual/en/book.gettext.php
[gd2]: https://www.php.net/manual/en/book.image.php
[gentoo-overlay]: https://github.com/smoke/phalcon-gentoo-overlay
[imagick]: https://www.php.net/manual/en/book.imagick.php
[json]: https://www.php.net/manual/en/book.json.php
[mbstring]: https://php.net/manual/en/book.mbstring.php
[memcached]: https://php.net/manual/en/book.memcached.php
[mysql]: https://php.net/manual/en/ref.pdo-mysql.php
[ondrej]: https://launchpad.net/~ondrej/+archive/ubuntu/php/
[openssl]: https://php.net/manual/en/book.openssl.php
[packagecloud]: https://packagecloud.io/phalcon
[pcre]: https://www.pcre.org/
[pdo]: https://php.net/manual/en/book.pdo.php
[php-support]: https://www.php.net/supported-versions.php
[postgresql]: https://php.net/manual/en/ref.pdo-pgsql.php
[psr-extension]: https://github.com/jbboehr/php-psr
[remi]: https://github.com/remicollet
[remi-config]: https://blog.remirepo.net/pages/Config-en
[zephir-phar]: https://github.com/phalcon/zephir/releases
[install-pecl]: https://pear.php.net/manual/en/installation.getting.php
[install-phpbrew]: https://github.com/phpbrew/phpbrew/wiki/Quick-Start
