---
layout: default
language: 'ko-kr'
version: '4.0'
title: '개발환경 - Nanobox'
keywords: 'environment, nanobox, docker, 개발환경, 환경, 도커'
---

# 개발환경

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 개요

[Nanobox](https://nanobox.io) 앱을 개발하고 배포하기 위한, 가벼운 마이크로플랫폼입니다. 로컬에서 작업할 때, Nanobox는 구체적인 필요에 맞게 설정된 가상 개발 환경을 돌리고 구성하기 위해 도커를 사용합니다. 운영서버로 배포할 준비가 되면, Nanobox는 당신이 선택한 클라우드서비스에 동일한 개발환경을 구성하고 사용할 수 있도록 해주며, 앱의 관리와 확장은 Nanobox 대시보드에서 할 수 있게 됩니다.

## 로컬 개발

Nanobox는 프로젝트 갯수에 관계없이 로컬 개발에 사용할 수 있습니다 (PHP 외에도 사용가능). Nanobox를 사용하기 위해서는 우선 [무료 Nanobox 계정을 생성](https://dashboard.nanobox.io/users/register) 한 후, [Nanobox 인스톨러를 내려받아서 실행](https://dashboard.nanobox.io/download) 합니다. 계정은 nanobox에 로그인하고 콘솔 명령어를 사용하는 용도로만 사용됩니다. Nanobox는 인증정보를 기억하기 때문에 처음 한번만 로그인하시면 됩니다. Nanobox를 로컬에서만 사용하신다면, 이외 다른 작업은 아무것도 할 필요가 없습니다. 하지만 개발한 어플리케이션을 운영환경에 배포하시려는 경우, 동일한 로그인이 이후에 사용될 수 있습니다.

### 새 프로젝트 생성

프로젝트 폴더를 만들고 `cd` 명령어로 폴더내로 진입합니다:

```bash
mkdir nanobox-phalcon && cd nanobox-phalcon
```

### `boxfile.yml` 추가

Nanobox 는 앱의 런타임을 빌드하고 환경을 구성하기 위해 [`boxfile.yml`](https://docs.nanobox.io/boxfile/) 파일을 사용합니다. 프로젝트 루트폴더에 다음과 같은 내용으로 `boxfile.yml` 파일을 생성하세요:

```yaml
run.config:
  engine: php
  engine.config:
    runtime: php-7.2
    document_root: public
    extensions:
      - phalcon
  extra_steps:
    #===========================================================================
    # PSR extension compilation
    - |
      (
        CURRENT_FOLDER=$(pwd)
        rm -fR /tmp/php-psr
        cd /tmp/build
        git clone --depth=1 https://github.com/jbboehr/php-psr.git
        cd php-psr
        set -e
        phpize
        ./configure --with-php-config=$(which php-config)
        make -j"$(getconf _NPROCESSORS_ONLN)"
        make install
        cd $CURRENT_FOLDER
        rm -fR /tmp/php-psr
        unset CURRENT_FOLDER
      )
    - echo -e 'extension=psr.so' >> "/data/etc/php/dev_php.ini"
    - echo "alias phalcon=\'phalcon.php\'" >> /data/var/home/gonano/.bashrc
```

이 구성은 다음과 같은 역할을 합니다:

- 앱의 런타임을 빌드하는 스크립트들로 구성된, PHP [엔진](https://docs.nanobox.io/engines/)을 사용.
- PHP 7.2 사용
- Apache 문서 루트를 `public` 로 설정.
- 사용할 익스텐션에 phalcon 포함 *Nanobox 는 기본설치 익스텐션이 따로 없기 때문에, 필요한 익스텐션들이 있다면 직접 추가해 주셔야 합니다. 자세한 정보는 href="https://guides.nanobox.io/php/phalcon/php-extensions/">여기</a> 에서 확인하실 수 있습니다.*
- 필요한 [PSR](https://github.com/jbboehr/php-psr.git) 익스텐션 설치
- `phalcon` 명령어를 사용하기 위해 Phalcon Devtools에 대해 bash alias 추가.

어플리테이션의 필요에 따라, 추가적인 익스텐션을 설치해야 할 수도 있습니다. 예를 들어 `mbcrypt`, `igbinary`, `json`, `session`, `redis` 등. `boxfile.yml` 파일의 `extensions` 섹션 구성 예:

```yaml
run.config:
  engine: php
  engine.config:
    extensions:
      - json
      - mbstring
      - igbinary
      - session
      - phalcon
      - redis
```

> **주의** 익스텐션 순서는 **매우 중요**. 특정 익스텐션은 필요한 다른 익스텐션이 먼저 로드되어야 자신이 로드되는 경우가 있음. 예를 들어 `igbinary` 는 `redis` 이전에 로드되어야 함.
{: .alert .alert-warning }

### `composer.json` 에 Phalcon Devtools 추가

프로젝트 루트폴더에 `composer.json` 파일을 만들고 dev requirements에 `phalcon/devtools` 를 추가합니다:

```json
{
    "require-dev": {
        "phalcon/devtools": "~3.0.3"
    }
}
```

> **주의**: Phalcon Devtools 버전은 사용 중인 PHP 버전과 Phalcon 버전에 따라 달라집니다.
{: .alert .alert-warning }

### Nanobox 를 시작하고 새로운 Phalcon 앱 생성

프로젝트 루트폴더에서, 다음 명령어들을 실행해서 Nanobox를 시작하고 새로운 Phalcon 앱을 생성합니다. Nanbox가 시작되면, PHP엔진이 Phalcon 익스텐션을 자동으로 설치하고 활성화시킵니다. `composer install` 명령으로 Phalcon Devtools 를 설치한 후, 가상 환경 내의 대화형 콘솔창이 나타납니다. 작업 디렉토리는 VM 내에 `/app` 디렉토리로 마운트되기 때문에, 변경사항이 있으면 VM과 로컬 작업디렉토리에 동시에 반영됩니다.

```bash
# Nanobox를 시작하고 (설치완료 후) Nanobox 콘솔표시
nanobox run

# /tmp 디렉토리로 이동
cd /tmp

# 새 Phalcon 앱 생성
phalcon project myapp

# 원래의 /app 디렉토리로 이동
cd -

# 생성된 앱을 프로젝트로 복사
cp -a /tmp/myapp/* .

# 콘솔 닫음
exit
```

### 앱 실행

새로운 Phalcon 앱을 실행하기 전, Nanobox를 이용해서 DNS alias 를 추가하기를 권장합니다. 이 작업은 로컬 `hosts`파일에 개발환경을 가르키는 라인을 추가하여 브라우저에서 앱으로 접근할 수 있는 편리한 방법을 제공합니다.

```bash
nanobox dns add local phalcon.dev
```

물론 컨테이너의 IP 주소를 직접 사용해서 접속하셔도 됩니다. IP 주소는 처음에 컨테이너를 실행하면 화면에 표시됩니다. 모르고 지나치셨거나 기억이 나지 않는다면, 터미널을 새창으로 하나 더 열어서, 시스템 상에서 프로젝트가 저장되어 있는 폴더로 이동하신 후 다음의 명령어를 입력하세요

```bash
nanobox info local
```

이 명령어는 모든 컨테이너/컴포넌트의 전체 IP 주소와 (가능한 경우) 데이터베이스의 암호까지 출력 해줍니다.

Nanbox는 Apache ( `boxfile.yml`에 Nginx 로 설정한 경우 Nginx) 와 PHP`php-server` 를 시작해주는 헬퍼 스크립트를 제공합니다. `nanobox run` 명령어에 파라미터 값으로 입력하면, 로컬 개발환경을 시작하고 즉시 앱을 실행시켜줍니다.

```bash
nanobox run php-server
```

실행되면, `https://phalcon.dev` 로 가서 앱 실행화면을 확인하실 수 있습니다.

### 개발 환경 확인하기

가상환경은 Phalcon 어플리케이션을 실행하기 위해 필요한 모든 것을 포함하고 있습니다.

```bash
# Nanobox 콘솔 열기
nanobox run

# Php 버전 체크
php -v

# Phalcon Devtools 사용가능여부 확인
phalcon info

# 로컬 코드베이스가 마운트되었는지 확인
ls

# 콘솔 나가기
exit
```