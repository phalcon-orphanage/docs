---
layout: default
language: 'zh-cn'
version: '4.0'
---

# Model Metadata

* * *

![](/assets/images/document-status-under-review-red.svg)

## 概述

To speed up development [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) helps you to query fields and constraints from tables related to models. To achieve this, [Phalcon\Mvc\Model\MetaData](api/Phalcon_Mvc_Model_MetaData) is available to manage and cache table metadata.

Sometimes it is necessary to get those attributes when working with models. You can get a metadata instance as follows:

```php
<?php

$robot = new Robots();

// Get Phalcon\Mvc\Model\Metadata instance
$metadata = $robot->getModelsMetaData();

// Get robots fields names
$attributes = $metadata->getAttributes($robot);
print_r($attributes);

// Get robots fields data types
$dataTypes = $metadata->getDataTypes($robot);
print_r($dataTypes);
```

## Caching

Once the application is in a production stage, it is not necessary to query the metadata of the table from the database system each time you use the table. This could be done caching the metadata using any of the following adapters:

| 适配器          | 描述                                                                                                                                                                                                                       | API                                                                                        |
| ------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------ |
| Apc          | This adapter uses the [Alternative PHP Cache (APC)](https://secure.php.net/manual/en/book.apc.php) to store the table metadata. You can specify the lifetime of the metadata with options. (Recommended for Production). | [Phalcon\Mvc\Model\MetaData\Apc](api/Phalcon_Mvc_Model_MetaData_Apc)                   |
| Files        | This adapter uses plain files to store metadata. This adapter reduces database queries but has an increased I/O with the file system.                                                                                    | [Phalcon\Mvc\Model\MetaData\Files](api/Phalcon_Mvc_Model_MetaData_Files)               |
| Libmemcached | This adapter uses the [Memcached Server](https://www.memcached.org) to store the table metadata. The server parameters as well as the cache lifetime are specified in the options. (Recommended for Production)          | [Phalcon\Mvc\Model\MetaData\Libmemcached](api/Phalcon_Mvc_Model_MetaData_Libmemcached) |
| Memory       | This adapter is the default. The metadata is cached only during the request. When the request is completed, the metadata are released as part of the normal memory of the request. (Recommended for Development)         | [Phalcon\Mvc\Model\MetaData\Memory](api/Phalcon_Mvc_Model_MetaData_Memory)             |
| Redis        | This adapter uses [Redis](https://redis.io) to store the table metadata. The server parameters as well as the cache lifetime are specified in the options. (Recommended for Production).                                 | [Phalcon\Mvc\Model\MetaData\Redis](api/Phalcon_Mvc_Model_MetaData_Redis)               |

As other ORM's dependencies, the metadata manager is requested from the services container:

```php
<?php

use Phalcon\Mvc\Model\MetaData\Apc as ApcMetaData;

$di['modelsMetadata'] = function () {
    // Create a metadata manager with APC
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
    // Instantiate a metadata adapter
    $metadata = new ApcMetaData(
        [
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ]
    );

    // Set a custom metadata introspection strategy
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

| Name     | 描述                                                |
| -------- | ------------------------------------------------- |
| Primary  | Mark the field as part of the table's primary key |
| Identity | The field is an auto_increment/serial column      |
| Column   | This marks an attribute as a mapped column        |

The annotation `@Column` supports the following parameters:

| Name                 | 描述                                                                                                                                                                            |
| -------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| column               | Real column name                                                                                                                                                              |
| type                 | The column's types: varchar/string (default), text, char, json, tinyblob, blob, mediumblob, longblob, integer, biginteger, float, decimal, date, datetime, timestamp, boolean |
| length               | The column's length if any                                                                                                                                                    |
| nullable             | Set whether the column accepts null values or not                                                                                                                             |
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
    // Instantiate a metadata adapter
    $metadata = new ApcMetaData(
        [
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ]
    );

    // Set a custom metadata database introspection
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
            // Every column in the mapped table
            MetaData::MODELS_ATTRIBUTES => [
                'id',
                'name',
                'type',
                'year',
            ],

            // Every column part of the primary key
            MetaData::MODELS_PRIMARY_KEY => [
                'id',
            ],

            // Every column that isn't part of the primary key
            MetaData::MODELS_NON_PRIMARY_KEY => [
                'name',
                'type',
                'year',
            ],

            // Every column that doesn't allows null values
            MetaData::MODELS_NOT_NULL => [
                'id',
                'name',
                'type',
            ],

            // Every column and their data types
            MetaData::MODELS_DATA_TYPES => [
                'id'   => Column::TYPE_INTEGER,
                'name' => Column::TYPE_VARCHAR,
                'type' => Column::TYPE_VARCHAR,
                'year' => Column::TYPE_INTEGER,
            ],

            // The columns that have numeric data types
            MetaData::MODELS_DATA_TYPES_NUMERIC => [
                'id'   => true,
                'year' => true,
            ],

            // The identity column, use boolean false if the model doesn't have
            // an identity column
            MetaData::MODELS_IDENTITY_COLUMN => 'id',

            // How every column must be bound/casted
            MetaData::MODELS_DATA_TYPES_BIND => [
                'id'   => Column::BIND_PARAM_INT,
                'name' => Column::BIND_PARAM_STR,
                'type' => Column::BIND_PARAM_STR,
                'year' => Column::BIND_PARAM_INT,
            ],

            // Fields that must be ignored from INSERT SQL statements
            MetaData::MODELS_AUTOMATIC_DEFAULT_INSERT => [
                'year' => true,
            ],

            // Fields that must be ignored from UPDATE SQL statements
            MetaData::MODELS_AUTOMATIC_DEFAULT_UPDATE => [
                'year' => true,
            ],

            // Default values for columns
            MetaData::MODELS_DEFAULT_VALUES => [
                'year' => '2015',
            ],

            // Fields that allow empty strings
            MetaData::MODELS_EMPTY_STRING_VALUES => [
                'name' => true,
            ],
        );
    }
}
```