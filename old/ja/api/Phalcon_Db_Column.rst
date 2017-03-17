Class **Phalcon\\Db\\Column**
=============================

*implements* :doc:`Phalcon\\Db\\ColumnInterface <Phalcon_Db_ColumnInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/column.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Allows to define columns to be used on create or alter table operations

.. code-block:: php

    <?php

    use Phalcon\Db\Column as Column;

    // Column definition
    $column = new Column(
        "id",
        [
            "type"          => Column::TYPE_INTEGER,
            "size"          => 10,
            "unsigned"      => true,
            "notNull"       => true,
            "autoIncrement" => true,
            "first"         => true,
        ]
    );

    // Add column to existing table
    $connection->addColumn("robots", null, $column);



Constants
---------

*integer* **TYPE_INTEGER**

*integer* **TYPE_DATE**

*integer* **TYPE_VARCHAR**

*integer* **TYPE_DECIMAL**

*integer* **TYPE_DATETIME**

*integer* **TYPE_CHAR**

*integer* **TYPE_TEXT**

*integer* **TYPE_FLOAT**

*integer* **TYPE_BOOLEAN**

*integer* **TYPE_DOUBLE**

*integer* **TYPE_TINYBLOB**

*integer* **TYPE_BLOB**

*integer* **TYPE_MEDIUMBLOB**

*integer* **TYPE_LONGBLOB**

*integer* **TYPE_BIGINTEGER**

*integer* **TYPE_JSON**

*integer* **TYPE_JSONB**

*integer* **TYPE_TIMESTAMP**

*integer* **BIND_PARAM_NULL**

*integer* **BIND_PARAM_INT**

*integer* **BIND_PARAM_STR**

*integer* **BIND_PARAM_BLOB**

*integer* **BIND_PARAM_BOOL**

*integer* **BIND_PARAM_DECIMAL**

*integer* **BIND_SKIP**

Methods
-------

public  **getName** ()

Column's name



public  **getSchemaName** ()

Schema which table related is



public  **getType** ()

Column data type



public  **getTypeReference** ()

Column data type reference



public  **getTypeValues** ()

Column data type values



public  **getSize** ()

Integer column size



public  **getScale** ()

Integer column number scale



public  **getDefault** ()

Default column value



public  **__construct** (*mixed* $name, *array* $definition)

Phalcon\\Db\\Column constructor



public  **isUnsigned** ()

Returns true if number column is unsigned



public  **isNotNull** ()

Not null



public  **isPrimary** ()

Column is part of the primary key?



public  **isAutoIncrement** ()

Auto-Increment



public  **isNumeric** ()

Check whether column have an numeric type



public  **isFirst** ()

Check whether column have first position in table



public *string* **getAfterPosition** ()

Check whether field absolute to position in table



public  **getBindType** ()

Returns the type of bind handling



public static  **__set_state** (*array* $data)

Restores the internal state of a Phalcon\\Db\\Column object



public  **hasDefault** ()

Check whether column has default value



