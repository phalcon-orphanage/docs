---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Config'
---
# Class **Phalcon\Config**

*implements* [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [Countable](https://php.net/manual/en/class.countable.php)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config.zep)

Phalcon\Config is designed to simplify the access to, and the use of, configuration data within applications. Uygulama kodundaki yapılandırma verisine erişmek için iç içe geçmiş bir nesne özelliğini temel alan kullanıcı arabirimi sağlar.

```php
<?php

$config = new \Phalcon\Config(
    [
        "database" => [
            "adapter"  => "Mysql",
            "host"     => "localhost",
            "username" => "scott",
            "password" => "cheetah",
            "dbname"   => "test_db",
        ],
        "phalcon" => [
            "controllersDir" => "../app/controllers/",
            "modelsDir"      => "../app/models/",
            "viewsDir"       => "../app/views/",
        ],
    ]
);

```

## Sabitler

*string* **DEFAULT_PATH_DELIMITER**

## Metodlar

public **__construct** ([*array* $arrayConfig])

Phalcon\Config constructor

public **offsetExists** (*mixed* $index)

Bir özelliğin dizi sözdizimini kullanarak tanımlı olup olmadığını kontrol etmeye izin verir

```php
<?php

var_dump(
    isset($config["database"])
);

```

public **path** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter])

Mevcut yapılandırmada nokta kullanılarak ayrılmış yolun değerini döndürür.

```php
<?php

echo $config->path("unknown.path", "default", ".");

```

public **get** (*mixed* $index, [*mixed* $defaultValue])

Yapılandırmadan bir özellik döndürür, eğer özellik tanımlanmamışsa boş döndürür Değer kesinlikle boş ise veya tanımlanmamışsa, bunun yerine varsayılan değer kullanılacaktır

```php
<?php

echo $config->get("controllersDir", "../app/controllers/");

```

public **offsetGet** (*mixed* $index)

Dizi sözdizimini kullanarak bir özellik döndürür

```php
<?php

print_r(
    $config["database"]
);

```

public **offsetSet** (*mixed* $index, *mixed* $value)

Sets an attribute using the array-syntax

```php
<?php

$config["database"] = [
    "type" => "Sqlite",
];

```

public **offsetUnset** (*mixed* $index)

Dizi sözdizimini kullanarak bir özelliği kaldırır

```php
<?php

unset($config["database"]);

```

public **merge** ([Phalcon\Config](Phalcon_Config) $config)

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

public **toArray** ()

Nesneyi bir diziye özyinelemeli olarak dönüştürür

```php
<?php

print_r(
    $config->toArray()
);

```

herkese açık **say** ()

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

public static **__set_state** (*array* $data)

Restores the state of a Phalcon\Config object

public static **setPathDelimiter** ([*mixed* $delimiter])

Varsayılan yol ayırıcı ayarlar

public static **getPathDelimiter** ()

Varsayılan yol ayırıcıyı getirir

final protected *Config merged config* **_merge** (*Config* $config, [*mixed* $instance])

Yapılandırmaları birleştirme için yardımcı metot (iç içe yapılandırma örneklerini yönlendirir)