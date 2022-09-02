---
layout: default
title: 'Configuración'
upgrade: '#config'
keywords: 'config, fábrica, configuración, agrupado, ini, json, array, yaml'
---

# Config
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
Casi todas las aplicaciones requieren datos de configuración para funcionar correctamente. La configuración puede contener parámetros y ajustes iniciales para la aplicación como localización de ficheros de registro, valores de conexión a base de datos, servicios registrados, etc. The [Phalcon\Config\Config][config] is designed to store this configuration data in an easy object-oriented way. El componente se puede instanciar usando un vector PHP directamente o leer ficheros de configuración desde varios formatos como se describirá más adelante en la sección de adaptadores. [Phalcon\Config\Config][config] extends the [Phalcon\Support\Collection][collection] object and thus inheriting its functionality.

```php
<?php

use Phalcon\Config;

$config = new Config(
    [
        'app' => [
            'baseUri'  => getenv('APP_BASE_URI'),
            'env'      => getenv('APP_ENV'),
            'name'     => getenv('APP_NAME'),
            'timezone' => getenv('APP_TIMEZONE'),
            'url'      => getenv('APP_URL'),
            'version'  => getenv('VERSION'),
            'time'     => microtime(true),
        ],
    ]
);

echo $config->get('app')->get('name');  // PHALCON
echo $config->app->name;                // PHALCON
echo $config->path('app.name');         // PHALCON
```

## Fábrica (Factory)
### `newInstance`
We can easily create a `Phalcon\Config\Config` or any of the supporting adapter classes `Phalcon\Config\Adapter\*` by using the `new` keyword. However, Phalcon offers the `Phalcon\Config\ConfigFactory` class, so that developers can easily instantiate config objects. Llamando a `newInstance` con `name`, `fileName` y un vector `parameters` devolverá el nuevo objeto de configuración.

The allowed values for `name`, which correspond to a different adapter class are:

| Nombre    | Adaptador                                    |
| --------- | -------------------------------------------- |
| `grouped` | [Phalcon\Config\Adapter\Grouped][grouped] |
| `ini`     | [Phalcon\Config\Adapter\Ini][ini]         |
| `json`    | [Phalcon\Config\Adapter\Json][json]       |
| `php`     | [Phalcon\Config\Adapter\Php][php]         |
| `yaml`    | [Phalcon\Config\Adapter\Yaml][yaml]       |

The example below how to create a new [PHP array][php] based adapter:

Dado un fichero de configuración PHP `/app/storage/config.php`

```php
<?php

return [
    'app' => [
        'baseUri'  => getenv('APP_BASE_URI'),
        'env'      => getenv('APP_ENV'),
        'name'     => getenv('APP_NAME'),
        'timezone' => getenv('APP_TIMEZONE'),
        'url'      => getenv('APP_URL'),
        'version'  => getenv('VERSION'),
        'time'     => microtime(true),
    ],
];
```

lo puede cargar de la siguiente manera:

```php
<?php

use Phalcon\Config\ConfigFactory;

$fileName = '/app/storage/config.php';
$factory  = new ConfigFactory();

$config = $factory->newInstance('php', $fileName);
```

Como se ha visto arriba, el tercer parámetro para `newInstance` que es un vector no se ha pasado porque no es necesario. Sin embargo, otros tipos de adaptador lo usan, con lo que puede proporcionarlo dependiendo del tipo de adaptador que use. Puede encontrar más información sobre qué puede contener el vector `parameters` en la sección de adaptadores.

### `load`
La Fábrica de Configuración también ofrece el método `load`, que acepta una cadena o un vector como parámetro. Si se pasa una cadena, se trata como el `fileName` del fichero que necesitamos cargar. La extensión del fichero es la que determina el adaptador a usar.

```php
<?php

use Phalcon\Cache\CacheFactory;

$fileName = '/app/storage/config.php';
$factory  = new ConfigFactory();

$config = $factory->load($fileName);
```

In the above example, the [PHP][php] adapter will be used (extension of the file) and the file will be loaded for you.

Si se pasa un vector, entonces se necesita el elemento `adapter` para especificar qué adaptador va a crearse. Adicionalmente, se necesita `filePath` para especificar donde se encuentra el fichero a cargar. Más información de qué puede contener el vector se puede encontrar en la sección de adaptadores.

Dado un fichero de configuración INI `/app/storage/config.ini`

```ini
[config]
adapter = ini
filePath = PATH_DATA"storage/config"
mode = 1
```

the `load` function will create an [Ini][ini] config object:

```php
<?php

use Phalcon\Cache\CacheFactory;

$fileName = '/app/storage/config.ini';
$factory  = new ConfigFactory();

$config = $factory->load($fileName);
```

## Excepciones
Any exceptions thrown in the [Phalcon\Config\Config][config] component will be of type [Phalcon\Config\Exception][config-exception]. Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Config\Exception;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            // Get some configuration values
            $this->config->database->dbname;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Vector Nativo
The [Phalcon\Config\Config][config] component accepts a PHP array in the constructor and loads it up.

```php
<?php

use Phalcon\Config;

$config = new Config(
    [
        'app' => [
            'baseUri'  => getenv('APP_BASE_URI'),  // '/'
            'env'      => getenv('APP_ENV'),       // 3
            'name'     => getenv('APP_NAME'),      // 'PHALCON'
            'timezone' => getenv('APP_TIMEZONE'),  // 'UTC'
            'url'      => getenv('APP_URL'),       // 'http://127.0.0.1',
            'version'  => getenv('VERSION'),       // '0.1'
            'time'     => microtime(true),         // 
        ],
    ]
);
```

### Obtener
#### Magia
Puede obtener los datos desde el objeto utilizando la clave como una propiedad (método mágico):

```php
<?php

echo $config->app->name; // PHALCON
```

#### Path
También puede usar el método `path()`con un delimitador, para pasar una cadena que contiene las claves separadas por el delimitador:

```php
<?php

echo $config->path('app.name'); // PHALCON
```

`path()` también afecta un `valorPredeterminado` que, si se indica, se devolverá si el elemento no se encuentra o no está establecido en el objeto de configuración. El último parámetro de `path()` es el delimitador a usar para dividir la cadena pasada (`path`) que también denota el nivel de anidación.

```php
<?php

echo $config->path('app-name', 'default', '-');     // PHALCON
echo $config->path('app-unknown', 'default', '-');  // default
```

También puede usar los métodos `getPathDelimiter()` y `setPathDelimiter()` para obtener y establecer el delimitador que usará el componente. El parámetro `delimitador` del método `path()` se puede usar entonces para sobreescribir si lo desea, para un caso especial, mientras que el delimitador se establece usando el *getter* y *setter*. El delimitador predeterminado es `.`.

También puede usar programación funcional en conjunto con `path()` para obtener datos de configuración:

```php
<?php

use Phalcon\Di;
use Phalcon\Config;

/**
 * @return mixed|Config
 */
function config() {
    $args = func_get_args();
    $config = Di::getDefault()->getShared('config');

    if (empty($args)) {
       return $config;
    }

    return call_user_func_array(
        [$config, 'path'],
        $args
    );
}
```
y luego puede usar:
```php
<?php

echo config('app-name', 'default', '-');     // PHALCON
echo config('app-unknown', 'default', '-');  // default
```

#### Obtener
Finally, you can use the `get()` method and chain it to traverse the nested objects:

```php
<?php

echo $config
        ->get('app')
        ->get('name');  // PHALCON
```

Since [Phalcon\Config\Config][config] extends [Phalcon\Support\Collection][collection] you can also pass a second parameter in the `get()` that will act as the default value returned, should the particular config element is not defined.

### Combinar
Hay veces que podríamos necesitar combinar datos de configuración que vienen de dos objetos de configuración diferentes. For instance, we might have one config object that contains our base/default settings, while a second config object loads options that are specific to the system the application is running on (i.e. test, development, production etc.). The system specific data can come from a `.env` file and loaded with a [DotEnv][dotenv] library.

En el escenario anterior, necesitaremos combinar el segundo objeto de configuración con el primero. `merge()` nos permite hacer esto, combinar los dos objetos de configuración recursivamente.

```php
<?php

use Phalcon\Config;
use josegonzalez\Dotenv\Loader;

$baseConfig = new Config(
    [
        'app' => [
            'baseUri'  => '/',
            'env'      => 3,
            'name'     => 'PHALCON',
            'timezone' => 'UTC',
            'url'      => 'http://127.0.0.1',
            'version'  => '0.1',
        ],
    ]
);


// .env
// APP_NAME='MYAPP'
// APP_TIMEZONE='America/New_York'

$loader = (new josegonzalez\Dotenv\Loader('/app/.env'))
    ->parse()
    ->toEnv()
;

$envConfig= new Config(
    [
        'app'     => [
            'baseUri'  => getenv('APP_BASE_URI'),  // '/'
            'env'      => getenv('APP_ENV'),       // 3
            'name'     => getenv('APP_NAME'),      // 'MYAPP'
            'timezone' => getenv('APP_TIMEZONE'),  // 'America/New_York'
            'url'      => getenv('APP_URL'),       // 'http://127.0.0.1',
            'version'  => getenv('VERSION'),       // '0.1'
            'time'     => microtime(true),         //
        ],
        'logging' => true,
    ]
);

$baseConfig->merge($envConfig);

echo $baseConfig
        ->get('app')
        ->get('name');  // MYAPP
echo $baseConfig
        ->get('app')
        ->get('timezone');  // America/New_York
echo $baseConfig
        ->get('app')
        ->get('time');  // 1562909409.6162
```

El objeto combinado será:

```bash
Phalcon\Config Object
(
    [app] => Phalcon\Config Object
        (
            [baseUri]  => '/',
            [env]      => 3,
            [name]     => 'MYAPP',
            [timezone] => 'America/New_York',
            [url]      => 'http://127.0.0.1',
            [version]  => '0.1',
            [time]     => microtime(true),
        )
    [logging] => true
)
```

### Has
Usando `has()` puede determinar si una clave particular existe en la colección.

### Establecer
El componente también soporta `set()` que le permite añadir o cambiar programáticamente los datos cargados.

### Serialización
El objeto se puede serializar y guardar en un fichero o servicio de caché usando el método `serialize()`. Se puede lograr lo contrario usando el método `unserialize`

### `toArray` / `toJson`
Si necesita recuperar el objeto como un vector `toArray()` y `toJson()` están disponibles.

For additional information, you can check the [Phalcon\Support\Collection](support-collection) documentation.

## Adaptadores
Other than the base component [Phalcon\Config\Config][config], which accepts a string (file name and path) or a native PHP array, there are several available adapters that can read different file types and load the configuration from them.

Los adaptadores disponibles son:

| Clase                                        | Descripción                                                                                                      |
| -------------------------------------------- | ---------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Config\Adapter\Grouped][grouped] | Carga diferentes ficheros de configuración basados en adaptadores iguales o diferentes.                          |
| [Phalcon\Config\Adapter\Ini][ini]         | Carga la configuración desde ficheros INI. Internamente el adaptador utiliza la función `parse_ini_file` de PHP. |
| [Phalcon\Config\Adapter\Json][json]       | Carga la configuración desde ficheros JSON. Requiere que la extensión PHP `json` esté presente en el sistema.    |
| [Phalcon\Config\Adapter\Php][php]         | Carga la configuración desde vectores multidimensionales PHP. Este adaptador ofrece el mejor rendimiento.        |
| [Phalcon\Config\Adapter\Yaml][yaml]       | Carga la configuración desde ficheros YAML. Requiere que la extensión PHP `yaml` esté presente en el sistema.    |

## Grouped
The [Phalcon\Config\Adapter\Grouped][grouped] adapter allows you to create a [Phalcon\Config\Config][config] object from multiple sources without having to create each object separately from its source and then merge them together. Acepta un vector de configuración con los datos necesarios así como `defaultAdapter` que se establece a `php` por defecto.

The first parameter of the constructor (`arrayConfig`) is a multidimensional array which requires the following options

- `adapter` - el adaptador a usar
- `filePath` - la ruta del fichero de configuración

```php
<?php

use Phalcon\Config\Adapter\Grouped;

$options = [
    [
        'adapter'  => 'php',
        'filePath' => '/apps/storage/config.php',
    ],
    [
        'adapter'  => 'ini',
        'filePath' => '/apps/storage/database.ini',
        'mode'     => INI_SCANNER_NORMAL,
    ],
    [
        'adapter'  => 'json',
        'filePath' => '/apps/storage/override.json',
    ],
];

$config = new Grouped($options);
```

El conjunto de claves para cada elemento del vector (que representa un fichero de configuración) refleja los parámetros del constructor de cada adaptador. Puede encontrar más información sobre los parámetros necesarios u opcionales en la sección correspondiente que describe cada adaptador.

También puede usar `array` como valor del adaptador. Si elige hacerlo, necesitará usar `config` como segunda clave, con valores que representan los valores actuales de la configuración que quiere cargar.

```php
<?php

use Phalcon\Config\Adapter\Grouped;

$options = [
    [
        'adapter'  => 'php',
        'filePath' => '/apps/storage/config.php',
    ],
    [
        'adapter'  => 'array',
        'config'   => [
            'app' => [
                'baseUri'  => '/',
                'env'      => 3,
                'name'     => 'PHALCON',
                'timezone' => 'UTC',
                'url'      => 'http://127.0.0.1',
                'version'  => '0.1',
            ],
        ],
    ],
];

$config = new Grouped($options);
```

Finally, you can also use a [Phalcon\Config\Config][config] object, as an option to your grouped object.

```php
<?php

use Phalcon\Config;
use Phalcon\Config\Adapter\Grouped;

$baseConfig = new Config(
    [
        'app' => [
            'baseUri'  => '/',
            'env'      => 3,
            'name'     => 'PHALCON',
        ],
    ]
);

$options = [
    $baseConfig,
    [
        'adapter'  => 'array',
        'config'   => [
            'app' => [
                'timezone' => 'UTC',
                'url'      => 'http://127.0.0.1',
                'version'  => '0.1',
            ],
        ],
    ],
];

$config = new Grouped($options);
```

## Ini
Los ficheros ini son una forma común de almacenar datos de configuración. [Phalcon\Config\Ini][ini] uses the optimized PHP function [parse_ini_file][parse-ini-file] to read these files. Cada sección representa un elemento de nivel superior. Los subelementos se dividen en colecciones anidadas si las claves tienen el separador `.`. By default, the scanning method of the ini file is `INI_SCANNER_RAW`. Sin embargo, se puede sobreescribir pasando un modo diferente en el constructor como segundo parámetro.

```ini
[database]
adapter  = Mysql
host     = localhost
username = scott
password = cheetah
dbname   = test_db

[config]
adapter  = ini
filePath = PATH_DATA"storage/config"
mode = 1

[models]
metadata.adapter  = 'Memory'
```

Puede leer el fichero de la siguiente forma:

```php
<?php

use Phalcon\Config\Adapter\Ini;

$fileName = '/apps/storage/config.ini';
$mode     =  INI_SCANNER_NORMAL;
$config   = new Ini($fileName, $mode);

echo $config
        ->get('database')
        ->get('host');       // localhost
echo $config
        ->get('models')
        ->get('metadata')
        ->get('adapter');    // Memory
```

Whenever you want to use the [Phalcon\Config\ConfigFactory][config-configfactory] component, you can set the `mode` as a parameter.

```php
<?php

use Phalcon\Cache\CacheFactory;

$fileName = '/app/storage/config.ini';
$factory  = new ConfigFactory();

$options = [
    'adapter'  => 'ini',
    'filePath' => $fileName,
    'mode'     => INI_SCANNER_NORMAL, 
];

$config = $factory->load($options);
```

o cuando use `newInstance()` en su lugar:

```php
<?php

use Phalcon\Cache\CacheFactory;

$fileName = '/app/storage/config.ini';
$factory  = new ConfigFactory();

$params = [
    'mode' => INI_SCANNER_NORMAL, 
];

$config = $factory->newinstance('ini', $fileName, $params);
```

## Json
> **NOTE**: Requires PHP's `json` extension to be present in the system 
> 
> {: .alert .alert-info }

JSON es un formato muy popular, especialmente cuando transporta datos desde tu aplicación al frontal o cuando devuelve respuestas desde un API. También se puede usar para almacenar datos de configuración. [Phalcon\Config\Adapter\Json][json] uses `json_decode()` internally to convert a JSON file to a PHP native array and parse it accordingly.

```json
{
    "database": {
        "adapter": "Mysql",
        "host": "localhost",
        "username": "scott",
        "password": "cheetah",
        "dbname": "test_db"  
    },
    "models": {
        "metadata": {
            "adapter": "Memory"
        }
    }
}
```

Puede leer el fichero de la siguiente forma:

```php
<?php

use Phalcon\Config\Adapter\Json;

$fileName = '/apps/storage/config.json';
$config   = new Json($fileName);

echo $config
        ->get('database')
        ->get('host');       // localhost
echo $config
        ->get('models')
        ->get('metadata')
        ->get('adapter');    // Memory
```

Whenever you want to use the [Phalcon\Config\ConfigFactory][config-configfactory] component, you will just need to pass the name of the file.

```php
<?php

use Phalcon\Cache\CacheFactory;

$fileName = '/app/storage/config.json';
$factory  = new ConfigFactory();

$options = [
    'adapter'  => 'json',
    'filePath' => $fileName,
];

$config = $factory->load($options);
```

o cuando use `newInstance()` en su lugar:

```php
<?php

use Phalcon\Cache\CacheFactory;

$fileName = '/app/storage/config.json';
$factory  = new ConfigFactory();

$config = $factory->newinstance('json', $fileName);
```

## Php
The [Phalcon\Config\Adapter\Php][php] adapter reads a PHP file that returns an array and loads it in the [Phalcon\Config\Config][config] object. Puede almacenar su configuración como un vector PHP en un fichero y devolver el vector. El adaptador lo leerá y analizará en consecuencia.

```php
<?php

return [ 
    'database' => [
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'scott',
        'password' => 'cheetah',
        'dbname'   => 'test_db',  
    ],
    'models'   => [
        'metadata' => [
            'adapter' => 'Memory',
        ],
    ],
];
```

Puede leer el fichero de la siguiente forma:

```php
<?php

use Phalcon\Config\Adapter\Php;

$fileName = '/apps/storage/config.php';
$config   = new Php($fileName);

echo $config
        ->get('database')
        ->get('host');       // localhost
echo $config
        ->get('models')
        ->get('metadata')
        ->get('adapter');    // Memory
```

Whenever you want to use the [Phalcon\Config\ConfigFactory][config-configfactory] component, you will just need to pass the name of the file.

```php
<?php

use Phalcon\Cache\CacheFactory;

$fileName = '/app/storage/config.php';
$factory  = new ConfigFactory();

$options = [
    'adapter'  => 'php',
    'filePath' => $fileName,
];

$config = $factory->load($options);
```

o cuando use `newInstance()` en su lugar:

```php
<?php

use Phalcon\Cache\CacheFactory;

$fileName = '/app/storage/config.php';
$factory  = new ConfigFactory();

$config = $factory->newinstance('php', $fileName);
```

## Yaml

> **NOTE**: Requires PHP's yaml extension to be present in the system 
> 
> {: .alert .alert-info }

Otro formato de fichero común es YAML. [Phalcon\Config\Adapter\Yaml][yaml] requires the `yaml` PHP extension to be present in your system. It uses the PHP function [yaml_parse_file][yaml-parse-file] to read these files. El adaptador lee un fichero `yaml` proporcionado como primer parámetro del constructor, pero también acepta un segundo parámetro `callbacks` como un vector. `callbacks` proporciona manejadores de contenido para nodos YAML. Es un vector asociativo de mapeos `tag => callable`.

```yaml
app:
  baseUri: /     
  env: 3         
  name: PHALCON        
  timezone: UTC    
  url: http://127.0.0.1         
  version: 0.1
  time: 1562960897.712697          
models:
  metadata:
    adapter: Memory
loggers:
  handlers:
    0:
      name: stream
    1:
      name: redis
```

Puede leer el fichero de la siguiente forma:

```php
<?php

use Phalcon\Config\Adapter\Yaml;

define("APPROOT", dirname(__DIR__));

$fileName  = '/apps/storage/config.yml';
$callbacks = [
    "!approot" => function($value) {
        return APPROOT . $value;
    },
];
$config    = new Yaml($fileName, $callbacks);

echo $config
        ->get('database')
        ->get('host');       // localhost
echo $config
        ->get('models')
        ->get('metadata')
        ->get('adapter');    // Memory
```

Whenever you want to use the [Phalcon\Config\ConfigFactory][config-configfactory] component, you can set the `mode` as a parameter.

```php
<?php

use Phalcon\Cache\CacheFactory;

define("APPROOT", dirname(__DIR__));

$fileName = '/apps/storage/config.yml';
$factory  = new ConfigFactory();
$options  = [
    'adapter'  => 'yaml',
    'filePath'  => $fileName,
    'callbacks' => [
        "!approot" => function($value) {
            return APPROOT . $value;
        },
    ],
];

$config = $factory->load($options);
```

o cuando use `newInstance()` en su lugar:

```php
<?php

use Phalcon\Cache\CacheFactory;

define("APPROOT", dirname(__DIR__));

$fileName  = '/app/storage/config.yaml';
$factory   = new ConfigFactory();
$callbacks = [
    "!approot" => function($value) {
        return APPROOT . $value;
    },
];

$config = $factory->newinstance('yaml', $fileName, $callbacks);
```

## Adaptadores Personalizados
There are more adapters available for Config in the [Phalcon Incubator][phalcon-incubator]

## Inyección de Dependencias
As with most Phalcon components, you can store the [Phalcon\Config\Config][config] object in your [Phalcon\Di\Di](di) container. Al hacerlo, podrá acceder a su objeto de configuración desde controladores, modelos, vistas y cualquier componente que implemente `Injectable`.

A continuación, un ejemplo de registro del servicio así como de acceso a él:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Config;

// Create a container
$container = new FactoryDefault();

$container->set(
    'config',
    function () {
        $configData = require 'config/config.php';

        return new Config($configData);
    }
);
```

El componente está ahora disponible en sus controladores usando la clave `config`

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Config;

/**
 * @property Config $config
 */
class MyController extends Controller
{
    private function getDatabaseName()
    {
        return $this->config->database->dbname;
    }
}
```

También en sus vistas (sintaxis Volt)

```twig
{% raw %}{{ config.database.dbname }}{% endraw %}
```

[config]: api/phalcon_config
[collection]: support-collection
[phalcon-incubator]: https://github.com/phalcon/incubator
[grouped]: api/phalcon_config#config-adapter-grouped
[ini]: api/phalcon_config#config-adapter-ini
[ini]: api/phalcon_config#config-adapter-ini
[ini]: api/phalcon_config#config-adapter-ini
[json]: api/phalcon_config#config-adapter-json
[php]: api/phalcon_config#config-adapter-php
[php]: api/phalcon_config#config-adapter-php
[php]: api/phalcon_config#config-adapter-php
[yaml]: api/phalcon_config#config-adapter-yaml
[config-configfactory]: api/phalcon_config#config-configfactory
[config-exception]: api/phalcon_config#config-exception
[dotenv]: https://github.com/josegonzalez/php-dotenv
[parse-ini-file]: https://www.php.net/manual/en/function.parse-ini-file.php
[yaml-parse-file]: https://www.php.net/manual/en/function.yaml-parse-file.php
