---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Config'
---

* [Phalcon\Config](#config)
* [Phalcon\Config\Adapter\Grouped](#config-adapter-grouped)
* [Phalcon\Config\Adapter\Ini](#config-adapter-ini)
* [Phalcon\Config\Adapter\Json](#config-adapter-json)
* [Phalcon\Config\Adapter\Php](#config-adapter-php)
* [Phalcon\Config\Adapter\Yaml](#config-adapter-yaml)
* [Phalcon\Config\ConfigFactory](#config-configfactory)
* [Phalcon\Config\ConfigInterface](#config-configinterface)
* [Phalcon\Config\Exception](#config-exception)

<h1 id="config">Class Phalcon\Config</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Config.zep)

| Namespace | Phalcon | | Uses | Phalcon\Collection, Phalcon\Config\ConfigInterface, Phalcon\Config\Exception | | Extends | Collection | | Implements | ConfigInterface |

`Phalcon\Config` está diseñado para simplificar el acceso a, y el uso de, los datos de configuración de las aplicaciones. Proporciona una propiedad de objeto anidado basada en interfaz de usuario para acceder a estos datos de configuración dentro del código de la aplicación.

```php
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

```php
const DEFAULT_PATH_DELIMITER = .;
```

## Propiedades

```php
/**
 * @var string
 */
protected pathDelimiter;

```

## Métodos

```php
public function getPathDelimiter(): string;
```

Devuelve el delimitador de ruta por defecto

```php
public function merge( mixed $toMerge ): ConfigInterface;
```

Combina una configuración con la actual

```php
$appConfig = new \Phalcon\Config(
    [
        "database" => [
            "host" => "localhost",
        ],
    ]
);

$globalConfig->merge($appConfig);
```

```php
public function path( string $path, mixed $defaultValue = null, mixed $delimiter = null ): mixed | null;
```

Devuelve un valor de la configuración actual usando una ruta separada por puntos.

```php
echo $config->path("unknown.path", "default", ".");
```

```php
public function setPathDelimiter( string $delimiter = null ): ConfigInterface;
```

Establece el delimitador de la ruta predeterminada

```php
public function toArray(): array;
```

Convierte recursivamente el objeto a un vector

```php
print_r(
    $config->toArray()
);
```

```php
final protected function internalMerge( array $source, array $target ): array;
```

Ejecuta una combinación recursivamente

```php
protected function setData( mixed $element, mixed $value ): void;
```

Establece los datos de la colección

<h1 id="config-adapter-grouped">Class Phalcon\Config\Adapter\Grouped</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Config/Adapter/Grouped.zep)

| Namespace | Phalcon\Config\Adapter | | Uses | Phalcon\Config, Phalcon\Config\ConfigFactory, Phalcon\Config\ConfigInterface, Phalcon\Config\Exception, Phalcon\Factory\Exception | | Extends | Config |

Lee múltiples ficheros (o vectores) y los combina todos juntos.

Ver `Phalcon\Config\Factory::load` para cargar la clase `Config Adapter` usando la opción *'adapter'*.

```php
use Phalcon\Config\Adapter\Grouped;

$config = new Grouped(
    [
        "path/to/config.php",
        "path/to/config.dist.php",
    ]
);
```

```php
use Phalcon\Config\Adapter\Grouped;

$config = new Grouped(
    [
        "path/to/config.json",
        "path/to/config.dist.json",
    ],
    "json"
);
```

```php
use Phalcon\Config\Adapter\Grouped;

$config = new Grouped(
    [
        [
            "filePath" => "path/to/config.php",
            "adapter"  => "php",
        ],
        [
            "filePath" => "path/to/config.json",
            "adapter"  => "json",
        ],
        [
            "adapter"  => "array",
            "config"   => [
                "property" => "value",
            ],
        ],
    ],
);
```

## Métodos

```php
public function __construct( array $arrayConfig, string $defaultAdapter = string );
```

Constructor Phalcon\Config\Adapter\Grouped

<h1 id="config-adapter-ini">Class Phalcon\Config\Adapter\Ini</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Config/Adapter/Ini.zep)

| Namespace | Phalcon\Config\Adapter | | Uses | Phalcon\Config, Phalcon\Config\Exception | | Extends | Config |

Lee ficheros ini y los convierte a objetos Phalcon\Config.

Dado el siguiente fichero de configuración:

```ini
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

Puede leerlo de la siguiente manera:

```php
use Phalcon\Config\Adapter\Ini;

$config = new Ini("path/config.ini");

echo $config->phalcon->controllersDir;
echo $config->database->username;
```

Las constantes PHP también se pueden analizar en el fichero ini, así que si define una constante como un valor ini antes de llamar al constructor, el valor de la constante será integrada en los resultados. Para usarlo de esta forma debe especificar el segundo parámetro opcional como `INI_SCANNER_NORMAL` cuando llame al constructor:

```php
$config = new \Phalcon\Config\Adapter\Ini(
    "path/config-with-constants.ini",
    INI_SCANNER_NORMAL
);
```

## Métodos

```php
public function __construct( string $filePath, mixed $mode = null );
```

Constructor Ini.

```php
protected function cast( mixed $ini ): bool | null | double | int | string;
```

Tenemos que convertir valores manualmente porque parse_ini_file() tiene una implementación pobre.

```php
protected function parseIniString( string $path, mixed $value ): array;
```

Construye un vector multidimensional desde una cadena

<h1 id="config-adapter-json">Class Phalcon\Config\Adapter\Json</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Config/Adapter/Json.zep)

| Namespace | Phalcon\Config\Adapter | | Uses | Phalcon\Config, Phalcon\Helper\Json | | Extends | Config |

Lee ficheros JSON y los convierte a objetos Phalcon\Config.

Dado el siguiente fichero de configuración:

```json
{"phalcon":{"baseuri":"\/phalcon\/"},"models":{"metadata":"memory"}}
```

Puede leerlo de la siguiente manera:

```php
use Phalcon\Config\Adapter\Json;

$config = new Json("path/config.json");

echo $config->phalcon->baseuri;
echo $config->models->metadata;
```

## Métodos

```php
public function __construct( string $filePath );
```

Constructor Phalcon\Config\Adapter\Json

<h1 id="config-adapter-php">Class Phalcon\Config\Adapter\Php</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Config/Adapter/Php.zep)

| Namespace | Phalcon\Config\Adapter | | Uses | Phalcon\Config | | Extends | Config |

Lee ficheros php y los convierte a objetos Phalcon\Config.

Dado el siguiente fichero de configuración:

```php
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

Puede leerlo de la siguiente manera:

```php
use Phalcon\Config\Adapter\Php;

$config = new Php("path/config.php");

echo $config->phalcon->controllersDir;
echo $config->database->username;
```

## Métodos

```php
public function __construct( string $filePath );
```

Constructor Phalcon\Config\Adapter\Php

<h1 id="config-adapter-yaml">Class Phalcon\Config\Adapter\Yaml</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Config/Adapter/Yaml.zep)

| Namespace | Phalcon\Config\Adapter | | Uses | Phalcon\Config, Phalcon\Config\Exception | | Extends | Config |

Lee ficheros YAML y los convierte a objetos Phalcon\Config.

Dado el siguiente fichero de configuración:

```yaml
phalcon:
  baseuri:        /phalcon/
  controllersDir: !approot  /app/controllers/
models:
  metadata: memory
```

Puede leerlo de la siguiente manera:

```php
define(
    "APPROOT",
    dirname(__DIR__)
);

use Phalcon\Config\Adapter\Yaml;

$config = new Yaml(
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

## Métodos

```php
public function __construct( string $filePath, array $callbacks = null );
```

Constructor Phalcon\Config\Adapter\Yaml

<h1 id="config-configfactory">Class Phalcon\Config\ConfigFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Config/ConfigFactory.zep)

| Namespace | Phalcon\Config | | Uses | Phalcon\Config, Phalcon\Config\ConfigInterface, Phalcon\Factory\AbstractFactory, Phalcon\Helper\Arr | | Extends | AbstractFactory |

Carga la clase `Config Adapter` usando la opción 'adapter', si no se proporciona ninguna extensión será añadirá al filePath

```php
use Phalcon\Config\ConfigFactory;

$options = [
    "filePath" => "path/config",
    "adapter"  => "php",
];

$config = (new ConfigFactory())->load($options);
```

## Métodos

```php
public function __construct( array $services = [] );
```

Constructor ConfigFactory.

```php
public function load( mixed $config ): ConfigInterface;
```

Carga una configuración para crear una nueva instancia

```php
public function newInstance( string $name, string $fileName, mixed $params = null ): ConfigInterface;
```

Devuelve una nueva instancia de configuración

```php
protected function getAdapters(): array;
```

Devuelve los adaptadores de la fábrica

<h1 id="config-configinterface">Interface Phalcon\Config\ConfigInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Config/ConfigInterface.zep)

| Namespace | Phalcon\Config | | Uses | Phalcon\Collection\CollectionInterface | | Extends | CollectionInterface |

Phalcon\Config\ConfigInterface

Interfaz para la clase Phalcon\Config

## Métodos

```php
public function getPathDelimiter(): string;
```

```php
public function merge( mixed $toMerge ): ConfigInterface;
```

```php
public function path( string $path, mixed $defaultValue = null, mixed $delimiter = null ): mixed | null;
```

```php
public function setPathDelimiter( string $delimiter = null ): ConfigInterface;
```

<h1 id="config-exception">Class Phalcon\Config\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Config/Exception.zep)

| Namespace | Phalcon\Config | | Extends | \Phalcon\Exception |

Las excepciones lanzadas en Phalcon\Config usarán esta clase
