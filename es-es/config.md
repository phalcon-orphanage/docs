* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='overview'></a>

# Configuraciones de Lectura

[Phalcon\Config](api/Phalcon_Config) is a component used to convert configuration files of various formats (using adapters) into PHP objects for use in an application.

Los valores pueden obtenerse de `Phalcon\Config` como se muestra a continuación:

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

echo $config->get('test')->get('parent')->get('property');  // muestra 1
echo $config->test->parent->property;                       // muestra 1
echo $config->path('test.parent.property');                 // muestra 1
```

<a name='factory'></a>

## Factory

Carga la clase adaptador Config usando la opción `adapter`, si no se provee una extensión, se agregará al `filePath`

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
The first example shows how to convert native arrays into [Phalcon\Config](api/Phalcon_Config) objects. Esta opción ofrece el mejor rendimiento ya que no se leen archivos durante esta solicitud.

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

Si quiere organizar mejor su proyecto puede guardar el arreglo en otro archivo y luego leerlo.

```php
<?php

use Phalcon\Config;

require 'config/config.php';

$config = new Config($settings);
```

<a name='file-adapter'></a>

## Adaptadores de Archivo

Los adaptadores disponibles son:

| Clase                                                             | Descripción                                                                                                                 |
| ----------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Config\Adapter\Ini](api/Phalcon_Config_Adapter_Ini)   | Utiliza archivos INI para almacenar la configuración. Internamente el adaptador utiliza la función `parse_ini_file` de PHP. |
| [Phalcon\Config\Adapter\Json](api/Phalcon_Config_Adapter_Json) | Utiliza archivos JSON para almacenar la configuración.                                                                      |
| [Phalcon\Config\Adapter\Php](api/Phalcon_Config_Adapter_Php)   | Utiliza arrays multidimensionales de PHP para almacenar la configuración. Este adaptador ofrece el mejor desempeño.         |
| [Phalcon\Config\Adapter\Yaml](api/Phalcon_Config_Adapter_Yaml) | Utiliza archivos YAML para almacenar la configuración.                                                                      |

<a name='ini-files'></a>

## Leer Archivos INI

Los archivos ini son una forma común para almacenar la configuración. [Phalcon\Config](api/Phalcon_Config) uses the optimized PHP function `parse_ini_file` to read these files. Las secciones de los archivos se analizan en sub-conjuntos para facilitar el acceso.

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

Puede leer el archivo de la siguiente forma:

```php
<?php

use Phalcon\Config\Adapter\Ini as ConfigIni;

$config = new ConfigIni('path/config.ini');

echo $config->phalcon->controllersDir, "\n";
echo $config->database->username, "\n";
echo $config->models->metadata->adapter, "\n";
```

<a name='merging'></a>

## Fusión de Configuraciones

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

El código anterior devuelve lo siguiente:

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

Hay más adaptadores disponibles para estos componentes en la [Incubadora de Phalcon](https://github.com/phalcon/incubator)

<a name='nested-configuration'></a>

## Configuraciones Anidadas

Usted puede acceder fácilmente a los valores de configuración anidados, utilizando el método `Phalcon\Config::path`. Este método permite obtener valores sin preocuparse, por el hecho, de que algunas partes de la ruta estén ausentes. Veamos un ejemplo:

```php
<?php

use Phalcon\Config;

$config = new Config(
   [
        'phalcon' => [
            'baseuri' => '/phalcon/'
        ],
        'models' => [
            'metadata' => 'memory'
        ],
        'database' => [
            'adapter'  => 'mysql',
            'host'     => 'localhost',
            'username' => 'user',
            'password' => 'passwd',
            'name'     => 'demo'
        ],
        'test' => [
            'parent' => [
                'property' => 1,
                'property2' => 'yeah'
            ],
        ],
   ]
);

// Usando el punto cono delimitador
$config->path('test.parent.property2');    // yeah
$config->path('database.host', null, '.'); // localhost

$config->path('test.parent'); // Phalcon\Config

// Usando una diagonal como delimitador. Un valor por default puede ser especificado y
// será devuelto si la opción de configuración no existe.
$config->path('test/parent/property3', 'no', '/'); // no

Config::setPathDelimiter('/');
$config->path('test/parent/property2'); // yeah
```

En el ejemplo siguiente se muestra cómo crear una fachada útil para acceder a los valores de configuración anidados:

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

## Inyección de Dependencias de Configuración

You can inject your configuration to the controller allowing us to use [Phalcon\Config](api/Phalcon_Config) inside [Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller). Para poder hacerlo, tienes que añadirlo como un servicio en el contenedor del Inyector de Dependencias. Añade el siguiente código dentro de tu archivo bootstrap o de inicialización:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Config;

// Crear un DI (Inyector de Dependencias)
$di = new FactoryDefault();

$di->set(
    'config',
    function () {
        $configData = require 'config/config.php';

        return new Config($configData);
    }
);
```

Ahora, en el controlador, puede acceder a su configuración usando la función de inyección de dependencia mediante el nombre `config` como se muestra en el siguiente código:

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