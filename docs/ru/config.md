<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Чтение конфигураций</a> <ul>
        <li>
          <a href="#native-arrays">Нативные массивы</a>
        </li>
        <li>
          <a href="#file-adapter">Адаптеры файлов</a>
        </li>
        <li>
          <a href="#ini-files">Чтение INI-файлов</a>
        </li>
        <li>
          <a href="#merging">Объединение конфигураций</a>
        </li>
        <li>
          <a href="#nested-configuration">Вложенная конфигурация</a>
        </li>
        <li>
          <a href="#injecting-into-di">Внедрение конфигурации</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Чтение конфигураций

`Phalcon\Config` — это компонент, используемый для преобразования файлов конфигурации различных форматов (с помощью адаптеров) в PHP объекты для использования в приложении.

<a name='native-arrays'></a>

## Нативные массивы

Первый пример показывает, как конвертировать нативный массивы в объекты `Phalcon\Config`. Адаптер для нативных массивов более производителен, так как файлы не разбираются при обращении.

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

Из соображений более гибкой и универсальной организации структуры проекта, вы можете сохранить конфигурационный массив в отдельный файл и затем считать его.

```php
<?php

use Phalcon\Config;

require 'config/config.php';

$config = new Config($settings);
```

<a name='file-adapter'></a>

## Адаптеры файлов

Доступные адаптеры:

| Класс                            | Описание                                                                                            |
| -------------------------------- | --------------------------------------------------------------------------------------------------- |
| `Phalcon\Config\Adapter\Ini`  | Использует INI-файлы для хранения конфигурации. Использует PHP-функцию `parse_ini_file`.            |
| `Phalcon\Config\Adapter\Json` | Использует JSON-файлы для хранения конфигурации.                                                    |
| `Phalcon\Config\Adapter\Php`  | Использует многомерные PHP-массивы для хранения конфигурации. Этот адаптер наиболее производителен. |
| `Phalcon\Config\Adapter\Yaml` | Использует YAML-файлы для хранения конфигурации.                                                    |

<a name='ini-files'></a>

## Чтение INI-файлов

Ini-файлы являются довольно распространённым способом хранения конфигурации. Для чтения таких файлов `Phalcon\Config` использует оптимизированную PHP-функцию `parse_ini_file`. Разделы файла разбиваются в подразделы для более лёгкого доступа.

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

Вы можете прочитать конфигурационный файл следующим образом:

```php
<?php

use Phalcon\Config\Adapter\Ini as ConfigIni;

$config = new ConfigIni('path/config.ini');

echo $config->phalcon->controllersDir, "\n";
echo $config->database->username, "\n";
echo $config->models->metadata->adapter, "\n";
```

<a name='merging'></a>

## Объединение конфигураций

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

Приведенный выше код выводит следующее:

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

## Вложенная конфигурация

Also to get nested configuration you can use the `Phalcon\Config::path` method. This method allows to obtain nested configurations, without caring about the fact that some parts of the path are absent. Let's look at an example:

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

// Использование точки в качестве разделителя (по умолчанию)
$config->path('test.parent.property2');    // yeah
$config->path('database.host', null, '.'); // localhost

$config->path('test.parent'); // Phalcon\Config

// Использование слеша в качестве разделителя
$config->path('test/parent/property3', 'no', '/'); // no

Config::setPathDelimiter('/');
$config->path('test/parent/property2'); // yeah
```

<a name='injecting-into-di'></a>

## Внедрение конфигурации

You can inject your configuration to the controllers by adding it as a service. To be able to do that, add following code inside your dependency injector script.

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