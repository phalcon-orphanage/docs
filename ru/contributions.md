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

Phalcon is an open source project and heavily relies on volunteer efforts. We welcome contributions from everyone!

Please take a moment to review this document in order to make the contribution process easy and effective for all.

Следование этим принципам, позволит вам эффективней общаться с остальными участниками сообщества, быстрее решать проблемы и двигать проект вперед.

<a name='contributions'></a>

## Вклад

Вклад в Phalcon следует оформлять в виде [запроса на принятие изменений (Pull Request) на GitHub](https://help.github.com/articles/using-pull-requests/). Каждый такой запрос будет рассмотрен участником команды (кем-то с правом принимать запрос). В зависимости от типа и содержания запроса, он может быть принят сразу, отложен, если необходимы разъяснения, или отклонен.

Пожалуйста, убедитесь, что вы отправляете свой запрос на принятие изменений в соответствующую ветку, и что ваша ветка в актуальном состоянии.

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

- Не отправляйте запросы на принятие изменений в `master` ветку. Перед отправкой запроса, сделайте ответвление из необходимой для изменений ветки и при необходимости сделайте перемещение (rebase) с соответствующей веткой. Если ваши изменения не возможно будет слить (merge) без конфликтов, вам будет предложено сделать перемещение (rebase).
- Не отправляйте обновления подмодулей, файла `composer.lock` и т.д.
- Add tests relevant to the fixed bug or new feature. See our [testing guide](https://github.com/phalcon/cphalcon/blob/master/tests/README.md) for more information
- Phalcon написан на языке [Zephir](https://zephir-lang.com/). Пожалуйста, не отправляйте коммиты с изменениями C-файлов.
- Убедитесь, что PHP-код, который вы написали, соответствует общему стилю и стандартам кодирования [PSR](http://www.php-fig.org/psr/).
- Удалите любые изменения `ext/kernel`, `*.zep.c` и `*.zep.h` файлов перед отправкой запроса на изменение.

Before submit **new functionality**, please open a [NFR](/[[language]]/[[version]]/new-feature-request) as a new issue on GitHub to discuss the impact of including the functionality or changes in the core extension. После утверждения, убедитесь, что ваш запрос на принятие изменений содержит следующее:

- Обновлённый файл `CHANGELOG.md`
- Модульные тесты
- Документацию и примеры использования

<a name='getting-support'></a>

## Получение поддержки

If you have any questions about how to use Phalcon, please see the [support page](https://phalconphp.com/support).

<a name='requesting-features'></a>

## Предложение идей

If you have any changes or new features in mind, please fill an [NFR](/[[language]]/[[version]]/new-feature-request).

Спасибо!

&lt;3 Команда Phalcon