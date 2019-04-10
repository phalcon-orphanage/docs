---
layout: default
language: 'es-es'
version: '4.0'
category: 'installation'
---
# Instalación

* * *

## Requerimentos

### PHP 7.2

Phalcon v4 soporta sólo PHP 7.2 y superiores. PHP 7.1 ha sido publicado hace 2 años y su [soporte activo](https://secure.php.net/supported-versions.php) ha caducado, así que decidimos seguir activamente las versiones soportadas de PHP.

### PSR

Phalcon requiere la extensión PSR. La extensión se puede descargar y compilar desde [este repositorio de GitHub](https://github.com/jbboehr/php-psr). Las instrucciones de instalación están disponibles en el `README` del repositorio. Una vez que la extensión haya sido compilada y esté disponible en su sistema, necesitará cargarla a su `php.ini`. Necesitarás añadir esta línea:

```ini
extension=psr.so
```

before

```ini
extension=phalcon.so
```

Alternativamente algunas distribuciones añaden un prefijo numérico en los archivos `ini`. Si ese es el caso, elija un número alto para Phalcon (por ejemplo `50-phalcon.ini`).

### PDO

Dado que Phalcon tiene bajo acoplamiento, expone la funcionalidad sin necesidad de extensiones adicionales. Sin embargo, ciertos componentes dependen de extensiones adicionales para funcionar. Cuando necesite conectividad y acceso a la base de datos, necesitará instalar la extensión `php_pdo`. Si su RDBMS es MySql/MariaDB o Aurora, también se necesita la extensión `php_mysqlnd`. De manera similar, si utiliza una base de datos PostgreSQL con Phalcon, la extensión `php_pgsql` será requerida.

### Hardware

Phalcon fue diseñado para utilizar los menos recursos posibles, al tiempo que ofrece un alto rendimiento. Aunque hemos probado Phalcon en varios ambientes de bajo rendimiento, (por ejemplo 0.25GB RAM, 0.5 CPU), el hardware que usted elija dependerá de las necesidades de su aplicación.

Hemos alojado nuestro sitio web y blog durante los últimos años en una VM de Amazon con 512MB de RAM y 1 vCPU.

### Software

> Siempre deberias utilizar la última versión de PHP y Phalcon para evitar bugs, mejorar la seguridad y el rendimento.
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

> La instalación de estos paquetes variará en función de su sistema operativo, así como del gestor de paquetes que utilice (si corresponde). Por favor consulte la documentación pertinente sobre cómo instalar estas extensiones.
{: .alert .alert-info }

Para el paquete `libpcre3-dev` puedes usar los siguientes comandos:

#### Debian

```bash
sudo apt-get install libpcre3-dev
```

y luego intenta instalar Phalcon nuevamente

#### CentOS

```bash
sudo yum install pcre-devel
```

#### Mac

```bash
brew install pcre
```

Sin `brew`, necesitas ir al sitio web [PCRE](https://www.pcre.org/) y descargar la última pcre:

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

#### Distribuciones basadas en DEB (Debian, Ubuntu, etc)

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

> Esto sólo debe hacerse una sola vez, a menos que cambie su distribución o quiera cambiar de versiones estables a nocturnas.
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

#### Distribuciones basadas en RPM (CentOS, Fedora, etc.)

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

> Esto sólo debe hacerse una sola vez, a menos que cambie su distribución o quiera cambiar de versiones estables a nocturnas.
{; .alert .alert-warning }


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
pkg_add -r phalcon
```

##### Codigo fuente

```bash
export CFLAGS="-O2 --fvisibility=hidden"

cd /usr/ports/www/phalcon

make install clean
```

##### Gentoo

Un overlay para la instalación de Phalcon se puede encontrar [aquí](https://github.com/smoke/phalcon-gentoo-overlay)

### macOS

En sistemas macOS puede compilar e instalar la extensión con `brew`, `macports` o el código fuente:

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

Editar el archivo php.ini y luego añadir al final:

```ini
extension=php_phalcon.so
```

Reiniciar tu navegador web.

### Windows

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

Editar el archivo php.ini y luego añadir al final:

```ini
extension=php_phalcon.dll
```

Reiniciar tu navegador web.

### Compilar desde código fuente

Compilar desde código fuente es similar a la mayoría de los entornos (Linux/macOS).

#### Requerimentos

* Recursos de desarrollo de PHP 7.2.x/7.3.x
* Compilador GCC (Linux/Solaris/FreeBSD) o Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

#### Compilación

Descarga la última `zephir.phar` desde [aquí](https://github.com/phalcon/zephir/releases). Añada a una carpeta a la que puede acceder su sistema.

Clonar el repositorio

```bash
git clone https://github.com/phalcon/cphalcon
```

Compilar Phalcon

```bash
cd cphalcon/
git checkout tags/v4.0.0-alpha1 ./
zephir fullclean
zephir build
```

Comprueba el módulo

```bash
php -m | grep phalcon
```

Ahora usted tendrá que añadir `extension=phalcon.so` a su archivo PHP ini y reiniciar su servidor web, para que la extensión sea cargada.

```ini
# Suse: Agregue un archivo llamado phalcon.ini en /etc/php7/conf.d/ con el siguiente contenido:
extension=phalcon.so

# CentOS/RedHat/Fedora: Agregue un archivo llamado phalcon.ini en /etc/php.d/ con el siguiente contenido:
extension=phalcon.so

# Ubuntu/Debian con apache2: Agregue un archivo llamado 30-phalcon.ini en /etc/php7/apache2/conf.d/ con el siguiente contenido:
extension=phalcon.so

# Ubuntu/Debian con php7-fpm: Agregue un archivo llamado 30-phalcon.ini en /etc/php7/fpm/conf.d/ con el siguiente contenido:
extension=phalcon.so

# Ubuntu/Debian con php7-cli: Agregue un archivo llamado 30-phalcon.ini en /etc/php7/cli/conf.d/ con el siguiente contenido:
extension=phalcon.so
```

Las instrucciones anteriores compilarán e instalarán el módulo en su sistema. También puedes compilar la extensión y luego añadirla manualmente en tu archivo `ini`:

```bash
cd cphalcon/
git checkout tags/v4.0.0-alpha1 ./
zephir fullclean
zephir compile
cd ext
phpize
./configure
make && make install
```

Si usas el método anterior, necesitarás añadir la linea `extension=phalcon.so` en tu `php.ini` tanto para CLI como para el servidor web.

#### Ajuste de construcción

Por defecto, compilamos para ser lo más compatible posible con todos los procesadores (`gcc -mtune=native -O2 -fomit-frame-pointer`). Si desea que el compilador genere código de máquina optimizado, que coincida con el procesador en el que se está ejecutando actualmente, puede configurar sus propios parámetros de compilación, exportando CFLAGS antes de la compilación. Por ejemplo

    export CFLAGS="-march=native -O2 -fomit-frame-pointer"
    zephir build
    

Esto generará el mejor código posible para ese chipset pero probablemente romperá el objeto compilado en chipsets antiguos.

### Hosting compartido - cPanel

Aunque el alojamiento dedicado es extremadamente barato, usted puede optar por el alojamiento compartido. Esto podría restringirle la instalación de Phalcon, especialmente si no tiene acceso root.

Si su servidor de hosting compartido está ejecutando cPanel, puede instalar Phalcon siguiendo las instrucciones en [este repositorio](https://github.com/thecpaneladmin/EA-PhalconPHP)