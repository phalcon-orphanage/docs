---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Config\Adapter\Yaml'
---
# Class **Phalcon\Config\Adapter\Yaml**

*extends* class [Phalcon\Config](Phalcon_Config)

*implements* [Countable](https://php.net/manual/en/class.countable.php), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config/adapter/yaml.zep)

Reads YAML files and converts them to Phalcon\Config objects.

Aşağıdaki yapılandırma dosyası göz önüne alındığında:

```php
<?php

phalcon:
  baseuri:        /phalcon/
  controllersDir: !approot  /app/controllers/
models:
  metadata: memory

```

Bunu aşağıdaki şekilde okuyabilirsiniz:

```php
<?php

define(
    "APPROOT",
    dirname(__DIR__)
);

$config = new \Phalcon\Config\Adapter\Yaml(
    "path/config.yaml",
    [
        "!approot" => function($value) {
            return APPROOT . $value;
        },
    ]
);

echo $config->phalcon->controllersDir;
echo $config->phalcon->baseuri;
echo $config->models->metadata;

```

## Sabitler

*string* **DEFAULT_PATH_DELIMITER**

## Metodlar

public **__construct** (*mixed* $filePath, [*array* $callbacks])

Phalcon\Config\Adapter\Yaml constructor

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