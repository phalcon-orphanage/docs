# Class **Phalcon\\Mvc\\Model\\MetaData\\Libmemcached**

*extends* abstract class [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

*implements* [Phalcon\Mvc\Model\MetaDataInterface](/en/3.2/api/Phalcon_Mvc_Model_MetaDataInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.2/api/Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/metadata/libmemcached.zep" class="btn btn-default btn-sm">GitHub üzerindeki kaynak</a>

Stores model meta-data in the Memcache.

By default meta-data is stored for 48 hours (172800 seconds)

```php
<?php

$metaData = new Phalcon\Mvc\Model\Metadata\Libmemcached(
    [
        "servers" => [
            [
                "host"   => "localhost",
                "port"   => 11211,
                "weight" => 1,
            ],
        ],
        "client" => [
            Memcached::OPT_HASH       => Memcached::HASH_MD5,
            Memcached::OPT_PREFIX_KEY => "prefix.",
        ],
        "lifetime" => 3600,
        "prefix"   => "my_",
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

public **__construct** ([*array* $options])

Phalcon\\Mvc\\Model\\MetaData\\Libmemcached constructor

public **read** (*mixed* $key)

Reads metadata from Memcache

public **write** (*mixed* $key, *mixed* $data)

Writes the metadata to Memcache

public **reset** ()

Flush Memcache data and resets internal meta-data in order to regenerate it

final protected **_initialize** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $key, *mixed* $table, *mixed* $schema) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Initialize the metadata for certain table

public **setDI** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Sets the DependencyInjector container

public **getDI** () inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

DependencyInjector kutusunu döndürür

public **setStrategy** ([Phalcon\Mvc\Model\MetaData\StrategyInterface](/en/3.2/api/Phalcon_Mvc_Model_MetaData_StrategyInterface) $strategy) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Set the meta-data extraction strategy

public **getStrategy** () inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Meta-veriyi elde edebilmek için bir strateji döndürün

final public **readMetaData** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Reads the complete meta-data for certain model

```php
<?php

print_r(
    $metaData->readMetaData(
        new Robots()
    )
);

```

final public **readMetaDataIndex** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $index) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Belirli bir modele yönelik meta-verileri okur

```php
<?php

print_r(
    $metaData->readMetaDataIndex(
        new Robots(),
        0
    )
);

```

final public **writeMetaDataIndex** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $index, *mixed* $data) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

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

final public **readColumnMap** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Belli bir modele yönelik sıralı yada ters haldeki sütun haritasını okur

```php
<?php

print_r(
    $metaData->readColumnMap(
        new Robots()
    )
);

```

final public **readColumnMapIndex** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $index) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

MODEL_ * sabitini kullanması sayesinde belirli model için sütun haritası bilgilerini okuyabilir

```php
<?php

print_r(
    $metaData->readColumnMapIndex(
        new Robots(),
        MetaData::MODELS_REVERSE_COLUMN_MAP
    )
);

```

public **getAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Tablo nitelik isimlerini (alanları) döndürür

```php
<?php

print_r(
    $metaData->getAttributes(
        new Robots()
    )
);

```

public **getPrimaryKeyAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Birincil anahtara ait olan alanlardan meydana gelen bir dizi döndürür

```php
<?php

print_r(
    $metaData->getPrimaryKeyAttributes(
        new Robots()
    )
);

```

public **getNonPrimaryKeyAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Returns an array of fields which are not part of the primary key

```php
<?php

print_r(
    $metaData->getNonPrimaryKeyAttributes(
        new Robots()
    )
);

```

public **getNotNullAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Returns an array of not null attributes

```php
<?php

print_r(
    $metaData->getNotNullAttributes(
        new Robots()
    )
);

```

public **getDataTypes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Returns attributes and their data types

```php
<?php

print_r(
    $metaData->getDataTypes(
        new Robots()
    )
);

```

public **getDataTypesNumeric** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Returns attributes which types are numerical

```php
<?php

print_r(
    $metaData->getDataTypesNumeric(
        new Robots()
    )
);

```

public *string* **getIdentityField** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Returns the name of identity field (if one is present)

```php
<?php

print_r(
    $metaData->getIdentityField(
        new Robots()
    )
);

```

public **getBindTypes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Öz nitelikleri ve bunlara ait bağlı veri çeşitlerini döndürür

```php
<?php

print_r(
    $metaData->getBindTypes(
        new Robots()
    )
);

```

public **getAutomaticCreateAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Returns attributes that must be ignored from the INSERT SQL generation

```php
<?php

print_r(
    $metaData->getAutomaticCreateAttributes(
        new Robots()
    )
);

```

public **getAutomaticUpdateAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Returns attributes that must be ignored from the UPDATE SQL generation

```php
<?php

print_r(
    $metaData->getAutomaticUpdateAttributes(
        new Robots()
    )
);

```

public **setAutomaticCreateAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model, *array* $attributes) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

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

public **setAutomaticUpdateAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model, *array* $attributes) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

UPDATE SQL nesnesinde görmezden gelinmesi gereken nitelikleri ayarlayın

```php
<?php

$metaData->setAutomaticUpdateAttributes(
    new Robots(),
    [
        "modified_at" => true,
    ]
);

```

public **setEmptyStringAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model, *array* $attributes) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Boş dize değerlerine imkan sağlayan öznitelikleri ayarlayın

```php
<?php

$metaData->setEmptyStringAttributes(
    new Robots(),
    [
        "name" => true,
    ]
);

```

public **getEmptyStringAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Boş dizelere imkan veren nitelikleri döndürür

```php
<?php

print_r(
    $metaData->getEmptyStringAttributes(
        new Robots()
    )
);

```

public **getDefaultValues** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

(Varsayılan değerlere sahip olan) öz nitelikler ve bunların varsayılan değerlerini döndürür

```php
<?php

print_r(
    $metaData->getDefaultValues(
        new Robots()
    )
);

```

public **getColumnMap** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Eğer varsa, sütun haritasını döndürür

```php
<?php

print_r(
    $metaData->getColumnMap(
        new Robots()
    )
);

```

public **getReverseColumnMap** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Eğer varsa ters sütun haritasını döndürür

```php
<?php

print_r(
    $metaData->getReverseColumnMap(
        new Robots()
    )
);

```

public **hasAttribute** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $attribute) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Bir modelin belirli bir özelliğe sahip olup olmadığını test edin

```php
<?php

var_dump(
    $metaData->hasAttribute(
        new Robots(),
        "name"
    )
);

```

public **isEmpty** () inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Dahili meta- veri kutusunun boş olup olmadığını denetler

```php
<?php

var_dump(
    $metaData->isEmpty()
);

```