Phalcon Query Language (PHQL)
=============================

Phalcon Query Language, PhalconQL or simply PHQL is a high level, object oriented SQL dialect that allows to write queries using a
standarized SQL-like language. PHQL is implemented as a parser (written in C) that translates syntax in that of the target RDBMS.

To achieve the highest performance possible, Phalcon provides a parser that uses the same technology as SQLite_. This technology provides a small in-memory parser with a very low memory footprint that is also thread-safe.

The parser first checks the syntax of the passed PHQL statement, then builds an intermediate representation of the statement and finally it converts it to the respective SQL dialect of the target RDBMS.

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
As the familiar SQL, PHQL allows querying of records using the SELECT statement we know, except that instead of specifying tables, we use models.

.. code-block:: php

    <?php

    $query = $manager->createQuery("SELECT * FROM Cars ORDER BY Cars.name");
    $query = $manager->createQuery("SELECT Cars.name FROM Cars ORDER BY Cars.name");

Most of the SQL standard is supported by PHQL even nonstandard directives as LIMIT:

.. code-block:: php

    <?php

    $phql   = "SELECT c.name FROM Cars AS c "
       . "WHERE c.brand_id = 21 ORDER BY c.name LIMIT 100";
    $query = $manager->createQuery($sql);

SELECT Queries Results
^^^^^^^^^^^^^^^^^^^^^^
Depending on the type of columns we query, the result type will vary. If you retrieve a single whole object then the object returned will be a :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`. This kind of resultset is a set of complete model objects:

.. code-block:: php

    <?php

    $phql  = "SELECT c.* FROM Cars AS c ORDER BY c.name";
    $cars = $manager->executeQuery($sql);
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
    $cars = $manager->executeQuery($sql);
    foreach ($cars as $car){
        echo "Name: ", $car->name, "\n";
    }

We are only requesting some fields in the table therefore those can not be considered an entire object. In this case also returns a type resulset :doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`. However, each element is an standard object that only contains the two columns that were requested.

These values ​​that don't represent complete objects we call them scalars. PHQL allows you to query all types of scalars: fields, functions, literals, expressions, etc..:

.. code-block:: php

    <?php

    $phql  = "SELECT CONCAT(c.id, ' ', c.name) AS id_name FROM Cars AS c ORDER BY c.name";
    $cars = $manager->executeQuery($sql);
    foreach ($cars as $car){
        echo $car->id_name, "\n";
    }

As we can query complete objects or scalars, also we can query both at once:

.. code-block:: php

    <?php

    $phql  = "SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c ORDER BY c.name";
    $result = $manager->executeQuery($sql);

The result in this case is an object :doc:`Phalcon\\Mvc\\Model\\Resultset\\Complex <../api/Phalcon_Mvc_Model_Resultset_Complex>`. This allows access both complete objects and scalars at once:

.. code-block:: php

    <?php

    foreach ($result as $row) {
        echo "Name: ", $row->cars->name, "\n";
        echo "Price: ", $row->cars->price, "\n";
        echo "Taxes: ", $row->taxes, "\n";
    }

Scalars are mapped as properties of each "row", while complete objects are mapped as the name of its related model.

.. _SQLite: http://en.wikipedia.org/wiki/Lemon_Parser_Generator