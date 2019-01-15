* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='requirements'></a>

# Требования

Phalcon требует PHP для запуска. Его слабо связанный дизайн позволяет разработчикам один раз установив Phalcon, использовать его возможности везде, без дополнительных расширений. Однако некоторые его компоненты зависят от других расширений. Например, использование подключений к базам данных, требует расширения `php_pdo`. Если ваша СУБД MySql/MariaDb или Aurora, вам так же понадобится расширение `php_mysqlnd`. Аналогично, использование базы данных PostgreSql с Phalcon, требует расширения `php_pgsql`.

<a name='requirements-hardware'></a>

## Аппаратное обеспечение

Phalcon разработан таким образом, чтобы потреблять как можно меньше ресурсов, взамен предлагая высокую производительность. Хотя мы и тестировали Phalcon на маломощных машинах (например с 256 MB RAM и процессором 500 MHz), оборудование, которое вы будете выбирать, будет зависеть от потребностей приложения.

Наш веб-сайт и блог (а также другие сайты) работают на Amazon VM с 512 MB RAM и 1 vCPU.

<a name='requirements-software'></a>

## Программное обеспечение

* PHP > = 5.5

<h5 class='alert alert-danger'>You should always try and use the latest version of Phalcon and PHP as both address bugs, security enhancements as well as performance. PHP 5.5 will be deprecated in the near future, and Phalcon 4 will only support PHP 7 </h5>

Phalcon нуждается в следующем минимальном наборе расширений:

* `curl`
* `gettext`
* `gd2` (для использования класса `Phalcon\Image\Adapter\Gd`)
* `libpcre3-dev` (Debian/Ubuntu), `pcre-devel` (CentOS), `pcre` (macOS)
* `json`
* `mbstring`
* `pdo_*`
* `fileinfo`
* `openssl`

<a name='requirements-software-optional'></a>

### Дополнительно, в зависимости от потребностей вашего приложения

* [PDO](https://php.net/manual/en/book.pdo.php) Extension as well as the relevant RDBMS specific extension (i.e. [MySQL](https://php.net/manual/en/ref.pdo-mysql.php), [PostgreSql](https://php.net/manual/en/ref.pdo-pgsql.php) etc.)
* [OpenSSL](https://php.net/manual/en/book.openssl.php) Extension
* [Mbstring](https://php.net/manual/en/book.mbstring.php) Extension
* [Memcache](https://php.net/manual/en/book.memcache.php), [Memcached](https://php.net/manual/en/book.memcached.php) or other relevant cache adapters depending on your usage of cache

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

<h5 class='alert alert-warning'>This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds. </h5>

<a name='installation-linux-debian-phalcon'></a>

#### Установка Phalcon

Чтобы установить Phalcon выполните следующие команды в терминале:

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

#### Сторонние PPA-репозитории

#### Ondřej Surý

Так же существует возможность использовать репозиторий [Ondřej Surý](https://launchpad.net/~ondrej/+archive/ubuntu/php/), вместо packagecloud.io</0>.</p> 

Installation of the repo:

```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

and Phalcon:

```php
sudo apt-get install php-phalcon
```

<a name='installation-linux-rpm'></a>

### RPM дистрибутивы (CentOS, Fedora, и т.д.)

<a name='installation-linux-rpm-repository'></a>

#### Настройка репозитория

Добавьте репозиторий для вашего дистрибутива:

<a name='installation-linux-rpm-repository-stable'></a>

##### Стабильные релизы

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

или

<a name='installation-linux-rpm-repository-nightly'></a>

##### Ночные релизы

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

<h5 class='alert alert-warning'>This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds. </h5>

<a name='installation-linux-rpm-phalcon'></a>

#### Установка Phalcon

Чтобы установить Phalcon выполните следующие команды в терминале:

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

#### Сторонние RPM-репозитории

##### Remi

[Remi Collet](https://github.com/remicollet) поддерживает отличный репозиторий для операционных систем использующих RPM-пакеты. Вы можете найти инструкции о том, как включить его для вашего дистрибутива [здесь](https://blog.remirepo.net/pages/Config-en).

Установка Phalcon, после того, проста:

```bash
yum install php56-php-phalcon3
```

Доступны версии для архитектур x86/x64 и PHP 5.5/5.6/7.x.

<a name='installation-freebsd'></a>

## FreeBSD

Порт доступен для FreeBSD. Для установки достаточно пары простых команд:

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

<a name='installation-gentoo'></a>

## Gentoo

Оверлей для установки Phalcon может быть найден здесь: <https://github.com/smoke/phalcon-gentoo-overlay>

<a name='installation-macos'></a>

## macOS

В macOs вы можете скомпилировать и установить расширение из исходников, либо воспользоваться `brew` или `macports`:

### Требования

* Набор инструментов для разработчика PHP 5.5.x/5.6.x/7.0.x/7.1.x (php-dev)
* XCode

<a name='installation-macos-brew'></a>

### Brew

As the [homebrew/php tap has been deprecated](https://brew.sh/2018/01/19/homebrew-1.5.0/) and is in the process of being removed, A custom repository for Phalcon has been created.

PHP 5.5 has not been ported to homebrew/core and as such no longer exists. PHP 7.2 on the other hand has been added.

```bash
brew tap tigerstrikemedia/homebrew-phalconphp
brew install php56-phalcon
brew install php70-phalcon
brew install php71-phalcon
brew install php72-phalcon
```

<a name='installation-macos-macports'></a>

### MacPorts

```bash
sudo port install php55-phalcon
sudo port install php56-phalcon
```

Откройте ваш php.ini и добавьте в конец файла:

```ini
extension=php_phalcon.so
```

Перезагрузите веб-сервер.

<a name='installation-windows'></a>

## Windows

Для использования Phalcon в Windows вам понадобится установить phalcon.dll. Мы подготовили различные DLL для большинства целевых платформ. DLL могут быть найдены на нашей страничке [загрузок](https://phalconphp.com/en/download/windows).

В первую очередь определите вашу версию PHP, а также архитектуру. Обратите внимание, если вы скачаете неподходящую версию DLL, Phalcon работать не будет. Вам может помочь функция `phpinfo()`, которая выводит соответствующую информацию. В приведенном ниже примере, нам понадобится NTS версия DLL:

![phpinfo](/assets/images/content/phpinfo-api.png)

Доступны следующие DLL:

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
|     x64     |  5.5   | Потокобезопасный                     |
|     x64     |  5.5   | Не являющийся потокобезопасным (NTS) |
|     x86     |  5.5   | Потокобезопасный                     |
|     x86     |  5.5   | Не являющийся потокобезопасным (NTS) |

Откройте ваш php.ini и добавьте в конец файла:

```ini
extension=php_phalcon.dll
```

Перезагрузите веб-сервер.

<a name='installation-sources'></a>

## Компиляция из исходников

Сборка из исходников похожа в большинстве сред (Linux/macOs).

### Требования

* Набор инструментов для разработчика PHP 5.5.x/5.6.x/7.0.x/7.1.x (php-dev)
* Компилятор GCC (Linux/Solaris/FreeBSD) или Xcode (macOS)
* re2c >= 0.13
* libpcre-dev (libpcre3-dev)

Вы можете установить эти пакеты в вашей системе используя соответствующий пакетный менеджер. Инструкции для популярных дистрибутивов приведены ниже:

#### Ubuntu

```bash
sudo apt-get install php5-dev libpcre3-dev gcc make
```

#### Suse

```bash
sudo zypper install php5-devel gcc make
```

#### CentOS / Fedora / RHEL

```bash
sudo yum install php-devel pcre-devel gcc make
```

### Компиляция Phalcon

Для начала необходимо получить Phalcon с официального репозитория на Github

```bash
git clone https://github.com/phalcon/cphalcon
```

затем собрать расширение

```bash
cd cphalcon/build
sudo ./install
```

Вам понадобится добавить `extension=phalcon.so` в ваш php.ini и перезапустить веб-сервер для загрузки расширения.

```ini
# Suse: создайте файл phalcon.ini в /etc/php5/conf.d/ со следующим содержимым:
extension=phalcon.so

# CentOS/RedHat/Fedora: создайте файл phalcon.ini в /etc/php.d/ со следующим содержимым:
extension=phalcon.so

# Ubuntu/Debian с apache2: создайте файл 30-phalcon.ini в /etc/php5/apache2/conf.d/ со следующим содержимым:
extension=phalcon.so

# Ubuntu/Debian с php5-fpm: создайте файл 30-phalcon.ini в /etc/php5/fpm/conf.d/ со следующим содержимым:
extension=phalcon.so

# Ubuntu/Debian с php5-cli: создайте файл 30-phalcon.ini в /etc/php5/cli/conf.d/ со следующим содержимым:
extension=phalcon.so
```

<a name='installation-sources-advanced'></a>

## Расширенная компиляция

Инсталлятор Phalcon способен автоматически обнаружить целевую архитектуру. Однако, вы можете указать архитектуру явно, при запуске:

```bash
cd cphalcon/build

# Одна из следующих команд установит Phalcon для нужной архитектуры:
sudo ./install --arch 32bits
sudo ./install --arch 64bits
sudo ./install --arch safe
```

Если в результате автоматической установки произошел сбой, вы можете попробовать собрать расширение вручную:

```bash
git clone https://github.com/phalcon/cphalcon
# cd cphalcon/build/php5/32bits
cd cphalcon/build/php5/64bits

# Обратите внимание:
# Для PHP 7 вам необходимо использовать
# cd cphalcon/build/php7/32bits
# или
# cd cphalcon/build/php7/64bits

make clean
phpize --clean

export CFLAGS="-O2 --fvisibility=hidden"
./configure --enable-phalcon

make
make install
```

Если у вас не стандартная версия PHP:

```bash
git clone https://github.com/phalcon/cphalcon
# cd cphalcon/build/php5/32bits
cd cphalcon/build/php5/64bits

# Обратите внимание:
# Для PHP 7 вам необходимо использовать
# cd cphalcon/build/php7/32bits
# или
# cd cphalcon/build/php7/64bits

make clean
/opt/php-5.6.15/bin/phpize --clean

export CFLAGS="-O2 --fvisibility=hidden"
./configure --with-php-config=/opt/php-5.6.15/bin/php-config --enable-phalcon

make
make install
```

Вам понадобится добавить `extension=phalcon.so` в ваш php.ini и перезапустить веб-сервер для загрузки расширения.

<a name='installation-testing'></a>
Можно создать небольшой скрипт в корне веб-сервера, следующего содержания:

```php
<?php

phpinfo();
```

и загрузить его в браузере. В появившемся результате, среди прочего, вы должны увидеть секцию Phalcon. Если такой секции нет, убедитесь в том, что модуль был скомпилирован правильно, вы сделали необходимые изменения в файле `php.ini`, а также веб-сервер был перезагружен.

Также вы можете проверить вашу установку из командной строки:

```bash
php -r 'print_r(get_loaded_extensions());'
```

Это выведет что-то похожее на это:

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

Также вы можете проверить установку модуля командой:

```bash
php -m
```

<h5 class='alert alert-danger'>Note that in some Linux based systems, you might need to change two <code>php.ini</code> files, one for your web server (Apache/Nginx), and one for the CLI. If Phalcon is loaded only for say the web server, you will need to locate the CLI <code>php.ini</code> and make the necessary additions for the module to be loaded. </h5>
