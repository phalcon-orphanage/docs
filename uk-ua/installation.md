---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Встановлення'
keywords: 'встановлення, встановлення Phalcon'
---

# Встановлення

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Вимоги

### PHP 7.2

Phalcon v4 підтримує тільки PHP 7.2 або вище. PHP 7.1 випущено понад 2 роки тому і [активна підтримка](https://secure.php.net/supported-versions.php) цієї версії уже припинена, тому ми вирішили працювати лише з версіями PHP, що активно підтримуються.

### PSR

Phalcon потребує PSR-розширення. Його можна завантажити і скомпілювати з [цього](https://github.com/jbboehr/php-psr) GitHub репозиторію. Інструкції з встановлення викладені у файлі `README` цього репозиторію. Після компіляції цього розширення у вашій системі його слід додати до `php.ini`. Ви маєте додати цей рядок:

```ini
extension=psr.so
```

перед

```ini
extension=phalcon.so
```

Деякі дистрибутиви додають числовий префікс до `ini` файлів для управління черговістю завантаження розширень. Якщо це має місце у вашій системі, вкажіть вище число для Phalcon (наприклад, `50-phalcon.ini`).

Використання Pecl передбачає автоматичне встановлення цього розширення.

### PDO

Оскільки Phalcon слабко зв'язаний, використання його функціоналу не потребує додаткових розширень. Однак деякі компоненти потребують додаткових розширень для своєї роботи. Якщо є необхідність у використанні доступу до баз даних у вашому проєкті, то необхідно встановити `php_pdo` розширення. Якщо ваша реляційна база даних - MySQL/MariaDB або Aurora, вам знадобиться також розширення `php_mysqlnd`. Подібним чином, для використання PostgreSql з Phalcon вам знадобиться розширення `php_pgsql`.

### Апаратне забезпечення

Phalcon спроектований таким чином, щоб для забезпечення максимальної продуктивності споживати мінімально можливу кількість ресурсів. Хоча ми тестували Phalcon в низькоресурсних середовищах (таких як 0.25GB RAM, 0.5 CPU), вибір обладнання залежатиме від потреб вашого проєкту.

Ми розміщуємо наш веб-сайт і блог впродовж останніх кількох років на віртуальній машині Amazon з 512 Мб оперативної пам'яті і 1 віртуальним процесором.

### Програмне забезпечення

> **ПРИМІТКА**: Завжди намагайтесь тестувати і використовувати у роботі лише останні версії Phalcon та PHP, оскільки вони передбачають виправлення відомих помилок, покращення безпеки та продуктивності.
{: .alert .alert-danger }

Окрім PHP 7.2 або новішої, в залежності від потреб вашого застосунку та компонентів, які вам потрібні, може виникнути потреба в установленні таких розширень:

* [curl](https://secure.php.net/manual/en/book.curl.php)
* [fileinfo](https://secure.php.net/manual/en/book.fileinfo.php)
* [gettext](https://secure.php.net/manual/en/book.gettext.php)
* [gd2](https://secure.php.net/manual/en/book.image.php) (для використання класу [Phalcon\Image\Adapter\Gd](api/Phalcon_Image_Adapter_Gd))
* [imagick](https://secure.php.net/manual/en/book.imagick.php) (для використання класу[Phalcon\Image\Adapter\Imagick](api/Phalcon_Image_Adapter_Imagick))
* [json](https://secure.php.net/manual/en/book.json.php)
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (macOS)
* [Розширення PDO](https://php.net/manual/en/book.pdo.php) або інше розширення, що відповідає вашій RDBMS (наприклад [MySQL](https://php.net/manual/en/ref.pdo-mysql.php), [PostgreSql](https://php.net/manual/en/ref.pdo-pgsql.php) і т. д.)
* [Розширення OpenSSL](https://php.net/manual/en/book.openssl.php)
* [Розширення Mbstring](https://php.net/manual/en/book.mbstring.php)
* [Memcached](https://php.net/manual/en/book.memcached.php) або інші відповідні адаптери в залежності від вашої політики використання кешу

> **ПРИМІТКА**: Установка цих пакунків може відрізнятись, залежно від операційної системи вашого сервера чи менеджера пакунків, яким ви користуєтесь. Будь ласка, користуйтесь відповідною документацією про те, як встановити ці розширення.
{: .alert .alert-info }

Для пакету `libpcre3-dev` ви можете використовувати наступні команди:

### Pecl

Метод установки Pecl доступний для Windows, Linux та MacOS. У Windows будуть використані попередньо компільовані файли dll. У Linux та MacOS Phalcon буде компілюватися локально, тому ефективніше буде використовувати методи встановлення на цих платформах. Для встановлення за допомогою Pecl переконайтеся, що у вас встановлено [pecl/pear](https://pear.php.net/manual/en/installation.getting.php).

    pecl channel-update pecl.php.net
    pecl install phalcon
    

#### Debian

```bash
sudo apt-get install libpcre3-dev
```

а потім спробуйте встановити Phalcon знову

#### CentOS

```bash
sudo yum install pcre-devel
```

#### Mac/Osx використовує Brew

```bash
brew install pcre
```

Без `brew`, вам необхідно перейти до сайту [PCRE](https://www.pcre.org/) та завантажити останню версію pcre:

```bash
tar -xzvf pcre-8.42.tar.gz
cd pcre-8.42
./configure --prefix=/usr/local/pcre-8.42
make
make install
ln -s /usr/local/pcre-8.42 /usr/sbin/pcre
ln -s /usr/local/pcre-8.42/include/pcre.h /usr/include/pcre.h
```

Для Maverick

```bash
brew install pcre
```

якщо це видає помилку, ви можете використовувати

```bash
sudo ln -s /opt/local/include/pcre.h /usr/include/
sudo pecl install apc 
```

## Установка платформи

Оскільки Phalcon компілюється як PHP-розширення, його встановлення дещо відрізняється від будь-яких інших традиційний PHP-фреймворків. Phalcon повинен бути встановлений та завантажений як модуль на вашому веб-сервері.

### Linux

Щоб встановити Phalcon на Linux, Вам необхідно додати наш репозиторій у свій дистрибутив і тоді встановити його.

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

If you do not wish to use our repository at [packagecloud.io](https://packagecloud.io/phalcon), you can always use the one offered by [Ondřej Surý](https://launchpad.net/~ondrej/+archive/ubuntu/php/).

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

PHPBrew is an excellent way to manage multiple versions of PHP and PHP extensions on your system(s). Installation instructions for PHPBrew can be found [here](https://github.com/phpbrew/phpbrew/wiki/Quick-Start)

If you're using PHPBrew, you can install Phalcon using the following:

```bash
sudo phpbrew ext install phalcon
```

You can install the PSR dependency via phpbrew as well if needed:

```bash
sudo phpbrew ext install psr
```

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

### Compile From Sources

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

By default we compile to be as compatible as possible with all processors (`gcc -mtune=native -O2 -fomit-frame-pointer`). If you would like instruct the compiler to generate optimized machine code that matches the processor where it is currently running on you can set your own compile flags by exporting CFLAGS before the build. For example

    export CFLAGS="-march=native -O2 -fomit-frame-pointer"
    zephir build
    

This will generate the best possible code for that chipset but will likely break the compiled object on older chipsets.

### Shared Hosting

Running your application on shared hosting might restrict you in installing Phalcon, especially if you do not have root access. Some web hosting control panels luckily have Phalcon support.

#### cPanel & WHM

cPanel & WHM support Phalcon using Easy Apache 4 (EA4). You can install Phalcon by enabling the [module](https://github.com/CpanelInc/scl-phalcon) in Easy Apache 4 (EA4).

#### Plesk

The plesk control panel doesn't have Phalcon support but you can find installation instructions on the Plesk [website](https://support.plesk.com/hc/en-us/articles/115002186489-How-to-install-Phalcon-framework-for-a-PHP-supplied-by-Plesk-)