---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon \ Config \ Adapter \ Dikelompokkan'
---
# Class **Phalcon\Config\Adapter\Grouped**

*extends* class [Phalcon\Config](Phalcon_Config)

*implements* [Countable](https://php.net/manual/en/class.countable.php), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config/adapter/grouped.zep)

Membaca beberapa file (atau array) dan menggabungkan semuanya.

```php
<?php

use Phalcon\Config\Adapter\Grouped;

$config = new Grouped(
    [
        "path/to/config.php",
        "path/to/config.dist.php",
    ]
);

```

```php
<?php

use Phalcon\Config\Adapter\Grouped;

$config = new Grouped(
    [
        "path/to/config.json",
        "path/to/config.dist.json",
    ],
    "json"
);

```

```php
<?php

use Phalcon\Config\Adapter\Grouped;

$config = new Grouped(
    [
        [
            "filePath" => "path/to/config.php",
            "adapter"  => "php",
        ],
        [
            "filePath" => "path/to/config.json",
            "adapter"  => "json",
        ],
        [
            "adapter"  => "array",
            "config"   => [
                "property" => "value",
        ],
    ],
);

```

## Constants

*string* **DEFAULT_PATH_DELIMITER**

## Metode

umum **__construct** (*array* $arrayConfig, [*campuran* $defaultAdapter])

Phalcon\Config\Adapter\Grouped constructor

public **offsetExists** (*mixed* $index) inherited from [Phalcon\Config](Phalcon_Config)

Memungkinkan untuk memeriksa apakah atribut didefinisikan menggunakan array-syntax

```php
<? php

var_dump)
isset($config["database"])
);

```

public **path** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter]) inherited from [Phalcon\Config](Phalcon_Config)

Mengembalikan nilai dari konfigurasi saat ini menggunakan jalur yang dipisahkan titik.

```php
<?php

echo $config->path("unknown.path", "default", ".");

```

public **get** (*mixed* $index, [*mixed* $defaultValue]) inherited from [Phalcon\Config](Phalcon_Config)

Mendapatkan atribut dari konfigurasi, jika atribut tidak didefinisikan mengembalikan null Jika nilainya benar-benar null atau tidak didefinisikan, nilai default akan digunakan sebagai gantinya

```php
<?php

echo $config->get("controllersDir", "../app/controllers/");

```

public **offsetGet** (*mixed* $index) inherited from [Phalcon\Config](Phalcon_Config)

Mendapat atribut menggunakan sintaks-array

```php
<?php

print_r(
    $config["database"]
);

```

public **offsetSet** (*mixed* $index, *mixed* $value) inherited from [Phalcon\Config](Phalcon_Config)

Menetapkan atribut menggunakan sintaks-array

```php
<?php

$config["database"] = [
    "type" => "Sqlite",
];

```

public **offsetUnset** (*mixed* $index) inherited from [Phalcon\Config](Phalcon_Config)

Unsets an attribute using the array-syntax

```php
<?php

unset($config["database"]);

```

public **merge** ([Phalcon\Config](Phalcon_Config) $config) inherited from [Phalcon\Config](Phalcon_Config)

Menggabungkan konfigurasi menjadi yang sekarang

```php
<?php

$appConfig = new \Phalcon\Config(
    [
        "database" => [
            "host" => "localhost",
        ],
    ]
);

$globalConfig->merge($appConfig);

```

public **toArray** () inherited from [Phalcon\Config](Phalcon_Config)

Mengonversi objek secara rekursif ke sebuah array

```php
<?php

print_r(
    $config->toArray()
);

```

public **count** () inherited from [Phalcon\Config](Phalcon_Config)

Mengembalikan jumlah properti yang ditetapkan dalam konfigurasi

```php
<?php

print count($config);

```

or

```php
<?php

print $config->count();

```

public static **__set_state** (*array* $data) inherited from [Phalcon\Config](Phalcon_Config)

Restores the state of a Phalcon\Config object

public static **setPathDelimiter** ([*mixed* $delimiter]) inherited from [Phalcon\Config](Phalcon_Config)

Mengatur pembatas jalur default

public static **getPathDelimiter** () inherited from [Phalcon\Config](Phalcon_Config)

Mendapatkan pembatas jalur default

final protected *Config merged config* **_merge** (*Config* $config, [*mixed* $instance]) inherited from [Phalcon\Config](Phalcon_Config)

Metode Helper untuk menggabungkan konfigurasi (contoh nested forwarding nested)