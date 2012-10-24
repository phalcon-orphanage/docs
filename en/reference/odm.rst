ODM (Object-Document Mapper)
============================
In addition to its ability to :doc:`map tables <models>` in relational databases, Phalcon can map documents from NoSQL databases.
The ODM offers a CRUD functionality, events, validations among other services.

Due to the absence of SQL queries and planners, NoSQL databases can see real improvements in performance using the Phalcon approach.
Additionally, there are no SQL building eliminating the possibility of SQL injections.

The following NoSQL databases are supported:

+------------+----------------------------------------------------------------------+
| Name       | Description                                                          |
+============+======================================================================+
| MongoDB_   | MongoDB is a scalable, high-performance, open source NoSQL database. |
+------------+----------------------------------------------------------------------+

Creating Models
---------------
A model is a class that extends from :doc:`Phalcon\\Mvc\\Collection <../api/Phalcon_Mvc_Collection>`. It must be placed in the models directory. A model
file must contain a single class; its class name should be in camel case notation:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Collection
    {

    }

By default model "Robots" will refer to the collection "robots". If you want to manually specify another name for the mapping collection,
you can use the getSource() method:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Collection
    {

        public function getSource()
        {
            return "the_robots";
        }

    }

Understanding Documents To Objects
----------------------------------
Every instance of a model represents a document in the collection. You can easily access collection data by reading object properties. For example,
for a collection "robots" with the documents:

.. code-block:: bash

	$ mongo test
	MongoDB shell version: 1.8.2
	connecting to: test
	> db.robots.find()
	{ "_id" : ObjectId("508735512d42b8c3d15ec4e1"), "name" : "Astro Boy", "year" : 1952,
		"type" : "mechanical" }
	{ "_id" : ObjectId("5087358f2d42b8c3d15ec4e2"), "name" : "Bender", "year" : 1999,
		"type" : "mechanical" }
	{ "_id" : ObjectId("508735d32d42b8c3d15ec4e3"), "name" : "Wall-E", "year" : 2008 }
	>

Models in Namespaces
--------------------
Namespaces can be used to avoid class name collision. In this case it is necessary to indicate the name of the related collection using getSource:

.. code-block:: php

    <?php

    namespace Store\Toys;

    class Robots extends \Phalcon\Mvc\Collection
    {

        public function getSource()
        {
            return "robots";
        }

    }

You could find a certain document by its id and then print its name:

.. code-block:: php

    <?php

    // Find record with _id = "5087358f2d42b8c3d15ec4e2"
    $robot = Robots::findById("5087358f2d42b8c3d15ec4e2");

    // Prints "Bender"
    echo $robot->name;

Once the record is in memory, you can make modifications to its data and then save changes:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(array(
    	array('name' => 'Astroy Boy')
    ));
    $robot->name = "Voltron";
    $robot->save();

Finding Documents
-----------------
As :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` relies on the Mongo PHP extension you have the same facilities
to query documents and convert them transparently to model instances:

.. code-block:: php

    <?php

    // How many robots are there?
    $robots = Robots::find();
    echo "There are ", count($robots), "\n";

    // How many mechanical robots are there?
    $robots = Robots::find(array(
    	array("type" => "mechanical")
    );
    echo "There are ", count($robots), "\n";

    // Get and print mechanical robots ordered by name upward
    $robots = Robots::find(array(
    	array("type" => "mechanical"),
    	"sort" => array("name" => 1)
    ));
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // Get first 100 mechanical robots ordered by name
    $robots = Robots::find(array(
    	array("type" => "mechanical"),
    	"sort" => array("name" => 1),
    	"limit" => 100
    ));
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

You could also use the findFirst() method to get only the first record matching the given criteria:

.. code-block:: php

    <?php

    // What's the first robot in robots collection?
    $robot = Robots::findFirst();
    echo "The robot name is ", $robot->name, "\n";

    // What's the first mechanical robot in robots collection?
    $robot = Robots::findFirst(array(
    	array("type" => "mechanical")
    ));
    echo "The first mechanical robot name is ", $robot->name, "\n";

Both find() and findFirst() methods accept an associative array specifying the search criteria:

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

The available query options are:

+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| Parameter   | Description                                                                                                                                                                                  | Example                                                                 |
+=============+==============================================================================================================================================================================================+=========================================================================+
| conditions  | Search conditions for the find operation. Is used to extract only those records that fulfill a specified criterion. By default Phalcon_model assumes the first parameter are the conditions. | "conditions" => "name LIKE 'steve%'"                                    |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+

If you have experience with SQL databases, you may want to check the `SQL to Mongo Mapping Chart`_.

.. _MongoDB: http://www.mongodb.org/
.. _`SQL to Mongo Mapping Chart`: http://www.php.net/manual/en/mongo.sqltomongo.php