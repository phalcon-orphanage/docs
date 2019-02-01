---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Dispatcher'
---
# Class **Phalcon\Mvc\Dispatcher**

*extends* abstract class [Phalcon\Dispatcher](Phalcon_Dispatcher)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface), [Phalcon\Mvc\DispatcherInterface](Phalcon_Mvc_DispatcherInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/dispatcher.zep)

Pengiriman adalah proses mengambil objek permintaan, mengeluarkan nama modul, nama controller, nama tindakan, dan parameter opsional yang terdapat di dalamnya, dan kemudian instantiating controller dan memanggil sebuah tindakan dari controller itu.

```php
<?php

$di = new \Phalcon\Di();

$dispatcher = new \Phalcon\Mvc\Dispatcher();

$dispatcher->setDI($di);

$dispatcher->setControllerName("posts");
$dispatcher->setActionName("index");
$dispatcher->setParams([]);

$controller = $dispatcher->dispatch();

```

## Constants

*bilangan bulat* **EXCEPTION_NO_DI**

*bilangan bulat* **EXCEPTION_CYCLIC_ROUTING**

*bilangan bulat* **EXCEPTION_HANDLER_NOT_FOUND**

*bilangan bulat* **EXCEPTION_INVALID_HANDLER**

*bilangan bulat* **EXCEPTION_INVALID_PARAMS**

*bilangan bulat* **EXCEPTION_ACTION_NOT_FOUND**

## Metode

public **setControllerSuffix** (*mixed* $controllerSuffix)

Mengatur akhiran kontroler default

public **setDefaultController** (*mixed* $controllerName)

Menetapkan nama pengontrol default

public **setControllerName** (*mixed* $controllerName)

Menetapkan nama pengontrol yang akan dikirim

public **getControllerName** ()

Dapatkan nama pengontrol terakhir yang dikirim

public **getPreviousNamespaceName** ()

Minta nama ruang nama yang dikirim sebelumnya

public **getPreviousControllerName** ()

Dapatkan nama pengontrol yang dikirim sebelumnya

public **getPreviousActionName** ()

Dapatkan nama tindakan yang dikirim sebelumnya

protected **_throwDispatchException** (*mixed* $message, [*mixed* $exceptionCode])

Melemparkan pengecualian internal

protected **_handleException** ([Exception](https://php.net/manual/en/class.exception.php) $exception)

Menangani pengecualian pengguna

public **forward** (*array* $forward)

Ke depan aliran eksekusi ke kontroler / tindakan lainnya.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use App\Backend\Bootstrap as Backend;
use App\Frontend\Bootstrap as Frontend;

// Registering modules
$modules = [
    "frontend" => [
        "className" => Frontend::class,
        "path"      => __DIR__ . "/app/Modules/Frontend/Bootstrap.php",
        "metadata"  => [
            "controllersNamespace" => "App\Frontend\Controllers",
        ],
    ],
    "backend" => [
        "className" => Backend::class,
        "path"      => __DIR__ . "/app/Modules/Backend/Bootstrap.php",
        "metadata"  => [
            "controllersNamespace" => "App\Backend\Controllers",
        ],
    ],
];

$application->registerModules($modules);

// Setting beforeForward listener
$eventsManager  = $di->getShared("eventsManager");

$eventsManager->attach(
    "dispatch:beforeForward",
    function(Event $event, Dispatcher $dispatcher, array $forward) use ($modules) {
        $metadata = $modules[$forward["module"]]["metadata"];

        $dispatcher->setModuleName($forward["module"]);
        $dispatcher->setNamespaceName($metadata["controllersNamespace"]);
    }
);

// Forward
$this->dispatcher->forward(
    [
        "module"     => "backend",
        "controller" => "posts",
        "action"     => "index",
    ]
);

```

public **getControllerClass** ()

Kemungkinan nama kelas pengendali yang akan ditempatkan untuk mengirimkan permintaan

public **getLastController** ()

Mengembalikan pengontrol pengiriman terbaru

public **getActiveController** ()

Mengembalikan kontroler aktif ke petugas operator

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

public **wasForwarded** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Periksa apakah tindakan yang dijalankan saat ini diteruskan oleh yang lain

public **getHandlerClass** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Kemungkinan nama kelas yang akan ditempatkan untuk mengirimkan permintaan

public **callActionMethod** (*mixed* $handler, *mixed* $actionMethod, [*array* $params]) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

...

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