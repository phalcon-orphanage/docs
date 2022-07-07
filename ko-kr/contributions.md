---
layout: default
language: 'ko-kr'
version: '5.0'
title: '기여하기'
keywords: 'contributing, nfr, pull request, pr, new feature request, 기여하기, 새로운 기능 요청'
---

# 기여하기
- - -
![](/assets/images/document-status-under-review-red.svg) ![](/assets/images/version-{{ page.version }}.svg)

# Phalcon에 기여하기
Phalcon은 오픈소스 프로젝트이며 자원봉사자들의 노력과 기여에 주로 의존하고 있습니다. 누구든 기여하실 분들은 대환영입니다!

기여 절차를 이해할 수 있도록 잠시 시간을 내어 문서를 검토하셔서 모두에게 가능한 효율적이 될수 있도록 해주세요. 다음의 가인드라인을 따라 주심으로써, 우리는 발생하는 문제들에 대한 더 빠른 해결과 더 나은 커뮤니케이션을 얻을 수 있게 되고, 다함께 프로젝트가 한발짝 더 나갈 수 있도록 할 수 있습니다!

The Phalcon source code (along with documentation, websites etc.) is stored in [GitHub][github]. You can browse our repositories in our [organization page][phalcon-org].

If you wish to contribute to Phalcon, you can do so by issuing a [GitHub pull request][github-pr].

Pull request 를 생성하실 때, pull request의 범위를 설명하는데 도움이 될 수 있는 간편한 템플릿을 준비해 뒀습니다. Pull request 에 대한 테스트를 추가해 주시는 것은 매우 중요하며 커뮤니티에게도 큰 도움이 됩니다. 각각의 pull request는 핵심 기여자(pull request의 merge권한이 있는 누군가) 가 검토하게 됩니다. Based on the type and content of the pull request, it could be:

* merged immediately or
* put on hold, where the reviewer requires changes (styling, tests etc.)
* put on hold, if discussion is necessary (community, core team etc.)
* rejected

> **NOTE**: Please make sure that the target branch that you send your pull request is correct and that you have already rebased your code. Pull requests to the **master** branch are not allowed 
> 
> {:.alert .alert-danger}

## 문서
Zephir 프로그래밍이 쉽지 않으시다면, 그밖에도 기여할 수 있는 영역은 차고 넘칩니다. 문서의 오탈자나 문맥 오류는 언제나 잡아내실 수 있구요. 각 페이지 내에서 예시를 추가해서 문서를 향상시키는 것도 가능하지요.

All you have to do is go to our [docs][phalcon-docs] repository, fork it, make the changes and send us a pull request.

> **NOTE**: Note that changes to the `docs` repository are allowed **only** to the English documents (`en` folder). 
> 
> {:.alert .alert-warning}

## 번역
If you wish to contribute to Phalcon by translating our documents in your native tongue, you can utilize the excellent service of our friends at [Crowdin][crowdin]. Our project is located [here][phalcon-docs]. 리스트에 당신의 언어가 보이지 않는다면, 추가할 수 있도록 우리에게 메시지를 보내주세요.

## 질문과 지원

> **NOTE**: We only accept bug reports, new feature requests and pull requests in GitHub. For questions regarding the usage of the framework or support requests please visit the [official forum][phalcon-forum] or our [Discord][phalcon-discord] server. 
> 
> {:.alert .alert-danger}

## 버그 리포트 체크리스트
- Make sure you are using the latest released version of Phalcon before creating an issue in GitHub.
- Only bugs found in the latest released version of Phalcon will be addressed.
- We have a handy template when creating an issue to help you provide as much information for the core team to reproduce and address. Being able to reproduce a bug significantly reduces the time to find the cause and fix it. Scripts of even failing tests are more than appreciated. Please check how to create the [reproducible tests][tests] page for more information.
- As part of your report, please include additional information such as the OS, PHP version, Phalcon version, web server, memory etc.
- If you're submitting a [Segmentation Fault][segfault] error, we require a backtrace. Please check the [Generating a Backtrace](#generating-a-backtrace) section for more information.

### Backtrace 생성
Sometimes due to [Segmentation Fault][segfault] error, Phalcon could crash some of your web server processes. 이 segmentation fault 의 원인을 찾도록 도와주시려면, crash backtrace 를 보내주세요.

다음의 링크에서 backtrace 생성 방법에 대한 설명을 확인하실 수 있습니다:

* [Generating a gdb backtrace][gdb]
* [Generating a backtrace, with a compiler, on Win32][gdb-w32]
* [Debugging Symbols][symbols]
* [Building PHP][building-php]

## Pull Request 체크리스트
- Pull requests to the `master` branch are not accepted. Please fork the repository and create your branch from the necessary "source" branch, for instance `4.0.x` and if need be rebase your branch before submitting your pull request. If there are collisions, we will ask you to rebase your branch again.
- Add tests to your pull request or adjust existing ones. This is very important since it helps justify your pull request. Please check our [testing][env] page for more information on how to set up a test environment and how to write tests.
- Since Phalcon is written in [Zephir][zephir], please do not submit commits that modify the C generated files directly
- Phalcon follows a specific coding style. Please install the `editorconfig` plugin in your favorite IDE to take advantage of the supplied `.editorconfig` file that comes with this repository and not to have to worry about coding standards. All tests (PHP code), follow the [PSR-2][psr-2] standard
- Remove any change to `ext/kernel`, `*.zep.c` and `*.zep.h` files before submitting the pull request
- More information [here][pr].

Before submitting **new functionality**, please open a [NFR][nfr] as a new issue on GitHub to discuss the impact of including the functionality or changes in the core extension. 기능이 승인되면, PR이 다음을 포함하고 있는지 다시한번 확인해 주세요:

- An update to the `CHANGELOG.md`
- Unit Tests
- Documentation or Usage Examples

## 지원 받기
If you have any questions about how to use Phalcon, please see the [support page][support].

## 기능 요청
If you have any changes or new features in mind, please fill an [NFR][nfr].

감사합니닷!


<3 Phalcon Team

[github]: https://github.com
[phalcon-org]: https://github.com/phalcon
[github-pr]: https://help.github.com/articles/using-pull-requests/
[phalcon-docs]: https://crowdin.com/project/phalcon-documentation
[phalcon-docs]: https://crowdin.com/project/phalcon-documentation
[crowdin]: https://crowdin.com
[phalcon-forum]: https://phalcon.io/forum
[phalcon-discord]: https://phalcon.io/discord
[tests]: reproducible-tests
[segfault]: https://en.wikipedia.org/wiki/Segmentation_fault
[gdb]: https://bugs.php.net/bugs-generating-backtrace.php
[gdb-w32]: https://bugs.php.net/bugs-generating-backtrace-win32.php
[symbols]: https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols
[building-php]: http://www.phpinternalsbook.com/build_system/building_php.html
[env]: testing-environment
[zephir]: https://zephir-lang.com
[psr-2]: https://www.php-fig.org/psr/
[pr]: new-pull-request
[nfr]: new-feature-request
[support]: https://phalcon.io/support
