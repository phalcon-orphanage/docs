* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# 設定の読み込み

[Phalcon\Config](api/Phalcon_Config) is a component used to convert configuration files of various formats (using adapters) into PHP objects for use in an application.

値は次のように`Phalcon\Config`から取得できます。

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

プロジェクトをよりよく整理したい場合は、配列を別のファイルに保存してから読み込むことができます。

```php
<?php

use Phalcon\Config;

require 'config/config.php';

$config = new Config($settings);
```

<a name='file-adapter'></a>

## ファイルアダプター

使用可能なアダプタは次のとおりです:

| Class                                                             | Description                                                 |
| ----------------------------------------------------------------- | ----------------------------------------------------------- |
| [Phalcon\Config\Adapter\Ini](api/Phalcon_Config_Adapter_Ini)   | INIファイルを使用して設定を保存します。 アダプタは内部的にPHP関数`parse_ini_file`を使用します。 |
| [Phalcon\Config\Adapter\Json](api/Phalcon_Config_Adapter_Json) | JSONファイルを使用して設定を保存します。                                      |
| [Phalcon\Config\Adapter\Php](api/Phalcon_Config_Adapter_Php)   | PHPの多次元配列を使用して設定を保存します。 このアダプターは最高のパフォーマンスを提供します。           |
| [Phalcon\Config\Adapter\Yaml](api/Phalcon_Config_Adapter_Yaml) | YAMLファイルを使用して設定を保存します。                                      |

<a name='ini-files'></a>

## INIファイルの読み込み

Iniファイルは、設定を保存する一般的な方法です。 [Phalcon\Config](api/Phalcon_Config) uses the optimized PHP function `parse_ini_file` to read these files. ファイル内の各セクションは、簡単にアクセスできるようにサブの設定として解釈されます。

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

次のようにファイルを読むことができます:

```php
<?php

use Phalcon\Config\Adapter\Ini as ConfigIni;

$config = new ConfigIni('path/config.ini');

echo $config->phalcon->controllersDir, "\n";
echo $config->database->username, "\n";
echo $config->models->metadata->adapter, "\n";
```

<a name='merging'></a>

## 設定のマージ

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

上記のコードは次のようになります:

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

[Phalcon Incubator](https://github.com/phalcon/incubator) には、このコンポーネントを利用するための複数のアダプターが用意されています。

<a name='nested-configuration'></a>

## ネストした設定

`Phalcon\Config::path`メソッドを使用して、ネストされた設定値に簡単にアクセスできます。 この方法では、パスの一部が存在しないという事実を気にすることなく、値を得ることができます。 ひとつ、例を見てみましょう:

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

// 区切り文字としてドットを使用する
$config->path('test.parent.property2');    // yeah
$config->path('database.host', null, '.'); // localhost

$config->path('test.parent'); // Phalcon\Config

// デリミタとしてスラッシュを使用する デフォルト値も指定でき、
// 設定オプションが存在しない場合はデフォルト値が返されます。
$config->path('test/parent/property3', 'no', '/'); // no

Config::setPathDelimiter('/');
$config->path('test/parent/property2'); // yeah
```

次の例は、有効なファサードを作成してネストされた構成値にアクセスする方法を示しています。

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

## 依存する設定のインジェクション

You can inject your configuration to the controller allowing us to use [Phalcon\Config](api/Phalcon_Config) inside [Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller). これを実行できるようにするには、Dependency Injectorコンテナにサービスとして追加する必要があります。 ブートストラップファイルの中に以下のコードを追加してください:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Config;

// DIの生成
$di = new FactoryDefault();

$di->set(
    'config',
    function () {
        $configData = require 'config/config.php';

        return new Config($configData);
    }
);
```

コントローラではDIの機能を使って、以下のコードのように`config`という名前で設定にアクセスできます:

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