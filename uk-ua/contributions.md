---
layout: default
title: 'Участь у розвитку'
keywords: 'contributing, nfr, pull request, pr, new feature request, участь у розвитку фреймворка, звф, вдосконалення функціоналу'
---

# Участь у розвитку фреймворка
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

# Участь у розвитку Phalcon
Phalcon - проект з відкритим вихідним кодом, який значною мірою залежить від зусиль добровольців та пожертв. Ми будемо вдячні за будь-яку допомогу у розвитку фреймворка!

Будь ласка, виділіть кілька хвилин, щоб переглянути цей документ, зрозуміти процес участі у розвитку і зробити його максимально ефективним для всіх. By following these guidelines, we can have faster resolution of issues, better communication, and we can all move the project forward!

The Phalcon source code (along with documentation, websites etc.) is stored in [GitHub][github]. You can browse our repositories in our [organization page][phalcon-org].

If you wish to contribute to Phalcon, you can do so by issuing a [GitHub pull request][github-pr].

Щоб допомогти вам створити запит на вдосконалення функціоналу і описати пропозицію, ми маємо зручний шаблон. Буде дуже важливим і корисним для спільноти, якщо до запиту ви додасте детальний опис способу відтворення проблеми чи реалізації пропозиції. Кожен запит буде розглянуто ключовими розробниками, (кимось, хто має право об'єднувати pull-запити). Виходячи з типу та змісту запиту, він може бути:

* включений до плану розвитку фреймворка невідкладно
* відкладений у чергу, якщо автор вимагає менш пріоритетних змін (оформлення, тести тощо)
* відкладений, якщо потрібне широке обговорення (спільнота, ключові розробники тощо)
* відхилений

> **NOTE**: If your pull request is a new feature, it is best to discuss with the core team first, to ensure that it will align with the evolution of the framework. 
> 
> {:.alert .alert-warning}

> **NOTE**: Please make sure that the target branch that you send your pull request is correct and that you have already rebased your code. Pull requests to the **master** branch are not allowed 
> 
> {:.alert .alert-danger}

## Документація
Якщо програмування на Zephir може здатися страшним, то є багато інших сфер, де ви можете допомогти. Ви завжди можете перевірити документацію на предмет наявності будь-яких помилок. Ви також можете розширити документацію іншими прикладами на відповідних сторінках.

All you have to do is go to our [docs][phalcon-docs] repository, fork it, make the changes and send us a pull request.

> **NOTE**: Note that changes to the `docs` repository are allowed **only** to the English documents (`en` folder). 
> 
> {:.alert .alert-warning}

## Переклади
If you wish to contribute to Phalcon by translating our documents in your native tongue, you can utilize the excellent service of our friends at [Crowdin][crowdin]. Our project is located [here][phalcon-docs]. Якщо вашої мови немає в списку доступних для перекладу, надішліть нам повідомлення, щоб ми могли додати її.

## Питання та підтримка

> **NOTE**: We only accept bug reports, new feature requests and pull requests in GitHub. For questions regarding the usage of the framework or support requests please visit the [official forum][phalcon-forum] or our [Discord][phalcon-discord] server. 
> 
> {:.alert .alert-danger}

## Занесення помилок до контрольного списку
- Переконайтеся, що ви використовуєте останню версію Phalcon перед створенням запиту на GitHub.
- Будуть виправлятись помилки, знайдені лише в останній версії Phalcon.
- Ми розробили зручний шаблон для створення запитів, що допоможе надати ключовим розробникам якомога більше інформації щодо відтворення та розв'язання проблеми. Можливість відтворити помилку значно скоротить час пошуку причини та її усунення. Скрипти навіть невдалих тестів будуть дуже корисні. Please check how to create the [reproducible tests][tests] page for more information.
- До вашого звіту включіть, будь ласка, додаткову інформацію, таку як версія ОС, версія PHP, версія Phalcon, web-сервер, пам'ять тощо.
- If you're submitting a [Segmentation Fault][segfault] error, we require a backtrace. Будь ласка, ознайомтесь із розділом про [створення зворотного трасування](#generating-a-backtrace) для додаткової інформації.

### Створення зворотного трасування
Sometimes due to [Segmentation Fault][segfault] error, Phalcon could crash some of your web server processes. Щоб допомогти нам знайти причину цієї сегментаційної помилки, нам знадобляться результати зворотного трасування проблемної ситуації.

Будь ласка, перегляньте наступні посилання з інструкціями щодо генерування зворотного трасування:

* [Створення зворотного трасування gdb][gdb]
* [Створення зворотного трасування за допомогою компілятора на Win32][gdb-w32]
* [Символи налагодження][symbols]
* [Збірка РНР][building-php]

## Контрольний список запитів на злиття
- Запити на злиття в гілку `master` не приймаються. Будь ласка, створіть виправлену копію репозиторію та створіть свою гілку з необхідної гілки-джерела, наприклад `4.0.x` і якщо потрібно перпбащуйте гілку перед тим, як надіслати запит на злиття. Якщо мають місце колізії, ми попросимо вас повторно перебазувати вашу гілку.
- Додайте тести до вашого запиту на злиття або налаштуйте існуючі. Це дуже важливо, оскільки допомагає обґрунтувати ваш запит на злиття. Please check our [testing][env] page for more information on how to set up a test environment and how to write tests.
- Since Phalcon is written in [Zephir][zephir], please do not submit commits that modify the C generated files directly
- Phalcon слідує певному стилю кодування. Будь ласка, встановіть `editorconfig` плагін у вашому улюбленому IDE, щоб скористатися переванами наданого `. ditorconfig` файлу, який поставляється з репозиторію, а тому не потрібно хвилюватися за стандарти кодування. All tests (PHP code), follow the [PSR-2][psr-2] standard
- Видаліть будь-яку зміну файлів `ext/kernel`, `*.zep.c` та `*.zep.h` перед надсиланням запиту на злиття
- More information [here][pr].

Before submitting **new functionality**, please open a [NFR][nfr] as a new issue on GitHub to discuss the impact of including the functionality or changes in the core extension. Як тільки новий функціонал буде погоджено, переконайтеся, що ваш PR містить таке:

- Оновлення до `CHANGELOG.md`
- Юніт-тести
- Приклади використання або документація

## Отримання допомоги
If you have any questions about how to use Phalcon, please see the [support page][support].

## Запити на новий функціонал
If you have any changes or new features in mind, please fill an [NFR][nfr].

Дякуємо!


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
