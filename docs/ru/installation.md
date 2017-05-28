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
                      <a href="#installation-linux-debian-phalcon-php5">PHP 5.x</a>
                    </li>
                    <li>
                      <a href="#installation-linux-debian-phalcon-php7">PHP 7</a>
                    </li>
                  </ul>
                </li>
                
                <li>
                  <a href="#installation-linux-debian-other-ppa">Сторонние PPA-репозитории</a>
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
                  <a href="#installation-linux-rpm-phalcon">Установка Phalcon</a> <ul>
                    <li>
                      <a href="#installation-linux-rpm-phalcon-php5">PHP 5.x</a>
                    </li>
                    <li>
                      <a href="#installation-linux-rpm-phalcon-php7">PHP 7</a>
                    </li>
                  </ul>
                </li>
                
                <li>
                  <a href="installation-linux-rpm-other-rpm">Сторонние RPM-репозитории</a>
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

Phalcon требует PHP для запуска. Его слабо связанный дизайн позволяет разработчикам один раз установив Phalcon, использовать его возможности везде, без дополнительных расширений. Однако некоторые его компоненты зависят от других расширений. Например, использование подключений к базам данных, требует расширения `php_pdo`. Если ваша СУБД MySql/MariaDb или Aurora, вам так же понадобится расширение `php_mysqlnd`. Аналогично, использование базы данных PostgreSql с Phalcon, требует расширения `php_pgsql`.

<a name='requirements-hardware'></a>

## Аппаратное обеспечение

Phalcon разработан таким образом, чтобы потреблять как можно меньше ресурсов, взамен предлагая высокую производительность. Хотя мы и тестировали Phalcon на маломощных машинах (например с 256 MB RAM и процессором 500 MHz), оборудование, которое вы будете выбирать, будет зависеть от потребностей приложения.

Наш веб-сайт и блог (а также другие сайты) работают на Amazon VM с 512 MB RAM и 1 vCPU.

<a name='requirements-software'></a>

## Программное обеспечение

- PHP > = 5.5

<h5 class='alert alert-danger'>Рекомендуется всегда использовать последние версии Phalcon и PHP из соображений стабильности, улучшения безопасности, а также производительности. Поддержка PHP 5.x будет прекращена в ближайшее время. Phalcon 4 будет поддерживать только PHP 7. </h5>

### Дополнительно, в зависимости от потребностей вашего приложения

- Расширение [PDO](http://php.net/manual/en/book.pdo.php), а также расширение для работы с соответствующей СУБД ([MySQL](http://php.net/manual/en/ref.pdo-mysql.php), [PostgreSql](http://php.net/manual/en/ref.pdo-pgsql.php) и т.д.)
- Расширение [OpenSSL](http://php.net/manual/en/book.openssl.php)
- Расширение [Mbstring](http://php.net/manual/en/book.mbstring.php)
- Расширение [Memcache](http://php.net/manual/en/book.memcache.php), [Memcached](http://php.net/manual/en/book.memcached.php) или любое другое, в зависимости от планируемого драйвера кеша

<a name='installation'></a>

# Установка

Так как Phalcon распространяется в виде расширения для PHP, его установка отличается от традиционных PHP фреймворков. Phalcon нуждается в установке и загрузке в виде модуля на вашем веб сервере.

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

<a name='requirements-hardware'></a>

0

<a name='requirements-hardware'></a>

1#### Установка Phalcon

Чтобы установить Phalcon выполните следующие команды в терминале:

<a name='requirements-hardware'></a>

2##### PHP 5.x

```bash
sudo apt-get update
sudo apt-get install php5-phalcon
```

<a name='requirements-hardware'></a>

3##### PHP 7

```bash
sudo apt-get update
sudo apt-get install php7.0-phalcon
```

<a name='requirements-hardware'></a>

4#### Сторонние PPA-репозитории

#### Ondřej Surý

Вы всегда можете использовать репозитории [Ondřej Surý](https://launchpad.net/~ondrej/+archive/ubuntu/php/), если в не хотите использовать packagecloud.io.

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

5### RPM дистрибутивы (CentOS, Fedora, и т.д.)

<a name='requirements-hardware'></a>

6#### Настройка репозитория

Добавьте репозиторий для вашего дистрибутива:

<a name='requirements-hardware'></a>

7##### Стабильные релизы

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

или

<a name='requirements-hardware'></a>

8##### Ночные релизы

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

<a name='requirements-hardware'></a>

9

<a name='requirements-software'></a>

0#### Установка Phalcon

Чтобы установить Phalcon выполните следующие команды в терминале:

<a name='requirements-software'></a>

1##### PHP 5.x

```bash
sudo yum update
sudo yum install php56u-phalcon
```

<a name='requirements-software'></a>

2##### PHP 7

```bash
sudo yum update
sudo yum install php70u-phalcon
```

<a name='requirements-software'></a>

3#### Сторонние RPM-репозитории

##### Remi

Remi Collet сопровождает отличный RPM -репозиторий. Вы можете найти инструкции о том, как включить его для вашего дистрибутива [здесь](https://blog.remirepo.net/pages/Config-en)

Установка Phalcon, после того, проста:

```bash
yum install php56-php-phalcon3
```

Доступны версии для архитектур x86/x64 и PHP 5.5/5.6/7.x.

<a name='requirements-software'></a>

4## FreeBSD

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

<a name='requirements-software'></a>

5## Gentoo

Оверлей для установки Phalcon может быть найден здесь: <https://github.com/smoke/phalcon-gentoo-overlay>

<a name='requirements-software'></a>

6## macOS

В macOs вы можете скомпилировать и установить расширение из исходников, либо воспользоваться `brew` или `macports`:

### Требования

- Набор инструментов для разработчика PHP 5.5.x/5.6.x/7.0.x.7.1.x (php-dev)
- XCode

<a name='requirements-software'></a>

7### Brew

```bash
brew tap homebrew/homebrew-php
brew install php55-phalcon
brew install php56-phalcon
brew install php70-phalcon
brew install php71-phalcon
```

<a name='requirements-software'></a>

8### MacPorts

```bash
sudo port install php55-phalcon
sudo port install php56-phalcon
```

Откройте ваш php.ini и добавьте в конец файла:

```ini
extension=php_phalcon.so
```

Перезагрузите веб-сервер.

<a name='requirements-software'></a>

9## Windows

Для использования Phalcon в Windows вам понадобится установить phalcon.dll. Мы подготовили различные DLL для большинства целевых платформ. DLL могут быть найдены на нашей страничке [загрузок](https://phalconphp.com/en/download/windows).

В первую очередь определите вашу версию PHP, а также архитектуру. Обратите внимание, если вы скачаете неподходящую версию DLL, Phalcon работать не будет. Вам может помочь функция `phpinfo()`, которая выводит соответствующую информацию. В приведенном ниже примере, нам понадобится NTS версия DLL:

![phpinfo](/images/content/phpinfo-api.png)

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

Откройте ваш php.ini и добавьте в конец файла:

```ini
extension=php_phalcon.dll
```

Перезагрузите веб-сервер.

<a name='installation-sources'></a>

## Компиляция из исходников

Сборка из исходников похожа в большинстве сред (Linux/macOs).

### Необходимое программное обеспечение

- Набор инструментов для разработчика PHP 5.5.x/5.6.x/7.0.x.7.1.x (php-dev)
- Компилятор GCC (Linux/Solaris/FreeBSD) или Xcode (macOS)
- re2c >= 0.13
- libpcre-dev (libpcre3-dev)

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

Если у вас не стандартная версия PHP

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

<h5 class='alert alert-danger'>Обратите внимание, в большинстве Linux систем вы должны изменить два файла <code>php.ini</code>. Один для веб-сервера (Apache/Nginx), другой — для CLI. Если вы столкнетесь с тем, что Phalcon загружается только для веб-сервера, вам нужно будет найти <code>php.ini</code> относящийся к CLI и внести в него необходимые изменения, для загрузки модуля в консольном режиме. </h5>