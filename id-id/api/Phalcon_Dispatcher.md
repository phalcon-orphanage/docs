---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Dispatcher'
---
# Abstract class **Phalcon\Dispatcher**

*implements* [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/dispatcher.zep)

This is the base class for Phalcon\Mvc\Dispatcher and Phalcon\Cli\Dispatcher. This class can't be instantiated directly, you can use it to create your own dispatchers.

## Constants

*bilangan bulat* **EXCEPTION_NO_DI**

*bilangan bulat* **EXCEPTION_CYCLIC_ROUTING**

*bilangan bulat* **EXCEPTION_HANDLER_NOT_FOUND**

*bilangan bulat* **EXCEPTION_INVALID_HANDLER**

*bilangan bulat* **EXCEPTION_INVALID_PARAMS**

*bilangan bulat* **EXCEPTION_ACTION_NOT_FOUND**

## Metode

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Mengatur injector ketergantungan

publik **mendapatkanDI** ()

Mengembalikan injector ketergantungan internal

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Menyetel pengelola acara

publik **getEventsManager** ()

Mengembalikan manajer acara internal

umum ** setActionSuffix ** (* campuran * $actionSuffix)

Mengatur akhiran aksi seperti semula

umum ** getActionSuffix ** ()

Mendapatkan aksi mendapatkan seperti semula

umum ** setModuleName ** (*mixed * $moduleName)

Mengatur modul dimana controller (hanya memberikan informasi)

publik **mendapatkanNamaModul** ()

Mendapat modul di mana pengontrolan kelasnya

umum **setNamespaceName** (* mixed * $namespaceName)

Mengatur ruang nama dimana kelas kontrol berada

umum **getNamespaceName **()

Mendapatkan ruang nama untuk ditambahkan ke nama peralatan saat ini

umum ** setDefaultNamespace ** (* mixed * $namespaceName)

Mengatur ruang nama seperti awal

umum **getDefaultNamespace **()

Mengembalikan ruang nama seperti awal

publik **setDefaultTindakan** (*campuraduk* $actionName)

Sets the default action name

umum **set nama aksi ** (*campuran * $actionName)

Menetapkan nama tindakan yang akan dikirim

publik **dapatkanNamaAksi** ()

Dapatkan nama tindakan pengiriman terbaru

umum **setParams ** (*array *$params)

Menetapkan parameter tindakan yang akan dikirim

umum **getParams** ()

Mendapatkan tindakan params

umum **setParam** (*mixed* $param, *mixed* $value)

Menetapkan params tindakan yang akan dikirim

umum *campur* **getParam** (*campur* $param, [*string* |*array *$filters], [*campur*$defaultValue])

Mendapatkan param dengan nama atau indeks numeriknya

umum *boolean* **hasParam** (*mixed* $param)

Periksa apakah param bekerja

umum **getActiveMethod** ()

Mengembalikan cara saat ini ke/dieksekusi di petugas operator

umum **isFinished** ()

Memeriksa apakah putaran pengiriman selesai atau memiliki kontroler/tugas yang lebih mudah dikendalikan untuk dikirim

public **setReturnedValue** (*mixed* $value)

Menetapkan nilai pengembalian terbaru dengan tindakan secara manua

public *mixed* **getReturnedValue** ()

Mengembalikan nilai yang dikembalikan oleh tindakan pengiriman terbaru

public **setModelBinding** (*mixed* $value, [*mixed* $cache])

Aktifkan / Nonaktifkan model yang mengikat selama pengiriman

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinding(true, 'cache');
    return $dispatcher;
});

```

public **setModelBinder** ([Phalcon\Mvc\Model\BinderInterface](Phalcon_Mvc_Model_BinderInterface) $modelBinder, [*mixed* $cache])

Aktifkan pengikatan model selama pengiriman

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinder(new Binder(), 'cache');
    return $dispatcher;
});

```

public **getModelBinder** ()

Mendapat model map

public *object* **dispatch** ()

Mengirimkan tindakan penanganan dengan mempertimbangkan parameter perutean

protected *object* **_dispatch** ()

Mengirimkan tindakan penanganan dengan mempertimbangkan parameter perutean

public **forward** (*array* $forward)

Ke depan aliran eksekusi ke kontroler / tindakan lainnya.

```php
<?php

$this->dispatcher->forward(
    [
        "controller" => "posts",
        "action"     => "index",
    ]
);

```

public **wasForwarded** ()

Periksa apakah tindakan yang dijalankan saat ini diteruskan oleh yang lain

public **getHandlerClass** ()

Kemungkinan nama kelas yang akan ditempatkan untuk mengirimkan permintaan

public **callActionMethod** (*mixed* $handler, *mixed* $actionMethod, [*array* $params])

...

public **getBoundModels** ()

Mengembalikan model terikat dari contoh pengikat

```php
<?php

class UserController extends Controller
{
    public function showAction(User $user)
    {
        $boundModels = $this->dispatcher->getBoundModels(); // return array with $user
    }
}

```

protected **_resolveEmptyProperties** ()

Setel properti kosong ke kegagalan mereka (tempat kegagalan tersedia)