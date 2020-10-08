---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Міграції бази даних'
keywords: 'database, migrations, schema, tables, columns, база, міграції, схеми, таблиці, стовпці'
---

# Міграції бази даних

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

> **ПРИМІТКА**: Міграції Phalcon були вилучені з DevTools та переміщені в окреме сховище.
{: .alert .alert-info } 

## Git репозиторій

https://github.com/phalcon/migrations

## Вимоги

* PHP >= 7.2
* Phalcon >= 4.0.5

## Встановлення за допомогою Composer

    composer require --dev phalcon/migrations
    

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
    'database' => [
        'adapter' => 'mysql',
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'dbname' => 'db-name',
        'charset' => 'utf8',
    ],
    'application' => [
        'logInDb' => true,
        'migrationsDir' => 'db/migrations',
        'migrationsTsBased' => true, // true - використовуємо TIMESTAMP як назву версії, false - використовуємо версії
        'exportDataFromTables' => [
            // Імена таблиць
            // Увага! Це експортує дані кожної нової міграції
        ],
    ],
]);
```

### Генерування міграцій

**Базова генерація**

    vendor/bin/phalcon-migrations generate
    

**Згенеруйте спеціальну таблицю і експортуйте з неї дані

    vendor/bin/phalcon-migrations generate \
        --config=migrations.php \
        --table=users \
        --exportDataFromTables=users \
        --data=oncreate
    

### Запуск міграції

    vendor/bin/phalcon-migrations run
    

### Список існуючих міграцій

    vendor/bin/phalcon-migrations list
    

## Приклад використання

**Запустити міграції з каталогу міграцій**

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
    

## Методи міграції

Кожна міграція є окремим класом, який працює як сутність для конкретної таблиці бази даних. Всередині кожного класу є різні методи, які можуть виконуватися під час роботи міграції.

Кожен файл міграції (та клас) може реалізувати конкретні методи, які будуть виконані на основі запитаної операції. У кожному методі немає жодних обмежень за логікою.

Таблиця нижче показує методи міграції. Вони зберігаються в порядку виконання, першими йдуть актуальніші.

**Running to up**

| Method name      | Description                                        |
| ---------------- | -------------------------------------------------- |
| morph            | Morph table structure                              |
| afterCreateTable | Make something immediately after table was created |
| up               | Table is created and ready to work with            |
| afterUp          | Extra method to work for some specific cases       |

**Running to down**

| Method name                         | Description                                                                      |
| ----------------------------------- | -------------------------------------------------------------------------------- |
| down                                | Normally you put here table drop or data truncation                              |
| aferDown                            | Extra method to work after all was cleaned up                                    |
| morph (**from previous migration**) | As migration was moved backward, there need to be all returned to previous state |

## CLI Arguments and options

**Arguments**

| Argument | Description                   |
| -------- | ----------------------------- |
| generate | Generate a Migration          |
| run      | Run a Migration               |
| list     | List all available migrations |

**Options**

| Action                   | Description                                                                              |
| ------------------------ | ---------------------------------------------------------------------------------------- |
| --config=s               | Configuration file                                                                       |
| --migrations=s           | Migrations directory. Use comma separated string to specify multiple directories         |
| --directory=s            | Directory where the project was created                                                  |
| --table=s                | Table to migrate. Table name or table prefix with asterisk. Default: all                 |
| --version=s              | Version to migrate                                                                       |
| --descr=s                | Migration description (used for timestamp based migration)                               |
| --data=s                 | Export data \['always' or 'oncreate'\] (Data is imported during migration run)           |
| --exportDataFromTables=s | Export data from specific tables, use comma separated string.                            |
| --force                  | Forces to overwrite existing migrations                                                  |
| --ts-based               | Timestamp based migration version                                                        |
| --log-in-db              | Keep migrations log in the database table rather then in file                            |
| --dry                    | Attempt requested operation without making changes to system (Generating only)           |
| --verbose                | Output of debugging information during operation (Running only)                          |
| --no-auto-increment      | Disable auto increment (Generating only)                                                 |
| --skip-ref-schema        | Skip referencedSchema inside generated migration (Generating only)                       |
| --skip-foreign-checks    | Wrap `SET FOREIGN_KEY_CHECKS` query before and after execution of a query (Running only) |
| --help                   | Shows this help                                                                          |

## Timestamp based migrations

Using this approach is useful when more than one developer is participating in the database structure management. Use `'migrationsTsBased' => true` in config file or `--ts-based` option in CLI environment. Also, you need to specify suffix `descr`, which could be anything you want, for example: semantic version.

Current command

    vendor/bin/phalcon-migrations generate --ts-based --descr=1.0.0
    

Will produce folder name with such names

* 1582539287636860_1.0.0
* 1682539471102635_1.0.0
* 1782539471102635_1.0.0

Migrations will be executed from oldest to newest.

> **NOTE**: Whenever migrations are run, the application scans all available migrations and their status irrespective of their "age". If one or more were not executed in a previous run, they will be executed in the next run.
{: .alert .alert-info }
