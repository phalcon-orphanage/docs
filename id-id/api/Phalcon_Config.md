---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Config'
---
# Class **Phalcon\Config**

*implements* [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [Countable](https://php.net/manual/en/class.countable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config.zep)

Phalcon\Config is designed to simplify the access to, and the use of, configuration data within applications. Ini menyediakan properti bertingkat berbasis user interface untuk mengakses data konfigurasi ini di dalamnya kode aplikasi.

```php
<? php

$config = (\Phalcon\Config) baru
[
"database" = > [
"adaptor" = > "Mysql",
"host" = > "localhost",
"username" = > "scott",
"password" = > "cheetah",
"dbname" = > "test_db",
],
"phalcon" = > [
"controllersDir" = > "... /App/controller / ",
"modelsDir" = > "... /App/model / ",
"viewsDir" = > "... /App/views / ",
],
]
);

```

## Constants

*string* **DEFAULT_PATH_DELIMITER**

## Metode

umum **__construct** ([*array* $arrayConfig])

Phalcon\Config constructor

public **offsetExists** (*mixed* $index)

Memungkinkan untuk memeriksa apakah atribut didefinisikan menggunakan array-syntax

```php
<? php

var_dump)
isset($config["database"])
);

```

public **path** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter])

Mengembalikan nilai dari konfigurasi saat ini menggunakan jalur yang dipisahkan titik.

```php
<?php

echo $config->path("unknown.path", "default", ".");

```

public **get** (*mixed* $index, [*mixed* $defaultValue])

Mendapatkan atribut dari konfigurasi, jika atribut tidak didefinisikan mengembalikan null Jika nilainya benar-benar null atau tidak didefinisikan, nilai default akan digunakan sebagai gantinya

```php
<?php

echo $config->get("controllersDir", "../app/controllers/");

```

public **offsetGet** (*mixed* $index)

Mendapat atribut menggunakan sintaks-array

```php
<?php

print_r(
    $config["database"]
);

```

public **offsetSet** (*mixed* $index, *mixed* $value)

Menetapkan atribut menggunakan sintaks-array

```php
<?php

$config["database"] = [
    "type" => "Sqlite",
];

```

public **offsetUnset** (*mixed* $index)

Unsets an attribute using the array-syntax

```php
<?php

unset($config["database"]);

```

public **merge** ([Phalcon\Config](Phalcon_Config) $config)

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

publik **kunci** ()

Mengonversi objek secara rekursif ke sebuah array

```php
<?php

print_r(
    $config->toArray()
);

```

publik **menghitung**()

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

public static **__set_state** (*array* $data)

Restores the state of a Phalcon\Config object

public static **setPathDelimiter** ([*mixed* $delimiter])

Mengatur pembatas jalur default

public static **getPathDelimiter** ()

Mendapatkan pembatas jalur default

final protected *Config merged config* **_merge** (*Config* $config, [*mixed* $instance])

Metode Helper untuk menggabungkan konfigurasi (contoh nested forwarding nested)