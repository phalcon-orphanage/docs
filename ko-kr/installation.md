---
layout: 기본값
language: 'ko'
version: '4.0'
title: '설치하기'
keywords: '설치, Phalcon 설치, 팔콘설치'
---

# 설치하기

* * *

![](/assets/images/document-status-stable-success.svg)

## 사전 요구사항

### PHP 7.2

Phalcon v4는 PHP 7.2 이상만 지원합니다. PHP 7.1이 출시된 지 2년이 지났고 [기술지원(active support)](https://secure.php.net/supported-versions.php) 도 이제는 끝난 상황이라, 기술지원이 되는 PHP버전을 따르기로 결정했습니다.

### PSR

Phalcon은 PSR 익스텐션이 필요합니다. 이 익스텐션은 [여기](https://github.com/jbboehr/php-psr) 깃헙 저장소에서 다운로드 받아서 컴파일 할 수 있습니다. 설치 설명서는 저장소의 `README`에서 확인하실 수 있습니다. 익스텐션이 컴파일 되어 시스템에서 사용가능해 지면, `php.ini` 파일에 추가해 주어야 합니다. 다음과 같이 추가해 주시면 됩니다:

```ini
extension=psr.so
```

phalcon 익스텐션보다 위에 위치해야 함

```ini
extension=phalcon.so #Phalcon 익스텐션
```

일부 배포판의 경우 `ini` 파일명에 접두어로 숫자를 붙이는 경우가 있습니다. 그런 경우, Phalcon 에는 높은 숫자를 할당해 주세요 ( 예. `50-phalcon.ini`).

### PDO

Phalcon은 느슨하게 연결되어 있기 때문에, 추가적인 익스텐션 필요없이 기능을 사용할 수 있습니다. 하지만 특정 컴포넌트는 동작을 위해 추가적인 익스텐션이 필요한 경우가 있습니다. 데이터베이스 연결 및 사용이 필요한 경우, `php_pdo` 익스텐션을 설치해야 합니다. 사용중인 RDBMS가 MYSQL/MariaDB 혹은 Aurora인 경우, `php_mysqlnd` 익스텍션도 필요합니다. Similarly, using a PostgreSql database with Phalcon requires the `php_pgsql` extension.

### Hardware

Phalcon is designed to use as little resources as possible, while offering high performance. Although we have tested Phalcon in various low end environments, (such as 0.25GB RAM, 0.5 CPU), the hardware that you will choose will depend on the your application needs.

We have hosted our website and blog for the last few years on an Amazon VM with 512MB RAM and 1 vCPU.

### Software

> You should always try and use the latest version of Phalcon and PHP as both address bugs, security enhancements as well as performance.
{: .alert .alert-danger }

Along with PHP 7.2 or greater, depending on your application needs and the Phalcon components you need, you might need to install the following extensions:

* [curl](https://secure.php.net/manual/en/book.curl.php)
* [fileinfo](https://secure.php.net/manual/en/book.fileinfo.php)
* [gettext](https://secure.php.net/manual/en/book.gettext.php)
* [gd2](https://secure.php.net/manual/en/book.image.php) (to use the [Phalcon\Image\Adapter\Gd](api/Phalcon_Image_Adapter_Gd) class)
* [imagick](https://secure.php.net/manual/en/book.imagick.php) (to use the [Phalcon\Image\Adapter\Imagick](api/Phalcon_Image_Adapter_Imagick) class)
* [json](https://secure.php.net/manual/en/book.json.php)
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (macOS)
* [PDO](https://php.net/manual/en/book.pdo.php) Extension as well as the relevant RDBMS specific extension (i.e. [MySQL](https://php.net/manual/en/ref.pdo-mysql.php), [PostgreSql](https://php.net/manual/en/ref.pdo-pgsql.php) etc.)
* [OpenSSL](https://php.net/manual/en/book.openssl.php) Extension
* [Mbstring](https://php.net/manual/en/book.mbstring.php) Extension
* [Memcached](https://php.net/manual/en/book.memcached.php) or other relevant cache adapters depending on your usage of cache

> Installing these packages will vary based on your operating system as well as the package manager you use (if any). Please consult the relevant documentation on how to install these extensions.
{: .alert .alert-info }

For the `libpcre3-dev` package you can use the following commands:

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

#### Mac/Osx using brew

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

#### DEB based distributions (Debian, Ubuntu, etc.)

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

> This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds.
{: .alert .alert-warning }

##### Phalcon installation

To install Phalcon you need to type the following commands in your terminal:

```bash
sudo apt-get update
sudo apt-get install php7.2-phalcon
```

##### Additional PPAs

**Ondřej Surý**

If you do not wish to use our repository at [packagecloud.io](https://packagecloud.io/phalcon), you can always use the one offered by [Ondřej Surý](https://launchpad.net/~ondrej/+archive/ubuntu/php/).

Installation of the repo:

```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

and Phalcon:

```php
sudo apt-get install php-phalcon
```

#### RPM based distributions (CentOS, Fedora, etc.)

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

> This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds.
{: .alert .alert-warning }


##### Phalcon installation

To install Phalcon you need to issue the following commands in your terminal:

```bash
sudo yum update
sudo yum install php72u-phalcon
```

##### Additional RPMs

**Remi**

[Remi Collet](https://github.com/remicollet) maintains an excellent repository for RPM based installations. You can find instructions on how to enable it for your distribution [here](https://blog.remirepo.net/pages/Config-en).

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

An overlay for installing Phalcon can be found [here](https://github.com/smoke/phalcon-gentoo-overlay)

### macOS

On a macOS system you can compile and install the extension with `brew`, `macports` or the source code:

#### Requirements

* PHP 7.2.x development resources
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

| Architecture | Version | Type                  |
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

### Compile from Sources

Compiling from source is similar to most environments (Linux/macOS).

#### Requirements

* PHP 7.2.x/7.3.x development resources
* GCC compiler (Linux/Solaris/FreeBSD) or Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

#### Compilation

Download the latest `zephir.phar` from [here](https://github.com/phalcon/zephir/releases). Add it to a folder that can be accessed by your system.

Clone the repository

```bash
git clone https://github.com/phalcon/cphalcon
```

Compile Phalcon

```bash
cd cphalcon/
git checkout tags/v4.0.0-alpha1 ./
zephir fullclean
zephir build
```

Check the module

```bash
php -m | grep phalcon
```

You will now need to add `extension=phalcon.so` to your PHP ini and restart your web server, so as to load the extension.

```ini
# Suse: Add a file called phalcon.ini in /etc/php7/conf.d/ with this content:
extension=phalcon.so

# CentOS/RedHat/Fedora: Add a file called phalcon.ini in /etc/php.d/ with this content:
extension=phalcon.so

# Ubuntu/Debian with apache2: Add a file called 30-phalcon.ini in /etc/php7/apache2/conf.d/ with this content:
extension=phalcon.so

# Ubuntu/Debian with php7-fpm: Add a file called 30-phalcon.ini in /etc/php7/fpm/conf.d/ with this content:
extension=phalcon.so

# Ubuntu/Debian with php7-cli: Add a file called 30-phalcon.ini in /etc/php7/cli/conf.d/ with this content:
extension=phalcon.so
```

The instructions above will compile **and** install the module on your system. You can also compile the extension and then add it manually in your `ini` file:

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

If you use the above method you will need to add the `extension=phalcon.so` in your `php.ini` both for CLI and web server.

#### Tuning build

By default we compile to be as compatible as possible with all processors (`gcc -mtune=native -O2 -fomit-frame-pointer`). If you would like instruct the compiler to generate optimized machine code that matches the processor where it is currently running on you can set your own compile flags by exporting CFLAGS before the build. For example

    export CFLAGS="-march=native -O2 -fomit-frame-pointer"
    zephir build
    

This will generate the best possible code for that chipset but will likely break the compiled object on older chipsets.

### Shared hosting

Running your application on shared hosting might restrict you in installing Phalcon, especially if you do not have root access. Some web hosting control panels luckly have Phalcon support.

#### cPanel & WHM

cPanel & WHM support Phalcon using Easy Apache 4 (EA4). You can install Phalcon by enabling the [module](https://github.com/CpanelInc/scl-phalcon) in Easy Apache 4 (EA4).

#### Plesk

The plesk control panel doesn't have Phalcon support but you can find installation instructions on the Plesk [website](https://support.plesk.com/hc/en-us/articles/115002186489-How-to-install-Phalcon-framework-for-a-PHP-supplied-by-Plesk-)