---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Registry'
---
# Final class **Phalcon\Registry**

*implements* [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [Countable](https://php.net/manual/en/class.countable.php), [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/registry.zep)

A registry is a container for storing objects and values in the application space. By storing the value in a registry, the same object is always available throughout your application.

```php
<?php

$registry = new \Phalcon\Registry();

// Set value
$registry->something = "something";
// or
$registry["something"] = "something";

// Get value
$value = $registry->something;
// or
$value = $registry["something"];

// Check if the key exists
$exists = isset($registry->something);
// or
$exists = isset($registry["something"]);

// Unset
unset($registry->something);
// or
unset($registry["something"]);

```

In addition to ArrayAccess, Phalcon\Registry also implements Countable (count($registry) will return the number of elements in the registry), Serializable and Iterator (you can iterate over the registry using a foreach loop) interfaces. For PHP 5.4 and higher, JsonSerializable interface is implemented.

Phalcon\Registry is very fast (it is typically faster than any userspace implementation of the registry); however, this comes at a price: Phalcon\Registry is a final class and cannot be inherited from.

Though Phalcon\Registry exposes methods like __get(), offsetGet(), count() etc, it is not recommended to invoke them manually (these methods exist mainly to match the interfaces the registry implements): $registry->__get("property") is several times slower than $registry->property.

Secara internal semua metode sihir (dan antarmuka kecuali JsonSerializable) di implementasikan menggunakan objek seorang pedagang atau tekhnik serupa: ini memungkinkan untuk memotong metode pemanggilan yang relatif lambat.

## Metode

publik **__membangun** ()

Konstruktor pendaftaran

final public **offsetExists** (*mixed* $offset)

Periksa jika elemen hadir dalam pendaftaran

final public **offsetGet** (*mixed* $offset)

Mengembalikan sebuah indeks dalam pendaftaran

final public **offsetSet** (*mixed* $offset, *mixed* $value)

Mengatur sebuah elemen dalam pendaftaran

final public **offsetUnset** (*mixed* $offset)

Tidak mengatur sebuah elemen dalam pendaftaran

final public **count** ()

Memeriksa berapa banyak elemen sedang dalam pendaftaran

final public **next** ()

Memindahkan jarum untuk baris selanjutnya dalam pendaftaran

final public **key** ()

Mendapatkan nomor petunjuk dari baris aktif dalam pendaftaran

final public **rewind** ()

Memutar balik pendaftaran jarum ke awal

publik **sah** ()

Memeriksa apakah iterator itu benar

public **current** ()

Memperoleh nilai saat ini dalam iterator internal

final public **__set** (*mixed* $key, *mixed* $value)

Mengatur sebuah elemen dalam pendaftaran

final public **__get** (*mixed* $key)

Mengembalikan sebuah indeks dalam pendaftaran

final public **__isset** (*mixed* $key)

...

final public **__unset** (*mixed* $key)

...