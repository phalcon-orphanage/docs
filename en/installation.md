---
layout: default
language: 'en'
version: '4.0'
title: 'Installation'
keywords: 'installation, installing Phalcon'
---
# Installation
<hr/>
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Requirements

### PHP 7.2
Phalcon v4 supports only PHP 7.2 and above. PHP 7.1 has been released 2 years ago and its [active support][php-support] has lapsed, so we decided to follow actively supported PHP versions.

### PSR
Phalcon requires the PSR extension. The extension can be downloaded and compiled from [this][psr-extension] GitHub repository. Installation instructions are available on the `README` of the repository. Once the extension has been compiled and is available in your system, you will need to load it to your `php.ini`. You will need to add this line:

```ini
extension=psr.so
```

before

```ini
extension=phalcon.so
```

Alternatively some distributions add a number prefix on `ini` files. If that is the case, choose a high number for Phalcon (e.g. `50-phalcon.ini`).

Using Pecl this extension will be automatically installed. 

### PDO
Since Phalcon is loosely coupled, it exposes functionality without the need for additional extensions. However certain components rely on additional extensions to work. When in need for database connectivity and access, you will need to install the `php_pdo` extension. If your RDBMS is MySQL/MariaDB or Aurora, you will need the `php_mysqlnd` extension also. Similarly, using a PostgreSql database with Phalcon requires the `php_pgsql` extension.

### Hardware
Phalcon is designed to use as little resources as possible, while offering high performance. Although we have tested Phalcon in various low end environments, (such as 0.25GB RAM, 0.5 CPU), the hardware that you will choose will depend on the your application needs.

We have hosted our website and blog for the last few years on an Amazon VM with 512MB RAM and 1 vCPU.

### Software

> **NOTE**: You should always try and use the latest version of Phalcon and PHP as both address bugs, security enhancements as well as performance.
{: .alert .alert-danger }

Along with PHP 7.2 or greater, depending on your application needs and the Phalcon components you need, you might need to install the following extensions:

* [curl][curl]
* [fileinfo][fileinfo]
* [gettext][gettext]
* [gd2][gd2] (to use the [Phalcon\Image\Adapter\Gd](api/Phalcon_Image_Adapter_Gd) class)
* [imagick][imagick] (to use the [Phalcon\Image\Adapter\Imagick](api/Phalcon_Image_Adapter_Imagick) class)
* [json][json]
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (macOS)
* [PDO][pdo] Extension as well as the relevant RDBMS specific extension (i.e. [MySQL][mysql], [PostgreSql][postgresql] etc.)
* [OpenSSL][openssl] Extension
* [Mbstring][mbstring] Extension
* [Memcached][memcached] or other relevant cache adapters depending on your usage of cache

> **NOTE**: Installing these packages will vary based on your operating system as well as the package manager you use (if any). Please consult the relevant documentation on how to install these extensions.
{: .alert .alert-info }

For the `libpcre3-dev` package you can use the following commands:

### Pecl
The Pecl installation method is available for Windows, Linux and MacOS. Under windows pre-compiled dll files will be used. Under Linux and MacOS it will compile Phalcon locally so it could be faster to use a different installation method on these platforms. To install using Pecl make sure you have [pecl/pear][install-pecl] installed. 
```
pecl channel-update pecl.php.net
pecl install phalcon
```

#### Debian
```bash
sudo apt-get install libpcre3-dev
```
and then try and install Phalcon again

#### CentOS
```bash
sudo yum install pcre-devel
```

#### Mac/Osx using Brew
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

For Maverick
```bash
brew install pcre
```
if it gives you error, you can use

```bash
sudo ln -s /opt/local/include/pcre.h /usr/include/
sudo pecl install apc 
```

## Installation Platforms
Since Phalcon is compiled as a PHP extension, its installation is somewhat different than any other traditional PHP framework. Phalcon needs to be installed and loaded as a module on your web server.

### Linux
To install Phalcon on Linux, you will need to add our repository in your distribution and then install it.

#### DEB Based Distributions (Debian, Ubuntu, Etc.)

##### Repository installation
Add the repository to your distribution:

**Stable releases**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

**Nightly releases**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

**Mainline releases (alpha, beta etc.)**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.deb.sh | sudo bash
```

> **NOTE**: This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds.
{: .alert .alert-warning }

##### Phalcon installation
To install Phalcon you need to type the following commands in your terminal:

```bash
sudo apt-get update
sudo apt-get install php7.2-phalcon
```

##### Additional PPAs
**Ondřej Surý**

If you do not wish to use our repository at [packagecloud.io][packagecloud], you can always use the one offered by [Ondřej Surý][ondrej].

Installation of the repo:
```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

and Phalcon:

```php
sudo apt-get install php-phalcon4
```

#### RPM Based Distributions (CentOS, Fedora, Etc.)

##### Repository installation
Add the repository to your distribution:

**Stable releases**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

**Nightly releases**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

**Mainline releases (alpha, beta etc.)**
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.rpm.sh | sudo bash
```

> **NOTE**: This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds.
{: .alert .alert-warning }


##### Phalcon installation
To install Phalcon you need to issue the following commands in your terminal:

```bash
sudo yum update
sudo yum install php72u-phalcon
```

##### Additional RPMs
**Remi**

[Remi Collet][remi] maintains an excellent repository for RPM based installations. You can find instructions on how to enable it for your distribution [here][remi-config].

Installing Phalcon after that is as easy as:

```bash
yum install php72-php-phalcon4
```

Additional versions are available both architecture specific (x86/x64) as well as PHP version specific


#### FreeBSD
A port is available for FreeBSD. To install it you will need to issue the following commands:

##### pkg_add

```bash
pkg_add -r phalcon4
```

##### Source
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

It is also necessary to increase the swap file from the default 100 MB to at least 2000 MB. Because, the compiler lacks RAM.

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
Brew includes binary packages so you don't need to compile Phalcon yourself.
If you want to compile the extension yourself you need the following dependencies installed:

#### Compilation requirements
* PHP 7.x development resources
* XCode

#### Brew
Binary installation (preferred):
```bash
brew tap phalcon/extension https://github.com/phalcon/homebrew-tap
brew install phalcon
```
Compile phalcon:
```bash
brew tap phalcon/extension https://github.com/phalcon/homebrew-tap
brew install phalcon --build-from-source 
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

### PHPBrew (macOS/Linux)

```bash
sudo phpbrew ext install phalcon
```

You can install the PSR dependency via phpbrew as well if needed:

```bash
sudo phpbrew ext install psr
```

### Windows
To use Phalcon on Windows, you will need to install the phalcon.dll. We have compiled several DLLs depending on the target platform. The DLLs can be found in our [download][download] page.

Identify your PHP installation as well as architecture. If you download the wrong DLL, Phalcon will not work. `phpinfo()` contains this information. In the example below, we will need the NTS version of the DLL:

![phpinfo](/assets/images/content/phpinfo-api.png)

The available DLLs are:

| Architecture | Version | Type                  |
| :----------: | :-----: |---------------------- |
| x64          | 7.x     | Thread safe           |
| x64          | 7.x     | Non Thread safe (NTS) |
| x86          | 7.x     | Thread safe           |
| x86          | 7.x     | Non Thread safe (NTS) |

Edit your php.ini file and then append at the end:

```ini
extension=php_phalcon.dll
```

Restart your webserver.

### Compile From Sources
Compiling from source is similar to most environments (Linux/macOS).

#### Requirements
* PHP 7.2.x/7.3.x development resources
* GCC compiler (Linux/Solaris/FreeBSD) or Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

#### Compilation
Download the latest `zephir.phar` from [here][zephir-phar]. Add it to a folder that can be accessed by your system.

Clone the repository

```bash
git clone https://github.com/phalcon/cphalcon
```

Compile Phalcon

```bash
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir build
```

Check the module

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
git checkout tags/v4.0.0 ./
zephir fullclean
zephir compile
cd ext
phpize
./configure
make && make install
```

If you use the above method you will need to add the `extension=phalcon.so` in your `php.ini` both for CLI and web server.

#### Tuning Build

By default we compile to be as compatible as possible with all processors (`gcc -mtune=native -O2 -fomit-frame-pointer`). If you would like instruct the compiler to generate optimized machine code that matches the processor where it is currently running on you can set your own compile flags by exporting CFLAGS before the build.
For example

```
export CFLAGS="-march=native -O2 -fomit-frame-pointer"
zephir build
```

This will generate the best possible code for that chipset but will likely break the compiled object on older chipsets.

### Shared Hosting 
Running your application on shared hosting might restrict you in installing Phalcon, especially if you do not have root access. Some web hosting control panels luckily have Phalcon support.

#### cPanel & WHM
cPanel & WHM support Phalcon using Easy Apache 4 (EA4). You can install Phalcon by enabling the [module][cpanel-phalcon] in Easy Apache 4 (EA4).

#### Plesk
The plesk control panel doesn't have Phalcon support but you can find installation instructions on the Plesk [website][plesk]

[plesk]: https://support.plesk.com/hc/en-us/articles/115002186489-How-to-install-Phalcon-framework-for-a-PHP-supplied-by-Plesk-
[cpanel-phalcon]: https://github.com/CpanelInc/scl-phalcon
[curl]: https://secure.php.net/manual/en/book.curl.php
[download]: https://phalcon.io/en/download/windows
[fileinfo]: https://secure.php.net/manual/en/book.fileinfo.php
[gettext]: https://secure.php.net/manual/en/book.gettext.php
[gd2]: https://secure.php.net/manual/en/book.image.php
[gentoo-overlay]: https://github.com/smoke/phalcon-gentoo-overlay
[imagick]: https://secure.php.net/manual/en/book.imagick.php
[json]: https://secure.php.net/manual/en/book.json.php
[mbstring]: https://php.net/manual/en/book.mbstring.php
[memcached]: https://php.net/manual/en/book.memcached.php 
[mysql]: https://php.net/manual/en/ref.pdo-mysql.php
[ondrej]: https://launchpad.net/~ondrej/+archive/ubuntu/php/
[openssl]: https://php.net/manual/en/book.openssl.php
[packagecloud]: https://packagecloud.io/phalcon
[pcre]: https://www.pcre.org/
[pdo]: https://php.net/manual/en/book.pdo.php
[php-support]: https://secure.php.net/supported-versions.php
[postgresql]: https://php.net/manual/en/ref.pdo-pgsql.php
[psr-3]: https://www.php-fig.org/psr/psr-3/
[psr-extension]: https://github.com/jbboehr/php-psr
[remi]: https://github.com/remicollet
[remi-config]: https://blog.remirepo.net/pages/Config-en
[zephir-phar]: https://github.com/phalcon/zephir/releases
[install-pecl]: https://pear.php.net/manual/en/installation.getting.php
