---
layout: default
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Config\Adapter\Php'
---
# Class **Phalcon\Config\Adapter\Php**

*extends* class [Phalcon\Config](Phalcon_Config)

*implements* [Countable](https://php.net/manual/en/class.countable.php), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config/adapter/php.zep)

Reads php files and converts them to Phalcon\Config objects.

Given the next configuration file:

```php
<?php

<?php

return [
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
];

```

You can read it as follows:

```php
<?php

$config = new \Phalcon\Config\Adapter\Php("path/config.php");

echo $config->phalcon->controllersDir;
echo $config->database->username;

```

## 常量

*string* **DEFAULT_PATH_DELIMITER**

## 方法

public **__construct** (*mixed* $filePath)

Phalcon\Config\Adapter\Php constructor

public **offsetExists** (*mixed* $index) inherited from [Phalcon\Config](Phalcon_Config)

Allows to check whether an attribute is defined using the array-syntax

```php
<?php

var_dump(
    isset($config["database"])
);

```

public **path** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter]) inherited from [Phalcon\Config](Phalcon_Config)

Returns a value from current config using a dot separated path.

```php
<?php

echo $config->path("unknown.path", "default", ".");

```

public **get** (*mixed* $index, [*mixed* $defaultValue]) inherited from [Phalcon\Config](Phalcon_Config)

Gets an attribute from the configuration, if the attribute isn't defined returns null If the value is exactly null or is not defined the default value will be used instead

```php
<?php

echo $config->get("controllersDir", "../app/controllers/");

```

public **offsetGet** (*mixed* $index) inherited from [Phalcon\Config](Phalcon_Config)

Gets an attribute using the array-syntax

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

Unsets an attribute using the array-syntax

```php
<?php

unset($config["database"]);

```

public **merge** ([Phalcon\Config](Phalcon_Config) $config) inherited from [Phalcon\Config](Phalcon_Config)

Merges a configuration into the current one

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

Converts recursively the object to an array

```php
<?php

print_r(
    $config->toArray()
);

```

public **count** () inherited from [Phalcon\Config](Phalcon_Config)

Returns the count of properties set in the config

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

Sets the default path delimiter

public static **getPathDelimiter** () inherited from [Phalcon\Config](Phalcon_Config)

Gets the default path delimiter

final protected *Config merged config* **_merge** (*Config* $config, [*mixed* $instance]) inherited from [Phalcon\Config](Phalcon_Config)

Helper method for merge configs (forwarding nested config instance)