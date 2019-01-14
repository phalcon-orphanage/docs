* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Phalcon的查询语言 (PHQL)

Phalcon查询语言、PhalconQL或简单的PHQL是一种高级的、面向对象的SQL方言，允许使用标准化的类似SQL的语言编写查询。 PHQL实现为解析器(用C语言编写)，将语法转换为目标RDBMS的语法。

To achieve the highest performance possible, Phalcon provides a parser that uses the same technology as [SQLite](https://en.wikipedia.org/wiki/Lemon_Parser_Generator). 这项技术提供了一个小的内存解析器, 内存占用非常低, 也是线程安全的。

解析器首先检查 pass PHQL 语句的语法, 然后生成语句的中间表示形式, 最后将其转换为目标 rdbms 的相应 sql 方言。

在 PHQL 中, 我们实现了一组功能, 使您对数据库的访问更加安全:

* 绑定参数是 PHQL语言的一部分, 可帮助您保护代码
* PHQL只允许每个调用执行一个 sql 语句, 以防止注入
* PHQL忽略 sql 注入中经常使用的所有 sql 注释
* PHQL只允许数据操作语句, 避免错误地更改或删除表数据库或未经授权在外部更改或删除
* PHQL 实现了一个高级抽象, 允许您将表作为模型处理, 将字段作为类属性处理

<a name='usage'></a>

## 用法示例

为了更好地解释PHQL如何工作，请考虑下面的示例。我们有两个车的模型`Cars`和`Brands`:

```php
<?php

use Phalcon\Mvc\Model;

class Cars extends Model
{
    public $id;

    public $name;

    public $brand_id;

    public $price;

    public $year;

    public $style;

    /**
     * This model is mapped to the table sample_cars
     */
    public function getSource()
    {
        return 'sample_cars';
    }

    /**
     * A car only has a Brand, but a Brand have many Cars
     */
    public function initialize()
    {
        $this->belongsTo('brand_id', 'Brands', 'id');
    }
}
```

每辆车都有一个品牌，所以一个品牌有很多车:

```php
<?php

use Phalcon\Mvc\Model;

class Brands extends Model
{
    public $id;

    public $name;

    /**
     * The model Brands is mapped to the 'sample_brands' table
     */
    public function getSource()
    {
        return 'sample_brands';
    }

    /**
     * A Brand can have many Cars
     */
    public function initialize()
    {
        $this->hasMany('id', 'Cars', 'brand_id');
    }
}
```

<a name='creating'></a>

## 创建 PHQL 查询

PHQL queries can be created just by instantiating the class [Phalcon\Mvc\Model\Query](api/Phalcon_Mvc_Model_Query):

```php
<?php

use Phalcon\Mvc\Model\Query;

// 实例化查询
$query = new Query(
    'SELECT * FROM Cars',
    $this->getDI()
);

// 执行返回任何结果的查询
$cars = $query->execute();
```

From a controller or a view, it's easy to create/execute them using an injected `models manager` ([Phalcon\Mvc\Model\Manager](api/Phalcon_Mvc_Model_Manager)):

```php
<?php

// Executing a simple query
$query = $this->modelsManager->createQuery('SELECT * FROM Cars');
$cars  = $query->execute();

// With bound parameters
$query = $this->modelsManager->createQuery('SELECT * FROM Cars WHERE name = :name:');
$cars  = $query->execute(
    [
        'name' => 'Audi',
    ]
);
```

或者简单地执行:

```php
<?php

// Executing a simple query
$cars = $this->modelsManager->executeQuery(
    'SELECT * FROM Cars'
);

// Executing with bound parameters
$cars = $this->modelsManager->executeQuery(
    'SELECT * FROM Cars WHERE name = :name:',
    [
        'name' => 'Audi',
    ]
);
```

<a name='selecting-records'></a>

## 查询记录

作为熟悉的SQL, PHQL允许使用我们知道的SELECT语句查询记录，除了我们使用模型类而不是指定表:

```php
<?php

$query = $manager->createQuery(
    'SELECT * FROM Cars ORDER BY Cars.name'
);

$query = $manager->createQuery(
    'SELECT Cars.name FROM Cars ORDER BY Cars.name'
);
```

名称空间中的类也被允许:

```php
<?php

$phql  = 'SELECT * FROM Formula\Cars ORDER BY Formula\Cars.name';
$query = $manager->createQuery($phql);

$phql  = 'SELECT Formula\Cars.name FROM Formula\Cars ORDER BY Formula\Cars.name';
$query = $manager->createQuery($phql);

$phql  = 'SELECT c.name FROM Formula\Cars c ORDER BY c.name';
$query = $manager->createQuery($phql);
```

大多数SQL标准都由PHQL支持，甚至是非标准指令，如LIMIT:

```php
<?php

$phql = 'SELECT c.name FROM Cars AS c WHERE c.brand_id = 21 ORDER BY c.name LIMIT 100';

$query = $manager->createQuery($phql);
```

<a name='result-types'></a>

### 结果类型

根据我们查询的列的类型，结果类型会有所不同。 If you retrieve a single whole object, then the object returned is a [Phalcon\Mvc\Model\Resultset\Simple](api/Phalcon_Mvc_Model_Resultset_Simple). 这种resultset是一组完整的模型对象:

```php
<?php

$phql = 'SELECT c.* FROM Cars AS c ORDER BY c.name';

$cars = $manager->executeQuery($phql);

foreach ($cars as $car) {
    echo 'Name: ', $car->name, "\n";
}
```

这与:

```php
<?php

$cars = Cars::find(
    [
        'order' => 'name'
    ]
);

foreach ($cars as $car) {
    echo 'Name: ', $car->name, "\n";
}
```

完整的对象可以被修改并重新保存在数据库中，因为它们表示关联表的完整记录。 还有其他类型的查询不返回完整的对象，例如:

```php
<?php

$phql = 'SELECT c.id, c.name FROM Cars AS c ORDER BY c.name';

$cars = $manager->executeQuery($phql);

foreach ($cars as $car) {
    echo 'Name: ', $car->name, "\n";
}
```

We are only requesting some fields in the table, therefore those cannot be considered an entire object, so the returned object is still a resultset of type [Phalcon\Mvc\Model\Resultset\Simple](api/Phalcon_Mvc_Model_Resultset_Simple). 但是，每个元素都是一个标准对象，只包含请求的两列。

这些不代表完整对象的值就是我们所说的标量。PHQL允许您查询所有类型的标量: 字段、函数、文字、表达式等等。

```php
<?php

$phql = "SELECT CONCAT(c.id, ' ', c.name) AS id_name FROM Cars AS c ORDER BY c.name";

$cars = $manager->executeQuery($phql);

foreach ($cars as $car) {
    echo $car->id_name, "\n";
}
```

因为我们可以查询完整的对象或标量，我们也可以同时查询:

```php
<?php

$phql = 'SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c ORDER BY c.name';

$result = $manager->executeQuery($phql);
```

The result in this case is an object [Phalcon\Mvc\Model\Resultset\Complex](api/Phalcon_Mvc_Model_Resultset_Complex). This allows access to both complete objects and scalars at once:

```php
<?php

foreach ($result as $row) {
    echo 'Name: ', $row->cars->name, "\n";
    echo 'Price: ', $row->cars->price, "\n";
    echo 'Taxes: ', $row->taxes, "\n";
}
```

”标量映射为每个“行”的属性，而完整对象映射为具有相关模型名称的属性。

<a name='joins'></a>

### Joins

使用PHQL从多个模型请求记录很容易。支持大多数类型的连接。当我们在模型中定义关系时，PHQL会自动添加这些条件:

```php
<?php

$phql = 'SELECT Cars.name AS car_name, Brands.name AS brand_name FROM Cars JOIN Brands';

$rows = $manager->executeQuery($phql);

foreach ($rows as $row) {
    echo $row->car_name, "\n";
    echo $row->brand_name, "\n";
}
```

默认情况下，假定内部连接。您可以在查询中指定连接的类型:

```php
<?php

$phql = 'SELECT Cars.*, Brands.* FROM Cars INNER JOIN Brands';
$rows = $manager->executeQuery($phql);

$phql = 'SELECT Cars.*, Brands.* FROM Cars LEFT JOIN Brands';
$rows = $manager->executeQuery($phql);

$phql = 'SELECT Cars.*, Brands.* FROM Cars LEFT OUTER JOIN Brands';
$rows = $manager->executeQuery($phql);

$phql = 'SELECT Cars.*, Brands.* FROM Cars CROSS JOIN Brands';
$rows = $manager->executeQuery($phql);
```

也可以手动设置连接的条件:

```php
<?php

$phql = 'SELECT Cars.*, Brands.* FROM Cars INNER JOIN Brands ON Brands.id = Cars.brands_id';

$rows = $manager->executeQuery($phql);
```

另外，可以使用FROM子句中的多个表创建连接:

```php
<?php

$phql = 'SELECT Cars.*, Brands.* FROM Cars, Brands WHERE Brands.id = Cars.brands_id';

$rows = $manager->executeQuery($phql);

foreach ($rows as $row) {
    echo 'Car: ', $row->cars->name, "\n";
    echo 'Brand: ', $row->brands->name, "\n";
}
```

如果一个别名用于重命名查询中的模型，那么这些别名将用于命名结果的每一行中的属性:

```php
<?php

$phql = 'SELECT c.*, b.* FROM Cars c, Brands b WHERE b.id = c.brands_id';

$rows = $manager->executeQuery($phql);

foreach ($rows as $row) {
    echo 'Car: ', $row->c->name, "\n";
    echo 'Brand: ', $row->b->name, "\n";
}
```

当连接的模型与模型有多对多关系时，中间模型隐式地添加到生成的查询中:

```php
<?php

$phql = 'SELECT Artists.name, Songs.name FROM Artists ' .
        'JOIN Songs WHERE Artists.genre = "Trip-Hop"';

$result = $this->modelsManager->executeQuery($phql);
```

此代码在MySQL中执行以下SQL:

```sql
SELECT `artists`.`name`, `songs`.`name` FROM `artists`
INNER JOIN `albums` ON `albums`.`artists_id` = `artists`.`id`
INNER JOIN `songs` ON `albums`.`songs_id` = `songs`.`id`
WHERE `artists`.`genre` = 'Trip-Hop'
```

<a name='aggregations'></a>

### Aggregations

下面的例子展示了如何在PHQL中使用聚合:

```php
<?php

// 所有汽车的价格是多少?
$phql = 'SELECT SUM(price) AS summatory FROM Cars';
$row  = $manager->executeQuery($phql)->getFirst();
echo $row['summatory'];

// 每个品牌有多少辆车?
$phql = 'SELECT Cars.brand_id, COUNT(*) FROM Cars GROUP BY Cars.brand_id';
$rows = $manager->executeQuery($phql);
foreach ($rows as $row) {
    echo $row->brand_id, ' ', $row['1'], "\n";
}

// 每个品牌有多少辆车?
$phql = 'SELECT Brands.name, COUNT(*) FROM Cars JOIN Brands GROUP BY 1';
$rows = $manager->executeQuery($phql);
foreach ($rows as $row) {
    echo $row->name, ' ', $row['1'], "\n";
}

$phql = 'SELECT MAX(price) AS maximum, MIN(price) AS minimum FROM Cars';
$rows = $manager->executeQuery($phql);
foreach ($rows as $row) {
    echo $row['maximum'], ' ', $row['minimum'], "\n";
}

// 统计不同的品牌
$phql = 'SELECT COUNT(DISTINCT brand_id) AS brandId FROM Cars';
$rows = $manager->executeQuery($phql);
foreach ($rows as $row) {
    echo $row->brandId, "\n";
}
```

<a name='conditions'></a>

### 条件

条件允许我们过滤我们想查询的记录集。`WHERE`子句允许这样做:

```php
<?php

// Simple conditions
$phql = 'SELECT * FROM Cars WHERE Cars.name = "Lamborghini Espada"';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE Cars.price > 10000';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE TRIM(Cars.name) = "Audi R8"';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE Cars.name LIKE "Ferrari%"';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE Cars.name NOT LIKE "Ferrari%"';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE Cars.price IS NULL';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE Cars.id IN (120, 121, 122)';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE Cars.id NOT IN (430, 431)';
$cars = $manager->executeQuery($phql);

$phql = 'SELECT * FROM Cars WHERE Cars.id BETWEEN 1 AND 100';
$cars = $manager->executeQuery($phql);
```

同时，作为PHQL的一部分，准备的参数会自动转义输入数据，引入更多的安全性:

```php
<?php

$phql = 'SELECT * FROM Cars WHERE Cars.name = :name:';
$cars = $manager->executeQuery(
    $phql,
    [
        'name' => 'Lamborghini Espada'
    ]
);

$phql = 'SELECT * FROM Cars WHERE Cars.name = ?0';
$cars = $manager->executeQuery(
    $phql,
    [
        0 => 'Lamborghini Espada'
    ]
);
```

<a name='inserting-data'></a>

## 插入数据

使用PHQL，可以使用熟悉的insert语句插入数据:

```php
<?php

// Inserting without columns
$phql = 'INSERT INTO Cars VALUES (NULL, "Lamborghini Espada", '
      . '7, 10000.00, 1969, "Grand Tourer")';
$manager->executeQuery($phql);

// Specifying columns to insert
$phql = 'INSERT INTO Cars (name, brand_id, year, style) '
      . 'VALUES ("Lamborghini Espada", 7, 1969, "Grand Tourer")';
$manager->executeQuery($phql);

// Inserting using placeholders
$phql = 'INSERT INTO Cars (name, brand_id, year, style) '
      . 'VALUES (:name:, :brand_id:, :year:, :style)';
$manager->executeQuery(
    $phql,
    [
        'name'     => 'Lamborghini Espada',
        'brand_id' => 7,
        'year'     => 1969,
        'style'    => 'Grand Tourer',
    ]
);
```

Phalcon不只是将PHQL语句转换成SQL。 模型中定义的所有事件和业务规则都像手动创建单个对象一样执行。 让我们在模型汽车上添加一个业务规则。 一辆车的价格不能低于1万美元:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;

class Cars extends Model
{
    public function beforeCreate()
    {
        if ($this->price < 10000) {
            $this->appendMessage(
                new Message('A car cannot cost less than $ 10,000')
            );

            return false;
        }
    }
}
```

如果我们在Cars模型中插入以下`INSERT`，操作将不会成功，因为价格不符合我们实现的业务规则。 通过检查插入的状态，我们可以打印内部生成的任何验证消息:

```php
<?php

$phql = "INSERT INTO Cars VALUES (NULL, 'Nissan Versa', 7, 9999.00, 2015, 'Sedan')";

$result = $manager->executeQuery($phql);

if ($result->success() === false) {
    foreach ($result->getMessages() as $message) {
        echo $message->getMessage();
    }
}
```

<a name='updating-data'></a>

## 更新数据

更新行与插入行非常相似。 您可能知道，更新记录的指令是UPDATE。 当一条记录被更新时，将对每一行执行与更新操作相关的事件。

```php
<?php

// Updating a single column
$phql = 'UPDATE Cars SET price = 15000.00 WHERE id = 101';
$manager->executeQuery($phql);

// Updating multiples columns
$phql = 'UPDATE Cars SET price = 15000.00, type = "Sedan" WHERE id = 101';
$manager->executeQuery($phql);

// Updating multiples rows
$phql = 'UPDATE Cars SET price = 7000.00, type = "Sedan" WHERE brands_id > 5';
$manager->executeQuery($phql);

// Using placeholders
$phql = 'UPDATE Cars SET price = ?0, type = ?1 WHERE brands_id > ?2';
$manager->executeQuery(
    $phql,
    [
        0 => 7000.00,
        1 => 'Sedan',
        2 => 5,
    ]
);
```

一个`UPDATE`语句执行两个阶段的更新:

* 首先，如果`UPDATE`具有`WHERE`子句检索所有符合这些条件的对象，
* 其次，基于查询对象，它更新/更改将其存储到关系数据库的请求属性

这种操作方式允许事件、虚拟外键和验证参与更新过程。 综上所述，以下代码:

```php
<?php

$phql = 'UPDATE Cars SET price = 15000.00 WHERE id > 101';

$result = $manager->executeQuery($phql);

if ($result->success() === false) {
    $messages = $result->getMessages();

    foreach ($messages as $message) {
        echo $message->getMessage();
    }
}
```

相当于:

```php
<?php

$messages = null;

$process = function () use (&$messages) {
    $cars = Cars::find('id > 101');

    foreach ($cars as $car) {
        $car->price = 15000;

        if ($car->save() === false) {
            $messages = $car->getMessages();

            return false;
        }
    }

    return true;
};

$success = $process();
```

<a name='deleting-data'></a>

## 删除数据

当一个记录被删除时，与删除操作相关的事件将对每一行执行:

```php
<?php

// Deleting a single row
$phql = 'DELETE FROM Cars WHERE id = 101';
$manager->executeQuery($phql);

// Deleting multiple rows
$phql = 'DELETE FROM Cars WHERE id > 100';
$manager->executeQuery($phql);

// Using placeholders
$phql = 'DELETE FROM Cars WHERE id BETWEEN :initial: AND :final:';
$manager->executeQuery(
    $phql,
    [
        'initial' => 1,
        'final'   => 100,
    ]
);
```

`删除`操作也执行在两个阶段，就像`更新`。要检查删除是否产生任何验证消息，您应该检查返回的状态码:

```php
<?php

// Deleting multiple rows
$phql = 'DELETE FROM Cars WHERE id > 100';

$result = $manager->executeQuery($phql);

if ($result->success() === false) {
    $messages = $result->getMessages();

    foreach ($messages as $message) {
        echo $message->getMessage();
    }
}
```

<a name='query-builder'></a>

## 使用查询生成器创建查询

构建器可以创建PHQL查询，而不需要编写PHQL语句，还提供IDE工具:

```php
<?php

// Getting a whole set
$robots = $this->modelsManager->createBuilder()
    ->from('Robots')
    ->join('RobotsParts')
    ->orderBy('Robots.name')
    ->getQuery()
    ->execute();

// Getting the first row
$robots = $this->modelsManager->createBuilder()
    ->from('Robots')
    ->join('RobotsParts')
    ->orderBy('Robots.name')
    ->getQuery()
    ->getSingleResult();
```

这等于:

```php
<?php

$phql = 'SELECT Robots.* FROM Robots JOIN RobotsParts p ORDER BY Robots.name LIMIT 20';

$result = $manager->executeQuery($phql);
```

更多的构建器例子:

```php
<?php

// 'SELECT Robots.* FROM Robots';
$builder->from('Robots');

// 'SELECT Robots.*, RobotsParts.* FROM Robots, RobotsParts';
$builder->from(
    [
        'Robots',
        'RobotsParts',
    ]
);

// 'SELECT * FROM Robots';
$phql = $builder->columns('*')
                ->from('Robots');

// 'SELECT id FROM Robots';
$builder->columns('id')
        ->from('Robots');

// 'SELECT id, name FROM Robots';
$builder->columns(['id', 'name'])
        ->from('Robots');

// 'SELECT Robots.* FROM Robots WHERE Robots.name = 'Voltron'';
$builder->from('Robots')
        ->where("Robots.name = 'Voltron'");

// 'SELECT Robots.* FROM Robots WHERE Robots.id = 100';
$builder->from('Robots')
        ->where(100);

// 'SELECT Robots.* FROM Robots WHERE Robots.type = 'virtual' AND Robots.id > 50';
$builder->from('Robots')
        ->where("type = 'virtual'")
        ->andWhere('id > 50');

// 'SELECT Robots.* FROM Robots WHERE Robots.type = 'virtual' OR Robots.id > 50';
$builder->from('Robots')
        ->where("type = 'virtual'")
        ->orWhere('id > 50');

// 'SELECT Robots.* FROM Robots GROUP BY Robots.name';
$builder->from('Robots')
        ->groupBy('Robots.name');

// 'SELECT Robots.* FROM Robots GROUP BY Robots.name, Robots.id';
$builder->from('Robots')
        ->groupBy(['Robots.name', 'Robots.id']);

// 'SELECT Robots.name, SUM(Robots.price) FROM Robots GROUP BY Robots.name';
$builder->columns(['Robots.name', 'SUM(Robots.price)'])
    ->from('Robots')
    ->groupBy('Robots.name');

// 'SELECT Robots.name, SUM(Robots.price) FROM Robots GROUP BY Robots.name HAVING SUM(Robots.price) > 1000';
$builder->columns(['Robots.name', 'SUM(Robots.price)'])
    ->from('Robots')
    ->groupBy('Robots.name')
    ->having('SUM(Robots.price) > 1000');

// 'SELECT Robots.* FROM Robots JOIN RobotsParts';
$builder->from('Robots')
    ->join('RobotsParts');

// 'SELECT Robots.* FROM Robots JOIN RobotsParts AS p';
$builder->from('Robots')
    ->join('RobotsParts', null, 'p');

// 'SELECT Robots.* FROM Robots JOIN RobotsParts ON Robots.id = RobotsParts.robots_id AS p';
$builder->from('Robots')
    ->join('RobotsParts', 'Robots.id = RobotsParts.robots_id', 'p');

// 'SELECT Robots.* FROM Robots
// JOIN RobotsParts ON Robots.id = RobotsParts.robots_id AS p
// JOIN Parts ON Parts.id = RobotsParts.parts_id AS t';
$builder->from('Robots')
    ->join('RobotsParts', 'Robots.id = RobotsParts.robots_id', 'p')
    ->join('Parts', 'Parts.id = RobotsParts.parts_id', 't');

// 'SELECT r.* FROM Robots AS r';
$builder->addFrom('Robots', 'r');

// 'SELECT Robots.*, p.* FROM Robots, Parts AS p';
$builder->from('Robots')
    ->addFrom('Parts', 'p');

// 'SELECT r.*, p.* FROM Robots AS r, Parts AS p';
$builder->from(['r' => 'Robots'])
        ->addFrom('Parts', 'p');

// 'SELECT r.*, p.* FROM Robots AS r, Parts AS p';
$builder->from(['r' => 'Robots', 'p' => 'Parts']);

// 'SELECT Robots.* FROM Robots LIMIT 10';
$builder->from('Robots')
    ->limit(10);

// 'SELECT Robots.* FROM Robots LIMIT 10 OFFSET 5';
$builder->from('Robots')
        ->limit(10, 5);

// 'SELECT Robots.* FROM Robots WHERE id BETWEEN 1 AND 100';
$builder->from('Robots')
        ->betweenWhere('id', 1, 100);

// 'SELECT Robots.* FROM Robots WHERE id IN (1, 2, 3)';
$builder->from('Robots')
        ->inWhere('id', [1, 2, 3]);

// 'SELECT Robots.* FROM Robots WHERE id NOT IN (1, 2, 3)';
$builder->from('Robots')
        ->notInWhere('id', [1, 2, 3]);

// 'SELECT Robots.* FROM Robots WHERE name LIKE '%Art%';
$builder->from('Robots')
        ->where('name LIKE :name:', ['name' => '%' . $name . '%']);

// 'SELECT r.* FROM Store\Robots WHERE r.name LIKE '%Art%';
$builder->from(['r' => 'Store\Robots'])
        ->where('r.name LIKE :name:', ['name' => '%' . $name . '%']);
```

<a name='query-builder-parameters'></a>

### 绑定参数

查询生成器中的绑定参数可以在查询被构造时设置，或者在执行时一次性全部超过:

```php
<?php

// Passing parameters in the query construction
$robots = $this->modelsManager->createBuilder()
    ->from('Robots')
    ->where('name = :name:', ['name' => $name])
    ->andWhere('type = :type:', ['type' => $type])
    ->getQuery()
    ->execute();

// Passing parameters in query execution
$robots = $this->modelsManager->createBuilder()
    ->from('Robots')
    ->where('name = :name:')
    ->andWhere('type = :type:')
    ->getQuery()
    ->execute(['name' => $name, 'type' => $type]);
```

<a name='disallow-literals'></a>

## 不允许PHQL中的文字

在PHQL中可以禁用文字，这意味着直接使用字符串、数字和布尔值将被禁用。 如果创建了将外部数据嵌入到PHQL语句上的PHQL语句，这可能会使应用程序面临潜在的SQL注入:

```php
<?php

$login  = 'voltron';
$phql   = "SELECT * FROM Models\Users WHERE login = '$login'";
$result = $manager->executeQuery($phql);
```

如果`$login` 被更改为 `' OR '' = '`, name生成的PHQL就是:

```sql
SELECT * FROM Models\Users WHERE login = '' OR '' = ''
```

无论数据库中存储的登录名是什么，它总是`true`。

如果不允许字面值的字符串可以作为PHQL语句的一部分使用，那么就会抛出一个异常，迫使开发人员使用绑定参数。 可以以安全的方式编写相同的查询, 如下所示:

```php
<?php

$type   = 'virtual';
$phql   = 'SELECT Robots.* FROM Robots WHERE Robots.type = :type:';
$result = $manager->executeQuery(
    $phql,
    [
        'type' => $type,
    ]
);
```

您可以通过以下方式不允许文本:

```php
<?php

use Phalcon\Mvc\Model;

Model::setup(
    [
        'phqlLiterals' => false
    ]
);
```

即使允许或不允许使用文本, 也可以使用绑定参数。不允许它们只是开发人员在 web 应用程序中可以采取的另一个安全决定。

<a name='escaping-reserved-words'></a>

## 转义保留字

PHQL 有几个保留字, 如果要将其中任何一个用作属性或模型名称, 则需要使用跨数据库转义分隔符 ` [` 和 `] ` 来转义这些单词:

```php
<?php

$phql   = 'SELECT * FROM [Update]';
$result = $manager->executeQuery($phql);

$phql   = 'SELECT id, [Like] FROM Posts';
$result = $manager->executeQuery($phql);
```

根据应用程序当前运行的数据库系统，将分隔符动态转换为有效的分隔符。

<a name='lifecycle'></a>

## PHQL生命周期

作为一种高级语言, PHQL 使开发人员能够个性化和自定义不同方面, 以满足他们的需求。 以下是执行的每个 PHQL 语句的生命周期:

* 对 PHQL 进行解析并转换为中间表示 (IR), 该表示独立于数据库系统实现的 sql
* IR 根据与模型关联的数据库系统转换为有效的 sql
* PHQL 语句被分析一次, 并缓存在内存中。进一步执行同一语句可使执行速度稍快

<a name='raw-sql'></a>

## 使用原始的SQL

数据库系统可以提供 PHQL 不支持的特定 sql 扩展, 在这种情况下, 原始 sql 可能是合适的:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Robots extends Model
{
    public static function findByCreateInterval()
    {
        // A raw SQL statement
        $sql = 'SELECT * FROM robots WHERE id > 0';

        // Base model
        $robot = new Robots();

        // Execute the query
        return new Resultset(
            null,
            $robot,
            $robot->getReadConnection()->query($sql)
        );
    }
}
```

如果原始SQL查询在您的应用程序中是常见的，一个通用的方法可以添加到您的模型:

```php
<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Robots extends Model
{
    public static function findByRawSql($conditions, $params = null)
    {
        // A raw SQL statement
        $sql = 'SELECT * FROM robots WHERE $conditions';

        // Base model
        $robot = new Robots();

        // Execute the query
        return new Resultset(
            null,
            $robot,
            $robot->getReadConnection()->query($sql, $params)
        );
    }
}
```

以上`findByRawSql`可使用如下:

```php
<?php

$robots = Robots::findByRawSql(
    'id > ?',
    [
        10
    ]
);
```

<a name='troubleshooting'></a>

## 疑难解答

使用PHQL时要记住的一些事情:

* 类是区分大小写的，如果一个类在创建时没有使用相同的名称定义，这可能会导致在具有区分大小写文件系统(如Linux) 的操作系统中出现意外行为。
* 必须在连接中定义正确的字符集，才能成功绑定参数。
* 别名类不会被完全带名称空间的类所替代，因为这只发生在PHP代码中，而不在字符串中。
* 如果启用了列重命名，避免使用与要重命名的列同名的列别名，这可能会使查询解析器感到困惑。