---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Config'
---
# Class **Phalcon\Config**

*implements* [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [Countable](https://php.net/manual/en/class.countable.php)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config.zep)

Phalcon\Config is designed to simplify the access to, and the use of, configuration data within applications. Esto proporciona una interfaz de usuario basada en propiedades de objeto anidadas para acceder a estos datos de configuración dentro de código de aplicación.

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

## Constantes

*string* **DEFAULT_PATH_DELIMITER**

## Métodos

public **__construct** ([*array* $arrayConfig])

Phalcon\Config constructor

public **offsetExists** (*mixed* $index)

Permite verificar si un atributo se define usando la sintaxis de matriz

```php
<?php

var_dump(
    isset($config["database"])
);

```

public **path** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter])

Devuelve un valor de la configuración actual utilizando una ruta separada por puntos.

```php
<?php

echo $config->path("unknown.path", "default", ".");

```

public **get** (*mixed* $index, [*mixed* $defaultValue])

Obtiene un atributo de la configuración; si el atributo no está definido, devuelve un valor nulo Si el valor es exactamente nulo o no está definido, se usará el valor predeterminado en su lugar

```php
<?php

echo $config->get("controllersDir", "../app/controllers/");

```

public **offsetGet** (*mixed* $index)

Obtiene un atributo usando la sintaxis de matriz

```php
<?php

print_r(
    $config["database"]
);

```

public **offsetSet** (*mixed* $index, *mixed* $value)

Establece un atributo usando la sintaxis de matriz

```php
<?php

$config["database"] = [
    "type" => "Sqlite",
];

```

public **offsetUnset** (*mixed* $index)

Deshace un atributo usando la sintaxis de matriz

```php
<?php

unset($config["database"]);

```

public **merge** ([Phalcon\Config](Phalcon_Config) $config)

Fusiona una configuración en la actual

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

Convierte recursivamente el objeto a una matriz

```php
<?php

print_r(
    $config->toArray()
);

```

public **count** ()

Devuelve el recuento de propiedades establecidas en la configuración

```php
<?php

print count($config);

```

o

```php
<?php

print $config->count();

```

public static **__set_state** (*array* $data)

Restores the state of a Phalcon\Config object

public static **setPathDelimiter** ([*mixed* $delimiter])

Establece el delimitador de ruta predeterminado

public static **getPathDelimiter** ()

Obtiene el delimitador de ruta predeterminado

final protected *Config merged config* **_merge** (*Config* $config, [*mixed* $instance])

Método de ayuda para las configuraciones de combinación (reenvío de la instancia de configuración anidada)