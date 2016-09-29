使用模型（Working with Models）
===============================

模型代表了应用程序中的信息（数据）和处理数据的规则。模型主要用于管理与相应数据库表进行交互的规则。
大多数情况中，在应用程序中，数据库中每个表将对应一个模型。
应用程序中的大部分业务逻辑都将集中在模型里。

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 是 Phalcon 应用程序中所有模型的基类。它保证了数据库的独立性，基本的 CURD 操作，
高级的查询功能，多表关联等功能。
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 不需要直接使用 SQL 语句，因为它的转换方法，会动态的调用相应的数据库引擎进行处理。

.. highlights::

    模型是数据库的高级抽象层。如果您想进行低层次的数据库操作，您可以查看
    :doc:`Phalcon\\Db <../api/Phalcon_Db>` 组件文档。

创建模型
--------
模型是一个继承自 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 的一个类。时它的类名必须符合驼峰命名法：

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class RobotParts extends Model
    {

    }

.. highlights::

    如果使用 PHP 5.4/5.5 建议在模型中预先定义好所有的列，这样可以减少模型内存的开销以及内存分配。

默认情况下，模型 "Store\\Toys\\RobotParts" 对应的是数据库表 "robot_parts"， 如果想映射到其他数据库表，可以使用 :code:`setSource()` 方法：

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class RobotParts extends Model
    {
        public function initialize()
        {
            $this->setSource("toys_robot_parts");
        }
    }

模型 RobotParts 现在映射到了 "toys_robot_parts" 表。:code:`initialize()` 方法可以帮助在模型中建立自定义行为，例如指定不同的数据库表。

:code:`initialize()` 方法在请求期间仅会被调用一次，目的是为应用中所有该模型的实例进行初始化。如果需要为每一个实例在创建的时候单独进行初始化，
可以使用 :code:`onConstruct()` 事件：

.. code-block:: php

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

公共属性对比设置与取值 Setters/Getters（Public properties vs. Setters/Getters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
模型可以通过公共属性的方式实现，意味着模型的所有属性在实例化该模型的地方可以无限制的读取和更新。

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public $id;

        public $name;

        public $price;
    }

通过使用 getters/setters 方法，可以控制哪些属性可以公开访问，并且对属性值执行不同的形式的转换，同时可以保存在模型中的数据添加相应的验证规则。

.. code-block:: php

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
                    "The name is too short"
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

公共属性的方式可以在开发中降低复杂度。而 getters/setters 的实现方式可以显著的增强应用的可测试性、扩展性和可维护性。
开发人员可以自己决定哪一种策略更加适合自己开发的应用。ORM同时兼容这两种方法。

.. highlights::

    Underscores in property names can be problematic when using getters and setters.

If you use underscores in your property names, you must still use camel case in your getter/setter declarations for use
with magic methods. (e.g. $model->getPropertyName instead of $model->getProperty_name, $model->findByPropertyName
instead of $model->findByProperty_name, etc.). As much of the system expects camel case, and underscores are commonly
removed, it is recommended to name your properties in the manner shown throughout the documentation. You can use a
column map (as described above) to ensure proper mapping of your properties to their database counterparts.

理解记录对象（Understanding Records To Objects）
------------------------------------------------
每个模型的实例对应一条数据表中的记录。可以方便的通过读取对象的属性来访问相应的数据。比如，
一个表 "robots" 有如下数据：

.. code-block:: bash

    mysql> select * from robots;
    +----+------------+------------+------+
    | id | name       | type       | year |
    +----+------------+------------+------+
    |  1 | Robotina   | mechanical | 1972 |
    |  2 | Astro Boy  | mechanical | 1952 |
    |  3 | Terminator | cyborg     | 2029 |
    +----+------------+------------+------+
    3 rows in set (0.00 sec)

你可以通过主键找到某一条记录并且打印它的名称：

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Find record with id = 3
    $robot = Robots::findFirst(3);

    // Prints "Terminator"
    echo $robot->name;

一旦记录被加载到内存中之后，你可以修改它的数据并保存所做的修改：

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst(3);

    $robot->name = "RoboCop";

    $robot->save();

如上所示，不需要写任何SQL语句。:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 为web应用提供了高层数据库抽象。

查找记录（Finding Records）
---------------------------
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 为数据查询提供了多种方法。下面的例子将演示如何从一个模型中查找一条或者多条记录：

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // How many robots are there?
    $robots = Robots::find();
    echo "There are ", count($robots), "\n";

    // How many mechanical robots are there?
    $robots = Robots::find("type = 'mechanical'");
    echo "There are ", count($robots), "\n";

    // Get and print virtual robots ordered by name
    $robots = Robots::find(
        [
            "type = 'virtual'",
            "order" => "name",
        ]
    );
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // Get first 100 virtual robots ordered by name
    $robots = Robots::find(
        [
            "type = 'virtual'",
            "order" => "name",
            "limit" => 100,
        ]
    );
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

.. highlights::

    如果需要通过外部数据（比如用户输入）或变量来查询记录，则必须要用`Binding Parameters`（绑定参数）的方式来防止SQL注入.

你可以使用 :code:`findFirst()` 方法获取第一条符合查询条件的结果：

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // What's the first robot in robots table?
    $robot = Robots::findFirst();
    echo "The robot name is ", $robot->name, "\n";

    // What's the first mechanical robot in robots table?
    $robot = Robots::findFirst("type = 'mechanical'");
    echo "The first mechanical robot name is ", $robot->name, "\n";

    // Get first virtual robot ordered by name
    $robot = Robots::findFirst(
        [
            "type = 'virtual'",
            "order" => "name",
        ]
    );
    echo "The first virtual robot name is ", $robot->name, "\n";

:code:`find()` 和 :code:`findFirst()` 方法都接受关联数组作为查询条件：

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst(
        [
            "type = 'virtual'",
            "order" => "name DESC",
            "limit" => 30,
        ]
    );

    $robots = Robots::find(
        [
            "conditions" => "type = ?1",
            "bind"       => [
                1 => "virtual",
            ]
        ]
    );

可用的查询选项如下：

+-------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| 参数        | 描述                                                                                                                                                  | 举例                                                                    |
+=============+=======================================================================================================================================================+=========================================================================+
| conditions  | 查询操作的搜索条件。用于提取只有那些满足指定条件的记录。默认情况下 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 假定第一个参数就是查询条件。 | :code:`"conditions" => "name LIKE 'steve%'"`                            |
+-------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| columns     | 只返回指定的字段，而不是模型所有的字段。 当用这个选项时，返回的是一个不完整的对象。                                                                   | :code:`"columns" => "id, name"`                                         |
+-------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| bind        | 绑定与选项一起使用，通过替换占位符以及转义字段值从而增加安全性。                                                                                      | :code:`"bind" => ["status" => "A", "type" => "some-time"]`              |
+-------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| bindTypes   | 当绑定参数时，可以使用这个参数为绑定参数定义额外的类型限制从而更加增强安全性。                                                                        | :code:`"bindTypes" => [Column::BIND_PARAM_STR, Column::BIND_PARAM_INT]` |
+-------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| order       | 用于结果排序。使用一个或者多个字段，逗号分隔。                                                                                                        | :code:`"order" => "name DESC, status"`                                  |
+-------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| limit       | 限制查询结果的数量在一定范围内。                                                                                                                      | :code:`"limit" => 10`                                                   |
+-------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| offset      | Offset the results of the query by a certain amount                                                                                                   | :code:`"offset" => 5`                                                   |
+-------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| group       | 从多条记录中获取数据并且根据一个或多个字段对结果进行分组。                                                                                            | :code:`"group" => "name, status"`                                       |
+-------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| for_update  | 通过这个选项， :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 读取最新的可用数据，并且为读到的每条记录设置独占锁。                             | :code:`"for_update" => true`                                            |
+-------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| shared_lock | 通过这个选项， :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 读取最新的可用数据，并且为读到的每条记录设置共享锁。                             | :code:`"shared_lock" => true`                                           |
+-------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| cache       | 缓存结果集，减少了连续访问数据库。                                                                                                                    | :code:`"cache" => ["lifetime" => 3600, "key" => "my-find-key"]`         |
+-------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| hydration   | Sets the hydration strategy to represent each returned record in the result                                                                           | :code:`"hydration" => Resultset::HYDRATE_OBJECTS`                       |
+-------------+-------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+

如果你愿意，除了使用数组作为查询参数外，还可以通过一种面向对象的方式来创建查询：

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robots = Robots::query()
        ->where("type = :type:")
        ->andWhere("year < 2000")
        ->bind(["type" => "mechanical"])
        ->order("name")
        ->execute();

静态方法 :code:`query()` 返回一个对IDE自动完成友好的 :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>`  对象。

所有查询在内部都以 :doc:`PHQL <phql>` 查询的方式处理。PHQL是一个高层的、面向对象的类SQL语言。通过PHQL语言你可以使用更多的比如join其他模型、定义分组、添加聚集等特性。

最后，还有一个 :code:`findFirstBy<property-name>()` 方法。这个方法扩展了前面提及的 :code:`findFirst()` 方法。它允许您利用方法名中的属性名称，通过将要搜索的该字段的内容作为参数传给它，来快速从一个表执行检索操作。

还是用上面用过的 Robots 模型来举例说明：

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public $id;

        public $name;

        public $price;
    }

我们这里有3个属性：:code:`$id`, :code:`$name` 和 :code:`$price`。因此，我们以想要查询第一个名称为 'Terminator' 的记录为例，可以这样写：

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $name = "Terminator";

    $robot = Robots::findFirstByName($name);

    if ($robot) {
        echo "The first robot with the name " . $name . " cost " . $robot->price . ".";
    } else {
        echo "There were no robots found in our table with the name " . $name . ".";
    }

请注意我们在方法调用中用的是 'Name'，并向它传递了变量 :code:`$name`， :code:`$name` 的值就是我们想要找的记录的名称。另外注意，当我们的查询找到了符合的记录后，这个记录的其他属性也都是可用的。

模型结果集（Model Resultsets）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
:code:`findFirst()` 方法直接返回一个被调用对象的实例（如果有结果返回的话），而 :code:`find()` 方法返回一个 :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>` 对象。这个对象也封装进了所有结果集的功能，比如遍历、查找特定的记录、统计等等。

这些对象比一般数组功能更强大。最大的特点是 :doc:`Phalcon\\Mvc\\Model\\Resultset <../api/Phalcon_Mvc_Model_Resultset>` 每时每刻只有一个结果在内存中。这对操作大数据量时的内存管理相当有帮助。

.. code-block:: php

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

Phalcon 的结果集模拟了可滚动的游标，你可以通过位置，或者内部指针去访问任何一条特定的记录。注意有一些数据库系统不支持滚动游标，这就使得查询会被重复执行，
以便回放光标到最开始的位置，然后获得相应的记录。类似地，如果多次遍历结果集，那么必须执行相同的查询次数。

将大数据量的查询结果存储在内存会消耗很多资源，正因为如此，分成每32行一块从数据库中获得结果集，以减少重复执行查询请求的次数，在一些情况下也节省内存。

注意结果集可以序列化后保存在一个后端缓存里面。 :doc:`Phalcon\\Cache <cache>` 可以用来实现这个。但是，序列化数据会导致 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
将从数据库检索到的所有数据以一个数组的方式保存，因此在这样执行的地方会消耗更多的内存。

.. code-block:: php

    <?php

    // Query all records from model parts
    $parts = Parts::find();

    // Store the resultset into a file
    file_put_contents(
        "cache.txt",
        serialize($parts)
    );

    // Get parts from file
    $parts = unserialize(
        file_get_contents("cache.txt")
    );

    // Traverse the parts
    foreach ($parts as $part) {
        echo $part->id;
    }

过滤结果集（Filtering Resultsets）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
过滤数据最有效的方法是设置一些查询条件，数据库会利用表的索引快速返回数据。Phalcon 额外的允许你通过任何数据库不支持的方式过滤数据。

.. code-block:: php

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

绑定参数（Binding Parameters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
在 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 中也支持绑定参数。即使使用绑定参数对性能有一点很小的影响，还是强烈建议您使用这种方法，以消除代码受SQL注入攻击的可能性。
绑定参数支持字符串和整数占位符。实现方法如下：

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Query robots binding parameters with string placeholders
    // Parameters whose keys are the same as placeholders
    $robots = Robots::find(
        [
            "name = :name: AND type = :type:",
            "bind" => [
                "name" => "Robotina",
                "type" => "maid",
            ],
        ]
    );

    // Query robots binding parameters with integer placeholders
    $robots = Robots::find(
        [
            "name = ?1 AND type = ?2",
            "bind" => [
                1 => "Robotina",
                2 => "maid",
            ],
        ]
    );

    // Query robots binding parameters with both string and integer placeholders
    // Parameters whose keys are the same as placeholders
    $robots = Robots::find(
        [
            "name = :name: AND type = ?1",
            "bind" => [
                "name" => "Robotina",
                1      => "maid",
            ],
        ]
    );

如果是数字占位符，则必须把它们定义成整型（如1或者2）。若是定义为字符串型（如"1"或者"2"），则这个占位符不会被替换。

使用PDO_的方式会自动转义字符串。它依赖于字符集编码，因此建议在连接参数或者数据库配置中设置正确的字符集编码。
若是设置错误的字符集编码，在存储数据或检索数据时，可能会出现乱码。

另外你可以设置参数的“bindTypes”，这允许你根据数据类型来定义参数应该如何绑定：

.. code-block:: php

    <?php

    use Phalcon\Db\Column;
    use Store\Toys\Robots;

    // Bind parameters
    $parameters = [
        "name" => "Robotina",
        "year" => 2008,
    ];

    // Casting Types
    $types = [
        "name" => Column::BIND_PARAM_STR,
        "year" => Column::BIND_PARAM_INT,
    ];

    // Query robots binding parameters with string placeholders
    $robots = Robots::find(
        [
            "name = :name: AND year = :year:",
            "bind"      => $parameters,
            "bindTypes" => $types,
        ]
    );

.. highlights::

	默认的参数绑定类型是 :code:`Phalcon\Db\Column::BIND_PARAM_STR` , 若所有字段都是string类型，则不用特意去设置参数的“bindTypes”.

如果你的绑定参数是array数组，那么数组索引必须从数字0开始:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $array = ["a","b","c"]; // $array: [[0] => "a", [1] => "b", [2] => "c"]

    unset($array[1]); // $array: [[0] => "a", [2] => "c"]

    // Now we have to renumber the keys
    $array = array_values($array); // $array: [[0] => "a", [1] => "c"]

    $robots = Robots::find(
        [
            'letter IN ({letter:array})',
            'bind' => [
                'letter' => $array
            ]
        ]
    );

.. highlights::

	参数绑定的方式适用于所有与查询相关的方法，如 :code:`find()` , :code:`findFirst()` 等等, 
	同时也适用于与计算相关的方法，如 :code:`count()`, :code:`sum()`, :code:`average()` 等等.

若使用如下方式，phalcon也会自动为你进行参数绑定:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Explicit query using bound parameters
    $robots = Robots::find(
        [
            "name = ?0",
            "bind" => [
                "Ultron",
            ],
        ]
    );

    // Implicit query using bound parameters（隐式的参数绑定）
    $robots = Robots::findByName("Ultron");

获取记录的初始化以及准备（Initializing/Preparing fetched records）
------------------------------------------------------------------
有时从数据库中获取了一条记录之后，在被应用程序使用之前，需要对数据进行初始化。
你可以在模型中实现"afterFetch"方法，在模型实例化之后会执行这个方法，并将数据分配给它:

.. code-block:: php

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
            $this->status = join(",", $this->status);
        }

        public function afterFetch()
        {
            // Convert the string to an array
            $this->status = explode(",", $this->status);
        }
        
        public function afterSave()
        {
            // Convert the string to an array
            $this->status = explode(",", $this->status);
        }
    }

如果使用getters/setters方法代替公共属性的取/赋值，你能在它被调用时，对成员属性进行初始化:

.. code-block:: php

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
            return explode(",", $this->status);
        }
    }

生成运算（Generating Calculations）
-----------------------------------
Calculations (or aggregations) are helpers for commonly used functions of database systems such as COUNT, SUM, MAX, MIN or AVG.
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` allows to use these functions directly from the exposed methods.

Count examples:

.. code-block:: php

    <?php

    // How many employees are?
    $rowcount = Employees::count();

    // How many different areas are assigned to employees?
    $rowcount = Employees::count(
        [
            "distinct" => "area",
        ]
    );

    // How many employees are in the Testing area?
    $rowcount = Employees::count(
        "area = 'Testing'"
    );

    // Count employees grouping results by their area
    $group = Employees::count(
        [
            "group" => "area",
        ]
    );
    foreach ($group as $row) {
       echo "There are ", $row->rowcount, " in ", $row->area;
    }

    // Count employees grouping by their area and ordering the result by count
    $group = Employees::count(
        [
            "group" => "area",
            "order" => "rowcount",
        ]
    );

    // Avoid SQL injections using bound parameters
    $group = Employees::count(
        [
            "type > ?0",
            "bind" => [
                $type
            ],
        ]
    );

Sum examples:

.. code-block:: php

    <?php

    // How much are the salaries of all employees?
    $total = Employees::sum(
        [
            "column" => "salary",
        ]
    );

    // How much are the salaries of all employees in the Sales area?
    $total = Employees::sum(
        [
            "column"     => "salary",
            "conditions" => "area = 'Sales'",
        ]
    );

    // Generate a grouping of the salaries of each area
    $group = Employees::sum(
        [
            "column" => "salary",
            "group"  => "area",
        ]
    );
    foreach ($group as $row) {
       echo "The sum of salaries of the ", $row->area, " is ", $row->sumatory;
    }

    // Generate a grouping of the salaries of each area ordering
    // salaries from higher to lower
    $group = Employees::sum(
        [
            "column" => "salary",
            "group"  => "area",
            "order"  => "sumatory DESC",
        ]
    );

    // Avoid SQL injections using bound parameters
    $group = Employees::sum(
        [
            "conditions" => "area > ?0",
            "bind"       => [
                $area
            ],
        ]
    );

Average examples:

.. code-block:: php

    <?php

    // What is the average salary for all employees?
    $average = Employees::average(
        [
            "column" => "salary",
        ]
    );

    // What is the average salary for the Sales's area employees?
    $average = Employees::average(
        [
            "column"     => "salary",
            "conditions" => "area = 'Sales'",
        ]
    );

    // Avoid SQL injections using bound parameters
    $average = Employees::average(
        [
            "column"     => "age",
            "conditions" => "area > ?0",
            "bind"       => [
                $area
            ],
        ]
    );

Max/Min examples:

.. code-block:: php

    <?php

    // What is the oldest age of all employees?
    $age = Employees::maximum(
        [
            "column" => "age",
        ]
    );

    // What is the oldest of employees from the Sales area?
    $age = Employees::maximum(
        [
            "column"     => "age",
            "conditions" => "area = 'Sales'",
        ]
    );

    // What is the lowest salary of all employees?
    $salary = Employees::minimum(
        [
            "column" => "salary",
        ]
    );

创建与更新记录（Creating/Updating Records）
-------------------------------------------
The :code:`Phalcon\Mvc\Model::save()` method allows you to create/update records according to whether they already exist in the table
associated with a model. The save method is called internally by the create and update methods of :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`.
For this to work as expected it is necessary to have properly defined a primary key in the entity to determine whether a record
should be updated or created.

Also the method executes associated validators, virtual foreign keys and events that are defined in the model:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    if ($robot->save() === false) {
        echo "Umh, We can't store robots right now: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo "Great, a new robot was saved successfully!";
    }

An array could be passed to "save" to avoid assign every column manually. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` will check if there are setters implemented for
the columns passed in the array giving priority to them instead of assign directly the values of the attributes:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->save(
        [
            "type" => "mechanical",
            "name" => "Astro Boy",
            "year" => 1952,
        ]
    );

Values assigned directly or via the array of attributes are escaped/sanitized according to the related attribute data type. So you can pass
an insecure array without worrying about possible SQL injections:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->save($_POST);

.. highlights::

    Without precautions mass assignment could allow attackers to set any database column's value. Only use this feature
    if you want to permit a user to insert/update every column in the model, even if those fields are not in the submitted
    form.

You can set an additional parameter in 'save' to set a whitelist of fields that only must taken into account when doing
the mass assignment:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->save(
        $_POST,
        [
            "name",
            "type",
        ]
    );

创建与更新结果判断（Create/Update with Confidence）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
When an application has a lot of competition, we could be expecting create a record but it is actually updated. This
could happen if we use :code:`Phalcon\Mvc\Model::save()` to persist the records in the database. If we want to be absolutely
sure that a record is created or updated, we can change the :code:`save()` call with :code:`create()` or :code:`update()`:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    // This record only must be created
    if ($robot->create() === false) {
        echo "Umh, We can't store robots right now: \n";

        $messages = $robot->getMessages();

        foreach ($messages as $message) {
            echo $message, "\n";
        }
    } else {
        echo "Great, a new robot was created successfully!";
    }

These methods "create" and "update" also accept an array of values as parameter.

删除记录（Deleting Records）
----------------------------
The :code:`Phalcon\Mvc\Model::delete()` method allows to delete a record. You can use it as follows:

.. code-block:: php

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
            echo "The robot was deleted successfully!";
        }
    }

You can also delete many records by traversing a resultset with a foreach:

.. code-block:: php

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
            echo "The robot was deleted successfully!";
        }
    }

The following events are available to define custom business rules that can be executed when a delete operation is
performed:

+-----------+--------------+---------------------+------------------------------------------+
| Operation | Name         | Can stop operation? | Explanation                              |
+===========+==============+=====================+==========================================+
| Deleting  | beforeDelete | YES                 | Runs before the delete operation is made |
+-----------+--------------+---------------------+------------------------------------------+
| Deleting  | afterDelete  | NO                  | Runs after the delete operation was made |
+-----------+--------------+---------------------+------------------------------------------+

With the above events can also define business rules in the models:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function beforeDelete()
        {
            if ($this->status === "A") {
                echo "The robot is active, it can't be deleted";

                return false;
            }

            return true;
        }
    }

.. _PDO: http://php.net/manual/zh/pdo.prepared-statements.php
