---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Cli\Dispatcher'
---
# Class **Phalcon\Cli\Dispatcher**

*extends* abstract class [Phalcon\Dispatcher](Phalcon_Dispatcher)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface), [Phalcon\Cli\DispatcherInterface](Phalcon_Cli_DispatcherInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/dispatcher.zep)

Pengiriman adalah proses mengambil argumen baris perintah, mengekstrak nama modul, tugas nama, nama tindakan, dan parameter opsional yang terkandung di dalamnya, dan kemudian instantiating tugas dan menyerukan tindakan itu.

```php
<? php menggunakan Phalcon\Di; menggunakan Phalcon\Cli\Dispatcher;$di = new Di();$dispatcher = new Dispatcher(); $dispatcher -> setDi($di); $dispatcher -> setTaskName("posts"); $dispatcher -> setActionName("index"); $dispatcher -> setParams([]); $handle = $dispatcher -> dispatch();

```

## Constants

*bilangan bulat* **EXCEPTION_NO_DI**

*bilangan bulat* **EXCEPTION_CYCLIC_ROUTING**

*bilangan bulat* **EXCEPTION_HANDLER_NOT_FOUND**

*bilangan bulat* **EXCEPTION_INVALID_HANDLER**

*bilangan bulat* **EXCEPTION_INVALID_PARAMS**

*bilangan bulat* **EXCEPTION_ACTION_NOT_FOUND**

## Metode

umum **setTaskSuffix** (*campuran* $taskSuffix)

Set akhiran tugas default

umum **setDefaultTask** (*campuran* $taskName)

Menyetel nama tindakan default

umum **setDefaultTask** (*campuran* $taskName)

Menetapkan nama tindakan yang akan dikirim

umum **getActiveRole** ()

Dapatkan nama tindakan pengiriman terbaru

protected **_throwDispatchException** (*mixed* $message, [*mixed* $exceptionCode])

Melemparkan pengecualian internal

protected **_handleException** ([Exception](https://php.net/manual/en/class.exception.php) $exception)

Menangani pengecualian pengguna

umum **getActiveRole** ()

Mengembalikan pengontrol pengiriman terbaru

umum **getActiveRole** ()

Mengembalikan tugas aktif ke petugas operator

public **setOptions** (*array* $options)

Menetapkan nama tindakan yang akan dikirim

public **getOptions** ()

Dapatkan pilihan pengiriman

umum **getOption** (*mixed* $option, [*string* | *array* $filters], [*mixed* $defaultValue])

Mendapatkan param dengan nama atau indeks numeriknya

public **hasOption** (*mixed* $option)

Pemeriksaan jika ada indeks

public **callActionMethod** (*mixed* $handler, *mixed* $actionMethod, [*array* $params])

Panggilan metode tindakan.

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mengatur injector ketergantungan

public **getDI** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mengembalikan injector ketergantungan internal

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Menyetel pengelola acara

public **getEventsManager** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mengembalikan manajer acara internal

public **setActionSuffix** (*mixed* $actionSuffix) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mengatur akhiran aksi seperti semula

public **getActionSuffix** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mendapatkan aksi mendapatkan seperti semula

public **setModuleName** (*mixed* $moduleName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mengatur modul dimana controller (hanya memberikan informasi)

public **getModuleName** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mendapat modul di mana pengontrolan kelasnya

public **setNamespaceName** (*mixed* $namespaceName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mengatur ruang nama dimana kelas kontrol berada

public **getNamespaceName** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mendapatkan ruang nama untuk ditambahkan ke nama peralatan saat ini

public **setDefaultNamespace** (*mixed* $namespaceName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mengatur ruang nama seperti awal

public **getDefaultNamespace** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mengembalikan ruang nama seperti awal

public **setDefaultAction** (*mixed* $actionName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Sets the default action name

public **setActionName** (*mixed* $actionName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Menetapkan nama tindakan yang akan dikirim

public **getActionName** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Dapatkan nama tindakan pengiriman terbaru

public **setParams** (*array* $params) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Menetapkan parameter tindakan yang akan dikirim

public **getParams** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mendapatkan tindakan params

public **setParam** (*mixed* $param, *mixed* $value) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Menetapkan params tindakan yang akan dikirim

public *mixed* **getParam** (*mixed* $param, [*string* | *array* $filters], [*mixed* $defaultValue]) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mendapatkan param dengan nama atau indeks numeriknya

public *boolean* **hasParam** (*mixed* $param) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Periksa apakah param bekerja

public **getActiveMethod** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mengembalikan cara saat ini ke/dieksekusi di petugas operator

public **isFinished** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Memeriksa apakah putaran pengiriman selesai atau memiliki kontroler/tugas yang lebih mudah dikendalikan untuk dikirim

public **setReturnedValue** (*mixed* $value) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Menetapkan nilai pengembalian terbaru dengan tindakan secara manua

public *mixed* **getReturnedValue** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mengembalikan nilai yang dikembalikan oleh tindakan pengiriman terbaru

public **setModelBinding** (*mixed* $value, [*mixed* $cache]) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Aktifkan / Nonaktifkan model yang mengikat selama pengiriman

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinding(true, 'cache');
    return $dispatcher;
});

```

public **setModelBinder** ([Phalcon\Mvc\Model\BinderInterface](Phalcon_Mvc_Model_BinderInterface) $modelBinder, [*mixed* $cache]) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Aktifkan pengikatan model selama pengiriman

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinder(new Binder(), 'cache');
    return $dispatcher;
});

```

public **getModelBinder** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mendapat model map

public *object* **dispatch** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mengirimkan tindakan penanganan dengan mempertimbangkan parameter perutean

protected *object* **_dispatch** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Mengirimkan tindakan penanganan dengan mempertimbangkan parameter perutean

public **forward** (*array* $forward) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

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

public **wasForwarded** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Periksa apakah tindakan yang dijalankan saat ini diteruskan oleh yang lain

public **getHandlerClass** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Kemungkinan nama kelas yang akan ditempatkan untuk mengirimkan permintaan

public **getBoundModels** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

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

protected **_resolveEmptyProperties** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Setel properti kosong ke kegagalan mereka (tempat kegagalan tersedia)