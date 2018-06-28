# Clase **Phalcon\\Config\\Adapter\\Json**

*extiende* de clase [Phalcon\Config](/en/3.2/api/Phalcon_Config)

*implementa* [Countable](http://php.net/manual/en/class.countable.php), [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/config/adapter/json.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Lee archivos JSON y los convierte en objetos de configuración Phalcon\\Config.

Dado el siguiente archivo de configuración:

```php
<?php

{"phalcon":{"baseuri":"\/phalcon\/"},"models":{"metadata":"memory"}}

```

Usted puede leerlo de la sigue manera:

```php
<?php

$config = new Phalcon\Config\Adapter\Json("path/config.json");

echo $config->phalcon->baseuri;
echo $config->models->metadata;

```

## Constantes

*string* **DEFAULT_PATH_DELIMITER**

## Métodos

public **__construct** (*mixed* $filePath)

Constructor de Phalcon\\Config\\Adapter\\Json

public **offsetExists** (*mixed* $index) heredado de [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Permite verificar si un atributo es definido usando la sintaxis de matriz

```php
<?php

var_dump(
    isset($config["database"])
);

```

public **path** (*mixed* $path, [*mixed* $defaultValue], [*mixed* $delimiter]) heredado desde [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Devuelve un valor de la configuración actual utilizando una ruta separada por puntos.

```php
<?php

echo $config->path("unknown.path", "default", ".");

```

public **get** (*mixed* $index, [*mixed* $defaultValue]) hereado desde [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Obtiene un atributo de la configuración, si el atributo no está definido, devuelve un valor nulo. Si el valor es exactamente nulo o no está definido, se usará el valor predeterminado en su lugar

```php
<?php

echo $config->get("controllersDir", "../app/controllers/");

```

public **offsetGet** (*mixed* $index) heredado desde [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Obtiene un atributo usando la sintaxis de matriz

```php
<?php

print_r(
    $config["database"]
);

```

public **offsetSet** (*mixed* $index, *mixed* $value) heredado desde [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Establece un atributo usando la sintaxis de matriz

```php
<?php

$config["database"] = [
    "type" => "Sqlite",
];

```

public **offsetUnset** (*mixed* $index) heredado desde [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Remueve un atributo usando la sintaxis de matriz

```php
<?php

unset($config["database"]);

```

public **merge** ([Phalcon\Config](/en/3.2/api/Phalcon_Config) $config) heredado desde [Phalcon\Config](/en/3.2/api/Phalcon_Config)

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

public **toArray** () heredado desde [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Convierte recursivamente el objeto a una matriz

```php
<?php

print_r(
    $config->toArray()
);

```

public **count** () heredado desde [Phalcon\Config](/en/3.2/api/Phalcon_Config)

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

public static **__set_state** (*array* $data) heredado desde [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Restaura el estado de un objeto configurado por Phalcon

public static **setPathDelimiter** ([*mixed* $delimiter]) heredado desde [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Establece el delimitador de ruta predeterminado

public static **getPathDelimiter** () heredado desde [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Obtiene el delimitador de ruta predeterminado

final protected *Config merged config* **_merge** (*Config* $config, [*mixed* $instance]) heredado desde [Phalcon\Config](/en/3.2/api/Phalcon_Config)

Método de ayuda para las configuraciones de combinación (reenvío de la instancia de configuración anidada)