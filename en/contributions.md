---
layout: article
language: 'en'
version: '4.0'
---
##### This article reflects v3.4 and has not yet been revised
{:.alert .alert-danger}

<a name='contributing'></a>
# Contributing to Phalcon
Phalcon is an open source project and heavily relies on volunteer efforts. We welcome contributions from everyone!

Please take a moment to review this document in order to make the contribution process easy and effective for all.

Following these guidelines, allows better communication, faster resolution of issues and moves the project forward.

<a name='contributions'></a>
## Contributions
Contributions to Phalcon should be made in the form of [GitHub pull requests][ghpr]. Each pull request will be reviewed by a core contributor (someone with permission to merge pull requests). Based on the type and content of the pull request, it can either be merged immediately, put on hold if clarifications are needed, or rejected.

Please ensure that you are sending your pull request to the correct branch and that you already have rebased your code.

<a name='questions-and-support'></a>
## Questions and Support

<h5 class='alert alert-warning'>We only accept bug reports, new feature requests and pull requests in GitHub. For questions regarding the usage of the framework or support requests please visit the <a href='https://phalcon.link/forum'>official forum</a>.</h5>

<a name='bug-report-checklist'></a>
## Bug Report Checklist
- Make sure you are using the latest released version of Phalcon before submitting a bug report. Bugs in versions older than the latest released one will not be addressed by the core team.
- If you have found a bug, it is essential to add relevant information to reproduce it. Being able to reproduce a bug greatly reduces the time to investigate and fix it. This information should come in the form of a script, small application, or even a failing test. Please check [Submit Reproducible Test][srt] for more information.
- As part of your report, please include additional information such as the OS, PHP version, Phalcon version, web server, memory etc.
- If you're submitting a [Segmentation Fault][segfault] error, we would require a backtrace. Please check [Generating a Backtrace](#bug-report-generating-backtrace) for more information.

<a name='bug-report-generating-backtrace'></a>
### Generating a backtrace
Sometimes due to [Segmentation Fault][segfault] error, Phalcon could crash some of your web server processes. Please help us to find out the problem by adding a crash backtrace to your bug report.

Please follow this guides to understand how to generate the backtrace:

* [Generating a gdb backtrace][gdb-howto]
* [Generating a backtrace, with a compiler, on Win32][gdb-howto-w32]
* [Debugging Symbols][gdb-dbgsym]
* [Building PHP][internals-build-php]

<a name='pull-request-checklist'></a>
## Pull Request Checklist
- Don't submit your pull requests to the `master` branch. Branch from the required branch and, if needed, rebase to the proper branch before submitting your pull request. If it doesn't merge cleanly with master you may be asked to rebase your changes
- Don't put submodule updates, `composer.lock`, etc in your pull request unless they are to merged commits
- Add tests relevant to the fixed bug or new feature. See our [testing guide][testing] for more information
- Phalcon is written in [Zephir][zephir], please do not submit commits that modify C generated files directly or those whose functionality/fixes are implemented in the C programming language
- Make sure that the PHP code you write fits with the general style and coding standards of the [Accepted PHP Standards][psr]
- Remove any change to `ext/kernel`, `*.zep.c` and `*.zep.h` files before submitting the pull request

Before submit **new functionality**, please open a [NFR](/4.0/en/new-feature-request) as a new issue on GitHub to discuss the impact of including the functionality or changes in the core extension. Once the functionality is approved, make sure your PR contains the following:

- An update to the `CHANGELOG.md`
- Unit Tests
- Documentation or Usage Examples

<a name='getting-support'></a>
## Getting Support
If you have any questions about how to use Phalcon, please see the [support page][support].

<a name='requesting-features'></a>
## Requesting Features
If you have any changes or new features in mind, please fill an [NFR](/4.0/en/new-feature-request).

Thanks!


&lt;3 Phalcon Team

[ghpr]: https://help.github.com/articles/using-pull-requests/
[forum]: https://phalcon.link/forum
[srt]: https://github.com/phalcon/cphalcon/wiki/Submit-Reproducible-Test
[segfault]: https://en.wikipedia.org/wiki/Segmentation_fault
[gdb-howto]: https://bugs.php.net/bugs-generating-backtrace.php
[gdb-howto-w32]: https://bugs.php.net/bugs-generating-backtrace-win32.php
[gdb-dbgsym]: https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols
[internals-build-php]: https://www.phpinternalsbook.com/build_system/building_php.html
[testing]: https://github.com/phalcon/cphalcon/blob/master/tests/README.md
[zephir]: https://zephir-lang.com/
[psr]: https://www.php-fig.org/psr/
[support]: https://phalconphp.com/support
[nfr]: /4.0/en/new-feature-request

