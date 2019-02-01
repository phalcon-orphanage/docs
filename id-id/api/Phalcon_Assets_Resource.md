---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Assets\Resource'
---
# Class **Phalcon\Assets\Resource**

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/resource.zep)

Merupakan sumber daya aset

```php
<?php

$resource = new \Phalcon\Assets\Resource ("js","javascripts / jquery.js");

```

## Metode

publik **berhenti** ()

public **getPath** ()

public **getLocal** ()

public **getFilter** ()

public **getAttributes** ()

public **getSourcePath** ()

...

public **getTargetPath** ()

...

public **getTargetUri** ()

...

public **__construct** (*string* $type, *string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Resource constructor

publik **perangkat Tipe** (*dicampur* $type)

Menetapkan jenis sumber daya

public **setPath** (*mixed* $path)

Menetapkan jalur sumber daya

public **setLocal** (*mixed* $local)

Menetapkan apakah sumber daya itu lokal atau eksternal

public **setFilter** (*campuran* $filter)

Menetapkan apakah sumber daya harus disaring atau tidak

public **setAttributes** (*array* $attributes)

Menetapkan beberapa atribut HTML tambahan

public **setTargetUri** (*mixed* $targetUri)

Menetapkan sebuah target uri untuk menghasilkan HTML

public **setSourcePath** (*mixed* $sourcePath)

Menetapkan jalur sumber sumber

public **setTargetPath** (*mixed* $targetPath)

Menetapkan jalur target sumber daya

public **getContent** ([*mixed* $basePath])

Mengembalikan isi sumber daya sebagai string Opsional jalur dasar dimana sumber daya berada dapat diatur

public **getRealTargetUri** ()

Returns the real target uri for the generated HTML

public **getRealSourcePath** ([*mixed* $basePath])

Mengembalikan lokasi lengkap tempat sumber daya berada

public **getRealTargetPath** ([*mixed* $basePath])

Mengembalikan lokasi lengkap dimana sumber daya harus ditulis

publik **getResourceKey** ()

Mendapatkan kunci sumber.