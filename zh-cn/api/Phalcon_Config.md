---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Config'
---
# Class **Phalcon\Config**

*implements* [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [Countable](https://php.net/manual/en/class.countable.php)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config.zep)

Phalcon\Config is designed to simplify the access to, and the use of, configuration data within applications. 它提供用于在应用程序中访问此配置数据的嵌套的对象属性基于用户数据。

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

## 常量

*string* **DEFAULT_PATH_DELIMITER**

## 方法

public **__construct** ([*array* $arrayConfig])

Phalcon\Config constructor

public **offsetExists** (*mixed* $index)

检查是否使用的数组的属性是否已定义

```php
<?php

var_dump(
    isset($config["database"])
);

```

public **path** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter])

从当前配置使用点分隔路径返回一个值。

```php
<?php

echo $config->path("unknown.path", "default", ".");

```

public **get** (*mixed* $index, [*mixed* $defaultValue])

从配置中获取属性，如果该属性没有定义则返回 null ，如果默认值存在且这个属性是完全为空或未定义的将返回默认值

```php
<?php

echo $config->get("controllersDir", "../app/controllers/");

```

public **offsetGet** (*mixed* $index)

获取配置数组对应键名的值

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

清空配置数组的这个键

```php
<?php

unset($config["database"]);

```

public **merge** ([Phalcon\Config](Phalcon_Config) $config)

将配置合并到当前

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

将对象以递归方式的转换为数组

```php
<?php

print_r(
    $config->toArray()
);

```

public **count** ()

返回配置中设置的属性的计数

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

设置默认路径的分隔符

public static **getPathDelimiter** ()

获取默认路径的分隔符

final protected *Config merged config* **_merge** (*Config* $config, [*mixed* $instance])

合并配置 （转发嵌套的配置实例） 的辅助方法