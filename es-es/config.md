---
layout: default
language: 'es-es'
version: '4.0'
title: 'Configuración'
keywords: 'config, fábrica, configuración, agrupado, ini, json, array, yaml'
---

# Config

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Casi todas las aplicaciones requieren datos de configuración para funcionar correctamente. La configuración puede contener parámetros y ajustes iniciales para la aplicación como localización de ficheros de registro, valores de conexión a base de datos, servicios registrados, etc. [Phalcon\Config](api/phalcon_config) está diseñado para almacenar estos datos de configuración de una forma orientada a objetos fácil. El componente se puede instanciar usando un vector PHP directamente o leer ficheros de configuración desde varios formatos como se describirá más adelante en la sección de adaptadores. [Phalcon\Config](api/phalcon_config) extiende el objeto [Phalcon\Collection](api/phalcon_collection) y hereda así su funcionalidad.

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

Podemos crear un `Phalcon\Config` o cualquiera de las clases adaptador soportadas `Phalcon\Config\Adapter\*` usando la palabra clave `new`. Sin embargo Phalcon ofrece la clase `Phalcon\Config\ConfigFactory`, para que los desarrolladores puedan instanciar fácilmente los objetos de configuración. Llamando a `newInstance` con `name`, `fileName` y un vector `parameters` devolverá el nuevo objeto de configuración.

Los valores permitidos para `name`, que corresponden a diferentes clases adaptador son: * `grouped` * `ini` * `json` * `php` * `yaml`

El siguiente ejemplo muestra cómo crear un nuevo adaptador basado en un [vector PHP](api/phalcon_config#config-adapter-php):

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

En el ejemplo anterior, se usará el adaptador [PHP](api/phalcon_config#config-adapter-php) (extensión del fichero) y el fichero se cargará para usted.

Si se pasa un vector, entonces se necesita el elemento `adapter` para especificar qué adaptador va a crearse. Adicionalmente, se necesita `filePath` para especificar donde se encuentra el fichero a cargar. Más información de qué puede contener el vector se puede encontrar en la sección de adaptadores.

Dado un fichero de configuración INI `/app/storage/config.ini`

```ini
[config]
adapter = ini
filePath = PATH_DATA"storage/config"
mode = 1
```

la función `load` creará un objeto de configuración [Ini](api/phalcon_config#config-adapter-ini):

```php
<?php

use Phalcon\Cache\CacheFactory;

$fileName = '/app/storage/config.ini';
$factory  = new ConfigFactory();

$config = $factory->load($fileName);
```

## Excepciones

Cualquier excepción lanzada en el componente [Phalcon\Config](api/phalcon_config) será del tipo [Phalcon\Config\Exception](api/phalcon_config#config-exception). Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

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

El componente [Phalcon\Config](api/phalcon_config) acepta un vector PHP en el constructor y lo carga.

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

Finalmente puede usar el método `get()` y encadenarlo para recorrer los objetos anidados:

```php
<?php

echo $config
        ->get('app')
        ->get('name');  // PHALCON
```

Ya que [Phalcon\Config](api/phalcon_config) extiende [Phalcon\Collection](api/phalcon_collection) también puede pasar un segundo parámetro en `get()` que actuará como valor por defecto devuelto, si el elemento de configuración determinado no está definido.

### Combinar

Hay veces que podríamos necesitar combinar datos de configuración que vienen de dos objetos de configuración diferentes. Por ejemplo podríamos tener un objeto de configuración que contiene nuestros ajustes base/predeterminados, mientras que un segundo objeto de configuración carga opciones que son específicas para el sistema en el que se está ejecutando la aplicación (ej: test, desarrollo, producción, etc.). Los datos específicos del sistema pueden venir desde un fichero `.env` y cargados con una librería[DotEnv](https://github.com/josegonzalez/php-dotenv).

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

Para información adicional, puede comprobar la documentación de [Phalcon\Collection](api/phalcon_collection).

## Adaptadores

Además del componente base [Phalcon\Config](api/phalcon_config), que acepta una cadena (nombre y ruta de fichero) o un vector nativo de PHP, hay varios adaptadores disponibles que pueden leer diferentes tipos de ficheros y cargar la configuración desde ellos.

Los adaptadores disponibles son:

| Clase                                                                          | Descripción                                                                                                      |
| ------------------------------------------------------------------------------ | ---------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Config\Adapter\Grouped](api/phalcon_config#config-adapter-grouped) | Carga diferentes ficheros de configuración basados en adaptadores iguales o diferentes.                          |
| [Phalcon\Config\Adapter\Ini](api/phalcon_config#config-adapter-ini)         | Carga la configuración desde ficheros INI. Internamente el adaptador utiliza la función `parse_ini_file` de PHP. |
| [Phalcon\Config\Adapter\Json](api/phalcon_config#config-adapter-json)       | Carga la configuración desde ficheros JSON. Requiere que la extensión PHP `json` esté presente en el sistema.    |
| [Phalcon\Config\Adapter\Php](api/phalcon_config#config-adapter-php)         | Carga la configuración desde vectores multidimensionales PHP. Este adaptador ofrece el mejor rendimiento.        |
| [Phalcon\Config\Adapter\Yaml](api/phalcon_config#config-adapter-yaml)       | Carga la configuración desde ficheros YAML. Requiere que la extensión PHP `yaml` esté presente en el sistema.    |

## Grouped

El adaptador [Phalcon\Config\Adapter\Grouped](api/phalcon_config#config-adapter-grouped) le permite crear un objeto [Phalcon\Config](api/phalcon_config) desde múltiples fuentes sin tener que crear cada objeto de forma separada desde su fuente y luego combinarlos. Acepta un vector de configuración con los datos necesarios así como `defaultAdapter` que se establece a `php` por defecto.

El primer parámetro del constructor (`arrayConfig`) es un vector multidimensional que requiere las siguientes opciones

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

Finalmente, puede usar un objeto [Phalcon\Config](api/phalcon_config), como una opción para su objeto agrupado.

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

Los ficheros ini son una forma común de almacenar datos de configuración. [Phalcon\Config\Ini](api/phalcon_config#config-adapter-ini) usa la función optimizada de PHP [parse_ini_file](https://www.php.net/manual/en/function.parse-ini-file.php) para leer estos ficheros. Cada sección representa un elemento de nivel superior. Los subelementos se dividen en colecciones anidadas si las claves tienen el separador `.`. Por defecto, el método de escaneo del fichero ini es `INI_SCANNER_RAW`. Sin embargo, se puede sobreescribir pasando un modo diferente en el constructor como segundo parámetro.

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

Siempre que quiera usar el componente [Phalcon\Config\ConfigFactory](api/phalcon_config#config-configfactory), podrá establecer el `modo` como parámetro.

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

> **NOTA**: Requiere que la extensión de PHP `json` esté presente en el sistema
{: .alert .alert-info }

JSON es un formato muy popular, especialmente cuando transporta datos desde tu aplicación al frontal o cuando devuelve respuestas desde un API. También se puede usar para almacenar datos de configuración. [Phalcon\Config\Json](api/phalcon_config#config-adapter-json) usa `json_decode()` internamente para convertir un fichero JSON a un vector nativo PHP y analizarlo en consecuencia.

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

Siempre que quiera usar el componente [Phalcon\Config\ConfigFactory](api/phalcon_config#config-configfactory), sólo necesitará pasar el nombre del fichero.

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

El adaptador [Phalcon\Config\Php](api/phalcon_config#config-adapter-php) lee un fichero PHP que devuelve un vector y lo carga en el objeto [Phalcon\Config](api/phalcon_config). Puede almacenar su configuración como un vector PHP en un fichero y devolver el vector. El adaptador lo leerá y analizará en consecuencia.

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

Siempre que quiera usar el componente [Phalcon\Config\ConfigFactory](api/phalcon_config#config-configfactory), sólo necesitará pasar el nombre del fichero.

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

> **NOTA**: Requiere que la extensión de PHP yaml esté presente en el sistema
{: .alert .alert-info }

Otro formato de fichero común es YAML. [Phalcon\Config\Yaml](api/phalcon_config#config-adapter-yaml) requiere que la extensión PHP `yaml` esté presente en su sistema. Usa la función PHP [yaml_parse_file](https://www.php.net/manual/en/function.yaml-parse-file.php) para leer estos ficheros. El adaptador lee un fichero `yaml` proporcionado como primer parámetro del constructor, pero también acepta un segundo parámetro `callbacks` como un vector. `callbacks` proporciona manejadores de contenido para nodos YAML. Es un vector asociativo de mapeos `tag => callable`.

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

Siempre que quiera usar el componente [Phalcon\Config\ConfigFactory](api/phalcon_config#config-configfactory), podrá establecer el `modo` como parámetro.

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

Hay más adaptadores disponibles para Configuración en [Phalcon Incubator](https://github.com/phalcon/incubator)

## Inyección de Dependencias

Como en la mayoría de componentes Phalcon, puede almacenar el objeto [Phalcon\Config](api/phalcon_config) en su contenedor [Phalcon\Di](di). Al hacerlo, podrá acceder a su objeto de configuración desde controladores, modelos, vistas y cualquier componente que implemente `Injectable`.

A continuación un ejemplo de registro del servicio así como de acceso a él:

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
