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

<a name='factory'></a>

## Factory

کلاس پیکربندی آداپتور را با استفاده از گزینه `آداپتور` بارگزاری کنید، اگر هیچ افزونه ای ارائه نشود باید به `filePath` اضافه گردد

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

آداپتورهای بیشتر وجود دارد برای این کامپوننت در [Phalcon Incubator](https://github.com/phalcon/incubator)

<a name='nested-configuration'></a>

## پیکربندی های تو در تو

برای دسترسی به پیکربندی های تو در تو میتوانید از متد `Phalcon\Config::path` استفاده کنید. یکی از ویژگی های این متد آن است که در صورت وجود نداشتن مسیر پیکربندی میتوان مقدار پیش فرض برای آن قرار داد. به مثال زیر توجه کنید:

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

// استفاده از نقطه به عنوان جدا کننده
$config->path('test.parent.property2');    // yeah
$config->path('database.host', null, '.'); // localhost

$config->path('test.parent'); // Phalcon\Config

// استفاده از اسلش به عنوان جدا کننده
$config->path('test/parent/property3', 'no', '/'); // no

Config::setPathDelimiter('/');
$config->path('test/parent/property2'); // yeah
```

<a name='injecting-into-di'></a>

## اعمال پیگربندی ها

میتوانید پیکربندی های سفارشی خود به عنوان یک سرویس به کنترلر ها اضاف کنید. برای این کار از کد زیر میتوانید استفاده کنید.

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