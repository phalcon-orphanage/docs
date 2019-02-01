---
layout: article
language: 'id-id'
version: '4.0'
---
**This article reflects v3.4 and has not yet been revised**

<a name='models-metadata'></a>

# Models Metadata

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

<a name='caching-metadata'></a>

## Caching Metadata

Once the application is in a production stage, it is not necessary to query the metadata of the table from the database system each time you use the table. This could be done caching the metadata using any of the following adapters:

| Adaptor      | Deskripsi                                                                                                                                                                                                                                                                                                     | API                                                                                        |
| ------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------ |
| Apc          | This adapter uses the [Alternative PHP Cache (APC)](https://secure.php.net/manual/en/book.apc.php) to store the table metadata. Anda dapat menentukan seumur hidup metadata dengan opsi. (Disarankan untuk Produksi).                                                                                         | [Phalcon\Mvc\Model\MetaData\Apc](api/Phalcon_Mvc_Model_MetaData_Apc)                   |
| File         | This adapter uses plain files to store metadata. This adapter reduces database queries but has an increased I/O with the file system.                                                                                                                                                                         | [Phalcon\Mvc\Model\MetaData\Files](api/Phalcon_Mvc_Model_MetaData_Files)               |
| Libmemcached | Adaptor ini menggunakan [Memcached Server](https://www.memcached.org/) untuk menyimpan metadata tabel. Parameter server dan juga masa pakai cache ditentukan dalam pilihan. (Disarankan untuk Produksi)                                                                                                       | [Phalcon\Mvc\Model\MetaData\Libmemcached](api/Phalcon_Mvc_Model_MetaData_Libmemcached) |
| Memcache     | This adapter uses [Memcache](https://php.net/manual/en/book.memcache.php) to store the table metadata. Anda dapat menentukan seumur hidup metadata dengan opsi. (Disarankan untuk Produksi)                                                                                                                   | `Phalcon\Mvc\Model\MetaData\MEmcache`                                                  |
| Memory       | Adaptor ini adalah defaultnya. Metadata hanya di-cache selama permintaan. Saat permintaan selesai, metadata dilepaskan sebagai bagian dari memori normal permintaan. (Disarankan untuk pengembangan)                                                                                                          | [Phalcon\Mvc\Model\MetaData\Memory](api/Phalcon_Mvc_Model_MetaData_Memory)             |
| Redis        | This adapter uses [Redis](https://redis.io/) to store the table metadata. Parameter server dan juga masa pakai cache ditentukan dalam pilihan. (Disarankan untuk Produksi).                                                                                                                                   | [Phalcon\Mvc\Model\MetaData\Redis](api/Phalcon_Mvc_Model_MetaData_Redis)               |
| Session      | Adaptor ini menyimpan metadata di superglobal `$_SESSION`. Adaptor ini hanya disarankan bila aplikasi benar-benar menggunakan sejumlah kecil model. Metadata disegarkan setiap kali sesi baru dimulai. Ini juga memerlukan penggunaan `session_start ()` untuk memulai sesi sebelum menggunakan model apapun. | [Phalcon\Mvc\Model\MetaData\Session](api/Phalcon_Mvc_Model_MetaData_Session)           |
| XCache       | This adapter uses [XCache](https://xcache.lighttpd.net/) to store the table metadata. Anda dapat menentukan seumur hidup metadata dengan opsi. Ini adalah salah satu cara yang disarankan untuk menyimpan metadata saat aplikasi dalam produksi.                                                              | [Phalcon\Mvc\Model\MetaData\Xcache](api/Phalcon_Mvc_Model_MetaData_Xcache)             |

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

## Strategi Metadata

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

### Strategi Introspeksi Database

This strategy doesn't require any customization and is implicitly used by all the metadata adapters.

<a name='strategies-annotations'></a>

### Strategi Anotasi

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

| Nama      | Deskripsi                                           |
| --------- | --------------------------------------------------- |
| Utama     | Tandai bidang sebagai bagian dari kunci utama tabel |
| Identitas | Bidang adalah kolom auto_increment / serial         |
| Kolom     | Ini menandai atribut sebagai kolom yang dipetakan   |

The annotation `@Column` supports the following parameters:

| Nama                 | Deskripsi                                                                                                                                                                     |
| -------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| column               | Real column name                                                                                                                                                              |
| jenis                | The column's types: varchar/string (default), text, char, json, tinyblob, blob, mediumblob, longblob, integer, biginteger, float, decimal, date, datetime, timestamp, boolean |
| panjang              | Panjang kolom jika ada                                                                                                                                                        |
| nullable             | Tetapkan apakah kolom menerima nilai null atau tidak                                                                                                                          |
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

## Metadata manual

Using the introspection strategies presented above, Phalcon can obtain the metadata for each model automatically without the developer needing to set them manually.

The developer also has the option of define the metadata manually. This strategy overrides any strategy set in the metadata manager. New columns added/modified/removed to/from the mapped table must be added/modified/removed also for everything to work properly.

The following example shows how to define the metadata manually:

```php
& lt; ? php 

menggunakan Phalcon \ Mvc \ Model; gunakan Phalcon \ Db \ Column; gunakan Phalcon \ Mvc \ Model \ MetaData; class Robots memanjang Model {
     public function metaData ()
     {
         return array (
             // Setiap kolom di tabel yang dipetakan
             MetaData :: MODELS_ATTRIBUTES = & gt; [
                 'id',
                 'name',
                 'type',
                 'year',
             ],

             // Setiap kolom bagian dari primary key
             MetaData :: MODELS_PRIMARY_KEY = & gt; [
                 'id',
             ],

             // Setiap kolom yang bukan merupakan bagian dari primary key
             MetaData :: MODELS_NON_PRIMARY_KEY = & gt; [
                 'name',
                 'type',
                            ],

             // Setiap kolom yang tidak memungkinkan nilai null
             MetaData :: MODELS_NOT_NULL = & gt; [
                 'id',
                 'name',
                 'type',
             ],

             // Setiap kolom dan tipe data mereka
             MetaData :: MODELS_DATA_TYPES = & gt; [
                 'id' = & gt; Kolom :: TYPE_INTEGER,
                 'nama' = & gt; Kolom :: TYPE_VARCHAR,
                 'type' = & gt; Kolom :: TYPE_VARCHAR,
                 'year' = & gt; Kolom :: TYPE_INTEGER,
             ],

             // Kolom yang memiliki tipe data numerik
             MetaData :: MODELS_DATA_TYPES_NUMERIC = & gt;                benar,
                 'tahun' = & gt; true,
             ],

             // Kolom identitas, gunakan false boolean jika model tidak memiliki
             // kolom identitas
             MetaData :: MODELS_IDENTITY_COLUMN = & gt; 'id',

             // Bagaimana setiap kolom harus diikat / dicor
             MetaData :: MODELS_DATA_TYPES_BIND = & gt; [
                 'id' = & gt; Kolom :: BIND_PARAM_INT,
                 'nama' = & gt; Kolom :: BIND_PARAM_STR,
                 'type' = & gt; Kolom :: BIND_PARAM_STR,
                 'year' = & gt; Kolom :: BIND_PARAM_INT,
             ],

                        MetaData :: MODELS_AUTOMATIC_DEFAULT_INSERT = & gt; [
                 'year' = & gt; true,
             ],

             // Fields yang harus diabaikan dari statemen SQL UPDATE
             MetaData :: MODELS_AUTOMATIC_DEFAULT_UPDATE = & gt; [
                 'year' = & gt; true,
             ],

             // Nilai default untuk kolom
             MetaData :: MODELS_DEFAULT_VALUES = & gt; [
                 'year' = & gt; '2015',
             ],

             // Bidang yang memungkinkan string kosong
             MetaData :: MODELS_EMPTY_STRING_VALUES = & gt; [
                 'nama' = & gt; benar,
             ],
         );
    
```