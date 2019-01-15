* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Config'

* * *

# Class **Phalcon\Config**

*implements* [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [Countable](https://php.net/manual/en/class.countable.php)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/config.zep" class="btn btn-default btn-sm">源码在GitHub</a>

Phalcon\Config is designed to simplify the access to, and the use of, configuration data within applications. It provides a nested object property based user interface for accessing this configuration data within application code.

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

Allows to check whether an attribute is defined using the array-syntax

```php
<?php

var_dump(
    isset($config["database"])
);

```

public **path** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter])

Returns a value from current config using a dot separated path.

```php
<?php

echo $config->path("unknown.path", "default", ".");

```

public **get** (*mixed* $index, [*mixed* $defaultValue])

Gets an attribute from the configuration, if the attribute isn't defined returns null If the value is exactly null or is not defined the default value will be used instead

```php
<?php

echo $config->get("controllersDir", "../app/controllers/");

```

public **offsetGet** (*mixed* $index)

Gets an attribute using the array-syntax

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

Unsets an attribute using the array-syntax

```php
<?php

unset($config["database"]);

```

public **merge** ([Phalcon\Config](/4.0/en/api/Phalcon_Config) $config)

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

public **toArray** ()

Converts recursively the object to an array

```php
<?php

print_r(
    $config->toArray()
);

```

public **count** ()

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

public static **__set_state** (*array* $data)

Restores the state of a Phalcon\Config object

public static **setPathDelimiter** ([*mixed* $delimiter])

Sets the default path delimiter

public static **getPathDelimiter** ()

Gets the default path delimiter

final protected *Config merged config* **_merge** (*Config* $config, [*mixed* $instance])

Helper method for merge configs (forwarding nested config instance)