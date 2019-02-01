---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Resultset'
---
# Abstract class **Phalcon\Mvc\Model\Resultset**

*implements* [Phalcon\Mvc\Model\ResultsetInterface](Phalcon_Mvc_Model_ResultsetInterface), [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php), [SeekableIterator](https://php.net/manual/en/class.seekableiterator.php), [Countable](https://php.net/manual/en/class.countable.php), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [Serializable](https://php.net/manual/en/class.serializable.php), [JsonSerializable](https://php.net/manual/en/class.jsonserializable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/resultset.zep)

This component allows to Phalcon\Mvc\Model returns large resultsets with the minimum memory consumption Resultsets can be traversed using a standard foreach or a while statement. Jika sebuah resultset diserialisasikan itu akan membuang semua baris ke array besar.   Konteks | Permintaan Konteks. Kemudian unserialize akan mengambil baris seperti mereka sebelum serialisasi.

```php
<?php

// Using a standard foreach
$robots = Robots::find(
    [
        "type = 'virtual'",
        "order" => "name",
    ]
);

foreach ($robots as robot) {
    echo robot->name, "\n";
}

// Using a while
$robots = Robots::find(
    [
        "type = 'virtual'",
        "order" => "name",
    ]
);

$robots->rewind();

while ($robots->valid()) {
    $robot = $robots->current();

    echo $robot->name, "\n";

    $robots->next();
}

```

## Constants

*integer* **TYPE_RESULT_FULL**

*integer* **TYPE_RESULT_PARTIAL**

*integer* **HYDRATE_RECORDS**

*integer* **HYDRATE_OBJECTS**

*integer* **HYDRATE_ARRAYS**

## Metode

public **__construct** ([Phalcon\Db\ResultInterface](Phalcon_Db_ResultInterface) | *false* $result, [[Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $cache])

Phalcon\Mvc\Model\Resultset constructor

publik **berikutnya** ()

Memindahkan kursor ke baris berikutnya di resultset

publik **sah** ()

Periksa apakah sumber internal memiliki baris untuk diambil

publik **kunci** ()

Mendapat nomor pointer dari baris aktif di resultset

final public **rewind** ()

Rewinds resultset to its beginning

final public **seek** (*mixed* $position)

Perubahan internal pointer ke posisi tertentu dalam resultset Mengatur posisi baru jika diperlukan dan mengatur ini->_row

final public **count** ()

Menghitung berapa banyak baris yang ada di resultset

public **offsetExists** (*mixed* $index)

Cek apakah offset ada di resultset

public **offsetGet** (*mixed* $index)

Mendapat baris pada posisi tertentu dari resultset

public **offsetSet** (*int* $index, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $value)

Resultsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface

public **offsetUnset** (*mixed* $offset)

Resultsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface

publik **berhenti** ()

Mengembalikan tipe internal pengambilan data yang digunakan oleh resultset

public **getFirst** ()

Dapatkan baris pertama di resultset

public **getLast** ()

Dapatkan baris terakhir di resultset

public **setIsFresh** (*mixed* $isFresh)

Atur apakah resultset sudah segar atau yang lama di-cache

publik ** isFresh </ 0> ()</p> 

Katakan jika resultset jika segar atau yang lama cache

public **setHydrateMode** (*mixed* $hydrateMode)

Sets the hydration mode in the resultset

public **getHydrateMode** ()

Returns the current hydration mode

public **getCache** ()

Kembali dikaitkan cache untuk resultset

public **getMessages** ()

Mengembalikan pesan galat yang dihasilkan oleh operasi batch

public *boolean* **update** (*array* $data, [[Closure](https://php.net/manual/en/class.closure.php) $conditionCallback])

Update setiap catatan dalam resultset

public **delete** ([[Closure](https://php.net/manual/en/class.closure.php) $conditionCallback])

Menghapus setiap catatan dalam resultset

public [Phalcon\Mvc\Model](Phalcon_Mvc_Model) **filter** (*callback* $filter)

Filters a resultset returning only those the developer requires

```php
<?php

$filtered = $robots->filter(
    function ($robot) {
        if ($robot->id < 3) {
            return $robot;
        }
    }
);

```

public *array* **jsonSerialize** ()

Returns serialised model objects as array for json_encode. Calls jsonSerialize on each object if present

```php
<?php

$robots = Robots::find();
echo json_encode($robots);

```

abstract public **toArray** () inherited from [Phalcon\Mvc\Model\ResultsetInterface](Phalcon_Mvc_Model_ResultsetInterface)

...

abstract public **current** () inherited from [Iterator](https://php.net/manual/en/class.iterator.php)

...

abstract public **serialize** () inherited from [Serializable](https://php.net/manual/en/class.serializable.php)

...

abstract public **unserialize** (*mixed* $serialized) inherited from [Serializable](https://php.net/manual/en/class.serializable.php)

...