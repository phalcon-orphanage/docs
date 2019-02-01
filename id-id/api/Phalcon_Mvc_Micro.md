---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Micro'
---
# Class **Phalcon\Mvc\Micro**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/micro.zep)

Dengan Phalcon Anda bisa membuat aplikasi "Micro-Framework like". Dengan melakukan ini, anda hanya perlu tuliskan jumlah minimal kode untuk membuat aplikasi PHP. Aplikasi mikro yang cocok untuk aplikasi kecil, API dan prototip dengan cara yang praktis.

```php
<?php

$app = = baru \Phalcon\ Mvc\Micro();

$app->get(
    "/say/welcome/{name}",
    function ($name) {
        echo "<h1>Welcome $name!</h1>";
    }
);

$app->menangani();

```

## Metode

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Phalcon\Mvc\Micro constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Menetapkan kontainer Injector Ketergantungan

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **map** (*string* $routePattern, *callable* $handler)

Peta rute ke pengendali tanpa batasan metode HTTP

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **get** (*string* $routePattern, *callable* $handler)

Peta rute ke handler yang hanya cocok jika metode HTTP nya adalah GET

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **post** (*string* $routePattern, *callable* $handler)

Peta rute ke handler yang hanya cocok jika metode HTTP adalah POST

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **put** (*string* $routePattern, *callable* $handler)

Peta rute ke handler yang hanya cocok jika metode HTTP adalah PUT

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **patch** (*string* $routePattern, *callable* $handler)

Peta rute ke handler yang hanya cocok jika metode HTTP adalah PATCH

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **head** (*string* $routePattern, *callable* $handler)

Peta rute ke handler yang hanya cocok jika metode HTTP adalah HEAD

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **delete** (*string* $routePattern, *callable* $handler)

Peta rute ke handler yang hanya cocok jika metode HTTP adalah DELETE

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **options** (*string* $routePattern, *callable* $handler)

Peta rute ke handler yang hanya cocok jika metode HTTP adalah OPTIONS

public **mount** ([Phalcon\Mvc\Micro\CollectionInterface](Phalcon_Mvc_Micro_CollectionInterface) $collection)

Menaikkan koleksi dari penangan

public [Phalcon\Mvc\Micro](Phalcon_Mvc_Micro) **notFound** (*callable* $handler)

Menetapkan handler yang akan dipanggil saat router tidak sesuai dengan rute yang ditentukan

public [Phalcon\Mvc\Micro](Phalcon_Mvc_Micro) **error** (*callable* $handler)

Menetapkan handler yang akan dipanggil saat dikecualikan dilemparkan penanganan rute

publik **mendapatkan** ()

Mengembalikan router internal yang digunakan oleh aplikasi

public [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface) **setService** (*string* $serviceName, *mixed* $definition, [*boolean* $shared])

Menetapkan layanan dari DI

publik **memilikiLayanan** (*campuran* $serviceName)

Memeriksa apakah layanan terdaftar di DI

publik *object* **getService** (*tali* $serviceName)

Mendapatkan layanan dari DI

publik *campuran* **mendapatkanLayananBersama** (*tali* $serviceName)

Mendapatkan layanan bersama dari DI

publik *campuran* **menangani** ([*tali* $uri])

Tangani seluruh permintaan

publik ** berhenti ** ()

Menghentikan middleware menghindari menghindari middlewares lainnya dieksekusi

publik **aturActiveHandler** (*callable* $activeHandler)

Mengatur secara eksternal pawang yang harus dipanggil oleh rute yang cocok

publik *callable* **getActiveHandler** ()

Kembalikan pawang yang akan dipanggil untuk rute yang cocok

public *mixed* **getReturnedValue** ()

Mengembalikan nilai yang dikembalikan oleh pengendali yang dieksekusi

public *boolean* **offsetExists** (*string* $alias)

Periksa apakah layanan terdaftar di wadah layanan internal menggunakan array syntax

public **offsetSet** (*string* $alias, *mixed* $definition)

Memungkinkan untuk mendaftarkan layanan bersama di wadah layanan internal menggunakan array syntax

```php
<?php

$app["request"] = new \Phalcon\Http\Request();

```

public *mixed* **offsetGet** (*string* $alias)

Memungkinkan untuk mendapatkan layanan bersama di kontainer layanan internal menggunakan array syntax

```php
<?php

var_dump(
    $app["request"]
);

```

public **offsetUnset** (*string* $alias)

Menghapus layanan dari Internal layanan kontener menggunakan array syntax

public [Phalcon\Mvc\Micro](Phalcon_Mvc_Micro) **before** (*callable* $handler)

Menambahkan middleware sebelum dipanggil sebelum menjalankan rute

public [Phalcon\Mvc\Micro](Phalcon_Mvc_Micro) **afterBinding** (*callable* $handler)

Menambahkan middleware setelah Binding dipanggil model setelah mengikat

public [Phalcon\Mvc\Micro](Phalcon_Mvc_Micro) **after** (*callable* $handler)

Menambahkan middleware 'setelah' dipanggil setelah menjalankan rute

public [Phalcon\Mvc\Micro](Phalcon_Mvc_Micro) **finish** (*callable* $handler)

Menambahkan middleware 'selesai' untuk dipanggil ketika permintaan selesai

publik **getHandlers** ()

Mengembalikan internal handlers yang di pakai aplikasi

public **getModelBinder** ()

Mendapat model map

public **setModelBinder** ([Phalcon\Mvc\Model\BinderInterface](Phalcon_Mvc_Model_BinderInterface) $modelBinder, [*mixed* $cache])

Ubah model map

```php
<php

$micro = Mikro baru($di);
$micro->setModelBinder(Map baru(), 'sampah');

```

public **getBoundModels** ()

Mengembalikan model terikat dari contoh pengikat

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengembalikan injector ketergantungan internal

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Menyetel pengelola acara

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Mengembalikan manajer acara internal

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Metode __get