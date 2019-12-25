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

#### Debian

```bash
sudo apt-get install libpcre3-dev
```

설치 후 Phalcon을 다시한번 설치해주세요.

#### CentOS

```bash
sudo yum install pcre-devel
```

#### Mac/Osx 에서 MacPorts 사용시

[MacPorts](https://www.macports.org) 가 설치되어 있고 최신 버전인지 확인(`sudo port -v selfupdate`) 해주세요.

```bash
sudo port install php-phalcon4
```

#### Mac/Osx에서 Brew 사용시

```bash
brew install pcre
```

`brew`없이 바로 설치하시려면, [PCRE](https://www.pcre.org/) 웹사이트에서 해당 모듈의 최신버전을 직접 다운로드받으세요.

```bash
tar -xzvf pcre-8.42.tar.gz
cd pcre-8.42
./configure --prefix=/usr/local/pcre-8.42
make
make install
ln -s /usr/local/pcre-8.42 /usr/sbin/pcre
ln -s /usr/local/pcre-8.42/include/pcre.h /usr/include/pcre.h
```

Maverick

```bash
brew install pcre
```

에러가 발생하는 경우, 다음과 같이 입력

```bash
sudo ln -s /opt/local/include/pcre.h /usr/include/
sudo pecl install apc 
```

## 설치 플랫폼

Phalcon은 PHP 익스텐션 형태로 컴파일 되기 때문에, 설치과정이 다른 전통적인 PHP 프레임워크와는 다른 부분들이 좀 있습니다. Phalcon은 웹서버의 모듈형태로 설치/로드 되어져야 합니다.

### Linux

Phalcon을 리눅스에 설치하시려면, 리눅스 배포판에 있는 우리의 저장소를 추가한 후 설치하세요.

#### DEB 기반의 배포판 ( Debian, Ubuntu 등)

##### 저장소 설치

다음과 같이 배포판에 저장소를 추가하세요

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

Phalcon 설치:

```php
sudo apt-get install php-phalcon
```

#### RPM 기반 배포판 (CentOS, Fedora 등)

##### 저장소 설치

다음과 같이 배포판에 저장소를 추가하세요

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

macOS 시스템에서는 `brew`, `macports` 혹은 소스코드에서 직접 컴파일 하실 수 있습니다:

#### 요구사항

* PHP 7.2x 개발 환경
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

php.ini 파일을 열어 제일 끝 부분에 아래 내용을 추가합니다:

```ini
extension=php_phalcon.so
```

웹서버를 재시작 합니다.

### Windows

Phalcon을 윈도우에서 사용하시려면, 먼저 phalcon.dll을 설치해야 합니다. 대상 플랫폼 별로 몇개의 DLL파일을 컴파일 해두었습니다. 이 DLL파일들은 [다운로드](https://phalcon.io/en/download/windows) 페이지에서 받으실 수 있습니다.

설치된 PHP 버전과 아키텍처를 우선 확인하세요. 잘못된 DLL파일을 내려받으시면 Phalcon이 동작하지 않습니다. 해당정보는 `phpinfo()` 함수로 확인하실 수 있습니다. 예를 들어 아래의 경우는 NTS버전의 DLL파일이 필요합니다:

![phpinfo](/assets/images/content/phpinfo-api.png)

다운로드 가능한 DLL 파일들은 다음과 같습니다:

| 아키텍처 | 버전  | 타입            |
|:----:|:---:| ------------- |
| x64  | 7.x | 멀티스레드 빌드(TS)  |
| x64  | 7.x | 단일스레드 빌드(NTS) |
| x86  | 7.x | 멀티스레드 빌드(TS)  |
| x86  | 7.x | 단일스레드 빌드(NTS) |

php.ini 파일을 열어 제일 끝 부분에 아래 내용을 추가합니다:

```ini
extension=php_phalcon.dll
```

웹서버를 재시작 합니다.

### 소스를 직접 컴파일하기

소스를 직접 컴파일 하는 방법은 대부분의 환경에서 비슷합니다 (Linux/macOS)

#### 요구사항

* PHP 7.2x/7.3.x 개발 환경
* GCC 컴파일러 (리눅스/Solaris/FreeBSD) 혹은 Xcode (macOS)
* re2c >= 0.13
* libpcre-dev

#### 컴파일

[여기](https://github.com/phalcon/zephir/releases)에서 최신버전의 `zephir.phar` 를 다운받으세요. 시스템에서 접근할 수 있는 폴더에 추가하세요.

저장소 복제

```bash
https://github.com/phalcon/cphalcon 저장소 복제
```

Phalcon 컴파일

```bash
cd cphalcon/
git checkout tags/v4.0.0 ./
zephir fullclean
zephir build
```

모듈 확인

```bash
php -m | grep phalcon
```

PHP ini 파일에 `extension=phalcon.so` 라인을 추가하신 후 웹서버를 재시작해서 추가한 익스텐션이 로드되도록 해주세요.

```ini
# Suse: Phalcon.ini 파일을 만들어 extension= phalcon.so 라인을 추가한 후 /etc/php7/conf.d/ 폴더에 저장해 주세요.

# CentOS/RedHat/Fedora: Phalcon.ini 파일을 만들어 extension=phalcon.so 라인을 추가한 후 /etc/php.d/ 폴더에 저장해 주세요.

# Ubuntu/Debian 에서 Apache2 사용시: 30-phalcon.ini 파일을 만들어 extension=phalcon.so 라인을 추가한 후 /etc/php7/apache2/conf.d/ 폴더에 저장해 주세요.

# Ubuntu/Debian 에서 Php7-fpm 사용시: 30-phalcon.ini 파일을 만들어 extension=phalcon.so 라인을 추가한 후 /etc/php7/fpm/conf.d/ 폴더에 저장해 주세요.

# Ubuntu/Debian 에서 Php7-cli 사용시: 30-phalcon.ini 파일을 만들어 extension=phalcon.so 라인을 추가한 후 /etc/php7/cli/conf.d/ 폴더에 저장해 주세요.
```

위의 설명대로 따라 하시면 컴파일 **과 함께** 시스템 상에 모듈 설치까지 진행됩니다. 물론 익스텐션을 컴파일만 한 후 수동으로 직접 `ini`파일에 추가하실 수도 있습니다.

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

이렇게 하시는 경우 CLI와 웹서버 용의 `php.ini` 파일들에 직접`extension=phalcon.so` 라인을 추가해 주셔야 합니다.

#### 빌드 세부조정

기본값은 모든 프로세서에 대해 가능한 최대한 호환되도록 컴파일 하는 것입니다(`gcc -mtune=native -O2 -fomit-frame-pointer`). 컴파일 시 현재 사용중인 프로세스에 맞게 최적화된 머신코드를 생성하시려면, 빌드 전 CFLAGS 값을 export 하여 자신이 원하는 컴파일 플래그를 설정하실 수 있습니다. 예를 들어

    export CFLAGS="-march=native -O2 -fomit-frame-pointer"
    zephir build
    

와 같이 하시는 경우, 사용하시는 칩셋에 대해서는 가능한 최적의 코드를 생성해 주지만, 반대로 컴파일된 개체가 구형 칩셋에 대해서는 호환되지 않을 가능성이 큽니다.

### 공유 호스팅

공유 호스팅 환경에서 어플리케이션을 운영하실 경우, 특히 root 권한이 없을 경우에 Phalcon 설치가 제한될 가능성이 큽니다. 일부 웹 호스팅사의 경우 운 좋게도 제어판에서 Phalcon 설치를 지원합니다.

#### cPanel & WHM

cPanel & WHM 은 Easy Apache 4 (EA4) 상에서 Phalcon을 지원합니다. Easy Apache 4 (EA4) 에 [module](https://github.com/CpanelInc/scl-phalcon)을 활성화 하셔서 Phalcon을 설치하실 수 있습니다.

#### Plesk

Plesk 제어판에서는 Phalcon을 지원하지 않지만, Plesk [웹사이트](https://support.plesk.com/hc/en-us/articles/115002186489-How-to-install-Phalcon-framework-for-a-PHP-supplied-by-Plesk-) 에서 설치방법에 대한 설명서를 확인하실 수 있습니다.