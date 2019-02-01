---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Loader'
---
# Class **Phalcon\Loader**

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/loader.zep)

Bu bileşen, bazı sözleşmelere dayalı olarak proje sınıflarınızı otomatik olarak yüklemeye yardımcı olur

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

## Metodlar

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Olay yöneticisini ayarlar

herkes **Olay yöneticisini al** ()

Dahili olay yöneticisini döndürür

public **setExtensions** (*array* $extensions)

Yükleyicinin dosyayı bulmak için her girişimi denemesi gereken bir dosya uzantıları dizisi ayarlar

public **getExtensions** ()

Returns the file extensions registered in the loader

public **registerNamespaces** (*array* $namespaces, [*mixed* $merge])

Register namespaces and their related directories

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

Otomatik yükleyici'de kayıtlı olan ad alanlarını geri getirir

public **registerDirs** (*array* $directories, [*mixed* $merge])

"Bulunamadı" sınıflarının bulunamadığı kayıt dizinleri

public **getDirs** ()

Otomatik yükleyici'de kayıtlı olan dizinleri geri getirir

public **registerFiles** (*array* $files, [*mixed* $merge])

Registers files that are "non-classes" hence need a "require". This is very useful for including files that only have functions

public **getFiles** ()

Otomatik yükleyici'de kayıtlı olan dosyaları geri getirir

public **registerClasses** (*array* $classes, [*mixed* $merge])

Kayıtlı sınıflar ve onların konumları

public **getClasses** ()

Halen otomatik yükleyici'de kayıtlı olan dizinleri geri getiriri

public **register** ([*mixed* $prepend])

Otomatik yükleyici metodunu kaydettirin

public **unregister** ()

Otomatik yükleyici metodunun kaydını silin

public **loadFiles** ()

Bir dosyanın var olup olmadığını kontrol eder var ise dosyayı sanal gereklerine göre yükler

public **autoLoad** (*mixed* $className)

Kayıtlı sınıfları otomatik olarak yükler

public **getFoundPath** ()

Get the path when a class was found

public **getCheckedPath** ()

Get the path the loader is checking for a path