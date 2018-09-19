<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">モデルのリレーション</a> <ul>
        <li>
          <a href="#relationships">モデル同士のリレーション</a> <ul>
            <li>
              <a href="#unidirectional">一方向の関係</a>
            </li>
            <li>
              <a href="#bidirectional">双方向の関係</a>
            </li>
            <li>
              <a href="#defining">リレーションの定義</a> <ul>
                <li>
                  <a href="#multiple-fields">複数フィールドのリレーション</a>
                </li>
                <li>
                  <a href="#parameters">パラメーター付きリレーション</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#taking-advantage-of">リレーションの活用</a>
            </li>
            <li>
              <a href="#aliases">リレーションのエイリアス</a> <ul>
                <li>
                  <a href="#getters-vs-methods">Getterのマジックメソッド vs 明示的なメソッド</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a href="#virtual-foreign-keys">仮想外部キー</a> <ul>
            <li>
              <a href="#cascade-restrict-actions">カスケード/制限アクション</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#storing-related-records">関連レコードの保存</a>
        </li>
        <li>
          <a href="#operations-over-resultsets">結果セットの操作</a> <ul>
            <li>
              <a href="#updating-related-records">関連レコードの更新</a>
            </li>
            <li>
              <a href="#deleting-related-records">関連レコードの削除</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# モデルのリレーション

<a name='relationships'></a>

## モデル同士のリレーション

There are four types of relationships: one-on-one, one-to-many, many-to-one and many-to-many. The relationship may be unidirectional or bidirectional, and each can be simple (a one to one model) or more complex (a combination of models). The model manager manages foreign key constraints for these relationships, the definition of these helps referential integrity as well as easy and fast access of related records to a model. Through the implementation of relations, it is easy to access data in related models from each record in a uniform way.

<a name='unidirectional'></a>

### 一方向の関係

Unidirectional relations are those that are generated in relation to one another but not vice versa.

<a name='bidirectional'></a>

### 双方向の関係

The bidirectional relations build relationships in both models and each model defines the inverse relationship of the other.

<a name='defining'></a>

### リレーションの定義

In Phalcon, relationships must be defined in the `initialize()` method of a model. The methods `belongsTo()`, `hasOne()`, `hasMany()` and `hasManyToMany()` define the relationship between one or more fields from the current model to fields in another model. Each of these methods requires 3 parameters: local fields, referenced model, referenced fields.

| メソッド          | 説明        |
| ------------- | --------- |
| hasMany       | 1対nの関係を定義 |
| hasOne        | 1対1の関係を定義 |
| belongsTo     | n対1の関係を定義 |
| hasManyToMany | n対nの関係を定義 |

The following schema shows 3 tables whose relations will serve us as an example regarding relationships:

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

- The model `Robots` has many `RobotsParts`.
- The model `Parts` has many `RobotsParts`.
- The model `RobotsParts` belongs to both `Robots` and `Parts` models as a many-to-one relation.
- The model `Robots` has a relation many-to-many to `Parts` through `RobotsParts`.

Check the EER diagram to understand better the relations:

![](/images/content/models-relationships-eer-1.png)

The models with their relations could be implemented as follows:

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

The first parameter indicates the field of the local model used in the relationship; the second indicates the name of the referenced model and the third the field name in the referenced model. You could also use arrays to define multiple fields in the relationship.

Many to many relationships require 3 models and define the attributes involved in the relationship:

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

#### パラメーター付きリレーション

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
                 'reusable' => true, // 関連データのキャッシュ
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
#### 複数フィールドのリレーション
フィールドの組み合わせだけでなく、複数の関係を定義しなければならない場合もあります。 次の例を考えてみます:

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

と

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

In the above we have a `Robots` model which has three properties. A unique `id`, a `name` and a `type` which defines what this robot is (mechnical, etc.); In the `Parts` model we also have a `name` for the part but also fields that tie the robot and its type with a specific part.

Using the relationships options discussed earlier, binding one field between the two models will not return the results we need. For that we can use an array in our relationship:

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

**NOTE** The field mappings in the relationship are one for one i.e. the first field of the source model array matches the first field of the target array etc. The field count must be identical in both source and target models.

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

// RobotsPartsのすべての関連レコード
$robotsParts = $robot->getRobotsParts();

// パラメータを渡す
$robotsParts = $robot->getRobotsParts(
    [
        'limit' => 5,
    ]
);
```

If the called method has a `get` prefix `Phalcon\Mvc\Model` will return a `findFirst()`/`find()` result. The following example compares retrieving related results with using magic methods and without:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

// RobotsモデルがRobotsPartsと
// 1-n (hasMany)の関係にあるなら
$robotsParts = $robot->robotsParts;

// 条件に一致するレコードのみ
$robotsParts = $robot->getRobotsParts(
    [
        'created_at = :date:',
        'bind' => [
            'date' => '2015-03-15'
        ]
    ]
);

$robotPart = RobotsParts::findFirst(1);

// RobotsモデルがRobotsPartsと
// n-1 (belongsTo)の関係にあるなら
$robot = $robotPart->robots;
```

Getting related records manually:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

// RobotsモデルがRobotsPartsと
// 1-n (hasMany)の関係にあるなら
$robotsParts = RobotsParts::find(
    [
        'robots_id = :id:',
        'bind' => [
            'id' => $robot->id,
        ]
    ]
);

// 条件に一致するレコードのみ
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

// RobotsモデルがRobotsPartsと
// n-1 (belongsTo)の関係にあるなら
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

| タイプ              | 説明                                                                                                                         | 暗黙のメソッド名  |
| ---------------- | -------------------------------------------------------------------------------------------------------------------------- | --------- |
| Belongs-To       | Returns a model instance of the related record directly                                                                    | findFirst |
| Has-One          | Returns a model instance of the related record directly                                                                    | findFirst |
| Has-Many         | Returns a collection of model instances of the referenced model                                                            | find      |
| Has-Many-to-Many | Returns a collection of model instances of the referenced model, it implicitly does 'inner joins' with the involved models | (クエリの組合せ) |

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

![](/images/content/models-relationships-eer-1.png)

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

With the aliasing we can get the related records easily:

```php
<?php

$robotsSimilar = RobotsSimilar::findFirst(); 

// カラム(robots_id) に基いて、関連するレコードを返す。 
$robot = $robotsSimilar->getRobot();
$robot = $robotsSimilar->robot;

// カラム(similar_robots_id)に基いて、関連するレコードを返す。
$similarRobot = $robotsSimilar->getSimilarRobot();
$similarRobot = $robotsSimilar->similarRobot;
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

// アーティストを作成
$artist = new Artists();

$artist->name    = 'Shinichi Osawa';
$artist->country = 'Japan';

// アルバムを作成
$album = new Albums();

$album->name   = 'The One';
$album->artist = $artist; // アーティストをセット
$album->year   = 2008;

// 両方のレコードを保存
$album->save();
```

Saving a record and its related records in a has-many relation:

```php
<?php

// 既存のアーティストを取得
$artist = Artists::findFirst(
    'name = 'Shinichi Osawa''
);

// アルバムを作成
$album = new Albums();

$album->name   = 'The One';
$album->artist = $artist;

$songs = [];

// 最初の曲を作成
$songs[0]           = new Songs();
$songs[0]->name     = 'Star Guitar';
$songs[0]->duration = '5:54';

// 2番目の曲を作成
$songs[1]           = new Songs();
$songs[1]->name     = 'Last Days';
$songs[1]->duration = '4:29';

// 曲リストをセット
$album->songs = $songs;

// アルバム+曲を保存
$album->save();
```

Saving the album and the artist at the same time implicitly makes use of a transaction so if anything goes wrong with saving the related records, the parent will not be saved either. Messages are passed back to the user for information regarding any errors.

Note: Adding related entities by overloading the following methods is not possible:

- `Phalcon\Mvc\Model::beforeSave()`
- `Phalcon\Mvc\Model::beforeCreate()`
- `Phalcon\Mvc\Model::beforeUpdate()`

You need to overload `Phalcon\Mvc\Model::save()` for this to work from within a model.

<a name='operations-over-resultsets'></a>

## 結果セットの操作

If a resultset is composed of complete objects, the resultset is in the ability to perform operations on the records obtained in a simple manner:

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

`update` also accepts an anonymous function to filter what records must be updated:

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

`delete()` also accepts an anonymous function to filter what records must be deleted:

```php
<?php

// Delete only whose stock is greater or equal than zero
$robots->getParts()->delete(
    function ($part) {
        if ($part->stock < 0) {
            return false;
        }

        return true;
    }
);
```