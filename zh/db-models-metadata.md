<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Models Metadata</a> <ul>
        <li>
          <a href="#caching-metadata">Caching Metadata</a>
        </li>
        <li>
          <a href="#metadata-strategies">Metadata Strategies</a> 
          <ul>
            <li>
              <a href="#strategies-database-introspection">Database Introspection Strategy</a>
            </li>
            <li>
              <a href="#strategies-annotations">Annotations Strategy</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#strategies-manual">Manual Metadata</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='models-metadata'></a>

# Models Metadata

To speed up development `Phalcon\Mvc\Model` helps you to query fields and constraints from tables related to models. To achieve this, `Phalcon\Mvc\Model\MetaData` is available to manage and cache table metadata.

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

<a name='caching-metadata'></a>

## Caching Metadata

Once the application is in a production stage, it is not necessary to query the metadata of the table from the database system each time you use the table. This could be done caching the metadata using any of the following adapters:

| Adapter      | Description                                                                                                                                                                                                                                                                                                              | API                                           |
| ------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | --------------------------------------------- |
| Apc          | This adapter uses the [Alternative PHP Cache (APC)](http://www.php.net/manual/en/book.apc.php) to store the table metadata. You can specify the lifetime of the metadata with options. (Recommended for Production).                                                                                                     | `Phalcon\Mvc\Model\MetaData\Apc`          |
| Files        | This adapter uses plain files to store metadata. This adapter reduces database queries but has an increased I/O with the file system.                                                                                                                                                                                    | `Phalcon\Mvc\Model\MetaData\Files`        |
| Libmemcached | This adapter uses the [Memcached Server](https://www.memcached.org/) to store the table metadata. The server parameters as well as the cache lifetime are specified in the options. (Recommended for Production)                                                                                                         | `Phalcon\Mvc\Model\MetaData\Libmemcached` |
| Memcache     | This adapter uses [Memcache](http://php.net/manual/en/book.memcache.php) to store the table metadata. You can specify the lifetime of the metadata with options. (Recommended for Production)                                                                                                                            | `Phalcon\Mvc\Model\MetaData\Memcache`     |
| Memory       | This adapter is the default. The metadata is cached only during the request. When the request is completed, the metadata are released as part of the normal memory of the request. (Recommended for Development)                                                                                                         | `Phalcon\Mvc\Model\MetaData\Memory`       |
| Redis        | This adapter uses [Redis](https://redis.io/) to store the table metadata. The server parameters as well as the cache lifetime are specified in the options. (Recommended for Production).                                                                                                                                | `Phalcon\Mvc\Model\MetaData\Redis`        |
| Session      | This adapter stores metadata in the `$_SESSION` superglobal. This adapter is recommended only when the application is actually using a small number of models. The metadata are refreshed every time a new session starts. This also requires the use of `session_start()` to start the session before using any models. | `Phalcon\Mvc\Model\MetaData\Session`      |
| XCache       | This adapter uses [XCache](http://xcache.lighttpd.net/) to store the table metadata. You can specify the lifetime of the metadata with options. This is one of the recommended ways to store metadata when the application is in production.                                                                             | `Phalcon\Mvc\Model\MetaData\Xcache`       |

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

<a name='metadata-strategies'></a>

## Metadata Strategies

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

<a name='strategies-database-introspection'></a>

### Database Introspection Strategy

This strategy doesn't require any customization and is implicitly used by all the metadata adapters.

<a name='strategies-annotations'></a>

### Annotations Strategy

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

| Name     | Description                                       |
| -------- | ------------------------------------------------- |
| Primary  | Mark the field as part of the table's primary key |
| Identity | The field is an auto_increment/serial column      |
| Column   | This marks an attribute as a mapped column        |

The annotation `@Column` supports the following parameters:

| Name                 | Description                                                                                                                                                                   |
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

<a name='strategies-manual'></a>

## Manual Metadata

Phalcon can obtain the metadata for each model automatically without the developer must set them manually using any of the introspection strategies presented above.

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