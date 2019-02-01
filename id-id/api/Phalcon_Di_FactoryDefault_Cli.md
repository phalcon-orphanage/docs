---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Di\FactoryDefault\Cli'
---
# Class **Phalcon\Di\FactoryDefault\Cli**

*extends* class [Phalcon\Di\FactoryDefault](Phalcon_Di_FactoryDefault)

*implements* [Phalcon\DiInterface](Phalcon_DiInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/di/factorydefault/cli.zep)

This is a variant of the standard Phalcon\Di. Secara default, otomatis mencatat semua layanan yang disediakan oleh kerangka kerja. Berkat ini, pengembang tidak perlu mendaftarkan masing-masing layanan secara terpisah. Kelas ini sangat sesuai untuk aplikasi CLI

## Metode

publik **__membangun** ()

Phalcon\Di\FactoryDefault\Cli constructor

public **setInternalEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di](Phalcon_Di)

Mengatur pengelola acara internal

public **getInternalEventsManager** () inherited from [Phalcon\Di](Phalcon_Di)

Mengembalikan manajer acara internal

public **set** (*mixed* $name, *mixed* $definition, [*mixed* $shared]) inherited from [Phalcon\Di](Phalcon_Di)

Mendaftarkan layanan ke dalam wadah layanan

public **setShared** (*mixed* $name, *mixed* $definition) inherited from [Phalcon\Di](Phalcon_Di)

Mendaftarkan sebuah layanan "selalu berbagi" dalam wadah layanan

public **remove** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Menghapus layanan dalam wadah servis Ini juga menghapus contoh bersama yang dibuat untuk layanan ini

public **attempt** (*mixed* $name, *mixed* $definition, [*mixed* $shared]) inherited from [Phalcon\Di](Phalcon_Di)

Upaya untuk mendaftarkan layanan di wadah layanan Hanya berhasil jika layanan belum terdaftar sebelumnya dengan nama yang sama

public **setRaw** (*mixed* $name, [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface) $rawDefinition) inherited from [Phalcon\Di](Phalcon_Di)

Sets a service using a raw Phalcon\Di\Service definition

public **getRaw** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Mengembalikan definisi layanan tanpa menyelesaikannya

public **getService** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Returns a Phalcon\Di\Service instance

public **get** (*mixed* $name, [*mixed* $parameters]) inherited from [Phalcon\Di](Phalcon_Di)

Mengatasi layanan berdasarkan konfigurasinya

public *mixed* **getShared** (*string* $name, [*array* $parameters]) inherited from [Phalcon\Di](Phalcon_Di)

Mengatasi layanan, layanan terselesaikan disimpan di DI, selanjutnya Permintaan layanan ini akan mengembalikan instance yang sama

public **has** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Periksan apakah DI berisi sebuah layanan dengan sebuah nama

public **wasFreshInstance** () inherited from [Phalcon\Di](Phalcon_Di)

Periksa apakah layanan terakhir yang diperoleh melalui getShared menghasilkan contoh baru atau yang sudah ada

public **getServices** () inherited from [Phalcon\Di](Phalcon_Di)

Mengembalikan layanan yang terdaftar pada DI

public **offsetExists** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Periksa apakah sebuah layanan terdaftar menggunakan sintaks array

public **offsetSet** (*mixed* $name, *mixed* $definition) inherited from [Phalcon\Di](Phalcon_Di)

Memungkinkan untuk mendaftarkan layanan bersama menggunakan sintaks array

```php
$di["permintaan"] = new \Phalcon\Http\Permintaan();

```

public **offsetGet** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Memungkinkan untuk mendapatkan layanan bersama menggunakan sintaks array

```php
<?php

var_dump($di["request"]);

```

public **offsetUnset** (*mixed* $name) inherited from [Phalcon\Di](Phalcon_Di)

Menghapus sebuah layanan dari wadah pelayanan menggunakan sintaks array

public **__call** (*mixed* $method, [*mixed* $arguments]) inherited from [Phalcon\Di](Phalcon_Di)

Metode magic untuk dapat atau mengatur layanan menggunakan setters/getters

public **register** ([Phalcon\Di\ServiceProviderInterface](Phalcon_Di_ServiceProviderInterface) $provider) inherited from [Phalcon\Di](Phalcon_Di)

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

public static **setDefault** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Di](Phalcon_Di)

Tetapkan wadah injeksi dependensi default untuk mendapatkan metode statis

public static **getDefault** () inherited from [Phalcon\Di](Phalcon_Di)

Kembalikan DI yang terbaru dibuat

public static **reset** () inherited from [Phalcon\Di](Phalcon_Di)

Mengatur ulang internal default DI

public **loadFromYaml** (*mixed* $filePath, [*array* $callbacks]) inherited from [Phalcon\Di](Phalcon_Di)

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

public **loadFromPhp** (*mixed* $filePath) inherited from [Phalcon\Di](Phalcon_Di)

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

protected **loadFromConfig** ([Phalcon\Config](Phalcon_Config) $config) inherited from [Phalcon\Di](Phalcon_Di)

Memuatkan layanan dari objek Config.