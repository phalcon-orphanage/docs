Database Migrations
===================
Migrations are a convenient way for you to alter your database in a structured and organized manner.

.. highlights::
    **Important:** Migrations are available on :doc:`Phalcon Developer Tools <tools>` You need at least Phalcon Framework version 0.3.5 to use developer tools. Also is recommended to have PHP 5.3.6 or greater installed.

Often in development we need to update changes in production environments. Some of these changes could be database modifications like new fields, new tables, removing indexes, etc.

When a migration is generated a set of classes are created to describe how your database is structured at that moment. These classes can be used to synchronize the schema structure on remote databases setting your database ready to work with the new changes that your application implements. Migrations describe these transformations using plain PHP.

.. raw:: html

    <div align="center">
    <iframe src="http://player.vimeo.com/video/41381817" width="500" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
    </div>

Schema Dumping
--------------
The :doc:`Phalcon Developer Tools <tools>` provides scripts to manage migrations (generation, running and rollback).

The available options for generating migrations are:

.. figure:: ../_static/img/migrations-1.png
   :align: center

Running this script without any parameters will simply dump every object (tables and views) from your database in migration classes.

Each migration has a version identifier associated to it. The version number allows us to identify if the migration is newer or older than the current 'version' of our database. Versions also inform Phalcon of the running order when executing a migration.

.. figure:: ../_static/img/migrations-2.png
   :align: center

When a migration is generated, instructions are displayed on the console to describe the different steps of the migration and the execution time of those statements. At the end, a migration version is generated.

By default :doc:`Phalcon Developer Tools <tools>` use the *app/migrations* directory to dump the migration files. You can change the location by setting one of the parameters on the generation script. Each table in the database has its respective class generated in a separated file under a directory referring its version:

.. figure:: ../_static/img/migrations-3.png
   :align: center

Migration Class Anatomy
-----------------------
Each file contains a unique class that extends the :doc:`Phalcon_Model_Migration <../api/Phalcon_Model_Migration>`. These classes normally have two methods: up() and down(). Up() performs the migration, while down() rolls it back.

Up() also contains the *magic* method morphTable(). The magic comes when it recognizes the changes needed to synchronize the actual table in the database to the description given.

.. code-block:: php

    <?php

    use Phalcon_Db_Column as Column;
    use Phalcon_Db_Index as Index;
    use Phalcon_Db_Reference as Reference;

    class ProductsMigration_100 extends Phalcon_Model_Migration
    {

        public function up()
        {
            $this->morphTable(
                "products",
                array(
                    "columns" => array(
                        new Column(
                            "id",
                            array(
                                "type"          => Column::TYPE_INTEGER,
                                "size"          => 10,
                                "unsigned"      => true,
                                "notNull"       => true,
                                "autoIncrement" => true,
                                "first"         => true,
                            )
                        ),
                        new Column(
                            "product_types_id",
                            array(
                                "type"     => Column::TYPE_INTEGER,
                                "size"     => 10,
                                "unsigned" => true,
                                "notNull"  => true,
                                "after"    => "id",
                            )
                        ),
                        new Column(
                            "name",
                            array(
                                "type"    => Column::TYPE_VARCHAR,
                                "size"    => 70,
                                "notNull" => true,
                                "after"   => "product_types_id",
                            )
                        ),
                        new Column(
                            "price",
                            array(
                                "type"    => Column::TYPE_DECIMAL,
                                "size"    => 16,
                                "scale"   => 2,
                                "notNull" => true,
                                "after"   => "name",
                            )
                        ),
                    ),
                    "indexes" => array(
                        new Index(
                            "PRIMARY",
                            array("id")
                        ),
                        new Index(
                            "product_types_id",
                            array("product_types_id")
                        )
                    ),
                    "references" => array(
                        new Reference(
                            "products_ibfk_1",
                            array(
                                "referencedSchema"  => "invo",
                                "referencedTable"   => "product_types",
                                "columns"           => array("product_types_id"),
                                "referencedColumns" => array("id"),
                            )
                        )
                    ),
                    "options" => array(
                        "TABLE_TYPE"      => "BASE TABLE",
                        "ENGINE"          => "InnoDB",
                        "TABLE_COLLATION" => "utf8_general_ci",
                    )
                )
            );
        }

    }

The class is called "ProductsMigration_100". Suffix 100 refers to the version 1.0.0. morphTable() receives an associative array with 4 possible sections:

+--------------+---------------------------------------------------------------------------------------------------------------------------------------------+----------+
| Index        | Description                                                                                                                                 | Optional |
+==============+=============================================================================================================================================+==========+
| "columns"    | An array with a set of table columns                                                                                                        | No       |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "indexes"    | An array with a set of table indexes.                                                                                                       | Yes      |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "references" | An array with a set of table references (foreign keys).                                                                                     | Yes      |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "options"    | An array with a set of table creation options. These options are often related to the database system in which the migration was generated. | Yes      |
+--------------+---------------------------------------------------------------------------------------------------------------------------------------------+----------+

Defining Columns
^^^^^^^^^^^^^^^^
:doc:`Phalcon_Db_Column <../api/Phalcon_Db_Column>` is used to define table columns. It encapsulates a wide variety of column related features. Its constructor receives as first parameter the column name and an array describing the column. The following options are available when describing columns:

+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| Option          | Description                                                                                                                                | Optional |
+=================+============================================================================================================================================+==========+
| "type"          | Column type. Must be a :doc:`Phalcon_Db_Column <../api/Phalcon_Db_Column>` constant (see below)                                            | No       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "size"          | Some type of columns like VARCHAR or INTEGER may have a specific size                                                                      | Yes      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "scale"         | DECIMAL or NUMBER columns may be have a scale to specify how much decimals it must store                                                   | Yes      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "unsigned"      | INTEGER columns may be signed or unsigned. This option does not apply to other types of columns                                            | Yes      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "notNull"       | Column can store null values?                                                                                                              | Yes      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "autoIncrement" | With this attribute column will filled automatically with an auto-increment integer. Only one column in the table can have this attribute. | Yes      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "first"         | Column must be placed at first position in the column order                                                                                | Yes      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "after"         | Column must be placed after indicated column                                                                                               | Yes      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+

Database migrations support the following database column types:

* Phalcon_Db_Column::TYPE_INTEGER
* Phalcon_Db_Column::TYPE_DATE
* Phalcon_Db_Column::TYPE_VARCHAR
* Phalcon_Db_Column::TYPE_DECIMAL
* Phalcon_Db_Column::TYPE_DATETIME
* Phalcon_Db_Column::TYPE_CHAR
* Phalcon_Db_Column::TYPE_TEXT

Defining Indexes
^^^^^^^^^^^^^^^^
:doc:`Phalcon_Db_Index <../api/Phalcon_Db_Index>` defines table indexes. An index only requires that you define a name for it and a list of its columns. Note that if any index has the name PRIMARY, Phalcon will create a primary key index in that table.

Defining References
^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon_Db_Reference <../api/Phalcon_Db_Reference>` defines table references (also called foreign keys). The following options can be used to define a reference:

+---------------------+-----------------------------------------------------------------------------------------------------+----------+
| Index               | Description                                                                                         | Optional |
+=====================+=====================================================================================================+==========+
| "referencedTable"   | It's auto-descriptive. It refers to the name of the referenced table.                               | No       |
+---------------------+-----------------------------------------------------------------------------------------------------+----------+
| "columns"           | An array with the name of the columns at the table that have the reference                          | No       |
+---------------------+-----------------------------------------------------------------------------------------------------+----------+
| "referencedColumns" | An array with the name of the columns at the referenced table                                       | No       |
+---------------------+-----------------------------------------------------------------------------------------------------+----------+
| "referencedTable"   | The referenced table maybe is on another schema or database. This option allows you to define that. | Yes      |
+---------------------+-----------------------------------------------------------------------------------------------------+----------+

Writing Migrations
------------------
Migrations aren't only designed to "morph" table. A migration is just a regular PHP class so you're not limited to these functions. For example after adding a column you could write code to set the value of that column for existing records. For more details and examples of individual methods, check the :doc:`database component <db>`.

.. code-block:: php

    <?php

    class ProductsMigration_100 extends Phalcon_Model_Migration
    {

        public function up()
        {
            //...
            self::$_connection->insert(
                "products",
                array("Malabar spinach", 14.50),
                array("name", "price")
            );
        }

    }

Running Migrations
------------------
Once the generated migrations are uploaded on the target server, you can easily run them as shown in the following example:

.. figure:: ../_static/img/migrations-4.png
   :align: center

.. figure:: ../_static/img/migrations-5.png
   :align: center

Depending on how outdated is the database with respect to migrations, Phalcon may run multiple migration versions in the same migration process. If you specify a target version, Phalcon will run the required migrations until it reaches the specified version.

