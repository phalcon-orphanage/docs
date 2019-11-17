---
layout: default
language: 'en'
version: '4.0'
title: '기여하기'
keywords: 'contributing, nfr, pull request, pr, new feature request, 기여하기, 새로운 기능 요청'
---

# 공헌

* * *

![](/assets/images/document-status-stable-success.svg)

# Phalcon에 기여하기

Phalcon은 오픈소스 프로젝트이며 자원봉사자들의 노력과 기여에 주로 의존하고 있습니다. 누구든 기여하실 분들은 대환영입니다!

기여 절차를 이해할 수 있도록 잠시 시간을 내어 문서를 검토하셔서 모두에게 가능한 효율적이 될수 있도록 해주세요. 다음의 가인드라인을 따라 주심으로써, 우리는 발생하는 문제들에 대한 더 빠른 해결과 더 나은 커뮤니케이션을 얻을 수 있게 되고, 다함께 프로젝트가 한발짝 더 나갈 수 있도록 할 수 있습니다!

Phalcon 소스코드 ( 문서, 웹사이트 등을 포함해서) 는 [GitHub](https://github.com) 에 저장되어 있습니다. [organization 페이지](https://github.com/phalcon)에서 모든 저장소를 둘러 보실 수 있습니다.

Phalcon에 기여하고 싶으시다면, [GitHub pull request](https://help.github.com/articles/using-pull-requests/) 를 생성해 주시면 됩니다.

Pull request 를 생성하실 때, pull request의 범위를 설명하는데 도움이 될 수 있는 간편한 템플릿을 준비해 뒀습니다. Pull request 에 대한 테스트를 추가해 주시는 것은 매우 중요하며 커뮤니티에게도 큰 도움이 됩니다. 각각의 pull request는 핵심 기여자(pull request의 merge권한이 있는 누군가) 가 검토하게 됩니다. Pull reqeust 의 타입과 내용에 따라, 진행은 몇가지로 나뉠 수 있습니다: * 즉시 merge됨 * 적용 보류, 검토자가 변경 필요 (스타일링, 테스트 등) * 적용 보류, 논의가 필요함 (커뮤니티, 코어팀 등) * 거절

> **주의**: pull request를 보낸 대상 브랜치가 확실히 맞는지, 그리고 코드를 rebase 했는지 여부 등을 반드시 확인해 주세요. **master** 브랜치로의 pull request는 허용되지 않습니다
{:.alert .alert-danger}

## 문서

Zephir 프로그래밍이 쉽지 않으시다면, 그밖에도 기여할 수 있는 영역은 차고 넘칩니다. 문서의 오탈자나 문맥 오류는 언제나 잡아내실 수 있구요. 각 페이지 내에서 예시를 추가해서 문서를 향상시키는 것도 가능하지요.

[docs](https://crowdin.com/project/phalcon-documentation) 저장소로 가셔서, fork 하시고, 수정하신 다음 우리에게 pull request만 보내주시면 됩니다.

> **주의**: `docs` 저장소의 변경사항은 **오직** 영문 문서 (`en` 폴더) 만 가능하다는 사실을 명심해 주세요.
{:.alert .alert-warning}

## 번역

자신의 모국어로 문서를 번역하는 것으로 Phalcon에 기여하실 분들은, 우리의 친구 [Crowdin](https://crowdin.com) 사에서 제공하는 최상의 서비스를 사용하실 수 있습니다. 프로젝트는 [여기](https://crowdin.com/project/phalcon-documentation)에 있습니다. 리스트에 당신의 언어가 보이지 않는다면, 추가할 수 있도록 우리에게 메시지를 보내주세요.

## 질문과 지원

> **주의**: 우리는 Github에서 버그리포트, 새로운기능 요청 그리고 pull request만 받습니다. 프레임워크 사용에 대한 문의나 지원요청 등은 [공식 포럼](https://phalcon.io/forum) 이나 [Discord](https://phalcon.io/discord) 서버를 이용해 주세요.
{:.alert .alert-danger}

## 버그 리포트 체크리스트

- Github에 이슈를 생성하기 전에 현재 사용중이신 Phalcon의 버전이 최신버전인지 확인해 주세요.
- 최신 버전의 Phalcon에서 발견된 버그의 경우만 다루어집니다.
- 우리 코어팀에서 문제를 재현해 보고 다룰 수 있을 정도로 충분한 정보를 이슈를 생성하실 때 제공하실 수 있도록 편리한 템플릿을 제공합니다. 버그를 재현해 볼 수 있다면 문제의 원인을 찾고 고치는데에 엄청난 시간을 절약할 수 있습니다. 심지어 실패한 테스트의 스크립트도 저희에게는 큰 도움이 됩니다. 더 많은 정보를 알고 싶으시다면 [재현가능한 테스트](reproducible-tests) 페이지에서 확인하실 수 있습니다.
- OS, PHP 버전, Phalcon 버전, 웹서버, 메모리 등등의 추가정보도 리포트의 한 부분으로 추가해 주시기를 부탁드립니다.
- [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) 오류를 제출하시려는 경우, backtrace 로그가 필요합니다. 더 자세한 정보는 [Backtrace 생성](#generating-a-backtrace) 섹션을 참고하세요.

### Backtrace 생성

때로는 [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) 오류 때문에, Phalcon이 웹 서버 프로세스의 일부를 멈춰버리게 만들 수 있습니다. 이 segmentation fault 의 원인을 찾도록 도와주시려면, crash backtrace 를 보내주세요.

다음의 링크에서 backtrace 생성 방법에 대한 설명을 확인하실 수 있습니다:

- [gdb backtrace 생성](https://bugs.php.net/bugs-generating-backtrace.php)
- [Win32 환경의 컴파일러에서 backtrace 생성하기](https://bugs.php.net/bugs-generating-backtrace-win32.php)
- [심볼 디버그하기](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [PHP 빌드](http://www.phpinternalsbook.com/build_system/building_php.html)

## Pull Request 체크리스트

- `master` 브랜치로의 pull request는 허용되지 않습니다. 저장소를 fork 해서 필요한 예를 들어 `4.0.x` 같은 "소스" 브랜치에서 자신의 브랜치를 생성하세요. 필요하다면 pull request를 제출하기 전 브랜치를 rebase 하세요. 충돌이 일어난다면, 브랜치를 다시한번 rebase해달라고 요청드릴 것입니다.
- Pull request에 테스트를 추가하거나 기존에 있는 테스트를 적절하게 수정하세요. 이것은 당신의 pull request 가 합당한지 여부를 판단하는데 도움이 되므로 매우 중요합니다. 테스트 환경 설정방법과 테스트 작성 방법에 대해 더 자세히 알고 싶으시다면 [testing](testing-environment) 페이지를 참조하세요.
- Phalcon 은 [Zephir](https://zephir-lang.com) 로 작성되었으므로, C에서 생성한 파일을 직접 수정하는 커밋을 제출하지는 말아주시기 바랍니다.
- Phalcon은 특정한 코딩스타일을 따릅니다. 저장소에 같이 있는 `.editorconfig` 파일을 선호하는 IDE에 `editorconfig` 플러그인으로 설치하시면 코딩스탠다드에 대해 고민하지 않으셔도 됩니다. 모든 테스트(PHP 코드)는 [PSR-2](https://www.php-fig.org/psr/) 스탠다드를 따릅니다.
- Pull reqeust를 제출하기 전 `ext/kernel`, `*.zep.c` 그리고 `*.zep.h` 파일에 대한 수정사항이 있다면 제거해 주세요.
- 자세한 내용은 [여기에](new-pull-request).

**새로운 기능** 을 제출하시기 전, Github 에서 [NFR](new-feature-request) 을 새로운 이슈로 열어주세요. 해당 기능을 포함할 경우의 영향과 코어 익스텐션의 변경사항을 논의하기 위함입니다. 기능이 승인되면, PR이 다음을 포함하고 있는지 다시한번 확인해 주세요:

- `CHANGELOG.md`의 업데이트
- 단위 테스트
- 도움말 문서 혹은 사용 예제

## 지원 받기

Phalcon 사용방법에 대해 문의사항이 있으신 경우, [지원 페이지](http://phalcon.io/support)를 확인해 주세요.

## 기능 요청

무언가 변경사항이 있거나 새로운 기능에 대한 아이디어가 있으시다면, [NFR](new-feature-request) 서식을 채워주세요.

감사합니닷!

<3 Phalcon 팀