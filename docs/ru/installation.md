<div class='article-menu'>
  <ul>
    <li>
      <a href="#requirements">Требования</a> <ul>
        <li>
          <a href="#requirements-hardware">Аппаратное обеспечение</a>
        </li>
        <li>
          <a href="#requirements-software">Программное обеспечение</a>
        </li>
      </ul>
    </li>
    
    <li>
      <a href="#installation">Установка</a> <ul>
        <li>
          <a href="#installation-linux">Linux</a> <ul>
            <li>
              <a href="#installation-linux-debian">DEB дистрибутивы (Debian, Ubuntu, и т.д.)</a> <ul>
                <li>
                  <a href="#installation-linux-debian-repository">Настройка репозитория</a> <ul>
                    <li>
                      <a href="#installation-linux-debian-repository-stable">Стабильные релизы</a>
                    </li>
                    <li>
                      <a href="#installation-linux-debian-repository-nightly">Ночные релизы</a>
                    </li>
                  </ul>
                </li>
                
                <li>
                  <a href="#installation-linux-debian-phalcon">Установка Phalcon</a> <ul>
                    <li>
                      <a href="#installation-linux-debian-phalcon-php5">PHP 5.7</a>
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
              <a href="#installation-linux-rpm">RPM дистрибутивы (CentOS, Fedora, и т.д.)</a> <ul>
                <li>
                  <a href="#installation-linux-rpm-repository">Настройка репозитория</a> <ul>
                    <li>
                      <a href="#installation-linux-rpm-repository-stable">Стабильные релизы</a>
                    </li>
                    <li>
                      <a href="#installation-linux-rpm-repository-nightly">Ночные релизы</a>
                    </li>
                  </ul>
                </li>
                
                <li>
                  <a href="#installation-linux-rpm-phalcon">Phalcon installation</a> <ul>
                    <li>
                      <a href="#installation-linux-rpm-phalcon-php5">PHP 5.7</a>
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
          <a href="#installation-macos">macOS</a> <ul>
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
          <a href="#installation-sources">Компиляция из исходников</a>
        </li>
        <li>
          <a href="#installation-sources-advanced">Расширенная компиляция</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='requirements'></a>

# Требования

Phalcon требует PHP для запуска. Its loosely coupled design allows developers to install Phalcon and use its functionality without additional extensions. Certain components have dependencies to other extensions. For instance using database connectivity will require the `php_pdo` extension. If your RDBMS is MySql/MariaDb or Aurora databases you will need the `php_mysqlnd` extension also. Similarly, using a PostgreSql database with Phalcon requires the `php_pgsql` extension.

<a name='requirements-hardware'></a>

## Аппаратное обеспечение

Phalcon is designed to use as little resources as possible, while offering high performance. Although we have tested Phalcon in various low end environments, (such as 0.25GB RAM, 0.5 CPU), the hardware that you will choose will depend on the your application needs.

Our website and blog (as well as other sites) are hosted on an Amazon VM with 512MB RAM and 1 vCPU.

<a name='requirements-software'></a>

## Программное обеспечение

- PHP > = 5.5

##### You should always try and use the latest version of Phalcon and PHP as both address bugs, security enhancements as well as performance. PHP 5.5 will be deprecated in the near future, and Phalcon 4 will only support PHP 7 {.alert.alert-danger}

### Optional depending on the needs of your application

- [PDO](http://php.net/manual/en/book.pdo.php) Extension as well as the relevant RDBMS specific extension (i.e. [MySQL](http://php.net/manual/en/ref.pdo-mysql.php), [PostgreSql](http://php.net/manual/en/ref.pdo-pgsql.php) etc.)
- [OpenSSL](http://php.net/manual/en/book.openssl.php) Extension
- [Mbstring](http://php.net/manual/en/book.mbstring.php) Extension
- [Memcache](http://php.net/manual/en/book.memcache.php), [Memcached](http://php.net/manual/en/book.memcached.php) or other relevant cache adapters depending on your usage of cache.

<a name='installation'></a>

# Установка

Since Phalcon is compiled as a PHP extension, its installation is somewhat different than any other traditional PHP framework. Phalcon needs to be installed and loaded as a module on your web server.

<a name='installation-linux'></a>

## Linux

Перед установкой Phalcon в Linux, необходимо добавить репозиторий.

<a name='installation-linux-debian'></a>

### DEB дистрибутивы (Debian, Ubuntu, и т.д.)

<a name='installation-linux-debian-repository'></a>

#### Настройка репозитория

Добавьте репозиторий для вашего дистрибутива:

<a name='installation-linux-debian-repository-stable'></a>

##### Стабильные релизы

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

или

<a name='installation-linux-debian-repository-nightly'></a>

##### Ночные релизы

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

##### This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds. {.alert.alert-warning}

<a name='installation-linux-debian-phalcon'></a>

#### Установка Phalcon

To install Phalcon you need to issue the following commands in your terminal:

<a name='requirements-hardware'></a>

0##### PHP 5.7

```bash
sudo apt-get update
sudo apt-get install php5-phalcon
```

<a name='requirements-hardware'></a>

1##### PHP 7

```bash
sudo apt-get update
sudo apt-get install php7.0-phalcon
```

<a name='requirements-hardware'></a>

2#### Additional PPAs

#### Ondřej Surý

If you do not wish to use our packagecloud.io repository, you can always use the one offered by [Ondřej Surý](https://launchpad.net/~ondrej/+archive/ubuntu/php/).

Добавление репозитория:

```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

установка Phalcon:

```php
sudo apt-get install php-phalcon
```

https://launchpad.net/~ondrej/+archive/ubuntu/php/

<a name='requirements-hardware'></a>

3### RPM дистрибутивы (CentOS, Fedora, и т.д.)

<a name='requirements-hardware'></a>

4#### Настройка репозитория

Добавьте репозиторий для вашего дистрибутива:

<a name='requirements-hardware'></a>

5##### Стабильные релизы

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

или

<a name='requirements-hardware'></a>

6##### Ночные релизы

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

##### This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds. {.alert.alert-warning}

<a name='requirements-hardware'></a>

7#### Phalcon installation

To install Phalcon you need to issue the following commands in your terminal:

<a name='requirements-hardware'></a>

8##### PHP 5.7

```bash
sudo yum update
sudo yum install php56u-phalcon
```

<a name='requirements-hardware'></a>

9##### PHP 7

```bash
sudo yum update
sudo yum install php70u-phalcon
```

<a name='requirements-software'></a>

0#### Additional RPMs

##### Remi

Remi maintains an excellent repository for RPM based installations. You can find instructions on how to enable it for your distribution [here](https://blog.remirepo.net/pages/Config-en)

Installing Phalcon after that is as easy as:

```bash
yum install php56-php-phalcon3
```

Additional versions are available both architecture specific (x86/x64) as well as PHP specific (5.5, 5.6, 7.x)

<a name='requirements-software'></a>

1## FreeBSD

A port is available for FreeBSD. To install it you will need to issue the following commands:

### `pkg_add`

```bash
pkg_add -r phalcon
```

### Сборка из исходников

```bash
export CFLAGS="-O2 --fvisibility=hidden"

cd /usr/ports/www/phalcon

make install clean
```

<a name='requirements-software'></a>

2## Gentoo

An overlay for installing Phalcon can be found here <https://github.com/smoke/phalcon-gentoo-overlay>

<a name='requirements-software'></a>

3## macOS

On a Mac OS X system you can compile and install the extension with `brew`, `macports` or the source code:

### Требования

- PHP >= 5.5 development resources
- XCode

<a name='requirements-software'></a>

4### Brew

```bash
brew tap homebrew/homebrew-php
brew install php55-phalcon
brew install php56-phalcon
```

<a name='requirements-software'></a>

5### MacPorts

```bash
sudo port install php55-phalcon
sudo port install php56-phalcon
```

Edit your php.ini file and then append at the end:

```ini
extension=php_phalcon.dll
```

Перезагрузите веб-сервер.

<a name='requirements-software'></a>

6## Windows

To use Phalcon on Windows, you will need to install the phalcon.dll. We have compiled several DLLs depending on the target platform. The DLLs can be found in our \[download\]\[download-dll\] page.

To use phalcon on Windows you will need to download a DLL library. Identify your PHP installation as well as architecture. If you download the wrong DLL, Phalcon will not work. `phpinfo()` contains this information. In the example below, we will need the NTS version of the DLL:

![phpinfo](/images/content/phpinfo-api.png)

The available DLLs are:

| Архитектура | Версия | Тип                                  |
|:-----------:|:------:| ------------------------------------ |
|     x64     |  7.x   | Потокобезопасный                     |
|     x64     |  7.x   | Не являющийся потокобезопасным (NTS) |
|     x86     |  7.x   | Потокобезопасный                     |
|     x86     |  7.x   | Не являющийся потокобезопасным (NTS) |
|     x64     |  5.6   | Потокобезопасный                     |
|     x64     |  5.6   | Не являющийся потокобезопасным (NTS) |
|     x86     |  5.6   | Потокобезопасный                     |
|     x86     |  5.6   | Не являющийся потокобезопасным (NTS) |

Edit your php.ini file and then append at the end:

```ini
extension=php_phalcon.dll
```

Перезагрузите веб-сервер.

<a name='requirements-software'></a>

7## Компиляция из исходников

Compiling from source is similar to most environments (Linux/Mac).

### Requirements

- PHP 5.5.x/5.6.x/7.0.x development resources
- GCC compiler (Linux/Solaris/FreeBSD) or Xcode (MacOS)
- re2c >= 0.13
- libpcre-dev

You can install these packages in your system with the relevant package manager. Instructions for popular linux distributions are below:

#### Ubuntu

```bash
sudo apt-get install php5-dev libpcre3-dev gcc make
```

#### Suse:

```bash
sudo zypper install php5-devel gcc make
```

#### CentOS / Fedora / RHEL

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

<a name='requirements-software'></a>

8## Расширенная компиляция

Phalcon automatically detects your architecture, however, you can force the compilation for a specific architecture:

```bash
cd cphalcon/build

# One of the following:
sudo ./install 32bits
sudo ./install 64bits
sudo ./install safe
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

export CFLAGS="-O2 --fvisibility=hidden"

# Example: /opt/php-5.6.15
export CUSTOM_PHP_INSTALLATION_PATH=/your/php/installation/path

# Example: /opt/php-5.6.15/bin/phpize --clean
$CUSTOM_PHP_INSTALLATION_PATH/bin/phpize --clean

# Example: /opt/php-5.6.15/bin/phpize
$CUSTOM_PHP_INSTALLATION_PATH/bin/phpize

# Example: ./configure --with-php-config=/opt/php-5.6.15/bin/php-config
./configure --with-php-config=$CUSTOM_PHP_INSTALLATION_PATH/bin/php-config --enable-phalcon

make && sudo make install
```

You will now need to add `extension=phalcon.so` to your PHP ini and restart your web server, so as to load the extension.

<a name='requirements-software'></a>

9You can create a small script in your web server root that has the following in it:

```php
<?php

phpinfo();
```

and load it on your web browser. There should be a section for Phalcon. If there is not, make sure that your extension has been compiled properly, that you made the necessary changes to your `php.ini` and also that you have restarted your web server.

Также вы можете проверить вашу установку из командной строки:

```bash
php -r 'print_r(get_loaded_extensions())'
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

##### Note that in some Linux based systems, you might need to change two `php.ini` files, one for your web server (Apache/nginX), and one for the CLI. If Phalcon is loaded only for say the web server, you will need to locate the CLI `php.ini` and make the necessary additions for the module to be loaded. {.alert.alert-danger}

#### Dev environments

- Vagrant
- Docker
- Homestead Improved

#### Примеры приложений

Hello World Configuration Files

#### Конфигурация веб-сервера

Apache .htaccess VirtualHost/Directory

nginX

[download-dll](https://phalconphp.com/en/download/windows)