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
          <a href="#bug-report-checklist">Bug 报告清单</a> 
          <ul>
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

Phalcon是一个开源项目，非常依赖志愿者的努力。 我们欢迎大家的贡献!

请花一点时间来审查这份文件做出贡献过程简便而有效的所有。

遵循这些准则，允许更好的交流，更快地解决问题和向前移动该项目。

<a name='contributions'></a>

## 贡献

Phalcon的贡献应该在 [GitHub pr](https://help.github.com/articles/using-pull-requests/) 的形式。 每个合并请求将由核心贡献者（具有合并请求权限的人员）进行审阅。 根据合并请求的类型和内容，可以立即合并，如果需要澄清，则搁置或拒绝。

请确保将合并请求发送到正确的分支，并且已经重新变基代码。

<a name='questions-and-support'></a>

## 问题和支持

<div class="alert alert-warning">
    <p>
       我们只接受 bug 报告、 新的功能要求和在 GitHub 的合并请求。 至于使用的框架或支持请求的问题请访问 <a href="https://phalcon.link/forum">官方的论坛</a>。
    </p>
</div>

<a name='bug-report-checklist'></a>

## Bug 报告清单

- 在提交bug报告之前，请确保您使用的是最新发布的Phalcon版本。 核心团队不会解决比最新发布版本更老的版本中的bug。
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

## 合并请求清单

- 不要将您的合并请求提交给 `master` 分支。 从所需的分支中分支，如果需要，在提交你的合并请求之前，把它分配给正确的分支。 如果它不能和 master 分支合并，你可能会被要求改变你的改变
- 除非要合并提交，否则不要将子模块更新，`composer.lock` 等放在您的 pull 请求中
- 添加与修复bug或新特性相关的测试。 有关更多信息，请参阅我们的[测试指南](https://github.com/phalcon/cphalcon/blob/master/tests/README.md)
- Phalcon 是在 [Zephir](https://zephir-lang.com/) 中编写的，请不要提交修改 C 生成的文件，或者是使用 C 语言实现其功能/修复的提交
- 请确保您编写的 PHP 代码符合 [公认的PHP标准](http://www.php-fig.org/psr/) 的一般风格和编码标准
- 在提交 Pull 请求之前，删除对 `ext/kernel`, `*.zep.c` 和 `*.zep.h` 文件的任何更改

在提交 **新功能 ** 之前，请在 GitHub 上打开一个 [NFR](/[[language]]/[[version]]/new-feature-request) 作为新问题，讨论包含功能或核心扩展的更改的影响。 一旦功能被批准，请确保您的 PR 包含以下内容:

- 对 `CHANGELOG.md` 的更新
- 单元测试
- 文档或使用示例

<a name='getting-support'></a>

## 获得支持

如果你有一个关于如何使用Phalcon的问题，请参见 [支持页面](https://phalconphp.com/support)。

<a name='requesting-features'></a>

## 请求功能

如果你有一个改变或新的特性，请填写一个 [NFR](/[[language]]/[[version]]/new-feature-request)。

谢谢！

&lt;3 Phalcon Team