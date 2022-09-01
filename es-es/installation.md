---
layout: default
language: 'es-es'
version: '5.0'
title: 'Instalación'
keywords: 'instalación, instalación de Phalcon'
---

# Instalación
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Requerimentos

### PHP 7.4
Phalcon v5 supports only PHP 7.4 and above. PHP 7.4 has been released 2 years ago and its [active support][php-support] was until November 2021, while security updates were until November 2022. Phalcon follows actively supported PHP versions, therefore support for PHP 7.4 will not be available in future versions. La instalación de un servidor web está fuera del ámbito de este documento. Por favor, consulte las guías relevantes en Internet sobre cómo instalar un servidor web.

### PDO
Dado que Phalcon tiene bajo acoplamiento, expone la funcionalidad sin necesidad de extensiones adicionales. Sin embargo, ciertos componentes dependen de extensiones adicionales para funcionar. Cuando necesite conectividad y acceso a la base de datos, necesitará instalar la extensión `php_pdo`. Si su RDBMS es MySQL/MariaDB o Aurora, también se necesita la extensión `php_mysqlnd`. De manera similar, usar una base de datos PostgreSql con Phalcon requiere la extensión `php_pgsql`.

### Orden de Carga
Phalcon needs to be loaded after `PDO`. Algunas distribuciones añaden un prefijo numérico en los archivos `ini`. If that is the case, choose a high number for Phalcon (e.g. `50-phalcon.ini`), higher than `PDO`. This will load Phalcon after the prerequisite extensions. Sin embargo, si su distribución solo tiene un archivo `php.ini`, por favor asegúrese de que el orden es similar a este:

```ini
extension=pdo.so
extension=phalcon.so
```

### Hardware
Phalcon is designed to use as few resources as possible, while offering high performance. Although we have tested Phalcon in various high-end environments, (such as 0.25GB RAM, 0.5 CPU), the hardware that you will choose will depend on your application needs.

Hemos alojado nuestro sitio web y blog durante los últimos años en una VM de Amazon con 512MB de RAM y 1 vCPU.

### Software

> **NOTE**: You should always try and use the latest version of Phalcon and PHP as both address bugs, security enhancements as well as performance. 
> 
> {: .alert .alert-danger }

Along with PHP 7.4 or greater, depending on your application needs and the Phalcon components you need, you might need to install the following extensions:

* [curl][curl]
* [fileinfo][fileinfo]
* [gettext][gettext]
* [gd2][gd2] (to use the [Phalcon\Image\Adapter\Gd](api/phalcon_image#image-adapter-gd) class)
* [imagick][imagick] (to use the [Phalcon\Image\Adapter\Imagick](api/phalcon_image#image-adapter-imagick) class)
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

#### PCRE
##### Debian
```bash
sudo apt-get install libpcre3-dev
```
y luego intente instalar Phalcon otra vez

##### CentOS
```bash
sudo yum install pcre-devel
```

##### Mac/Osx usando Brew
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
Since Phalcon is compiled as a PHP extension, its installation is somewhat different from any other traditional PHP framework. Phalcon necesita ser instalado y cargado como un módulo en su servidor web.

> **NOTE**: The preferred method of installation is through [PECL][install-pecl]. 
> 
> {: .alert .alert-info }

### PECL
The PECL installation method is available for Windows, Linux and macOS. Under windows pre-compiled dll files are available, while under Linux and macOS, Phalcon will be compiled locally. To install Phalcon using PECL make sure you have [pecl/pear][install-pecl] installed.
```
pecl channel-update pecl.php.net
pecl install phalcon-5.0.0
```

### Additional PPA
#### Linux DEB: **Ondřej Surý**

You can install the repository offered by [Ondřej Surý][ondrej].

Instalación del repositorio:
```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

y Phalcon:

```php
sudo apt-get install php-phalcon5
```

#### Linux RPM: **Remi**

[Remi Collet][remi] maintains an excellent repository for RPM based installations. You can find instructions on how to enable it for your distribution [here][remi-config].

La instalación de Phalcon después de eso, es tan fácil como:

```bash
yum install php72-php-phalcon4
```

Additional versions are available both architecture specific (x86/x64) and PHP version specific


### FreeBSD
Binary package (pkg) and compile from source (ports) are available for FreeBSD. Para instalarlo deberá ejecutar los siguientes comandos:

##### pkg
```bash
pkg install php74-phalcon5
```

##### ports
```bash
cd /usr/ports/www/phalcon5

make install clean
```

### Gentoo
An overlay for installing Phalcon can be found [here][gentoo-overlay]

### Raspberry Pi

```bash
sudo -s
git clone https://github.com/phalcon/cphalcon
cd cphalcon/
git checkout tags/v5.0.0 ./
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
Brew includes binary packages, so you don't need to compile Phalcon yourself. Si desea compilar la extensión usted mismo, necesita las siguientes dependencias instaladas:

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
|     x64      |   8.x   | Thread safe           |
|     x64      |   8.x   | Non Thread safe (NTS) |
|     x86      |   8.x   | Thread safe           |
|     x86      |   8.x   | Non Thread safe (NTS) |

Editar el archivo `php.ini` y luego añadir al final:

```ini
extension=php_phalcon.dll
```

Reinicie su servidor web.

### Compilar Desde Código Fuente
Compilar desde código fuente es similar a la mayoría de los entornos (Linux/macOS).

#### Requerimentos
* PHP 7.4.x+ development resources
* Compilador GCC (Linux/Solaris/FreeBSD) o Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

#### Compilación
If you wish to compile Phalcon you can do so by using [Zephir][zephir-phar]. You will first need to have the [Zephir Parser][zephir-parser] installed in your system:

```bash
pecl install zephir_parser
```

Depending on your target system, you might need to create a `zephir_parser.ini` file, to load this extension. The contents of the file should be:

```ini
extension=zephir_parser.so
```

and you might need to enable the extension using `phpenmod`

```bash
phpenmod zephir_parser
```

You will then need to download the latest `zephir.phar` from [here][zephir-phar]. Move the file to a folder that is available in your `PATH`, such as `/usr/local/bin` for example, and make it executable:

```bash
mv zephir.phar /usr/local/bin 
cd /usr/local/bin/
mv zephir.phar zephir 
chmod a+x zephir
```
You might also need to change the ownership of the file, depending on your environment.

Clone the repository to a location on your file system.

```bash
git clone https://github.com/phalcon/cphalcon
```

Compilación de Phalcon

```bash
cd cphalcon/
git checkout tags/v5.0.0 ./
zephir fullclean
zephir build
```

Comprueba el módulo

```bash
php -m | grep phalcon
```

You will now need enable Phalcon. Create a file called `phalcon.ini` with `extension=phalcon.so` as its content. The file should be present in:

- Suse: `/etc/php7/conf.d/phalcon.ini`
- CentOS/RedHat/Fedora: `/etc/php.d/phalcon.ini`
- Ubuntu/Debian with Apache2: `/etc/php7/apache2/conf.d/30-phalcon.ini` with this Content:
- Ubuntu/Debian with Php7-FPM: `/etc/php7/fpm/conf.d/30-phalcon.ini`
- Ubuntu/Debian with Php7-CLI: `/etc/php7/cli/conf.d/30-phalcon.ini`

The instructions above will compile **and** install the module on your system. También puede compilar la extensión y luego añadirla manualmente a su archivo `ini`:

```bash
cd cphalcon/
git checkout tags/v5.0.0 ./
zephir fullclean
zephir compile
cd ext
phpize
./configure
make && make install
```

Si usa el método anterior, necesitará añadir la linea `extension=phalcon.so` a su `php.ini` tanto para CLI como para el servidor web.

> **NOTE**: If you are installing Phalcon with PHP 8.+, the paths will vary slightly. 
> 
> {: .alert .alert-warning }

#### Ajustes de construcción

By default, we compile to be as compatible as possible with all processors (`gcc -mtune=native -O2 -fomit-frame-pointer`). Si desea que el compilador genere código de máquina optimizado, que coincida con el procesador en el que se está ejecutando actualmente, puede configurar sus propios parámetros de compilación, exportando CFLAGS antes de la compilación. Por ejemplo

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
The plesk control panel doesn't have Phalcon support, but you can find installation instructions on the Plesk [website][plesk]

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
[pcre]: https://www.pcre.org/
[pdo]: https://php.net/manual/en/book.pdo.php
[php-support]: https://www.php.net/supported-versions.php
[postgresql]: https://php.net/manual/en/ref.pdo-pgsql.php
[remi]: https://github.com/remicollet
[remi-config]: https://blog.remirepo.net/pages/Config-en
[zephir-parser]: https://github.com/zephir-lang/php-zephir-parser/releases
[zephir-phar]: https://github.com/phalcon/zephir/releases
[zephir-phar]: https://github.com/phalcon/zephir/releases
[install-pecl]: https://pear.php.net/manual/en/installation.getting.php
[install-pecl]: https://pear.php.net/manual/en/installation.getting.php
[install-phpbrew]: https://github.com/phpbrew/phpbrew/wiki/Quick-Start
