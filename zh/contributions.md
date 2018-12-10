<div class='article-menu'>
  <ul>
    <li>
      <a href="#contributing">为 Phalcon 作出贡献</a> <ul>
        <li>
          <a href="#contributions">贡献者</a>
        </li>
        <li>
          <a href="#questions-and-support">问题和支持</a>
        </li>
        <li>
          <a href="#bug-report-checklist">Bug 报告清单</a> <ul>
            <li>
              <a href="#bug-report-generating-backtrace">生成回溯跟踪</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#pull-request-checklist">拉请求清单</a>
        </li>
        <li>
          <a href="#getting-support">获得支持</a>
        </li>
        <li>
          <a href="#requesting-features">请求的功能</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='contributing'></a>

# 为 Phalcon 作出贡献

Phalcon is an open source project and heavily relies on volunteer efforts. We welcome contributions from everyone!.

Please take a moment to review this document in order to make the contribution process easy and effective all.

遵循这些准则，允许更好的交流，更快地解决问题和向前移动该项目。

<a name='contributions'></a>

## 贡献

Phalcon的贡献应该在 [GitHub pr](https://help.github.com/articles/using-pull-requests/) 的形式。 Each pull request will be reviewed by a core contributor (someone with permission to merge pull requests). Based on the type and content of the pull request, it can either be merged immediately, put on hold if clarifications are needed, or rejected.

Please ensure that you are sending your pull request to the correct branch and that you already have rebased your code.

<a name='questions-and-support'></a>

## 问题和支持

<h5 class='alert alert-warning'>We only accept bug reports, new feature requests and pull requests in GitHub. 至于使用的框架或支持请求的问题请访问 <a href="https://phalcon.link/forum">官方的论坛</a>。</h5>

<a name='bug-report-checklist'></a>

## Bug 报告清单

- Make sure you are using the latest released version of Phalcon before submitting a bug report. Bugs in versions older than the latest released one will not be addressed by the core team.
- 如果你找到了一个 bug，就必须添加相关的信息，以重现它。 能够重现 bug，大大减少了时间，调查并解决它。 这个信息应该进来的脚本、 小应用程序或甚至是一个失败的测试形式。 请检查 [提交的可重复的测试](https://github.com/phalcon/cphalcon/wiki/Submit-Reproducible-Test) 的详细信息。
- 作为你的报告的一部分，请包括额外的信息，如操作系统，PHP 版本、 Phalcon版本、 web 服务器、 内存等。
- 如果您正在提交一个 [分割故障](https://en.wikipedia.org/wiki/Segmentation_fault) 错误，我们将需要回溯跟踪。 请有关详细信息，检查 [生成回溯跟踪](#bug-report-generating-backtrace)。

<a name='bug-report-generating-backtrace'></a>

### 生成回溯跟踪

有时由于 [分段故障](https://en.wikipedia.org/wiki/Segmentation_fault) 错误，Phalcon 能会使您的一些 Web 服务器进程崩溃。 请通过在错误报告中添加崩溃回溯来帮助我们找出问题所在。

请按照本指南了解如何生成回溯跟踪：

- [生成 gdb 回溯](https://bugs.php.net/bugs-generating-backtrace.php)
- [使用编译器在 Win32 上生成回溯](http://bugs.php.net/bugs-generating-backtrace-win32.php)
- [调试符号](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [构建PHP](http://www.phpinternalsbook.com/build_system/building_php.html)

<a name='pull-request-checklist'></a>

## Pull Request Checklist

- 不要将您的 pull 请求提交给 `master` 分支。 Branch from the required branch and, if needed, rebase to the proper branch before submitting your pull request. 如果它不能和 master 分支合并，你可能会被要求改变你的改变
- 除非要合并提交，否则不要将子模块更新，`composer.lock` 等放在您的 pull 请求中
- Add tests relevant to the fixed bug or new feature. See our [testing guide](https://github.com/phalcon/cphalcon/blob/master/tests/README.md) for more information
- Phalcon 是在 [Zephir](https://zephir-lang.com/) 中编写的，请不要提交修改 C 生成的文件，或者是使用 C 语言实现其功能/修复的提交
- 请确保您编写的 PHP 代码符合 [公认的PHP标准](http://www.php-fig.org/psr/) 的一般风格和编码标准
- 在提交 Pull 请求之前，删除对 `ext/kernel`, `*.zep.c` 和 `*.zep.h` 文件的任何更改

Before submit **new functionality**, please open a [NFR](/[[language]]/[[version]]/new-feature-request) as a new issue on GitHub to discuss the impact of include the functionality or changes in the core extension. 一旦功能被批准，请确保您的 PR 包含以下内容:

- 对 `CHANGELOG.md` 的更新
- 单元测试
- 文档或使用示例

<a name='getting-support'></a>

## 获得支持

If you have a question about how to use Phalcon, please see the [support page](https://phalconphp.com/support).

<a name='requesting-features'></a>

## 请求功能

If you have a change or new feature in mind, please fill an [NFR](/[[language]]/[[version]]/new-feature-request).

谢谢！

<3 Phalcon Team