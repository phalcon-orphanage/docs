---
layout: default
language: 'es-es'
version: '4.0'
title: 'Metadatos de modelos'
keywords: 'modelo, caché, metadatos, campos de consulta'
---

# Metadatos de Modelo

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Cuando usamos clases [Phalcon\Mvc\Model](api/Phalcon_Mvc#mvc-model), que corresponden a tablas actuales en la base de datos, Phalcon necesita saber información esencial sobre esas tablas, como campos, tipos de datos, claves primarias y ajenas, así como relaciones. El objeto [Phalcon\Mvc\Model\MetaData](api/Phalcon_Mvc#mvc-model-metadata) ofrece esta funcionalidad, transparentemente consulta la base de datos y genera los datos necesarios desde el esquema de base de datos. Los datos se pueden almacenar en un almacén de datos (tipo Redis, APCu, etc.) para asegurar que la base de datos no se consulta por el esquema cada vez que se ejecuta una consulta.

> **NOTA**: Durante los despliegues a producción, por favor asegúrese que siempre invalida el caché metaData para que los cambios de la base de datos que se propagaron durante su despliegue estén disponibles en su aplicación. El caché metaData se reconstruirá con todos los cambios necesarios.
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

El código anterior imprimirá los nombres de los campos y también los campos al vector de tipos de campo. Usamos `attributes` como un alias de `fields`.

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

## Constantes

[Phalcon\Mvc\Model\MetaData](api/Phalcon_Mvc#mvc-model-metadata) expone un número de constantes que se pueden usar para obtener atributos de la colección interna.

| Nombre                            | Descripción                                                                   |
| --------------------------------- | ----------------------------------------------------------------------------- |
| `MODELS_ATTRIBUTES`               | Cada columna en la tabla mapeada                                              |
| `MODELS_AUTOMATIC_DEFAULT_INSERT` | Campos que se deben ignorar de las sentencias SQL `INSERT`                    |
| `MODELS_AUTOMATIC_DEFAULT_UPDATE` | Campos que se deben ignorar de las sentencias SQL `UPDATE`                    |
| `MODELS_COLUMN_MAP`               | Mapa de columna (alias)                                                       |
| `MODELS_DATA_TYPES`               | Cada columna y su tipo de datos                                               |
| `MODELS_DATA_TYPES_BIND`          | Como se debe vincular/convertir cada columna                                  |
| `MODELS_DATA_TYPES_NUMERIC`       | Las columnas que tienen tipos de datos numéricos                              |
| `MODELS_DEFAULT_VALUES`           | Valores por defecto para las columnas                                         |
| `MODELS_EMPTY_STRING_VALUES`      | Columnas que permiten cadenas vacías                                          |
| `MODELS_IDENTITY_COLUMN`          | La columna identidad. `false` si el modelo no tiene ninguna columna identidad |
| `MODELS_NON_PRIMARY_KEY`          | Cada columna que no sea parte de la clave primaria                            |
| `MODELS_NOT_NULL`                 | Cada columna que no permita valores `null`                                    |
| `MODELS_PRIMARY_KEY`              | Cada columna que sea parte de la clave primaria                               |
| `MODELS_REVERSE_COLUMN_MAP`       | Mapa de columna inverso (alias)                                               |

## Métodos

```php
public function getAttributes(ModelInterface $model): array
```

Devuelve los nombres de los atributos de la tabla (campos)

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

Devuelve los atributos que deben ser ignorados de la generación SQL del `INSERT`

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

Devuelve los atributos que deben ser ignorados de la generación SQL del `UPDATE`

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

Devuelve los atributos y sus tipos de datos de enlace

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

Devuelve el mapa de columnas si lo hay

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

Devuelve los atributos (que tienen valores por defecto) y sus valores por defecto

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

Devuelve los atributos y sus tipos de datos

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

Devuelve los atributos con tipos numéricos

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

Devuelve atributos que permiten cadenas vacías

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

Devuelve el nombre del campo identidad (si hay uno presente)

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

Devuelve un vector de campos que no forman parte de la clave primaria

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

Devuelve un vector de atributos no nulos

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

Devuelve un vector de campos que forman parte de la clave primaria

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

Devuelve el mapa de columnas inverso si existe

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

Devuelve la estrategia para obtener los metadatos

```php
public function hasAttribute(
    ModelInterface $model, 
    string $attribute
): bool
```

Comprueba si un modelo tiene cierto atributo

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

Comprueba si el contenedor de metadatos interno está vacío

```php
print_r(
    $metaData->isEmpty()
);
```

```php
public function read(string $key): array | null
```

Lee los metadatos del adaptador

```php
final public function readColumnMap(
    ModelInterface $model
): array | null
```

Lee el mapa de columnas ordenado/inverso para cierto modelo

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

Lee información del mapa de columnas para cierto modelo usando la constante `MODEL_*`

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

Lee los metadatos completos para cierto modelo

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

Lee los metadatos para cierto modelo

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

Resetea los metadatos internos para regenerarlos

```php
 $metaData->reset();
```

```php
public function setAutomaticCreateAttributes(
    ModelInterface $model, 
    array $attributes
): void
```

Establece los atributos que se deben ignorar en la generación SQL del `INSERT`

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

Establece los atributos que se deben ignorar en la generación SQL del `UPDATE`

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

Establece los atributos que permiten valores de cadena vacía

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

Establece la estrategia de extracción de metadatos

```php
public function write(string $key, array $data): void
```

Escribe los metadatos al adaptador

```php
final public function writeMetaDataIndex(
    ModelInterface $model, 
    int $index, 
    mixed $data
): void
```

Escribe metadatos para cierto modelo usando una constante `MODEL_*`

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

Inicializa los metadatos para cierta tabla

## Adaptadores

Obtener los metadatos es una operación de base de datos costosa y ciertamente no queremos ejecutarla cada vez que se ejecute una consulta. Sin embargo, podemos usar uno de los muchos adaptadores disponibles para almacenar en caché los metadatos.

> **NOTA**: Para desarrollo local, el adaptador [Phalcon\Mvc\Models\MetaData\Memory](api/Phalcon_Mvc#mvc-model-metadata-memory) se recomienda para que cualquier cambio en la base de datos se refleje inmediatamente. 
{: .alert .alert-info }
 
| Adaptador                                                                                       | Descripción                                                                                                                                          |
| ----------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Mvc\Models\MetaData\Apcu](api/Phalcon_Mvc#mvc-model-metadata-apcu)                 | Este adaptador usa [Alternative PHP Cache (APC)](https://www.php.net/manual/en/book.apcu.php) para almacenar los metadatos de la tabla. (producción) |
| [Phalcon\Mvc\Models\MetaData\Libmemcached](api/Phalcon_Mvc#mvc-model-metadata-libmemcached) | Este adaptador usa [Memcached Server](https://www.memcached.org) para almacenar los metadatos de la tabla. (producción)                              |
| [Phalcon\Mvc\Models\MetaData\Memory](api/Phalcon_Mvc#mvc-model-metadata-memory)             | Este adaptador usa la memoria. Los metadatos se almacenan en caché sólo durante la petición. (desarrollo)                                            |
| [Phalcon\Mvc\Models\MetaData\Redis](api/Phalcon_Mvc#mvc-model-metadata-redis)               | Este adaptador usa [Redis](https://redis.io) para almacenar los metadatos de la tabla. (producción)                                                  |
| [Phalcon\Mvc\Models\MetaData\Stream](api/Phalcon_Mvc#mvc-model-metadata-stream)             | Este adaptador usa ficheros planos para almacenar los metadatos. (no para producción)                                                                |

### APCu

Este adaptador usa [Alternative PHP Cache (APC)](https://www.php.net/manual/en/book.apcu.php) para almacenar los metadatos de la tabla. La extensión debe estar presente en su sistema para que funcione este caché de metadatos. Si el servidor se reinicia, los datos se perderán. Este adaptador es apropiado para aplicaciones en producción.

El adaptador recibe una clase [Phalcon\Cache\AdapterFactory](cache#adapter-factory) para instanciar el objeto de caché relevante. También puede pasar un vector con opciones adicionales para que el caché opere.

El prefijo predeterminado es `ph-mm-apcu-` y el tiempo de vida es `172.000` (48 horas).

```php
<?php

use Phalcon\Cache\AdapterFactory;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Model\MetaData\Apcu;
use Phalcon\Storage\SerializerFactory;

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

Este adaptador usa [Memcached Server](https://www.memcached.org) para almacenar los metadatos de la tabla. La extensión debe estar presente en su sistema para que funcione este caché de metadatos. Este adaptador es apropiado para aplicaciones en producción.

El adaptador recibe una clase [Phalcon\Cache\AdapterFactory](cache#adapter-factory) para instanciar el objeto de caché relevante. También puede pasar un vector con opciones adicionales para que el caché opere.

El prefijo predeterminado es `ph-mm-memc-` y el tiempo de vida es `172.000` (48 horas). `persistenId` está preconfigurado a `php-mm-mcid-`.

```php
<?php

use Phalcon\Cache\AdapterFactory;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Model\MetaData\Libmemcached;
use Phalcon\Storage\SerializerFactory;

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

Este adaptador usa la memoria del servidor para almacenar el caché de metadatos. El cache está disponible sólo durante la petición, y después el caché se pierde. Este caché es más apropiado para desarrollo, ya que se adapta a los cambios frecuentes en la base de datos durante el desarrollo.

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

Este adaptador usa [Redis](https://redis.io) para almacenar los metadatos de la tabla. La extensión debe estar presente en su sistema para que funcione este caché de metadatos. Este adaptador es apropiado para aplicaciones en producción.

El adaptador recibe una clase [Phalcon\Cache\AdapterFactory](cache#adapter-factory) para instanciar el objeto de caché relevante. También puede pasar un vector con opciones adicionales para que el caché opere.

El prefijo predeterminado es `ph-mm-reds-` y el tiempo de vida es `172.000` (48 horas).

```php
<?php

use Phalcon\Cache\AdapterFactory;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Model\MetaData\Redis;
use Phalcon\Storage\SerializerFactory;

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

### Flujo (Stream)

Este adaptador usa el sistema de ficheros para almacenar los metadatos de la tabla. Este adaptador es apropiado para aplicaciones de producción pero no es recomendable ya que introduce un aumento de E/S.

El adaptador puede aceptar una opción `metaDataDir` con un directorio donde almacenar los metadatos. El directorio por defecto es el directorio actual.

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

Puede usar la opción `orm.exception_on_failed_metadata_save` en su fichero `php.ini` para forzar que el componente lance una excepción si hay algún error almacenando los metadatos o si el directorio destino no es escribible.

```ini
orm.exception_on_failed_metadata_save = true
```

## Estrategias

La estrategia por defecto para obtener los metadatos del modelo es la introspección de la base de datos. Utilizando esta estrategia, el esquema de información se usa para identificar los campos de una tabla, su clave primaria, campos nulos, tipos de datos, etc.

```php
<?php

use Phalcon\Cache\AdapterFactory;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Model\MetaData\Apcu;
use Phalcon\Mvc\Model\MetaData\Strategy\Introspection;
use Phalcon\Storage\SerializerFactory;

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

### Introspección

Esta estrategia no necesita ninguna personalización y se usa implícitamente por todos los adaptadores de metadatos.

### Anotaciones

Esta estrategia hace uso de [anotaciones](annotations) para describir las columnas de un modelo.

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

Las anotaciones deben colocarse en propiedades que se asignan a columnas en la fuente mapeada. Las propiedades sin la anotación `@Column` se gestionan como atributos de clase simples.

Se soportan las siguientes anotaciones:

| Nombre      | Descripción                                                |
| ----------- | ---------------------------------------------------------- |
| `@Primary`  | Marca el campo como parte de la clave primaria de la tabla |
| `@Identity` | El campo es una columna `auto_increment/serial`            |
| `@Column`   | Esto marca un atributo como una columna mapeada            |

La anotación `@Column` soporta los siguientes parámetros:

| Nombre               | Descripción                                                                                                                                                                                                               |
| -------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `column`             | Nombre de la columna real                                                                                                                                                                                                 |
| `type`               | El tipo de la columna: `char`, `biginteger`, `blob`, `boolean`, `date`, `datetime`, `decimal`, `integer`, `float`, `json`, `longblob`, `mediumblob`, `timestamp`, `tinyblob`, `text`, `varchar`/`string` (predeterminado) |
| `length`             | El tamaño de la columna si hay                                                                                                                                                                                            |
| `nullable`           | Establece si la columna acepta valores `null` o no                                                                                                                                                                        |
| `skip_on_insert`     | Omite esta columna al insertar                                                                                                                                                                                            |
| `skip_on_update`     | Omite esta columna al actualizar                                                                                                                                                                                          |
| `allow_empty_string` | La columna permite cadenas vacías                                                                                                                                                                                         |
| `default`            | Valor por defecto                                                                                                                                                                                                         |

La estrategia de anotaciones se podría configurar de la siguiente manera:

```php
<?php

use Phalcon\Cache\AdapterFactory;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Model\MetaData\Apcu;
use Phalcon\Mvc\Model\MetaData\Strategy\Annotations;
use Phalcon\Storage\SerializerFactory;

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

Usando las estrategias de introspección presentadas anteriormente, Phalcon puede obtener los metadatos de cada modelo automáticamente. Sin embargo, tiene la opción de definir los metadatos manualmente. Esta estrategia anula cualquier estrategia que se haya configurado en el gestor de metadatos. Las columnas añadidas, modificadas o eliminadas de la tabla mapeada se deben actualizar manualmente en el modelo para que todo funcione correctamente.

Para configurar los metadatos, usamos el método `metaData` en un modelo:

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

### Personalizado

Phalcon ofrece el interfaz [Phalcon\Mvc\Model\MetaData\Strategy\StrategyInterface](api/Phalcon_Mvc#mvc-model-metadata-strategyinterface), que le permite crear su propia clase de Estrategia.

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
