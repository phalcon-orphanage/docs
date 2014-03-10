%{migrations_e9344089a64801b2141c890b330a0fcb}%
===================
%{migrations_f301d41b7379bf73aa2ec3a13c5aa6e0}%

.. highlights::
    **Important:** Migrations are available on :doc:`Phalcon Developer Tools <tools>` You need at least Phalcon Framework version 0.5.0 to use developer tools. Also is recommended to have PHP 5.3.11 or greater installed.



%{migrations_6d0774cca265eac9c4f7900155a19c10}%

%{migrations_86a4e169a1f5e1c962715ed06af30e3b}%

.. raw:: html

    <div align="center">
        <iframe src="http://player.vimeo.com/video/41381817" width="500" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
    </div>



%{migrations_c2c6a196f47f93f72deb7b1bdb09136d}%
--------------
%{migrations_dafacf70bbd1a474c5d65134fc5d05ea|:doc:`Phalcon Developer Tools <tools>`}%

%{migrations_203535c85e7bb7824da0d937e8ab2fe0}%

.. figure:: ../_static/img/migrations-1.png
   :align: center



%{migrations_360af274a46cce617945ea23ff912b4b}%

%{migrations_b726638947cbfbefc87e275c663b82a1}%

.. figure:: ../_static/img/migrations-2.png
   :align: center



%{migrations_6d7decd5070994a0afa0d63acb389aca}%

%{migrations_2b1b05d9ab89746ef007eeb359671172|:doc:`Phalcon Developer Tools <tools>`}%

.. figure:: ../_static/img/migrations-3.png
   :align: center



%{migrations_b673cb7a0ed9fb88408b3bb89ae3c1ef}%
-----------------------
%{migrations_1dd1afd8dc05142d04a6cb584c4be3f3}%

%{migrations_cbe6b57bfb055245ecb16ec1e3e6fd23}%

.. code-block:: php

    <?php

    use Phalcon\Db\Column as Column;
    use Phalcon\Db\Index as Index;
    use Phalcon\Db\Reference as Reference;

    class ProductsMigration_100 extends \Phalcon\Mvc\Model\Migration
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


%{migrations_5d8072dc56e4dcc8255178194d5001c1}%

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


%{migrations_fdc42990e3b6f6fbdfa0c2091c3dd1b0}%
^^^^^^^^^^^^^^^^
%{migrations_9bd114f770bc302f84fa27b173617833|:doc:`Phalcon\\Db\\Column <../api/Phalcon_Db_Column>`}%

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


%{migrations_693f023ec4e718b7c0a6c9a231892599}%

* {%migrations_e64f0954f63861dae89f79260e579f6e%}
* {%migrations_652aaca330a0a20efd856f8035d6709e%}
* {%migrations_77c940959f1f2a9308919a987740ebc1%}
* {%migrations_4deb53b39e30c5a62952881c49fec2e8%}
* {%migrations_3e7a50f2c5c3bebed9bed171bd6663a5%}
* {%migrations_25253fe1d826d42e6db699f3e7d99514%}
* {%migrations_070faf863b6a1cfe77f660ccdd4d9ee1%}

%{migrations_98592e9224abec7b6a4957b5f4b035b4}%
^^^^^^^^^^^^^^^^
%{migrations_173520fb94187f133174d26fa590a3bc|:doc:`Phalcon\\Db\\Index <../api/Phalcon_Db_Index>`}%

%{migrations_18f0b0ff59a37b6adc6b8a16e4430559}%
^^^^^^^^^^^^^^^^^^^
%{migrations_f0baedbf67e787b77fd3a0c2065a9573|:doc:`Phalcon\\Db\\Reference <../api/Phalcon_Db_Reference>`}%

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


%{migrations_3288ae777aa932ca0f6a2a90da292c6d}%
------------------
%{migrations_cf35cba6fd8ac5359966ed7d8b9c6c93|:doc:`database component <db>`}%

.. code-block:: php

    <?php

    class ProductsMigration_100 extends \Phalcon\Mvc\Model\Migration
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


%{migrations_d7452f33e484571303e4cc4ab5b15ffe}%
------------------
%{migrations_063f176fa57cf226a7d0a5d3b84c0935}%

.. figure:: ../_static/img/migrations-4.png
   :align: center

.. figure:: ../_static/img/migrations-5.png
   :align: center



%{migrations_1c64e9a2a899094ccdcad4688e8b3b3d}%

