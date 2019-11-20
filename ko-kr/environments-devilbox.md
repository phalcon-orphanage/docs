---
layout: default
language: 'ko-kr'
version: '4.0'
title: '개발환경 - Devilbox'
keywords: 'environment, devilbox, docker, 개발환경'
---

# 개발환경

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 개요

[Devilbox](https://devilbox.org) Devilbox 는 최근 출시되어 LAMP 와 MEAN을 완벽히 지원하며, 세부적인 것까지 맞춤 설정가능한 PHP스택입니다. 또한 이 스택은 도커화(dockerized)되어 모든 주요 플랫폼에서 동작합니다. 로컬 개발시 필요한 모든 버전들 간에 쉽게 전환하거나 결합할 수 있도록 하는 것이 주 목표입니다. 가상호스트, SSL인증서와 DNS레코드가 자동으로 생성되는 환경을 지원하기 위해 지원하는 프로젝트 갯수에 제한이 없습니다. NodeJS 같은 리스닝서버도 문제없이 사용 할 수 있도록 프로젝트별 리버스 프록시 또한 지원하고 있습니다. Catch-all 이메일과 인기있는 개발도구들 또한 준비되어 있습니다. 모든 것들이 사전 설정되어 있기 때문에 별도의 설정이 필요없습니다.

게다가, Devilbox 는 상이한 운영체제 들 간에도 동일하고 재현가능한 개발환경을 제공하고 있습니다.

이 예제는 Devilbox PHP 컨테이너 내에 Phalcon을 설치하기 위해 `phalcon`을 사용합니다. 아래의 단계들을 완료하고 나면, http와 https 로 서비스 할 준비가 완료된 유효한 Phalcon 셋업을 가지게 될 것입니다.

## 설정

다음의 설정이 사용됩니다:

| Project name | `my-phalcon` | | VirtualHost directory | `/shared/httpd/my-phalcon` | | Database | n.a. | | `TLD_SUFFIX` | loc | | Project URL | `http://my-phalcon.loc`, `https://my-phalcon.loc` |

> * Devilbox PHP 컨테이너 내에서, 프로젝트는 항상 `/shared/httpd/` 폴더에 존재하게 됩니다.
> * 호스트 운영체제에서, 프로젝트는 Devilbox git 디렉토리 내 `./data/www/` 에 존재하게 됩니다(기본값). 이 경로는 `HOST_PATH_HTTPD_DATADIR` 값을 수정하여 변경할 수 있습니다.
{: .alert .alert-info }

## 활성화

간단한 6단계만으로 개발환경이 준비완료됩니다.

- PHP 컨테이너로 진입
- 신규 가상호스트 디렉토리 생성
- Phalcon 설치
- Webroot 디렉토리를 심링크
- DNS 레코드 셋업
- 브라우저로 `http://my-phalcon.loc` 주소를 여세요
- (Nginx) 커스텀 vhost 설정파일 생성

### PHP 컨테이너로 진입

필요한 모든 도구를 PHP컨테이너가 제공하기 때문에 모든 작업은 PHP 컨테이너 내에서 진행됩니다. Devilbox git 디렉토리로 이동해서 `./shell.sh` (윈도우 환경에서는 `shell.bat`)를 실행시켜서 PHP 컨테이너로 진입합니다.

```bash
host> ./shell.sh
```

### 신규 가상호스트 디렉토리 생성

가상호스트(vhost) 디렉토리는 프로젝트가 저장될 위치의 이름입니다. (`<가상호스트 디렉토리명>.TLD_SUFFIX` 가 최종 URL이 됩니다 ).

```bash
devilbox@php-7.3 in /shared/httpd $ mkdir my-phalcon
```

### Phalcon 설치

새로 만들어진 가상호스트 디렉토리로 이동해서 `phalcon` cli 로 Phalcon을 설치합니다.

```bash
devilbox@php-7.3 in /shared/httpd $ cd my-phalcon
devilbox@php-7.3 in /shared/httpd/my-phalcon $ phalcon project phalconphp
```

설치 후 디렉토리 구조는 다음과 유사합니다:

```bash
devilbox@php-7.3 in /shared/httpd/my-phalcon $ tree -L 1
.
└── phalconphp

1 directory, 0 files
```

### 웹루트(webroot) 심링크

실제 웹루트 디렉토리를 `htdocs`로 심링크 하는 것은 중요한 부분입니다. 웹서버는 모든 프로젝트의 문서 루트가 `<가상호스트 디렉토리명>/htdocs/` 에 있다고 판단합니다. 서버는 이 경로에서 파일을 읽어 서비스 하게 됩니다. 이 경로에는 어플리케이션의 진입점(보통 `index.php`)이 있어야 할 곳이기도 합니다.

그러나 일부 프레임워크에서는 파일과 컨텐츠를, 몇단계까지 내려가는지 알수 없는 하위 디렉토리에 저장하기도 합니다. 그래서 이 부분은 개발환경에 대해 사전설정하는 것이 불가능합니다. 그런 이유로 직접 수작업으로 프레임워크가 요구하는 해당 폴더로 심링크를 걸어야 합니다.

```bash
devilbox@php-7.3 in /shared/httpd/my-phalcon $ ln -s phalconphp/public/ htdocs
```

설치 후 디렉토리 구조는 다음과 유사합니다:

```bash
devilbox@php-7.3 in /shared/httpd/my-phalcon $ tree -L 1
.
├── phalconphp
└── htdocs -> phalconphp/public

2 directories, 0 files
```

위의 리스트에서도 볼 수 있듯이, 웹서버에서 필요로 하는 `htdocs` 폴더는 이제 프레임워크의 진입점을 가르키게 됩니다.

> **주의**: **Docker Toolbox**를 이용하고 계시다면, **symlink** 의 사용을 **명시적으로 허용** 할 필요가 있습니다.
{: .alert .alert-warning }

### DNS 레코드

Auth DNS 설정을 이미 **하신** 경우에는, 번들링 된 DNS서버가 자동으로 DNS입력값을 받기 때문에 이 섹션은 건너뛰셔도 됩니다.

Auto DNS 설정을 **하지 않으신** 경우, 호스트 운영체제의 `/etc/hosts` 파일에 다음 줄을 추가해 주셔야 합니다( 윈도우 인 경우 `C:\Windows\System32\drivers\etc`):

```bash
127.0.0.1 my-phalcon.loc
```

### 브라우저 실행

브라우저를 실행해서 `http://my-phalcon.loc` 혹은 `https://my-phalcon.loc` 으로 이동

### 별도의 가상호스트용 Config 파일 생성 (Nginx 인 경우만)

Nginx를 사용중이시라면 기본값으로 동작하지 않습니다. 이 부분을 해결하려면, 별도의 vhost 설정파일을 생성해야 합니다.

`.env` 파일의 `HTTPD_TEMPLATE_DIR` 값을 수정하지 않았다면, 프로젝트 폴더에 안에 `.devilbox` 폴더를 생성하세요.

`./cfg/vhost-gen/nginx.yml-example-vhost`에서 디폴트 nginx 설정값들을 `./data/www/my-project/.devilbox/nginx.yml` 파일로 복사해 넣으세요

복사해서 만든 nginx.yml 파일을 다른건 건드리지 않도록 조심스럽게 수정합니다:

`try_files $uri $uri/ /index.php$is_args$args;`

부분을

`try_files $uri $uri/ /index.php?_url=$uri&$args;`

으로 변경하고,

`location ~ \.php?$ {`

부분을

`location ~ [^/]\.php(/|$) {`

으로 변경하고 `nginx.yml`을 저장합니다. 탭이 한칸이라도 들어가 있으면 devilbox 는 이 별도설정값을 사용하지 않으니 주의해주세요. Devilbox를 재시작 하기 전 Devilbox 쉘에서 `yamllint nginx.yml` 명령을 사용해서 파일 유효성을 체크하실 수 있습니다.

## 참조

- [Devilbox.com](https://devilbox.org)
- [Devilbox 문서](https://devilbox.readthedocs.io/en/latest/examples/setup-phalcon.html)
- [HOST_PATH_HTTPD_DATADIR](https://devilbox.readthedocs.io/en/latest/configuration-files/env-file.html#env-httpd-datadir)
- [PHP 컨테이너로 진입](https://devilbox.readthedocs.io/en/latest/getting-started/enter-the-php-container.html#enter-the-php-container) 
- [PHP 컨테이너 안에서 작업하기](https://devilbox.readthedocs.io/en/latest/intermediate/work-inside-the-php-container.html#work-inside-the-php-container)
- [사용가능한 도구](https://devilbox.readthedocs.io/en/latest/readings/available-tools.html#available-tools) 
- [TLD_SUFFIX](https://devilbox.readthedocs.io/en/latest/configuration-files/env-file.html#env-tld-suffix)
- [도커 Toolbox와 심링크](https://devilbox.readthedocs.io/en/latest/howto/docker-toolbox/docker-toolbox-and-the-devilbox.html#howto-docker-toolbox-and-the-devilbox-windows-symlinks)
- [MacOS에서 프로젝트 hosts 입력값 추가하기](https://devilbox.readthedocs.io/en/latest/howto/dns/add-project-dns-entry-on-mac.html#howto-add-project-hosts-entry-on-mac)
- [윈도우에서 프로젝트 hosts 입력값 추가하기](https://devilbox.readthedocs.io/en/latest/howto/dns/add-project-dns-entry-on-win.html#howto-add-project-hosts-entry-on-win)
- [Auto DNS 설정](https://devilbox.readthedocs.io/en/latest/intermediate/setup-auto-dns.html#setup-auto-dns)