---
layout: default
language: 'es-es'
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

// Obtener instancia de Phalcon\Mvc\Model\Metadata
$metadata = $robot->getModelsMetaData();

// Obtener nombres de los campos de los robots
$attributes = $metadata->getAttributes($robot);
print_r($attributes);

// Obtener tipos de datos de los campos de los robots
$dataTypes = $metadata->getDataTypes($robot);
print_r($dataTypes);
```

## Caching

Once the application is in a production stage, it is not necessary to query the metadata of the table from the database system each time you use the table. This could be done caching the metadata using any of the following adapters:

| Adaptador    | Descripción                                                                                                                                                                                                                            | API                                                                                        |
| ------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------ |
| Apc          | Este adaptador utiliza [Alternative PHP Cache (APC)](https://secure.php.net/manual/en/book.apc.php) para almacenar los metadatos de tabla. Puede especificar la duración de los metadatos con opciones. (Recomendado para producción). | [Phalcon\Mvc\Model\MetaData\Apc](api/Phalcon_Mvc_Model_MetaData_Apc)                   |
| Files        | Este adaptador utiliza archivos planos para almacenar los metadatos. Este adaptador reduce las consultas a la base de datos, pero puede incrementar el acceso al sistema de archivos.                                                  | [Phalcon\Mvc\Model\MetaData\Files](api/Phalcon_Mvc_Model_MetaData_Files)               |
| Libmemcached | This adapter uses the [Memcached Server](https://www.memcached.org) to store the table metadata. Los parámetros de servidor así como la duración de la caché se especifica en las opciones. (Recomendado para producción)              | [Phalcon\Mvc\Model\MetaData\Libmemcached](api/Phalcon_Mvc_Model_MetaData_Libmemcached) |
| Memory       | This adapter is the default. The metadata is cached only during the request. When the request is completed, the metadata are released as part of the normal memory of the request. (Recommended for Development)                       | [Phalcon\Mvc\Model\MetaData\Memory](api/Phalcon_Mvc_Model_MetaData_Memory)             |
| Redis        | This adapter uses [Redis](https://redis.io) to store the table metadata. Los parámetros de servidor así como la duración de la caché se especifica en las opciones. (Recomendado para producción).                                     | [Phalcon\Mvc\Model\MetaData\Redis](api/Phalcon_Mvc_Model_MetaData_Redis)               |

As other ORM's dependencies, the metadata manager is requested from the services container:

```php
<?php

use Phalcon\Mvc\Model\MetaData\Apc as ApcMetaData;

$di['modelsMetadata'] = function () {
    // Creamos un gestor de metadatos con APC
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
    // Instanciar un adaptador de metadata
    $metadata = new ApcMetaData(
        [
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ]
    );

    // Configurar una estratégia personalizada de instrospección
    $metadata->setStrategy(
        new MyIntrospectionStrategy()
    );

    return $metadata;
};
```

### Introspection

This strategy doesn't require any customization and is implicitly used by all the metadata adapters.

### Anotaciones

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

| Nombre   | Descripción                                                 |
| -------- | ----------------------------------------------------------- |
| Primary  | Marcar el campo como parte de la clave primaria de la tabla |
| Identity | El campo es una columna auto_increment/serial               |
| Column   | Esto marca un atributo como una columna mapeada             |

The annotation `@Column` supports the following parameters:

| Nombre               | Descripción                                                                                                                                                                      |
| -------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| column               | Nombre real de la columna                                                                                                                                                        |
| type                 | Tipos de columnas: varchar/string (por defecto), text, char, json, tinyblob, blob, mediumblob, longblob, integer, biginteger, float, decimal, date, datetime, timestamp, boolean |
| length               | Longitud de la columna, si lo hubiere                                                                                                                                            |
| nullable             | Si la columna acepta valores null o no                                                                                                                                           |
| skip_on_insert     | Omitir esta columna al insertar                                                                                                                                                  |
| skip_on_update     | Omitir esta columna al actualizar                                                                                                                                                |
| allow_empty_string | Esta columna permite cadenas vacías                                                                                                                                              |
| default              | Valor por defecto                                                                                                                                                                |

The annotations strategy could be set up this way:

```php
<?php

use Phalcon\Mvc\Model\MetaData\Apc as ApcMetaData;
use Phalcon\Mvc\Model\MetaData\Strategy\Annotations as StrategyAnnotations;

$di['modelsMetadata'] = function () {
    // Instancia del adaptador de metadata 
    $metadata = new ApcMetaData(
        [
            'lifetime' => 86400,
            'prefix'   => 'my-prefix',
        ]
    );

    // Configurar un introspección personalizada para la base de datos
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
            // Cada columna en la tabla asignada
            MetaData::MODELS_ATTRIBUTES => [
                'id',
                'name',
                'type',
                'year',
            ],

            // Cada columna que es parte de la clave primaria
            MetaData::MODELS_PRIMARY_KEY => [
                'id',
            ],

            // Columnas que no son parte de la clave primaria
            MetaData::MODELS_NON_PRIMARY_KEY => [
                'name',
                'type',
                'year',
            ],

            // Columnas que no permiten valores nulos
            MetaData::MODELS_NOT_NULL => [
                'id',
                'name',
                'type',
            ],

            // Cada columna con su tipo de datos
            MetaData::MODELS_DATA_TYPES => [
                'id'   => Column::TYPE_INTEGER,
                'name' => Column::TYPE_VARCHAR,
                'type' => Column::TYPE_VARCHAR,
                'year' => Column::TYPE_INTEGER,
            ],

            // Columnas que tienen tipos de datos numéricos
            MetaData::MODELS_DATA_TYPES_NUMERIC => [
                'id'   => true,
                'year' => true,
            ],

            // Columna identidad, utilizar false si el modelo no tiene una columna identidad
            MetaData::MODELS_IDENTITY_COLUMN => 'id',

            // Como deben enlazarse y clasificarse las columnas
            MetaData::MODELS_DATA_TYPES_BIND => [
                'id'   => Column::BIND_PARAM_INT,
                'name' => Column::BIND_PARAM_STR,
                'type' => Column::BIND_PARAM_STR,
                'year' => Column::BIND_PARAM_INT,
            ],

            // Campos que deben ser ignorados en las instrucciones SQL INSERT
            MetaData::MODELS_AUTOMATIC_DEFAULT_INSERT => [
                'year' => true,
            ],

            // Campos que deben ser ignorados en instrucciones SQL UPDATE
            MetaData::MODELS_AUTOMATIC_DEFAULT_UPDATE => [
                'year' => true,
            ],

            // Valores por defecto de las columnas
            MetaData::MODELS_DEFAULT_VALUES => [
                'year' => '2015',
            ],

            // Campos que permiten string vacios
            MetaData::MODELS_EMPTY_STRING_VALUES => [
                'name' => true,
            ],
        );
    }
}
```