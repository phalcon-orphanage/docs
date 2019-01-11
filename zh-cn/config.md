* * *

layout: default language: 'en' version: '4.0'

* * *

<a name='overview'></a>

# 读取配置

[Phalcon\Config](api/Phalcon_Config) is a component used to convert configuration files of various formats (using adapters) into PHP objects for use in an application.

值可以从 `Phalcon\Config` 获得，详情如下：

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

## 工厂

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

## 文件适配器

The adapters available are:

| 类                                                                 | 描述                                               |
| ----------------------------------------------------------------- | ------------------------------------------------ |
| [Phalcon\Config\Adapter\Ini](api/Phalcon_Config_Adapter_Ini)   | 使用 INI 文件来存储设置。在内部适配器使用 PHP 函数 `parse_ini_file`。 |
| [Phalcon\Config\Adapter\Json](api/Phalcon_Config_Adapter_Json) | 使用 JSON 文件来存储设置。                                 |
| [Phalcon\Config\Adapter\Php](api/Phalcon_Config_Adapter_Php)   | 使用 PHP 多维数组来存储设置。此适配器提供了最佳的性能。                   |
| [Phalcon\Config\Adapter\Yaml](api/Phalcon_Config_Adapter_Yaml) | 使用 YAML 文件来存储设置。                                 |

<a name='ini-files'></a>

## 读取 INI 文件

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

## 合并配置

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

## 嵌套的配置

您可以使用`Phalcon\Config::path`方法轻松访问嵌套的配置值。 这种方法允许获取值，而不考虑路径的某些部分不存在。 Let's look at an example:

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

// Using slash as delimiter. 也可以指定默认值
// 如果配置选项不存在, 将返回。
$config->path('test/parent/property3', 'no', '/'); // no

Config::setPathDelimiter('/');
$config->path('test/parent/property2'); // yeah
```

下面的示例展示了如何创建usefull facade来访问嵌套的配置值:

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

## Injecting Configuration Dependency

You can inject your configuration to the controller allowing us to use [Phalcon\Config](api/Phalcon_Config) inside [Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller). 要做到这一点，您必须将其作为服务添加到依赖注入器容器中。 在引导文件中添加以下代码:

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