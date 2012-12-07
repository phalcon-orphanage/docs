Working with Models
===================
<<<<<<< HEAD
A model represents the information (data) of the application and the rules to manipulate that data. Models are primarily used for managing
the rules of interaction with a corresponding database table. In most cases, each table in your database will correspond to one model in
your application. The bulk of your application's business logic will be concentrated in the models.

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` is the base for all models in a Phalcon application. It provides database independence, basic
CRUD functionality, advanced finding capabilities, and the ability to relate models to one another, among other services.
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` avoids the need of having to use SQL statements because it translates methods dynamically
to the respective database engine operations.

.. highlights::

    Models are intended to work on a database high layer of abstraction. If you need to work with databases at a lower level check out the
    :doc:`Phalcon\\Db <../api/Phalcon_Db>` component documentation.

Creating Models
---------------
A model is a class that extends from :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`. It must be placed in the models directory. A model
file must contain a single class; its class name should be in camel case notation:
=======
在应用程序中，模型是代表的是一种数据以及通过一些规则来操作这些数据，模型主要用于通过一些规则使其与数据库表进行相互操作，在大多数情况下，每个数据库表将对应到一个模型，整个应用程序的业务逻辑都会集中在模型中。

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 是应用程序中所有模型的基类，它保证了数据库的独立性，基本的CURD操作，高级的查询功能，多表关联等功能。

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 提供了SQL语句的动态转化功能，避免了直接使用SQL语句带来的安全风险。

.. highlights::

   Models是数据库的高级抽象层，如果您需要与数据库直接打交道，你可以查看 :doc:`Phalcon\\Db <../api/Phalcon_Db>` 组件文档。

Creating Models
---------------
一个Model就是一个继承自 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 的类文件，它必须放到models文件夹目录下，一个Model文件必须是一个独立的类文件，同时它的命名采用驼蜂式的书写方法：
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

    }

<<<<<<< HEAD
The above example shows the implementation of the "Robots" model. Note that the class Robots inherits from :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`.
This component provides a great deal of functionality to models that inherit it, including basic database
CRUD (Create, Read, Update, Destroy) operations, data validation, as well as sophisticated search support and the ability to relate multiple models
with each other.

.. highlights::

    If you're using PHP 5.4 is recommended declare each column that makes part of the model in order to save
    memory and reduce the memory allocation.

By default model "Robots" will refer to the table "robots". If you want to manually specify another name for the mapping table,
you can use the getSource() method:
=======
上面的例子是一个 "Robots"模型类，需要注意的是，类Robots继承自 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`。因为继承，该模型提供了大量的功能，包括基本的数据库CRUDCreate, Read, Update, Destroy) 操作，数据验证，先进的检索功能，并且可以同时关联多个模型。

.. highlights::

    推荐你使用PHP5.4版本，这可以使得模型中的属性在保存到内存时，更节省内存。

默认情况下，模型"Robots"对应的是数据库表"robots"，如果你想手工指定映射到其他的数据库表，你可以使用 getSource() 方法：
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSource()
        {
            return "the_robots";
        }

    }

<<<<<<< HEAD
The model Robots now maps to "the_robots" table. The initialize() method aids in setting up the model with a custom behavior i.e. a different table.
The initialize() method is only called once during the request.

Models in Namespaces
--------------------
Namespaces can be used to avoid class name collision. In this case it is necessary to indicate the name of the related table using getSource:
=======
此时，模型"Robots"映射到数据库表"the_robots"，initialize()方法有助于在模型中建立自定义行为，如，不同的数据表。initialize()方法在请求期间只被调用一次。

Models in Namespaces
--------------------
命名空间可以用来避免类名冲突，在这种情况下，使用getSource()方法来指定数据表名称是必要的：
>>>>>>> 0.7.0

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
<<<<<<< HEAD
Every instance of a model represents a row in the table. You can easily access record data by reading object properties. For example,
for a table "robots" with the records:
=======
每一个模型对象表示数据表中的一行数据，你可以轻松的通过读取对象的属性来访问数据。举个例子，数据表"robots"的记录如下：
>>>>>>> 0.7.0

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

<<<<<<< HEAD
You could find a certain record by its primary key and then print its name:
=======
你可以通过数据库主键查找某条记录，然后打印出它们的名字：
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    // Find record with id = 3
    $robot = Robots::findFirst(3);

    // Prints "Terminator"
    echo $robot->name;

<<<<<<< HEAD
Once the record is in memory, you can make modifications to its data and then save changes:
=======
一旦记录被读取到内存中，你可以修改它的数据，然后保存更改：
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    $robot = Robots::findFirst(3);
    $robot->name = "RoboCop";
    $robot->save();

<<<<<<< HEAD
As you can see, there is no need to use raw SQL statements. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` provides high database
abstraction for web applications.

Finding Records
---------------
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` also offers several methods for querying records. The following examples will show you
how to query one or more records from a model:
=======
正如你所看到的，这里没有使用原始的SQL语句。:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 为web应用程序提供了高度的数据库抽象。

Finding Records
---------------
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 还提供了多种方法来查询数据记录。下面的例子将为你展示如何通过Model查询单条以及多条记录：
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    // How many robots are there?
    $robots = Robots::find();
    echo "There are ", count($robots), "\n";

    // How many mechanical robots are there?
    $robots = Robots::find("type = 'mechanical'");
    echo "There are ", count($robots), "\n";

    // Get and print virtual robots ordered by name
<<<<<<< HEAD
    $robots = Robots::find(array("type = 'virtual'", "order" => "name"));
=======
    $robots = Robots::find(array(
        "type = 'virtual'",
        "order" => "name"
    ));
>>>>>>> 0.7.0
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // Get first 100 virtual robots ordered by name
<<<<<<< HEAD
    $robots = Robots::find(array("type = 'virtual'", "order" => "name", "limit" => 100));
=======
    $robots = Robots::find(array(
        "type = 'virtual'",
        "order" => "name",
        "limit" => 100
    ));
>>>>>>> 0.7.0
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

<<<<<<< HEAD
You could also use the findFirst() method to get only the first record matching the given criteria:
=======
你也可以使用findFirst()方法来获取给定条件下的第一条记录：
>>>>>>> 0.7.0

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

<<<<<<< HEAD
Both find() and findFirst() methods accept an associative array specifying the search criteria:
=======
find()和findFirst()这两个方法都接收一个关联数组作为检索条件：
>>>>>>> 0.7.0

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

<<<<<<< HEAD
The available query options are:

+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| Parameter   | Description                                                                                                                                                                                  | Example                                                                 |
+=============+==============================================================================================================================================================================================+=========================================================================+
| conditions  | Search conditions for the find operation. Is used to extract only those records that fulfill a specified criterion. By default Phalcon_model assumes the first parameter are the conditions. | "conditions" => "name LIKE 'steve%'"                                    |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| bind        | Bind is used together with options, by replacing placeholders and escaping values thus increasing security                                                                                   | "bind" => array("status" => "A", "type" => "some-time")                 |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| bindTypes   | When binding parameters, you can use this parameter to define additional casting to the bound parameters increasing even more the security                                                   | "bindTypes" => array(Column::BIND_TYPE_STR, Column::BIND_TYPE_INT)      |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| order       | Is used to sort the resultset. Use one or more fields separated by commas.                                                                                                                   | "order" => "name DESC, status"                                          |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| limit       | Limit the results of the query to results to certain range                                                                                                                                   | "limit" => 10                                                           |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| group       | Allows to collect data across multiple records and group the results by one or more columns                                                                                                  | "group" => "name, status"                                               |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| for_update  | With this option, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` reads the latest available data, setting exclusive locks on each row it reads                                        | "for_update" => true                                                    |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| shared_lock | With this option, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` reads the latest available data, setting shared locks on each row it reads                                           | "shared_lock" => true                                                   |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| cache       | Cache the resulset, reducing the continuous access to the relational system                                                                                                                  | "cache" => array("lifetime" => 3600, "key" => "my-find-key")            |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+

If you prefer, there is also available a way to create queries in an object oriented way, instead of using an array of parameters:
=======
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
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    $robots = Robots::query()
        ->where("type = :type:")
        ->bind(array("type" => "mechanical"))
        ->order("name")
        ->execute();

<<<<<<< HEAD
The static method query() returns a :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` object that is friendly with IDE autocompleters.

Phalcon also offers you the possibility to query records using a high level, object oriented, SQL-like language called :doc:`PHQL <phql>`.

Model Resultsets
^^^^^^^^^^^^^^^^
While findFirst() returns directly an instance of the called class (when there is data to be returned), the find() method returns a
:doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`. This is an object that encapsulates all the functionality
a resultset has like traversing, seeking specific records, counting, etc.

These objects are more powerful than standard arrays. One of the greatest features of the :doc:`Phalcon\\Mvc\\Model\\Resultset <../api/Phalcon_Mvc_Model_Resultset>`
is that at any time there is only one record in memory. This greatly helps in memory management especially when working with large amounts of data.
=======
静态方法 query()返回一个 :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` 的实例化对象，因此它对IDE自动提示功能非常友好。


所有的查询都被进行内部处理成 :doc:`PHQL <phql>` 。PHQL是一个高层次的，面向对象的类SQL语言。这种语言为你提供更多的功能来进行查询，如与其他模型关联查询，定义分组，添加聚合等。

Model Resultsets
^^^^^^^^^^^^^^^^
findFirst()方法直接返回一个类的实例对象(查询有数据返回的时候)，find()方法则返回:doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>` 的一个实例对象，这个对象是一个封装了所有功能的结果集，比如像数据遍历，寻找特定的数据记录，计数等等。

这些对象比标准数组更为强大，最大的优点之一是  :doc:`Phalcon\\Mvc\\Model\\Resultset <../api/Phalcon_Mvc_Model_Resultset>` 在任何时候它在内存中只保存一条记录，这极大的优化了内存管理，特别是处理大量数据的时候。
>>>>>>> 0.7.0

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

<<<<<<< HEAD
Phalcon resulsets emulates scrollable cursors, you can get any row just by accessing its position, or seeking the internal pointer to a certain position.
Note that some database systems don't support scrollable cursors, this forces to re-execute the query in order to rewind the cursor to the beginning
and obtain the record at the requested position. Similarly, if a resultset is traversed several times, the query must be executed the same number of times.

Some database systems drivers like SQLite doesn't support scrollable cursors, additionally, store large query results in memory can
consume many resources, due to this resultsets are obtained from the database in chunks of 32 rows reducing the need to
re-execute the request in several cases.

Note that resultsets can be serialized and stored in a a cache backend. :doc:`Phalcon\\Cache <cache>` can help with that task. However,
=======
Phalcon数据集模拟游标的方式，你可以获取任意一行数据，只需要通过访问其位置，或者通过移动内部指针到一个特定的位置。需要注意的是，一些数据库系统并不支持游标，这将会导致每次强制重新执行，游标移动到头部，并从头到尾去查询请求位置。同理，如果一个结果集遍历多次，查询必须被执行相同的次数。

大量的查询结果存储在内存中，会消耗大量的资源。resultsets are obtained
from the database in chunks of 32 rows reducing the need for re-execute the request in several cases.

请注意，结果集可以被序列化后存储到缓存中。:doc:`Phalcon\\Cache <cache>` 可以帮助完成这项任务。However,
>>>>>>> 0.7.0
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

Binding Parameters
^^^^^^^^^^^^^^^^^^
<<<<<<< HEAD
Bound parameters are also supported in :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`. Although there is a minimal performance
impact by using bound parameters, you are encouraged to use this methodology so as to eliminate the possibility of your code being subject
to SQL injection attacks. Both string and integer placeholders are supported. Binding parameters can simply be achieved as follows:
=======
在 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`同样支持参数类型绑定。虽然会有比较小的性能消耗，但我们推荐你使用这种方法，因为它会清除SQL注入攻击，字符串过滤及整形数据验证等。绑定绑定，可以通过如下方式实现：
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    // Query robots binding parameters with string placeholders
    $conditions = "name = :name: AND type = :type:";
<<<<<<< HEAD
    $parameters = array("name" => "Robotina", "type" => "maid");
    $robots     = Robots::find(array($conditions, "bind" => $parameters));
=======

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
>>>>>>> 0.7.0

    // Query robots binding parameters with integer placeholders
    $conditions = "name = ?1 AND type = ?2";
    $parameters = array(1 => "Robotina", 2 => "maid");
<<<<<<< HEAD
    $robots     = Robots::find(array($conditions, "bind" => $parameters));

    // Query robots binding parameters with both string and integer placeholders
    $conditions = "name = :name: AND type = ?1";
    $parameters = array("name" => "Robotina", 1 => "maid");
    $robots     = Robots::find(array($conditions, "bind" => $parameters));

When using numeric placeholders, you will need to define them as integers i.e. 1 or 2. In this case "1" or "2" are considered strings
and not numbers, so the placeholder could not be successfully replaced.

Strings are automatically escaped using PDO_. This function takes into account the connection charset, so its recommended to define
the correct charset in the connection parameters or in the database configuration, as a wrong charset will produce undesired effects
when storing or retrieving data.

Additionally you can set the parameter "bindTypes", this allows to define how the parameters should be binded according to its data type:
=======
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
>>>>>>> 0.7.0

.. code-block:: php

    <?php

<<<<<<< HEAD
    // Query robots binding parameters with string placeholders
    $conditions = "name = :name: AND year = :year:";
    $parameters = array("name" => "Robotina", "year" => 2008);
    $types = array(Phalcon\Db\Column::BIND_TYPE_STR, Phalcon\Db\Column::BIND_TYPE_INT);
=======
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
>>>>>>> 0.7.0
    $robots = Robots::find(array(
        $conditions,
        "bind" => $parameters,
        "bindTypes" => $types
    ));


<<<<<<< HEAD
Bound parameters are available for all query methods such as find() and findFirst() but also the calculation methods like count(), sum(), average() etc.

Relationships between Models
----------------------------
There are four types of relationships: one-on-one, one-to-many, many-to-one and many-to-many. The relationship may be unidirectional
or bidirectional, and each can be simple (a one to one model) or more complex (a combination of models). The model manager manages
foreign key constraints for these relationships, the definition of these helps referential integrity as well as easy and fast access
of related records to a model. Through the implementation of relations, it is easy to access data in related models from each record
in a uniform way.

Unidirectional relationships
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Unidirectional relations are those that are generated in relation to one another but not vice versa.

Bidirectional relations
^^^^^^^^^^^^^^^^^^^^^^^
The bidirectional relations build relationships in both models and each model defines the inverse relationship of the other.

Defining relationships
^^^^^^^^^^^^^^^^^^^^^^
In Phalcon, relationships must be defined in the initialize() method of a model. The methods belongsTo(), hasOne() or hasMany() define
the relationship between one or more fields from the current model to fields in another model. Each of these methods requires 3
parameters: local fields, referenced model, referenced fields.
=======
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
>>>>>>> 0.7.0

+-----------+----------------------------+
| Method    | Description                |
+===========+============================+
| hasMany   | Defines a 1-n relationship |
+-----------+----------------------------+
| hasOne    | Defines a 1-1 relationship |
+-----------+----------------------------+
| belongsTo | Defines a n-1 relationship |
+-----------+----------------------------+

<<<<<<< HEAD
The following schema shows 3 tables whose relations will serve us as an example regarding relationships:
=======
下面的schema显示了三个数据表的关系，用这个作为例子有助于我们更好的理解：
>>>>>>> 0.7.0

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
<<<<<<< HEAD
* The model "RobotsParts" belongs to "Robots" and "Parts" models as a one-to-many relation.

The models with their relations could be implemented as follows:
=======
* The model "RobotsParts" belongs to both "Robots" and "Parts" models as a one-to-many relation.

在模型中他们的实现方法是这样的：
>>>>>>> 0.7.0

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

<<<<<<< HEAD
The first parameter indicates the field of the local model used in the relationship; the second indicates the name of the referenced
model and the third the field name in the referenced model. You could also use arrays to define multiple fields in the relationship.
=======
在映射关系中，第一个参数是当前模型的属性，第二个参数为关联模型的类名称，第三个参数为关联模型的属性。你也可以在映射关系中使用数组定义多个属性。
>>>>>>> 0.7.0

Taking advantage of relationships
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
When explicitly defining the relationships between models, it is easy to find related records for a particular record.

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);
    foreach ($robot->getRobotsParts() as $robotPart) {
        echo $robotPart->getParts()->name, "\n";
    }

Phalcon uses the magic method __call to retrieve data from a relationship. If the called method has a "get" prefix
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` will return a findFirst()/find() result. The following example compares
retrieving related results with using the magic method and without:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);

    // Robots model has a 1-n (hasMany)
    // relationship to RobotsParts then
    $robotsParts = $robot->getRobotsParts();

    // Only parts that match conditions
<<<<<<< HEAD
    $robotsParts = $robot->getRobotsParts("created_at='2012-03-15'");

    // Or using bound parameters
    $robotsParts = $robot->getRobotsParts(array(
        "created_at=:date:",
=======
    $robotsParts = $robot->getRobotsParts("created_at = '2012-03-15'");

    // Or using bound parameters
    $robotsParts = $robot->getRobotsParts(array(
        "created_at = :date:",
>>>>>>> 0.7.0
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


The prefix "get" is used to find()/findFirst() related records. You can also use "count" prefix to return an integer denoting the count of the related records:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);
    echo "The robot have ", $robot->countRobotsParts(), " parts\n";

Virtual Foreign Keys
^^^^^^^^^^^^^^^^^^^^
By default, relationships do not act like database foreign keys, that is, if you try to insert/update a value without having a valid
value in the referenced model, Phalcon will not produce a validation message. You can modify this behavior by adding a fourth parameter
when defining a relationship.

The RobotsPart model can be changed to demonstrate this feature:

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

If you alter a belongsTo() relationship to act as foreign key, it will validate that the values inserted/updated on those fields have a
valid value on the referenced model. Similarly, if a hasMany()/hasOne() is altered it will validate that the records cannot be deleted
if that record is used on a referenced model.

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
Calculations are helpers for commonly used functions of database systems such as COUNT, SUM, MAX, MIN or AVG.
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` allows to use these functions directly from the exposed methods.

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

Caching Resultsets
^^^^^^^^^^^^^^^^^^
Access to database systems is often one of the most common bottlenecks in terms of performance. This is due to the complex connection
process that PHP must do in each request to obtain data from the database. A well established technique to avoid the continuous access
to the database is to cache resultsets that don't change frequently in a system with faster access (usually memory).

When :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` requires a service to cache resultsets, it will request it to the Dependency
Injector Container with the convention name "modelsCache".

As Phalcon provides a component to cache any kind of data, we'll explain how to integrate it with Models. First you need to register
it as a service in the services container:

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

You have complete control in creating and customizing the cache before being used to record the service as an anonymous function.
Once the cache setup is properly defined you could cache resultsets as follows:

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

By default, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` will create a unique key to store the resultset, using a md5 hash
of the SQL select statement generated internally. This is very practical because it generates a new unique key for every change in
the parameters passed in the object. If you wish to control the cache keys, you could always use the key() parameter as seen in the
example above. The getLastKey() method retrieves the key of the last cached entry so that you can target and retrieve the resultset
later on from the cache.:

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

Cache keys automatically generated by :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` are always prefixed with "phc". This helps
to easily identify the cached entries related to :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`:

.. code-block:: php

    <?php

    // Set the cache to the models manager
    $cache = $di->getModelsCache();

    // Get keys created by Phalcon\Mvc\Model
    foreach ($cache->queryKeys("phc") as $key) {
         echo $key, "\n";
    }

Note that not all resultsets must be cached. Results that change very frequently should not be cached since they are invalidated very
quickly and caching in that case impacts performance. Additionally, large datasets that do not change frequently could be cached but
that is a decision that the developer has to make based on the available caching mechanism and whether the performance impact to simply
retrieve that data in the first place is acceptable.

Caching could be also applied to resultsets generated using relationships:

.. code-block:: php

    <?php

    // Query some post
    $post = Post::findFirst();

    // Get comments related to a post, also cache it
    $comments = $post->getComments(array("cache" => true));

    // Get comments related to a post, setting lifetime
    $comments = $post->getComments(array("cache" => true, "lifetime" => 3600));

When a cached resultset needs to be invalidated, you can simply delete it from the cache using the generated key.

Creating Updating/Records
-------------------------
The method Phalcon\\Mvc\\Model::save() allows you to create/update records according to whether they already exist in the table
associated with a model. The save method is called internally by the create and update methods of :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`.
For this to work as expected it is necessary to have properly defined a primary key in the entity to determine whether a record
should be updated or created.

Also the method executes associated validators, virtual foreign keys and events that are defined in the model:

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

<<<<<<< HEAD
=======
An array could be passed to "save" to avoid assign every column manually. Phalcon\\Mvc\\Model will check if there are setters implemented for
the columns passed in the array giving priority to them instead of assign directly the values of the attributes:

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->save(array(
        "type" => "mechanical",
        "name" => "Astro Boy",
        "year" => 1952
    ));

Values assigned directly or via the array of attributes are escaped/sanitized according to the related attribute data type. So you can pass
an insecure array without worrying about possible SQL injections:

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->save($_POST);

>>>>>>> 0.7.0
Create/Update with Certainty
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
When an application has a lot of competition, maybe we expect to create a record but that is actually updated. This could happen if we use
Phalcon\\Mvc\\Model::save() to persist the records in the database. If we want to be certain that a record will be created or updated
created we can change save by "create" or "update":

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

<<<<<<< HEAD
=======
These methods "create" and "update" also accept an array of values as parameter.

>>>>>>> 0.7.0
Auto-generated identity columns
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Some models may have identity columns. These columns usually are the primary key of the mapped table. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
can recognize the identity column and will omit it from the internal SQL INSERT, so the database system could generate an auto-generated value for it.
Always after creating a record, the identity field will be registered with the  value generated in the database system for it:

.. code-block:: php

    <?php

    $robot->save();
    echo "The generated id is: ", $robot->id;

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` is able to recognize the identity column. Depending on the database system, those columns may be
serial columns like in PostgreSQL or auto_increment columns in the case of MySQL.

PostgreSQL uses sequences to generate auto-numeric values, by default, Phalcon tries to obtain the generated value from the sequence "table_field_seq",
for example: robots_id_seq, if that sequence has a different name, the method "getSequenceName" needs to be implemented:

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
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` has a messaging subsystem that provides a flexible way to output or store the
validation messages generated during the insert/update processes.

Each message consists of an instance of the class :doc:`Phalcon\\Mvc\\Model\\Message <../api/Phalcon_Mvc_Model_Message>`. The set of
messages generated can be retrieved with the method getMessages(). Each message provides extended information like the field name that
generated the message or the message type:

.. code-block:: php

    <?php

    if ($robot->save() == false) {
        foreach ($robot->getMessages() as $message) {
            echo "Message: ", $message->getMessage();
            echo "Field: ", $message->getField();
            echo "Type: ", $message->getType();
        }
    }

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` can generate the following types of validation messages:

+---------------------+------------------------------------------------------------------------------------------------------------------------------------+
| Type                | Description                                                                                                                        |
+=====================+====================================================================================================================================+
| PresenceOf          | Generated when a field with a non-null attribute on the database is trying to insert/update a null value                           |
+---------------------+------------------------------------------------------------------------------------------------------------------------------------+
| ConstraintViolation | Generated when a field part of a virtual foreign key is trying to insert/update a value that doesn't exist in the referenced model |
+---------------------+------------------------------------------------------------------------------------------------------------------------------------+
<<<<<<< HEAD
| InvalidValue        | Generated when a validator failed due to an invalid value                                                                          |
=======
| InvalidValue        | Generated when a validator failed because of an invalid value                                                                      |
>>>>>>> 0.7.0
+---------------------+------------------------------------------------------------------------------------------------------------------------------------+

Validation Events and Events Manager
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Models allow you to implement events that will be thrown when performing an insert or update. They help to define business rules for a
certain model. The following are the events supported by :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` and their order of execution:

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

<<<<<<< HEAD
To make a model to react to an event, we must to implement a method with the same name of the event:
=======
To make a model react to events, we must to implement a method with the same name of the event:
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function beforeValidationOnCreate()
        {
<<<<<<< HEAD

=======
>>>>>>> 0.7.0
            echo "This is executed before create a Robot!";
        }

    }

<<<<<<< HEAD
Events can be useful to assign values before perform a operation, for example:
=======
Events can be useful to assign values before performing an operation, for example:
>>>>>>> 0.7.0

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

<<<<<<< HEAD
Additionally, this component is integrated with :doc:`Phalcon\\Events\\Manager <../api/Phalcon_Events_Manager>`, this means we can create
listeners that run when an event is triggered.
=======
Additionally, this component is integrated with :doc:`Phalcon\\Events\\Manager <../api/Phalcon_Events_Manager>`,
this means we can create listeners that run when an event is triggered.
>>>>>>> 0.7.0

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

<<<<<<< HEAD
In the above example the EventsManager only acted as a bridge between an object and a listener (the anonymous function). If we want all
objects created in our application use the same EventsManager then we need to assign this to the Models Manager:
=======
In the above example the EventsManager only acts as a bridge between an object and a listener (the anonymous function).
If we want all objects created in our application use the same EventsManager then we need to assign this to the Models Manager:
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    //Registering the modelsManager service
<<<<<<< HEAD
    $di->set('modelsManager', function() {
=======
    $di->setShared('modelsManager', function() {
>>>>>>> 0.7.0

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
<<<<<<< HEAD
When an insert, update or delete is executed, the model verifies if there are any methods with the names of the events listed in the table above.

We recommend that validation methods are declared protected to prevent that business logic implementation from being exposed publicly.
=======
When an insert, update or delete is executed, the model verifies if there are any methods with the names of
the events listed in the table above.

We recommend that validation methods are declared protected to prevent that business logic implementation
from being exposed publicly.
>>>>>>> 0.7.0

The following example implements an event that validates the year cannot be smaller than 0 on update or insert:

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

Some events return false as an indication to stop the current operation. If an event doesn't return anything, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
will assume a true value.

Validating Data Integrity
^^^^^^^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` provides several events to validate data and implement business rules. The special "validation"
event allows us to call built-in validators over the record. Phalcon exposes a few built-in validators that can be used at this stage of validation.

The following example shows how to use it:

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

The above example performs a validation using the built-in validator "InclusionIn". It checks the value of the field "type" in a domain list. If
the value is not included in the method then the validator will fail and return false. The following built-in validators are available:

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

In addition to the built-in validatiors, you can create your own validators:

.. code-block:: php

    <?php

<<<<<<< HEAD
    class UrlValidator extends \Phalcon\Mvc\Model\Validator
=======
    use \Phalcon\Mvc\Model\Validator,
        \Phalcon\Mvc\Model\ValidatorInterface;

    class UrlValidator extends Validator implements ValidatorInterface
>>>>>>> 0.7.0
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

Adding the validator to a model:

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

The idea of ​​creating validators is make them reusable between several models. A validator can also be as simple as:

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

Avoiding SQL injections
^^^^^^^^^^^^^^^^^^^^^^^
Every value assigned to a model attribute is escaped depending of its data type. A developer doesn't need to escape manually
each value before store it on the database. Phalcon uses internally the `bound parameters <http://php.net/manual/en/pdostatement.bindparam.php>`_
capability provided by PDO.

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

If we use just PDO to store a record in a secure way, we need to write the following code:

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

The good news is that Phalcon do this automatically for you:

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
To tell to Phalcon\\Mvc\\Model that omits some fields in the creation and/or update in order to delegate the database
system assigns the value by a trigger or a default:

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

This will ignore globally these fields on each INSERT/UPDATE operation on the whole application.
Forcing a default value can be done in the following way:

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->name = 'Bender';
    $robot->year = 1999;
    $robot->created_at = new Phalcon\Db\RawValue('default');
    $robot->create();

Deleting Records
----------------
The method Phalcon\\Mvc\\Model::delete() allows to delete a record. You can use it as follows:

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

You can also delete many records by traversing a resultset with a foreach:

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

The following events are available to define custom business rules that can be executed when a delete operation is performed:

+-----------+--------------+---------------------+------------------------------------------+
| Operation | Name         | Can stop operation? | Explanation                              |
+===========+==============+=====================+==========================================+
| Deleting  | beforeDelete | YES                 | Runs before the delete operation is made |
+-----------+--------------+---------------------+------------------------------------------+
| Deleting  | afterDelete  | NO                  | Runs after the delete operation was made |
+-----------+--------------+---------------------+------------------------------------------+

Validation Failed Events
------------------------

Another type of events is available when the data validation process finds any inconsistency:

+--------------------------+--------------------+--------------------------------------------------------------------+
| Operation                | Name               | Explanation                                                        |
+==========================+====================+====================================================================+
| Insert or Update         | notSave            | Triggered when the INSERT or UPDATE operation fails for any reason |
+--------------------------+--------------------+--------------------------------------------------------------------+
| Insert, Delete or Update | onValidationFails  | Triggered when any data manipulation operation fails               |
+--------------------------+--------------------+--------------------------------------------------------------------+

Transactions
------------
When a process performs multiple database operations, it is often that each step is completed successfully so that data integrity can
be maintained. Transactions offer the ability to ensure that all database operations have been executed successfully before the data
is committed in the database.

Transactions in Phalcon allow you to commit all operations if they have been executed successfully or rollback all operations if something went wrong.

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

<<<<<<< HEAD
    try {

        //Create a transaction manager
        $manager = new Phalcon\Mvc\Model\Transaction\Manager();
=======
    use Phalcon\Mvc\Model\Transaction\Manager as Tx,
        Phalcon\Mvc\Model\Transaction\Failed as TxFailed;

    try {

        //Create a transaction manager
        $manager = new Tx();
>>>>>>> 0.7.0

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

<<<<<<< HEAD
    } catch(Phalcon\Mvc\Model\Transaction\Failed $e) {
=======
    } catch(TxFailed $e) {
>>>>>>> 0.7.0
        echo "Failed, reason: ", $e->getMessage();
    }

Transactions are reused no matter where the transaction object is retrieved. A new transaction is generated only when a commit() or rollback()
is performed. You can use the service container to create an overall transaction manager for the entire application:

.. code-block:: php

    <?php

<<<<<<< HEAD
    $di->set('transactions', function(){
=======
    $di->setShared('transactions', function(){
>>>>>>> 0.7.0
        return new Phalcon\Mvc\Model\Transaction\Manager();
    });

Then access it from a controller or view:

.. code-block:: php

    <?php

    class ProductsController extends \Phalcon\Mvc\Controller {

        public function saveAction()
        {

            //Obtain the TransactionsManager from the DI container
<<<<<<< HEAD
            $manager = $this->di->getShared('transactions');
=======
            $manager = $this->di->getTransactions();
>>>>>>> 0.7.0

            //Request a transaction
            $transaction = $manager->get();

        }

    }

<<<<<<< HEAD
=======
Independent Column Mapping
--------------------------
The ORM supports a independent column map, which allows the developer to use different column names in the model to the ones in
the table. Phalcon will recognize the new column names and will rename them accordingly to match the respective columns in the database.
This is a great feature when one needs to rename fields in the database without having to worry about all the queries
in the code. A change in the column map in the model will take care of the rest. For example:

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

Then you can use the new names naturally in your code:

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

Take into consideration the following the next when renaming your columns:

* References to attributes in relationships/validators must use the new names
* Refer the column names will result in an exception by the ORM

>>>>>>> 0.7.0
Models Meta-Data
----------------
To speed up development :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` helps you to query fields and constraints from tables
related to models. To achieve this, :doc:`Phalcon\\Mvc\\Model\\MetaData <../api/Phalcon_Mvc_Model_MetaData>` is available to manage
and cache table meta-data.

Sometimes it is necessary to get those attributes when working with models. You can get a meta-data instance as follows:

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
Once the application is in a production stage, it is not necessary to query the meta-data of the table from the database system each
time you use the table. This could be done caching the meta-data using any of the following adapters:

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

As other ORM's dependencies, the metadata manager is requested from the services container:

.. code-block:: php

    <?php

<<<<<<< HEAD
    $di->set('modelsMetadata', function() {
=======
    $di->setShared('modelsMetadata', function() {
>>>>>>> 0.7.0

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
Phalcon can obtain the metadata for each model automatically without the developer must set them manually.
Remember that when defining the metadata manually, new columns added/modified/removed to/from the mapped
table must be added/modified/removed also for everything to work correctly.

The following example shows how to define the meta-data manually:

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

<<<<<<< HEAD
                //How every column must be binded/casted
=======
                //How every column must be bound/casted
>>>>>>> 0.7.0
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

<<<<<<< HEAD
Setting a different schema
--------------------------
Models may are mapped to tables that are in different schemas/databases than the default. You can use the getSchema method to define that:

Then, in the Initialize method, we define the connection service for the model:
=======
Pointing to a different schema
------------------------------
If a model is mapped to a table that is in a different schemas/databases than the default. You can use the getSchema method to define that:
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSchema()
        {
            return "toys";
        }

    }

Setting multiple databases
--------------------------
In Phalcon, all models can belong to the same database connection or have an individual one. Actually, when
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` needs to connect to the database it requests the "db" service
in the application's services container. You can overwrite this service setting it in the initialize method:

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

Then, in the Initialize method, we define the connection service for the model:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->setConnectionService('dbPostgres');
        }

    }

Logging Low-Level SQL Statements
--------------------------------
When using high-level abstraction components such as :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` to access a database, it is
difficult to understand which statements are finally sent to the database system. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
is supported internally by :doc:`Phalcon\\Db <../api/Phalcon_Db>`. :doc:`Phalcon\\Logger <../api/Phalcon_Logger>` interacts
with :doc:`Phalcon\\Db <../api/Phalcon_Db>`, providing logging capabilities on the database abstraction layer, thus allowing us to log SQL
statements as they happen.

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

As models access the default database connection, all SQL statements that are sent to the database system will be logged in the file:

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->name = "Robby the Robot";
    $robot->created_at = "1956-07-21"
    if ($robot->save() == false) {
        echo "Cannot save robot";
    }

As above, the file *app/logs/db.log* will contain something like this:

.. code-block:: irc

    [Mon, 30 Apr 12 13:47:18 -0500][DEBUG][Resource Id #77] INSERT INTO robots
    (name, created_at) VALUES ('Robby the Robot', '1956-07-21')

Profiling SQL Statements
------------------------
Thanks to :doc:`Phalcon\\Db <../api/Phalcon_Db>`, the underlying component of :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`,
it's possible to profile the SQL statements generated by the ORM in order to analyze the performance of database operations. With
this you can diagnose performance problems and to discover bottlenecks.

.. code-block:: php

    <?php

    $di->set('profiler', function(){
        return new Phalcon\Db\Profiler();
<<<<<<< HEAD
    })

    $di->set('db', function() use($di) {
=======
    });

    $di->set('db', function() use ($di) {
>>>>>>> 0.7.0

        $eventsManager = new Phalcon\Events\Manager();

        //Get a shared instance of the DbProfiler
<<<<<<< HEAD
        $profiler = $di->getShared('profiler');
=======
        $profiler = $di->getProfiler();
>>>>>>> 0.7.0

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

Each generated profile contains the duration in miliseconds that each instruction takes to complete as well as the generated SQL statement.

Injecting services into Models
------------------------------
You may be required to access the application services within a model, the following example explains how to do that:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function notSave()
        {
            //Obtain the flash service from the DI container
<<<<<<< HEAD
            $flash = $this->getDI()->getShared('flash');

            //Show validation messages
            foreach($this->getMesages() as $message) {
=======
            $flash = $this->getDI()->getFlash();

            //Show validation messages
            foreach ($this->getMesages() as $message) {
>>>>>>> 0.7.0
                $flash->error((string) $message);
            }
        }

    }

The "notSave" event is triggered every time that a "create" or "update" action fails. So we're flashing the validation messages
obtaining the "flash" service from the DI container. By doing this, we don't have to print messages after each save.


.. _Alternative PHP Cache (APC): http://www.php.net/manual/en/book.apc.php
.. _PDO: http://www.php.net/manual/en/pdo.prepared-statements.php
