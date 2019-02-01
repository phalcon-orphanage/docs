---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Di'
---
# Class **Phalcon\Di**

*implements* [Phalcon\DiInterface](Phalcon_DiInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di.zep)

Phalcon\Di is a component that implements Dependency Injection/Service Location of services and it's itself a container for them.

Since Phalcon is highly decoupled, Phalcon\Di is essential to integrate the different components of the framework. Karena Phalcon sangat terpisah, Phalcon \ \ Di sangat penting untuk mengintegrasikan perbedaan komponen pengertian kerja.

Pada dasarnya, komponen ini menerapkan `Pembalikan dari Kontrol` pola. Menerapkan ini, objek tidak menerima dependensinya menggunakan setter atau konstruktor, tapi meminta sebuah injector ketergantungan layanan. Hal ini mengurangi kompleksitas keseluruhan, karena hanya ada satu cara untuk mendapatkan dependensi yang dibutuhkan dalam suatu komponen.

Selain itu, pola ini meningkatkan testability pada kode, sehingga membuatnya kurang rentan terhadap kesalahan.

```php
<?php

use Phalcon\Di;
use Phalcon\Http\Request;

$di = new Di();

// Using a string definition
$di->set("request", Request::class, true);

// Using an anonymous function
$di->setShared(
    "request",
    function () {
        return new Request();
    }
);

$request = $di->getRequest();

```

## Metode

publik **__membangun** ()

Phalcon\Di constructor

public **setInternalEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Mengatur pengelola acara internal

umum **getInternalEventsManager** ()

Mengembalikan manajer acara internal

umum **set** (*campuran* $nama *campuran* $definisi, [*campuran* $shared])

Mendaftarkan layanan ke dalam wadah layanan

umum **setShared** (*campuran* $nama *campuran* $definition)

Mendaftarkan sebuah layanan "selalu berbagi" dalam wadah layanan

umum **hapus** (*campuran* $nama)

Menghapus layanan dalam wadah servis Ini juga menghapus contoh bersama yang dibuat untuk layanan ini

publik **mencoba** (*campuran* $name, *campuran* $definition, [*campuran*$shared])

Upaya untuk mendaftarkan layanan di wadah layanan Hanya berhasil jika layanan belum terdaftar sebelumnya dengan nama yang sama

public **setRaw** (*mixed* $name, [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface) $rawDefinition)

Sets a service using a raw Phalcon\Di\Service definition

umum **getRaw** (*campuran* $nama)

Mengembalikan definisi layanan tanpa menyelesaikannya

public **getService** (*mixed* $name)

Returns a Phalcon\Di\Service instance

publik **mendapatkan** (*campuran* $name, [*campuran* $parameters])

Mengatasi layanan berdasarkan konfigurasinya

umum *campuran* **getShared** (*string* $nama, [*array* $parameter])

Mengatasi layanan, layanan terselesaikan disimpan di DI, selanjutnya Permintaan layanan ini akan mengembalikan instance yang sama

publik **telah** (*campuran* $name)

Periksan apakah DI berisi sebuah layanan dengan sebuah nama

publik **ituSegarContoh** ()

Periksa apakah layanan terakhir yang diperoleh melalui getShared menghasilkan contoh baru atau yang sudah ada

publik **mendapatkanJasa** ()

Mengembalikan layanan yang terdaftar pada DI

umum **offsetExists** (*campuran* $nama)

Periksa apakah sebuah layanan terdaftar menggunakan sintaks array

umum **offsetSet** (*campuran* $nama *campuran* $definition)

Memungkinkan untuk mendaftarkan layanan bersama menggunakan sintaks array

```php
$di["permintaan"] = new \Phalcon\Http\Permintaan();

```

umum **offsetGet** (*campuran* $nama)

Memungkinkan untuk mendapatkan layanan bersama menggunakan sintaks array

```php
<?php

var_dump($di["request"]);

```

umum **offsetUnset** (*campuran* $nama)

Menghapus sebuah layanan dari wadah pelayanan menggunakan sintaks array

umum **__call** (*campuran* $metode, [*campuran* $argumen])

Metode magic untuk dapat atau mengatur layanan menggunakan setters/getters

public **register** ([Phalcon\Di\ServiceProviderInterface](Phalcon_Di_ServiceProviderInterface) $provider)

Daftarkan sebuah penyedia layanan.

```php
<?php

use Phalcon\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class SomeServiceProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di)
    {
        $di->setShared('service', function () {
            // ...
        });
    }
}

```

public static **setDefault** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Tetapkan wadah injeksi dependensi default untuk mendapatkan metode statis

public static **getDefault** ()

Kembalikan DI yang terbaru dibuat

publik static **reset** ()

Mengatur ulang internal default DI

umum **loadFromYaml** (*campuran* $filePath, [*array* $callback])

Memuat layanan dari sebuah file yaml.

```php
<?php

$di->loadFromYaml(
    "path/services.yaml",
    [
        "!approot" => function ($value) {
            return dirname(__DIR__) . $value;
        }
    ]
);

```

Dan layanan dapat ditentukan dalam file sebagai:

```php
<?php

myComponent:
    className: \Acme\Components\MyComponent
    shared: true

group:
    className: \Acme\Group
    arguments:
        - type: service
          name: myComponent

user:
   className: \Acme\User

```

publik **bebanDariPhp** (*campuran* $filePath)

Memuatkan layanan dari file konfigurasi php.

```php
<?php

$di->loadFromPhp("path/services.php");

```

Dan layanan dapat ditentukan dalam file sebagai:

```php
<?php

return [
     'myComponent' => [
         'className' => '\Acme\Components\MyComponent',
         'shared' => true,
     ],
     'group' => [
         'className' => '\Acme\Group',
         'arguments' => [
             [
                 'type' => 'service',
                 'service' => 'myComponent',
             ],
         ],
     ],
     'user' => [
         'className' => '\Acme\User',
     ],
];

```

protected **loadFromConfig** ([Phalcon\Config](Phalcon_Config) $config)

Memuatkan layanan dari objek Config.