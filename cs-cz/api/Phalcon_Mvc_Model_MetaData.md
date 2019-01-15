* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Model\MetaData'

* * *

# Abstract class **Phalcon\Mvc\Model\MetaData**

*implements* [Phalcon\Di\InjectionAwareInterface](/4.0/en/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\Mvc\Model\MetaDataInterface](/4.0/en/api/Phalcon_Mvc_Model_MetaDataInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/model/metadata.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Because Phalcon\Mvc\Model requires meta-data like field names, data types, primary keys, etc. this component collect them and store for further querying by Phalcon\Mvc\Model. Phalcon\Mvc\Model\MetaData can also use adapters to store temporarily or permanently the meta-data.

A standard Phalcon\Mvc\Model\MetaData can be used to query model attributes:

```php
<?php

$metaData = new \Phalcon\Mvc\Model\MetaData\Memory();

$attributes = $metaData->getAttributes(
    new Robots()
);

print_r($attributes);

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

final protected **_initialize** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $key, *mixed* $table, *mixed* $schema)

Initialize the metadata for certain table

public **setDI** ([Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector)

Sets the DependencyInjector container

public **getDI** ()

Returns the DependencyInjector container

public **setStrategy** ([Phalcon\Mvc\Model\MetaData\StrategyInterface](/4.0/en/api/Phalcon_Mvc_Model_MetaData_StrategyInterface) $strategy)

Set the meta-data extraction strategy

public **getStrategy** ()

Return the strategy to obtain the meta-data

final public **readMetaData** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Reads the complete meta-data for certain model

```php
<?php

print_r(
    $metaData->readMetaData(
        new Robots()
    )
);

```

final public **readMetaDataIndex** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $index)

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

final public **writeMetaDataIndex** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $index, *mixed* $data)

Writes meta-data for certain model using a MODEL_* constant

```php
<?php

print_r(
    $metaData->writeMetaDataIndex(
        new Robots(),
        MetaData::MODELS_REVERSE_COLUMN_MAP,
        [
            "leName" => "name",
        ]
    )
);

```

final public **readColumnMap** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Reads the ordered/reversed column map for certain model

```php
<?php

print_r(
    $metaData->readColumnMap(
        new Robots()
    )
);

```

final public **readColumnMapIndex** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $index)

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

public **getAttributes** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Returns table attributes names (fields)

```php
<?php

print_r(
    $metaData->getAttributes(
        new Robots()
    )
);

```

public **getPrimaryKeyAttributes** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Returns an array of fields which are part of the primary key

```php
<?php

print_r(
    $metaData->getPrimaryKeyAttributes(
        new Robots()
    )
);

```

public **getNonPrimaryKeyAttributes** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Returns an array of fields which are not part of the primary key

```php
<?php

print_r(
    $metaData->getNonPrimaryKeyAttributes(
        new Robots()
    )
);

```

public **getNotNullAttributes** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Returns an array of not null attributes

```php
<?php

print_r(
    $metaData->getNotNullAttributes(
        new Robots()
    )
);

```

public **getDataTypes** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Returns attributes and their data types

```php
<?php

print_r(
    $metaData->getDataTypes(
        new Robots()
    )
);

```

public **getDataTypesNumeric** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Returns attributes which types are numerical

```php
<?php

print_r(
    $metaData->getDataTypesNumeric(
        new Robots()
    )
);

```

public *string* **getIdentityField** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Returns the name of identity field (if one is present)

```php
<?php

print_r(
    $metaData->getIdentityField(
        new Robots()
    )
);

```

public **getBindTypes** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Returns attributes and their bind data types

```php
<?php

print_r(
    $metaData->getBindTypes(
        new Robots()
    )
);

```

public **getAutomaticCreateAttributes** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Returns attributes that must be ignored from the INSERT SQL generation

```php
<?php

print_r(
    $metaData->getAutomaticCreateAttributes(
        new Robots()
    )
);

```

public **getAutomaticUpdateAttributes** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Returns attributes that must be ignored from the UPDATE SQL generation

```php
<?php

print_r(
    $metaData->getAutomaticUpdateAttributes(
        new Robots()
    )
);

```

public **setAutomaticCreateAttributes** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *array* $attributes)

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

public **setAutomaticUpdateAttributes** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *array* $attributes)

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

public **setEmptyStringAttributes** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *array* $attributes)

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

public **getEmptyStringAttributes** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Returns attributes allow empty strings

```php
<?php

print_r(
    $metaData->getEmptyStringAttributes(
        new Robots()
    )
);

```

public **getDefaultValues** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Returns attributes (which have default values) and their default values

```php
<?php

print_r(
    $metaData->getDefaultValues(
        new Robots()
    )
);

```

public **getColumnMap** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Returns the column map if any

```php
<?php

print_r(
    $metaData->getColumnMap(
        new Robots()
    )
);

```

public **getReverseColumnMap** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model)

Returns the reverse column map if any

```php
<?php

print_r(
    $metaData->getReverseColumnMap(
        new Robots()
    )
);

```

public **hasAttribute** ([Phalcon\Mvc\ModelInterface](/4.0/en/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $attribute)

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

public **isEmpty** ()

Checks if the internal meta-data container is empty

```php
<?php

var_dump(
    $metaData->isEmpty()
);

```

public **reset** ()

Resets internal meta-data in order to regenerate it

```php
<?php

$metaData->reset();

```

abstract public **read** (*mixed* $key) inherited from [Phalcon\Mvc\Model\MetaDataInterface](/4.0/en/api/Phalcon_Mvc_Model_MetaDataInterface)

...

abstract public **write** (*mixed* $key, *mixed* $data) inherited from [Phalcon\Mvc\Model\MetaDataInterface](/4.0/en/api/Phalcon_Mvc_Model_MetaDataInterface)

...