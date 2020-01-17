---
layout: default
language: 'ko-kr'
version: '4.0'
title: '설치하기'
keywords: '설치, Phalcon 설치, 팔콘설치'
---

# 설치하기

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

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
extension=phalcon.so
```

일부 배포판의 경우 `ini` 파일명에 접두어로 숫자를 붙이는 경우가 있습니다. 그런 경우, Phalcon 에는 높은 숫자를 할당해 주세요 ( 예. `50-phalcon.ini`).

Using Pecl this extension will be automatically installed.

### PDO

Since Phalcon is loosely coupled, it exposes functionality without the need for additional extensions. However certain components rely on additional extensions to work. When in need for database connectivity and access, you will need to install the `php_pdo` extension. If your RDBMS is MySQL/MariaDB or Aurora, you will need the `php_mysqlnd` extension also. Similarly, using a PostgreSql database with Phalcon requires the `php_pgsql` extension.

### 하드웨어

Phalcon is designed to use as little resources as possible, while offering high performance. Although we have tested Phalcon in various low end environments, (such as 0.25GB RAM, 0.5 CPU), the hardware that you will choose will depend on the your application needs.

We have hosted our website and blog for the last few years on an Amazon VM with 512MB RAM and 1 vCPU.

### 소프트웨어

> **주의**: 버그 해결, 보안 강화 뿐만이 아니라 성능향상을 위해서라도 Phalcon과 PHP는 가능한 항상 최신버전을 사용해야 합니다.
{: .alert .alert-danger }

Along with PHP 7.2 or greater, depending on your application needs and the Phalcon components you need, you might need to install the following extensions:

* [curl](https://secure.php.net/manual/en/book.curl.php)
* [fileinfo](https://secure.php.net/manual/en/book.fileinfo.php)
* [gettext](https://secure.php.net/manual/en/book.gettext.php)
* [gd2](https://secure.php.net/manual/en/book.image.php) ( [Phalcon\Image\Adapter\Gd](api/Phalcon_Image_Adapter_Gd) 클래스 사용시 필요)
* [imagick](https://secure.php.net/manual/en/book.imagick.php) ( [Phalcon\Image\Adapter\Imagick](api/Phalcon_Image_Adapter_Imagick) 클래스 사용시 필요)
* [json](https://secure.php.net/manual/en/book.json.php)
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (macOS)
* [PDO](https://php.net/manual/en/book.pdo.php) 익스텐션과 사용해야할 특정 RDBMS 익스텐션 (즉, [MySQL](https://php.net/manual/en/ref.pdo-mysql.php), [PostgreSql](https://php.net/manual/en/ref.pdo-pgsql.php) 등)
* [OpenSSL](https://php.net/manual/en/book.openssl.php) 익스텐션
* [Mbstring](https://php.net/manual/en/book.mbstring.php) 익스텐션
* 캐시 사용 여부 및 방식에 따라 [Memcached](https://php.net/manual/en/book.memcached.php) 혹은 관련된 다른 캐시 어댑터

> **주의**: 이 패키지들의 설치는 사용중인 운영체제와 (있다면) 패키지관리자에 따라 달라질 수 있습니다. 이 익스텐션들의 설치방법에 대해서는 관련문서를 참조 해주세요.
{: .alert .alert-info }

For the `libpcre3-dev` package you can use the following commands:

### Pecl

The Pecl installation method is available for Windows, Linux and MacOS. Under windows pre-compiled dll files will be used. Under Linux and MacOS it will compile phalcon locally so it could be faster to use a different installation method on these platforms. To install using Pecl make sure you have [pecl/pear](https://pear.php.net/manual/en/installation.getting.php) installed.

    pecl channel-update pecl.php.net
    pecl install phalcon
    

#### Debian

```bash
sudo apt-get install libpcre3-dev
```

and then try and install Phalcon again

#### CentOS

```bash
sudo yum install pcre-devel
```

#### Mac/Osx에서 Brew 사용시

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

## 설치 플랫폼

Since Phalcon is compiled as a PHP extension, its installation is somewhat different than any other traditional PHP framework. Phalcon needs to be installed and loaded as a module on your web server.

### Linux

To install Phalcon on Linux, you will need to add our repository in your distribution and then install it.

#### DEB 기반의 배포판 ( Debian, Ubuntu 등)

##### 저장소 설치

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

> **주의**: 이 버전의 경우에는 배포판을 변경하거나 Stable 릴리즈에서 nightly 빌드로 전환 하는 경우가 아니라면 최초 한번만 실행하시면 됩니다.
{: .alert .alert-warning }

##### Phalcon 설치

To install Phalcon you need to type the following commands in your terminal:

```bash
sudo apt-get update
sudo apt-get install php7.2-phalcon
```

#### RPM 기반 배포판 (CentOS, Fedora 등)

##### 저장소 설치

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

> **주의**: 이 버전의 경우에는 배포판을 변경하거나 Stable 릴리즈에서 nightly 빌드로 전환 하는 경우가 아니라면 최초 한번만 실행하시면 됩니다.
{: .alert .alert-warning }


##### Phalcon 설치

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

Brew includes binary packages so you don't need to compile Phalcon yourself. If you want to compile the extension yourself you need the following dependencies installed:

#### 컴파일 요구사항

* PHP 7.x 개발 환경
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

### Windows

To use Phalcon on Windows, you will need to install the phalcon.dll. We have compiled several DLLs depending on the target platform. The DLLs can be found in our [download](https://phalcon.io/en/download/windows) page.

Identify your PHP installation as well as architecture. If you download the wrong DLL, Phalcon will not work. `phpinfo()` contains this information. In the example below, we will need the NTS version of the DLL:

![phpinfo](/assets/images/content/phpinfo-api.png)

The available DLLs are:

| 아키텍처 | 버전  | 타입            |
|:----:|:---:| ------------- |
| x64  | 7.x | 멀티스레드 빌드(TS)  |
| x64  | 7.x | 단일스레드 빌드(NTS) |
| x86  | 7.x | 멀티스레드 빌드(TS)  |
| x86  | 7.x | 단일스레드 빌드(NTS) |

Edit your php.ini file and then append at the end:

```ini
extension=php_phalcon.dll
```

Restart your webserver.

### Compile From Sources

Compiling from source is similar to most environments (Linux/macOS).

#### 요구사항

* PHP 7.2x/7.3.x 개발 환경
* GCC 컴파일러 (리눅스/Solaris/FreeBSD) 혹은 Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

#### 컴파일

Download the latest `zephir.phar` from [here](https://github.com/phalcon/zephir/releases). Add it to a folder that can be accessed by your system.

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

#### 빌드 세부조정

By default we compile to be as compatible as possible with all processors (`gcc -mtune=native -O2 -fomit-frame-pointer`). If you would like instruct the compiler to generate optimized machine code that matches the processor where it is currently running on you can set your own compile flags by exporting CFLAGS before the build. For example

    export CFLAGS="-march=native -O2 -fomit-frame-pointer"
    zephir build
    

This will generate the best possible code for that chipset but will likely break the compiled object on older chipsets.

### Shared Hosting

Running your application on shared hosting might restrict you in installing Phalcon, especially if you do not have root access. Some web hosting control panels luckly have Phalcon support.

#### cPanel & WHM

cPanel & WHM support Phalcon using Easy Apache 4 (EA4). You can install Phalcon by enabling the [module](https://github.com/CpanelInc/scl-phalcon) in Easy Apache 4 (EA4).

#### Plesk

The plesk control panel doesn't have Phalcon support but you can find installation instructions on the Plesk [website](https://support.plesk.com/hc/en-us/articles/115002186489-How-to-install-Phalcon-framework-for-a-PHP-supplied-by-Plesk-)