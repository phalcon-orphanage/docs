<div class='article-menu'>
  <ul>
    <li>
      <a href="#working-with">使用模型</a> 
      <ul>
        <li>
          <a href="#creating">创建模型</a> 
          <ul>
            <li>
              <a href="#properties-setters-getters">Public properties vs. Setters/Getters</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#records-to-objects">Understanding Records To Objects</a>
        </li>
        <li>
          <a href="#finding-records">查找记录</a> 
          <ul>
            <li>
              <a href="#resultsets">模型结果集</a>
            </li>
            <li>
              <a href="#custom-resultsets">Custom Resultsets</a>
            </li>
            <li>
              <a href="#filters">Filtering Resultsets</a>
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
          <a href="#create-update-records">创建/更新记录</a> 
          <ul>
            <li>
              <a href="#create-update-with-confidence">Create/Update with Confidence</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#delete-records">删除记录</a>
        </li>
        <li>
          <a href="#hydration-modes">Hydration Modes</a>
        </li>
        <li>
          <a href="#table-prefixes">Table prefixes</a>
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

模型表示的信息 （数据） 的应用程序和规则来操作这些数据。 Models are primarily used for managing the rules of interaction with a corresponding database table. 在大多数情况下，每个数据库中的表将对应于在应用程序中的一个模型。 您的应用程序的业务逻辑的大部分将集中在模型。

`Phalcon\Mvc\Model` 是一个Phalcon应用程序中的所有模型的基础。 It provides database independence, basic CRUD functionality, advanced finding capabilities, and the ability to relate models to one another, among other services. `Phalcon\Mvc\Model` 避免了不得不使用 SQL 语句，因为它意味着方法动态地向各自的数据库引擎操作的需要。

<div class="alert alert-warning">
    <p>
        Models are intended to work with the database on a high layer of abstraction. If you need to work with databases at a lower level check out the <a href="/[[language]]/[[version]]/api/Phalcon_Db">Phalcon\Db</a> component documentation.
    </p>
</div>

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

<div class="alert alert-warning">
    <p>
        如果您使用的 PHP 5.4/5.5 建议您声明使为了节省内存，减少内存分配模型的一部分的每一列。
    </p>
</div>

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

Models can be implemented public properties, meaning that each property can be read/updated from any part of the code that has instantiated that model class:

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

<div class="alert alert-warning">
    <p>
        当使用 getter 和 setter，下划线属性名称中的可能有问题。
    </p>
</div>

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

<div class="alert alert-warning">
    <p>
        If you want find record by external data (such as user input) or variable data you must use <a href="#binding-parameters">Binding Parameters</a>
    </p>
</div>

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

`Find （）` 和 `findFirst()` 方法接受一个关联数组，指定的搜索条件：

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

| 参数            | 描述                                                                                                                                          | 示例                                                                   |
| ------------- | ------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------- |
| `conditions`  | 查找操作的搜索条件。 用于提取只有那些满足指定的条件的记录。 默认情况下 `Phalcon\Mvc\Model` 假定第一个参数是的条件。                                                                     | `'conditions' => "name LIKE 'steve%'"`                            |
| `columns`     | Return specific columns instead of the full columns in the model. When using this option an incomplete object is returned.                  | `'columns' => 'id, name'`                                         |
| `bind`        | Bind is used together with options, by replacing placeholders and escaping values thus increasing security.                                 | `'bind' => ['status' => 'A', 'type' => 'some-time']`        |
| `bindTypes`   | When binding parameters, you can use this parameter to define additional casting to the bound parameters increasing even more the security. | `'bindTypes' => [Column::BIND_PARAM_STR, Column::BIND_PARAM_INT]` |
| `order`       | 用来对结果集进行排序。使用以逗号分隔的一个或多个字段。                                                                                                                 | `'order' => 'name DESC, status'`                                  |
| `limit`       | Limit the results of the query to results to certain range.                                                                                 | `'limit' => 10`                                                   |
| `offset`      | Offset the results of the query by a certain amount.                                                                                        | `'offset' => 5`                                                   |
| `group`       | Allows to collect data across multiple records and group the results by one or more columns.                                                | `'group' => 'name, status'`                                       |
| `for_update`  | With this option, `Phalcon\Mvc\Model` reads the latest available data, setting exclusive locks on each row it reads.                      | `'for_update' => true`                                            |
| `shared_lock` | With this option, `Phalcon\Mvc\Model` reads the latest available data, setting shared locks on each row it reads.                         | `'shared_lock' => true`                                           |
| `cache`       | Cache the resultset, reducing the continuous access to the relational system.                                                               | `'cache' => ['lifetime' => 3600, 'key' => 'my-find-key']`   |
| `hydration`   | Sets the hydration strategy to represent each returned record in the result.                                                                | `'hydration' => Resultset::HYDRATE_OBJECTS`                       |

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

The static method `query()` returns a `Phalcon\Mvc\Model\Criteria` object that is friendly with IDE autocompleters.

All the queries are internally handled as [PHQL](/[[language]]/[[version]]/db-phql) queries. PHQL is a high-level, object-oriented and SQL-like language. 这种语言为您提供了更多的功能来执行查询像加入其他模型，定义分组，添加聚合等。

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

While `findFirst()` returns directly an instance of the called class (when there is data to be returned), the `find()` method returns a `Phalcon\Mvc\Model\Resultset\Simple`. 这是一个对象，封装所有结果集有像遍历、 寻求特定记录、 计数等功能。

这些对象是比标准数组更强大。 One of the greatest features of the `Phalcon\Mvc\Model\Resultset` is that at any time there is only one record in memory. 这大大有助于在内存管理，特别是处理大量数据时。

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

With custom resultsets, you no longer need to do that. 自定义结果集将封装的功能，否则为会在模型中，可以通过其他的模型，从而保持 [DRY](https://en.wikipedia.org/wiki/Don%27t_repeat_yourself) 的代码重用。 This way, the `find()` method will no longer return the default `Phalcon\Mvc\Model\Resultset`, but instead the custom one. Phalcon allows you to do this by using the `getResultsetClass()` in your model.

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

<div class="alert alert-warning">
    <p>
        Since the default bind-type is <code>Phalcon\Db\Column::BIND_PARAM_STR</code>, there is no need to specify the <code>bindTypes</code> parameter if all of the columns are of that type.
    </p>
</div>

如果您在绑定参数绑定数组，请牢记，编号为键的同时，还必须从零：

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

<div class="alert alert-warning">
    <p>
        绑定的参数，供所有查询方法 <code>find （）</code> 和 <code>findFirst()</code> 等，但也像 <code>count （）</code>，<code>sum （）</code>，<code>average()</code> 等的计算方法。
    </p>
</div>

If you're using "finders" e.g. `find()`, `findFirst()`, etc., bound parameters are automatically used:

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

如果你使用而不是 getter/setter / 或公共的属性，你可以初始化字段一旦访问它：

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

`Phalcon\Mvc\Model::save()` 方法允许您创建并更新记录是否已经存在与模型关联的表中。 The `save()` method is called internally by the `create` and `update` methods of `Phalcon\Mvc\Model`. For this to work as expected it is necessary to have properly defined a primary key in the entity to determine whether a record should be updated or created.

Also the method executes associated validators, virtual foreign keys and events that are defined in the model:

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

An array could be passed to `save` to avoid assign every column manually. `Phalcon\Mvc\Model` will check if there are setters implemented for the columns passed in the array giving priority to them instead of assign directly the values of the attributes:

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

Values assigned directly or via the array of attributes are escaped/sanitized according to the related attribute data type. 所以你可以传递一个不安全的数组，而不用担心可能的 SQL 注入：

```php
<?php

use Store\Toys\Robots;

$robot = new Robots();

$robot->save($_POST);
```

<div class="alert alert-warning">
    <p>
        Without precautions mass assignment could allow attackers to set any database column's value. Only use this feature if you want to permit a user to insert/update every column in the model, even if those fields are not in the submitted form.
    </p>
</div>

You can set an additional parameter in `save` to set a whitelist of fields that only must taken into account when doing the mass assignment:

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

当应用程序有很多的竞争时，我们可以期待创建记录，但它实际上更新。 如果我们使用 `Phalcon\Mvc\Model::save()` 来保留数据库中的记录，这可能发生。 If we want to be absolutely sure that a record is created or updated, we can change the `save()` call with `create()` or `update()`:

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

The methods `create` and `update` also accept an array of values as parameter.

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

You can also delete many records by traversing a resultset with a `foreach`:

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
| Deleting | afterDelete  |    No    | 运行删除操作后    |
| Deleting | beforeDelete |   Yes    | 在做删除操作之前运行 |

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

Hydration mode can also be passed as a parameter of `find`:

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

## Table prefixes

If you want all your tables to have certain prefix and without setting source in all models you can use the `Phalcon\Mvc\Model\Manager` and the method `setModelPrefix()`:

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
echo $robots->getSource(); // will return wp_robots
```

<a name='identity-columns'></a>

## Auto-generated identity columns

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

## Skipping Columns

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

This will ignore globally these fields on each `INSERT`/`UPDATE` operation on the whole application. If you want to ignore different attributes on different `INSERT`/`UPDATE` operations, you can specify the second parameter (boolean) - `true` for replacement. Forcing a default value can be done as follows:

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

<div class="alert alert-danger">
    <p>
        Never use a <a href="/[[language]]/[[version]]/api/Phalcon_Db_RawValue">Phalcon\Db\RawValue</a> to assign external data (such as user input) or variable data. 将参数绑定到查询时，将忽略这些字段的值。 所以它可以用于攻击注入 SQL 的应用程序。
    </p>
</div>

<a name='dynamic-updates'></a>

## Dynamic Updates

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

## Independent Column Mapping

The ORM supports an independent column map, which allows the developer to use different column names in the model to the ones in the table. Phalcon will recognize the new column names and will rename them accordingly to match the respective columns in the database. This is a great feature when one needs to rename fields in the database without having to worry about all the queries in the code. A change in the column map in the model will take care of the rest. For example:

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

* 对relationships/validators的属性的引用必须使用新的名称
* 请参阅名称将导致异常的 ORM 的实列

独立的列映射，您可以：

* 编写应用程序使用您自己的约定
* 消除供应商的前缀后缀，可在您的代码
* 更改列名称不改变应用程序代码

<a name='record-snapshots'></a>

## Record Snapshots

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

When activating this feature the application consumes a bit more of memory to keep track of the original values obtained from the persistence. In models that have this feature activated you can check what fields changed as follows:

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

Snapshots are updated on model creation/update. Using `hasUpdated()` and `getUpdatedFields()` can be used to check if fields were updated after a create/save/update but it could potentially cause problems to your application if you execute `getChangedFields()` in `afterUpdate()`, `afterSave()` or `afterCreate()`.

You can disable this functionality by using:

```php
Phalcon\Mvc\Model::setup(
    [
        'updateSnapshotOnSave' => false,
    ]
);
```

or if you prefer set this in your `php.ini`

```ini
phalcon.orm.update_snapshot_on_save = 0
```

Using this functionality will have the following effect:

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

On Phalcon 3.1.0 and later it is:

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

`getUpdatedFields()` will properly return updated fields or as mentioned above you can go back to the previous behavior by setting the relevant ini value.

<a name='different-schemas'></a>

## Pointing to a different schema

If a model is mapped to a table that is in a different schemas/databases than the default. You can use the `setSchema()` method to define that:

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

The `selectReadConnection()` method is called to choose the right connection, this method intercepts any new query executed:

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

The `notSaved` event is triggered every time that a `create` or `update` action fails. So we're flashing the validation messages obtaining the `flash` service from the DI container. By doing this, we don't have to print messages after each save.

<a name='disabling-enabling-features'></a>

## Disabling/Enabling Features

In the ORM we have implemented a mechanism that allow you to enable/disable specific features or options globally on the fly. According to how you use the ORM you can disable that you aren't using. These options can also be temporarily disabled if required:

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

| 选项                    | 描述                                                                                        |   默认    |
| --------------------- | ----------------------------------------------------------------------------------------- |:-------:|
| astCache              | Enables/Disables callbacks, hooks and event notifications from all the models             | `null`  |
| cacheLevel            | Sets the cache level for the ORM                                                          |   `3`   |
| castOnHydrate         |                                                                                           | `false` |
| columnRenaming        | Enables/Disables the column renaming                                                      | `true`  |
| disableAssignSetters  | Allow disabling setters in your model                                                     | `false` |
| enableImplicitJoins   |                                                                                           | `true`  |
| enableLiterals        |                                                                                           | `true`  |
| escapeIdentifiers     |                                                                                           | `true`  |
| events                | Enables/Disables callbacks, hooks and event notifications from all the models             | `true`  |
| exceptionOnFailedSave | Enables/Disables throwing an exception when there is a failed `save()`                    | `false` |
| forceCasting          |                                                                                           | `false` |
| ignoreUnknownColumns  | Enables/Disables ignoring unknown columns on the model                                    | `false` |
| lateStateBinding      | Enables/Disables late state binding of the `Phalcon\Mvc\Model::cloneResultMap()` method | `false` |
| notNullValidations    | The ORM automatically validate the not null columns present in the mapped table           | `true`  |
| parserCache           |                                                                                           | `null`  |
| phqlLiterals          | Enables/Disables literals in the PHQL parser                                              | `true`  |
| uniqueCacheId         |                                                                                           |   `3`   |
| updateSnapshotOnSave  | Enables/Disables updating snapshots on `save()`                                           | `true`  |
| virtualForeignKeys    | Enables/Disables the virtual foreign keys                                                 | `true`  |

<div class="alert alert-warning">
    <p>
        <strong>NOTE</strong> <code>Phalcon\Mvc\Model::assign()</code> (which is used also when creating/updating/saving model) is always using setters if they exist when have data arguments passed, even when it's required or necessary. This will add some additional overhead to your application. You can change this behavior by adding <code>phalcon.orm.disable_assign_setters = 1</code> to your ini file, it will just simply use <code>$this->property = value</code>.
    </p>
</div>

<a name='stand-alone-component'></a>

## Stand-Alone component

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