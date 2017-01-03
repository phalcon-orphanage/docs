Working with Models (Advanced)
==============================

Hydration Modes
---------------
As mentioned previously, resultsets are collections of complete objects, this means that every returned result is an object
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

Auto-generated identity columns
-------------------------------
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
                if ($conditions["left"]["name"] === "id") {
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
