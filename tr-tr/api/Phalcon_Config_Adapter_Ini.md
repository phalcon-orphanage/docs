---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Config\Adapter\Ini'
---
# Class **Phalcon\Config\Adapter\Ini**

*extends* class [Phalcon\Config](Phalcon_Config)

*implements* [Countable](https://php.net/manual/en/class.countable.php), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config/adapter/ini.zep)

Reads ini files and converts them to Phalcon\Config objects.

Bir sonraki yapılandırma dosyası verildiğinde:

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

Bunu aşağıdaki şekilde okuyabilirsiniz:

```php
<?php

$config = new \Phalcon\Config\Adapter\Ini("path/config.ini");

echo $config->phalcon->controllersDir;
echo $config->database->username;

```

PHP sabitleri de ini dosyası içinde ayrıştırılabilir, bu nedenle eğer yapıcıyı çağırmadan bir ini değerini sabit olarak tanımlarsanız, sabitin değeri sonuçlara dahil edilecektir. Bunu bu şekilde kullanmak için yapıcıyı çağırırken isteğe bağlı olan ikinci parametreyi INI_SCANNER_NORMAL olarak belirtmelisiniz:

```php
<?php

$config = new \Phalcon\Config\Adapter\Ini(
    "path/config-with-constants.ini",
    INI_SCANNER_NORMAL
);

```

## Sabitler

*string* **DEFAULT_PATH_DELIMITER**

## Metodlar

public **__construct** (*mixed* $filePath, [*mixed* $mode])

Phalcon\Config\Adapter\Ini constructor

protected **_parseIniString** (*mixed* $path, *mixed* $value)

Dilimden çok boyutlu diziyi oluşturun

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

Parse_ini_file() işlevinin zayıf bir şekilde uygulanması nedeniyle değerleri el ile atamamız gerekir.

public **offsetExists** (*mixed* $index) inherited from [Phalcon\Config](Phalcon_Config)

Bir özelliğin dizi sözdizimini kullanarak tanımlı olup olmadığını kontrol etmeye izin verir

```php
<?php

var_dump(
    isset($config["database"])
);

```

public **path** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter]) inherited from [Phalcon\Config](Phalcon_Config)

Mevcut yapılandırmada nokta kullanılarak ayrılmış yolun değerini döndürür.

```php
<?php

echo $config->path("unknown.path", "default", ".");

```

public **get** (*mixed* $index, [*mixed* $defaultValue]) inherited from [Phalcon\Config](Phalcon_Config)

Yapılandırmadan bir özellik döndürür, eğer özellik tanımlanmamışsa boş döndürür Değer kesinlikle boş ise veya tanımlanmamışsa, bunun yerine varsayılan değer kullanılacaktır

```php
<?php

echo $config->get("controllersDir", "../app/controllers/");

```

public **offsetGet** (*mixed* $index) inherited from [Phalcon\Config](Phalcon_Config)

Dizi sözdizimini kullanarak bir özellik döndürür

```php
<?php

print_r(
    $config["database"]
);

```

public **offsetSet** (*mixed* $index, *mixed* $value) inherited from [Phalcon\Config](Phalcon_Config)

Sets an attribute using the array-syntax

```php
<?php

$config["database"] = [
    "type" => "Sqlite",
];

```

public **offsetUnset** (*mixed* $index) inherited from [Phalcon\Config](Phalcon_Config)

Dizi sözdizimini kullanarak bir özelliği kaldırır

```php
<?php

unset($config["database"]);

```

public **merge** ([Phalcon\Config](Phalcon_Config) $config) inherited from [Phalcon\Config](Phalcon_Config)

Bir yapılandırma ile mevcut olanını birleştirir

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

Nesneyi bir diziye özyinelemeli olarak dönüştürür

```php
<?php

print_r(
    $config->toArray()
);

```

public **count** () inherited from [Phalcon\Config](Phalcon_Config)

Yapılandırmada ayarlanan özelliklerin sayısını döndürür

```php
<?php

print count($config);

```

veya

```php
<?php

print $config->count();

```

public static **__set_state** (*array* $data) inherited from [Phalcon\Config](Phalcon_Config)

Restores the state of a Phalcon\Config object

public static **setPathDelimiter** ([*mixed* $delimiter]) inherited from [Phalcon\Config](Phalcon_Config)

Varsayılan yol ayırıcı ayarlar

public static **getPathDelimiter** () inherited from [Phalcon\Config](Phalcon_Config)

Varsayılan yol ayırıcıyı getirir

final protected *Config merged config* **_merge** (*Config* $config, [*mixed* $instance]) inherited from [Phalcon\Config](Phalcon_Config)

Yapılandırmaları birleştirme için yardımcı metot (iç içe yapılandırma örneklerini yönlendirir)