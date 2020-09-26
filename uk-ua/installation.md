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

#### Дистрибутиви, що базуються на DEB (Debian, Ubuntu тощо)

##### Встановлення з репозиторію

Додайте репозиторій у свій дистрибутив:

**Стабільні випуски**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

**Нічні випуски**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

**Основні релізи (альфа, бета, тощо)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.deb.sh | sudo bash
```

> **ПРИМІТКА**: Це потрібно зробити лише один раз, поки не відбудеться зміни вашого дистрибутива або переходу зі стабільної на нічну збірку.
{: .alert .alert-warning }

##### Встановлення Phalcon

Для встановлення Phalcon необхідно виконати наступні команди в терміналі:

```bash
sudo apt-get update
sudo apt-get install php7.2-phalcon
```

##### Додаткові PPA

**Ondřej Surý**

Якщо ви не бажаєте використовувати наш репозиторій на [packagecloud.io](https://packagecloud.io/phalcon), то завжди можете скористатись запропонованим [Ondřej Surý](https://launchpad.net/~ondrej/+archive/ubuntu/php/).

Встановлення репозиторію:

```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

та Phalcon:

```php
sudo apt-get install php-phalcon4
```

#### Дистрибутиви, що базуються на RPM (CentOS, Fedora тощо)

##### Встановлення з репозиторію

Додайте репозиторій у свій дистрибутив:

**Стабільні випуски**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

**Нічні випуски**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

**Основні релізи (альфа, бета, тощо)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.rpm.sh | sudo bash
```

> **ПРИМІТКА**: Це потрібно зробити лише один раз, поки не відбудеться зміни вашого дистрибутива або переходу зі стабільної на нічну збірку.
{: .alert .alert-warning }


##### Встановлення Phalcon

Для встановлення Phalcon необхідно виконати наступні команди в терміналі:

```bash
sudo yum update
sudo yum install php72u-phalcon
```

##### Додаткові RPM

**Remi**

[Remi Collet](https://github.com/remicollet) підтримує відмінний репозиторій для встановлення на базі RPM. Ви можете знайти інструкції як додати його до вашого дистрибутиву [тут](https://blog.remirepo.net/pages/Config-en).

Після цього встановлення Phalcon можна здійснити легко, як показано нижче:

```bash
yum install php72-php-phalcon4
```

Додаткові версії доступні для обох архітектур (x86/x64), а також для різних версій PHP

#### FreeBSD

Порт доступний для FreeBSD. Для установки вам доведеться виконати наступні команди:

##### pkg_add

```bash
pkg_add -r phalcon4
```

##### Джерело

```bash
cd /usr/ports/www/phalcon4

make install clean
```

##### Gentoo

Сегмент перекриття (overlay) для встановлення Phalcon можна знайти [тут](https://github.com/smoke/phalcon-gentoo-overlay)

#### Raspberry Pi

```bash
sudo -s
git clone https://github.com/phalcon/cphalcon
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir build
```

Також необхідно збільшити розмір свопу зі значення за замовчуванням 100 МБ до щонайменше 2000 МБ. Тому що компілятору бракуватиме оперативної пам'яті.

```bash
sudo -s
nano /etc/dphys-swapfile
```

Замінивши `CONF_SWAPSIZE=100` на `CONF_SWAPSIZE=2000`

Після збереження налаштувань, перезапустіть демон:

```bash
/etc/init.d/dphys-swapfile stop
/etc/init.d/dphys-swapfile start
```

### macOS

Brew включає бінарні пакети, тому вам не потрібно компілювати Phalcon самостійно. Якщо ви хочете скомпілювати розширення самостійно, вам потрібно забезпечити наступні залежності:

#### Вимоги до компіляції

* Інструменти розробки PHP 7.x
* XCode

#### Brew

Бінарне встановлення (бажано):

```bash
brew tap phalcon/extension https://github.com/phalcon/homebrew-tap
brew install phalcon
```

Компіляція Рhalcon:

```bash
brew tap phalcon/extension https://github.com/phalcon/homebrew-tap
brew install phalcon --build-from-source 
```

#### MacPorts

```bash
sudo port install php72-phalcon
sudo port install php73-phalcon
```

Відредагуйте ваш файл php.ini, а потім додайте у кінці:

```ini
extension=php_phalcon.so
```

Перезапустіть свій веб-сервер.

### PHPBrew (macOS/Linux)

PHPBrew є чудовим способом управління кількома версіями PHP та PHP-розширеннями у ваших системах. Інструкції щодо встановлення PHPBrew можна знайти [тут](https://github.com/phpbrew/phpbrew/wiki/Quick-Start)

Якщо ви використовуєте PHPBrew, ви можете встановити Phalcon наступним чином:

```bash
sudo phpbrew ext install phalcon
```

При потребі ви можете встановити залежність PSR через PHPBrew:

```bash
sudo phpbrew ext install psr
```

### Windows

Щоб використовувати Phalcon на Windows, Вам потрібно встановити phalcon.dll. Ми скомпілювали декілька DLL в залежності від цільової платформи. DLL можна знайти в нашій [сторінці завантаження](https://phalcon.io/en/download/windows).

Визначте установлену версію PHP та архітектуру. Якщо ви завантажите хибний DLL, Phalcon не запрацює. `phpinfo()` містить цю інформацію. На прикладі нижче нам буде потрібна NTS версія DLL:

![phpinfo](/assets/images/content/phpinfo-api.png)

Доступні DLL є:

| Архітектура | Версія | Тип                   |
|:-----------:|:------:| --------------------- |
|     x64     |  7.x   | Thread safe           |
|     x64     |  7.x   | Non Thread safe (NTS) |
|     x86     |  7.x   | Thread safe           |
|     x86     |  7.x   | Non Thread safe (NTS) |

Відредагуйте ваш файл php.ini, а потім додайте у кінці:

```ini
extension=php_phalcon.dll
```

Перезапустіть свій веб-сервер.

### Компіляція з джерельних кодів

Компіляція з джерельних кодів є подібною у більшості оточень (Linux/macOS).

#### Вимоги

* 7.2.x/7.3.x версії інструментів розробки PHP
* GCC компілятор (Linux/Solaris/FreeBSD) або Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

#### Компіляція

Завантажте останню версію `zephir.phar` [звідси](https://github.com/phalcon/zephir/releases). Додайте її в теку, до якої буде мати доступ ваша система.

Скопіюйте репозиторій

```bash
git clone https://github.com/phalcon/cphalcon
```

Скомпілюйте Phalcon

```bash
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir build
```

Перевірте модуль

```bash
php -m | grep phalcon
```

Тепер необхідно додати `extension=phalcon.so` у ваш PHP ini і перезапустити web-сервер, щоб таким чином завантажити розширення.

```ini
; Suse: додайте файл з назвою Phalcon.ini у теку /etc/php7/conf.d/ та скопіюйте до нього такий вміст:
extension=phalcon.so

; CentOS/RedHat/Fedora: додайте файл з назвою Phalcon.ini у теку /etc/php.d/ та скопіюйте до нього такий вміст:
extension=phalcon.so

; Ubuntu/Debian з Apache2: додайте файл з назвою 30 phalcon.ini в теку /etc/php7/apache2/conf.d/ та скопіюйте до нього такий вміст:
extension=phalcon.so

; Ubuntu/Debian з Php7-fpm: додайте файл з назвою 30-phalcon.ini в теку /etc/php7/fpm/conf.d/ та скопіюйте до нього такий вміст:
extension=phalcon.so

; Ubuntu/Debian з Php7-cli: додайте файл з назвою 30-phalcon.ini в теку /etc/php7/cli/conf.d/ та скопіюйте до нього такий вміст:
extension=phalcon.so
```

Наведені вище інструкції наведених вище скомпілюють **та** встановлять модуль у вашу систему. Ви також можете скомпілювати розширення самостійно, а потім додати його вручну до вашого `ini` файлу:

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

Якщо ви використовуєте вказаний вище метод, необхідно додати розширення `: extension=phalcon.so` до вашого `php.ini` як для консолі, так і для веб-сервера.

#### Адаптована збірка

За замовчуванням ми збираємо максимально сумісні з усіма процесорами збірки (`gcc -mtune=native -O2 -fomit-pointer`). Якщо ви хочете, щоб компілятор створив оптимізований машинний код, який відповідає процесору який зараз працює, ви можете встановити свої власні прапорці компіляції, експортувавши CFLAGS до збирання. Наприклад

    export CFLAGS="-march=native -O2 -fomit-frame-pointer"
    zephir build
    

Це згенерує найкращий можливий код для цього чіпсета, однак, швидше за все, зламає скомпільований об’єкт під старіші чіпсети.

### Спільний хостинг

Запуск вашого продукту на спільному хостингу може бути обмежений можливостями установки Phalcon, особливо якщо у вас немає root-прав. На щастя, деякі панелі управління веб-хостингу мають вбудовану підтримку Phalcon.

#### cPanel, Brainy & WHM

cPanel & WHM підтримують Phalcon використовуючи Easy Apache 4 (EA4), а Brainy на базі гнучкої конфігурації веб-сервера. Ви можете встановити Phalcon, увімкнувши [модуль](https://github.com/CpanelInc/scl-phalcon) в Easy Apache 4 (EA4), або через налаштування РНР-модулів у Brainy.

#### Plesk

Панель управління Plesk не має підтримки Phalcon з коробки, але ви можете знайти інструкції для його установки на сайті [Plesk](https://support.plesk.com/hc/en-us/articles/115002186489-How-to-install-Phalcon-framework-for-a-PHP-supplied-by-Plesk-)