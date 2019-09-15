---
layout: default
language: 'ru-ru'
version: '4.0'
---

# Model Metadata

* * *

![](/assets/images/document-status-under-review-red.svg)

## Overview

To speed up development [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) helps you to query fields and constraints from tables related to models. To achieve this, [Phalcon\Mvc\Model\MetaData](api/Phalcon_Mvc_Model_MetaData) is available to manage and cache table metadata.

Sometimes it is necessary to get those attributes when working with models. You can get a metadata instance as follows:

```php
<?php

$robot = new Robots();

// Получаем экземпляр Phalcon\Mvc\Model\Metadata
$metadata = $robot->getModelsMetaData();

// Получаем имена полей робота
$attributes = $metadata->getAttributes($robot);
print_r($attributes);

// Получаем типы данных полей робота
$dataTypes = $metadata->getDataTypes($robot);
print_r($dataTypes);
```

## Caching

Once the application is in a production stage, it is not necessary to query the metadata of the table from the database system each time you use the table. This could be done caching the metadata using any of the following adapters:

| Адаптер      | Описание                                                                                                                                                                                                                                                                              | API                                                                                        |
| ------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------ |
| Apc          | This adapter uses the [Alternative PHP Cache (APC)](https://secure.php.net/manual/en/book.apc.php) to store the table metadata. Вы можете задать время жизни метаданных с помощью параметров. Рекомендуемый способ хранения метаданных, когда приложение находится в продакшн режиме. | [Phalcon\Mvc\Model\MetaData\Apc](api/Phalcon_Mvc_Model_MetaData_Apc)                   |
| Files        | This adapter uses plain files to store metadata. This adapter reduces database queries but has an increased I/O with the file system.                                                                                                                                                 | [Phalcon\Mvc\Model\MetaData\Files](api/Phalcon_Mvc_Model_MetaData_Files)               |
| Libmemcached | This adapter uses the [Memcached Server](https://www.memcached.org) to store the table metadata. Параметры сервера, а также время жизни кэша указываются в параметрах. Рекомендуемый способ хранения метаданных, когда приложение находится в продакшн режиме.                        | [Phalcon\Mvc\Model\MetaData\Libmemcached](api/Phalcon_Mvc_Model_MetaData_Libmemcached) |
| Memory       | This adapter is the default. The metadata is cached only during the request. When the request is completed, the metadata are released as part of the normal memory of the request. (Recommended for Development)                                                                      | [Phalcon\Mvc\Model\MetaData\Memory](api/Phalcon_Mvc_Model_MetaData_Memory)             |
| Redis        | This adapter uses [Redis](https://redis.io) to store the table metadata. Параметры сервера, а также время жизни кэша указываются в параметрах. Рекомендуемый способ хранения метаданных, когда приложение находится в продакшн режиме.                                                | [Phalcon\Mvc\Model\MetaData\Redis](api/Phalcon_Mvc_Model_MetaData_Redis)               |

As other ORM's dependencies, the metadata manager is requested from the services container:

```php
<?php

use Phalcon\Mvc\Model\MetaData\Apc as ApcMetaData;

$di['modelsMetadata'] = function () {
    // Создаём менеджер метаданных с APC
    $metadata = new ApcMetaData(
        [
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ]
    );

    return $metadata;
};
```

## Strategies

As mentioned above the default strategy to obtain the model's metadata is database introspection. In this strategy, the information schema is used to know the fields in a table, its primary key, nullable fields, data types, etc.

You can change the default metadata introspection in the following way:

```php
<?php

use Phalcon\Mvc\Model\MetaData\Apc as ApcMetaData;

$di['modelsMetadata'] = function () {
    // Создаём адаптер метаданных
    $metadata = new ApcMetaData(
        [
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ]
    );

    // Изменяем стратегию интроспекции метаданных
    $metadata->setStrategy(
        new MyIntrospectionStrategy()
    );

    return $metadata;
};
```

### Introspection

This strategy doesn't require any customization and is implicitly used by all the metadata adapters.

### Annotations

This strategy makes use of `annotations <annotations>` to describe the columns in a model:

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    /**
     * @Primary
     * @Identity
     * @Column(type='integer', nullable=false)
     */
    public $id;

    /**
     * @Column(type='string', length=70, nullable=false)
     */
    public $name;

    /**
     * @Column(type='string', length=32, nullable=false)
     */
    public $type;

    /**
     * @Column(type='integer', nullable=false)
     */
    public $year;
}
```

Annotations must be placed in properties that are mapped to columns in the mapped source. Properties without the `@Column` annotation are handled as simple class attributes.

The following annotations are supported:

| Название | Описание                                              |
| -------- | ----------------------------------------------------- |
| Primary  | Отмечает поле как часть первичного ключа таблицы      |
| Identity | Поле является автоинкрементным и/или идентифицирующим |
| Column   | Отмечает атрибут в качестве отображаемого столбца     |

The annotation `@Column` supports the following parameters:

| Название             | Описание                                                                                                                                                                      |
| -------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| column               | Real column name                                                                                                                                                              |
| type                 | The column's types: varchar/string (default), text, char, json, tinyblob, blob, mediumblob, longblob, integer, biginteger, float, decimal, date, datetime, timestamp, boolean |
| length               | Длина столбца, если есть                                                                                                                                                      |
| nullable             | Принимает ли столбец нулевые значения или нет                                                                                                                                 |
| skip_on_insert     | Skip this column on insert                                                                                                                                                    |
| skip_on_update     | Skip this column on updates                                                                                                                                                   |
| allow_empty_string | Column allow empty strings                                                                                                                                                    |
| default              | Default value                                                                                                                                                                 |

The annotations strategy could be set up this way:

```php
<?php

use Phalcon\Mvc\Model\MetaData\Apc as ApcMetaData;
use Phalcon\Mvc\Model\MetaData\Strategy\Annotations as StrategyAnnotations;

$di['modelsMetadata'] = function () {
    // Создаём адаптер метаданных
    $metadata = new ApcMetaData(
        [
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ]
    );

    // Изменяем стратегию интроспекции метаданных
    $metadata->setStrategy(
        new StrategyAnnotations()
    );

    return $metadata;
};
```

## Manual

Using the introspection strategies presented above, Phalcon can obtain the metadata for each model automatically without the developer needing to set them manually.

The developer also has the option of define the metadata manually. This strategy overrides any strategy set in the metadata manager. New columns added/modified/removed to/from the mapped table must be added/modified/removed also for everything to work properly.

The following example shows how to define the metadata manually:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Db\Column;
use Phalcon\Mvc\Model\MetaData;

class Robots extends Model
{
    public function metaData()
    {
        return array(
            // Столбцы в отображаемой таблице
            MetaData::MODELS_ATTRIBUTES => [
                'id',
                'name',
                'type',
                'year',
            ],

            // Столбцы, являющиеся частью первичного ключа
            MetaData::MODELS_PRIMARY_KEY => [
                'id',
            ],

            // Столбцы, которые не являются частью первичного ключа
            MetaData::MODELS_NON_PRIMARY_KEY => [
                'name',
                'type',
                'year',
            ],

            // Столбцы, которые не позволяют хранить нулевые значения
            MetaData::MODELS_NOT_NULL => [
                'id',
                'name',
                'type',
            ],

            // Все столбцы и их типы данных
            MetaData::MODELS_DATA_TYPES => [
                'id'   => Column::TYPE_INTEGER,
                'name' => Column::TYPE_VARCHAR,
                'type' => Column::TYPE_VARCHAR,
                'year' => Column::TYPE_INTEGER,
            ],

            // Стобцы, которые имеют числовые типы данных
            MetaData::MODELS_DATA_TYPES_NUMERIC => [
                'id'   => true,
                'year' => true,
            ],

            // Столбец идентификатора. Используйте логическое значение FALSE,
            // если модель не имеет столбца идентификации
            MetaData::MODELS_IDENTITY_COLUMN => 'id',

            // К какому типу приводить каждый столбец
            MetaData::MODELS_DATA_TYPES_BIND => [
                'id'   => Column::BIND_PARAM_INT,
                'name' => Column::BIND_PARAM_STR,
                'type' => Column::BIND_PARAM_STR,
                'year' => Column::BIND_PARAM_INT,
            ],

            // Поля, которые должны быть проигнорированы в INSERT SQL инструкциях
            MetaData::MODELS_AUTOMATIC_DEFAULT_INSERT => [
                'year' => true,
            ],

            // Поля, которые должны быть проигнорированы в UPDATE SQL инструкциях
            MetaData::MODELS_AUTOMATIC_DEFAULT_UPDATE => [
                'year' => true,
            ],

            // Значения по умолчанию для столбцов
            MetaData::MODELS_DEFAULT_VALUES => [
                'year' => '2015',
            ],

            // Поля, допускающие пустые строки
            MetaData::MODELS_EMPTY_STRING_VALUES => [
                'name' => true,
            ],
        );
    }
}
```