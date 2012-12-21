Phalcon Query Language (PHQL)
=============================
译者注：学过JAVA，略懂Hibernate的人应该会知道，hibernate是javaee中一个非常流程的ORM软件，它其中生成的中间语句就叫做HQL。

Phalcon查询语言，也可以叫PhalconQL或PHQL，是一个高层次的，允许你使用一种类SQL语言的方式的一种SQL方言。PHQL是一个用C语言编写的SQL语法分析器。

为了达到尽可能高的性能，Phalcon提供了一个分析器，使用了和 SQLite_ 相同的技术。该技术提供了一个小型的内存分析器，具有非常低的内存占用，同时也是线程安全的。

解析器首先检查传递过来的PHQL语句，然后把它们转化成一种中间性的语句，最后再将其转换为相应的RDBMS所需要的SQL方言。

在PHQL中，我们已经实现了一系列的功能，以保证你在访问数据库时是安全的：

* Bound parameters are part of the PHQL language helping you to secure your code
* PHQL only allows one SQL statement to be executed per call preventing injections
* PHQL ignores all SQL comments which are often used in SQL injections
* PHQL only allows data manipulation statements, avoiding altering or dropping tables/databases by mistake or externally without authorization
* PHQL implements a high level abstraction allowing you handling models as tables and class attributes as fields

使用示例
-------------
为了更好的展示PHQL是如何工作的，我们将使用模型  “Cars” 和 “Brands”：

.. code-block:: php

    <?php

    class Cars extends Phalcon\Mvc\Model
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

每个Car只有一个Brand,一个Brand有多个Cars:

.. code-block:: php

    <?php

    class Brands extends Phalcon\Mvc\Model
    {

        public $id;

        public $name;

        /**
         * The model Brands is mapped to the "sample_brands" table
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

Creating PHQL Queries
---------------------
PHQL查询可以通过实例化 :doc:`Phalcon\\Mvc\\Model\\Query <../api/Phalcon_Mvc_Model_Query>` 来创建：

.. code-block:: php

    <?php

    // Instantiate the Query
    $query = new Phalcon\Mvc\Model\Query("SELECT * FROM Cars");

    // Pass the DI container
    $query->setDI($di);

    // Execute the query returning a result if any
    $robots = $query->execute();

在控制器或视图文件中，它可以使用服务容器中的一个注入服务 :doc:`models manager <../api/Phalcon_Mvc_Model_Manager>` 来轻松的实现create/execute

.. code-block:: php

    <?php

    $query = $this->modelsManager->createQuery("SELECT * FROM Cars");

    $robots = $query->execute();

或者像下面这样：

.. code-block:: php

    <?php

    $robots = $this->modelsManager->executeQuery("SELECT * FROM Cars");

Selecting Records
-----------------
作为大家所熟悉的SQL，PHQL允许你在查询中使用SELECT语句，只是需要使用模型类的名称来替代数据表名：

.. code-block:: php

    <?php

    $query = $manager->createQuery("SELECT * FROM Cars ORDER BY Cars.name");
    $query = $manager->createQuery("SELECT Cars.name FROM Cars ORDER BY Cars.name");

带有命名空间的模型类同样可以：

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Formula\Cars ORDER BY Formula\Cars.name";
    $query = $manager->createQuery($phql);

    $phql = "SELECT Formula\Cars.name FROM Formula\Cars ORDER BY Formula\Cars.name";
    $query = $manager->createQuery($phql);

    $phql = "SELECT c.name FROM Formula\Cars c ORDER BY c.name";
    $query = $manager->createQuery($phql);

Phalcon支持大部分的SQL标准，甚至是非标准指令，如，LIMIT:

.. code-block:: php

    <?php

    $phql   = "SELECT c.name FROM Cars AS c "
       . "WHERE c.brand_id = 21 ORDER BY c.name LIMIT 100";
    $query = $manager->createQuery($phql);

Results Types
^^^^^^^^^^^^^
根据我们查询列的类型，返回的结果类型会稍有不同。如果你检索一个整体对象，它将返回 :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>` 的对象实例。这种结果集是一组完整的模型对象：

.. code-block:: php

    <?php

    $phql = "SELECT c.* FROM Cars AS c ORDER BY c.name";
    $cars = $manager->executeQuery($phql);
    foreach ($cars as $car)
    {
        echo "Name: ", $car->name, "\n";
    }

这是完全一样的：

.. code-block:: php

    <?php

    $cars = Cars::find(array("order" => "name"));
    foreach ($cars as $car)
    {
        echo "Name: ", $car->name, "\n";
    }

完整的对象可以被修改和重新保存到数据库，因为他们代表着关联数据表的一个完整记录。有一些其他类型的查询不返回完整的对象，例如：

.. code-block:: php

    <?php

    $phql = "SELECT c.id, c.name FROM Cars AS c ORDER BY c.name";
    $cars = $manager->executeQuery($phql);
    foreach ($cars as $car)
    {
        echo "Name: ", $car->name, "\n";
    }

我们只查询了数据表中的某些字段，因此，这不能算是一个完整的对象。在这种情况下，也返回 :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>` 的实例对象。然而，这个对象只包含两列属性值。

这些值不代表完整的对象，我们称他们为标量。PHQL允许你查询各种类型的标量，如fields,functions,literals, expressions等

.. code-block:: php

    <?php

    $phql = "SELECT CONCAT(c.id, ' ', c.name) AS id_name FROM Cars AS c ORDER BY c.name";
    $cars = $manager->executeQuery($phql);
    foreach ($cars as $car)
    {
        echo $car->id_name, "\n";
    }

我们既可以只查询完整的对象或标量，也可以同时查询他们：

.. code-block:: php

    <?php

    $phql   = "SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c ORDER BY c.name";
    $result = $manager->executeQuery($phql);

在这种情况下，返回的是  :doc:`Phalcon\\Mvc\\Model\\Resultset\\Complex <../api/Phalcon_Mvc_Model_Resultset_Complex>` 的实例对象，这允许同时访问完整对象和标量：

.. code-block:: php

    <?php

    foreach ($result as $row)
    {
        echo "Name: ", $row->cars->name, "\n";
        echo "Price: ", $row->cars->price, "\n";
        echo "Taxes: ", $row->taxes, "\n";
    }

标量的属性值映射到"row"上，而完整的对象则是被映射到与它相关的模型对象上。

Joins
^^^^^
使用PHQL可以很方便的通过多个模型来获取数据，Phalcon支持大多数类型的Joins。我们在模型中定义的关系，在使用PHQL时会自动的添加到条件上：

.. code-block:: php

    <?php

    $phql  = "SELECT Cars.name AS car_name, Brands.name AS brand_name FROM Cars JOIN Brands";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row)
    {
        echo $row->car_name, "\n";
        echo $row->brand_name, "\n";
    }

默认情况下，将使用INNER JOIN的方式，你也可以在查询中使用其他类型的JOIN：

.. code-block:: php

    <?php

    $phql = "SELECT Cars.*, Brands.* FROM Cars INNER JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql = "SELECT CCars.*, Brands.* FROM Cars LEFT JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql = "SELECT Cars.*, Brands.* FROM Cars LEFT OUTER JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql = "SELECT Cars.*, Brands.* FROM Cars CROSS JOIN Brands";
    $rows = $manager->executeQuery($phql);

有可能的话，在JOIN中手工设置SQL条件：

.. code-block:: php

    <?php

    $phql = "SELECT Cars.*, Brands.* FROM Cars INNER JOIN Brands ON Brands.id = Cars.brands_id";
    $rows = $manager->executeQuery($phql);

同时，Joins还可以在使用以下方式：

.. code-block:: php

    <?php

    $phql = "SELECT Cars.*, Brands.* FROM Cars, Brands WHERE Brands.id = Cars.brands_id";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row)
    {
        echo "Car: ", $row->cars->name, "\n";
        echo "Brand: ", $row->brands->name, "\n";
    }

如果在查询时使用了别名，获取属性值将使用别名的名称做为row的名称：

.. code-block:: php

    <?php

    $phql = "SELECT c.*, b.* FROM Cars c, Brands b WHERE b.id = c.brands_id";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row)
    {
        echo "Car: ", $row->c->name, "\n";
        echo "Brand: ", $row->b->name, "\n";
    }

Aggregations
^^^^^^^^^^^^
下面的示例将展示如何在PHQL中使用聚合：

.. code-block:: php

    <?php

    // How much are the prices of all the cars?
    $phql = "SELECT SUM(price) AS summatory FROM Cars";
    $row  = $manager->executeQuery($phql)->getFirst();
    echo $row['summatory'];

    // How many cars are by each brand?
    $phql = "SELECT Cars.brand_id, COUNT(*) FROM Cars GROUP BY Cars.brand_id";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row)
    {
        echo $row->brand_id, ' ', $row["1"], "\n";
    }

    // How many cars are by each brand?
    $phql = "SELECT Brands.name, COUNT(*) FROM Cars JOIN Brands GROUP BY 1";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row)
    {
        echo $row->name, ' ', $row["1"], "\n";
    }

    $phql = "SELECT MAX(price) AS maximum, MIN(price) AS minimum FROM Cars";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row)
    {
        echo $row["maximum"], ' ', $row["minimum"], "\n";
    }

    // Count distinct used brands
    $phql = "SELECT COUNT(DISTINCT brand_id) AS brandId FROM Cars";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row)
    {
        echo $row->brandId, "\n";
    }

条件(Conditions)
^^^^^^^^^^^^^^^^^^^^^
条件的作用是允许你过滤查询内容，WHERE条件可以这样使用：

.. code-block:: php

    <?php

    // Simple conditions
    $phql = "SELECT * FROM Cars WHERE Cars.name = 'Lamborghini Espada'";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.price > 10000";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE TRIM(Cars.name) = 'Audi R8'";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.name LIKE 'Ferrari%'";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.name NOT LIKE 'Ferrari%'";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.price IS NULL";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.id IN (120, 121, 122)";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.id NOT IN (430, 431)";
    $cars = $manager->executeQuery($phql);

    $phql = "SELECT * FROM Cars WHERE Cars.id BETWEEN 1 AND 100";
    $cars = $manager->executeQuery($phql);

此外，PHQL的另一特点，prepared参数自动转义用户输入数据，下面将介绍的是与安全相关：

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Cars WHERE Cars.name = :name:";
    $cars = $manager->executeQuery($phql, array("name" => 'Lamborghini Espada'));

    $phql = "SELECT * FROM Cars WHERE Cars.name = ?0";
    $cars = $manager->executeQuery($phql, array(0 => 'Lamborghini Espada'));


Inserting Data
--------------
PHQL是使用熟悉的INSERT语句插入数据：

.. code-block:: php

    <?php

    // Inserting without columns
    $phql = "INSERT INTO Cars VALUES (NULL, 'Lamborghini Espada', "
          . "7, 10000.00, 1969, 'Grand Tourer')";
    $manager->executeQuery($phql);

    // Specifyng columns to insert
    $phql = "INSERT INTO Cars (name, brand_id, year, style) "
          . "VALUES ('Lamborghini Espada', 7, 1969, 'Grand Tourer')";
    $manager->executeQuery($phql);

    // Inserting using placeholders
    $phql = "INSERT INTO Cars (name, brand_id, year, style) "
          . "VALUES (:name:, :brand_id:, :year:, :style)";
    $manager->executeQuery($sql,
        array(
            'name'     => 'Lamborghini Espada',
            'brand_id' => 7,
            'year'     => 1969,
            'style'    => 'Grand Tourer',
        )
    );

Phalcon中不只是用PHQL语句转换为SQL语句的。如果我们是手工创建模型对象，里面的所有事件及定义的业务规则都会被执行。现在，我们添加一个模型Cars的业务规则，让car的价格不低于$ 10,000:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Message;

    class Cars extends Phalcon\Mvc\Model
    {

        public function beforeCreate()
        {
            if ($this->price < 10000)
            {
                $this->appendMessage(new Message("A car cannot cost less than $ 10,000"));
                return false;
            }
        }

    }

如果我们在模型中使用以下的INSERT语句，INSERT操作将不成功，因为价格不符合定义的规则：

.. code-block:: php

    <?php

    $phql   = "INSERT INTO Cars VALUES (NULL, 'Nissan Versa', 7, 9999.00, 2012, 'Sedan')";
    $result = $manager->executeQuery($phql);
    if ($result->success() == false)
    {
        foreach ($result->getMessages() as $message)
        {
            echo $message->getMessage();
        }
    }

更新数据(Updating Data)
-----------------------------
更新一行记录和插入一行记录非常相似。正如你所知道的，更新数据记录的指令是UPDATE。当更新一行记录时，对应的模型事件将被执行。

.. code-block:: php

    <?php

    // Updating a single column
    $phql = "UPDATE Cars SET price = 15000.00 WHERE id = 101";
    $manager->executeQuery($phql);

    // Updating multiples columns
    $phql = "UPDATE Cars SET price = 15000.00, type = 'Sedan' WHERE id = 101";
    $manager->executeQuery($phql);

    // Updating multiples rows
    $phql = "UPDATE Cars SET price = 7000.00, type = 'Sedan' WHERE brands_id > 5";
    $manager->executeQuery($phql);

    // Using placeholders
    $phql = "UPDATE Cars SET price = ?0, type = ?1 WHERE brands_id > ?2";
    $manager->executeQuery(
        $phql,
        array(
            0 => 7000.00,
            1 => 'Sedan',
            2 => 5
        )
    );

删除数据(Deleting Data)
------------------------
当删除数据时，对应的模型事件将被执行：

.. code-block:: php

    <?php

    // Deleting a single row
    $phql = "DELETE FROM Cars WHERE id = 101";
    $manager->executeQuery($phql);

    // Deleting multiple rows
    $phql = "DELETE FROM Cars WHERE id > 100";
    $manager->executeQuery($phql);

    // Using placeholders
    $phql = "DELETE FROM Cars WHERE id BETWEEN :initial: AND :final:";
    $manager->executeQuery(
        $phql,
        array(
            'initial' => 1,
            'final' => '100
        )
    );

使用Query Builder创建queries(Creating queries using the Query Builder)
-------------------------------------------------------------------------
Query Builder可以创建一个PHQL query，而不需要编写PHQL语句了，同时Query Builder对IDE工具是友好的（可以自动提示）：

.. code-block:: php

    <?php

    $manager->createBuilder()
        >join('RobotsParts');
        ->limit(20);
        ->order('Robots.name')
        ->getQuery()
        ->execute();

与下面是相同的：

.. code-block:: php

    <?php

    $phql = "SELECT Robots.*
        FROM Robots JOIN RobotsParts p
        ORDER BY Robots.name LIMIT 20";
    $result = $manager->executeQuery($phql);

更多关于query builder的示例：

.. code-block:: php

    <?php

    $builder->from('Robots')
    // 'SELECT Robots.* FROM Robots'

    // 'SELECT Robots.*, RobotsParts.* FROM Robots, RobotsParts'
    $builder->from(array('Robots', 'RobotsParts'))

    // 'SELECT * FROM Robots'
    $phql = $builder->columns('*')
                    ->from('Robots')

    // 'SELECT id, name FROM Robots'
    $builder->columns(array('id', 'name'))
            ->from('Robots')

    // 'SELECT id, name FROM Robots'
    $builder->columns('id, name')
            ->from('Robots')

    // 'SELECT Robots.* FROM Robots WHERE Robots.name = "Voltron"'
    $builder->from('Robots')
            ->where('Robots.name = "Voltron"')

    // 'SELECT Robots.* FROM Robots WHERE Robots.id = 100'
    $builder->from('Robots')
            ->where(100)

    // 'SELECT Robots.* FROM Robots GROUP BY Robots.name'
    $builder->from('Robots')
            ->groupBy('Robots.name')

    // 'SELECT Robots.* FROM Robots GROUP BY Robots.name, Robots.id'
    $builder->from('Robots')
            ->groupBy(array('Robots.name', 'Robots.id'))

    // 'SELECT Robots.name, SUM(Robots.price) FROM Robots GROUP BY Robots.name'
    $builder->columns(array('Robots.name', 'SUM(Robots.price)'))
        ->from('Robots')
        ->groupBy('Robots.name')

    // 'SELECT Robots.name, SUM(Robots.price) FROM Robots
    // GROUP BY Robots.name HAVING SUM(Robots.price) > 1000'
    $builder->columns(array('Robots.name', 'SUM(Robots.price)'))
        ->from('Robots')
        ->groupBy('Robots.name')
        ->having('SUM(Robots.price) > 1000')

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts');
    $builder->from('Robots')
        ->join('RobotsParts')

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts AS p');
    $builder->from('Robots')
        ->join('RobotsParts', null, 'p')

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts ON Robots.id = RobotsParts.robots_id AS p');
    $builder->from('Robots')
        ->join('RobotsParts', 'Robots.id = RobotsParts.robots_id', 'p')

    // 'SELECT Robots.* FROM Robots
    // JOIN RobotsParts ON Robots.id = RobotsParts.robots_id AS p
    // JOIN Parts ON Parts.id = RobotsParts.parts_id AS t'
    $builder->from('Robots')
        ->join('RobotsParts', 'Robots.id = RobotsParts.robots_id', 'p')
        ->join('Parts', 'Parts.id = RobotsParts.parts_id', 't')

    // 'SELECT r.* FROM Robots AS r'
    $builder->addFrom('Robots', 'r')

    // 'SELECT Robots.*, p.* FROM Robots, Parts AS p'
    $builder->from('Robots')
        ->addFrom('Parts', 'p')

    // 'SELECT r.*, p.* FROM Robots AS r, Parts AS p'
    $builder->from(array('r' => 'Robots'))
            ->addFrom('Parts', 'p')

    // 'SELECT r.*, p.* FROM Robots AS r, Parts AS p');
    $builder->from(array('r' => 'Robots', 'p' => 'Parts'))

    // 'SELECT Robots.* FROM Robots LIMIT 10'
    $builder->from('Robots')
        ->limit(10)

    // 'SELECT Robots.* FROM Robots LIMIT 10 OFFSET 5'
    $builder->from('Robots')
            ->limit(10, 5)


.. _SQLite: http://en.wikipedia.org/wiki/Lemon_Parser_Generator