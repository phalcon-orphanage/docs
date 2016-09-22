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

    class Robots extends Model
    {

    }

.. highlights::

    如果使用 PHP 5.4/5.5 建议在模型中预先定义好所有的列，这样可以减少模型内存的开销以及内存分配。

默认情况下，模型 "Store\\Toys\\Robots" 对应的是数据库表 "robots"， 如果想映射到其他数据库表，可以使用 :code:`setSource()` 方法：

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->setSource("toys_robots");
        }
    }

模型 Robots 现在映射到了 "toys_robots" 表。:code:`initialize()` 方法可以帮助在模型中建立自定义行为，例如指定不同的数据库表。

:code:`initialize()` 方法在请求期间仅会被调用一次，目的是为应用中所有该模型的实例进行初始化。如果需要为每一个实例在创建的时候单独进行初始化，
可以使用 :code:`onConstruct()` 事件：

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
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

Hydration Modes
---------------
As mentioned above, resultsets are collections of complete objects, this means that every returned result is an object
representing a row in the database. These objects can be modified and saved again to persistence:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robots = Robots::find();

    // Manipulating a resultset of complete objects
    foreach ($robots as $robot) {
        $robot->year = 2000;

        $robot->save();
    }

Sometimes records are obtained only to be presented to a user in read-only mode, in these cases it may be useful
to change the way in which records are represented to facilitate their handling. The strategy used to represent objects
returned in a resultset is called 'hydration mode':

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Resultset;
    use Store\Toys\Robots;

    $robots = Robots::find();

    // Return every robot as an array
    $robots->setHydrateMode(
        Resultset::HYDRATE_ARRAYS
    );

    foreach ($robots as $robot) {
        echo $robot["year"], PHP_EOL;
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

Hydration mode can also be passed as a parameter of 'find':

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Resultset;
    use Store\Toys\Robots;

    $robots = Robots::find(
        [
            "hydration" => Resultset::HYDRATE_ARRAYS,
        ]
    );

    foreach ($robots as $robot) {
        echo $robot["year"], PHP_EOL;
    }

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

自动生成标识列（Auto-generated identity columns）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Some models may have identity columns. These columns usually are the primary key of the mapped table. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
can recognize the identity column omitting it in the generated SQL INSERT, so the database system can generate an auto-generated value for it.
Always after creating a record, the identity field will be registered with the value generated in the database system for it:

.. code-block:: php

    <?php

    $robot->save();

    echo "The generated id is: ", $robot->id;

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` is able to recognize the identity column. Depending on the database system, those columns may be
serial columns like in PostgreSQL or auto_increment columns in the case of MySQL.

PostgreSQL uses sequences to generate auto-numeric values, by default, Phalcon tries to obtain the generated value from the sequence "table_field_seq",
for example: robots_id_seq, if that sequence has a different name, the :code:`getSequenceName()` method needs to be implemented:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function getSequenceName()
        {
            return "robots_sequence_name";
        }
    }

忽略指定列的数据（Skipping Columns）
------------------------------------
To tell :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` that always omits some fields in the creation and/or update of records in order
to delegate the database system the assignation of the values by a trigger or a default:

.. code-block:: php

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
                    "year",
                    "price",
                ]
            );

            // Skips only when inserting
            $this->skipAttributesOnCreate(
                [
                    "created_at",
                ]
            );

            // Skips only when updating
            $this->skipAttributesOnUpdate(
                [
                    "modified_in",
                ]
            );
        }
    }

This will ignore globally these fields on each INSERT/UPDATE operation on the whole application.
If you want to ignore different attributes on different INSERT/UPDATE operations, you can specify the second parameter (boolean) - true
for replacement. Forcing a default value can be done in the following way:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    use Phalcon\Db\RawValue;

    $robot = new Robots();

    $robot->name       = "Bender";
    $robot->year       = 1999;
    $robot->created_at = new RawValue("default");

    $robot->create();

A callback also can be used to create a conditional assignment of automatic default values:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;
    use Phalcon\Db\RawValue;

    class Robots extends Model
    {
        public function beforeCreate()
        {
            if ($this->price > 10000) {
                $this->type = new RawValue("default");
            }
        }
    }

.. highlights::

    Never use a :doc:`Phalcon\\Db\\RawValue <../api/Phalcon_Db_RawValue>` to assign external data (such as user input)
    or variable data. The value of these fields is ignored when binding parameters to the query.
    So it could be used to attack the application injecting SQL.

动态更新（Dynamic Update）
^^^^^^^^^^^^^^^^^^^^^^^^^^
SQL UPDATE statements are by default created with every column defined in the model (full all-field SQL update).
You can change specific models to make dynamic updates, in this case, just the fields that had changed
are used to create the final SQL statement.

In some cases this could improve the performance by reducing the traffic between the application and the database server,
this specially helps when the table has blob/text fields:

.. code-block:: php

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
            if ($this->status == "A") {
                echo "The robot is active, it can't be deleted";

                return false;
            }

            return true;
        }
    }

独立的列映射（Independent Column Mapping）
------------------------------------------
The ORM supports an independent column map, which allows the developer to use different column names in the model to the ones in
the table. Phalcon will recognize the new column names and will rename them accordingly to match the respective columns in the database.
This is a great feature when one needs to rename fields in the database without having to worry about all the queries
in the code. A change in the column map in the model will take care of the rest. For example:

.. code-block:: php

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
                "id"       => "code",
                "the_name" => "theName",
                "the_type" => "theType",
                "the_year" => "theYear",
            ];
        }
    }

Then you can use the new names naturally in your code:

.. code-block:: php

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
            "order" => "theType DESC",
        ]
    );

    foreach ($robots as $robot) {
        echo "Code: ", $robot->code, "\n";
    }

    // Create a robot
    $robot = new Robots();

    $robot->code    = "10101";
    $robot->theName = "Bender";
    $robot->theType = "Industrial";
    $robot->theYear = 2999;

    $robot->save();

Take into consideration the following the next when renaming your columns:

* References to attributes in relationships/validators must use the new names
* Refer the real column names will result in an exception by the ORM

The independent column map allow you to:

* Write applications using your own conventions
* Eliminate vendor prefixes/suffixes in your code
* Change column names without change your application code

记录快照（Record Snapshots）
----------------------------
Specific models could be set to maintain a record snapshot when they're queried. You can use this feature to implement auditing or just to know what
fields are changed according to the data queried from the persistence:

.. code-block:: php

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

When activating this feature the application consumes a bit more of memory to keep track of the original values obtained from the persistence.
In models that have this feature activated you can check what fields changed:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Get a record from the database
    $robot = Robots::findFirst();

    // Change a column
    $robot->name = "Other name";

    var_dump($robot->getChangedFields()); // ["name"]

    var_dump($robot->hasChanged("name")); // true

    var_dump($robot->hasChanged("type")); // false

设置模式（Pointing to a different schema）
------------------------------------------
如果一个模型映射到一个在非默认的schemas/数据库中的表，你可以通过 :code:`setSchema()` 方法去定义它：

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->setSchema("toys");
        }
    }

设置多个数据库（Setting multiple databases）
--------------------------------------------
在Phalcon中，所有模型可以属于同一个数据库连接，也可以分属独立的数据库连接。实际上，当 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
需要连接数据库的时候，它在应用服务容器内请求"db"这个服务。 可以通过在 :code:`initialize()` 方法内重写这个服务的设置。

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as MysqlPdo;
    use Phalcon\Db\Adapter\Pdo\PostgreSQL as PostgreSQLPdo;

    // This service returns a MySQL database
    $di->set(
        "dbMysql",
        function () {
            return new MysqlPdo(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );
        }
    );

    // This service returns a PostgreSQL database
    $di->set(
        "dbPostgres",
        function () {
            return new PostgreSQLPdo(
                [
                    "host"     => "localhost",
                    "username" => "postgres",
                    "password" => "",
                    "dbname"   => "invo",
                ]
            );
        }
    );

然后，在 :code:`initialize()` 方法内，我们为这个模型定义数据库连接。

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->setConnectionService("dbPostgres");
        }
    }

另外Phalcon还提供了更多的灵活性，你可分别定义用来读取和写入的数据库连接。这对实现主从架构的数据库负载均衡非常有用。
（译者注：EvaEngine项目为使用Phalcon提供了更多的灵活性，推荐了解和使用）

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function initialize()
        {
            $this->setReadConnectionService("dbSlave");

            $this->setWriteConnectionService("dbMaster");
        }
    }

另外ORM还可以通过根据当前查询条件来实现一个 'shard' 选择器，来实现水平切分的功能。

.. code-block:: php

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
            if (isset($intermediate["where"])) {
                $conditions = $intermediate["where"];

                // Choose the possible shard according to the conditions
                if ($conditions["left"]["name"] == "id") {
                    $id = $conditions["right"]["value"];

                    if ($id > 0 && $id < 10000) {
                        return $this->getDI()->get("dbShard1");
                    }

                    if ($id > 10000) {
                        return $this->getDI()->get("dbShard2");
                    }
                }
            }

            // Use a default shard
            return $this->getDI()->get("dbShard0");
        }
    }

:code:`selectReadConnection()` 方法用来选择正确的数据库连接，这个方法拦截任何新的查询操作：

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst('id = 101');

注入服务到模型（Injecting services into Models）
------------------------------------------------
你可能需要在模型中用到应用中注入的服务，下面的例子会教你如何去做：

.. code-block:: php

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

每当 "create" 或者 "update" 操作失败时会触发 "notSave" 事件。所以我们从DI中获取 "flash" 服务并推送确认消息。这样的话，我们不需要每次在save之后去打印信息。

禁用或启用特性（Disabling/Enabling Features）
---------------------------------------------
In the ORM we have implemented a mechanism that allow you to enable/disable specific features or options globally on the fly.
According to how you use the ORM you can disable that you aren't using. These options can also be temporarily disabled if required:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    Model::setup(
        [
            "events"         => false,
            "columnRenaming" => false,
        ]
    );

The available options are:

+---------------------+---------------------------------------------------------------------------------------+---------------+
| Option              | Description                                                                           | Default       |
+=====================+=======================================================================================+===============+
| events              | Enables/Disables callbacks, hooks and event notifications from all the models         | :code:`true`  |
+---------------------+---------------------------------------------------------------------------------------+---------------+
| columnRenaming      | Enables/Disables the column renaming                                                  | :code:`true`  |
+---------------------+---------------------------------------------------------------------------------------+---------------+
| notNullValidations  | The ORM automatically validate the not null columns present in the mapped table       | :code:`true`  |
+---------------------+---------------------------------------------------------------------------------------+---------------+
| virtualForeignKeys  | Enables/Disables the virtual foreign keys                                             | :code:`true`  |
+---------------------+---------------------------------------------------------------------------------------+---------------+
| phqlLiterals        | Enables/Disables literals in the PHQL parser                                          | :code:`true`  |
+---------------------+---------------------------------------------------------------------------------------+---------------+
| lateStateBinding    | Enables/Disables late state binding of the :code:`Mvc\Model::cloneResultMap()` method | :code:`false` |
+---------------------+---------------------------------------------------------------------------------------+---------------+

独立的组件（Stand-Alone component）
-----------------------------------
Using :doc:`Phalcon\\Mvc\\Model <models>` in a stand-alone mode can be demonstrated below:

.. code-block:: php

    <?php

    use Phalcon\Di;
    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Manager as ModelsManager;
    use Phalcon\Db\Adapter\Pdo\Sqlite as Connection;
    use Phalcon\Mvc\Model\Metadata\Memory as MetaData;

    $di = new Di();

    // Setup a connection
    $di->set(
        "db",
        new Connection(
            [
                "dbname" => "sample.db",
            ]
        )
    );

    // Set a models manager
    $di->set(
        "modelsManager",
        new ModelsManager()
    );

    // Use the memory meta-data adapter or other
    $di->set(
        "modelsMetadata",
        new MetaData()
    );

    // Create a model
    class Robots extends Model
    {

    }

    // Use the model
    echo Robots::count();

.. _PDO: http://php.net/manual/zh/pdo.prepared-statements.php
