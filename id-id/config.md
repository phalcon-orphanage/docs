---
layout: article
language: 'id-id'
version: '4.0'
---
**This article reflects v3.4 and has not yet been revised**

<a name='overview'></a>

# Membaca konfigurasi

[Phalcon\Config](api/Phalcon_Config) is a component used to convert configuration files of various formats (using adapters) into PHP objects for use in an application.

Values can be obtained from `Phalcon\Config` as follows:

```php
<?php

use Phalcon\Config;

$config = new Config(
    [
        'test' => [
            'parent' => [
                'property'  => 1,
                'property2' => 'yeah',
            ],
        ],  
    ]
);

echo $config->get('test')->get('parent')->get('property');  // displays 1
echo $config->test->parent->property;                       // displays 1
echo $config->path('test.parent.property');                 // displays 1
```

<a name='factory'></a>

## Pabrik

Loads Config Adapter class using `adapter` option, if no extension is provided it will be added to `filePath`

```php
<?php

use Phalcon\Config\Factory;

$options = [
    'filePath' => 'path/config',
    'adapter'  => 'php',
 ];

 $config = Factory::load($options);
 ```

<a name='native-arrays'></a>
## Native Arrays
The first example shows how to convert native arrays into [Phalcon\Config](api/Phalcon_Config) objects. This option offers the best performance since no files are read during this request.

```php
<?php

use Phalcon\Config;

$settings = [
    'database' => [
        'adapter'  => 'Mysql',
        'host'     => 'localhost',
        'username' => 'scott',
        'password' => 'cheetah',
        'dbname'   => 'test_db'
    ],
     'app' => [
        'controllersDir' => '../app/controllers/',
        'modelsDir'      => '../app/models/',
        'viewsDir'       => '../app/views/'
    ],
    'mysetting' => 'the-value'
];

$config = new Config($settings);

echo $config->app->controllersDir, "\n";
echo $config->database->username, "\n";
echo $config->mysetting, "\n";
```

If you want to better organize your project you can save the array in another file and then read it.

```php
<?php

use Phalcon\Config;

require 'config/config.php';

$config = new Config($settings);
```

<a name='file-adapter'></a>

## File Adapters

The adapters available are:

| Kelas                                                             | Deskripsi                                                                                        |
| ----------------------------------------------------------------- | ------------------------------------------------------------------------------------------------ |
| [Phalcon\Config\Adapter\Ini](api/Phalcon_Config_Adapter_Ini)   | Uses INI files to store settings. Internally the adapter uses the PHP function `parse_ini_file`. |
| [Phalcon\Config\Adapter\Json](api/Phalcon_Config_Adapter_Json) | Menggunakan file JSON untuk menyimpan setting.                                                   |
| [Phalcon\Config\Adapter\Php](api/Phalcon_Config_Adapter_Php)   | Uses PHP multidimensional arrays to store settings. This adapter offers the best performance.    |
| [Phalcon\Config\Adapter\Yaml](api/Phalcon_Config_Adapter_Yaml) | Menggunakan file YAML untuk menyimpan setting.                                                   |

<a name='ini-files'></a>

## Membaca file INI

Ini files are a common way to store settings. [Phalcon\Config](api/Phalcon_Config) uses the optimized PHP function `parse_ini_file` to read these files. Files sections are parsed into sub-settings for easy access.

```ini
[database]
adapter  = Mysql
host     = localhost
username = scott
password = cheetah
dbname   = test_db

[phalcon]
controllersDir = '../app/controllers/'
modelsDir      = '../app/models/'
viewsDir       = '../app/views/'

[models]
metadata.adapter  = 'Memory'
```

You can read the file as follows:

```php
<?php

use Phalcon\Config\Adapter\Ini as ConfigIni;

$config = new ConfigIni('path/config.ini');

echo $config->phalcon->controllersDir, "\n";
echo $config->database->username, "\n";
echo $config->models->metadata->adapter, "\n";
```

<a name='merging'></a>

## Menggabungkan Konfigurasi

[Phalcon\Config](api/Phalcon_Config) can recursively merge the properties of one configuration object into another. New properties are added and existing properties are updated.

```php
<?php

use Phalcon\Config;

$config = new Config(
    [
        'database' => [
            'host'   => 'localhost',
            'dbname' => 'test_db',
        ],
        'debug' => 1,
    ]
);

$config2 = new Config(
    [
        'database' => [
            'dbname'   => 'production_db',
            'username' => 'scott',
            'password' => 'secret',
        ],
        'logging' => 1,
    ]
);

$config->merge($config2);

print_r($config);
```

The above code produces the following:

```bash
Phalcon\Config Object
(
    [database] => Phalcon\Config Object
        (
            [host] => localhost
            [dbname]   => production_db
            [username] => scott
            [password] => secret
        )
    [debug] => 1
    [logging] => 1
)
```

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator)

<a name='nested-configuration'></a>

## Konfigurasi bersarang

You may easily access nested configuration values using the `Phalcon\Config::path` method. This method allows to obtain values, without caring about the fact that some parts of the path are absent. Let's look at an example:

```php
<?php

gunakan Phalcon\konfigurasi;

$konfigurasi = konfigurasi baru(
   [
        'phalcon' => [
            'baseuri' => '/phalcon/'
        ],
        'model' => [
            'metadata' => 'memori'
        ],
        'database' => [
            'adapter'  => 'mysql',
            'host'     => 'localhost',
            'nama pengguna' => 'pengguna',
            'sandi' => 'sandi',
            'nama'     => 'demo'
        ],
        'uji' => [
            'parent' => [
                'properti' => 1,
                'properti2' => 'ya'
            ],
        ],
   ]
);

// Menggunakan titik sebagai pembatas
$konfirgurasi->path('uji induk.properti');    // ya
$konfigurasi->path('database.host', null, '.'); //host lokal

$konfigurasi->path('tes induk'); // Phalcon\konfigurasi

// Menggunakan garis miring sebagai pembatas. Nilai default juga dapat ditentukan dan // akan dikembalikan jika opsi konfigurasi tidak ada.
$konfigurasi->path('uji/induk/properti3', 'no', '/'); // tidak

Konfigurasi::set Path Pembatas('/');
$config->path('uji/induk/properti2'); // ya
```

The following example shows how to create usefull facade to access nested configuration values:

```php
<?php

use Phalcon\Di;
use Phalcon\Config;

/**
 * @return mixed|Config
 */
function config() {
    $args = func_get_args();
    $config = Di::getDefault()->getShared(__FUNCTION__);

    if (empty($args)) {
       return $config;
    }

    return call_user_func_array([$config, 'path'], $args);
}
```

<a name='injecting-into-di'></a>

## Ketergantungan Konfigurasi Suntik

You can inject your configuration to the controller allowing us to use [Phalcon\Config](api/Phalcon_Config) inside [Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller). To be able to do that, you have to add it as a service in the Dependency Injector container. Add following code inside your bootstrap file:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Config;

// Create a DI
$di = new FactoryDefault();

$di->set(
    'config',
    function () {
        $configData = require 'config/config.php';

        return new Config($configData);
    }
);
```

Now in your controller you can access your configuration by using dependency injection feature using name `config` like following code:

```php
<?php

use Phalcon\Mvc\Controller;

class MyController extends Controller
{
    private function getDatabaseName()
    {
        return $this->config->database->dbname;
    }
}
```