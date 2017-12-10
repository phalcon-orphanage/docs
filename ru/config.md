<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Чтение конфигураций</a> <ul>
        <li>
          <a href="#factory">Фабрика</a>
        </li>
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

`Phalcon\Config` — это компонент для чтения конфигурации в разных форматах (используя адаптеры), и преобразования её в PHP-объекты для использования в приложении.

<a name='factory'></a>

## Фабрика

Загружает адаптер конфигурации используя параметр `adapter`. Если расширение файла не было предоставлено, параметр будет добавлен к `filePath`

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
The first example shows how to convert native arrays into `Phalcon\Config` objects. This option offers the best performance since no files are read during this request.

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

Если вы хотите лучшей организации для вашего проекта, можно сохранить массив в другой файл и затем прочитать его.

```php
<?php

use Phalcon\Config;

require 'config/config.php';

$config = new Config($settings);
```

<a name='file-adapter'></a>

## Файловые адаптеры

Доступные адаптеры:

| Класс                            | Описание                                                                                            |
| -------------------------------- | --------------------------------------------------------------------------------------------------- |
| `Phalcon\Config\Adapter\Ini`  | Использует INI-файлы для хранения конфигурации. Использует PHP-функцию `parse_ini_file`.            |
| `Phalcon\Config\Adapter\Json` | Использует JSON-файлы для хранения конфигурации.                                                    |
| `Phalcon\Config\Adapter\Php`  | Использует многомерные PHP-массивы для хранения конфигурации. Этот адаптер наиболее производителен. |
| `Phalcon\Config\Adapter\Yaml` | Использует YAML-файлы для хранения конфигурации.                                                    |

<a name='ini-files'></a>

## Чтение INI-файлов

Ini-файлы являются довольно распространённым способом хранения настроек. `Phalcon\Config` использует оптимизированную PHP функцию `parse_ini_file`, чтобы читать эти файлы. Разделы файла разбиваются в подпункты конфигурации для более лёгкого доступа.

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

Вы можете прочитать этот файл следующим образом:

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

`Phalcon\Config` может рекурсивно объединить свойства одного объекта конфигурации с другим. Новые свойства будут добавлены, а существующие обновлены.

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

Результатом выполнения кода выше будет следующее:

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

Существует еще несколько типов адаптеров конфигурации, их можно получить в “Инкубаторе” - [Phalcon Incubator](https://github.com/phalcon/incubator)

<a name='nested-configuration'></a>

## Вложенная конфигурация

Также, чтобы получить вложенную конфигурацию, можно воспользоваться методом `Phalcon\Config::path`. Этот метод позволяет получить вложенную конфигурацию, не беспокоясь о том, что некоторые части пути отсутствуют. Давайте рассмотрим пример:

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

## Внедрение зависимости конфигурации

You can inject your configuration to the controllers by adding it as a service. To be able to do that, add following code inside your dependency injector script.

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Config;

// Создаем DI
$di = new FactoryDefault();

$di->set(
    'config',
    function () {
        $configData = require 'config/config.php';

        return new Config($configData);
    }
);
```

Теперь в контроллере вы можете получить доступ к конфигурации, используя возможность внедрения зависимости, указав имя `config`, как показано ниже:

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