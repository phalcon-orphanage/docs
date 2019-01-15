* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='contributing'></a>

# Вклад в Phalcon

Phalcon is an open source project and heavily relies on volunteer efforts. We welcome contributions from everyone!

Please take a moment to review this document in order to make the contribution process easy and effective for all.

Following these guidelines, allows better communication, faster resolution of issues and moves the project forward.

<a name='contributions'></a>

## Вклад

Contributions to Phalcon should be made in the form of [GitHub pull requests](https://help.github.com/articles/using-pull-requests/). Each pull request will be reviewed by a core contributor (someone with permission to merge pull requests). Based on the type and content of the pull request, it can either be merged immediately, put on hold if clarifications are needed, or rejected.

Please ensure that you are sending your pull request to the correct branch and that you already have rebased your code.

<a name='questions-and-support'></a>

## Вопросы и ответы

<h5 class='alert alert-warning'>We only accept bug reports, new feature requests and pull requests in GitHub. For questions regarding the usage of the framework or support requests please visit the <a href='https://phalcon.link/forum'>official forum</a>.</h5>

<a name='bug-report-checklist'></a>

## Контрольный список отчета об ошибках

- Убедитесь, что вы используете последнюю стабильную версию Phalcon, перед отправкой отчёта об ошибке. Ошибки в предыдущих релизах не будут рассматриваться основной командой фреймворка.
- Если вы нашли ошибку, добавьте как можно больше связанной информации — любые детали, которые помогут нам воспроизвести её. Это очень важно. Воспроизводимые ошибки имеют наивысший шанс быть исправленными. Эта информация должна быть в виде скрипта, небольшого приложения или падающего теста. Для получения дополнительной информации, пожалуйста, ознакомьтесь с разделом [Отправка воспроизводимого теста](https://github.com/phalcon/cphalcon/wiki/Submit-Reproducible-Test).
- Пожалуйста, включите в ваш отчет дополнительную информацию, например ОС, версии PHP, Phalcon, веб-сервера, а так-же описание аппаратного обеспечения.
- Если вы отправляете отчет об ошибке типа [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault), нам будет необходима трассировка. Пожалуйста, ознакомьтесь с разделом [Генерация трассировки](#bug-report-generating-backtrace) для получения дополнительной информации.

<a name='bug-report-generating-backtrace'></a>

### Генерация трассировки

Sometimes due to [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, Phalcon could crash some of your web server processes. Please help us to find out the problem by adding a crash backtrace to your bug report.

Please follow this guides to understand how to generate the backtrace:

- [Генерация gdb трассировки](https://bugs.php.net/bugs-generating-backtrace.php)
- [Генерация трассировки с использованием компилятора в Win32](https://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Отладочные символы](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Сборка PHP](https://www.phpinternalsbook.com/build_system/building_php.html)

<a name='pull-request-checklist'></a>

## Контрольный список пулл реквеста

- Не отправляйте запросы на принятие изменений в `master` ветку. Перед отправкой запроса, сделайте ответвление из необходимой для изменений ветки и при необходимости сделайте перемещение (rebase) с соответствующей веткой. Если ваши изменения не возможно будет слить (merge) без конфликтов, вам будет предложено сделать перемещение (rebase).
- Не отправляйте обновления подмодулей, файла `composer.lock` и т.д.
- Ваш запрос на принятие изменений должен быть покрыт тестом. Дя более подробной информацией обратитесь к разделу [Руководство по тестированию](https://github.com/phalcon/cphalcon/blob/master/tests/README.md).
- Phalcon написан на языке [Zephir](https://zephir-lang.com/). Пожалуйста, не отправляйте коммиты с изменениями C-файлов.
- Make sure that the PHP code you write fits with the general style and coding standards of the [Accepted PHP Standards](https://www.php-fig.org/psr/)
- Удалите любые изменения `ext/kernel`, `*.zep.c` и `*.zep.h` файлов перед отправкой запроса на изменение.

Before submit **new functionality**, please open a [NFR](/4.0/en/new-feature-request) as a new issue on GitHub to discuss the impact of including the functionality or changes in the core extension. Once the functionality is approved, make sure your PR contains the following:

- Обновлённый файл `CHANGELOG.md`
- Модульные тесты
- Документацию и примеры использования

<a name='getting-support'></a>

## Получение поддержки

If you have any questions about how to use Phalcon, please see the [support page](https://phalconphp.com/support).

<a name='requesting-features'></a>

## Предложение идей

If you have any changes or new features in mind, please fill an [NFR](/4.0/en/new-feature-request).

Thanks!

<3 Phalcon Team