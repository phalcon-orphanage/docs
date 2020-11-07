- - -
layout: default language: 'uk-ua' version: '4.0' title: 'Юніт-тестування' keywords: 'unit testing, phpunit, phalcon, юніт-тести'
- - -
# Юніт-тестування
<hr />
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg) ![](/assets/images/level-intermediate.svg)

## Огляд

Написання правильних тестів може допомогти у написанні кращого програмного забезпечення. Якщо ви правильно визначите потенційні проблемні ситуації для тестування, то зможете уникнути більшості функціональних помилок і краще підтримуватимете ваше програмне забезпечення.

## Поєднання PHPUnit з Phalcon

```bash
composer require --dev phpunit/phpunit:^9.0
```

або додавши вручну у `composer.json`:

```json
{
    "require-dev": {
        "phpunit/phpunit": "^9.0"
    }
}
```

Як тільки PHPUnit буде встановлено, створіть теку з назвою `tests` у корені проекту, у яку додайте теку з назвою `Unit`:

```
app/
src/
public/
tests/Unit/
```

### Налаштування простору імен для тестів

Для того щоб автоматично завантажити наш тестовий каталог, ми повинні додати наш тестовий простір імен в composer. Додайте нижче зазначений код до composer та змініть його відповідно до ваших потреб.

```json
{
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests"
        }
    }
}
```

Тепер створіть файл `phpunit.xml` наступним чином:

### Файл `phpunit.xml`

Змініть зазначений нижче код `phpunit.xml`, щоб він відповідав вашим потребам, і збережіть його в кореневій теці вашого проекту. Це дозволить запускати всі тести з теки `tests/Unit`.

```xml
<?xml version="1.0" encoding="UTF-8"?>

<phpunit backupGlobals="false"
         backupStaticAttributes="false"
         verbose="true"
         colors="true"
         convertErrorsToExceptions="true"
         convertNoticesToExceptions="true"
         convertWarningsToExceptions="true"
         processIsolation="false"
         stopOnFailure="false">

    <testsuite name="Phalcon - Unit Test">
        <directory>./tests/Unit</directory>
    </testsuite>
</phpunit>
```

### Phalcon Incubator Test

Phalcon надає тестову бібліотеку, яка містить декілька абстрактних класів, які можна використовувати для завантаження Unit тестів. Ці файли існують у репозиторії [Phalcon Incubator Test](https://github.com/phalcon/incubator-test).

Ви можете використати бібліотеку тестів Incubator, додавши її як залежність:

```bash
composer require --dev phalcon/incubator-test:^v1.0.0-alpha.1
```

або додавши вручну у `composer.json`:

```json
{
    "require-dev": {
        "phalcon/incubator-test": "^v1.0.0-alpha.1"
    }
}
```

## Створення Unit тесту

Завжди розумно автоматично завантажувати ваші класи за допомогою просторів імен. Конфігурація нижче передбачає, що ви використовуєте PSR-4 для автоматичного завантаження класів проекту через конфігурацію composer. Якщо так робити, то автозавантажувача перевірятиме, чи правильні файли завантажені, тому все, що вам залишиться зробити - це створити файли проекту і phpunit буде запускати тести для вас.

Цей приклад не містить файла конфігурації, оскільки більшість випадків вам слід придумати самостійно, залежно від особливостей вашого проекту. Якщо він вам буде потрібен, то можете додати його до `DI` в `AbstractUnitTest`.

### Абстрактний юніт-тест
Спочатку створіть базовий юніт тест під назвою `AbstractUnitTest.php` у теці `tests/Unit`:

```php
<?php

declare(strict_types=1);

namespace Tests\Unit;

use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\Incubator\Test\PHPUnit\UnitTestCase;
use PHPUnit\Framework\IncompleteTestError;

abstract class AbstractUnitTest extends UnitTestCase
{
    private bool $loaded = false;

    protected function setUp(): void
    {
        parent::setUp();

        $di = new FactoryDefault();

        Di::reset();
        Di::setDefault($di);

        $this->loaded = true;
    }

    public function __destruct()
    {
        if (!$this->loaded) {
            throw new IncompleteTestError(
                "Будь ласка запустіть parent::setUp()."
            );
        }
    }
}
```

### Ваш перший тест

Створіть зазначений нижче тест і збережіть його у теці `tests/Unit`.

```php
<?php

declare(strict_types=1);

namespace Tests\Unit;

class UnitTest extends AbstractUnitTest
{
    public function testTestCase(): void
    {
        $this->assertEquals(
            "roman",
            "roman",
            "Цей буде успішним"
        );

        $this->assertEquals(
            "hope",
            "ava",
            "Цей буде невдалим"
        );
    }
}
```

Якщо вам потрібно змінити метод `setUp`, то важливо викликати батьківський метод також, а інакше Phalcon не ініціюється правильно.
```php
    protected function setUp(): void
    {
        parent::setUp();

        //Деякі базові видозміни
    }

```

### Запуск юніт-тестів

Коли ви виконаєте `vendor/bin/phpunit` в командному рядку, то отримаєте такий результат:

```bash
$ phpunit
PHPUnit 9.1.4 by Sebastian Bergmann and contributors.

Runtime:       PHP 7.4.5 with Xdebug 2.9.5
Configuration: /var/www//phpunit.xml


Time: 3 ms, Memory: 3.25Mb

Мала місце 1 помилка:

1) Test\Unit\UnitTest::testTestCase
Цей буде невдалим
Хибне твердження, що тих дві стрічки однакові.
--- Expected
+++ Actual
@@ @@
-'hope'
+'ava'

/var/www/tests/Unit/UnitTest.php:25

FAILURES!
Tests: 1, Assertions: 2, Failures: 1.
```

## Ресурси
- [Документація з PHPUnit](https://phpunit.de/documentation.html)
- [Початок роботи з TDD в PHP](https://www.sitepoint.com/re-introducing-phpunit-getting-started-tdd-php/)
- [Виписування видатних юніт-тестів](https://blog.stevensanderson.com/2009/08/24/writing-great-unit-tests-best-and-worst-practises/)
- [Що таке Mocking в PHP-тестуванні одиниць](https://www.clariontech.com/blog/what-is-mocking-in-php-unit-testing)
