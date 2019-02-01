---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Config'
---
# Class **Phalcon\Config**

*implements* [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [Countable](https://php.net/manual/en/class.countable.php)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config.zep)

Phalcon\Config is designed to simplify the access to, and the use of, configuration data within applications. Es bietet eine auf verschachtelten Objekteigenschaften basierende Benutzeroberfläche für den Zugriff auf diese Konfigurationsdaten innerhalb des Anwendungscode.

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

## Konstanten

*string* **DEFAULT_PATH_DELIMITER**

## Methoden

public **__construct** ([*array* $arrayConfig])

Phalcon\Config constructor

public **offsetExists** (*mixed* $index)

Ermöglicht es zu prüfen, ob ein Attribut mit der Array-Syntax definiert ist

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

Holt ein Attribut aus der Konfiguration, wenn das Attribut nicht definiert ist, gibt es null zurück, wenn der Wert genau null ist oder nicht definiert ist, dann wird stattdessen der Standardwert verwendet

```php
<?php

echo $config->get("controllersDir", "../app/controllers/");

```

public **offsetGet** (*mixed* $index)

Holt ein Attribut mittels der Array-syntax

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

public **merge** ([Phalcon\Config](Phalcon_Config) $config)

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