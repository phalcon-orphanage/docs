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
          <a href="#bug-report-checklist">Контрольный список отчета об ошибках</a> <ul>
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

Phalcon является проектом с открытым кодом и сильно зависит от добровольных усилий. Мы приветствуем посильную помощь от всех!

Пожалуйста, уделите время на ознакомление с этим документом для того, чтобы сделать процесс вашего участия в развитии фреймворка легким и эффективным.

Следование этим принципам, позволит вам эффективней общаться с остальными участниками сообщества, быстрее решать проблемы и двигать проект вперед.

<a name='contributions'></a>

## Вклад

Вклад в Phalcon следует оформлять в виде [запроса на принятие изменений (Pull Request) на GitHub](https://help.github.com/articles/using-pull-requests/). Каждый такой запрос будет рассмотрен участником команды (кем-то с правом принимать запрос). В зависимости от типа и содержания запроса, он может быть принят сразу, отложен, если необходимы разъяснения, или отклонен.

Пожалуйста, убедитесь, что вы отправляете свой запрос на принятие изменений в соответствующую ветку, и что ваша ветка в актуальном состоянии.

<a name='questions-and-support'></a>

## Вопросы и поддержка

<h5 class='alert alert-warning'>We only accept bug reports, new feature requests and pull requests in GitHub. For questions regarding the usage of the framework or support requests please visit the <a href="https://phalcon.link/forum">official forums</a>.</h5>

<a name='bug-report-checklist'></a>

## Контрольный список отчета об ошибках

- Убедитесь, что вы используете последнюю стабильную версию Phalcon, перед отправкой отчёта об ошибке. Ошибки в предыдущих релизах не будут рассматриваться основной командой фреймворка.
- Если вы нашли ошибку, добавьте как можно больше связанной информации — любые детали, которые помогут нам воспроизвести её. Это очень важно. Воспроизводимые ошибки имеют наивысший шанс быть исправленными. Эта информация должна быть в виде скрипта, небольшого приложения или падающего теста. Для получения дополнительной информации, пожалуйста, ознакомьтесь с разделом [Отправка воспроизводимого теста](https://github.com/phalcon/cphalcon/wiki/Submit-Reproducible-Test).
- Пожалуйста, включите в ваш отчет дополнительную информацию, например ОС, версии PHP, Phalcon, веб-сервера, а так-же описание аппаратного обеспечения.
- Если вы отправляете отчет об ошибке типа [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault), нам будет необходима трассировка. Пожалуйста, ознакомьтесь с разделом [Генерация трассировки](#bug-report-generating-backtrace) для получения дополнительной информации.

<a name='bug-report-generating-backtrace'></a>

### Генерация трассировки

Иногда, из-за ошибки [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault), Phalcon может аварийно завершить работу. Пожалуйста, помогите нам найти эту проблему, добавив трассировку аварийного завершения работы ваше сообщение об ошибке.

Пожалуйста, ознакомьтесь со следующим руководствами, в случае любых вопросов связанных с созданием трассировки:

- [Генерация gdb трассировки](https://bugs.php.net/bugs-generating-backtrace.php)
- [Генерация трассировки с использованием компилятора в Win32](http://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Отладочные символы](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Сборка PHP](http://www.phpinternalsbook.com/build_system/building_php.html)

<a name='pull-request-checklist'></a>

## Контрольный список запроса на принятие изменений

- Don't submit your pull requests to the `master` branch. Branch from the required branch and, if needed, rebase to the proper branch before submitting your pull request. If it doesn't merge cleanly with master you may be asked to rebase your changes
- Don't put submodule updates, `composer.lock`, etc in your pull request unless they are to merged commits
- Add tests relevant to the fixed bug or new feature. See our [testing guide](https://github.com/phalcon/cphalcon/blob/master/tests/README.md) for more information
- Phalcon is written in [Zephir](https://zephir-lang.com/), please do not submit commits that modify C generated files directly or those whose functionality/fixes are implemented in the C programming language
- Make sure that the PHP code you write fits with the general style and coding standards of the [Accepted PHP Standards](http://www.php-fig.org/psr/)
- Remove any change to `ext/kernel`, `*.zep.c` and `*.zep.h` files before submitting the pull request

Перед отправкой **запроса на внесение новой функциональности**, пожалуйста, [предложите свою идею](/[[language]]/[[version]]/new-feature-request) в форме тикета GitHub, чтобы обсудить последствия или изменения в ядре фреймворка. После утверждения, убедитесь, что ваш запрос на принятие изменений содержит следующее:

- Обновлённый файл `CHANGELOG.md`
- Модульные тесты
- Документацию и примеры использования

<a name='getting-support'></a>

## Получение поддержки

По вопросам использования Phalcon, пожалуйста, используйте [раздел поддержки](https://phalconphp.com/support) на нашем сайте.

<a name='requesting-features'></a>

## Предложение идей

Если вы хотели бы предложить изменения или новый функционал, пожалуйста, [оформите](/[[language]]/[[version]]/new-feature-request) соответствующим образом ваше предложение.

Спасибо!

<3 Команда Phalcon