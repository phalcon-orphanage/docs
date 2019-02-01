---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Manager'
---
# Class **Phalcon\Mvc\Model\Manager**

*implements* [Phalcon\Mvc\Model\ManagerInterface](Phalcon_Mvc_Model_ManagerInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/manager.zep)

Komponen ini mengendalikan inisialisasi model, menjaga catatan hubungan antara berbagai model aplikasi.

A ModelsManager is injected to a model via a Dependency Injector/Services Container such as Phalcon\Di.

```php
<?php

gunakan Phalcon\Di;
gunakan Phalcon\Mvc\Model\Manager sebagai ModelsManager;

$di = baru Di();

$di->set(
    "modelsManager",
    fungsi() {
        kembali ModelsManager baru();
    }
);

$robot = Robot baru($di);

```

## Metode

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Menetapkan kontainer Injector Ketergantungan

publik **mendapatkanDI** ()

Mengembalikan kontainer DependencyInjector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Menetapkan manajer acara global

publik **getEventsManager** ()

Mengembalikan manajer acara internal

public **setCustomEventsManager** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, [Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Menyetel pengelola acara khusus untuk model tertentu

public **getCustomEventsManager** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan manajer acara khusus yang terkait dengan model

public **initialize** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Menginisialisasi model dalam model manager

public **isInitialized** (*mixed* $modelName)

Periksa apakah model sudah diinisialisasi

public **getLastInitialized** ()

Dapatkan model yang diinisialisasi terakhir

publik **load** (*mixed* $modelName, [*mixed* $newInstance])

Muatkan sebuah model yang melemparkan pengecualian jika tidak ada

publik **setModelPrefix** (*mixed* $prefix)

Menetapkan awalan untuk semua sumber model.

```php
<?php

menggunakan Phalcon\Mvc\Model\Manager;

$di->set("modelsManager", fungsi () {
    $modelsManager = new Manager();
    $modelsManager->setModelPrefix("wp_");

    kembali $modelsManager
});

$robots = new Robots();
gema $robots->getSource(); // wp_robots

```

publik **getModelPrefix** ()

Mengembalikan awalan untuk semua sumber model.

```php
<?php

menggunakan Phalcon\Mvc\Model\Manager;

$di->set("modelsManager", fungsi () {
    $modelsManager = new Manager();
    $modelsManager->setModelPrefix("wp_");

    kembali $modelsManager
});

$robots = new Robots();
gema $robots->getSource(); // wp_robots

```

public **setModelSource** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $source)

Menetapkan sumber yang dipetakan untuk model

final public **isVisibleModelProperty** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $property)

Periksa apakah properti model dinyatakan sebagai publik.

```php
<?php

$isPublic = $manager->isVisibleModelProperty(
    Robot baru(),
    "nama"
);

```

public **getModelSource** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan sumber yang dipetakan untuk model

public **setModelSchema** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $schema)

Menetapkan skema yang dipetakan untuk model

public **getModelSchema** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan skema yang dipetakan untuk model

public **setConnectionService** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $connectionService)

Mengatur keduanya menulis dan membaca layanan koneksi untuk model

public **setWriteConnectionService** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $connectionService)

Set menulis layanan koneksi untuk model

public **setReadConnectionService** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $connectionService)

Set membaca layanan koneksi untuk model

public **getReadConnection** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan koneksi untuk membaca data yang terkait dengan model

public **getWriteConnection** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan koneksi untuk menulis data yang terkait dengan model

protected **_getConnection** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $connectionServices)

Mengembalikan koneksi untuk membaca atau menulis data yang terkait dengan model tergantung pada layanan koneksi.

public **getReadConnectionService** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan nama layanan koneksi yang digunakan untuk membaca data yang terkait dengan model

public **getWriteConnectionService** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mengembalikan nama layanan koneksi yang digunakan untuk menulis data yang terkait dengan model

public **_getConnectionService** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $connectionServices)

Mengembalikan nama layanan koneksi yang digunakan untuk membaca atau menulis data yang terkait sebuah model tergantung pada layanan koneksi

public **notifyEvent** (*mixed* $eventName, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Menerima acara yang dihasilkan dalam model dan mengirimkannya ke pengelola acara jika tersedia Beritahu perilaku yang sedang didengarkan dalam model

public **missingMethod** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $eventName, *mixed* $data)

Mengirimkan acara ke pendengar dan perilaku Metode ini mengharapkan pendengar/perilaku endpoint mengembalikan nilai true artinya yang paling sedikit diimplementasikan

public **addBehavior** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, [Phalcon\Mvc\Model\BehaviorInterface](Phalcon_Mvc_Model_BehaviorInterface) $behavior)

Mengikat perilaku ke model

public **keepSnapshots** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $keepSnapshots)

Menetapkan apakah model harus menyimpan foto

public **isKeepingSnapshots** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Memeriksa apakah sebuah model menyimpan foto untuk catatan tanya

public **useDynamicUpdate** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $dynamicUpdate)

Menyetel jika model harus menggunakan pembaruan dinamis dan bukan pembaruan semua bidang

public **isUsingDynamicUpdate** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Memeriksa apakah model menggunakan pembaruan dinamis dan bukan pembaruan semua bidang

public [Phalcon\Mvc\Model\Relation](Phalcon_Mvc_Model_Relation) **addHasOne** ([Phalcon\Mvc\Model](Phalcon_Mvc_Model) $model, *mixed* $fields, *string* $referencedModel, *mixed* $referencedFields, [*array* $options])

Setup hubungan 1-1 antara dua model

public [Phalcon\Mvc\Model\Relation](Phalcon_Mvc_Model_Relation) **addBelongsTo** ([Phalcon\Mvc\Model](Phalcon_Mvc_Model) $model, *mixed* $fields, *string* $referencedModel, *mixed* $referencedFields, [*array* $options])

Setup relasi membalikkan banyak ke satu di antara dua model

public **addHasMany** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *mixed* $fields, *string* $referencedModel, *mixed* $referencedFields, [*array* $options])

Setup hubungan 1-n antara dua model

public [Phalcon\Mvc\Model\Relation](Phalcon_Mvc_Model_Relation) **addHasManyToMany** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *string* $fields, *string* $intermediateModel, *string* $intermediateFields, *string* $intermediateReferencedFields, *string* $referencedModel, *string* $referencedFields, [*array* $options])

Mengatur hubungan n-m di antara dua model

publik **existsBelongsTo** (*mixed* $modelName, *mixed* $modelRelation)

Memeriksa apakah sebuah model memiliki hubungan milikTo dengan model lain

publik **existsHasMany** (*mixed* $modelName, *mixed* $modelRelation)

Memeriksa apakah suatu model memiliki hubungan hasmany dengan model lain

publik **existsHasOne** (*mixed* $modelName, *mixed* $modelRelation)

Memeriksa apakah model memiliki hubungan hasOne dengan model lain

publik **existsHasManyToMany** (*mixed* $modelName, *mixed* $modelRelation)

Memeriksa apakah model memiliki hubungan hasManyToMany dengan model lain

publik **getRelationByAlias** (*mixed* $modelName, *mixed* $alias)

Mengembalikan sebuah relasi dengan alias nya

akhir dilindungi **_mergeFindParameters** (*campur aduk* $findParamsOne, *campur aduk* $findParamsTwo)

Gabungkan dua array parameter pencarian

public [Phalcon\Mvc\Model\Resultset\Simple](Phalcon_Mvc_Model_Resultset_Simple) | [Phalcon\Mvc\Model\Resultset\Simple](Phalcon_Mvc_Model_Resultset_Simple) | *int* | *false* **getRelationRecords** ([Phalcon\Mvc\Model\RelationInterface](Phalcon_Mvc_Model_RelationInterface) $relation, *mixed* $method, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $record, [*mixed* $parameters])

Metode Helper untuk query record berdasarkan definisi relasi

publik **getReusableRecords** (*mixed* $modelName, *mixed* $key)

Mengembalikan objek yang dapat digunakan kembali dari daftar internal

publik **setReusableRecords** (*mixed* $modelName, *mixed* $key, *mixed* $records)

Menyimpan catatan yang dapat digunakan kembali dalam daftar internal

publik **clearReusableObjects** ()

Menghapus daftar internal yang dapat digunakan kembali

public **getBelongsToRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $record, [*mixed* $parameters])

Gets wereTo catatan terkait dari model

public **getHasManyRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $record, [*mixed* $parameters])

Mendapat beberapa catatan terkait dari sebuah model

public **getHasOneRecords** (*mixed* $method, *mixed* $modelName, *mixed* $modelRelation, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $record, [*mixed* $parameters])

Gets wereTo catatan terkait dari model

public **getBelongsTo** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Mendapat semua hubungan yang dimilikiTo didefinisikan dalam sebuah model

```php
<?php

$relations = $modelsManager->getBelongsTo(
    new Robots()
);

```

public **getHasMany** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Dapatkan Banyak hubungan yang didefinisikan pada model

public **getHasOne** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Gets hasOne relations defined on a model

public **getHasManyToMany** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Gets hasManyToMany relations defined on a model

public **getHasOneAndHasMany** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model)

Gets hasOne relations defined on a model

public **getRelations** (*mixed* $modelName)

Permintaan semua hubungan didefinisikan pada sebuah model

public **getRelationsBetween** (*mixed* $first, *mixed* $second)

Permintaan hubungan pertama didefinisikan antara dua model

public **createQuery** (*mixed* $phql)

Creates a Phalcon\Mvc\Model\Query without execute it

public **executeQuery** (*mixed* $phql, [*mixed* $placeholders], [*mixed* $types])

Creates a Phalcon\Mvc\Model\Query and execute it

public **createBuilder** ([*mixed* $params])

Creates a Phalcon\Mvc\Model\Query\Builder

public **getLastQuery** ()

Mengembalikan permintaan terakhir yang dibuat atau dijalankan di manajer model

public **registerNamespaceAlias** (*mixed* $alias, *mixed* $namespaceName)

Mendaftarkan alias yang lebih pendek untuk ruang nama di laporan PHQL

public **getNamespaceAlias** (*mixed* $alias)

Mengembalikan namespace sebenarnya dari alias

public **getNamespaceAliases** ()

Mengembalikan semua alias namespace terdaftar

publik **__penghancuran** ()

Hancurkan cache PHQL saat ini