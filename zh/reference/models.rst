使用模型(Working with Models)
======================================
在应用程序中，模型是代表的是一种数据以及通过一些规则来操作这些数据，模型主要用于通过一些规则使其与数据库表进行相互操作，在大多数情况下，每个数据库表将对应到一个模型，整个应用程序的业务逻辑都会集中在模型中。

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 是应用程序中所有模型的基类，它保证了数据库的独立性，基本的CURD操作，高级的查询功能，多表关联等功能。

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 提供了SQL语句的动态转化功能，避免了直接使用SQL语句带来的安全风险。

.. highlights::

   Models是数据库的高级抽象层，如果您需要与数据库直接打交道，你可以查看 :doc:`Phalcon\\Db <../api/Phalcon_Db>` 组件文档。

创建模型
---------------
一个Model就是一个继承自 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 的类文件，它必须放到models文件夹目录下，一个Model文件必须是一个独立的类文件，同时它的命名采用驼蜂式的书写方法：

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

    }

上面的例子是一个 "Robots"模型类，需要注意的是，类Robots继承自 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`。因为继承，该模型提供了大量的功能，包括基本的数据库CRUDCreate, Read, Update, Destroy) 操作，数据验证，先进的检索功能，并且可以同时关联多个模型。

.. highlights::

    推荐你使用PHP5.4版本，这可以使得模型中的属性在保存到内存时，更节省内存。

默认情况下，模型"Robots"对应的是数据库表"robots"，如果你想手工指定映射到其他的数据库表，你可以使用 getSource() 方法：

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSource()
        {
            return "the_robots";
        }

    }

此时，模型"Robots"映射到数据库表"the_robots"，initialize()方法有助于在模型中建立自定义行为，如，不同的数据表。initialize()方法在请求期间只被调用一次。

在模型中使用命名空间
--------------------
命名空间可以用来避免类名冲突，在这种情况下，使用getSource()方法来指定数据表名称是必要的：

.. code-block:: php

    <?php

    namespace Store\Toys;

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSource()
        {
            return "robots";
        }

    }

Understanding Records To Objects
--------------------------------
每一个模型对象表示数据表中的一行数据，你可以轻松的通过读取对象的属性来访问数据。举个例子，数据表"robots"的记录如下：

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

你可以通过数据库主键查找某条记录，然后打印出它们的名字：

.. code-block:: php

    <?php

    // Find record with id = 3
    $robot = Robots::findFirst(3);

    // Prints "Terminator"
    echo $robot->name;

一旦记录被读取到内存中，你可以修改它的数据，然后保存更改：

.. code-block:: php

    <?php

    $robot = Robots::findFirst(3);
    $robot->name = "RoboCop";
    $robot->save();

正如你所看到的，这里没有使用原始的SQL语句。:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 为web应用程序提供了高度的数据库抽象。

查找记录
---------------
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 还提供了多种方法来查询数据记录。下面的例子将为你展示如何通过Model查询单条以及多条记录：

.. code-block:: php

    <?php

    // How many robots are there?
    $robots = Robots::find();
    echo "There are ", count($robots), "\n";

    // How many mechanical robots are there?
    $robots = Robots::find("type = 'mechanical'");
    echo "There are ", count($robots), "\n";

    // Get and print virtual robots ordered by name
    $robots = Robots::find(array(
        "type = 'virtual'",
        "order" => "name"
    ));
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // Get first 100 virtual robots ordered by name
    $robots = Robots::find(array(
        "type = 'virtual'",
        "order" => "name",
        "limit" => 100
    ));
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

你也可以使用findFirst()方法来获取给定条件下的第一条记录：

.. code-block:: php

    <?php

    // What's the first robot in robots table?
    $robot = Robots::findFirst();
    echo "The robot name is ", $robot->name, "\n";

    // What's the first mechanical robot in robots table?
    $robot = Robots::findFirst("type = 'mechanical'");
    echo "The first mechanical robot name is ", $robot->name, "\n";

    // Get first virtual robot ordered by name
    $robot = Robots::findFirst(array("type = 'virtual'", "order" => "name"));
    echo "The first virtual robot name is ", $robot->name, "\n";

find()和findFirst()这两个方法都接收一个关联数组作为检索条件：

.. code-block:: php

    <?php

    $robot = Robots::findFirst(
        array(
            "type = 'virtual'",
            "order" => "name DESC",
            "limit" => 30
        )
    );

    $robots = Robots::find(
        array(
            "conditions" => "type = ?1",
            "bind"       => array(1 => "virtual")
        )
    );

可用的查询选项列表：

+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| Parameter   | Description                                                                                                                                                                                      | Example                                                                 |
+=============+==================================================================================================================================================================================================+=========================================================================+
| conditions  | Search conditions for the find operation. Is used to extract only those records that fulfill a specified criterion. By default Phalcon\Mvc\Model assumes the first parameter are the conditions. | "conditions" => "name LIKE 'steve%'"                                    |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| bind        | Bind is used together with options, by replacing placeholders and escaping values thus increasing security                                                                                       | "bind" => array("status" => "A", "type" => "some-time")                 |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| bindTypes   | When binding parameters, you can use this parameter to define additional casting to the bound parameters increasing even more the security                                                       | "bindTypes" => array(Column::BIND_TYPE_STR, Column::BIND_TYPE_INT)      |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| order       | Is used to sort the resultset. Use one or more fields separated by commas.                                                                                                                       | "order" => "name DESC, status"                                          |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| limit       | Limit the results of the query to results to certain range                                                                                                                                       | "limit" => 10                                                           |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| group       | Allows to collect data across multiple records and group the results by one or more columns                                                                                                      | "group" => "name, status"                                               |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| for_update  | With this option, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` reads the latest available data, setting exclusive locks on each row it reads                                            | "for_update" => true                                                    |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| shared_lock | With this option, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` reads the latest available data, setting shared locks on each row it reads                                               | "shared_lock" => true                                                   |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| cache       | Cache the resulset, reducing the continuous access to the relational system                                                                                                                      | "cache" => array("lifetime" => 3600, "key" => "my-find-key")            |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+

如果你愿意，你也可以通过面向对象的方式创建查询，而不是使用上面讲到的关联数组的形式：

.. code-block:: php

    <?php

    $robots = Robots::query()
        ->where("type = :type:")
        ->bind(array("type" => "mechanical"))
        ->order("name")
        ->execute();

静态方法 query()返回一个 :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` 的实例化对象，因此它对IDE自动提示功能非常友好。


所有的查询都被进行内部处理成 :doc:`PHQL <phql>` 。PHQL是一个高层次的，面向对象的类SQL语言。这种语言为你提供更多的功能来进行查询，如与其他模型关联查询，定义分组，添加聚合等。

模型数据集(Model Resultsets)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
findFirst()方法直接返回一个类的实例对象(查询有数据返回的时候)，find()方法则返回:doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>` 的一个实例对象，这个对象是一个封装了所有功能的结果集，比如像数据遍历，寻找特定的数据记录，计数等等。

这些对象比标准数组更为强大，最大的优点之一是  :doc:`Phalcon\\Mvc\\Model\\Resultset <../api/Phalcon_Mvc_Model_Resultset>` 在任何时候它在内存中只保存一条记录，这极大的优化了内存管理，特别是处理大量数据的时候。

.. code-block:: php

    <?php

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
    $robot = $robots->current()

    // Access a robot by its position in the resultset
    $robot = $robots[5];

    // Check if there is a record in certain position
    if (isset($robots[3]) {
       $robot = $robots[3];
    }

    // Get the first record in the resultset
    $robot = robots->getFirst();

    // Get the last record
    $robot = robots->getLast();

Phalcon数据集模拟游标的方式，你可以获取任意一行数据，只需要通过访问其位置，或者通过移动内部指针到一个特定的位置。需要注意的是，一些数据库系统并不支持游标，这将会导致每次强制重新执行，游标移动到头部，并从头到尾去查询请求位置。同理，如果一个结果集遍历多次，查询必须被执行相同的次数。

大量的查询结果存储在内存中，会消耗大量的资源。resultsets are obtained
from the database in chunks of 32 rows reducing the need for re-execute the request in several cases.

请注意，结果集可以被序列化后存储到缓存中。:doc:`Phalcon\\Cache <cache>` 可以帮助完成这项任务。However,
serializing data causes :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` to retrieve all the data from the database in an array,
thus consuming more memory while this process takes place.

.. code-block:: php

    <?php

    // Query all records from model parts
    $parts = Parts::find();

    // Store the resultset into a file
    file_put_contents("cache.txt", serialize($parts));

    // Get parts from file
    $parts = unserialize(file_get_contents("cache.txt"));

    // Traverse the parts
    foreach ($parts as $part) {
       echo $part->id;
    }

参数绑定
^^^^^^^^^^^^^^^^^^
在 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 同样支持参数类型绑定。虽然会有比较小的性能消耗，但我们推荐你使用这种方法，因为它会清除SQL注入攻击，字符串过滤及整形数据验证等。绑定绑定，可以通过如下方式实现：

.. code-block:: php

    <?php

    // Query robots binding parameters with string placeholders
    $conditions = "name = :name: AND type = :type:";

    //Parameters whose keys are the same as placeholders
    $parameters = array(
        "name" => "Robotina",
        "type" => "maid"
    );

    //Perform the query
    $robots = Robots::find(array(
        $conditions,
        "bind" => $parameters
    ));

    // Query robots binding parameters with integer placeholders
    $conditions = "name = ?1 AND type = ?2";
    $parameters = array(1 => "Robotina", 2 => "maid");
    $robots     = Robots::find(array(
        $conditions,
        "bind" => $parameters
    ));

    // Query robots binding parameters with both string and integer placeholders
    $conditions = "name = :name: AND type = ?1";

    //Parameters whose keys are the same as placeholders
    $parameters = array(
        "name" => "Robotina",
        1 => "maid"
    );

    //Perform the query
    $robots = Robots::find(array(
        $conditions,
        "bind" => $parameters
    ));

当使用数字时，你可能需要定义他们为整形数字。比如 1或2， 在这种情况下，有可能是字符串"1"或"2"，而不是数字，所以这是不正确的。

在使用 PDO_ 的时候字符串是被自动转义的，此功能和数据库连接的字符集有关，所以在进行数据库连接时，必须设置正确的连接参数或者在数据库中设置好，错误的字符集会导致数据在存储读取时产生意想不到的结果。

此外，你还可以通过设置参数"bindTypes"，定义参数的数据类型：

.. code-block:: php

    <?php

    //Bind parameters
    $parameters = array(
        "name" => "Robotina",
        "year" => 2008
    );

    //Casting Types
    $types = array(
        Phalcon\Db\Column::BIND_PARAM_STR,
        Phalcon\Db\Column::BIND_PARAM_INT
    );

    // Query robots binding parameters with string placeholders
    $conditions = "name = :name: AND year = :year:";
    $robots = Robots::find(array(
        $conditions,
        "bind" => $parameters,
        "bindTypes" => $types
    ));


参数绑定可以用于所有的查询方法上，比如find()和findFirst()。当然也包括一些计算类的方法，如 count(),sum(),average()等。

模型之间的关系
----------------------------
共有四种类型的关系：一对一，一对多，多对一，多对多。关系可以是单向也可以是双向的，并且每个可以是简单的(一个一个的Model)或者更复杂的(组合Model)。模型管理器管理这些关系的外键约束，这将有助于定义参照完整性以及方便快捷的访问关联数据。通过关系映射，可以在一个记录中很容易的访问相关模型中的数据。

单向关系
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Unidirectional relations are those that are generated in relation to one another but not vice versa.

双向关系
^^^^^^^^^^^^^^^^^^^^^^^
The bidirectional relations build relationships in both models and each model defines the inverse relationship of the other.

定义关系
^^^^^^^^^^^^^^^^^^^^^^
在Phalcon中，关系的定义必须在model的initialize()方法中进行定义，通过方法belongsTo(),hasOne(), hasMany() 进行关联关系，用当前模型的属性关联其他模型。这几个方法都需要3个参数，即： 当前模型属性，关联模型名称，关联模型的属性。

+-----------+----------------------------+
| Method    | Description                |
+===========+============================+
| hasMany   | Defines a 1-n relationship |
+-----------+----------------------------+
| hasOne    | Defines a 1-1 relationship |
+-----------+----------------------------+
| belongsTo | Defines a n-1 relationship |
+-----------+----------------------------+

下面的schema显示了三个数据表的关系，用这个作为例子有助于我们更好的理解：

.. code-block:: sql

    CREATE TABLE `robots` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(70) NOT NULL,
        `type` varchar(32) NOT NULL,
        `year` int(11) NOT NULL,
        PRIMARY KEY (`id`)
    );

    CREATE TABLE `robots_parts` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `robots_id` int(10) NOT NULL,
        `parts_id` int(10) NOT NULL,
        `created_at` DATE NOT NULL,
        PRIMARY KEY (`id`),
        KEY `robots_id` (`robots_id`),
        KEY `parts_id` (`parts_id`)
    );

    CREATE TABLE `parts` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(70) NOT NULL,
        PRIMARY KEY (`id`)
    );

* The model "Robots" has many "RobotsParts".
* The model "Parts" has many "RobotsParts".
* The model "RobotsParts" belongs to both "Robots" and "Parts" models as a one-to-many relation.

在模型中他们的实现方法是这样的：

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->hasMany("id", "RobotsParts", "robots_id");
        }

    }

.. code-block:: php

    <?php

    class Parts extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->hasMany("id", "RobotsParts", "parts_id");
        }

    }

.. code-block:: php

    <?php

    class RobotsParts extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->belongsTo("robots_id", "Robots", "id");
            $this->belongsTo("parts_id", "Parts", "id");
        }

    }

在映射关系中，第一个参数是当前模型的属性，第二个参数为关联模型的类名称，第三个参数为关联模型的属性。你也可以在映射关系中使用数组定义多个属性。

Taking advantage of relationships
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
当明确定义了模型之间的关系后，就很容易通过查找到的记录找到相关模型的记录

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);
    foreach ($robot->getRobotsParts() as $robotPart) {
        echo $robotPart->getParts()->name, "\n";
    }

Phalcon使用魔术方法 __call来获得关联模型的数据。如果被调用的方法中含有"get"前辍，:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 将返回 findFirst()/find()的结果集。下面的示例展示了使用和未使用魔术方法获取数据的区别：

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);

    // Robots model has a 1-n (hasMany)
    // relationship to RobotsParts then
    $robotsParts = $robot->getRobotsParts();

    // Only parts that match conditions
    $robotsParts = $robot->getRobotsParts("created_at = '2012-03-15'");

    // Or using bound parameters
    $robotsParts = $robot->getRobotsParts(array(
        "created_at = :date:",
        "bind" => array("date" => "2012-03-15"
    )));

    $robotPart = RobotsParts::findFirst(1);

    // RobotsParts model has a n-1 (belongsTo)
    // relationship to RobotsParts then
    $robot = $robotPart->getRobots();

Getting related records manually:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);

    // Robots model has a 1-n (hasMany)
    // relationship to RobotsParts then
    $robotsParts = RobotsParts::find("robots_id = '" . $robot->id . "'");

    // Only parts that match conditions
    $robotsParts = RobotsParts::find(
        "robots_id = '" . $robot->id . "' AND created_at='2012-03-15'"
    );

    $robotPart = RobotsParts::findFirst(1);

    // RobotsParts model has a n-1 (belongsTo)
    // relationship to RobotsParts then
    $robot = Robots::findFirst("id = '" . $robotPart->robots_id . "'");


前辍"get"使用find()/findFirst()来获取关联记录。当然你也可以"count"前辍来获取记录的数量：

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);
    echo "The robot have ", $robot->countRobotsParts(), " parts\n";

虚拟外键
^^^^^^^^^^^^^^^^^^^^
默认情况下，关联关系并不定义外键约束，也就是说，如果你尝试insert/update数据的话，将不会进行外键验证，Phalcon也不会提示验证信息。你可以修改此行为，增加一个参数定义这种关系。

RobotsPart模型可以这样修改，以实现此功能：

.. code-block:: php

    <?php

    class RobotsParts extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->belongsTo("robots_id", "Robots", "id", array(
                "foreignKey" => true
            ));

            $this->belongsTo("parts_id", "Parts", "id", array(
                "foreignKey" => array(
                    "message" => "The part_id does not exist on the parts model"
                )
            ));
        }

    }

如果你在belongsTo()中设置了外键约束，它将会验证insert/update的值是不是一个有效的值。同样地，如果你在hasMany()/hasOne()中设置了外键约束，它将会验证记录是否可以删除。

.. code-block:: php

    <?php

    class Parts extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->hasMany("id", "RobotsParts", "parts_id", array(
                "foreignKey" => array(
                    "message" => "The part cannot be deleted because other robots are using it"
                )
            ));
        }

    }

Generating Calculations
-----------------------
数量统计是数据库中常用的功能，如COUNT,SUM,MAX,MIN,AVG. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 可以通过公开的方法实现此种功能。

Count examples:

.. code-block:: php

    <?php

    // How many employees are?
    $rowcount = Employees::count();

    // How many different areas are assigned to employees?
    $rowcount = Employees::count(array("distinct" => "area"));

    // How many employees are in the Testing area?
    $rowcount = Employees::count("area = 'Testing'");

    //Count employees grouping results by their area
    $group = Employees::count(array("group" => "area"));
    foreach ($group as $row) {
       echo "There are ", $group->rowcount, " in ", $group->area;
    }

    // Count employees grouping by their area and ordering the result by count
    $group = Employees::count(
        array(
            "group" => "area",
            "order" => "rowcount"
        )
    );

Sum examples:

.. code-block:: php

    <?php

    // How much are the salaries of all employees?
    $total = Employees::sum(array("column" => "salary"));

    // How much are the salaries of all employees in the Sales area?
    $total = Employees::sum(
        array(
            "column"     => "salary",
            "conditions" => "area = 'Sales'"
        )
    );

    // Generate a grouping of the salaries of each area
    $group = Employees::sum(
        array(
            "column" => "salary",
            "group"  => "area"
        )
    );
    foreach ($group as $row) {
       echo "The sum of salaries of the ", $group->area, " is ", $group->sumatory;
    }

    // Generate a grouping of the salaries of each area ordering
    // salaries from higher to lower
    $group = Employees::sum(
        array(
            "column" => "salary",
            "group"  => "area",
            "order"  => "sumatory DESC"
        )
    );

Average examples:

.. code-block:: php

    <?php

    // What is the average salary for all employees?
    $average = Employees::average(array("column" => "salary"));

    // What is the average salary for the Sales's area employees?
    $average = Employees::average(
        array(
            "column" => "salary",
            "conditions" => "area = 'Sales'"
        )
    );

Max/Min examples:

.. code-block:: php

    <?php

    // What is the oldest age of all employees?
    $age = Employees::maximum(array("column" => "age"));

    // What is the oldest of employees from the Sales area?
    $age = Employees::maximum(
        array(
            "column" => "age",
            "conditions" => "area = 'Sales'"
        )
    );

    // What is the lowest salary of all employees?
    $salary = Employees::minimum(array("column" => "salary"));

缓存结果集
^^^^^^^^^^^^^^^^^^
频繁访问数据库往往是WEB应用性能方面最常见的瓶颈之一。这是由于复杂的连接过程，PHP必须在每个请求都从数据库获取数据。一个较完善的技术架构是，将不经常改变的结果集缓存到系统中可以更快访问的地方（通常是内存）。

当 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 需要缓存结果集时，它会依赖于容器中的"modelsCache"这个服务。

Phalcon提供了一个组件缓存任何类型的数据，我们下面将介绍它如何与模型一块工作。首先，你需要把它作为一个服务注册到服务容器中：

.. code-block:: php

    <?php

    //Set the models cache service
    $di->set('modelsCache', function(){

        //Cache data for one day by default
        $frontCache = new Phalcon\Cache\Frontend\Data(array(
            "lifetime" => 86400
        ));

        //Memcached connection settings
        $cache = new Phalcon\Cache\Backend\Memcached($frontCache, array(
            "host" => "localhost",
            "port" => "11211"
        ));

        return $cache;
    });

你可以创建和自定义缓存规则，然后作为一个匿名函数使用它们。一量缓存被正确设置，可以按如下方式缓存结果集：

.. code-block:: php

    <?php

    // Get products without caching
    $products = Products::find();

    // Just cache the resultset. The cache will expire in 1 hour (3600 seconds)
    $products = Products::find(array("cache" => true));

    // Cache the resultset only for 5 minutes
    $products = Products::find(array("cache" => 300));

    // Cache the resultset with a key pre-defined
    $products = Products::find(array("cache" => array("key" => "my-products-key")));

    // Cache the resultset with a key pre-defined and for 2 minutes
    $products = Products::find(
        array(
            "cache" => array(
                "key"      => "my-products-key",
                "lifetime" => 120
            )
        )
    );

    // Using a custom cache
    $products = Products::find(array("cache" => $myCache));

默认情况下，:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 将创建一个唯一的KEY来保存结果集数据，它使用md5 hash内部SQL语句的方式来生成唯一KEY，这将是非常实用的，因为它会产生一个新的唯一的KEY值。如果你想改变KEY值，你可以像上面的示例一样随时使用key参数进行指定，getLastKey()方法检索最后的缓存KEY值，这样就可以从缓存中定位和检索结果集：

.. code-block:: php

    <?php

    // Cache the resultset using an automatic key
    $products = Products::find(array("cache" => 3600));

    // Get last generated key
    $automaticKey = $products->getCache()->getLastKey();

    // Use resultset as normal
    foreach($products as $product){
        //...
    }

缓存的KEY是通过 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 自动生成的，而且问题以"phc"为前辍，这将有助于识别此类缓存KEY是与 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 相关的：

.. code-block:: php

    <?php

    // Set the cache to the models manager
    $cache = $di->getModelsCache();

    // Get keys created by Phalcon\Mvc\Model
    foreach ($cache->queryKeys("phc") as $key) {
         echo $key, "\n";
    }

请注意，并非所有的结果集都必须被缓存。变化非常频繁的结果不应该被缓存起来，因为在这种情况下他们是无效的，而且会影响性能。此外，不经常更改的大数据集可以被缓存，但是否一定需要缓存得衡量一下，不对性能造成一定的影响，还是可以按受的。

同样，缓存系统也可以应用于使用关联关系生成的结果集：

.. code-block:: php

    <?php

    // Query some post
    $post = Post::findFirst();

    // Get comments related to a post, also cache it
    $comments = $post->getComments(array("cache" => true));

    // Get comments related to a post, setting lifetime
    $comments = $post->getComments(array("cache" => true, "lifetime" => 3600));

当获取缓存结果集失败时，你可以简单的通过它的KEY值从缓存系统中删除它。

Creating/Updating Records
-------------------------
Phalcon\\Mvc\\Model::save() 方法允许你创建/更新记录。save方法自动调用 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 内部的create和update方法，如果想达到预期般的工作效果，正确定义实体主键是非常必须的，以确保创建和更新记录成功。

同时，方法的执行关联到 validators,虚拟外键以及在模型中定义的事件：

.. code-block:: php

    <?php

    $robot       = new Robots();
    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;
    if ($robot->save() == false) {
        echo "Umh, We can't store robots right now: \n";
        foreach ($robot->getMessages() as $message) {
            echo $message, "\n";
        }
    } else {
        echo "Great, a new robot was saved successfully!";
    }

save方法还可以直接通过传入一个数组的形式进行保存数据，Phalcon\\Mvc\\Model 会自动完成数组和对象的绑定的，而不需要直接指定对象的属性值：

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->save(array(
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952
    ));

数据直接赋值或通过数组绑定，这些数据都会根据相关的数据类型被escaped/sanitized，所以你可以传递一个不安全的数组，而不必担心发生SQL注入：

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->save($_POST);

Create/Update with Certainty
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
当一个应用程序有很多的竞争的时候，也许我们希望创建一个记录，但实际上是更新一个记录（想不到老外也搞作孽，哈哈）。如果我们使用Phalcon\\Mvc\\Model::save()保存数据到数据库，首先我们得确定我们的记录是将被创建还是更新：

.. code-block:: php

    <?php

    $robot       = new Robots();
    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    //This record only must be created
    if ($robot->create() == false) {
        echo "Umh, We can't store robots right now: \n";
        foreach ($robot->getMessages() as $message) {
            echo $message, "\n";
        }
    } else {
        echo "Great, a new robot was created successfully!";
    }

方法"create"和"update"都接受数组作为参数.

Auto-generated identity columns
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
有些模型可能有标识列。这些列通常是映射数据表的主键。  :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 可以识别标识列，同时会忽略它内部的SQL INSERT，所以数据库系统能够生成一个自动生成的值。在创建一个记录后，标识列总是会通过数据库系统产生一个值：

.. code-block:: php

    <?php

    $robot->save();
    echo "The generated id is: ", $robot->id;

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 能够识别标识列。根据不同的数据库系统，这些列可能是串行列，例如PostgreSQL以及MYSQL的auto_increment列。

PostgreSQL使用序列来生成自动的数值，默认情况下，Phalcon试图多序列table_field_seq来获得生成的值，例如：robots_id_seq，如果该序列具有不同的名称，"getSequenceName"方法需要明确指定：

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSequenceName()
        {
            return "robots_sequence_name";
        }

    }

Validation Messages
^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 有一个消息传递子系统，它提供了一个灵活的输出方式，或存储在insert/update过程中的验证消息。

每个消息都是类 :doc:`Phalcon\\Mvc\\Model\\Message <../api/Phalcon_Mvc_Model_Message>` 的一个实例对象。生成的该组消息可以通过getMessages()方法来获取。每个消息都提供了扩展的信息，如字段名称，同时产生了消息及消息类型：

.. code-block:: php

    <?php

    if ($robot->save() == false) {
        foreach ($robot->getMessages() as $message) {
            echo "Message: ", $message->getMessage();
            echo "Field: ", $message->getField();
            echo "Type: ", $message->getType();
        }
    }

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 也可以产生以下类型的验证消息：

+---------------------+------------------------------------------------------------------------------------------------------------------------------------+
| Type                | Description                                                                                                                        |
+=====================+====================================================================================================================================+
| PresenceOf          | Generated when a field with a non-null attribute on the database is trying to insert/update a null value                           |
+---------------------+------------------------------------------------------------------------------------------------------------------------------------+
| ConstraintViolation | Generated when a field part of a virtual foreign key is trying to insert/update a value that doesn't exist in the referenced model |
+---------------------+------------------------------------------------------------------------------------------------------------------------------------+
| InvalidValue        | Generated when a validator failed because of an invalid value                                                                      |
+---------------------+------------------------------------------------------------------------------------------------------------------------------------+

验证事件及事件管理
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
模型允许你实现事件，当执行insert和update的时候，这些事件将被抛出。他们帮助你定义业务规则。以下是 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 支持的事件以及他们的执行顺序：

+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Operation          | Name                     | Can stop operation?   | Explanation                                                                                                         |
+====================+==========================+=======================+=====================================================================================================================+
| Inserting/Updating | beforeValidation         | YES                   | Is executed before the fields are validated for not nulls or foreign keys                                           |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting          | beforeValidationOnCreate | YES                   | Is executed before the fields are validated for not nulls or foreign keys when an insertion operation is being made |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Updating           | beforeValidationOnUpdate | YES                   | Is executed before the fields are validated for not nulls or foreign keys when an updating operation is being made  |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | onValidationFails        | YES (already stopped) | Is executed after an integrity validator fails                                                                      |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting          | afterValidationOnCreate  | YES                   | Is executed after the fields are validated for not nulls or foreign keys when an insertion operation is being made  |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Updating           | afterValidationOnUpdate  | YES                   | Is executed after the fields are validated for not nulls or foreign keys when an updating operation is being made   |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | afterValidation          | YES                   | Is executed after the fields are validated for not nulls or foreign keys                                            |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | beforeSave               | YES                   | Runs before the required operation over the database system                                                         |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Updating           | beforeUpdate             | YES                   | Runs before the required operation over the database system only when an updating operation is being made           |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting          | beforeCreate             | YES                   | Runs before the required operation over the database system only when an inserting operation is being made          |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Updating           | afterUpdate              | NO                    | Runs after the required operation over the database system only when an updating operation is being made            |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting          | afterCreate              | NO                    | Runs after the required operation over the database system only when an inserting operation is being made           |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | afterSave                | NO                    | Runs after the required operation over the database system                                                          |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+

为了使模型对事件作出反应，我们必须实现一个方法具有相同名称的事件：

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function beforeValidationOnCreate()
        {
            echo "This is executed before create a Robot!";
        }

    }

事件同样可以在执行一个操作之前做赋值操作，这将会很有用，下面是示例：

.. code-block:: php

    <?php

    class Products extends \Phalcon\Mvc\Model
    {

        public function beforeCreate()
        {
            //Set the creation date
            $this->created_at = date('Y-m-d H:i:s');
        }

        public function beforeUpdate()
        {
            //Set the modification date
            $this->modified_in = date('Y-m-d H:i:s');
        }

    }

此外，该组件将与 :doc:`Phalcon\\Events\\Manager <../api/Phalcon_Events_Manager>` 一同工作，这意味着当事件被触发时，我们可以创建监听器。

.. code-block:: php

    <?php

    $eventsManager = new Phalcon\Events\Manager();

    //Attach an anonymous function as a listener for "model" events
    $eventsManager->attach('model', function($event, $robot) {
        if ($event->getType() == 'beforeSave') {
            if ($robot->name == 'Scooby Doo') {
                echo "Scooby Doo isn't a robot!";
                return false;
            }
        }
        return true;
    });

    $robot = new Robots();
    $robot->setEventsManager($eventsManager);
    $robot->name = 'Scooby Doo';
    $robot->year = 1969;
    $robot->save();

在上面的例子中，事件管理只是作为对象和监听器（匿名函数）之间的桥梁。如果我们想要在我们的应用程序中创建的所有对象使用相同的事件管理，那么我们就需要到指定的模型管理器：

.. code-block:: php

    <?php

    //Registering the modelsManager service
    $di->setShared('modelsManager', function() {

        $eventsManager = new Phalcon\Events\Manager();

        //Attach an anonymous function as a listener for "model" events
        $eventsManager->attach('model', function($event, $model){
            if (get_class($model) == 'Robots') {
                if ($event->getType() == 'beforeSave') {
                    if ($modle->name == 'Scooby Doo') {
                        echo "Scooby Doo isn't a robot!";
                        return false;
                    }
                }
            }
            return true;
        });

        //Setting a default EventsManager
        $modelsManager = new Phalcon\Mvc\Models\Manager();
        $modelsManager->setEventsManager($eventsManager);
        return $modelsManager;
    });

Implementing a Business Rule
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
当执行insert,update或delete的时候，如果有任何方法名称与上表列出的事件名称相同，模型验证将起作用。

我们建议验证方法被声明为protected，以防止业务逻辑不被公开。

下面的示例实现验证在update或insert时，year不小于0的事件：

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function beforeSave()
        {
            if ($this->year < 0) {
                echo "Year cannot be smaller than zero!";
                return false;
            }
        }

    }

有些事件返回false用于指示停止当前操作。如果一个事件没有返回任何东西，:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 将假设它返回true。

Validating Data Integrity
^^^^^^^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 提供了几个事件来验证数据，并实现业务规则。特殊的"validation"事件能使我们能够调用内置的验证器。Phalcon发布了一些内置的验证器，可用于在这个阶段的验证。

以下示例显示了如何使用它：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Validator\InclusionIn;
    use Phalcon\Mvc\Model\Validator\Uniqueness;

    class Robots extends \Phalcon\Mvc\Model
    {

        public function validation()
        {

            $this->validate(new InclusionIn(
                array(
                    "field"  => "type",
                    "domain" => array("Mechanical", "Virtual")
                )
            ));

            $this->validate(new Uniqueness(
                array(
                    "field"   => "name",
                    "message" => "The robot name must be unique"
                )
            ));

            return $this->validationHasFailed() != true;
        }

    }

上面的例子中，使用内置的验证器“InclusionIn”执行验证。检查值在域列表中的“type”。如果该值没有被包括在该方法中，那么验证程序将失败并返回false。下列内置的验证器是可用的：

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Name         | Explanation                                                                                                                                                      | Example                                                           |
+==============+==================================================================================================================================================================+===================================================================+
| PresenceOf   | Validates that a field's value isn't null or empty string. This validator is automatically added based on the attributes marked as not null on the mapped table  | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_PresenceOf>`    |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Email        | Validates that field contains a valid email format                                                                                                               | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Email>`         |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| ExclusionIn  | Validates that a value is not within a list of possible values                                                                                                   | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Exclusionin>`   |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| InclusionIn  | Validates that a value is within a list of possible values                                                                                                       | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Inclusionin>`   |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Numericality | Validates that a field has a numeric format                                                                                                                      | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Numericality>`  |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Regex        | Validates that the value of a field matches a regular expression                                                                                                 | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Regex>`         |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Uniqueness   | Validates that a field or a combination of a set of fields are not present more than once in the existing records of the related table                           | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Uniqueness>`    |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| StringLength | Validates the length of a string                                                                                                                                 | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_StringLength>`  |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+

除了使用这些内置验证器，你还可以创建你自己的验证器：

.. code-block:: php

    <?php

    use \Phalcon\Mvc\Model\Validator,
        \Phalcon\Mvc\Model\ValidatorInterface;

    class UrlValidator extends Validator implements ValidatorInterface
    {

        public function validate($model)
        {
            $field = $this->getOption('field');

            $value = $model->$field;
            $filtered = filter_var($value, FILTER_VALIDATE_URL);
            if (!$filtered) {
                $this->appendMessage("The URL is invalid", $field, "UrlValidator");
                return false;
            }
            return true;
        }

    }

把你编写的验证器绑定到模型上：

.. code-block:: php

    <?php

    class Customers extends \Phalcon\Mvc\Model
    {

        public function validation()
        {
            $this->validate(new UrlValidator(
                array(
                    "field"  => "url",
                )
            ));
            if ($this->validationHasFailed() == true) {
                return false;
            }
        }

    }

创建自定义验证器，主要想法是让他们可以在不同的模型中使用，即代码复用。一个验证器也可以按以下方式实现：

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function validation()
        {
            if ($this->type == "Old") {
                $message = new Phalcon\Mvc\Model\Message(
                    "Sorry, old robots are not allowed anymore",
                    "type",
                    "MyType"
                );
                $this->appendMessage($message);
                return false;
            }
            return true;
        }

    }

避免SQL注入攻击
^^^^^^^^^^^^^^^^^^^^^^^
每个被赋值到模型属性上的值在保存到数据库之前都将按照数据类型被转义，开发人员不需要手工转义每个值。Phalcon内部使用 `bound parameters <http://php.net/manual/en/pdostatement.bindparam.php>`_ PDO提供转义。

.. code-block:: bash

    mysql> desc products;
    +------------------+------------------+------+-----+---------+----------------+
    | Field            | Type             | Null | Key | Default | Extra          |
    +------------------+------------------+------+-----+---------+----------------+
    | id               | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    | product_types_id | int(10) unsigned | NO   | MUL | NULL    |                |
    | name             | varchar(70)      | NO   |     | NULL    |                |
    | price            | decimal(16,2)    | NO   |     | NULL    |                |
    | active           | char(1)          | YES  |     | NULL    |                |
    +------------------+------------------+------+-----+---------+----------------+
    5 rows in set (0.00 sec)

如果我们只使用PDO来安全的存储一条记录，我们需要编写以下代码：

.. code-block:: php

    <?php

    $productTypesId = 1;
    $name = 'Artichoke';
    $price = 10.5;
    $active = 'Y';

    $sql = 'INSERT INTO products VALUES (null, :productTypesId, :name, :price, :active)';
    $sth = $dbh->prepare($sql);

    $sth->bindParam(':productTypesId', $productTypesId, PDO::PARAM_INT);
    $sth->bindParam(':name', $name, PDO::PARAM_STR, 70);
    $sth->bindParam(':price', doubleval($price));
    $sth->bindParam(':active', $active, PDO::PARAM_STR, 1);

    $sth->execute();

好消息是，Phalcon自动为您做到这一点：

.. code-block:: php

    <?php

    $product = new Products();
    $product->product_types_id = 1;
    $product->name = 'Artichoke';
    $product->price = 10.5;
    $product->active = 'Y';
    $product->create();

Skipping Columns
----------------
有时候，有一些数据使用数据库系统的触发器或默认值，因此我们在insert/update的时候，会忽略掉这些属性：

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            //Skips fields/columns on both INSERT/UPDATE operations
            $this->skipAttributes(array('year', 'price'));

            //Skips only when inserting
            $this->skipAttributesOnCreate(array('created_at'));

            //Skips only when updating
            $this->skipAttributesOnUpdate(array('modified_in'));
        }

    }

这时，在整个应用程序中执行insert/update的时候，都会忽略这些值的传递。
强制一个默认值，可以以下列方式进行：

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->name = 'Bender';
    $robot->year = 1999;
    $robot->created_at = new Phalcon\Db\RawValue('default');
    $robot->create();

删除记录
----------------
Phalcon\\Mvc\\Model::delete() 允许删除一条记录，你可以按如下方式使用：

.. code-block:: php

    <?php

    $robot = Robots::findFirst(11);
    if ($robot != false) {
        if ($robot->delete() == false) {
            echo "Sorry, we can't delete the robot right now: \n";
            foreach ($robot->getMessages() as $message) {
                echo $message, "\n";
            }
        } else {
            echo "The robot was deleted successfully!";
        }
    }

你也可以通过使用foreach遍历一个结果集的方式删除多条记录：

.. code-block:: php

    <?php

    foreach (Robots::find("type='mechanical'") as $robot) {
        if ($robot->delete() == false) {
            echo "Sorry, we can't delete the robot right now: \n";
            foreach ($robot->getMessages() as $message) {
                echo $message, "\n";
            }
        } else {
            echo "The robot was deleted successfully!";
        }
    }

当执行一个删除操作时，你可以使用以下事件定义一个自定义的业务规则：

+-----------+--------------+---------------------+------------------------------------------+
| Operation | Name         | Can stop operation? | Explanation                              |
+===========+==============+=====================+==========================================+
| Deleting  | beforeDelete | YES                 | Runs before the delete operation is made |
+-----------+--------------+---------------------+------------------------------------------+
| Deleting  | afterDelete  | NO                  | Runs after the delete operation was made |
+-----------+--------------+---------------------+------------------------------------------+

Validation Failed Events
------------------------

另一种类型的事件是，当你验证数据过程中发现任何不一致时：

+--------------------------+--------------------+--------------------------------------------------------------------+
| Operation                | Name               | Explanation                                                        |
+==========================+====================+====================================================================+
| Insert or Update         | notSave            | Triggered when the INSERT or UPDATE operation fails for any reason |
+--------------------------+--------------------+--------------------------------------------------------------------+
| Insert, Delete or Update | onValidationFails  | Triggered when any data manipulation operation fails               |
+--------------------------+--------------------+--------------------------------------------------------------------+

事务管理(Transactions)
-------------------------
当一个进程执行多个数据库操作时，如果要保证数据的完整性，那么它每个步骤的执行都必须保证是成功的。事务提供了在数据被提交到数据库之前，保证所有数据库操作被成功执行的能力。

在Phalcon中，事务允许你提交所有操作，如果出现了错误，你可以回滚所有的操作。

.. code-block:: php

    <?php

    try {

        //Create a transaction manager
        $manager = new Phalcon\Mvc\Model\Transaction\Manager();

        // Request a transaction
        $transaction = $manager->get();

        $robot = new Robots();
        $robot->setTransaction($transaction);
        $robot->name = "WALLÂ·E";
        $robot->created_at = date("Y-m-d");
        if ($robot->save() == false) {
            $transaction->rollback("Cannot save robot");
        }

        $robotPart = new RobotParts();
        $robotPart->setTransaction($transaction);
        $robotPart->type = "head";
        if ($robotPart->save() == false) {
            $transaction->rollback("Cannot save robot part");
        }

        //Everything goes fine, let's commit the transaction
        $transaction->commit();

    } catch(Phalcon\Mvc\Model\Transaction\Failed $e) {
        echo "Failed, reason: ", $e->getMessage();
    }

Transactions can be used to delete many records in a consistent way:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Transaction\Manager as Tx,
        Phalcon\Mvc\Model\Transaction\Failed as TxFailed;

    try {

        //Create a transaction manager
        $manager = new Tx();

        //Request a transaction
        $transaction = $manager->get();

        //Get the robots will be deleted
        foreach (Robots::find("type='mechanical'") as $robot) {
            $robot->setTransaction($transaction);
            if ($robot->delete() == false) {
                //Something goes wrong, we should to rollback the transaction
                foreach ($robot->getMessages() as $message) {
                    $transaction->rollback($message->getMessage());
                }
            }
        }

        //Everything goes fine, let's commit the transaction
        $transaction->commit();

        echo "Robots were deleted successfully!";

    } catch(TxFailed $e) {
        echo "Failed, reason: ", $e->getMessage();
    }

事务总是被重复使用。我们希望只有当commit()或rollback()被执行的时候，才会产生一个事务的实例，你可以把事务注册为整个应用程序的一个服务，当作一个整体的事务管理器使用：

.. code-block:: php

    <?php

    $di->setShared('transactions', function(){
        return new Phalcon\Mvc\Model\Transaction\Manager();
    });

然后我们可以在控制器和视图中直接访问它：

.. code-block:: php

    <?php

    class ProductsController extends \Phalcon\Mvc\Controller {

        public function saveAction()
        {

            //Obtain the TransactionsManager from the DI container
            $manager = $this->di->getTransactions();

            //Request a transaction
            $transaction = $manager->get();

        }

    }

Independent Column Mapping
--------------------------
ORM支持独立的列映射，它允许开发人员在模型中的属性不同于数据库的字段名称。Phalcon能够识别新的列名，并会相应的进行重命名，以对应数据库中的字段。
这是一个伟大的功能，当你需要重命名数据库中的字段，而不必担心代码中所有的查询。示例如下：

.. code-block:: php

    <?php

    class Robots extends Phalcon\Mvc\Model
    {

        public function columnMap()
        {
            //Keys are the real names in the table and
            //the values their names in the application
            return array(
                'id' => 'code',
                'the_name' => 'theName',
                'the_type' => 'theType',
                'the_year' => 'theYear'
            );
        }

    }

然后你就可以在你的代码中理所当然的使用新的属性名称：

.. code-block:: php

    <?php

    //Find a robot by its name
    $robot = Robots::findFirst("theName = 'Voltron'");
    echo $robot->theName, "\n";

    //Get robots ordered by type
    $robot = Robots::find(array('order' => 'theType DESC'));
    foreach ($robots as $robot) {
        echo 'Code: ', $robot->code, "\n";
    }

    //Create a robot
    $robot = new Robots();
    $robot->code = '10101';
    $robot->theName = 'Bender';
    $robot->theType = 'Industrial';
    $robot->theYear = 2999;
    $robot->save();

当有下面的情况时，你可以考虑使用新的别名：

* 在relationships/validators中，必须使用新的名称
* 列名会导致ORM的异常发生

Models Meta-Data
----------------
为了加快开发 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 帮助你从数据表中查询字段以及查询数据库的约束。要做到这一点，:doc:`Phalcon\\Mvc\\Model\\MetaData <../api/Phalcon_Mvc_Model_MetaData>` 用于管理和缓存这些元数据。

有时，需要使用模型获取那些元数据的，你可以通过以下示例获得：

.. code-block:: php

    <?php

    $robot = new Robots();

    // Get Phalcon\Mvc\Model\Metadata instance
    $metaData = $robot->getDI()->getModelsMetaData();

    // Get robots fields names
    $attributes = $metaData->getAttributes($robot);
    print_r($attributes);

    // Get robots fields data types
    $dataTypes = $metaData->getDataTypes($robot);
    print_r($dataTypes);

Caching Meta-Data
^^^^^^^^^^^^^^^^^
应用程序在一个生产阶段时，没有必要总是从数据库系统中查询元数据，你可以使用以下的几种适配器把这些元数据缓存起来：

+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+
| Adapter | Description                                                                                                                                                                                                                                                                                                                                   | API                                                                                       |
+=========+===============================================================================================================================================================================================================================================================================================================================================+===========================================================================================+
| Memory  | This adapter is the default. The meta-data is cached only during the request. When the request is completed, the meta-data are released as part of the normal memory of the request. This adapter is perfect when the application is in development so as to refresh the meta-data in each request containing the new and/or modified fields. | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Memory <../api/Phalcon_Mvc_Model_MetaData_Memory>`   |
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+
| Session | This adapter stores meta-data in the $_SESSION superglobal. This adapter is recommended only when the application is actually using a small number of models. The meta-data are refreshed every time a new session starts. This also requires the use of session_start() to start the session before using any models.                        | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Session <../api/Phalcon_Mvc_Model_MetaData_Session>` |
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+
| Apc     | The Apc adapter uses the `Alternative PHP Cache (APC)`_ to store the table meta-data. You can specify the lifetime of the meta-data with options. This is the most recommended way to store meta-data when the application is in production stage.                                                                                            | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Apc <../api/Phalcon_Mvc_Model_MetaData_Apc>`         |
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+
| Files   | This adapter uses plain files to store meta-data. By using this adapter the disk-reading is increased but the database access is reduced                                                                                                                                                                                                      | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Files <../api/Phalcon_Mvc_Model_MetaData_Files>`     |
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+

作为其他ORM的依赖，元数据需要从服务容器中获得：

.. code-block:: php

    <?php

    $di->setShared('modelsMetadata', function() {

        // Create a meta-data manager with APC
        $metaData = new Phalcon\Mvc\Model\MetaData\Apc(
            array(
                "lifetime" => 86400,
                "suffix"   => "my-suffix"
            )
        );

        return $metaData;
    });

Manual Meta-Data
^^^^^^^^^^^^^^^^
Phalcon可以自动的获得元数据，不强制开发人员必须手工设定他们。
请注意，手工定义元数据时，添加/修改/删除 数据表字段的时候，必须手工添加／修改／删除 元数据对应列，以保证一切正常工作。

下面的例子演示了如何手工定义元数据：

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\MetaData;
    use Phalcon\Db\Column;

    class Robots extends Phalcon\Mvc\Model
    {

        public function metaData()
        {
            return array(

                //Every column in the mapped table
                MetaData::MODELS_ATTRIBUTES => array(
                    'id', 'name', 'type', 'year'
                ),

                //Every column part of the primary key
                MetaData::MODELS_PRIMARY_KEY => array(
                    'id'
                ),

                //Every column that isn't part of the primary key
                MetaData::MODELS_NON_PRIMARY_KEY => array(
                    'name', 'type', 'year'
                ),

                //Every column that doesn't allows null values
                MetaData::MODELS_NOT_NULL => array(
                    'id', 'name', 'type', 'year'
                ),

                //Every column and their data types
                MetaData::MODELS_DATA_TYPES => array(
                    'id' => Column::TYPE_INTEGER,
                    'name' => Column::TYPE_VARCHAR,
                    'type' => Column::TYPE_VARCHAR,
                    'year' => Column::TYPE_INTEGER
                ),

                //The columns that have numeric data types
                MetaData::MODELS_DATA_TYPES_NUMERIC => array(
                    'id' => true,
                    'year' => true,
                ),

                //The identity column
                MetaData::MODELS_IDENTITY_COLUMN => 'id',

                //How every column must be bound/casted
                MetaData::MODELS_DATA_TYPES_BIND => array(
                    'id' => Column::BIND_PARAM_INT,
                    'name' => Column::BIND_PARAM_STR,
                    'type' => Column::BIND_PARAM_STR,
                    'year' => Column::BIND_PARAM_INT,
                ),

                //Fields that must be ignored from INSERT/UPDATE SQL statements
                MetaData::MODELS_AUTOMATIC_DEFAULT => array('year')

            );
        }

    }

Pointing to a different schema
------------------------------
如果模型映射的表不是默认的schemas/databases，你可以通过 getSchema 方法手工指定它：

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSchema()
        {
            return "toys";
        }

    }

建立多个数据库连接
-----------------------------------
在Phalcon中，所有的模型都属于一个数据库连接，实际上，当 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 需要连接数据库时，它请求服务容器中的"db"服务，在initialize方法中，您可以覆盖此服务：

.. code-block:: php

    <?php

    //This service returns a MySQL database
    $di->set('dbMysql', function() {
         return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "invo"
        ));
    });

    //This service returns a PostgreSQL database
    $di->set('dbPostgres', function() {
         return new \Phalcon\Db\Adapter\Pdo\PostgreSQL(array(
            "host" => "localhost",
            "username" => "postgres",
            "password" => "",
            "dbname" => "invo"
        ));
    });

然后，在模型的Initialize方法中，我们可以通过以下方式访问一个数据库连接：

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->setConnectionService('dbPostgres');
        }

    }

记录SQL日志
--------------------------------
当使用高层次的抽象组件，比如 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 访问数据库时，很难理解这些语句最终发送到数据库时是什么样的。 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 内部由 :doc:`Phalcon\\Db <../api/Phalcon_Db>` 支持。:doc:`Phalcon\\Logger <../api/Phalcon_Logger>` 与  :doc:`Phalcon\\Db <../api/Phalcon_Db>` 交互工作，可以提供数据库抽象层的日志记录功能，从而使我们能够记录下SQL语句。

.. code-block:: php

    <?php

    $di->set('db', function() {

        $eventsManager = new Phalcon\Events\Manager();

        $logger = new Phalcon\Logger\Adapter\File("app/logs/debug.log");

        //Listen all the database events
        $eventsManager->attach('db', function($event, $connection) use ($logger) {
            if ($event->getType() == 'beforeQuery') {
                $logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
            }
        });

        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "invo"
        ));

        //Assign the eventsManager to the db adapter instance
        $connection->setEventsManager($eventsManager);

        return $connection;
    });

当模型访问默认的数据库连接时，所有的SQL语句都会被记录在该文件中：

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->name = "Robby the Robot";
    $robot->created_at = "1956-07-21"
    if ($robot->save() == false) {
        echo "Cannot save robot";
    }

如上文所述，文件 *app/logs/db.log* 包含这样的内容：

.. code-block:: irc

    [Mon, 30 Apr 12 13:47:18 -0500][DEBUG][Resource Id #77] INSERT INTO robots
    (name, created_at) VALUES ('Robby the Robot', '1956-07-21')

剖析SQL语句
------------------------
感谢  :doc:`Phalcon\\Db <../api/Phalcon_Db>` ，作为 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 的基本组成部分，剖析ORM产生的SQL语句变得可能，以便分析数据库的性能问题，同时你可以诊断性能问题，并发现瓶颈。

.. code-block:: php

    <?php

    $di->set('profiler', function(){
        return new Phalcon\Db\Profiler();
    });

    $di->set('db', function() use ($di) {

        $eventsManager = new Phalcon\Events\Manager();

        //Get a shared instance of the DbProfiler
        $profiler = $di->getProfiler();

        //Listen all the database events
        $eventsManager->attach('db', function($event, $connection) use ($profiler) {
            if ($event->getType() == 'beforeQuery') {
                $profiler->startProfile($connection->getSQLStatement());
            }
            if ($event->getType() == 'afterQuery') {
                $profiler->stopProfile();
            }
        });

        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "invo"
        ));

        //Assign the eventsManager to the db adapter instance
        $connection->setEventsManager($eventsManager);

        return $connection;
    });

Profiling some queries:

.. code-block:: php

    <?php

    // Send some SQL statements to the database
    Robots::find();
    Robots::find(array("order" => "name");
    Robots::find(array("limit" => 30);

    //Get the generated profiles from the profiler
    $profiles = $di->getShared('profiler')->getProfiles();

    foreach ($profiles as $profile) {
       echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
       echo "Start Time: ", $profile->getInitialTime(), "\n";
       echo "Final Time: ", $profile->getFinalTime(), "\n";
       echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }

每个生成的profile文件，都是以毫秒为单位。

Injecting services into Models
------------------------------
你可能需要在模型中访问服务容器的一个服务，下面的示例将为你展示如何使用：

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function notSave()
        {
            //Obtain the flash service from the DI container
            $flash = $this->getDI()->getFlash();

            //Show validation messages
            foreach ($this->getMesages() as $message) {
                $flash->error((string) $message);
            }
        }

    }

"create"或"update"操作失败的时候，"notSave"事件总是被触发，所以我们通过访问服务容器中的"flash"服务来输出验证消息。


.. _Alternative PHP Cache (APC): http://www.php.net/manual/en/book.apc.php
.. _PDO: http://www.php.net/manual/en/pdo.prepared-statements.php
