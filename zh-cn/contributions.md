* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='contributing'></a>

# 为 Phalcon 作出贡献

Phalcon is an open source project and heavily relies on volunteer efforts. We welcome contributions from everyone!

Please take a moment to review this document in order to make the contribution process easy and effective for all.

Following these guidelines, allows better communication, faster resolution of issues and moves the project forward.

<a name='contributions'></a>

## 贡献者

Contributions to Phalcon should be made in the form of [GitHub pull requests](https://help.github.com/articles/using-pull-requests/). Each pull request will be reviewed by a core contributor (someone with permission to merge pull requests). Based on the type and content of the pull request, it can either be merged immediately, put on hold if clarifications are needed, or rejected.

Please ensure that you are sending your pull request to the correct branch and that you already have rebased your code.

<a name='questions-and-support'></a>

## 问题和支持

<h5 class='alert alert-warning'>We only accept bug reports, new feature requests and pull requests in GitHub. For questions regarding the usage of the framework or support requests please visit the <a href='https://phalcon.link/forum'>official forum</a>.</h5>

<a name='bug-report-checklist'></a>

## Bug 报告清单

- Make sure you are using the latest released version of Phalcon before submitting a bug report. Bugs in versions older than the latest released one will not be addressed by the core team.
- 如果你找到了一个 bug，就必须添加相关的信息，以重现它。 能够重现 bug，大大减少了时间，调查并解决它。 这个信息应该进来的脚本、 小应用程序或甚至是一个失败的测试形式。 请检查 [提交的可重复的测试](https://github.com/phalcon/cphalcon/wiki/Submit-Reproducible-Test) 的详细信息。
- 作为你的报告的一部分，请包括额外的信息，如操作系统，PHP 版本、 Phalcon版本、 web 服务器、 内存等。
- 如果您正在提交一个 [分割故障](https://en.wikipedia.org/wiki/Segmentation_fault) 错误，我们将需要回溯跟踪。 请有关详细信息，检查 [生成回溯跟踪](#bug-report-generating-backtrace)。

<a name='bug-report-generating-backtrace'></a>

### 生成回溯跟踪

Sometimes due to [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, Phalcon could crash some of your web server processes. Please help us to find out the problem by adding a crash backtrace to your bug report.

Please follow this guides to understand how to generate the backtrace:

- [生成 gdb 回溯](https://bugs.php.net/bugs-generating-backtrace.php)
- [使用编译器在 Win32 上生成回溯](https://bugs.php.net/bugs-generating-backtrace-win32.php)
- [调试符号](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [构建PHP](https://www.phpinternalsbook.com/build_system/building_php.html)

<a name='pull-request-checklist'></a>

## 拉请求清单

- 不要将您的 pull 请求提交给 `master` 分支。 Branch from the required branch and, if needed, rebase to the proper branch before submitting your pull request. 如果它不能和 master 分支合并，你可能会被要求改变你的改变
- 除非要合并提交，否则不要将子模块更新，`composer.lock` 等放在您的 pull 请求中
- Add tests relevant to the fixed bug or new feature. See our [testing guide](https://github.com/phalcon/cphalcon/blob/master/tests/README.md) for more information
- Phalcon 是在 [Zephir](https://zephir-lang.com/) 中编写的，请不要提交修改 C 生成的文件，或者是使用 C 语言实现其功能/修复的提交
- Make sure that the PHP code you write fits with the general style and coding standards of the [Accepted PHP Standards](https://www.php-fig.org/psr/)
- 在提交 Pull 请求之前，删除对 `ext/kernel`, `*.zep.c` 和 `*.zep.h` 文件的任何更改

Before submit **new functionality**, please open a [NFR](/4.0/en/new-feature-request) as a new issue on GitHub to discuss the impact of including the functionality or changes in the core extension. Once the functionality is approved, make sure your PR contains the following:

- 对 `CHANGELOG.md` 的更新
- 单元测试
- 文档或使用示例

<a name='getting-support'></a>

## 获得支持

If you have any questions about how to use Phalcon, please see the [support page](https://phalconphp.com/support).

<a name='requesting-features'></a>

## 请求的功能

If you have any changes or new features in mind, please fill an [NFR](/4.0/en/new-feature-request).

Thanks!

<3 Phalcon Team