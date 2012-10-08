Phalcon Query Language (PHQL)
=============================

Phalcon Query Language, PhalconQL or simply PHQL is a high level, object oriented SQL dialect that allows to write queries using a standardized SQL-like language. PHQL is implemented as a parser (written in C) that translates syntax in that of the target RDBMS.

To achieve the highest performance possible, Phalcon provides a parser that uses the same technology as SQLite_. This technology provides a small in-memory parser with a very low memory footprint that is also thread-safe.

The parser first checks the syntax of the passed PHQL statement, then builds an intermediate representation of the statement and finally it converts it to the respective SQL dialect of the target RDBMS.

Currently, PHQL only supports data manipulation statements such as SELECT, INSERT, UPDATE and DELETE.

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
            $this->hasMany('id', 'Brands', 'brand_id');
        }
    }

Creating PHQL Queries
---------------------
PHQL queries can be created just instantiating the class :doc:`Phalcon\\Mvc\\Model\\Query <../api/Phalcon_Mvc_Model_Query>`:

.. code-block:: php

    <?php

    //Instantiate the Query
    $query = new Phalcon\Mvc\Model\Query("SELECT * FROM Cars");

    //Pass the DI container
    $query->setDI($di);

    //Execute the query returning a result if any
    $robots = $query->execute();

From a controller or a view, it's easy create/execute them using a injected :doc:`models manager <../api/Phalcon_Mvc_Model_Manager>`:

.. code-block:: php

    <?php

    $query = $this->modelsManager->createQuery("SELECT * FROM Cars");

    $robots = $query->execute();

Or simply execute it:

.. code-block:: php

    <?php

    $robots = $this->modelsManager->executeQuery("SELECT * FROM Cars");

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

    $query = $manager->createQuery("SELECT * FROM Formula\Cars ORDER BY Formula\Cars.name");
    $query = $manager->createQuery("SELECT Formula\Cars.name FROM Formula\Cars ORDER BY Formula\Cars.name");
    $query = $manager->createQuery("SELECT c.name FROM Formula\Cars c ORDER BY c.name");

Most of the SQL standard is supported by PHQL even nonstandard directives as LIMIT:

.. code-block:: php

    <?php

    $phql   = "SELECT c.name FROM Cars AS c "
       . "WHERE c.brand_id = 21 ORDER BY c.name LIMIT 100";
    $query = $manager->createQuery($phql);

Results Types
^^^^^^^^^^^^^
Depending on the type of columns we query, the result type will vary. If you retrieve a single whole object then the object returned will be a :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`. This kind of resultset is a set of complete model objects:

.. code-block:: php

    <?php

    $phql  = "SELECT c.* FROM Cars AS c ORDER BY c.name";
    $cars = $manager->executeQuery($phql);
    foreach ($cars as $car){
        echo "Name: ", $car->name, "\n";
    }

This is exactly the same as:

.. code-block:: php

    <?php

    $cars = Cars::find(array("order" => "name"));
    foreach ($cars as $car){
        echo "Name: ", $car->name, "\n";
    }

Complete objects can be modified and re-saved in the database because they represent a complete record of the associated table. There are other types of queries that do not return complete objects, for example:

.. code-block:: php

    <?php

    $phql  = "SELECT c.id, c.name FROM Cars AS c ORDER BY c.name";
    $cars = $manager->executeQuery($phql);
    foreach ($cars as $car){
        echo "Name: ", $car->name, "\n";
    }

We are only requesting some fields in the table therefore those can not be considered an entire object. In this case also returns a type resulset :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`. However, each element is an standard object that only contains the two columns that were requested.

These values ​​that don't represent complete objects we call them scalars. PHQL allows you to query all types of scalars: fields, functions, literals, expressions, etc..:

.. code-block:: php

    <?php

    $phql  = "SELECT CONCAT(c.id, ' ', c.name) AS id_name FROM Cars AS c ORDER BY c.name";
    $cars = $manager->executeQuery($phql);
    foreach ($cars as $car){
        echo $car->id_name, "\n";
    }

As we can query complete objects or scalars, also we can query both at once:

.. code-block:: php

    <?php

    $phql  = "SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c ORDER BY c.name";
    $result = $manager->executeQuery($phql);

The result in this case is an object :doc:`Phalcon\\Mvc\\Model\\Resultset\\Complex <../api/Phalcon_Mvc_Model_Resultset_Complex>`. This allows access to both complete objects and scalars at once:

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
It's easy to request records from multiple models using PHQL. Most kinds of Joins are supported. As we defined relationships in the models. PHQL adds these conditions automatically:

.. code-block:: php

    <?php

    $phql   = "SELECT Cars.name AS car_name, Brands.name AS brand_name FROM Cars JOIN Brands";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row){
        echo $row->car_name, "\n";
        echo $row->brand_name, "\n";
    }

By default, a INNER JOIN is assumed. You can specify the type of JOIN in the query:

.. code-block:: php

    <?php

    $phql   = "SELECT Cars.*, Brands.* FROM Cars INNER JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql   = "SELECT CCars.*, Brands.* FROM Cars LEFT JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql   = "SELECT Cars.*, Brands.* FROM Cars LEFT OUTER JOIN Brands";
    $rows = $manager->executeQuery($phql);

    $phql   = "SELECT Cars.*, Brands.* FROM Cars CROSS JOIN Brands";
    $rows = $manager->executeQuery($phql);

Also is posibly, manually set the conditions of the JOIN:

.. code-block:: php

    <?php

    $phql   = "SELECT Cars.*, Brands.* FROM Cars INNER JOIN Brands ON Brands.id = Cars.brands_id";
    $rows = $manager->executeQuery($phql);

Also, the joins can be created using multiple tables in the FROM clause:

.. code-block:: php

    <?php

    $phql   = "SELECT Cars.*, Brands.* FROM Cars, Brands WHERE Brands.id = Cars.brands_id";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row) {
        echo "Car: ", $row->cars->name, "\n";
        echo "Brand: ", $row->brands->name, "\n";
    }

Aggregations
^^^^^^^^^^^^
The following examples shows how to use aggregations in PHQL:

.. code-block:: php

    <?php

    //How much are the prices of all the cars?
    $phql   = "SELECT SUM(price) AS summatory FROM Cars";
    $row = $manager->executeQuery($phql)->getFirst();
    echo $row['summatory'];

    //How many cars are by each brand?
    $phql   = "SELECT Cars.brand_id, COUNT(*) FROM Cars GROUP BY Cars.brand_id";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row){
        echo $row->brand_id, ' ', $row["1"], "\n";
    }

    //How many cars are by each brand?
    $phql   = "SELECT Brands.name, COUNT(*) FROM Cars JOIN Brands GROUP BY 1";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row){
        echo $row->name, ' ', $row["1"], "\n";
    }

    $phql   = "SELECT MAX(price) AS maximum, MIN(price) AS minimum FROM Cars";
    $rows = $manager->executeQuery($phql);
    foreach ($rows as $row){
        echo $row["maximum"], ' ', $row["minimum"], "\n";
    }

Conditions
^^^^^^^^^^
Conditions allow us to filter the set of records we want to query. The WHERE clause allows to to that:

.. code-block:: php

    <?php

    //Simple conditions
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

Also, as part of PHQL, prepared parameters automatically escape the input data, introducing more security:

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Cars WHERE Cars.name = :name:";
    $cars = $manager->executeQuery($phql, array("name" => 'Lamborghini Espada'));

    $phql = "SELECT * FROM Cars WHERE Cars.name = ?0";
    $cars = $manager->executeQuery($phql, array(0 => 'Lamborghini Espada'));

Creating Rows
-------------
With PHQL is possible insert data using the familiar INSERT statement:

.. code-block:: php

    <?php

    //Inserting without columns
    $phql = "INSERT INTO Cars VALUES (NULL, 'Lamborghini Espada', 7, 10000.00, 1969, 'Grand Tourer')";
    $manager->executeQuery($phql);

    //Specifyng columns to insert
    $phql = "INSERT INTO Cars (name, brand_id, year, style) "
     . "VALUES ('Lamborghini Espada', 7, 1969, 'Grand Tourer')";
    $manager->executeQuery($phql);

    //Inserting using placeholders
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

Phalcon not just only transform the PHQL statements into SQL. All events and business rules defined in the model are executed as if we created individual objects manually. Let's add a business rule to the model cars. A car cannot cost less than $ 10,000:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Message;

    class Cars extends Phalcon\Mvc\Model
    {

        public function beforeCreate()
        {
            if ($this->price < 10000) {
                $this->appendMessage(new Message("A car cannot cost less than $ 10,000"));
                return false;
            }
        }

    }

If we made the following INSERT in the the models Cars, the operation will not be successful because the price does not meet the business rule that we implemented:

.. code-block:: php

    <?php

    $phql = "INSERT INTO Cars VALUES (NULL, 'Nissan Versa', 7, 9999.00, 2012, 'Sedan')";
    $result = $manager->executeQuery($phql);
    if ($result->success() == false) {
        foreach ($result->getMessages() as $message){
            echo $message->getMessage();
        }
    }

Updating Rows
-------------
Update rows is very similar than Insert rows. As you may know, the instruction to update records is UPDATE. When a record is updated
the events related to the update operation will be executed for each row.

.. code-block:: php

    <?php

    //Updating a single column
    $phql = "UPDATE Cars SET price = 15000.00 WHERE id = 101";
    $manager->executeQuery($phql);

    //Updating multiples columns
    $phql = "UPDATE Cars SET price = 15000.00, type = 'Sedan' WHERE id = 101";
    $manager->executeQuery($phql);

    //Updating multiples rows
    $phql = "UPDATE Cars SET price = 7000.00, type = 'Sedan' WHERE brands_id > 5";
    $manager->executeQuery($phql);

    //Using placeholders
    $phql = "UPDATE Cars SET price = ?0, type = ?1 WHERE brands_id > ?2";
    $manager->executeQuery($phql, array(
        0 => 7000.00,
        1 => 'Sedan',
        2 => 5
    ));

Deleting Rows
-------------
When a record is deleted the events related to the delete operation will be executed for each row.

.. code-block:: php

    <?php

    //Deleting a single row
    $phql = "DELETE FROM Cars WHERE id = 101";
    $manager->executeQuery($phql);

    //Deleting multiple rows
    $phql = "DELETE FROM Cars WHERE id > 100";
    $manager->executeQuery($phql);


.. _SQLite: http://en.wikipedia.org/wiki/Lemon_Parser_Generator