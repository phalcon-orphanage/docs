* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# 关联模型

<a name='relationships'></a>

## 模型之间的关系

有四种类型的关系： 一对一、 一到多、 多对一和多对多。 The relationship may be unidirectional or bidirectional, and each can be simple (a one to one model) or more complex (a combination of models). The model manager manages foreign key constraints for these relationships, the definition of these helps referential integrity as well as easy and fast access of related records to a model. 通过执行的关系，很容易从每个记录中以统一的方式访问相关模型中的数据。

<a name='unidirectional'></a>

### 单向的关系

Unidirectional relations are those that are generated in relation to one another but not vice versa.

<a name='bidirectional'></a>

### 双向关系

The bidirectional relations build relationships in both models and each model defines the inverse relationship of the other.

<a name='defining'></a>

### 定义关系

在Phalcon，必须在模型的 `initialize()` 方法中定义关系。 方法 `belongsTo()`、 `hasOne()`、 `hasMany()` 和 `hasManyToMany()` 定义一个或多个字段从当前模型到另一个模型中的字段之间的关系。 每一种方法需要 3 个参数： 本地字段，引用模型引用字段。

| 方法            | 描述           |
| ------------- | ------------ |
| hasMany       | 定义 1 n 的关系   |
| hasOne        | 定义 1-1 的关系   |
| belongsTo     | 定义一个 n-1 的关系 |
| hasManyToMany | 定义 n n 的关系   |

下面的架构显示 3 表的关系将我们作为关于关系的示例：

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

* `Robots` 的模型有很多 `RobotsParts`。
* `Parts` 模型有很多 `RobotsParts`。
* `RobotsParts` 模型属于 `Robots` 和 `Parts` 模型作为一种多对一关系。
* `Robots` 模型已关系到 `Parts` 通过 `RobotsParts` 多。

Check the EER diagram to understand better the relations:

![](/assets/images/content/models-relationships-eer-1.png)

与他们的关系模型可以实施如下：

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

The first parameter indicates the field of the local model used in the relationship; the second indicates the name of the referenced model and the third the field name in the referenced model. 你也可以使用数组来定义多个字段中的关系。

多对多关系需要 3 模型和定义关系中涉及的属性：

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
                'reusable' => true, // cache related data
                'alias'    => 'parts',
            ]
        );
    }
}
```

**NOTE** The field mappings in the relationship are one for one i.e. the first field of the source model array matches the first field of the target array etc. The field count must be identical in both source and target models.

<a name='taking-advantage-of'></a>

### Taking advantage of relationships

当显式定义模型之间的关系，很容易查找特定记录相关的记录。

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

foreach ($robot->robotsParts as $robotPart) {
    echo $robotPart->parts->name, "\n";
}
```

Phalcon uses the magic methods `__set`/`__get`/`__call` to store or retrieve related data using relationships.

通过访问属性与关系相同的名称将检索其相关的记录。

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst();

// All the related records in RobotsParts
$robotsParts = $robot->robotsParts;
```

此外，您可以使用魔法的 getter:

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst();

// All the related records in RobotsParts
$robotsParts = $robot->getRobotsParts();

// Passing parameters
$robotsParts = $robot->getRobotsParts(
    [
        'limit' => 5,
    ]
);
```

If the called method has a `get` prefix [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) will return a `findFirst()`/`find()` result. 下面的示例检索相关的结果使用魔法的方法与无：

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

// Robots model has a 1-n (hasMany)
// relationship to RobotsParts then
$robotsParts = $robot->robotsParts;

// Only parts that match conditions
$robotsParts = $robot->getRobotsParts(
    [
        'created_at = :date:',
        'bind' => [
            'date' => '2015-03-15'
        ]
    ]
);

$robotPart = RobotsParts::findFirst(1);

// RobotsParts model has a n-1 (belongsTo)
// relationship to RobotsParts then
$robot = $robotPart->robots;
```

手动获取相关的记录：

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

// Robots model has a 1-n (hasMany)
// relationship to RobotsParts, then
$robotsParts = RobotsParts::find(
    [
        'robots_id = :id:',
        'bind' => [
            'id' => $robot->id,
        ]
    ]
);

// Only parts that match conditions
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

// RobotsParts model has a n-1 (belongsTo)
// relationship to RobotsParts then
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

| Type             | 描述                                                              | Implicit Method |
| ---------------- | --------------------------------------------------------------- | --------------- |
| Belongs-To       | Returns a model instance of the related record directly         | findFirst()     |
| Has-One          | Returns a model instance of the related record directly         | findFirst()     |
| Has-Many         | Returns a collection of model instances of the referenced model | find            |
| Has-Many-to-Many | 返回一个集合的引用模型的模型实例，它隐式对 '内部联接' 所涉及的模型                             | （复杂的查询）         |

您还可以使用 `count` 前缀返回一个整数，表示的相关记录的计数：

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

echo 'The robot has ', $robot->countRobotsParts(), " parts\n";
```

<a name='aliases'></a>

### 混叠的关系

为了更好地解释别名是如何工作的让我们检查下面的示例：

`Robots_similar` 表具有用于定义什么机器人与其他相近的函数：

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

`Robots_id` 和 `similar_robots_id` 具有模型机器人的关系：

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

别名允许我们重命名这两个关系来解决这些问题：

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

#### Magic Getters vs. Explicit methods

Most IDEs and editors with auto-completion capabilities can not infer the correct types when using magic getters (both methods and properties). 要克服的您可以使用指定什么神奇的行为是可用的类块帮助 IDE 以产生更好的自动完成功能：

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

## Conditionals

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

## 虚拟的外键

By default, relationships do not act like database foreign keys, that is, if you try to insert/update a value without having a valid value in the referenced model, Phalcon will not produce a validation message. 通过添加第四个参数，当定义一个关系时，您可以修改此行为。

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

### Cascade/Restrict actions

默认情况下充当虚拟的外键的关系限制创建/更新/删除的记录，以保持数据的完整性：

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

上面的代码中设置删除被引用的所有记录 （parts），如果删除了主记录 （robot）。

<a name='storing-related-records'></a>

## 存储相关的记录

魔法属性可以用于存储记录和其相关的属性：

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

有许多关系中保存记录和其相关的记录：

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

保存这张专辑，艺术家，同时隐式使用的交易所以如果有任何差错与保存相关的记录，父将不会保存任何。 消息传递有关任何错误的信息返回给用户。

注意： 通过重载以下方法添加相关的实体是不可能的：

* `Phalcon\Mvc\Model::beforeSave()`
* `Phalcon\Mvc\Model::beforeCreate()`
* `Phalcon\Mvc\Model::beforeUpdate()`

您需要重载 `Phalcon\Mvc\Model::save()` 为此要从内部模型工作。

<a name='operations-over-resultsets'></a>

## 在结果集的操作

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

### 更新相关的记录

Instead of doing this:

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

你可以这样做：

```php
<?php

$robots->getParts()->update(
    [
        'stock'      => 100,
        'updated_at' => time(),
    ]
);
```

`update` 也接受匿名函数来筛选哪些记录必须更新：

```php
<?php

$data = [
    'stock'      => 100,
    'updated_at' => time(),
];

// Update all the parts except those whose type is basic
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

### 删除相关的记录

Instead of doing this:

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

你可以这样做：

```php
<?php

$robots->getParts()->delete();
```

`delete （） 方法` 还接受匿名函数来筛选哪些记录，必须先删除：

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