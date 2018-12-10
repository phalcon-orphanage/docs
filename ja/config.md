<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">設定の読み込み</a> <ul>
        <li>
          <a href="#native-arrays">PHPの配列</a>
        </li>
        <li>
          <a href="#file-adapter">ファイルアダプター</a>
        </li>
        <li>
          <a href="#ini-files">INIファイルの読み込み</a>
        </li>
        <li>
          <a href="#merging">設定のマージ</a>
        </li>
        <li>
          <a href="#nested-configuration">ネストした設定</a>
        </li>
        <li>
          <a href="#injecting-into-di">依存する設定のインジェクション</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# 設定の読み込み

`Phalcon\Config`は、アプリケーションで使用するために、（アダプタを使用する）さまざまな形式の設定ファイルをPHPオブジェクトに変換するために使用されるコンポーネントです。

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

<a name='native-arrays'></a>

## PHPの配列

最初の例は、PHPの配列を`Phalcon\Config`オブジェクトに変換する方法を示しています。 このオプションではリクエスト中にファイルが読み込まれないため、最高のパフォーマンスが得られます。

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

| クラス                              | 説明                                                          |
| -------------------------------- | ----------------------------------------------------------- |
| `Phalcon\Config\Adapter\Ini`  | INIファイルを使用して設定を保存します。 アダプタは内部的にPHP関数`parse_ini_file`を使用します。 |
| `Phalcon\Config\Adapter\Json` | JSONファイルを使用して設定を保存します。                                      |
| `Phalcon\Config\Adapter\Php`  | PHPの多次元配列を使用して設定を保存します。 このアダプターは最高のパフォーマンスを提供します。           |
| `Phalcon\Config\Adapter\Yaml` | YAMLファイルを使用して設定を保存します。                                      |

<a name='ini-files'></a>

## INIファイルの読み込み

Iniファイルは、設定を保存する一般的な方法です。 `Phalcon\Config`は、最適化されたPHP関数`parse_ini_file`を使用してこれらのファイルを読み取ります。 ファイル内の各セクションは、簡単にアクセスできるようにサブの設定として解釈されます。

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

`Phalcon\Config`は、ある構成オブジェクトのプロパティを別の構成オブジェクトに再帰的にマージすることができます。 新しいプロパティが追加され、既存のプロパティが更新されます。

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

ネストされた設定を取得するには、`Phalcon\Config::path`メソッドを使用することもできます。 この方法では、パスの一部が存在しないという事実を気にすることなく、ネストされた構成を得ることができます。 ひとつ、例を見てみましょう:

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

// 区切り文字としてスラッシュを使用する
$config->path('test/parent/property3', 'no', '/'); // no

Config::setPathDelimiter('/');
$config->path('test/parent/property2'); // yeah
```

<a name='injecting-into-di'></a>

## 依存する設定のインジェクション

サービスとして追加することで、コントローラに設定を注入することができます。 これを行うには、DI用のスクリプト内に次のコードを追加します。

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