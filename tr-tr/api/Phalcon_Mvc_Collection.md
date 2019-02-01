---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Mvc\Collection'
---
# Abstract class **Phalcon\Mvc\Collection**

*implements* [Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface), [Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Serializable](https://php.net/manual/en/class.serializable.php)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/collection.zep)

Bu bileşen, belgelerle çalışan NoSQL veritabanları için üst düzey bir soyutlama işlemi uygular

## Sabitler

*integer* **OP_NONE**

*integer* **OP_CREATE**

*integer* **OP_UPDATE**

*integer* **OP_DELETE**

*integer* **DIRTY_STATE_PERSISTENT**

*integer* **DIRTY_STATE_TRANSIENT**

*integer* **DIRTY_STATE_DETACHED**

## Metodlar

final public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector], [[Phalcon\Mvc\Collection\ManagerInterface](Phalcon_Mvc_Collection_ManagerInterface) $modelsManager])

Phalcon\Mvc\Collection constructor

public **setId** (*mixed* $id)

_id özelliği için bir değer ayarlar, eğer gerekirse bir MongoId nesnesi oluşturur

public *MongoId* **getId** ()

Kimlik özelliğinin_ değerini döndürür

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Bağımlılık enjeksiyonu kapsayıcısını ayarlar

public **getDI** ()

Bağımlılık enjeksiyonu kapsayıcısını döndürür

protected **setEventsManager** ([Phalcon\Mvc\Collection\ManagerInterface](Phalcon_Mvc_Collection_ManagerInterface) $eventsManager)

Özel olay yöneticisini ayarlar

protected **getEventsManager** ()

Özel olay yöneticisini döndürür

public **getCollectionManager** ()

Varlık örneğine ilişkin model yöneticisini geri getirir

public **getReservedAttributes** ()

Ayrılmış özelliklere sahip, yerleştir/güncelle nin bir parçası olamayan bir satırı geri getirir

protected **useImplicitObjectIds** (*mixed* $useImplicitObjectIds)

Bir modelin örtük nesne kimlikleri kullanmasının, gerekip gerekmediğini ayarlar

protected **setSource** (*mixed* $source)

Modelin eşlenmesi gereken koleksiyon adını ayarlar

public **getSource** ()

Modelin eşlenmesi gereken koleksiyon adını döndürür

public **setConnectionService** (*mixed* $connectionService)

Bağımlılık enjeksiyon bağlantısının servis adını ayarlar

public **getConnectionService** ()

Bağımlılık enjeksiyon bağlantısının servis adını döndürür

public *MongoDb* **getConnection** ()

Bir veri tabanı bağlantısını geri çağırır

public *mixed* **readAttribute** (*string* $attribute)

Bir nitelik değerini onun adıyla okur

```php
<?php

echo $robot->readAttribute("name");

```

public **writeAttribute** (*string* $attribute, *mixed* $value)

Bir nitelik değerini onun adıyla yazar

```php
<?php

$robot->writeAttribute("name", "Rosey");

```

public static **cloneResult** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $collection, *array* $document)

Çoğaltılmış bir koleksiyonu döndürür

protected static *array* **_getResultset** (*array* $params, [Phalcon\Mvc\Collection](Phalcon_Mvc_Collection) $collection, *MongoDb* $connection, *boolean* $unique)

Bir koleksiyon sonuç setini döndürür

protected static *int* **_getGroupResultset** (*array* $params, [Phalcon\Mvc\Collection](Phalcon_Mvc_Collection) $collection, *MongoDb* $connection)

Bir sonuç seti üzerinden hesap yapar

final protected *boolean* **_preSave** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector, *boolean* $disableEvents, *boolean* $exists)

Belgeyi kaydetmeden önce dahili kancaları çalıştırır

final protected **_postSave** (*mixed* $disableEvents, *mixed* $success, *mixed* $exists)

Bir belge kaydettikten sonra dahili durumları yürütür

protected **validate** (*mixed* $validator)

Her doğrulama çağrısında doğrulayıcıları yürütür

```php
<?php

use Phalcon\Mvc\Model\Validator\ExclusionIn as ExclusionIn;

class Subscriptors extends \Phalcon\Mvc\Collection
{
    public function validation()
    {
        // Old, deprecated syntax, use new one below
        $this->validate(
            new ExclusionIn(
                [
                    "field"  => "status",
                    "domain" => ["A", "I"],
                ]
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}

```

```php
<?php

use Phalcon\Validation\Validator\ExclusionIn as ExclusionIn;
use Phalcon\Validation;

class Subscriptors extends \Phalcon\Mvc\Collection
{
    public function validation()
    {
        $validator = new Validation();
        $validator->add("status",
            new ExclusionIn(
                [
                    "domain" => ["A", "I"]
                ]
            )
        );

        return $this->validate($validator);
    }
}

```

public **validationHasFailed** ()

Doğrulama süreci herhangi bir mesaj üretilip üretilmediğini denetler

```php
<?php

use Phalcon\Mvc\Model\Validator\ExclusionIn as ExclusionIn;

class Subscriptors extends \Phalcon\Mvc\Collection
{
    public function validation()
    {
        $this->validate(
            new ExclusionIn(
                [
                    "field"  => "status",
                    "domain" => ["A", "I"],
                ]
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}

```

public **fireEvent** (*mixed* $eventName)

Dahili olayı tetikler

public **fireEventCancel** (*mixed* $eventName)

İşlemi iptal eden dahili bir olayı tetikler

protected **_cancelOperation** (*mixed* $disableEvents)

Geçerli işlemi iptal et

protected *boolean* **_exists** (*MongoCollection* $collection)

Belgenin koleksiyonda olup olmadığını denetler

public **getMessages** ()

Tüm doğrulama iletilerini döndürür

```php
<?php

$robot = new Robots();

$robot->type = "mechanical";
$robot->name = "Astro Boy";
$robot->year = 1952;

if ($robot->save() === false) {
    echo "Umh, We can't store robots right now ";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message;
    }
} else {
    echo "Great, a new robot was saved successfully!";
}

```

public **appendMessage** ([Phalcon\Mvc\Model\MessageInterface](Phalcon_Mvc_Model_MessageInterface) $message)

Doğrulama sürecinde özelleştirilmiş bir ileti ekler

```php
<?php

use \Phalcon\Mvc\Model\Message as Message;

class Robots extends \Phalcon\Mvc\Model
{
    public function beforeSave()
    {
        if ($this->name === "Peter") {
            $message = new Message(
                "Sorry, but a robot cannot be named Peter"
            );

            $this->appendMessage(message);
        }
    }
}

```

protected **prepareCU** ()

Shared Code for CU Operations Prepares Collection

public **save** ()

Nitelik değerlerine dayanan bir koleksiyon oluşturur/günceller

public **create** ()

Nitelik değerlerine dayalı bir koleksiyon oluşturur

public **createIfNotExist** (*array* $criteria)

Kriterlere göre bulunmazsa, niteliklerdeki değerlere dayalı bir belge oluşturur Tekrarlamayı önlemek için tercih edilen yol, nitelik için dizin oluşturmaktır

```php
<?php

$robot = new Robot();

$robot->name = "MyRobot";
$robot->type = "Droid";

// Create only if robot with same name and type does not exist
$robot->createIfNotExist(
    [
        "name",
        "type",
    ]
);

```

public **update** ()

Nitelik değerlerine dayanan bir koleksiyon oluşturur/günceller

public static **findById** (*mixed* $id)

Kimliği ile bir belge bulur(_kimlik)

```php
<?php

// Find user by using \MongoId object
$user = Users::findById(
    new \MongoId("545eb081631d16153a293a66")
);

// Find user by using id as sting
$user = Users::findById("45cbc4a0e4123f6920000002");

// Validate input
if ($user = Users::findById($_POST["id"])) {
    // ...
}

```

public static **findFirst** ([*array* $parameters])

Belirtilen koşullarla eşleşen ilk kaydın sorgulanmasına izin verir

```php
<?php

// What's the first robot in the robots table?
$robot = Robots::findFirst();

echo "The robot name is ", $robot->name, "\n";

// What's the first mechanical robot in robots table?
$robot = Robots::findFirst(
    [
        [
            "type" => "mechanical",
        ]
    ]
);

echo "The first mechanical robot name is ", $robot->name, "\n";

// Get first virtual robot ordered by name
$robot = Robots::findFirst(
    [
        [
            "type" => "mechanical",
        ],
        "order" => [
            "name" => 1,
        ],
    ]
);

echo "The first virtual robot name is ", $robot->name, "\n";

// Get first robot by id (_id)
$robot = Robots::findFirst(
    [
        [
            "_id" => new \MongoId("45cbc4a0e4123f6920000002"),
        ]
    ]
);

echo "The robot id is ", $robot->_id, "\n";

```

public static **find** ([*array* $parameters])

Belirtilen koşullarla eşleşen bir kayıt kümesinin sorgulanmasına izin verir

```php
<?php

// Orada kaç tane robot var?
$robots = Robots::find();

echo "There are ", count($robots), "\n";

// How many mechanical robots are there?
$robots = Robots::find(
    [
        [
            "type" => "mechanical",
        ]
    ]
);

echo "There are ", count(robots), "\n";

// Get and print virtual robots ordered by name
$robots = Robots::findFirst(
    [
        [
            "type" => "virtual"
        ],
        "order" => [
            "name" => 1,
        ]
    ]
);

foreach ($robots as $robot) {
   echo $robot->name, "\n";
}

// Get first 100 virtual robots ordered by name
$robots = Robots::find(
    [
        [
            "type" => "virtual",
        ],
        "order" => [
            "name" => 1,
        ],
        "limit" => 100,
    ]
);

foreach ($robots as $robot) {
   echo $robot->name, "\n";
}

```

public static **count** ([*array* $parameters])

Perform a count over a collection

```php
<?php

echo "There are ", Robots::count(), " robots";

```

public static **aggregate** ([*array* $parameters])

Perform an aggregation using the Mongo aggregation framework

public static **summatory** (*mixed* $field, [*mixed* $conditions], [*mixed* $finalize])

Koleksiyondaki bir sütun için bir toplam grup gerçekleştirme işlemine izin verir

public **delete** ()

Deletes a model instance. Returning true on success or false otherwise.

```php
<?php

$robot = Robots::findFirst();

$robot->delete();

$robots = Robots::find();

foreach ($robots as $robot) {
    $robot->delete();
}

```

public **setDirtyState** (*mixed* $dirtyState)

ONAYLANMAYAN_DURUM_* sabitlerinden birini kullanarak nesnenin onaylanmayan durumunu ayarlar

public **getDirtyState** ()

Belgenin koleksiyonda olup olmadığını söyleyen ONAYLANMAYAN_DURUM * sabitlerinden birini döndürür

protected **addBehavior** ([Phalcon\Mvc\Collection\BehaviorInterface](Phalcon_Mvc_Collection_BehaviorInterface) $behavior)

Bir koleksiyonda bir davranış belirler

public **skipOperation** (*mixed* $skip)

Bir başarı durumunu zorlayarak geçerli işlemi atlar

public **toArray** ()

Örneği bir dizi gösterimi biçiminde döndürür

```php
<?php

print_r(
    $robot->toArray()
);

```

public **serialize** ()

Bağlantıları veya korumalı özellikleri göz ardı ederek nesneyi seri hale getirir

public **unserialize** (*mixed* $data)

Nesneyi serileştirilmiş bir dizeden serileştirilmemiş hale getirir