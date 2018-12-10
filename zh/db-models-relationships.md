<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">关联模型</a> <ul>
        <li>
          <a href="#relationships">模型之间的关系</a> <ul>
            <li>
              <a href="#unidirectional">单向的关系</a>
            </li>
            <li>
              <a href="#bidirectional">双向关系</a>
            </li>
            <li>
              <a href="#defining">定义关系</a> <ul>
                <li>
                  <a href="#multiple-fields">多个字段关系</a>
                </li>
                <li>
                  <a href="#parameters">有参数的关联关系</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="#taking-advantage-of">使用关系</a>
            </li>
            <li>
              <a href="#aliases">混叠的关系</a> <ul>
                <li>
                  <a href="#getters-vs-methods">魔术方法 Getters vs. 显式方法</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <a href="#virtual-foreign-keys">虚拟外键</a> <ul>
            <li>
              <a href="#cascade-restrict-actions">级联/限制行动</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#storing-related-records">存储相关的记录</a>
        </li>
        <li>
          <a href="#operations-over-resultsets">结果集的操作</a> <ul>
            <li>
              <a href="#updating-related-records">更新相关的记录</a>
            </li>
            <li>
              <a href="#deleting-related-records">删除相关的记录</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# 关联模型

<a name='relationships'></a>

## 模型之间的关系

有四种类型的关系： 一对一、 一到多、 多对一和多对多。 关系可以是单向或双向，和每个可以简单 （一对一模式） 或更复杂 （模型的组合）。 模型管理器管理这些关系的外键约束, 这些约束的定义有助于数据完整性以及对模型的相关记录的轻松快速访问。 通过执行的关系，很容易从每个记录中以统一的方式访问相关模型中的数据。

<a name='unidirectional'></a>

### 单向的关系

单向关系是那些彼此相关但反之不生成。

<a name='bidirectional'></a>

### 双向关系

双向关系在两个模型中建立关系, 每个模型定义另一个模型的反向关系。

<a name='defining'></a>

### 定义关系

在Phalcon，必须在模型的 `initialize()` 方法中定义关系。 方法 `belongsTo()`、 `hasOne()`、 `hasMany()` 和 `hasManyToMany()` 定义一个或多个字段从当前模型到另一个模型中的字段之间的关系。 每一种方法需要 3 个参数： 本地字段，引用模型引用字段。

| 方法            | 描述           |
| ------------- | ------------ |
| hasMany       | 定义 1 n 的关系   |
| hasOne        | 定义 1-1 的关系   |
| belongsTo     | 定义一个 n-1 的关系 |
| hasManyToMany | 定义 n-n 的关系   |

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

- `Robots` 的模型有很多 `RobotsParts`。
- `Parts` 模型有很多 `RobotsParts`。
- `RobotsParts` 模型属于 `Robots` 和 `Parts` 模型作为一种多对一关系。
- `Robots` 模型已关系到 `Parts` 通过 `RobotsParts` 多。

检查EER图表以更好地理解关系:

![](/images/content/models-relationships-eer-1.png)

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

第一个参数表示用于关联的字段; 第二个字段是用于关联的模型名字, 第三个字段的引用的模型的字段名字。 你也可以使用数组来定义多个字段中的关系。

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

#### 有参数的关联关系

根据我们的应用程序的需要，我们可能希望将数据存储在一个表中，描述不同的行为。 例如，您可能想要只有一个名为` parts `的表格，它的字段`type</0，描述该部分的类型。</p>

<p>使用关系，我们只能得到与我们的机器人相关的部分。在我们的关系中定义约束允许我们让模型完成所有的工作。</p>

<pre><code class="php"><?php

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
There are times where relationships need to be defined on a combination of fields and not only one. 如下例子:

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
`</pre> 

以及

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

在上面我们有一个`Robots`模型，它有三个属性。 一个唯一的`id`，一个`name`，一个`type`，它定义了这个机器人是什么(机械的，等等); 在`Parts` model中，我们也有一个`name`的部分，以及连接机器人及其类型与特定部分的字段。

使用前面讨论的关系选项，在两个模型之间绑定一个字段不会返回我们需要的结果。为此，我们可以在我们的关系中使用一个数组:

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

**NOTE** 关系中的字段映射是一对一的，即源模型数组的第一个字段与目标数组的第一个字段匹配，等等。 在源模型和目标模型中，字段计数必须相同。

<a name='taking-advantage-of'></a>

### 使用关系

当显式定义模型之间的关系，很容易查找特定记录相关的记录。

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(2);

foreach ($robot->robotsParts as $robotPart) {
    echo $robotPart->parts->name, "\n";
}
```

Phalcon使用魔法的方法，`__set` / `__get` / `__call` 来存储或检索相关数据使用关系。

通过访问属性与关系相同的名称将检索其相关的记录。

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst();

// All the related records in RobotsParts
$robotsParts = $robot->robotsParts;
```

此外，您可以使用魔术方法的 getter:

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

如果被调用的方法已 `get` prefix `Phalcon\Mvc\Model` 将返回 `findFirst()` `find()` 导致。 下面的示例检索相关的结果使用魔法的方法与无：

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

前缀`get`用于`find()`/`findFirst()`相关记录。取决于它将使用的关系类型< 0 >find()< / 0 >或< 0 > findFirst()< / 0 >:

| 类型               | Description                         | 隐式方法        |
| ---------------- | ----------------------------------- | ----------- |
| Belongs-To       | 直接返回相关记录的模型实例                       | findFirst() |
| Has-One          | 直接返回相关记录的模型实例                       | findFirst   |
| Has-Many         | 返回引用模型的模型实例的集合                      | find        |
| Has-Many-to-Many | 返回一个集合的引用模型的模型实例，它隐式对 '内部联接' 所涉及的模型 | （复杂的查询）     |

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

既然两者关系指向相同的模型 （Robots） 获得的记录相关的关系不能被清除:

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

通过映射，我们可以很容易地得到相关的记录：

```php
<?php

$robotsSimilar = RobotsSimilar::findFirst();

// Returns the related record based on the column (robots_id)
$robot = $robotsSimilar->getRobot();
$robot = $robotsSimilar->robot;

// Returns the related record based on the column (similar_robots_id)
$similarRobot = $robotsSimilar->getSimilarRobot();
$similarRobot = $robotsSimilar->similarRobot;
```

<a name='getters-vs-methods'></a>

#### Magic Getters vs. Explicit methods

大多数具有自动完成功能的ide和编辑器在使用magic getter(方法和属性) 时不能推断出正确的类型。 要克服的您可以使用指定什么神奇的行为是可用的类块帮助 IDE 以产生更好的自动完成功能：

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

## 虚拟外键

默认情况下，关系不像数据库外键，也就是说，如果您尝试在引用的模型中插入/更新值而没有有效值，Phalcon将不会生成验证消息。 通过添加第四个参数，当定义一个关系时，您可以修改此行为。

可以更改RobotsPart模型来演示这个特性:

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

如果您将`belongsTo() 关系修改为外键，它将验证在这些字段中插入/更新的值在被引用的模型上是否具有有效值。 类似地，如果<code>hasMany()`/`hasOne()`被修改，它将验证如果在引用的模型上使用该记录，则不能删除该记录。

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

可以设置一个虚拟的外键允许空值，如下所示：

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

### 级联/限制行动

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

- `Phalcon\Mvc\Model::beforeSave()`
- `Phalcon\Mvc\Model::beforeCreate()`
- `Phalcon\Mvc\Model::beforeUpdate()`

您需要重载 `Phalcon\Mvc\Model::save()` 为此要从内部模型工作。

<a name='operations-over-resultsets'></a>

## 在结果集的操作

如果结果集是由完整对象组成的, 则集是能够对以简单方式获取的记录执行操作:

<a name='updating-related-records'></a>

### 更新相关的记录

不要这样做：

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

不要这样做：

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