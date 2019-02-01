---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Collection\Manager'
---
# Class **Phalcon\Mvc\Collection\Manager**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/collection/manager.zep)

Komponen ini mengendalikan inisialisasi model, menjaga catatan hubungan antara berbagai model aplikasi.

A CollectionManager is injected to a model via a Dependency Injector Container such as Phalcon\Di.

```php
<?php

$di = new \Phalcon\Di();

$di->set(
    "collectionManager",
    function () {
        return new \Phalcon\Mvc\Collection\Manager();
    }
);

$robot = new Robots($di);

```

## Metode

public **getServiceName** ()

...

public **setServiceName** (*mixed* $serviceName)

...

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Menetapkan kontainer Injector Ketergantungan

publik **mendapatkanDI** ()

Mengembalikan kontainer DependencyInjector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Menyetel pengelola acara

publik **getEventsManager** ()

Mengembalikan manajer acara internal

public **setCustomEventsManager** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, [Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Menyetel pengelola acara khusus untuk model tertentu

public **getCustomEventsManager** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Mengembalikan manajer acara khusus yang terkait dengan model

public **initialize** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Menginisialisasi model dalam model manager

public **isInitialized** (*mixed* $modelName)

Periksa apakah model sudah diinisialisasi

public **getLastInitialized** ()

Dapatkan model inisialisasi terbaru

public **setConnectionService** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, *mixed* $connectionService)

Menetapkan layanan koneksi untuk model tertentu

public **getConnectionService** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Mendapatkan layanan koneksi untuk model tertentu

public **useImplicitObjectIds** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, *mixed* $useImplicitObjectIds)

Menetapkan apakah model harus menggunakan id objek implisit

public **isUsingImplicitObjectIds** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Memeriksa apakah model menggunakan id objek implisit

public *Mongo* **getConnection** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Mengembalikan koneksi yang terkait dengan model

public **notifyEvent** (*mixed* $eventName, [Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Menerima acara yang dihasilkan dalam model dan mengirimkannya ke pengelola acara jika tersedia Beritahu perilaku yang sedang didengarkan dalam model

public **missingMethod** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, *mixed* $eventName, *mixed* $data)

Mengirimkan acara ke pendengar dan perilaku Metode ini mengharapkan pendengar/perilaku endpoint mengembalikan nilai true artinya setidaknya satu diimplementasikan

public **addBehavior** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, [Phalcon\Mvc\Collection\BehaviorInterface](Phalcon_Mvc_Collection_BehaviorInterface) $behavior)

Mengikat perilaku ke model