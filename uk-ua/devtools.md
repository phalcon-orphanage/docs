---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Devtools'
keywords: 'devtools, developer tools, models, controllers'
---

# Phalcon Devtools

* * *

![](/assets/images/document-status-under-review-red.svg)

## Огляд

Ці інструменти допомагають генерувати скелетний код, підтримувати структуру бази даних та сприяють пришвидшенню розробки. Основні компоненти вашого додатка можна створити за допомогою простої команди, що дозволяє легко розробляти програми за допомогою Phalcon.

Управляти Phalcon Devtool можна за допомогою командного рядка (cmd) або веб-інтерфейсу.

## Встановлення

Phalcon Devtools можна встановити за допомогою <composer>. Переконайтесь, що ви встановили composer.

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

Phalcon DevTools (4.0.0)

Доступні команди:
  info             (синонім: i)
  commands         (синоніми: list, enumerate)
  controller       (синонім: create-controller)
  module           (синонім: create-module)
  model            (синонім: create-model)
  all-models       (синонім: create-all-models)
  project          (синонім: create-project)
  scaffold         (синонім: create-scaffold)
  migration        (синонім: create-migration)
  webtools         (синонім: create-webtools)
  serve            (синонім: server)
  console          (синоніми: shell, psysh)
```

Інструменти devtools також доступні у форматі phar для завантаження у нашому [репозиторії](github_devtools) github.

## Використання

### Доступні команди

Ви можете отримати список доступних команд в інструментах Phalcon, набравши: `phalcon commands`

```bash
$ phalcon commands

Phalcon DevTools (4.0.0)

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

Ви можете використовувати інструменти Phalcon для створення типового скелета проекту для ваших додатків на основі фреймворка Phalcon. За замовчуванням генератор скелета проекту використовуватиме mod_rewrite для Apache. Наберіть таку команду в кореневій папці проекту:

```bash
$ phalcon create-project store
```

Зазначене вище згенерувало рекомендовану структуру проекту:

![](/assets/images/content/v4/devtools-store-dirstructure.png)

Ви можете додати параметр `--help`, щоб отримати допомогу у використанні певного сценарію:

```bash
$ phalcon project --help

Phalcon DevTools (4.0.0)

Довідка:
  Створює проект

Використання:
  project [name] [type] [directory] [enable-webtools]

Аргументи:
  help  Показує цей довідковий текст (англійською)

Приклад
  phalcon project store simple

Опції:
 --name=s               Назва нового проекту
 --enable-webtools      Визначає, чи має бути активовано вебінструментарій
 [optional]
 --directory=s          Базовий шлях, де проект буде створено [optional]
 --type=s               Тип додатка, що буде згенеровано (cli, micro, simple, modules)
 --template-path=s      Уточнення шляху до шаблону [optional]
 --template-engine=s    Визначення двигуна візуалізації, за замовчуванням phtml (phtml, volt) [optional]
 --use-config-ini       Використання файлу ini для зберігання параметрів налаштувань [optional]
 --trace                Відображає трасування фреймворка у разі виняткової ситуації [optional]
 --help                 Показувати цю довідку (англійською) [optional]
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

Коли проект згенеровано за допомогою інструментів розробника, файл конфігурації можна знайти в `app/config/config.php`. Для створення моделей або їх типових структур потрібно змінити параметри, які використовуються для підключення до бази даних.

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

Найпростіший спосіб створити модель для таблиці з назвою users:

```bash
$ phalcon model users
```

Якщо ваша база даних виглядає так:

```sql
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
```

Це призведе до

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

class Users extends \Phalcon\Mvc\Model
{

    /**
     *

     * @var integer
     */
    public $id;

    /**
     *

     * @var string
     */
    public $name;

    /**
     *

     * @var string
     */
    public $email;

    /**
     *

     * @var string
     */
    public $password;

    /**
     *

     * @var string
     */
    public $active;

    /**
     * Перевірка та бізнес логіка
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Будь ласка вкажіть правильну email-адресу',
                ]
            )
        );

        return $this->validate($validator);
    }

    /**
     * Метод ініціалізації моделі.
     */
    public function initialize()
    {
        $this->setSchema("test");
        $this->setSource("users");
    }

    /**
     * Дозволяє запитувати набір записів, які відповідають зазначеним умовам
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Дозволяє запитувати перший запис, який відповідає вказаним умовам
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
```

Варіанти створення різних типів креслень моделі можна знайти за допомогою

```bash
phalcon model --help
```

### Генерування CRUD

Генерування - це швидкий спосіб створити деякі основні частини додатку. Якщо ви хочете створити моделі, представлення та контролери для нового ресурсу в одній операції, використовуйте інструмент генерування.

Після генерації коду, він повинен бути налаштований для задоволення ваших потреб. Багато розробників уникають генерації, обирають писати всі або більшість своїх вихідних кодів з нуля. Згенерований код може слугувати довідником, щоб краще зрозуміти як працює фреймворк або розробка прототипів. Наведений нижче код показує генерацію на основі таблиці `users`:

```bash
$ phalcon scaffold --table-name users
```

Генератор побудує декілька файлів у вашому застосунку, а також створить деякі папки. Ось короткий огляд того, що буде згенеровано:

| Файл                                  | Призначення                        |
| ------------------------------------- | ---------------------------------- |
| `app/controllers/UsersController.php` | The Users controller               |
| `app/models/Users.php`                | The Users model                    |
| `app/views/layout/users.phtml`        | Шаблон контролера для користувачів |
| `app/views/products/search.phtml`     | Представлення для дії `search`     |
| `app/views/products/new.phtml`        | Представлення для дії `new`        |
| `app/views/products/edit.phtml`       | Представлення для дії `edit`       |

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

Нижче показаний ролик про те, як поєднати інструменти розробника з [PhpStorm IDE](https://www.jetbrains.com/phpstorm/). Налаштування можуть бути легко адаптовані для інших IDE під PHP.

<div align="center">
<iframe width="560" height="315" src="https://www.youtube.com/embed/UbUx_6Cs6r4" frameborder="0" allowfullscreen></iframe>
</div>
