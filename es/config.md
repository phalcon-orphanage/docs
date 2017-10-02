<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Configuraciones de Lectura</a> <ul>
        <li>
          <a href="#native-arrays">Arreglos Nativos</a>
        </li>
        <li>
          <a href="#file-adapter">Adaptadores de Archivo</a>
        </li>
        <li>
          <a href="#ini-files">Leer Archivos INI</a>
        </li>
        <li>
          <a href="#merging">Fusión de Configuraciones</a>
        </li>
        <li>
          <a href="#nested-configuration">Configuraciones Anidadas</a>
        </li>
        <li>
          <a href="#injecting-into-di">Inyección de Dependencias de Configuración</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Configuraciones de Lectura

`Phalcon\Config` es un componente utilizado para convertir los archivos de configuración de varios formatos (usando adaptadores) a objetos PHP para usarlos en una aplicación.

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

echo $config->get('test')->get('parent')->get('property');  // muestra 1
echo $config->test->parent->property;                       // muestra 1
echo $config->path('test.parent.property');                 // muestra 1
```

<a name='native-arrays'></a>

## Native Arrays

El primer ejemplo muestra cómo convertir los arreglos nativos en objetos `Phalcon\Config`. Esta opción ofrece el mejor desempeño ya que no hay archivos que deban leerse durante esta solicitud.

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

Si quiere organizar mejor su proyecto puede guardar el arreglo en otro archivo y luego leerlo.

```php
<?php

use Phalcon\Config;

require 'config/config.php';

$config = new Config($settings);
```

<a name='file-adapter'></a>

## File Adapters

Los adaptadores disponibles son:

| Clase                            | Descripción                                                                                                              |
| -------------------------------- | ------------------------------------------------------------------------------------------------------------------------ |
| `Phalcon\Config\Adapter\Ini`  | Utiliza archivos INI para almacenar la configuración. Internamente el adaptador utiliza la función PHP `parse_ini_file`. |
| `Phalcon\Config\Adapter\Json` | Utiliza archivos JSON para almacenar la configuración.                                                                   |
| `Phalcon\Config\Adapter\Php`  | Utiliza arreglos multidimensionales en PHP para almacenar la configuración. Este adaptador ofrece el mejor rendimiento.  |
| `Phalcon\Config\Adapter\Yaml` | Utiliza archivos YAML para almacenar la configuración.                                                                   |

<a name='ini-files'></a>

## Reading INI Files

Los archivos ini son una forma común para almacenar la configuración. `Phalcon\Config` utiliza la función optimizada de PHP `parse_ini_file` para leer estos archivos. Las secciones de los archivos se analizan en sub-conjuntos para facilitar el acceso.

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

## Merging Configurations

`Phalcon\Config` can recursively merge the properties of one configuration object into another. New properties are added and existing properties are updated.

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

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator)

<a name='nested-configuration'></a>

## Nested Configuration

Also to get nested configuration you can use the `Phalcon\Config::path` method. This method allows to obtain nested configurations, without caring about the fact that some parts of the path are absent. Veamos un ejemplo:

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

// Using dot as delimiter
$config->path('test.parent.property2');    // yeah
$config->path('database.host', null, '.'); // localhost

$config->path('test.parent'); // Phalcon\Config

// Using slash as delimiter
$config->path('test/parent/property3', 'no', '/'); // no

Config::setPathDelimiter('/');
$config->path('test/parent/property2'); // yeah
```

<a name='injecting-into-di'></a>

## Injecting Configuration Dependency

You can inject your configuration to the controllers by adding it as a service. To be able to do that, add following code inside your dependency injector script.

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