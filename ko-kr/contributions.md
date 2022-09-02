---
layout: default
language: 'ko-kr'
version: '4.0'
title: '기여하기'
keywords: 'contributing, nfr, pull request, pr, new feature request, 기여하기, 새로운 기능 요청'
---

# 공헌

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

# Phalcon에 기여하기

Phalcon은 오픈소스 프로젝트이며 자원봉사자들의 노력과 기여에 주로 의존하고 있습니다. 누구든 기여하실 분들은 대환영입니다!

기여 절차를 이해할 수 있도록 잠시 시간을 내어 문서를 검토하셔서 모두에게 가능한 효율적이 될수 있도록 해주세요. 다음의 가인드라인을 따라 주심으로써, 우리는 발생하는 문제들에 대한 더 빠른 해결과 더 나은 커뮤니케이션을 얻을 수 있게 되고, 다함께 프로젝트가 한발짝 더 나갈 수 있도록 할 수 있습니다!

Phalcon 소스코드 ( 문서, 웹사이트 등을 포함해서) 는 [GitHub](https://github.com) 에 저장되어 있습니다. [organization 페이지](https://github.com/phalcon)에서 모든 저장소를 둘러 보실 수 있습니다.

Phalcon에 기여하고 싶으시다면, [GitHub pull request](https://help.github.com/articles/using-pull-requests/) 를 생성해 주시면 됩니다.

Pull request 를 생성하실 때, pull request의 범위를 설명하는데 도움이 될 수 있는 간편한 템플릿을 준비해 뒀습니다. Pull request 에 대한 테스트를 추가해 주시는 것은 매우 중요하며 커뮤니티에게도 큰 도움이 됩니다. 각각의 pull request는 핵심 기여자(pull request의 merge권한이 있는 누군가) 가 검토하게 됩니다. Based on the type and content of the pull request, it could be:

- merged immediately or 
- put on hold, where the reviewer requires changes (styling, tests etc.)
- put on hold, if discussion is necessary (community, core team etc.)
- rejected

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

> **주의**: 우리는 Github에서 버그리포트, 새로운기능 요청 그리고 pull request만 받습니다. For questions regarding the usage of the framework or support requests please visit the [github discussions](https://github.com/phalcon/cphalcon/discussions) or our [Discord](https://phalcon.io/discord) server.
{:.alert .alert-danger}

## 버그 리포트 체크리스트

- Make sure you are using the latest released version of Phalcon before creating an issue in GitHub.
- Only bugs found in the latest released version of Phalcon will be addressed.
- We have a handy template when creating an issue to help you provide as much information for the core team to reproduce and address. Being able to reproduce a bug significantly reduces the time to find the cause and fix it. Scripts of even failing tests are more than appreciated. Please check how to create the [reproducible tests](reproducible-tests) page for more information.
- As part of your report, please include additional information such as the OS, PHP version, Phalcon version, web server, memory etc.
- If you're submitting a [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, we require a backtrace. Please check the [Generating a Backtrace](#generating-a-backtrace) section for more information.

### Backtrace 생성

때로는 [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) 오류 때문에, Phalcon이 웹 서버 프로세스의 일부를 멈춰버리게 만들 수 있습니다. 이 segmentation fault 의 원인을 찾도록 도와주시려면, crash backtrace 를 보내주세요.

다음의 링크에서 backtrace 생성 방법에 대한 설명을 확인하실 수 있습니다:

- [Generating a gdb backtrace](https://bugs.php.net/bugs-generating-backtrace.php)
- [Generating a backtrace, with a compiler, on Win32](https://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Debugging Symbols](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Building PHP](http://www.phpinternalsbook.com/build_system/building_php.html)

## Pull Request 체크리스트

- Pull requests to the `master` branch are not accepted. Please fork the repository and create your branch from the necessary "source" branch, for instance `4.0.x` and if need be rebase your branch before submitting your pull request. If there are collisions, we will ask you to rebase your branch again.
- Add tests to your pull request or adjust existing ones. This is very important since it helps justify your pull request. Please check our [testing](testing-environment) page for more information on how to set up a test environment and how to write tests.
- Since Phalcon is written in [Zephir](https://zephir-lang.com), please do not submit commits that modify the C generated files directly
- Phalcon follows a specific coding style. Please install the `editorconfig` plugin in your favorite IDE to take advantage of the supplied `.editorconfig` file that comes with this repository and not to have to worry about coding standards. All tests (PHP code), follow the [PSR-2](https://www.php-fig.org/psr/) standard
- Remove any change to `ext/kernel`, `*.zep.c` and `*.zep.h` files before submitting the pull request
- More information [here](new-pull-request).

**새로운 기능** 을 제출하시기 전, Github 에서 [NFR](new-feature-request) 을 새로운 이슈로 열어주세요. 해당 기능을 포함할 경우의 영향과 코어 익스텐션의 변경사항을 논의하기 위함입니다. 기능이 승인되면, PR이 다음을 포함하고 있는지 다시한번 확인해 주세요:

- An update to the `CHANGELOG.md`
- Unit Tests
- Documentation or Usage Examples

## 지원 받기

If you have any questions about how to use Phalcon, please see the [support page](https://phalcon.io/support).

## 기능 요청

무언가 변경사항이 있거나 새로운 기능에 대한 아이디어가 있으시다면, [NFR](new-feature-request) 서식을 채워주세요.

감사합니닷!

<3 Phalcon 팀
