---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Resultset\Complex'
---
# Class **Phalcon\Mvc\Model\Resultset\Complex**

*extends* abstract class [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

*implements* [JsonSerializable](https://php.net/manual/en/class.jsonserializable.php), [Serializable](https://php.net/manual/en/class.serializable.php), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [Countable](https://php.net/manual/en/class.countable.php), [SeekableIterator](https://php.net/manual/en/class.seekableiterator.php), [Traversable](https://php.net/manual/en/class.traversable.php), [Iterator](https://php.net/manual/en/class.iterator.php), [Phalcon\Mvc\Model\ResultsetInterface](Phalcon_Mvc_Model_ResultsetInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/resultset/complex.zep)

Complex resultsets may include complete objects and scalar values. This class builds every complex row as it is required

## Constants

*integer* **TYPE_RESULT_FULL**

*integer* **TYPE_RESULT_PARTIAL**

*integer* **HYDRATE_RECORDS**

*integer* **HYDRATE_OBJECTS**

*integer* **HYDRATE_ARRAYS**

## Metode

public **__construct** (*array* $columnTypes, [[Phalcon\Db\ResultInterface](Phalcon_Db_ResultInterface) $result], [[Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface) $cache])

Phalcon\Mvc\Model\Resultset\Complex constructor

publik akhir **saat ini** ()

Mengembalikan baris saat ini di resultset

publik **kunci** ()

Mengembalikan hasil lengkap yang ditetapkan sebagai array, jika resultset memiliki sejumlah besar baris, itu bisa menghabiskan lebih banyak memori daripada saat ini.

publik **getName** ()

Serializing sebuah resultset akan membuang semua baris yang terkait ke dalam array yang besar

public ** beforeStore ** ( * mixed * $data)

Unserializing sebuah resultset akan memungkinkan untuk hanya bekerja pada baris yang ada dalam keadaan tersimpan

public **next** () inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Memindahkan kursor ke baris berikutnya di resultset

public **valid** () inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Periksa apakah sumber internal memiliki baris untuk diambil

public **key** () inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Mendapat nomor pointer dari baris aktif di resultset

final public **rewind** () inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Rewinds resultset to its beginning

final public **seek** (*mixed* $position) inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Perubahan internal pointer ke posisi tertentu dalam resultset Mengatur posisi baru jika diperlukan dan mengatur ini->_row

final public **count** () inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Menghitung berapa banyak baris yang ada di resultset

public **offsetExists** (*mixed* $index) inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Cek apakah offset ada di resultset

public **offsetGet** (*mixed* $index) inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Mendapat baris pada posisi tertentu dari resultset

public **offsetSet** (*int* $index, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $value) inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Resultsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface

public **offsetUnset** (*mixed* $offset) inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Resultsets cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface

public **getType** () inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Mengembalikan tipe internal pengambilan data yang digunakan oleh resultset

public **getFirst** () inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Dapatkan baris pertama di resultset

public **getLast** () inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Dapatkan baris terakhir di resultset

public **setIsFresh** (*mixed* $isFresh) inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Atur apakah resultset sudah segar atau yang lama di-cache

public **isFresh** () inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Katakan jika resultset jika segar atau yang lama cache

public **setHydrateMode** (*mixed* $hydrateMode) inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Sets the hydration mode in the resultset

public **getHydrateMode** () inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Returns the current hydration mode

public **getCache** () inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Kembali dikaitkan cache untuk resultset

public **getMessages** () inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Mengembalikan pesan galat yang dihasilkan oleh operasi batch

public *boolean* **update** (*array* $data, [[Closure](https://php.net/manual/en/class.closure.php) $conditionCallback]) inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Update setiap catatan dalam resultset

public **delete** ([[Closure](https://php.net/manual/en/class.closure.php) $conditionCallback]) inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Menghapus setiap catatan dalam resultset

public [Phalcon\Mvc\Model](Phalcon_Mvc_Model) **filter** (*callback* $filter) inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

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

public *array* **jsonSerialize** () inherited from [Phalcon\Mvc\Model\Resultset](Phalcon_Mvc_Model_Resultset)

Returns serialised model objects as array for json_encode. Calls jsonSerialize on each object if present

```php
<?php

$robots = Robots::find();
echo json_encode($robots);

```