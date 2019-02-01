---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Config\Adapter\Php'
---
# Class **Phalcon\Config\Adapter\Php**

*extends* class [Phalcon\Config](Phalcon_Config)

*implements* [Countable](https://php.net/manual/en/class.countable.php), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/config/adapter/php.zep)

Reads php files and converts them to Phalcon\Config objects.

Dado el siguiente archivo de configuración:

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

Usted puede leerlo como sigue:

```php
<?php

$config = new \Phalcon\Config\Adapter\Php("path/config.php");

echo $config->phalcon->controllersDir;
echo $config->database->username;

```

## Constantes

*string* **DEFAULT_PATH_DELIMITER**

## Métodos

public **__construct** (*mixed* $filePath)

Phalcon\Config\Adapter\Php constructor

public **offsetExists** (*mixed* $index) inherited from [Phalcon\Config](Phalcon_Config)

Permite verificar si un atributo se define usando la sintaxis de matriz

```php
<?php

var_dump(
    isset($config["database"])
);

```

public **path** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter]) inherited from [Phalcon\Config](Phalcon_Config)

Devuelve un valor de la configuración actual utilizando una ruta separada por puntos.

```php
<?php

echo $config->path("unknown.path", "default", ".");

```

public **get** (*mixed* $index, [*mixed* $defaultValue]) inherited from [Phalcon\Config](Phalcon_Config)

Obtiene un atributo de la configuración; si el atributo no está definido, devuelve un valor nulo Si el valor es exactamente nulo o no está definido, se usará el valor predeterminado en su lugar

```php
<?php

echo $config->get("controllersDir", "../app/controllers/");

```

public **offsetGet** (*mixed* $index) inherited from [Phalcon\Config](Phalcon_Config)

Obtiene un atributo usando la sintaxis de matriz

```php
<?php

print_r(
    $config["database"]
);

```

public **offsetSet** (*mixed* $index, *mixed* $value) inherited from [Phalcon\Config](Phalcon_Config)

Establece un atributo usando la sintaxis de matriz

```php
<?php

$config["database"] = [
    "type" => "Sqlite",
];

```

public **offsetUnset** (*mixed* $index) inherited from [Phalcon\Config](Phalcon_Config)

Deshace un atributo usando la sintaxis de matriz

```php
<?php

unset($config["database"]);

```

public **merge** ([Phalcon\Config](Phalcon_Config) $config) inherited from [Phalcon\Config](Phalcon_Config)

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

public **toArray** () inherited from [Phalcon\Config](Phalcon_Config)

Convierte recursivamente el objeto a una matriz

```php
<?php

print_r(
    $config->toArray()
);

```

public **count** () inherited from [Phalcon\Config](Phalcon_Config)

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

public static **__set_state** (*array* $data) inherited from [Phalcon\Config](Phalcon_Config)

Restores the state of a Phalcon\Config object

public static **setPathDelimiter** ([*mixed* $delimiter]) inherited from [Phalcon\Config](Phalcon_Config)

Establece el delimitador de ruta predeterminado

public static **getPathDelimiter** () inherited from [Phalcon\Config](Phalcon_Config)

Obtiene el delimitador de ruta predeterminado

final protected *Config merged config* **_merge** (*Config* $config, [*mixed* $instance]) inherited from [Phalcon\Config](Phalcon_Config)

Método de ayuda para las configuraciones de combinación (reenvío de la instancia de configuración anidada)