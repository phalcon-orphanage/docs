---
layout: default
language: 'zh-cn'
version: '5.0'
title: '数据库迁移'
keywords: 'database, migrations, schema, tables, columns'
---

# 数据库迁移
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

> **NOTE**: Phalcon migrations have been removed from DevTools and moved to a separate repository. 
> 
> {: .alert .alert-info }

## Package git repository

https://github.com/phalcon/migrations

## Requirements

* PHP >= 7.5
* Phalcon >= 5.0.0

## Installing via Composer

```
composer require --dev phalcon/migrations
```

## Quick start

What you need for quick start:

* Configuration file in root of your project (you can also pass them as parameters inside CLI environment)
* Create database tables structure
* Execute command to generate migrations

After that you can execute that migrations (run) in another environment to create same DB structure.

### Create configuration file

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

### Generate migrations

**Basic generation**

```
vendor/bin/phalcon-migrations generate
```

**Generate specific table and export data from it

```
vendor/bin/phalcon-migrations generate \
    --config=migrations.php \
    --table=users \
    --exportDataFromTables=users \
    --data=oncreate
```

### Run migrations

```
vendor/bin/phalcon-migrations run
```

### List existing migrations

```
vendor/bin/phalcon-migrations list
```

## Usage example

**Run migrations from specific migrations directory**

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

## Migration methods

Each migration is an separate class that works as an entity for specific database table. Inside each class there are different methods that can occur during migration running.

Each migration file (and class) can implement specific methods, that will be executed based on the operation requested. There are no restrictions on the logic encapsulated in each method.

The tables below show the Migration Class methods. They are stored by order of execution, earliest to latest.

**Running to up**

| Method name        | 描述                                                 |
| ------------------ | -------------------------------------------------- |
| `morph`            | Morph table structure                              |
| `afterCreateTable` | Make something immediately after table was created |
| `up`               | Table is created and ready to work with            |
| `afterUp`          | Extra method to work for some specific cases       |


**Running to down**

| Method name | 描述                                                                                                                 |
| ----------- | ------------------------------------------------------------------------------------------------------------------ |
| `down`      | Normally you put here table drop or data truncation                                                                |
| `aferDown`  | Extra method to work after all was cleaned up                                                                      |
| `morph`     | (**from previous migration**) As the migration was moved backward, there need to be all returned to previous state |

## CLI Arguments and options

**Arguments**

| Argument   | 描述                            |
| ---------- | ----------------------------- |
| `generate` | Generate a Migration          |
| `run`      | Run a Migration               |
| `list`     | List all available migrations |

**Options**

| Action                     | 描述                                                                                       |
| -------------------------- | ---------------------------------------------------------------------------------------- |
| `--config=s`               | Configuration file                                                                       |
| `--migrations=s`           | Migrations directory. Use comma separated string to specify multiple directories         |
| `--directory=s`            | Directory where the project was created                                                  |
| `--table=s`                | Table to migrate. Table name or table prefix with asterisk. Default: all                 |
| `--version=s`              | Version to migrate                                                                       |
| `--descr=s`                | Migration description (used for timestamp based migration)                               |
| `--data=s`                 | Export data \['always' or 'oncreate'\] (Data is imported during migration run)           |
| `--exportDataFromTables=s` | Export data from specific tables, use comma separated string                             |
| `--force`                  | Forces to overwrite existing migrations                                                  |
| `--ts-based`               | Timestamp based migration version                                                        |
| `--log-in-db`              | Keep migrations log in the database table rather then in file                            |
| `--dry`                    | Attempt requested operation without making changes to system (Generating only)           |
| `--verbose`                | Output of debugging information during operation (Running only)                          |
| `--no-auto-increment`      | Disable auto increment (Generating only)                                                 |
| `--skip-ref-schema`        | Skip referencedSchema inside generated migration (Generating only)                       |
| `--skip-foreign-checks`    | Wrap `SET FOREIGN_KEY_CHECKS` query before and after execution of a query (Running only) |
| `--help`                   | Shows this help                                                                          |

## Timestamp based migrations

Using this approach is useful when more than one developer is participating in the database structure management. Use `'migrationsTsBased' => true` in config file or `--ts-based` option in CLI environment. Also, you need to specify suffix `descr`, which could be anything you want, for example: semantic version.

Current command
```
vendor/bin/phalcon-migrations generate --ts-based --descr=1.0.0
```

Will produce folder name with such names

```sh
* 1582539287636860_1.0.0
* 1682539471102635_1.0.0
* 1782539471102635_1.0.0
```

Migrations will be executed from oldest to newest.

> **NOTE**: Whenever migrations are run, the application scans all available migrations and their status irrespective of their "age". If one or more were not executed in a previous run, they will be executed in the next run. 
> 
> {: .alert .alert-info }
