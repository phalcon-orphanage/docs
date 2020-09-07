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

If you wish to contribute to Phalcon by translating our documents in your native tongue, you can utilize the excellent service of our friends at [Crowdin](https://crowdin.com). Our project is located [here](https://crowdin.com/project/phalcon-documentation). If your language is not listed, please send us a message so that we can add it.

## Questions and Support

> **NOTE**: We only accept bug reports, new feature requests and pull requests in GitHub. For questions regarding the usage of the framework or support requests please visit the [official forum](https://phalcon.io/forum) or our [Discord](https://phalcon.io/discord) server.
{:.alert .alert-danger}

## Bug Report Checklist

- Make sure you are using the latest released version of Phalcon before creating an issue in GitHub.
- Only bugs found in the latest released version of Phalcon will be addressed.
- We have a handy template when creating an issue to help you provide as much information for the core team to reproduce and address. Being able to reproduce a bug significantly reduces the time to find the cause and fix it. Scripts of even failing tests are more than appreciated. Please check how to create the [reproducible tests](reproducible-tests) page for more information.
- As part of your report, please include additional information such as the OS, PHP version, Phalcon version, web server, memory etc.
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