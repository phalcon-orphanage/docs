# Class **Phalcon\\Mvc\\Model\\MetaData\\Memory**

*extends* abstract class [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

*implements* [Phalcon\Mvc\Model\MetaDataInterface](/en/3.2/api/Phalcon_Mvc_Model_MetaDataInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.2/api/Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/metadata/memory.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Stores model meta-data in memory. Data will be erased when the request finishes

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

Phalcon\\Mvc\\Model\\MetaData\\Memory constructor

public *array* **read** (*string* $key)

Meta verileri zamansal hafıza üzerinden okur

public **write** (*string* $key, *array* $data)

Meta verileri zamansal hafıza üzerine yazar

final protected **_initialize** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $key, *mixed* $table, *mixed* $schema) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Belirli bir tabloya yönelik meta verileri başlatın

public **setDI** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

DependencyInjector kutusunu ayarlar

public **getDI** () inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

DependencyInjector kutusunu döndürür

public **setStrategy** ([Phalcon\Mvc\Model\MetaData\StrategyInterface](/en/3.2/api/Phalcon_Mvc_Model_MetaData_StrategyInterface) $strategy) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Meta-verisi çıkarma stratejisini ayarlayın

public **getStrategy** () inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Return the strategy to obtain the meta-data

final public **readMetaData** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Belirli bir modele yönelik meta-verisinin tamamını okur

```php
<?php

print_r(
    $metaData->readMetaData(
        new Robots()
    )
);

```

final public **readMetaDataIndex** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $index) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

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

Reads the ordered/reversed column map for certain model

```php
<?php

print_r(
    $metaData->readColumnMap(
        new Robots()
    )
);

```

final public **readColumnMapIndex** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model, *mixed* $index) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

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

public **getAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

(Alanları) yani tablo nitelikleri isimlerini döndürür

```php
<?php

print_r(
    $metaData->getAttributes(
        new Robots()
    )
);

```

public **getPrimaryKeyAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Birincil anahtarın sahip olduğu alanlardan meydana gelen bir dizi döndürür

```php
<?php

print_r(
    $metaData->getPrimaryKeyAttributes(
        new Robots()
    )
);

```

public **getNonPrimaryKeyAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Birincil anahtarda yer almayan alanlardan oluşan bir diziyi geri getirir

```php
<?php

print_r(
    $metaData->getNonPrimaryKeyAttributes(
        new Robots()
    )
);

```

public **getNotNullAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Geçersiz olmayan niteliklere ait bir dizi döndürür

```php
<?php

print_r(
    $metaData->getNotNullAttributes(
        new Robots()
    )
);

```

public **getDataTypes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Nitelikleri ve onlara ait veri türlerini döndürür

```php
<?php

print_r(
    $metaData->getDataTypes(
        new Robots()
    )
);

```

public **getDataTypesNumeric** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Türleri sayısal olan nitelikleri döndürür

```php
<?php

print_r(
    $metaData->getDataTypesNumeric(
        new Robots()
    )
);

```

public *string* **getIdentityField** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

(Eğer bulunuyorsa) kimlik alanının ismini döndürür

```php
<?php

print_r(
    $metaData->getIdentityField(
        new Robots()
    )
);

```

public **getBindTypes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Nitelikleri ve bunların sarılmış haldeki veri türlerini döndürür

```php
<?php

print_r(
    $metaData->getBindTypes(
        new Robots()
    )
);

```

public **getAutomaticCreateAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

INSERT SQL nesnesinde görmezden gelinmesi gereken nitelikleri döndürür

```php
<?php

print_r(
    $metaData->getAutomaticCreateAttributes(
        new Robots()
    )
);

```

public **getAutomaticUpdateAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

UPDATE SQL nesnesinde görmezden gelinmesi gereken nitelikleri döndürür

```php
<?php

print_r(
    $metaData->getAutomaticUpdateAttributes(
        new Robots()
    )
);

```

public **setAutomaticCreateAttributes** ([Phalcon\Mvc\ModelInterface](/en/3.2/api/Phalcon_Mvc_ModelInterface) $model, *array* $attributes) inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

INSERT SQL nesnesinde görmezden gelinmesi gereken nitelikleri ayarlayın

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

UPDATE SQL nesnesinden görmezden gelinmesi gereken nitelikleri ayarlayın

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

Dahili meta-veri kutusunun boş olup olmadığını kontrol eder

```php
<?php

var_dump(
    $metaData->isEmpty()
);

```

public **reset** () inherited from [Phalcon\Mvc\Model\MetaData](/en/3.2/api/Phalcon_Mvc_Model_MetaData)

Yeniden üretebilmek amacıyla dahili meta veriyi sıfırlar

```php
<?php

$metaData->reset();

```