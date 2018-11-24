<div class='article-menu'>
  <ul>
    <li>
      <a href="#working-with">使用模型</a> <ul>
        <li>
          <a href="#creating">创建模型</a> <ul>
            <li>
              <a href="#properties-setters-getters">公共属性 vs. Setter/getter 方法</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#records-to-objects">理解对象的记录</a>
        </li>
        <li>
          <a href="#finding-records">查找记录</a> <ul>
            <li>
              <a href="#resultsets">模型结果集</a>
            </li>
            <li>
              <a href="#filters">筛选结果集</a>
            </li>
            <li>
              <a href="#binding-parameters">Binding Parameters</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#preparing-records">初始化/准备读取的记录</a>
        </li>
        <li>
          <a href="#calculations">生成的计算</a>
        </li>
        <li>
          <a href="#create-update-records">创建/更新记录</a> <ul>
            <li>
              <a href="#create-update-with-confidence">创建和更新的完整</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#delete-records">删除记录</a>
        </li>
        <li>
          <a href="#hydration-modes">水化模型</a>
        </li>
        <li>
          <a href="#identity-columns">自动生成的标识列</a>
        </li>
        <li>
          <a href="#skipping-columns">跳过列</a>
        </li>
        <li>
          <a href="#dynamic-updates">动态更新</a>
        </li>
        <li>
          <a href="#column-mapping">独立列映射</a>
        </li>
        <li>
          <a href="#record-snapshots">记录快照</a>
        </li>
        <li>
          <a href="#different-schemas">指向一个不同的架构</a>
        </li>
        <li>
          <a href="#multiple-databases">设置多个数据库</a>
        </li>
        <li>
          <a href="#injecting-services-into-models">服务注入模型</a>
        </li>
        <li>
          <a href="#disabling-enabling-features">禁用/启用的功能</a>
        </li>
        <li>
          <a href="#stand-alone-component">独立组件</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='working-with'></a>

# 使用模型

模型表示的信息 （数据） 的应用程序和规则来操作这些数据。 模型主要用于管理与相应数据库表的交互规则。 在大多数情况下，每个数据库中的表将对应于在应用程序中的一个模型。 您的应用程序的业务逻辑的大部分将集中在模型。

`Phalcon\Mvc\Model` 是一个Phalcon应用程序中的所有模型的基类。 它提供了基本的数据库独立性CRUD功能、高级查找功能以及将模型与其他服务关联起来的能力。 `Phalcon\Mvc\Model` 避免了不得不使用 SQL 语句，因为它意味着方法动态地向各自的数据库引擎操作的需要。

<h5 class='alert alert-warning'>模型的目的是在抽象层上与数据库一起工作。如果需要在较低级别使用数据库，请查看<code>Phalcon\Db</code>组件文档。</h5>

<a name='creating'></a>

## 创建模型

模型是一个类，继承 `Phalcon\Mvc\Model` 。其类名称应为驼峰法：

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class RobotParts extends Model
{

}
```

<h5 class='alert alert-warning'>如果您使用的 PHP 5.4/5.5 建议您声明使为了节省内存，减少内存分配模型的一部分的每一列。 </h5>

默认情况下，该模型 `Store\Toys\RobotParts` 将映射到表 `robot_parts`。 如果你想要手动指定映射表的另一个名称，您可以使用 `setSource()` 方法：

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

该模型 `RobotParts` 现在映射到 `toys_robot_parts` 表。`Initialize()` 方法帮助建立这个模型的自定义行为即一个不同的表。

在请求期间一次只调用 `initialize()` 方法。 此方法用于执行初始化，则适用的所有实例的应用程序中创建的模型。 如果您想要创建的每个实例执行初始化任务你可以使用 `onConstruct()` 方法：

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

### 公共属性 与 Setter/getter 方法

模型可以实现公共属性，这意味着每个属性都可以从实例化模型类的代码的任何部分读取/更新:

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

另一个实现是使用 getter 和 setter 函数，控制哪些属性是公开可用于该模型。 使用 getter 和 setter 的好处是，开发人员可以执行转换和验证检查为模型，这是不可能的当使用公共属性设置的值。 另外 getter 和 setter 允许将来的更改而无需更改模型的类的接口。 所以如果一个字段名称发生了变化，唯一的改变所需也会在模型中相关的 getter/setter 和无处可在代码中引用的私有财产。

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
        // The name is too short?
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
        // Negative prices aren't allowed
        if ($price < 0) {
            throw new InvalidArgumentException(
                "Price can't be negative"
            );
        }

        $this->price = $price;
    }

    public function getPrice()
    {
        // Convert the value to double before be used
        return (double) $this->price;
    }
}
```

公共属性提供在发展中的复杂程度较低。 然而 getter/setter 可以大大提高可测试性、 可扩展性和可维护性的应用程序。 开发人员可以决定哪一种策略是更适合他们正在创建，具体取决于应用程序的需要的应用。 ORM 是符合这两项计划的定义属性。

<h5 class='alert alert-warning'>当使用 getter 和 setter，下划线属性名称中的可能有问题。 </h5>

如果你在你的属性名称中使用下划线，你必须仍然 camel 大小写你的 getter/setter 在声明中使用用于与神奇的方法。 (e.g. `$model->getPropertyName` instead of `$model->getProperty_name`, `$model->findByPropertyName` instead of `$model->findByProperty_name`, etc.). 由于大部分的系统预计 camel 大小写，并且通常删除下划线，它建议来命名您的属性显示整个文档的方式。 你可以使用列映射 （如上文所述） 以确保您的属性与数据库的同行的正确映射。

<a name='records-to-objects'></a>

## Understanding Records To Objects

模型的每个实例表示表中的一行。通过阅读对象属性，您可以轻松访问记录数据。例如，对于一个表 '机器人' 的记录：

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

你可以按其主键查找某个记录，然后打印它的名字：

```php
<?php

use Store\Toys\Robots;

// Find record with id = 3
$robot = Robots::findFirst(3);

// Prints 'Terminator'
echo $robot->name;
```

一旦该记录是在内存中，可以对其数据进行修改，然后保存更改：

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst(3);

$robot->name = 'RoboCop';

$robot->save();
```

正如你所看到的那里是没有需要使用原始 SQL 语句。`Phalcon\Mvc\Model` 提供高数据库抽象为 web 应用程序。

<a name='finding-records'></a>

## 查找记录

`Phalcon\Mvc\Model` 还提供查询记录的几种方法。下面的示例将显示你如何查询模型中的一个或多个记录：

```php
<?php

use Store\Toys\Robots;

// How many robots are there?
$robots = Robots::find();
echo 'There are ', count($robots), "\n";

// How many mechanical robots are there?
$robots = Robots::find("type = 'mechanical'");
echo 'There are ', count($robots), "\n";

// Get and print virtual robots ordered by name
$robots = Robots::find(
    [
        "type = 'virtual'",
        'order' => 'name',
    ]
);
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

// Get first 100 virtual robots ordered by name
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

<h5 class='alert alert-warning'>如果你想要查找的外部数据 （如用户输入） 或变量的数据，您必须使用 <a href="#binding-parameters">绑定参数</a> 的记录 '。</h5>

你也可以使用 `findFirst()` 方法去只匹配给定的条件的第一个记录：

```php
<?php

use Store\Toys\Robots;

// 机器人表的第一个机器人
$robot = Robots::findFirst();
echo 'The robot name is ', $robot->name, "\n";

// What's the first mechanical robot in robots table?
$robot = Robots::findFirst("type = 'mechanical'");
echo 'The first mechanical robot name is ', $robot->name, "\n";

// Get first virtual robot ordered by name
$robot = Robots::findFirst(
    [
        "type = 'virtual'",
        'order' => 'name',
    ]
);

echo 'The first virtual robot name is ', $robot->name, "\n";
```

`Find()` 和 `findFirst()` 方法接受一个关联数组，指定的搜索条件：

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

可用的查询选项有：

| 参数            | 描述                                                                      | 示例                                                                   |
| ------------- | ----------------------------------------------------------------------- | -------------------------------------------------------------------- |
| `conditions`  | 查找操作的搜索条件。 用于提取只有那些满足指定的条件的记录。 默认情况下 `Phalcon\Mvc\Model` 假定第一个参数是的条件。 | `'conditions' => "name LIKE 'steve%'"`                            |
| `columns`     | 返回模型中的特定列而不是全部的列。使用此选项时返回不完整的对象                                         | `'columns' => 'id, name'`                                         |
| `bind`        | 绑定选项，并替换占位符和使用转义值从而增加安全                                                 | `'bind' => ['status' => 'A', 'type' => 'some-time']`        |
| `bindTypes`   | 在绑定参数时，可以使用此参数定义绑定参数的附加类型，从而增加安全性                                       | `'bindTypes' => [Column::BIND_PARAM_STR, Column::BIND_PARAM_INT]` |
| `order`       | 用来对结果集进行排序。使用以逗号分隔的一个或多个字段。                                             | `'order' => 'name DESC, status'`                                  |
| `limit`       | 限制结果缩小到一定范围内查询的结果                                                       | `'limit' => 10`                                                   |
| `offset`      | 只查询结构的多少条                                                               | `'offset' => 5`                                                   |
| `group`       | 允许跨多个记录收集数据，并按一个或多个列进行分组结果                                              | `'group' => 'name, status'`                                       |
| `for_update`  | 使用此选项，`Phalcon\Mvc\Model` 读取最新的可用数据，它读取的每一行上设置排它锁                     | `'for_update' => true`                                            |
| `shared_lock` | 使用此选项，`Phalcon\Mvc\Model` 读取最新的可用数据，它读取的每一行上设置共享的锁                    | `'shared_lock' => true`                                           |
| `cache`       | 缓存的结果集，减少连续访问关系型系统                                                      | `'cache' => ['lifetime' => 3600, 'key' => 'my-find-key']`   |
| `hydration`   | 设置hydration 来表示每个返回的记录的结果                                               | `'hydration' => Resultset::HYDRATE_OBJECTS`                       |

如果你喜欢，也是在一种面向对象的方式，而不是使用一个数组参数中可用一个方法来创建查询：

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

静态方法 `query()` 返回一个 `Phalcon\Mvc\Model\Criteria` 对象，是友好与 IDE autocompleters。

所有查询都被内部处理为[PHQL](/[[language]]/[[version]]/db-phql)查询。 PHQL 是一种高级的、 面向对象的类似 SQL 的语言。 这种语言为您提供了更多的功能来执行查询像加入其他模型，定义分组，添加聚合等。

最后，是 `findFirstBy<property-name>()` 方法。 此方法扩展前面提到的 `findFirst()` 方法。 它允许您快速使用属性名称方法本身从表执行检索和传递给它的参数，其中包含的数据要在该列中搜索。 An example is in order, so taking our Robots model mentioned earlier:

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

我们都要在这里工作的三个属性： `$id`、 `$name` 和 `$price`。 所以，让我们说你想要检索 'Terminator' 的名称与表中的第一个记录。 这可以像编写：

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

请注意我们在方法调用中使用的名称和传递变量 `$name` 给它，其中包含我们正在寻找我们的表中的名称。 此外请注意，当我们与我们的查询找到匹配项，所有其他属性是提供给我们的。

<a name='resultsets'></a>

### 模型结果集

虽然 `findFirst()` 直接返回被调用的类的一个实例 （当要返回的数据），`find()` 方法返回 `Phalcon\Mvc\Model\Resultset\Simple`。 这是一个对象，封装所有结果集有像遍历、 寻求特定记录、 计数等功能。

这些对象是比标准数组更强大。 :doc: `Phalcon\Mvc\Model\Resultset` 最大的特点之一是，其实在任何时候内存是只有一条记录。 这大大有助于在内存管理，特别是处理大量数据时。

```php
<?php

use Store\Toys\Robots;

// Get all robots
$robots = Robots::find();

// Traversing with a foreach
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

// Traversing with a while
$robots->rewind();

while ($robots->valid()) {
    $robot = $robots->current();

    echo $robot->name, "\n";

    $robots->next();
}

// Count the resultset
echo count($robots);

// Alternative way to count the resultset
echo $robots->count();

// Move the internal cursor to the third robot
$robots->seek(2);

$robot = $robots->current();

// Access a robot by its position in the resultset
$robot = $robots[5];

// Check if there is a record in certain position
if (isset($robots[3])) {
   $robot = $robots[3];
}

// Get the first record in the resultset
$robot = $robots->getFirst();

// Get the last record
$robot = $robots->getLast();
```

Phalcon的结果集模拟可滚动游标，你可以得到任何行只是通过访问它的位置，或寻求内部的指针指向一个特定的位置。 请注意，某些数据库系统不支持可滚动游标，这会强制重新执行查询以倒带将光标移动到开始并获得所请求的位置处的记录。 同样，如果结果集遍历几次，查询必须执行相同的次数。

As storing large query results in memory could consume many resources, resultsets are obtained from the database in chunks of 32 rows - reducing the need to re-execute the request in several cases.

请注意结果集可以被序列化并存储在缓存后端。 `Phalcon\Cache` 可以帮助完成该任务。 然而，序列化数据原因 `Phalcon\Mvc\Model` 从数组中的数据库中检索所有数据，因此消耗更多的内存，在这一过程同时发生。

```php
<?php

// Query all records from model parts
$parts = Parts::find();

// Store the resultset into a file
file_put_contents(
    'cache.txt',
    serialize($parts)
);

// Get parts from file
$parts = unserialize(
    file_get_contents('cache.txt')
);

// Traverse the parts
foreach ($parts as $part) {
    echo $part->id;
}
```

<a name='custom-resultsets'></a>

### 自定义结果集

有的应用程序逻辑需要额外的操作的数据，因为它从数据库中检索。 以前，我们只是将扩展模型，封装在类中的模型或特征，功能将返回到调用方通常数组转换后的数据。

有了自定义结果集，你不再需要这样做。 自定义结果集将封装的功能，否则为会在模型中，可以通过其他的模型，从而保持 [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself) 的代码重用。 这种方式，`find()` 方法将不再返回默认的 `Phalcon\Mvc\Model\Resultset`，而是自定义一个。 Phalcon allows you to do this by using the `getResultsetClass()` in your model.

首先，我们需要定义的结果集类：

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

在模型中，我们设置了 `getResultsetClass()` 中的类如下：

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

和最后在您的代码中你会有这样的事情：

```php
<?php

/**
 * Find the robots 
 */
$robots = Robots::find(
    [
        'conditions' => 'date between "2017-01-01" AND "2017-12-31"',
        'order'      => 'date'
    ]
);

/**
 * Pass the data to the view
 */
$this->view->mydata = $robots->getSomeData();
```

<a name='filters'></a>

### 筛选结果集

筛选数据的最有效途径设置一些搜索条件，数据库将使用索引在表上设置数据更快地返回。 Phalcon另外允许您筛选数据使用 PHP 使用不是数据库中可用的任何资源：

```php
<?php

$customers = Customers::find();

$customers = $customers->filter(
    function ($customer) {
        // Return only customers with a valid e-mail
        if (filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
            return $customer;
        }
    }
);
```

<a name='binding-parameters'></a>

### Binding Parameters

在 `Phalcon\Mvc\Model` 也支持绑定的参数。 你被鼓励使用此方法，以消除您的代码受到 SQL 注入式攻击的可能性。 支持字符串和整数的占位符。 绑定参数可以简单地实现，如下所示：

```php
<?php

use Store\Toys\Robots;

// Query robots binding parameters with string placeholders
// Parameters whose keys are the same as placeholders
$robots = Robots::find(
    [
        'name = :name: AND type = :type:',
        'bind' => [
            'name' => 'Robotina',
            'type' => 'maid',
        ],
    ]
);

// Query robots binding parameters with integer placeholders
$robots = Robots::find(
    [
        'name = ?1 AND type = ?2',
        'bind' => [
            1 => 'Robotina',
            2 => 'maid',
        ],
    ]
);

// Query robots binding parameters with both string and integer placeholders
// Parameters whose keys are the same as placeholders
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

当使用数字占位符，您将需要将它们定义为即 `1` 或 `2` 的整数。 在这种情况下 `'1'` 或 `'2'` 是考虑的字符串而不是数字，所以该占位符不能被成功替换。

字符串是使用 [PDO](http://php.net/manual/en/pdo.prepared-statements.php) 自动转义的。 此函数还考虑连接字符集，其建议以定义正确的字符集中的数据库配置，作为错误的字符集或在连接参数中会产生意外的影响，在存储或检索数据时。

Additionally you can set the parameter `bindTypes`, this allows defining how the parameters should be bound according to its data type:

```php
<?php

use Phalcon\Db\Column;
use Store\Toys\Robots;

// Bind parameters
$parameters = [
    'name' => 'Robotina',
    'year' => 2008,
];

// Casting Types
$types = [
    'name' => Column::BIND_PARAM_STR,
    'year' => Column::BIND_PARAM_INT,
];

// Query robots binding parameters with string placeholders
$robots = Robots::find(
    [
        'name = :name: AND year = :year:',
        'bind'      => $parameters,
        'bindTypes' => $types,
    ]
);
```

<h5 class='alert alert-warning'>由于默认的绑定类型是 <code>Phalcon\Db\Column::BIND_PARAM_STR</code>，还有没有必要指定 'bindTypes' 参数，如果所有的列都是该类型。</h5>

如果您在绑定参数绑定数组，请牢记，编号为键的同时，还必须从零开始：

```php
<?php

use Store\Toys\Robots;

$array = ['a','b','c']; // $array: [[0] => 'a', [1] => 'b', [2] => 'c']

unset($array[1]); // $array: [[0] => 'a', [2] => 'c']

// Now we have to renumber the keys
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

<h5 class='alert alert-warning'>绑定的参数，供所有查询方法 <code>find （）</code> 和 <code>findFirst()</code> 等，但也像 <code>count （）</code>，<code>sum （）</code>，<code>average()</code> 等的计算方法。 </h5>

如果您使用的 'finders'，自动使用绑定的参数：

```php
<?php

use Store\Toys\Robots;

// Explicit query using bound parameters
$robots = Robots::find(
    [
        'name = ?0',
        'bind' => [
            'Ultron',
        ],
    ]
);

// Implicit query using bound parameters
$robots = Robots::findByName('Ultron');
```

<a name='preparing-records'></a>

## 初始化/准备读取的记录

可能是从数据库获取记录后有必要在正在使用的应用程序的其余部分之前初始化数据的情况。 您可以在模型中实现的 `afterFetch()` 方法，此事件将只是后执行创建实例并将数据分配给它：

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
        // Convert the array into a string
        $this->status = join(',', $this->status);
    }

    public function afterFetch()
    {
        // Convert the string to an array
        $this->status = explode(',', $this->status);
    }

    public function afterSave()
    {
        // Convert the string to an array
        $this->status = explode(',', $this->status);
    }
}
```

如果您使用getter /setter而不是/或与公共属性一起使用，您可以在访问字段时初始化它:

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

## 生成的计算

为常用功能的数据库系统，如 `COUNT`、 `SUM`、 `MAX`、 `MIN` 或 `AVG` 佣工是计算 （或聚合）。 `Phalcon\Mvc\Model` 允许使用这些函数直接从已公开的方法。

计数的例子：

```php
<?php

// How many employees are?
$rowcount = Employees::count();

// How many different areas are assigned to employees?
$rowcount = Employees::count(
    [
        'distinct' => 'area',
    ]
);

// How many employees are in the Testing area?
$rowcount = Employees::count(
    'area = 'Testing''
);

// Count employees grouping results by their area
$group = Employees::count(
    [
        'group' => 'area',
    ]
);
foreach ($group as $row) {
   echo 'There are ', $row->rowcount, ' in ', $row->area;
}

// Count employees grouping by their area and ordering the result by count
$group = Employees::count(
    [
        'group' => 'area',
        'order' => 'rowcount',
    ]
);

// Avoid SQL injections using bound parameters
$group = Employees::count(
    [
        'type > ?0',
        'bind' => [
            $type
        ],
    ]
);
```

求和的例子：

```php
<?php

// How much are the salaries of all employees?
$total = Employees::sum(
    [
        'column' => 'salary',
    ]
);

// How much are the salaries of all employees in the Sales area?
$total = Employees::sum(
    [
        'column'     => 'salary',
        'conditions' => "area = 'Sales'",
    ]
);

// Generate a grouping of the salaries of each area
$group = Employees::sum(
    [
        'column' => 'salary',
        'group'  => 'area',
    ]
);
foreach ($group as $row) {
   echo 'The sum of salaries of the ', $row->area, ' is ', $row->sumatory;
}

// Generate a grouping of the salaries of each area ordering
// salaries from higher to lower
$group = Employees::sum(
    [
        'column' => 'salary',
        'group'  => 'area',
        'order'  => 'sumatory DESC',
    ]
);

// Avoid SQL injections using bound parameters
$group = Employees::sum(
    [
        'conditions' => 'area > ?0',
        'bind'       => [
            $area
        ],
    ]
);
```

平均数的例子：

```php
<?php

// What is the average salary for all employees?
$average = Employees::average(
    [
        'column' => 'salary',
    ]
);

// What is the average salary for the Sales's area employees?
$average = Employees::average(
    [
        'column'     => 'salary',
        'conditions' => "area = 'Sales'",
    ]
);

// Avoid SQL injections using bound parameters
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

最大/最小的例子：

```php
<?php

// What is the oldest age of all employees?
$age = Employees::maximum(
    [
        'column' => 'age',
    ]
);

// What is the oldest of employees from the Sales area?
$age = Employees::maximum(
    [
        'column'     => 'age',
        'conditions' => "area = 'Sales'",
    ]
);

// What is the lowest salary of all employees?
$salary = Employees::minimum(
    [
        'column' => 'salary',
    ]
);
```

<a name='create-update-records'></a>

## 创建/更新记录

`Phalcon\Mvc\Model::save()` 方法允许您创建并更新记录是否已经存在与模型关联的表中。 保存方法由 `Phalcon\Mvc\Model` 的创建和更新方法内部调用。 要使其正常工作，必须在实体中正确定义主键，以确定是否应该更新或创建记录。

该方法还执行相关的验证器、虚拟外键和模型中定义的事件:

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

可以将数组传递给`save`，以避免手动分配每个列。 `Phalcon\Mvc\Model`将检查数组中传递的列是否实现了赋优先级的setter，而不是直接赋值属性:

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

根据相关的属性数据类型转义/清除直接或通过属性数组分配的值。 所以你可以传递一个不安全的数组，而不用担心可能的 SQL 注入：

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->save($_POST);
```

<h5 class='alert alert-warning'>如果没有预防措施，大规模分配可能允许攻击者设置任何数据库列的值。 仅当您希望允许用户插入/更新模型中的每一列时才使用该特性，即使这些字段不在提交的表单中。 </h5>

您可以在`save`中设置一个额外的参数，以设置一个只有在执行大规模分配时才必须考虑的白名单字段:

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

### Create/Update with Confidence

当应用程序有很多的竞争时，我们可以期待创建记录，但它实际上更新。 如果我们使用 `Phalcon\Mvc\Model::save()` 来保留数据库中的记录，这可能发生。 如果我们想要绝对确定一条记录被创建或更新，我们可以使用`save()` ，使用`create()`或`update()`:

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->type = 'mechanical';
$robot->name = 'Astro Boy';
$robot->year = 1952;

// This record only must be created
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

方法 `create` 和 'update' 也接受一个值数组作为参数。

<a name='delete-records'></a>

## 删除记录

`Phalcon\Mvc\Model::delete()` 方法允许删除一条记录。你可以使用它，如下所示：

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

你还可以通过遍历结果集与 foreach 删除多个记录：

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

以下事件可以用来定义可以执行删除操作时执行的自定义业务规则：

| 操作       | 名称           | 可以停止操作吗？ | 注解         |
| -------- | ------------ |:--------:| ---------- |
| Deleting | beforeDelete |   Yes    | 在做删除操作之前运行 |
| Deleting | afterDelete  |    No    | 运行删除操作后    |

与上述事件还可以定义业务规则的模型：

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

## Hydration Modes

正如前面提到的结果集是完整的对象的集合，这意味着每个返回的结果是一个对象，表示数据库中的行。 这些对象可以修改并再次保存到持久性：

```php
<?php

use Store\Toys\Robots;

$robots = Robots::find();

// Manipulating a resultset of complete objects
foreach ($robots as $robot) {
    $robot->year = 2000;

    $robot->save();
}
```

有时记录可得出只以提交给用户在只读模式下，在这些情况下，它可能是有用的改变，从而记录都代表，以便他们处理的方式。 用来表示在结果集中返回的对象的策略称为'hydration mode':

```php
<?php

use Phalcon\Mvc\Model\Resultset;
use Store\Toys\Robots;

$robots = Robots::find();

// Return every robot as an array
$robots->setHydrateMode(
    Resultset::HYDRATE_ARRAYS
);

foreach ($robots as $robot) {
    echo $robot['year'], PHP_EOL;
}

// Return every robot as a stdClass
$robots->setHydrateMode(
    Resultset::HYDRATE_OBJECTS
);

foreach ($robots as $robot) {
    echo $robot->year, PHP_EOL;
}

// Return every robot as a Robots instance
$robots->setHydrateMode(
    Resultset::HYDRATE_RECORDS
);

foreach ($robots as $robot) {
    echo $robot->year, PHP_EOL;
}
```

Hydration 模式也可以作为 'find' 的参数传递：

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

<a name='identity-columns'></a>

## 自动生成的标识列

Some models may have identity columns. These columns usually are the primary key of the mapped table. `Phalcon\Mvc\Model` can recognize the identity column omitting it in the generated SQL `INSERT`, so the database system can generate an auto-generated value for it. Always after creating a record, the identity field will be registered with the value generated in the database system for it:

```php
<?php

$robot->save();

echo 'The generated id is: ', $robot->id;
```

`Phalcon\Mvc\Model` is able to recognize the identity column. Depending on the database system, those columns may be serial columns like in PostgreSQL or auto_increment columns in the case of MySQL.

PostgreSQL uses sequences to generate auto-numeric values, by default, Phalcon tries to obtain the generated value from the sequence `table_field_seq`, for example: `robots_id_seq`, if that sequence has a different name, the `getSequenceName()` method needs to be implemented:

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

## 跳过列

To tell `Phalcon\Mvc\Model` that always omits some fields in the creation and/or update of records in order to delegate the database system the assignation of the values by a trigger or a default:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function initialize()
    {
        // Skips fields/columns on both INSERT/UPDATE operations
        $this->skipAttributes(
            [
                'year',
                'price',
            ]
        );

        // Skips only when inserting
        $this->skipAttributesOnCreate(
            [
                'created_at',
            ]
        );

        // Skips only when updating
        $this->skipAttributesOnUpdate(
            [
                'modified_in',
            ]
        );
    }
}
```

这将全局忽略每个`INSERT`/`UPDATE`操作对整个应用程序的影响。 如果要忽略不同的不同属性在`INSERT`/`UPDATE`操作，可以指定第二个参数(布尔值)- `true`进行替换。 强制一个默认值可以这样做:

```php
<?php

use Store\Toys\Robots;

use Phalcon\Db\RawValue;

$robot = new Robots();

$robot->name       = 'Bender';
$robot->year       = 1999;
$robot->created_at = new RawValue('default');

$robot->create();
```

A callback also can be used to create a conditional assignment of automatic default values:

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

<h5 class='alert alert-warning'>永远不要使用<code>Phalcon\Db\RawValue</code>分配外部数据(如用户输入) 或变量数据。 将参数绑定到查询时，将忽略这些字段的值。 所以它可以用于攻击注入 SQL 的应用程序。 </h5>

<a name='dynamic-updates'></a>

## 动态更新

SQL `UPDATE` statements are by default created with every column defined in the model (full all-field SQL update). You can change specific models to make dynamic updates, in this case, just the fields that had changed are used to create the final SQL statement.

In some cases this could improve the performance by reducing the traffic between the application and the database server, this specially helps when the table has blob/text fields:

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

## 独立列映射

ORM支持独立的列映射，允许开发人员在模型中使用与表中不同的列名。 Phalcon将识别新的列名，并相应地重新命名它们以匹配数据库中的相应列。 当需要重命名数据库中的字段时，无需担心代码中的所有查询，这是一个很好的特性。 模型中列映射的更改将处理其余部分。 例如：

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
        // Keys are the real names in the table and
        // the values their names in the application
        return [
            'id'       => 'code',
            'the_name' => 'theName',
            'the_type' => 'theType',
            'the_year' => 'theYear',
        ];
    }
}
```

然后可以在代码中自然地使用新的名称：

```php
<?php

use Store\Toys\Robots;

// Find a robot by its name
$robot = Robots::findFirst(
    "theName = 'Voltron'"
);

echo $robot->theName, "\n";

// Get robots ordered by type
$robot = Robots::find(
    [
        'order' => 'theType DESC',
    ]
);

foreach ($robots as $robot) {
    echo 'Code: ', $robot->code, "\n";
}

// Create a robot
$robot = new Robots();

$robot->code    = '10101';
$robot->theName = 'Bender';
$robot->theType = 'Industrial';
$robot->theYear = 2999;

$robot->save();
```

重命名您的列时，请考虑下列事项：

- 对relationships/validators的属性的引用必须使用新的名称
- 引用真实列名将导致ORM异常

独立的列映射，您可以：

- 编写应用程序使用您自己的约定
- 消除供应商的前缀后缀，可在您的代码
- 更改列名称不改变应用程序代码

<a name='record-snapshots'></a>

## 记录快照

Specific models could be set to maintain a record snapshot when they're queried. You can use this feature to implement auditing or just to know what fields are changed according to the data queried from the persistence:

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

在激活该特性时，应用程序会消耗更多的内存来跟踪从持久性中获得的原始值。 已激活此功能的模型中，您可以检查字段，如下所示更改：

```php
<?php

use Store\Toys\Robots;

// Get a record from the database
$robot = Robots::findFirst();

// Change a column
$robot->name = 'Other name';

var_dump($robot->getChangedFields()); // ['name']

var_dump($robot->hasChanged('name')); // true

var_dump($robot->hasChanged('type')); // false
```

<a name='different-schemas'></a>

## 指向一个不同的表

如果模型映射到与默认模式/数据库不同的表。 您可以使用`setSchema()`方法来定义:

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

## 设置多个数据库

In Phalcon, all models can belong to the same database connection or have an individual one. Actually, when `Phalcon\Mvc\Model` needs to connect to the database it requests the `db` service in the application's services container. You can overwrite this service setting it in the `initialize()` method:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql as MysqlPdo;
use Phalcon\Db\Adapter\Pdo\PostgreSQL as PostgreSQLPdo;

// This service returns a MySQL database
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

// This service returns a PostgreSQL database
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

But Phalcon offers you more flexibility, you can define the connection that must be used to `read` and for `write`. This is specially useful to balance the load to your databases implementing a master-slave architecture:

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

The ORM also provides Horizontal Sharding facilities, by allowing you to implement a 'shard' selection according to the current query conditions:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    /**
     * Dynamically selects a shard
     *
     * @param array $intermediate
     * @param array $bindParams
     * @param array $bindTypes
     */
    public function selectReadConnection($intermediate, $bindParams, $bindTypes)
    {
        // Check if there is a 'where' clause in the select
        if (isset($intermediate['where'])) {
            $conditions = $intermediate['where'];

            // Choose the possible shard according to the conditions
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

        // Use a default shard
        return $this->getDI()->get('dbShard0');
    }
}
```

调用 `selectReadConnection()` 方法来选择正确的连接，此方法截取执行任何新查询：

```php
<?php

use Store\Toys\Robots;

$robot = Robots::findFirst('id = 101');
```

<a name='injecting-services-into-models'></a>

## 服务注入模型

You may be required to access the application services within a model, the following example explains how to do that:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function notSaved()
    {
        // Obtain the flash service from the DI container
        $flash = $this->getDI()->getFlash();

        $messages = $this->getMessages();

        // Show validation messages
        foreach ($messages as $message) {
            $flash->error($message);
        }
    }
}
```

每次当`create`或`update`操作失败时，`notSaved`事件被触发。 因此，我们正在从DI容器中获取`flash`服务的验证消息。 通过这样做，我们不需要在每个保存以后打印消息。

<a name='disabling-enabling-features'></a>

## 禁用/启用的功能

在ORM中，我们实现了一种机制，允许您在全局范围内启用/禁用特定的特性或选项。 根据您如何使用ORM，您可以禁用您不使用的ORM。 如果需要，这些选项也可以暂时禁用:

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

可用的查询选项有：

| 选项                 | 描述                                                    |   默认    |
| ------------------ | ----------------------------------------------------- |:-------:|
| events             | 启用/禁用所有模型的回调、钩子和事件通知                                  | `true`  |
| columnRenaming     | 启用/禁用列重命名                                             | `true`  |
| notNullValidations | ORM自动验证映射表中出现的not null列                               | `true`  |
| virtualForeignKeys | 启用/禁用虚拟外键                                             | `true`  |
| phqlLiterals       | 在PHQL解析器中启用/禁用文字                                      | `true`  |
| lateStateBinding   | 启用/禁用`Phalcon\Mvc\Model::cloneResultMap()`方法的延迟状态绑定 | `false` |

<a name='stand-alone-component'></a>

## 独立组件

在独立模式下使用 `Phalcon\Mvc\Model` 可以如下文所示：

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Db\Adapter\Pdo\Sqlite as Connection;
use Phalcon\Mvc\Model\Metadata\Memory as MetaData;

$di = new Di();

// Setup a connection
$di->set(
    'db',
    new Connection(
        [
            'dbname' => 'sample.db',
        ]
    )
);

// Set a models manager
$di->set(
    'modelsManager',
    new ModelsManager()
);

// Use the memory meta-data adapter or other
$di->set(
    'modelsMetadata',
    new MetaData()
);

// Create a model
class Robots extends Model
{

}

// Use the model
echo Robots::count();
```