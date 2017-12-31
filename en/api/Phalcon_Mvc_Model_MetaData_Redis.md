# Class **Phalcon\\Mvc\\Model\\MetaData\\Redis**

*extends* abstract class [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

*implements* [Phalcon\Mvc\Model\MetaDataInterface](/en/3.1.2/api/Phalcon_Mvc_Model_MetaDataInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.1.2/api/Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/metadata/redis.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Stores model meta-data in the Redis.

By default meta-data is stored for 48 hours (172800 seconds)

```php
<?php

use Phalcon\Mvc\Model\Metadata\Redis;

$metaData = new Redis(
    [
        "host"       => "127.0.0.1",
        "port"       => 6379,
        "persistent" => 0,
        "statsKey"   => "_PHCM_MM",
        "lifetime"   => 172800,
        "index"      => 2,
    ]
);

```

## Constants
*integer* **MODELS_ATTRIBUTES**

*integer* **MODELS_PRIMARY_KEY**

*integer* **MODELS_NON_PRIMARY_KEY**

*integer* **MODELS_NOT_NULL**

*integer* **MODELS_DATA_TYPES**

*integer* **MODELS_DATA_TYPES_NUMERIC**

*integer* **MODELS_DATE_AT**

*integer* **MODELS_DATE_IN**

*integer* **MODELS_IDENTITY_COLUMN**

*integer* **MODELS_DATA_TYPES_BIND**

*integer* **MODELS_AUTOMATIC_DEFAULT_INSERT**

*integer* **MODELS_AUTOMATIC_DEFAULT_UPDATE**

*integer* **MODELS_DEFAULT_VALUES**

*integer* **MODELS_EMPTY_STRING_VALUES**

*integer* **MODELS_COLUMN_MAP**

*integer* **MODELS_REVERSE_COLUMN_MAP**

## Methods
public  **__construct** ([*array* $options])

Phalcon\\Mvc\\Model\\MetaData\\Redis constructor

public  **read** (*mixed* $key)

Reads metadata from Redis

public  **write** (*mixed* $key, *mixed* $data)

Writes the metadata to Redis

public  **reset** ()

Flush Redis data and resets internal meta-data in order to regenerate it

final protected  **_initialize** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $key, *mixed* $table, *mixed* $schema) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Initialize the metadata for certain table

public  **setDI** ([Phalcon\DiInterface](/en/3.1.2/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Sets the DependencyInjector container

public  **getDI** () inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns the DependencyInjector container

public  **setStrategy** ([Phalcon\Mvc\Model\MetaData\StrategyInterface](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData_StrategyInterface) $strategy) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Set the meta-data extraction strategy

public  **getStrategy** () inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Return the strategy to obtain the meta-data

final public  **readMetaData** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Reads the complete meta-data for certain model

```php
<?php

print_r(
    $metaData->readMetaData(
        new Robots()
    )
);

```

final public  **readMetaDataIndex** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $index) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Reads meta-data for certain model

```php
<?php

print_r(
    $metaData->readMetaDataIndex(
        new Robots(),
        0
    )
);

```

final public  **writeMetaDataIndex** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $index, *mixed* $data) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Writes meta-data for certain model using a MODEL_* constant

```php
<?php

print_r(
    $metaData->writeColumnMapIndex(
        new Robots(),
        MetaData::MODELS_REVERSE_COLUMN_MAP,
        [
            "leName" => "name",
        ]
    )
);

```

final public  **readColumnMap** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Reads the ordered/reversed column map for certain model

```php
<?php

print_r(
    $metaData->readColumnMap(
        new Robots()
    )
);

```

final public  **readColumnMapIndex** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $index) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Reads column-map information for certain model using a MODEL_* constant

```php
<?php

print_r(
    $metaData->readColumnMapIndex(
        new Robots(),
        MetaData::MODELS_REVERSE_COLUMN_MAP
    )
);

```

public  **getAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns table attributes names (fields)

```php
<?php

print_r(
    $metaData->getAttributes(
        new Robots()
    )
);

```

public  **getPrimaryKeyAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns an array of fields which are part of the primary key

```php
<?php

print_r(
    $metaData->getPrimaryKeyAttributes(
        new Robots()
    )
);

```

public  **getNonPrimaryKeyAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns an array of fields which are not part of the primary key

```php
<?php

print_r(
    $metaData->getNonPrimaryKeyAttributes(
        new Robots()
    )
);

```

public  **getNotNullAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns an array of not null attributes

```php
<?php

print_r(
    $metaData->getNotNullAttributes(
        new Robots()
    )
);

```

public  **getDataTypes** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns attributes and their data types

```php
<?php

print_r(
    $metaData->getDataTypes(
        new Robots()
    )
);

```

public  **getDataTypesNumeric** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns attributes which types are numerical

```php
<?php

print_r(
    $metaData->getDataTypesNumeric(
        new Robots()
    )
);

```

public *string* **getIdentityField** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns the name of identity field (if one is present)

```php
<?php

print_r(
    $metaData->getIdentityField(
        new Robots()
    )
);

```

public  **getBindTypes** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns attributes and their bind data types

```php
<?php

print_r(
    $metaData->getBindTypes(
        new Robots()
    )
);

```

public  **getAutomaticCreateAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns attributes that must be ignored from the INSERT SQL generation

```php
<?php

print_r(
    $metaData->getAutomaticCreateAttributes(
        new Robots()
    )
);

```

public  **getAutomaticUpdateAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns attributes that must be ignored from the UPDATE SQL generation

```php
<?php

print_r(
    $metaData->getAutomaticUpdateAttributes(
        new Robots()
    )
);

```

public  **setAutomaticCreateAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model, *array* $attributes) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Set the attributes that must be ignored from the INSERT SQL generation

```php
<?php

$metaData->setAutomaticCreateAttributes(
    new Robots(),
    [
        "created_at" => true,
    ]
);

```

public  **setAutomaticUpdateAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model, *array* $attributes) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Set the attributes that must be ignored from the UPDATE SQL generation

```php
<?php

$metaData->setAutomaticUpdateAttributes(
    new Robots(),
    [
        "modified_at" => true,
    ]
);

```

public  **setEmptyStringAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model, *array* $attributes) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Set the attributes that allow empty string values

```php
<?php

$metaData->setEmptyStringAttributes(
    new Robots(),
    [
        "name" => true,
    ]
);

```

public  **getEmptyStringAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns attributes allow empty strings

```php
<?php

print_r(
    $metaData->getEmptyStringAttributes(
        new Robots()
    )
);

```

public  **getDefaultValues** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns attributes (which have default values) and their default values

```php
<?php

print_r(
    $metaData->getDefaultValues(
        new Robots()
    )
);

```

public  **getColumnMap** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns the column map if any

```php
<?php

print_r(
    $metaData->getColumnMap(
        new Robots()
    )
);

```

public  **getReverseColumnMap** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Returns the reverse column map if any

```php
<?php

print_r(
    $metaData->getReverseColumnMap(
        new Robots()
    )
);

```

public  **hasAttribute** ([Phalcon\Mvc\ModelInterface](/en/3.1.2/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $attribute) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Check if a model has certain attribute

```php
<?php

var_dump(
    $metaData->hasAttribute(
        new Robots(),
        "name"
    )
);

```

public  **isEmpty** () inherited from [Phalcon\Mvc\Model\MetaData](/en/3.1.2/api/Phalcon_Mvc_Model_MetaData)

Checks if the internal meta-data container is empty

```php
<?php

var_dump(
    $metaData->isEmpty()
);

```

