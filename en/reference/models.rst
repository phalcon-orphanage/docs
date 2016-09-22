Working with Models
===================

A model represents the information (data) of the application and the rules to manipulate that data. Models are primarily used for managing
the rules of interaction with a corresponding database table. In most cases, each table in your database will correspond to one model in
your application. The bulk of your application's business logic will be concentrated in the models.

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` is the base for all models in a Phalcon application. It provides database independence, basic
CRUD functionality, advanced finding capabilities, and the ability to relate models to one another, among other services.
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` avoids the need of having to use SQL statements because it translates
methods dynamically to the respective database engine operations.

.. highlights::

    Models are intended to work with the database on a high layer of abstraction. If you need to work with databases at a lower level check out the
    :doc:`Phalcon\\Db <../api/Phalcon_Db>` component documentation.

Creating Models
---------------
A model is a class that extends from :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`. Its class name should be in camel case notation:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {

    }

.. highlights::

    If you're using PHP 5.4/5.5 it is recommended you declare each column that makes part of the model in order to save
    memory and reduce the memory allocation.

By default, the model "Store\\Toys\\Robots" will refer to the table "robots". If you want to manually specify another name for the mapping table,
you can use the :code:`setSource()` method:

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

The model Robots now maps to "toys_robots" table. The :code:`initialize()` method aids in setting up the model with a custom behavior i.e. a different table.

The :code:`initialize()` method is only called once during the request, it's intended to perform initializations that apply for
all instances of the model created within the application. If you want to perform initialization tasks for every instance
created you can use the :code:`onConstruct()` method:

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

Public properties vs. Setters/Getters
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Models can be implemented with properties of public scope, meaning that each property can be read/updated
from any part of the code that has instantiated that model class without any restrictions:

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

By using getters and setters you can control which properties are visible publicly perform various transformations
to the data (which would be impossible otherwise) and also add validation rules to the data stored in the object:

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

Public properties provide less complexity in development. However getters/setters can heavily increase the testability,
extensibility and maintainability of applications. Developers can decide which strategy is more appropriate for the
application they are creating. The ORM is compatible with both schemes of defining properties.

.. highlights::

    Underscores in property names can be problematic when using getters and setters.

If you use underscores in your property names, you must still use camel case in your getter/setter declarations for use
with magic methods. (e.g. $model->getPropertyName instead of $model->getProperty_name, $model->findByPropertyName
instead of $model->findByProperty_name, etc.). As much of the system expects camel case, and underscores are commonly
removed, it is recommended to name your properties in the manner shown throughout the documentation. You can use a
column map (as described above) to ensure proper mapping of your properties to their database counterparts.

Understanding Records To Objects
--------------------------------
Every instance of a model represents a row in the table. You can easily access record data by reading object properties. For example,
for a table "robots" with the records:

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

You could find a certain record by its primary key and then print its name:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Find record with id = 3
    $robot = Robots::findFirst(3);

    // Prints "Terminator"
    echo $robot->name;

Once the record is in memory, you can make modifications to its data and then save changes:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst(3);

    $robot->name = "RoboCop";

    $robot->save();

As you can see, there is no need to use raw SQL statements. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` provides high database
abstraction for web applications.

Finding Records
---------------
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` also offers several methods for querying records. The following examples will show you
how to query one or more records from a model:

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

    If you want find record by external data (such as user input) or variable data you must use `Binding Parameters`_.

You could also use the :code:`findFirst()` method to get only the first record matching the given criteria:

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

Both :code:`find()` and :code:`findFirst()` methods accept an associative array specifying the search criteria:

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

The available query options are:

+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Parameter   | Description                                                                                                                                                                                                                          | Example                                                                    |
+=============+======================================================================================================================================================================================================================================+============================================================================+
| conditions  | Search conditions for the find operation. Is used to extract only those records that fulfill a specified criterion. By default :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` assumes the first parameter are the conditions. | :code:`"conditions" => "name LIKE 'steve%'"`                               |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| columns     | Return specific columns instead of the full columns in the model. When using this option an incomplete object is returned                                                                                                            | :code:`"columns" => "id, name"`                                            |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| bind        | Bind is used together with options, by replacing placeholders and escaping values thus increasing security                                                                                                                           | :code:`"bind" => ["status" => "A", "type" => "some-time"]`                 |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| bindTypes   | When binding parameters, you can use this parameter to define additional casting to the bound parameters increasing even more the security                                                                                           | :code:`"bindTypes" => [Column::BIND_PARAM_STR, Column::BIND_PARAM_INT]`    |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| order       | Is used to sort the resultset. Use one or more fields separated by commas.                                                                                                                                                           | :code:`"order" => "name DESC, status"`                                     |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| limit       | Limit the results of the query to results to certain range                                                                                                                                                                           | :code:`"limit" => 10`                                                      |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| offset      | Offset the results of the query by a certain amount                                                                                                                                                                                  | :code:`"offset" => 5`                                                      |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| group       | Allows to collect data across multiple records and group the results by one or more columns                                                                                                                                          | :code:`"group" => "name, status"`                                          |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| for_update  | With this option, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` reads the latest available data, setting exclusive locks on each row it reads                                                                                | :code:`"for_update" => true`                                               |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| shared_lock | With this option, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` reads the latest available data, setting shared locks on each row it reads                                                                                   | :code:`"shared_lock" => true`                                              |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| cache       | Cache the resultset, reducing the continuous access to the relational system                                                                                                                                                         | :code:`"cache" => ["lifetime" => 3600, "key" => "my-find-key"]`            |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+
| hydration   | Sets the hydration strategy to represent each returned record in the result                                                                                                                                                          | :code:`"hydration" => Resultset::HYDRATE_OBJECTS`                          |
+-------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+----------------------------------------------------------------------------+

If you prefer, there is also available a way to create queries in an object-oriented way, instead of using an array of parameters:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robots = Robots::query()
        ->where("type = :type:")
        ->andWhere("year < 2000")
        ->bind(["type" => "mechanical"])
        ->order("name")
        ->execute();

The static method :code:`query()` returns a :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` object that is friendly with IDE autocompleters.

All the queries are internally handled as :doc:`PHQL <phql>` queries. PHQL is a high-level, object-oriented and SQL-like language.
This language provide you more features to perform queries like joining other models, define groupings, add aggregations etc.

Lastly, there is the :code:`findFirstBy<property-name>()` method. This method expands on the :code:`findFirst()` method mentioned earlier. It allows you to quickly perform a
retrieval from a table by using the property name in the method itself and passing it a parameter that contains the data you want to search for in that column.
An example is in order, so taking our Robots model mentioned earlier:

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

We have three properties to work with here: :code:`$id`, :code:`$name` and :code:`$price`. So, let's say you want to retrieve the first record in
the table with the name 'Terminator'. This could be written like:

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

Notice that we used 'Name' in the method call and passed the variable :code:`$name` to it, which contains the name
we are looking for in our table. Notice also that when we find a match with our query, all the other properties
are available to us as well.

Model Resultsets
^^^^^^^^^^^^^^^^
While :code:`findFirst()` returns directly an instance of the called class (when there is data to be returned), the :code:`find()` method returns a
:doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`. This is an object that encapsulates all the functionality
a resultset has like traversing, seeking specific records, counting, etc.

These objects are more powerful than standard arrays. One of the greatest features of the :doc:`Phalcon\\Mvc\\Model\\Resultset <../api/Phalcon_Mvc_Model_Resultset>`
is that at any time there is only one record in memory. This greatly helps in memory management especially when working with large amounts of data.

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

Phalcon's resultsets emulate scrollable cursors, you can get any row just by accessing its position, or seeking the internal pointer
to a specific position. Note that some database systems don't support scrollable cursors, this forces to re-execute the query
in order to rewind the cursor to the beginning and obtain the record at the requested position. Similarly, if a resultset
is traversed several times, the query must be executed the same number of times.

As storing large query results in memory could consume many resources, resultsets are obtained
from the database in chunks of 32 rows - reducing the need to re-execute the request in several cases.

Note that resultsets can be serialized and stored in a cache backend. :doc:`Phalcon\\Cache <cache>` can help with that task. However,
serializing data causes :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` to retrieve all the data from the database in an array,
thus consuming more memory while this process takes place.

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

Filtering Resultsets
^^^^^^^^^^^^^^^^^^^^
The most efficient way to filter data is setting some search criteria, databases will use indexes set on tables to return data faster.
Phalcon additionally allows you to filter the data using PHP using any resource that is not available in the database:

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

Binding Parameters
^^^^^^^^^^^^^^^^^^
Bound parameters are also supported in :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`. You are encouraged to use
this methodology so as to eliminate the possibility of your code being subject to SQL injection attacks.
Both string and integer placeholders are supported. Binding parameters can simply be achieved as follows:

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

When using numeric placeholders, you will need to define them as integers i.e. 1 or 2. In this case "1" or "2" are considered strings
and not numbers, so the placeholder could not be successfully replaced.

Strings are automatically escaped using PDO_. This function takes into account the connection charset, so its recommended to define
the correct charset in the connection parameters or in the database configuration, as a wrong charset will produce undesired effects
when storing or retrieving data.

Additionally you can set the parameter "bindTypes", this allows defining how the parameters should be bound according to its data type:

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

    Since the default bind-type is :code:`Phalcon\Db\Column::BIND_PARAM_STR`, there is no need to specify the
    "bindTypes" parameter if all of the columns are of that type.

If you bind arrays in bound parameters, keep in mind, that keys must be numbered from zero:

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

    Bound parameters are available for all query methods such as :code:`find()` and :code:`findFirst()` but also the calculation
    methods like :code:`count()`, :code:`sum()`, :code:`average()` etc.

If you're using "finders", bound parameters are automatically used for you:

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

    // Implicit query using bound parameters
    $robots = Robots::findByName("Ultron");

Initializing/Preparing fetched records
--------------------------------------
May be the case that after obtaining a record from the database is necessary to initialise the data before
being used by the rest of the application. You can implement the :code:`afterFetch()` method in a model, this event
will be executed just after create the instance and assign the data to it:

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

If you use getters/setters instead of/or together with public properties, you can initialize the field once it is
accessed:

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

Generating Calculations
-----------------------
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

Creating/Updating Records
-------------------------
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

Create/Update with Confidence
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
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

Auto-generated identity columns
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
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

Events and Events Manager
-------------------------
Models allow you to implement events that will be thrown while performing an insert/update/delete which can be used to define business rules. The following are the events supported by :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` and their order of execution:

+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Operation          | Name                     | Can stop operation?   | Explanation                                                                                                                       |
+====================+==========================+=======================+===================================================================================================================================+
| Inserting/Updating | beforeValidation         | YES                   | Is executed before the fields are validated for not nulls/empty strings or foreign keys                                           |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting          | beforeValidationOnCreate | YES                   | Is executed before the fields are validated for not nulls/empty strings or foreign keys when an insertion operation is being made |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Updating           | beforeValidationOnUpdate | YES                   | Is executed before the fields are validated for not nulls/empty strings or foreign keys when an updating operation is being made  |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | onValidationFails        | YES (already stopped) | Is executed after an integrity validator fails                                                                                    |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting          | afterValidationOnCreate  | YES                   | Is executed after the fields are validated for not nulls/empty strings or foreign keys when an insertion operation is being made  |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Updating           | afterValidationOnUpdate  | YES                   | Is executed after the fields are validated for not nulls/empty strings or foreign keys when an updating operation is being made   |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | afterValidation          | YES                   | Is executed after the fields are validated for not nulls/empty strings or foreign keys                                            |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | beforeSave               | YES                   | Runs before the required operation over the database system                                                                       |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Updating           | beforeUpdate             | YES                   | Runs before the required operation over the database system only when an updating operation is being made                         |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting          | beforeCreate             | YES                   | Runs before the required operation over the database system only when an inserting operation is being made                        |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Updating           | afterUpdate              | NO                    | Runs after the required operation over the database system only when an updating operation is being made                          |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting          | afterCreate              | NO                    | Runs after the required operation over the database system only when an inserting operation is being made                         |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | afterSave                | NO                    | Runs after the required operation over the database system                                                                        |
+--------------------+--------------------------+-----------------------+-----------------------------------------------------------------------------------------------------------------------------------+

Implementing Events in the Model's class
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The easier way to make a model react to events is to implement a method with the same name of the event in the model's class:

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public function beforeValidationOnCreate()
        {
            echo "This is executed before creating a Robot!";
        }
    }

Events can be used to assign values before performing an operation, for example:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Products extends Model
    {
        public function beforeCreate()
        {
            // Set the creation date
            $this->created_at = date("Y-m-d H:i:s");
        }

        public function beforeUpdate()
        {
            // Set the modification date
            $this->modified_in = date("Y-m-d H:i:s");
        }
    }

Using a custom Events Manager
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Additionally, this component is integrated with :doc:`Phalcon\\Events\\Manager <../api/Phalcon_Events_Manager>`,
this means we can create listeners that run when an event is triggered.

.. code-block:: php

    <?php

    namespace Store\Toys;

    use Phalcon\Mvc\Model;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    class Robots extends Model
    {
        public function initialize()
        {
            $eventsManager = new EventsManager();

            // Attach an anonymous function as a listener for "model" events
            $eventsManager->attach(
                "model:beforeSave",
                function (Event $event, $robot) {
                    if ($robot->name == "Scooby Doo") {
                        echo "Scooby Doo isn't a robot!";

                        return false;
                    }

                    return true;
                }
            );

            // Attach the events manager to the event
            $this->setEventsManager($eventsManager);
        }
    }

In the example given above, the Events Manager only acts as a bridge between an object and a listener (the anonymous function).
Events will be fired to the listener when 'robots' are saved:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->name = "Scooby Doo";
    $robot->year = 1969;

    $robot->save();

If we want all objects created in our application use the same EventsManager, then we need to assign it to the Models Manager:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    // Registering the modelsManager service
    $di->setShared(
        "modelsManager",
        function () {
            $eventsManager = new EventsManager();

            // Attach an anonymous function as a listener for "model" events
            $eventsManager->attach(
                "model:beforeSave",
                function (Event $event, $model) {
                    // Catch events produced by the Robots model
                    if (get_class($model) === "Store\\Toys\\Robots") {
                        if ($model->name === "Scooby Doo") {
                            echo "Scooby Doo isn't a robot!";

                            return false;
                        }
                    }

                    return true;
                }
            );

            // Setting a default EventsManager
            $modelsManager = new ModelsManager();

            $modelsManager->setEventsManager($eventsManager);

            return $modelsManager;
        }
    );

If a listener returns false that will stop the operation that is executing currently.

Skipping Columns
----------------
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

Dynamic Update
^^^^^^^^^^^^^^
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

Deleting Records
----------------
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

Independent Column Mapping
--------------------------
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

Record Snapshots
----------------
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

Pointing to a different schema
------------------------------
If a model is mapped to a table that is in a different schemas/databases than the default. You can use the :code:`setSchema()` method to define that:

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

Setting multiple databases
--------------------------
In Phalcon, all models can belong to the same database connection or have an individual one. Actually, when
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` needs to connect to the database it requests the "db" service
in the application's services container. You can overwrite this service setting it in the :code:`initialize()` method:

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

Then, in the :code:`initialize()` method, we define the connection service for the model:

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

But Phalcon offers you more flexibility, you can define the connection that must be used to 'read' and for 'write'. This is specially useful
to balance the load to your databases implementing a master-slave architecture:

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

The ORM also provides Horizontal Sharding facilities, by allowing you to implement a 'shard' selection
according to the current query conditions:

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

The :code:`selectReadConnection()` method is called to choose the right connection, this method intercepts any new
query executed:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = Robots::findFirst('id = 101');

Logging Low-Level SQL Statements
--------------------------------
When using high-level abstraction components such as :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` to access a database, it is
difficult to understand which statements are finally sent to the database system. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
is supported internally by :doc:`Phalcon\\Db <../api/Phalcon_Db>`. :doc:`Phalcon\\Logger <../api/Phalcon_Logger>` interacts
with :doc:`Phalcon\\Db <../api/Phalcon_Db>`, providing logging capabilities on the database abstraction layer, thus allowing us to log SQL
statements as they happen.

.. code-block:: php

    <?php

    use Phalcon\Logger;
    use Phalcon\Events\Manager;
    use Phalcon\Logger\Adapter\File as FileLogger;
    use Phalcon\Db\Adapter\Pdo\Mysql as Connection;

    $di->set(
        "db",
        function () {
            $eventsManager = new EventsManager();

            $logger = new FileLogger("app/logs/debug.log");

            // Listen all the database events
            $eventsManager->attach(
                "db:beforeQuery",
                function ($event, $connection) use ($logger) {
                    $logger->log(
                        $connection->getSQLStatement(),
                        Logger::INFO
                    );
                }
            );

            $connection = new Connection(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );

            // Assign the eventsManager to the db adapter instance
            $connection->setEventsManager($eventsManager);

            return $connection;
        }
    );

As models access the default database connection, all SQL statements that are sent to the database system will be logged in the file:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    $robot = new Robots();

    $robot->name       = "Robby the Robot";
    $robot->created_at = "1956-07-21";

    if ($robot->save() === false) {
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

    use Phalcon\Db\Profiler as ProfilerDb;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Adapter\Pdo\Mysql as MysqlPdo;

    $di->set(
        "profiler",
        function () {
            return new ProfilerDb();
        },
        true
    );

    $di->set(
        "db",
        function () use ($di) {
            $eventsManager = new EventsManager();

            // Get a shared instance of the DbProfiler
            $profiler = $di->getProfiler();

            // Listen all the database events
            $eventsManager->attach(
                "db",
                function ($event, $connection) use ($profiler) {
                    if ($event->getType() === "beforeQuery") {
                        $profiler->startProfile(
                            $connection->getSQLStatement()
                        );
                    }

                    if ($event->getType() === "afterQuery") {
                        $profiler->stopProfile();
                    }
                }
            );

            $connection = new MysqlPdo(
                [
                    "host"     => "localhost",
                    "username" => "root",
                    "password" => "secret",
                    "dbname"   => "invo",
                ]
            );

            // Assign the eventsManager to the db adapter instance
            $connection->setEventsManager($eventsManager);

            return $connection;
        }
    );

Profiling some queries:

.. code-block:: php

    <?php

    use Store\Toys\Robots;

    // Send some SQL statements to the database
    Robots::find();

    Robots::find(
        [
            "order" => "name",
        ]
    );

    Robots::find(
        [
            "limit" => 30,
        ]
    );

    // Get the generated profiles from the profiler
    $profiles = $di->get("profiler")->getProfiles();

    foreach ($profiles as $profile) {
       echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
       echo "Start Time: ", $profile->getInitialTime(), "\n";
       echo "Final Time: ", $profile->getFinalTime(), "\n";
       echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }

Each generated profile contains the duration in milliseconds that each instruction takes to complete as well as the generated SQL statement.

Injecting services into Models
------------------------------
You may be required to access the application services within a model, the following example explains how to do that:

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

The "notSaved" event is triggered every time that a "create" or "update" action fails. So we're flashing the validation messages
obtaining the "flash" service from the DI container. By doing this, we don't have to print messages after each save.

Disabling/Enabling Features
---------------------------
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

Stand-Alone component
---------------------
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

.. _PDO: http://php.net/manual/en/pdo.prepared-statements.php
