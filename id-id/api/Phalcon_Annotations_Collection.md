---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Annotations\Collection'
---
# Class **Phalcon\Annotations\Collection**

*implements* [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php), [Countable](https://php.net/manual/en/class.countable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/collection.zep)

Represents a collection of annotations. This class allows to traverse a group of annotations easily

```php
<?php

//Traverse annotations
foreach ($classAnnotations as $annotation) {
    echo "Name=", $annotation->getName(), PHP_EOL;
}

//Check if the annotations has a specific
var_dump($classAnnotations->has("Cacheable"));

//Get an specific annotation in the collection
$annotation = $classAnnotations->get("Cacheable");

```

## Metode

public **__membangun**([*array*$reflectionData)

Phalcon\Annotations\Collection constructor

publik **menghitung**()

Mengembalikan jumlah anotasi dalam koleksi

publik**mundur**()

Melakukan pemutaran balik internal iterator

public [Phalcon\Annotations\Annotation](Phalcon_Annotations_Annotation) **current** ()

Mengembalikan posisi/kunci saat ini di iterator

publik **kunci** ()

Mengembalikan posisi/kunci saat ini di iterator

publik **berikutnya** ()

Bergerak pointer internal iterasi kepada posisi yang berikut

publik **sah** ()

Periksa apakah pesan yang sekarang di iterator berlaku

public **getAnnotations** ()

Kembali anotasi internal sebagai array

public **dapatkan** (*string* $name)

Kembali anotasi pertama yang cocok dengan nama

public **getAll** (*string* $name)

Kembali anotasi pertama yang cocok dengan nama

publik **memiliki** (*string* $name)

Memeriksa jika anotasi yang ada dalam koleksi