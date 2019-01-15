* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='working-with'></a>

# モデルの動作

モデルは、アプリケーションの情報 (データ) と、そのデータを操作するためのルールを表します。 モデルは主に、それに対応するテーブルとの対話のルールを管理するために使用されます。 ほとんどの場合、データベース内の各テーブルは、アプリケーション内の1つのモデルと対応します。 アプリケーションのビジネスロジックの大半は、モデルに集中します。

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) is the base for all models in a Phalcon application. データベースの独立性、基本的なCRUD機能、高度な検索機能、および他のサービスの中でモデルを相互に関連付ける機能を提供します。 [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) avoids the need of having to use SQL statements because it translates methods dynamically to the respective database engine operations.

<h5 class='alert alert-warning'>Models are intended to work with the database on a high layer of abstraction. If you need to work with databases at a lower level check out the <a href="api/Phalcon_Db">Phalcon\Db</a> component documentation.</h5>

<a name='creating'></a>

## モデルの作成

A model is a class that extends from [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model). Its class name should be in camel case notation:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class RobotParts extends Model
{

}
```

<h5 class='alert alert-warning'>If you're using PHP 5.4/5.5 it is recommended you declare each column that makes part of the model in order to save memory and reduce the memory allocation. </h5>

デフォルトでは、モデル `Store\Toys\RobotParts` が `robot_parts` テーブルにマッピングされます。 マッピングされたテーブル名を手動で指定する場合は、 `setSource()` メソッドが使用できます:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class RobotParts extends Model
{
    public function initialize()
    {
        $this->setSource('toys_robot_parts');
    }
}
```

モデル `RobotParts` は、 `toys_robot_parts` テーブルにマッピングされています。 `initialize()` メソッドは、カスタムビヘイビア（例えば別のテーブル）などでこのモデルを設定するのに役立ちます。

`initialize()` メソッドはリクエスト時に1度だけ呼ばれます。 このメソッドは、アプリケーション内で作成されたモデルのすべてのインスタンスに適用される、初期化処理を実行するためのものです。 作成されたすべてのインスタンスに対して初期化タスクを実行する場合は、`onConstruct()` メソッドを使用できます。

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class RobotParts extends Model
{
    public function onConstruct()
    {
        // ...
    }
}
```

<a name='properties-setters-getters'></a>

### パブリックプロバティー VS セッター/ゲッター

モデルはパブリックプロパティとして実装できます。つまり、モデルクラスをインスタンス化したコードの任意の部分から各プロパティを読み込み/更新できます。

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $price;
}
```

もう1つの実装では、gettersとsetter関数を使用して、そのモデルで公開されているプロパティを制御します。 getterとsetterを使用する利点は、パブリックプロパティを使用する場合に不可能な、モデルに対して設定された値の変換と検証チェックを実行できることです。 さらに、getterとsetterは、モデルクラスのインタフェースを変更せずに将来の変更を可能にします。 したがって、フィールド名が変更された場合に必要な変更は、関連するgetter/setterで参照されているモデルのプライベートプロパティだけで、コード内の他の場所にはありません。

```php
<?php

namespace Store\Toys;

use InvalidArgumentException;
use Phalcon\Mvc\Model;

class Robots extends Model
{
    protected $id;

    protected $name;

    protected $price;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        // 名前は短すぎないか？
        if (strlen($name) < 10) {
            throw new InvalidArgumentException(
                'The name is too short'
            );
        }

        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPrice($price)
    {
        // マイナスの価格は許可されない
        if ($price < 0) {
            throw new InvalidArgumentException(
                "Price can't be negative"
            );
        }

        $this->price = $price;
    }

    public function getPrice()
    {
        // 使う前にdouble型に変換
        return (double) $this->price;
    }
}
```

パブリックプロパティは、開発の複雑さを軽減します。 しかし、getter/setterはアプリケーションのテスト容易性、拡張性、保守性を大幅に向上させる可能性があります。 開発者はアプリケーションのニーズに応じて、作成するアプリケーションに適した戦略を決めることができます。 ORMは、プロパティを定義する両方のスキーマと互換性があります。

<h5 class='alert alert-warning'>Underscores in property names can be problematic when using getters and setters. </h5>

プロパティ名にアンダースコアを使用する場合は、マジックメソッドで使用するために、getter/setter宣言でキャメルケースを使う必要があります。 (例えば、 `$model->getProperty_name` は `$model->getPropertyName` に, `$model->findByProperty_name` は `$model->findByPropertyName` にするなど) 多くのシステムではキャメルケースが前提とされ、アンダースコアは一般的に削除されるためドキュメント全体に示されている方法でプロパティの名前を付けることをお勧めします。 カラムのマッピングを使用すると（上で説明したように）、データベースに対してプロパティを正しくマッピングすることができます。

<a name='records-to-objects'></a>

## オブジェクトへのレコード格納について理解する

モデルの各インスタンスは、表の行を表します。 オブジェクトのプロパティを読み取ることで、レコードのデータに簡単にアクセスできます。 たとえば、レコードが存在するテーブル 'robots' の場合は、次のようになります:

```sql
mysql> select * from robots;
+----+------------+------------+------+
| id | name       | type       | year |
+----+------------+------------+------+
|  1 | Robotina   | mechanical | 1972 |
|  2 | Astro Boy  | mechanical | 1952 |
|  3 | Terminator | cyborg     | 2029 |
+----+------------+------------+------+
3 rows in set (0.00 sec)
```

プライマリキーで特定のレコードを見つけ、その名前を出力することができます:

```php
<?php

use Store\Toys\Robots;

// id = 3のレコードを検索
$robot = Robots::findFirst(3);

// 'Terminator' を出力
echo $robot->name;
```

一度レコードがメモリ内に格納されれば、データを更新して、その変更を保存することができます:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(3);

$robot->name = 'RoboCop';

$robot->save();
```

As you can see, there is no need to use raw SQL statements. [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) provides high database abstraction for web applications.

<a name='finding-records'></a>

## レコードの検索

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) also offers several methods for querying records. The following examples will show you how to query one or more records from a model:

```php
<?php

use Store\Toys\Robots;

// どれくらいロボットがいるか？
$robots = Robots::find();
echo 'There are ', count($robots), "\n";

// 機械式のロボットはどれくらいいるか？
$robots = Robots::find("type = 'mechanical'");
echo 'There are ', count($robots), "\n";

// バーチャルなロボットを取得して名前順に並び替えて出力する
$robots = Robots::find(
    [
        "type = 'virtual'",
        'order' => 'name',
    ]
);
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

// バーチャルなロボットを名前順に並び替えて最初の100件を取得する
$robots = Robots::find(
    [
        "type = 'virtual'",
        'order' => 'name',
        'limit' => 100,
    ]
);
foreach ($robots as $robot) {
   echo $robot->name, "\n";
}
```

<h5 class='alert alert-warning'>If you want find record by external data (such as user input) or variable data you must use <a href="#binding-parameters">Binding Parameters</a>`.</h5>

`findFirst()` メソッドを使用して、指定した条件に一致する最初のレコードのみを取得することもできます。

```php
<?php

use Store\Toys\Robots;

// robotsテーブルの最初のレコードは？
$robot = Robots::findFirst();
echo 'The robot name is ', $robot->name, "\n";

// robotsテーブルの最初の機械式のロボットは？
$robot = Robots::findFirst("type = 'mechanical'");
echo 'The first mechanical robot name is ', $robot->name, "\n";

// バーチャルなロボットを名前順に並び替えて最初の100件を取得する
$robot = Robots::findFirst(
    [
        "type = 'virtual'",
        'order' => 'name',
    ]
);

echo 'The first virtual robot name is ', $robot->name, "\n";
```

`find()` および `findFirst()` メソッドは、検索条件を指定する連想配列を受け付けます:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(
    [
        "type = 'virtual'",
        'order' => 'name DESC',
        'limit' => 30,
    ]
);

$robots = Robots::find(
    [
        'conditions' => 'type = ?1',
        'bind'       => [
            1 => 'virtual',
        ]
    ]
);
```

使用可能なクエリのオプションは次のとおりです:

| Parameter     | Description                                                                                                                                          | 例                                                                    |
| ------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------- |
| `conditions`  | find時の検索条件。 指定された条件を満たすレコードのみを抽出するために使用されます。 By default [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) assumes the first parameter are the conditions. | `'conditions' => "name LIKE 'steve%'"`                            |
| `columns`     | モデル内の完全な列の代わりに特定の列を返します。 このオプションを使用すると、不完全なオブジェクトが返されます。                                                                                             | `'columns' => 'id, name'`                                         |
| `bind`        | bindは、プレースホルダをエスケープ値で置き換えるオプションと一緒に使用されるため、セキュリティが強化されます。                                                                                            | `'bind' => ['status' => 'A', 'type' => 'some-time']`        |
| `bindTypes`   | パラメータをバインドする時にこのパラメータを使用すると、バインドされたパラメータをさらに型キャストして、セキュリティをさらに強化することができます。                                                                           | `'bindTypes' => [Column::BIND_PARAM_STR, Column::BIND_PARAM_INT]` |
| `order`       | 結果セットをソートするために使用されます。 1つまたは複数のフィールドをカンマで区切って使用します。                                                                                                   | `'order' => 'name DESC, status'`                                  |
| `limit`       | クエリの結果を特定の範囲に制限します。                                                                                                                                  | `'limit' => 10`                                                   |
| `offset`      | クエリの結果を一定量だけオフセットします。                                                                                                                                | `'offset' => 5`                                                   |
| `group`       | 複数のレコードにわたってデータを収集し、結果を1つ以上の列でグループ化することができます。                                                                                                        | `'group' => 'name, status'`                                       |
| `for_update`  | With this option, [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) reads the latest available data, setting exclusive locks on each row it reads         | `'for_update' => true`                                            |
| `shared_lock` | With this option, [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) reads the latest available data, setting shared locks on each row it reads            | `'shared_lock' => true`                                           |
| `cache`       | 結果セットをキャッシュし、リレーショナルシステムへの継続的なアクセスを減らします。                                                                                                            | `'cache' => ['lifetime' => 3600, 'key' => 'my-find-key']`   |
| `hydration`   | 結果に返された各レコードを表すためのハイドレーション戦略を設定します。                                                                                                                  | `'hydration' => Resultset::HYDRATE_OBJECTS`                       |

必要に応じて、一連のパラメータを使用する代わりに、オブジェクト指向の方法でクエリを作成する方法もあります:

```php
<?php

use Store\Toys\Robots;

$robots = Robots::query()
    ->where('type = :type:')
    ->andWhere('year < 2000')
    ->bind(['type' => 'mechanical'])
    ->order('name')
    ->execute();
```

The static method `query()` returns a [Phalcon\Mvc\Model\Criteria](api/Phalcon_Mvc_Model_Criteria) object that is friendly with IDE autocompleters.

All the queries are internally handled as [PHQL](/4.0/en/db-phql) queries. PHQLは、高度で、オブジェクト指向な、SQLライクな言語です。 この言語は、他のモデルへのjoin、グルーピングの定義、集計の追加など、クエリを実行するための多くの機能を提供します。

最後に、 `findFirstBy<property-name>()` メソッドがあります。 このメソッドは、前述の `findFirst()` メソッドを拡張します。 メソッド自体のプロパティ名を使用し、その列で検索するデータを含むパラメータを渡すことで、テーブルからの取得を素早く実行できます。 例が整っているので前述のRomotsモデルを使用します:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $price;
}
```

ここでは3つのプロパティがあります: `$id`, `$name`, `$price` それでは、テーブル内で名前が 'Terminator' の最初のレコードを取得したいとしましょう。 このように記述することができます:

```php
<?php

use Store\Toys\Robots;

$name = 'Terminator';

$robot = Robots::findFirstByName($name);

if ($robot) {
    echo 'The first robot with the name ' . $name . ' cost ' . $robot->price . '.';
} else {
    echo 'There were no robots found in our table with the name ' . $name . '.';
}
```

メソッド呼び出しで 'Name' を使用し、 `$name` という変数を渡したことに注目してください。この変数には、テーブルで検索する名前が含まれています。 また、クエリと一致するものが見つかると、他のすべてのプロパティも同様に使用できることに注意してください。

<a name='resultsets'></a>

### モデルの結果セット

While `findFirst()` returns directly an instance of the called class (when there is data to be returned), the `find()` method returns a [Phalcon\Mvc\Model\Resultset\Simple](api/Phalcon_Mvc_Model_Resultset_Simple). これは結果セットを横断したり、特定のレコードを探したり数えたりするような、すべての機能をカプセル化するオブジェクトです。

これらのオブジェクトは、スタンダードな配列よりも強力です。 One of the greatest features of the [Phalcon\Mvc\Model\Resultset](api/Phalcon_Mvc_Model_Resultset) is that at any time there is only one record in memory. これは特に、大量のデータを扱う場合のメモリ管理に大きく役立ちます。

```php
<?php

use Store\Toys\Robots;

// 全てのロボットを取得
$robots = Robots::find();

// foreachで横断する
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

// whileで横断する
$robots->rewind();

while ($robots->valid()) {
    $robot = $robots->current();

    echo $robot->name, "\n";

    $robots->next();
}

// 結果セットをカウント
echo count($robots);

// 結果セットをカウントする他の方法
echo $robots->count();

// 内部カーソルを3番目のロボットに移動する
$robots->seek(2);

$robot = $robots->current();

// 結果セットのあるポジションのロボットにアクセス
$robot = $robots[5];

// 特定の位置にレコードがあるかどうかを確認する
if (isset($robots[3])) {
   $robot = $robots[3];
}

// 結果セットの最初のレコードを取得
$robot = $robots->getFirst();

// 最後のレコードを取得
$robot = $robots->getLast();
```

Phalconの結果セットはスクロール可能なカーソルをエミュレートします。その位置にアクセスするだけで行を取得したり、特定のポジションへの内部ポインタを探すことができます。 一部のデータベースシステムではスクロール可能なカーソルはサポートされていません。このため、要求されたポジションのレコードを取得するために、カーソルを先頭に戻してクエリを再実行する必要があります。 同様に、結果セットが複数回走査される場合、クエリは同じ回数だけ実行されなければなりません。

大きなクエリ結果をメモリに格納すると、多くのリソースを消費する可能性があります。結果セットは32行のチャンクでデータベースから取得されるため、いくつかのケースではリクエストを再実行する必要性が減ります。

結果セットをシリアライズしてキャッシュバックエンドに格納できることに注意してください。 [Phalcon\Cache](api/Phalcon_Cache) can help with that task. However, serializing data causes [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) to retrieve all the data from the database in an array, thus consuming more memory while this process takes place.

```php
<?php

// partsモデルからすべてのレコードを照会します
$parts = Parts::find();

// ファイルに結果セットを保存
file_put_contents(
    'cache.txt',
    serialize($parts)
);

// ファイルからpartsを取得
$parts = unserialize(
    file_get_contents('cache.txt')
);

// partsを走査
foreach ($parts as $part) {
    echo $part->id;
}
```

<a name='custom-resultsets'></a>

### カスタム結果セット

アプリケーションのロジックでは、データベースから取得されたデータに対して、追加の操作を必要とすることがあります。 以前は、モデルを拡張して、モデルのクラスやtraitの機能をカプセル化し、通常は変換されたデータの配列を呼び出し側に返すだけでした。

カスタム結果セットでは、これを行う必要はありません。 カスタム結果セットは、他のモデルになる機能をカプセル化し、他のモデルから再利用することができます。このためコードの [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself) が保たれます。 This way, the `find()` method will no longer return the default [Phalcon\Mvc\Model\Resultset](api/Phalcon_Mvc_Model_Resultset), but instead the custom one. Phalconでは、モデル内で `getResultsetClass()` を使用してこれを行うことができます。

最初に、結果セットのクラスを定義する必要があります:

```php
<?php

namespace Application\Mvc\Model\Resultset;

use \Phalcon\Mvc\Model\Resultset\Simple;

class Custom extends Simple
{
    public function getSomeData() {
        /** CODE */
    }
}
```

モデルでは、クラスを次のように `getResultsetClass()` に設定します。

```php
<?php

namespace Phalcon\Test\Models\Statistics;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function getSource()
    {
        return 'robots';
    }

    public function getResultsetClass()
    {
    return 'Application\Mvc\Model\Resultset\Custom';
    }
}
```

そして最後にあなたのコードでは、次のようなになります:

```php
<?php

/**
 * robotsの検索
 */
$robots = Robots::find(
    [
        'conditions' => 'date between "2017-01-01" AND "2017-12-31"',
        'order'      => 'date'
    ]
);

/**
 * データをビューに渡す
 */
$this->view->mydata = $robots->getSomeData();
```

<a name='filters'></a>

### 結果セットのフィルタリング

データをフィルタリングする最も効率的な方法は、いくつかの検索条件を設定することです。データベースは、テーブルに設定されたインデックスを使用してデータを高速に返します。 Phalconではさらに、データベースでは利用できない機能を、PHPを使うことでデータをフィルタリングすることができます:

```php
<?php

$customers = Customers::find();

$customers = $customers->filter(
    function ($customer) {
        // 有効な電子メールを持っている顧客のみを返します
        if (filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
            return $customer;
        }
    }
);
```

<a name='binding-parameters'></a>

### パラメーターのバインド

Bound parameters are also supported in [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model). この方法論を使用して、コードがSQLインジェクション攻撃を受けないようにすることをお勧めします。 文字列と整数の両方のプレースホルダがサポートされています。 パラメータのバインドは、以下のように簡単に実施できます:

```php
<?php

use Store\Toys\Robots;

// 文字列プレースホルダを使用してパラメータをバインドするrobotsテーブル用クエリ
// プレースホルダと同じキーのパラメータ
$robots = Robots::find(
    [
        'name = :name: AND type = :type:',
        'bind' => [
            'name' => 'Robotina',
            'type' => 'maid',
        ],
    ]
);

// 整数のプレースホルダによるパラメータをバインドしたrobotsテーブル用クエリ
$robots = Robots::find(
    [
        'name = ?1 AND type = ?2',
        'bind' => [
            1 => 'Robotina',
            2 => 'maid',
        ],
    ]
);

// 文字列と整数の両方のプレースホルダによるパラメータをバインドしたrobotsテーブル用クエリ
// プレースホルダと同じキーのパラメータ
$robots = Robots::find(
    [
        'name = :name: AND type = ?1',
        'bind' => [
            'name' => 'Robotina',
            1      => 'maid',
        ],
    ]
);
```

数値プレースホルダを使用する場合は、整数を `1` または `2` として定義する必要があります。 この場合、 `'1'` または `'2'` は文字列であり数字ではないため、プレースホルダを正常に置き換えることができません。

Strings are automatically escaped using [PDO](https://php.net/manual/en/pdo.prepared-statements.php). この関数は接続文字セットを考慮しているため、接続パラメータまたはデータベースの設定で、正しい文字セットを定義することをお勧めします。データセットを格納または取得するときに間違った文字セットが望ましくない影響を及ぼすためです。

さらに、パラメータ `bindTypes` を設定することができます。これにより、データ型に応じてパラメータをバインドする方法を定義できます:

```php
<?php

use Phalcon\Db\Column;
use Store\Toys\Robots;

// バインドパラメータ
$parameters = [
    'name' => 'Robotina',
    'year' => 2008,
];

// 型キャスト
$types = [
    'name' => Column::BIND_PARAM_STR,
    'year' => Column::BIND_PARAM_INT,
];

// 文字列プレースホルダを使用してパラメータをバインドするrobotsテーブル用クエリ
$robots = Robots::find(
    [
        'name = :name: AND year = :year:',
        'bind'      => $parameters,
        'bindTypes' => $types,
    ]
);
```

<h5 class='alert alert-warning'>Since the default bind-type is <code>Phalcon\Db\Column::BIND_PARAM_STR</code>, there is no need to specify the 'bindTypes' parameter if all of the columns are of that type.</h5>

バインドパラメータに配列をバインドする場合、キーには0から番号を付ける必要があることに注意してください:

```php
<?php

use Store\Toys\Robots;

$array = ['a','b','c']; // $array: [[0] => 'a', [1] => 'b', [2] => 'c']

unset($array[1]); // $array: [[0] => 'a', [2] => 'c']

// キーの番号を振り直さなければならない
$array = array_values($array); // $array: [[0] => 'a', [1] => 'c']

$robots = Robots::find(
    [
        'letter IN ({letter:array})',
        'bind' => [
            'letter' => $array
        ]
    ]
);
```

<h5 class='alert alert-warning'>Bound parameters are available for all query methods such as <code>find()</code> and <code>findFirst()</code> but also the calculation methods like <code>count()</code>, <code>sum()</code>, <code>average()</code> etc. </h5>

もし "finders" ( `find()`、 `findFirst()` 、etc) を使用している場合、バインドパラメータは自動的に使用されます:

```php
<?php

use Store\Toys\Robots;

// バインドパラメータを使用する明示的なクエリ
$robots = Robots::find(
    [
        'name = ?0',
        'bind' => [
            'Ultron',
        ],
    ]
);

// バインドパラメータを使用した暗黙的なクエリ
$robots = Robots::findByName('Ultron');
```

<a name='preparing-records'></a>

## 取得したレコードの初期化/準備

データベースからレコードを取得した後に、アプリケーションの残りの部分が使用する前にデータを初期化する必要があるかもしれません。 モデル内で `afterFetch()` メソッドを実装することができます。このイベントは、インスタンスを作成してデータを割り当てる直後に実行されます。

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $status;

    public function beforeSave()
    {
        // 配列を文字列に変換
        $this->status = join(',', $this->status);
    }

    public function afterFetch()
    {
        // 文字列を配列に変換
        $this->status = explode(',', $this->status);
    }

    public function afterSave()
    {
        // 文字列を配列に変換
        $this->status = explode(',', $this->status);
    }
}
```

publicプロパティの代わり、もしくは一緒にgetters/settersを使用する場合、一度アクセスされたフィールドを初期化することができます:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $status;

    public function getStatus()
    {
        return explode(',', $this->status);
    }
}
```

<a name='calculations'></a>

## 集計の生成

計算（集計）は、データベースシステムで一般に使用される、`COUNT` 、 `SUM` 、 `MAX` 、 `MIN` 、 `AVG` などの関数のヘルパーです。 [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) allows to use these functions directly from the exposed methods.

countの例:

```php
<?php

// 従業員は何名？
$rowcount = Employees::count();

// 従業員に割り当てられる担当はいくつあるか？
$rowcount = Employees::count(
    [
        'distinct' => 'area',
    ]
);

// 検査担当の従業員は何名いるか？
$rowcount = Employees::count(
    'area = 'Testing''
);

// 担当別にグルーピングした結果で従業員をカウントする
$group = Employees::count(
    [
        'group' => 'area',
    ]
);
foreach ($group as $row) {
   echo 'There are ', $row->rowcount, ' in ', $row->area;
}

// 従業員を担当別にグルーピングしてカウントし、件数で結果を並び替える
$group = Employees::count(
    [
        'group' => 'area',
        'order' => 'rowcount',
    ]
);

// バインドされたパラメータを使用してSQLインジェクションを避ける
$group = Employees::count(
    [
        'type > ?0',
        'bind' => [
            $type
        ],
    ]
);
```

sumの例:

```php
<?php

// 全従業員の給与はいくらか？
$total = Employees::sum(
    [
        'column' => 'salary',
    ]
);

// 全ての営業担当の給与はいくらか？
$total = Employees::sum(
    [
        'column'     => 'salary',
        'conditions' => "area = 'Sales'",
    ]
);

// 各担当ごとの給与のグルーピングを生成する
$group = Employees::sum(
    [
        'column' => 'salary',
        'group'  => 'area',
    ]
);
foreach ($group as $row) {
   echo 'The sum of salaries of the ', $row->area, ' is ', $row->sumatory;
}

// 各担当ごとの給与のグルーピングを生成して
// 給与が高いものから低いものへ並べる
$group = Employees::sum(
    [
        'column' => 'salary',
        'group'  => 'area',
        'order'  => 'sumatory DESC',
    ]
);

// バインドされたパラメータを使用してSQLインジェクションを避ける
$group = Employees::sum(
    [
        'conditions' => 'area > ?0',
        'bind'       => [
            $area
        ],
    ]
);
```

averageの例:

```php
<?php

// 全従業員の平均給与はいくらか？
$average = Employees::average(
    [
        'column' => 'salary',
    ]
);

// 営業担当者の平均給与はいくらか？
$average = Employees::average(
    [
        'column'     => 'salary',
        'conditions' => "area = 'Sales'",
    ]
);

// バインドされたパラメータを使用してSQLインジェクションを避ける
$average = Employees::average(
    [
        'column'     => 'age',
        'conditions' => 'area > ?0',
        'bind'       => [
            $area
        ],
    ]
);
```

max/min の例:

```php
<?php

// 全従業員で最年長は？
$age = Employees::maximum(
    [
        'column' => 'age',
    ]
);

// 全ての営業担当で最年長は？
$age = Employees::maximum(
    [
        'column'     => 'age',
        'conditions' => "area = 'Sales'",
    ]
);

// 全従業員中の最低給与は？
$salary = Employees::minimum(
    [
        'column' => 'salary',
    ]
);
```

<a name='create-update-records'></a>

## レコードの登録と更新

`Phalcon\Mvc\Model::save()` メソッドを使用すると、モデルに関連付けられたテーブルにレコードがすでに存在するかどうかによってレコードを作成/更新できます。 The save method is called internally by the create and update methods of [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model). これが期待どおりに機能するためには、レコードを更新または作成するかどうかを判断するために、主キーをエンティティに適切に定義する必要があります。

またこのメソッドはモデルで定義されている関連付けられたバリデータ、仮想外部キー、およびイベントを実行します。

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->type = 'mechanical';
$robot->name = 'Astro Boy';
$robot->year = 1952;

if ($robot->save() === false) {
    echo "Umh, We can't store robots right now: \n";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message, "\n";
    }
} else {
    echo 'Great, a new robot was saved successfully!';
}
```

すべての列を手動で割り当てるのを避けるために、配列を `save` に渡すことができます。 [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) will check if there are setters implemented for the columns passed in the array giving priority to them instead of assign directly the values of the attributes:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->save(
    [
        'type' => 'mechanical',
        'name' => 'Astro Boy',
        'year' => 1952,
    ]
);
```

直接または属性の配列を介して割り当てられた値は、関連する属性データ型に従ってエスケープ/サニタイズされます。 SQLインジェクションを心配することなく、安全でない配列を渡すことができます:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->save($_POST);
```

<h5 class='alert alert-warning'>Without precautions mass assignment could allow attackers to set any database column's value. Only use this feature if you want to permit a user to insert/update every column in the model, even if those fields are not in the submitted form. </h5>

`save` に追加のパラメータを設定して、脆弱性対策を行う際に考慮する必要があるフィールドの、ホワイトリストを設定することができます。

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->save(
    $_POST,
    [
        'name',
        'type',
    ]
);
```

<a name='create-update-with-confidence'></a>

### 確実に作成/更新する

アプリケーションの負荷が高い時には、レコードが作成されることを期待しているにも関わらず、更新されてしまう場合があります。 これは、 `Phalcon\Mvc\Model::save()` を使用してデータベースのレコードに永続化する際に発生します。 レコードの作成や更新を確実に行いたい場合は、`save()` の代わりに `create()` や `update()` の呼び出しに変更できます。

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->type = 'mechanical';
$robot->name = 'Astro Boy';
$robot->year = 1952;

// このレコードは作成されなければいけない
if ($robot->create() === false) {
    echo "Umh, We can't store robots right now: \n";

    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo $message, "\n";
    }
} else {
    echo 'Great, a new robot was created successfully!';
}
```

`create` と `update` メソッドは、値の配列をパラメータとして受け入れます。

<a name='delete-records'></a>

## レコードの削除

`Phalcon\Mvc\Model::delete()` メソッドは、レコードを削除することを可能にします。 次のように使用できます:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(11);

if ($robot !== false) {
    if ($robot->delete() === false) {
        echo "Sorry, we can't delete the robot right now: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo 'The robot was deleted successfully!';
    }
}
```

`foreach` を使用して結果セットを横断することで、多くのレコードを削除することもできます。

```php
<?php

use Store\Toys\Robots;

$robots = Robots::find(
    "type = 'mechanical'"
);

foreach ($robots as $robot) {
    if ($robot->delete() === false) {
        echo "Sorry, we can't delete the robot right now: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo 'The robot was deleted successfully!';
    }
}
```

削除が処理される際に、カスタムビジネスルールの実行を定義するには、次のイベントを使用します。

| Operation | Name         | Can stop operation? | Explanation                              |
| --------- | ------------ |:-------------------:| ---------------------------------------- |
| 削除        | afterDelete  |         No          | Runs after the delete operation was made |
| 削除        | beforeDelete |         Yes         | Runs before the delete operation is made |

上記のイベントを使用すると、ビジネスルールをモデルで定義することもできます:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function beforeDelete()
    {
        if ($this->status === 'A') {
            echo "The robot is active, it can't be deleted";

            return false;
        }

        return true;
    }
}
```

<a name='hydration-modes'></a>

## ハイドレーションモード

前述のように、結果セットは完全なオブジェクトの集合です。つまり、返される結果はすべて、データベース内の行を表すオブジェクトです。 これらのオブジェクトは変更して、再び永続的に保存することができます:

```php
<?php

use Store\Toys\Robots;

$robots = Robots::find();

// 完全なオブジェクトの結果セットを操作する
foreach ($robots as $robot) {
    $robot->year = 2000;

    $robot->save();
}
```

時として、ユーザーに対して読み取り専用モードでレコードを取得させることがあります。このような場合、レコードの表示方法を変更して処理を簡単にすると便利です。 結果セットとして返されるオブジェクトを指定する方法は、「ハイドレーションモード」と呼ばれます:

```php
<?php

use Phalcon\Mvc\Model\Resultset;
use Store\Toys\Robots;

$robots = Robots::find();

// すべてのrobotを配列として返す
$robots->setHydrateMode(
    Resultset::HYDRATE_ARRAYS
);

foreach ($robots as $robot) {
    echo $robot['year'], PHP_EOL;
}

// すべてのrobotを標準クラスとして返す
$robots->setHydrateMode(
    Resultset::HYDRATE_OBJECTS
);

foreach ($robots as $robot) {
    echo $robot->year, PHP_EOL;
}

// すべてのrobotをRobotsインスタンスとして返す
$robots->setHydrateMode(
    Resultset::HYDRATE_RECORDS
);

foreach ($robots as $robot) {
    echo $robot->year, PHP_EOL;
}
```

ハイドレーションモードは、 `find` のパラメーターとして渡すこともできます:

```php
<?php

use Phalcon\Mvc\Model\Resultset;
use Store\Toys\Robots;

$robots = Robots::find(
    [
        'hydration' => Resultset::HYDRATE_ARRAYS,
    ]
);

foreach ($robots as $robot) {
    echo $robot['year'], PHP_EOL;
}
```

<a name='table-prefixes'></a>

## テーブル名のプレフィックス

すべてのテーブルに特定のプレフィックスがあり、ソースを設定しない場合は、 すべてのモデルに対して `Phalcon\Mvc\Model\Manager` の `setModelPrefix()` メソッドが使用できます:

```php
<?php

use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Model;

class Robots extends Model
{

}

$manager = new Manager();
$manager->setModelPrefix('wp_');
$robots = new Robots(null, null, $manager);
echo $robots->getSource(); // wp_robotsが返される
```

<a name='identity-columns'></a>

## 自動生成された id カラム

一部のモデルにはID列があります。 これらの列は通常、マッピングされた表の主キーです。 [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) can recognize the identity column omitting it in the generated SQL `INSERT`, so the database system can generate an auto-generated value for it. レコードを作成した後は常に、IDフィールドはデータベースシステムで生成された値が設定されます:

```php
<?php

$robot->save();

echo 'The generated id is: ', $robot->id;
```

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) is able to recognize the identity column. データベースシステムによっては、PostgreSQLのようなシリアルカラムや、MySQLの場合はauto_incrementカラムがあります。

PostgreSQLはシーケンスを使って自動数値を生成しますが、Phalconはシーケンス `table_field_seq` から生成された値を取得しようとします。例えば: `robots_id_seq`。そのシーケンスの名前が異なる場合は、 `getSequenceName()` メソッドを実装する必要があります。

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function getSequenceName()
    {
        return 'robots_sequence_name';
    }
}
```

<a name='skipping-columns'></a>

## カラムをスキップ

To tell [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) that always omits some fields in the creation and/or update of records in order to delegate the database system the assignation of the values by a trigger or a default:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        // INSERT / UPDATE操作の両方でフィールド/列をスキップします。
        $this->skipAttributes(
            [
                'year',
                'price',
            ]
        );

        // INSERT時のみスキップする
        $this->skipAttributesOnCreate(
            [
                'created_at',
            ]
        );

        // UPDATE時のみスキップする
        $this->skipAttributesOnUpdate(
            [
                'modified_in',
            ]
        );
    }
}
```

これにより各 `INSERT` / `UPDATE` 操作に対して、アプリケーション全体でこれらのフィールドが無視されます。 `INSERT` / `UPDATE` で異なる属性を無視する場合は、置換のために2番目のパラメータ（ブール値） - ` true </ 0>を指定できます。 デフォルト値を強制するには、次のようにします:</p>

<pre><code class="php"><?php

use Store\Toys\Robots;

use Phalcon\Db\RawValue;

$robot = new Robots();

$robot->name       = 'Bender';
$robot->year       = 1999;
$robot->created_at = new RawValue('default');

$robot->create();
`</pre> 

コールバックを使用して、自動デフォルト値の条件付き割り当てを作成することもできます:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Db\RawValue;

class Robots extends Model
{
    public function beforeCreate()
    {
        if ($this->price > 10000) {
            $this->type = new RawValue('default');
        }
    }
}
```

<h5 class='alert alert-warning'>Never use a <a href="api/Phalcon_Db_RawValue">Phalcon\Db\RawValue</a> to assign external data (such as user input) or variable data. The value of these fields is ignored when binding parameters to the query. So it could be used to attack the application injecting SQL. </h5>

<a name='dynamic-updates'></a>

## ダイナミックアップデート

SQLの `UPDATE` ステートメントはデフォルトで、モデルに定義されたすべての列に対して作成されます（全フィールドの更新SQL）。 特定のモデルを変更して動的に更新を行うことができます。この場合、変更されたフィールドだけが最終的なSQL文の作成に使用されます。

場合によっては、アプリケーションとデータベースサーバー間のトラフィックを減らすことでパフォーマンスを向上させることができます。これは、テーブルにBLOB /テキストフィールドがある場合に特に役立ちます:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->useDynamicUpdate(true);
    }
}
```

<a name='column-mapping'></a>

## 独立したカラムマッピング

ORMは、独立したカラムマッピングをサポートしています。これにより開発者は、テーブルのカラム名とは別の名前をモデル内のカラム名として使用することができます。 Phalconは新しいカラム名を認識し、データベースのそれぞれのカラムと一致するように名前を変更します。 これは、コード内のすべてのクエリについて心配することなく、データベース内のフィールドの名前を変更する必要がある場合に便利な機能です。 モデル内のカラムのマッピング変更により、残りの部分が処理されます。 例えば:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $code;

    public $theName;

    public $theType;

    public $theYear;

    public function columnMap()
    {
        // キーはテーブル内の実際の名前
        // 値はアプリケーション内の名前
        return [
            'id'       => 'code',
            'the_name' => 'theName',
            'the_type' => 'theType',
            'the_year' => 'theYear',
        ];
    }
}
```

次に、あなたのコードで新しい名前を自然に使うことができます:

```php
<?php

use Store\Toys\Robots;

// 名前でrobotを見つける
$robot = Robots::findFirst(
    "theName = 'Voltron'"
);

echo $robot->theName, "\n";

// タイプで並び替えてrobotを取得
$robot = Robots::find(
    [
        'order' => 'theType DESC',
    ]
);

foreach ($robots as $robot) {
    echo 'Code: ', $robot->code, "\n";
}

// robotを作成
$robot = new Robots();

$robot->code    = '10101';
$robot->theName = 'Bender';
$robot->theType = 'Industrial';
$robot->theYear = 2999;

$robot->save();
```

列の名前を変更するときは、次の点を考慮してください:

* リレーションやバリデータの属性への参照は、新しい名前を使用する必要があります
* 実際の列名を参照すると、ORMによる例外が発生します

独立したカラムマッピングは以下を可能にします:

* 独自の規則を使用してアプリケーションを記述する
* コード内のベンダー接頭辞/接尾辞を排除する
* アプリケーションコードを変更せずに列名を変更する

<a name='record-snapshots'></a>

## レコードのスナップショット

特定のモデルはクエリーを実行した際に、レコードのスナップショットを維持するように設定できます。 この機能を使用して、監査を実装したり、永続データの照会時にどのフィールドが変更されるかを知ることができます。

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->keepSnapshots(true);
    }
}
```

この機能を有効にすると、アプリケーションは永続データから取得した元の値を追跡するために、少しだけメモリを消費します。 この機能が有効になっているモデルでは、次のように変更されたフィールドを確認できます:

```php
<?php

use Store\Toys\Robots;

// データベースからレコードを取得する
$robot = Robots::findFirst();

// 列を変更する
$robot->name = 'Other name';

var_dump($robot->getChangedFields()); // ['name']

var_dump($robot->hasChanged('name')); // true

var_dump($robot->hasChanged('type')); // false
```

スナップショットは、モデルの作成/更新時に更新されます。 作成/保存/更新後にフィールドが更新されたかどうかを確認するには、 `hasUpdated()` および `getUpdatedFields()` を使用できます。 しかし `getUpdatedFields()` を `afterUpdate()` 、 `afterSave()` 、 `afterCreate()` の中で実行すると、アプリケーションに問題を引き起こす可能性があります

この機能を無効にするには、次のコマンドを使用します:

```php
Phalcon\Mvc\Model::setup(
    [
        'updateSnapshotOnSave' => false,
    ]
);
```

または `php.ini` でこれを設定したい場合は、

```ini
phalcon.orm.update_snapshot_on_save = 0
```

この機能を使用すると、次のような効果があります:

```php
<?php

use Phalcon\Mvc\Model;

class User extends Model
{
  public function initialize()
  {
      $this->keepSnapshots(true);
  }
}

$user       = new User();
$user->name = 'Test User';
$user->create();
var_dump($user->getChangedFields());
$user->login = 'testuser';
var_dump($user->getChangedFields());
$user->update();
var_dump($user->getChangedFields());
```

On Phalcon 4.0.0 and later it is:

```php
array(0) {
}
array(1) {
[0]=> 
    string(5) "login"
}
array(0) {
}
```

` getUpdatedFields()` は更新されたフィールドを適切に返しますが、上記のように関連するini値を設定することで前の動作に戻ることもできます。

<a name='different-schemas'></a>

## 別のスキーマを指す

モデルが、デフォルトとは異なるスキーマやデータベースのテーブルにマップされている場合。 `setSchema()` メソッドを使用して、以下を定義できます:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->setSchema('toys');
    }
}
```

<a name='multiple-databases'></a>

## Setting multiple databases

Phalconでは、すべてのモデルが同じデータベース接続に属しているか、個別のものを持つことができます。 Actually, when [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) needs to connect to the database it requests the `db` service in the application's services container. このサービス設定は、 `initialize()` メソッドで上書きできます。

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as MysqlPdo;
use Phalcon\Db\Adapter\Pdo\PostgreSQL as PostgreSQLPdo;

// このサービスはMySQLデータベースを返す
$di->set(
    'dbMysql',
    function () {
        return new MysqlPdo(
            [
                'host'     => 'localhost',
                'username' => 'root',
                'password' => 'secret',
                'dbname'   => 'invo',
            ]
        );
    }
);

// このサービスはPostgreSQLデータベースを返します
$di->set(
    'dbPostgres',
    function () {
        return new PostgreSQLPdo(
            [
                'host'     => 'localhost',
                'username' => 'postgres',
                'password' => '',
                'dbname'   => 'invo',
            ]
        );
    }
);
```

Then, in the `initialize()` method, we define the connection service for the model:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->setConnectionService('dbPostgres');
    }
}
```

しかし、Phalconはあなたにもっと柔軟性を提供します。あなたは `read` と `write` に使わなければならない接続を定義できます。 これは、マスタとスレーブのアーキテクチャを実装するデータベースと負荷のバランスをとるのに特に役立ちます:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        $this->setReadConnectionService('dbSlave');

        $this->setWriteConnectionService('dbMaster');
    }
}
```

ORMは、現在のクエリ条件に従って「シャード」選択を実装できるようにすることで、Horizontal Sharding機能も提供します。

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    /**
     * シャードを動的に選択
     *
     * @param array $intermediate
     * @param array $bindParams
     * @param array $bindTypes
     */
    public function selectReadConnection($intermediate, $bindParams, $bindTypes)
    {
        // select文に 'where' 句があるかどうかを確認する
        if (isset($intermediate['where'])) {
            $conditions = $intermediate['where'];

            // 条件に応じて可能なシャードを選択する
            if ($conditions['left']['name'] === 'id') {
                $id = $conditions['right']['value'];

                if ($id > 0 && $id < 10000) {
                    return $this->getDI()->get('dbShard1');
                }

                if ($id > 10000) {
                    return $this->getDI()->get('dbShard2');
                }
            }
        }

        // デフォルトのシャードを使用する
        return $this->getDI()->get('dbShard0');
    }
}
```

`selectReadConnection()` メソッドは、正しい接続を選択するために呼び出されます。このメソッドは、実行された新しいクエリをインターセプトします:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst('id = 101');
```

<a name='injecting-services-into-models'></a>

## Injecting services into Models

You may be required to access the application services within a model, the following example explains how to do that:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function notSaved()
    {
        // DIコンテナからflashサービスを取得する
        $flash = $this->getDI()->getFlash();

        $messages = $this->getMessages();

        // バリデーションメッセージを表示
        foreach ($messages as $message) {
            $flash->error($message);
        }
    }
}
```

`notSaved` イベントは、`create` または `update` アクションが失敗するたびにトリガーされます。 そしてDIコンテナから `flash` サービスを取得して、バリデーションメッセージをフラッシュさせます。 これにより、保存後に毎回メッセージを出力する必要が無くなります。

<a name='disabling-enabling-features'></a>

## 機能の有効/無効

ORMでは、特定の機能やオプションをオンザフライでグローバルに有効/無効にする仕組みを実装しました。 ORMの使い方に応じて、使用していないものを無効にすることができます。 これらのオプションは、必要に応じて一時的に無効にすることもできます。

```php
<?php

use Phalcon\Mvc\Model;

Model::setup(
    [
        'events'         => false,
        'columnRenaming' => false,
    ]
);
```

使用可能なオプションは次のとおりです:

| オプション                 | Description                                                        |  デフォルト  |
| --------------------- | ------------------------------------------------------------------ |:-------:|
| astCache              | すべてのモデルのコールバック、フック、イベント通知を有効/無効にする                                 | `null`  |
| cacheLevel            | ORMのキャッシュレベルを設定します。                                                |   `3`   |
| castOnHydrate         |                                                                    | `false` |
| columnRenaming        | 列名の変更を有効または無効にします。                                                 | `true`  |
| disableAssignSetters  | モデル内のセッターを無効にすることを許可する                                             | `false` |
| enableImplicitJoins   |                                                                    | `true`  |
| enableLiterals        |                                                                    | `true`  |
| escapeIdentifiers     |                                                                    | `true`  |
| events                | すべてのモデルのコールバック、フック、イベント通知を有効/無効にする                                 | `true`  |
| exceptionOnFailedSave | 失敗した `save()` が存在する場合に例外をスローするかどうかを設定します。                          | `false` |
| forceCasting          |                                                                    | `false` |
| ignoreUnknownColumns  | モデル上の未知の列の無視を有効または無効にする                                            | `false` |
| lateStateBinding      | `Phalcon\Mvc\Model::cloneResultMap()` メソッドの遅延バインディングを有効または無効にします | `false` |
| notNullValidations    | ORMは、マップされた表に存在するNOT NULL列を自動的に検証します                               | `true`  |
| parserCache           |                                                                    | `null`  |
| phqlLiterals          | PHQLパーサのリテラルを有効/無効にする                                              | `true`  |
| uniqueCacheId         |                                                                    |   `3`   |
| updateSnapshotOnSave  | `save()` でスナップショットの更新を有効または無効にします。                                 | `true`  |
| virtualForeignKeys    | 仮想外部キーを有効/無効にします。                                                  | `true`  |

<div class="alert alert-warning">
    <p>
        <strong>備考</strong> <code>Phalcon\Mvc\Model::assign()</code> （モデルの作成/更新/保存時にも使用されます）は、データ引数が渡されたときには常にセッターが使われます。 これにより、アプリケーションにオーバーヘッドが追加されます。 この動作を変更するには、 <code>phalcon.orm.disable_assign_setters = 1</code> をiniファイルに追加します。これは単に <code>$this->property = value</code> を使用するだけです。
    </p>
</div>

<a name='stand-alone-component'></a>

## 独立コンポーネント

Using [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) in a stand-alone mode can be demonstrated below:

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Db\Adapter\Pdo\Sqlite as Connection;
use Phalcon\Mvc\Model\Metadata\Memory as MetaData;

$di = new Di();

// コネクションの初期化
$di->set(
    'db',
    new Connection(
        [
            'dbname' => 'sample.db',
        ]
    )
);

// モデルマネージャを設定する
$di->set(
    'modelsManager',
    new ModelsManager()
);

// メタデータ記憶アダプターなどを使用する
$di->set(
    'modelsMetadata',
    new MetaData()
);

// モデルを作成する
class Robots extends Model
{

}

// モデルを使用する
echo Robots::count();
```