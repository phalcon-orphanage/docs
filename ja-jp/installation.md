---
layout: default
title: 'インストール'
keywords: 'インストール, インストール方法, Phalconのインストール'
---

# インストール
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Requirements

### PHP 7.4
Phalcon v5 supports only PHP 7.4 and above.

PHP 7.4 has been released 2 years ago and its [active support][php-support] was until November 2021, while security updates were until November 2022. Phalcon follows actively supported PHP versions, therefore support for PHP 7.4 will not be available in future versions. We will continue to support PHP 7.4 for v5 for another year, until September 2023. Phalcon v6 and later will support PHP 8.+.

Installing a web server is outside the scope of this document. Please refer to relevant guides on the Internet on how to install a web server.

### PDO
Since Phalcon is loosely coupled, it exposes functionality without the need for additional extensions. However, certain components rely on additional extensions to work. When in need for database connectivity and access, you will need to install the `php_pdo` extension. If your RDBMS is MySQL/MariaDB or Aurora, you will need the `php_mysqlnd` extension also. Similarly, using a PostgreSql database with Phalcon requires the `php_pgsql` extension.

### Load order
Phalcon needs to be loaded after `PDO`. Some distributions add a number prefix on `ini` files. If that is the case, choose a high number for Phalcon (e.g. `50-phalcon.ini`), higher than `PDO`. This will load Phalcon after the prerequisite extensions. If however, your distribution only has a `php.ini` file, please make sure that the order is similar to this:

```ini
extension=pdo.so
extension=phalcon.so
```

### Hardware
Phalcon is designed to use as few resources as possible, while offering high performance. Although we have tested Phalcon in various high-end environments, (such as 0.25GB RAM, 0.5 CPU), the hardware that you will choose will depend on your application needs.

We have hosted our website and blog for the last few years on an Amazon VM with 512MB RAM and 1 vCPU.

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
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (macOS)
* [PDO][pdo] Extension as well as the relevant RDBMS specific extension (i.e. [MySQL][mysql], [PostgreSql][postgresql] etc.)
* [OpenSSL][openssl] Extension
* [Mbstring][mbstring] Extension
* [Memcached][memcached] or other relevant cache adapters depending on your usage of cache

> **NOTE**: Installing these packages will vary based on your operating system as well as the package manager you use (if any). Please consult the relevant documentation on how to install these extensions. 
> 
> {: .alert .alert-info }

For the `libpcre3-dev` package you can use the following commands:

#### PCRE
##### Debian
```bash
sudo apt-get install libpcre3-dev
```
and then try and install Phalcon again

##### CentOS
```bash
sudo yum install pcre-devel
```

##### Mac/Osx で Brew を使用する場合
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

## インストール プラットフォーム
Since Phalcon is compiled as a PHP extension, its installation is somewhat different from any other traditional PHP framework. Phalcon needs to be installed and loaded as a module on your web server.

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

Installation of the repo:
```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

and Phalcon:

```php
sudo apt-get install php-phalcon5
```

#### Linux RPM: **Remi**

[Remi Collet][remi] maintains an excellent repository for RPM based installations. You can find instructions on how to enable it for your distribution [here][remi-config].

Installing Phalcon after that is as easy as:

```bash
yum install php74-php-phalcon5
```

Additional versions are available both architecture specific (x86/x64) and PHP version specific


### FreeBSD
Binary package (pkg) and compile from source (ports) are available for FreeBSD. To install it you will need to issue the following commands:

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
Brew includes binary packages, so you don't need to compile Phalcon yourself. If you want to compile the extension yourself you need the following dependencies installed:

#### コンパイル要件
* PHP 7.x (or 8.x) development resources
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
sudo port install php74-phalcon
sudo port install php80-phalcon
```

Edit your php.ini file and then append at the end:

```ini
extension=php_phalcon.so
```

Restart your webserver.

### PHPBrew (macOS/Linux)

PHPBrew is an excellent way to manage multiple versions of PHP and PHP extensions on your system(s). Installation instructions for PHPBrew can be found [here][install-phpbrew]

If you're using PHPBrew, you can install Phalcon using the following:

```bash
sudo phpbrew ext install phalcon
```

### Windows
To use Phalcon on Windows, you will need to install the phalcon.dll. We have compiled several DLLs depending on the target platform. The DLLs can be found in our [download][download] page.

Identify your PHP installation as well as architecture. If you download the wrong DLL, Phalcon will not work. `phpinfo()` contains this information. In the example below, we will need the NTS version of the DLL:

![phpinfo](/assets/images/content/phpinfo-api.png)

The available DLLs are:

| アーキテクチャー | バージョン | Type           |
|:--------:|:-----:| -------------- |
|   x64    |  7.x  | スレッドセーフ        |
|   x64    |  7.x  | 非スレッドセーフ (NTS) |
|   x86    |  7.x  | スレッドセーフ        |
|   x86    |  7.x  | 非スレッドセーフ (NTS) |
|   x64    |  8.x  | スレッドセーフ        |
|   x64    |  8.x  | 非スレッドセーフ (NTS) |
|   x86    |  8.x  | スレッドセーフ        |
|   x86    |  8.x  | 非スレッドセーフ (NTS) |

Edit your php.ini file and then append at the end:

```ini
extension=php_phalcon.dll
```

Restart your webserver.

### Compile From Sources
Compiling from source is similar to most environments (Linux/macOS).

#### Requirements
* PHP 7.4.x+ development resources
* GCCコンパイラ (Linux/Solaris/FreeBSD) または Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

#### コンパイル
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

Phalconのコンパイル

```bash
cd cphalcon/
git checkout tags/v5.0.0 ./
zephir fullclean
zephir build
```

モジュールをチェック

```bash
php -m | grep phalcon
```

You will now need enable Phalcon. Create a file called `phalcon.ini` with `extension=phalcon.so` as its content. The file should be present in:

- Suse: `/etc/php7/conf.d/phalcon.ini`
- CentOS/RedHat/Fedora: `/etc/php.d/phalcon.ini`
- Ubuntu/Debian with Apache2: `/etc/php7/apache2/conf.d/30-phalcon.ini` with this Content:
- Ubuntu/Debian with Php7-FPM: `/etc/php7/fpm/conf.d/30-phalcon.ini`
- Ubuntu/Debian with Php7-CLI: `/etc/php7/cli/conf.d/30-phalcon.ini`

For PHP 8.+ the above paths might differ slightly.

The instructions above will compile **and** install the module on your system. You can also compile the extension and then add it manually in your `ini` file:

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

If you use the above method you will need to add the `extension=phalcon.so` in your `php.ini` both for CLI and web server.

> **NOTE**: If you are installing Phalcon with PHP 8.+, the paths will vary slightly. 
> 
> {: .alert .alert-warning }

#### チューニングビルド（最適化オプションの指定されたコンパイル）

By default, we compile to be as compatible as possible with all processors (`gcc -mtune=native -O2 -fomit-frame-pointer`). If you would like instruct the compiler to generate optimized machine code that matches the processor where it is currently running on you can set your own compile flags by exporting CFLAGS before the build. For example

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
