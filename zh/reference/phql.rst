Phalcon 查询语言（Phalcon Query Language (PHQL)）
=================================================

Phalcon查询语言，PhalconQL或者简单的称之为PHQL，是一种面向对象的高级SQL语言，允许使用标准化的SQL编写操作语句。
PHQL实现了一个解析器（C编写）来把操作语句解析成RDBMS的语法。

为了达到高性能，Phalcon实现了一个和 SQLite_ 中相似的解析器。它只占用了非常低的内存，同时也是线程安全的。

The parser first checks the syntax of the pass PHQL statement, then builds an intermediate representation of the statement and
finally it converts it to the respective SQL dialect of the target RDBMS.

In PHQL, we've implemented a set of features to make your access to databases more secure:

* Bound parameters are part of the PHQL language helping you to secure your code
* PHQL only allows one SQL statement to be executed per call preventing injections
* PHQL ignores all SQL comments which are often used in SQL injections
* PHQL only allows data manipulation statements, avoiding altering or dropping tables/databases by mistake or externally without authorization
* PHQL implements a high-level abstraction allowing you to handle tables as models and fields as class attributes

范例（Usage Example）
---------------------
为了更好的说明PHQL是如何使用的，在接下的例子中，我们定义了两个模型 “Cars” and “Brands”:

.. code-block:: php

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
            return "sample_cars";
        }

        /**
         * A car only has a Brand, but a Brand have many Cars
         */
        public function initialize()
        {
            $this->belongsTo("brand_id", "Brands", "id");
        }
    }

然后每辆车(Car)都有一个品牌(Brand)，一个品牌(Brand)却可以有很多辆车(Car):

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Brands extends Model
    {
        public $id;

        public $name;

        /**
         * The model Brands is mapped to the "sample_brands" table
         */
        public function getSource()
        {
            return "sample_brands";
        }

        /**
         * A Brand can have many Cars
         */
        public function initialize()
        {
            $this->hasMany("id", "Cars", "brand_id");
        }
    }

创建 PHQL 查询（Creating PHQL Queries）
---------------------------------------
PHQL查询可以通过实例化 :doc:`Phalcon\\Mvc\\Model\\Query <../api/Phalcon_Mvc_Model_Query>` 这个类来创建:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Query;

    // Instantiate the Query
    $query = new Query(
        "SELECT * FROM Cars",
        $this->getDI()
    );

    // Execute the query returning a result if any
    $cars = $query->execute();

在控制器或者视图中，通过 :doc:`models manager <../api/Phalcon_Mvc_Model_Manager>` 可以非常容易 create/execute PHQL查询:

.. code-block:: php

    <?php

    // Executing a simple query
    $query = $this->modelsManager->createQuery("SELECT * FROM Cars");
    $cars  = $query->execute();

    // With bound parameters
    $query = $this->modelsManager->createQuery("SELECT * FROM Cars WHERE name = :name:");
    $cars  = $query->execute(
        [
            "name" => "Audi",
        ]
    );

或者使用一种更简单的执行方式:

.. code-block:: php

    <?php

    // Executing a simple query
    $cars = $this->modelsManager->executeQuery(
        "SELECT * FROM Cars"
    );

    // Executing with bound parameters
    $cars = $this->modelsManager->executeQuery(
        "SELECT * FROM Cars WHERE name = :name:",
        [
            "name" => "Audi",
        ]
    );

选取记录（Selecting Records）
-----------------------------
和SQL类似，PHQL也允许使用SELECT来查询记录，但必须用模型类替换语句的表名:

.. code-block:: php

    <?php

    $query = $manager->createQuery(
        "SELECT * FROM Cars ORDER BY Cars.name"
    );

    $query = $manager->createQuery(
        "SELECT Cars.name FROM Cars ORDER BY Cars.name"
    );

带命名空间的模型类名也是允许的:

.. code-block:: php

    <?php

    $phql  = "SELECT * FROM Formula\Cars ORDER BY Formula\Cars.name";
    $query = $manager->createQuery($phql);

    $phql  = "SELECT Formula\Cars.name FROM Formula\Cars ORDER BY Formula\Cars.name";
    $query = $manager->createQuery($phql);

    $phql  = "SELECT c.name FROM Formula\Cars c ORDER BY c.name";
    $query = $manager->createQuery($phql);

PHQL支持绝大多数的标准SQL语法，甚至非标准的SQL语法也支持，比如LIMIT:

.. code-block:: php

    <?php

    $phql = "SELECT c.name FROM Cars AS c WHERE c.brand_id = 21 ORDER BY c.name LIMIT 100";

    $query = $manager->createQuery($phql);

结果类型（Result Types）
^^^^^^^^^^^^^^^^^^^^^^^^
查询结果的类型依赖于我们查询时列的类型，所以结果类型是多样化的。 如果你获得了一个完整的对象，那么这个对象是 :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>` 的实例。
这样的查询结果集是一组完整的模型对象:

.. code-block:: php

    <?php

    $phql = "SELECT c.* FROM Cars AS c ORDER BY c.name";

    $cars = $manager->executeQuery($phql);

    foreach ($cars as $car) {
        echo "Name: ", $car->name, "\n";
    }

下面这种方式的查询结果集也是一样的:

.. code-block:: php

    <?php

    $cars = Cars::find(
        [
            "order" => "name"
        ]
    );

    foreach ($cars as $car) {
        echo "Name: ", $car->name, "\n";
    }

完整的对象中的数据可以被修改，并且可以重新保存在数据库中，因为它们在数据表里面本身就是一条完整的数据记录。
但是如下这种查询方式，就不会返回一个完整的对象:

.. code-block:: php

    <?php

    $phql = "SELECT c.id, c.name FROM Cars AS c ORDER BY c.name";

    $cars = $manager->executeQuery($phql);

    foreach ($cars as $car) {
        echo "Name: ", $car->name, "\n";
    }

我们只想要数据表中的一些字段，尽管返回的结果集对象仍然是 :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>` 的实例，但是却不能认为是一个完整的对象。
上述例子中，返回的结果集中的每个对象仅仅只有两个列对应的数据。

These values that don't represent complete objects are what we call scalars. PHQL allows you to query all types of scalars: fields, functions, literals, expressions, etc..:

.. code-block:: php

    <?php

    $phql = "SELECT CONCAT(c.id, ' ', c.name) AS id_name FROM Cars AS c ORDER BY c.name";

    $cars = $manager->executeQuery($phql);

    foreach ($cars as $car) {
        echo $car->id_name, "\n";
    }

As we can query complete objects or scalars, we can also query both at once:

.. code-block:: php

    <?php

    $phql = "SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c ORDER BY c.name";

    $result = $manager->executeQuery($phql);

The result in this case is an object :doc:`Phalcon\\Mvc\\Model\\Resultset\\Complex <../api/Phalcon_Mvc_Model_Resultset_Complex>`.
This allows access to both complete objects and scalars at once:

.. code-block:: php

    <?php

    foreach ($result as $row) {
        echo "Name: ", $row->cars->name, "\n";
        echo "Price: ", $row->cars->price, "\n";
        echo "Taxes: ", $row->taxes, "\n";
    }

Scalars are mapped as properties of each "row", while complete objects are mapped as properties with the name of its related model.

连接（Joins）
^^^^^^^^^^^^^
通过PHQL可以非常方便的从多个模型中请求数据记录。PHQL支持绝大多数的JOIN操作。As we defined
relationships in the models, PHQL adds these conditions automatically:

.. code-block:: php

    <?php

    $phql = "SELECT Cars.name AS car_name, Brands.name AS brand_name FROM Cars JOIN Brands";

    $rows = $manager->executeQuery($phql);

    foreach ($rows as $row) {
        echo $row->car_name, "\n";
        echo $row->brand_name, "\n";
    }

By default, an INNER JOIN is assumed. You can specify the type of JOIN in the query:

.. code-block:: php

    <?php

    $phql = "SELECT Cars.*, Brands.* FROM Cars INNER JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql = "SELECT Cars.*, Brands.* FROM Cars LEFT JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql = "SELECT Cars.*, Brands.* FROM Cars LEFT OUTER JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql = "SELECT Cars.*, Brands.* FROM Cars CROSS JOIN Brands";
    $rows = $manager->executeQuery($phql);

也可以手动设置JOIN条件:

.. code-block:: php

    <?php

    $phql = "SELECT Cars.*, Brands.* FROM Cars INNER JOIN Brands ON Brands.id = Cars.brands_id";

    $rows = $manager->executeQuery($phql);

Also, the joins can be created using multiple tables in the FROM clause:

.. code-block:: php

    <?php

    $phql = "SELECT Cars.*, Brands.* FROM Cars, Brands WHERE Brands.id = Cars.brands_id";

    $rows = $manager->executeQuery($phql);

    foreach ($rows as $row) {
        echo "Car: ", $row->cars->name, "\n";
        echo "Brand: ", $row->brands->name, "\n";
    }

If an alias is used to rename the models in the query, those will be used to name the attributes in the every row of the result:

.. code-block:: php

    <?php

    $phql = "SELECT c.*, b.* FROM Cars c, Brands b WHERE b.id = c.brands_id";

    $rows = $manager->executeQuery($phql);

    foreach ($rows as $row) {
        echo "Car: ", $row->c->name, "\n";
        echo "Brand: ", $row->b->name, "\n";
    }

When the joined model has a many-to-many relation to the 'from' model, the intermediate model is implicitly added to the generated query:

.. code-block:: php

    <?php

    $phql = "SELECT Artists.name, Songs.name FROM Artists " .
            "JOIN Songs WHERE Artists.genre = 'Trip-Hop'";

    $result = $this->modelsManager->executeQuery($phql);

This code executes the following SQL in MySQL:

.. code-block:: sql

    SELECT `artists`.`name`, `songs`.`name` FROM `artists`
    INNER JOIN `albums` ON `albums`.`artists_id` = `artists`.`id`
    INNER JOIN `songs` ON `albums`.`songs_id` = `songs`.`id`
    WHERE `artists`.`genre` = 'Trip-Hop'

聚合（Aggregations）
^^^^^^^^^^^^^^^^^^^^
The following examples show how to use aggregations in PHQL:

.. code-block:: php

    <?php

    // How much are the prices of all the cars?
    $phql = "SELECT SUM(price) AS summatory FROM Cars";
    $row  = $manager->executeQuery($phql)->getFirst();
    echo $row['summatory'];

    // How many cars are by each brand?
    $phql = "SELECT Cars.brand_id, COUNT(*) FROM Cars GROUP BY Cars.brand_id";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo $row->brand_id, ' ', $row["1"], "\n";
    }

    // How many cars are by each brand?
    $phql = "SELECT Brands.name, COUNT(*) FROM Cars JOIN Brands GROUP BY 1";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo $row->name, ' ', $row["1"], "\n";
    }

    $phql = "SELECT MAX(price) AS maximum, MIN(price) AS minimum FROM Cars";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo $row["maximum"], ' ', $row["minimum"], "\n";
    }

    // Count distinct used brands
    $phql = "SELECT COUNT(DISTINCT brand_id) AS brandId FROM Cars";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo $row->brandId, "\n";
    }

条件（Conditions）
^^^^^^^^^^^^^^^^^^
Conditions allow us to filter the set of records we want to query. The WHERE clause allows to do that:

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

Also, as part of PHQL, prepared parameters automatically escape the input data, introducing more security:

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Cars WHERE Cars.name = :name:";
    $cars = $manager->executeQuery(
        $phql,
        [
            "name" => "Lamborghini Espada"
        ]
    );

    $phql = "SELECT * FROM Cars WHERE Cars.name = ?0";
    $cars = $manager->executeQuery(
        $phql,
        [
            0 => "Lamborghini Espada"
        ]
    );

插入数据（Inserting Data）
--------------------------
With PHQL it's possible to insert data using the familiar INSERT statement:

.. code-block:: php

    <?php

    // Inserting without columns
    $phql = "INSERT INTO Cars VALUES (NULL, 'Lamborghini Espada', "
          . "7, 10000.00, 1969, 'Grand Tourer')";
    $manager->executeQuery($phql);

    // Specifying columns to insert
    $phql = "INSERT INTO Cars (name, brand_id, year, style) "
          . "VALUES ('Lamborghini Espada', 7, 1969, 'Grand Tourer')";
    $manager->executeQuery($phql);

    // Inserting using placeholders
    $phql = "INSERT INTO Cars (name, brand_id, year, style) "
          . "VALUES (:name:, :brand_id:, :year:, :style)";
    $manager->executeQuery(
        $phql,
        [
            "name"     => "Lamborghini Espada",
            "brand_id" => 7,
            "year"     => 1969,
            "style"    => "Grand Tourer",
        ]
    );

Phalcon doesn't only transform the PHQL statements into SQL. All events and business rules defined
in the model are executed as if we created individual objects manually. Let's add a business rule
on the model cars. A car cannot cost less than $ 10,000:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Message;

    class Cars extends Model
    {
        public function beforeCreate()
        {
            if ($this->price < 10000) {
                $this->appendMessage(
                    new Message("A car cannot cost less than $ 10,000")
                );

                return false;
            }
        }
    }

If we made the following INSERT in the models Cars, the operation will not be successful
because the price does not meet the business rule that we implemented. By checking the
status of the insertion we can print any validation messages generated internally:

.. code-block:: php

    <?php

    $phql = "INSERT INTO Cars VALUES (NULL, 'Nissan Versa', 7, 9999.00, 2015, 'Sedan')";

    $result = $manager->executeQuery($phql);

    if ($result->success() === false) {
        foreach ($result->getMessages() as $message) {
            echo $message->getMessage();
        }
    }

更新数据（Updating Data）
-------------------------
Updating rows is very similar than inserting rows. As you may know, the instruction to
update records is UPDATE. When a record is updated the events related to the update operation
will be executed for each row.

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
        [
            0 => 7000.00,
            1 => 'Sedan',
            2 => 5,
        ]
    );

An UPDATE statement performs the update in two phases:

* First, if the UPDATE has a WHERE clause it retrieves all the objects that match these criteria,
* Second, based on the queried objects it updates/changes the requested attributes storing them to the relational database

This way of operation allows that events, virtual foreign keys and validations take part of the updating process.
In summary, the following code:

.. code-block:: php

    <?php

    $phql = "UPDATE Cars SET price = 15000.00 WHERE id > 101";

    $result = $manager->executeQuery($phql);

    if ($result->success() === false) {
        $messages = $result->getMessages();

        foreach ($messages as $message) {
            echo $message->getMessage();
        }
    }

is somewhat equivalent to:

.. code-block:: php

    <?php

    $messages = null;

    $process = function () use (&$messages) {
        $cars = Cars::find("id > 101");

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

删除数据（Deleting Data）
-------------------------
When a record is deleted the events related to the delete operation will be executed for each row:

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
        [
            "initial" => 1,
            "final"   => 100,
        ]
    );

DELETE operations are also executed in two phases like UPDATEs. To check if the deletion produces
any validation messages you should check the status code returned:

.. code-block:: php

    <?php

    // Deleting multiple rows
    $phql = "DELETE FROM Cars WHERE id > 100";

    $result = $manager->executeQuery($phql);

    if ($result->success() === false) {
        $messages = $result->getMessages();

        foreach ($messages as $message) {
            echo $message->getMessage();
        }
    }

使用查询构建器创建查询（Creating queries using the Query Builder）
------------------------------------------------------------------
A builder is available to create PHQL queries without the need to write PHQL statements, also providing IDE facilities:

.. code-block:: php

    <?php

    // Getting a whole set
    $robots = $this->modelsManager->createBuilder()
        ->from("Robots")
        ->join("RobotsParts")
        ->orderBy("Robots.name")
        ->getQuery()
        ->execute();

    // Getting the first row
    $robots = $this->modelsManager->createBuilder()
        ->from("Robots")
        ->join("RobotsParts")
        ->orderBy("Robots.name")
        ->getQuery()
        ->getSingleResult();

That is the same as:

.. code-block:: php

    <?php

    $phql = "SELECT Robots.* FROM Robots JOIN RobotsParts p ORDER BY Robots.name LIMIT 20";

    $result = $manager->executeQuery($phql);

More examples of the builder:

.. code-block:: php

    <?php

    // 'SELECT Robots.* FROM Robots';
    $builder->from("Robots");

    // 'SELECT Robots.*, RobotsParts.* FROM Robots, RobotsParts';
    $builder->from(
        [
            "Robots",
            "RobotsParts",
        ]
    );

    // 'SELECT * FROM Robots';
    $phql = $builder->columns("*")
                    ->from("Robots");

    // 'SELECT id FROM Robots';
    $builder->columns("id")
            ->from("Robots");

    // 'SELECT id, name FROM Robots';
    $builder->columns(["id", "name"])
            ->from("Robots");

    // 'SELECT Robots.* FROM Robots WHERE Robots.name = "Voltron"';
    $builder->from("Robots")
            ->where("Robots.name = 'Voltron'");

    // 'SELECT Robots.* FROM Robots WHERE Robots.id = 100';
    $builder->from("Robots")
            ->where(100);

    // 'SELECT Robots.* FROM Robots WHERE Robots.type = "virtual" AND Robots.id > 50';
    $builder->from("Robots")
            ->where("type = 'virtual'")
            ->andWhere("id > 50");

    // 'SELECT Robots.* FROM Robots WHERE Robots.type = "virtual" OR Robots.id > 50';
    $builder->from("Robots")
            ->where("type = 'virtual'")
            ->orWhere("id > 50");

    // 'SELECT Robots.* FROM Robots GROUP BY Robots.name';
    $builder->from("Robots")
            ->groupBy("Robots.name");

    // 'SELECT Robots.* FROM Robots GROUP BY Robots.name, Robots.id';
    $builder->from("Robots")
            ->groupBy(["Robots.name", "Robots.id"]);

    // 'SELECT Robots.name, SUM(Robots.price) FROM Robots GROUP BY Robots.name';
    $builder->columns(["Robots.name", "SUM(Robots.price)"])
        ->from("Robots")
        ->groupBy("Robots.name");

    // 'SELECT Robots.name, SUM(Robots.price) FROM Robots GROUP BY Robots.name HAVING SUM(Robots.price) > 1000';
    $builder->columns(["Robots.name", "SUM(Robots.price)"])
        ->from("Robots")
        ->groupBy("Robots.name")
        ->having("SUM(Robots.price) > 1000");

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts';
    $builder->from("Robots")
        ->join("RobotsParts");

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts AS p';
    $builder->from("Robots")
        ->join("RobotsParts", null, "p");

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts ON Robots.id = RobotsParts.robots_id AS p';
    $builder->from("Robots")
        ->join("RobotsParts", "Robots.id = RobotsParts.robots_id", "p");

    // 'SELECT Robots.* FROM Robots
    // JOIN RobotsParts ON Robots.id = RobotsParts.robots_id AS p
    // JOIN Parts ON Parts.id = RobotsParts.parts_id AS t';
    $builder->from("Robots")
        ->join("RobotsParts", "Robots.id = RobotsParts.robots_id", "p")
        ->join("Parts", "Parts.id = RobotsParts.parts_id", "t");

    // 'SELECT r.* FROM Robots AS r';
    $builder->addFrom("Robots", "r");

    // 'SELECT Robots.*, p.* FROM Robots, Parts AS p';
    $builder->from("Robots")
        ->addFrom("Parts", "p");

    // 'SELECT r.*, p.* FROM Robots AS r, Parts AS p';
    $builder->from(["r" => "Robots"])
            ->addFrom("Parts", "p");

    // 'SELECT r.*, p.* FROM Robots AS r, Parts AS p';
    $builder->from(["r" => "Robots", "p" => "Parts"]);

    // 'SELECT Robots.* FROM Robots LIMIT 10';
    $builder->from("Robots")
        ->limit(10);

    // 'SELECT Robots.* FROM Robots LIMIT 10 OFFSET 5';
    $builder->from("Robots")
            ->limit(10, 5);

    // 'SELECT Robots.* FROM Robots WHERE id BETWEEN 1 AND 100';
    $builder->from("Robots")
            ->betweenWhere("id", 1, 100);

    // 'SELECT Robots.* FROM Robots WHERE id IN (1, 2, 3)';
    $builder->from("Robots")
            ->inWhere("id", [1, 2, 3]);

    // 'SELECT Robots.* FROM Robots WHERE id NOT IN (1, 2, 3)';
    $builder->from("Robots")
            ->notInWhere("id", [1, 2, 3]);

    // 'SELECT Robots.* FROM Robots WHERE name LIKE '%Art%';
    $builder->from("Robots")
            ->where("name LIKE :name:", ["name" => "%" . $name . "%"]);

    // 'SELECT r.* FROM Store\Robots WHERE r.name LIKE '%Art%';
    $builder->from(['r' => 'Store\Robots'])
            ->where("r.name LIKE :name:", ["name" => "%" . $name . "%"]);

绑定参数（Bound Parameters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Bound parameters in the query builder can be set as the query is constructed or past all at once when executing:

.. code-block:: php

    <?php

    // Passing parameters in the query construction
    $robots = $this->modelsManager->createBuilder()
        ->from("Robots")
        ->where("name = :name:", ["name" => $name])
        ->andWhere("type = :type:", ["type" => $type])
        ->getQuery()
        ->execute();

    // Passing parameters in query execution
    $robots = $this->modelsManager->createBuilder()
        ->from("Robots")
        ->where("name = :name:")
        ->andWhere("type = :type:")
        ->getQuery()
        ->execute(["name" => $name, "type" => $type]);

禁止使用字面值（Disallow literals in PHQL）
-------------------------------------------
Literals can be disabled in PHQL, this means that directly using strings, numbers and boolean values in PHQL strings
will be disallowed. If PHQL statements are created embedding external data on them, this could open the application
to potential SQL injections:

.. code-block:: php

    <?php

    $login = 'voltron';

    $phql = "SELECT * FROM Models\Users WHERE login = '$login'";

    $result = $manager->executeQuery($phql);

If :code:`$login` is changed to :code:`' OR '' = '`, the produced PHQL is:

.. code-block:: sql

    SELECT * FROM Models\Users WHERE login = '' OR '' = ''

Which is always true no matter what the login stored in the database is.

If literals are disallowed strings can be used as part of a PHQL statement, thus an exception
will be thrown forcing the developer to use bound parameters. The same query can be written in a
secure way like this:

.. code-block:: php

    <?php

    $phql = "SELECT Robots.* FROM Robots WHERE Robots.name = :name:";

    $result = $manager->executeQuery(
        $phql,
        [
            "name" => $name,
        ]
    );

You can disallow literals in the following way:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    Model::setup(
        [
            "phqlLiterals" => false
        ]
    );

Bound parameters can be used even if literals are allowed or not. Disallowing them is just
another security decision a developer could take in web applications.

转义保留字（Escaping Reserved Words）
-------------------------------------
PHQL has a few reserved words, if you want to use any of them as attributes or models names, you need to escape those
words using the cross-database escaping delimiters '[' and ']':

.. code-block:: php

    <?php

    $phql   = "SELECT * FROM [Update]";
    $result = $manager->executeQuery($phql);

    $phql   = "SELECT id, [Like] FROM Posts";
    $result = $manager->executeQuery($phql);

The delimiters are dynamically translated to valid delimiters depending on the database system where the application is currently running on.

PHQL 生命周期（PHQL Lifecycle）
-------------------------------
Being a high-level language, PHQL gives developers the ability to personalize and customize different aspects in order to suit their needs.
The following is the life cycle of each PHQL statement executed:

* The PHQL is parsed and converted into an Intermediate Representation (IR) which is independent of the SQL implemented by database system
* The IR is converted to valid SQL according to the database system associated to the model
* PHQL statements are parsed once and cached in memory. Further executions of the same statement result in a slightly faster execution

使用原生 SQL（Using Raw SQL）
-----------------------------
A database system could offer specific SQL extensions that aren't supported by PHQL, in this case, a raw SQL can be appropriate:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

    class Robots extends Model
    {
        public static function findByCreateInterval()
        {
            // A raw SQL statement
            $sql = "SELECT * FROM robots WHERE id > 0";

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

If Raw SQL queries are common in your application a generic method could be added to your model:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

    class Robots extends Model
    {
        public static function findByRawSql($conditions, $params = null)
        {
            // A raw SQL statement
            $sql = "SELECT * FROM robots WHERE $conditions";

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

The above findByRawSql could be used as follows:

.. code-block:: php

    <?php

    $robots = Robots::findByRawSql(
        "id > ?",
        [
            10
        ]
    );

注意事项（Troubleshooting）
---------------------------
Some things to keep in mind when using PHQL:

* Classes are case-sensitive, if a class is not defined with the same name as it was created this could lead to an unexpected behavior in operating systems with case-sensitive file systems such as Linux.
* Correct charset must be defined in the connection to bind parameters with success.
* Aliased classes aren't replaced by full namespaced classes since this only occurs in PHP code and not inside strings.
* If column renaming is enabled avoid using column aliases with the same name as columns to be renamed, this may confuse the query resolver.

.. _SQLite: http://en.wikipedia.org/wiki/Lemon_Parser_Generator
