---
layout: default
language: 'uk-ua'
version: '5.0'
title: 'Devtools'
keywords: 'devtools, developer tools, models, controllers'
---

# Phalcon Devtools
- - -
![](/assets/images/document-status-under-review-red.svg)

## Огляд
Ці інструменти допомагають генерувати скелетний код, підтримувати структуру бази даних та сприяють пришвидшенню розробки. Основні компоненти вашого додатка можна створити за допомогою простої команди, що дозволяє легко розробляти програми за допомогою Phalcon.

You can use the Phalcon Devtools either from the command line (terminal) or the web interface.

## Встановлення

Phalcon Devtools можна встановити за допомогою [composer](composer). Переконайтесь, що ви встановили composer.

Установка Phalcon Devtools глобально
```bash
composer global require phalcon/devtools
```
Або лише всередині вашого проекту
```bash
composer require phalcon/devtools
```

Перевірте свою установку, набравши: `phalcon`
```bash
$ phalcon

Phalcon DevTools (5.0.0)

Available commands:
  info             (alias of: i)
  commands         (alias of: list, enumerate)
  controller       (alias of: create-controller)
  module           (alias of: create-module)
  model            (alias of: create-model)
  all-models       (alias of: create-all-models)
  project          (alias of: create-project)
  scaffold         (alias of: create-scaffold)
  migration        (alias of: create-migration)
  webtools         (alias of: create-webtools)
  serve            (alias of: server)
  console          (alias of: shell, psysh)
```

The devtools are also available as phar download on our GitHub [repository](github_devtools).

## Використання
### Доступні команди
Ви можете отримати список доступних команд в інструментах Phalcon, набравши: `phalcon commands`

```bash
$ phalcon commands

Phalcon DevTools (5.0.0)

Available commands:
  info             (alias of: i)
  commands         (alias of: list, enumerate)
  controller       (alias of: create-controller)
  module           (alias of: create-module)
  model            (alias of: create-model)
  all-models       (alias of: create-all-models)
  project          (alias of: create-project)
  scaffold         (alias of: create-scaffold)
  migration        (alias of: create-migration)
  webtools         (alias of: create-webtools)
  serve            (alias of: server)
  console          (alias of: shell, psysh)
```

### Створення скелету проекту
Ви можете використовувати інструменти Phalcon для створення типового скелета проекту для ваших додатків на основі фреймворка Phalcon. By default, the project skeleton generator will use mod_rewrite for Apache. Наберіть таку команду в кореневій папці проекту:

```bash
$ phalcon create-project store
```

Зазначене вище згенерувало рекомендовану структуру проекту:

![](/assets/images/content/v4/devtools-store-dirstructure.png)

Ви можете додати параметр `--help`, щоб отримати допомогу у використанні певного сценарію:

```bash
$ phalcon project --help

Phalcon DevTools (5.0.0)

Help:
  Creates a project

Usage:
  project [name] [type] [directory] [enable-webtools]

Arguments:
  help  Shows this help text

Example
  phalcon project store simple

Options:
 --name=s               Name of the new project
 --enable-webtools      Determines if webtools should be enabled [optional]
 --directory=s          Base path on which project will be created [optional]
 --type=s               Type of the application to be generated (cli, micro, simple, modules)
 --template-path=s      Specify a template path [optional]
 --template-engine=s    Define the template engine, default phtml (phtml, volt) [optional]
 --use-config-ini       Use a ini file as configuration file [optional]
 --trace                Shows the trace of the framework in case of exception [optional]
 --help                 Shows this help [optional]
```

Доступ до проекту з веб-сервера покаже вам:

![](/assets/images/content/v4/devtools-store-localhost.png)

### Створення контролерів
Команда `create-controller` генерує скелетні структури контролерів. Важливо викликати цю команду в каталозі, у якому вже є проєкт Phalcon.

```bash
$ phalcon create-controller --name test
```

Команда згенерує код:

```php
<?php
declare(strict_types=1);

class TestController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {

    }
}

```

### Підготовка налаштувань бази даних
Коли проект згенеровано за допомогою інструментів розробника,  файл конфігурації можна знайти в `app/config/config.php`. Для створення моделей або їх типових структур потрібно змінити параметри, які використовуються для підключення до бази даних.

Змініть розділ налаштувань доступу до бази даних у вашому файлі config.php:

```php
<?php

/*
 * Змінено: попередній шлях до теки цього файлу, оскільки цей файл має різні ENV при доступі через Apache та командну стрічку.
 * ПРИМІТКА: будь ласка, видаліть цей коментар.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'test',
        'charset'     => 'utf8',
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/',
        'baseUri'        => '/',
    ]
]);
```

### Створення моделей
Існує кілька способів створити моделі. Ви можете створити всі моделі з підключення до бази даних за замовчуванням або деякі вибірково. Моделі можуть використовувати публічні атрибути для представлення полів або установлювачі (сетери)/збирачі (ґеттери).

```bash
Опції:
 --name=s             Назва таблиці
 --schema=s           Назва схеми [optional]
 --config=s           Файл конфігурації [optional]
 --namespace=s        Простір імен моделі [optional]
 --get-set            Атрибути будуть захищені та матимуть сетери/геттери [optional]
 --extends=s          Модель розширює клас із зазначеною назвою [optional]
 --excludefields=l    Виключає поля, визначені у списку, розділеному комами [optional]
 --doc                Допомагає покращити заповнення коду в середовищах розробки [optional]
 --directory=s        Базовий шлях, за яким розташований проект [optional]
 --output=s           Тека, де розташовані моделі [optional]
 --force              Переписати модель [optional]
 --camelize           Властивості визначає написання з використанням горбатого регістру [optional]
 --trace              Показує трасування фреймворку у випадку винятку [optional]
 --mapcolumn          Отримати код для вказівників стовпців [optional]
 --abstract           Абстрактна модель [optional]
 --annotate           Анотувати атрибути [optional]
 --help               Показує цю довідку [optional]
```

The simplest way to generate a model for a table called `customers` is:

```bash
$ phalcon model customers
```

Якщо ваша база даних виглядає так:

```sql
create table customers
(
    `cst_id`          int(10) auto_increment primary key,
    `cst_status_flag` tinyint(1)   null,
    `cst_name_last`   varchar(100) null,
    `cst_name_first`  varchar(50)  null
);

create index customers_cst_status_flag_index
    on `customers` (`cst_status_flag`);

create index customers_cst_name_last_index
    on `customers` (`cst_name_last`);

create index customers_cst_name_first_index
    on `customers` (`cst_name_first`);
```

Це призведе до

```php
<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Tests\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf as EmailValidator;

/**
 * @property int    $cst_id
 * @property int    $cst_status_flag
 * @property string $cst_name_last
 * @property string $cst_name_first
 * @property array  $cst_data;
 */
class Customers extends Model
{
    /**
     * @var int 
     */
    public $cst_id;

    /**
     * @var int 
     */
    public $cst_status_flag;

    /**
     * @var string 
     */
    public $cst_name_last;

    /**
     * @var string 
     */
    public $cst_name_first;

    public function initialize()
    {
        $this->setSource('customers');
    }

    /**
     * @return bool
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'cst_name_last',
            new PresenceOf(
                [
                    'model'   => $this,
                    'message' => 'Please enter a valid last name',
                ]
            )
        );

        return $this->validate($validator);
    }
}
```

Варіанти створення різних типів креслень моделі можна знайти за допомогою

```bash
phalcon model --help
```

### Генерування CRUD
Scaffolding is a quick way to generate some major pieces of an application. Якщо ви хочете створити моделі, представлення та контролери для нового ресурсу в одній операції, використовуйте інструмент генерування.

Після генерації коду, він повинен бути налаштований для задоволення ваших потреб. Багато розробників уникають генерації, обирають писати всі або більшість своїх вихідних кодів з нуля. Згенерований код може слугувати довідником, щоб краще зрозуміти як працює фреймворк або розробка прототипів. The code below shows a scaffold based on the table `customers`:

```bash
$ phalcon scaffold --table-name customers
```

Генератор побудує декілька файлів у вашому застосунку, а також створить деякі папки. Ось короткий огляд того, що буде згенеровано:

| Файл                                      | Призначення                        |
| ----------------------------------------- | ---------------------------------- |
| `app/controllers/CustomersController.php` | The Customers controller           |
| `app/models/Customers.php`                | The Customers model                |
| `app/views/layout/customers.phtml`        | Шаблон контролера для користувачів |
| `app/views/products/search.phtml`         | Представлення для дії `search`     |
| `app/views/products/new.phtml`            | Представлення для дії `new`        |
| `app/views/products/edit.phtml`           | Представлення для дії `edit`       |

Переглядаючи щойно згенерований контролер, ви побачите форму пошуку та посилання на створення нового продукту:

![](/assets/images/content/devtools-usage-03.png)

`Створити сторінку` дозволяє створювати продукти із виконанням перевірок, що визначені у моделі продуктів. Phalcon автоматично перевіряє поля на предмет їх заповнення, попереджаючи, якщо воно обов'язкове.

![](/assets/images/content/devtools-usage-04.png)

Після виконання пошуку, відповідний компонент розділить отримані результати на окремі сторінки. Використовуйте посилання "Редагувати" або "Видалити" перед кожним результатом для виконання таких дій.

![](/assets/images/content/devtools-usage-05.png)

### Веб-інтерфейс для інструментів
Також, якщо бажаєте, можна використати інструменти розробника Phalcon через веб-інтерфейс. Перегляньте наступний ролик, щоб з'ясувати, як це працює:

<div align="center">
<iframe src="https://player.vimeo.com/video/42367665" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
</div>

### Поєднання інструментів з PhpStorm IDE
The screencast below shows how to integrate developer tools with the [PhpStorm IDE][phpstorm]. Налаштування можуть бути легко адаптовані для інших IDE під PHP.

<div align="center">
<iframe width="560" height="315" src="https://www.youtube.com/embed/UbUx_6Cs6r4" frameborder="0" allowfullscreen></iframe>
</div>
[phpstorm]: https://www.jetbrains.com/phpstorm/
