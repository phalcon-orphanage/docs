---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Collection'
---
# Abstract class **Phalcon\Mvc\Collection**

*implements* [Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface), [Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Serializable](https://php.net/manual/en/class.serializable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/collection.zep)

Komponen ini mengimplementasikan sebuah abstraksi tingkat tinggi untuk NoSQL database yang bekerja dengan dokumen

## Constants

*bilangan bulat* **OP_NONE**

*bilangan bulat* **OP_CREATE**

*bilangan bulat* **OP_UPDATE**

*bilangan bulat* **OP_DELETE**

*bilangan bulat* **DIRTY_STATE_PERSISTENT**

*bilangan bulat* **DIRTY_STATE_TRANSIENT**

*bilangan bulat* **DIRTY_STATE_DETACHED**

## Metode

final public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector], [[Phalcon\Mvc\Collection\ManagerInterface](Phalcon_Mvc_Collection_ManagerInterface) $modelsManager])

Phalcon\Mvc\Collection constructor

public **setId** (*mixed* $id)

Set nilai untuk properti _id, menciptakan sebuah objek MongoId jika diperlukan

umum *MongoId* **getId**)

Mengembalikan nilai _id properti

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Menetapkan ketergantungan injeksi wadah

publik **mendapatkanDI** ()

Kembali wadah injeksi ketergantungan

protected **setEventsManager** ([Phalcon\Mvc\Collection\ManagerInterface](Phalcon_Mvc_Collection_ManagerInterface) $eventsManager)

Set manajer acara kustom

dilindungi (**getEventsManager**)

Kembali manajer acara kustom

umum **getCollectionManager**)

Kembali pengelola model yang berkaitan dengan contoh entitas

umum **getReservedAttributes**)

Mengembalikan array dengan sifat yang dilindungi undang-undang yang tidak dapat menjadi bagian dari insert/update

dilindungi **useImplicitObjectIds** (*campuran* $useImplicitObjectIds)

Set jika model harus menggunakan Id objek implisit

dilindungi **setSource** (*campuran* $source)

Menetapkan nama koleksi model mana harus dipetakan

publik **mendapatkan Sumber** ()

Mengembalikan nama koleksi yang dipetakan dalam model

umum **setConnectionService** (*campuran* $connectionService)

Menetapkan nama layanan sambungan DependencyInjection

umum **getConnectionService**)

Kembali DependencyInjection sambungan layanan

umum *MongoDb* **getConnection**)

Mengambil koneksi database

public *mixed* **readAttribute** (*string* $attribute)

Membaca nilai atribut dengan nama

```php
<? php echo $robot -> readAttribute("name");

```

public **writeAttribute** (*string* $attribute, *mixed* $value)

Menulis nilai atribut dengan nama

```php
<? php $robot -> writeAttribute ("nama", "Rosey");

```

public static **cloneResult** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $collection, *array* $document)

Kembali koleksi clone

protected static *array* **_getResultset** (*array* $params, [Phalcon\Mvc\Collection](Phalcon_Mvc_Collection) $collection, *MongoDb* $connection, *boolean* $unique)

Mengembalikan hasil ditetapkan koleksi

protected static *int* **_getGroupResultset** (*array* $params, [Phalcon\Mvc\Collection](Phalcon_Mvc_Collection) $collection, *MongoDb* $connection)

Lakukan hitungan di atas hasil ditetapkan

final protected *boolean* **_preSave** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector, *boolean* $disableEvents, *boolean* $exists)

Jalankan kait internal sebelum menyimpan dokumen

final protected **_postSave** (*mixed* $disableEvents, *mixed* $success, *mixed* $exists)

Jalankan peristiwa internal setelah menyimpan dokumen

protected **validate** (*mixed* $validator)

Jalankan validator pada setiap panggilan validasi

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

Periksa apakah proses validasi telah menghasilkan pesan apa pun

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

Membakar acara internal

public **fireEventCancel** (*mixed* $eventName)

Membakar peristiwa internal yang membatalkan operasi

protected **_cancelOperation** (*mixed* $disableEvents)

Batalkan operasi saat ini

protected *boolean* **_exists** (*MongoCollection* $collection)

Memeriksa apakah dokumen ada dalam koleksi

public **getMessages** ()

Mengembalikan semua pesan validasi

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

Menambahkan pesan yang disesuaikan pada proses validasi

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

Kode Bersama untuk Operasi CU Mempersiapkan Koleksi

public **save** ()

Membuat / memperbarui kumpulan berdasarkan nilai atribut

public **create** ()

Membuat koleksi berdasarkan nilai atribut

public **createIfNotExist** (*array* $criteria)

Membuat dokumen berdasarkan nilai atribut, jika tidak ditemukan kriteria. Cara yang dipilih untuk menghindari duplikasi adalah membuat indeks atribut.

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

Membuat / memperbarui kumpulan berdasarkan nilai atribut

public static **findById** (*mixed* $id)

Temukan dokumen dengan idnya (_id)

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

Memungkinkan untuk query catatan pertama yang sesuai dengan kondisi yang ditentukan

```php
<?php

// Apa robot pertama di meja robot?
$robot = Robots::findFirst(); echo "adalah nama robot", $robot -> nama, "\n"; Apakah robot mekanis pertama dalam tabel robot?
$robot = Robots::findFirst ([["jenis" = > "mekanikal"]]);  echo "adalah nama mekanis robot pertama", $robot -> nama, "\n";  Dapatkan robot virtual pertama yang diperintahkan oleh $robot nama = Robots::findFirst ([["jenis" = > "mekanikal"], "perintah" = > ["nama" = > 1,],]);  echo "adalah nama virtual robot pertama", $robot -> nama, "\n";  Dapatkan robot pertama dengan id (_id) $robot = Robots::findFirst ([["_id" = > baru \MongoId("45cbc4a0e4123f6920000002"),]]);  echo "robot id adalah", $robot -> _id, "\n";

```

umum statis **menemukan** ([*array* $parameters])

Memungkinkan untuk query serangkaian catatan yang cocok dengan persyaratan yang ditetapkan

```php
<?php

// How many robots are there?
$robots = Robots::find(); echo "Ada", count($robots), "\n"; Robot mekanis berapa banyak Apakah ada?
$robots = Robots::find ([["jenis" = > "mekanikal"]]); echo "Ada", count(robots), "\n"; Mendapatkan dan mencetak virtual robot diperintahkan nama $robots = Robots::findFirst ([["jenis" = > "virtual"], "perintah" = > ["name" = > 1,]]); foreach ($robots sebagai $robot) {echo $robot -> nama, "\n";} / / Dapatkan robot virtual pertama 100 yang diperintahkan nama $robots = Robots::find ([["jenis" = > "virtual",], "perintah" = > ["name" = > 1,], "batas "= > 100,]); foreach ($robots sebagai $robot) {echo $robot -> nama, "\n";}

```

umum statis **count** ([*array* $parameters])

Melakukan hitungan atas koleksi

```php
<?php

echo "There are ", Robots::count(), " robots";

```

public static **aggregate** ([*array* $parameters])

Lakukan agregasi dengan menggunakan kerangka agregasi Mongo

public static **summatory** (*mixed* $field, [*mixed* $conditions], [*mixed* $finalize])

Memungkinkan untuk melakukan kelompok penjumlahan untuk kolom dalam koleksi

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

Set kotor keadaan objek menggunakan salah satu DIRTY_STATE_* konstanta

public **getDirtyState** ()

Mengembalikan salah satu konstanta DIRTY_STATE_ * yang memberitahukan jika dokumen itu ada dalam koleksi atau tidak

protected **addBehavior** ([Phalcon\Mvc\Collection\BehaviorInterface](Phalcon_Mvc_Collection_BehaviorInterface) $behavior)

Menetapkan perilaku dalam koleksi

public **skipOperation** (*mixed* $skip)

Melompati operasi saat ini yang memaksa negara sukses

publik **kunci** ()

Mengembalikan instance sebagai representasi array

```php
<?php

print_r(
    $robot->toArray()
);

```

publik **getName** ()

Serializes objek mengabaikan koneksi atau properti yang dilindungi

public ** beforeStore ** ( * mixed * $data)

Unserializes objek dari string serial