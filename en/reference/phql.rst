Phalcon Query Language (PHQL)
=============================

Phalcon Query Language, PhalconQL or simply PHQL is a high-level, object-oriented SQL dialect that allows to write queries using a
standardized SQL-like language. PHQL is implemented as a parser (written in C) that translates syntax in that of the target RDBMS.

To achieve the highest performance possible, Phalcon provides a parser that uses the same technology as SQLite_. This technology
provides a small in-memory parser with a very low memory footprint that is also thread-safe.

The parser first checks the syntax of the pass PHQL statement, then builds an intermediate representation of the statement and
finally it converts it to the respective SQL dialect of the target RDBMS.

In PHQL, we've implemented a set of features to make your access to databases more secure:

* Bound parameters are part of the PHQL language helping you to secure your code
* PHQL only allows one SQL statement to be executed per call preventing injections
* PHQL ignores all SQL comments which are often used in SQL injections
* PHQL only allows data manipulation statements, avoiding altering or dropping tables/databases by mistake or externally without authorization
* PHQL implements a high-level abstraction allowing you to handle models as tables and class attributes as fields

Usage Example
-------------
To better explain how PHQL works consider the following example. We have two models “Cars” and “Brands”:

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

And every Car has a Brand, so a Brand has many Cars:

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
PHQL queries can be created just instantiating the class :doc:`Phalcon\\Mvc\\Model\\Query <../api/Phalcon_Mvc_Model_Query>`:

.. code-block:: php

    <?php

    // Instantiate the Query
    $query = new Phalcon\Mvc\Model\Query("SELECT * FROM Cars");

    // Pass the DI container
    $query->setDI($di);

    // Execute the query returning a result if any
    $cars = $query->execute();

From a controller or a view, it's easy create/execute them using an injected :doc:`models manager <../api/Phalcon_Mvc_Model_Manager>`:

.. code-block:: php

    <?php

    //Executing a simple query
    $query = $this->modelsManager->createQuery("SELECT * FROM Cars");
    $cars = $query->execute();

    //With bound parameters
    $query = $this->modelsManager->createQuery("SELECT * FROM Cars WHERE name = :name:");
    $cars = $query->execute(array(
        'name' => 'Audi'
    ));

Or simply execute it:

.. code-block:: php

    <?php

    //Executing a simple query
    $cars = $this->modelsManager->executeQuery("SELECT * FROM Cars");

    //Executing with bound parameters
    $cars = $this->modelsManager->executeQuery("SELECT * FROM Cars WHERE name = :name:", array(
        'name' => 'Audi'
    ));

Selecting Records
-----------------
As the familiar SQL, PHQL allows querying of records using the SELECT statement we know, except that instead of specifying tables, we use the models classes:

.. code-block:: php

    <?php

    $query = $manager->createQuery("SELECT * FROM Cars ORDER BY Cars.name");
    $query = $manager->createQuery("SELECT Cars.name FROM Cars ORDER BY Cars.name");

Classes in namespaces are also allowed:

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Formula\Cars ORDER BY Formula\Cars.name";
    $query = $manager->createQuery($phql);

    $phql = "SELECT Formula\Cars.name FROM Formula\Cars ORDER BY Formula\Cars.name";
    $query = $manager->createQuery($phql);

    $phql = "SELECT c.name FROM Formula\Cars c ORDER BY c.name";
    $query = $manager->createQuery($phql);

Most of the SQL standard is supported by PHQL even nonstandard directives as LIMIT:

.. code-block:: php

    <?php

    $phql   = "SELECT c.name FROM Cars AS c "
       . "WHERE c.brand_id = 21 ORDER BY c.name LIMIT 100";
    $query = $manager->createQuery($phql);

Result Types
^^^^^^^^^^^^
Depending on the type of columns we query, the result type will vary. If you retrieve a single whole object, then the object returned is
a :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`. This kind of resultset is a set of complete model objects:

.. code-block:: php

    <?php

    $phql = "SELECT c.* FROM Cars AS c ORDER BY c.name";
    $cars = $manager->executeQuery($phql);
    foreach ($cars as $car) {
        echo "Name: ", $car->name, "\n";
    }

This is exactly the same as:

.. code-block:: php

    <?php

    $cars = Cars::find(array("order" => "name"));
    foreach ($cars as $car) {
        echo "Name: ", $car->name, "\n";
    }

Complete objects can be modified and re-saved in the database because they represent a complete record of the associated table. There are
other types of queries that do not return complete objects, for example:

.. code-block:: php

    <?php

    $phql = "SELECT c.id, c.name FROM Cars AS c ORDER BY c.name";
    $cars = $manager->executeQuery($phql);
    foreach ($cars as $car) {
        echo "Name: ", $car->name, "\n";
    }

We are only requesting some fields in the table therefore those cannot be considered an entire object. In this case, also returns a
resulset type :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`. However, each element is a standard
object that only contain the two columns that were requested.

These values that don't represent complete objects we call them scalars. PHQL allows you to query all types of scalars: fields, functions, literals, expressions, etc..:

.. code-block:: php

    <?php

    $phql = "SELECT CONCAT(c.id, ' ', c.name) AS id_name FROM Cars AS c ORDER BY c.name";
    $cars = $manager->executeQuery($phql);
    foreach ($cars as $car) {
        echo $car->id_name, "\n";
    }

As we can query complete objects or scalars, also we can query both at once:

.. code-block:: php

    <?php

    $phql   = "SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c ORDER BY c.name";
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

Joins
^^^^^
It's easy to request records from multiple models using PHQL. Most kinds of Joins are supported. As we defined
relationships in the models. PHQL adds these conditions automatically:

.. code-block:: php

    <?php

    $phql  = "SELECT Cars.name AS car_name, Brands.name AS brand_name FROM Cars JOIN Brands";
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

Also is possibly, manually set the conditions of the JOIN:

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

Aggregations
^^^^^^^^^^^^
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

Conditions
^^^^^^^^^^
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
    $cars = $manager->executeQuery($phql, array("name" => 'Lamborghini Espada'));

    $phql = "SELECT * FROM Cars WHERE Cars.name = ?0";
    $cars = $manager->executeQuery($phql, array(0 => 'Lamborghini Espada'));


Inserting Data
--------------
With PHQL is possible insert data using the familiar INSERT statement:

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

Phalcon not just only transform the PHQL statements into SQL. All events and business rules defined
in the model are executed as if we created individual objects manually. Let's add a business rule
on the model cars. A car cannot cost less than $ 10,000:

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

If we made the following INSERT in the models Cars, the operation will not be successful
because the price does not meet the business rule that we implemented:

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

Updating Data
-------------
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
    $manager->executeQuery($phql, array(
        0 => 7000.00,
        1 => 'Sedan',
        2 => 5
    ));

An UPDATE statement performs the update in two phases:

* First, if the UPDATE has a WHERE clause it retrieves all the objects that match these criteria,
* Second, based on the queried objects it updates/changes the requested attributes storing them to the relational database

This way of operation allows that events, virtual foreign keys and validations take part of the updating process.
In summary, the following code:

.. code-block:: php

    <?php

    $phql = "UPDATE Cars SET price = 15000.00 WHERE id > 101";
    $success = $manager->executeQuery($phql);

is somewhat equivalent to:

.. code-block:: php

    <?php

    $messages = null;

    $process = function() use (&$messages) {
        foreach (Cars::find("id > 101") as $car) {
            $car->price = 15000;
            if ($car->save() == false) {
                $messages = $car->getMessages();
                return false;
            }
        }
        return true;
    };

    $success = $process();

Deleting Data
-------------
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
        array(
            'initial' => 1,
            'final' => 100
        )
    );

DELETE operations are also executed in two phases like UPDATEs.

Creating queries using the Query Builder
----------------------------------------
A builder is available to create PHQL queries without the need to write PHQL statements, this is also IDE friendly:

.. code-block:: php

    <?php

    //Getting a whole set
    $robots = $this->modelsManager->createBuilder()
        ->from('Robots')
        ->join('RobotsParts')
        ->order('Robots.name')
        ->getQuery()
        ->execute();

    //Getting the first row
    $robots = $this->modelsManager->createBuilder()
        ->from('Robots')
        ->join('RobotsParts')
        ->order('Robots.name')
        ->getQuery()
        ->getSingleResult();

That is the same as:

.. code-block:: php

    <?php

    $phql = "SELECT Robots.*
        FROM Robots JOIN RobotsParts p
        ORDER BY Robots.name LIMIT 20";
    $result = $manager->executeQuery($phql);

More examples of the builder:

.. code-block:: php

    <?php

    $builder->from('Robots');
    // 'SELECT Robots.* FROM Robots'

    // 'SELECT Robots.*, RobotsParts.* FROM Robots, RobotsParts'
    $builder->from(array('Robots', 'RobotsParts'));

    // 'SELECT * FROM Robots'
    $phql = $builder->columns('*')
                    ->from('Robots');

    // 'SELECT id FROM Robots'
    $builder->columns('id')
            ->from('Robots');

    // 'SELECT id, name FROM Robots'
    $builder->columns(array('id', 'name'))
            ->from('Robots');

    // 'SELECT Robots.* FROM Robots WHERE Robots.name = "Voltron"'
    $builder->from('Robots')
            ->where('Robots.name = "Voltron"');

    // 'SELECT Robots.* FROM Robots WHERE Robots.id = 100'
    $builder->from('Robots')
            ->where(100);

    // 'SELECT Robots.* FROM Robots WHERE Robots.type = "virtual" AND Robots.id > 50'
    $builder->from('Robots')
            ->where('type = "virtual"')
            ->andWhere('id > 50');

    // 'SELECT Robots.* FROM Robots WHERE Robots.type = "virtual" OR Robots.id > 50'
    $builder->from('Robots')
            ->where('type = "virtual"')
            ->orWhere('id > 50');

    // 'SELECT Robots.* FROM Robots GROUP BY Robots.name'
    $builder->from('Robots')
            ->groupBy('Robots.name');

    // 'SELECT Robots.* FROM Robots GROUP BY Robots.name, Robots.id'
    $builder->from('Robots')
            ->groupBy(array('Robots.name', 'Robots.id'));

    // 'SELECT Robots.name, SUM(Robots.price) FROM Robots GROUP BY Robots.name'
    $builder->columns(array('Robots.name', 'SUM(Robots.price)'))
        ->from('Robots')
        ->groupBy('Robots.name');

    // 'SELECT Robots.name, SUM(Robots.price) FROM Robots
    // GROUP BY Robots.name HAVING SUM(Robots.price) > 1000'
    $builder->columns(array('Robots.name', 'SUM(Robots.price)'))
        ->from('Robots')
        ->groupBy('Robots.name')
        ->having('SUM(Robots.price) > 1000');

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts');
    $builder->from('Robots')
        ->join('RobotsParts');

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts AS p');
    $builder->from('Robots')
        ->join('RobotsParts', null, 'p');

    // 'SELECT Robots.* FROM Robots JOIN RobotsParts ON Robots.id = RobotsParts.robots_id AS p');
    $builder->from('Robots')
        ->join('RobotsParts', 'Robots.id = RobotsParts.robots_id', 'p');

    // 'SELECT Robots.* FROM Robots
    // JOIN RobotsParts ON Robots.id = RobotsParts.robots_id AS p
    // JOIN Parts ON Parts.id = RobotsParts.parts_id AS t'
    $builder->from('Robots')
        ->join('RobotsParts', 'Robots.id = RobotsParts.robots_id', 'p')
        ->join('Parts', 'Parts.id = RobotsParts.parts_id', 't');

    // 'SELECT r.* FROM Robots AS r'
    $builder->addFrom('Robots', 'r');

    // 'SELECT Robots.*, p.* FROM Robots, Parts AS p'
    $builder->from('Robots')
        ->addFrom('Parts', 'p');

    // 'SELECT r.*, p.* FROM Robots AS r, Parts AS p'
    $builder->from(array('r' => 'Robots'))
            ->addFrom('Parts', 'p');

    // 'SELECT r.*, p.* FROM Robots AS r, Parts AS p');
    $builder->from(array('r' => 'Robots', 'p' => 'Parts'));

    // 'SELECT Robots.* FROM Robots LIMIT 10'
    $builder->from('Robots')
        ->limit(10);

    // 'SELECT Robots.* FROM Robots LIMIT 10 OFFSET 5'
    $builder->from('Robots')
            ->limit(10, 5);

    // 'SELECT Robots.* FROM Robots WHERE id BETWEEN 1 AND 100
    $builder->from('Robots')
            ->betweenWhere('id', 1, 100);

    // 'SELECT Robots.* FROM Robots WHERE id IN (1, 2, 3)
    $builder->from('Robots')
            ->inWhere('id', array(1, 2, 3));

    // 'SELECT Robots.* FROM Robots WHERE id NOT IN (1, 2, 3)
    $builder->from('Robots')
            ->notInWhere('id', array(1, 2, 3));

Escaping Reserved Words
-----------------------
PHQL has a few reserved words, if you want to use any of them as attributes or models names, you need to escape those
words using the cross-database escaping delimiters '[' and ']':

.. code-block:: php

    <?php

    $phql = "SELECT * FROM [Update]";
    $result = $manager->executeQuery($phql);

    $phql = "SELECT id, [Like] FROM Posts";
    $result = $manager->executeQuery($phql);

The delimiters are dynamically translated to valid delimiters depending on the database system where the application is currently running on.

PHQL Lifecycle
--------------
Being a high-level language, PHQL gives developers the ability to personalize and customize different aspects in order to suit their needs.
The following is the life cycle of each PHQL statement executed:

* The PHQL is parsed and converted into an Intermediate Representation (IR) which is independent of the SQL implemented by database system
* The IR is converted to valid SQL according to the database system associated to the model

Using Raw SQL
-------------
A database system could offer specific SQL extensions that aren't supported by PHQL, in this case, a raw SQL can be appropiate:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

    class Robots extends Phalcon\Mvc\Model
    {
        public static function findByCreateInterval()
        {
            // A raw SQL statement
            $sql = "SELECT * FROM robots WHERE id > 0";

            // Base model
            $robot = new Robots();

            // Execute the query
            return new Resultset(null, $robot, $robot->getReadConnection()->query($sql));
        }
    }

If Raw SQL queries are common in your application a generic method could be added to your model:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

    class Robots extends Phalcon\Mvc\Model
    {
        public static function findByRawSql($conditions, $params=null)
        {
            // A raw SQL statement
            $sql = "SELECT * FROM robots WHERE $conditions";

            // Base model
            $robot = new Robots();

            // Execute the query
            return new Resultset(null, $robot, $robot->getReadConnection()->query($sql, $params));
        }
    }

The above findByRawSql could be used as follows:

.. code-block:: php

    <?php

    $robots = Robots::findByRawSql('id > ?', array(10));

Troubleshooting
---------------
Some things to keep in mind when using PHQL:

* Classes are case-sensitive, if a class is not defined as it was defined this could lead to an unexpected behavior.
* The correct charset must be defined in the connection to bind parameters with success.
* Aliased classes aren't replaced by full namespaced classes since this only occurs in PHP code and not inside strings

.. _SQLite: http://en.wikipedia.org/wiki/Lemon_Parser_Generator
