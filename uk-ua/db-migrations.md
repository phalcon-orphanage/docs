---
layout: default
title: 'Міграції бази даних'
keywords: 'database, migrations, schema, tables, columns, база, міграції, схеми, таблиці, стовпці'
---

# Міграції бази даних
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

> **NOTE**: Phalcon migrations have been removed from DevTools and moved to a separate repository. 
> 
> {: .alert .alert-info }

## Git репозиторій

https://github.com/phalcon/migrations

## Вимоги

* PHP >= 7.5
* Phalcon >= 5.0.0

## Встановлення за допомогою Composer

```
composer require --dev phalcon/migrations
```

## Швидкий старт

Що вам потрібно для швидкого старту:

* Файл конфігурації в кореневому каталозі вашого проекту (ви також можете передати їх як параметри в середовищі CLI)
* Створення структури таблиць бази даних
* Виконайте команду для створення міграцій

Після цього ви зможете виконати цю міграцію (run) в іншому середовищі для створення такої ж структури БД.

### Створюємо файл конфігурації

```php
<?php

use Phalcon\Config;

return new Config([
    'database'    => [
        'adapter'  => 'mysql',
        'host'     => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'dbname'   => 'db-name',
        'charset'  => 'utf8',
    ],
    'application' => [
        'logInDb'              => true,
        'migrationsDir'        => 'db/migrations',
        // true - TIMESTAMP, false - versions
        'migrationsTsBased'    => true, 
        'exportDataFromTables' => [
            // Tables names
        ],
    ],
]);
```

> NOTE: If `exportDataFromTables` is set, data will be exported with every migration 
> 
> {: .alert .alert-warning }

### Генерування міграцій

**Базова генерація**

```
vendor/bin/phalcon-migrations generate
```

**Згенеруйте спеціальну таблицю і експортуйте з неї дані

```
vendor/bin/phalcon-migrations generate \
    --config=migrations.php \
    --table=users \
    --exportDataFromTables=users \
    --data=oncreate
```

### Запуск міграції

```
vendor/bin/phalcon-migrations run
```

### Список існуючих міграцій

```
vendor/bin/phalcon-migrations list
```

## Приклад використання

**Запустити міграції з каталогу міграцій**

```
use Phalcon\Migrations\Migrations;

$migration = new Migrations();
$migration::run([
    'migrationsDir' => [
        __DIR__ . '/migrations',
    ],
    'config' => [
        'database' => [
            'adapter' => 'Mysql',
            'host' => 'phalcon-db-mysql',
            'username' => 'root',
            'password' => 'root',
            'dbname' => 'vokuro',
        ],
    ]
]);
```

## Методи міграції

Each migration is a separate class that works as an entity for specific database table. Всередині кожного класу є різні методи, які можуть виконуватися під час роботи міграції.

Кожен файл міграції (та клас) може реалізувати конкретні методи, які будуть виконані на основі запитаної операції. У кожному методі немає жодних обмежень за логікою.

Таблиця нижче показує методи міграції. Вони зберігаються в порядку виконання, від перших до останніх.

**Працює догори**

| Назва методу       | Description                                                  |
| ------------------ | ------------------------------------------------------------ |
| `morph`            | Морфологічна структура таблиці                               |
| `afterCreateTable` | Виконати щось одразу після створення таблиці                 |
| `up`               | Таблиця створена і готова до роботи з нею                    |
| `afterUp`          | Додатковий метод для виконання у деяких специфічних випадках |


**Працює донизу**

| Назва методу | Description                                                                                                        |
| ------------ | ------------------------------------------------------------------------------------------------------------------ |
| `down`       | Зазвичай ви тут додаєте видалення таблиці або очищення даних                                                       |
| `aferDown`   | Додатковий метод для виконання після всіх очищень                                                                  |
| `morph`      | (**from previous migration**) As the migration was moved backward, there need to be all returned to previous state |

## Параметри і опції CLI

**Аргументи**

| Аргумент   | Description                    |
| ---------- | ------------------------------ |
| `generate` | Генерування міграції           |
| `run`      | Запуск міграції                |
| `list`     | Список усіх доступних міграцій |

**Options**

| Action                     | Description                                                                               |
| -------------------------- | ----------------------------------------------------------------------------------------- |
| `--config=s`               | Файл конфігурації                                                                         |
| `--migrations=s`           | Папка міграцій. Для вказання декількох каталогів запишіть їх через кому                   |
| `--directory=s`            | Каталог, де був створений проект                                                          |
| `--table=s`                | Таблиця для міграції. Ім'я таблиці або префікс таблиць з зірочкою. За замовчуванням: всі  |
| `--version=s`              | Версія для міграції                                                                       |
| `--descr=s`                | Опис міграції (використовується для міграцій на основі позначки часу)                     |
| `--data=s`                 | Експорт даних \['always' або 'oncreate'\] (Дані імпортуються під час виконання міграції)  |
| `--exportDataFromTables=s` | Export data from specific tables, use comma separated string                              |
| `--force`                  | Примусово перезаписати існуючі міграції                                                   |
| `--ts-based`               | Версія міграції на основі часових позначок                                                |
| `--log-in-db`              | Зберігати журнал міграції у базі даних, а не у файлі                                      |
| `--dry`                    | Спроба запитуваної операції без внесення змін до системи (лише для створення)             |
| `--verbose`                | Вивід інформації для налагодження під час роботи (лише виконання)                         |
| `--no-auto-increment`      | Вимкнути автоматичне доповнення (тільки для генерації)                                    |
| `--skip-ref-schema`        | Пропустити схему залежностей всередині згенерованої міграції (лише для створення)         |
| `--skip-foreign-checks`    | Загорнути запит `SET FOREIGN_KEY_CHECKS` до і після виконання запиту (лише для виконання) |
| `--help`                   | Показує цю довідку                                                                        |

## Версія міграції на основі часових позначок

Використання цього підходу корисне, коли більше одного розробника бере участь в управлінні структурою бази даних. Використовуйте параметр `'migrationsTsBased' => true` у файлі конфігурації або `--ts-based` в середовищі CLI. Крім того, необхідно вказати суфікс `descr`, це може бути що завгодно, наприклад: семантичні версії.

Поточна команда
```
vendor/bin/phalcon-migrations generate --ts-based --descr=1.0.0
```

Створить назву теки з такими іменами

```sh
* 1582539287636860_1.0.0
* 1682539471102635_1.0.0
* 1782539471102635_1.0.0
```

Міграції будуть виконані від старіших до новіших.

> **NOTE**: Whenever migrations are run, the application scans all available migrations and their status irrespective of their "age". Якщо одна чи кілька не були виконані попереднього разу, вони будуть виконані наступного разу. 
> 
> {: .alert .alert-info }
