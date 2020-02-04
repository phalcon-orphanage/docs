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

Pecl을 사용하면 이 익스텐션은 자동으로 설치됩니다.

### PDO

Phalcon은 느슨하게 연결되어 있기 때문에, 추가적인 익스텐션 필요없이 기능을 사용할 수 있습니다. 하지만 특정 컴포넌트는 동작을 위해 추가적인 익스텐션이 필요한 경우가 있습니다. 데이터베이스 연결 및 사용이 필요한 경우, `php_pdo` 익스텐션을 설치해야 합니다. 사용중인 RDBMS가 MYSQL/MariaDB 혹은 Aurora인 경우, `php_mysqlnd` 익스텍션도 필요합니다. 마찬가지로, Phalcon에서 PostgreSql을 사용하는 경우 `php_pgsql` 익스텐션이 필요합니다.

### 하드웨어

Phalcon은 최고의 성능을 제공하면서도 가능한 최소의 리소스를 사용하도록 설계되어 있습니다. Phalcon을 다양한 저사양의 환경(예를 들어 0.5CPU에 0.25GB 램) 에서 테스트 해보기는 했지만, 하드웨어의 선택은 전적으로 구동시키는 어플리케이션의 필요에 따라야 할 것입니다.

우리는 최근 몇년간 아마존AWS에서 1 vCPU/512MB RAM 의 VM 사양으로 웹사이트와 블로그를 호스팅 해왔습니다.

### 소프트웨어

> **주의**: 버그 해결, 보안 강화 뿐만이 아니라 성능향상을 위해서라도 Phalcon과 PHP는 가능한 항상 최신버전을 사용해야 합니다.
{: .alert .alert-danger }

어플리케이션의 요구사항과 필요한 Phalcon 컴포넌트에 따라, PHP 7.2 이상을 사용해야 하는 것 외에도 다음의 익스텐션들을 추가해야 할 수 있습니다.

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

`libpcre3-dev` 패키지의 경우에 다음의 명령어를 사용하시면 됩니다:

### Pecl

Pecl 설치방법은 윈도우, 리눅스와 MacOS에서 가능합니다. 윈도우에서는 사전컴파일 된 dll 파일을 사용합니다. Under Linux and MacOS it will compile Phalcon locally so it could be faster to use a different installation method on these platforms. Pecl을 이용해서 설치하시려면 [pecl/pear](https://pear.php.net/manual/en/installation.getting.php) 가 설치되어있는지를 먼저 확인해 주세요.

    pecl channel-update pecl.php.net
    pecl install phalcon
    

#### Debian

```bash
sudo apt-get install libpcre3-dev
```

설치 후 Phalcon을 다시한번 설치해주세요.

#### CentOS

```bash
sudo yum install pcre-devel
```

#### Mac/Osx에서 Brew 사용시

```bash
brew install pcre
```

`brew`없이 바로 설치하시려면, [PCRE](https://www.pcre.org/) 웹사이트에서 최신버전의 pcre를 직접 다운로드받으세요.

```bash
tar -xzvf pcre-8.42.tar.gz
cd pcre-8.42
./configure --prefix=/usr/local/pcre-8.42
make
make install
ln -s /usr/local/pcre-8.42 /usr/sbin/pcre
ln -s /usr/local/pcre-8.42/include/pcre.h /usr/include/pcre.h
```

Maverick 사용자

```bash
brew install pcre
```

만약 오류가 발생한다면, 아래와 같이 작업해 주세요

```bash
sudo ln -s /opt/local/include/pcre.h /usr/include/
sudo pecl install apc 
```

## 설치 플랫폼

Phalcon은 PHP 익스텐션 형태로 컴파일 되기 때문에, 설치과정이 다른 전통적인 PHP 프레임워크와는 다른 부분들이 좀 있습니다. Phalcon은 웹서버의 모듈형태로 설치/로드 되어져야 합니다.

### 리눅스

Phalcon을 리눅스에 설치하시려면, 리눅스 배포판에 있는 우리의 저장소를 추가한 후 설치하세요.

#### DEB 기반의 배포판 ( Debian, Ubuntu 등)

##### 저장소 설치

배포판에 저장소를 추가해 주세요:

**Stable 릴리즈**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

**Nightly 릴리즈**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

**Mainline 릴리즈 ( 알파버전, 베타버전 등)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.deb.sh | sudo bash
```

> **주의**: 이 버전의 경우에는 배포판을 변경하거나 Stable 릴리즈에서 nightly 빌드로 전환 하는 경우가 아니라면 최초 한번만 실행하시면 됩니다.
{: .alert .alert-warning }

##### Phalcon 설치

Phalcon을 설치하시려면 터미널에서 아래와 같이 명령어를 입력하세요:

```bash
sudo apt-get update
sudo apt-get install php7.2-phalcon
```

##### 다른 PPA

**Ondřej Surý**

[packagecloud.io](https://packagecloud.io/phalcon)에 있는 공식 저장소를 사용하고 싶지 않으신 경우, [Ondřej Surý](https://launchpad.net/~ondrej/+archive/ubuntu/php/)가 제공하는 것을 사용하실 수 있습니다.

저장소 설치:

```php
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
```

그다음 Phalcon 설치:

```php
sudo port install php-phalcon4
```

#### RPM 기반 배포판 (CentOS, Fedora 등)

##### 저장소 설치

배포판에 저장소를 추가해 주세요:

**Stable 릴리즈**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

**Nightly 릴리즈**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

**Mainline 릴리즈 ( 알파버전, 베타버전 등)**

```bash
curl -s https://packagecloud.io/install/repositories/phalcon/mainline/script.rpm.sh | sudo bash
```

> **주의**: 이 버전의 경우에는 배포판을 변경하거나 Stable 릴리즈에서 nightly 빌드로 전환 하는 경우가 아니라면 최초 한번만 실행하시면 됩니다.
{: .alert .alert-warning }


##### Phalcon 설치

Phalcon을 설치하시려면 터미널에서 아래와 같이 명령어를 입력하세요:

```bash
sudo yum update
sudo yum install php72u-phalcon
```

##### 다른 RPM

**Remi**

[Remi Collet](https://github.com/remicollet) 님은 RPM 기반 설치를 위한 최고의 저장소를 유지관리 중입니다. [여기](https://blog.remirepo.net/pages/Config-en) 가시면 배포판 별로 어떻게 활성화 하는지에 대한 설명을 확인하실 수 있습니다.

그다음 Phalcon의 설치는 너무 간단합니다:

```bash
yum install php72-php-phalcon4
```

특정 아키텍처(x86/x64) 나 PHP버전에 맞춘 추가적인 버전들도 있습니다.

#### FreeBSD

FreeBSD 용의 포팅버전이 있습니다. 설치하시려면 아래의 명령어를 입력해 주세요.

##### pkg_add

```bash
pkg_add -r phalcon4
```

##### 소스

```bash
cd /usr/ports/www/phalcon4

make install clean
```

##### Gentoo

[여기](https://github.com/smoke/phalcon-gentoo-overlay)에서 Phalcon 설치를 위한 오버레이를 확인하실 수 있습니다.

#### Raspberry Pi

```bash
sudo -s
git clone https://github.com/phalcon/cphalcon
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir build
```

또한 기본값이 100MB인 스왑파일을 최소한 2000MB로 늘려야 합니다. 컴파일러가 램을 엄청 먹기 때문이지요.

```bash
sudo -s
nano /etc/dphys-swapfile
```

`CONF_SWAPSIZE=100` 부분을`CONF_SWAPSIZE=2000` 로 바꿔주세요

파일을 저장 후, 데몬을 재시작합니다:

```bash
/etc/init.d/dphys-swapfile stop
/etc/init.d/dphys-swapfile start
```

### macOS

Brew는 바이너리 패키지를 포함하고 있으므로 Phalcon을 직접 컴파일 하실 필요가 없습니다. 익스텐션을 직접 컴파일 하고자 하시면 다음의 패키지가 먼저 설치되어 있어야 합니다:

#### 컴파일 요구사항

* PHP 7.x 개발 환경
* XCode

#### Brew

바이너리 설치(권장):

```bash
brew tap phalcon/extension https://github.com/phalcon/homebrew-tap
brew install phalcon
```

Phalcon 컴파일:

```bash
brew tap phalcon/extension https://github.com/phalcon/homebrew-tap
brew install phalcon --build-from-source 
```

#### MacPorts

```bash
sudo port install php72-phalcon
sudo port install php73-phalcon
```

Php.ini 파일을 열어서 파일 제일 아래에 다음의 라인을 추가해 주세요:

```ini
extension=php_phalcon.so
```

웹서버를 재시작 합니다.

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

| 아키텍처 | 버전  | 타입            |
|:----:|:---:| ------------- |
| x64  | 7.x | 멀티스레드 빌드(TS)  |
| x64  | 7.x | 단일스레드 빌드(NTS) |
| x86  | 7.x | 멀티스레드 빌드(TS)  |
| x86  | 7.x | 단일스레드 빌드(NTS) |

Php.ini 파일을 열어서 파일 제일 아래에 다음의 라인을 추가해 주세요:

```ini
extension=php_phalcon.dll
```

웹서버를 재시작 합니다.

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

Running your application on shared hosting might restrict you in installing Phalcon, especially if you do not have root access. Some web hosting control panels luckily have Phalcon support.

#### cPanel & WHM

cPanel & WHM support Phalcon using Easy Apache 4 (EA4). You can install Phalcon by enabling the [module](https://github.com/CpanelInc/scl-phalcon) in Easy Apache 4 (EA4).

#### Plesk

The plesk control panel doesn't have Phalcon support but you can find installation instructions on the Plesk [website](https://support.plesk.com/hc/en-us/articles/115002186489-How-to-install-Phalcon-framework-for-a-PHP-supplied-by-Plesk-)