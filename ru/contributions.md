<div class='article-menu'>
  <ul>
    <li>
      <a href="#contributing">Вклад в Phalcon</a> <ul>
        <li>
          <a href="#contributions">Вклад</a>
        </li>
        <li>
          <a href="#questions-and-support">Вопросы и ответы</a>
        </li>
        <li>
          <a href="#bug-report-checklist">Контрольный список отчета об ошибках</a> 
          <ul>
            <li>
              <a href="#bug-report-generating-backtrace">Генерация трассировки</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#pull-request-checklist">Контрольный список пулл реквеста</a>
        </li>
        <li>
          <a href="#getting-support">Получение поддержки</a>
        </li>
        <li>
          <a href="#requesting-features">Предложение идей</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='contributing'></a>

# Вклад в Phalcon

Phalcon является проектом с открытым кодом и сильно зависит от добровольных усилий. Мы приветствуем вклады от всех!.

Пожалуйста, уделите время на ознакомление с этим документом, чтобы сделать процесс вашего участия в развитии фреймворка легким и эффективным.

Следование этим принципам, позволит вам эффективней общаться с остальными участниками сообщества, быстрее решать проблемы и двигать проект вперед.

<a name='contributions'></a>

## Вклад

Вклад в Phalcon следует оформлять в виде [пулл запросов на GitHub](https://help.github.com/articles/using-pull-requests/). Каждый пулл запрос будет рассмотрен основным контрибьютером (кем-то с разрешениями на объединение пулл запросов). В зависимости от типа и содержания пулл запроса, он может быть принят сразу, отложен, если необходимы разъяснения, или отклонен.

Пожалуйста, убедитесь, что вы отправляете свой пулл запрос в корректную ветку, и что ваша ветка в актуальном состоянии.

<a name='questions-and-support'></a>

## Вопросы и поддержка

<div class="alert alert-warning">
    <p>
       We only accept bug reports, new feature requests and pull requests in GitHub. For questions regarding the usage of the framework or support requests please visit the <a href="https://phalcon.link/forum">official forums</a>.
    </p>
</div>

<a name='bug-report-checklist'></a>

## Контрольный список отчета об ошибках

- Make sure you are using the latest released version of Phalcon before submitting a bug report. Bugs in versions older than the latest released one will not be addressed by the core team.
- If you have found a bug, it is essential to add relevant information to reproduce it. Being able to reproduce a bug greatly reduces the time to investigate and fix it. This information should come in the form of a script, small application, or even a failing test. Please check [Submit Reproducible Test](https://github.com/phalcon/cphalcon/wiki/Submit-Reproducible-Test) for more information.
- As part of your report, please include additional information such as the OS, PHP version, Phalcon version, web server, memory etc.
- If you're submitting a [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, we would require a backtrace. Please check [Generating a Backtrace](#bug-report-generating-backtrace) for more information.

<a name='bug-report-generating-backtrace'></a>

### Генерация трассировки

Sometimes due to [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, Phalcon could crash some of your web server processes. Please help us to find out the problem by adding a crash backtrace to your bug report.

Please follow this guides to understand how to generate the backtrace:

- [Generating a gdb backtrace](https://bugs.php.net/bugs-generating-backtrace.php)
- [Generating a backtrace, with a compiler, on Win32](http://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Debugging Symbols](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Building PHP](http://www.phpinternalsbook.com/build_system/building_php.html)

<a name='pull-request-checklist'></a>

## Контрольный список пулл реквеста

- Don't submit your pull requests to the `master` branch. Branch from the required branch and, if needed, rebase to the proper branch before submitting your pull request. If it doesn't merge cleanly with master you may be asked to rebase your changes
- Don't put submodule updates, `composer.lock`, etc in your pull request unless they are to merged commits
- Add tests relevant to the fixed bug or new feature. See our [testing guide](https://github.com/phalcon/cphalcon/blob/master/tests/README.md) for more information
- Phalcon is written in [Zephir](https://zephir-lang.com/), please do not submit commits that modify C generated files directly or those whose functionality/fixes are implemented in the C programming language
- Make sure that the PHP code you write fits with the general style and coding standards of the [Accepted PHP Standards](http://www.php-fig.org/psr/)
- Remove any change to `ext/kernel`, `*.zep.c` and `*.zep.h` files before submitting the pull request

Before submit **new functionality**, please open a [NFR](/[[language]]/[[version]]/new-feature-request) as a new issue on GitHub to discuss the impact of include the functionality or changes in the core extension. Once the functionality is approved, make sure your PR contains the following:

- An update to the `CHANGELOG.md`
- Unit Tests
- Documentation or Usage Examples

<a name='getting-support'></a>

## Получение поддержки

If you have a question about how to use Phalcon, please see the [support page](https://phalconphp.com/support).

<a name='requesting-features'></a>

## Предложение идей

If you have a change or new feature in mind, please fill an [NFR](/[[language]]/[[version]]/new-feature-request).

Thanks!

<3 Phalcon Team