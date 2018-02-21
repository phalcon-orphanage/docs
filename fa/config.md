<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Reading Configurations</a> <ul>
        <li>
          <a href="#factory">Factory</a>
        </li>
        <li>
          <a href="#native-arrays">آرایه های محلی</a>
        </li>
        <li>
          <a href="#file-adapter">فایل آداپتور</a>
        </li>
        <li>
          <a href="#ini-files">خواندن فایل INI</a>
        </li>
        <li>
          <a href="#merging">ادغام تنظیمات</a>
        </li>
        <li>
          <a href="#nested-configuration">پیکربندی های تو در تو</a>
        </li>
        <li>
          <a href="#injecting-into-di">اعمال پیگربندی ها</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Reading Configurations

`Phalcon\Config` is a component used to convert configuration files of various formats (using adapters) into PHP objects for use in an application.

مقادیر پیگربندی شده را میتوان از `Phalcon\Config` به روش زیر دریافت کرد:

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

## Factory

Loads Config Adapter class using `adapter` option, if no extension is provided it will be added to `filePath`.

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

## آرایه های محلی

در این مثال نحوه تبدیل آرایه های بومی به اشیاء `Phalcon\Config` را نشان میدهد. از آنجا که در این روش هیچ فایلی خوانده نشده است به همین علت میتواند بهترین عملکرد را داشته باشد.

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
 
Text
Xpath: /pre[2]/code;
```

برای سازماندهی بهتر پروژه تان میتوانید آرایه را در فایل دیگری ذخیره کنید و سپس آن را فراخوانی کنید.

```php
<?php

use Phalcon\Config;

require 'config/config.php';

$config = new Config($settings);
```

<a name='file-adapter'></a>

## فایل آداپتور

آداپتورهای موجود عبارتند از:

| Class                            | Description                                                                                      |
| -------------------------------- | ------------------------------------------------------------------------------------------------ |
| `Phalcon\Config\Adapter\Ini`  | Uses INI files to store settings. Internally the adapter uses the PHP function `parse_ini_file`. |
| `Phalcon\Config\Adapter\Json` | Uses JSON files to store settings.                                                               |
| `Phalcon\Config\Adapter\Php`  | Uses PHP multidimensional arrays to store settings. This adapter offers the best performance.    |
| `Phalcon\Config\Adapter\Yaml` | Uses YAML files to store settings.                                                               |

<a name='ini-files'></a>

## خواندن فایل INI

یک از روش های رایج ذخیره سازی تنظیمات استفاده از فایل های با پسوند ini است. `Phalcon\Config` از تابع بهینه سازی شده `parse_ini_file` در php استفاده می کند برای خواندن فایل های ini. برای دسترسی آسان تر هر قسمت از تنظیمات، تنظیمات را به یک زیر تنظیمات از همان قسمت در می آورد.

```ini
[phalcon]
controllersDir = '../app/controllers/'
modelsDir = '../app/models/'
viewsDir = '../app/views/'

[models]
metadata.adapter = 'Memory'
```

میتوانید به روش زیر فایل ini خود را بخوانید:

```php
$config = new ConfigIni('path/config.ini');

echo $config->phalcon->controllersDir, "\n";
echo $config->database->username, "\n";
echo $config->models->metadata->adapter, "\n";
```

<a name='merging'></a>

## ادغام تنظیمات

`Phalcon\Config` می تواند تنظیمات یک شئ را با شئ دیگر ادغام کند. به صورتی که تنظیمات جدید اضافه و تنظیمات موجود بروزرسانی می شوند.

```php
<?php

use Phalcon\Config;

$config = new Config(
    [
        'database' => [
            'host' => 'localhost',
            'dbname' => 'test_db',
        ],
        'debug' => 1,
    ]
);

$config2 = new Config(
    [
        'database' => [
            'dbname' => 'production_db',
            'username' => 'scott',
            'password' => 'secret',
        ],
        'logging' => 1,
    ] 
);
$config->merge($config2);
print_r($config);
```

نتیجه کد بالا به صورت زیر است:

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

There are more adapters available for this components in the [Phalcon Incubator](https://github.com/phalcon/incubator).

<a name='nested-configuration'></a>

## پیکربندی های تو در تو

You may easily access nested configuration values using the `Phalcon\Config::path` method. This method allows to obtain values, without caring about the fact that some parts of the path are absent. به مثال زیر توجه کنید:

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

// Using slash as delimiter. A default value may also be specified and
// will be returned if the configuration option does not exist.
$config->path('test/parent/property3', 'no', '/'); // no

Config::setPathDelimiter('/');
$config->path('test/parent/property2'); // yeah
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

## اعمال پیگربندی ها

You can inject your configuration to the controller allowing us to use `Phalcon\Config` inside `Phalcon\Mvc\Controller`. To be able to do that, you have to add it as a service in the Dependency Injector container. Add following code inside your bootstrap file:

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

بعد از اجرای کد بالا شما میتواند درکنترلر ها به پیکربندی خود از طریق `config` دسترسی داشته باشید. مانند کد زیر:

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