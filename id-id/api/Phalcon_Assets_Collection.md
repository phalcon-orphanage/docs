---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Assets\Collection'
---
# Class **Phalcon\Assets\Collection**

*implements* [Countable](https://php.net/manual/en/class.countable.php), [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/collection.zep)

Merupakan sekumpulan sumber

## Metode

public **getPrefix** ()

...

public **getLocal** ()

...

publik **dapatkansumberdaya** ()

...

public **getCodes** ()

...

public **getPosition** ()

...

public **getFilters** ()

...

public **getAttributes** ()

...

public **getJoin** ()

...

public **getTargetUri** ()

...

public **getTargetPath** ()

...

public **getTargetLocal** ()

...

public **getSourcePath** ()

...

publik **__membangun** ()

Phalcon\Assets\Collection constructor

public **add** ([Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Menambah penyumberan kepada koleksi

public **addInline** ([Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Menambahkan kode inline pada collection

public **has** ([Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface) $resource)

Periksa penyumberan ini sudah ditambahkan ke koleksi.

```php
<?php

Gunakan Phalcon\Aset\Penyumberan;
Gunakan Phalcon\Aset\Koleksi;

$collection = new Collection();

$resource = new Resource("js", "js/jquery.js");
$resource->has($resource); // true

```

public **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*dicampur* $attributes])

Menambahkan peyumberan CSS ke koleksi

public **addInlineCss** (*campuran* $content, [*mixed* $filter], [*mixed* $attributes])

Menambahkan sekumpulan inline CSS ke koleksi

public [Phalcon\Assets\Collection](Phalcon_Assets_Collection) **addJs** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Menambahkan sebuah penyumberan javascript ke koleksi

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Menambahkan sekumpulan inline javascript ke collection

publik **menghitung**()

Mengembalikan jumlah elemen dalam formulir

publik**mundur**()

Melakukan pemutaran balik internal iterator

public **current** ()

Mengembalikan penyumberan aliran pada iterator

public *int* **key** ()

Mengembalikan posisi/kunci saat ini di iterator

publik **berikutnya** ()

Bergerak pointer internal iterasi kepada posisi yang berikut

publik **sah** ()

Periksa apakah pesan yang sekarang di iterator berlaku

public **setTargetPath** (*mixed* $targetPath)

Menetapkan target dari bagian file untuk penyaringan/bergabung

public **setSourcePath** (*mixed* $sourcePath)

Penetapan sekumpulan sumber bagian untuk semua penyumberan pada collection ini

public **setTargetUri** (*mixed* $targetUri)

Menetapkan sebuah target uri untuk menghasilkan HTML

public **setPrefix** (*mixed* $prefix)

Mengedepankan semua penyumberan bersama

public **setLocal** (*mixed* $local)

Menetapkan jika collection menggunakan penyumberan lokal secara default

public **setAttributes** (*array* $attributes)

Menetapkan beberapa atribut HTML tambahan

public **setFilters** (*array* $filters)

Menetapkan sebuah penyaringan array di collection

public **setTargetLocal** (*mixed* $targetLocal)

Menetapkan target lokal

public **join** (*mixed* $join)

Menetapkan jika semua penyumberan yang disaring dalam collection harus sudah bergabung dalam hasil file tunggal

public **getRealTargetPath** (*mixed* $basePath)

Mengembalikan lokasi lengkap tempat dimana collection yang telah digabungkan/disaring harus ditulis

public **addFilter** ([Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface) $filter)

Menambahkan sebuah penyaringan ke collection

final protected **addResource** ([Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface) $resource)

Menambahkan penyumberan atau inline-kode ke collection