<div class='article-menu'>
  <ul>
    <li>
      <a href="#requirements">Requirements</a> <ul>
        <li>
          <a href="#requirements-hardware">Hardware</a>
        </li>
        <li>
          <a href="#requirements-software">Software</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="#installation">Installation</a> <ul>
        <li>
          <a href="#installation-linux">Linux</a> <ul>
            <li>
              <a href="#installation-linux-debian">DEB based distributions (Debian, Ubuntu, etc.)</a> <ul>
                <li>
                  <a href="#installation-linux-debian-repository">Repository installation</a> <ul>
                    <li>
                      <a href="#installation-linux-debian-repository-stable">Stable releases</a>
                    </li>
                    <li>
                      <a href="#installation-linux-debian-repository-nightly">Nightly releases</a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="#installation-linux-debian-phalcon">Phalcon installation</a> <ul>
                    <li>
                      <a href="#installation-linux-debian-phalcon-php5">PHP 5.x</a>
                    </li>
                    <li>
                      <a href="#installation-linux-debian-phalcon-php7">PHP 7</a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="#installation-linux-debian-other-ppa">Additional PPAs</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#installation-linux-rpm">RPM based distributions (CentOS, Fedora, etc.)</a> <ul>
                <li>
                  <a href="#installation-linux-rpm-repository">Repository installation</a> <ul>
                    <li>
                      <a href="#installation-linux-rpm-repository-stable">Stable releases</a>
                    </li>
                    <li>
                      <a href="#installation-linux-rpm-repository-nightly">Nightly releases</a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="#installation-linux-rpm-phalcon">Phalcon installation</a> <ul>
                    <li>
                      <a href="#installation-linux-rpm-phalcon-php5">PHP 5.x</a>
                    </li>
                    <li>
                      <a href="#installation-linux-rpm-phalcon-php7">PHP 7</a>
                    </li>
                  </ul>
                </li>
                <li>
                  <a href="installation-linux-rpm-other-rpm">Additional RPMs</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#installation-freebsd">FreeBSD</a>
            </li>
            <li>
              <a href="#installation-linux-gentoo">Gentoo</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#installation-macos">MacOS</a> <ul>
            <li>
              <a href="#installation-macos-brew">Brew</a>
            </li>
            <li>
              <a href="#installation-macos-macports">MacPorts</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#installation-windows">Windows</a>
        </li>
        <li>
          <a href="#installation-sources">Compile from sources</a>
        </li>
        <li>
          <a href="#installation-sources-advanced">Advanced Compilation</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='requirements'></a>

# Requirements

Phalcon needs PHP to run. Its loosely coupled design allows developers to install Phalcon and use its functionality without additional extensions. Certain components have dependencies to other extensions. For instance using database connectivity will require the `php_pdo` extension. If your RDBMS is MySql/MariaDb or Aurora databases you will need the `php_mysqlnd` extension also. Similarly, using a PostgreSql database with Phalcon requires the `php_pgsql` extension.

<a name='requirements-hardware'></a>

## Hardware

Phalcon is designed to use as little resources as possible, while offering high performance. Although we have tested Phalcon in various low end environments, (such as 0.25GB RAM, 0.5 CPU), the hardware that you will choose will depend on the your application needs.

Our website and blog (as well as other sites) are hosted on an Amazon VM with 512MB RAM and 1 vCPU.

<a name='requirements-software'></a>

## Software

- PHP >= 5.5

<h5 class='alert alert-danger'>Dapat palaging subukan at gamitin ang pinakabagong bersyon ng Phalcon at Php bilang parehong mga address ng bug, pagpapa-unlad ng seguridad lalo na sa pagganap. Ang PHP 5.5 ay bababa sa malapit na hinaharap, at ang Phalcon 4 ay susuporta lamang sa PHP 7 </h5>

Phalcon need the following extensions to run (minimal):

- `curl`
- `gettext`
- `gd2` (para sa klase ng imahe)
- `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (Mac OS)
- `json`
- `mbstring`
- `pdo_*`
- `fileinfo`
- `openssl`

### Optional depending on the needs of your application

- [PDO](http://php.net/manual/en/book.pdo.php) Extension as well as the relevant RDBMS specific extension (i.e. [MySQL](http://php.net/manual/en/ref.pdo-mysql.php), [PostgreSql](http://php.net/manual/en/ref.pdo-pgsql.php) etc.)
- [OpenSSL](http://php.net/manual/en/book.openssl.php) Extension
- [Mbstring](http://php.net/manual/en/book.mbstring.php) Extension
- [Memcache](http://php.net/manual/en/book.memcache.php), [Memcached](http://php.net/manual/en/book.memcached.php) o mga kaugnay na mga adaptor ng cache depende sa iyong paggamit na cache.

<a name='installation'></a>

# Installation

Since Phalcon is compiled as a PHP extension, its installation is somewhat different than any other traditional PHP framework. Phalcon needs to be installed and loaded as a module on your web server.

<a name='installation-linux'></a>

## Linux

To install Phalcon on linux, you will need to add our repository in your distribution and then install it.

<a name='installation-linux-debian'></a>

### DEB based distributions (Debian, Ubuntu, etc.)

<a name='installation-linux-debian-repository'></a>

#### Repository installation

Add the repository to your distribution:

<a name='installation-linux-debian-repository-stable'></a>

##### Stable releases

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

or

<a name='installation-linux-debian-repository-nightly'></a>

##### Nightly releases

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

<h5 class='alert alert-warning'>This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds. </h5>

<a name='installation-linux-debian-phalcon'></a>

#### Phalcon installation

To install Phalcon you need to issue the following commands in your terminal:

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

#### Additional PPAs

#### Ondřej Surý

If you do not wish to use our packagecloud.io repository, you can always use the one offered by [Ondřej Surý](https://launchpad.net/~ondrej/+archive/ubuntu/php/).

Installation of the repo:

```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

and Phalcon:

```php
sudo apt-get install php-phalcon
```

https://launchpad.net/~ondrej/+archive/ubuntu/php/

<a name='installation-linux-rpm'></a>

### RPM based distributions (CentOS, Fedora, etc.)

<a name='installation-linux-rpm-repository'></a>

#### Repository installation

Add the repository to your distribution:

<a name='installation-linux-rpm-repository-stable'></a>

##### Stable releases

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

or

<a name='installation-linux-rpm-repository-nightly'></a>

##### Nightly releases

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

<h5 class='alert alert-warning'>This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds. </h5>

<a name='installation-linux-rpm-phalcon'></a>

#### Phalcon installation

To install Phalcon you need to issue the following commands in your terminal:

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

#### Additional RPMs

##### Remi

Remi maintains an excellent repository for RPM based installations. You can find instructions on how to enable it for your distribution [here](https://blog.remirepo.net/pages/Config-en)

Installing Phalcon after that is as easy as:

```bash
yum install php56-php-phalcon3
```

Additional versions are available both architecture specific (x86/x64) as well as PHP specific (5.5, 5.6, 7.x)

<a name='installation-freebsd'></a>

## FreeBSD

A port is available for FreeBSD. To install it you will need to issue the following commands:

### `pkg_add`

```bash
pkg_add -r phalcon
```

### Source

```bash
export CFLAGS="-O2 --fvisibility=hidden"

cd /usr/ports/www/phalcon

make install clean
```

<a name='installation-gentoo'></a>

## Gentoo

An overlay for installing Phalcon can be found here <https://github.com/smoke/phalcon-gentoo-overlay>

<a name='installation-macos'></a>

## Mac OS X

On a Mac OS X system you can compile and install the extension with `brew`, `macports` or the source code:

### Requirements

- PHP 5.5.x/5.6.x/7.0.x/7.1.x development resources
- XCode

<a name='installation-macos-brew'></a>

### Brew

```bash
brew tap homebrew/homebrew-php
brew install php55-phalcon
brew install php56-phalcon
brew install php70-phalcon
brew install php71-phalcon
```

<a name='installation-macos-macports'></a>

### MacPorts

```bash
sudo port install php55-phalcon
sudo port install php56-phalcon
```

Edit your php.ini file and then append at the end:

```ini
extension=php_phalcon.so
```

Restart your webserver.

<a name='installation-windows'></a>

## Windows

To use Phalcon on Windows, you will need to install the phalcon.dll. We have compiled several DLLs depending on the target platform. The DLLs can be found in our [download](https://phalconphp.com/en/download/windows) page.

Identify your PHP installation as well as architecture. If you download the wrong DLL, Phalcon will not work. `phpinfo()` contains this information. In the example below, we will need the NTS version of the DLL:

![phpinfo](/images/content/phpinfo-api.png)

The available DLLs are:

| Architecture | Version | Type                  |
|:------------:|:-------:| --------------------- |
|     x64      |   7.x   | Thread safe           |
|     x64      |   7.x   | Non Thread safe (NTS) |
|     x86      |   7.x   | Thread safe           |
|     x86      |   7.x   | Non Thread safe (NTS) |
|     x64      |   5.6   | Thread safe           |
|     x64      |   5.6   | Non Thread safe (NTS) |
|     x86      |   5.6   | Thread safe           |
|     x86      |   5.6   | Non Thread safe (NTS) |

Edit your php.ini file and then append at the end:

```ini
extension=php_phalcon.dll
```

Restart your webserver.

<a name='installation-sources'></a>

## Compile from Sources

Compiling from source is similar to most environments (Linux/Mac).

### Requirements

- PHP 5.5.x/5.6.x/7.0.x/7.1.x development resources
- GCC compiler (Linux/Solaris/FreeBSD) or Xcode (MacOS)
- re2c >= 0.13
- libpcre-dev

You can install these packages in your system with the relevant package manager. Instructions for popular linux distributions are below:

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

### Compile Phalcon

We first need to clone Phalcon from the Github repository

```bash
git clone https://github.com/phalcon/cphalcon
```

and now build the extension

```bash
cd cphalcon/build
sudo ./install
```

You will now need to add `extension=phalcon.so` to your PHP ini and restart your web server, so as to load the extension.

```ini
# Suse: Add a file called phalcon.ini in /etc/php5/conf.d/ with this content:
extension=phalcon.so

# CentOS/RedHat/Fedora: Add a file called phalcon.ini in /etc/php.d/ with this content:
extension=phalcon.so

# Ubuntu/Debian with apache2: Add a file called 30-phalcon.ini in /etc/php5/apache2/conf.d/ with this content:
extension=phalcon.so

# Ubuntu/Debian with php5-fpm: Add a file called 30-phalcon.ini in /etc/php5/fpm/conf.d/ with this content:
extension=phalcon.so

# Ubuntu/Debian with php5-cli: Add a file called 30-phalcon.ini in /etc/php5/cli/conf.d/ with this content:
extension=phalcon.so
```

<a name='installation-sources-advanced'></a>

## Advanced Compilation

Phalcon automatically detects your architecture, however, you can force the compilation for a specific architecture:

```bash
cd cphalcon/build

# One of the following:
sudo ./install --arch 32bits
sudo ./install --arch 64bits
sudo ./install --arch safe
```

If the automatic installer fails you can build the extension manually

```bash
git clone https://github.com/phalcon/cphalcon
# cd cphalcon/build/php5/32bits
cd cphalcon/build/php5/64bits

# NOTE: for PHP 7 you have to use
# cd cphalcon/build/php7/32bits
# or
# cd cphalcon/build/php7/64bits

make clean
phpize --clean

export CFLAGS="-O2 --fvisibility=hidden"
./configure --enable-phalcon

make
make install
```

If you have specific php versions running

```bash
git clone https://github.com/phalcon/cphalcon
# cd cphalcon/build/php5/32bits
cd cphalcon/build/php5/64bits

# NOTE: for PHP 7 you have to use
# cd cphalcon/build/php7/32bits
# or
# cd cphalcon/build/php7/64bits

make clean
/opt/php-5.6.15/bin/phpize --clean

export CFLAGS="-O2 --fvisibility=hidden"
./configure --with-php-config=/opt/php-5.6.15/bin/php-config --enable-phalcon

make
make install
```

You will now need to add `extension=phalcon.so` to your PHP ini and restart your web server, so as to load the extension.

<a name='installation-testing'></a>
You can create a small script in your web server root that has the following in it:

```php
<?php

phpinfo();
```

and load it on your web browser. There should be a section for Phalcon. If there is not, make sure that your extension has been compiled properly, that you made the necessary changes to your `php.ini` and also that you have restarted your web server.

You can also check your installation from the command line:

```bash
php -r 'print_r(get_loaded_extensions());'
```

This will output something similar to this:

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

You can also see the modules installed using the CLI:

```bash
php -m
```

<h5 class='alert alert-danger'>Note that in some Linux based systems, you might need to change two <code>php.ini</code> files, one for your web server (Apache/Nginx), and one for the CLI. If Phalcon is loaded only for say the web server, you will need to locate the CLI <code>php.ini</code> and make the necessary additions for the module to be loaded. </h5>
