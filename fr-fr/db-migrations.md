---
layout: default
language: 'fr-fr'
version: '4.0'
title: 'Database Migrations'
keywords: 'database, migrations, schema, tables, columns'
---

# Database Migrations

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

> **NOTE**: Phalcon migrations have been removed from DevTools and moved to a separate repository.
{: .alert .alert-info } 

## Package git repository

https://github.com/phalcon/migrations

## Requirements

* PHP >= 7.2
* Phalcon >= 4.0.0

## Installing via Composer

    composer require --dev phalcon/migrations
    

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
        'migrationsTsBased' => true, // true - Use TIMESTAMP as version name, false - use versions (1.0.1)
        'exportDataFromTables' => [
            // Tables names
            // Attention! It will export data every new migration
        ],
    ],
]);
```

### Generate migrations

    vendor/bin/phalcon-migrations migration generate
    

### Run Migrations

    vendor/bin/phalcon-migrations migration run
    

## Usage example

**Run migrations from specific migrations directory**

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
    

## CLI Arguments and options

**Arguments**

| Argument | Description                   |
| -------- | ----------------------------- |
| generate | Generate a Migration          |
| run      | Run a Migration               |
| list     | List all available migrations |

**Options**

| Action                   | Description                                                                      |
| ------------------------ | -------------------------------------------------------------------------------- |
| --action=s               | Generates/Runs a Migration [generate|run]                                        |
| --config=s               | Configuration file                                                               |
| --migrations=s           | Migrations directory. Use comma separated string to specify multiple directories |
| --directory=s            | Directory where the project was created                                          |
| --table=s                | Table to migrate. Table name or table prefix with asterisk. Default: all         |
| --version=s              | Version to migrate                                                               |
| --descr=s                | Migration description (used for timestamp based migration)                       |
| --data=s                 | Export data \[always|oncreate\] (Import data when run migration)                 |
| --exportDataFromTables=s | Export data from specific tables, use comma separated string.                    |
| --force                  | Forces to overwrite existing migrations                                          |
| --ts-based               | Timestamp based migration version                                                |
| --log-in-db              | Keep migrations log in the database table rather then in file                    |
| --dry                    | Attempt requested operation without making changes to system (Generating only)   |
| --verbose                | Output of debugging information during operation (Running only)                  |
| --no-auto-increment      | Disable auto increment (Generating only)                                         |
| --help                   | Shows this help                                                                  |