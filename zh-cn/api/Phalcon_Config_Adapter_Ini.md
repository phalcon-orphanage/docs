---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Config\Adapter\Ini'
---
# Class **Phalcon\Config\Adapter\Ini**

*extends* class [Phalcon\Config](Phalcon_Config)

*implements* [Countable](https://php.net/manual/en/class.countable.php), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config/adapter/ini.zep)

Reads ini files and converts them to Phalcon\Config objects.

给出下一个配置文件：

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

你可以阅读它，如下所示：

```php
<?php

$config = new \Phalcon\Config\Adapter\Ini("path/config.ini");

echo $config->phalcon->controllersDir;
echo $config->database->username;

```

PHP 常量也能在 ini 文件中进行解析，所以如果在调用该构造函数之前定义一个常量作为 ini 的值，常量的值将被整合到结果。 若要以此方式使用它，你必须在调用构造函数时，指定可选的第二个参数，作为 INI_SCANNER_NORMAL ：

```php
<?php

$config = new \Phalcon\Config\Adapter\Ini(
    "path/config-with-constants.ini",
    INI_SCANNER_NORMAL
);

```

## 常量

*string* **DEFAULT_PATH_DELIMITER**

## 方法

public **__construct** (*mixed* $filePath, [*mixed* $mode])

Phalcon\Config\Adapter\Ini constructor

protected **_parseIniString** (*mixed* $path, *mixed* $value)

从字符串构建多维数组

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

我们必须手动将值转换，因为 parse_ini_file() 已执行不力。

public **offsetExists** (*mixed* $index) inherited from [Phalcon\Config](Phalcon_Config)

检查是否使用的数组的属性是否已定义

```php
<?php

var_dump(
    isset($config["database"])
);

```

public **path** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter]) inherited from [Phalcon\Config](Phalcon_Config)

从当前配置使用点分隔路径返回一个值。

```php
<?php

echo $config->path("unknown.path", "default", ".");

```

public **get** (*mixed* $index, [*mixed* $defaultValue]) inherited from [Phalcon\Config](Phalcon_Config)

从配置中获取属性，如果该属性没有定义则返回 null ，如果默认值存在且这个属性是完全为空或未定义的将返回默认值

```php
<?php

echo $config->get("controllersDir", "../app/controllers/");

```

public **offsetGet** (*mixed* $index) inherited from [Phalcon\Config](Phalcon_Config)

获取配置数组对应键名的值

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

清空配置数组的这个键

```php
<?php

unset($config["database"]);

```

public **merge** ([Phalcon\Config](Phalcon_Config) $config) inherited from [Phalcon\Config](Phalcon_Config)

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

public **toArray** () inherited from [Phalcon\Config](Phalcon_Config)

将对象以递归方式的转换为数组

```php
<?php

print_r(
    $config->toArray()
);

```

public **count** () inherited from [Phalcon\Config](Phalcon_Config)

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

public static **__set_state** (*array* $data) inherited from [Phalcon\Config](Phalcon_Config)

Restores the state of a Phalcon\Config object

public static **setPathDelimiter** ([*mixed* $delimiter]) inherited from [Phalcon\Config](Phalcon_Config)

设置默认路径的分隔符

public static **getPathDelimiter** () inherited from [Phalcon\Config](Phalcon_Config)

获取默认路径的分隔符

final protected *Config merged config* **_merge** (*Config* $config, [*mixed* $instance]) inherited from [Phalcon\Config](Phalcon_Config)

合并配置 （转发嵌套的配置实例） 的辅助方法