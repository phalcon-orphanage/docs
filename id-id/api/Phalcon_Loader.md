---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Loader'
---
# Class **Phalcon\Loader**

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/loader.zep)

Komponen ini membantu memuat kelas proyek Anda secara otomatis berdasarkan beberapa konvensi

```php
<?php

use Phalcon\Loader;

// Creates the autoloader
$loader = new Loader();

// Register some namespaces
$loader->registerNamespaces(
    [
        "Example\Base"    => "vendor/example/base/",
        "Example\Adapter" => "vendor/example/adapter/",
        "Example"          => "vendor/example/",
    ]
);

// Register autoloader
$loader->register();

// Requiring this class will automatically include file vendor/example/adapter/Some.php
$adapter = new \Example\Adapter\Some();

```

## Metode

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Menyetel pengelola acara

publik **getEventsManager** ()

Mengembalikan manajer acara internal

public **setExtensions** (*array* $extensions)

Menetapkan array ekstensi file yang harus dilakukan oleh loader dalam setiap usaha untuk menemukan file tersebut

public **getExtensions** ()

Mengembalikan ekstensi file yang terdaftar di loader

public **registerNamespaces** (*array* $namespaces, [*mixed* $merge])

Mendaftar ruang nama dan direktori terkait mereka

public **setFileCheckingCallback** (*mixed* $callback = null): [Phalcon\Loader](Phalcon_Loader)

Sets the file check callback.

```php
<?php

// Default behavior.
$loader->setFileCheckingCallback("is_file");

// Faster than `is_file()`, but implies some issues if
// the file is removed from the filesystem.
$loader->setFileCheckingCallback("stream_resolve_include_path");

// Do not check file existence.
$loader->setFileCheckingCallback(null);
```

A [Phalcon\Loader\Exception](Phalcon_Loader_Exception) is thrown if the $callback parameter is not a `callable` or `null`;

protected **prepareNamespace** (*array* $namespace)

...

public **getNamespaces** ()

Mengembalikan ruang nama yang saat ini terdaftar di autoloader

public **registerDirs** (*array* $directories, [*mixed* $merge])

Daftar direktori di mana "tidak ditemukan" kelas dapat ditemukan

public **getDirs** ()

Mengembalikan direktori yang saat ini terdaftar di autoloader

public **registerFiles** (*array* $files, [*mixed* $merge])

Registers files that are "non-classes" hence need a "require". This is very useful for including files that only have functions

public **getFiles** ()

Mengembalikan file yang saat ini terdaftar di autoloader

public **registerClasses** (*array* $classes, [*mixed* $merge])

Mendaftar kelas dan lokasinya

public **getClasses** ()

Mengembalikan peta kelas yang saat ini terdaftar di autoloader

public **register** ([*mixed* $prepend])

Daftarkan metode autoload

public **unregister** ()

Unregister metode autoload

public **loadFiles** ()

Memeriksa apakah ada file dan kemudian menambahkan file dengan melakukan virtual require

public **autoLoad** (*mixed* $className)

Autoload kelas yang terdaftar

public **getFoundPath** ()

Dapatkan jalan saat kelas ditemukan

public **getCheckedPath** ()

Dapatkan jalan yang dilacak loader untuk jalan setapak