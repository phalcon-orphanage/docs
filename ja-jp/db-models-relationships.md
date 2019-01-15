* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# モデルのリレーション

<a name='relationships'></a>

## モデル同士のリレーション

リレーションは4種類あります: 1対1、1対多、多対1、多対多です。 リレーションは1方向と双方向がありえます。それぞれ、(1対1モデルの) 単純なものから、(モデルを組合せた) 複雑なものがあります。 モデルマネージャーは、これらのリレーションの外部キー制約を管理します。これらの定義は、参照整合性と関連レコードのモデルへの簡単で迅速なアクセスに役立ちます。 リレーションの実装によって、一定の方法で各レコードから関連モデルのデータへ容易にアクセスできます。

<a name='unidirectional'></a>

### 一方向のリレーション

一方向の関係は、一方が他方へ関係するのに対して逆は成り立ちません。

<a name='bidirectional'></a>

### 双方向のリレーション

双方向の関係は両方のモデルで関係が構築されます。そしてそれぞれのモデルは互いに逆の関係を定義します。

<a name='defining'></a>

### リレーションの定義

Phalconでは、リレーションは モデルの`initialize()` メソッドによって定義しなければなりません。 `belongsTo()`, `hasOne()`, `hasMany()` や `hasManyToMany()` のメソッドは現在のモデルの一つまたは複数のフィールドと別のモデルのフィールドとの関係を定義します。 これらのメソッドは3つのパラメーターを必要とします: ローカルフィールド、参照モデル、参照フィールドです。

| メソッド          | Description |
| ------------- | ----------- |
| hasMany       | 1対nの関係を定義   |
| hasOne        | 1対1の関係を定義   |
| belongsTo     | n対1の関係を定義   |
| hasManyToMany | n対nの関係を定義   |

次のスキーマでは、リレーションシップに関するサンプルとしてリレーションを持つ3つのテーブルを示しています。

```sql
CREATE TABLE robots (
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
    name varchar(70) NOT NULL,
    type varchar(32) NOT NULL,
    year int(11) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE robots_parts (
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
    robots_id int(10) NOT NULL,
    parts_id int(10) NOT NULL,
    created_at DATE NOT NULL,
    PRIMARY KEY (id),
    KEY robots_id (robots_id),
    KEY parts_id (parts_id)
);

CREATE TABLE parts (
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
    name varchar(70) NOT NULL,
    PRIMARY KEY (id)
);
```

* `Robots`モデルは、複数の`RobotsParts`を持つ。
* `Parts`モデルは、複数の`RobotsParts`を持つ。
* モデル`RobotsParts`は多対1の関係として、`Robots`と`Parts`モデルの両方に属します。
* `Robots`モデルは `Parts` とn対nの関係があり、それは`RobotsParts`を経由しています。

関係をよりよく理解するために、EER図を確認してください:

![](/assets/images/content/models-relationships-eer-1.png)

この関係のあるモデルは次のように実装できます:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public function initialize()
    {
        $this->hasMany(
            'id',
            'RobotsParts',
            'robots_id'
        );
    }
}
```

```php
<?php

use Phalcon\Mvc\Model;

class Parts extends Model
{
    public $id;

    public $name;

    public function initialize()
    {
        $this->hasMany(
            'id',
            'RobotsParts',
            'parts_id'
        );
    }
}
```

```php
<?php

use Phalcon\Mvc\Model;

class RobotsParts extends Model
{
    public $id;

    public $robots_id;

    public $parts_id;

    public function initialize()
    {
        $this->belongsTo(
            'robots_id',
            'Store\Toys\Robots',
            'id'
        );

        $this->belongsTo(
            'parts_id',
            'Parts',
            'id'
        );
    }
}
```

最初のパラメーターは、リレーションで使用されるローカルモデルのフィールドを示します。2 番目のパラメーターは参照先モデル、3番目は参照モデル内のフィールド名を示します。 また、配列を使用して、リレーションの複数のフィールドを定義できます。

多対多リレーションは 3 つのモデルが必要です。また、そのリレーションの属性を定義します。

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public function initialize()
    {
        $this->hasManyToMany(
            'id',
            'RobotsParts',
            'robots_id', 'parts_id',
            'Parts',
            'id'
        );
    }
}
```

<a name='parameters'></a>

#### Relationships with parameters

Depending on the needs of our application we might want to store data in one table, that describe different behaviors. For instance you might want to only have a table called `parts` which has a field `type` describing the type of the part.

Using relationships, we can get only those parts that relate to our Robot that are of certain type. Defining that constraint in our relationship allows us to let the model do all the work.

```php
<?php

 namespace Store\Toys;

 use Phalcon\Mvc\Model;

 class Robots extends Model
 {
     public $id;

     public $name;

     public $type;

     public function initialize()
     {
         $this->hasMany(
             'id',
             Parts::class,
             'robotId',
             [
                 'reusable' => true, // cache related data
                 'alias'    => 'mechanicalParts',
                 'params'   => [
                     'conditions' => 'robotTypeId = :type:',
                     'bind'       => [
                         'type' => 4,
                     ]
                 ]
             ]
         );
     }
 }
 ```

<a name='multiple-fields'></a>
#### Multiple field relationships
There are times where relationships need to be defined on a combination of fields and not only one. Consider the following example:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $type;
}
```

and

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Parts extends Model
{
    public $id;

    public $robotId;

    public $robotType;

    public $name;
}
```

上の例で、`Robots`モデルは3つの属性を持っています。 一意の`id`、`name` と `type` はそのロボットが何か(mechnicalなど) を定義します。`Parts` モデルの`name` は部品の名前ですが、その他のフィールドはそのロボットとそのtypeに結びついており特定の部品であることを意味しています。

前述のリレーションオプションを使用すると、2つのモデル間で1つのフィールドをバインドしても、必要な結果は返されません。 そのために、私たちの関係に配列を使うことができます:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public $id;

    public $name;

    public $type;

    public function initialize()
    {
        $this->hasOne(
            ['id', 'type'],
            Parts::class,
            ['robotId', 'robotType'],
            [
                'reusable' => true, // 関連データのキャッシュ
                'alias'    => 'parts',
            ]
        );
    }
}
```

**注意** リレーションのフィールドマッピングは1対1です。いいかえれば、参照元モデルの最初のフィールドは対象となる配列の最初のフィールドにマッチします。 フィールド数は、参照元モデルと対象モデルの両方で同等でなければなりません。

<a name='taking-advantage-of'></a>

### リレーションの活用

When explicitly defining the relationships between models, it is easy to find related records for a particular record.

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

foreach ($robot->robotsParts as $robotPart) {
    echo $robotPart->parts->name, "\n";
}
```

Phalcon uses the magic methods `__set`/`__get`/`__call` to store or retrieve related data using relationships.

By accessing an attribute with the same name as the relationship will retrieve all its related record(s).

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst();

// RobotsPartsのすべての関連レコード
$robotsParts = $robot->robotsParts;
```

Also, you can use a magic getter:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst();

// RobotsPartsの関連するすべてのレコード
$robotsParts = $robot->getRobotsParts();

// パラメータ渡し
$robotsParts = $robot->getRobotsParts(
    [
        'limit' => 5,
    ]
);
```

If the called method has a `get` prefix [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) will return a `findFirst()`/`find()` result. The following example compares retrieving related results with using magic methods and without:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

// Robots モデルは RobotsPartsは
// 1対n (hasMany) の関係です。
$robotsParts = $robot->robotsParts;

// 条件にマッチした partsのみ
$robotsParts = $robot->getRobotsParts(
    [
        'created_at = :date:',
        'bind' => [
            'date' => '2015-03-15'
        ]
    ]
);

$robotPart = RobotsParts::findFirst(1);

// RobotsParts モデルは RobotsPartsと
//  n対1 (belongsTo)の関係です。
$robot = $robotPart->robots;
```

Getting related records manually:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

// Robots モデルは RobotsPartsと
// 1対n (hasMany)の関係です。
$robotsParts = RobotsParts::find(
    [
        'robots_id = :id:',
        'bind' => [
            'id' => $robot->id,
        ]
    ]
);

// 条件にマッチした Partsのみ
$robotsParts = RobotsParts::find(
    [
        'robots_id = :id: AND created_at = :date:',
        'bind' => [
            'id'   => $robot->id,
            'date' => '2015-03-15',
        ]
    ]
);

$robotPart = RobotsParts::findFirst(1);

// RobotsParts モデルは RobotsPartsと
// n対1 (belongsTo)の関係です。
$robot = Robots::findFirst(
    [
        'id = :id:',
        'bind' => [
            'id' => $robotPart->robots_id,
        ]
    ]
);
```

The prefix `get` is used to `find()`/`findFirst()` related records. Depending on the type of relation it will use `find()` or `findFirst()`:

| Type             | Description                                                                                                                | Implicit Method |
| ---------------- | -------------------------------------------------------------------------------------------------------------------------- | --------------- |
| Belongs-To       | Returns a model instance of the related record directly                                                                    | findFirst       |
| Has-One          | Returns a model instance of the related record directly                                                                    | findFirst       |
| Has-Many         | Returns a collection of model instances of the referenced model                                                            | find            |
| Has-Many-to-Many | Returns a collection of model instances of the referenced model, it implicitly does 'inner joins' with the involved models | (complex query) |

You can also use the `count` prefix to return an integer denoting the count of the related records:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

echo 'The robot has ', $robot->countRobotsParts(), " parts\n";
```

<a name='aliases'></a>

### リレーションのエイリアス

To explain better how aliases work, let's check the following example:

The `robots_similar` table has the function to define what robots are similar to others:

```sql
mysql> desc robots_similar;
+-------------------+------------------+------+-----+---------+----------------+
| Field             | Type             | Null | Key | Default | Extra          |
+-------------------+------------------+------+-----+---------+----------------+
| id                | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| robots_id         | int(10) unsigned | NO   | MUL | NULL    |                |
| similar_robots_id | int(10) unsigned | NO   |     | NULL    |                |
+-------------------+------------------+------+-----+---------+----------------+
3 rows in set (0.00 sec)
```

Both `robots_id` and `similar_robots_id` have a relation to the model Robots:

![](/assets/images/content/models-relationships-eer-1.png)

A model that maps this table and its relationships is the following:

```php
<?php

class RobotsSimilar extends Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->belongsTo(
            'robots_id',
            'Store\Toys\Robots',
            'id'
        );

        $this->belongsTo(
            'similar_robots_id',
            'Store\Toys\Robots',
            'id'
        );
    }
}
```

Since both relations point to the same model (Robots), obtain the records related to the relationship could not be clear:

```php
<?php

$robotsSimilar = RobotsSimilar::findFirst();

// Returns the related record based on the column (robots_id)
// Also as is a belongsTo it's only returning one record
// but the name 'getRobots' seems to imply that return more than one
$robot = $robotsSimilar->getRobots();

// but, how to get the related record based on the column (similar_robots_id)
// if both relationships have the same name?
```

The aliases allow us to rename both relationships to solve these problems:

```php
<?php

use Phalcon\Mvc\Model;

class RobotsSimilar extends Model
{
    public function initialize()
    {
        $this->belongsTo(
            'robots_id',
            'Store\Toys\Robots',
            'id',
            [
                'alias' => 'Robot',
            ]
        );

        $this->belongsTo(
            'similar_robots_id',
            'Store\Toys\Robots',
            'id',
            [
                'alias' => 'SimilarRobot',
            ]
        );
    }
}
```

With the aliasing we can get the related records easily. You can also use the `getRelated()` method to access the relationship using the alias name:

```php
<?php

$robotsSimilar = RobotsSimilar::findFirst();

// Returns the related record based on the column (robots_id)
$robot = $robotsSimilar->getRobot();
$robot = $robotsSimilar->robot;
$robot = $robotsSimilar->getRelated('Robot');

// Returns the related record based on the column (similar_robots_id)
$similarRobot = $robotsSimilar->getSimilarRobot();
$similarRobot = $robotsSimilar->similarRobot;
$similarRobot = $robotsSimilar->getRelated('SimilarRobot');
```

<a name='getters-vs-methods'></a>

#### Getterのマジックメソッド vs 明示的なメソッド

Most IDEs and editors with auto-completion capabilities can not infer the correct types when using magic getters (both methods and properties). To overcome that, you can use a class docblock that specifies what magic actions are available, helping the IDE to produce a better auto-completion:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

/**
 * Model class for the robots table.
 * @property Simple|RobotsParts[] $robotsParts
 * @method   Simple|RobotsParts[] getRobotsParts($parameters = null)
 * @method   integer              countRobotsParts()
 */
class Robots extends Model
{
    public $id;

    public $name;

    public function initialize()
    {
        $this->hasMany(
            'id',
            'RobotsParts',
            'robots_id'
        );
    }
}
```

<a name='conditionals'></a>

## 条件

You can also create relationships based on conditionals. When querying based on the relationship the condition will be automatically appended to the query:

```php
<?php

use Phalcon\Mvc\Model;

// Companies have invoices issued to them (paid/unpaid)
// Invoices model
class Invoices extends Model
{

}

// Companies model
class Companies extends Model
{
    public function initialize()
    {
        // All invoices relationship
        $this->hasMany(
            'id', 
            'Invoices', 
            'inv_id', 
            [
                'alias' => 'Invoices'
            ]
        );

        // Paid invoices relationship
        $this->hasMany(
            'id', 
            'Invoices', 
            'inv_id', 
            [
                'alias'    => 'InvoicesPaid',
                'params'   => [
                    'conditions' => "inv_status = 'paid'"
                ]
            ]
        );

        // Unpaid invoices relationship + bound parameters
        $this->hasMany(
            'id', 
            'Invoices', 
            'inv_id', 
            [
                'alias'    => 'InvoicesUnpaid',
                'params'   => [
                    'conditions' => "inv_status <> :status:",
                    'bind' => ['status' => 'unpaid']
                ]
            ]
        );
    }
}
```

Additionally, you can use the second parameter of `getRelated()` when accessing your relationship from your model object to further filter or order your relationship:

```php
<?php

// Unpaid Invoices
$company = Companies::findFirst(
    [
        'conditions' => 'id = :id:',
        'bind'       => ['id' => 1],
    ]
);

$unpaidInvoices = $company->InvoicesUnpaid;
$unpaidInvoices = $company->getInvoicesUnpaid();
$unpaidInvoices = $company->getRelated('InvoicesUnpaid');
$unpaidInvoices = $company->getRelated(
    'Invoices', 
    ['conditions' => "inv_status = 'paid'"]
);

// Also ordered
$unpaidInvoices = $company->getRelated(
    'Invoices', 
    [
        'conditions' => "inv_status = 'paid'",
        'order'      => 'inv_created_date ASC',
    ]
);
```

<a name='virtual-foreign-keys'></a>

## 仮想外部キー

By default, relationships do not act like database foreign keys, that is, if you try to insert/update a value without having a valid value in the referenced model, Phalcon will not produce a validation message. You can modify this behavior by adding a fourth parameter when defining a relationship.

The RobotsPart model can be changed to demonstrate this feature:

```php
<?php

use Phalcon\Mvc\Model;

class RobotsParts extends Model
{
    public $id;

    public $robots_id;

    public $parts_id;

    public function initialize()
    {
        $this->belongsTo(
            'robots_id',
            'Store\Toys\Robots',
            'id',
            [
                'foreignKey' => true
            ]
        );

        $this->belongsTo(
            'parts_id',
            'Parts',
            'id',
            [
                'foreignKey' => [
                    'message' => 'The part_id does not exist on the Parts model'
                ]
            ]
        );
    }
}
```

If you alter a `belongsTo()` relationship to act as foreign key, it will validate that the values inserted/updated on those fields have a valid value on the referenced model. Similarly, if a `hasMany()`/`hasOne()` is altered it will validate that the records cannot be deleted if that record is used on a referenced model.

```php
<?php

use Phalcon\Mvc\Model;

class Parts extends Model
{
    public function initialize()
    {
        $this->hasMany(
            'id',
            'RobotsParts',
            'parts_id',
            [
                'foreignKey' => [
                    'message' => 'The part cannot be deleted because other robots are using it',
                ]
            ]
        );
    }
}
```

A virtual foreign key can be set up to allow null values as follows:

```php
<?php

use Phalcon\Mvc\Model;

class RobotsParts extends Model
{
    public $id;

    public $robots_id;

    public $parts_id;

    public function initialize()
    {
        $this->belongsTo(
            'parts_id',
            'Parts',
            'id',
            [
                'foreignKey' => [
                    'allowNulls' => true,
                    'message'    => 'The part_id does not exist on the Parts model',
                ]
            ]
        );
    }
}
```

<a name='cascade-restrict-actions'></a>

### カスケード/制限アクション

Relationships that act as virtual foreign keys by default restrict the creation/update/deletion of records to maintain the integrity of data:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;

class Robots extends Model
{
    public $id;

    public $name;

    public function initialize()
    {
        $this->hasMany(
            'id',
            'Parts',
            'robots_id',
            [
                'foreignKey' => [
                    'action' => Relation::ACTION_CASCADE,
                ]
            ]
        );
    }
}
```

The above code set up to delete all the referenced records (parts) if the master record (robot) is deleted.

<a name='storing-related-records'></a>

## 関連レコードの保存

Magic properties can be used to store a record and its related properties:

```php
<?php

// Create an artist
$artist = new Artists();

$artist->name    = 'Shinichi Osawa';
$artist->country = 'Japan';

// Create an album
$album = new Albums();

$album->name   = 'The One';
$album->artist = $artist; // Assign the artist
$album->year   = 2008;

// Save both records
$album->save();
```

Saving a record and its related records in a has-many relation:

```php
<?php

// Get an existing artist
$artist = Artists::findFirst(
    'name = 'Shinichi Osawa''
);

// Create an album
$album = new Albums();

$album->name   = 'The One';
$album->artist = $artist;

$songs = [];

// Create a first song
$songs[0]           = new Songs();
$songs[0]->name     = 'Star Guitar';
$songs[0]->duration = '5:54';

// Create a second song
$songs[1]           = new Songs();
$songs[1]->name     = 'Last Days';
$songs[1]->duration = '4:29';

// Assign the songs array
$album->songs = $songs;

// Save the album + its songs
$album->save();
```

Saving the album and the artist at the same time implicitly makes use of a transaction so if anything goes wrong with saving the related records, the parent will not be saved either. Messages are passed back to the user for information regarding any errors.

Note: Adding related entities by overloading the following methods is not possible:

* `Phalcon\Mvc\Model::beforeSave()`
* `Phalcon\Mvc\Model::beforeCreate()`
* `Phalcon\Mvc\Model::beforeUpdate()`

You need to overload `Phalcon\Mvc\Model::save()` for this to work from within a model.

<a name='operations-over-resultsets'></a>

## 結果セットの操作

If a resultset is composed of complete objects, model operations can be performed on those objects. For example:

```php
<?php

/** @var RobotType $type */
$type = $robots->getRelated('type');

$type->name = 'Some other type';
$result = $type->save();


// Get the related robot type but only the `name` column
$type = $robots->getRelated('type', ['columns' => 'name']);

$type->name = 'Some other type';

// This will fail because `$type` is not a complete object
$result = $type->save();

```

<a name='updating-related-records'></a>

### 関連レコードの更新

こうする代わりに:

```php
<?php

$parts = $robots->getParts();

foreach ($parts as $part) {
    $part->stock      = 100;
    $part->updated_at = time();

    if ($part->update() === false) {
        $messages = $part->getMessages();

        foreach ($messages as $message) {
            echo $message;
        }

        break;
    }
}
```

以下のようにできます:

```php
<?php

$robots->getParts()->update(
    [
        'stock'      => 100,
        'updated_at' => time(),
    ]
);
```

`update` は無名関数を使用して、どのレコードを更新するかをフィルタすることができます。

```php
<?php

$data = [
    'stock'      => 100,
    'updated_at' => time(),
];

// typeがbasicのもの以外のすべてのカラムを更新
$robots->getParts()->update(
    $data,
    function ($part) {
        if ($part->type === Part::TYPE_BASIC) {
            return false;
        }

        return true;
    }
);
```

<a name='deleting-related-records'></a>

### 関連レコードの削除

こうする代わりに:

```php
<?php

$parts = $robots->getParts();

foreach ($parts as $part) {
    if ($part->delete() === false) {
        $messages = $part->getMessages();

        foreach ($messages as $message) {
            echo $message;
        }

        break;
    }
}
```

以下のようにできます:

```php
<?php

$robots->getParts()->delete();
```

`delete()` は無名関数を使用して、どのレコードを削除するかをフィルタすることができます。

```php
<?php

// ストックが0以上のもののみを削除する
$robots->getParts()->delete(
    function ($part) {
        if ($part->stock < 0) {
            return false;
        }

        return true;
    }
);
```