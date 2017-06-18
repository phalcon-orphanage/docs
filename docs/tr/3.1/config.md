<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Yapılandırmaları Okuma</a> <ul>
        <li>
          <a href="#native-arrays">Doğal Diziler</a>
        </li>
        <li>
          <a href="#file-adapter">Dosya Bağdaştırıcıları</a>
        </li>
        <li>
          <a href="#ini-files">INI Dosyaları Okuma</a>
        </li>
        <li>
          <a href="#merging">Yapılandırmaları Birleştirme</a>
        </li>
        <li>
          <a href="#nested-configuration">Nested Configuration</a>
        </li>
        <li>
          <a href="#injecting-into-di">Injecting Configuration Dependency</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Reading Configurations

`Phalcon\Config`, bir uygulamada kullanmak üzere çeşitli biçimlerdeki yapılandırma dosyalarını (bağdaştırıcıları kullanarak) PHP nesnelerine dönüştürmek için kullanılan bir bileşendir.

<a name='native-arrays'></a>

## Native Arrays

Birinci örnek, doğal dizileri `Phalcon\Config` nesnelerine dönüştürmeyi gösterir. Bu seçenek, bu istek sırasında herhangi bir dosya okunmadığından en iyi performansı sunar.

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

Projenizi daha iyi organize etmek istiyorsanız, diziyi başka bir dosyaya kaydedebilir ve sonra okuyabilirsiniz.

```php
<?php

use Phalcon\Config;

require 'config/config.php';

$config = new Config($settings);
```

<a name='file-adapter'></a>

## File Adapters

Mevcut bağdaştırıcılar şunlardır:

| Sınıf                            | Description                                                                                                             |
| -------------------------------- | ----------------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Config\Adapter\Ini`  | INI dosyalarını ayarları depolamak için kullanır. Dahili olarak, adaptör PHP işlevi `parse_ini_file`'yi kullanmaktadır. |
| `Phalcon\Config\Adapter\Json` | Ayarları saklamak için JSON dosyalarını kullanır.                                                                       |
| `Phalcon\Config\Adapter\Php`  | Ayarları depolamak için PHP çok boyutlu dizileri kullanır. Bu adaptör en iyi performansı sunar.                         |
| `Phalcon\Config\Adapter\Yaml` | Ayarları saklamak için YAML dosyalarını kullanır.                                                                       |

<a name='ini-files'></a>

## Reading INI Files

Ini dosyaları ayarları depolamanın yaygın bir yoludur. `Phalcon\Config`, bu dosyaları okumak için optimize edilmiş PHP işlevi `parse_ini_file` kullanır. Dosya bölümleri, kolay erişim için alt ayarlara ayrıştırılır.

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

Dosyayı aşağıdaki gibi okuyabilirsiniz:

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

`Phalcon\Config`, bir yapılandırma nesnesinin özelliklerini tekrar tekrar birleştirir. Yeni özellikler eklendi ve mevcut özellikler güncellendi.

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

Yukarıdaki kod aşağıdakileri üretir:

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