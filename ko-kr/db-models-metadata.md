---
layout: default
language: 'ko-kr'
version: '4.0'
title: 'Models Metadata'
keywords: 'model, caching, metadata, query fields'
---

# Model Metadata

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 개요

When using [Phalcon\Mvc\Model](api/Phalcon_Mvc#mvc-model) classes, which correspond to actual tables in the database, Phalcon needs to know essential information regarding those tables, such as fields, data types, primary and foreign keys as well as relationships. The [Phalcon\Mvc\Model\MetaData](api/Phalcon_Mvc#mvc-model-metadata) object is offering this functionality, transparently querying the database and generating the necessary data from the database schema. The data can then be stored in a data store (such as Redis, APCu etc.) to ensure that the database is not queried for the schema every time a query is executed.

> **NOTE**: During deployments to production, please ensure that you always invalidate the metaData cache so that database changes that propagated during your deployment are available in your application. The metaData cache will be rebuilt with all the necessary changes.
{: .alert .alert-warning } 


```php
<?php

use MyApp\Models\Invoices;
use Phalcon\Mvc\Model\MetaData;

$invoice = new Invoices();

/** @var MetaData\ $metadata */
$metadata = $invoice->getModelsMetaData();

$attributes = $metadata->getAttributes($invoice);
print_r($attributes);

$dataTypes = $metadata->getDataTypes($invoice);
print_r($dataTypes);
```

The above code will print the field names and also the fields to field types array. We use `attributes` as an alias of `fields`.

```php
[
    [0] => inv_id
    [1] => inv_cst_id
    [2] => inv_status_flag
    [3] => inv_title
    [4] => inv_total
    [5] => inv_created_at
    [6] => inv_created_by
    [7] => inv_updated_at
    [8] => inv_updated_by
]

[
    [inv_id]          => 0,
    [inv_cst_id]      => 0,
    [inv_status_flag] => 0,
    [inv_title]       => 2,
    [inv_total]       => 0,
    [inv_created_at]  => 4,
    [inv_created_by]  => 0,
    [inv_updated_at]  => 4,
    [inv_updated_by]  => 0,
]
```

## Constants

[Phalcon\Mvc\Model\MetaData](api/Phalcon_Mvc#mvc-model-metadata) exposes a number of constants that can be used to retrieve attributes from the internal collection.

| Name                              | Description                                                                |
| --------------------------------- | -------------------------------------------------------------------------- |
| `MODELS_ATTRIBUTES`               | Every column in the mapped table                                           |
| `MODELS_AUTOMATIC_DEFAULT_INSERT` | Fields that must be ignored from `INSERT` SQL statements                   |
| `MODELS_AUTOMATIC_DEFAULT_UPDATE` | Fields that must be ignored from `UPDATE` SQL statements                   |
| `MODELS_COLUMN_MAP`               | Column map (aliases)                                                       |
| `MODELS_DATA_TYPES`               | Every column and its data type                                             |
| `MODELS_DATA_TYPES_BIND`          | How every column must be bound/casted                                      |
| `MODELS_DATA_TYPES_NUMERIC`       | The columns that have numeric data types                                   |
| `MODELS_DEFAULT_VALUES`           | Default values for columns                                                 |
| `MODELS_EMPTY_STRING_VALUES`      | Columns that allow empty strings                                           |
| `MODELS_IDENTITY_COLUMN`          | The identity column. `false` if the model does not have an identity column |
| `MODELS_NON_PRIMARY_KEY`          | Every column that is not part of the primary key                           |
| `MODELS_NOT_NULL`                 | Every column that does not allow `null` values                             |
| `MODELS_PRIMARY_KEY`              | Every column part of the primary key                                       |
| `MODELS_REVERSE_COLUMN_MAP`       | Reverse column map (aliases)                                               |

## Methods

```php
public function getAttributes(ModelInterface $model): array
```

Returns table attributes names (fields)

```php
print_r(
    $metaData->getAttributes(
        new Invoices()
    )
);
```

```php
public function getAutomaticCreateAttributes(
    ModelInterface $model
): array
```

Returns attributes that must be ignored from the `INSERT` SQL generation

```php
print_r(
    $metaData->getAutomaticCreateAttributes(
        new Invoices()
    )
);
```

```php
public function getAutomaticUpdateAttributes(
    ModelInterface $model
): array
```

Returns attributes that must be ignored from the `UPDATE` SQL generation

```php
print_r(
    $metaData->getAutomaticUpdateAttributes(
        new Invoices()
    )
);
```

```php
public function getBindTypes(ModelInterface $model): array
```

Returns attributes and their bind data types

```php
print_r(
    $metaData->getBindTypes(
        new Invoices()
    )
);
```

```php
public function getColumnMap(ModelInterface $model): array
```

Returns the column map if any

```php
print_r(
    $metaData->getColumnMap(
        new Invoices()
    )
);
```

```php
public function getDefaultValues(ModelInterface $model): array
```

Returns attributes (which have default values) and their default values

```php
 print_r(
     $metaData->getDefaultValues(
         new Invoices()
     )
 );
```

```php
public function getDataTypes(ModelInterface $model): array
```

Returns attributes and their data types

```php
print_r(
    $metaData->getDataTypes(
        new Invoices()
    )
);
```

```php
public function getDataTypesNumeric(ModelInterface $model): array
```

Returns attributes which types are numerical

```php
print_r(
    $metaData->getDataTypesNumeric(
        new Invoices()
    )
);
```

```php
public function getEmptyStringAttributes(
    ModelInterface $model
): array
```

Returns attributes allow empty strings

```php
print_r(
    $metaData->getEmptyStringAttributes(
        new Invoices()
    )
);
```

```php
public function getIdentityField(ModelInterface $model): string
```

Returns the name of identity field (if one is present)

```php
print_r(
    $metaData->getIdentityField(
        new Invoices()
    )
);
```

```php
public function getNonPrimaryKeyAttributes(
    ModelInterface $model
): array
```

Returns an array of fields which are not part of the primary key

```php
print_r(
    $metaData->getNonPrimaryKeyAttributes(
        new Invoices()
    )
);
```

```php
public function getNotNullAttributes(ModelInterface $model): array
```

Returns an array of not null attributes

```php
print_r(
    $metaData->getNotNullAttributes(
        new Invoices()
    )
);
```

```php
public function getPrimaryKeyAttributes(
    ModelInterface $model
): array
```

Returns an array of fields which are part of the primary key

```php
print_r(
    $metaData->getPrimaryKeyAttributes(
        new Invoices()
    )
);
```

```php
public function getReverseColumnMap(
    ModelInterface $model
): array
```

Returns the reverse column map if any

```php
print_r(
    $metaData->getReverseColumnMap(
        new Invoices()
    )
);
```

```php
public function getStrategy(): StrategyInterface
```

Return the strategy to obtain the meta-data

```php
public function hasAttribute(
    ModelInterface $model, 
    string $attribute
): bool
```

Check if a model has certain attribute

```php
print_r(
    $metaData->hasAttribute(
        new Invoices(),
        "inv_title"
    )
);
```

```php
public function isEmpty(): bool
```

Checks if the internal meta-data container is empty

```php
print_r(
    $metaData->isEmpty()
);
```

```php
public function read(string $key): array | null
```

Reads metadata from the adapter

```php
final public function readColumnMap(
    ModelInterface $model
): array | null
```

Reads the ordered/reversed column map for certain model

```php
print_r(
    $metaData->readColumnMap(
        new Invoices()
    )
);
```

```php
final public function readColumnMapIndex(
    ModelInterface $model, 
    int $index
)
```

Reads column-map information for certain model using a `MODEL_*` constant

```php
print_r(
    $metaData->readColumnMapIndex(
        new Invoices(),
        MetaData::MODELS_REVERSE_COLUMN_MAP
    )
);
```

```php
final public function readMetaData(ModelInterface $model): array
```

Reads the complete meta-data for certain model

```php
print_r(
    $metaData->readMetaData(
        new Invoices()
    )
);
```

```php
final public function readMetaDataIndex(
    ModelInterface $model, 
    int $index
)
```

Reads meta-data for certain model

```php
print_r(
    $metaData->readMetaDataIndex(
        new Invoices(),
        0
    )
);
```

```php
public function reset(): void
```

Resets internal meta-data in order to regenerate it

```php
 $metaData->reset();
```

```php
public function setAutomaticCreateAttributes(
    ModelInterface $model, 
    array $attributes
): void
```

Set the attributes that must be ignored from the INSERT SQL generation

```php
$metaData->setAutomaticCreateAttributes(
    new Invoices(),
    [
        "inv_created_at" => true,
    ]
);
```

```php
public function setAutomaticUpdateAttributes(
    ModelInterface $model, 
    array $attributes
): void
```

Set the attributes that must be ignored from the UPDATE SQL generation

```php
$metaData->setAutomaticUpdateAttributes(
    new Invoices(),
    [
        "inv_updated_at" => true,
    ]
);
```

```php
public function setEmptyStringAttributes(
    ModelInterface $model, 
    array $attributes
): void
```

Set the attributes that allow empty string values

```php
$metaData->setEmptyStringAttributes(
    new Invoices(),
    [
        "inv_title" => true,
    ]
);
```

```php
public function setStrategy(StrategyInterface $strategy): void
```

Set the meta-data extraction strategy

```php
public function write(string $key, array $data): void
```

Writes the metadata to adapter

```php
final public function writeMetaDataIndex(
    ModelInterface $model, 
    int $index, 
    mixed $data
): void
```

Writes meta-data for certain model using a MODEL_* constant

```php
print_r(
    $metaData->writeColumnMapIndex(
        new Invoices(),
        MetaData::MODELS_REVERSE_COLUMN_MAP,
        [
            "title" => "inv_title",
        ]
    )
);
```

```php
final protected function initialize(
    ModelInterface $model, 
    mixed $key, 
    mixed $table, 
    mixed $schema
)
```

Initialize the metadata for certain table

## Adapters

Retrieving the metadata is an expensive database operation and we certainly do not want to perform it every time we run a query. We can however use one of many adapters available in order to cache the metadata.

> **NOTE**: For local development, the [Phalcon\Mvc\Models\MetaData\Memory](api/Phalcon_Mvc#mvc-model-metadata-memory) adapter is recommended so that any changes to the database can be reflected immediately. 
{: .alert .alert-info }
 
| Adapter                                                                                         | Description                                                                                                                                  |
| ----------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Mvc\Models\MetaData\Apcu](api/Phalcon_Mvc#mvc-model-metadata-apcu)                 | This adapter uses the [Alternative PHP Cache (APC)](https://secure.php.net/manual/en/book.apc.php) to store the table metadata. (production) |
| [Phalcon\Mvc\Models\MetaData\Libmemcached](api/Phalcon_Mvc#mvc-model-metadata-libmemcached) | This adapter uses the [Memcached Server](https://www.memcached.org) to store the table metadata. (production)                                |
| [Phalcon\Mvc\Models\MetaData\Memory](api/Phalcon_Mvc#mvc-model-metadata-memory)             | This adapter uses memory. The metadata is cached only during the request. (development)                                                      |
| [Phalcon\Mvc\Models\MetaData\Redis](api/Phalcon_Mvc#mvc-model-metadata-redis)               | This adapter uses [Redis](https://redis.io) to store the table metadata. (production)                                                        |
| [Phalcon\Mvc\Models\MetaData\Stream](api/Phalcon_Mvc#mvc-model-metadata-stream)             | This adapter uses plain files to store metadata. (not for production)                                                                        |

### APCu

This adapter uses the [Alternative PHP Cache (APC)](https://secure.php.net/manual/en/book.apc.php) to store the table metadata. The extension must be present in your system for this metadata cache to work. If the server is restarted, the data will be lost. This adapter is suitable for production applications.

The adapter receives a [Phalcon\Cache\AdapterFactory](cache#adapter-factory) class in order to instantiate the relevant cache object. You can also pass an array with additional options for the cache to operate.

The default prefix is `ph-mm-apcu-` and the lifetime is `172,000` (48 hours).

```php
<?php

use Phalcon\Cache\SerializerFactory;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Model\MetaData\Apcu;

$container = new FactoryDefault();
$container->set(
    'modelsMetadata',
    function () {
        $serializerFactory = new SerializerFactory();
        $adapterFactory    = new AdapterFactory($serializerFactory);
        $options = [
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ];

        return new Apcu($adapterFactory, $options);
    }
);
```

### Libmemcached

This adapter uses the [Memcached Server](https://www.memcached.org) to store the table metadata. The extension must be present in your system for this metadata cache to work. This adapter is suitable for production applications.

The adapter receives a [Phalcon\Cache\AdapterFactory](cache#adapter-factory) class in order to instantiate the relevant cache object. You can also pass an array with additional options for the cache to operate.

The default prefix is `ph-mm-memc-` and the lifetime is `172,000` (48 hours). The `persistenId` is preset to `php-mm-mcid-`.

```php
<?php

use Phalcon\Cache\SerializerFactory;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Model\MetaData\Libmemcached;

$container = new FactoryDefault();
$container->set(
    'modelsMetadata',
    function () {
        $serializerFactory = new SerializerFactory();
        $adapterFactory    = new AdapterFactory($serializerFactory);
        $options = [
            'servers' => [
                0 => [
                    'host'   => '127.0.0.1',
                    'port'   => 11211,
                    'weight' => 1
                ],   
            ],
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ];

        return new Libmemcached($adapterFactory, $options);
    }
);
```

### Memory

This adapter uses the server's memory to store the metadata cache. The cache is available only during the request, and then the cache is lost. This cache is more suitable for development, since it accommodates the frequent changes in the database during development.

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Model\MetaData\Memory;

$container = new FactoryDefault();
$container->set(
    'modelsMetadata',
    function () {
        return new Memory();
    }
);
```

### Redis

This adapter uses the [Redis](https://redis.io) to store the table metadata. The extension must be present in your system for this metadata cache to work. This adapter is suitable for production applications.

The adapter receives a [Phalcon\Cache\AdapterFactory](cache#adapter-factory) class in order to instantiate the relevant cache object. You can also pass an array with additional options for the cache to operate.

The default prefix is `ph-mm-reds-` and the lifetime is `172,000` (48 hours).

```php
<?php

use Phalcon\Cache\SerializerFactory;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Model\MetaData\Redis;

$container = new FactoryDefault();
$container->set(
    'modelsMetadata',
    function () {
        $serializerFactory = new SerializerFactory();
        $adapterFactory    = new AdapterFactory($serializerFactory);
        $options = [
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'index'    => 1,
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ];

        return new Redis($adapterFactory, $options);
    }
);
```

### Stream

This adapter uses the file system to store the table metadata. This adapter is suitable for production applications but not recommended since it introduces an increase in I/O.

The adapter can accept a `metaDadaDir` option with a directory on where the metadata will be stored. The default directory is the current directory.

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Model\MetaData\Stream;

$container = new FactoryDefault();
$container->set(
    'modelsMetadata',
    function () {
        $options = [
            'metaDataDir' => '/app/storage/cache/metaData',
        ];

        return new Stream($options);
    }
);
```

You can use the `orm.exception_on_failed_metadata_save` option in your `php.ini` file to force the component to throw an exception if there is an error storing the metadata or if the target directory is not writeable.

```ini
orm.exception_on_failed_metadata_save = true
```

## Strategies

The default strategy to obtain the model's metadata is database introspection. Using this strategy, the information schema is used to identify the fields in a table, its primary key, nullable fields, data types, etc.

```php
<?php

use Phalcon\Cache\SerializerFactory;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Model\MetaData\Apcu;
use Phalcon\Mvc\Model\MetaData\Strategy\Introspection;

$container = new FactoryDefault();
$container->set(
    'modelsMetadata',
    function () {
        $serializerFactory = new SerializerFactory();
        $adapterFactory    = new AdapterFactory($serializerFactory);
        $options = [
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ];

        $metadata = new Apcu($adapterFactory, $options);
        $metadata->setStrategy(new Introspection());

        return $metadata;
    }
);
```

### Introspection

This strategy does not require any customization and is implicitly used by all the metadata adapters.

### 주석

This strategy makes use of <annotations> to describe the columns in a model.

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    /**
     * @Primary
     * @Identity
     * @Column(type='integer', nullable=false)
     */
    public $inv_id;

    /**
     * @Column(type='integer', nullable=false)
     */
    public $inv_cst_id;

    /**
     * @Column(type='string', length=70, nullable=false)
     */
    public $inv_title;

    /**
     * @Column(type='double', nullable=false)
     */
    public $inv_total;
}
```

Annotations must be placed in properties that are mapped to columns in the mapped source. Properties without the `@Column` annotation are handled as simple class attributes.

The following annotations are supported:

| Name        | Description                                       |
| ----------- | ------------------------------------------------- |
| `@Primary`  | Mark the field as part of the table's primary key |
| `@Identity` | The field is an auto_increment/serial column      |
| `@Column`   | This marks an attribute as a mapped column        |

The annotation `@Column` supports the following parameters:

| Name                 | Description                                                                                                                                                                                                    |
| -------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `column`             | Real column name                                                                                                                                                                                               |
| `type`               | The column's type: `char`, `biginteger`, `blob`, `boolean`, `date`, `datetime`, `decimal`, `integer`, `float`, `json`, `longblob`, `mediumblob`, `timestamp`, `tinyblob`, `text`, `varchar`/`string` (default) |
| `length`             | The column's length if any                                                                                                                                                                                     |
| `nullable`           | Set whether the column accepts `null` values or not                                                                                                                                                            |
| `skip_on_insert`     | Skip this column on insert                                                                                                                                                                                     |
| `skip_on_update`     | Skip this column on updates                                                                                                                                                                                    |
| `allow_empty_string` | Column allow empty strings                                                                                                                                                                                     |
| `default`            | Default value                                                                                                                                                                                                  |

The annotations strategy could be set up as follows:

```php
<?php

use Phalcon\Cache\SerializerFactory;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Model\MetaData\Apcu;
use Phalcon\Mvc\Model\MetaData\Strategy\Annotations;

$container = new FactoryDefault();
$container->set(
    'modelsMetadata',
    function () {
        $serializerFactory = new SerializerFactory();
        $adapterFactory    = new AdapterFactory($serializerFactory);
        $options = [
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ];

        $metadata = new Apcu($adapterFactory, $options);
        $metadata->setStrategy(new Annotations());

        return $metadata;
    }
);
```

### Manual

Using the introspection strategies presented above, Phalcon can obtain the metadata for each model automatically. However, you have the option to define the metadata manually. This strategy overrides any strategy that has been set on the metadata manager. Columns added, modified or removed from the mapped table must be manually updated in the model for everything to work properly.

To set the metadata, we use the `metaData` method in a model:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Db\Column;
use Phalcon\Mvc\Model\MetaData;

class Invoices extends Model
{
    public function metaData()
    {
        return array(
            MetaData::MODELS_ATTRIBUTES => [
                'inv_id',
                'inv_cst_id',
                'inv_status_flag',
                'inv_title',
                'inv_total',
                'inv_created_at',
                'inv_created_by',
                'inv_updated_at',
                'inv_updated_by',
            ],

            MetaData::MODELS_PRIMARY_KEY => [
                'inv_id',
            ],

            MetaData::MODELS_NON_PRIMARY_KEY => [
                'inv_cst_id',
                'inv_status_flag',
                'inv_title',
                'inv_total',
                'inv_created_at',
                'inv_created_by',
                'inv_updated_at',
                'inv_updated_by',
            ],

            MetaData::MODELS_NOT_NULL => [
                'inv_id',
                'inv_cst_id',
                'inv_status_flag',
                'inv_title',
                'inv_total',
                'inv_created_at',
                'inv_created_by',
                'inv_updated_at',
                'inv_updated_by',

            MetaData::MODELS_DATA_TYPES => [
                'inv_id'          => Column::TYPE_INTEGER,
                'inv_cst_id'      => Column::TYPE_INTEGER,
                'inv_status_flag' => Column::TYPE_INTEGER,
                'inv_title'       => Column::TYPE_VARCHAR,
                'inv_total'       => Column::TYPE_FLOAT,
                'inv_created_at'  => Column::TYPE_DATETIME,
                'inv_created_by'  => Column::TYPE_INTEGER,
                'inv_updated_at'  => Column::TYPE_DATETIME,
                'inv_updated_by'  => Column::TYPE_INTEGER,
            ],

            MetaData::MODELS_DATA_TYPES_NUMERIC => [
                'inv_id'          => true,
                'inv_cst_id'      => true,
                'inv_status_flag' => true,
                'inv_total'       => true,
                'inv_created_by'  => true,
                'inv_updated_by'  => true,
            ],

            MetaData::MODELS_IDENTITY_COLUMN => 'inv_id',

            MetaData::MODELS_DATA_TYPES_BIND => [
                'inv_id'          => Column::BIND_PARAM_INT,
                'inv_cst_id'      => Column::BIND_PARAM_INT,
                'inv_status_flag' => Column::BIND_PARAM_INT,
                'inv_title'       => Column::BIND_PARAM_INT,
                'inv_total'       => Column::BIND_PARAM_DECIMAL,
                'inv_created_at'  => Column::BIND_PARAM_STR,
                'inv_created_by'  => Column::BIND_PARAM_INT,
                'inv_updated_at'  => Column::BIND_PARAM_STR,
                'inv_updated_by'  => Column::BIND_PARAM_INT,
            ],

            MetaData::MODELS_AUTOMATIC_DEFAULT_INSERT => [
                'inv_created_at' => true,
                'inv_created_by' => true,
                'inv_updated_at' => true,
                'inv_updated_by' => true,
            ],

            MetaData::MODELS_AUTOMATIC_DEFAULT_UPDATE => [
                'inv_created_at' => true,
                'inv_created_by' => true,
                'inv_updated_at' => true,
                'inv_updated_by' => true,
            ],

            MetaData::MODELS_DEFAULT_VALUES => [
                'inv_status_flag' => 0,
            ],

            MetaData::MODELS_EMPTY_STRING_VALUES => [
                'inv_created_at' => true,
                'inv_updated_at' => true,
            ],
        );
    }
}
```

### Custom

Phalcon offers the [Phalcon\Mvc\Model\MetaData\Strategy\StrategyInterface](api/Phalcon_Mvc#mvc-model-metadata-strategyinterface) interface, allowing you to create your own Strategy class.

```php
<?php

namespace MyApp\Components\Strategy;

use Phalcon\Mvc\ModelInterface;
use Phalcon\Di\DiInterface;

class MyStrategy StrategyInterface
{
    public function getColumnMaps(
        ModelInterface $model, 
        DiInterface $container
    ): array;

    public function getMetaData(
        ModelInterface $model, 
        DiInterface $container
    ): array;
}

```