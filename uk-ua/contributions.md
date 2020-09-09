---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Участь у розвитку'
keywords: 'contributing, nfr, pull request, pr, new feature request, участь у розвитку фреймворка, звф, вдосконалення функціоналу'
---

# Участь у розвитку фреймворка

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

# Участь у розвитку Phalcon

Phalcon - проект з відкритим вихідним кодом, який значною мірою залежить від зусиль добровольців та пожертв. Ми будемо вдячні за будь-яку допомогу у розвитку фреймворка!

Будь ласка, виділіть кілька хвилин, щоб переглянути цей документ, зрозуміти процес участі у розвитку і зробити його максимально ефективним для всіх. Дотримуючись цих інструкцій, ми можемо досягти швидшого розв'язання проблем, кращої комунікації, що дозволить усім нам отримати найкращий результат!

Вихідний код Phalcon (разом з документацією, веб-сайтами і т. д.) зберігається на [GitHub](https://github.com). Ви можете переглядати наші репозиторії на [організаційній сторінці](https://github.com/phalcon).

Якщо ви бажаєте зробити внесок у Phalcon - можете зробити [запит на вдосконалення функціоналу на GitHub](https://help.github.com/articles/using-pull-requests/).

Щоб допомогти вам створити запит на вдосконалення функціоналу і описати пропозицію, ми маємо зручний шаблон. Буде дуже важливим і корисним для спільноти, якщо до запиту ви додасте детальний опис способу відтворення проблеми чи реалізації пропозиції. Кожен запит буде розглянуто ключовими розробниками, (кимось, хто має право об'єднувати pull-запити). Виходячи з типу та змісту запиту, він може бути:

- включений до плану розвитку фреймворка невідкладно 
- відкладений у чергу, якщо автор вимагає менш пріоритетних змін (оформлення, тести тощо)
- відкладений, якщо потрібне широке обговорення (спільнота, ключові розробники тощо)
- відхилений

> **ПРИМІТКА**: Будь ласка переконайтеся, що цільова гілка, у якій ви залишаєте запит, - правильна, а ви актуалізували ваш код до останньої версії фреймворка. Запити на вдосконалення функціоналу до гілки **master** заборонені
{:.alert .alert-danger}

## Документація

Якщо програмування на Zephir може здатися страшним, то є багато інших сфер, де ви можете допомогти. Ви завжди можете перевірити документацію на предмет наявності будь-яких помилок. Ви також можете розширити документацію іншими прикладами на відповідних сторінках.

Все, що вам потрібно зробити, це перейти до нашого репозиторію [документації](https://crowdin.com/project/phalcon-documentation), створити змінений дублікат його змісту та зробити запит на вдосконалення функціоналу (pull request).

> **ПРИМІТКА**: Зверніть увагу на те, що зміни до репозиторію `docs` дозволено вносити **лише** до англомовних документів (папка `en`).
{:.alert .alert-warning}

## Переклади

Якщо ви бажаєте допомогти у розвитку Phalcon, перекладаючи наші документи своєю рідною мовою, ви можете скористатися відмінним сервісом наших друзів - [Crowdin](https://crowdin.com). Наш проект розташований [тут](https://crowdin.com/project/phalcon-documentation). Якщо вашої мови немає в списку доступних для перекладу, надішліть нам повідомлення, щоб ми могли додати її.

## Питання та підтримка

> **ПРИМІТКА**: Ми приймаємо лише звіти про помилки, запити на вдосконалення функціоналу та запити на злиття на GitHub. Для обговорення тем, що стосуються використання фреймворку чи подання запитів щодо підтримки, будь ласка, відвідайте [офіційний форум](https://phalcon.io/forum) або наш [сервер Discord](https://phalcon.io/discord).
{:.alert .alert-danger}

## Занесення помилок до контрольного списку

- Переконайтеся, що ви використовуєте останню версію Phalcon перед створенням запиту на GitHub.
- Будуть виправлятись помилки, знайдені лише в останній версії Phalcon.
- Ми розробили зручний шаблон для створення запитів, що допоможе надати ключовим розробникам якомога більше інформації щодо відтворення та розв'язання проблеми. Можливість відтворити помилку значно скоротить час пошуку причини та її усунення. Скрипти навіть невдалих тестів будуть дуже корисні. Будь ласка, ознайомтесь з додатковою інформацією про те, як створити [відтворювані тести](reproducible-tests).
- До вашого звіту включіть, будь ласка, додаткову інформацію, таку як версія ОС, версія PHP, версія Phalcon, web-сервер, пам'ять тощо.
- If you're submitting a [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, we require a backtrace. Please check the [Generating a Backtrace](#generating-a-backtrace) section for more information.

### Generating a Backtrace

Sometimes due to [Segmentation Fault](https://en.wikipedia.org/wiki/Segmentation_fault) error, Phalcon could crash some of your web server processes. In order to help us find the cause of this segmentation fault, we will need the crash backtrace.

Please check the following links for instructions on how to generate the backtrace:

- [Generating a gdb backtrace](https://bugs.php.net/bugs-generating-backtrace.php)
- [Generating a backtrace, with a compiler, on Win32](https://bugs.php.net/bugs-generating-backtrace-win32.php)
- [Debugging Symbols](https://github.com/oerdnj/deb.sury.org/wiki/Debugging-symbols)
- [Building PHP](http://www.phpinternalsbook.com/build_system/building_php.html)

## Pull Request Checklist

- Pull requests to the `master` branch are not accepted. Please fork the repository and create your branch from the necessary "source" branch, for instance `4.0.x` and if need be rebase your branch before submitting your pull request. If there are collisions, we will ask you to rebase your branch again.
- Add tests to your pull request or adjust existing ones. This is very important since it helps justify your pull request. Please check our [testing](testing-environment) page for more information on how to set up a test environment and how to write tests.
- Since Phalcon is written in [Zephir](https://zephir-lang.com), please do not submit commits that modify the C generated files directly
- Phalcon follows a specific coding style. Please install the `editorconfig` plugin in your favorite IDE to take advantage of the supplied `.editorconfig` file that comes with this repository and not to have to worry about coding standards. All tests (PHP code), follow the [PSR-2](https://www.php-fig.org/psr/) standard
- Remove any change to `ext/kernel`, `*.zep.c` and `*.zep.h` files before submitting the pull request
- More information [here](new-pull-request).

Before submitting **new functionality**, please open a [NFR](new-feature-request) as a new issue on GitHub to discuss the impact of including the functionality or changes in the core extension. Once the functionality is approved, make sure your PR contains the following:

- An update to the `CHANGELOG.md`
- Unit Tests
- Documentation or Usage Examples

## Отримання допомоги

If you have any questions about how to use Phalcon, please see the [support page](https://phalcon.io/support).

## Requesting Features

If you have any changes or new features in mind, please fill an [NFR](new-feature-request).

Thanks!

<3 Phalcon Team