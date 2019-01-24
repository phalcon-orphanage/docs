---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Config\Adapter\Ini'
---
# Class **Phalcon\Config\Adapter\Ini**

*extends* class [Phalcon\Config](Phalcon_Config)

*implements* [Countable](https://php.net/manual/en/class.countable.php), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config/adapter/ini.zep)

Reads ini files and converts them to Phalcon\Config objects.

Dengan file konfigurasi berikutnya:

```ini
<?php

[database]
adapter = Mysql
host = localhost
username = scott
password = cheetah
dbname = test_db

[phalcon]
controllersDir = "../app/controllers/"
modelsDir = "../app/models/"
viewsDir = "../app/views/"

```

Anda bisa membacakan sebagai berikut:

```php
<?php

$config = new \Phalcon\Config\Adapter\Ini("path/config.ini");

echo $config->phalcon->controllersDir;
echo $config->database->username;

```

Konstanta PHP juga dapat diuraikan dalam file ini, jadi jika Anda mendefinisikan sebuah konstanta Sebagai nilai ini sebelum memanggil konstruktor, nilai konstannya adalah diintegrasikan ke dalam hasil. Untuk menggunakannya dengan cara ini Anda harus menentukan pilihannya Parameter kedua seperti INI_SCANNER_NORMAL saat memanggil konstruktor:

```php
<?php

$config = new \Phalcon\Config\Adapter\Ini(
    "path/config-with-constants.ini",
    INI_SCANNER_NORMAL
);

```

## Constants

*string* **DEFAULT_PATH_DELIMITER**

## Metode

public **__construct** (*mixed* $filePath, [*mixed* $mode])

Phalcon\Config\Adapter\Ini constructor

dilindungi **_parseIniString** (*campuran* $path, *campuran* $value)

Membangun array multidimensi dari string

```php
<?php

$this->_parseIniString("path.hello.world", "value for last key");

// result
[
     "path" => [
         "hello" => [
             "world" => "value for last key",
         ],
     ],
];

```

protected **_cast** (*mixed* $ini)

Kita harus membuang nilai secara manual karena parse_ini_file() memiliki implementasi yang buruk.

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