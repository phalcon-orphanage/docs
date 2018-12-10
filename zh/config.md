<div class='article-menu'>
  <ul>
    <li>
      <a href="#总览">读取配置</a> <ul>
        <li>
          <a href="#native-arrays">本机数组</a>
        </li>
        <li>
          <a href="#file-adapter">文件适配器</a>
        </li>
        <li>
          <a href="#ini-files">读取 INI 文件</a>
        </li>
        <li>
          <a href="#merging">合并的配置</a>
        </li>
        <li>
          <a href="#nested-configuration">嵌套的配置</a>
        </li>
        <li>
          <a href="#injecting-into-di">注射配置依赖项</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# 读取配置

`Phalcon\Config` 到应用程序中使用的 PHP 对象是组件，用于转换配置文件的不同格式 （使用适配器）。

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

<a name='native-arrays'></a>

## Native Arrays

第一个示例演示如何将本机数组转换成 `Phalcon\Config` 对象。此选项提供了最佳性能，因为在此请求时读取没有文件。

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

如果你想要更好地组织你的项目你可以在另一个文件中保存该数组，然后阅读它。

```php
<?php

use Phalcon\Config;

require 'config/config.php';

$config = new Config($settings);
```

<a name='file-adapter'></a>

## 文件适配器

可用的适配器是：

| 类                                | 描述                                               |
| -------------------------------- | ------------------------------------------------ |
| `Phalcon\Config\Adapter\Ini`  | 使用 INI 文件来存储设置。在内部适配器使用 PHP 函数 `parse_ini_file`。 |
| `Phalcon\Config\Adapter\Json` | 使用 JSON 文件来存储设置。                                 |
| `Phalcon\Config\Adapter\Php`  | 使用 PHP 多维数组来存储设置。此适配器提供了最佳的性能。                   |
| `Phalcon\Config\Adapter\Yaml` | 使用 YAML 文件来存储设置。                                 |

<a name='ini-files'></a>

## 读取 INI 文件

Ini 文件是常见的方式来存储设置。 `Phalcon\Config` 使用优化的 PHP 函数 `parse_ini_file` 来读取这些文件。 文件节被解析成子设置，以便轻松访问。

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

您可以读取文件，如下所示：

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

`Phalcon\Config` 可以递归地合并到另一个配置对象的属性。添加了新属性，并更新现有属性。

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

上面的代码产生以下内容：

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

有更多的适配器可供此 [Phalcon incubaror](https://github.com/phalcon/incubator) 中的组件

<a name='nested-configuration'></a>

## 嵌套的配置

也要获取嵌套的配置可以使用 `Phalcon\Config::path` 方法。 This method allows to obtain nested configurations, without caring about the fact that some parts of the path are absent. 让我们看看一个例子：

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

您可以通过添加作为一种服务注入您的控制器的配置。为了能够做到这一点，添加下列代码里面你依赖项注入器脚本。

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

现在在您的控制器可以访问您的配置通过使用依赖注入功能使用名称 `config` 像下面的代码：

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