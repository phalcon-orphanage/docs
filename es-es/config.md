---
layout: default
language: 'es-es'
version: '4.0'
title: 'Configuración'
keywords: 'config, factory, configuration, grouped, ini, json, array, yaml'
---

# Config Component

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Controladores

Nearly all applications require configuration data for it to operate correctly. The configuration can contain parameters and initial settings for the application like location of log files, database connection values, services registered etc. The [Phalcon\Config](api/phalcon_config) is designed to store this configuration data in an easy object oriented way. The component can be instantiated using a PHP array directly or read configuration files from various formats as described further down in the adapters section. [Phalcon\Config](api/phalcon_config) extends the [Phalcon\Collection](api/phalcon_collection) object and thus inheriting its functionality.

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

## Factory

### `newInstance`

We can easily create a `Phalcon\Config` or any of the supporting adapter classes `Phalcon\Config\Adapter\*` by using the `new` keyword. However Phalcon offers the `Phalcon\Config\ConfigFactory` class, so that developers can easily instantiate config objects. Calling `newInstance` with the `name`, `fileName` and a `parameters` array will return the new config object.

The allowed values for `name`, which correspond to a different adapter class are: * `grouped` * `ini` * `json` * `php` * `yaml`

The example below how to create a new [PHP array](api/phalcon_config#config-adapter-php) based adapter:

Given a PHP configuration file `/app/storage/config.php`

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

you can load it as follows:

```php
<?php

use Phalcon\Config\ConfigFactory;

$fileName = '/app/storage/config.php';
$factory  = new ConfigFactory();

$config = $factory->newInstance('php', $fileName);
```

As seen above, the third parameter for `newInstance` which is an array is not passed because it is not required. However, other adapter types use it, so you can supply it depending on the type of adapter you use. More information on what can be contained in the `parameters` array can be found in the adapters section.

### `load`

The Config Factory also offers the `load` method, which accepts a string or an array as a parameter. If a string is passed, it is treated as the `fileName` of the file that we need to load. The extension of the file is what determines the adapter that will be used.

```php
<?php

use Phalcon\Cache\CacheFactory;

$fileName = '/app/storage/config.php';
$factory  = new ConfigFactory();

$config = $factory->load($fileName);
```

In the above example, the [PHP](api/phalcon_config#config-adapter-php) adapter will be used (extension of the file) and the file will be loaded for you.

If an array is passed, then the `adapter` element is required to specify what adapter will be created. Additionally `filePath` is required to specify where the file to load is located. More information on what can be contained in the array cam be found in the adapters section.

Given an INI configuration file `/app/storage/config.ini`

```ini
[config]
adapter = ini
filePath = PATH_DATA"storage/config"
mode = 1
```

the `load` function will create a [Ini](api/phalcon_config#config-adapter-ini) config object:

```php
<?php

use Phalcon\Cache\CacheFactory;

$fileName = '/app/storage/config.ini';
$factory  = new ConfigFactory();

$config = $factory->load($fileName);
```

## Exceptions

Any exceptions thrown in the [Phalcon\Config](api/phalcon_config) component will be of type [Phalcon\Config\Exception](api/phalcon_config#config-exception). You can use this exception to selectively catch exceptions thrown only from this component.

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

## Native Array

The [Phalcon\Config](api/phalcon_config) component accepts a PHP array in the constructor and loads it up.

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

### Get

#### Magic

You can retrieve the data from the object either using the key as a property (magic method):

```php
<?php

echo $config->app->name; // PHALCON
```

#### Path

You can also use the `path()` method with a delimiter, to pass a string that will contain the keys separated by the delimiter:

```php
<?php

echo $config->path('app.name'); // PHALCON
```

`path()` also accepts a `defaultValue` which, if set, will be returned if the element is not found or is not set in the config object. The last parameter of `path()` is the delimiter to be used for splitting the passed string (`path`) which also denotes the nesting level.

```php
<?php

echo $config->path('app-name', 'default', '-');     // PHALCON
echo $config->path('app-unknown', 'default', '-');  // default
```

You can also use the `getPathDelimiter()` and `setPathDelimiter()` methods to get or set the delimiter that the component will use. The `delimiter` parameter in the `path()` method can then be used as an override if you like, for a special case, while the default delimiter is set using the getter and setter. The default delimiter is `.`.

You can also use functional programming in conjunction with `path()` to obtain configuration data:

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

and then you can use it:

```php
<?php

echo config('app-name', 'default', '-');     // PHALCON
echo config('app-unknown', 'default', '-');  // default
```

#### Get

Finally you can use the `get()` method and chain it to traverse the nested objects:

```php
<?php

echo $config
        ->get('app')
        ->get('name');  // PHALCON
```

Since [Phalcon\Config](api/phalcon_config) extends [Phalcon\Collection](api/phalcon_collection) you can also pass a second parameter in the `get()` that will act as the default value returned, should the particular config element is not defined.

### Merge

There are times that we might need to merge configuration data coming from two different config objects. For instance we might have one config object that contains our base/default settings, while a second config object loads options that are specific to the system the application is running on (i.e. test, development, production etc.). The system specific data can come from a `.env` file and loaded with a [DotEnv](https://github.com/josegonzalez/php-dotenv) library.

In the above scenario, we will need to merge the second configuration object with the first one. `merge()` allows us to do this, merging the two config objects recursively.

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

The merged object will be:

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

Using `has()` you can determine if a particular key exists in the collection.

### Set

The component also supports `set()` which allows you to programmatically add or change loaded data.

### Serialization

The object can be serialized and saved in a file or a cache service using the `serialize()` method. The reverse can be achieved using the `unserialize` method

### `toArray` / `toJson`

If you need to get the object back as an array `toArray()` and `toJson()` are available.

For additional information, you can check the [Phalcon\Collection](api/phalcon_collection) documentation.

## Adaptadores

Other than the base component [Phalcon\Config](api/phalcon_config), which accepts a string (file name and path) or a native PHP array, there are several available adapters that can read different file types and load the configuration from them.

The available adapters are:

| Clase                                                                          | Descripción                                                                                         |
| ------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------------------- |
| [Phalcon\Config\Adapter\Grouped](api/phalcon_config#config-adapter-grouped) | Loads different configuration files based on identical or different adapters.                       |
| [Phalcon\Config\Adapter\Ini](api/phalcon_config#config-adapter-ini)         | Loads configuration from INI files. Internally the adapter uses the PHP function `parse_ini_file`.  |
| [Phalcon\Config\Adapter\Json](api/phalcon_config#config-adapter-json)       | Loads configuration from JSON files. Requires the PHP `json` extension to be present in the system. |
| [Phalcon\Config\Adapter\Php](api/phalcon_config#config-adapter-php)         | Loads configuration from PHP multidimensional arrays. This adapter offers the best performance.     |
| [Phalcon\Config\Adapter\Yaml](api/phalcon_config#config-adapter-yaml)       | Loads configuration from YAML files. Requires the PHP `yaml` extension to be present in the system. |

## Grouped

The [Phalcon\Config\Adapter\Grouped](api/phalcon_config#config-adapter-grouped) adapter allows you to create a [Phalcon\Config](api/phalcon_config) object from multiple sources without having to create each object separately from its source and then merge them together. It accepts an array configuration with the necessary data as well as the `defaultAdapter` which is set to `php` by default.

The first parameter of the constructor (`arrayConfig`) is a multi dimensional array which requires the following options

- `adapter` - the adapter to be used
- `filePath` - the path of the configuration file

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

The keys set for each array element (representing one configuration file) mirror the constructor parameters of each adapter. More information regarding the parameters required or optional can be found in the relevant section describing each adapter.

You can also use `array` as the adapter value. If you choose to do so, you will need to use `config` as the second key, with values that represent the actual values of the configuration you want to load.

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

Finally you can also use a [Phalcon\Config](api/phalcon_config) object, as an option to your grouped object.

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

Ini files are a common way to store configuration data. [Phalcon\Config\Ini](api/phalcon_config#config-adapter-ini) uses the optimized PHP function [parse_ini_file](https://www.php.net/manual/en/function.parse-ini-file.php) to read these files. Each section represents a top level element. Sub elements are split into nested collections if the keys have the `.` separator. By default the scanning method of the ini file is `INI_SCANNER_RAW`. It can however be overridden by passing a different mode in the constructor as the second parameter.

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

You can read the file as follows:

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

Whenever you want to use the [Phalcon\Config\ConfigFactory](api/phalcon_config#config-configfactory) component, you will can set the `mode` as a parameter.

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

or when using the `newInstance()` instead:

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
{: .alert .alert-info }

JSON is a very popular format, especially when transporting data from your application to the front end or when sending back responses from an API. It can also be used as a storage for configuration data. [Phalcon\Config\Json](api/phalcon_config#config-adapter-json) uses `json_decode()` internally to convert a JSON file to a PHP native array and parse it accordingly.

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

You can read the file as follows:

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

Whenever you want to use the [Phalcon\Config\ConfigFactory](api/phalcon_config#config-configfactory) component, you will just need to pass the name of the file.

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

or when using the `newInstance()` instead:

```php
<?php

use Phalcon\Cache\CacheFactory;

$fileName = '/app/storage/config.json';
$factory  = new ConfigFactory();

$config = $factory->newinstance('json', $fileName);
```

## Php

The [Phalcon\Config\Php](api/phalcon_config#config-adapter-php) adapter reads a PHP file that returns an array and loads it in the [Phalcon\Config](api/phalcon_config) object. You can store your configuration as a PHP array in a file and return the array back. The adapter will read it and parse it accordingly.

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

You can read the file as follows:

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

Whenever you want to use the [Phalcon\Config\ConfigFactory](api/phalcon_config#config-configfactory) component, you will just need to pass the name of the file.

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

or when using the `newInstance()` instead:

```php
<?php

use Phalcon\Cache\CacheFactory;

$fileName = '/app/storage/config.php';
$factory  = new ConfigFactory();

$config = $factory->newinstance('php', $fileName);
```

## Yaml

> **NOTE**: Requires PHP's yaml extension to be present in the system
{: .alert .alert-info }

Another common file format is YAML. [Phalcon\Config\Yaml](api/phalcon_config#config-adapter-yaml) requires the `yaml` PHP extension to be present in your system. It uses the PHP function [yaml_parse_file](https://www.php.net/manual/en/function.yaml-parse-file.php) to read these files. The adapter reads a `yaml` file supplied as the first parameter of the constructor, but also accepts a second parameter `callbacks` as an array. The `callbacks` supplies content handlers for YAML nodes. It is an associative array of `tag => callable` mappings.

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

You can read the file as follows:

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

Whenever you want to use the [Phalcon\Config\ConfigFactory](api/phalcon_config#config-configfactory) component, you will can set the `mode` as a parameter.

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

or when using the `newInstance()` instead:

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

## Custom Adapters

There are more adapters available for Config in the [Phalcon Incubator](https://github.com/phalcon/incubator)

## Inyección de Dependencias

As with most Phalcon components, you can store the [Phalcon\Config](api/phalcon_config) object in your [Phalcon\Di](di) container. By doing so, you will be able to access your configuration object from controllers, models, views and any component that implements `Injectable`.

An example of the registration of the service as well as accessing it is below:

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

The component is now available in your controllers using the `config` key

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

Also in your views (Volt syntax)

```twig
{% raw %}{{ config.database.dbname }}{% endraw %}
```